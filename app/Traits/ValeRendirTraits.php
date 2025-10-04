<?php

namespace App\Traits;

use App\Modelos\WEBValeRendir;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, App\CMPCategoria;
use App\Modelos\STDTrabajadorVale;
use App\User;
use Session;
use PDO;

trait ValeRendirTraits
{

    public function insertValeRendir($ind_tipo_operacion, $id, $fec_autorizacion, $txt_serie, $txt_numero , $cod_empr, $cod_centro, $cod_empr_cli, 
                                     $txt_nom_solicita, $usuario_autoriza, $txt_nom_autoriza, $usuario_aprueba, $txt_nom_aprueba, $cod_contrato, 
                                     $sub_cuenta, $tipo_motivo, $cod_moneda, $tipo_pago, $txt_glosa, $txt_glosa_autorizado,  $txt_glosa_rechazado, $txt_glosa_aprobado, 
                                     $can_total_importe, $can_total_saldo, $txt_categoria_banco, $numero_cuenta, $cod_categoria_estado_vale, 
                                     $txt_categoria_estado_vale, $cod_estado, $cod_usuario_registro)

    {
         try {
                  $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_RENDIR_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID = ?,
                                                                        @FEC_AUTORIZACION = ?,
                                                                        @TXT_SERIE = ?,
                                                                        @TXT_NUMERO = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_EMPR_CLIENTE = ?,
                                                                        @TXT_NOM_SOLICITA =?,
                                                                        @USUARIO_AUTORIZA = ?,
                                                                        @TXT_NOM_AUTORIZA = ?,
                                                                        @USUARIO_APRUEBA = ?,
                                                                        @TXT_NOM_APRUEBA = ?,
                                                                        @COD_CONTRATO = ?,
                                                                        @SUB_CUENTA = ?,
                                                                        @TIPO_MOTIVO = ?,
                                                                        @COD_MONEDA = ?,
                                                                        @TIPO_PAGO = ?,
                                                                        @TXT_GLOSA = ?,
                                                                        @TXT_GLOSA_AUTORIZADO = ?,
                                                                        @TXT_GLOSA_RECHAZADO = ?,
                                                                        @TXT_GLOSA_APROBADO = ?,
                                                                        @CAN_TOTAL_IMPORTE = ?,
                                                                        @CAN_TOTAL_SALDO = ?,
                                                                        @TXT_CATEGORIA_BANCO = ?,
                                                                        @NRO_CUENTA = ?,
                                                                        @COD_CATEGORIA_ESTADO_VALE = ?,
                                                                        @TXT_CATEGORIA_ESTADO_VALE = ?,
                                                                        @COD_ESTADO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

                 $cod_usuario_registro = Session::get('usuario')->id;
                 $cod_empr = Session::get('empresas')->COD_EMPR;
                 
               $trabajador     =   DB::table('STD.TRABAJADOR')
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
            

                 $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                 $stmt->bindParam(2, $id, PDO::PARAM_STR);
                 $stmt->bindParam(3, $fec_autorizacion, PDO::PARAM_STR);
                 $stmt->bindParam(4, $txt_serie, PDO::PARAM_STR);
                 $stmt->bindParam(5, $txt_numero, PDO::PARAM_STR);
                 $stmt->bindParam(6, $cod_empr, PDO::PARAM_STR);
                 $stmt->bindParam(7, $cod_centro, PDO::PARAM_STR);
                 $stmt->bindParam(8, $cod_empr_cli, PDO::PARAM_STR);
                 $stmt->bindParam(9, $txt_nom_solicita, PDO::PARAM_STR);
                 $stmt->bindParam(10, $usuario_autoriza, PDO::PARAM_STR);
                 $stmt->bindParam(11, $txt_nom_autoriza, PDO::PARAM_STR);
                 $stmt->bindParam(12, $usuario_aprueba, PDO::PARAM_STR);
                 $stmt->bindParam(13, $txt_nom_aprueba, PDO::PARAM_STR);
                 $stmt->bindParam(14, $cod_contrato, PDO::PARAM_STR);
                 $stmt->bindParam(15, $sub_cuenta, PDO::PARAM_STR);
                 $stmt->bindParam(16, $tipo_motivo, PDO::PARAM_STR);
                 $stmt->bindParam(17, $cod_moneda, PDO::PARAM_STR);
                 $stmt->bindParam(18, $tipo_pago, PDO::PARAM_STR);
                 $stmt->bindParam(19, $txt_glosa, PDO::PARAM_STR);
                 $stmt->bindParam(20, $txt_glosa_autorizado, PDO::PARAM_STR);
                 $stmt->bindParam(21, $txt_glosa_rechazado, PDO::PARAM_STR);
                 $stmt->bindParam(22, $txt_glosa_aprobado, PDO::PARAM_STR);
                 $stmt->bindParam(23, $can_total_importe, PDO::PARAM_STR);
                 $stmt->bindParam(24, $can_total_saldo, PDO::PARAM_STR);
                 $stmt->bindParam(25, $txt_categoria_banco, PDO::PARAM_STR);
                 $stmt->bindParam(26, $numero_cuenta, PDO::PARAM_STR);
                 $stmt->bindParam(27, $cod_categoria_estado_vale, PDO::PARAM_STR);
                 $stmt->bindParam(28, $txt_categoria_estado_vale, PDO::PARAM_STR);
                 $stmt->bindParam(29, $cod_estado, PDO::PARAM_BOOL);
                 $stmt->bindParam(30, $cod_usuario_registro, PDO::PARAM_STR);


                $stmt->execute();

         } catch (\Exception $e) {
        Log::error('Error al insertar el vale rendir: ' . $e->getMessage());
        throw $e; 
      }
    }



