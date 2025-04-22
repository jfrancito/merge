<?php

namespace App\Traits;

use App\Modelos\ALMCentro;
use App\Modelos\CMPContrato;
use App\Modelos\CMPTipoCambio;

use App\Modelos\STDEmpresa;
use Illuminate\Support\Facades\DB;
use View;
use Session;
use Nexmo;
use PDO;

trait ComprasEnvasesSedeTraits
{

    private function listaEmpresa($todo, $titulo)
    {
        $array = STDEmpresa::where('STD.EMPRESA.COD_ESTADO', '=', '1')
            ->where('STD.EMPRESA.IND_SISTEMA', '=', '1')
            ->pluck('NOM_EMPR', 'COD_EMPR')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }

    private function listaCentro()
    {
        $array = ALMCentro::where('ALM.CENTRO.COD_ESTADO', '=', '1')
            ->selectRaw('COD_CENTRO, NOM_CENTRO, 0.0000 AS MONTO')
            ->get();

        return $array;
    }

    private function listaFamiliaTipo($codigo, $todo, $titulo)
    {
        $array = DB::table('CMP.CATEGORIA')
            ->join('CMP.CATEGORIA_RELACION', 'CMP.CATEGORIA.COD_CATEGORIA', '=', 'CMP.CATEGORIA_RELACION.COD_CATEGORIA')
            ->where('CMP.CATEGORIA.COD_ESTADO', '=', 1)
            ->where('CMP.CATEGORIA_RELACION.COD_CATEGORIA_SUP', '=', $codigo)
            ->pluck('CMP.CATEGORIA.NOM_CATEGORIA', 'CMP.CATEGORIA.COD_CATEGORIA')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }

    private function generar_reporte($cod_empresa, $fecha_ini, $fecha_fin, $cod_tipo, $cod_familia)
    {
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.REPORTE_COMPRAS_ENVASES_SEDE
                                                            @COD_EMPR = ?,
                                                            @FECHA_INI = ?,
                                                            @FECHA_FIN = ?,
                                                            @COD_TIPO_PRODUCTO = ?,
                                                            @COD_FAMILIA = ?');
        $stmt->bindParam(1, $cod_empresa, PDO::PARAM_STR);
        $stmt->bindParam(2, $fecha_ini, PDO::PARAM_STR);
        $stmt->bindParam(3, $fecha_fin, PDO::PARAM_STR);
        $stmt->bindParam(4, $cod_tipo, PDO::PARAM_STR);
        $stmt->bindParam(5, $cod_familia, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
