<?php

namespace App\Http\Controllers;

use App\Modelos\ALMCentro;
use App\Traits\IngresosSalidasEnvasesTraits;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use View;
use Session;
use Nexmo;

class IngresosSalidasEnvasesController extends Controller
{

    use IngresosSalidasEnvasesTraits;

    public function actionListarIngresosSalidasEnvases($idopcion)
    {
        $validar_url = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validar_url <> 'true') {
            return $validar_url;
        }

        View::share('titulo', 'Ingresos / Salidas Envase, Bobinas y Materiales');

        $combo_empresa = $this->listaEmpresa('', 'TODOS');
        $combo_centro = $this->listaCentro('', 'TODOS');
        $combo_tipo_producto = $this->listaCategoriaTipo('TIPO_PRODUCTO', '', 'SELECCIONE TIPO PRODUCTO', array('TPR0000000000004', 'TPR0000000000005', 'TPR0000000000001'));
        //$combo_familia = $this->listaCategoria('FAMILIA_MATERIAL', '', 'SELECCIONE FAMILIA');
        $combo_familia = array();
        $combo_subfamilia = array();
        $combo_producto = array();

        $empresa_defecto = '';
        $centro_defecto = '';
        $tipo_producto_defecto = '';
        $familia_defecto = '';
        $subfamilia_defecto = '';
        $producto_defecto = '';

        $lista_internacional = array();
        $lista_comercial = array();
        $stock_anterior_internacional = 0.0000;
        $stock_anterior_comercial = 0.0000;
        $stock_compras_internacional = 0.0000;
        $stock_compras_comercial = 0.0000;
        $stock_anterior_compras_internacional = 0.0000;
        $stock_anterior_compras_comercial = 0.0000;
        $total_anterior_internacional = 0.0000;
        $total_anterior_comercial = 0.0000;
        $total_compras_internacional = 0.0000;
        $total_compras_comercial = 0.0000;
        $total_anterior_compras_internacional = 0.0000;
        $total_anterior_compras_comercial = 0.0000;
        $stock_ingresos_internacional = 0.0000;
        $stock_ingresos_comercial = 0.0000;
        $stock_salidas_internacional = 0.0000;
        $stock_salidas_comercial = 0.0000;
        $stock_ultima_fecha_internacional = 0.0000;
        $stock_ultima_fecha_comercial = 0.0000;
        $total_ingresos_internacional = 0.0000;
        $total_ingresos_comercial = 0.0000;
        $total_salidas_internacional = 0.0000;
        $total_salidas_comercial = 0.0000;
        $total_ultima_fecha_internacional = 0.0000;
        $total_ultima_fecha_comercial = 0.0000;

        $funcion = $this;