     public function insertValeRendirAutoApruebaRechaza($ind_tipo_operacion, $id, $fec_autorizacion, $txt_serie, $txt_numero , $cod_empr, $cod_centro, $cod_empr_cli, 
                                     $txt_nom_solicita, $usuario_autoriza, $txt_nom_autoriza, $usuario_aprueba, $txt_nom_aprueba, $cod_contrato, 
                                     $sub_cuenta, $tipo_motivo, $cod_moneda, $tipo_pago, $txt_glosa, $txt_glosa_autorizado,  $txt_glosa_rechazado, $txt_glosa_aprobado, 
                                     $can_total_importe, $can_total_saldo, $txt_categoria_banco, $numero_cuenta, $cod_categoria_estado_vale, 
                                     $txt_categoria_estado_vale, $cod_estado, $cod_usuario_registro)

    {
         try {
                  $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_RENDIR_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID = ?,
                                                                        @FEC_AUTORIZACION = ?,
                                                                        @TXT_SERIE = ?,
                                                                        @TXT_NUMERO = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_EMPR_CLIENTE = ?,
                                                                        @TXT_NOM_SOLICITA =?,
                                                                        @USUARIO_AUTORIZA = ?,
                                                                        @TXT_NOM_AUTORIZA = ?,
                                                                        @USUARIO_APRUEBA = ?,
                                                                        @TXT_NOM_APRUEBA = ?,
                                                                        @COD_CONTRATO = ?,
                                                                        @SUB_CUENTA = ?,
                                                                        @TIPO_MOTIVO = ?,
                                                                        @COD_MONEDA = ?,
                                                                        @TIPO_PAGO = ?,
                                                                        @TXT_GLOSA = ?,
                                                                        @TXT_GLOSA_AUTORIZADO = ?,
                                                                        @TXT_GLOSA_RECHAZADO = ?,
                                                                        @TXT_GLOSA_APROBADO = ?,
                                                                        @CAN_TOTAL_IMPORTE = ?,
                                                                        @CAN_TOTAL_SALDO = ?,
                                                                        @TXT_CATEGORIA_BANCO = ?,
                                                                        @NRO_CUENTA = ?,
                                                                        @COD_CATEGORIA_ESTADO_VALE = ?,
                                                                        @TXT_CATEGORIA_ESTADO_VALE = ?,
                                                                        @COD_ESTADO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

                 $cod_usuario_registro = Session::get('usuario')->id;
                 $cod_empr = Session::get('empresas')->COD_EMPR;
                 
              
                 $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                 $stmt->bindParam(2, $id, PDO::PARAM_STR);
                 $stmt->bindParam(3, $fec_autorizacion, PDO::PARAM_STR);
                 $stmt->bindParam(4, $txt_serie, PDO::PARAM_STR);
                 $stmt->bindParam(5, $txt_numero, PDO::PARAM_STR);
                 $stmt->bindParam(6, $cod_empr, PDO::PARAM_STR);
                 $stmt->bindParam(7, $cod_centro, PDO::PARAM_STR);
                 $stmt->bindParam(8, $cod_empr_cli, PDO::PARAM_STR);
                 $stmt->bindParam(9, $txt_nom_solicita, PDO::PARAM_STR);
                 $stmt->bindParam(10, $usuario_autoriza, PDO::PARAM_STR);
                 $stmt->bindParam(11, $txt_nom_autoriza, PDO::PARAM_STR);
                 $stmt->bindParam(12, $usuario_aprueba, PDO::PARAM_STR);
                 $stmt->bindParam(13, $txt_nom_aprueba, PDO::PARAM_STR);
                 $stmt->bindParam(14, $cod_contrato, PDO::PARAM_STR);
                 $stmt->bindParam(15, $sub_cuenta, PDO::PARAM_STR);
                 $stmt->bindParam(16, $tipo_motivo, PDO::PARAM_STR);
                 $stmt->bindParam(17, $cod_moneda, PDO::PARAM_STR);
                 $stmt->bindParam(18, $tipo_pago, PDO::PARAM_STR);
                 $stmt->bindParam(19, $txt_glosa, PDO::PARAM_STR);
                 $stmt->bindParam(20, $txt_glosa_autorizado, PDO::PARAM_STR);
                 $stmt->bindParam(21, $txt_glosa_rechazado, PDO::PARAM_STR);
                 $stmt->bindParam(22, $txt_glosa_aprobado, PDO::PARAM_STR);
                 $stmt->bindParam(23, $can_total_importe, PDO::PARAM_STR);
                 $stmt->bindParam(24, $can_total_saldo, PDO::PARAM_STR);
                 $stmt->bindParam(25, $txt_categoria_banco, PDO::PARAM_STR);
                 $stmt->bindParam(26, $numero_cuenta, PDO::PARAM_STR);
                 $stmt->bindParam(27, $cod_categoria_estado_vale, PDO::PARAM_STR);
                 $stmt->bindParam(28, $txt_categoria_estado_vale, PDO::PARAM_STR);
                 $stmt->bindParam(29, $cod_estado, PDO::PARAM_BOOL);
                 $stmt->bindParam(30, $cod_usuario_registro, PDO::PARAM_STR);


                $stmt->execute();

         } catch (\Exception $e) {
        Log::error('Error al insertar el vale rendir: ' . $e->getMessage());
        throw $e; 
      }
    }




