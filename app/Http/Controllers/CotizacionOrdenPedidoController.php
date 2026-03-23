<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\OrdenPedidoCotizacionTraits;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;


class CotizacionOrdenPedidoController extends Controller
{
	 use OrdenPedidoCotizacionTraits;  

    public function actionCotizacionOrdenPedido($idopcion)
    {
        $combo_tipo_pago = DB::table('CMP.CATEGORIA')
            ->where('TXT_GRUPO', 'TIPO_PAGO')
            ->where('COD_ESTADO', 1)
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

        $combo_moneda = DB::table('CMP.CATEGORIA')
            ->whereIn('COD_CATEGORIA', ['MOM0000000000001', 'MOM0000000000002'])
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

        // Calcular correlativo siguiendo la lógica del SP
        $empresa_sesion = Session::get('empresas');
        $usuario_id     = Session::get('usuario')->usuarioosiris_id;

        // Obtener el centro del trabajador (equivalente a lo que hace el sistema en otros módulos)
        $centro = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->where('C.COD_ESTADO', 1)
            ->select('C.COD_CENTRO', 'C.TXT_ABREVIATURA as ABREV_CENTRO')
            ->first();

        $abrev_empresa = trim($empresa_sesion->TXT_ABREVIATURA);
        $abrev_centro  = $centro ? trim($centro->ABREV_CENTRO) : '';
        $prefijo       = $abrev_empresa . $abrev_centro . 'COT';

        $max_id = DB::table('WEB.ORDEN_COTIZACION')
            ->where('ID_COTIZACION', 'LIKE', $prefijo . '%')
            ->max('ID_COTIZACION');

        if ($max_id) {
            $number = (int)substr($max_id, strlen($prefijo));
            $new_number = $number + 1;
            // Asumiendo longitud total de 16 caracteres como en el ejemplo IICOT00000000001
            $nro_cotizacion = $prefijo . str_pad($new_number, 16 - strlen($prefijo), '0', STR_PAD_LEFT);
        } else {
            $nro_cotizacion = $prefijo . str_pad(1, 11, '0', STR_PAD_LEFT);
        }

        // Obtener tipo de cambio actual (específico para la fecha de hoy)
        $tipo_cambio = DB::table('CMP.TIPO_CAMBIO')
            ->whereDate('FEC_CAMBIO', date('Y-m-d'))
            ->where('COD_ESTADO', 1)
            ->first();
        
        $valor_tipo_cambio = $tipo_cambio ? $tipo_cambio->CAN_COMPRA : 0;

        return view('ordenpedido.cotizacion.cotizacionordenpedido', [
            'combo_tipo_pago'         => $combo_tipo_pago,
            'combo_moneda'            => $combo_moneda,
            'nro_cotizacion'          => $nro_cotizacion,
            'valor_tipo_cambio'       => $valor_tipo_cambio,
            'funcion'                 => $this,
            'idopcion'                => $idopcion
        ]);
    }

