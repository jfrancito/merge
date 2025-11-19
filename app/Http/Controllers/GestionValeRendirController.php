<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\ValeRendirTraits;
use App\Traits\EnviarCorreoVRDetalleImporteTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoMotivoValeRendir;
use App\Modelos\WEBValeRendir;
use App\Modelos\WEBValeRendirDetalle;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;

class GestionValeRendirController extends Controller
{
    use ValeRendirTraits, EnviarCorreoVRDetalleImporteTraits;

  
    public function actionListarValeRendir($idopcion)
    {
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista Vales a Rendir');
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;

        $fecha_inicio = $this->fecha_menos_diez_dias;
        $fecha_fin = $this->fecha_sin_hora;
        $combo_estado = [
            'TODO' => 'TODO',
            'ETM0000000000001' => 'GENERADO',
            'ETM0000000000005' => 'AUTORIZADO',
            'ETM0000000000007' => 'APROBADO',
            'ETM0000000000010' => 'ANULADO',
        ];

         $combo_tipo_vale = [
        'RENDIR' => 'VALE A RENDIR',
        'REEMBOLSO' => 'REEMBOLSO',
        'TODO' => 'TODO',
        ];


    
         $estado_id = 'TODO';
         $tipo_vale = 'TODO';
         $listavale = $this->lg_lista_cabecera_vale_rendir($fecha_inicio, $fecha_fin, $estado_id, $tipo_vale);


        $funcion = $this;
            

         return view('valerendir.gestion.listavalesrendiradmin', [
            'listavale' => $listavale,
            'funcion' => $funcion,
            'idopcion' => $idopcion, 
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'estado_id' => $estado_id,
            'combo_estado' => $combo_estado,
            'combo_tipo_vale' => $combo_tipo_vale,
            'tipo_vale' => $tipo_vale
        ]);

    }


     public function actionListarAjaxBuscarDocumentoVL(Request $request)
    {

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        $estado_id = $request['estado_id'];
        $tipo_vale = $request['tipo_vale'];
        $idopcion = $request['idopcion'];


        $listavale = $this->lg_lista_cabecera_vale_rendir($fecha_inicio, $fecha_fin, $estado_id, $tipo_vale);
        $funcion = $this;

        return View::make('valerendir/gestion/alistavalesrendiradmin',
            [
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'estado_id' => $estado_id,
                'tipo_vale' => $tipo_vale,
                'idopcion' => $idopcion,
                'listavale' => $listavale,
                'ajax' => true,
                'funcion' => $funcion
            ]);
    }


     public function actionVerDetalleValeImporte(Request $request)
    { 
       $id_buscar = $request->input('valerendir_id'); 

        
        $vale = WEBValeRendir::where('ID', $id_buscar)->first(); 
        $detallesImporte = WEBValeRendirDetalle::where('ID', $id_buscar)->get(); 

        
        $fecha_inicio = $detallesImporte->min('FEC_INICIO');
        $fecha_fin = $detallesImporte->max('FEC_FIN');
        $cod_centro = $detallesImporte->first()->COD_CENTRO ?? null;
        $ultimo = $detallesImporte->last();
        $ultimo_destino = $ultimo ? $ultimo->NOM_DESTINO : '';
        $total_dias = $detallesImporte->sum('DIAS');
        $ruta_viaje = $detallesImporte->pluck('NOM_DESTINO')->implode('/ ');
        $txt_glosa = $vale->TXT_GLOSA ?? null;
        $txt_glosa_venta = $detallesImporte->pluck('TXT_GLOSA_VENTA')->filter()->implode(' // ');
        $txt_glosa_cobranza = $detallesImporte->pluck('TXT_GLOSA_COBRANZA')->filter()->implode(' // ');
        

       $trabajador     =   DB::table('STD.TRABAJADOR')
                            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                            ->first();
        $dni            =       '';
        $centro_id      =       '';

        if ($trabajador) {
            $dni = $trabajador->NRO_DOCUMENTO;
        }

        $trabajadorespla = DB::table('WEB.platrabajadores')
            ->where('situacion_id', 'PRMAECEN000000000002')
            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
            ->where('dni', $dni)
            ->first();


        if ($trabajadorespla) {
            $centro_id = $trabajadorespla->centro_osiris_id;

        } else {
            $tercero = DB::table('terceros')
                ->where('DNI', $dni)
                ->first();
            $centro_id = $tercero->COD_CENTRO;
        }

        $cod_centro = '';
        $nom_centro = '';

        if ($centro_id) {
            $centro = DB::table('ALM.CENTRO')
                ->where('COD_CENTRO', $centro_id)
                ->first();

            if ($centro) {
                $cod_centro = $centro->COD_CENTRO;
                $nom_centro = $centro->NOM_CENTRO;
            }
        }

         $areacomercial = DB::table('WEB.platrabajadores')
        ->where('situacion_id', 'PRMAECEN000000000002') // activo
        ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
        ->where('dni', $dni)
        ->value('cadarea');


        
        return view('valerendir.gestion.modaltab', [
            'ajax' => true,
            'valerendir' => $vale,
            'detalles' => $detallesImporte,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'cod_centro' => $cod_centro,
            'ultimo_destino' => $ultimo_destino,
            'txt_glosa' => $txt_glosa,
            'total_dias' => $total_dias,
            'ruta_viaje' => $ruta_viaje,
            'txt_glosa_venta' => $txt_glosa_venta,
            'txt_glosa_cobranza' => $txt_glosa_cobranza,
            'areacomercial' => $areacomercial
        ]);  
    }



