<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use Carbon\Carbon;
use Session;
use View;

class AsociarCotOrdenCompraController extends Controller
{
    public function actionAsociarCotOrdenCompra($idopcion)
    {
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Asociar Cotización y Orden de Compra');

        $empresa_sesion = Session::get('empresas');
        $cod_empr = $empresa_sesion ? (isset($empresa_sesion->COD_EMPR) ? $empresa_sesion->COD_EMPR : $empresa_sesion->COD_EMR) : '';
        $nom_empr = $empresa_sesion ? $empresa_sesion->NOM_EMPR : 'EMPRESA ACTUAL';

        $combo_empresa = [
            $cod_empr => $nom_empr
        ];

        // Obtener centros activos
        $array_centros = ALMCentro::where('COD_ESTADO', 1)
            ->pluck('NOM_CENTRO', 'COD_CENTRO')
            ->toArray();

        $combo_centro = ['' => 'TODOS LOS CENTROS'] + $array_centros;

        // Fechas por defecto: inicio de mes y fecha actual
        $fecha_inicio = Carbon::now()->startOfMonth()->format('d-m-Y');
        $fecha_fin = Carbon::now()->format('d-m-Y');

        return view('compras.asociarcotizacion.index', [
            'idopcion' => $idopcion,
            'combo_empresa' => $combo_empresa,
            'cod_empr' => $cod_empr,
            'nom_empr' => $nom_empr,
            'combo_centro' => $combo_centro,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
        ]);
    }

