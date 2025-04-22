<?php

namespace App\Traits;

use App\Modelos\ALMCentro;
use App\Modelos\ALMProducto;
use App\Modelos\STDEmpresa;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use View;
use Session;
use Nexmo;
use PDO;

trait IngresosSalidasEnvasesTraits
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

    private function listaCentro($todo, $titulo)
    {
        $array = ALMCentro::where('ALM.CENTRO.COD_ESTADO', '=', '1')
            ->pluck('NOM_CENTRO', 'COD_CENTRO')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }

    private function listaProducto($tipo_producto, $familia, $subfamilia, $todo, $titulo)
    {
        $array = ALMProducto::where('ALM.PRODUCTO.COD_ESTADO', '=', '1')
            ->where(function (Builder $query) use($tipo_producto, $familia, $subfamilia) {
                if(!is_null($tipo_producto) and $tipo_producto <> ''){
                    $query->where('ALM.PRODUCTO.COD_CATEGORIA_TIPO_PRODUCTO', '=', $tipo_producto);
                }
                if(!is_null($familia) and $familia <> ''){
                    $query->where('ALM.PRODUCTO.COD_CATEGORIA_FAMILIA', '=', $familia);
                }
                if(!is_null($subfamilia) and $subfamilia <> ''){
                    $query->where('ALM.PRODUCTO.COD_CATEGORIA_SUB_FAMILIA', '=', $subfamilia);
                }
            })->pluck('NOM_PRODUCTO', 'COD_PRODUCTO')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
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

    private function listaCategoria($txt_grupo, $todo, $titulo){
        $array = DB::table('CMP.CATEGORIA')
            ->where('COD_ESTADO', '=', 1)
            ->where('TXT_GRUPO', '=', $txt_grupo)
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }

    private function listaCategoriaTipo($txt_grupo, $todo, $titulo, $tipo_array){
        $array = DB::table('CMP.CATEGORIA')
            ->where('COD_ESTADO', '=', 1)
            ->where('TXT_GRUPO', '=', $txt_grupo)
            ->whereIn('COD_CATEGORIA', $tipo_array)
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }

    private function listaCodigoCategoria($codigo, $todo, $titulo){
        $array = DB::table('CMP.CATEGORIA')
            ->where('COD_ESTADO', '=', 1)
            ->where('COD_CATEGORIA_SUP', '=', $codigo)
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;
    }

    private function generar_reporte($tipo, $empresa, $centro, $tipo_inv, $empr_propietario, $empr_servicio,
                                     $cod_producto, $fecha, $almacen, $estado_almacen, $cod_familia, $cod_sub_familia,
                                     $cod_tipo_producto)
    {
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.INGRESOS_SALIDAS_MATERIAL
                                                             @TIPO = ?,
                                                             @EMPRESA = ?,
                                                             @CENTRO = ?,
                                                             @TIPO_INV = ?,
                                                             @EMPR_PROPIETARIO = ?,
                                                             @EMPR_SERVICIO = ?,
                                                             @COD_PRODUCTO = ?,
                                                             @FECHA = ?,
                                                             @ALMACEN = ?,
                                                             @ESTADO_ALMACEN = ?,
                                                             @COD_FAMILIA = ?,
                                                             @COD_SUB_FAMILIA = ?,
                                                             @COD_TIPO_PRODUCTO = ?');
        $stmt->bindParam(1, $tipo, PDO::PARAM_STR);
        $stmt->bindParam(2, $empresa, PDO::PARAM_STR);
        $stmt->bindParam(3, $centro, PDO::PARAM_STR);
        $stmt->bindParam(4, $tipo_inv, PDO::PARAM_STR);
        $stmt->bindParam(5, $empr_propietario, PDO::PARAM_STR);
        $stmt->bindParam(6, $empr_servicio, PDO::PARAM_STR);
        $stmt->bindParam(7, $cod_producto, PDO::PARAM_STR);
        $stmt->bindParam(8, $fecha, PDO::PARAM_STR);
        $stmt->bindParam(9, $almacen, PDO::PARAM_STR);
        $stmt->bindParam(10, $estado_almacen, PDO::PARAM_STR);
        $stmt->bindParam(11, $cod_familia, PDO::PARAM_STR);
        $stmt->bindParam(12, $cod_sub_familia, PDO::PARAM_STR);
        $stmt->bindParam(13, $cod_tipo_producto, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