        return View::make('reporte/logistica/reporteingresossalidasenvases',
            [
                'idopcion' => $idopcion,
                'funcion' => $funcion,
                'ajax' => true,
                'fecha_corte' => date('Y-m-d'),
                'combo_empresa' => $combo_empresa,
                'combo_centro' => $combo_centro,
                'combo_tipo_producto' => $combo_tipo_producto,
                'combo_familia' => $combo_familia,
                'combo_subfamilia' => $combo_subfamilia,
                'combo_producto' => $combo_producto,
                'empresa_defecto' => $empresa_defecto,
                'centro_defecto' => $centro_defecto,
                'tipo_producto_defecto' => $tipo_producto_defecto,
                'familia_defecto' => $familia_defecto,
                'subfamilia_defecto' => $subfamilia_defecto,
                'producto_defecto' => $producto_defecto,
                'sede' => 'TODOS',
                'lista_internacional' => $lista_internacional,
                'lista_comercial' => $lista_comercial,
                'stock_anterior_internacional' => $stock_anterior_internacional,
                'stock_anterior_comercial' => $stock_anterior_comercial,
                'stock_compras_internacional' => $stock_compras_internacional,
                'stock_compras_comercial' => $stock_compras_comercial,
                'stock_anterior_compras_internacional' => $stock_anterior_compras_internacional,
                'stock_anterior_compras_comercial' => $stock_anterior_compras_comercial,
                'total_anterior_internacional' => $total_anterior_internacional,
                'total_anterior_comercial' => $total_anterior_comercial,
                'total_compras_internacional' => $total_compras_internacional,
                'total_compras_comercial' => $total_compras_comercial,
                'total_anterior_compras_internacional' => $total_anterior_compras_internacional,
                'total_anterior_compras_comercial' => $total_anterior_compras_comercial,
                'stock_ingresos_internacional' => $stock_ingresos_internacional,
                'stock_ingresos_comercial' => $stock_ingresos_comercial,
                'stock_salidas_internacional' => $stock_salidas_internacional,
                'stock_salidas_comercial' => $stock_salidas_comercial,
                'stock_ultima_fecha_internacional' => $stock_ultima_fecha_internacional,
                'stock_ultima_fecha_comercial' => $stock_ultima_fecha_comercial,
                'total_ingresos_internacional' => $total_ingresos_internacional,
                'total_ingresos_comercial' => $total_ingresos_comercial,
                'total_salidas_internacional' => $total_salidas_internacional,
                'total_salidas_comercial' => $total_salidas_comercial,
                'total_ultima_fecha_internacional' => $total_ultima_fecha_internacional,
                'total_ultima_fecha_comercial' => $total_ultima_fecha_comercial,
            ]);
    }

    public function actionAjaxListarFamilia(Request $request)
    {
        $tipo_producto = $request['tipo_producto'];
        $id_opcion = $request['id_opcion'];

        $combo_familia = $this->listaFamiliaTipo($tipo_producto, '', 'SELECCIONE FAMILIA');

        $familia_defecto = '';

        $funcion = $this;
        return View::make('general/combo/combofamilia',
            [
                'combo_familia' => $combo_familia,
                'familia_defecto' => $familia_defecto,
                'idopcion' => $id_opcion,
                'funcion' => $funcion,
                'ajax' => true
            ]);
    }

    public function actionAjaxListarSubFamilia(Request $request)
    {
        $familia = $request['familia'];
        $id_opcion = $request['id_opcion'];

        $combo_subfamilia = $this->listaCodigoCategoria($familia, '', 'SELECCIONE SUBFAMILIA');

        $subfamilia_defecto = '';

        $funcion = $this;
        return View::make('general/combo/combosubfamilia',
            [
                'combo_subfamilia' => $combo_subfamilia,
                'subfamilia_defecto' => $subfamilia_defecto,
                'idopcion' => $id_opcion,
                'funcion' => $funcion,
                'ajax' => true
            ]);
    }

    public function actionAjaxListarProducto(Request $request)
    {
        $subfamilia = $request['subfamilia'];
        $familia = $request['familia'];
        $tipo_producto = $request['tipo_producto'];
        $id_opcion = $request['id_opcion'];

        $combo_producto = $this->listaProducto($tipo_producto, $familia, $subfamilia, '', 'SELECCIONE PRODUCTO');

        $producto_defecto = '';

        $funcion = $this;
        return View::make('general/combo/comboproducto',
            [
                'combo_producto' => $combo_producto,
                'producto_defecto' => $producto_defecto,
                'idopcion' => $id_opcion,
                'funcion' => $funcion,
                'ajax' => true
            ]);
    }

    public function actionAjaxListarIngresosSalidasEnvases(Request $request)
    {
        $empresa = is_null($request['empresa']) ? '' : $request['empresa'];
        $centro = is_null($request['centro']) ? '' : $request['centro'];
        $fecha = is_null($request['fecha']) ? date('Y-m-d') : $request['fecha'];
        $cod_producto = is_null($request['producto']) ? '' : $request['producto'];
        $cod_sub_familia = is_null($request['subfamilia']) ? '' : $request['subfamilia'];
        $cod_familia = is_null($request['familia']) ? '' : $request['familia'];
        $cod_tipo_producto = is_null($request['tipo_producto']) ? '' : $request['tipo_producto'];
        $id_opcion = $request['id_opcion'];

        $lista_internacional = array();
        $lista_comercial = array();
        $stock_anterior_internacional = 0.0000;
        $stock_anterior_comercial = 0.0000;
        $stock_compras_internacional = 0.0000;
        $stock_compras_comercial = 0.0000;
        $stock_anterior_compras_internacional = 0.0000;
        $stock_anterior_compras_comercial = 0.0000;
        $total_anterior_internacional = 0.0000;
        $total_anterior_comercial = 0.0000;
        $total_compras_internacional = 0.0000;
        $total_compras_comercial = 0.0000;
        $total_anterior_compras_internacional = 0.0000;
        $total_anterior_compras_comercial = 0.0000;

        $stock_ingresos_internacional = 0.0000;
        $stock_ingresos_comercial = 0.0000;
        $stock_salidas_internacional = 0.0000;
        $stock_salidas_comercial = 0.0000;
        $stock_ultima_fecha_internacional = 0.0000;
        $stock_ultima_fecha_comercial = 0.0000;
        $total_ingresos_internacional = 0.0000;
        $total_ingresos_comercial = 0.0000;
        $total_salidas_internacional = 0.0000;
        $total_salidas_comercial = 0.0000;
        $total_ultima_fecha_internacional = 0.0000;
        $total_ultima_fecha_comercial = 0.0000;

        if ($empresa <> '') {
            if ($empresa === 'IACHEM0000007086') {
                $lista_comercial = $this->generar_reporte('RES', $empresa, $centro, '', $empresa, $empresa,
                    $cod_producto, $fecha, '', 1, $cod_familia, $cod_sub_familia,
                    $cod_tipo_producto);
            } else {
                $lista_internacional = $this->generar_reporte('RES', $empresa, $centro, '', $empresa, $empresa,
                    $cod_producto, $fecha, '', 1, $cod_familia, $cod_sub_familia,
                    $cod_tipo_producto);
            }
        } else {
            $lista_internacional = $this->generar_reporte('RES', 'IACHEM0000010394', $centro, '', 'IACHEM0000010394', 'IACHEM0000010394',
                $cod_producto, $fecha, '', 1, $cod_familia, $cod_sub_familia,
                $cod_tipo_producto);
            $lista_comercial = $this->generar_reporte('RES', 'IACHEM0000007086', $centro, '', 'IACHEM0000007086', 'IACHEM0000007086',
                $cod_producto, $fecha, '', 1, $cod_familia, $cod_sub_familia,
                $cod_tipo_producto);
        }

        if (count($lista_comercial) > 0) {
            foreach ($lista_comercial as $compra) {
                $stock_anterior_comercial = $stock_anterior_comercial + $compra['STOCK_ANT'];
                $stock_compras_comercial = $stock_compras_comercial + $compra['STOCK_COMP'];
                $stock_anterior_compras_comercial = $stock_anterior_compras_comercial + $compra['STOCK_FECHA'];
                $total_anterior_comercial = $total_anterior_comercial + $compra['COSTO_TOTAL_ANT'];
                $total_compras_comercial = $total_compras_comercial + $compra['COSTO_TOTAL_COMP'];
                $total_anterior_compras_comercial = $total_anterior_compras_comercial + $compra['COSTO_FECHA'];

                $stock_ingresos_comercial = $stock_ingresos_comercial + $compra['STOCK_ING'];
                $stock_salidas_comercial = $stock_salidas_comercial + $compra['STOCK_SAL'];
                $stock_ultima_fecha_comercial = $stock_ultima_fecha_comercial + $compra['STOCK_ULTIMA_FECHA'];
                $total_ingresos_comercial = $total_ingresos_comercial + $compra['COSTO_TOTAL_ING'];
                $total_salidas_comercial = $total_salidas_comercial + $compra['COSTO_TOTAL_SAL'];
                $total_ultima_fecha_comercial = $total_ultima_fecha_comercial + $compra['COSTO_ULTIMA_FECHA'];

            }
        }

        if (count($lista_internacional) > 0) {
            foreach ($lista_internacional as $compra) {
                $stock_anterior_internacional = $stock_anterior_internacional + $compra['STOCK_ANT'];
                $stock_compras_internacional = $stock_compras_internacional + $compra['STOCK_COMP'];
                $stock_anterior_compras_internacional = $stock_anterior_compras_internacional + $compra['STOCK_FECHA'];
                $total_anterior_internacional = $total_anterior_internacional + $compra['COSTO_TOTAL_ANT'];
                $total_compras_internacional = $total_compras_internacional + $compra['COSTO_TOTAL_COMP'];
                $total_anterior_compras_internacional = $total_anterior_compras_internacional + $compra['COSTO_FECHA'];

                $stock_ingresos_internacional = $stock_ingresos_internacional + $compra['STOCK_ING'];
                $stock_salidas_internacional = $stock_salidas_internacional + $compra['STOCK_SAL'];
                $stock_ultima_fecha_internacional = $stock_ultima_fecha_internacional + $compra['STOCK_ULTIMA_FECHA'];
                $total_ingresos_internacional = $total_ingresos_internacional + $compra['COSTO_TOTAL_ING'];
                $total_salidas_internacional = $total_salidas_internacional + $compra['COSTO_TOTAL_SAL'];
                $total_ultima_fecha_internacional = $total_ultima_fecha_internacional + $compra['COSTO_ULTIMA_FECHA'];

            }
        }

        if ($centro <> '') {
            $centro_get = ALMCentro::where('COD_CENTRO', $centro)->first();
            $sede = $centro_get->NOM_CENTRO;
        } else {
            $sede = 'TODOS';
        }

        $funcion = $this;

        return View::make('reporte/logistica/ajax/alistareporteingresossalidasenvases',
            [
                'lista_internacional' => $lista_internacional,
                'lista_comercial' => $lista_comercial,
                'stock_anterior_internacional' => $stock_anterior_internacional,
                'stock_anterior_comercial' => $stock_anterior_comercial,
                'stock_compras_internacional' => $stock_compras_internacional,
                'stock_compras_comercial' => $stock_compras_comercial,
                'stock_anterior_compras_internacional' => $stock_anterior_compras_internacional,
                'stock_anterior_compras_comercial' => $stock_anterior_compras_comercial,
                'total_anterior_internacional' => $total_anterior_internacional,
                'total_anterior_comercial' => $total_anterior_comercial,
                'total_compras_internacional' => $total_compras_internacional,
                'total_compras_comercial' => $total_compras_comercial,
                'total_anterior_compras_internacional' => $total_anterior_compras_internacional,
                'total_anterior_compras_comercial' => $total_anterior_compras_comercial,

                'stock_ingresos_internacional' => $stock_ingresos_internacional,
                'stock_ingresos_comercial' => $stock_ingresos_comercial,
                'stock_salidas_internacional' => $stock_salidas_internacional,
                'stock_salidas_comercial' => $stock_salidas_comercial,
                'stock_ultima_fecha_internacional' => $stock_ultima_fecha_internacional,
                'stock_ultima_fecha_comercial' => $stock_ultima_fecha_comercial,
                'total_ingresos_internacional' => $total_ingresos_internacional,
                'total_ingresos_comercial' => $total_ingresos_comercial,
                'total_salidas_internacional' => $total_salidas_internacional,
                'total_salidas_comercial' => $total_salidas_comercial,
                'total_ultima_fecha_internacional' => $total_ultima_fecha_internacional,
                'total_ultima_fecha_comercial' => $total_ultima_fecha_comercial,

                'empresa_defecto' => $empresa,
                'sede' => $sede,
                'idopcion' => $id_opcion,
                'funcion' => $funcion,
                'ajax' => true
            ]);
    }

    public function actionAjaxListarIngresosSalidasEnvasesExcel(Request $request)
    {
        set_time_limit(0);

        $empresa = is_null($request['empresa']) ? '' : $request['empresa'];
        $centro = is_null($request['centro']) ? '' : $request['centro'];
        $fecha = is_null($request['fechaCorte']) ? date('Y-m-d') : $request['fechaCorte'];
        $cod_producto = is_null($request['producto']) ? '' : $request['producto'];
        $cod_sub_familia = is_null($request['subfamilia']) ? '' : $request['subfamilia'];
        $cod_familia = is_null($request['familia']) ? '' : $request['familia'];
        $cod_tipo_producto = is_null($request['tipoProducto']) ? '' : $request['tipoProducto'];
        $id_opcion = $request['id_opcion'];

        $lista_internacional = array();
        $lista_comercial = array();
        $stock_anterior_internacional = 0.0000;
        $stock_anterior_comercial = 0.0000;
        $stock_compras_internacional = 0.0000;
        $stock_compras_comercial = 0.0000;
        $stock_anterior_compras_internacional = 0.0000;
        $stock_anterior_compras_comercial = 0.0000;
        $total_anterior_internacional = 0.0000;
        $total_anterior_comercial = 0.0000;
        $total_compras_internacional = 0.0000;
        $total_compras_comercial = 0.0000;
        $total_anterior_compras_internacional = 0.0000;
        $total_anterior_compras_comercial = 0.0000;
        $stock_ingresos_internacional = 0.0000;
        $stock_ingresos_comercial = 0.0000;
        $stock_salidas_internacional = 0.0000;
        $stock_salidas_comercial = 0.0000;
        $stock_ultima_fecha_internacional = 0.0000;
        $stock_ultima_fecha_comercial = 0.0000;
        $total_ingresos_internacional = 0.0000;
        $total_ingresos_comercial = 0.0000;
        $total_salidas_internacional = 0.0000;
        $total_salidas_comercial = 0.0000;
        $total_ultima_fecha_internacional = 0.0000;
        $total_ultima_fecha_comercial = 0.0000;

        if ($empresa <> '') {
            if ($empresa === 'IACHEM0000007086') {
                $lista_comercial = $this->generar_reporte('RES', $empresa, $centro, '', $empresa, $empresa,
                    $cod_producto, $fecha, '', 1, $cod_familia, $cod_sub_familia,
                    $cod_tipo_producto);
            } else {
                $lista_internacional = $this->generar_reporte('RES', $empresa, $centro, '', $empresa, $empresa,
                    $cod_producto, $fecha, '', 1, $cod_familia, $cod_sub_familia,
                    $cod_tipo_producto);
            }
        } else {
            $lista_internacional = $this->generar_reporte('RES', 'IACHEM0000010394', $centro, '', 'IACHEM0000010394', 'IACHEM0000010394',
                $cod_producto, $fecha, '', 1, $cod_familia, $cod_sub_familia,
                $cod_tipo_producto);
            $lista_comercial = $this->generar_reporte('RES', 'IACHEM0000007086', $centro, '', 'IACHEM0000007086', 'IACHEM0000007086',
                $cod_producto, $fecha, '', 1, $cod_familia, $cod_sub_familia,
                $cod_tipo_producto);
        }

        if (count($lista_comercial) > 0) {
            foreach ($lista_comercial as $compra) {
                $stock_anterior_comercial = $stock_anterior_comercial + $compra['STOCK_ANT'];
                $stock_compras_comercial = $stock_compras_comercial + $compra['STOCK_COMP'];
                $stock_anterior_compras_comercial = $stock_anterior_compras_comercial + $compra['STOCK_FECHA'];
                $total_anterior_comercial = $total_anterior_comercial + $compra['COSTO_TOTAL_ANT'];
                $total_compras_comercial = $total_compras_comercial + $compra['COSTO_TOTAL_COMP'];
                $total_anterior_compras_comercial = $total_anterior_compras_comercial + $compra['COSTO_FECHA'];
                $stock_ingresos_comercial = $stock_ingresos_comercial + $compra['STOCK_ING'];
                $stock_salidas_comercial = $stock_salidas_comercial + $compra['STOCK_SAL'];
                $stock_ultima_fecha_comercial = $stock_ultima_fecha_comercial + $compra['STOCK_ULTIMA_FECHA'];
                $total_ingresos_comercial = $total_ingresos_comercial + $compra['COSTO_TOTAL_ING'];
                $total_salidas_comercial = $total_salidas_comercial + $compra['COSTO_TOTAL_SAL'];
                $total_ultima_fecha_comercial = $total_ultima_fecha_comercial + $compra['COSTO_ULTIMA_FECHA'];
            }
        }

        if (count($lista_internacional) > 0) {
            foreach ($lista_internacional as $compra) {
                $stock_anterior_internacional = $stock_anterior_internacional + $compra['STOCK_ANT'];
                $stock_compras_internacional = $stock_compras_internacional + $compra['STOCK_COMP'];
                $stock_anterior_compras_internacional = $stock_anterior_compras_internacional + $compra['STOCK_FECHA'];
                $total_anterior_internacional = $total_anterior_internacional + $compra['COSTO_TOTAL_ANT'];
                $total_compras_internacional = $total_compras_internacional + $compra['COSTO_TOTAL_COMP'];
                $total_anterior_compras_internacional = $total_anterior_compras_internacional + $compra['COSTO_FECHA'];
                $stock_ingresos_internacional = $stock_ingresos_internacional + $compra['STOCK_ING'];
                $stock_salidas_internacional = $stock_salidas_internacional + $compra['STOCK_SAL'];
                $stock_ultima_fecha_internacional = $stock_ultima_fecha_internacional + $compra['STOCK_ULTIMA_FECHA'];
                $total_ingresos_internacional = $total_ingresos_internacional + $compra['COSTO_TOTAL_ING'];
                $total_salidas_internacional = $total_salidas_internacional + $compra['COSTO_TOTAL_SAL'];
                $total_ultima_fecha_internacional = $total_ultima_fecha_internacional + $compra['COSTO_ULTIMA_FECHA'];
            }
        }

        if ($centro <> '') {
            $centro_get = ALMCentro::where('COD_CENTRO', $centro)->first();
            $sede = $centro_get->NOM_CENTRO;
        } else {
            $sede = 'TODOS';
        }

        $funcion = $this;

        $titulo = 'Reporte-Ingresos-Salidas-Envases-Materiales';

        Excel::create($titulo, function ($excel) use (
            $lista_comercial, $stock_anterior_comercial,
            $stock_compras_comercial, $stock_anterior_compras_comercial, $total_anterior_comercial,
            $total_compras_comercial, $total_anterior_compras_comercial, $lista_internacional, $stock_anterior_internacional,
            $stock_compras_internacional, $stock_anterior_compras_internacional, $total_anterior_internacional,
            $total_compras_internacional, $total_anterior_compras_internacional, $stock_ingresos_internacional,
            $stock_ingresos_comercial, $stock_salidas_internacional, $stock_salidas_comercial,
            $stock_ultima_fecha_internacional, $stock_ultima_fecha_comercial, $total_ingresos_internacional,
            $total_ingresos_comercial, $total_salidas_internacional, $total_salidas_comercial,
            $total_ultima_fecha_internacional, $total_ultima_fecha_comercial, $sede, $funcion
        ) {
            if (count($lista_internacional) > 0) {
                $excel->sheet('Ingresos y Salidas II', function ($sheet) use (
                    $lista_internacional, $stock_anterior_internacional,
                    $stock_compras_internacional, $stock_anterior_compras_internacional, $total_anterior_internacional,
                    $total_compras_internacional, $total_anterior_compras_internacional, $stock_ingresos_internacional,
                    $stock_ingresos_comercial, $stock_salidas_internacional, $stock_ultima_fecha_internacional,
                    $total_ingresos_internacional, $total_salidas_internacional, $total_ultima_fecha_internacional,
                    $sede, $funcion
                ) {
                    $sheet->setColumnFormat(array(
                        'C:H' => '0.0000'
                    ));
                    $sheet->loadView('reporte/logistica/excel/listaingresossalidasinternacional')
                        ->with('funcion', $funcion)
                        ->with('lista_internacional', $lista_internacional)
                        ->with('stock_anterior_internacional', $stock_anterior_internacional)
                        ->with('stock_compras_internacional', $stock_compras_internacional)
                        ->with('stock_anterior_compras_internacional', $stock_anterior_compras_internacional)
                        ->with('total_anterior_internacional', $total_anterior_internacional)
                        ->with('total_compras_internacional', $total_compras_internacional)
                        ->with('total_anterior_compras_internacional', $total_anterior_compras_internacional)

                        ->with('stock_ingresos_internacional', $stock_ingresos_internacional)
                        ->with('stock_salidas_internacional', $stock_salidas_internacional)
                        ->with('stock_ultima_fecha_internacional', $stock_ultima_fecha_internacional)
                        ->with('total_ingresos_internacional', $total_ingresos_internacional)
                        ->with('total_salidas_internacional', $total_salidas_internacional)
                        ->with('total_ultima_fecha_internacional', $total_ultima_fecha_internacional)
                        ->with('sede', $sede);
                });
            }
            if (count($lista_comercial) > 0) {
                $excel->sheet('Ingresos y Salidas IC', function ($sheet) use (
                    $lista_comercial, $stock_anterior_comercial,
                    $stock_compras_comercial, $stock_anterior_compras_comercial, $total_anterior_comercial,
                    $total_compras_comercial, $total_anterior_compras_comercial,
                    $stock_ingresos_comercial, $stock_salidas_comercial, $stock_ultima_fecha_comercial,
                    $total_ingresos_comercial, $total_salidas_comercial, $total_ultima_fecha_comercial, $sede, $funcion
                ) {
                    $sheet->setColumnFormat(array(
                        'C:H' => '0.0000'
                    ));
                    $sheet->loadView('reporte/logistica/excel/listaingresossalidascomercial')
                        ->with('funcion', $funcion)
                        ->with('lista_comercial', $lista_comercial)
                        ->with('stock_anterior_comercial', $stock_anterior_comercial)
                        ->with('stock_compras_comercial', $stock_compras_comercial)
                        ->with('stock_anterior_compras_comercial', $stock_anterior_compras_comercial)
                        ->with('total_anterior_comercial', $total_anterior_comercial)
                        ->with('total_compras_comercial', $total_compras_comercial)
                        ->with('total_anterior_compras_comercial', $total_anterior_compras_comercial)

                        ->with('stock_ingresos_comercial', $stock_ingresos_comercial)
                        ->with('stock_salidas_comercial', $stock_salidas_comercial)
                        ->with('stock_ultima_fecha_comercial', $stock_ultima_fecha_comercial)
                        ->with('total_ingresos_comercial', $total_ingresos_comercial)
                        ->with('total_salidas_comercial', $total_salidas_comercial)
                        ->with('total_ultima_fecha_comercial', $total_ultima_fecha_comercial)

                        ->with('sede', $sede);
                });
            }
        })->export('xls');
    }

}