    public function insertValeRendirOsiris($ind_tipo_operacion, $id, $cod_empr, $cod_centro, $cod_empresa, $txt_empresa, 
                                              $cod_contrato, $cod_cultivo, $fec_autorizacion, $cod_tra_autoriza, 
                                              $txt_tra_autoriza, $cod_tipo_documento, $txt_tipo_documento, $txt_serie, $txt_numero, 
                                              $cod_categoria_moneda, $txt_categoria_moneda, $can_tipo_cambio, $can_total, 
                                              $can_saldo, $cod_tipo_estado, $txt_tipo_estado, $cod_estado, $cod_usuario_registro, 
                                              $txt_glosa, $cod_centro_costo,
                                              $cod_centro_gasto, $ind_ms)
    {
       $conexionbd = 'sqlsrv';
        if($cod_centro == 'CEN0000000000004'){
            $conexionbd = 'sqlsrv_r';
        }else{
            if($cod_centro == 'CEN0000000000006'){
                $conexionbd = 'sqlsrv_b';
            }
        }

        try {
           
            $stmt = DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON; EXEC TES.AUTORIZACION_IUD
                                                                    @IND_TIPO_OPERACION = ?,
                                                                    @COD_AUTORIZACION = ?,
                                                                    @COD_EMPR = ?,
                                                                    @COD_CENTRO = ?,
                                                                    @COD_EMPRESA = ?,
                                                                    @TXT_EMPRESA = ?,
                                                                    @COD_CONTRATO = ?,
                                                                    @COD_CULTIVO = ?,
                                                                    @FEC_AUTORIZACION = ?,
                                                                    @COD_TRABAJADOR_AUTORIZA = ?,
                                                                    @TXT_TRABAJADOR_AUTORIZA = ?,
                                                                    @COD_TIPO_DOCUMENTO = ?,
                                                                    @TXT_TIPO_DOCUMENTO = ?,
                                                                    @TXT_SERIE = ?,
                                                                    @TXT_NUMERO = ?,
                                                                    @COD_CATEGORIA_MONEDA = ?,
                                                                    @TXT_CATEGORIA_MONEDA = ?,
                                                                    @CAN_TIPO_CAMBIO = ?,
                                                                    @CAN_TOTAL = ?,
                                                                    @CAN_SALDO = ?,
                                                                    @COD_TIPO_ESTADO = ?,
                                                                    @TXT_TIPO_ESTADO = ?,
                                                                    @COD_ESTADO = ?,
                                                                    @COD_USUARIO_REGISTRO = ?,
                                                                    @TXT_GLOSA = ?,
                                                                    @COD_CENTROCOSTO = ?,
                                                                    @COD_CENTROGASTO = ?,
                                                                    @IND_MS = ?');

           
            $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
            $stmt->bindParam(2, $id, PDO::PARAM_STR);
            $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
            $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
            $stmt->bindParam(5, $cod_empresa, PDO::PARAM_STR); 
            $stmt->bindParam(6, $txt_empresa, PDO::PARAM_STR); 
            $stmt->bindParam(7, $cod_contrato, PDO::PARAM_STR); 
            $stmt->bindParam(8, $cod_cultivo, PDO::PARAM_STR); 
            $stmt->bindParam(9, $fec_autorizacion, PDO::PARAM_STR); 
            $stmt->bindParam(10, $cod_tra_autoriza, PDO::PARAM_STR); 
            $stmt->bindParam(11, $txt_tra_autoriza, PDO::PARAM_STR); 
            $stmt->bindParam(12, $cod_tipo_documento, PDO::PARAM_STR); 
            $stmt->bindParam(13, $txt_tipo_documento, PDO::PARAM_STR); 
            $stmt->bindParam(14, $txt_serie, PDO::PARAM_STR); 
            $stmt->bindParam(15, $txt_numero, PDO::PARAM_STR); 
            $stmt->bindParam(16, $cod_categoria_moneda, PDO::PARAM_STR); 
            $stmt->bindParam(17, $txt_categoria_moneda, PDO::PARAM_STR); 
            $stmt->bindParam(18, $can_tipo_cambio, PDO::PARAM_STR);
            $stmt->bindParam(19, $can_total, PDO::PARAM_STR); 
            $stmt->bindParam(20, $can_saldo, PDO::PARAM_STR); 
            $stmt->bindParam(21, $cod_tipo_estado, PDO::PARAM_STR); 
            $stmt->bindParam(22, $txt_tipo_estado, PDO::PARAM_STR); 
            $stmt->bindParam(23, $cod_estado, PDO::PARAM_STR); 
            $stmt->bindParam(24, $cod_usuario_registro, PDO::PARAM_STR); 
            $stmt->bindParam(25, $txt_glosa, PDO::PARAM_STR); 
            $stmt->bindParam(26, $cod_centro_costo, PDO::PARAM_STR); 
            $stmt->bindParam(27, $cod_centro_gasto, PDO::PARAM_STR); 
            $stmt->bindParam(28, $ind_ms, PDO::PARAM_STR); 

 // $stmt->bindParam(2, $codorden[0]  ,PDO::PARAM_STR); 
            
            $stmt->execute();
            $codorden = $stmt->fetch();

            return $codorden[0];

            } catch (\Exception $e) {
            Log::error('Error al insertar el vale rendir: ' . $e->getMessage());
            throw $e; 
        }
    }


