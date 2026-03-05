<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Traits\OrdenPedidoTraits;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;
use Maatwebsite\Excel\Facades\Excel;


class ConsolidadoGeneralOrdenPedidoController extends Controller
{
    use OrdenPedidoTraits;

    public function actionConsolidadoGeneralOrdenPedido($idopcion)
    {
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Lista Orden Pedido General');

        $empresa_sesion = Session::get('empresas');
        $usuario_id = Session::get('usuario')->usuarioosiris_id;

        $combo_empresa = [
            $empresa_sesion->COD_EMPR => $empresa_sesion->NOM_EMPR
        ];

        /* =========================
           COMBOS GENERALES
        ========================== */

        $periodo_mes = DB::table('Web.periodos')
            ->whereIn('COD_EMPR', array_keys($combo_empresa))
            ->pluck('TXT_NOMBRE', 'COD_PERIODO')
            ->toArray();

        $combo_mes = ['' => 'Seleccione Mes'] + $periodo_mes;


        $periodo_anio = DB::table('Web.periodos')
            ->where('activo', 1)
            ->whereIn('COD_EMPR', array_keys($combo_empresa))
            ->pluck('anio', 'anio')
            ->toArray();

        $combo_anio = $periodo_anio;

        $anio_pedido = '';

        if (!empty($periodo_anio)) {
            $keys = array_keys($periodo_anio);
            $anio_pedido = $keys[0]; // primer año (el más reciente)
        }
        /* =========================
           OBTENER CENTRO DEL LOGUEADO
        ========================== */

        $empresa_id = '';
        $mes_pedido = '';
        $anio_pedido = '';


        $listaordenpedidogeneral = $this->lg_lista_cabecera_pedido_consolidado_general($empresa_id,
            $mes_pedido,
            $anio_pedido
        );

        $listaordenpedidogeneralterminado = $this->lg_lista_cabecera_pedido_consolidado_general_terminado();


        return view('ordenpedido.consolidadogeneral.ordenpedidoconsolidadogeneral', [
            'listaordenpedidogeneral' => $listaordenpedidogeneral,
            'listaordenpedidogeneralterminado' => $listaordenpedidogeneralterminado,
            'funcion' => $this,
            'empresa_id' => $empresa_id,
            'combo_empresa' => $combo_empresa,
            'combo_mes' => $combo_mes,
            'mes_pedido' => $mes_pedido,
            'combo_anio' => $combo_anio,
            'anio_pedido' => $anio_pedido,
            'idopcion' => $idopcion
        ]);
    }

