<?php

namespace App\Traits;

use App\Modelos\WEBRegistroImporteViaticos;  //cambiar
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, App\CMPCategoria;
use App\Traits\STDTrabajadorVale;
use App\User;
use Session;
use PDO;

trait RegistroImporteRutasTraits
{

    public function insertRegistroImporteViaticos($ind_tipo_operacion, $id_importe, $cod_empr, $cod_centro,  $nom_centro, $cod_departamento, 
                                                  $nom_departamento, $cod_provincia, $nom_provincia, $cod_distrito, $nom_distrito, 
                                                  $cod_tipo, $txt_nom_tipo, $cod_linea, $txt_linea, $can_importe, $ind_destino, $cod_estado, $cod_usuario_registro)

    {
         try {
                  $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.REGISTRO_IMPORTE_VIATICOS_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID_IMPORTE = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @NOM_CENTRO = ?,
                                                                        @COD_DEPARTAMENTO = ?,
                                                                        @NOM_DEPARTAMENTO = ?,
                                                                        @COD_PROVINCIA = ?,
                                                                        @NOM_PROVINCIA = ?,
                                                                        @COD_DISTRITO = ?,
                                                                        @NOM_DISTRITO = ?,
                                                                        @COD_TIPO = ?,
                                                                        @TXT_NOM_TIPO = ?,
                                                                        @COD_LINEA = ?,
                                                                        @TXT_LINEA = ?,
                                                                        @CAN_IMPORTE = ?,
                                                                        @IND_DESTINO = ?,
                                                                        @COD_ESTADO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

                 $cod_usuario_registro = Session::get('usuario')->id;
                 $cod_empr = Session::get('empresas')->COD_EMPR;
                 


                 $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                 $stmt->bindParam(2, $id_importe, PDO::PARAM_STR);
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
                 $stmt->bindParam(13, $txt_nom_tipo, PDO::PARAM_STR); 
                 $stmt->bindParam(14, $cod_linea, PDO::PARAM_STR);  
                 $stmt->bindParam(15, $txt_linea, PDO::PARAM_STR);       
                 $stmt->bindParam(16, $can_importe, PDO::PARAM_STR);
                 $stmt->bindParam(17, $ind_destino, PDO::PARAM_STR);        
                 $stmt->bindParam(18, $cod_estado, PDO::PARAM_BOOL);
                 $stmt->bindParam(19, $cod_usuario_registro, PDO::PARAM_STR);

                $stmt->execute();

         } catch (\Exception $e) {
        Log::error('Error al insertar el Importe Gasto: ' . $e->getMessage());
        throw $e; 
      }
    }
}