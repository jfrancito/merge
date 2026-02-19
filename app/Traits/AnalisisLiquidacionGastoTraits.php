<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;

use App\Modelos\LqgDetDocumentoLiquidacionGasto;
use App\Modelos\LqgDetLiquidacionGasto;
use App\Modelos\LqgLiquidacionGasto;
use App\Modelos\VLiquidacionGastos_Analitica;

use App\User;

use ZipArchive;
use SplFileInfo;
use View;
use Session;
use Hashids;
use Nexmo;
use Keygen;
use SoapClient;
use Carbon\Carbon;
use PDO;
trait AnalisisLiquidacionGastoTraits
{
    public function scopeFilterAnalitica($query, $request)
    {
        $filters = [
            'ano' => 'ANIO',
            'mes' => 'MES',
            'empresa_id' => 'ID_EMPRESA',
            'moneda_id' => 'MONEDA',
            'estado_id' => 'ESTADO_LIQUIDACION',
            'centro_id' => 'ID_CENTRO_TRABAJO',
            'area_id' => 'ID_AREA_TRABAJO',
            'proveedor_id' => 'ID_PROVEEDOR',
            'trabajador_id' => 'ID_TRABAJADOR',
            'jefe_id' => 'ID_JEFE_AUTORIZA'
        ];

        foreach ($filters as $reqKey => $dbCol) {
            if ($request->has($reqKey) && $request->$reqKey != '') {
                $values = explode(',', $request->$reqKey);
                if (count($values) > 1) {
                    $query->whereIn($dbCol, $values);
                } else {
                    if ($values[0] === 'null') {
                        $query->whereRaw('1=0');
                    } else {
                        $query->where($dbCol, $values[0]);
                    }
                }
            }
        }

        if ($request->has('fecha_inicio') && $request->fecha_inicio != '') {
            $query->where('FECHA_EMISION', '>=', $request->fecha_inicio);
        }
        if ($request->has('fecha_fin') && $request->fecha_fin != '') {
            $query->where('FECHA_EMISION', '<=', $request->fecha_fin);
        }
        return $query;
    }

