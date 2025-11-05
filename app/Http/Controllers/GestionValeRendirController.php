<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\ValeRendirTraits;
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
    use ValeRendirTraits;

  
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
        ];


    
        $estado_id = 'TODO';
        $listavale = $this->lg_lista_cabecera_vale_rendir($fecha_inicio, $fecha_fin, $estado_id);


        $funcion = $this;
            

         return view('valerendir.gestion.listavalesrendiradmin', [
            'listavale' => $listavale,
            'funcion' => $funcion,
            'idopcion' => $idopcion, 
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'estado_id' => $estado_id,
            'combo_estado' => $combo_estado
        ]);

    }


     public function actionListarAjaxBuscarDocumentoVL(Request $request)
    {

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        $estado_id = $request['estado_id'];
        $idopcion = $request['idopcion'];


        $listavale = $this->lg_lista_cabecera_vale_rendir($fecha_inicio, $fecha_fin, $estado_id);
        $funcion = $this;

        return View::make('valerendir/gestion/alistavalesrendiradmin',
            [
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'estado_id' => $estado_id,
                'idopcion' => $idopcion,
                'listavale' => $listavale,
                'ajax' => true,
                'funcion' => $funcion
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

}




