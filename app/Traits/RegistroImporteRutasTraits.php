<?php

namespace App\Traits;

use App\Modelos\WEBRegistroImporteRutas;  //cambiar
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\WEBRegla, App\Modelos\STDTrabajador, App\STDEmpresa, App\CMPCategoria;
use App\Traits\STDTrabajadorVale;
use App\User;
use Session;
use PDO;

trait RegistroImporteRutasTraits
{

    public function insertRegistroImporteRutas($ind_tipo_operacion, $id_importe, $cod_empr, $cod_centro,  $nom_centro,
     $cod_origen, $nom_origen, $cod_distrito, $nom_distrito, $cod_tipo, $txt_nom_tipo, $cod_linea, $txt_linea, $can_importe, 
     $ind_destino, $cod_estado, $cod_usuario_registro)

    {
         try {
                  $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.REGISTRO_IMPORTE_RUTAS_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID_IMPORTE = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @NOM_CENTRO = ?,
                                                                        @COD_ORIGEN = ?,
                                                                        @NOM_ORIGEN = ?,
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

                 $usuario = Session::get('usuario');
                 $cod_usuario_registro = $usuario->id;
                 $empresas = Session::get('empresas');
                 $cod_empr = is_object($empresas) ? $empresas->COD_EMPR : (is_array($empresas) ? $empresas['COD_EMPR'] : '');

                 $centros = Session::get('centros');
                 $cod_centro = '';
                 $nom_centro = '';

                 if ($centros) {
                     $cod_centro = is_object($centros) ? $centros->COD_CENTRO : (is_array($centros) ? $centros['COD_CENTRO'] : '');
                     $nom_centro = is_object($centros) ? $centros->NOM_CENTRO : (is_array($centros) ? $centros['NOM_CENTRO'] : '');
                 } 

                 if (empty($cod_centro) && isset($usuario->usuarioosiris_id)) {
                     $trabajador = STDTrabajador::where('COD_TRAB', $usuario->usuarioosiris_id)->first();
                     if ($trabajador && !empty($trabajador->NRO_DOCUMENTO)) {
                         $planilla = DB::table('WEB.platrabajadores as P')
                             ->where('P.dni', $trabajador->NRO_DOCUMENTO)
                             ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
                             ->select('C.COD_CENTRO', 'C.NOM_CENTRO')
                             ->first();
                         if ($planilla) {
                             $cod_centro = $planilla->COD_CENTRO;
                             $nom_centro = $planilla->NOM_CENTRO;
                         }
                     }
                 }
                 


                 $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
                 $stmt->bindParam(2, $id_importe, PDO::PARAM_STR);
                 $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
                 $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
                 $stmt->bindParam(5, $nom_centro, PDO::PARAM_STR);
                 $stmt->bindParam(6, $cod_origen, PDO::PARAM_STR);
                 $stmt->bindParam(7, $nom_origen, PDO::PARAM_STR);
                 $stmt->bindParam(8, $cod_distrito, PDO::PARAM_STR);
                 $stmt->bindParam(9, $nom_distrito, PDO::PARAM_STR);
                 $stmt->bindParam(10, $cod_tipo, PDO::PARAM_STR);   
                 $stmt->bindParam(11, $txt_nom_tipo, PDO::PARAM_STR); 
                 $stmt->bindParam(12, $cod_linea, PDO::PARAM_STR);  
                 $stmt->bindParam(13, $txt_linea, PDO::PARAM_STR);       
                 $stmt->bindParam(14, $can_importe, PDO::PARAM_STR);
                 $stmt->bindParam(15, $ind_destino, PDO::PARAM_STR);        
                 $stmt->bindParam(16, $cod_estado, PDO::PARAM_BOOL);
                 $stmt->bindParam(17, $cod_usuario_registro, PDO::PARAM_STR);

                $stmt->execute();

         } catch (\Exception $e) {
        Log::error('Error al insertar el Importe Gasto: ' . $e->getMessage());
        throw $e; 
      }
    }
}