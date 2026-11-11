<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\LqgLiquidacionGasto;
use App\Modelos\LqgDocumentoHistorial;
use App\Modelos\LqgDetLiquidacionGasto;
use App\Modelos\LqgDetDocumentoLiquidacionGasto;
use App\Modelos\VLiquidacionGastos_Analitica;


use Greenter\Parser\DocumentParserInterface;
use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;
use Greenter\Xml\Parser\PerceptionParser;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use App\Traits\GeneralesTraits;
use App\Traits\ConciliacionLiquidacionGastoTraits;


use PDF;
use Hashids;
use SplFileInfo;
use Excel;
use Carbon\Carbon;

class GestionConciliacionLiquidacionGastosController extends Controller
{
    use GeneralesTraits;
    use ConciliacionLiquidacionGastoTraits;


    public function actionGestionConciliacionLiquidacionCompra($idopcion, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Anadir');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/

        // Obtener código de empresa de la sesión (probando ambas variantes comunes)
        $empresas = Session::get('empresas');
        $codEmpresa = $empresas->COD_EMPR ?? $empresas->COD_EMP ?? null;

        // Obtener lista de trabajadores agrupados (sin duplicados)
        $trabajadores = $this->obtenerTrabajadoresAgrupados($codEmpresa);

        View::share('titulo', 'Conciliación de Liquidación de Gastos y Vales');
        return View::make(
            'reporte/coinciliacionliquidacionvale/coinciliacionliquidacionvale',
            [
                'idopcion' => $idopcion,
                'trabajadores' => $trabajadores,
            ]
        );
    }

    /**
     * Endpoint AJAX para buscar datos del reporte con filtros
     */
    public function buscarReporteConciliacion(Request $request)
    {
        $codEmpresa = Session::get('empresas')->COD_EMPR;
        $trabajador = $request->get('trabajador');
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        $res = $this->obtenerLiquidacionesConVales($codEmpresa, $trabajador, $fechaInicio, $fechaFin);

        return response()->json($res);
    }

    public function exportarExcelDetalle(Request $request)
    {
        set_time_limit(0);
        $codEmpresa = Session::get('empresas')->COD_EMPR;
        $trabajador = $request->get('trabajador');
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        $listaDetalle = $this->obtenerLiquidacionesDetalle($codEmpresa, $trabajador, $fechaInicio, $fechaFin);

        $titulo = 'DETALLE-CONCILIACION-' . date('YmdHis');

        Excel::create($titulo, function ($excel) use ($listaDetalle) {
            $excel->sheet('Detalle', function ($sheet) use ($listaDetalle) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name' => 'Calibri',
                        'size' => 10
                    )
                ));
                $sheet->setAutoSize(true);
                $sheet->loadView('reporte/coinciliacionliquidacionvale/excel/detalleliquidacion')
                    ->with('listaDetalle', $listaDetalle);
            });
        })->export('xlsx');
    }
}
