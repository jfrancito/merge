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
        $combo_tipo_pago = ['' => 'Seleccione tipo de pago'] + $combo_tipo_pago;

        $combo_moneda = DB::table('CMP.CATEGORIA')
            ->whereIn('COD_CATEGORIA', ['MOM0000000000001', 'MOM0000000000002'])
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();
        $combo_moneda = ['' => 'Seleccione moneda'] + $combo_moneda;

        // Calcular correlativo siguiendo la lógica del SP
        $empresa_sesion = Session::get('empresas');
        $usuario_id = Session::get('usuario')->usuarioosiris_id;

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
        $abrev_centro = $centro ? trim($centro->ABREV_CENTRO) : '';
        $prefijo = $abrev_empresa . $abrev_centro . 'COT';

        $max_id = DB::table('WEB.ORDEN_COTIZACION')
            ->where('ID_COTIZACION', 'LIKE', $prefijo . '%')
            ->max('ID_COTIZACION');

        if ($max_id) {
            $number = (int)substr($max_id, strlen($prefijo));
            $new_number = $number + 1;
            // Asumiendo longitud total de 16 caracteres como en el ejemplo IICOT00000000001
            $nro_cotizacion = $prefijo . str_pad($new_number, 16 - strlen($prefijo), '0', STR_PAD_LEFT);
        }
        else {
            $nro_cotizacion = $prefijo . str_pad(1, 11, '0', STR_PAD_LEFT);
        }

        // Obtener tipo de cambio actual (específico para la fecha de hoy, usando la lógica nativa SQL Server)
        $tipo_cambio = DB::table('CMP.TIPO_CAMBIO')
            ->whereRaw('CAST(FEC_CAMBIO AS DATE) = CAST(GETDATE() AS DATE)')
            ->where('COD_ESTADO', 1)
            ->first();
        
        $valor_tipo_cambio = 0;
        if ($tipo_cambio) {
            $valor_tipo_cambio = $tipo_cambio->CAN_COMPRA;
            // Normalizar si el ERP lo guarda escalado por 10000 (ej: 34480.0000 -> 3.4480)
            if ($valor_tipo_cambio > 100) {
                $valor_tipo_cambio = $valor_tipo_cambio / 10000;
            }
        }

        $listacotizaciones = DB::table('WEB.ORDEN_COTIZACION as C')
            ->leftJoin('dbo.ARCHIVOS as A', function ($join) {
            $join->on('A.ID_DOCUMENTO', '=', 'C.ID_COTIZACION')
                ->where('A.ACTIVO', '=', 1);
        })
            ->where('C.COD_EMPR', $empresa_sesion->COD_EMR ?? $empresa_sesion->COD_EMPR)
            ->where('C.ACTIVO', 1)
            ->select('C.*', 'A.URL_ARCHIVO as RUTA_ARCHIVO')
            ->orderBy('C.ID_COTIZACION', 'DESC')
            ->get();

        return view('ordenpedido.cotizacion.cotizacionordenpedido', [
            'combo_tipo_pago' => $combo_tipo_pago,
            'combo_moneda' => $combo_moneda,
            'nro_cotizacion' => $nro_cotizacion,
            'valor_tipo_cambio' => $valor_tipo_cambio,
            'listacotizaciones' => $listacotizaciones,
            'funcion' => $this,
            'idopcion' => $idopcion
        ]);
    }

    public function actionAjaxListarDetalleCotizacion(Request $request)
    {
        $id_cotizacion = $request->input('id_cotizacion');

        $lista_detalle = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
            ->where('ID_COTIZACION', $id_cotizacion)
            ->where('ACTIVO', 1)
            ->get();

        return view('ordenpedido.cotizacion.ajax.listadetallecotizacion', [
            'lista_detalle' => $lista_detalle
        ]);
    }

    public function actionAjaxEditarCotizacion(Request $request)
    {
        $id_cotizacion = $request->input('id_cotizacion');

        $cotizacion = DB::table('WEB.ORDEN_COTIZACION')
            ->where('ID_COTIZACION', $id_cotizacion)
            ->first();

        $detalles = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
            ->where('ID_COTIZACION', $id_cotizacion)
            ->where('ACTIVO', 1)
            ->get();

        // Obtener el HTML de los productos para refrescar el panel
        $prouctos_html = view('ordenpedido.cotizacion.ajax.listaproductoscotizacion', [
            'lista_detalle' => $detalles,
            'es_edicion' => true
        ])->render();

        return response()->json([
            'success' => true,
            'cotizacion' => $cotizacion,
            'productos_html' => $prouctos_html
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
        $empresa_sesion = Session::get('empresas');
        $cod_empr = $empresa_sesion->COD_EMR ?? $empresa_sesion->COD_EMPR;

        $lista_consolidado = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL as C')
            ->where('C.COD_EMPR', $cod_empr)
            ->where('C.COD_ESTADO', 'ETM0000000000005')
            ->where('C.ACTIVO', 1)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE as D')
                    ->whereColumn('D.ID_PEDIDO_CONSOLIDADO_GENERAL', 'C.ID_PEDIDO_CONSOLIDADO_GENERAL')
                    ->where('D.ACTIVO', 1)
                    ->where(function($q) {
                        $q->whereNull('D.TXT_COTIZACION')
                          ->orWhere('D.TXT_COTIZACION', '<>', 'SI');
                    });
            })
            ->orderBy('C.FEC_PEDIDO', 'DESC')
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
            ->where(function($q) {
                $q->where('TXT_COTIZACION', '<>', 'SI')
                  ->orWhereNull('TXT_COTIZACION');
            })
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
            $usuario_id = Session::get('usuario')->usuarioosiris_id;

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

            $id_cotizacion_edit = $request->input('id_cotizacion_edit');
            $accion = 'I';
            $id_cotizacion = '';

            if(!empty($id_cotizacion_edit)){
                $accion = 'U';
                $id_cotizacion = $id_cotizacion_edit;
            }

            // 4. Inserción/Actualización de cabecera usando el Trait
            $id_cotizacion = $this->insertOrdenCotizacion(
                $accion,
                $id_cotizacion, 
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
            // Si es edición, primero desactivamos los detalles anteriores y liberamos el estado 'Cotizado'
            if($accion == 'U'){
                // Obtener detalles previos para resetear su estado en consolidados
                $detalles_previos = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
                    ->where('ID_COTIZACION', $id_cotizacion)
                    ->where('ACTIVO', 1)
                    ->get();

                foreach($detalles_previos as $dp){
                    DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                        ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $dp->ID_PEDIDO_CONSOLIDADO_GENERAL)
                        ->where('COD_PRODUCTO', $dp->COD_PRODUCTO)
                        ->update(['TXT_COTIZACION' => null]);
                }

                DB::table('WEB.ORDEN_COTIZACION_DETALLE')
                    ->where('ID_COTIZACION', $id_cotizacion)
                    ->update(['ACTIVO' => 0]);
            }

            $detalles_json = $request->input('detalles');
            $detalles = json_decode($detalles_json, true);

            if (is_array($detalles)) {
                foreach ($detalles as $det) {
                    $this->insertOrdenCotizacionDetalle(
                        'I',
                        $id_cotizacion,
                        $det['id_consolidado'],
                        '', 
                        $cod_centro,
                        $det['cod_producto'],
                        $det['nom_producto'],
                        $det['cod_medida'],
                        $det['nom_medida'],
                        $det['cantidad'],
                        $det['precio'],
                        $det['precio_igv'] ?? 0,
                        $det['cod_familia'],
                        $det['nom_familia'],
                        1,
                        ''
                    );

                    // Marcar como cotizado en el consolidado general
                    if (isset($det['id_consolidado'])) {
                        DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                            ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $det['id_consolidado'])
                            ->where('COD_PRODUCTO', $det['cod_producto'])
                            ->update(['TXT_COTIZACION' => 'SI']);
                    }
                }
            }

            // 6. Manejo de archivo adjunto si existe (Subida inmediata en creación)
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $nombre_original = $archivo->getClientOriginalName();
                $extension = $archivo->getClientOriginalExtension();
                $size = $archivo->getSize();
                $mime = $archivo->getMimeType();
                $nombre_guardado = time() . '_' . $nombre_original;

                $destino_remoto = '\\\\10.1.50.2\\comprobantes\\ORDENCOTIZACION';
                $ruta_final = $destino_remoto . '\\' . $nombre_guardado;

                // Copia al servidor remoto UNC
                if (copy($archivo->getRealPath(), $ruta_final)) {
                    DB::table('dbo.ARCHIVOS')->insert([
                        'ID_DOCUMENTO' => $id_cotizacion,
                        'DOCUMENTO_ITEM' => 1,
                        'TIPO_ARCHIVO' => $mime,
                        'NOMBRE_ARCHIVO' => pathinfo($nombre_original, PATHINFO_FILENAME),
                        'DESCRIPCION_ARCHIVO' => $nombre_original,
                        'URL_ARCHIVO' => $ruta_final,
                        'EXTENSION' => $extension,
                        'SIZE' => $size,
                        'ACTIVO' => 1,
                        'FECHA_CREA' => DB::raw('GETDATE()'),
                        'USUARIO_CREA' => Session::get('usuario')->usuario ?? 'SISTEMA',
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'id_cotizacion' => $id_cotizacion, 'mensaje' => 'Cotización guardada correctamente con ID: ' . $id_cotizacion]);

        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error al guardar cotización: ' . $e->getMessage()]);
        }
    }

    public function actionAjaxSubirArchivoCotizacion(Request $request)
    {
        $id_cotizacion = $request->input('id_cotizacion');

        if ($request->hasFile('archivo')) {

            $archivo = $request->file('archivo');

            $nombre_original = $archivo->getClientOriginalName();
            $extension = $archivo->getClientOriginalExtension();
            $nombre_sin_extension = pathinfo($nombre_original, PATHINFO_FILENAME);
            $size = $archivo->getSize();
            $mime = $archivo->getMimeType();

            $nombre_guardado = time() . '_' . $nombre_original;

            // Ruta remota para Cotizaciones
            $destino_remoto = '\\\\10.1.50.2\\comprobantes\\ORDENCOTIZACION';

            // Verificar si el directorio existe (opcional, path UNC puede dar problemas con is_dir en algunos entornos)
            // if (!is_dir($destino_remoto)) { mkdir($destino_remoto, 0777, true); }

            $ruta_final = $destino_remoto . '\\' . $nombre_guardado;

            // Copia al servidor remoto UNC
            try {
                if (!copy($archivo->getRealPath(), $ruta_final)) {
                    return response()->json(['ok' => false, 'mensaje' => 'No se pudo copiar el archivo al servidor remoto.']);
                }
            }
            catch (\Exception $e) {
                return response()->json(['ok' => false, 'mensaje' => 'Error al escribir en la ruta remota: ' . $e->getMessage()]);
            }

            // Registro en la tabla ARCHIVOS
            DB::table('dbo.ARCHIVOS')->insert([
                'ID_DOCUMENTO' => $id_cotizacion,
                'DOCUMENTO_ITEM' => 1,
                'TIPO_ARCHIVO' => $mime,
                'NOMBRE_ARCHIVO' => $nombre_sin_extension,
                'DESCRIPCION_ARCHIVO' => $nombre_original,
                'URL_ARCHIVO' => $ruta_final,
                'EXTENSION' => $extension,
                'SIZE' => $size,
                'ACTIVO' => 1,
                'FECHA_CREA' => DB::raw('GETDATE()'),
                'USUARIO_CREA' => Session::get('usuario')->usuario ?? 'SISTEMA',
            ]);

            return response()->json(['ok' => true]);
        }

        return response()->json(['ok' => false, 'mensaje' => 'No se recibió ningún archivo.']);
    }
}
