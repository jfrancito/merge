<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


use App\Modelos\WEBCuentaContable;
use App\Modelos\ALMProducto;
use App\Modelos\CONPeriodo;
use App\Modelos\WEBViewMigrarVenta;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\WEBHistorialMigrar;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\WEBProductoEmpresa;
use App\Modelos\WEBAsientoMovimiento;
use App\Modelos\CMPReferecenciaAsoc;
use App\Modelos\WEBAsientoModelo;
use App\Modelos\CMPCategoria;

use App\Modelos\WEBAsientoModeloDetalle;
use App\Modelos\WEBAsientoModeloReferencia;
use App\Modelos\WEBAsiento;
use App\Modelos\STDEmpresa;


use ZipArchive;
use View;
use Session;
use Hashids;
use Nexmo;
use Keygen;
use PDO;

trait ReporteVentaNTraits
{

    public function rv_reporte_registro_venta($anio, $mes, $listaasiento, $detallelistaasiento)
    {

        //llenado de datalle
        $array_detalle_asiento = array();

        foreach ($listaasiento as $index => $item) {

            $empresa = STDEmpresa::where('COD_EMPR', '=', $item->COD_EMPR_CLI)->first();
            $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA_TIPO_DOCUMENTO)->first();
            $periodo = CONPeriodo::where('COD_PERIODO', '=', $item->COD_PERIODO)->first();

            //1->afecto ; 0->no afecto
            $indicador_afecto = $this->rv_ind_afecta_infecta($item);

            $mes_01 = str_pad($item->periodo->COD_MES, 2, "0", STR_PAD_LEFT);
            $periodo_01 = $item->periodo->COD_ANIO . $mes_01 . "00";
            $correlativo_02 = str_pad($index + 1, 9, "0", STR_PAD_LEFT);
            $codigo_03 = 'M' . $correlativo_02;
            $fecha_emision_04 = date_format(date_create($item->FEC_ASIENTO), 'd/m/Y');
            $fecha_vencimiento_05 = '01/01/0001';
            $tipo_documento_06 = $categoria->CODIGO_SUNAT;
            $nro_serie_07 = $item->NRO_SERIE;
            $nro_correlativo_08 = $item->NRO_DOC;

            $codigo_09 = "";
            $identidad_cliente_10 = intval($empresa->tipo_documento->CODIGO_SUNAT);
            $documento_cliente_11 = $empresa->NRO_DOCUMENTO;
            $nombre_cliente_12 = $empresa->NOM_EMPR;

            $importe_total = $item->CAN_TOTAL_DEBE;


            $v_f_e_13 = '0.00';
            $suma_70_14 = '0.00';
            $codigo_15 = '0.00';
            $suma_40_16 = '0.00';

            $codigo_17 = '0.00';
            $codigo_18 = '0.00';
            $codigo_19 = '0.00';
            $codigo_20 = '0.00';
            $importe_total_21 = '0.00';

            $importe_total_21 = $importe_total;
            $importe_total_21 = number_format($importe_total_21, 2, '.', '');
            if ($tipo_documento_06 == '07') {
                $importe_total_21 = $importe_total_21 * -1;
            }


            if ($item->COD_EMPR == 'EMP0000000000007') {
                if ($indicador_afecto == 1) {
                    $suma_70_14 = $this->rv_suma_subtotal_7($item, $tipo_documento_06);
                    //$suma_70_14 		= 	$item->CAN_TOTAL_DEBE;
                    $suma_70_14 = number_format($suma_70_14, 2, '.', '');
                }
                $suma_40_16 = $this->rv_suma_igv_40($item, $indicador_afecto, $tipo_documento_06);

                if ($indicador_afecto == 0) {
                    $codigo_18 = $item->CAN_TOTAL_DEBE;
                    //$codigo_19 				= 	$this->ar_suma_subtotal_7($item,$tipo_documento_06);
                    $codigo_18 = number_format($codigo_18, 2, '.', '');
                }
            } else {
                //EXONERADA
                if ($item->tipo_ivap_id == 'CTV0000000000003') {
                    $codigo_17 = $item->CAN_TOTAL_DEBE;

                    if ($tipo_documento_06 == '07') {
                        $codigo_17 = $codigo_17 * -1;
                    }

                }
                if ($item->tipo_ivap_id == 'CTV0000000000002') {
                    $codigo_18 = $item->CAN_TOTAL_DEBE;

                    if ($tipo_documento_06 == '07') {
                        $codigo_18 = $codigo_18 * -1;
                    }

                }

                if ($item->tipo_ivap_id == 'CTV0000000000001') {
                    // $codigo_19  			=  	$this->rv_suma_subtotal_7_tt($detallelistaasiento,$tipo_documento_06,$item->COD_ASIENTO);
                    // $codigo_20  			=  	$this->rv_suma_ivap_40_tt($detallelistaasiento,$tipo_documento_06,$item->COD_ASIENTO);
                    $codigo_19 = $item->SIETE_CAN_HABER_MN;
                    $codigo_20 = $item->IVAP_CAN_HABER_MN;

                    $sumaivasub = $codigo_19 + $codigo_20;

                    if (($sumaivasub - $importe_total_21) == 0.01) {
                        $codigo_19 = $codigo_19 - 0.01;
                    }

                    if ($tipo_documento_06 == '07') {
                        $codigo_19 = $codigo_19 * -1;
                        $codigo_20 = $codigo_20 * -1;
                    }


                }
            }


            $tipo_cambio_22 = $item->CAN_TIPO_CAMBIO;
            $tipo_cambio_22 = number_format($tipo_cambio_22, 3, '.', '');

            $fecha_asociada_23 = '01/01/0001';
            $tipo_asociado_24 = '00';
            $serie_asociada_25 = '-';
            $nro_asociada_26 = '-';

            //NC Y ND
            if ($tipo_documento_06 == '07' or $tipo_documento_06 == '08') {
                $fecha_asociada_23 = date_format(date_create($item->FEC_ASIENTO), 'd/m/Y');
                $documento_asociado = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                if (count($documento_asociado) > 0) {
                    $tipo_asociado_24 = $documento_asociado->CODIGO_SUNAT;
                }

                $serie_asociada_25 = $item->NRO_SERIE_REF;
                $nro_asociada_26 = $item->NRO_DOC_REF;
            }


            $txt_anulado = '';
            if ($item->IND_EXTORNO == 1) {
                $txt_anulado = '*** ANULADO *** ';
            }


            $alias = $item->alias;
            if ($item->IND_GRATUITO == 1) {
                $alias = $alias . ' - TRANSFERENCIA GRATUITA';
            }
            if ($item->ind_boni > 0) {
                $alias = $alias . ' - BONIFICACION';
            }


            if ($item->IND_ANTICIPO == 1 and $tipo_documento_06 == '07') {
                $alias = 'Ventas inafectas - Anticipos Notas de Credito';
            }
            if ($item->IND_ANTICIPO == 1 and $tipo_documento_06 == '01') {
                $alias = 'Ventas inafectas - Anticipos Facturas';
            }


            $array_nuevo_asiento = array();
            $array_nuevo_asiento = array(
                "tipo_venta_00" => $alias,
                "periodo_01" => $periodo_01,
                "correlativo_02" => $correlativo_02,
                "codigo_03" => $codigo_03,
                "fecha_emision_04" => $fecha_emision_04,
                "fecha_vencimiento_05" => $fecha_vencimiento_05,
                "tipo_documento_06" => $tipo_documento_06,
                "nro_serie_07" => $nro_serie_07,
                "nro_correlativo_08" => $nro_correlativo_08,
                "codigo_09" => $codigo_09,
                "identidad_cliente_10" => $identidad_cliente_10,
                "documento_cliente_11" => $documento_cliente_11,
                "nombre_cliente_12" => $nombre_cliente_12,

                "v_f_e_13" => $v_f_e_13,
                "suma_70_14" => $suma_70_14,
                "codigo_15" => $codigo_15,
                "suma_40_16" => $suma_40_16,
                "codigo_17" => $codigo_17,
                "codigo_18" => $codigo_18,

                "codigo_19" => $codigo_19,
                "codigo_20" => $codigo_20,
                "importe_total_21" => $importe_total_21,
                "tipo_cambio_22" => $tipo_cambio_22,
                "fecha_asociada_23" => $fecha_asociada_23,
                "tipo_asociado_24" => $tipo_asociado_24,
                "serie_asociada_25" => $serie_asociada_25,
                "nro_asociada_26" => $nro_asociada_26,


            );

            array_push($array_detalle_asiento, $array_nuevo_asiento);

        }

