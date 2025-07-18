<?php

namespace App\Traits;

use App\Modelos\WEBRegistroPersonalAprueba;  
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, App\CMPCategoria;
use App\Traits\STDTrabajadorVale;
use App\User;
use Session;
use PDO;

trait RegistroPersonalApruebaTraits
{

    public function insertRegistroPersonalAprueba($ind_tipo_operacion, $id, $cod_empr, $cod_centro, $cod_area, $txt_area, $cod_cargo, $txt_cargo, $cod_aprueba, $txt_aprueba, $cod_estado, $cod_usuario_registro)

    {
         try {
                  $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_PERSONAL_APRUEBA_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_AREA = ?,
                                                                        @TXT_AREA = ?,
                                                                        @COD_CARGO = ?,
                                                                        @TXT_CARGO = ?,
                                                                        @COD_APRUEBA = ?,
                                                                        @TXT_APRUEBA = ?,
                                                                        @COD_ESTADO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

                 $cod_usuario_registro = Session::get('usuario')->id;
                 $cod_empr = Session::get('empresas')->COD_EMPR;
                 


                 $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                 $stmt->bindParam(2, $id, PDO::PARAM_STR);
                 $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
                 $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
                 $stmt->bindParam(5, $cod_area, PDO::PARAM_STR);
                 $stmt->bindParam(6, $txt_area, PDO::PARAM_STR);
                 $stmt->bindParam(7, $cod_cargo, PDO::PARAM_STR);
                 $stmt->bindParam(8, $txt_cargo, PDO::PARAM_STR);
                 $stmt->bindParam(9, $cod_aprueba, PDO::PARAM_STR);
                 $stmt->bindParam(10, $txt_aprueba, PDO::PARAM_STR);     
                 $stmt->bindParam(11, $cod_estado, PDO::PARAM_BOOL);
                 $stmt->bindParam(12, $cod_usuario_registro, PDO::PARAM_STR);


                $stmt->execute();

         } catch (\Exception $e) {
        Log::error('Error al insertar el Personal aprueba: ' . $e->getMessage());
        throw $e; 
      }
    }
 

     public function listaRegistroPersonalAprueba($ind_tipo_operacion, $id, $cod_empr, $cod_centro, $cod_area, $txt_area, $cod_cargo, $txt_cargo, $cod_aprueba, $txt_aprueba, $cod_usuario_registro)
    {
        $array_lista_retail = array();

        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;
       

        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.VALE_PERSONAL_APRUEBA_LISTAR

                                                             @IND_TIPO_OPERACION = ?,
                                                             @ID = ?,
                                                             @COD_EMPR= ?,
                                                             @COD_CENTRO= ?,
                                                             @COD_AREA = ?,
                                                             @TXT_AREA = ?,
                                                             @COD_CARGO = ?,
                                                             @TXT_CARGO = ?,
                                                             @COD_APRUEBA = ?,
                                                             @TXT_APRUEBA = ?,
                                                             @COD_USUARIO = ?');


                    $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                    $stmt->bindParam(2, $id, PDO::PARAM_STR);
                    $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
                    $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
                    $stmt->bindParam(5, $cod_area, PDO::PARAM_STR);
                    $stmt->bindParam(6, $txt_area, PDO::PARAM_STR);
                    $stmt->bindParam(7, $cod_cargo, PDO::PARAM_STR);
                    $stmt->bindParam(8, $txt_cargo, PDO::PARAM_STR);
                    $stmt->bindParam(9, $cod_aprueba, PDO::PARAM_STR);
                    $stmt->bindParam(10, $txt_aprueba, PDO::PARAM_STR);     
                    $stmt->bindParam(11, $cod_usuario_registro, PDO::PARAM_STR);

                    $stmt->execute();
                                          
                    while ($row = $stmt->fetch()){
                      array_push($array_lista_retail, $row);
                    }

        return $array_lista_retail;
    }

  
}