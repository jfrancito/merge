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

trait OrdenPedidoTraits

{

    public function insertOrdenPedido($ind_tipo_operacion, $id_pedido, $fec_pedido, $cod_periodo, $txt_nombre, $cod_anio, $cod_empr, $cod_centro, 
                                      $cod_tipo_pedido, $txt_tipo_pedido, $cod_trabajador_solicita, $txt_trabajador_solicita, 
                                      $cod_trabajador_autoriza, $txt_trabajador_autoriza, $cod_trabajador_aprueba_ger, $txt_trabajador_aprueba_ger,          $cod_trabajador_aprueba_adm, $txt_trabajador_aprueba_adm,  $txt_glosa, $cod_estado, $txt_estado, $cod_area,          $txt_area, $activo, $cod_usuario_registro)

    {
        try {
                  $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ORDEN_PEDIDO_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID_PEDIDO = ?,
                                                                        @FEC_PEDIDO = ?,
                                                                        @COD_PERIODO = ?,
                                                                        @TXT_NOMBRE = ?,
                                                                        @COD_ANIO = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_TIPO_PEDIDO = ?,
                                                                        @TXT_TIPO_PEDIDO = ?,
                                                                        @COD_TRABAJADOR_SOLICITA = ?,
                                                                        @TXT_TRABAJADOR_SOLICITA = ?,
                                                                        @COD_TRABAJADOR_AUTORIZA = ?,
                                                                        @TXT_TRABAJADOR_AUTORIZA = ?,
                                                                        @COD_TRABAJADOR_APRUEBA_GER = ?,
                                                                        @TXT_TRABAJADOR_APRUEBA_GER = ?,
                                                                        @COD_TRABAJADOR_APRUEBA_ADM = ?,
                                                                        @TXT_TRABAJADOR_APRUEBA_ADM = ?,
                                                                        @TXT_GLOSA = ?,
                                                                        @COD_ESTADO = ?,
                                                                        @TXT_ESTADO = ?,
                                                                        @COD_AREA = ?,
                                                                        @TXT_AREA = ?,
                                                                        @ACTIVO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

                    $cod_usuario_registro = Session::get('usuario')->id;
                    $cod_empr = Session::get('empresas')->COD_EMPR;
                     
                   
            
                 $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                 $stmt->bindParam(2, $id_pedido, PDO::PARAM_STR);
                 $stmt->bindParam(3, $fec_pedido, PDO::PARAM_STR);
                 $stmt->bindParam(4, $cod_periodo, PDO::PARAM_STR);
                 $stmt->bindParam(5, $txt_nombre, PDO::PARAM_STR);
                 $stmt->bindParam(6, $cod_anio, PDO::PARAM_STR);
                 $stmt->bindParam(7, $cod_empr, PDO::PARAM_STR);
                 $stmt->bindParam(8, $cod_centro, PDO::PARAM_STR);
                 $stmt->bindParam(9, $cod_tipo_pedido, PDO::PARAM_STR);
                 $stmt->bindParam(10, $txt_tipo_pedido, PDO::PARAM_STR);
                 $stmt->bindParam(11, $cod_trabajador_solicita, PDO::PARAM_STR);
                 $stmt->bindParam(12, $txt_trabajador_solicita, PDO::PARAM_STR);
                 $stmt->bindParam(13, $cod_trabajador_autoriza, PDO::PARAM_STR);
                 $stmt->bindParam(14, $txt_trabajador_autoriza, PDO::PARAM_STR);
                 $stmt->bindParam(15, $cod_trabajador_aprueba_ger, PDO::PARAM_STR);
                 $stmt->bindParam(16, $txt_trabajador_aprueba_ger, PDO::PARAM_STR);
                 $stmt->bindParam(17, $cod_trabajador_aprueba_adm, PDO::PARAM_STR);
                 $stmt->bindParam(18, $txt_trabajador_aprueba_adm, PDO::PARAM_STR);
                 $stmt->bindParam(19, $txt_glosa, PDO::PARAM_STR);
                 $stmt->bindParam(20, $cod_estado, PDO::PARAM_STR);
                 $stmt->bindParam(21, $txt_estado, PDO::PARAM_STR);
                 $stmt->bindParam(22, $cod_area, PDO::PARAM_STR);
                 $stmt->bindParam(23, $txt_area, PDO::PARAM_STR);
                 $stmt->bindParam(24, $activo, PDO::PARAM_STR);
                 $stmt->bindParam(25, $cod_usuario_registro, PDO::PARAM_STR);


                $stmt->execute();

                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_pedido = $resultado['ID_PEDIDO'];
                return $id_pedido;

            } catch (\Exception $e) {  
            Log::error('Error al insertar el vale rendir: ' . $e->getMessage());
            throw $e; 
        }
    }




