<?php

namespace App\Http\Controllers;

use App\Modelos\ALMCentro;
use App\Traits\GeneralesTraits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

// <-- Agregar esto
use Illuminate\Http\Request;
use App\Traits\OrdenPedidoTraits;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Session;

class ReporteOrdenPedidoController extends Controller
{
    use OrdenPedidoTraits;
    use GeneralesTraits;

    public function actionReporteOrdenPedido($idopcion)
    {
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista Orden de Pedido');

        $combo_empresa = [
            'TODO' => 'TODO',
            'IACHEM0000010394' => 'INDUAMERICA INTERNACIONAL S.A.C.',
            'IACHEM0000007086' => 'INDUAMERICA COMERCIAL SOCIEDAD ANONIMA CERRADA',
        ];

        $fecha_inicio = $this->fecha_menos_diez_dias;

        $fecha_fin = $this->fecha_sin_hora;

        $combo_centro = [
            'TODO' => 'TODO',
            'CEN0000000000001' => 'CHICLAYO',
            'CEN0000000000002' => 'LIMA',
            'CEN0000000000003' => 'RIOJA',
            'CEN0000000000004' => 'BELLAVISTA',

        ];

        $empresa_id = 'TODO';

        $centro_pedido = 'TODO';

        $listaordenpedido = $this->lg_lista_cabecera_pedido($fecha_inicio, $fecha_fin, $empresa_id, $centro_pedido);

        $funcion = $this;

        return view('ordenpedido.reporte.reporteordenpedido', [
            'listaordenpedido' => $listaordenpedido,
            'funcion' => $funcion,
            'idopcion' => $idopcion,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'empresa_id' => $empresa_id,
            'combo_empresa' => $combo_empresa,
            'combo_centro' => $combo_centro,
            'centro_pedido' => $centro_pedido
        ]);

    }

    public function actionReporteOrdenPedidoEstado($id_opcion)
    {
        $validar_url = $this->funciones->getUrl($id_opcion, 'Ver');

        if ($validar_url <> 'true') {
            return $validar_url;
        }

        /******************************************************/

        View::share('titulo', 'Lista Orden de Pedido Estado');

        $array_centro = ALMCentro::where('COD_ESTADO', '=', 1)
            ->pluck('NOM_CENTRO', 'COD_CENTRO')
            ->toArray();

        $array_general = ['' => 'TODOS'];

        $combo_centro = array_merge($array_general, $array_centro);

        $combo_anio = DB::table('Web.periodos')
            ->whereNotNull('COD_PERIODO')  // Mejor que '<>', 'NULL'
            ->distinct()
            ->pluck('anio', 'anio')
            ->toArray();

        $defecto_anio = $this->anio;

        $combo_periodo = $this->generar_combo_periodo_web('SELECCIONE PERIODO', 'TODO', Session::get('empresas')->COD_EMPR, $defecto_anio);

        $resultado = [];

        $funcion = $this;

        return view('ordenpedido.reporte.reporteordenpedidoestado', [
            'resultado' => $resultado,
            'funcion' => $funcion,
            'id_opcion' => $id_opcion,
            'combo_centro' => $combo_centro,
            'combo_anio' => $combo_anio,
            'combo_periodo' => $combo_periodo,
            'defecto_anio' => $defecto_anio,
        ]);

    }

    public function actionListarAjaxReporte(Request $request)
    {

        $periodo = $request['periodo'];
        $anio = $request['anio'];
        $centro = $request['centro'];
        $empresa_id = Session::get('empresas')->COD_EMPR;

        $resultado = $this->reporte_pedidos_estado($periodo, $empresa_id, $centro, $anio);

        $funcion = $this;

        return View::make('ordenpedido/ajax/alistareporteordenpedidoestado',
            [
                'resultado' => $resultado,
                'ajax' => true,
                'funcion' => $funcion
            ]);
    }