    public function actionGuardarConsolidadoGeneral(Request $request)
    {
        $pedidos_input = $request->input('pedidos_ids');

        if (empty($pedidos_input)) {
            return response()->json([
                'success' => false,
                'mensaje' => 'No hay consolidados seleccionados.'
            ]);
        }

        $pedidos_ids = is_array($pedidos_input)
            ? $pedidos_input
            : array_filter(array_map('trim', explode(',', $pedidos_input)));

        try {

            DB::beginTransaction();

            // 1️⃣ Obtener detalles origen
            $detalles_origen = DB::connection('sqlsrv')
                ->table('WEB.ORDEN_PEDIDO_CONSOLIDADO as C')
                ->join(
                    'WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE as D',
                    'C.ID_PEDIDO_CONSOLIDADO',
                    '=',
                    'D.ID_PEDIDO_CONSOLIDADO'
                )
                ->whereIn('C.ID_PEDIDO_CONSOLIDADO', $pedidos_ids)
                ->where('D.ACTIVO', 1)
                ->select(
                    'D.*',
                    'C.COD_PERIODO',
                    'C.COD_EMPR',
                    'C.COD_CENTRO',
                    'C.TXT_NOMBRE'
                )
                ->get();

            // 2️⃣ Agrupar por FAMILIA
            $agrupado_por_familia = $detalles_origen->groupBy('COD_CATEGORIA_FAMILIA');

            $generated_ids = [];

            foreach ($agrupado_por_familia as $familia_id => $items) {

                $first = $items->first();

                // 3️⃣ Crear CABECERA CONSOLIDADO GENERAL
                $id_general = $this->insertOrdenPedidoConsolidadoGeneral(
                    'I',
                    '',
                    date('Y-m-d'),
                    $first->COD_PERIODO,
                    $first->TXT_NOMBRE,
                    $first->COD_EMPR,
                    'CEN0000000000001',
                    $familia_id,
                    $first->NOM_CATEGORIA_FAMILIA,
                    'ETM0000000000001',
                    'GENERADO',
                    true,
                    Session::get('usuario')->id
                );

                $generated_ids[] = $id_general;

                // 4️⃣ Agrupar detalle por PRODUCTO
                $items_agrupados = $items->groupBy('COD_PRODUCTO');

                foreach ($items_agrupados as $prod_items) {

                    $p = $prod_items->first();

                    $sum_cantidad = $prod_items->sum('CANTIDAD');
                    $sum_stock = $prod_items->sum('STOCK');
                    $sum_reservado = $prod_items->sum('RESERVADO');
                    $sum_diferencia = $prod_items->sum('DIFERENCIA');

                    $this->insertOrdenPedidoConsolidadoGeneralDetalle(
                        'I',
                        $id_general,
                        'CEN0000000000001',
                        $p->COD_PRODUCTO,
                        $p->NOM_PRODUCTO,
                        $p->COD_CATEGORIA_MEDIDA,
                        $p->NOM_CATEGORIA_MEDIDA,
                        $sum_cantidad,
                        $sum_stock,
                        $sum_reservado,
                        $sum_diferencia,
                        $familia_id,
                        $p->NOM_CATEGORIA_FAMILIA,
                        true
                    );
                }

                // 5️⃣ Insertar referencias POR CADA FAMILIA
                // 5️⃣ Insertar referencias POR CADA FAMILIA
                foreach ($items->pluck('ID_PEDIDO_CONSOLIDADO')->unique() as $origen_id) {

                    // 🔥 ELIMINAR RELACIONES ANTERIORES
                    DB::table('CMP.REFERENCIA_ASOC')
                        ->where('COD_TABLA', $origen_id)
                        ->where('TXT_TIPO_REFERENCIA', 'CONSOLIDADO_GENERAL')
                        ->delete();

                    // 🔥 INSERTAR NUEVA RELACIÓN
                    DB::table('CMP.REFERENCIA_ASOC')->insert([
                        'COD_TABLA' => $origen_id,
                        'COD_TABLA_ASOC' => $id_general,
                        'TXT_TABLA' => 'WEB.ORDEN_PEDIDO_CONSOLIDADO',
                        'TXT_TABLA_ASOC' => 'WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL',
                        'TXT_TIPO_REFERENCIA' => 'CONSOLIDADO_GENERAL',
                        'COD_USUARIO_CREA_AUD' => Session::get('usuario')->id,
                        'FEC_USUARIO_CREA_AUD' => date('Y-m-d\TH:i:s'),
                        'COD_ESTADO' => 1
                    ]);
                }
            }

            // 6️⃣ Actualizar estado origen
            DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO')
                ->whereIn('ID_PEDIDO_CONSOLIDADO', $pedidos_ids)
                ->update(['CONSOLIDADO_GENERAL' => 'SI']);

            DB::commit();

            return response()->json([
                'success' => true,
                'mensaje' => 'Se generaron ' . count($generated_ids) . ' consolidados generales.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'mensaje' => 'Error: ' . $e->getMessage()
            ]);
        }
    }


    public function actionListarAjaxDetalleConsolidadoGeneralOP(Request $request)
    {
        $id_consolidado_general = $request->input('id_consolidado_general');
        $familia_id = $request->input('familia_id');
        $listadetalle = $this->lg_lista_detalle_consolidado_general($id_consolidado_general, $familia_id);
        return view('ordenpedido.consolidadogeneral.ajax.listadetalleconsolidadogeneral', [
            'listadetalle' => $listadetalle,
            'ajax' => true,
        ]);
    }