    public function insertOrdenPedidoDetalle($ind_tipo_operacion, $id_pedido, $cod_empr, $cod_centro, $cod_producto, $nom_producto, $cod_categoria, 
                                              $nom_categoria, $cantidad, $txt_observacion, $activo, $cod_usuario_registro)

    {


         try {

            
                  $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ORDEN_PEDIDO_DETALLE_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID_PEDIDO = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_PRODUCTO = ?,
                                                                        @NOM_PRODUCTO = ?,
                                                                        @COD_CATEGORIA = ?,
                                                                        @NOM_CATEGORIA = ?,
                                                                        @CANTIDAD = ?,
                                                                        @TXT_OBSERVACION = ?,
                                                                        @ACTIVO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

                 $cod_usuario_registro = Session::get('usuario')->id;
                 $cod_empr = Session::get('empresas')->COD_EMPR;
                 

                 $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                 $stmt->bindParam(2, $id_pedido, PDO::PARAM_STR);
                 $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
                 $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
                 $stmt->bindParam(5, $cod_producto, PDO::PARAM_STR);
                 $stmt->bindParam(6, $nom_producto, PDO::PARAM_STR);
                 $stmt->bindParam(7, $cod_categoria, PDO::PARAM_STR);
                 $stmt->bindParam(8, $nom_categoria, PDO::PARAM_STR);
                 $stmt->bindParam(9, $cantidad, PDO::PARAM_STR);
                 $stmt->bindParam(10, $txt_observacion, PDO::PARAM_STR);
                 $stmt->bindParam(11, $activo, PDO::PARAM_BOOL);
                 $stmt->bindParam(12, $cod_usuario_registro, PDO::PARAM_STR);


                $stmt->execute();

         } catch (\Exception $e) {
        Log::error('Error al insertar el vale rendir detalle: ' . $e->getMessage());
        throw $e; 
      }
    }

    

      public function listaOrdenPedido($ind_tipo_operacion, $id_pedido, $fec_pedido, $cod_periodo, $cod_anio, $cod_empr, $cod_centro, 
                                      $cod_tipo_pedido,  $cod_trabajador_solicita,
                                      $cod_trabajador_autoriza, $cod_trabajador_aprueba_ger,  $cod_trabajador_aprueba_adm, 
                                      $txt_glosa, $cod_estado, $cod_usuario_registro)
    {
        $array_lista_retail = array();

        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;

        
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ORDEN_PEDIDO_LISTAR

                                                             @IND_TIPO_OPERACION = ?,
                                                             @ID_PEDIDO = ?, 
                                                             @FEC_PEDIDO = ?, 
                                                             @COD_PERIODO = ?, 
                                                             @COD_ANIO = ?, 
                                                             @COD_EMPR = ?, 
                                                             @COD_CENTRO = ?,
                                                             @COD_TIPO_PEDIDO = ?,
                                                             @COD_TRABAJADOR_SOLICITA = ?,
                                                             @COD_TRABAJADOR_AUTORIZA = ?,
                                                             @COD_TRABAJADOR_APRUEBA_GER = ?,
                                                             @COD_TRABAJADOR_APRUEBA_ADM = ?,
                                                             @TXT_GLOSA = ?,
                                                             @COD_ESTADO = ?,
                                                             @COD_USUARIO = ?');


                    $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                    $stmt->bindParam(2, $id_pedido, PDO::PARAM_STR);
                    $stmt->bindParam(3, $fec_pedido, PDO::PARAM_STR);
                    $stmt->bindParam(4, $cod_periodo, PDO::PARAM_STR);
                    $stmt->bindParam(5, $cod_anio, PDO::PARAM_INT);
                    $stmt->bindParam(6, $cod_empr, PDO::PARAM_STR);
                    $stmt->bindParam(7, $cod_centro, PDO::PARAM_STR);
                    $stmt->bindParam(8, $cod_tipo_pedido, PDO::PARAM_STR);
                    $stmt->bindParam(9, $cod_trabajador_solicita, PDO::PARAM_STR);
                    $stmt->bindParam(10, $cod_trabajador_autoriza, PDO::PARAM_STR);
                    $stmt->bindParam(11, $cod_trabajador_aprueba_ger, PDO::PARAM_STR);
                    $stmt->bindParam(12, $cod_trabajador_aprueba_adm, PDO::PARAM_STR);
                    $stmt->bindParam(13, $txt_glosa, PDO::PARAM_STR);
                    $stmt->bindParam(14, $cod_estado, PDO::PARAM_STR);
                    $stmt->bindParam(15, $cod_usuario_registro, PDO::PARAM_STR);

                    $stmt->execute();
                                          
                    while ($row = $stmt->fetch()){
                      array_push($array_lista_retail, $row);
                    }

        return $array_lista_retail;
    }

}


