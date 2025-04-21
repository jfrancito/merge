<?php

namespace App\Http\Controllers;

use App\Modelos\STDEmpresa;
use App\Traits\ComprasEnvasesSedeTraits;
use App\Traits\CuentaSaldosTraits;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use View;

class ReporteComprasEnvasesSedeController extends Controller
{
    use ComprasEnvasesSedeTraits;

    public function actionReporteComprasEnvasesSede($id_opcion)
    {
        $combo_empresa = $this->listaEmpresa('', 'TODOS');

        $compras_internacional = array();
        $compras_comercial = array();

        $combo_centro_internacional = $this->listaCentro();
        $combo_centro_comercial = $this->listaCentro();

        $total_internacional = 0.0000;
        $total_comercial = 0.0000;
        $total_porcentaje_internacional = 0.0000;
        $total_porcentaje_comercial = 0.0000;

        return View::make('reporte/reportecomprasenvasessede',
            [
                'combo_empresa' => $combo_empresa,
                'compras_internacional' => $compras_internacional,
                'compras_comercial' => $compras_comercial,
                'centros_internacional' => $combo_centro_internacional,
                'centros_comercial' => $combo_centro_comercial,
                'total_internacional' => $total_internacional,
                'total_comercial' => $total_comercial,
                'total_porcentaje_internacional' => $total_porcentaje_internacional,
                'total_porcentaje_comercial' => $total_porcentaje_comercial,
                'todos' => '',
                'fecha_ini' => date('Y-m-d'),
                'fecha_fin' => date('Y-m-d'),
                'idopcion' => $id_opcion,
            ]);
    }

    public function actionAjaxListarReporteComprasEnvasesSede(Request $request)
    {
        $fecha_ini = $request['fecha_ini'];
        $fecha_fin = $request['fecha_fin'];
        $cod_empresa = $request['cod_empresa'];
        $id_opcion = $request['idopcion'];

        $compras_internacional = array();
        $compras_comercial = array();
        $combo_centro_internacional = $this->listaCentro();
        $combo_centro_comercial = $this->listaCentro();
        $total_internacional = 0.0000;
        $total_comercial = 0.0000;
        $total_porcentaje_internacional = 0.0000;
        $total_porcentaje_comercial = 0.0000;

        if(is_null($cod_empresa)){
            $cod_empresa = '';
            $compras_internacional = $this->generar_reporte('IACHEM0000010394', $fecha_ini, $fecha_fin);
            $compras_comercial = $this->generar_reporte('IACHEM0000007086', $fecha_ini, $fecha_fin);
        } else {
            if($cod_empresa === 'IACHEM0000007086') {
                $compras_comercial = $this->generar_reporte($cod_empresa, $fecha_ini, $fecha_fin);
            } else {
                $compras_internacional = $this->generar_reporte($cod_empresa, $fecha_ini, $fecha_fin);
            }
        }

        if(count($compras_comercial) > 0){
            foreach($compras_comercial as $compra){
                foreach($combo_centro_comercial as $centro){
                    $centro['MONTO'] = $centro['MONTO'] + $compra[$centro['COD_CENTRO']];
                }
                $total_comercial = $total_comercial + $compra['TOTAL'];
            }
            foreach($compras_comercial as $compra){
                $compra['PORCENTAJE'] = ($compra['TOTAL']*100)/$total_comercial;
                $total_porcentaje_comercial =  $total_porcentaje_comercial + $compra['PORCENTAJE'];
            }
        }

        if(count($compras_internacional) > 0){
            foreach($compras_internacional as $compra){
                foreach($combo_centro_internacional as $centro){
                    $centro['MONTO'] = $centro['MONTO'] + $compra[$centro['COD_CENTRO']];
                }
                $total_internacional = $total_internacional + $compra['TOTAL'];
            }
            foreach($compras_internacional as $compra){
                $compra['PORCENTAJE'] = ($compra['TOTAL']*100)/$total_internacional;
                $total_porcentaje_internacional =  $total_porcentaje_internacional + $compra['PORCENTAJE'];
            }
        }

        $funcion = $this;

        return View::make('reporte/ajax/alistareportecomprasenvasessede',
            [
                'compras_internacional' => $compras_internacional,
                'compras_comercial' => $compras_comercial,
                'centros_internacional' => $combo_centro_internacional,
                'centros_comercial' => $combo_centro_comercial,
                'total_internacional' => $total_internacional,
                'total_comercial' => $total_comercial,
                'total_porcentaje_internacional' => $total_porcentaje_internacional,
                'total_porcentaje_comercial' => $total_porcentaje_comercial,
                'todos' => $cod_empresa,
                'idopcion' => $id_opcion,
                'funcion' => $funcion,
                'ajax' => true
            ]);
    }

