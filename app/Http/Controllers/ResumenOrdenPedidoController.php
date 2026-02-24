<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View; // <-- Agregar esto
use Illuminate\Http\Request;
use App\Traits\OrdenPedidoTraits;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Session;

class ResumenOrdenPedidoController extends Controller
{
    use OrdenPedidoTraits;

    public function actionResumenOrdenPedido($idopcion)
    {
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista Resumen Orden de Pedido');
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;

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
         $listaordenpedido = $this->lg_lista_cabecera_pedido_resumen($fecha_inicio, $fecha_fin, $empresa_id, $centro_pedido);


        $funcion = $this;
            

         return view('ordenpedido.reporte.resumenordenpedido', [
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


     public function actionListarAjaxBuscarResumenOP(Request $request)
    {

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        $empresa_id = $request['empresa_id'];
        $centro_pedido = $request['centro_pedido'];
        $idopcion = $request['idopcion'];


 		$listaordenpedido = $this->lg_lista_cabecera_pedido_resumen($fecha_inicio, $fecha_fin, $empresa_id, $centro_pedido);
        $funcion = $this;

        return View::make('ordenpedido/reporte/alistaresumenordenpedido',
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

     public function actionResumenMasivoExcelOp($fecha_inicio, $fecha_fin, $empresa_id, $centro_pedido, $idopcion)
    {
        set_time_limit(0);

        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        $fechadia = date_format(date_create(date('d-m-Y')), 'd-m-Y');
        $fecha_actual = date("Y-m-d");
        $titulo = 'Orden-de-Pedido';
        $funcion = $this;

        $listaordenpedido = $this->lg_lista_cabecera_pedido_resumen($fecha_inicio, $fecha_fin, $empresa_id, $centro_pedido);
        Excel::create($titulo . '-(' . $fecha_actual . ')', function ($excel) use ($listaordenpedido, $titulo, $funcion) {
            $excel->sheet('ORDEN PEDIDO', function ($sheet) use ($listaordenpedido, $titulo, $funcion) {

                $sheet->loadView('reporte/excel/listaresumenmasivoop')->with('listaordenpedido', $listaordenpedido)
                    ->with('titulo', $titulo)
                    ->with('funcion', $funcion);
            });
        })->export('xls');
    }

}
