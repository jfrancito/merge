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
use App\Traits\AnalisisLiquidacionGastoTraits;


use PDF;
use Hashids;
use SplFileInfo;
use Excel;
use Carbon\Carbon;

class GestionAnalisisLiquidacionGastosController extends Controller
{
    use GeneralesTraits;
    use AnalisisLiquidacionGastoTraits;

    public function actionGestionAnalisisaLiquidacionCompra($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Anadir');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Análisis de Liquidación de Gastos');

        // Obtener listas de filtros directamente de la vista histórica para evitar errores de tablas inexistentes
        $lista_empresas = VLiquidacionGastos_Analitica::select('ID_EMPRESA', 'NOMBRE_EMPRESA')->distinct()->pluck('NOMBRE_EMPRESA', 'ID_EMPRESA')->all();
        $lista_monedas = VLiquidacionGastos_Analitica::select('MONEDA')->distinct()->pluck('MONEDA', 'MONEDA')->all();
        $lista_estados = VLiquidacionGastos_Analitica::select('ESTADO_LIQUIDACION')->distinct()->pluck('ESTADO_LIQUIDACION', 'ESTADO_LIQUIDACION')->all();
        $lista_centros = VLiquidacionGastos_Analitica::select('ID_CENTRO_TRABAJO', 'NOMBRE_CENTRO_TRABAJO')->distinct()->pluck('NOMBRE_CENTRO_TRABAJO', 'ID_CENTRO_TRABAJO')->all();
        $lista_areas = VLiquidacionGastos_Analitica::select('ID_AREA_TRABAJO', 'NOMBRE_AREA_TRABAJO')->distinct()->pluck('NOMBRE_AREA_TRABAJO', 'ID_AREA_TRABAJO')->all();

        $anios = VLiquidacionGastos_Analitica::select('ANIO')->distinct()->orderBy('ANIO', 'desc')->pluck('ANIO', 'ANIO')->all();
        $meses = [
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Junio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];

        return View::make(
            'analisisliquidaciongasto/analisiliquidaciongastos',
            [
                'idopcion' => $idopcion,
                'lista_empresas' => $lista_empresas,
                'lista_monedas' => $lista_monedas,
                'lista_estados' => $lista_estados,
                'lista_centros' => $lista_centros,
                'lista_areas' => $lista_areas,
                'anios' => $anios,
                'meses' => $meses,
            ]
        );
    }

    public function actionAjaxDashboards(Request $request)
    {
        $tipo = $request->input('tipo');
        $data = [];

        switch ($tipo) {
            case 'ejecutivo':
                $data = $this->getDashboardEjecutivo($request);
                break;
            case 'areacentro':
                $data = $this->getDashboardAreaCentro($request);
                break;
            case 'proveedores':
                $data = $this->getDashboardProveedores($request);
                break;
            case 'responsables':
                $data = $this->getDashboardResponsables($request);
                break;
            case 'productos':
                $data = $this->getDashboardProductos($request);
                break;
            case 'comparativos':
                $data = $this->getDashboardComparativos($request);
                break;
            case 'detalle':
                $data = $this->getDashboardDetalle($request);
                break;
        }

        return response()->json($data);
    }

    public function actionGetSampleData(Request $request)
    {
        $data = VLiquidacionGastos_Analitica::first();
        return response()->json($data);
    }

}
