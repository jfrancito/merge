<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\ValeRendirTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoMotivoValeRendir;
use App\Modelos\WEBValeRendir;
use App\Modelos\WEBValeRendirDetalle;
use App\Modelos\STDTrabajador;
use App\Modelos\STDEmpresa;

use App\Modelos\CMPCategoria;
use Illuminate\Support\Facades\Log;

use Session;
use App\WEBRegla;
use APP\User;
use App\Modelos\CMPContrato;
use View;
use Validator;
use App\Biblioteca\NotaCredito;

class ValeRendirApruebaController extends Controller
{
    use ValeRendirTraits;

   
    public function actionValeRendirAprueba(Request $request)
    {

        $cod_centro = '';
        $nom_centro = '';  


        $usuariosAp = STDTrabajadorVale::where('ind_aprueba', 1)->pluck('nombre', 'cod_trabajador_vale')->toArray();
        $usuariosAu = STDTrabajadorVale::where('ind_autoriza', 1)->pluck('nombre', 'cod_trabajador_vale')->toArray();
        $tipoMotivo = WEBTipoMotivoValeRendir::where('cod_estado',1)->pluck('txt_motivo', 'cod_motivo')->toArray();

        $combo = array('' => 'Seleccione Usuario Autoriza') + $usuariosAu;
        $combo1 = array('' => 'Seleccione Usuario Aprueba') + $usuariosAp;
        $combo2 = array('' => 'Seleccione Tipo o Motivo') + $tipoMotivo;

        

        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;

      /*  $trabajador     =   DB::table('STD.TRABAJADOR')
                            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                            ->first();
        $dni            =       '';
        $centro_id      =       '';
        if(count($trabajador)>0){
            $dni        =       $trabajador->NRO_DOCUMENTO;
        }
        $trabajadorespla    =   DB::table('WEB.platrabajadores')
                                ->where('situacion_id', 'PRMAECEN000000000002')
                                ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                ->where('dni', $dni)
                                ->first();
        if(count($trabajador)>0){
            $centro_id      =       $trabajadorespla->centro_osiris_id;
        }
        $centrot        =   DB::table('ALM.CENTRO')
                            ->where('COD_CENTRO', $centro_id)
                            ->first();




        $cod_centro = $centrot->COD_CENTRO; 
        $nom_centro = $centrot->NOM_CENTRO; */

    
        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;


        $listarusuarios = $this->listaValeRendirAprueba(
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

        //dd($listarusuarios);

        return view('valerendir.ajax.modalvalerendiraprueba', [
            'listausuarios' => $combo,
            'listausuarios1' => $combo1,
            'listausuarios2' => $combo2,
            'listarusuarios' => $listarusuarios,
            'usuario_logueado_id' => $usuario_logueado_id,
            'txtNombreCliente'=>'',
            'ajax'=>true,
         
        ]);
    }

    public function actionApruebaValeRendir(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 

        $fec_autorizacion = $request->input('fec_autorizacion');
        $txt_serie = $request->input('txt_serie');
        $txt_numero = $request->input('txt_numero');
        $cod_contrato = $request->input('cod_contrato');
        $sub_cuenta = $request->input('sub_cuenta');
        $txt_glosa_autorizado = $request->input('txt_glosa_autorizado');
        $tipo_pago = (int) $request->input('tipo_pago');
        $txt_categoria_banco = $request->input('txt_categoria_banco');
        $numero_cuenta = $request->input('numero_cuenta');
        $txt_glosa_aprobado = $request->input('txt_glosa_aprobado');
        

        $cod_categoria_estado_vale = 'ETM0000000000007';  
        $txt_categoria_estado_vale = 'APROBADO'; 

         $valerendir_id = $request->input('valerendir_id');

        $registro = DB::table('WEB.VALE_RENDIR')
        ->select('COD_CENTRO')
        ->where('ID', $valerendir_id) 
        ->first();

        $cod_centro = $registro ? $registro->COD_CENTRO : null;
  

            $this->insertValeRendirAutoApruebaRechaza(
                 'D', 
                $id_buscar,
                $fec_autorizacion, 
                $txt_serie,
                $txt_numero,   
                '', 
                '', 
                '',
                '',
                '',
                '', 
                '', 
                '', 
                $cod_contrato, 
                $sub_cuenta,
                '',
                '',
                $tipo_pago,
                '',
                $txt_glosa_autorizado,
                '',
                $txt_glosa_aprobado,
                0.0, 
                0.0,
                $txt_categoria_banco,
                $numero_cuenta,
                $cod_categoria_estado_vale,
                $txt_categoria_estado_vale, 
                false,
                Session::get('usuario')->id 
            );

             $this->actionInsertValeRendirOsiris($request);

        return response()->json(['success' => 'Vale de rendir aprobado correctamente.']);
    }


     public function actionRechazarValeRendir(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 

        $cod_categoria_estado_vale = 'ETM0000000000006';  
        $txt_categoria_estado_vale = 'RECHAZADO'; 

        $valerendir_id = $request->input('valerendir_id');

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
                '',
                '',
                '',
                '',
                '',
                $txt_glosa_rechazado, 
                0.0, 
                0.0,
                '',
                '',
                $cod_categoria_estado_vale,
                $txt_categoria_estado_vale, 
                false,
                Session::get('usuario')->id 
            );

         return response()->json(['success' => 'Vale de rendir rechazado correctamente.']);
    }
    