     public function actionVerDetalleVale(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 

    
        $vale = WEBValeRendir::where('ID', $id_buscar)->first();
        $detallesImporte = WEBValeRendirDetalle::where('ID', $id_buscar)->get(); 

      
        $fecha_inicio = $detallesImporte->min('FEC_INICIO');
        $fecha_fin = $detallesImporte->max('FEC_FIN');
        $cod_centro = $detallesImporte->first()->COD_CENTRO ?? null;
        $ultimo = $detallesImporte->last();
        $ultimo_destino = $ultimo ? $ultimo->NOM_DESTINO : '';
        $total_dias = $detallesImporte->sum('DIAS');
        $ruta_viaje = $detallesImporte->pluck('NOM_DESTINO')->implode('/ ');
        $txt_glosa = $vale->TXT_GLOSA ?? null;
 
        return view('valerendir.gestion.modalvaledetallegestion', [
            'ajax' => true,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'vale' => $vale,
            'cod_centro' => $cod_centro,
            'ultimo_destino' => $ultimo_destino,
            'txt_glosa' => $txt_glosa,
            'total_dias' => $total_dias,
            'ruta_viaje' => $ruta_viaje,
            'detallesImporte' => $detallesImporte
        ]);  
    }


      public function actionVAumDetalleValeImporte(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 

    
        $vale = WEBValeRendir::where('ID', $id_buscar)->first();
        $detallesImporte = WEBValeRendirDetalle::where('ID', $id_buscar)->get(); 

      
        $fecha_inicio = $detallesImporte->min('FEC_INICIO');
        $fecha_fin = $detallesImporte->max('FEC_FIN');
        $cod_centro = $detallesImporte->first()->COD_CENTRO ?? null;
        $ultimo = $detallesImporte->last();
        $ultimo_destino = $ultimo ? $ultimo->NOM_DESTINO : '';
        $total_dias = $detallesImporte->sum('DIAS');
        $ruta_viaje = $detallesImporte->pluck('NOM_DESTINO')->implode('/ ');
        $txt_glosa = $vale->TXT_GLOSA ?? null;

 
        return view('valerendir.gestion.modaltab2', [
            'ajax' => true,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'vale' => $vale,
            'cod_centro' => $cod_centro,
            'ultimo_destino' => $ultimo_destino,
            'txt_glosa' => $txt_glosa,
            'total_dias' => $total_dias,
            'ruta_viaje' => $ruta_viaje,
            'detalles' => $detallesImporte
        ]);  
    }


    public function actionActualizarDiasVale(Request $request)
    {
        $vale_id = $request->input('vale_id');
        $aumento_dias = $request->input('aumento_dias');

        if (!$vale_id || $aumento_dias === null) {
            return response()->json(['error' => 'Faltan datos requeridos.']);
        }

        try {
            $vale = WEBValeRendir::find($vale_id);

            if (!$vale) {
                return response()->json(['error' => 'Vale no encontrado.']);
            }

            WEBValeRendir::where('ID', $vale_id)
                ->update(['AUMENTO_DIAS' => $aumento_dias]);

            return response()->json(['success' => 'Vale actualizado correctamente.']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function actionActualizarImporteVale(Request $request)
    {
        $detalles = $request->input('detalles');

        if (!$detalles || !is_array($detalles)) {
            return response()->json(['error' => 'No se recibieron importes.']);
        }

        try {
            $agrupados = [];
            $cambios = [];

            foreach ($detalles as $d) {
                $key = $d['id'] . '_' . $d['destino'];
                $agrupados[$key][] = $d;
            }

            foreach ($agrupados as $key => $lineas) {

                list($id, $destino) = explode('_', $key);

                $detalle = DB::table('WEB.VALE_RENDIR_DETALLE')
                    ->where('ID', $id)
                    ->where('COD_DESTINO', $destino)
                    ->first();

                if (!$detalle) continue;

                // Valores ANTES
                $importeActual = explode("<br>", $detalle->CAN_UNITARIO_TOTAL);

                // Obtener nombre del destino del primer item
                $nombreDestino = $lineas[0]['nomdestino'] ?? '(Sin destino)';

                // Inicializar estructura
                $cambios[$key] = [
                    'id'          => $id,
                    'destino'     => $destino,
                    'nomdestino'  => $nombreDestino,
                    'antes'       => $importeActual,
                    'despues'     => [],
                    'diferencias' => []
                ];

                foreach ($lineas as $l) {

                    $Id = $l['id'];
                    $linea = intval($l['linea']);
                    $nombreTipo = $l['nomtipo'];
                    $nuevoValor = $l['importe'];

                    $valorAnterior = $importeActual[$linea] ?? null;

                    // Registrar nuevo valor
                    $cambios[$key]['despues'][$linea] = $nuevoValor;

                    // Registrar diferencia si cambia
                    if ($valorAnterior != $nuevoValor) {
                        $cambios[$key]['diferencias'][] = [
                            'id'           => $Id,
                            'linea'        => $linea + 1,
                            'nombre'       => $nombreTipo,
                            'nombredestino'=> $nombreDestino,
                            'antes'        => $valorAnterior,
                            'despues'      => $nuevoValor
                        ];
                    }

                    // Actualizar memoria local
                    $importeActual[$linea] = $nuevoValor;
                }

                // Actualizar BD
                DB::table('WEB.VALE_RENDIR_DETALLE')
                    ->where('ID', $id)
                    ->where('COD_DESTINO', $destino)
                    ->update([
                        'CAN_UNITARIO_TOTAL' => implode("<br>", $importeActual)
                    ]);
            }

            // Enviar correo
            $valeId = $detalles[0]['id'] ?? null;

            if ($valeId) {

                $this->enviarCorreoValeRendirDetalleImporte($valeId, $cambios);
            }

            return response()->json([
                'success' => true,
                'cambios' => $cambios
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}