    public function actionAjaxBuscarConsolidadoGeneralOP(Request $request)
    {
        $empresa_id = $request['empresa_id'];
        $mes_pedido = $request['mes_pedido'];
        $anio_pedido = $request['anio_pedido'];
        $idopcion = $request['idopcion'];

        //DD($empresa_id, $mes_pedido, $anio_pedido);

        $listaordenpedidogeneral = $this->lg_lista_cabecera_pedido_consolidado_general(
            $empresa_id,
            $mes_pedido,
            $anio_pedido
        );

        //DD($listaordenpedidogeneral);

        return view('ordenpedido.consolidadogeneral.alistaordenconsolidadogeneral', [
            'listaordenpedidogeneral' => $listaordenpedidogeneral,
            'idopcion' => $idopcion,
            'empresa_id' => $empresa_id,
            'mes_pedido' => $mes_pedido,
            'anio_pedido' => $anio_pedido,
            'ajax' => true,
        ]);
    }

    public function actionAjaxGuardarCantidadCompradaGeneral(Request $request)
    {
        $id_consolidado_general = $request->input('id_consolidado_general');
        $detalles_json = $request->input('detalles');
        $detalles = json_decode($detalles_json, true);

        try {
            DB::beginTransaction();

            foreach ($detalles as $det) {
                DB::connection('sqlsrv')->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                    ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $id_consolidado_general)
                    ->where('COD_PRODUCTO', $det['cod_producto'])
                    ->update([
                        'CAN_COMPRADA' => $det['cantidad'],
                        'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id
                    ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'mensaje' => 'Cantidades actualizadas correctamente.']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'mensaje' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function actionAjaxAprobarConsolidadoGeneral(Request $request)
    {
        $id_consolidado_general = $request->input('id_consolidado_general');
        try {
            DB::beginTransaction();

            DB::connection('sqlsrv')->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL')
                ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $id_consolidado_general)
                ->update([
                    'COD_ESTADO' => 'ETM0000000000005', // APROBADO
                    'TXT_ESTADO' => 'APROBADO',
                    'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id,
                    'FEC_USUARIO_MODIF_AUD' => date('Y-m-d\TH:i:s')


                ]);

            DB::commit();
            return response()->json(['success' => true, 'mensaje' => 'Consolidado general aprobado correctamente.']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'mensaje' => 'Error al aprobar: ' . $e->getMessage()]);
        }
    }

    public function actionDescargarExcelDetalleConsolidadoGeneral($id_consolidado_general, $familia_id)
    {
        set_time_limit(0);
        if ($familia_id == 'TODO') $familia_id = '';
        $listadetalle = $this->lg_lista_detalle_consolidado_general_excel($id_consolidado_general, $familia_id);

        $titulo = 'Detalle-Consolidado-General-' . $id_consolidado_general;
        $fecha_actual = date("Y-m-d");
        Excel::create($titulo . '-(' . $fecha_actual . ')', function ($excel) use ($listadetalle, $titulo) {
            $excel->sheet('DETALLE', function ($sheet) use ($listadetalle, $titulo) {
                $sheet->loadView('ordenpedido.excel.listadetalleconsolidadogeneralexcel', [
                    'listadetalle' => $listadetalle,
                    'titulo' => $titulo
                ]);
            });
        })->export('xls');
    }

    public function actionDescargarExcelDetalleConsolidadoGeneralArea($id_consolidado_general, $familia_id)
    {
        set_time_limit(0);
        if ($familia_id == 'TODO') $familia_id = '';
        $listadetalle = $this->lg_lista_detalle_consolidado_general_excel_area($id_consolidado_general, $familia_id);

        $titulo = 'Detalle-Consolidado-General-' . $id_consolidado_general;
        $fecha_actual = date("Y-m-d");
        Excel::create($titulo . '-(' . $fecha_actual . ')', function ($excel) use ($listadetalle, $titulo) {
            $excel->sheet('DETALLE', function ($sheet) use ($listadetalle, $titulo) {
                $sheet->loadView('ordenpedido.excel.listadetalleconsolidadogeneralexcelarea', [
                    'listadetalle' => $listadetalle,
                    'titulo' => $titulo
                ]);
            });
        })->export('xls');
    }

}


