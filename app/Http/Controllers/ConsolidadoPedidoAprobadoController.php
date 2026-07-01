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
                        'COD_ALMACEN' => $det['cod_almacen'] ?? null,
                        'NOM_ALMACEN' => $det['nom_almacen'] ?? null,
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
                            'COD_ALMACEN' => $det['cod_almacen'] ?? null,
                            'NOM_ALMACEN' => $det['nom_almacen'] ?? null,
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

            // --- REPLICACIÓN EN ZONAS SEGÚN EL DETALLE ---
            try {
                // Función auxiliar para formatear fechas de manera inequívoca para SQL Server (evita problemas de idioma/regional en zonas)
                $safe_format_dates = function($array) {
                    foreach ($array as $key => $value) {
                        if (is_string($value)) {
                            // 1. Datetime con o sin milisegundos: YYYY-MM-DD HH:MM:SS(.fff)
                            if (preg_match('/^(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2}:\d{2}(\.\d+)?)$/', $value, $matches)) {
                                $array[$key] = $matches[1] . 'T' . $matches[2];
                            }
                            // 2. Date únicamente: YYYY-MM-DD
                            elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $matches)) {
                                $array[$key] = $matches[1] . $matches[2] . $matches[3]; // Formato YYYYMMDD libre de ambigüedades
                            }
                        }
                    }
                    return $array;
                };

                // 1. Obtener la cabecera completa que acabamos de aprobar
                $cabecera = DB::connection('sqlsrv')->table('WEB.ORDEN_PEDIDO_CONSOLIDADO')
                    ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
                    ->first();

                if ($cabecera) {
                    // 2. Obtener todos los detalles activos de este consolidado
                    $detalles_consolidado = DB::connection('sqlsrv')->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE')
                        ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
                        ->where('ACTIVO', 1)
                        ->get();

                    // 3. Agrupar los detalles por la conexión correspondiente a su COD_CENTRO_COMPRA
                    $detalles_por_zona = [];
                    foreach ($detalles_consolidado as $det) {
                        $cod_centro_compra = $det->COD_CENTRO_COMPRA;
                        $conexionbd = 'sqlsrv';

                        if ($cod_centro_compra == 'CEN0000000000004') {
                            $conexionbd = 'sqlsrv_r';
                        } else {
                            if ($cod_centro_compra == 'CEN0000000000006') {
                                $conexionbd = 'sqlsrv_b';
                            }
                        }

                        if ($conexionbd !== 'sqlsrv') {
                            $detalles_por_zona[$conexionbd][] = $det;
                        }
                    }

                    // 4. Insertar cabecera y detalles en las zonas correspondientes
                    foreach ($detalles_por_zona as $conn => $list_details) {
                        try {
                            $cab_array = $safe_format_dates((array)$cabecera);

                            // Sincronizar cabecera (usando updateOrInsert para evitar llaves duplicadas)
                            DB::connection($conn)->table('WEB.ORDEN_PEDIDO_CONSOLIDADO')
                                ->updateOrInsert(
                                    ['ID_PEDIDO_CONSOLIDADO' => $id_consolidado],
                                    $cab_array
                                );

                            // Eliminar detalles anteriores de este consolidado en esa zona específica para evitar duplicados
                            DB::connection($conn)->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE')
                                ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
                                ->delete();

                            // E insertar únicamente los detalles asignados a esa zona
                            foreach ($list_details as $det) {
                                $det_array = $safe_format_dates((array)$det);
                                DB::connection($conn)->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE')
                                    ->insert($det_array);
                            }
                        } catch (\Exception $ez) {
                            \Illuminate\Support\Facades\Log::error("Error al replicar consolidado $id_consolidado a zona ($conn): " . $ez->getMessage());
                        }
                    }
                }
            } catch (\Exception $e_rep) {
                \Illuminate\Support\Facades\Log::error("Error general en el proceso de réplica para consolidado $id_consolidado: " . $e_rep->getMessage());
            }

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

 

   
    