     public function actionApruebaRegistroValeRendir(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
     
        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;
        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;
       
        $txtNombreCliente   =   WEBValeRendir::where('id', $id_buscar)->first();
        $nombreCuentaCliente = $txtNombreCliente->TXT_NOM_SOLICITA;
        $glosaCliente = $txtNombreCliente->TXT_GLOSA_AUTORIZADO;
        $codemprcliente = $txtNombreCliente->COD_EMPR_CLIENTE;
        $cod_moneda = $txtNombreCliente->COD_MONEDA;
  
        $notacredito            = new NotaCredito();

        $cod_categoria_estado_vale = 'ETM0000000000001';  
        $txt_categoria_estado_vale = 'GENERADO'; 


        $contrato_diferente = CMPContrato::where('COD_EMPR', '=', $cod_empr)
            ->where('COD_CATEGORIA_TIPO_CONTRATO', '=', 'TCO0000000000069')
          //  ->where('TXT_EMPR_CLIENTE', 'LIKE', '%' . $nombreCuentaCliente . '%')
            ->where('COD_EMPR_CLIENTE', '=', $codemprcliente)
             ->where('COD_CATEGORIA_MONEDA', $cod_moneda)
            ->select(DB::raw("COD_CONTRATO, CONCAT(LEFT(COD_CONTRATO, 6), '-', RIGHT(CONCAT('00000', RIGHT(COD_CONTRATO, 5)), 5), ' - S/', ' ', REPLACE(TXT_CATEGORIA_CANAL_VENTA, 'POR', 'X')) AS CUENTA"))
            ->pluck('CUENTA', 'COD_CONTRATO')
            ->toArray();

         // dd($contrato_diferente);

    //  $combo_cuenta = array('' => 'Seleccione Cuenta') + $contrato_diferente;
        $combo_series = $notacredito->combo_series_tipodocumento('TDO0000000000072');

        //AGREGAR NUMEROOOOOOOOOO




        $ultimoCorrelativo = DB::table('TES.AUTORIZACION')
        ->where('TXT_SERIE', $combo_series)
        ->where('COD_TIPO_DOCUMENTO', 'TDO0000000000072')
        ->max('TXT_NUMERO');


        $nro_documento = is_null($ultimoCorrelativo) ? 1:$ultimoCorrelativo + 1;
        $nro_documento_formateado = str_pad($nro_documento, 10, '0', STR_PAD_LEFT);




        $fecha_actual = date('Y-m-d');

      
        $subcuentas = CMPContrato::from('CMP.CONTRATO AS CON')  
            ->join('CMP.CONTRATO_CULTIVO AS CUL', 'CON.COD_CONTRATO', '=', 'CUL.COD_CONTRATO')
            ->where('CON.COD_EMPR', '=', $cod_empr)
            ->where('CON.COD_CATEGORIA_TIPO_CONTRATO', '=', 'TCO0000000000069')
        //    ->where('CON.TXT_EMPR_CLIENTE', '=', $nombreCuentaCliente)
               ->where('COD_EMPR_CLIENTE', '=', $codemprcliente)
            ->select(DB::raw("CON.COD_CONTRATO, CONCAT(CUL.TXT_ZONA_COMERCIAL, '-', CUL.TXT_ZONA_CULTIVO) AS SUBCUENTA"))
            ->pluck('SUBCUENTA', 'COD_CONTRATO')
            ->toArray();
    //   $combo_subcuenta = array('' => 'Seleccione Sub Cuenta') + $subcuentas;
         //   dd($subcuentas);


       
        // $cuentaBancaria = DB::table('TES.CUENTA_BANCARIA AS TCB')
        //    ->join('STD.EMPRESA AS EMPR', 'TCB.COD_EMPR_TITULAR', '=', 'EMPR.COD_EMPR')
        //     ->where('EMPR.NOM_EMPR', 'LIKE', "%{$nombreCuentaCliente}%") 
        //     ->first(); 
        //     dd($cuentaBancaria);

        $empresatrabjador =   STDEmpresa::where('COD_EMPR','=',$codemprcliente)->first();
        $nrodocumentotrab = $empresatrabjador->NRO_DOCUMENTO;

        // $values                 =   ['42454192','IACHEM0000007086'];
        $values                 =   [$nrodocumentotrab,$cod_empr];
        $datoscuentasueldo      =   DB::select('exec ListaTrabajadorCuentaSueldo ?,?',$values);      

        // log($datoscuentasueldo[0]->trabajador_id);


        return view('valerendir.ajax.modalosirisvalerendiraprueba', [
            'txtNombreCliente' => $txtNombreCliente->TXT_NOM_SOLICITA,
         // 'contrato_diferente' => $combo_cuenta,
            'contrato_diferente' => $contrato_diferente,
            'combo_series' =>$combo_series,
            'fecha_actual' => $fecha_actual,
         // 'subcuentas' => $combo_subcuenta,
            'subcuentas' => $subcuentas,
            'estado' => $txt_categoria_estado_vale,
            'nro_documento_formateado' => $nro_documento_formateado,
            'glosaCliente' => $glosaCliente,
            // 'nombreBanco' => $cuentaBancaria->TXT_EMPR_BANCO,
            // 'numeroBanco' => $cuentaBancaria->TXT_NRO_CUENTA_BANCARIA,
            'nombreBanco' => $datoscuentasueldo[0]->numcuenta,
            'numeroBanco' => $datoscuentasueldo[0]->entidad,
            'ajax'=>true,
        ]);                     
    }