    public function actionAjaxBuscarProveedorRuc(Request $request)
    {
        $ruc = $request->input('ruc');

        $empresa = DB::table('STD.EMPRESA')
            ->where('NRO_DOCUMENTO', $ruc)
            ->where('IND_PROVEEDOR', 1)
            ->where('COD_ESTADO', 1)
            ->first();

        if ($empresa) {
            $direccion = DB::table('STD.EMPRESA_DIRECCION')
                ->where('COD_EMPR', $empresa->COD_EMPR)
                ->where('IND_DIRECCION_FISCAL', 1)
                ->where('COD_ESTADO', 1)
                ->first();

            return response()->json([
                'success' => true,
                'nombre' => $empresa->NOM_EMPR,
                'telefono' => $empresa->TXT_TELEFONO,
                'direccion' => $direccion ? $direccion->NOM_DIRECCION : ''
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Proveedor no encontrado']);
    }

    public function actionAjaxListarConsolidadoGeneralAprobado(Request $request)
    {
        $lista_consolidado = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL')
            ->where('COD_ESTADO', 'ETM0000000000005')
            ->where('ACTIVO', 1)
            ->orderBy('FEC_PEDIDO', 'DESC')
            ->get();

        return view('ordenpedido.modal.ajax.lista_consolidado_general', [
            'lista_consolidado' => $lista_consolidado
        ]);
    }

    public function actionAjaxListarDetalleConsolidadoGeneralSeleccionado(Request $request)
    {
        $id_consolidado_generals = $request->input('selected_ids');

        $lista_detalle = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
            ->whereIn('ID_PEDIDO_CONSOLIDADO_GENERAL', $id_consolidado_generals)
            ->where('ACTIVO', 1)
            ->get();

        return view('ordenpedido.cotizacion.ajax.listaproductoscotizacion', [
            'lista_detalle' => $lista_detalle
        ]);
    }

    public function actionGuardarCotizacion(Request $request)
    {
        try {
            DB::beginTransaction();

            $empresa_sesion = Session::get('empresas');
            $usuario_id     = Session::get('usuario')->usuarioosiris_id;

            // 1. Obtener el centro actual del usuario
            $centro = DB::table('STD.TRABAJADOR as T')
                ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
                ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
                ->where('T.COD_TRAB', $usuario_id)
                ->where('P.situacion_id', 'PRMAECEN000000000002')
                ->where('C.COD_ESTADO', 1)
                ->select('C.COD_CENTRO')
                ->first();

            $cod_centro = $centro ? $centro->COD_CENTRO : '';

            // 2. Obtener el código de la empresa proveedora (desde el RUC)
            $empresa_proveedor = DB::table('STD.EMPRESA')
                ->where('NRO_DOCUMENTO', $request->input('nro_ruc'))
                ->where('COD_ESTADO', 1)
                ->first();
            
            $cod_empr_proveedor = $empresa_proveedor ? $empresa_proveedor->COD_EMPR : '';

            // 3. Obtener el código de la dirección (preferiblemente fiscal)
            $direccion = DB::table('STD.EMPRESA_DIRECCION')
                ->where('COD_EMPR', $cod_empr_proveedor)
                ->where('IND_DIRECCION_FISCAL', 1)
                ->where('COD_ESTADO', 1)
                ->first();

            $cod_direccion = $direccion ? $direccion->COD_DIRECCION : '';

            // 4. Inserción de cabecera usando el Trait
            $id_cotizacion = $this->insertOrdenCotizacion(
                'I', 
                '', // Dejar vacío para que el SP lo genere con su propia lógica de correlativo
                $request->input('fec_cotizacion'),
                $request->input('nro_serie'),
                $request->input('nro_doc'),
                '', 
                $cod_centro, 
                $request->input('nro_ruc'),
                $cod_empr_proveedor, 
                $request->input('nom_empr_proveedor'),
                $request->input('txt_telefono'),
                $cod_direccion, 
                $request->input('nom_direccion'),
                $request->input('fec_validez'),
                $request->input('fec_entrega'),
                $request->input('cod_categoria_moneda'),
                $request->input('txt_categoria_moneda'),
                $request->input('cod_categoria_tipo_pago'),
                $request->input('txt_categoria_tipo_pago'),
                $request->input('txt_observacion'),
                $request->input('can_total'),
                'ETM0000000000001', 
                'GENERADO', 
                1, 
                '' 
            );

            // 5. Inserción de detalles
            $detalles_json = $request->input('detalles');
            $detalles = json_decode($detalles_json, true);

            if (is_array($detalles)) {
                foreach ($detalles as $det) {
                    $this->insertOrdenCotizacionDetalle(
                        'I',
                        $id_cotizacion,
                        '', 
                        $cod_centro,
                        $det['cod_producto'],
                        $det['nom_producto'],
                        $det['cod_medida'],
                        $det['nom_medida'],
                        $det['cantidad'],
                        $det['precio'],
                        $det['cod_familia'],
                        $det['nom_familia'],
                        1, 
                        '' 
                    );
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'id_cotizacion' => $id_cotizacion, 'mensaje' => 'Cotización guardada correctamente con ID: ' . $id_cotizacion]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error al guardar cotización: ' . $e->getMessage()]);
        }
    }
}