    public function actionAjaxListarReporteComprasEnvasesSedeExcel(Request $request)
    {
        set_time_limit(0);

        $fecha_ini = $request['fecha_ini'];
        $fecha_fin = $request['fecha_fin'];
        $cod_empresa = $request['cod_empresa'];

        $compras_internacional = array();
        $compras_comercial = array();
        $combo_centro_internacional = $this->listaCentro();
        $combo_centro_comercial = $this->listaCentro();
        $total_internacional = 0.0000;
        $total_comercial = 0.0000;
        $total_porcentaje_internacional = 0.0000;
        $total_porcentaje_comercial = 0.0000;

        if(is_null($cod_empresa)){
            $cod_empresa = '';
            $compras_internacional = $this->generar_reporte('IACHEM0000010394', $fecha_ini, $fecha_fin);
            $compras_comercial = $this->generar_reporte('IACHEM0000007086', $fecha_ini, $fecha_fin);
        } else {
            if($cod_empresa === 'IACHEM0000007086') {
                $compras_comercial = $this->generar_reporte($cod_empresa, $fecha_ini, $fecha_fin);
            } else {
                $compras_internacional = $this->generar_reporte($cod_empresa, $fecha_ini, $fecha_fin);
            }
        }

        if(count($compras_comercial) > 0){
            foreach($compras_comercial as $compra){
                foreach($combo_centro_comercial as $centro){
                    $centro['MONTO'] = $centro['MONTO'] + $compra[$centro['COD_CENTRO']];
                }
                $total_comercial = $total_comercial + $compra['TOTAL'];
            }
            foreach($compras_comercial as $compra){
                $compra['PORCENTAJE'] = ($compra['TOTAL']*100)/$total_comercial;
                $total_porcentaje_comercial =  $total_porcentaje_comercial + $compra['PORCENTAJE'];
            }
        }

        if(count($compras_internacional) > 0){
            foreach($compras_internacional as $compra){
                foreach($combo_centro_internacional as $centro){
                    $centro['MONTO'] = $centro['MONTO'] + $compra[$centro['COD_CENTRO']];
                }
                $total_internacional = $total_internacional + $compra['TOTAL'];
            }
            foreach($compras_internacional as $compra){
                $compra['PORCENTAJE'] = ($compra['TOTAL']*100)/$total_internacional;
                $total_porcentaje_internacional =  $total_porcentaje_internacional + $compra['PORCENTAJE'];
            }
        }

        $funcion = $this;

        $titulo = 'Reporte-Compras-Envases-Sede';

        Excel::create($titulo, function ($excel) use ($compras_internacional, $compras_comercial,
            $combo_centro_internacional, $total_internacional, $total_porcentaje_internacional,
            $combo_centro_comercial, $total_comercial, $total_porcentaje_comercial, $funcion) {
            if(count($compras_internacional)>0) {
                $excel->sheet('Envases II', function ($sheet) use ($compras_internacional, $combo_centro_internacional,
                    $total_internacional, $total_porcentaje_internacional, $funcion) {
                    $sheet->setColumnFormat(array(
                        'C:I' => '0.00'
                    ));
                    $sheet->loadView('reporte/excel/listacomprasenvasessedeinternacional')
                        ->with('funcion', $funcion)
                        ->with('compras_internacional', $compras_internacional)
                        ->with('centros_internacional', $combo_centro_internacional)
                        ->with('total_internacional', $total_internacional)
                        ->with('total_porcentaje_internacional', $total_porcentaje_internacional);
                });
            }
            if(count($compras_comercial)>0) {
                $excel->sheet('Envases IC', function ($sheet) use ($compras_comercial, $combo_centro_comercial,
                    $total_comercial, $total_porcentaje_comercial, $funcion) {
                    $sheet->setColumnFormat(array(
                        'C:I' => '0.00'
                    ));
                    $sheet->loadView('reporte/excel/listacomprasenvasessedecomercial')
                        ->with('funcion', $funcion)
                        ->with('compras_comercial', $compras_comercial)
                        ->with('centros_comercial', $combo_centro_comercial)
                        ->with('total_comercial', $total_comercial)
                        ->with('total_porcentaje_comercial', $total_porcentaje_comercial);
                });
            }
        })->export('xlsx');
    }
}