    public function actionAjaxBuscarCotizacionesSinOC(Request $request)
    {
        try {
            $fecha_inicio_raw = $request->input('fecha_inicio');
            $fecha_fin_raw = $request->input('fecha_fin');
            $cod_centro = $request->input('cod_centro', '');

            $empresa_sesion = Session::get('empresas');
            $cod_empr = $empresa_sesion ? (isset($empresa_sesion->COD_EMPR) ? $empresa_sesion->COD_EMPR : $empresa_sesion->COD_EMR) : '';

            $fec_inicio = Carbon::createFromFormat('d-m-Y', $fecha_inicio_raw)->format('Y-m-d');
            $fec_fin = Carbon::createFromFormat('d-m-Y', $fecha_fin_raw)->format('Y-m-d');

            // Llamada al Stored Procedure [WEB].[COTIZACIONES_SIN_ORDEN_COMPRA]
            $listacotizaciones = DB::select(
                "EXEC [WEB].[COTIZACIONES_SIN_ORDEN_COMPRA] ?, ?, ?, ?",
                [$fec_inicio, $fec_fin, $cod_empr, $cod_centro]
            );

            return view('compras.asociarcotizacion.ajax.listacotizaciones', [
                'listacotizaciones' => $listacotizaciones
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al procesar la búsqueda: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actionAjaxModalAsociarOC(Request $request)
    {
        try {
            $id_cotizacion = trim($request->input('id_cotizacion'));

            // Obtener la cotización
            $cotizacion = DB::table('WEB.ORDEN_COTIZACION')
                ->where('ID_COTIZACION', $id_cotizacion)
                ->first();

            if (!$cotizacion) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'No se encontró la cotización especificada.'
                ], 404);
            }

            $cod_empr = trim($cotizacion->COD_EMPR);
            $cod_centro = trim($cotizacion->COD_CENTRO);

            // Consultar órdenes de compra coincidentes con la empresa y centro de la cotización
            $lista_ordenes = DB::select("
                SELECT DISTINCT
                    OCT.ID_COTIZACION,
                    O.COD_EMPR,
                    O.COD_CENTRO,
                    O.COD_ORDEN,
                    O.FEC_ORDEN,
                    D.COD_PRODUCTO,
                    D.TXT_NOMBRE_PRODUCTO AS PRODUCTO_ORDEN
                FROM WEB.ORDEN_COTIZACION OCT
                INNER JOIN WEB.ORDEN_COTIZACION_DETALLE OCD
                    ON OCD.ID_COTIZACION = OCT.ID_COTIZACION
                   AND OCD.ACTIVO = 1
                INNER JOIN CMP.DETALLE_PRODUCTO D
                    ON D.COD_PRODUCTO = OCD.COD_PRODUCTO
                INNER JOIN CMP.ORDEN O
                    ON O.COD_ORDEN = D.COD_TABLA
                   AND O.COD_CATEGORIA_TIPO_ORDEN = 'TOR0000000000001'
                   AND O.COD_EMPR = OCT.COD_EMPR
                   AND O.COD_CENTRO = OCT.COD_CENTRO
                WHERE OCT.ID_COTIZACION = ?
                  AND OCT.COD_ESTADO = 'ETM0000000000005'
                  AND OCT.ACTIVO = 1
                  AND O.FEC_ORDEN >= '2026-11-01'
                  AND NOT EXISTS (
                        SELECT 1
                        FROM CMP.REFERENCIA_ASOC RA
                        WHERE RA.COD_TABLA = OCT.ID_COTIZACION
                  )                       
                ORDER BY O.FEC_ORDEN DESC
            ", [$id_cotizacion]);

            return view('compras.asociarcotizacion.ajax.modalasociaroc', [
                'cotizacion' => $cotizacion,
                'lista_ordenes' => $lista_ordenes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al cargar el modal de asociación: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actionAjaxGuardarAsociacionCotOC(Request $request)
    {
        try {
            $id_cotizacion = trim($request->input('id_cotizacion'));
            $cod_orden = trim($request->input('cod_orden'));

            if (empty($id_cotizacion) || empty($cod_orden)) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'Parámetros incompletos para asociar la cotización con la orden de compra.'
                ], 422);
            }

            // Validar que la cotización existe y sigue activa
            $cotizacion = DB::table('WEB.ORDEN_COTIZACION')
                ->where('ID_COTIZACION', $id_cotizacion)
                ->first();

            if (!$cotizacion) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'La cotización especificada no existe.'
                ], 404);
            }

            // VALIDACIÓN DE COINCIDENCIA DE PRODUCTOS:
            // Obtener los códigos de producto de la cotización
            $prods_cotizacion = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
                ->where('ID_COTIZACION', $id_cotizacion)
                ->where('ACTIVO', 1)
                ->pluck('COD_PRODUCTO')
                ->map(function ($item) {
                    return trim($item);
                })
                ->toArray();

            // Obtener los códigos de producto de la orden de compra
            $prods_orden = DB::table('CMP.DETALLE_PRODUCTO')
                ->where('COD_TABLA', $cod_orden)
                ->pluck('COD_PRODUCTO')
                ->map(function ($item) {
                    return trim($item);
                })
                ->toArray();

            if (empty($prods_cotizacion) || empty($prods_orden)) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'No se encontraron productos en la cotización o en la orden de compra para validar.'
                ], 422);
            }

            // Verificar coincidencia de productos
            $coincidencias = array_intersect($prods_cotizacion, $prods_orden);
            if (empty($coincidencias)) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'No se puede asociar: el código de producto de la cotización no coincide con el de la orden de compra seleccionada.'
                ], 422);
            }

            // Validar si ya está asociada
            $existe = DB::table('CMP.REFERENCIA_ASOC')
                ->where('COD_TABLA', $id_cotizacion)
                ->where('COD_TABLA_ASOC', $cod_orden)
                ->exists();

            $usuario_id = Session::has('usuario') ? Session::get('usuario')->id : 'SYSTEM';
            $fecha_crea = date('Y-m-d\TH:i:s');

            if (!$existe) {
                DB::table('CMP.REFERENCIA_ASOC')->insert([
                    'COD_TABLA'            => $id_cotizacion,
                    'COD_TABLA_ASOC'       => $cod_orden,
                    'TXT_TABLA'            => 'WEB.ORDEN_COTIZACION',
                    'TXT_TABLA_ASOC'       => 'CMP.ORDEN',
                    'TXT_DESCRIPCION'      => '',
                    'TXT_GLOSA'            => '',
                    'CAN_AUX1'             => 0,
                    'CAN_AUX2'             => 0,
                    'CAN_AUX3'             => 0,
                    'TXT_TIPO_REFERENCIA'  => '',
                    'TXT_REFERENCIA'       => '',
                    'COD_USUARIO_CREA_AUD' => $usuario_id,
                    'FEC_USUARIO_CREA_AUD' => $fecha_crea,
                    'COD_ESTADO'           => 1
                ]);

                // Réplica a servidor de zona si corresponde
                $cod_centro = trim($cotizacion->COD_CENTRO);
                $conexionbd = 'sqlsrv';
                if ($cod_centro == 'CEN0000000000004') {
                    $conexionbd = 'sqlsrv_r';
                } elseif ($cod_centro == 'CEN0000000000006') {
                    $conexionbd = 'sqlsrv_b';
                }

                if ($conexionbd !== 'sqlsrv') {
                    try {
                        $existe_zona = DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')
                            ->where('COD_TABLA', $id_cotizacion)
                            ->where('COD_TABLA_ASOC', $cod_orden)
                            ->exists();

                        if (!$existe_zona) {
                            DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->insert([
                                'COD_TABLA'            => $id_cotizacion,
                                'COD_TABLA_ASOC'       => $cod_orden,
                                'TXT_TABLA'            => 'WEB.ORDEN_COTIZACION',
                                'TXT_TABLA_ASOC'       => 'CMP.ORDEN',
                                'TXT_DESCRIPCION'      => '',
                                'TXT_GLOSA'            => '',
                                'CAN_AUX1'             => 0,
                                'CAN_AUX2'             => 0,
                                'CAN_AUX3'             => 0,
                                'TXT_TIPO_REFERENCIA'  => '',
                                'TXT_REFERENCIA'       => '',
                                'COD_USUARIO_CREA_AUD' => $usuario_id,
                                'FEC_USUARIO_CREA_AUD' => $fecha_crea,
                                'COD_ESTADO'           => 1
                            ]);
                        }
                    } catch (\Exception $ez) {
                        \Log::error('Error al replicar CMP.REFERENCIA_ASOC a ' . $conexionbd . ': ' . $ez->getMessage());
                    }
                }
            }

            return response()->json([
                'error' => false,
                'mensaje' => '¡Cotización ' . $id_cotizacion . ' asociada exitosamente con la Orden de Compra ' . $cod_orden . '!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Error al guardar la asociación: ' . $e->getMessage()
            ], 500);
        }
    }
}
