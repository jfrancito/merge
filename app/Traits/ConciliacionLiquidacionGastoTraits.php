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
trait ConciliacionLiquidacionGastoTraits
{
    /**
     * Obtener lista de trabajadores agrupados (sin duplicados)
     * desde el procedimiento almacenado WEB_ObtenerLiquidacionesConVales
     * 
     * @param string $codEmpresa Código de la empresa
     * @return array Lista de trabajadores únicos
     */
    public function obtenerTrabajadoresAgrupados($codEmpresa)
    {
        try {
            // Si el código de empresa que llegó es nulo, intentamos obtenerlo de nuevo
            if (!$codEmpresa) {
                $empresas = Session::get('empresas');
                $codEmpresa = isset($empresas->COD_EMPR) ? $empresas->COD_EMPR : (isset($empresas->COD_EMP) ? $empresas->COD_EMP : null);
            }

            if (!$codEmpresa) {
                \Log::warning('No se pudo determinar el código de empresa para obtener trabajadores.');
                return [];
            }

            $resultados = DB::select("SET NOCOUNT ON; EXEC WEB_ObtenerLiquidacionesConVales @COD_EMPRESA = ?", [$codEmpresa]);

            if (empty($resultados)) {
                return [];
            }

            // Convertir a colección para manipular
            $coleccion = collect($resultados);

            // Intentar obtener el campo TXT_EMPRESA_TRABAJADOR (probando variaciones de nombre)
            $primerRegistro = (array) $coleccion->first();
            $campoTrabajador = 'TXT_EMPRESA_TRABAJADOR';

            // Si no existe exactamente así, buscarlo sin importar mayúsculas
            if (!isset($primerRegistro[$campoTrabajador])) {
                foreach ($primerRegistro as $key => $value) {
                    if (strtoupper($key) === 'TXT_EMPRESA_TRABAJADOR') {
                        $campoTrabajador = $key;
                        break;
                    }
                }
            }

            $trabajadoresUnicos = $coleccion
                ->unique('COD_EMPRESA_TRABAJADOR')
                ->sortBy('TXT_EMPRESA_TRABAJADOR')
                ->values()
                ->toArray();

            return $trabajadoresUnicos;
        } catch (\Exception $e) {

            \Log::error('Error al obtener trabajadores: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener datos completos de liquidaciones con vales
     * con filtro opcional por trabajador y fechas
     * 
     * @param string $codEmpresa Código de la empresa
     * @param string|null $trabajador Filtro por trabajador
     * @param string|null $fechaInicio Fecha inicio del filtro
     * @param string|null $fechaFin Fecha fin del filtro
     * @return array Datos de liquidaciones
     */
    public function obtenerLiquidacionesConVales($codEmpresa, $trabajador = null, $fechaInicio = null, $fechaFin = null)
    {
        try {
            // Parámetros solicitados por el usuario
            // Session: COD_COD_EMPR (según indicación del usuario)
            $emprSession = Session::get('empresas');
            $codEmprSession = isset($emprSession->COD_EMPR) ? $emprSession->COD_EMPR : (isset($emprSession->COD_COD_EMPR) ? $emprSession->COD_COD_EMPR : $codEmpresa);

            // Si el trabajador es "todos", mandamos vacío al procedimiento
            $codTrabajador = ($trabajador === 'todos') ? '' : $trabajador;

            $fInicio = isset($fechaInicio) ? $fechaInicio : '';
            $fFin = isset($fechaFin) ? $fechaFin : '';
            $cTrab = isset($codTrabajador) ? $codTrabajador : '';

            $resultados = DB::select("SET NOCOUNT ON; EXEC WEB_ObtenerLiquidacionesConVales 
                @TIPO_CONSULTA = 'CONSULTA',
                @FECHA_DESDE = ?,
                @FECHA_HASTA = ?,
                @COD_EMPRESA_TRABAJADOR = ?,
                @COD_EMPRESA = ?", [
                $fInicio,
                $fFin,
                $cTrab,
                $codEmprSession
            ]);

            if (empty($resultados)) {
                return ['success' => true, 'data' => [], 'destinos' => [], 'trabajadores' => []];
            }

            $coleccion = collect($resultados);

            // 1. Obtener lista única de destinos de vales (Columnas dinámicas)
            $destinos = $coleccion->pluck('DESTINO')->unique()->filter()->values()->toArray();

            // 2. Obtener nombres de trabajadores presentes
            $nombresTrabajadores = $coleccion->pluck('TXT_EMPRESA_TRABAJADOR')->unique()->filter()->values()->toArray();

            // 3. Agrupar por Concepto (TXT_PRODUCTO_VALE)
            $reporte = [];
            $agrupado = $coleccion->groupBy('TXT_PRODUCTO_VALE');

            foreach ($agrupado as $concepto => $items) {
                $gasto = $items->first()->TOTAL ?? 0;
                $vales = [];
                $totalValesFila = 0;

                // Mapear cada destino a su monto total_vale
                foreach ($destinos as $des) {
                    $montoVale = $items->where('DESTINO', $des)->sum('TOTAL_VALE');
                    $vales[$des] = $montoVale;
                    $totalValesFila += $montoVale;
                }

                $reporte[] = [
                    'concepto' => $concepto,
                    'gasto' => (float) $gasto,
                    'vales' => $vales,
                    'total_vales' => (float) $totalValesFila,
                    'exceso' => (float) ($totalValesFila - $gasto)
                ];
            }

            return [
                'success' => true,
                'data' => $reporte,
                'destinos' => $destinos,
                'trabajadores' => $nombresTrabajadores
            ];

        } catch (\Exception $e) {
            \Log::error('Error al obtener liquidaciones: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Obtiene los resultados detallados (planos) para la exportación a Excel
     */
    public function obtenerLiquidacionesDetalle($codEmpresa, $codTrabajador = null, $fechaDesde = null, $fechaHasta = null)
    {
        // Si el trabajador es "todos", mandamos vacío al procedimiento
        $codTrabajador = ($codTrabajador === 'todos' || $codTrabajador === '') ? '' : $codTrabajador;

        $fDesde = isset($fechaDesde) ? $fechaDesde : '';
        $fFin = isset($fechaHasta) ? $fechaHasta : ''; // Corrected variable name from $fechaFin to $fechaHasta
        $cTrab = isset($codTrabajador) ? $codTrabajador : '';

        return DB::select("SET NOCOUNT ON; EXEC WEB_ObtenerLiquidacionesConVales 
            @TIPO_CONSULTA = 'CONSULTA', 
            @FECHA_DESDE = ?, 
            @FECHA_HASTA = ?, 
            @COD_EMPRESA_TRABAJADOR = ?, 
            @COD_EMPRESA = ?",
            [$fDesde, $fFin, $cTrab, $codEmpresa]
        );
    }
}