<?php

namespace App\Http\Controllers;

use App\Traits\CuentaSaldosTraits;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use View;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReporteCuentaSaldoController extends Controller
{
    use CuentaSaldosTraits;

    public function actionReporteCuentaSaldo($id_opcion)
    {
        $combo_tipo_contrato = $this->listaTipoContrato('', 'TODOS');
        $combo_centro = $this->listaCentro('', 'TODOS');
        $tipocambio = $this->getTipoCambio(date('d-m-Y'));

        return View::make('reporte/administracion/reportecuentasaldo',
            [
                'combo_tipo_contrato' => $combo_tipo_contrato,
                'combo_centro' => $combo_centro,
                'fecha_fin' => date('Y-m-d'),
                'tipo_cambio' => $tipocambio,
                'todos' => '',
                'cuentas' => array(),
                'idopcion' => $id_opcion,
            ]);
    }

    public function actionObtenerTipoCambio(Request $request)
    {
        $endDate = $request['endDate'];

        // Convertir la fecha a un timestamp de Unix
        $timestamp = strtotime($endDate);

        // Cambiar el formato de la fecha
        $fecha_formateada = date('d-m-Y', $timestamp);

        $tipocambio = $this->getTipoCambio($fecha_formateada);

        return response()->json($tipocambio);
    }

    public function actionAjaxListarReporteCuentasSaldo(Request $request)
    {
        $fechabilitacion = $request['fecha_fin'];
        $tcventa = $request['tc_venta'];
        $tccompra = $request['tc_compra'];
        $codcentro = $request['cod_centro'];
        $tipocuenta = $request['tipo_cuenta'];

        if ($codcentro === null){
            $codcentro = '';
        }

        if ($tipocuenta === null){
            $tipocuenta = '';
        }

        $idopcion = $request['idopcion'];

        $cuentas = $this->generar_reporte($fechabilitacion, $tcventa, $tccompra, $codcentro, $tipocuenta, '');

        $funcion = $this;

        return View::make('reporte/administracion/ajax/alistareportecuentasaldo',
            [
                'cuentas' => $cuentas,
                'todos' => $tipocuenta,
                'idopcion' => $idopcion,
                'funcion' => $funcion,
                'ajax' => true
            ]);
    }



    public function actionAjaxListarReporteCuentasSaldoExcel(Request $request)
    {
        set_time_limit(0);

        $fechabilitacion = $request['endDate'];
        $tcventa = $request['tc_venta'];
        $tccompra = $request['tc_compra'];
        $codcentro = $request['centro'];
        $tipocuenta = $request['tipocontrato'];

        if ($codcentro === null){
            $codcentro = '';
        }

        if ($tipocuenta === null){
            $tipocuenta = '';
        }

        $cuentas = $this->generar_reporte($fechabilitacion, $tcventa, $tccompra, $codcentro, $tipocuenta, '');

        $funcion = $this;

        $titulo = 'Reporte-Cuentas-Saldo-' . Session::get('empresas')->NOM_EMPR;

        Excel::create($titulo, function ($excel) use ($cuentas, $funcion) {
            $excel->sheet('CxC Terceros', function ($sheet) use ($cuentas, $funcion) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  9
                    )
                ));
                $sheet->setColumnFormat(array(
                    'M:O' => '#,##0.00',
                    'D' => '#,##0.00',
                    'E' => NumberFormat::FORMAT_DATE_YYYYMMDD
                ));
                $sheet->loadView('reporte/administracion/excel/listacuentascobrarterceros')
                    ->with('funcion', $funcion)
                    ->with('cuentas', $cuentas);
            });
            $excel->sheet('CxC Relacionadas', function ($sheet) use ($cuentas, $funcion) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  9
                    )
                ));
                $sheet->setColumnFormat(array(
                    'M:O' => '#,##0.00',
                    'D' => '#,##0.00',
                    'E' => NumberFormat::FORMAT_DATE_YYYYMMDD
                ));
                $sheet->loadView('reporte/administracion/excel/listacuentascobrarrelacionadas')
                    ->with('funcion', $funcion)
                    ->with('cuentas', $cuentas);
            });
            $excel->sheet('CxP Terceros', function ($sheet) use ($cuentas, $funcion) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  9
                    )
                ));
                $sheet->setColumnFormat(array(
                    'M:O' => '#,##0.00',
                    'D' => '#,##0.00',
                    'E' => NumberFormat::FORMAT_DATE_YYYYMMDD
                ));
                $sheet->loadView('reporte/administracion/excel/listacuentaspagarterceros')
                    ->with('funcion', $funcion)
                    ->with('cuentas', $cuentas);
            });
            $excel->sheet('CxP Relacionadas', function ($sheet) use ($cuentas, $funcion) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  9
                    )
                ));
                $sheet->setColumnFormat(array(
                    'M:O' => '#,##0.00',
                    'D' => '#,##0.00',
                    'E' => NumberFormat::FORMAT_DATE_YYYYMMDD
                ));
                $sheet->loadView('reporte/administracion/excel/listacuentaspagarrelacionadas')
                    ->with('funcion', $funcion)
                    ->with('cuentas', $cuentas);
            });
            $excel->sheet('CxP Retenciones', function ($sheet) use ($cuentas, $funcion) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  9
                    )
                ));
                $sheet->setColumnFormat(array(
                    'M:O' => '#,##0.00',
                    'D' => '#,##0.00',
                    'E' => NumberFormat::FORMAT_DATE_YYYYMMDD
                ));
                $sheet->loadView('reporte/administracion/excel/listacuentaspagarrelacionadasretenciones')
                    ->with('funcion', $funcion)
                    ->with('cuentas', $cuentas);
            });
        })->export('xlsx');
    }
}
