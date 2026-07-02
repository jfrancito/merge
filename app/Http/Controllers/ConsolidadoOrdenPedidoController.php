<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\OrdenPedidoTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoMotivoValeRendir;
use App\Modelos\WEBValeRendir;
use App\Modelos\WEBValeRendirDetalle;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;
use Illuminate\Support\Facades\Log;



class ConsolidadoOrdenPedidoController extends Controller
{
    use OrdenPedidoTraits;

    public function actionAjaxPeriodoConsolidado(Request $request)
    {

        $empresa = $request['empresa_id'];

        $periodo_mes = DB::table('Web.periodos')
            ->where('COD_EMPR', $empresa)
            ->pluck('TXT_NOMBRE', 'COD_PERIODO')
            ->toArray();

        $combo_mes = ['' => 'Seleccione Mes'] + $periodo_mes;

        return view('ordenpedido.consolidado.ajax.alistaperiodo', [
            'combo_mes' => $combo_mes,
            'mes_pedido' => ''
        ]);
    }

    public function actionConsolidadoOrdenPedido($idopcion)
    {
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Lista Orden Pedido Por Consolidar');

        $empresa_sesion = Session::get('empresas');
        $usuario_id = Session::get('usuario')->usuarioosiris_id;

        $planilla = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->first();

        $combo_empresa = [];
        $ind_compras = false;

        /*
        if ($planilla) {
            if ($planilla->cadarea === 'COMPRAS') {
                $ind_compras = true;
            }
        }
        */

        if ($ind_compras) {
            $combo_empresa = DB::table('STD.EMPRESA')
                ->where('COD_ESTADO', 1)
                ->where('IND_SISTEMA', 1)
                ->pluck('NOM_EMPR', 'COD_EMPR')
                ->toArray();
        } else {
            $combo_empresa = [
                $empresa_sesion->COD_EMPR => $empresa_sesion->NOM_EMPR
            ];
        }

        /* =========================
           COMBOS GENERALES
        ========================== */

        $periodo_mes = DB::table('Web.periodos')
            ->whereIn('COD_EMPR', array_keys($combo_empresa))
            ->pluck('TXT_NOMBRE', 'COD_PERIODO')
            ->toArray();

        $combo_mes = ['' => 'Seleccione Mes'] + $periodo_mes;

        $familias = DB::table('CMP.CATEGORIA')
            ->where('TXT_GRUPO', 'FAMILIA_MATERIAL')
            ->where('COD_ESTADO', 1)
            ->where('IND_ACTIVO', 1)
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

        $combo_familia = ['' => 'Seleccione Familia'] + $familias;

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

        $combo_centro = [];
        $centro_id = '';

        $centro = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->where('C.COD_ESTADO', 1)
            ->select('C.COD_CENTRO', 'C.NOM_CENTRO')
            ->first();

        if (!$ind_compras) {
            $centro_id = $centro->COD_CENTRO;
            $combo_centro = [
                $centro->COD_CENTRO => $centro->NOM_CENTRO
            ];
        } else {
            $centro_id = 'CEN0000000000001';
            $combo_centro = DB::table('ALM.CENTRO')
                ->where('COD_ESTADO', 1)
                ->pluck('NOM_CENTRO', 'COD_CENTRO')
                ->toArray();
        }
        /* =========================
           VARIABLES FILTRO
        ========================== */

        $empresa_id = '';
        $mes_pedido = '';
        $anio_pedido = '';
        $familia_id = '';

        $listaordenpedido = $this->lg_lista_cabecera_pedido_consolidado(
            $empresa_id,
            $centro_id,
            $mes_pedido,
            $anio_pedido
        );

        $listaordenconsolidado = $this->lg_lista_cabecera_consolidado();

        return view('ordenpedido.consolidado.ordenpedidoconsolidado', [
            'listaordenpedido' => $listaordenpedido,
            'listaordenconsolidado' => $listaordenconsolidado,
            'funcion' => $this,
            'idopcion' => $idopcion,
            'empresa_id' => $empresa_id,
            'combo_empresa' => $combo_empresa,
            'combo_mes' => $combo_mes,
            'mes_pedido' => $mes_pedido,
            'combo_anio' => $combo_anio,
            'centro_id' => $centro_id,
            'combo_centro' => $combo_centro,
            'anio_pedido' => $anio_pedido,
            'familia_id' => $familia_id,
            'combo_familia' => $combo_familia
        ]);
    }

