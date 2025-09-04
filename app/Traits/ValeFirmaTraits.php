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


trait ValeFirmaTraits
{

   
    public function listaFirmaValeRendir($cod_empr, $cod_centro)
    {
        
        $array_lista_retail = array();
        $cod_usuario_registro = "";

        $usuario = User::where('id', Session::get('usuario')->id)->get();
        $cod_empr = Session::get('empresas')->COD_EMPR;
        $cod_centro = Session::get('empresas')->COD_CENTRO_SISTEMA;


        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.FIRMA_VALE_RENDIR_LISTA 

                                                             @COD_EMPR = ?,
                                                             @COD_CENTRO = ?');



                    $stmt->bindParam(1, $cod_empr, PDO::PARAM_STR);
                    $stmt->bindParam(2, $cod_centro, PDO::PARAM_STR);

                    $stmt->execute();
                                          
                    while ($row = $stmt->fetch()){
                      array_push($array_lista_retail, $row);
                    }

        return $array_lista_retail;
    }

}
