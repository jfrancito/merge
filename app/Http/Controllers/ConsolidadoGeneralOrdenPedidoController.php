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
        $usuario_id     = Session::get('usuario')->usuarioosiris_id;

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

        $empresa_id   = '';
        $mes_pedido   = '';
        $anio_pedido  = '';
       

      
        $listaordenpedidogeneral = $this->lg_lista_cabecera_pedido_consolidado_general($empresa_id,
            $mes_pedido,
            $anio_pedido
        );

        $listaordenpedidogeneralterminado = $this->lg_lista_cabecera_pedido_consolidado_general_terminado();


        return view('ordenpedido.consolidadogeneral.ordenpedidoconsolidadogeneral', [
            'listaordenpedidogeneral'        => $listaordenpedidogeneral,
            'listaordenpedidogeneralterminado' => $listaordenpedidogeneralterminado,
            'funcion'                 => $this,
            'empresa_id'              => $empresa_id,
            'combo_empresa'           => $combo_empresa,
            'combo_mes'               => $combo_mes,
            'mes_pedido'              => $mes_pedido,
            'combo_anio'              => $combo_anio,
            'anio_pedido'             => $anio_pedido,
            'idopcion'                => $idopcion
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
                ->join('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE as D', 
                       'C.ID_PEDIDO_CONSOLIDADO', '=', 'D.ID_PEDIDO_CONSOLIDADO')
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

            // 2️⃣ Agrupar por FAMILIA (UNA SOLA CABECERA POR FAMILIA)
            $agrupado_por_familia = $detalles_origen->groupBy('COD_CATEGORIA_FAMILIA');

            $generated_ids = [];

            foreach ($agrupado_por_familia as $familia_id => $items) {

                $first = $items->first();

                // 🔹 Obtener TODOS los centros únicos
                $centros_unicos = $items->pluck('COD_CENTRO')->unique()->values();

                // 🔹 Texto concatenado para mostrar en cabecera
                $texto_centros = $centros_unicos->implode(' - ');

                // 3️⃣ Crear CABECERA CONSOLIDADO GENERAL
                $id_general = $this->insertOrdenPedidoConsolidadoGeneral(
                    'I',
                    '',
                    date('Y-m-d'),
                    $first->COD_PERIODO,
                    $first->TXT_NOMBRE,
                    $first->COD_EMPR,
                    null, // 👈 IMPORTANTE: ya no es un solo centro
                    $familia_id,
                    $first->NOM_CATEGORIA_FAMILIA,
                    'ETM0000000000001',
                    'GENERADO',
                    true,
                    Session::get('usuario')->id,
                    $texto_centros // 👈 nuevo campo descriptivo
                );

                $generated_ids[] = $id_general;

                // 4️⃣ AGRUPAR DETALLE POR PRODUCTO + CENTRO
                $items_agrupados = $items->groupBy(function ($item) {
                    return $item->COD_PRODUCTO . '|' . $item->COD_CENTRO;
                });

                foreach ($items_agrupados as $key => $prod_items) {

                    $p = $prod_items->first();

                    $sum_cantidad   = $prod_items->sum('CANTIDAD');
                    $sum_stock      = $prod_items->sum('STOCK');
                    $sum_reservado  = $prod_items->sum('RESERVADO');
                    $sum_diferencia = $sum_cantidad - $sum_stock + $sum_reservado;

                    // 🔹 Insertar detalle con SU CENTRO REAL
                    $this->insertOrdenPedidoConsolidadoGeneralDetalle(
                            'I',
                            $id_general,
                            $p->COD_CENTRO, // 👈 AHORA VA TERCERO
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
                            true // activo
                        );
                }

                // 5️⃣ Insertar referencias
                foreach ($items->pluck('ID_PEDIDO_CONSOLIDADO')->unique() as $origen_id) {

                    DB::table('CMP.REFERENCIA_ASOC')->insert([
                        'COD_TABLA'            => $origen_id,
                        'COD_TABLA_ASOC'       => $id_general,
                        'TXT_TABLA'            => 'WEB.ORDEN_PEDIDO_CONSOLIDADO',
                        'TXT_TABLA_ASOC'       => 'WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL',
                        'TXT_TIPO_REFERENCIA'  => 'CONSOLIDADO_GENERAL',
                        'COD_USUARIO_CREA_AUD' => Session::get('usuario')->id,
                        'FEC_USUARIO_CREA_AUD' => date('Y-m-d\TH:i:s'),
                        'COD_ESTADO'           => 1
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
        $familia_id             = $request->input('familia_id');
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

        $listaordenpedidogeneral = $this->lg_lista_cabecera_pedido_consolidado_general(
            $empresa_id,
            $mes_pedido,
            $anio_pedido
        );

        return view('ordenpedido.consolidadogeneral.alistaordenconsolidadogeneral', [
            'listaordenpedidogeneral' => $listaordenpedidogeneral,
            'idopcion' => $idopcion, 
            'empresa_id' => $empresa_id,
            'mes_pedido' => $mes_pedido,
            'anio_pedido' => $anio_pedido,
            'ajax'   => true,
        ]);
    }

}

   