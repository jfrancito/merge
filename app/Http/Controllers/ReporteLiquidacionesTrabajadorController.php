<?php

namespace App\Http\Controllers;

use App\Modelos\STDEmpresa;
use App\Traits\CuentaSaldosTraits;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use View;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReporteLiquidacionesTrabajadorController extends Controller
{
    use CuentaSaldosTraits;

    public function actionReporteLiquidacionesTrabajador($id_opcion)
    {
        return View::make('reporte/administracion/reporteliquidacionestrabajador',
            [
                'listaLiquidaciones' => array(),
                'idopcion' => $id_opcion,
            ]);
    }

    public function buscarTrabajadorLiquidaciones(Request $request)
    {
        $q = $request->get('busqueda', '');

        $data = STDEmpresa::where('COD_ESTADO', '=', 1)
            ->where('NOM_EMPR', 'like', "%{$q}%")
            ->select('COD_EMPR as id', 'NOM_EMPR as text')
            ->limit(50)
            ->get();

        // Agregar opción "Todos" al inicio
        $extra = collect([
            ['id' => '', 'text' => 'TODOS']
        ]);

        return $extra->merge($data);

    }

    public function actionAjaxListarReporteLiquidacionesTrabajador(Request $request)
    {
        $company = Session::get('empresas')->COD_EMPR;
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        $employee = $request['employee'];

        $idopcion = $request['idopcion'];

        $listaLiquidaciones = $this->generar_reporte_liquidaciones($startDate, $endDate, $employee, $company);

        $funcion = $this;

        return View::make('reporte/administracion/ajax/listaliquidacionestrabajador',
            [
                'listaLiquidaciones' => $listaLiquidaciones,
                'idopcion' => $idopcion,
                'funcion' => $funcion,
                'ajax' => true
            ]);
    }



    public function actionAjaxListarReporteLiquidacionesTrabajadorExcel(Request $request)
    {
        set_time_limit(0);

        $company = Session::get('empresas')->COD_EMPR;
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        $employee = $request['employee'];
        $funcion = $this;

        $listaLiquidaciones = $this->generar_reporte_liquidaciones($startDate, $endDate, $employee, $company);

        $titulo = 'REPORTE-LIQUIDACIONES-' . Session::get('empresas')->NOM_EMPR;

        Excel::create($titulo, function ($excel) use ($listaLiquidaciones, $funcion) {
            $excel->sheet('Reporte Caja', function ($sheet) use ($listaLiquidaciones, $funcion) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name' => 'Calibri',
                        'size' => 9
                    )
                ));
                $sheet->setAutoSize(true);
                $sheet->loadView('reporte/administracion/excel/listaliquidacionestrabajador')
                    ->with('funcion', $funcion)
                    ->with('listaLiquidaciones', $listaLiquidaciones);
            });
        })->export('xlsx');
    }
}
