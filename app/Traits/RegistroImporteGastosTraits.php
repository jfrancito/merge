<?php

namespace App\Traits;

use App\Modelos\WEBRegistroImporteGastos;  //cambiar
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, App\CMPCategoria;
use App\Traits\STDTrabajadorVale;
use App\User;
use Session;
use PDO;

trait RegistroImporteGastosTraits
{

    public function insertRegistroImporteGastos($ind_tipo_operacion, $id, $cod_empr, $cod_centro,  $nom_centro, $cod_departamento, $nom_departamento, $cod_provincia, $nom_provincia, $cod_distrito, $nom_distrito, $can_total_importe,  $cod_tipo, $txt_nom_tipo, $ind_destino, $can_combustible, $cod_linea, $txt_linea, $cod_estado, $cod_usuario_registro)

    {
         try {
                  $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.REGISTRO_IMPORTE_GASTOS_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @NOM_CENTRO = ?,
                                                                        @COD_DEPARTAMENTO = ?,
                                                                        @NOM_DEPARTAMENTO = ?,
                                                                        @COD_PROVINCIA = ?,
                                                                        @NOM_PROVINCIA = ?,
                                                                        @COD_DISTRITO = ?,
                                                                        @NOM_DISTRITO = ?,
                                                                        @CAN_TOTAL_IMPORTE = ?,
                                                                        @COD_TIPO = ?,
                                                                        @TXT_NOM_TIPO = ?,
                                                                        @IND_DESTINO = ?,
                                                                        @CAN_COMBUSTIBLE = ?,
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
                 $stmt->bindParam(5, $nom_centro, PDO::PARAM_STR);
                 $stmt->bindParam(6, $cod_departamento, PDO::PARAM_STR);
                 $stmt->bindParam(7, $nom_departamento, PDO::PARAM_STR);
                 $stmt->bindParam(8, $cod_provincia, PDO::PARAM_STR);
                 $stmt->bindParam(9, $nom_provincia, PDO::PARAM_STR);
                 $stmt->bindParam(10, $cod_distrito, PDO::PARAM_STR);
                 $stmt->bindParam(11, $nom_distrito, PDO::PARAM_STR);
                 $stmt->bindParam(12, $can_total_importe, PDO::PARAM_STR);
                 $stmt->bindParam(13, $cod_tipo, PDO::PARAM_STR);   
                 $stmt->bindParam(14, $txt_nom_tipo, PDO::PARAM_STR);     
                 $stmt->bindParam(15, $ind_destino, PDO::PARAM_STR);  
                 $stmt->bindParam(16, $can_combustible, PDO::PARAM_STR);  
                 $stmt->bindParam(17, $cod_linea, PDO::PARAM_STR);  
                 $stmt->bindParam(18, $txt_linea, PDO::PARAM_STR);         
                 $stmt->bindParam(19, $cod_estado, PDO::PARAM_BOOL);
                 $stmt->bindParam(20, $cod_usuario_registro, PDO::PARAM_STR);


                $stmt->execute();

         } catch (\Exception $e) {
        Log::error('Error al insertar el Importe Gasto: ' . $e->getMessage());
        throw $e; 
      }
    }


     public function listaRegistroImporteGastos($ind_tipo_operacion, $id, $cod_empr, $cod_centro,  $nom_centro, $cod_departamento, $nom_departamento, $cod_provincia, $nom_provincia, $cod_distrito, $nom_distrito, $cod_tipo,  $can_total_importe, $cod_usuario_registro)
    {
        $array_lista_retail = array();

        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;
       

        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.REGISTRO_IMPORTE_GASTOS_LISTAR

                                                             @IND_TIPO_OPERACION = ?,
                                                             @ID = ?,
                                                             @COD_EMPR= ?,
                                                             @COD_CENTRO= ?,
                                                             @NOM_CENTRO= ?,
                                                             @COD_DEPARTAMENTO= ?,
                                                             @NOM_DEPARTAMENTO= ?,
                                                             @COD_PROVINCIA= ?,
                                                             @NOM_PROVINCIA= ?,
                                                             @COD_DISTRITO= ?,
                                                             @NOM_DISTRITO= ?,
                                                             @COD_TIPO = ?,
                                                             @CAN_TOTAL_IMPORTE = ?,
                                                             @COD_USUARIO = ?');


                    $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                    $stmt->bindParam(2, $id, PDO::PARAM_STR);
                    $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
                    $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
                    $stmt->bindParam(5, $nom_centro, PDO::PARAM_STR);
                    $stmt->bindParam(6, $cod_departamento, PDO::PARAM_STR);
                    $stmt->bindParam(7, $nom_departamento, PDO::PARAM_STR);  
                    $stmt->bindParam(8, $cod_provincia, PDO::PARAM_STR);
                    $stmt->bindParam(9, $nom_provincia, PDO::PARAM_STR);  
                    $stmt->bindParam(10, $cod_distrito, PDO::PARAM_STR);
                    $stmt->bindParam(11, $nom_distrito, PDO::PARAM_STR);  
                    $stmt->bindParam(12, $cod_tipo, PDO::PARAM_STR);
                    $stmt->bindParam(13, $can_total_importe, PDO::PARAM_STR);
                    $stmt->bindParam(14, $cod_usuario_registro, PDO::PARAM_STR);

                    $stmt->execute();
                                          
                    while ($row = $stmt->fetch()){
                      array_push($array_lista_retail, $row);
                    }

        return $array_lista_retail;
    }
}