    public function insertValeRendirDetalle($ind_tipo_operacion, $id, $fec_inicio, $fec_fin, $cod_empr, $cod_centro, $cod_destino, $nom_destino, $nom_tipos, $dias, $can_unitario, $can_unitario_total, $can_total_importe,  $ind_destino, $ind_propio , $ind_aereo, $cod_estado, $cod_usuario_registro)

    {


         try {

            
                  $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_RENDIR_DETALLE_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID = ?,
                                                                        @FEC_INICIO = ?,
                                                                        @FEC_FIN = ?, 
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_DESTINO = ?,
                                                                        @NOM_DESTINO = ?,
                                                                        @NOM_TIPOS = ?,
                                                                        @DIAS = ?,
                                                                        @CAN_UNITARIO = ?,
                                                                        @CAN_UNITARIO_TOTAL = ?,
                                                                        @CAN_TOTAL_IMPORTE = ?,
                                                                        @IND_DESTINO = ?,
                                                                        @IND_PROPIO = ?,
                                                                        @IND_AEREO = ?,
                                                                        @COD_ESTADO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

                 $cod_usuario_registro = Session::get('usuario')->id;
                 $cod_empr = Session::get('empresas')->COD_EMPR;
                $trabajador     =   DB::table('STD.TRABAJADOR')
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

                $fec_inicio = !empty($fec_inicio) ? date("Ymd H:i:s", strtotime($fec_inicio)) : null;
                $fec_fin    = !empty($fec_fin)    ? date("Ymd H:i:s", strtotime($fec_fin))    : null;


                 $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                 $stmt->bindParam(2, $id, PDO::PARAM_STR);
                 $stmt->bindValue(3, $fec_inicio, $fec_inicio ? PDO::PARAM_STR : PDO::PARAM_NULL);
                 $stmt->bindValue(4, $fec_fin,    $fec_fin    ? PDO::PARAM_STR : PDO::PARAM_NULL);
                 $stmt->bindParam(5, $cod_empr, PDO::PARAM_STR);
                 $stmt->bindParam(6, $cod_centro, PDO::PARAM_STR);
                 $stmt->bindParam(7, $cod_destino, PDO::PARAM_STR);
                 $stmt->bindParam(8, $nom_destino, PDO::PARAM_STR);
                 $stmt->bindParam(9, $nom_tipos, PDO::PARAM_STR);
                 $stmt->bindParam(10, $dias, PDO::PARAM_STR);
                 $stmt->bindParam(11, $can_unitario, PDO::PARAM_STR);
                 $stmt->bindParam(12, $can_unitario_total, PDO::PARAM_STR);
                 $stmt->bindParam(13, $can_total_importe, PDO::PARAM_STR);
                 $stmt->bindParam(14, $ind_destino, PDO::PARAM_BOOL);
                 $stmt->bindParam(15, $ind_propio, PDO::PARAM_BOOL);
                 $stmt->bindParam(16, $ind_aereo, PDO::PARAM_BOOL);
                 $stmt->bindParam(17, $cod_estado, PDO::PARAM_BOOL);
                 $stmt->bindParam(18, $cod_usuario_registro, PDO::PARAM_STR);


                $stmt->execute();

         } catch (\Exception $e) {
        Log::error('Error al insertar el vale rendir detalle: ' . $e->getMessage());
        throw $e; 
      }
    }