 /*   public function actionObtenerCorrelativoValeRendir(Request $request)
    {

        $serie = $request->input('nro_serie'); 
      

        $ultimoCorrelativo = DB::table('TES.AUTORIZACION')
        ->where('TXT_SERIE', $serie)
        ->where('COD_TIPO_DOCUMENTO', 'TDO0000000000072')
        ->max('TXT_NUMERO');


        $nro_documento = is_null($ultimoCorrelativo) ? 1:$ultimoCorrelativo + 1;
        $nro_documento_formateado = str_pad($nro_documento, 10, '0', STR_PAD_LEFT);

        return response()->json(['nro_doc' => $nro_documento_formateado]);

    }*/

    public function actionInsertValeRendirOsiris(Request $request) { 
     $id_buscar = $request->input('valerendir_id'); 
     $can_tipo_cambio = DB::table('cmp.TIPO_CAMBIO')
                                    ->where('FEC_CAMBIO', DB::raw("(SELECT MAX(FEC_CAMBIO) FROM cmp.TIPO_CAMBIO)"))
                                    ->value('CAN_COMPRA');

    
        $valeRendirOsiris       =   WEBValeRendir::where('ID', $id_buscar)->first();
        $id = $valeRendirOsiris->ID;
        $cod_empr= $valeRendirOsiris->COD_EMPR;
        $cod_centro = $valeRendirOsiris->COD_CENTRO;
        $cod_empresa = $valeRendirOsiris->COD_EMPR_CLIENTE;
        $txt_empresa = $valeRendirOsiris->TXT_NOM_SOLICITA;   
        $cod_contrato = $valeRendirOsiris->COD_CONTRATO;
        $cod_cultivo = 'CCU0000000000001';
        $fec_autorizacion = $valeRendirOsiris->FEC_AUTORIZACION;
        $cod_tra_autoriza = $valeRendirOsiris->USUARIO_AUTORIZA;
        $txt_tra_autoriza = $valeRendirOsiris->TXT_NOM_AUTORIZA;
        $cod_tipo_documento = 'TDO0000000000072';
        $txt_tipo_documento = 'VALE A RENDIR';
        $txt_serie = $valeRendirOsiris->TXT_SERIE;
        $txt_numero = $valeRendirOsiris->TXT_NUMERO;
        $nro_cuenta = $valeRendirOsiris->NRO_CUENTA;
        $cod_categoria_moneda = $valeRendirOsiris->COD_MONEDA;
        if ($cod_categoria_moneda == 'MON0000000000001') {
            $txt_categoria_moneda = 'SOLES';
        } else {
            $txt_categoria_moneda = 'DOLARES';
        }
        $can_tipo_cambio;
        $can_total = $valeRendirOsiris->CAN_TOTAL_IMPORTE;
        $can_saldo = $valeRendirOsiris->CAN_TOTAL_SALDO;
        $cod_tipo_estado = 'IACHTE0000000017';
        $txt_tipo_estado = 'GENERADO'; 
        $cod_estado = $valeRendirOsiris->COD_ESTADO;
        $cod_usuario_registro = $valeRendirOsiris->COD_USUARIO_CREA_AUD;
        if (empty($nro_cuenta)) {
            $txt_glosa = $valeRendirOsiris->TXT_GLOSA . ' / EFECTIVO';
        } else {
            $txt_glosa = $valeRendirOsiris->TXT_GLOSA . ' / TRANSFERENCIA / ' . $valeRendirOsiris->TXT_CATEGORIA_BANCO . ' / ' . $nro_cuenta;
        }
        $cod_centro_costo = '';
        $cod_centro_gasto = ''; 
        $ind_ms = '';


        $codigo = $this->insertValeRendirOsiris(
            "I", 
            $id, 
            $cod_empr, 
            $cod_centro, 
            $cod_empresa,
            $txt_empresa,
            $cod_contrato,
            $cod_cultivo, 
            $fec_autorizacion,
            $cod_tra_autoriza,
            $txt_tra_autoriza,
            $cod_tipo_documento,
            $txt_tipo_documento,
            $txt_serie, 
            $txt_numero,
            $cod_categoria_moneda, 
            $txt_categoria_moneda,
            $can_tipo_cambio,
            $can_total,
            $can_saldo,
            $cod_tipo_estado,
            $txt_tipo_estado,
            $cod_estado,
            $cod_usuario_registro,
            $txt_glosa,
            $cod_centro_costo,
            $cod_centro_gasto,
            $ind_ms
        );


        WEBValeRendir::where('ID', $id_buscar)
            ->update(
                    [
                        'ID_OSIRIS'=> $codigo
                    ]);  


    return response()->json(['success' => 'Vale de rendir procesado correctamente.']);
    }