        return $array_detalle_asiento;

    }


    public function rv_suma_total($asiento, $tipo_documento_06)
    {

        $suma = 0.00;

        $asiento_movimiento = WEBAsientoMovimiento::where('COD_ASIENTO', '=', $asiento->COD_ASIENTO)
            ->where('COD_ESTADO', '=', 1)
            ->select(DB::raw('sum(CAN_DEBE_MN) as TOTAL'))
            ->first();

        if (count($asiento_movimiento) > 0) {
            $suma = $asiento_movimiento->TOTAL;

            if ($tipo_documento_06 == '07') {
                $suma = $suma * -1;
            }
        }


        return $suma;
    }

    public function rv_ind_afecta_infecta($asiento)
    {

        $afecto = 0;

        $asiento_modelo = WEBAsientoModelo::where('id', '=', $asiento->COD_ASIENTO_MODELO)
            ->first();

        if ($asiento_modelo->tipo_igv_id == 'CTI0000000000001') {
            $afecto = 1;
        }

        return $afecto;
    }


    public function rv_suma_subtotal_7_tt($detallelistaasiento, $tipo_documento_06, $COD_ASIENTO)
    {

        $suma = 0.00;

        $asiento_movimiento = $detallelistaasiento->where('COD_ESTADO', '=', 1)
            ->where('IND_PRODUCTO', '=', 1)
            ->where('COD_ASIENTO', '=', $COD_ASIENTO)
            ->sum('CAN_DB_T');

        if (count($asiento_movimiento) > 0) {
            $suma = $asiento_movimiento;

            if ($tipo_documento_06 == '07') {
                $suma = $suma * -1;
            }

        }
        return $suma;
    }

    public function rv_suma_ivap_40_tt($detallelistaasiento, $tipo_documento_06, $COD_ASIENTO)
    {

        $suma = 0.00;
        $asiento_movimiento = $detallelistaasiento->where('COD_ASIENTO', '=', $COD_ASIENTO)
            ->where('COD_ESTADO', '=', 1)
            ->where('ind_ivap', '=', '1')
            ->sum('CAN_DB_T');

        if (count($asiento_movimiento) > 0) {
            $suma = $asiento_movimiento;
            if ($tipo_documento_06 == '07') {
                $suma = $suma * -1;
            }
        }

        return $suma;
    }


    public function rv_suma_subtotal_7($asiento, $tipo_documento_06)
    {

        $suma = 0.00;

        $asiento_movimiento = WEBAsientoMovimiento::where('COD_ASIENTO', '=', $asiento->COD_ASIENTO)
            ->where('COD_ESTADO', '=', 1)
            ->where('IND_PRODUCTO', '=', 1)
            ->select(DB::raw('sum(CAN_DEBE_MN + CAN_HABER_MN) as TOTAL'))
            ->first();
        if (count($asiento_movimiento) > 0) {
            $suma = $asiento_movimiento->TOTAL;

            if ($tipo_documento_06 == '07') {
                $suma = $suma * -1;
            }

        }
        return $suma;
    }


    public function rv_suma_subtotal_debe($asiento, $tipo_documento_06)
    {

        $suma = 0.00;

        $asiento_movimiento = WEBAsientoMovimiento::where('COD_ASIENTO', '=', $asiento->COD_ASIENTO)
            ->where('COD_ESTADO', '=', 1)
            ->where('IND_PRODUCTO', '<>', 2)
            ->select(DB::raw('sum(CAN_DEBE_MN) as TOTAL'))
            ->first();
        if (count($asiento_movimiento) > 0) {
            $suma = $asiento_movimiento->TOTAL;
        }
        return $suma;
    }


    public function rv_suma_ivap_40($asiento, $tipo_documento_06)
    {

        $suma = 0.00;
        $asiento_movimiento = WEBAsientoMovimiento::where('COD_ASIENTO', '=', $asiento->COD_ASIENTO)
            ->where('COD_ESTADO', '=', 1)
            ->where('TXT_CUENTA_CONTABLE', 'like', '4%')
            ->select(DB::raw('sum(CAN_DEBE_MN + CAN_HABER_MN) as TOTAL'))
            ->first();
        if (count($asiento_movimiento) > 0) {
            $suma = $asiento_movimiento->TOTAL;

            if ($tipo_documento_06 == '07') {
                $suma = $suma * -1;
            }

        }


        return $suma;
    }


    public function rv_suma_igv_40($asiento, $indicador_afecto, $tipo_documento_06)
    {

        $suma = 0.00;

        if ($indicador_afecto == 1) {
            $asiento_movimiento = WEBAsientoMovimiento::where('COD_ASIENTO', '=', $asiento->COD_ASIENTO)
                ->where('COD_ESTADO', '=', 1)
                ->where('TXT_CUENTA_CONTABLE', 'like', '4%')
                ->select(DB::raw('sum(CAN_DEBE_MN + CAN_HABER_MN) as TOTAL'))
                ->first();

            if (count($asiento_movimiento) > 0) {
                $suma = $asiento_movimiento->TOTAL;

                if ($tipo_documento_06 == '07') {
                    $suma = $suma * -1;
                }

            }
        }

        return $suma;
    }

    public function obtener_tabla_formato_ventas($fecha_inicio, $fecha_fin, $cod_empresa, $emitido)
    {
        $array_lista_formato = array();

        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.LISTAR_FORMATO_ASIENTOS_VENTAS
                                                            @FECHA_INICIO = ?,
                                                            @FECHA_FIN = ?,
                                                            @COD_EMPRESA = ?,
                                                            @EMITIDA = ?');

        $stmt->bindParam(1, $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(2, $fecha_fin, PDO::PARAM_STR);
        $stmt->bindParam(3, $cod_empresa, PDO::PARAM_STR);
        $stmt->bindParam(4, $emitido, PDO::PARAM_STR);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            array_push($array_lista_formato, $row);
        }

        return $array_lista_formato;
    }

    public function obtener_tabla_div_saldos_n($fecha_inicio, $fecha_fin, $cod_empresa, $ind_reporte)
    {
        $cod_centro = '';

        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.REPORTE_DIV_SALDOS
                                                            @CODEMPRESA = ?,
                                                            @FECHAINI = ?,
                                                            @FECHAFIN = ?,
                                                            @CODCENTRO = ?,
                                                            @IND_REPORTE= ?');
        $stmt->bindParam(1, $cod_empresa, PDO::PARAM_STR);
        $stmt->bindParam(2, $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(3, $fecha_fin, PDO::PARAM_STR);
        $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
        $stmt->bindParam(5, $ind_reporte, PDO::PARAM_STR);
        $stmt->execute();

        $results = [];

        do {
            // Solo continuar si este rowset es una tabla con columnas
            if ($stmt->columnCount() > 0) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Guardamos incluso si viene vacío (tabla sin registros)
                $results[] = $rows;
            }
        } while ($stmt->nextRowset());

        return $results[0];
    }

    public function obtener_tabla_orden_ventas($fecha_inicio, $fecha_fin, $cod_empresa, $tipo_reporte)
    {
        if ($tipo_reporte == 'DIV_SIN_CON_CPE_PA' or $tipo_reporte == 'DIV_SIN_CON_CPE_PB' or $tipo_reporte == 'DIV_SIN_CON_CPE_R') {

            $cod_centro = '';

            if ($tipo_reporte == 'DIV_SIN_CON_CPE_PA') {
                $IND_REPORTE = 'PA';
            } else if ($tipo_reporte == 'DIV_SIN_CON_CPE_PB') {
                $IND_REPORTE = 'PB';
            } else {
                $IND_REPORTE = 'R';
            }

            $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.REPORTE_DIV_CON_SIN_CPE
                                                            @CODEMPRESA = ?,
                                                            @FECHAINI = ?,
                                                            @FECHAFIN = ?,
                                                            @CODCENTRO = ?,
                                                            @IND_REPORTE= ?');
            $stmt->bindParam(1, $cod_empresa, PDO::PARAM_STR);
            $stmt->bindParam(2, $fecha_inicio, PDO::PARAM_STR);
            $stmt->bindParam(3, $fecha_fin, PDO::PARAM_STR);
            $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
            $stmt->bindParam(5, $IND_REPORTE, PDO::PARAM_STR);
            $tipo_reporte = '';
        } else {
            $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ORDENVENTA_REPORTES
                                                            @FECHA_INICIO = ?,
                                                            @FECHA_FIN = ?,
                                                            @COD_EMPRESA = ?,
                                                            @TIPO_REPORTE = ?');
            $stmt->bindParam(1, $fecha_inicio, PDO::PARAM_STR);
            $stmt->bindParam(2, $fecha_fin, PDO::PARAM_STR);
            $stmt->bindParam(3, $cod_empresa, PDO::PARAM_STR);

        }

        $stmt->bindParam(4, $tipo_reporte, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_tabla_integridad_ventas($fecha_inicio, $fecha_fin, $cod_empresa)
    {
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.REPORTE_INTEGRIDAD_VENTAS
                                                            @COD_EMPR = ?,
                                                            @FEC_INI = ?,
                                                            @FEC_FIN = ?');

        $stmt->bindParam(1, $cod_empresa, PDO::PARAM_STR);
        $stmt->bindParam(2, $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(3, $fecha_fin, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_tabla_integridad_liquidacion($fecha_inicio, $fecha_fin, $cod_empresa)
    {
        $styl = ',';
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.REPORTE_INTEGRIDAD_LIQUIDACION_COMPRA
                                                            @COD_EMPR = ?,
                                                            @FEC_INI = ?,
                                                            @FEC_FIN = ?,
                                                            @COD_TIPO_DOC = ?');

        $stmt->bindParam(1, $cod_empresa, PDO::PARAM_STR);
        $stmt->bindParam(2, $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(3, $fecha_fin, PDO::PARAM_STR);
        $stmt->bindParam(4, $styl, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