     public function listaValeRendir($ind_tipo_operacion, $id, $cod_empr, $cod_centro, $usuario_autoriza, $usuario_aprueba, $tipo_motivo,
                                      $txt_glosa, $can_total_importe, $can_total_saldo, $cod_usuario_registro)
    {
        $array_lista_retail = array();

        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;
       $trabajador     =   DB::table('STD.TRABAJADOR')
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
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_RENDIR_LISTAR

                                                             @IND_TIPO_OPERACION = ?,
                                                             @ID = ?, 
                                                             @COD_EMPR = ?,
                                                             @COD_CENTRO = ?,
                                                             @USUARIO_AUTORIZA = ?,
                                                             @USUARIO_APRUEBA = ?,
                                                             @TIPO_MOTIVO = ?,
                                                             @TXT_GLOSA = ?,
                                                             @CAN_TOTAL_IMPORTE = ?,
                                                             @CAN_TOTAL_SALDO = ?,
                                                             @COD_USUARIO = ?');


                    $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                    $stmt->bindParam(2, $id, PDO::PARAM_STR);
                    $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
                    $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
                    $stmt->bindParam(5, $usuario_autoriza, PDO::PARAM_STR);
                    $stmt->bindParam(6, $usuario_aprueba, PDO::PARAM_STR);
                    $stmt->bindParam(7, $tipo_motivo, PDO::PARAM_STR);
                    $stmt->bindParam(8, $txt_glosa, PDO::PARAM_STR);
                    $stmt->bindParam(9, $can_total_importe, PDO::PARAM_STR);
                    $stmt->bindParam(10, $can_total_saldo, PDO::PARAM_STR);
                    $stmt->bindParam(11, $cod_usuario_registro, PDO::PARAM_STR);

                    $stmt->execute();
                                          
                    while ($row = $stmt->fetch()){
                      array_push($array_lista_retail, $row);
                    }

        return $array_lista_retail;
    }

