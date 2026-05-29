<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use View;
use App\WEBActivoFijo;
use Illuminate\Support\Carbon;

class ValeRendirAdministracionController extends Controller
{
    public function actionListar(Request $request, $idopcion)
    {
        $decidopcion = \Hashids::decode($idopcion);
        $idopcioncompleta = '1CIX' . str_pad($decidopcion[0], 8, "0", STR_PAD_LEFT);
        $opcion = DB::table('WEB.opciones')->where('id', $idopcioncompleta)->first();
        
        $cod_empresa = Session::get('empresas')->COD_EMPR;
        $combocentros = DB::table('ALM.CENTRO')->where('COD_ESTADO', 1)->pluck('NOM_CENTRO', 'COD_CENTRO');

        return view('activofijo.lista', [
            'idopcion' => $idopcion,
            'opcion' => $opcion,
            'combocentros' => $combocentros
        ]);
    }

    public function actionAjaxListar(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio', '');
        $fecha_fin = $request->input('fecha_fin', '');

        $query = WEBActivoFijo::where('modalidad_adquisicion', 'OBRA');
        
        if ($fecha_inicio != '') {
            $query->whereDate('fechacreacion', '>=', $fecha_inicio);
        }
        if ($fecha_fin != '') {
            $query->whereDate('fechacreacion', '<=', $fecha_fin);
        }

        $lista = $query->orderBy('fechacreacion', 'DESC')->get();

        return view('activofijo.ajax.lista', [
            'lista' => $lista,
            'ajax' => true
        ]);
    }

    public function actionAgregarModificar(Request $request)
    {
        $id = $request->input('id', '');
        $item_ple = $request->input('item_ple');
        $nombre = $request->input('nombre');
        $cantidad = $request->input('cantidad');
        $estado = $request->input('estado');
        $modalidad_adquisicion = $request->input('modalidad_adquisicion');
        $cod_empresa = Session::get('empresas')->COD_EMPR;
        $usuario_id = Session::get('usuario')->id;
        $fecha = date('Ymd H:i:s');

        DB::beginTransaction();
        try {
            if ($id == '') {
                // GENERAR ID
                $max_id = WEBActivoFijo::where('id', 'like', 'ACTF%')->max('id');
                $numero = $max_id ? (int) substr($max_id, 4) : 0;
                $nuevo_id = 'ACTF' . str_pad($numero + 1, 12, '0', STR_PAD_LEFT);

                $activo = new WEBActivoFijo();
                $activo->id = $nuevo_id;
                $activo->item_ple = $item_ple;
                $activo->nombre = $nombre;
                $activo->cantidad = 1;
                $activo->estado = 'OPERATIVO';
                $activo->modalidad_adquisicion = 'OBRA';
                $activo->tipo_activo = $request->input('tipo_activo', 'Edificaciones');
                $activo->estado_conservacion = 'BUENO';
                $activo->estado_depreciacion = 'DEPRECIANDOSE';
                $activo->origen = 'MANUAL';
                
                $activo->fecha_emision = $request->input('fecha_emision');
                $activo->base_de_calculo = $request->input('base_de_calculo');
                $activo->fecha_inicio_depreciacion = $request->input('fecha_inicio_depreciacion');

                $trabajador = DB::table('STD.TRABAJADOR')->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)->first();
                $dni = $trabajador ? $trabajador->NRO_DOCUMENTO : '';
                $trabajadorespla = DB::table('WEB.platrabajadores')->where('situacion_id', 'PRMAECEN000000000002')->where('empresa_osiris_id', $cod_empresa)->where('dni', $dni)->first();
                
                if ($trabajadorespla) {
                    $centro_id = $trabajadorespla->centro_osiris_id;
                } else {
                    $tercero = DB::table('terceros')->where('DNI', $dni)->first();
                    $centro_id = $tercero ? $tercero->COD_CENTRO : '';
                }
                $centro = DB::table('ALM.CENTRO')->where('COD_CENTRO', $centro_id)->first();
                
                $activo->cod_centro = $centro ? $centro->COD_CENTRO : '';
                $activo->centro_data = $centro ? $centro->NOM_CENTRO : '';

                $activo->saldo_inicio_depreciacion_acumulada = $request->input('base_de_calculo');
                $activo->depreciacion_acumulada = $request->input('depreciacion_acumulada', 0);
                $activo->ultima_fecha_depreciacion = $request->input('ultima_fecha_depreciacion');
                $activo->categoria_activo_fijo_id = 'CAF0000000000001';

                $activo->cod_empresa = $cod_empresa;
                $activo->usuario_id = $usuario_id;
                
                $activo->fecha_registro = $fecha;
                $activo->fechacreacion = $fecha;
                $activo->fecha_modificacion = $fecha;
                
                $activo->save();

                DB::commit();
                return response()->json(['success' => true, 'mensaje' => 'Obra registrada correctamente.']);
            } else {
                $activo = WEBActivoFijo::find($id);
                if ($activo) {
                    $activo->item_ple = $item_ple;
                    $activo->nombre = $nombre;
                    $activo->cantidad = 1;
                    $activo->estado = 'OPERATIVO';
                    $activo->tipo_activo = $request->input('tipo_activo', 'Edificaciones');
                    $activo->modalidad_adquisicion = 'OBRA';
                    
                    $activo->fecha_emision = $request->input('fecha_emision');
                    $activo->base_de_calculo = $request->input('base_de_calculo');
                    $activo->fecha_inicio_depreciacion = $request->input('fecha_inicio_depreciacion');

                    $trabajador = DB::table('STD.TRABAJADOR')->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)->first();
                    $dni = $trabajador ? $trabajador->NRO_DOCUMENTO : '';
                    $trabajadorespla = DB::table('WEB.platrabajadores')->where('situacion_id', 'PRMAECEN000000000002')->where('empresa_osiris_id', $cod_empresa)->where('dni', $dni)->first();
                    
                    if ($trabajadorespla) {
                        $centro_id = $trabajadorespla->centro_osiris_id;
                    } else {
                        $tercero = DB::table('terceros')->where('DNI', $dni)->first();
                        $centro_id = $tercero ? $tercero->COD_CENTRO : '';
                    }
                    $centro = DB::table('ALM.CENTRO')->where('COD_CENTRO', $centro_id)->first();
                    
                    $activo->cod_centro = $centro ? $centro->COD_CENTRO : '';
                    $activo->centro_data = $centro ? $centro->NOM_CENTRO : '';
                    
                    $activo->saldo_inicio_depreciacion_acumulada = $request->input('base_de_calculo');
                    $activo->depreciacion_acumulada = $request->input('depreciacion_acumulada', 0);
                    $activo->ultima_fecha_depreciacion = $request->input('ultima_fecha_depreciacion');

                    $activo->fecha_modificacion = $fecha;
                    $activo->save();
                    
                    DB::commit();
                    return response()->json(['success' => true, 'mensaje' => 'Obra modificada correctamente.']);
                }
                DB::rollBack();
                return response()->json(['success' => false, 'error' => 'Registro no encontrado.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function actionEliminar(Request $request)
    {
        $id = $request->input('id');
        $activo = WEBActivoFijo::find($id);
        if ($activo) {
            $activo->delete();
            return response()->json(['success' => true, 'mensaje' => 'Obra eliminada correctamente.']);
        }
        return response()->json(['success' => false, 'error' => 'Registro no encontrado.']);
    }
}
