<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\ConsolidadoPedidoApruebaTraits;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;


class ConsolidadoPedidoAprobadoController extends Controller
{
    use ConsolidadoPedidoApruebaTraits;

    public function actionConsolidadoPedidoAprobar($idopcion)
    {
         $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista Consolidado Pedidos');

       $empresa_sesion = Session::get('empresas');

       $combo_empresa = [
            $empresa_sesion->COD_EMPR => $empresa_sesion->NOM_EMPR
        ];
       
        $combo_centro = DB::table('ALM.CENTRO')
            ->where('COD_ESTADO', 1)
            ->pluck('NOM_CENTRO', 'COD_CENTRO')
            ->toArray();
        $combo_centro = ['TODO' => 'TODO'] + $combo_centro;

        $combo_anio = DB::table('Web.periodos')
            ->where('COD_EMPR', $empresa_sesion->COD_EMPR)
            ->where('activo', 1)
            ->distinct()
            ->pluck('anio', 'anio')
            ->toArray();

        $periodo_mes = DB::table('Web.periodos')
            ->whereIn('COD_EMPR', array_keys($combo_empresa))
            ->pluck('TXT_NOMBRE', 'COD_PERIODO')
            ->toArray();

        $combo_mes = ['' => 'Seleccione Mes'] + $periodo_mes;

        $empresa_id = $empresa_sesion->COD_EMPR;
        $centro_pedido = 'TODO';
        $mes_pedido = '';
        $anio_pedido = date('Y');

        $listaconsolidadopedidoap = [];
        if($mes_pedido != ''){
            $listaconsolidadopedidoap = $this->lg_lista_consolidado_aprueba($empresa_id, $centro_pedido,$mes_pedido, $anio_pedido);
        }
        $lista_aprobados = $this->lg_lista_consolidado_aprobados($empresa_sesion->COD_EMPR, '', '', '');

        $funcion = $this;

        return view('ordenpedido.consolidadoap.consolidadopedidoaprueba', [
            'funcion' => $this,
            'empresa_id' => $empresa_id,
            'combo_empresa' => $combo_empresa,
            'combo_mes' => $combo_mes,
            'mes_pedido' => $mes_pedido,
            'combo_anio' => $combo_anio,
            'centro_pedido' => $centro_pedido,
            'combo_centro' => $combo_centro,
            'anio_pedido' => $anio_pedido,
            'idopcion' => $idopcion,
            'listaconsolidadopedidoap' => $listaconsolidadopedidoap,
            'lista_aprobados' => $lista_aprobados
        ]); 
    }

    public function actionListarAjaxBuscarConsolidadoPedidoAprobar(Request $request)
    {
        $empresa_id = $request['empresa_id'];
        $centro_pedido = $request['centro_pedido'];
        $mes_pedido = $request['mes_pedido'];
        $anio_pedido = $request['anio_pedido'];
        $idopcion = $request['idopcion'];

        $listaconsolidadopedidoap = $this->lg_lista_consolidado_aprueba($empresa_id, $centro_pedido, $mes_pedido, $anio_pedido);
        $empresa_sesion_id = Session::get('empresas')->COD_EMPR;
        $lista_aprobados = $this->lg_lista_consolidado_aprobados($empresa_sesion_id, '', '', '');

        return view('ordenpedido.consolidadoap.ajax.listasconsolidado_buscar', [
            'listaconsolidadopedidoap' => $listaconsolidadopedidoap,
            'lista_aprobados' => $lista_aprobados,
            'idopcion' => $idopcion,
            'ajax' => true,
        ]);
    }

    public function actionListarAjaxDetalleConsolidadoPedidoAprobar(Request $request)
    {
        $id_consolidado = $request->input('id_consolidado');
        $idopcion = $request->input('idopcion');

        $usuario_id = Session::get('usuario')->usuarioosiris_id;
        $empresa_sesion = Session::get('empresas');

        $planilla = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.empresa_osiris_id', $empresa_sesion->COD_EMPR)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->select('C.COD_CENTRO', 'C.NOM_CENTRO')
            ->first();

        $cod_centro_usuario = $planilla ? $planilla->COD_CENTRO : '';
        $nom_centro_usuario = $planilla ? $planilla->NOM_CENTRO : '';

        $listadetalle = $this->lg_lista_detalle_consolidado_aprobado($id_consolidado);

        return view('ordenpedido.consolidadoap.ajax.listadetalleconsolidadoap', [
            'listadetalle' => $listadetalle,
            'idopcion' => $idopcion,
            'cod_centro_usuario' => $cod_centro_usuario,
            'nom_centro_usuario' => $nom_centro_usuario,
            'ajax' => true,
        ]);
    }

    public function actionAjaxGuardarCantidadCompradaAprobar(Request $request)
    {
        $id_consolidado = $request->input('id_consolidado');
        $detalles_json = $request->input('detalles');
        $detalles = json_decode($detalles_json, true);

        try {
            DB::beginTransaction();

            foreach ($detalles as $det) {
                DB::connection('sqlsrv')->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE')
                    ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
                    ->where('COD_PRODUCTO', $det['cod_producto'])
                    ->update([
                        'CAN_COMPRADA' => $det['cantidad'],
                        'IND_COMPRA'   => $det['ind_compra'] ?? null,
                        'COD_CENTRO_COMPRA' => $det['cod_centro_compra'] ?? null,
                        'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id
                    ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'mensaje' => 'Cantidades y origen de compra actualizados correctamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al actualizar: ' . $e->getMessage()
            ]);
        }
    }

    public function actionAjaxAprobarConsolidadoPedido(Request $request)
    {
        $id_consolidado = $request->input('id_consolidado');
        $detalles_json = $request->input('detalles');
        $detalles = json_decode($detalles_json, true);

        try {
            DB::beginTransaction();

            // 1. Guardar los cambios en el detalle (si se envían)
            if (!empty($detalles)) {
                foreach ($detalles as $det) {
                    DB::connection('sqlsrv')->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE')
                        ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
                        ->where('COD_PRODUCTO', $det['cod_producto'])
                        ->update([
                            'CAN_COMPRADA' => $det['cantidad'],
                            'IND_COMPRA'   => $det['ind_compra'],
                            'COD_CENTRO_COMPRA' => $det['cod_centro_compra'] ?? null,
                            'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id,
                            'FEC_USUARIO_MODIF_AUD' => date('Y-m-d\TH:i:s')
                        ]);
                }
            }

            // 2. Realizamos el UPDATE solicitado para aprobar
            DB::connection('sqlsrv')->table('WEB.ORDEN_PEDIDO_CONSOLIDADO')
                ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
                ->update([
                    'COD_ESTADO' => 'ETM0000000000005', // APROBADO
                    'TXT_ESTADO' => 'APROBADO',
                    'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id,
                    'FEC_USUARIO_MODIF_AUD' => date('Y-m-d\TH:i:s')
                ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'mensaje' => 'Consolidado guardado y aprobado correctamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al aprobar: ' . $e->getMessage()
            ]);
        }
    }

}

 

   
    