   public function listaValeRendirDetalle($ind_tipo_operacion, $id, $cod_empr, $cod_centro, $cod_destino,
                                      $nom_destino, $nom_tipos, $dias, $can_unitario, $can_unitario_total, $can_total_importe, $cod_usuario_registro)  
    {
        $array_lista_retail = array();

        
        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;
        $trabajador     =   DB::table('STD.TRABAJADOR')
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
        
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_RENDIR_DETALLE_LISTAR
                                                             @IND_TIPO_OPERACION = ?,
                                                             @ID = ?, 
                                                             @COD_EMPR = ?,
                                                             @COD_CENTRO = ?,
                                                             @COD_DESTINO = ?,
                                                             @NOM_DESTINO = ?,
                                                             @NOM_TIPOS = ?,
                                                             @DIAS = ?,
                                                             @CAN_UNITARIO = ?,
                                                             @CAN_UNITARIO_TOTAL = ?,
                                                             @CAN_TOTAL_IMPORTE = ?,
                                                             @COD_USUARIO = ?');

        $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_STR);
        $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
        $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
        $stmt->bindParam(5, $cod_destino, PDO::PARAM_STR);
        $stmt->bindParam(6, $nom_destino, PDO::PARAM_STR);
        $stmt->bindParam(7, $nom_tipos, PDO::PARAM_STR);
        $stmt->bindParam(8, $dias, PDO::PARAM_STR);
        $stmt->bindParam(9, $can_unitario, PDO::PARAM_STR);
        $stmt->bindParam(10, $can_unitario_total, PDO::PARAM_STR);
        $stmt->bindParam(11, $can_total_importe, PDO::PARAM_STR);
        $stmt->bindParam(12, $cod_usuario_registro, PDO::PARAM_STR);

        $stmt->execute();

        while ($row = $stmt->fetch()) {
            array_push($array_lista_retail, $row);
        }

