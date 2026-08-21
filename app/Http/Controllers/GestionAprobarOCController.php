<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use App\Modelos\CMPOrden;
use App\Modelos\CMPDetalleProducto;
use Carbon\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;


class GestionAprobarOCController extends Controller
{
    public function actionAporbarOc($idopcion)
    {
        $empresas = STDEmpresa::where('COD_ESTADO', '=', '1')
            ->where('IND_SISTEMA', '=', '1')
            ->pluck('NOM_EMPR', 'COD_EMPR')
            ->toArray();

        $empresaSesion = Session::get('empresas');
        $default_empresa_id = $empresaSesion ? $empresaSesion->COD_EMPR : '';

        $combo_centro = [
            'TODO' => 'TODO',
            'CEN0000000000001' => 'CHICLAYO',
            'CEN0000000000002' => 'LIMA',
            'CEN0000000000004' => 'RIOJA',
            'CEN0000000000006' => 'BELLAVISTA',
        ];

        $combo_tipo_compra = [
            'TODO' => 'TODO',
            'M' => 'MATERIAL',
            'S' => 'SERVICIO',
        ];

        $combo_moneda = [
            'TODO' => 'TODO',
            'MON0000000000001' => 'SOLES',
            'MON0000000000002' => 'DOLARES',
        ];

        $fecha_inicio = Carbon::now()->startOfMonth()->format('d-m-Y');
        $fecha_fin = Carbon::now()->format('d-m-Y');

        return view('compras.ajax.ordencompras', [
            'idopcion' => $idopcion,
            'empresas' => $empresas,
            'default_empresa_id' => $default_empresa_id,
            'combo_centro' => $combo_centro,
            'combo_tipo_compra' => $combo_tipo_compra,
            'combo_moneda' => $combo_moneda,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'titulo' => 'Aprobar Orden de Compra',
        ]);
    }

