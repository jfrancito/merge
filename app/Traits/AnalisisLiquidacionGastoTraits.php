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

        $totalGeneral = $query->sum('TOTAL_GENERAL');
        $totalDocumentos = $query->count();
        $ticketPromedio = $totalDocumentos > 0 ? ($totalGeneral / $totalDocumentos) : 0;

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

        $totalTrabajadores = (clone $query)->distinct()->count('ID_TRABAJADOR');
        $maxGasto = (clone $query)->max('TOTAL_GENERAL');

        return [
            'total_general' => $totalGeneral,
            'total_documentos' => $totalDocumentos,
            'ticket_promedio' => $ticketPromedio,
            'total_trabajadores' => $totalTrabajadores,
            'max_gasto' => $maxGasto,
            'por_moneda' => $porMoneda,
            'por_estado' => $porEstado,
            'evolucion_mensual' => $evolucionMensual,
            'por_tipo_documento' => $porTipoDocumento,
            'top_areas' => $topAreas,
            'top_proveedores' => $topProveedoresExec,
            'detalle' => $query->get()
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
            ->get();

        $porCentro = (clone $query)
            ->select('NOMBRE_CENTRO_TRABAJO', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('NOMBRE_CENTRO_TRABAJO')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'por_area' => $porArea,
            'por_centro' => $porCentro,
            'detalle' => $query->get()
        ];
    }

    public function getDashboardProveedores($request)
    {
        $query = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($query, $request);

        $topProveedores = (clone $query)
            ->select('NOMBRE_PROVEEDOR', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('NOMBRE_PROVEEDOR')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $evolucionProveedor = (clone $query)
            ->select('MES', 'ANIO', 'NOMBRE_PROVEEDOR', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('MES', 'ANIO', 'NOMBRE_PROVEEDOR')
            ->orderBy('ANIO', 'asc')
            ->orderBy('MES', 'asc')
            ->get();

        return [
            'top_proveedores' => $topProveedores,
            'evolucion_provider' => $evolucionProveedor,
            'detalle' => $query->get()
        ];
    }

    public function getDashboardResponsables($request)
    {
        $query = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($query, $request);

        $porSolicitante = (clone $query)
            ->select('NOMBRE_TRABAJADOR', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('NOMBRE_TRABAJADOR')
            ->orderBy('total', 'desc')
            ->get();

        $porAutorizador = (clone $query)
            ->select('NOMBRE_JEFE_AUTORIZA', DB::raw('SUM(TOTAL_GENERAL) as total'))
            ->groupBy('NOMBRE_JEFE_AUTORIZA')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'por_solicitante' => $porSolicitante,
            'por_autorizador' => $porAutorizador,
            'detalle' => $query->get()
        ];
    }

    public function getDashboardDetalle($request)
    {
        $query = VLiquidacionGastos_Analitica::query();
        $this->scopeFilterAnalitica($query, $request);

        return $query->orderBy('FECHA_EMISION', 'desc')->get();
    }
}