        return $array_lista_retail;
    }


    public function listaValeRendirAutoriza($ind_tipo_operacion, $id, $cod_empr, $cod_centro, $usuario_autoriza, $usuario_aprueba, $tipo_motivo,
                                             $txt_glosa, $can_total_importe, $can_total_saldo, $cod_usuario_registro)
    {
        /*$array_lista_retail = array();

        $cod_usuario_registro = "";

        $usuario = User::where('id', Session::get('usuario')->id)->get();
        $usuario_autoriza = $usuario->get(0)->usuarioosiris_id;

        $cod_empr = Session::get('empresas')->COD_EMPR;
        
        $trabajador = DB::table('STD.TRABAJADOR')
                        ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                        ->first();

            $centro_id = '';

            if ($trabajador) {
                $empresa = DB::table('STD.EMPRESA')
                            ->where('COD_EMPR', $trabajador->COD_EMPR)
                            ->first();

                if ($empresa) {
                    $centro_id = $empresa->COD_CENTRO_SISTEMA; 
                }
            }

            $centrot = DB::table('ALM.CENTRO')
                        ->where('COD_CENTRO', $centro_id)
                        ->first();


                $cod_centro = $centrot->COD_CENTRO;
                $nom_centro = $centrot->NOM_CENTRO;*/


        $array_lista_retail = array();

        $cod_usuario_registro = "";

        $usuario = User::where('id', Session::get('usuario')->id)->get();
        $usuario_aprueba = $usuario->get(0)->usuarioosiris_id;

        $cod_empr = Session::get('empresas')->COD_EMPR;
   
        $cod_centro = '';


        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_RENDIR_LISTAR

                                                             @IND_TIPO_OPERACION = ?,
                                                             @ID = ?, 
                                                             @COD_EMPR = ?,
                                                             @COD_CENTRO = ?,
                                                             @USUARIO_AUTORIZA = ?,
                                                             @USUARIO_APRUEBA = ?,
                                                             @TIPO_MOTIVO = ?,
                                                             @TXT_GLOSA = ?,
                                                             @CAN_TOTAL_IMPORTE = ?,
                                                             @CAN_TOTAL_SALDO = ?,
                                                             @COD_USUARIO = ?');


                    $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                    $stmt->bindParam(2, $id, PDO::PARAM_STR);
                    $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
                    $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
                    $stmt->bindParam(5, $usuario_autoriza, PDO::PARAM_STR);              
                    $stmt->bindParam(6, $usuario_aprueba, PDO::PARAM_STR);                
                    $stmt->bindParam(7, $tipo_motivo, PDO::PARAM_STR);
                    $stmt->bindParam(8, $txt_glosa, PDO::PARAM_STR);
                    $stmt->bindParam(9, $can_total_importe, PDO::PARAM_STR);
                    $stmt->bindParam(10, $can_total_saldo, PDO::PARAM_STR);
                    $stmt->bindParam(11, $cod_usuario_registro, PDO::PARAM_STR);

                    $stmt->execute();
                                          
                    while ($row = $stmt->fetch()){
                      array_push($array_lista_retail, $row);
                    }

        return $array_lista_retail;
    }





     public function listaValeRendirAprueba($ind_tipo_operacion, $id, $cod_empr, $cod_centro, $usuario_autoriza, $usuario_aprueba, $tipo_motivo,
                                    $txt_glosa, $can_total_importe, $can_total_saldo, $cod_usuario_registro)
    {
        $array_lista_retail = array();

        $cod_usuario_registro = "";

        $usuario = User::where('id', Session::get('usuario')->id)->get();
        $usuario_aprueba = $usuario->get(0)->usuarioosiris_id;

        $cod_empr = Session::get('empresas')->COD_EMPR;

        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;


        $trabajadorCentro = DB::table('STD.TRABAJADOR')
        ->select('COD_ZONA_TIPO')
        ->where('COD_TRAB', $usuario_logueado_id)
        ->first();
   
        $cod_centro = $trabajadorCentro->COD_ZONA_TIPO;
       


        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_RENDIR_LISTAR

                                                             @IND_TIPO_OPERACION = ?,
                                                             @ID = ?, 
                                                             @COD_EMPR = ?,
                                                             @COD_CENTRO = ?,
                                                             @USUARIO_AUTORIZA = ?,
                                                             @USUARIO_APRUEBA = ?,
                                                             @TIPO_MOTIVO = ?,
                                                             @TXT_GLOSA = ?,
                                                             @CAN_TOTAL_IMPORTE = ?,
                                                             @CAN_TOTAL_SALDO = ?,
                                                             @COD_USUARIO = ?');


                    $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                    $stmt->bindParam(2, $id, PDO::PARAM_STR);
                    $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
                    $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
                    $stmt->bindParam(5, $usuario_autoriza, PDO::PARAM_STR);
                    $stmt->bindParam(6, $usuario_aprueba, PDO::PARAM_STR);
                    $stmt->bindParam(7, $tipo_motivo, PDO::PARAM_STR);
                    $stmt->bindParam(8, $txt_glosa, PDO::PARAM_STR);
                    $stmt->bindParam(9, $can_total_importe, PDO::PARAM_STR);
                    $stmt->bindParam(10, $can_total_saldo, PDO::PARAM_STR);
                    $stmt->bindParam(11, $cod_usuario_registro, PDO::PARAM_STR);

                    $stmt->execute();
                                          
                    while ($row = $stmt->fetch()){
                      array_push($array_lista_retail, $row);
                    }

        return $array_lista_retail;
    }

      public function listaValeRendirPendientes($cod_usuario_crea)
    {
        
        $array_lista_retail = array();
        $cod_usuario_registro = "";

        $usuario = User::where('id', Session::get('usuario')->id)->get();
        $cod_empr = Session::get('empresas')->COD_EMPR;
        $cod_centro = '';


        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_RENDIR_PENDIENTES

                                                             @COD_USUARIO_CREA = ?');


                    $stmt->bindParam(1, $cod_usuario_crea, PDO::PARAM_STR);

                    $stmt->execute();
                                          
                    while ($row = $stmt->fetch()){
                      array_push($array_lista_retail, $row);
                    }

        return $array_lista_retail;
    }


    public function listaLiquidacionesPendientes($cod_usuario_crea)
        {
            
            $array_lista_retail = array();
            $cod_usuario_registro = "";

            $usuario = User::where('id', Session::get('usuario')->id)->get();
            $cod_empr = Session::get('empresas')->COD_EMPR;
            $cod_centro = '';


            $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.LIQUIDACIONES_SIN_PROCESAR

                                                                 @COD_USUARIO_CREA = ?');


                        $stmt->bindParam(1, $cod_usuario_crea, PDO::PARAM_STR);

                        $stmt->execute();
                                              
                        while ($row = $stmt->fetch()){
                          array_push($array_lista_retail, $row);
                        }

            return $array_lista_retail;
        }

      public function listaDocumentoXML_CDR($cod_empr, $cod_usuario_crea)
    {
        
        $array_lista_retail = array();
        $cod_usuario_registro = "";

        $usuario = User::where('id', Session::get('usuario')->id)->get();
        $cod_empr = Session::get('empresas')->COD_EMPR;
        $cod_centro = '';


        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.DOCUMENTO_XML_CDR

                                                             @COD_EMPRESA = ?,
                                                             @COD_USUARIO_CREA = ?');


                    $stmt->bindParam(1, $cod_empr, PDO::PARAM_STR);
                    $stmt->bindParam(2, $cod_usuario_crea, PDO::PARAM_STR);

                    $stmt->execute();
                                          
                    while ($row = $stmt->fetch()){
                      array_push($array_lista_retail, $row);
                    }

        return $array_lista_retail;
    }

      public function listaNegraProveedores($cod_empr)
    {
        
        $array_lista_retail = array();
        $cod_usuario_registro = "";

        $usuario = User::where('id', Session::get('usuario')->id)->get();
        $cod_empr = Session::get('empresas')->COD_EMPR;
        $cod_centro = '';


        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.PROVEEDOR_LISTA_NEGRA

                                                             @COD_EMPRESA = ?');


                    $stmt->bindParam(1, $cod_empr, PDO::PARAM_STR);

                    $stmt->execute();
                                          
                    while ($row = $stmt->fetch()){
                      array_push($array_lista_retail, $row);
                    }

        return $array_lista_retail;
    }


    public function  valependientesrendir($cod_usuario_crea)
        {
            
            $array_lista_retail = array();
            $cod_usuario_registro = "";

            $usuario = User::where('id', Session::get('usuario')->id)->get();
            $cod_empr = Session::get('empresas')->COD_EMPR;
            $cod_centro = '';


            $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_PENDIENTES_RENDIR

                                                                 @COD_USUARIO_CREA = ?');


                        $stmt->bindParam(1, $cod_usuario_crea, PDO::PARAM_STR);

                        $stmt->execute();
                                              
                        while ($row = $stmt->fetch()){
                          array_push($array_lista_retail, $row);
                        }

            return $array_lista_retail;
        }
}


