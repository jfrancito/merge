<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View; // <-- Agregar esto
use Illuminate\Http\Request;
use App\Traits\OrdenPedidoTraits;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Session;

class ReporteOrdenPedidoController extends Controller
{
    use OrdenPedidoTraits;

    public function actionReporteOrdenPedido($idopcion)
    {
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista Orden de Pedido');
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

        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        $fechadia = date_format(date_create(date('d-m-Y')), 'd-m-Y');
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
	) {
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