    public function actionListarPeriodo(Request $request)
    {

        $anio = $request['anio'];
        $empresa_id = Session::get('empresas')->COD_EMPR;

        $combo_periodo = $this->generar_combo_periodo_web('SELECCIONE PERIODO', 'TODO', $empresa_id, $anio);

        $funcion = $this;

        return View::make('ordenpedido/ajax/comboperiodo',
            [
                'combo_periodo' => $combo_periodo,
                'ajax' => true,
                'funcion' => $funcion
            ]);
    }

    public function actionListarAjaxReporteExcel(Request $request)
    {
        set_time_limit(0);

        $periodo = $request['periodo'];
        $anio = $request['anio'];
        $centro = $request['centro'];
        $empresa_id = Session::get('empresas')->COD_EMPR;

        $resultado = $this->reporte_pedidos_estado($periodo, $empresa_id, $centro, $anio);


        Excel::create('REPORTE_ORDEN_PEDIDO_ESTADO', function ($excel) use ($resultado) {

            $excel->sheet('ORDEN PEDIDO ESTADO', function ($sheet) use ($resultado) {

                $sheet->loadView('ordenpedido/excel/listaordenpedidoestadoexcel', [
                    'resultado' => $resultado
                ]);

            });

        })->export('xlsx');
    }

    public function actionListarAjaxBuscarDocumentoOP(Request $request)
    {

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        $empresa_id = $request['empresa_id'];
        $centro_pedido = $request['centro_pedido'];
        $idopcion = $request['idopcion'];

        $listaordenpedido = $this->lg_lista_cabecera_pedido($fecha_inicio, $fecha_fin, $empresa_id, $centro_pedido);

        $funcion = $this;

        return View::make('ordenpedido/reporte/alistareporteordenpedido',
            [
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'empresa_id' => $empresa_id,
                'centro_pedido' => $centro_pedido,
                'idopcion' => $idopcion,
                'listaordenpedido' => $listaordenpedido,
                'ajax' => true,
                'funcion' => $funcion
            ]);
    }

    public function actionComprobanteMasivoExcelOp($fecha_inicio, $fecha_fin, $empresa_id, $centro_pedido, $idopcion)
    {
        set_time_limit(0);

        $fecha_actual = date("Y-m-d");
        $titulo = 'Orden-de-Pedido';
        $funcion = $this;

        $listaordenpedido = $this->lg_lista_cabecera_pedido($fecha_inicio, $fecha_fin, $empresa_id, $centro_pedido);
        Excel::create($titulo . '-(' . $fecha_actual . ')', function ($excel) use ($listaordenpedido, $titulo, $funcion) {
            $excel->sheet('ORDEN PEDIDO', function ($sheet) use ($listaordenpedido, $titulo, $funcion) {

                $sheet->loadView('reporte/excel/listacomprobantemasivoop')->with('listaordenpedido', $listaordenpedido)
                    ->with('titulo', $titulo)
                    ->with('funcion', $funcion);
            });
        })->export('xls');
    }

    public function actionDiseñoMasivoExcelOp(
        $fecha_inicio,
        $fecha_fin,
        $empresa_id,
        $centro_pedido,
        $idopcion
    )
    {
        set_time_limit(0);

        $titulo = 'Orden-de-Pedido';
        $fecha_actual = date("Y-m-d");

        $listaordenpedido = $this->lg_lista_cabecera_pedido(
            $fecha_inicio,
            $fecha_fin,
            $empresa_id,
            $centro_pedido
        );

        // 🔴 AGRUPAR AQUÍ
        $pedidos = collect($listaordenpedido)->groupBy('ID_PEDIDO');

        Excel::create($titulo . '-(' . $fecha_actual . ')', function ($excel) use ($pedidos) {

            $excel->sheet('ORDEN PEDIDO', function ($sheet) use ($pedidos) {

                $sheet->loadView('reporte/excel/listapedidomasivoop', [
                    'pedidos' => $pedidos
                ]);

            });

        })->export('xls');
    }
}
