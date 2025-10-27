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
use App\Modelos\STDTrabajador;
use Illuminate\Support\Facades\Log;

use Session;
use App\WEBRegla, App\STDEmpresa, APP\User, App\CMPCategoria;
use View;
use Validator;
use App\Biblioteca\NotaCredito;


class ValeRendirAutorizaController extends Controller
{
    use ValeRendirTraits;  

   
    public function actionValeRendirAutoriza()
    {

        $cod_centro = '';
        $nom_centro = '';


        $usuariosAp =  DB::table('WEB.VALE_PERSONAL_APRUEBA')->where('cod_centro', $cod_centro)->pluck('txt_aprueba', 'cod_aprueba')->toArray();
        $usuariosAu = STDTrabajadorVale::where('ind_autoriza', 1)->pluck('nombre', 'cod_trabajador_vale')->toArray();
        $tipoMotivo = WEBTipoMotivoValeRendir::where('cod_estado',1)->pluck('txt_motivo', 'cod_motivo')->toArray();

        $combo = array('' => 'Seleccione Usuario Autoriza') + $usuariosAu;
        $combo1 = array('' => 'Seleccione Usuario Aprueba') + $usuariosAp;
        $combo2 = array('' => 'Seleccione Tipo o Motivo') + $tipoMotivo;

        $cod_usuario_registro = Session::get('usuario')->id;



        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;
        
        
        $listarusuarios = $this->listaValeRendirAutoriza(
                "GEN",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                0.0,
                0.0,
                ""
            );

       
        return view('valerendir.ajax.modalvalerendirautoriza', [
                    'listausuarios' => $combo,
                    'listausuarios1' => $combo1,
                    'listausuarios2' => $combo2,
                    'listarusuarios' => $listarusuarios,
                    'usuario_logueado_id' => $usuario_logueado_id,
                    'ajax'=>true,
        ]);
    }

    public function actionAutorizarValeRendir(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
        $txt_glosa_autorizado = $request->input('motivo_autoriza');

        $cod_categoria_estado_vale = 'ETM0000000000005';  
        $txt_categoria_estado_vale = 'AUTORIZADO'; 


        $valerendir_id = $request->input('valerendir_id');
        $vale = WEBValeRendir::where('ID', $id_buscar)->first();


        $registro = DB::table('WEB.VALE_RENDIR')
        ->select('COD_CENTRO')
        ->where('ID', $valerendir_id) 
        ->first();

        $cod_centro = $registro ? $registro->COD_CENTRO : null;

    
            $this->insertValeRendirAutoApruebaRechaza(
                'D', 
                $id_buscar,
                '', 
                '',
                '',
                '',
                $cod_centro,
                '',
                '', 
                '',
                '',
                '', 
                '',
                '', 
                '',
                '',
                '', 
                $vale->TIPO_PAGO,
                '',
                $txt_glosa_autorizado,
                '',
                '',
                0.0, 
                0.0,
                $vale->TXT_CATEGORIA_BANCO,
                $vale->NRO_CUENTA,
                $cod_categoria_estado_vale,
                $txt_categoria_estado_vale, 
                $vale->COD_PERSONAL_RENDIR,
                $vale->TXT_PERSONAL_RENDIR,
                false,
                Session::get('usuario')->id 
            );

        return response()->json(['success' => 'Vale de rendir autorizado correctamente.']);
    }


     public function actionRechazarValeRendir(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
        $txt_glosa_rechazado = $request->input('motivo_rechazo');
        
        $cod_categoria_estado_vale = 'ETM0000000000006';  
        $txt_categoria_estado_vale = 'RECHAZADO'; 

        $valerendir_id = $request->input('valerendir_id');
        $vale = WEBValeRendir::where('ID', $id_buscar)->first();

        $registro = DB::table('WEB.VALE_RENDIR')
        ->select('COD_CENTRO')
        ->where('ID', $valerendir_id) 
        ->first();

        $cod_centro = $registro ? $registro->COD_CENTRO : null;

        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;
        $usuario_nombre_logueado_id = Session::get('usuario')->nombre;


           
            $this->insertValeRendirAutoApruebaRechaza(
                'D', 
                $id_buscar,
                '', 
                '',
                '', 
                '',
                $cod_centro,
                '',
                '',
                '',
                '',
                '', 
                '',
                '', 
                '', 
                '',
                '',
                $vale->TIPO_PAGO,
                '',
                '',
                $txt_glosa_rechazado, 
                '',
                0.0, 
                0.0,
                $vale->TXT_CATEGORIA_BANCO,
                $vale->NRO_CUENTA,
                $cod_categoria_estado_vale,
                $txt_categoria_estado_vale, 
                $vale->COD_PERSONAL_RENDIR,
                $vale->TXT_PERSONAL_RENDIR,
                false,
                Session::get('usuario')->id 
            );
            
            DB::table('WEB.VALE_RENDIR')
                ->where('ID', $id_buscar)
                ->update([
                    'USUARIO_APRUEBA'  => $usuario_logueado_id,
                    'TXT_NOM_APRUEBA'  => $usuario_nombre_logueado_id,
                ]);


             return response()->json(['success' => 'Vale de rendir Rechazado correctamente.']);
    }

        public function actionDetalleImporte(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
   
        $vale = WEBValeRendir::where('ID', $id_buscar)->first(); // primero en lugar de get(), para tener objeto
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


         $areacomercial = '';



        return view('valerendir.ajax.modaldetalleimporte', [
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
}
 




