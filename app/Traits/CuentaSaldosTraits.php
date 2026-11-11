<?php

namespace App\Traits;

use App\Modelos\ALMCentro;
use App\Modelos\CMPContrato;
use App\Modelos\CMPTipoCambio;

use Illuminate\Support\Facades\DB;
use View;
use Session;
use Nexmo;
use PDO;

trait CuentaSaldosTraits
{
    private function listaTipoContrato($todo, $titulo)
    {
        $array = CMPContrato::join('CMP.CATEGORIA', 'CMP.CONTRATO.COD_CATEGORIA_TIPO_CONTRATO', '=', 'CMP.CATEGORIA.COD_CATEGORIA')
            ->where('CMP.CONTRATO.COD_EMPR', '=', Session::get('empresas')->COD_EMPR)
            ->where('CMP.CONTRATO.COD_CATEGORIA_ESTADO_CONTRATO', '<>', 'ECO0000000000005')
            ->where('CMP.CONTRATO.COD_ESTADO', '=', '1')
            ->selectRaw("DISTINCT 
                CMP.CATEGORIA.TXT_TIPO_REFERENCIA AS COD_TIPO_CUENTA,
                CASE 
                    WHEN CMP.CATEGORIA.TXT_TIPO_REFERENCIA = 'P' THEN 'CUENTA POR PAGAR - PROVEEDOR'
                    WHEN CMP.CATEGORIA.TXT_TIPO_REFERENCIA = 'C' THEN 'CUENTA POR COBRAR - CLIENTE'
                    ELSE 'NO DEFINIDO - ' + CMP.CATEGORIA.TXT_TIPO_REFERENCIA
                END AS NOM_TIPO_CUENTA")
            ->get()
            ->pluck('NOM_TIPO_CUENTA', 'COD_TIPO_CUENTA')
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

    private function getTipoCambio($fecha)
    {
        $tipo = CMPTipoCambio::where('FEC_CAMBIO', '=', $fecha)->first();
        if (empty($tipo)) {
            $tipo = CMPTipoCambio::where('COD_ESTADO', 1)->orderby('FEC_CAMBIO', 'DESC')->first();
        }
        return $tipo;
    }

    private function generar_reporte($fechabilitacion, $tcventa, $tccompra, $codcentro, $tipocuenta, $indrelacionado)
    {
        $codempresa = Session::get('empresas')->COD_EMPR;
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.OBTENER_REPORTE_ADMINISTRACION
                                                            @FEC_HABILITACION = ?,
                                                            @TC_VENTA = ?,
                                                            @TC_COMPRA = ?,
                                                            @COD_EMPR = ?,
                                                            @COD_CENTRO = ?,
                                                            @COD_TIPO_COBRAR_PAGAR = ?,
                                                            @IND_RELACIONADA = ?');
        $stmt->bindParam(1, $fechabilitacion, PDO::PARAM_STR);
        $stmt->bindParam(2, $tcventa, PDO::PARAM_STR);
        $stmt->bindParam(3, $tccompra, PDO::PARAM_STR);
        $stmt->bindParam(4, $codempresa, PDO::PARAM_STR);
        $stmt->bindParam(5, $codcentro, PDO::PARAM_STR);
        $stmt->bindParam(6, $tipocuenta, PDO::PARAM_STR);
        $stmt->bindParam(7, $indrelacionado, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function generar_reporte_liquidaciones($startDate, $endDate, $employee, $company)
    {
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC [WEB].[REPORTE_LIQUIDACIONES_TRABAJADOR] @PERIODO_INI = ?,
                                                          @PERIODO_FIN = ?,
                                                          @COD_TRABAJADOR  = ?,
                                                          @COD_EMPR = ?');
        $stmt->bindParam(1, $startDate, PDO::PARAM_STR);
        $stmt->bindParam(2, $endDate, PDO::PARAM_STR);
        $stmt->bindParam(3, $employee, PDO::PARAM_STR);
        $stmt->bindParam(4, $company, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