    public function actionAjaxListarOrdenCompras(Request $request)
    {
        try {
            $empresa_id = $request->get('empresa_id');
            $centro_id = $request->get('centro_id');
            $tipo_compra = $request->get('tipo_compra');
            $moneda_id = $request->get('moneda_id');
            $idopcion = $request->get('idopcion');

            $f_inicio = Carbon::createFromFormat('d-m-Y', $request->get('fecha_inicio'))->format('Y-m-d');
            $f_fin = Carbon::createFromFormat('d-m-Y', $request->get('fecha_fin'))->format('Y-m-d');

            $usuario = Session::get('usuario');

            $listaordenes = CMPOrden::leftJoin('ALM.CENTRO', 'ALM.CENTRO.COD_CENTRO', '=', 'CMP.ORDEN.COD_CENTRO')
                ->leftJoin('STD.TRABAJADOR', 'STD.TRABAJADOR.COD_TRAB', '=', 'CMP.ORDEN.COD_TRABAJADOR_ENCARGADO')
                ->where('CMP.ORDEN.COD_CATEGORIA_TIPO_ORDEN', '=', 'TOR0000000000001')
                ->where('CMP.ORDEN.COD_CATEGORIA_ESTADO_ORDEN', '=', 'EOR0000000000001')
                ->whereBetween('CMP.ORDEN.FEC_ORDEN', [$f_inicio, $f_fin])
                ->where(function($q) use ($empresa_id) {
                    if ($empresa_id) {
                        $q->where('CMP.ORDEN.COD_EMPR', '=', $empresa_id);
                    }
                })
                ->where(function($q) use ($centro_id) {
                    if ($centro_id && $centro_id !== 'TODO') {
                        $q->where('CMP.ORDEN.COD_CENTRO', '=', $centro_id);
                    }
                })
                ->where(function($q) use ($tipo_compra) {
                    if ($tipo_compra && $tipo_compra !== 'TODO') {
                        $q->where('CMP.ORDEN.IND_MATERIAL_SERVICIO', '=', $tipo_compra);
                    }
                })
                ->where(function($q) use ($moneda_id) {
                    if ($moneda_id && $moneda_id !== 'TODO') {
                        $q->where('CMP.ORDEN.COD_CATEGORIA_MONEDA', '=', $moneda_id);
                    }
                })
                ->where(function($q) use ($usuario) {
                    if ($usuario && $usuario->id !== '1CIX00000001') {
                        $nombre_usuario = trim($usuario->nombre);
                        if ($nombre_usuario !== '') {
                            $q->where(function($subq) use ($nombre_usuario) {
                                $subq->where('STD.TRABAJADOR.TXT_NOMBRES', 'like', '%' . $nombre_usuario . '%')
                                     ->orWhere(DB::raw("STD.TRABAJADOR.TXT_NOMBRES + ' ' + STD.TRABAJADOR.TXT_APE_PATERNO + ' ' + STD.TRABAJADOR.TXT_APE_MATERNO"), 'like', '%' . $nombre_usuario . '%')
                                     ->orWhere(DB::raw("STD.TRABAJADOR.TXT_APE_PATERNO + ' ' + STD.TRABAJADOR.TXT_APE_MATERNO + ' ' + STD.TRABAJADOR.TXT_NOMBRES"), 'like', '%' . $nombre_usuario . '%');
                            });
                        }
                    }
                })
                ->select('CMP.ORDEN.*', 'ALM.CENTRO.NOM_CENTRO')
                ->orderBy('CMP.ORDEN.FEC_ORDEN', 'desc')
                ->orderBy('CMP.ORDEN.COD_ORDEN', 'desc')
                ->get();

            return view('compras.ajax.listaordencompras', [
                'listaordenes' => $listaordenes,
                'idopcion' => $idopcion
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al listar las órdenes de compra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actionAjaxAprobarOrdenCompra(Request $request)
    {
        try {
            $cod_orden = $request->get('cod_orden');
            $orden = CMPOrden::where('COD_ORDEN', '=', $cod_orden)->first();

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se encontró la Orden de Compra especificada.'
                ]);
            }

            if ($orden->COD_CATEGORIA_ESTADO_ORDEN === 'EOR0000000000016') {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Esta orden ya se encuentra APROBADA.'
                ]);
            }
            if ($orden->COD_CATEGORIA_ESTADO_ORDEN === 'EOR0000000000017') {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Esta orden ya se encuentra RECHAZADA.'
                ]);
            }
            if ($orden->COD_CATEGORIA_ESTADO_ORDEN !== 'EOR0000000000001') {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Solo se pueden aprobar órdenes de compra en estado GENERADA.'
                ]);
            }

            $cod_centro = $orden->COD_CENTRO;
            $conexionbd = '';
            if ($cod_centro == 'CEN0000000000004') {
                $conexionbd = 'sqlsrv_r';
            } elseif ($cod_centro == 'CEN0000000000006') {
                $conexionbd = 'sqlsrv_b';
            }

            // Validar conexión a la zona antes de continuar
            if ($conexionbd !== '') {
                try {
                    DB::connection($conexionbd)->getPdo();
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'mensaje' => 'No hay conexión con la base de datos de la zona. Por favor, espere a que se restablezca para evitar inconsistencias.'
                    ]);
                }
            }

            // Consultar a la zona antes de proceder
            if ($conexionbd !== '') {
                $orden_zona = DB::connection($conexionbd)->table('CMP.ORDEN')
                    ->where('COD_ORDEN', '=', $cod_orden)
                    ->first();

                if ($orden_zona) {
                    $estado_zona = trim($orden_zona->COD_CATEGORIA_ESTADO_ORDEN);
                    if ($estado_zona === 'EOR0000000000016') {
                        return response()->json([
                            'success' => false,
                            'mensaje' => 'Esta orden ya se encuentra APROBADA de manera manual en la zona.'
                        ]);
                    }
                    if ($estado_zona === 'EOR0000000000017') {
                        return response()->json([
                            'success' => false,
                            'mensaje' => 'Esta orden ya se encuentra RECHAZADA de manera manual en la zona.'
                        ]);
                    }
                }
            }

            DB::beginTransaction();
            if ($conexionbd !== '') {
                DB::connection($conexionbd)->beginTransaction();
            }

            try {
                $estado_cod = 'EOR0000000000016';
                $estado_txt = 'APROBADO';
                $usuario_modif = Session::get('usuario')->name;
                $fecha_modif = date('Ymd H:i:s');

                $orden->COD_CATEGORIA_ESTADO_ORDEN = $estado_cod;
                $orden->TXT_CATEGORIA_ESTADO_ORDEN = $estado_txt;
                $orden->COD_USUARIO_MODIF_AUD = $usuario_modif;
                $orden->FEC_USUARIO_MODIF_AUD = $fecha_modif;
                $orden->save();

                if ($conexionbd !== '') {
                    DB::connection($conexionbd)->table('CMP.ORDEN')
                        ->where('COD_ORDEN', '=', $cod_orden)
                        ->update([
                            'COD_CATEGORIA_ESTADO_ORDEN' => $estado_cod,
                            'TXT_CATEGORIA_ESTADO_ORDEN' => $estado_txt,
                            'COD_USUARIO_MODIF_AUD' => $usuario_modif,
                            'FEC_USUARIO_MODIF_AUD' => $fecha_modif
                        ]);
                }

                DB::commit();
                if ($conexionbd !== '') {
                    DB::connection($conexionbd)->commit();
                }

                return response()->json([
                    'success' => true,
                    'mensaje' => 'La Orden de Compra ' . $cod_orden . ' ha sido aprobada con éxito.'
                ]);

            } catch (\Exception $ex) {
                DB::rollBack();
                if ($conexionbd !== '') {
                    DB::connection($conexionbd)->rollBack();
                }
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al aprobar la Orden de Compra: ' . $ex->getMessage()
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de servidor al aprobar la Orden de Compra: ' . $e->getMessage()
            ]);
        }
    }

    public function actionAjaxRechazarOrdenCompra(Request $request)
    {
        try {
            $cod_orden = $request->get('cod_orden');
            $orden = CMPOrden::where('COD_ORDEN', '=', $cod_orden)->first();

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se encontró la Orden de Compra especificada.'
                ]);
            }

            if ($orden->COD_CATEGORIA_ESTADO_ORDEN === 'EOR0000000000017') {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Esta orden ya se encuentra RECHAZADA.'
                ]);
            }
            if ($orden->COD_CATEGORIA_ESTADO_ORDEN !== 'EOR0000000000001' && $orden->COD_CATEGORIA_ESTADO_ORDEN !== 'EOR0000000000016') {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Solo se pueden rechazar órdenes de compra en estado GENERADA o APROBADA.'
                ]);
            }

            $cod_centro = $orden->COD_CENTRO;
            $conexionbd = '';
            if ($cod_centro == 'CEN0000000000004') {
                $conexionbd = 'sqlsrv_r';
            } elseif ($cod_centro == 'CEN0000000000006') {
                $conexionbd = 'sqlsrv_b';
            }

            // Validar conexión a la zona antes de continuar
            if ($conexionbd !== '') {
                try {
                    DB::connection($conexionbd)->getPdo();
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'mensaje' => 'No hay conexión con la base de datos de la zona. Por favor, espere a que se restablezca para evitar inconsistencias.'
                    ]);
                }
            }

            // Consultar a la zona antes de proceder
            if ($conexionbd !== '') {
                $orden_zona = DB::connection($conexionbd)->table('CMP.ORDEN')
                    ->where('COD_ORDEN', '=', $cod_orden)
                    ->first();

                if ($orden_zona) {
                    $estado_zona = trim($orden_zona->COD_CATEGORIA_ESTADO_ORDEN);
                    if ($estado_zona === 'EOR0000000000017') {
                        return response()->json([
                            'success' => false,
                            'mensaje' => 'Esta orden ya se encuentra RECHAZADA de manera manual en la zona.'
                        ]);
                    }
                }
            }

            DB::beginTransaction();
            if ($conexionbd !== '') {
                DB::connection($conexionbd)->beginTransaction();
            }

            try {
                $estado_cod = 'EOR0000000000017';
                $estado_txt = 'RECHAZADO';
                $usuario_modif = Session::get('usuario')->name;
                $fecha_modif = date('Ymd H:i:s');

                $orden->COD_CATEGORIA_ESTADO_ORDEN = $estado_cod;
                $orden->TXT_CATEGORIA_ESTADO_ORDEN = $estado_txt;
                $orden->COD_USUARIO_MODIF_AUD = $usuario_modif;
                $orden->FEC_USUARIO_MODIF_AUD = $fecha_modif;
                $orden->save();

                if ($conexionbd !== '') {
                    DB::connection($conexionbd)->table('CMP.ORDEN')
                        ->where('COD_ORDEN', '=', $cod_orden)
                        ->update([
                            'COD_CATEGORIA_ESTADO_ORDEN' => $estado_cod,
                            'TXT_CATEGORIA_ESTADO_ORDEN' => $estado_txt,
                            'COD_USUARIO_MODIF_AUD' => $usuario_modif,
                            'FEC_USUARIO_MODIF_AUD' => $fecha_modif
                        ]);
                }

                DB::commit();
                if ($conexionbd !== '') {
                    DB::connection($conexionbd)->commit();
                }

                return response()->json([
                    'success' => true,
                    'mensaje' => 'La Orden de Compra ' . $cod_orden . ' ha sido rechazada con éxito.'
                ]);

            } catch (\Exception $ex) {
                DB::rollBack();
                if ($conexionbd !== '') {
                    DB::connection($conexionbd)->rollBack();
                }
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al rechazar la Orden de Compra: ' . $ex->getMessage()
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de servidor al rechazar la Orden de Compra: ' . $e->getMessage()
            ]);
        }
    }

    public function actionAjaxCargarDetalleOrdenCompra(Request $request)
    {
        try {
            $cod_orden = $request->get('cod_orden');
            $idopcion = $request->get('idopcion');

            $orden = CMPOrden::leftJoin('ALM.CENTRO', 'ALM.CENTRO.COD_CENTRO', '=', 'CMP.ORDEN.COD_CENTRO')
                ->where('CMP.ORDEN.COD_ORDEN', '=', $cod_orden)
                ->select('CMP.ORDEN.*', 'ALM.CENTRO.NOM_CENTRO')
                ->first();

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se encontró la Orden de Compra.'
                ], 404);
            }

            $detalles = CMPDetalleProducto::with(['producto.unidadmedida'])
                ->where('COD_TABLA', '=', $cod_orden)
                ->where('COD_ESTADO', '=', 1)
                ->get();

            return view('compras.ajax.detalleordencompra', [
                'orden' => $orden,
                'detalles' => $detalles,
                'idopcion' => $idopcion
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al cargar el detalle: ' . $e->getMessage()
            ], 500);
        }
    }
}
