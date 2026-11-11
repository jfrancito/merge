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

trait MontoOrdenPedidoTraits

{

    public function listaMontoOrdenPedido($ind_tipo_operacion, $cod_monto, $cod_empr, $cod_centro, $cod_area, $cod_usuario_registro)
    {
        $array_lista_retail = array();

        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;


        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.MONTO_ORDEN_PEDIDO_LISTAR

                                                             @IND_TIPO_OPERACION = ?,
                                                             @COD_MONTO = ?, 
                                                             @COD_EMPR = ?, 
                                                             @COD_CENTRO = ?,
                                                             @COD_AREA = ?,
                                                             @COD_USUARIO = ?');


        $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
        $stmt->bindParam(2, $cod_monto, PDO::PARAM_STR);
        $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
        $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
        $stmt->bindParam(5, $cod_area, PDO::PARAM_STR);
        $stmt->bindParam(6, $cod_usuario_registro, PDO::PARAM_STR);

        $stmt->execute();

        while ($row = $stmt->fetch()) {
            array_push($array_lista_retail, $row);
        }

        return $array_lista_retail;
    }
}
