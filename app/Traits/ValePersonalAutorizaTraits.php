<?php

namespace App\Traits;

use App\Modelos\WEBRegistroValePersonalAutoriza;  
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, App\CMPCategoria;
use App\Traits\STDTrabajadorVale;
use App\User;
use Session;
use PDO;


trait ValePersonalAutorizaTraits
{

    public function insertRegistroPersonalAutoriza($ind_tipo_operacion, $id, $cod_empr, $cod_centro, $cod_personal, $txt_personal, $cod_gerencia, $txt_gerencia, $cod_area, $txt_area, $cod_cargo, $txt_cargo, $cod_autoriza,  $txt_autoriza, $cod_linea, $txt_linea ,$cod_estado, $cod_usuario_registro)

    {
         try {
                  $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_PERSONAL_AUTORIZA_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_PERSONAL = ?,
                                                                        @TXT_PERSONAL = ?,
                                                                        @COD_GERENCIA = ?,
                                                                        @TXT_GERENCIA = ?,
                                                                        @COD_AREA = ?,
                                                                        @TXT_AREA = ?,
                                                                        @COD_CARGO = ?,
                                                                        @TXT_CARGO = ?,
                                                                        @COD_AUTORIZA = ?,
                                                                        @TXT_AUTORIZA = ?,
                                                                        @COD_LINEA = ?,
                                                                        @TXT_LINEA = ?,
                                                                        @COD_ESTADO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

                 $cod_usuario_registro = Session::get('usuario')->id;
                 $cod_empr = Session::get('empresas')->COD_EMPR;
                 


                 $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                 $stmt->bindParam(2, $id, PDO::PARAM_STR);
                 $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
                 $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
                 $stmt->bindParam(5, $cod_personal, PDO::PARAM_STR);
                 $stmt->bindParam(6, $txt_personal, PDO::PARAM_STR);
                 $stmt->bindParam(7, $cod_gerencia, PDO::PARAM_STR);
                 $stmt->bindParam(8, $txt_gerencia, PDO::PARAM_STR);
                 $stmt->bindParam(9, $cod_area, PDO::PARAM_STR);
                 $stmt->bindParam(10, $txt_area, PDO::PARAM_STR);
                 $stmt->bindParam(11, $cod_cargo, PDO::PARAM_STR);
                 $stmt->bindParam(12, $txt_cargo, PDO::PARAM_STR);
                 $stmt->bindParam(13, $cod_autoriza, PDO::PARAM_STR);
                 $stmt->bindParam(14, $txt_autoriza, PDO::PARAM_STR);   
                 $stmt->bindParam(15, $cod_linea, PDO::PARAM_STR);
                 $stmt->bindParam(16, $txt_linea, PDO::PARAM_STR);         
                 $stmt->bindParam(17, $cod_estado, PDO::PARAM_BOOL);
                 $stmt->bindParam(18, $cod_usuario_registro, PDO::PARAM_STR);


                $stmt->execute();

         } catch (\Exception $e) {
        Log::error('Error al insertar el personal : ' . $e->getMessage());
        throw $e; 
      }
    }

 }