    public function getDashboardEjecutivo($request)
    {
        $query = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($query, $request);

        // Obtener totales en una sola query agregada
        $totales = (clone $query)->selectRaw('
            SUM(TOTAL_GENERAL) as total_general,
            COUNT(*) as total_documentos,
            MAX(TOTAL_GENERAL) as max_gasto,
            COUNT(DISTINCT ID_TRABAJADOR) as total_trabajadores
        ')->first();

        $totalGeneral = $totales->total_general ?? 0;
        $totalDocumentos = $totales->total_documentos ?? 0;
        $ticketPromedio = $totalDocumentos > 0 ? ($totalGeneral / $totalDocumentos) : 0;

        // Queries agrupadas (necesarias para charts)
        $porMoneda = (clone $query)
            ->select('MONEDA', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('MONEDA')
            ->get();

        $porEstado = (clone $query)
            ->select('ESTADO_LIQUIDACION', DB::raw('COUNT(*) as cantidad'), DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('ESTADO_LIQUIDACION')
            ->get();

        $evolucionMensual = (clone $query)
            ->select('MES', 'ANIO', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('MES', 'ANIO')
            ->orderBy('ANIO', 'asc')
            ->orderBy('MES', 'asc')
            ->get();

        $porTipoDocumento = (clone $query)
            ->select('TIPO_DOCUMENTO', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('TIPO_DOCUMENTO')
            ->orderBy('cantidad', 'desc')
            ->limit(10)
            ->get();

        $topAreas = (clone $query)
            ->select('NOMBRE_AREA_TRABAJO', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('NOMBRE_AREA_TRABAJO')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $topProveedoresExec = (clone $query)
            ->select('NOMBRE_PROVEEDOR', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('NOMBRE_PROVEEDOR')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return [
            'total_general' => $totalGeneral,
            'total_documentos' => $totalDocumentos,
            'ticket_promedio' => $ticketPromedio,
            'total_trabajadores' => $totales->total_trabajadores ?? 0,
            'max_gasto' => $totales->max_gasto ?? 0,
            'por_moneda' => $porMoneda,
            'por_estado' => $porEstado,
            'evolucion_mensual' => $evolucionMensual,
            'por_tipo_documento' => $porTipoDocumento,
            'top_areas' => $topAreas,
            'top_proveedores' => $topProveedoresExec,
            'detalle' => [] // Eliminado para mejorar rendimiento - usar tab Detalle si se necesita
        ];
    }

    public function getDashboardAreaCentro($request)
    {
        $query = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($query, $request);

        $porArea = (clone $query)
            ->select('NOMBRE_AREA_TRABAJO', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('NOMBRE_AREA_TRABAJO')
            ->orderBy('total', 'desc')
            ->limit(15)
            ->get();

        $porCentro = (clone $query)
            ->select('NOMBRE_CENTRO_TRABAJO', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('NOMBRE_CENTRO_TRABAJO')
            ->orderBy('total', 'desc')
            ->limit(15)
            ->get();

        return [
            'por_area' => $porArea,
            'por_centro' => $porCentro,
            'detalle' => []
        ];
    }

    public function getDashboardProveedores($request)
    {
        $query = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($query, $request);

        $topProveedores = (clone $query)
            ->select('NOMBRE_PROVEEDOR', DB::raw('SUM(TOTAL_GENERAL) as total'), DB::raw('COUNT(*) as cantidad'))
            ->groupBy('NOMBRE_PROVEEDOR')
            ->orderBy('total', 'desc')
            ->limit(15)
            ->get();

        // Evolución solo del top 5 proveedores para rendimiento
        $top5Names = $topProveedores->take(5)->pluck('NOMBRE_PROVEEDOR')->toArray();
        $evolucionProveedor = (clone $query)
            ->select('MES', 'ANIO', 'NOMBRE_PROVEEDOR', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->whereIn('NOMBRE_PROVEEDOR', $top5Names)
            ->groupBy('MES', 'ANIO', 'NOMBRE_PROVEEDOR')
            ->orderBy('ANIO', 'asc')
            ->orderBy('MES', 'asc')
            ->get();

        return [
            'top_proveedores' => $topProveedores,
            'evolucion_provider' => $evolucionProveedor,
            'detalle' => []
        ];
    }

    public function getDashboardResponsables($request)
    {
        $query = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($query, $request);

        $porSolicitante = (clone $query)
            ->select('NOMBRE_TRABAJADOR', DB::raw('SUM(TOTAL_GENERAL) as total'), DB::raw('COUNT(*) as cantidad'))
            ->groupBy('NOMBRE_TRABAJADOR')
            ->orderBy('total', 'desc')
            ->limit(15)
            ->get();

        $porAutorizador = (clone $query)
            ->select('NOMBRE_JEFE_AUTORIZA', DB::raw('SUM(TOTAL_GENERAL) as total'), DB::raw('COUNT(*) as cantidad'))
            ->groupBy('NOMBRE_JEFE_AUTORIZA')
            ->orderBy('total', 'desc')
            ->limit(15)
            ->get();

        return [
            'por_solicitante' => $porSolicitante,
            'por_autorizador' => $porAutorizador,
            'detalle' => []
        ];
    }

    public function getDashboardProductos($request)
    {
        $query = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($query, $request);

        $topProductos = (clone $query)
            ->select('NOMBRE_PRODUCTO', DB::raw('SUM(TOTAL_GENERAL) as total'), DB::raw('COUNT(*) as cantidad'))
            ->groupBy('NOMBRE_PRODUCTO')
            ->orderBy('total', 'desc')
            ->limit(15)
            ->get();

        // Evolución solo del top 5 productos para rendimiento
        $top5Names = $topProductos->take(5)->pluck('NOMBRE_PRODUCTO')->toArray();
        $evolucionProducto = (clone $query)
            ->select('MES', 'ANIO', 'NOMBRE_PRODUCTO', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->whereIn('NOMBRE_PRODUCTO', $top5Names)
            ->groupBy('MES', 'ANIO', 'NOMBRE_PRODUCTO')
            ->orderBy('ANIO', 'asc')
            ->orderBy('MES', 'asc')
            ->get();

        return [
            'top_productos' => $topProductos,
            'evolucion_producto' => $evolucionProducto,
            'detalle' => []
        ];
    }

    public function getDashboardComparativos($request)
    {
        // 1. Current Query
        $queryActual = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($queryActual, $request);

        // 2. Logic for Previous Period
        $requestPrev = clone $request;
        $tipoComparacion = $request->get('comparar_vs', 'anterior');

        $anios = explode(',', $request->ano);
        $meses = array_filter(explode(',', $request->mes));

        if ($tipoComparacion == 'anio_pasado') {
            $requestPrev->ano = (string) ((int) $request->ano - 1);
        } else {
            if (count($meses) == 1) {
                $m = (int) $meses[0];
                $y = (int) $anios[0];
                if ($m == 1) {
                    $requestPrev->mes = '12';
                    $requestPrev->ano = (string) ($y - 1);
                } else {
                    $requestPrev->mes = (string) ($m - 1);
                    $requestPrev->ano = (string) $y;
                }
            } elseif (count($meses) == 3) {
                $firstMonth = (int) min($meses);
                $y = (int) $anios[0];
                if ($firstMonth == 1) {
                    $requestPrev->mes = '10,11,12';
                    $requestPrev->ano = (string) ($y - 1);
                } else {
                    $start = $firstMonth - 3;
                    $requestPrev->mes = $start . ',' . ($start + 1) . ',' . ($start + 2);
                }
            } else {
                $requestPrev->ano = (string) ((int) $request->ano - 1);
            }
        }

        $queryPrev = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($queryPrev, $requestPrev);

        // KPI Calculations - una sola query para ambos
        $gastoActual = (clone $queryActual)->sum('TOTAL_GENERAL');
        $gastoPrev = (clone $queryPrev)->sum('TOTAL_GENERAL');
        $variacionAbs = $gastoActual - $gastoPrev;
        $variacionPct = $gastoPrev > 0 ? ($variacionAbs / $gastoPrev) * 100 : ($gastoActual > 0 ? 100 : 0);

        // Solo comparar las categorías principales
        return [
            'kpis' => [
                'actual' => $gastoActual,
                'anterior' => $gastoPrev,
                'variacion_abs' => $variacionAbs,
                'variacion_pct' => $variacionPct,
                'label_actual' => $this->getPeriodLabel($request),
                'label_prev' => $this->getPeriodLabel($requestPrev),
            ],
            'comparativo_area' => $this->compareByCategory($queryActual, $queryPrev, 'NOMBRE_AREA_TRABAJO'),
            'comparativo_proveedor' => $this->compareByCategory($queryActual, $queryPrev, 'NOMBRE_PROVEEDOR'),
            'comparativo_centro' => $this->compareByCategory($queryActual, $queryPrev, 'NOMBRE_CENTRO_TRABAJO'),
            'comparativo_responsable' => $this->compareByCategory($queryActual, $queryPrev, 'NOMBRE_TRABAJADOR'),
            'comparativo_producto' => $this->compareByCategory($queryActual, $queryPrev, 'NOMBRE_PRODUCTO'),
            'evolucion_mensual' => (clone $queryActual)
                ->select('MES', 'ANIO', DB::raw('SUM(TOTAL_GENERAL) as total'))
                ->groupBy('MES', 'ANIO')
                ->orderBy('ANIO', 'asc')
                ->orderBy('MES', 'asc')
                ->get()
        ];
    }

    private function compareByCategory($qActual, $qPrev, $column)
    {
        $actual = (clone $qActual)
            ->select($column, DB::raw('SUM(TOTAL_GENERAL) as total'), DB::raw('COUNT(*) as cantidad'))
            ->groupBy($column)
            ->get()
            ->keyBy($column);

        $prev = (clone $qPrev)
            ->select($column, DB::raw('SUM(TOTAL_GENERAL) as total'), DB::raw('COUNT(*) as cantidad'))
            ->groupBy($column)
            ->get()
            ->keyBy($column);

        $merged = [];
        $allKeys = $actual->keys()->merge($prev->keys())->unique();

        foreach ($allKeys as $key) {
            if (!$key)
                continue;

            $valActual = isset($actual[$key]) ? $actual[$key]->total : 0;
            $cantActual = isset($actual[$key]) ? $actual[$key]->cantidad : 0;
            $valPrev = isset($prev[$key]) ? $prev[$key]->total : 0;
            $cantPrev = isset($prev[$key]) ? $prev[$key]->cantidad : 0;

            $diff = $valActual - $valPrev;
            $pct = $valPrev > 0 ? ($diff / $valPrev) * 100 : ($valActual > 0 ? 100 : 0);

            $ticketActual = $cantActual > 0 ? ($valActual / $cantActual) : 0;
            $ticketPrev = $cantPrev > 0 ? ($valPrev / $cantPrev) : 0;
            $ticketDiff = $ticketActual - $ticketPrev;
            $ticketPct = $ticketPrev > 0 ? ($ticketDiff / $ticketPrev) * 100 : ($ticketActual > 0 ? 100 : 0);

            $merged[] = [
                'categoria' => $key,
                'actual' => $valActual,
                'anterior' => $valPrev,
                'cantidad_actual' => $cantActual,
                'cantidad_anterior' => $cantPrev,
                'ticket_actual' => $ticketActual,
                'ticket_anterior' => $ticketPrev,
                'ticket_variacion_pct' => $ticketPct,
                'variacion_abs' => $diff,
                'variacion_pct' => $pct
            ];
        }

        usort($merged, function ($a, $b) {
            $valA = abs($a['variacion_abs']);
            $valB = abs($b['variacion_abs']);
            if ($valA == $valB)
                return 0;
            return ($valB > $valA) ? 1 : -1;
        });

        return $merged;
    }

    private function getPeriodLabel($request)
    {
        $anios = explode(',', $request->ano);
        $mesesStr = isset($request->mes) ? $request->mes : '';
        $meses = array_filter(explode(',', $mesesStr));
        $mesesNombres = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];

        if (count($meses) == 1) {
            return $mesesNombres[(int) $meses[0]] . ' ' . $anios[0];
        } elseif (count($meses) > 1 && count($meses) < 12) {
            $min = (int) min($meses);
            $max = (int) max($meses);
            return $mesesNombres[$min] . '-' . $mesesNombres[$max] . ' ' . $anios[0];
        } elseif (count($meses) == 12 || count($meses) == 0) {
            return 'Año ' . $anios[0];
        }

        return count($anios) == 1 ? $anios[0] : 'Periodo';
    }

    public function getDashboardDetalle($request)
    {
        $query = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($query, $request);

        return $query->orderBy('FECHA_EMISION', 'desc')->get();
    }
}