        public function actionVerRegistroValeRendir(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
    
        $valeRendirOsiris       =   WEBValeRendir::where('ID', $id_buscar)->first();
        $id = $valeRendirOsiris->ID;
        $txt_serie = $valeRendirOsiris->TXT_SERIE;
        $txt_numero = $valeRendirOsiris->TXT_NUMERO;
        $fec_autorizacion = $valeRendirOsiris->FEC_AUTORIZACION;
        $txt_estado = $valeRendirOsiris->TXT_CATEGORIA_ESTADO_VALE;
        $txt_empresa = $valeRendirOsiris->TXT_NOM_SOLICITA;   
        $cod_contrato = $valeRendirOsiris->COD_CONTRATO;
        $sub_cuenta = $valeRendirOsiris->SUB_CUENTA;
        $txt_glosa_autorizado = $valeRendirOsiris->TXT_GLOSA_AUTORIZADO;
        $tipo_pago = $valeRendirOsiris->TIPO_PAGO;
        $NomBanco = $valeRendirOsiris->TXT_CATEGORIA_BANCO;
        $NumBanco = $valeRendirOsiris->NRO_CUENTA;
        $txt_glosa_aprobado = $valeRendirOsiris->TXT_GLOSA_APROBADO;

        
        $contrato_descripcion = CMPContrato::where('COD_CONTRATO', $cod_contrato)
        ->select(DB::raw("CONCAT(LEFT(COD_CONTRATO, 6), '-', 
            RIGHT(CONCAT('00000', RIGHT(COD_CONTRATO, 5)), 5), ' - S/', ' ', 
            REPLACE(TXT_CATEGORIA_CANAL_VENTA, 'POR', 'X')) AS CUENTA"))
        ->pluck('CUENTA')
        ->first();

         return view('valerendir.ajax.modalverdetallevalerendir', [
             'id' => $id,
             'txt_serie' => $txt_serie,
             'txt_numero' => $txt_numero,
             'fec_autorizacion' => $fec_autorizacion,
             'txt_estado' => $txt_estado,
             'txt_empresa' => $txt_empresa,
             'cod_contrato' => $cod_contrato,
              'contrato_descripcion' => $contrato_descripcion,
             'sub_cuenta' => $sub_cuenta,
             'txt_glosa_autorizado' => $txt_glosa_autorizado,
             'tipo_pago' => $tipo_pago,
             'NomBanco' => $NomBanco,
             'NumBanco' => $NumBanco,
             'txt_glosa_aprobado' => $txt_glosa_aprobado,
             'ajax'=>true,
        ]);           
    }


       public function actionVerDetalleImporte(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
    
   
    $detallesImporte = WEBValeRendirDetalle::where('ID', $id_buscar)->get(); 
   

    return view('valerendir.ajax.modaldetalleimporte', [
        'ajax' => true,
        'detalles' => $detallesImporte
    ]);  

    }         

}
    
 