    public function actionListarAjaxBuscarConsolidadoOP(Request $request)
    {

        $empresa_id = $request['empresa_id'];
        $centro_id = $request['centro_id'];
        $mes_pedido = $request['mes_pedido'];
        $anio_pedido = $request['anio_pedido'];
        $idopcion = $request['idopcion'];


        $listaordenpedido = $this->lg_lista_cabecera_pedido_consolidado($empresa_id, $centro_id, $mes_pedido, $anio_pedido);

        $funcion = $this;

        return View::make(
            'ordenpedido/consolidado/listaordenpedidoporconsolidar',
            [
                'listaordenpedido' => $listaordenpedido,
                'idopcion' => $idopcion,
                'empresa_id' => $empresa_id,
                'centro_id' => $centro_id,
                'mes_pedido' => $mes_pedido,
                'anio_pedido' => $anio_pedido,
                'funcion' => $funcion,
                'ajax' => true,
            ]
        );
    }

    public function actionGuardarConsolidado(Request $request)
    {
        $pedidos_input = $request->input('pedidos_ids');
        $productos = $request->input('productos');

        if (empty($pedidos_input) || empty($productos)) {
            return response()->json([
                'success' => false,
                'mensaje' => 'No hay pedidos o productos seleccionados.'
            ]);
        }

        //print_r($productos);
        //exit();

        // 🔹 Soporta string o array
        $pedidos_ids = is_array($pedidos_input)
            ? $pedidos_input
            : array_filter(array_map('trim', explode(',', $pedidos_input)));

        try {

            DB::beginTransaction();

            // 2. Obtener pedido base
            $base_order = DB::table('WEB.ORDEN_PEDIDO')
                ->where('ID_PEDIDO', $pedidos_ids[0])
                ->first();

            if (!$base_order) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se encontró información del pedido base.'
                ]);
            }

            $fec_pedido = date('Y-m-d');

            $cod_periodo = $base_order->COD_PERIODO;
            $cod_empr = $base_order->COD_EMPR;
            $txt_nombre = $base_order->TXT_NOMBRE;
            $cod_estado = 'ETM0000000000001';
            $txt_estado = 'GENERADO';

            $productos_agrupados = collect($productos)->groupBy(function ($item) {
                return $item['COD_FAMILIA'] . '|' . $item['COD_CENTRO'];
            });

            $consolidated_ids = [];

            foreach ($productos_agrupados as $items_del_grupo) {

                $primero = $items_del_grupo->first();
                $cod_familia = $primero['COD_FAMILIA'];
                $nom_familia = $primero['FAMILIA'];
                $cod_centro = $primero['COD_CENTRO'];

                // 4. Crear cabecera consolidado
                $id_pedido_consolidado = $this->insertOrdenPedidoConsolidado(
                    'I',
                    '',
                    $fec_pedido,
                    $cod_periodo,
                    $txt_nombre,
                    $cod_empr,
                    $cod_centro,
                    $cod_familia,
                    $nom_familia,
                    $cod_estado,
                    $txt_estado,
                    true,
                    Session::get('usuario')->id
                );

                $consolidated_ids[] = $id_pedido_consolidado;

                // 5. Insertar detalles
                foreach ($items_del_grupo as $p) {

                    $cantidad = (float) $p['CANTIDAD'];
                    $stock = (float) $p['STOCK'];
                    $reservado = (float) $p['CAN_STOCK_RESERVADO'];
                    $diferencia = $cantidad - $stock + $reservado;

                    $this->insertOrdenPedidoConsolidadoDetalle(
                        'I',
                        $id_pedido_consolidado,
                        $p['COD_PRODUCTO'],
                        $p['PRODUCTO'],
                        $p['COD_MEDIDA'],
                        $p['MEDIDA'],
                        $cantidad,
                        $stock,
                        $reservado,
                        $diferencia,
                        $cod_familia,
                        $nom_familia,
                        true
                    );
                }
            }

            // 6. Guardar relación N:N en CMP.REFERENCIA_ASOC
            foreach ($pedidos_ids as $pedido_id) {
                DB::table('CMP.REFERENCIA_ASOC')->where('COD_TABLA', '=', $pedido_id)->delete();
                foreach ($consolidated_ids as $consolidado_id) {
                    DB::table('CMP.REFERENCIA_ASOC')->insert([
                        'COD_TABLA' => $pedido_id,
                        'COD_TABLA_ASOC' => $consolidado_id,
                        'TXT_TABLA' => 'WEB.ORDEN_PEDIDO',
                        'TXT_TABLA_ASOC' => 'WEB.ORDEN_PEDIDO_CONSOLIDADO',
                        'TXT_DESCRIPCION' => '',
                        'TXT_GLOSA' => '',
                        'CAN_AUX1' => null,
                        'CAN_AUX2' => null,
                        'CAN_AUX3' => null,
                        'TXT_TIPO_REFERENCIA' => 'CONSOLIDADO',
                        'TXT_REFERENCIA' => '',
                        'COD_USUARIO_CREA_AUD' => Session::get('usuario')->id,
                        'FEC_USUARIO_CREA_AUD' => date('Y-m-d\TH:i:s'),
                        'COD_ESTADO' => 1
                    ]);
                }
            }

            DB::table('WEB.ORDEN_PEDIDO')
                ->whereIn('ID_PEDIDO', $pedidos_ids)
                ->update([
                    'CONSOLIDADO' => 'SI'
                ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'mensaje' => 'Se generaron ' . count($consolidated_ids) .
                    ' consolidados correctamente.<br>IDs: ' .
                    implode(', ', $consolidated_ids)
            ]);

        } catch (\Exception $e) {
            Log::error("Error en actionAjaxPedidoEditar: " . $e->getMessage());
            DB::rollBack();
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al guardar consolidados: ' . $e->getMessage()
            ]);
        }
    }


    public function actionListarAjaxDetalleConsolidadoOP(Request $request)
    {
        $id_consolidado = $request->input('id_consolidado');
        $familia_id = $request->input('familia_id');

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

        $listadetalle = $this->lg_lista_detalle_consolidado($id_consolidado, $familia_id);

        return view('ordenpedido.consolidado.ajax.listadetalleconsolidado', [
            'listadetalle' => $listadetalle,
            'cod_centro_usuario' => $cod_centro_usuario,
            'nom_centro_usuario' => $nom_centro_usuario,
            'ajax' => true,
        ]);
    }

    public function actionAjaxGuardarCantidadComprada(Request $request)
    {
        $id_consolidado = $request->input('id_consolidado');
        $detalles_json = $request->input('detalles');
        $detalles = json_decode($detalles_json, true);

        try {
            DB::beginTransaction();

            foreach ($detalles as $det) {
                // Realizar el update usando la conexión sqlsrv para mayor seguridad
                DB::connection('sqlsrv')->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE')
                    ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
                    ->where('COD_PRODUCTO', $det['cod_producto'])
                    ->update([
                        'CAN_COMPRADA' => $det['cantidad'],
                        'IND_COMPRA' => $det['ind_compra'] ?? null,
                        'COD_CENTRO_COMPRA' => $det['cod_centro_compra'] ?? null,
                        'COD_ALMACEN' => $det['cod_almacen'] ?? null,
                        'NOM_ALMACEN' => $det['nom_almacen'] ?? null,
                        'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id // Guardamos el ID del usuario
                    ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'mensaje' => 'Cantidades actualizadas correctamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al actualizar: ' . $e->getMessage()
            ]);
        }
    }

    public function actionAjaxAprobarConsolidado(Request $request)
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
                            'IND_COMPRA' => $det['ind_compra'],
                            'COD_CENTRO_COMPRA' => $det['cod_centro_compra'] ?? null,
                            'COD_ALMACEN' => $det['cod_almacen'] ?? null,
                            'NOM_ALMACEN' => $det['nom_almacen'] ?? null,
                            'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id,
                            'FEC_USUARIO_MODIF_AUD' => date('Y-m-d\TH:i:s')
                        ]);
                }
            }

            // 2. Realizamos el UPDATE solicitado para cerrar
            DB::connection('sqlsrv')->table('WEB.ORDEN_PEDIDO_CONSOLIDADO')
                ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
                ->update([
                    'COD_ESTADO' => 'ETM0000000000015', // COD_ESTADO POR APROBAR JEFE DE COMPRAS
                    'TXT_ESTADO' => 'POR APROBAR JEFE DE COMPRAS',
                    'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id,
                    'FEC_USUARIO_MODIF_AUD' => date('Y-m-d\TH:i:s')
                ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'mensaje' => 'Consolidado guardado y cerrado correctamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al cerrar: ' . $e->getMessage()
            ]);
        }
    }

    public function actionAjaxEliminarConsolidado(Request $request)
    {
        $id_consolidado = $request->input('id_consolidado');

        try {
            DB::beginTransaction();

            // 1. Obtener IDs de pedidos asociados antes de borrar la referencia
            $pedidos_ids = DB::table('CMP.REFERENCIA_ASOC')
                ->where('COD_TABLA_ASOC', $id_consolidado)
                ->where('TXT_TABLA_ASOC', 'WEB.ORDEN_PEDIDO_CONSOLIDADO')
                ->pluck('COD_TABLA')
                ->toArray();

            // 2. Regresar a NULL la columna CONSOLIDADO en WEB.ORDEN_PEDIDO
            if (!empty($pedidos_ids)) {
                DB::table('WEB.ORDEN_PEDIDO')
                    ->whereIn('ID_PEDIDO', $pedidos_ids)
                    ->update(['CONSOLIDADO' => null]);
            }

            // 3. Eliminar detalle del consolidado
            DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE')
                ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
                ->delete();

            // 4. Eliminar cabecera del consolidado
            DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO')
                ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
                ->delete();

            // 5. Eliminar asociaciones en CMP.REFERENCIA_ASOC
            DB::table('CMP.REFERENCIA_ASOC')
                ->where('COD_TABLA_ASOC', $id_consolidado)
                ->where('TXT_TABLA_ASOC', 'WEB.ORDEN_PEDIDO_CONSOLIDADO')
                ->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'mensaje' => 'Consolidado de sede eliminado correctamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al eliminar el consolidado: ' . $e->getMessage()
            ]);
        }
    }

    public function actionAjaxBuscarConsolidadoGenerado(Request $request)
    {
        $empresa_id = $request['empresa_id'];
        $centro_id = $request['centro_id'];
        $mes_pedido = $request['mes_pedido'];
        $anio_pedido = $request['anio_pedido'];

        $listaordenconsolidado = $this->lg_lista_cabecera_consolidado($empresa_id, $centro_id, $mes_pedido, $anio_pedido);

        return View::make('ordenpedido/consolidado/ajax/alistaconsolidadogenerado', [
            'listaordenconsolidado' => $listaordenconsolidado,
            'ajax' => true,
        ]);
    }

    public function actionExportarExcelConsolidado($id_consolidado)
    {
        set_time_limit(0);

        $usuario_id = Session::get('usuario')->usuarioosiris_id;
        $empresa_sesion = Session::get('empresas');

        // Consultamos el centro del trabajador. Quitamos el filtro de empresa_osiris_id
        // ya que el centro del trabajador es de catálogo global y en platrabajadores puede 
        // figurar bajo otra empresa asociada.
        $planilla = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->where('C.COD_ESTADO', 1)
            ->select('C.COD_CENTRO', 'C.NOM_CENTRO')
            ->first();

        $cod_centro_usuario = $planilla ? trim($planilla->COD_CENTRO) : '';

        $familia_id = 'TODO';
        $listadetalle = $this->lg_lista_detalle_consolidado($id_consolidado, $familia_id);

        if ($cod_centro_usuario !== '') {
            $listadetalle = collect($listadetalle)->filter(function ($item) use ($cod_centro_usuario) {
                // 1. Obtener el código de centro de compra guardado en base de datos
                $item_cod_centro_compra = trim($item->COD_CENTRO_COMPRA ?? '');

                // 2. Si no tiene código de centro de compra en BD, aplicamos reglas fallback en base a IND_COMPRA o empresa
                if ($item_cod_centro_compra === '') {
                    $current_ind_compra = trim($item->IND_COMPRA ?? '');
                    $current_cod_empr   = trim($item->COD_EMPR ?? '');
                    $current_cod_centro = trim($item->COD_CENTRO ?? '');

                    if ($current_ind_compra !== '') {
                        if (strcasecmp($current_ind_compra, 'CHICLAYO') === 0) {
                            $item_cod_centro_compra = 'CEN0000000000001';
                        } elseif (strcasecmp($current_ind_compra, 'LIMA') === 0) {
                            $item_cod_centro_compra = 'CEN0000000000002';
                        } else {
                            $item_cod_centro_compra = $current_cod_centro;
                        }
                    } else {
                        if ($current_cod_empr === 'IACHEM0000007086') {
                            $item_cod_centro_compra = 'CEN0000000000001'; // Chiclayo
                        } elseif ($current_cod_empr === 'IACHEM0000010394') {
                            if ($current_cod_centro === 'CEN0000000000002') {
                                $item_cod_centro_compra = 'CEN0000000000002'; // Lima
                            } elseif ($current_cod_centro === 'CEN0000000000001') {
                                $item_cod_centro_compra = 'CEN0000000000001'; // Chiclayo
                            }
                        }
                    }
                }

                // 3. Fallback final: Si sigue sin asignarse, se asume el centro origen del consolidado
                if ($item_cod_centro_compra === '') {
                    $item_cod_centro_compra = trim($item->COD_CENTRO ?? '');
                }

                // 4. Comparar códigos de centros
                return $item_cod_centro_compra === $cod_centro_usuario;
            })->values();
        }

        $titulo = 'Detalle-Consolidado-' . $id_consolidado;
        $fecha_actual = date("Y-m-d");

        Excel::create($titulo . '-(' . $fecha_actual . ')', function ($excel) use ($listadetalle, $id_consolidado) {
            $excel->sheet('DETALLE', function ($sheet) use ($listadetalle, $id_consolidado) {
                $sheet->loadView('ordenpedido.excel.listaconsolidadodetalleexcel', [
                    'listadetalle' => $listadetalle,
                    'id_consolidado' => $id_consolidado
                ]);
            });
        })->export('xls');
    }
    public function actionExportarExcelMasivoConsolidado(Request $request)
    {
        set_time_limit(0);

        $ids_str = $request->input('ids');
        if (empty($ids_str)) {
            return redirect()->back()->with('error', 'No se proporcionaron consolidados para exportar.');
        }

        $usuario_id = Session::get('usuario')->usuarioosiris_id;

        // Consultamos el centro del trabajador de catálogo global (sin filtrar por empresa_osiris_id)
        $planilla = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->where('C.COD_ESTADO', 1)
            ->select('C.COD_CENTRO', 'C.NOM_CENTRO')
            ->first();

        $cod_centro_usuario = $planilla ? trim($planilla->COD_CENTRO) : '';

        $ids_array = explode(',', $ids_str);
        
        $listadetalle_raw = $this->lg_lista_detalle_consolidado_masivo($ids_array);

        // Filtrar dinámicamente por la zona/sede del usuario logueado usando códigos únicos de centros
        if ($cod_centro_usuario !== '') {
            $listadetalle_raw = collect($listadetalle_raw)->filter(function ($item) use ($cod_centro_usuario) {
                // 1. Obtener el código de centro de compra guardado en base de datos
                $item_cod_centro_compra = trim($item->COD_CENTRO_COMPRA ?? '');

                // 2. Si no tiene código de centro de compra en BD, aplicamos reglas fallback en base a IND_COMPRA o empresa
                if ($item_cod_centro_compra === '') {
                    $current_ind_compra = trim($item->IND_COMPRA ?? '');
                    $current_cod_empr   = trim($item->COD_EMPR ?? '');
                    $current_cod_centro = trim($item->COD_CENTRO ?? '');

                    if ($current_ind_compra !== '') {
                        if (strcasecmp($current_ind_compra, 'CHICLAYO') === 0) {
                            $item_cod_centro_compra = 'CEN0000000000001';
                        } elseif (strcasecmp($current_ind_compra, 'LIMA') === 0) {
                            $item_cod_centro_compra = 'CEN0000000000002';
                        } else {
                            $item_cod_centro_compra = $current_cod_centro;
                        }
                    } else {
                        if ($current_cod_empr === 'IACHEM0000007086') {
                            $item_cod_centro_compra = 'CEN0000000000001'; // Chiclayo
                        } elseif ($current_cod_empr === 'IACHEM0000010394') {
                            if ($current_cod_centro === 'CEN0000000000002') {
                                $item_cod_centro_compra = 'CEN0000000000002'; // Lima
                            } elseif ($current_cod_centro === 'CEN0000000000001') {
                                $item_cod_centro_compra = 'CEN0000000000001'; // Chiclayo
                            }
                        }
                    }
                }

                // 3. Fallback final: Si sigue sin asignarse, se asume el centro origen del consolidado
                if ($item_cod_centro_compra === '') {
                    $item_cod_centro_compra = trim($item->COD_CENTRO ?? '');
                }

                // 4. Comparar códigos de centros
                return $item_cod_centro_compra === $cod_centro_usuario;
            })->values();
        }

        // Agrupación de productos requerida por el usuario
        $listadetalle = collect($listadetalle_raw)->groupBy('COD_PRODUCTO')->map(function ($items) {
            $primerItem = $items->first();
            
            // IDs de consolidado concatenados
            $ids_concatenados = $items->pluck('ID_PEDIDO_CONSOLIDADO')->unique()->implode(' - ');
            
            // Sumatorias
            $cantidad = $items->sum('CANTIDAD');
            $stock = $items->sum('STOCK');
            $reservado = $items->sum('RESERVADO');
            $diferencia = $items->sum('DIFERENCIA');
            
            $can_comprar = $items->sum(function($item) {
                if (!is_null($item->CAN_COMPRADA)) return $item->CAN_COMPRADA;
                return $item->DIFERENCIA < 0 ? 0 : $item->DIFERENCIA;
            });
            
            // Áreas (únicas y concatenadas separadas por coma)
            $areas = $items->pluck('TXT_AREAS')->map(function($a) {
                return array_map('trim', explode(',', $a));
            })->flatten()->filter()->unique()->implode(', ');
            
            // Glosas (únicas y concatenadas, ya vienen como "AREA : GLOSA" desde SQL)
            $glosas = $items->pluck('TXT_GLOSAS')->map(function($g) {
                return array_map('trim', explode(',', $g));
            })->flatten()->filter()->unique()->implode(', ');

            return (object)[
                'ID_PEDIDO_CONSOLIDADO' => $ids_concatenados,
                'COD_PRODUCTO' => $primerItem->COD_PRODUCTO,
                'NOM_PRODUCTO' => $primerItem->NOM_PRODUCTO,
                'NOM_CATEGORIA_MEDIDA' => $primerItem->NOM_CATEGORIA_MEDIDA,
                'NOM_CATEGORIA_FAMILIA' => $primerItem->NOM_CATEGORIA_FAMILIA,
                'TXT_CENTROS' => $primerItem->TXT_CENTROS,
                'TXT_AREAS' => $areas,
                'TXT_GLOSAS' => $glosas,
                'CANTIDAD' => $cantidad,
                'STOCK' => $stock,
                'RESERVADO' => $reservado,
                'DIFERENCIA' => $diferencia,
                'CAN_COMPRADA' => $can_comprar
            ];
        })->values();

        $titulo = 'Detalle-Consolidado-Masivo';
        $fecha_actual = date("Y-m-d");

        Excel::create($titulo . '-(' . $fecha_actual . ')', function ($excel) use ($listadetalle, $ids_array) {
            $excel->sheet('DETALLE MASIVO', function ($sheet) use ($listadetalle, $ids_array) {
                $sheet->loadView('ordenpedido.excel.listaconsolidadodetallemasivoexcel', [
                    'listadetalle' => $listadetalle,
                    'cantidad_consolidados' => count($ids_array)
                ]);
            });
        })->export('xls');
    }

    public function actionAjaxObtenerAlmacenesProductoCentro(Request $request)
    {
        $cod_producto = $request->input('cod_producto');
        $cod_centro = $request->input('cod_centro');
        $cod_empr = $request->input('cod_empr') ?: Session::get('empresas')->COD_EMPR;

        // Determinar dinámicamente la conexión según el centro de compra
        $conexionbd = 'sqlsrv';
        if ($cod_centro == 'CEN0000000000004') { // Rioja
            $conexionbd = 'sqlsrv_r';
        } elseif ($cod_centro == 'CEN0000000000006') { // Bellavista
            $conexionbd = 'sqlsrv_b';
        }

        $almacenes = DB::connection($conexionbd)
            ->table('ALM.REFERENCIA_ALMACEN as RA')
            ->join('ALM.PRODUCTO as P', 'P.COD_PRODUCTO', '=', 'RA.COD_TABLA_ASOC')
            ->join('ALM.ALMACEN as AL', 'AL.COD_ALMACEN', '=', 'RA.COD_ALMACEN')
            ->join('ALM.CENTRO as CE', 'CE.COD_CENTRO', '=', 'AL.COD_CENTRO')
            ->where('RA.TXT_TABLA_ASOC', 'ALM.PRODUCTO')
            ->where('RA.COD_TABLA_ASOC', $cod_producto)
            ->where('AL.COD_EMPR', $cod_empr)
            ->where('CE.COD_CENTRO', $cod_centro)
            ->where('RA.COD_ESTADO', 1)
            /*->where(function($query) {
                $query->where('AL.NOM_ALMACEN', 'like', '%ALMACEN SUMINISTROS%')
                      ->orWhere('AL.NOM_ALMACEN', 'like', '%ACTIVO FIJO%');
            })*/
            ->select('AL.COD_ALMACEN', 'AL.NOM_ALMACEN')
            ->orderBy('AL.NOM_ALMACEN', 'asc')
            ->get();

        return response()->json($almacenes);
    }
}



