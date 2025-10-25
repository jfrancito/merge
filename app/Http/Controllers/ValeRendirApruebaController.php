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
        $perfil_administracion = Session::get('usuario')->rol_id;

        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;
         $cod_empre = Session::get('empresas')->centro_id;
        $usuario_merge = session::get('usuario')->id;

        $usuario_nombre_logueado_id = Session::get('usuario')->nombre;

        $trabajadorCentro = DB::table('STD.TRABAJADOR')
        ->select('COD_ZONA_TIPO')
        ->where('COD_TRAB', $usuario_logueado_id)
        ->first();
     
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

        return view('valerendir.ajax.modalvalerendiraprueba', [
            'listausuarios' => $combo,
            'listausuarios1' => $combo1,
            'listausuarios2' => $combo2,
            'listarusuarios' => $listarusuarios,
            'usuario_logueado_id' => $usuario_logueado_id,
            'usuario_merge' => $usuario_merge,
            'perfil_administracion' => $perfil_administracion,
            'trabajadorCentro' => $trabajadorCentro,
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
        $txt_glosa_aprobado = $request->input('txt_glosa_aprobado');
        
        
        $cod_categoria_estado_vale = 'ETM0000000000007';  
        $txt_categoria_estado_vale = 'APROBADO'; 

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
                $vale->TIPO_PAGO,
                '',
                $txt_glosa_autorizado,
                '',
                $txt_glosa_aprobado,
                0.0, 
                0.0,
                $vale->TXT_CATEGORIA_BANCO,
                $vale->NRO_CUENTA,
                $cod_categoria_estado_vale,
                $txt_categoria_estado_vale, 
                '',
                '',
                false,
                Session::get('usuario')->id 
            );

            DB::table('WEB.VALE_RENDIR')
                ->where('ID', $id_buscar)
                ->update([
                    'USUARIO_APRUEBA'  => $usuario_logueado_id,
                    'TXT_NOM_APRUEBA'  => $usuario_nombre_logueado_id,
                ]);

             $this->actionInsertValeRendirOsiris($request);

        return response()->json(['success' => 'Vale de rendir aprobado correctamente.']);
    }


     public function actionRechazarValeRendir(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 

        $cod_categoria_estado_vale = 'ETM0000000000006';  
        $txt_categoria_estado_vale = 'RECHAZADO'; 
        $vale = WEBValeRendir::where('ID', $id_buscar)->first();

        $valerendir_id = $request->input('valerendir_id');

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
                $vale->TIPO_PAGO,
                '',
                '',
                '',
                $txt_glosa_rechazado, 
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


        $simbolo_moneda = '';
        if ($cod_moneda == 'MON0000000000001') {
            $simbolo_moneda = 'S/';
        } elseif ($cod_moneda == 'MON0000000000002') {
            $simbolo_moneda = '$';
        }

        $centrovale = $txtNombreCliente->COD_CENTRO;
        $conexionbd = 'sqlsrv';
            if ($centrovale == 'CEN0000000000004') {
                $conexionbd = 'sqlsrv_r';
            } elseif ($centrovale == 'CEN0000000000006') {
                $conexionbd = 'sqlsrv_b';
            }

        $contrato_diferente = DB::connection($conexionbd)
                            ->table('CMP.CONTRATO')
                            ->where('COD_EMPR', $cod_empr)
                            ->where('COD_CATEGORIA_TIPO_CONTRATO', 'TCO0000000000069')
                            ->where('COD_EMPR_CLIENTE', $codemprcliente)
                            ->where('COD_CATEGORIA_MONEDA', $cod_moneda)
                            ->select(
                                'COD_CONTRATO',
                                DB::raw("CONCAT(
                                    LEFT(COD_CONTRATO, 6), '-', 
                                    RIGHT(CONCAT('00000', RIGHT(COD_CONTRATO, 5)), 5), 
                                    ' - {$simbolo_moneda} ', 
                                    REPLACE(TXT_CATEGORIA_CANAL_VENTA, 'POR', 'X')
                                ) AS CUENTA")
                            )
                            ->pluck('CUENTA', 'COD_CONTRATO')
                            ->toArray();

        $combo_series = $notacredito->combo_series_tipodocumento('TDO0000000000072');
      
     
        $ultimoCorrelativo = DB::connection($conexionbd)
        ->table('TES.AUTORIZACION')
        ->where('TXT_SERIE', $combo_series)
        ->where('COD_TIPO_DOCUMENTO', 'TDO0000000000072')
        ->where('COD_CENTRO', $centrovale)
        ->max('TXT_NUMERO');

        //   dd($contrato_diferente);

        $nro_documento = is_null($ultimoCorrelativo) ? 1:$ultimoCorrelativo + 1;
        $nro_documento_formateado = str_pad($nro_documento, 10, '0', STR_PAD_LEFT);

        $fecha_actual = date('Y-m-d');

      
        $subcuentas = DB::connection($conexionbd)
                    ->table('CMP.CONTRATO AS CON')
                    ->join('CMP.CONTRATO_CULTIVO AS CUL', 'CON.COD_CONTRATO', '=', 'CUL.COD_CONTRATO')
                    ->where('CON.COD_EMPR', $cod_empr)
                    ->where('CON.COD_CATEGORIA_TIPO_CONTRATO', 'TCO0000000000069')
                    ->where('CON.COD_EMPR_CLIENTE', $codemprcliente)
                    ->select(
                        'CON.COD_CONTRATO',
                        DB::raw("CONCAT(CUL.TXT_ZONA_COMERCIAL, '-', CUL.TXT_ZONA_CULTIVO) AS SUBCUENTA")
                    )
                    ->pluck('SUBCUENTA', 'COD_CONTRATO')
                    ->toArray();

       


        return view('valerendir.ajax.modalosirisvalerendiraprueba', [
            'txtNombreCliente' => $txtNombreCliente->TXT_NOM_SOLICITA,
            'contrato_diferente' => $contrato_diferente,
            'combo_series' =>$combo_series,
            'fecha_actual' => $fecha_actual,
            'subcuentas' => $subcuentas,
            'estado' => $txt_categoria_estado_vale,
            'nro_documento_formateado' => $nro_documento_formateado,
            'glosaCliente' => $glosaCliente,
            'cod_moneda' =>$txtNombreCliente->COD_MONEDA,
            'ajax'=>true,
        ]);                     
    }


    public function actionInsertValeRendirOsiris(Request $request) { 
        $id_buscar = $request->input('valerendir_id'); 
        $can_tipo_cambio = DB::table('cmp.TIPO_CAMBIO')
                                        ->where('FEC_CAMBIO', DB::raw("(SELECT MAX(FEC_CAMBIO) FROM cmp.TIPO_CAMBIO)"))
                                        ->value('CAN_COMPRA');

        $valeRendirOsiris       =   WEBValeRendir::where('ID', $id_buscar)->first();

        $cod_usuario_registro = DB::table('users')
        ->where('id', $valeRendirOsiris->COD_USUARIO_MODIF_AUD)
        ->value('name');


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
        $cod_usuario_registro;
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
        $cod_moneda = $valeRendirOsiris->COD_MONEDA;
        $id_osiris = $valeRendirOsiris->ID_OSIRIS;

        $simbolo = $cod_moneda == 'MON0000000000001' ? 'S/.' : '$';

        $contrato_descripcion = CMPContrato::where('COD_CONTRATO', $cod_contrato)
            ->select(DB::raw("
                CONCAT(
                    LEFT(COD_CONTRATO, 6), '-', 
                    RIGHT(CONCAT('00000', RIGHT(COD_CONTRATO, 5)), 5), 
                    ' - ', '$simbolo', ' ',
                    REPLACE(TXT_CATEGORIA_CANAL_VENTA, 'POR', 'X')
                ) AS CUENTA
            "))
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
             'cod_moneda' => $cod_moneda,
             'id_osiris' => $id_osiris,
             'ajax'=>true,
        ]);           
    }


       public function actionVerDetalleImporte(Request $request)
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
        $txt_glosa = $vale->first()->TXT_GLOSA ?? null;
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
    
 




