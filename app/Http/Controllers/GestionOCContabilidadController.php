<?php

namespace App\Http\Controllers;

use App\Modelos\CMPTipoCambio;
use App\Modelos\CONPeriodo;
use App\Modelos\STDTipoDocumento;
use App\Modelos\WEBAsiento;
use App\Modelos\WEBCuentaContable;
use DateTime;
use Illuminate\Http\Request;
use App\Modelos\Grupoopcion;
use App\Modelos\Opcion;
use App\Modelos\Rol;
use App\Modelos\RolOpcion;
use App\Modelos\VMergeOC;
use App\Modelos\FeFormaPago;
use App\Modelos\FeDetalleDocumento;
use App\Modelos\FeDocumento;
use App\Modelos\Estado;
use App\Modelos\CMPOrden;
use App\Modelos\FeDocumentoHistorial;
use App\Modelos\SGDUsuario;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use App\Modelos\CMPCategoria;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\Archivo;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\CMPDetalleProductoAF;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\CMPReferecenciaAsoc;
use App\Modelos\FeRefAsoc;

use App\Modelos\WEBCategoriaActivoFijo;

use Greenter\Parser\DocumentParserInterface;
use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;
use Greenter\Xml\Parser\PerceptionParser;

use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use App\Traits\GeneralesTraits;
use App\Traits\ComprobanteTraits;
use App\Traits\WhatsappTraits;

use PDO;
use Hashids;
use SplFileInfo;
use trendClass;

class GestionOCContabilidadController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;


    public function actionListarComprobanteContabilidad($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista comprobantes por aprobar (Contabilidad)');
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto
        $operacion_id = 'ORDEN_COMPRA';
        //$operacion_id       =   'DOCUMENTO_INTERNO_PRODUCCION';

        $tab_id = 'oc';
        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO','ESTIBA' => 'ESTIBA');

        $combo_operacion = array('ORDEN_COMPRA' => 'ORDEN COMPRA',
            'CONTRATO' => 'CONTRATO',
            'ESTIBA' => 'ESTIBA',
            'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
            'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
            'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA',
            'DOCUMENTO_INTERNO_COMPRA' => 'DOCUMENTO INTERNO COMPRA',
            'COMISION' => 'COMISION',
            'LIQUIDACION_COMPRA_ANTICIPO' => 'LIQUIDACION DE COMPRA ANTICIPO',
            'PROVISION_GASTO' => 'PROVISION DE GASTO',
            'NOTA_CREDITO' => 'NOTA DE CREDITO',
            'NOTA_DEBITO' => 'NOTA DE DEBITO',
            'ORDEN_COMPRA_ANTICIPO' => 'ORDEN COMPRA ANTICIPO',
        );

        if (isset($request['operacion_id'])) {
            $operacion_id = $request['operacion_id'];
        }
        if (Session::has('operacion_id')) {
            $operacion_id = Session::get('operacion_id');
        }
        if (isset($request['tab_id'])) {
            $tab_id = $request['tab_id'];
        }

        $array_canjes = $this->con_array_canjes();

        if ($operacion_id == 'ORDEN_COMPRA') {
            $listadatos = $this->con_lista_cabecera_comprobante_total_cont($cod_empresa);
            $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_obs($cod_empresa);
            $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_obs_levantadas($cod_empresa);
        } else {

            if ($operacion_id == 'ORDEN_COMPRA_ANTICIPO') {
                $listadatos = $this->con_lista_cabecera_comprobante_oca_total_cont($cod_empresa);
                $listadatos_obs = $this->con_lista_cabecera_comprobante_oca_total_cont_obs($cod_empresa);
                $listadatos_obs_le = $this->con_lista_cabecera_comprobante_oca_total_cont_obs_levantadas($cod_empresa);
            } else {


                if ($operacion_id == 'CONTRATO') {
                    $listadatos = $this->con_lista_cabecera_comprobante_total_cont_contrato($cod_empresa);
                    $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_contrato_obs($cod_empresa);
                    $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_contrato_levantadas($cod_empresa);
                } else {
                    if ($operacion_id == 'NOTA_CREDITO') {
                        $listadatos = $this->con_lista_cabecera_comprobante_total_cont_nota_credito($cod_empresa);
                        $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_nota_credito_obs($cod_empresa);
                        $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_nota_credito_levantadas($cod_empresa);
                    } else {
                        if ($operacion_id == 'NOTA_DEBITO') {
                            $listadatos = $this->con_lista_cabecera_comprobante_total_cont_nota_debito($cod_empresa);
                            $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_nota_debito_obs($cod_empresa);
                            $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_nota_debito_levantadas($cod_empresa);
                        } else {
                            if ($operacion_id == 'PROVISION_GASTO') {
                                $listadatos = $this->con_lista_cabecera_comprobante_total_cont_pg($cod_empresa);
                                $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_pg_obs($cod_empresa);
                                $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_pg_levantadas($cod_empresa);
                            } else {

                                if ($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO') {
                                    $listadatos = $this->con_lista_cabecera_comprobante_total_con_liquidacion_compra_anticipo($cod_empresa);
                                    $listadatos_obs = $this->con_lista_cabecera_comprobante_total_con_liquidacion_compra_anticipo_obs($cod_empresa);
                                    $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_con_liquidacion_compra_anticipo_obs_levantadas($cod_empresa);
                                } else {

                                    if ($operacion_id == 'DOCUMENTO_INTERNO_COMPRA') {
                                        $listadatos = $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa, $operacion_id);
                                        $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa, $operacion_id);
                                        $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa, $operacion_id);
                                    } else {
                                        if ($operacion_id == 'COMISION') {

                                            $listadatos = $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa, $operacion_id);
                                            $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa, $operacion_id);
                                            $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa, $operacion_id);
                                        } else {
                                            $array_canjes = $this->con_array_canjes();
                                            if (in_array($operacion_id, $array_canjes)) {
                                                $listadatos = $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa, $operacion_id);
                                                $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa, $operacion_id);
                                                $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa, $operacion_id);
                                            }
                                        }

                                    }
                                }
                            }

                        }
                    }
                }
            }

        }
        $funcion = $this;

        return View::make('comprobante/listacontabilidad',
            [
                'listadatos' => $listadatos,
                'listadatos_obs' => $listadatos_obs,
                'listadatos_obs_le' => $listadatos_obs_le,
                'tab_id' => $tab_id,
                'funcion' => $funcion,
                'operacion_id' => $operacion_id,
                'combo_operacion' => $combo_operacion,
                'idopcion' => $idopcion,
            ]);
    }


    public function actionListarAjaxBuscarDocumentoContabilidad(Request $request)
    {

        $operacion_id = $request['operacion_id'];
        $idopcion = $request['idopcion'];

        $tab_id = 'oc';

        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        if ($operacion_id == 'ORDEN_COMPRA') {

            $listadatos = $this->con_lista_cabecera_comprobante_total_cont($cod_empresa);
            $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_obs($cod_empresa);
            $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_obs_levantadas($cod_empresa);

        } else {

            if ($operacion_id == 'ORDEN_COMPRA_ANTICIPO') {
                $listadatos = $this->con_lista_cabecera_comprobante_oca_total_cont($cod_empresa);
                $listadatos_obs = $this->con_lista_cabecera_comprobante_oca_total_cont_obs($cod_empresa);
                $listadatos_obs_le = $this->con_lista_cabecera_comprobante_oca_total_cont_obs_levantadas($cod_empresa);
            } else {
                if ($operacion_id == 'CONTRATO') {
                    $listadatos = $this->con_lista_cabecera_comprobante_total_cont_contrato($cod_empresa);
                    $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_contrato_obs($cod_empresa);
                    $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_contrato_levantadas($cod_empresa);
                } else {

                    if ($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO') {
                        $listadatos = $this->con_lista_cabecera_comprobante_total_con_liquidacion_compra_anticipo($cod_empresa);
                        $listadatos_obs = $this->con_lista_cabecera_comprobante_total_con_liquidacion_compra_anticipo_obs($cod_empresa);
                        $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_con_liquidacion_compra_anticipo_obs_levantadas($cod_empresa);
                    } else {

                        if ($operacion_id == 'NOTA_CREDITO') {
                            $listadatos = $this->con_lista_cabecera_comprobante_total_cont_nota_credito($cod_empresa);
                            $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_nota_credito_obs($cod_empresa);
                            $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_nota_credito_levantadas($cod_empresa);
                        } else {
                            if ($operacion_id == 'NOTA_DEBITO') {
                                $listadatos = $this->con_lista_cabecera_comprobante_total_cont_nota_debito($cod_empresa);
                                $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_nota_debito_obs($cod_empresa);
                                $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_nota_debito_levantadas($cod_empresa);
                            } else {

                                if ($operacion_id == 'PROVISION_GASTO') {
                                    $listadatos = $this->con_lista_cabecera_comprobante_total_cont_pg($cod_empresa);
                                    $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_pg_obs($cod_empresa);
                                    $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_pg_levantadas($cod_empresa);
                                } else {
                                    if ($operacion_id == 'COMISION') {

                                        $listadatos = $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa, $operacion_id);
                                        $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa, $operacion_id);
                                        $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa, $operacion_id);
                                    } else {
                                        $array_canjes = $this->con_array_canjes();
                                        if (in_array($operacion_id, $array_canjes)) {
                                            $listadatos = $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa, $operacion_id);
                                            $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa, $operacion_id);
                                            $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa, $operacion_id);
                                        }
                                    }
                                }

                            }
                        }

                    }

                }
            }

        }

        $procedencia = 'ADM';
        $funcion = $this;
        return View::make('comprobante/ajax/mergelistacontabilidad',
            [
                'operacion_id' => $operacion_id,
                'idopcion' => $idopcion,
                'tab_id' => $tab_id,
                'cod_empresa' => $cod_empresa,
                'listadatos' => $listadatos,
                'listadatos_obs' => $listadatos_obs,
                'listadatos_obs_le' => $listadatos_obs_le,
                'procedencia' => $procedencia,
                'ajax' => true,
                'funcion' => $funcion
            ]);
    }


    public function actionAprobarContabilidadLiquidacionCompraAnticipo($idopcion, $linea, $prefijo, $idordenpago, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idop = $this->funciones->decodificarmaestraprefijo($idordenpago, $prefijo);
        $ordenpago = $this->con_lista_comprobante_orden_pago_idoc_actual($idop);

        $idoc = $ordenpago->COD_DOCUMENTO_CTBLE;
        $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idop)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idop)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Aprobar  Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();

                $detalles = json_decode($request->input('asientosgenerados'), true);

                foreach ($detalles as $detalle) {

                    $cabeceras = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);
                    $generar = true;

                    foreach ($cabeceras as $cabecera) {

                        if ($cabecera['COD_CATEGORIA_TIPO_ASIENTO'] === 'TAS0000000000004') {
                            $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                ->where('COD_ESTADO', '=', 1)
                                ->where('TXT_GLOSA', 'LIKE', '%COMPRA%')
                                ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                ->first();
                        } else {
                            if (stripos($cabecera['TXT_GLOSA'], 'DEDUCCION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'LIKE', '%DEDUCCION%')
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                            } else {
                                if (stripos($cabecera['TXT_GLOSA'], 'PERCEPCION')) {
                                    $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                        ->where('COD_ESTADO', '=', 1)
                                        ->where('TXT_GLOSA', 'LIKE', '%PERCEPCION%')
                                        ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                        ->first();
                                } else {
                                    if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION') === false) {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    } else {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    }
                                }
                            }
                        }

                        if (empty($asiento_busqueda)) {
                            if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                                if (empty($asiento_busqueda)) {
                                    break;
                                }
                            }
                        } else {
                            break;
                        }

                        $COD_ASIENTO = $cabecera['COD_ASIENTO'];
                        $COD_EMPR = $cabecera['COD_EMPR'];
                        $COD_EMPR_CLI = $cabecera['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $cabecera['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = !empty($cabecera['COD_CATEGORIA_TIPO_DOCUMENTO']) ? $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO'] : 'TDO0000000000066';
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $cabecera['NRO_SERIE'];
                        $NRO_DOC = $cabecera['NRO_DOC'];
                        $COD_CENTRO = $cabecera['COD_CENTRO'];
                        $COD_PERIODO = $cabecera['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $cabecera['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $cabecera['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $cabecera['NRO_ASIENTO'];
                        $FEC_ASIENTO = $cabecera['FEC_ASIENTO'];
                        $TXT_GLOSA = $cabecera['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $cabecera['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $cabecera['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $cabecera['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $cabecera['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $cabecera['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $cabecera['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $cabecera['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $cabecera['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $cabecera['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $cabecera['IND_EXTORNO'];
                        $IND_ANULADO = $cabecera['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $cabecera['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $cabecera['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $cabecera['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $cabecera['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $cabecera['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $cabecera['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $cabecera['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $cabecera['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $cabecera['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $cabecera['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $cabecera['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $cabecera['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $cabecera['FEC_DETRACCION'];
                        $NRO_DETRACCION = $cabecera['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $cabecera['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $cabecera['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $cabecera['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $cabecera['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $cabecera['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $cabecera['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $cabecera['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $cabecera['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $cabecera['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $cabecera['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $cabecera['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $cabecera['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $cabecera['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $cabecera['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $cabecera['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $cabecera['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $cabecera['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $cabecera['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $cabecera['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $cabecera['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $cabecera['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();

                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if ($generar) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                'CEN0000000000001',
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $fedocumento_ap = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->where('COD_ESTADO', '<>', 'ETM0000000000004')->first();
                if (count($fedocumento_ap) > 0) {
                    return Redirect::back()->with('errorurl', 'El documento esta aprobado');
                }


                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idop)->where('DOCUMENTO_ITEM', '=', $linea)->first();

                if ($fedocumento->ind_observacion == 1) {
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }


                $descripcion = $request['descripcion'];
                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();

                }

                $filespdf = $request['otros'];
                if (!is_null($filespdf)) {
                    //PDF
                    foreach ($filespdf as $file) {

                        //
                        $contadorArchivos = Archivo::count();

                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta = $this->prefijo_empresa($ordenpago->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordenpago->NRO_DOC;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf = $contadorArchivos . '-' . $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilepdf;
                        copy($file->getRealPath(), $rutacompleta);
                        $path = $rutacompleta;

                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $ordenpago->COD_AUTORIZACION;
                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = 'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS CONTABILIDAD';
                        $dcontrol->URL_ARCHIVO = $path;
                        $dcontrol->SIZE = filesize($file);
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                    }
                }


                FeDocumento::where('ID_DOCUMENTO', $idop)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADO',
                            'ind_email_clap' => 0,
                            'fecha_ap' => $this->fechaactual,
                            'usuario_ap' => Session::get('usuario')->id
                        ]
                    );


                //esto pasar para contabilidad


                $conexionbd = 'sqlsrv';
                if ($ordenpago->COD_CENTRO == 'CEN0000000000004') { //rioja
                    $conexionbd = 'sqlsrv_r';
                } else {
                    if ($ordenpago->COD_CENTRO == 'CEN0000000000006') { //bellavista
                        $conexionbd = 'sqlsrv_b';
                    }
                }

                DB::connection($conexionbd)->table('CMP.DOCUMENTO_CTBLE')
                    ->where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)
                    ->update(
                        [
                            'IND_NOTIFICACION_CLIENTE' => 1
                        ]);

                //enviar tablas de fe_documento y fe_detalledocuemto
                if ($ordenpago->COD_CENTRO == 'CEN0000000000004' || $ordenpago->COD_CENTRO == 'CEN0000000000006') { //rioja
                    //dd($conexionbd);
                    //FE_DOCUENTO
                    $referenciaAsocQuery = FeDocumento::select('ID_DOCUMENTO'
                        , 'DOCUMENTO_ITEM'
                        , 'RUC_PROVEEDOR'
                        , 'RZ_PROVEEDOR'
                        , 'TIPO_CLIENTE'
                        , 'ID_CLIENTE'
                        , 'NOMBRE_CLIENTE'
                        , 'DIRECCION_CLIENTE'
                        , 'NUM_DOC_VENTA'
                        , 'SERIE'
                        , 'NUMERO'
                        , 'ID_TIPO_DOC'
                        , 'FEC_VENTA'
                        , 'FEC_VENCI_PAGO'
                        , 'FORMA_PAGO'
                        , 'FORMA_PAGO_DIAS'
                        , 'MONEDA'
                        , 'VALOR_TIPO_CAMBIO'
                        , 'VALOR_IGV_ORIG'
                        , 'VALOR_IGV_SOLES'
                        , 'SUB_TOTAL_VENTA_ORIG'
                        , 'SUB_TOTAL_VENTA_SOLES'
                        , 'TOTAL_VENTA_ORIG'
                        , 'TOTAL_VENTA_SOLES'
                        , 'V_EXONERADO'
                        , 'ESTADO'
                        , 'NUM_DOC_ELECT'
                        , 'ES_TRANS_GRATUITA'
                        , 'DES_COM'
                        , 'ES_ANULADO'
                        , 'ENVIADO_EMAIL'
                        , 'ENVIADO_EXTERNO'
                        , 'NRO_ORDEN_COMP'
                        , 'NUM_GUIA'
                        , 'TIPO_DOC_REL'
                        , 'CON_DETRACCION'
                        , 'OBSERVACION'
                        , 'HORA_EMISION'
                        , 'ES_TURISTICO'
                        , 'ES_EXONERADO'
                        , 'GUIA_CLIENTE'
                        , 'GLOSA_DETALE'
                        , 'VALIDACION_SUNAT'
                        , 'ID_MOTIVO_EMISION'
                        , 'MOTIVO_EMISION'
                        , 'MONTO_IMP_BOLSA'
                        , 'MONTO_DETRACCION'
                        , 'MONTO_RETENCION'
                        , 'MONTO_NETO_PAGO'
                        , 'DESCUENTO_I'
                        , 'DESCUENTO'
                        , 'IMPUESTO_2'
                        , 'TIPO_DETRACCION'
                        , 'PORC_DETRACCION'
                        , 'MONTO_ANTICIPO'
                        , 'COD_ESTADO'
                        , 'TXT_ESTADO'
                        , 'COD_EMPR'
                        , 'TXT_EMPR'
                        , 'COD_CONTACTO'
                        , 'TXT_CONTACTO'
                        , 'TXT_PROCEDENCIA'
                        , 'ARCHIVO_XML'
                        , 'ARCHIVO_CDR'
                        , 'ARCHIVO_PDF'
                        , 'success'
                        , 'message'
                        , 'estadoCp'
                        , 'nestadoCp'
                        , 'estadoRuc'
                        , 'nestadoRuc'
                        , 'condDomiRuc'
                        , 'ncondDomiRuc'
                        , 'CODIGO_CDR'
                        , 'RESPUESTA_CDR'
                        , 'ind_ruc'
                        , 'ind_rz'
                        , 'ind_moneda'
                        , 'ind_total'
                        , 'ind_cantidaditem'
                        , 'ind_formapago'
                        , 'ind_errototal'
                        , 'dni_usuariocontacto'
                        , 'usuario_pa'
                        , 'usuario_uc'
                        , 'usuario_ap'
                        , 'usuario_pr'
                        , 'usuario_ex'
                        , 'mensaje_exuc'
                        , 'mensaje_exap'
                        , 'mensaje_exadm'
                        , 'ind_email_uc'
                        , 'ind_email_ap'
                        , 'ind_email_adm'
                        , 'ind_email_clap'
                        , 'ind_email_ba'
                        , 'ind_observacion'
                        , 'area_observacion'
                        , 'OPERACION'
                        , 'PERCEPCION'
                        , 'usuario_tes'
                        , 'LOTE')
                        ->where('ID_DOCUMENTO', '=', $idop)
                        ->get();


                    //dd($referenciaAsocQuery);
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsert = $referenciaAsocQuery->toArray();
                    //dd($dataToInsert);

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DOCUMENTO')->insert($dataToInsert);

                    //FE_DETALLE_DOCUENTO
                    $referenciaAsocQueryd = FeDetalleDocumento::select('*')
                        ->where('ID_DOCUMENTO', '=', $idop)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertd = $referenciaAsocQueryd->toArray();

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DETALLE_DOCUMENTO')->insert($dataToInsertd);

                    //CMPDocAsociarCompra
                    $referenciaAsocQueryac = CMPDocAsociarCompra::select('COD_ORDEN', 'COD_CATEGORIA_DOCUMENTO', 'NOM_CATEGORIA_DOCUMENTO', 'IND_OBLIGATORIO', 'TXT_FORMATO', 'TXT_ASIGNADO', 'COD_USUARIO_CREA_AUD', 'COD_ESTADO', 'TIP_DOC')
                        ->where('COD_ORDEN', '=', $idop)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInserac = $referenciaAsocQueryac->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('CMP.DOC_ASOCIAR_COMPRA')->insert($dataToInserac);


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                //geolocalización


                DB::commit();

                Session::flash('operacion_id', 'LIQUIDACION_COMPRA_ANTICIPO');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $idoc . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'LIQUIDACION_COMPRA_ANTICIPO');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

        } else {

            $detalleordencompra = $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idop)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idop)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();

            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $idop)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();

            $archivos = $this->lista_archivos_total($idop, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idop, $fedocumento->DOCUMENTO_ITEM);


            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idop)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();


            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            if ($fedocumento->TXT_INGRESO_LIQ == 'SI') {
                $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                    ->where('COD_ESTADO', '=', 1)
                    ->whereIn('COD_CATEGORIA', ['DCC0000000000039', 'DCC0000000000040', 'DCC0000000000041', 'DCC0000000000044', 'DCC0000000000045', 'DCC0000000000049'])
                    ->get();
            } else {
                if ($ordenpago->COD_CENTRO == 'CEN0000000000004' || $ordenpago->COD_CENTRO == 'CEN0000000000006') { //rioja o bellavista
                    $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                        ->where('COD_ESTADO', '=', 1)
                        ->whereIn('COD_CATEGORIA', ['DCC0000000000041', 'DCC0000000000044', 'DCC0000000000045', 'DCC0000000000046', 'DCC0000000000049'])
                        ->get();
                } else {
                    $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                        ->where('COD_ESTADO', '=', 1)
                        ->whereIn('COD_CATEGORIA', ['DCC0000000000041', 'DCC0000000000044', 'DCC0000000000045', 'DCC0000000000049'])
                        ->get();
                }
            }

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idop)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //Archivo multiple


            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-fileliquidacioncompraanticipo', ['file' => $archivo->NOMBRE_ARCHIVO]);
            }
            $initialPreviewConfig = [];
            foreach ($archivospdf as $key => $archivo) {
                $initialPreviewConfig[] = [
                    'type' => "pdf",
                    'caption' => $archivo->NOMBRE_ARCHIVO,
                    'downloadUrl' => route('serve-fileliquidacioncompraanticipo', ['file' => $archivo->NOMBRE_ARCHIVO])
                ];
            }

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($anio_defecto, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio_defecto, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
            $periodo_defecto = $array_periodo_pc->COD_PERIODO;

            $sel_tipo_descuento = '';
            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $cod_contable = $fedocumento->ID_DOCUMENTO;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $centro_costo = '';
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            $asiento_compra = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':igv' => $igv,
                    ':ind_recalcular' => $ind_recalcular,
                    ':centro_costo' => $centro_costo,
                    ':ind_igv' => $ind_igv,
                    ':usuario' => $usuario
                ]
            );

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

            if (count($asiento_compra) <= 2) {
                array_push($asiento_compra, []);
            }

            //if ($respuesta === 'ASIENTO CORRECTO') {
            if (!empty($asiento_compra)) {

                $ind_reversion = 'R';

                $asiento_existe_reparable = WEBAsiento::where('COD_ESTADO', '=', 1)
                    ->where('TXT_REFERENCIA', '=', $cod_contable)
                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', 'TAS0000000000007')
                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                    ->where('TXT_TIPO_REFERENCIA', 'NOT LIKE', "%NAVASOFT%")
                    ->first();

                if ($asiento_existe_reparable) {
                    $asiento_reparable_reversion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':ind_reversion' => $ind_reversion,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_reparable_reversion = [[], [], []];
                }

                if ($fedocumento->MONTO_ANTICIPO_DESC > 0.0000) {
                    $asiento_deduccion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_DEDUCCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':igv' => $igv,
                            ':ind_recalcular' => $ind_recalcular,
                            ':centro_costo' => $centro_costo,
                            ':ind_igv' => $ind_igv,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_deduccion = [[], [], []];
                }

                if ($fedocumento->PERCEPCION > 0.0000) {
                    $asiento_percepcion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_PERCEPCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_percepcion = [[], [], []];
                }
            }

            $ind_reversion = 'N';

            $asiento_reparable = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':ind_recalcular' => $ind_recalcular,
                    ':ind_reversion' => $ind_reversion,
                    ':usuario' => $usuario
                ]
            );

            if (count($asiento_reparable) <= 2) {
                array_push($asiento_reparable, []);
            }
            //dd($asiento_compra, $asiento_reparable, $asiento_percepcion, $asiento_reparable_reversion, $asiento_deduccion);

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');
            $funciones = $this;

            //dd($initialPreviewConfig);

            return View::make('comprobante/aprobarconliquidacioncompraanticipo',
                [
                    'fedocumento' => $fedocumento,
                    'ordenpago' => $ordenpago,
                    'ordencompra' => $ordencompra,
                    'initialPreview' => json_encode($initialPreview),
                    'initialPreviewConfig' => json_encode($initialPreviewConfig),

                    //NUEVO
                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'defecto_anio' => $anio_defecto,
                    'defecto_periodo' => $periodo_defecto,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,
                    'combo_descuento' => $combo_descuento,
                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    'asiento_compra' => $asiento_compra,
                    'asiento_reparable_reversion' => $asiento_reparable_reversion,
                    'asiento_deduccion' => $asiento_deduccion,
                    'asiento_percepcion' => $asiento_percepcion,
                    'asiento_reparable' => $asiento_reparable,
                    // NUEVO

                    'linea' => $linea,
                    'archivos' => $archivos,
                    'archivosanulados' => $archivosanulados,

                    'trabajador' => $trabajador,
                    'documentoscompra' => $documentoscompra,
                    'totalarchivos' => $totalarchivos,


                    'documentohistorial' => $documentohistorial,
                    'archivospdf' => $archivospdf,
                    'detalleordencompra' => $detalleordencompra,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionAgregarObservacionContabilidadLiquidacionCompraAnticipo($idopcion, $linea, $prefijo, $idordenpago, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idop = $this->funciones->decodificarmaestraprefijo($idordenpago, $prefijo);
        $ordenpago = $this->con_lista_comprobante_orden_pago_idoc_actual($idop);

        $idoc = $ordenpago->COD_DOCUMENTO_CTBLE;

        $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idop)->where('DOCUMENTO_ITEM', '=', $linea)->where('TXT_PROCEDENCIA', '<>', 'SUE')->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idop)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Observar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idop)->where('DOCUMENTO_ITEM', '=', $linea)->where('TXT_PROCEDENCIA', '<>', 'SUE')->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivoob'];


                if ($fedocumento->ind_observacion == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }

                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-administracion-liquidacion-compra-anticipo/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordenpago)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }

                foreach ($archivoob as $index => $item) {


                    $docu_asoci = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idop)->where('COD_ESTADO', '=', 1)
                        ->where('COD_CATEGORIA_DOCUMENTO', '=', $item)->first();
                    if (count($docu_asoci) > 0) {

                        Archivo::where('ID_DOCUMENTO', '=', $idop)
                            ->where('ACTIVO', '=', '1')
                            ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                            ->where('TIPO_ARCHIVO', '=', $item)
                            ->update(
                                [
                                    'ACTIVO' => 0,
                                    'FECHA_MOD' => $this->fechaactual,
                                    'USUARIO_MOD' => Session::get('usuario')->id
                                ]
                            );

                    } else {

                        $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                        $docasociar = new CMPDocAsociarCompra;
                        $docasociar->COD_ORDEN = $idop;
                        $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                        $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                        $docasociar->IND_OBLIGATORIO = 0;
                        $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                        $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                        $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                        $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                        $docasociar->COD_ESTADO = 1;
                        $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
                        $docasociar->save();

                    }

                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR CONTABILIDAD';
                $documento->MENSAJE = $descripcion;
                $documento->save();


                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'OBSERVADO POR CONTABILIDAD');
                //geolocalización

                FeDocumento::where('ID_DOCUMENTO', $idop)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ind_observacion' => 1,
                            'TXT_OBSERVADO' => 'OBSERVADO',
                            'area_observacion' => 'CONT'
                        ]
                    );


                DB::commit();

                Session::flash('operacion_id', 'LIQUIDACION_COMPRA_ANTICIPO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $idop . ' OBSERVADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();

                Session::flash('operacion_id', 'LIQUIDACION_COMPRA_ANTICIPO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();

            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            //$archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);


            $codigo_sunat = 'N';
            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();


            return View::make('comprobante/observaradministracioncontrato',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }


    public function actionListarAprobarUsuarioContacto($idopcion, Request $request)
    {

        if ($_POST) {
            $msjarray = array();
            $respuesta = json_decode($request['pedido'], true);
            $conts = 0;
            $contw = 0;
            $contd = 0;

            //dd("hola");
            foreach ($respuesta as $obj) {

                $pedido_id = $obj['id'];
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                if ($fedocumento->COD_ESTADO == 'ETM0000000000003') {

                    FeDocumento::where('ID_DOCUMENTO', $pedido_id)
                        ->update(
                            [
                                'COD_ESTADO' => 'ETM0000000000005',
                                'TXT_ESTADO' => 'APROBADOO',
                                'ind_email_adm' => 0,
                                'fecha_pr' => $this->fechaactual,
                                'usuario_pr' => Session::get('usuario')->id
                            ]
                        );

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                    $documento->MENSAJE = '';
                    $documento->save();

                    //geolocalizacion
                    $device_info = $request['device_info'];
                    $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                    //geolocalización


                    //whatsaap para administracion
                    $fedocumento_w = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                    $ordencompra = CMPOrden::where('COD_ORDEN', '=', $pedido_id)->first();

                    $empresa = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR)->first();
                    $mensaje = 'COMPROBANTE : ' . $fedocumento_w->ID_DOCUMENTO
                        . '%0D%0A' . 'EMPRESA : ' . $empresa->NOM_EMPR . '%0D%0A'
                        . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_CLIENTE . '%0D%0A'
                        . 'ESTADO : ' . $fedocumento_w->TXT_ESTADO . '%0D%0A';


                    $msjarray[] = array("data_0" => $fedocumento->ID_DOCUMENTO,
                        "data_1" => 'COMPROBANTE APROBADO POR CONTABILIDAD',
                        "tipo" => 'S');
                    $conts = $conts + 1;
                    $codigo = $fedocumento->ID_DOCUMENTO;

                } else {
                    /**** ERROR DE PROGRMACION O SINTAXIS ****/
                    $msjarray[] = array("data_0" => $fedocumento->ID_DOCUMENTO,
                        "data_1" => 'ESTE COMPROBANTE YA ESTA APROBADO POR CONTABILIDAD',
                        "tipo" => 'D');
                    $contd = $contd + 1;

                }

            }


            /************** MENSAJES DEL DETALLE PEDIDO  ******************/
            $msjarray[] = array("data_0" => $conts,
                "data_1" => 'COMPROBANTE APROBADO POR CONTABILIDAD',
                "tipo" => 'TS');

            $msjarray[] = array("data_0" => $contw,
                "data_1" => 'COMPROBANTE APROBADO POR CONTABILIDAD',
                "tipo" => 'TW');

            $msjarray[] = array("data_0" => $contd,
                "data_1" => 'COMPROBANTES ERRADOS',
                "tipo" => 'TD');

            $msjjson = json_encode($msjarray);


            return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('xmlmsj', $msjjson);


        }
    }


    public function actionExtornarAprobar($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Extornar  Comprobante');


        if ($_POST) {
            $descripcion = $request['descripcion'];

            FeDocumento::where('ID_DOCUMENTO', $idoc)->where('COD_ESTADO', '<>', 'ETM0000000000006')
                ->update(
                    [
                        'COD_ESTADO' => 'ETM0000000000006',
                        'TXT_ESTADO' => 'RECHAZADO',
                        'ind_email_ba' => 0,
                        'mensaje_exuc' => $descripcion,
                        'mensaje_exap' => '',
                        'mensaje_exadm' => '',
                        'fecha_ex' => $this->fechaactual,
                        'usuario_ex' => Session::get('usuario')->id
                    ]
                );


            $ordencompra_t = CMPOrden::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->first();
            //HISTORIAL DE DOCUMENTO APROBADO
            $documento = new FeDocumentoHistorial;
            $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
            $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
            $documento->FECHA = $this->fechaactual;
            $documento->USUARIO_ID = Session::get('usuario')->id;
            $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
            $documento->TIPO = 'RECHAZADO POR CONTABILIDAD';
            $documento->MENSAJE = '';
            $documento->save();

            //geolocalizacion
            $device_info = $request['device_info'];
            $this->con_datos_de_la_pc($device_info, $fedocumento, 'RECHAZADO POR CONTABILIDAD');
            //geolocalización


            return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobantes Lote: ' . $ordencompra->COD_ORDEN . ' EXTORNADA con EXITO');

        } else {


            return View::make('comprobante/extornarcontabilidad',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'idopcion' => $idopcion,
                    'linea' => $linea,

                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionObtenerPeriodoTipoCambio(Request $request)
    {
        $fecha = $request->input('fecha');

        $dt = new DateTime($fecha);

        $tipoCambio = CMPTipoCambio::where('FEC_CAMBIO', '=', $dt)
            ->where('COD_ESTADO', '=', 1)
            ->first();

        $periodo = CONPeriodo::where('COD_ANIO', '=', $dt->format("Y"))
            ->where('COD_MES', '=', $dt->format("m"))
            ->where('COD_EMPR', '=', Session::get('empresas')->COD_EMPR)
            ->where('COD_ESTADO', '=', 1)
            ->first();

        $codPeriodo = '';
        $codAnio = '';
        $tipoCambioVenta = 0.0000;

        if (isset($periodo)) {
            $codPeriodo = $periodo->COD_PERIODO;
            $codAnio = $periodo->COD_ANIO;
        }

        if (isset($periodo)) {
            $tipoCambioVenta = $tipoCambio->CAN_VENTA;
        }

        return response()->json([
            'status' => 'success',
            'tipoCambio' => $tipoCambioVenta,
            'periodo' => $codPeriodo,
            'anio' => $codAnio,
        ]);

    }

    public function actionAprobarContabilidad($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/


        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $detalleordencompraaf = $this->con_lista_detalle_comprobante_idoc_actual_af($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Aprobar Comprobante');

        if ($_POST) {

            $fedocumento_ap = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->where('COD_ESTADO', '<>', 'ETM0000000000003')->first();
            if (count($fedocumento_ap) > 0) {
                return Redirect::back()->with('errorurl', 'El documento esta aprobado');
            }

            try {

                DB::beginTransaction();

                $detalles = json_decode($request->input('asientosgenerados'), true);

                foreach ($detalles as $detalle) {

                    $cabeceras = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);
                    $generar = true;

                    foreach ($cabeceras as $cabecera) {

                        if ($cabecera['COD_CATEGORIA_TIPO_ASIENTO'] === 'TAS0000000000004') {
                            $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                ->where('COD_ESTADO', '=', 1)
                                ->where('TXT_GLOSA', 'LIKE', '%COMPRA%')
                                ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                ->first();
                        } else {
                            if (stripos($cabecera['TXT_GLOSA'], 'DEDUCCION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'LIKE', '%DEDUCCION%')
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                            } else {
                                if (stripos($cabecera['TXT_GLOSA'], 'PERCEPCION')) {
                                    $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                        ->where('COD_ESTADO', '=', 1)
                                        ->where('TXT_GLOSA', 'LIKE', '%PERCEPCION%')
                                        ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                        ->first();
                                } else {
                                    if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION') === false) {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    } else {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    }
                                }
                            }
                        }

                        if (empty($asiento_busqueda)) {
                            if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                                if (empty($asiento_busqueda)) {
                                    break;
                                }
                            }
                        } else {
                            break;
                        }

                        $COD_ASIENTO = $cabecera['COD_ASIENTO'];
                        $COD_EMPR = $cabecera['COD_EMPR'];
                        $COD_EMPR_CLI = $cabecera['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $cabecera['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = !empty($cabecera['COD_CATEGORIA_TIPO_DOCUMENTO']) ? $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO'] : 'TDO0000000000066';
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $cabecera['NRO_SERIE'];
                        $NRO_DOC = $cabecera['NRO_DOC'];
                        $COD_CENTRO = $cabecera['COD_CENTRO'];
                        $COD_PERIODO = $cabecera['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $cabecera['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $cabecera['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $cabecera['NRO_ASIENTO'];
                        $FEC_ASIENTO = $cabecera['FEC_ASIENTO'];
                        $TXT_GLOSA = $cabecera['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $cabecera['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $cabecera['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $cabecera['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $cabecera['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $cabecera['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $cabecera['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $cabecera['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $cabecera['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $cabecera['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $cabecera['IND_EXTORNO'];
                        $IND_ANULADO = $cabecera['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $cabecera['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $cabecera['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $cabecera['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $cabecera['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $cabecera['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $cabecera['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $cabecera['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $cabecera['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $cabecera['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $cabecera['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $cabecera['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $cabecera['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $cabecera['FEC_DETRACCION'];
                        $NRO_DETRACCION = $cabecera['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $cabecera['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $cabecera['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $cabecera['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $cabecera['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $cabecera['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $cabecera['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $cabecera['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $cabecera['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $cabecera['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $cabecera['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $cabecera['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $cabecera['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $cabecera['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $cabecera['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $cabecera['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $cabecera['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $cabecera['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $cabecera['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $cabecera['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $cabecera['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $cabecera['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();

                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if ($generar) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                'CEN0000000000001',
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();

                if ($fedocumento->ind_observacion == 1) {
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }

                $descripcion = $request['descripcion'];

                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();

                    //LE LLEGA AL USUARIO DE CONTACTO
                    $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();
                    $empresa = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR)->first();
                    $mensaje = 'COMPROBANTE: ' . $fedocumento->ID_DOCUMENTO
                        . '%0D%0A' . 'EMPRESA : ' . $empresa->NOM_EMPR . '%0D%0A'
                        . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_CLIENTE . '%0D%0A'
                        . 'ESTADO : ' . $fedocumento->TXT_ESTADO . '%0D%0A'
                        . 'RECOMENDACION : ' . $descripcion . '%0D%0A';
                }

                $filespdf = $request['otros'];

                if (!is_null($filespdf)) {
                    //PDF
                    foreach ($filespdf as $file) {

                        //
                        $contadorArchivos = Archivo::count();

                        $nombre = $ordencompra->COD_ORDEN . '-' . $file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordencompra->NRO_DOCUMENTO_CLIENTE;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf = $contadorArchivos . '-' . $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilepdf;
                        copy($file->getRealPath(), $rutacompleta);
                        $path = $rutacompleta;

                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $ordencompra->COD_ORDEN;
                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = 'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS CONTABILIDAD';
                        $dcontrol->URL_ARCHIVO = $path;
                        $dcontrol->SIZE = filesize($file);
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                        //dd($nombre);
                    }
                }

                $nro_cuenta_contable = $request['nro_cuenta_contable'];

                FeDocumento::where('ID_DOCUMENTO', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADOO',
                            'NRO_CUENTA' => $nro_cuenta_contable,
                            'ind_email_adm' => 0,
                            'fecha_pr' => $this->fechaactual,
                            'usuario_pr' => Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                //geolocalización


                //whatsaap para administracion
                $fedocumento_w = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $ordencompra = CMPOrden::where('COD_ORDEN', '=', $pedido_id)->first();

                $empresa = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR)->first();
                $mensaje = 'COMPROBANTE : ' . $fedocumento_w->ID_DOCUMENTO
                    . '%0D%0A' . 'EMPRESA : ' . $empresa->NOM_EMPR . '%0D%0A'
                    . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_CLIENTE . '%0D%0A'
                    . 'ESTADO : ' . $fedocumento_w->TXT_ESTADO . '%0D%0A';


                $orden = CMPOrden::where('COD_ORDEN', '=', $pedido_id)->first();
                $conexionbd = 'sqlsrv';
                if ($orden->COD_CENTRO == 'CEN0000000000004') { //rioja
                    $conexionbd = 'sqlsrv_r';
                } else {
                    if ($orden->COD_CENTRO == 'CEN0000000000006') { //bellavista
                        $conexionbd = 'sqlsrv_b';
                    }
                }

                DB::connection($conexionbd)->table('CMP.ORDEN')
                    ->where('COD_ORDEN', $orden->COD_ORDEN)
                    ->update(['COD_OPERACION' => 1, 'FEC_USUARIO_MODIF_AUD' => $this->hoy]);


                //enviar tablas de fe_documento y fe_detalledocuemto
                if ($orden->COD_CENTRO == 'CEN0000000000004' || $orden->COD_CENTRO == 'CEN0000000000006') { //rioja
                    //dd($conexionbd);
                    //FE_DOCUENTO
                    $referenciaAsocQuery = FeDocumento::select('ID_DOCUMENTO'
                        , 'DOCUMENTO_ITEM'
                        , 'RUC_PROVEEDOR'
                        , 'RZ_PROVEEDOR'
                        , 'TIPO_CLIENTE'
                        , 'ID_CLIENTE'
                        , 'NOMBRE_CLIENTE'
                        , 'DIRECCION_CLIENTE'
                        , 'NUM_DOC_VENTA'
                        , 'SERIE'
                        , 'NUMERO'
                        , 'ID_TIPO_DOC'
                        , 'FEC_VENTA'
                        , 'FEC_VENCI_PAGO'
                        , 'FORMA_PAGO'
                        , 'FORMA_PAGO_DIAS'
                        , 'MONEDA'
                        , 'VALOR_TIPO_CAMBIO'
                        , 'VALOR_IGV_ORIG'
                        , 'VALOR_IGV_SOLES'
                        , 'SUB_TOTAL_VENTA_ORIG'
                        , 'SUB_TOTAL_VENTA_SOLES'
                        , 'TOTAL_VENTA_ORIG'
                        , 'TOTAL_VENTA_SOLES'
                        , 'V_EXONERADO'
                        , 'ESTADO'
                        , 'NUM_DOC_ELECT'
                        , 'ES_TRANS_GRATUITA'
                        , 'DES_COM'
                        , 'ES_ANULADO'
                        , 'ENVIADO_EMAIL'
                        , 'ENVIADO_EXTERNO'
                        , 'NRO_ORDEN_COMP'
                        , 'NUM_GUIA'
                        , 'TIPO_DOC_REL'
                        , 'CON_DETRACCION'
                        , 'OBSERVACION'
                        , 'HORA_EMISION'
                        , 'ES_TURISTICO'
                        , 'ES_EXONERADO'
                        , 'GUIA_CLIENTE'
                        , 'GLOSA_DETALE'
                        , 'VALIDACION_SUNAT'
                        , 'ID_MOTIVO_EMISION'
                        , 'MOTIVO_EMISION'
                        , 'MONTO_IMP_BOLSA'
                        , 'MONTO_DETRACCION'
                        , 'MONTO_RETENCION'
                        , 'MONTO_NETO_PAGO'
                        , 'DESCUENTO_I'
                        , 'DESCUENTO'
                        , 'IMPUESTO_2'
                        , 'TIPO_DETRACCION'
                        , 'PORC_DETRACCION'
                        , 'MONTO_ANTICIPO'
                        , 'COD_ESTADO'
                        , 'TXT_ESTADO'
                        , 'COD_EMPR'
                        , 'TXT_EMPR'
                        , 'COD_CONTACTO'
                        , 'TXT_CONTACTO'
                        , 'TXT_PROCEDENCIA'
                        , 'ARCHIVO_XML'
                        , 'ARCHIVO_CDR'
                        , 'ARCHIVO_PDF'
                        , 'success'
                        , 'message'
                        , 'estadoCp'
                        , 'nestadoCp'
                        , 'estadoRuc'
                        , 'nestadoRuc'
                        , 'condDomiRuc'
                        , 'ncondDomiRuc'
                        , 'CODIGO_CDR'
                        , 'RESPUESTA_CDR'
                        , 'ind_ruc'
                        , 'ind_rz'
                        , 'ind_moneda'
                        , 'ind_total'
                        , 'ind_cantidaditem'
                        , 'ind_formapago'
                        , 'ind_errototal'
                        , 'dni_usuariocontacto'
                        , 'usuario_pa'
                        , 'usuario_uc'
                        , 'usuario_ap'
                        , 'usuario_pr'
                        , 'usuario_ex'
                        , 'mensaje_exuc'
                        , 'mensaje_exap'
                        , 'mensaje_exadm'
                        , 'ind_email_uc'
                        , 'ind_email_ap'
                        , 'ind_email_adm'
                        , 'ind_email_clap'
                        , 'ind_email_ba'
                        , 'ind_observacion'
                        , 'area_observacion'
                        , 'OPERACION'
                        , 'PERCEPCION'
                        , 'usuario_tes'
                        , 'LOTE')
                        ->where('ID_DOCUMENTO', '=', $orden->COD_ORDEN)
                        ->get();


                    //dd($referenciaAsocQuery);
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsert = $referenciaAsocQuery->toArray();
                    //dd($dataToInsert);

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DOCUMENTO')->insert($dataToInsert);

                    //FE_DETALLE_DOCUENTO
                    $referenciaAsocQueryd = FeDetalleDocumento::select('*')
                        ->where('ID_DOCUMENTO', '=', $orden->COD_ORDEN)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertd = $referenciaAsocQueryd->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DETALLE_DOCUMENTO')->insert($dataToInsertd);


                    //FE_FORMAPAGO
                    $referenciaAsocQueryfp = FeFormaPago::select('ID_DOCUMENTO', 'DOCUMENTO_ITEM', 'ID_CUOTA', 'ID_MONEDA', 'MONTO_CUOTA', 'FECHA_PAGO')
                        ->where('ID_DOCUMENTO', '=', $orden->COD_ORDEN)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    //$dataToInsertfp = $referenciaAsocQueryfp->toArray();


                    $dataToInsertfp = $referenciaAsocQueryfp->map(function ($item) {
                        if ($item['FECHA_PAGO']) {
                            $item['FECHA_PAGO'] = date('Ymd', strtotime($item['FECHA_PAGO']));
                        }
                        return $item;
                    })->toArray();

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_FORMAPAGO')->insert($dataToInsertfp);

                }


                DB::commit();
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {


            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
            $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detalleordencompraaf = $this->con_lista_detalle_comprobante_idoc_actual_af($idoc);

            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            if ($fedocumento->nestadoCp === null) {

                //dd("hola");
                $rh = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)
                    ->where('COD_ESTADO', '=', 1)
                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                    ->get();
                $fechaemision = date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');

                $token = '';
                if ($prefijocarperta == 'II') {
                    $token = $this->generartoken_ii();
                } else {
                    $token = $this->generartoken_is();
                }


                //$numero              =      $fedocumento->NUMERO;
                $numero = ltrim($fedocumento->NUMERO, '0');

                //dd($numero);

                if (count($rh) <= 0) {
                    //FACTURA
                    $rvalidar = $this->validar_xml($token,
                        $fedocumento->ID_CLIENTE,
                        $fedocumento->RUC_PROVEEDOR,
                        $fedocumento->ID_TIPO_DOC,
                        $fedocumento->SERIE,
                        $numero,
                        $fechaemision,
                        $fedocumento->TOTAL_VENTA_ORIG);
                } else {
                    //RECIBO POR HONORARIO
                    $rvalidar = $this->validar_xml($token,
                        $fedocumento->ID_CLIENTE,
                        $fedocumento->RUC_PROVEEDOR,
                        $fedocumento->ID_TIPO_DOC,
                        $fedocumento->SERIE,
                        $numero,
                        $fechaemision,
                        $fedocumento->TOTAL_VENTA_ORIG + $fedocumento->MONTO_RETENCION);
                }

                $arvalidar = json_decode($rvalidar, true);
                if (isset($arvalidar['success'])) {

                    if ($arvalidar['success']) {

                        $datares = $arvalidar['data'];
                        if (!isset($datares['estadoCp'])) {
                            return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                        }

                        $estadoCp = $datares['estadoCp'];


                        $tablaestacp = Estado::where('tipo', '=', 'estadoCp')->where('codigo', '=', $estadoCp)->first();
                        //dd($tablaestacp);
                        $estadoRuc = '';
                        $txtestadoRuc = '';
                        $estadoDomiRuc = '';
                        $txtestadoDomiRuc = '';

                        if (isset($datares['estadoRuc'])) {
                            $tablaestaruc = Estado::where('tipo', '=', 'estadoRuc')->where('codigo', '=', $datares['estadoRuc'])->first();
                            $estadoRuc = $tablaestaruc->codigo;
                            $txtestadoRuc = $tablaestaruc->nombre;
                        }
                        if (isset($datares['condDomiRuc'])) {
                            $tablaestaDomiRuc = Estado::where('tipo', '=', 'condDomiRuc')->where('codigo', '=', $datares['condDomiRuc'])->first();
                            $estadoDomiRuc = $tablaestaDomiRuc->codigo;
                            $txtestadoDomiRuc = $tablaestaDomiRuc->nombre;
                        }


                        FeDocumento::where('ID_DOCUMENTO', '=', $ordencompra->COD_ORDEN)
                            ->update(
                                [
                                    'success' => $arvalidar['success'],
                                    'message' => $arvalidar['message'],
                                    'estadoCp' => $tablaestacp->codigo,
                                    'nestadoCp' => $tablaestacp->nombre,
                                    'estadoRuc' => $estadoRuc,
                                    'nestadoRuc' => $txtestadoRuc,
                                    'condDomiRuc' => $estadoDomiRuc,
                                    'ncondDomiRuc' => $txtestadoDomiRuc,
                                ]);

                        if ($tablaestacp->codigo == '0' && $fedocumento->ID_TIPO_DOC == 'R1') {

                            FeDocumento::where('ID_DOCUMENTO', '=', $ordencompra->COD_ORDEN)
                                ->update(
                                    [
                                        'success' => $arvalidar['success'],
                                        'message' => $arvalidar['message'],
                                        'estadoCp' => '1',
                                        'nestadoCp' => 'ACEPTADO',
                                        'estadoRuc' => '00',
                                        'nestadoRuc' => 'ACTIVO',
                                        'condDomiRuc' => '00',
                                        'ncondDomiRuc' => 'HABIDO',
                                    ]);

                        }


                    } else {
                        FeDocumento::where('ID_DOCUMENTO', '=', $ordencompra->COD_ORDEN)
                            ->update(
                                [
                                    'success' => $arvalidar['success'],
                                    'message' => $arvalidar['message']
                                ]);
                    }
                }


            }


            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();
            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();

            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idoc, $fedocumento->DOCUMENTO_ITEM);

            //orden de ingreso
            $orden_f = CMPOrden::where('COD_ORDEN', '=', $idoc)->first();
            $conexionbd = 'sqlsrv';
            if ($orden_f->COD_CENTRO == 'CEN0000000000004') { //rioja
                $conexionbd = 'sqlsrv_r';
            } else {
                if ($orden_f->COD_CENTRO == 'CEN0000000000006') { //bellavista
                    $conexionbd = 'sqlsrv_b';
                }
            }
            $referencia = DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->where('COD_TABLA', '=', $ordencompra->COD_ORDEN)
                ->where('COD_TABLA_ASOC', 'like', '%OI%')
                ->orderBy('COD_TABLA_ASOC', 'desc')
                ->first();
            $ordeningreso = array();
            if (count($referencia) > 0) {
                $ordeningreso = DB::connection($conexionbd)->table('CMP.ORDEN')->where('COD_ORDEN', '=', $referencia->COD_TABLA_ASOC)->first();
            }
            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();


            $ordencompra_t = CMPOrden::where('COD_ORDEN', '=', $idoc)->first();
            $codigo_sunat = 'I';
            if ($ordencompra_t->IND_VARIAS_ENTREGAS == 0) {
                $codigo_sunat = 'N';
            }
            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->where('TXT_GLOSA', '=', 'O')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();


            $archivosselect = Archivo::Join('CMP.CATEGORIA', 'TIPO_ARCHIVO', '=', 'COD_CATEGORIA')
                ->where('ID_DOCUMENTO', '=', $idoc)
                ->pluck('COD_CATEGORIA')
                ->toArray();

            $documentoscomprarepable = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_TIPO_REFERENCIA', '=', 'R')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO', 'ARCHIVO_VIRTUAL_FISICO' => 'ARCHIVO_VIRTUAL_FISICO');
            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
            $ordencompra_f = CMPOrden::where('COD_ORDEN', '=', $idoc)->first();

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            //$combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($anio_defecto, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio_defecto, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
            $periodo_defecto = $array_periodo_pc->COD_PERIODO;

            $sel_tipo_descuento = '';
            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $cod_contable = $fedocumento->ID_DOCUMENTO;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $centro_costo = '';
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            $asiento_compra = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':igv' => $igv,
                    ':ind_recalcular' => $ind_recalcular,
                    ':centro_costo' => $centro_costo,
                    ':ind_igv' => $ind_igv,
                    ':usuario' => $usuario
                ]
            );

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

            if (count($asiento_compra) <= 2) {
                array_push($asiento_compra, []);
            }

            //if ($respuesta === 'ASIENTO CORRECTO') {
            if (!empty($asiento_compra)) {

                $ind_reversion = 'R';

                $asiento_existe_reparable = WEBAsiento::where('COD_ESTADO', '=', 1)
                    ->where('TXT_REFERENCIA', '=', $cod_contable)
                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', 'TAS0000000000007')
                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                    ->where('TXT_TIPO_REFERENCIA', 'NOT LIKE', "%NAVASOFT%")
                    ->first();

                if ($asiento_existe_reparable) {
                    $asiento_reparable_reversion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':ind_reversion' => $ind_reversion,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_reparable_reversion = [[], [], []];
                }

                if ($fedocumento->MONTO_ANTICIPO_DESC > 0.0000) {
                    $asiento_deduccion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_DEDUCCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':igv' => $igv,
                            ':ind_recalcular' => $ind_recalcular,
                            ':centro_costo' => $centro_costo,
                            ':ind_igv' => $ind_igv,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_deduccion = [[], [], []];
                }

                if ($fedocumento->PERCEPCION > 0.0000) {
                    $asiento_percepcion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_PERCEPCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_percepcion = [[], [], []];
                }
            }

            $ind_reversion = 'N';

            $asiento_reparable = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':ind_recalcular' => $ind_recalcular,
                    ':ind_reversion' => $ind_reversion,
                    ':usuario' => $usuario
                ]
            );

            if (count($asiento_reparable) <= 2) {
                array_push($asiento_reparable, []);
            }
            //dd($asiento_compra, $asiento_reparable, $asiento_percepcion, $asiento_reparable_reversion, $asiento_deduccion);

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');
            $funciones = $this;
            return View::make('comprobante/aprobarcon',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'ordeningreso' => $ordeningreso,
                    'trabajador' => $trabajador,
                    'documentoscompra' => $documentoscompra,
                    'ordencompra_f' => $ordencompra_f,

                    'documentoscomprarepable' => $documentoscomprarepable,
                    'comboreparable' => $comboreparable,

                    //NUEVO
                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'defecto_anio' => $anio_defecto,
                    'defecto_periodo' => $periodo_defecto,

                    //'combo_empresa_proveedor' => $combo_empresa,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,
                    'combo_descuento' => $combo_descuento,
                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    'asiento_compra' => $asiento_compra,
                    'asiento_reparable_reversion' => $asiento_reparable_reversion,
                    'asiento_deduccion' => $asiento_deduccion,
                    'asiento_percepcion' => $asiento_percepcion,
                    'asiento_reparable' => $asiento_reparable,
                    // NUEVO
                    'totalarchivos' => $totalarchivos,
                    'ordencompra_t' => $ordencompra_t,
                    'linea' => $linea,
                    'detalleordencompra' => $detalleordencompra,
                    'detalleordencompraaf' => $detalleordencompraaf,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'archivosanulados' => $archivosanulados,

                    'archivospdf' => $archivospdf,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                    'funciones' => $funciones,
                ]);


        }
    }

    public function actionAprobarContabilidadReparable($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/


        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Aprobar Comprobante Reparable');

        if ($_POST) {
            try {

                DB::beginTransaction();

                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                FeDocumento::where('ID_DOCUMENTO', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'IND_REPARABLE' => '0'
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO DOCUMENTO REPARABLE';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO DOCUMENTO REPARABLE');
                //geolocalización


                //VERIFICAR SI ES HIBRIDO
                $tarchivoshibrido = CMPDocAsociarCompra::where('COD_ORDEN', '=', $pedido_id)
                    ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                    ->where('TIP_DOC', '=', 'F')
                    ->get();


                foreach ($tarchivoshibrido as $index => $item) {

                    CMPDocAsociarCompra::where('COD_ORDEN', $pedido_id)->where('COD_CATEGORIA_DOCUMENTO', '=', $item->COD_CATEGORIA_DOCUMENTO)
                        ->where('TIP_DOC', '=', 'F')
                        ->update(
                            [
                                'TXT_ASIGNADO' => 'ARCHIVO_FISICO'
                            ]
                        );
                    FeDocumento::where('ID_DOCUMENTO', $pedido_id)
                        ->update(
                            [
                                'IND_REPARABLE' => '1',
                                'MODO_REPARABLE' => 'ARCHIVO_FISICO'
                            ]
                        );
                }


                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-reparable/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-comprobantes-reparable/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

        }

    }


    public function actionAprobarContabilidadEstibaDIC($idopcion, $lote, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $lote;
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->get();
        View::share('titulo', 'Aprobar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();

                $detalles = json_decode($request->input('asientosgenerados'), true);

                foreach ($detalles as $detalle) {

                    $cabeceras = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);
                    $generar = true;

                    foreach ($cabeceras as $cabecera) {

                        if ($cabecera['COD_CATEGORIA_TIPO_ASIENTO'] === 'TAS0000000000004') {
                            $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                ->where('COD_ESTADO', '=', 1)
                                ->where('TXT_GLOSA', 'LIKE', '%COMPRA%')
                                ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                ->first();
                        } else {
                            if (stripos($cabecera['TXT_GLOSA'], 'DEDUCCION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'LIKE', '%DEDUCCION%')
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                            } else {
                                if (stripos($cabecera['TXT_GLOSA'], 'PERCEPCION')) {
                                    $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                        ->where('COD_ESTADO', '=', 1)
                                        ->where('TXT_GLOSA', 'LIKE', '%PERCEPCION%')
                                        ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                        ->first();
                                } else {
                                    if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION') === false) {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    } else {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    }
                                }
                            }
                        }

                        if (empty($asiento_busqueda)) {
                            if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                                if (empty($asiento_busqueda)) {
                                    break;
                                }
                            }
                        } else {
                            break;
                        }

                        $COD_ASIENTO = $cabecera['COD_ASIENTO'];
                        $COD_EMPR = $cabecera['COD_EMPR'];
                        $COD_EMPR_CLI = $cabecera['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $cabecera['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = !empty($cabecera['COD_CATEGORIA_TIPO_DOCUMENTO']) ? $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO'] : 'TDO0000000000066';
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $cabecera['NRO_SERIE'];
                        $NRO_DOC = $cabecera['NRO_DOC'];
                        $COD_CENTRO = $cabecera['COD_CENTRO'];
                        $COD_PERIODO = $cabecera['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $cabecera['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $cabecera['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $cabecera['NRO_ASIENTO'];
                        $FEC_ASIENTO = $cabecera['FEC_ASIENTO'];
                        $TXT_GLOSA = $cabecera['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $cabecera['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $cabecera['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $cabecera['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $cabecera['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $cabecera['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $cabecera['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $cabecera['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $cabecera['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $cabecera['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $cabecera['IND_EXTORNO'];
                        $IND_ANULADO = $cabecera['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $cabecera['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $cabecera['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $cabecera['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $cabecera['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $cabecera['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $cabecera['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $cabecera['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $cabecera['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $cabecera['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $cabecera['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $cabecera['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $cabecera['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $cabecera['FEC_DETRACCION'];
                        $NRO_DETRACCION = $cabecera['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $cabecera['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $cabecera['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $cabecera['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $cabecera['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $cabecera['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $cabecera['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $cabecera['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $cabecera['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $cabecera['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $cabecera['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $cabecera['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $cabecera['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $cabecera['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $cabecera['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $cabecera['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $cabecera['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $cabecera['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $cabecera['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $cabecera['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $cabecera['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $cabecera['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();

                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if ($generar) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                'CEN0000000000001',
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                if ($fedocumento->ind_observacion == 1) {
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }

                $descripcion = $request['descripcion'];
                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();

                }

                $filespdf = $request['otros'];
                if (!is_null($filespdf)) {
                    //PDF
                    foreach ($filespdf as $file) {

                        $larchivos = Archivo::get();
                        $nombre = $idoc . '-' . $file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $idoc;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf = count($larchivos) . '-' . $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilepdf;
                        copy($file->getRealPath(), $rutacompleta);
                        $path = $rutacompleta;

                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $idoc;
                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = 'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS CONTABILIDAD';
                        $dcontrol->URL_ARCHIVO = $path;
                        $dcontrol->SIZE = filesize($file);
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                        //dd($nombre);
                    }
                }

                $nro_cuenta_contable = $request['nro_cuenta_contable'];
                FeDocumento::where('ID_DOCUMENTO', $pedido_id)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADO',
                            'NRO_CUENTA' => $nro_cuenta_contable,
                            'ind_email_adm' => 0,
                            'fecha_pr' => $this->fechaactual,
                            'usuario_pr' => Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                //geolocalización


                $lotes = FeRefAsoc::where('lote', '=', $idoc)
                    ->pluck('ID_DOCUMENTO')
                    ->toArray();
                $documento_asociados = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->get();
                $documento_top = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->first();
                $conexionbd = 'sqlsrv';
                if ($documento_top->COD_CENTRO == 'CEN0000000000004') { //rioja
                    $conexionbd = 'sqlsrv_r';
                } else {
                    if ($documento_top->COD_CENTRO == 'CEN0000000000006') { //bellavista
                        $conexionbd = 'sqlsrv_b';
                    }
                }

                //enviar tablas de fe_documento y fe_detalledocuemto
                if ($documento_top->COD_CENTRO == 'CEN0000000000004' || $documento_top->COD_CENTRO == 'CEN0000000000006') { //rioja

                    $referenciaAsocQuery = FeDocumento::select('ID_DOCUMENTO'
                        , 'DOCUMENTO_ITEM'
                        , 'RUC_PROVEEDOR'
                        , 'RZ_PROVEEDOR'
                        , 'TIPO_CLIENTE'
                        , 'ID_CLIENTE'
                        , 'NOMBRE_CLIENTE'
                        , 'DIRECCION_CLIENTE'
                        , 'NUM_DOC_VENTA'
                        , 'SERIE'
                        , 'NUMERO'
                        , 'ID_TIPO_DOC'
                        , 'FEC_VENTA'
                        , 'FEC_VENCI_PAGO'
                        , 'FORMA_PAGO'
                        , 'FORMA_PAGO_DIAS'
                        , 'MONEDA'
                        , 'VALOR_TIPO_CAMBIO'
                        , 'VALOR_IGV_ORIG'
                        , 'VALOR_IGV_SOLES'
                        , 'SUB_TOTAL_VENTA_ORIG'
                        , 'SUB_TOTAL_VENTA_SOLES'
                        , 'TOTAL_VENTA_ORIG'
                        , 'TOTAL_VENTA_SOLES'
                        , 'V_EXONERADO'
                        , 'ESTADO'
                        , 'NUM_DOC_ELECT'
                        , 'ES_TRANS_GRATUITA'
                        , 'DES_COM'
                        , 'ES_ANULADO'
                        , 'ENVIADO_EMAIL'
                        , 'ENVIADO_EXTERNO'
                        , 'NRO_ORDEN_COMP'
                        , 'NUM_GUIA'
                        , 'TIPO_DOC_REL'
                        , 'CON_DETRACCION'
                        , 'OBSERVACION'
                        , 'HORA_EMISION'
                        , 'ES_TURISTICO'
                        , 'ES_EXONERADO'
                        , 'GUIA_CLIENTE'
                        , 'GLOSA_DETALE'
                        , 'VALIDACION_SUNAT'
                        , 'ID_MOTIVO_EMISION'
                        , 'MOTIVO_EMISION'
                        , 'MONTO_IMP_BOLSA'
                        , 'MONTO_DETRACCION'
                        , 'MONTO_RETENCION'
                        , 'MONTO_NETO_PAGO'
                        , 'DESCUENTO_I'
                        , 'DESCUENTO'
                        , 'IMPUESTO_2'
                        , 'TIPO_DETRACCION'
                        , 'PORC_DETRACCION'
                        , 'MONTO_ANTICIPO'
                        , 'COD_ESTADO'
                        , 'TXT_ESTADO'
                        , 'COD_EMPR'
                        , 'TXT_EMPR'
                        , 'COD_CONTACTO'
                        , 'TXT_CONTACTO'
                        , 'TXT_PROCEDENCIA'
                        , 'ARCHIVO_XML'
                        , 'ARCHIVO_CDR'
                        , 'ARCHIVO_PDF'
                        , 'success'
                        , 'message'
                        , 'estadoCp'
                        , 'nestadoCp'
                        , 'estadoRuc'
                        , 'nestadoRuc'
                        , 'condDomiRuc'
                        , 'ncondDomiRuc'
                        , 'CODIGO_CDR'
                        , 'RESPUESTA_CDR'
                        , 'ind_ruc'
                        , 'ind_rz'
                        , 'ind_moneda'
                        , 'ind_total'
                        , 'ind_cantidaditem'
                        , 'ind_formapago'
                        , 'ind_errototal'
                        , 'dni_usuariocontacto'
                        , 'usuario_pa'
                        , 'usuario_uc'
                        , 'usuario_ap'
                        , 'usuario_pr'
                        , 'usuario_ex'
                        , 'mensaje_exuc'
                        , 'mensaje_exap'
                        , 'mensaje_exadm'
                        , 'ind_email_uc'
                        , 'ind_email_ap'
                        , 'ind_email_adm'
                        , 'ind_email_clap'
                        , 'ind_email_ba'
                        , 'ind_observacion'
                        , 'area_observacion'
                        , 'OPERACION'
                        , 'PERCEPCION'
                        , 'usuario_tes'
                        , 'LOTE')
                        ->where('ID_DOCUMENTO', '=', $idoc)
                        ->get();


                    //dd($referenciaAsocQuery);
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsert = $referenciaAsocQuery->toArray();
                    //dd($dataToInsert);

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DOCUMENTO')->insert($dataToInsert);


                    //FE_DETALLE_DOCUENTO
                    $referenciaAsocQueryd = FeDetalleDocumento::select('*')
                        ->where('ID_DOCUMENTO', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertd = $referenciaAsocQueryd->toArray();

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DETALLE_DOCUMENTO')->insert($dataToInsertd);


                    //FE_REFENCIA_DOC
                    $referenciaAsocQueryr = FeRefAsoc::select('LOTE', 'ID_DOCUMENTO', 'ESTATUS', 'COD_ESTADO', 'OPERACION')
                        ->where('LOTE', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertr = $referenciaAsocQueryr->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_REF_ASOC')->insert($dataToInsertr);

                    //CMPDocAsociarCompra
                    $referenciaAsocQueryac = CMPDocAsociarCompra::select('COD_ORDEN', 'COD_CATEGORIA_DOCUMENTO', 'NOM_CATEGORIA_DOCUMENTO', 'IND_OBLIGATORIO', 'TXT_FORMATO', 'TXT_ASIGNADO', 'COD_USUARIO_CREA_AUD', 'COD_ESTADO', 'TIP_DOC')
                        ->where('COD_ORDEN', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInserac = $referenciaAsocQueryac->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('CMP.DOC_ASOCIAR_COMPRA')->insert($dataToInserac);


                }

                DB::connection($conexionbd)->table('CMP.DOCUMENTO_CTBLE')
                    ->where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)
                    ->update(
                        [
                            'IND_NOTIFICACION_CLIENTE' => 1
                        ]);

                if ($documento_top->COD_CENTRO == 'CEN0000000000004') {

                    $iddocumento_sel = $fedocumento->ID_DOCUMENTO;
                    DB::connection($conexionbd)->statement("
                        UPDATE FE_DOCUMENTO 
                        SET COD_CONTACTO = 'ITTR000000000212'
                        WHERE 1=1
                          AND RUC_PROVEEDOR IN ('20600004027','20602740278')
                          AND COD_ESTADO = 'ETM0000000000005' 
                          AND COD_CONTACTO <> 'ITTR000000000212'
                          AND FEC_VENTA >='2025-07-01'
                    ");

                }


                DB::commit();
                Session::flash('operacion_id', 'DOCUMENTO_INTERNO_COMPRA');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $pedido_id . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'DOCUMENTO_INTERNO_COMPRA');
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {


            $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();

            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idoc, $fedocumento->DOCUMENTO_ITEM);

            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();
            $codigo_sunat = 'N';


            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_GLOSA', '=', 'O')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            $archivosselect = Archivo::Join('CMP.CATEGORIA', 'TIPO_ARCHIVO', '=', 'COD_CATEGORIA')
                ->where('ID_DOCUMENTO', '=', $idoc)
                ->pluck('COD_CATEGORIA')
                ->toArray();

            $documentoscomprarepable = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_TIPO_REFERENCIA', '=', 'R')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO', 'ARCHIVO_VIRTUAL_FISICO' => 'ARCHIVO_VIRTUAL_FISICO');
            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();

            $lotes = FeRefAsoc::where('lote', '=', $idoc)
                ->pluck('ID_DOCUMENTO')
                ->toArray();
            $documento_asociados = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->get();
            $documento_top = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->first();

            $linea = $fedocumento->DOCUMENTO_ITEM;

            $fereftop1 = FeRefAsoc::where('lote', '=', $idoc)->first();

            $lotes = FeRefAsoc::where('lote', '=', $idoc)
                ->pluck('ID_DOCUMENTO')
                ->toArray();
            $documento_asociados = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->get();
            $documento_top = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->first();

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($anio_defecto, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio_defecto, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
            $periodo_defecto = $array_periodo_pc->COD_PERIODO;

            $sel_tipo_descuento = '';
            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $cod_contable = $fedocumento->ID_DOCUMENTO;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $centro_costo = '';
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            $asiento_compra = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':igv' => $igv,
                    ':ind_recalcular' => $ind_recalcular,
                    ':centro_costo' => $centro_costo,
                    ':ind_igv' => $ind_igv,
                    ':usuario' => $usuario
                ]
            );

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

            if (count($asiento_compra) <= 2) {
                array_push($asiento_compra, []);
            }

            //if ($respuesta === 'ASIENTO CORRECTO') {
            if (!empty($asiento_compra)) {

                $ind_reversion = 'R';

                $asiento_existe_reparable = WEBAsiento::where('COD_ESTADO', '=', 1)
                    ->where('TXT_REFERENCIA', '=', $cod_contable)
                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', 'TAS0000000000007')
                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                    ->where('TXT_TIPO_REFERENCIA', 'NOT LIKE', "%NAVASOFT%")
                    ->first();

                if ($asiento_existe_reparable) {
                    $asiento_reparable_reversion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':ind_reversion' => $ind_reversion,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_reparable_reversion = [[], [], []];
                }

                if ($fedocumento->MONTO_ANTICIPO_DESC > 0.0000) {
                    $asiento_deduccion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_DEDUCCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':igv' => $igv,
                            ':ind_recalcular' => $ind_recalcular,
                            ':centro_costo' => $centro_costo,
                            ':ind_igv' => $ind_igv,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_deduccion = [[], [], []];
                }

                if ($fedocumento->PERCEPCION > 0.0000) {
                    $asiento_percepcion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_PERCEPCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_percepcion = [[], [], []];
                }
            }

            $ind_reversion = 'N';

            $asiento_reparable = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':ind_recalcular' => $ind_recalcular,
                    ':ind_reversion' => $ind_reversion,
                    ':usuario' => $usuario
                ]
            );

            if (count($asiento_reparable) <= 2) {
                array_push($asiento_reparable, []);
            }
            //dd($asiento_compra, $asiento_reparable, $asiento_percepcion, $asiento_reparable_reversion, $asiento_deduccion);

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');
            $funciones = $this;

            return View::make('comprobante/aprobarconestibadic',
                [
                    'fedocumento' => $fedocumento,
                    'detalleordencompra' => $detalleordencompra,
                    'documento_asociados' => $documento_asociados,
                    'documento_top' => $documento_top,
                    'fereftop1' => $fereftop1,
                    'documento_asociados' => $documento_asociados,
                    'documento_top' => $documento_top,

                    //NUEVO
                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'defecto_anio' => $anio_defecto,
                    'defecto_periodo' => $periodo_defecto,

                    //'combo_empresa_proveedor' => $combo_empresa,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,
                    'combo_descuento' => $combo_descuento,
                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    'asiento_compra' => $asiento_compra,
                    'asiento_reparable_reversion' => $asiento_reparable_reversion,
                    'asiento_deduccion' => $asiento_deduccion,
                    'asiento_percepcion' => $asiento_percepcion,
                    'asiento_reparable' => $asiento_reparable,
                    // NUEVO

                    'lote' => $lote,
                    'archivospdf' => $archivospdf,
                    'trabajador' => $trabajador,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'totalarchivos' => $totalarchivos,
                    'documentoscomprarepable' => $documentoscomprarepable,
                    'comboreparable' => $comboreparable,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'archivosanulados' => $archivosanulados,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    //'tp'                    =>  $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }


    public function actionAprobarContabilidadEstibaOca($idopcion, $lote, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $lote;
        $lote = $lote;
        $lotes = FeRefAsoc::where('lote', '=', $idoc)
            ->first();
        $idcompra = $lotes->ID_DOCUMENTO;

        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($idcompra);
        $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idcompra);

        //dd($ordencompra);

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Aprobar  Comprobante');

        if ($_POST) {


            $fedocumento_ap = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('COD_ESTADO', '<>', 'ETM0000000000003')->first();
            if (count($fedocumento_ap) > 0) {
                return Redirect::back()->with('errorurl', 'El documento esta aprobado');
            }


            try {
                DB::beginTransaction();

                $detalles = json_decode($request->input('asientosgenerados'), true);

                foreach ($detalles as $detalle) {

                    $cabeceras = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);
                    $generar = true;

                    foreach ($cabeceras as $cabecera) {

                        if ($cabecera['COD_CATEGORIA_TIPO_ASIENTO'] === 'TAS0000000000004') {
                            $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                ->where('COD_ESTADO', '=', 1)
                                ->where('TXT_GLOSA', 'LIKE', '%COMPRA%')
                                ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                ->first();
                        } else {
                            if (stripos($cabecera['TXT_GLOSA'], 'DEDUCCION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'LIKE', '%DEDUCCION%')
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                            } else {
                                if (stripos($cabecera['TXT_GLOSA'], 'PERCEPCION')) {
                                    $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                        ->where('COD_ESTADO', '=', 1)
                                        ->where('TXT_GLOSA', 'LIKE', '%PERCEPCION%')
                                        ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                        ->first();
                                } else {
                                    if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION') === false) {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    } else {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    }
                                }
                            }
                        }

                        if (empty($asiento_busqueda)) {
                            if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                                if (empty($asiento_busqueda)) {
                                    break;
                                }
                            }
                        } else {
                            break;
                        }

                        $COD_ASIENTO = $cabecera['COD_ASIENTO'];
                        $COD_EMPR = $cabecera['COD_EMPR'];
                        $COD_EMPR_CLI = $cabecera['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $cabecera['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = !empty($cabecera['COD_CATEGORIA_TIPO_DOCUMENTO']) ? $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO'] : 'TDO0000000000066';
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $cabecera['NRO_SERIE'];
                        $NRO_DOC = $cabecera['NRO_DOC'];
                        $COD_CENTRO = $cabecera['COD_CENTRO'];
                        $COD_PERIODO = $cabecera['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $cabecera['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $cabecera['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $cabecera['NRO_ASIENTO'];
                        $FEC_ASIENTO = $cabecera['FEC_ASIENTO'];
                        $TXT_GLOSA = $cabecera['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $cabecera['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $cabecera['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $cabecera['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $cabecera['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $cabecera['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $cabecera['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $cabecera['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $cabecera['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $cabecera['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $cabecera['IND_EXTORNO'];
                        $IND_ANULADO = $cabecera['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $cabecera['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $cabecera['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $cabecera['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $cabecera['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $cabecera['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $cabecera['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $cabecera['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $cabecera['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $cabecera['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $cabecera['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $cabecera['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $cabecera['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $cabecera['FEC_DETRACCION'];
                        $NRO_DETRACCION = $cabecera['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $cabecera['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $cabecera['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $cabecera['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $cabecera['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $cabecera['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $cabecera['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $cabecera['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $cabecera['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $cabecera['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $cabecera['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $cabecera['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $cabecera['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $cabecera['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $cabecera['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $cabecera['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $cabecera['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $cabecera['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $cabecera['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $cabecera['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $cabecera['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $cabecera['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();

                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if ($generar) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                'CEN0000000000001',
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                if ($fedocumento->ind_observacion == 1) {
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }

                $descripcion = $request['descripcion'];
                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();

                }

                $filespdf = $request['otros'];
                if (!is_null($filespdf)) {
                    //PDF
                    foreach ($filespdf as $file) {

                        //
                        $contadorArchivos = Archivo::count();

                        $nombre = $idoc . '-' . $file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $idoc;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf = $contadorArchivos . '-' . $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilepdf;
                        copy($file->getRealPath(), $rutacompleta);
                        $path = $rutacompleta;

                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $idoc;
                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = 'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS CONTABILIDAD';
                        $dcontrol->URL_ARCHIVO = $path;
                        $dcontrol->SIZE = filesize($file);
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                        //dd($nombre);
                    }
                }

                $nro_cuenta_contable = $request['nro_cuenta_contable'];
                FeDocumento::where('ID_DOCUMENTO', $pedido_id)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADOO',
                            'NRO_CUENTA' => $nro_cuenta_contable,
                            'ind_email_adm' => 0,
                            'fecha_pr' => $this->fechaactual,
                            'usuario_pr' => Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                //geolocalización


                $lotes = FeRefAsoc::where('lote', '=', $idoc)
                    ->pluck('ID_DOCUMENTO')
                    ->toArray();

                $lotesr = FeRefAsoc::where('lote', '=', $idoc)
                    ->first();
                $idcompra = $lotesr->ID_DOCUMENTO;

                $documento_top = CMPOrden::where('COD_ORDEN', '=', $idcompra)->first();

                $conexionbd = 'sqlsrv';
                if ($documento_top->COD_CENTRO == 'CEN0000000000004') { //rioja
                    $conexionbd = 'sqlsrv_r';
                } else {
                    if ($documento_top->COD_CENTRO == 'CEN0000000000006') { //bellavista
                        $conexionbd = 'sqlsrv_b';
                    }
                }

                //enviar tablas de fe_documento y fe_detalledocuemto
                if ($documento_top->COD_CENTRO == 'CEN0000000000004' || $documento_top->COD_CENTRO == 'CEN0000000000006') { //rioja
                    //dd($conexionbd);
                    //FE_DOCUENTO
                    $referenciaAsocQuery = FeDocumento::select('ID_DOCUMENTO'
                        , 'DOCUMENTO_ITEM'
                        , 'RUC_PROVEEDOR'
                        , 'RZ_PROVEEDOR'
                        , 'TIPO_CLIENTE'
                        , 'ID_CLIENTE'
                        , 'NOMBRE_CLIENTE'
                        , 'DIRECCION_CLIENTE'
                        , 'NUM_DOC_VENTA'
                        , 'SERIE'
                        , 'NUMERO'
                        , 'ID_TIPO_DOC'
                        , 'FEC_VENTA'
                        , 'FEC_VENCI_PAGO'
                        , 'FORMA_PAGO'
                        , 'FORMA_PAGO_DIAS'
                        , 'MONEDA'
                        , 'VALOR_TIPO_CAMBIO'
                        , 'VALOR_IGV_ORIG'
                        , 'VALOR_IGV_SOLES'
                        , 'SUB_TOTAL_VENTA_ORIG'
                        , 'SUB_TOTAL_VENTA_SOLES'
                        , 'TOTAL_VENTA_ORIG'
                        , 'TOTAL_VENTA_SOLES'
                        , 'V_EXONERADO'
                        , 'ESTADO'
                        , 'NUM_DOC_ELECT'
                        , 'ES_TRANS_GRATUITA'
                        , 'DES_COM'
                        , 'ES_ANULADO'
                        , 'ENVIADO_EMAIL'
                        , 'ENVIADO_EXTERNO'
                        , 'NRO_ORDEN_COMP'
                        , 'NUM_GUIA'
                        , 'TIPO_DOC_REL'
                        , 'CON_DETRACCION'
                        , 'OBSERVACION'
                        , 'HORA_EMISION'
                        , 'ES_TURISTICO'
                        , 'ES_EXONERADO'
                        , 'GUIA_CLIENTE'
                        , 'GLOSA_DETALE'
                        , 'VALIDACION_SUNAT'
                        , 'ID_MOTIVO_EMISION'
                        , 'MOTIVO_EMISION'
                        , 'MONTO_IMP_BOLSA'
                        , 'MONTO_DETRACCION'
                        , 'MONTO_RETENCION'
                        , 'MONTO_NETO_PAGO'
                        , 'DESCUENTO_I'
                        , 'DESCUENTO'
                        , 'IMPUESTO_2'
                        , 'TIPO_DETRACCION'
                        , 'PORC_DETRACCION'
                        , 'MONTO_ANTICIPO'
                        , 'COD_ESTADO'
                        , 'TXT_ESTADO'
                        , 'COD_EMPR'
                        , 'TXT_EMPR'
                        , 'COD_CONTACTO'
                        , 'TXT_CONTACTO'
                        , 'TXT_PROCEDENCIA'
                        , 'ARCHIVO_XML'
                        , 'ARCHIVO_CDR'
                        , 'ARCHIVO_PDF'
                        , 'success'
                        , 'message'
                        , 'estadoCp'
                        , 'nestadoCp'
                        , 'estadoRuc'
                        , 'nestadoRuc'
                        , 'condDomiRuc'
                        , 'ncondDomiRuc'
                        , 'CODIGO_CDR'
                        , 'RESPUESTA_CDR'
                        , 'ind_ruc'
                        , 'ind_rz'
                        , 'ind_moneda'
                        , 'ind_total'
                        , 'ind_cantidaditem'
                        , 'ind_formapago'
                        , 'ind_errototal'
                        , 'dni_usuariocontacto'
                        , 'usuario_pa'
                        , 'usuario_uc'
                        , 'usuario_ap'
                        , 'usuario_pr'
                        , 'usuario_ex'
                        , 'mensaje_exuc'
                        , 'mensaje_exap'
                        , 'mensaje_exadm'
                        , 'ind_email_uc'
                        , 'ind_email_ap'
                        , 'ind_email_adm'
                        , 'ind_email_clap'
                        , 'ind_email_ba'
                        , 'ind_observacion'
                        , 'area_observacion'
                        , 'OPERACION'
                        , 'PERCEPCION'
                        , 'usuario_tes'
                        , 'LOTE')
                        ->where('ID_DOCUMENTO', '=', $idoc)
                        ->get();


                    //dd($referenciaAsocQuery);
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsert = $referenciaAsocQuery->toArray();
                    //dd($dataToInsert);

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DOCUMENTO')->insert($dataToInsert);


                    //FE_DETALLE_DOCUENTO
                    $referenciaAsocQueryd = FeDetalleDocumento::select('*')
                        ->where('ID_DOCUMENTO', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertd = $referenciaAsocQueryd->toArray();

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DETALLE_DOCUMENTO')->insert($dataToInsertd);


                    //FE_REFENCIA_DOC
                    $referenciaAsocQueryr = FeRefAsoc::select('LOTE', 'ID_DOCUMENTO', 'ESTATUS', 'COD_ESTADO', 'OPERACION')
                        ->where('LOTE', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertr = $referenciaAsocQueryr->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_REF_ASOC')->insert($dataToInsertr);

                    //CMPDocAsociarCompra
                    $referenciaAsocQueryac = CMPDocAsociarCompra::select('COD_ORDEN', 'COD_CATEGORIA_DOCUMENTO', 'NOM_CATEGORIA_DOCUMENTO', 'IND_OBLIGATORIO', 'TXT_FORMATO', 'TXT_ASIGNADO', 'COD_USUARIO_CREA_AUD', 'COD_ESTADO', 'TIP_DOC')
                        ->where('COD_ORDEN', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInserac = $referenciaAsocQueryac->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('CMP.DOC_ASOCIAR_COMPRA')->insert($dataToInserac);


                }

                DB::connection($conexionbd)->table('CMP.DOCUMENTO_CTBLE')
                    ->where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)
                    ->update(
                        [
                            'IND_NOTIFICACION_CLIENTE' => 1
                        ]);

                if ($documento_top->COD_CENTRO == 'CEN0000000000004') {

                    $iddocumento_sel = $fedocumento->ID_DOCUMENTO;
                    DB::connection($conexionbd)->statement("
                        UPDATE FE_DOCUMENTO 
                        SET COD_CONTACTO = 'ITTR000000000212'
                        WHERE 1=1
                          AND RUC_PROVEEDOR IN ('20600004027','20602740278')
                          AND COD_ESTADO = 'ETM0000000000005' 
                          AND COD_CONTACTO <> 'ITTR000000000212'
                          AND FEC_VENTA >='2025-07-01'
                    ");

                }


                DB::commit();
                Session::flash('operacion_id', 'ORDEN_COMPRA_ANTICIPO');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $pedido_id . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'ORDEN_COMPRA_ANTICIPO');
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {


            $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idcompra);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();

            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();

            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idoc, $fedocumento->DOCUMENTO_ITEM);
            //DD($archivospdf);

            //orden de ingreso
            $orden_f = CMPOrden::where('COD_ORDEN', '=', $idcompra)->first();
            $conexionbd = 'sqlsrv';
            if ($orden_f->COD_CENTRO == 'CEN0000000000004') { //rioja
                $conexionbd = 'sqlsrv_r';
            } else {
                if ($orden_f->COD_CENTRO == 'CEN0000000000006') { //bellavista
                    $conexionbd = 'sqlsrv_b';
                }
            }
            $referencia = DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->where('COD_TABLA', '=', $ordencompra->COD_ORDEN)
                ->orderBy('COD_TABLA_ASOC', 'desc')
                ->where('COD_TABLA_ASOC', 'like', '%OI%')->first();

            $ordeningreso = array();
            if (count($referencia) > 0) {
                $ordeningreso = DB::connection($conexionbd)->table('CMP.ORDEN')->where('COD_ORDEN', '=', $referencia->COD_TABLA_ASOC)->first();
            }


            //ORDEN DE SALIDA

            $empresa_relacionada = STDEmpresa::where('NRO_DOCUMENTO', '=', $fedocumento->RUC_PROVEEDOR)
                ->where('IND_RELACIONADO', '=', 1)
                ->first();
            $ordensalida = array();


            if (count($empresa_relacionada) > 0) {

                $documento_venta = DB::connection($conexionbd)->table('CMP.DOCUMENTO_CTBLE')
                    ->where('NRO_SERIE', '=', $fedocumento->SERIE)
                    ->where('NRO_DOC', '=', $fedocumento->NUMERO)
                    ->where('COD_EMPR_EMISOR', '=', $empresa_relacionada->COD_EMPR)
                    ->first();

                if (count($documento_venta) > 0) {


                    $referencia_venta = DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->where('COD_TABLA', '=', $documento_venta->COD_DOCUMENTO_CTBLE)
                        ->where(function ($query) {
                            $query->where('COD_TABLA_ASOC', 'like', '%VR%')
                                ->orWhere('COD_TABLA_ASOC', 'like', '%VL%');
                        })->first();

                    if (count($referencia_venta) > 0) {
                        $referencia_os = DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->where('COD_TABLA', '=', $referencia_venta->COD_TABLA_ASOC)
                            ->where('COD_TABLA_ASOC', 'like', '%OS%')->first();


                        if (count($referencia_os) > 0) {
                            $ordensalida = DB::connection($conexionbd)->table('CMP.ORDEN')->where('COD_ORDEN', '=', $referencia_os->COD_TABLA_ASOC)->first();
                        }
                    }
                }
            }


            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $ordencompra_t = CMPOrden::where('COD_ORDEN', '=', $idcompra)->first();
            $codigo_sunat = 'I';
            if ($ordencompra_t->IND_VARIAS_ENTREGAS == 0) {
                $codigo_sunat = 'N';
            }
            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();
            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            $ordencompra_f = CMPOrden::where('COD_ORDEN', '=', $idcompra)->first();


            //Archivo multiple


            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-fileliquidacioncompraanticipo', ['file' => $archivo->NOMBRE_ARCHIVO]);
            }
            $initialPreviewConfig = [];
            foreach ($archivospdf as $key => $archivo) {
                $initialPreviewConfig[] = [
                    'type' => "pdf",
                    'caption' => $archivo->NOMBRE_ARCHIVO,
                    'downloadUrl' => route('serve-fileliquidacioncompraanticipo', ['file' => $archivo->NOMBRE_ARCHIVO])
                ];
            }

            $ordencompra = CMPOrden::where('COD_ORDEN', $idcompra)->first();
            $empresa_sel = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR_CLIENTE)->first();
            $fereftop1 = FeRefAsoc::where('lote', '=', $idoc)->first();

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($anio_defecto, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio_defecto, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
            $periodo_defecto = $array_periodo_pc->COD_PERIODO;

            $sel_tipo_descuento = '';
            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $cod_contable = $fedocumento->ID_DOCUMENTO;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $centro_costo = '';
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            $asiento_compra = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':igv' => $igv,
                    ':ind_recalcular' => $ind_recalcular,
                    ':centro_costo' => $centro_costo,
                    ':ind_igv' => $ind_igv,
                    ':usuario' => $usuario
                ]
            );

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

            if (count($asiento_compra) <= 2) {
                array_push($asiento_compra, []);
            }

            //if ($respuesta === 'ASIENTO CORRECTO') {
            if (!empty($asiento_compra)) {

                $ind_reversion = 'R';

                $asiento_existe_reparable = WEBAsiento::where('COD_ESTADO', '=', 1)
                    ->where('TXT_REFERENCIA', '=', $cod_contable)
                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', 'TAS0000000000007')
                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                    ->where('TXT_TIPO_REFERENCIA', 'NOT LIKE', "%NAVASOFT%")
                    ->first();

                if ($asiento_existe_reparable) {
                    $asiento_reparable_reversion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':ind_reversion' => $ind_reversion,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_reparable_reversion = [[], [], []];
                }

                if ($fedocumento->MONTO_ANTICIPO_DESC > 0.0000) {
                    $asiento_deduccion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_DEDUCCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':igv' => $igv,
                            ':ind_recalcular' => $ind_recalcular,
                            ':centro_costo' => $centro_costo,
                            ':ind_igv' => $ind_igv,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_deduccion = [[], [], []];
                }

                if ($fedocumento->PERCEPCION > 0.0000) {
                    $asiento_percepcion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_PERCEPCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_percepcion = [[], [], []];
                }
            }

            $ind_reversion = 'N';

            $asiento_reparable = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':ind_recalcular' => $ind_recalcular,
                    ':ind_reversion' => $ind_reversion,
                    ':usuario' => $usuario
                ]
            );

            if (count($asiento_reparable) <= 2) {
                array_push($asiento_reparable, []);
            }

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');
            $funciones = $this;

            return View::make('comprobante/aprobarconestibacon',
                [
                    'fedocumento' => $fedocumento,
                    'lote' => $idoc,
                    'empresa_sel' => $empresa_sel,
                    'fereftop1' => $fereftop1,
                    'ordencompra' => $ordencompra,
                    'empresa_relacionada' => $empresa_relacionada,
                    'ordensalida' => $ordensalida,

                    //NUEVO
                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'defecto_anio' => $anio_defecto,
                    'defecto_periodo' => $periodo_defecto,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,
                    'combo_descuento' => $combo_descuento,
                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    'asiento_compra' => $asiento_compra,
                    'asiento_reparable_reversion' => $asiento_reparable_reversion,
                    'asiento_deduccion' => $asiento_deduccion,
                    'asiento_percepcion' => $asiento_percepcion,
                    'asiento_reparable' => $asiento_reparable,
                    // NUEVO

                    'initialPreview' => json_encode($initialPreview),
                    'initialPreviewConfig' => json_encode($initialPreviewConfig),

                    'ordeningreso' => $ordeningreso,
                    'linea' => $fedocumento->DOCUMENTO_ITEM,
                    'archivos' => $archivos,
                    'ordencompra_f' => $ordencompra_f,

                    'trabajador' => $trabajador,
                    'documentoscompra' => $documentoscompra,
                    'totalarchivos' => $totalarchivos,
                    'ordencompra_t' => $ordencompra_t,


                    'documentohistorial' => $documentohistorial,
                    'archivospdf' => $archivospdf,
                    'detalleordencompra' => $detalleordencompra,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,

                    'archivosanulados' => $archivosanulados,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }


    public function actionAprobarContabilidadEstiba($idopcion, $lote, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $lote;
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->get();
        View::share('titulo', 'Aprobar Comprobante');

        if ($_POST) {


            $fedocumento_ap = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('COD_ESTADO', '<>', 'ETM0000000000003')->first();
            if (count($fedocumento_ap) > 0) {
                return Redirect::back()->with('errorurl', 'El documento esta aprobado');
            }


            try {
                DB::beginTransaction();

                $detalles = json_decode($request->input('asientosgenerados'), true);

                foreach ($detalles as $detalle) {

                    $cabeceras = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);
                    $generar = true;

                    foreach ($cabeceras as $cabecera) {

                        if ($cabecera['COD_CATEGORIA_TIPO_ASIENTO'] === 'TAS0000000000004') {
                            $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                ->where('COD_ESTADO', '=', 1)
                                ->where('TXT_GLOSA', 'LIKE', '%COMPRA%')
                                ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                ->first();
                        } else {
                            if (stripos($cabecera['TXT_GLOSA'], 'DEDUCCION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'LIKE', '%DEDUCCION%')
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                            } else {
                                if (stripos($cabecera['TXT_GLOSA'], 'PERCEPCION')) {
                                    $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                        ->where('COD_ESTADO', '=', 1)
                                        ->where('TXT_GLOSA', 'LIKE', '%PERCEPCION%')
                                        ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                        ->first();
                                } else {
                                    if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION') === false) {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    } else {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    }
                                }
                            }
                        }

                        if (empty($asiento_busqueda)) {
                            if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                                if (empty($asiento_busqueda)) {
                                    break;
                                }
                            }
                        } else {
                            break;
                        }

                        $COD_ASIENTO = $cabecera['COD_ASIENTO'];
                        $COD_EMPR = $cabecera['COD_EMPR'];
                        $COD_EMPR_CLI = $cabecera['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $cabecera['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = !empty($cabecera['COD_CATEGORIA_TIPO_DOCUMENTO']) ? $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO'] : 'TDO0000000000066';
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $cabecera['NRO_SERIE'];
                        $NRO_DOC = $cabecera['NRO_DOC'];
                        $COD_CENTRO = $cabecera['COD_CENTRO'];
                        $COD_PERIODO = $cabecera['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $cabecera['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $cabecera['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $cabecera['NRO_ASIENTO'];
                        $FEC_ASIENTO = $cabecera['FEC_ASIENTO'];
                        $TXT_GLOSA = $cabecera['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $cabecera['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $cabecera['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $cabecera['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $cabecera['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $cabecera['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $cabecera['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $cabecera['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $cabecera['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $cabecera['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $cabecera['IND_EXTORNO'];
                        $IND_ANULADO = $cabecera['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $cabecera['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $cabecera['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $cabecera['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $cabecera['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $cabecera['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $cabecera['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $cabecera['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $cabecera['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $cabecera['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $cabecera['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $cabecera['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $cabecera['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $cabecera['FEC_DETRACCION'];
                        $NRO_DETRACCION = $cabecera['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $cabecera['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $cabecera['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $cabecera['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $cabecera['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $cabecera['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $cabecera['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $cabecera['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $cabecera['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $cabecera['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $cabecera['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $cabecera['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $cabecera['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $cabecera['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $cabecera['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $cabecera['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $cabecera['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $cabecera['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $cabecera['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $cabecera['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $cabecera['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $cabecera['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();

                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if ($generar) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                'CEN0000000000001',
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                if ($fedocumento->ind_observacion == 1) {
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }

                $descripcion = $request['descripcion'];
                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();

                }

                $filespdf = $request['otros'];
                if (!is_null($filespdf)) {
                    //PDF
                    foreach ($filespdf as $file) {

                        //
                        $contadorArchivos = Archivo::count();

                        $nombre = $idoc . '-' . $file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $idoc;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf = $contadorArchivos . '-' . $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilepdf;
                        copy($file->getRealPath(), $rutacompleta);
                        $path = $rutacompleta;

                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $idoc;
                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = 'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS CONTABILIDAD';
                        $dcontrol->URL_ARCHIVO = $path;
                        $dcontrol->SIZE = filesize($file);
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                        //dd($nombre);
                    }
                }

                $nro_cuenta_contable = $request['nro_cuenta_contable'];
                FeDocumento::where('ID_DOCUMENTO', $pedido_id)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADOO',
                            'NRO_CUENTA' => $nro_cuenta_contable,
                            'ind_email_adm' => 0,
                            'fecha_pr' => $this->fechaactual,
                            'usuario_pr' => Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                //geolocalización


                $lotes = FeRefAsoc::where('lote', '=', $idoc)
                    ->pluck('ID_DOCUMENTO')
                    ->toArray();
                $documento_asociados = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->get();
                $documento_top = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->first();
                $conexionbd = 'sqlsrv';
                if ($documento_top->COD_CENTRO == 'CEN0000000000004') { //rioja
                    $conexionbd = 'sqlsrv_r';
                } else {
                    if ($documento_top->COD_CENTRO == 'CEN0000000000006') { //bellavista
                        $conexionbd = 'sqlsrv_b';
                    }
                }

                //enviar tablas de fe_documento y fe_detalledocuemto
                if ($documento_top->COD_CENTRO == 'CEN0000000000004' || $documento_top->COD_CENTRO == 'CEN0000000000006') { //rioja
                    //dd($conexionbd);
                    //FE_DOCUENTO
                    $referenciaAsocQuery = FeDocumento::select('ID_DOCUMENTO'
                        , 'DOCUMENTO_ITEM'
                        , 'RUC_PROVEEDOR'
                        , 'RZ_PROVEEDOR'
                        , 'TIPO_CLIENTE'
                        , 'ID_CLIENTE'
                        , 'NOMBRE_CLIENTE'
                        , 'DIRECCION_CLIENTE'
                        , 'NUM_DOC_VENTA'
                        , 'SERIE'
                        , 'NUMERO'
                        , 'ID_TIPO_DOC'
                        , 'FEC_VENTA'
                        , 'FEC_VENCI_PAGO'
                        , 'FORMA_PAGO'
                        , 'FORMA_PAGO_DIAS'
                        , 'MONEDA'
                        , 'VALOR_TIPO_CAMBIO'
                        , 'VALOR_IGV_ORIG'
                        , 'VALOR_IGV_SOLES'
                        , 'SUB_TOTAL_VENTA_ORIG'
                        , 'SUB_TOTAL_VENTA_SOLES'
                        , 'TOTAL_VENTA_ORIG'
                        , 'TOTAL_VENTA_SOLES'
                        , 'V_EXONERADO'
                        , 'ESTADO'
                        , 'NUM_DOC_ELECT'
                        , 'ES_TRANS_GRATUITA'
                        , 'DES_COM'
                        , 'ES_ANULADO'
                        , 'ENVIADO_EMAIL'
                        , 'ENVIADO_EXTERNO'
                        , 'NRO_ORDEN_COMP'
                        , 'NUM_GUIA'
                        , 'TIPO_DOC_REL'
                        , 'CON_DETRACCION'
                        , 'OBSERVACION'
                        , 'HORA_EMISION'
                        , 'ES_TURISTICO'
                        , 'ES_EXONERADO'
                        , 'GUIA_CLIENTE'
                        , 'GLOSA_DETALE'
                        , 'VALIDACION_SUNAT'
                        , 'ID_MOTIVO_EMISION'
                        , 'MOTIVO_EMISION'
                        , 'MONTO_IMP_BOLSA'
                        , 'MONTO_DETRACCION'
                        , 'MONTO_RETENCION'
                        , 'MONTO_NETO_PAGO'
                        , 'DESCUENTO_I'
                        , 'DESCUENTO'
                        , 'IMPUESTO_2'
                        , 'TIPO_DETRACCION'
                        , 'PORC_DETRACCION'
                        , 'MONTO_ANTICIPO'
                        , 'COD_ESTADO'
                        , 'TXT_ESTADO'
                        , 'COD_EMPR'
                        , 'TXT_EMPR'
                        , 'COD_CONTACTO'
                        , 'TXT_CONTACTO'
                        , 'TXT_PROCEDENCIA'
                        , 'ARCHIVO_XML'
                        , 'ARCHIVO_CDR'
                        , 'ARCHIVO_PDF'
                        , 'success'
                        , 'message'
                        , 'estadoCp'
                        , 'nestadoCp'
                        , 'estadoRuc'
                        , 'nestadoRuc'
                        , 'condDomiRuc'
                        , 'ncondDomiRuc'
                        , 'CODIGO_CDR'
                        , 'RESPUESTA_CDR'
                        , 'ind_ruc'
                        , 'ind_rz'
                        , 'ind_moneda'
                        , 'ind_total'
                        , 'ind_cantidaditem'
                        , 'ind_formapago'
                        , 'ind_errototal'
                        , 'dni_usuariocontacto'
                        , 'usuario_pa'
                        , 'usuario_uc'
                        , 'usuario_ap'
                        , 'usuario_pr'
                        , 'usuario_ex'
                        , 'mensaje_exuc'
                        , 'mensaje_exap'
                        , 'mensaje_exadm'
                        , 'ind_email_uc'
                        , 'ind_email_ap'
                        , 'ind_email_adm'
                        , 'ind_email_clap'
                        , 'ind_email_ba'
                        , 'ind_observacion'
                        , 'area_observacion'
                        , 'OPERACION'
                        , 'PERCEPCION'
                        , 'usuario_tes'
                        , 'LOTE')
                        ->where('ID_DOCUMENTO', '=', $idoc)
                        ->get();


                    //dd($referenciaAsocQuery);
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsert = $referenciaAsocQuery->toArray();
                    //dd($dataToInsert);

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DOCUMENTO')->insert($dataToInsert);


                    //FE_DETALLE_DOCUENTO
                    $referenciaAsocQueryd = FeDetalleDocumento::select('*')
                        ->where('ID_DOCUMENTO', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertd = $referenciaAsocQueryd->toArray();

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DETALLE_DOCUMENTO')->insert($dataToInsertd);


                    //FE_REFENCIA_DOC
                    $referenciaAsocQueryr = FeRefAsoc::select('LOTE', 'ID_DOCUMENTO', 'ESTATUS', 'COD_ESTADO', 'OPERACION')
                        ->where('LOTE', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertr = $referenciaAsocQueryr->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_REF_ASOC')->insert($dataToInsertr);

                    //CMPDocAsociarCompra
                    $referenciaAsocQueryac = CMPDocAsociarCompra::select('COD_ORDEN', 'COD_CATEGORIA_DOCUMENTO', 'NOM_CATEGORIA_DOCUMENTO', 'IND_OBLIGATORIO', 'TXT_FORMATO', 'TXT_ASIGNADO', 'COD_USUARIO_CREA_AUD', 'COD_ESTADO', 'TIP_DOC')
                        ->where('COD_ORDEN', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInserac = $referenciaAsocQueryac->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('CMP.DOC_ASOCIAR_COMPRA')->insert($dataToInserac);


                }

                DB::connection($conexionbd)->table('CMP.DOCUMENTO_CTBLE')
                    ->where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)
                    ->update(
                        [
                            'IND_NOTIFICACION_CLIENTE' => 1
                        ]);

                if ($documento_top->COD_CENTRO == 'CEN0000000000004') {

                    $iddocumento_sel = $fedocumento->ID_DOCUMENTO;
                    DB::connection($conexionbd)->statement("
                        UPDATE FE_DOCUMENTO 
                        SET COD_CONTACTO = 'ITTR000000000212'
                        WHERE 1=1
                          AND RUC_PROVEEDOR IN ('20600004027','20602740278')
                          AND COD_ESTADO = 'ETM0000000000005' 
                          AND COD_CONTACTO <> 'ITTR000000000212'
                          AND FEC_VENTA >='2025-07-01'
                    ");

                }


                DB::commit();
                Session::flash('operacion_id', 'ESTIBA');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $pedido_id . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'ESTIBA');
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            //lectura del cdr
            //$prefijocarperta        =   $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
            //$lecturacdr             =   $this->lectura_cdr_archivo($idoc,$this->pathFiles,$prefijocarperta,$ordencompra->NRO_DOCUMENTO_CLIENTE);

            $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            //$tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();

            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idoc, $fedocumento->DOCUMENTO_ITEM);


            //dd($archivospdf);

            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();


            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();
            $codigo_sunat = 'N';


            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_GLOSA', '=', 'O')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            $archivosselect = Archivo::Join('CMP.CATEGORIA', 'TIPO_ARCHIVO', '=', 'COD_CATEGORIA')
                ->where('ID_DOCUMENTO', '=', $idoc)
                ->pluck('COD_CATEGORIA')
                ->toArray();

            $documentoscomprarepable = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_TIPO_REFERENCIA', '=', 'R')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO', 'ARCHIVO_VIRTUAL_FISICO' => 'ARCHIVO_VIRTUAL_FISICO');

            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();

            $lotes = FeRefAsoc::where('lote', '=', $idoc)
                ->pluck('ID_DOCUMENTO')
                ->toArray();
            $documento_asociados = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->get();
            $documento_top = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->first();

            $linea = $fedocumento->DOCUMENTO_ITEM;

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            //$combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($anio_defecto, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio_defecto, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
            $periodo_defecto = $array_periodo_pc->COD_PERIODO;

            $sel_tipo_descuento = '';
            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $cod_contable = $fedocumento->ID_DOCUMENTO;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $centro_costo = '';
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            $asiento_compra = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':igv' => $igv,
                    ':ind_recalcular' => $ind_recalcular,
                    ':centro_costo' => $centro_costo,
                    ':ind_igv' => $ind_igv,
                    ':usuario' => $usuario
                ]
            );

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

            //if ($respuesta === 'ASIENTO CORRECTO') {
            if (!empty($asiento_compra)) {

                $ind_reversion = 'R';

                $asiento_existe_reparable = WEBAsiento::where('COD_ESTADO', '=', 1)
                    ->where('TXT_REFERENCIA', '=', $cod_contable)
                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', 'TAS0000000000007')
                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                    ->where('TXT_TIPO_REFERENCIA', 'NOT LIKE', "%NAVASOFT%")
                    ->first();

                if ($asiento_existe_reparable) {
                    $asiento_reparable_reversion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':ind_reversion' => $ind_reversion,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_reparable_reversion = [[], [], []];
                }

                if ($fedocumento->MONTO_ANTICIPO_DESC > 0.0000) {
                    $asiento_deduccion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_DEDUCCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':igv' => $igv,
                            ':ind_recalcular' => $ind_recalcular,
                            ':centro_costo' => $centro_costo,
                            ':ind_igv' => $ind_igv,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_deduccion = [[], [], []];
                }

                if ($fedocumento->PERCEPCION > 0.0000) {
                    $asiento_percepcion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_PERCEPCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_percepcion = [[], [], []];
                }
            }

            $ind_reversion = 'N';

            $asiento_reparable = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':ind_recalcular' => $ind_recalcular,
                    ':ind_reversion' => $ind_reversion,
                    ':usuario' => $usuario
                ]
            );

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');

            return View::make('comprobante/aprobarconestiba',
                [
                    'fedocumento' => $fedocumento,

                    'detalleordencompra' => $detalleordencompra,
                    'documento_asociados' => $documento_asociados,
                    'documento_top' => $documento_top,
                    'lote' => $lote,
                    'archivospdf' => $archivospdf,
                    'trabajador' => $trabajador,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'totalarchivos' => $totalarchivos,
                    'documentoscomprarepable' => $documentoscomprarepable,
                    'comboreparable' => $comboreparable,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'archivosanulados' => $archivosanulados,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    //'tp'                    =>  $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,

                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'defecto_anio' => $anio_defecto,
                    'defecto_periodo' => $periodo_defecto,

                    //'combo_empresa_proveedor' => $combo_empresa,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,

                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_descuento' => $combo_descuento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    'asiento_compra' => $asiento_compra,
                    'asiento_reparable_reversion' => $asiento_reparable_reversion,
                    'asiento_deduccion' => $asiento_deduccion,
                    'asiento_percepcion' => $asiento_percepcion,
                    'asiento_reparable' => $asiento_reparable,
                ]);


        }
    }

    public function actionAprobarContabilidadEstibaComision($idopcion, $lote, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $lote;
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->get();
        View::share('titulo', 'Aprobar Comprobante');

        if ($_POST) {


            $fedocumento_ap = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('COD_ESTADO', '<>', 'ETM0000000000003')->first();
            if (count($fedocumento_ap) > 0) {
                return Redirect::back()->with('errorurl', 'El documento esta aprobado');
            }


            try {
                DB::beginTransaction();

                $detalles = json_decode($request->input('asientosgenerados'), true);

                foreach ($detalles as $detalle) {

                    $cabeceras = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);
                    $generar = true;

                    foreach ($cabeceras as $cabecera) {

                        if ($cabecera['COD_CATEGORIA_TIPO_ASIENTO'] === 'TAS0000000000004') {
                            $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                ->where('COD_ESTADO', '=', 1)
                                ->where('TXT_GLOSA', 'LIKE', '%COMPRA%')
                                ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                ->first();
                        } else {
                            if (stripos($cabecera['TXT_GLOSA'], 'DEDUCCION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'LIKE', '%DEDUCCION%')
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                            } else {
                                if (stripos($cabecera['TXT_GLOSA'], 'PERCEPCION')) {
                                    $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                        ->where('COD_ESTADO', '=', 1)
                                        ->where('TXT_GLOSA', 'LIKE', '%PERCEPCION%')
                                        ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                        ->first();
                                } else {
                                    if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION') === false) {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    } else {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    }
                                }
                            }
                        }

                        if (empty($asiento_busqueda)) {
                            if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                                if (empty($asiento_busqueda)) {
                                    break;
                                }
                            }
                        } else {
                            break;
                        }

                        $COD_ASIENTO = $cabecera['COD_ASIENTO'];
                        $COD_EMPR = $cabecera['COD_EMPR'];
                        $COD_EMPR_CLI = $cabecera['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $cabecera['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = !empty($cabecera['COD_CATEGORIA_TIPO_DOCUMENTO']) ? $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO'] : 'TDO0000000000066';
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $cabecera['NRO_SERIE'];
                        $NRO_DOC = $cabecera['NRO_DOC'];
                        $COD_CENTRO = $cabecera['COD_CENTRO'];
                        $COD_PERIODO = $cabecera['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $cabecera['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $cabecera['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $cabecera['NRO_ASIENTO'];
                        $FEC_ASIENTO = $cabecera['FEC_ASIENTO'];
                        $TXT_GLOSA = $cabecera['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $cabecera['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $cabecera['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $cabecera['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $cabecera['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $cabecera['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $cabecera['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $cabecera['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $cabecera['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $cabecera['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $cabecera['IND_EXTORNO'];
                        $IND_ANULADO = $cabecera['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $cabecera['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $cabecera['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $cabecera['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $cabecera['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $cabecera['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $cabecera['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $cabecera['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $cabecera['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $cabecera['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $cabecera['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $cabecera['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $cabecera['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $cabecera['FEC_DETRACCION'];
                        $NRO_DETRACCION = $cabecera['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $cabecera['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $cabecera['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $cabecera['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $cabecera['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $cabecera['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $cabecera['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $cabecera['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $cabecera['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $cabecera['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $cabecera['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $cabecera['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $cabecera['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $cabecera['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $cabecera['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $cabecera['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $cabecera['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $cabecera['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $cabecera['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $cabecera['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $cabecera['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $cabecera['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();

                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if ($generar) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                'CEN0000000000001',
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                if ($fedocumento->ind_observacion == 1) {
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }

                $descripcion = $request['descripcion'];
                $operacion_id = $request['operacion_id'];

                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();

                }

                $filespdf = $request['otros'];
                if (!is_null($filespdf)) {
                    //PDF
                    foreach ($filespdf as $file) {

                        //
                        $contadorArchivos = Archivo::count();

                        $nombre = $idoc . '-' . $file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $idoc;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf = $contadorArchivos . '-' . $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilepdf;
                        copy($file->getRealPath(), $rutacompleta);
                        $path = $rutacompleta;

                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $idoc;
                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = 'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS CONTABILIDAD';
                        $dcontrol->URL_ARCHIVO = $path;
                        $dcontrol->SIZE = filesize($file);
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                        //dd($nombre);
                    }
                }

                $nro_cuenta_contable = $request['nro_cuenta_contable'];
                FeDocumento::where('ID_DOCUMENTO', $pedido_id)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000008',
                            'TXT_ESTADO' => 'TERMINADA',
                            'NRO_CUENTA' => $nro_cuenta_contable,
                            'ind_email_adm' => 0,
                            'fecha_pr' => $this->fechaactual,
                            'usuario_pr' => Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                //geolocalización


                $lotes = FeRefAsoc::where('lote', '=', $idoc)
                    ->pluck('ID_DOCUMENTO')
                    ->toArray();
                $documento_asociados = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->get();
                $documento_top = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->first();


                DB::commit();
                Session::flash('operacion_id', $operacion_id);
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $pedido_id . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', $operacion_id);
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {


            $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            //$tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();

            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idoc, $fedocumento->DOCUMENTO_ITEM);


            //dd($archivospdf);

            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();


            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();
            $codigo_sunat = 'N';


            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_GLOSA', '=', 'O')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            $archivosselect = Archivo::Join('CMP.CATEGORIA', 'TIPO_ARCHIVO', '=', 'COD_CATEGORIA')
                ->where('ID_DOCUMENTO', '=', $idoc)
                ->pluck('COD_CATEGORIA')
                ->toArray();

            $documentoscomprarepable = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_TIPO_REFERENCIA', '=', 'R')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO', 'ARCHIVO_VIRTUAL_FISICO' => 'ARCHIVO_VIRTUAL_FISICO');

            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();


            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);

            $xmlarchivo = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $lote . '\\' . $fedocumento->ARCHIVO_XML;
            $cdrarchivo = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $lote . '\\' . $fedocumento->ARCHIVO_CDR;
            $pdfarchivo = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $lote . '\\' . $fedocumento->ARCHIVO_PDF;
            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $lote)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();
            $funcion = $this;
            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $lotes = FeRefAsoc::where('lote', '=', $idoc)
                ->pluck('ID_DOCUMENTO')
                ->toArray();
            $documento_asociados = $this->gn_lista_comision_asociados_atendidos($lotes, $idoc);
            $documento_top = $this->gn_lista_comision_asociados_top($lotes);

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            //$combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($anio_defecto, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio_defecto, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
            $periodo_defecto = $array_periodo_pc->COD_PERIODO;

            $sel_tipo_descuento = '';
            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $cod_contable = $fedocumento->ID_DOCUMENTO;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $centro_costo = '';
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            $asiento_compra = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO_COMISION]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':igv' => $igv,
                    ':ind_recalcular' => $ind_recalcular,
                    ':centro_costo' => $centro_costo,
                    ':ind_igv' => $ind_igv,
                    ':usuario' => $usuario
                ]
            );

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

            if (count($asiento_compra) <= 2) {
                array_push($asiento_compra, []);
            }

            //if ($respuesta === 'ASIENTO CORRECTO') {
            if (!empty($asiento_compra)) {

                $ind_reversion = 'R';

                $asiento_existe_reparable = WEBAsiento::where('COD_ESTADO', '=', 1)
                    ->where('TXT_REFERENCIA', '=', $cod_contable)
                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', 'TAS0000000000007')
                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                    ->where('TXT_TIPO_REFERENCIA', 'NOT LIKE', "%NAVASOFT%")
                    ->first();

                if ($asiento_existe_reparable) {
                    $asiento_reparable_reversion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':ind_reversion' => $ind_reversion,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_reparable_reversion = [[], [], []];
                }

                if ($fedocumento->MONTO_ANTICIPO_DESC > 0.0000) {
                    $asiento_deduccion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_DEDUCCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':igv' => $igv,
                            ':ind_recalcular' => $ind_recalcular,
                            ':centro_costo' => $centro_costo,
                            ':ind_igv' => $ind_igv,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_deduccion = [[], [], []];
                }

                if ($fedocumento->PERCEPCION > 0.0000) {
                    $asiento_percepcion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_PERCEPCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_percepcion = [[], [], []];
                }
            }

            $ind_reversion = 'N';

            $asiento_reparable = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':ind_recalcular' => $ind_recalcular,
                    ':ind_reversion' => $ind_reversion,
                    ':usuario' => $usuario
                ]
            );

            if (count($asiento_reparable) <= 2) {
                array_push($asiento_reparable, []);
            }
            //dd($asiento_compra, $asiento_reparable, $asiento_percepcion, $asiento_reparable_reversion, $asiento_deduccion);

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');
            $funciones = $this;

            return View::make('comprobante/aprobarconestibacomision',
                [
                    'fedocumento' => $fedocumento,

                    'detalleordencompra' => $detalleordencompra,
                    'documento_asociados' => $documento_asociados,
                    'documento_top' => $documento_top,
                    'lote' => $lote,
                    'archivospdf' => $archivospdf,
                    'trabajador' => $trabajador,
                    'linea' => $fedocumento->DOCUMENTO_ITEM,
                    'documentoscompra' => $documentoscompra,
                    'totalarchivos' => $totalarchivos,
                    'documentoscomprarepable' => $documentoscomprarepable,
                    'comboreparable' => $comboreparable,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'archivosanulados' => $archivosanulados,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    //'tp'                    =>  $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,


                    //NUEVO
                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'defecto_anio' => $anio_defecto,
                    'defecto_periodo' => $periodo_defecto,

                    //'combo_empresa_proveedor' => $combo_empresa,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,
                    'combo_descuento' => $combo_descuento,
                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    'asiento_compra' => $asiento_compra,
                    'asiento_reparable_reversion' => $asiento_reparable_reversion,
                    'asiento_deduccion' => $asiento_deduccion,
                    'asiento_percepcion' => $asiento_percepcion,
                    'asiento_reparable' => $asiento_reparable,
                    // NUEVO

                ]);


        }
    }


    public function actionAprobarContabilidadContrato($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Aprobar Comprobante');

        if ($_POST) {

            $fedocumento_ap = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->where('COD_ESTADO', '<>', 'ETM0000000000003')->first();
            if (count($fedocumento_ap) > 0) {
                return Redirect::back()->with('errorurl', 'El documento esta aprobado');
            }


            try {
                DB::beginTransaction();

                $detalles = json_decode($request->input('asientosgenerados'), true);

                foreach ($detalles as $detalle) {

                    $cabeceras = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);
                    $generar = true;

                    foreach ($cabeceras as $cabecera) {

                        if ($cabecera['COD_CATEGORIA_TIPO_ASIENTO'] === 'TAS0000000000004') {
                            $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                ->where('COD_ESTADO', '=', 1)
                                ->where('TXT_GLOSA', 'LIKE', '%COMPRA%')
                                ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                ->first();
                        } else {
                            if (stripos($cabecera['TXT_GLOSA'], 'DEDUCCION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'LIKE', '%DEDUCCION%')
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                            } else {
                                if (stripos($cabecera['TXT_GLOSA'], 'PERCEPCION')) {
                                    $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                        ->where('COD_ESTADO', '=', 1)
                                        ->where('TXT_GLOSA', 'LIKE', '%PERCEPCION%')
                                        ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                        ->first();
                                } else {
                                    if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION') === false) {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    } else {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    }
                                }
                            }
                        }

                        if (empty($asiento_busqueda)) {
                            if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                                if (empty($asiento_busqueda)) {
                                    break;
                                }
                            }
                        } else {
                            break;
                        }

                        $COD_ASIENTO = $cabecera['COD_ASIENTO'];
                        $COD_EMPR = $cabecera['COD_EMPR'];
                        $COD_EMPR_CLI = $cabecera['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $cabecera['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = !empty($cabecera['COD_CATEGORIA_TIPO_DOCUMENTO']) ? $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO'] : 'TDO0000000000066';
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $cabecera['NRO_SERIE'];
                        $NRO_DOC = $cabecera['NRO_DOC'];
                        $COD_CENTRO = $cabecera['COD_CENTRO'];
                        $COD_PERIODO = $cabecera['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $cabecera['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $cabecera['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $cabecera['NRO_ASIENTO'];
                        $FEC_ASIENTO = $cabecera['FEC_ASIENTO'];
                        $TXT_GLOSA = $cabecera['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $cabecera['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $cabecera['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $cabecera['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $cabecera['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $cabecera['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $cabecera['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $cabecera['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $cabecera['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $cabecera['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $cabecera['IND_EXTORNO'];
                        $IND_ANULADO = $cabecera['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $cabecera['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $cabecera['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $cabecera['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $cabecera['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $cabecera['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $cabecera['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $cabecera['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $cabecera['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $cabecera['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $cabecera['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $cabecera['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $cabecera['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $cabecera['FEC_DETRACCION'];
                        $NRO_DETRACCION = $cabecera['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $cabecera['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $cabecera['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $cabecera['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $cabecera['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $cabecera['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $cabecera['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $cabecera['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $cabecera['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $cabecera['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $cabecera['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $cabecera['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $cabecera['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $cabecera['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $cabecera['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $cabecera['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $cabecera['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $cabecera['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $cabecera['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $cabecera['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $cabecera['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $cabecera['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();

                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if ($generar) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                'CEN0000000000001',
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();

                if ($fedocumento->ind_observacion == 1) {
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }

                $descripcion = $request['descripcion'];
                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();
                }


                $filespdf = $request['otros'];
                if (!is_null($filespdf)) {
                    //PDF
                    foreach ($filespdf as $file) {

                        //
                        $contadorArchivos = Archivo::count();

                        $nombre = $ordencompra->COD_DOCUMENTO_CTBLE . '-' . $file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordencompra->NRO_DOCUMENTO_CLIENTE;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf = $contadorArchivos . '-' . $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilepdf;
                        copy($file->getRealPath(), $rutacompleta);
                        $path = $rutacompleta;

                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $ordencompra->COD_DOCUMENTO_CTBLE;
                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = 'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS CONTABILIDAD';
                        $dcontrol->URL_ARCHIVO = $path;
                        $dcontrol->SIZE = filesize($file);
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                        //dd($nombre);
                    }
                }


                $nro_cuenta_contable = $request['nro_cuenta_contable'];


                FeDocumento::where('ID_DOCUMENTO', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADOO',
                            'NRO_CUENTA' => $nro_cuenta_contable,

                            'ind_email_adm' => 0,
                            'fecha_pr' => $this->fechaactual,
                            'usuario_pr' => Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();


                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                //geolocalización


                //whatsaap para administracion
                $fedocumento_w = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $ordencompra = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)->first();


                $orden = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)->first();


                $conexionbd = 'sqlsrv';
                if ($orden->COD_CENTRO == 'CEN0000000000004') { //rioja
                    $conexionbd = 'sqlsrv_r';
                } else {
                    if ($orden->COD_CENTRO == 'CEN0000000000006') { //bellavista
                        $conexionbd = 'sqlsrv_b';
                    }
                }

                DB::connection($conexionbd)->table('CMP.DOCUMENTO_CTBLE')
                    ->where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)
                    ->update(
                        [
                            'IND_NOTIFICACION_CLIENTE' => 1
                        ]);

                //enviar tablas de fe_documento y fe_detalledocuemto
                if ($orden->COD_CENTRO == 'CEN0000000000004' || $orden->COD_CENTRO == 'CEN0000000000006') { //rioja

                    $referenciaAsocQuery = FeDocumento::select('ID_DOCUMENTO'
                        , 'DOCUMENTO_ITEM'
                        , 'RUC_PROVEEDOR'
                        , 'RZ_PROVEEDOR'
                        , 'TIPO_CLIENTE'
                        , 'ID_CLIENTE'
                        , 'NOMBRE_CLIENTE'
                        , 'DIRECCION_CLIENTE'
                        , 'NUM_DOC_VENTA'
                        , 'SERIE'
                        , 'NUMERO'
                        , 'ID_TIPO_DOC'
                        , 'FEC_VENTA'
                        , 'FEC_VENCI_PAGO'
                        , 'FORMA_PAGO'
                        , 'FORMA_PAGO_DIAS'
                        , 'MONEDA'
                        , 'VALOR_TIPO_CAMBIO'
                        , 'VALOR_IGV_ORIG'
                        , 'VALOR_IGV_SOLES'
                        , 'SUB_TOTAL_VENTA_ORIG'
                        , 'SUB_TOTAL_VENTA_SOLES'
                        , 'TOTAL_VENTA_ORIG'
                        , 'TOTAL_VENTA_SOLES'
                        , 'V_EXONERADO'
                        , 'ESTADO'
                        , 'NUM_DOC_ELECT'
                        , 'ES_TRANS_GRATUITA'
                        , 'DES_COM'
                        , 'ES_ANULADO'
                        , 'ENVIADO_EMAIL'
                        , 'ENVIADO_EXTERNO'
                        , 'NRO_ORDEN_COMP'
                        , 'NUM_GUIA'
                        , 'TIPO_DOC_REL'
                        , 'CON_DETRACCION'
                        , 'OBSERVACION'
                        , 'HORA_EMISION'
                        , 'ES_TURISTICO'
                        , 'ES_EXONERADO'
                        , 'GUIA_CLIENTE'
                        , 'GLOSA_DETALE'
                        , 'VALIDACION_SUNAT'
                        , 'ID_MOTIVO_EMISION'
                        , 'MOTIVO_EMISION'
                        , 'MONTO_IMP_BOLSA'
                        , 'MONTO_DETRACCION'
                        , 'MONTO_RETENCION'
                        , 'MONTO_NETO_PAGO'
                        , 'DESCUENTO_I'
                        , 'DESCUENTO'
                        , 'IMPUESTO_2'
                        , 'TIPO_DETRACCION'
                        , 'PORC_DETRACCION'
                        , 'MONTO_ANTICIPO'
                        , 'COD_ESTADO'
                        , 'TXT_ESTADO'
                        , 'COD_EMPR'
                        , 'TXT_EMPR'
                        , 'COD_CONTACTO'
                        , 'TXT_CONTACTO'
                        , 'TXT_PROCEDENCIA'
                        , 'ARCHIVO_XML'
                        , 'ARCHIVO_CDR'
                        , 'ARCHIVO_PDF'
                        , 'success'
                        , 'message'
                        , 'estadoCp'
                        , 'nestadoCp'
                        , 'estadoRuc'
                        , 'nestadoRuc'
                        , 'condDomiRuc'
                        , 'ncondDomiRuc'
                        , 'CODIGO_CDR'
                        , 'RESPUESTA_CDR'
                        , 'ind_ruc'
                        , 'ind_rz'
                        , 'ind_moneda'
                        , 'ind_total'
                        , 'ind_cantidaditem'
                        , 'ind_formapago'
                        , 'ind_errototal'
                        , 'dni_usuariocontacto'
                        , 'usuario_pa'
                        , 'usuario_uc'
                        , 'usuario_ap'
                        , 'usuario_pr'
                        , 'usuario_ex'
                        , 'mensaje_exuc'
                        , 'mensaje_exap'
                        , 'mensaje_exadm'
                        , 'ind_email_uc'
                        , 'ind_email_ap'
                        , 'ind_email_adm'
                        , 'ind_email_clap'
                        , 'ind_email_ba'
                        , 'ind_observacion'
                        , 'area_observacion'
                        , 'OPERACION'
                        , 'PERCEPCION'
                        , 'usuario_tes'
                        , 'LOTE')
                        ->where('ID_DOCUMENTO', '=', $orden->COD_DOCUMENTO_CTBLE)
                        ->get();


                    //dd($referenciaAsocQuery);
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsert = $referenciaAsocQuery->toArray();
                    //dd($dataToInsert);

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DOCUMENTO')->insert($dataToInsert);

                    //FE_DETALLE_DOCUENTO
                    $referenciaAsocQueryd = FeDetalleDocumento::select('*')
                        ->where('ID_DOCUMENTO', '=', $orden->COD_DOCUMENTO_CTBLE)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertd = $referenciaAsocQueryd->toArray();

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DETALLE_DOCUMENTO')->insert($dataToInsertd);

                    //CMPDocAsociarCompra
                    $referenciaAsocQueryac = CMPDocAsociarCompra::select('COD_ORDEN', 'COD_CATEGORIA_DOCUMENTO', 'NOM_CATEGORIA_DOCUMENTO', 'IND_OBLIGATORIO', 'TXT_FORMATO', 'TXT_ASIGNADO', 'COD_USUARIO_CREA_AUD', 'COD_ESTADO', 'TIP_DOC')
                        ->where('COD_ORDEN', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInserac = $referenciaAsocQueryac->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('CMP.DOC_ASOCIAR_COMPRA')->insert($dataToInserac);


                }


                DB::commit();
                Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

        } else {

            //lectura del cdr
            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
            //dd($idoc);
            $lecturacdr = $this->lectura_cdr_archivo($idoc, $this->pathFiles, $prefijocarperta, $ordencompra->NRO_DOCUMENTO_CLIENTE);

            if ($fedocumento->nestadoCp === null) {

                $fechaemision = date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                $token = '';
                if ($prefijocarperta == 'II') {
                    $token = $this->generartoken_ii();
                } else {
                    $token = $this->generartoken_is();
                }
                $rvalidar = $this->validar_xml($token,
                    $fedocumento->ID_CLIENTE,
                    $fedocumento->RUC_PROVEEDOR,
                    $fedocumento->ID_TIPO_DOC,
                    $fedocumento->SERIE,
                    $fedocumento->NUMERO,
                    $fechaemision,
                    $fedocumento->TOTAL_VENTA_ORIG);
                $arvalidar = json_decode($rvalidar, true);
                if (isset($arvalidar['success'])) {

                    if ($arvalidar['success']) {


                        $datares = $arvalidar['data'];

                        if (!isset($datares['estadoCp'])) {
                            return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                        }

                        $estadoCp = $datares['estadoCp'];
                        $tablaestacp = Estado::where('tipo', '=', 'estadoCp')->where('codigo', '=', $estadoCp)->first();

                        $estadoRuc = '';
                        $txtestadoRuc = '';
                        $estadoDomiRuc = '';
                        $txtestadoDomiRuc = '';

                        if (isset($datares['estadoRuc'])) {
                            $tablaestaruc = Estado::where('tipo', '=', 'estadoRuc')->where('codigo', '=', $datares['estadoRuc'])->first();
                            $estadoRuc = $tablaestaruc->codigo;
                            $txtestadoRuc = $tablaestaruc->nombre;
                        }
                        if (isset($datares['condDomiRuc'])) {
                            $tablaestaDomiRuc = Estado::where('tipo', '=', 'condDomiRuc')->where('codigo', '=', $datares['condDomiRuc'])->first();
                            $estadoDomiRuc = $tablaestaDomiRuc->codigo;
                            $txtestadoDomiRuc = $tablaestaDomiRuc->nombre;
                        }

                        FeDocumento::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)
                            ->update(
                                [
                                    'success' => $arvalidar['success'],
                                    'message' => $arvalidar['message'],
                                    'estadoCp' => $tablaestacp->codigo,
                                    'nestadoCp' => $tablaestacp->nombre,
                                    'estadoRuc' => $estadoRuc,
                                    'nestadoRuc' => $txtestadoRuc,
                                    'condDomiRuc' => $estadoDomiRuc,
                                    'ncondDomiRuc' => $txtestadoDomiRuc,
                                ]);
                    } else {
                        FeDocumento::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)
                            ->update(
                                [
                                    'success' => $arvalidar['success'],
                                    'message' => $arvalidar['message']
                                ]);
                    }
                }

            }

            $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();

            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idoc, $fedocumento->DOCUMENTO_ITEM);


            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();


            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();
            $codigo_sunat = 'N';


            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('TXT_GLOSA', '=', 'O')
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            $archivosselect = Archivo::Join('CMP.CATEGORIA', 'TIPO_ARCHIVO', '=', 'COD_CATEGORIA')
                ->where('ID_DOCUMENTO', '=', $idoc)
                ->pluck('COD_CATEGORIA')
                ->toArray();

            $documentoscomprarepable = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_TIPO_REFERENCIA', '=', 'R')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO', 'ARCHIVO_VIRTUAL_FISICO' => 'ARCHIVO_VIRTUAL_FISICO');

            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            //$combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($anio_defecto, $mes_defecto, Session::get('empresas')->COD_EMPR);
            //dd($mes_defecto);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio_defecto, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
            $periodo_defecto = $array_periodo_pc->COD_PERIODO;

            $sel_tipo_descuento = '';
            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

//            $combo_empresa = $this->gn_combo_empresa('Seleccione Cliente / Proveedor', '');

//            $tipo_doc = CMPCategoria::where('TXT_GRUPO', '=', 'TIPO_DOCUMENTO')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', $fedocumento->ID_TIPO_DOC)->first();
//            $empresa_doc = STDEmpresa::where('COD_ESTADO', '=', 1)->where('NRO_DOCUMENTO', '=', $fedocumento->RUC_PROVEEDOR)->first();
//            $tipo_cambio_asiento = CMPTipoCambio::where('COD_ESTADO', '=', 1)->whereDate('FEC_CAMBIO', '=', $fedocumento->FEC_VENTA)->first();

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $cod_contable = $fedocumento->ID_DOCUMENTO;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $centro_costo = '';
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            $asiento_compra = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':igv' => $igv,
                    ':ind_recalcular' => $ind_recalcular,
                    ':centro_costo' => $centro_costo,
                    ':ind_igv' => $ind_igv,
                    ':usuario' => $usuario
                ]
            );

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

            //if ($respuesta === 'ASIENTO CORRECTO') {
            if (!empty($asiento_compra)) {

                $ind_reversion = 'R';

                $asiento_existe_reparable = WEBAsiento::where('COD_ESTADO', '=', 1)
                    ->where('TXT_REFERENCIA', '=', $cod_contable)
                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', 'TAS0000000000007')
                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                    ->where('TXT_TIPO_REFERENCIA', 'NOT LIKE', "%NAVASOFT%")
                    ->first();

                if ($asiento_existe_reparable) {
                    $asiento_reparable_reversion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':ind_reversion' => $ind_reversion,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_reparable_reversion = [[], [], []];
                }

                if ($fedocumento->MONTO_ANTICIPO_DESC > 0.0000) {
                    $asiento_deduccion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_DEDUCCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':igv' => $igv,
                            ':ind_recalcular' => $ind_recalcular,
                            ':centro_costo' => $centro_costo,
                            ':ind_igv' => $ind_igv,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_deduccion = [[], [], []];
                }

                if ($fedocumento->PERCEPCION > 0.0000) {
                    $asiento_percepcion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_PERCEPCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_percepcion = [[], [], []];
                }
            }

            $ind_reversion = 'N';

            $asiento_reparable = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':ind_recalcular' => $ind_recalcular,
                    ':ind_reversion' => $ind_reversion,
                    ':usuario' => $usuario
                ]
            );

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');

            return View::make('comprobante/aprobarconcontrato',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,

                    'detalleordencompra' => $detalleordencompra,
                    'archivospdf' => $archivospdf,

                    'trabajador' => $trabajador,
                    'documentoscompra' => $documentoscompra,
                    'totalarchivos' => $totalarchivos,

                    'documentoscomprarepable' => $documentoscomprarepable,
                    'comboreparable' => $comboreparable,

                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'defecto_anio' => $anio_defecto,
                    'defecto_periodo' => $periodo_defecto,

                    //'combo_empresa_proveedor' => $combo_empresa,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,
//                    'tipo_doc_fe' => $tipo_doc,
//                    'empresa_doc_fe' => $empresa_doc,
//                    'tipo_cambio_asiento' => $tipo_cambio_asiento,

                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_descuento' => $combo_descuento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    'asiento_compra' => $asiento_compra,
                    'asiento_reparable_reversion' => $asiento_reparable_reversion,
                    'asiento_deduccion' => $asiento_deduccion,
                    'asiento_percepcion' => $asiento_percepcion,
                    'asiento_reparable' => $asiento_reparable,

                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'archivosanulados' => $archivosanulados,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionAprobarContabilidadNotaCredito($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_nota_credito_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_producto_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Aprobar Comprobante');

        if ($_POST) {


            try {

                DB::beginTransaction();

                $detalles = json_decode($request->input('asientosgenerados'), true);

                foreach ($detalles as $detalle) {

                    $cabeceras = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);
                    $generar = true;

                    foreach ($cabeceras as $cabecera) {

                        if ($cabecera['COD_CATEGORIA_TIPO_ASIENTO'] === 'TAS0000000000004') {
                            $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                ->where('COD_ESTADO', '=', 1)
                                ->where('TXT_GLOSA', 'LIKE', '%COMPRA%')
                                ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                ->first();
                        } else {
                            if (stripos($cabecera['TXT_GLOSA'], 'DEDUCCION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'LIKE', '%DEDUCCION%')
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                            } else {
                                if (stripos($cabecera['TXT_GLOSA'], 'PERCEPCION')) {
                                    $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                        ->where('COD_ESTADO', '=', 1)
                                        ->where('TXT_GLOSA', 'LIKE', '%PERCEPCION%')
                                        ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                        ->first();
                                } else {
                                    if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION') === false) {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    } else {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    }
                                }
                            }
                        }

                        if (empty($asiento_busqueda)) {
                            if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                                if (empty($asiento_busqueda)) {
                                    break;
                                }
                            }
                        } else {
                            break;
                        }

                        $COD_ASIENTO = $cabecera['COD_ASIENTO'];
                        $COD_EMPR = $cabecera['COD_EMPR'];
                        $COD_EMPR_CLI = $cabecera['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $cabecera['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = !empty($cabecera['COD_CATEGORIA_TIPO_DOCUMENTO']) ? $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO'] : 'TDO0000000000066';
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $cabecera['NRO_SERIE'];
                        $NRO_DOC = $cabecera['NRO_DOC'];
                        $COD_CENTRO = $cabecera['COD_CENTRO'];
                        $COD_PERIODO = $cabecera['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $cabecera['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $cabecera['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $cabecera['NRO_ASIENTO'];
                        $FEC_ASIENTO = $cabecera['FEC_ASIENTO'];
                        $TXT_GLOSA = $cabecera['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $cabecera['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $cabecera['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $cabecera['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $cabecera['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $cabecera['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $cabecera['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $cabecera['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $cabecera['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $cabecera['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $cabecera['IND_EXTORNO'];
                        $IND_ANULADO = $cabecera['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $cabecera['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $cabecera['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $cabecera['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $cabecera['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $cabecera['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $cabecera['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $cabecera['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $cabecera['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $cabecera['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $cabecera['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $cabecera['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $cabecera['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $cabecera['FEC_DETRACCION'];
                        $NRO_DETRACCION = $cabecera['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $cabecera['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $cabecera['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $cabecera['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $cabecera['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $cabecera['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $cabecera['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $cabecera['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $cabecera['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $cabecera['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $cabecera['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $cabecera['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $cabecera['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $cabecera['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $cabecera['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $cabecera['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $cabecera['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $cabecera['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $cabecera['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $cabecera['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $cabecera['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $cabecera['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();

                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if ($generar) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                'CEN0000000000001',
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();

                if ($fedocumento->ind_observacion == 1) {
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }

                $descripcion = $request['descripcion'];
                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();

                }


                $filespdf = $request['otros'];
                if (!is_null($filespdf)) {
                    //PDF
                    foreach ($filespdf as $file) {

                        //
                        $contadorArchivos = Archivo::count();

                        $nombre = $ordencompra->COD_DOCUMENTO_CTBLE . '-' . $file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordencompra->NRO_DOCUMENTO_CLIENTE;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf = $contadorArchivos . '-' . $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilepdf;
                        copy($file->getRealPath(), $rutacompleta);
                        $path = $rutacompleta;

                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $ordencompra->COD_DOCUMENTO_CTBLE;
                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = 'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS CONTABILIDAD';
                        $dcontrol->URL_ARCHIVO = $path;
                        $dcontrol->SIZE = filesize($file);
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                        //dd($nombre);
                    }
                }


                $nro_cuenta_contable = $request['nro_cuenta_contable'];


                FeDocumento::where('ID_DOCUMENTO', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADOO',
                            'NRO_CUENTA' => $nro_cuenta_contable,

                            'ind_email_adm' => 0,
                            'fecha_pr' => $this->fechaactual,
                            'usuario_pr' => Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                //geolocalización

                //whatsaap para administracion
                $fedocumento_w = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $ordencompra = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)->first();

                //$ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();

                $empresa = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR)->first();
                $mensaje = 'COMPROBANTE : ' . $fedocumento_w->ID_DOCUMENTO
                    . '%0D%0A' . 'EMPRESA : ' . $empresa->NOM_EMPR . '%0D%0A'
                    . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_EMISOR . '%0D%0A'
                    . 'ESTADO : ' . $fedocumento_w->TXT_ESTADO . '%0D%0A';


                DB::commit();
                Session::flash('operacion_id', 'NOTA_CREDITO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();

                Session::flash('operacion_id', 'NOTA_CREDITO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            //lectura del cdr
            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
            $lecturacdr = $this->lectura_cdr_archivo($idoc, $this->pathFiles, $prefijocarperta, $ordencompra->NRO_DOCUMENTO_CLIENTE);

            if ($fedocumento->nestadoCp === null) {

                $fechaemision = date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                $token = '';
                if ($prefijocarperta == 'II') {
                    $token = $this->generartoken_ii();
                } else {
                    $token = $this->generartoken_is();
                }
                $rvalidar = $this->validar_xml($token,
                    $fedocumento->ID_CLIENTE,
                    $fedocumento->RUC_PROVEEDOR,
                    $fedocumento->ID_TIPO_DOC,
                    $fedocumento->SERIE,
                    $fedocumento->NUMERO,
                    $fechaemision,
                    $fedocumento->TOTAL_VENTA_ORIG);
                $arvalidar = json_decode($rvalidar, true);
                if (isset($arvalidar['success'])) {

                    if ($arvalidar['success']) {


                        $datares = $arvalidar['data'];

                        if (!isset($datares['estadoCp'])) {
                            return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                        }

                        $estadoCp = $datares['estadoCp'];
                        $tablaestacp = Estado::where('tipo', '=', 'estadoCp')->where('codigo', '=', $estadoCp)->first();

                        $estadoRuc = '';
                        $txtestadoRuc = '';
                        $estadoDomiRuc = '';
                        $txtestadoDomiRuc = '';

                        if (isset($datares['estadoRuc'])) {
                            $tablaestaruc = Estado::where('tipo', '=', 'estadoRuc')->where('codigo', '=', $datares['estadoRuc'])->first();
                            $estadoRuc = $tablaestaruc->codigo;
                            $txtestadoRuc = $tablaestaruc->nombre;
                        }
                        if (isset($datares['condDomiRuc'])) {
                            $tablaestaDomiRuc = Estado::where('tipo', '=', 'condDomiRuc')->where('codigo', '=', $datares['condDomiRuc'])->first();
                            $estadoDomiRuc = $tablaestaDomiRuc->codigo;
                            $txtestadoDomiRuc = $tablaestaDomiRuc->nombre;
                        }

                        FeDocumento::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)
                            ->update(
                                [
                                    'success' => $arvalidar['success'],
                                    'message' => $arvalidar['message'],
                                    'estadoCp' => $tablaestacp->codigo,
                                    'nestadoCp' => $tablaestacp->nombre,
                                    'estadoRuc' => $estadoRuc,
                                    'nestadoRuc' => $txtestadoRuc,
                                    'condDomiRuc' => $estadoDomiRuc,
                                    'ncondDomiRuc' => $txtestadoDomiRuc,
                                ]);
                    } else {
                        FeDocumento::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)
                            ->update(
                                [
                                    'success' => $arvalidar['success'],
                                    'message' => $arvalidar['message']
                                ]);
                    }
                }

            }


            $detalleordencompra = $this->con_lista_detalle_producto_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->get();

            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idoc, $fedocumento->DOCUMENTO_ITEM);


            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();


            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();
            $codigo_sunat = 'N';


            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('TXT_GLOSA', '=', 'O')
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            $archivosselect = Archivo::Join('CMP.CATEGORIA', 'TIPO_ARCHIVO', '=', 'COD_CATEGORIA')
                ->where('ID_DOCUMENTO', '=', $idoc)
                ->pluck('COD_CATEGORIA')
                ->toArray();

            $documentoscomprarepable = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_TIPO_REFERENCIA', '=', 'R')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO', 'ARCHIVO_VIRTUAL_FISICO' => 'ARCHIVO_VIRTUAL_FISICO');

            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            //$combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($anio_defecto, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio_defecto, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
            $periodo_defecto = $array_periodo_pc->COD_PERIODO;

            $sel_tipo_descuento = '';
            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $cod_contable = $fedocumento->ID_DOCUMENTO;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $centro_costo = '';
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            $asiento_compra = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':igv' => $igv,
                    ':ind_recalcular' => $ind_recalcular,
                    ':centro_costo' => $centro_costo,
                    ':ind_igv' => $ind_igv,
                    ':usuario' => $usuario
                ]
            );

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

            if (count($asiento_compra) <= 2) {
                array_push($asiento_compra, []);
            }

            //if ($respuesta === 'ASIENTO CORRECTO') {
            if (!empty($asiento_compra)) {

                $ind_reversion = 'R';

                $asiento_existe_reparable = WEBAsiento::where('COD_ESTADO', '=', 1)
                    ->where('TXT_REFERENCIA', '=', $cod_contable)
                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', 'TAS0000000000007')
                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                    ->where('TXT_TIPO_REFERENCIA', 'NOT LIKE', "%NAVASOFT%")
                    ->first();

                if ($asiento_existe_reparable) {
                    $asiento_reparable_reversion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':ind_reversion' => $ind_reversion,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_reparable_reversion = [[], [], []];
                }

                if ($fedocumento->MONTO_ANTICIPO_DESC > 0.0000) {
                    $asiento_deduccion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_DEDUCCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':igv' => $igv,
                            ':ind_recalcular' => $ind_recalcular,
                            ':centro_costo' => $centro_costo,
                            ':ind_igv' => $ind_igv,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_deduccion = [[], [], []];
                }

                if ($fedocumento->PERCEPCION > 0.0000) {
                    $asiento_percepcion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_PERCEPCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_percepcion = [[], [], []];
                }
            }

            $ind_reversion = 'N';

            $asiento_reparable = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':ind_recalcular' => $ind_recalcular,
                    ':ind_reversion' => $ind_reversion,
                    ':usuario' => $usuario
                ]
            );

            if (count($asiento_reparable) <= 2) {
                array_push($asiento_reparable, []);
            }
            //dd($asiento_compra, $asiento_reparable, $asiento_percepcion, $asiento_reparable_reversion, $asiento_deduccion);

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');
            $funciones = $this;

            return View::make('comprobante/aprobarconnotacredito',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,

                    'detalleordencompra' => $detalleordencompra,
                    'archivospdf' => $archivospdf,

                    'trabajador' => $trabajador,
                    'documentoscompra' => $documentoscompra,
                    'totalarchivos' => $totalarchivos,

                    'documentoscomprarepable' => $documentoscomprarepable,
                    'comboreparable' => $comboreparable,

                    //NUEVO
                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'defecto_anio' => $anio_defecto,
                    'defecto_periodo' => $periodo_defecto,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,
                    'combo_descuento' => $combo_descuento,
                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    'asiento_compra' => $asiento_compra,
                    'asiento_reparable_reversion' => $asiento_reparable_reversion,
                    'asiento_deduccion' => $asiento_deduccion,
                    'asiento_percepcion' => $asiento_percepcion,
                    'asiento_reparable' => $asiento_reparable,
                    // NUEVO

                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'archivosanulados' => $archivosanulados,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionAprobarContabilidadNotaDebito($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_nota_debito_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_producto_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Aprobar Comprobante');

        if ($_POST) {


            try {

                DB::beginTransaction();

                $detalles = json_decode($request->input('asientosgenerados'), true);

                foreach ($detalles as $detalle) {

                    $cabeceras = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);
                    $generar = true;

                    foreach ($cabeceras as $cabecera) {

                        if ($cabecera['COD_CATEGORIA_TIPO_ASIENTO'] === 'TAS0000000000004') {
                            $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                ->where('COD_ESTADO', '=', 1)
                                ->where('TXT_GLOSA', 'LIKE', '%COMPRA%')
                                ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                ->first();
                        } else {
                            if (stripos($cabecera['TXT_GLOSA'], 'DEDUCCION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'LIKE', '%DEDUCCION%')
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                            } else {
                                if (stripos($cabecera['TXT_GLOSA'], 'PERCEPCION')) {
                                    $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                        ->where('COD_ESTADO', '=', 1)
                                        ->where('TXT_GLOSA', 'LIKE', '%PERCEPCION%')
                                        ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                        ->first();
                                } else {
                                    if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION') === false) {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    } else {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    }
                                }
                            }
                        }

                        if (empty($asiento_busqueda)) {
                            if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                                if (empty($asiento_busqueda)) {
                                    break;
                                }
                            }
                        } else {
                            break;
                        }

                        $COD_ASIENTO = $cabecera['COD_ASIENTO'];
                        $COD_EMPR = $cabecera['COD_EMPR'];
                        $COD_EMPR_CLI = $cabecera['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $cabecera['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = !empty($cabecera['COD_CATEGORIA_TIPO_DOCUMENTO']) ? $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO'] : 'TDO0000000000066';
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $cabecera['NRO_SERIE'];
                        $NRO_DOC = $cabecera['NRO_DOC'];
                        $COD_CENTRO = $cabecera['COD_CENTRO'];
                        $COD_PERIODO = $cabecera['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $cabecera['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $cabecera['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $cabecera['NRO_ASIENTO'];
                        $FEC_ASIENTO = $cabecera['FEC_ASIENTO'];
                        $TXT_GLOSA = $cabecera['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $cabecera['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $cabecera['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $cabecera['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $cabecera['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $cabecera['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $cabecera['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $cabecera['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $cabecera['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $cabecera['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $cabecera['IND_EXTORNO'];
                        $IND_ANULADO = $cabecera['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $cabecera['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $cabecera['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $cabecera['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $cabecera['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $cabecera['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $cabecera['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $cabecera['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $cabecera['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $cabecera['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $cabecera['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $cabecera['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $cabecera['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $cabecera['FEC_DETRACCION'];
                        $NRO_DETRACCION = $cabecera['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $cabecera['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $cabecera['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $cabecera['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $cabecera['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $cabecera['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $cabecera['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $cabecera['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $cabecera['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $cabecera['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $cabecera['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $cabecera['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $cabecera['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $cabecera['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $cabecera['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $cabecera['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $cabecera['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $cabecera['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $cabecera['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $cabecera['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $cabecera['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $cabecera['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();

                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if ($generar) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                'CEN0000000000001',
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();

                if ($fedocumento->ind_observacion == 1) {
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }

                $descripcion = $request['descripcion'];
                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();
                    //LE LLEGA AL USUARIO DE CONTACTO

                }


                $filespdf = $request['otros'];
                if (!is_null($filespdf)) {
                    //PDF
                    foreach ($filespdf as $file) {

                        //
                        $contadorArchivos = Archivo::count();

                        $nombre = $ordencompra->COD_DOCUMENTO_CTBLE . '-' . $file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordencompra->NRO_DOCUMENTO_CLIENTE;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf = $contadorArchivos . '-' . $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilepdf;
                        copy($file->getRealPath(), $rutacompleta);
                        $path = $rutacompleta;

                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $ordencompra->COD_DOCUMENTO_CTBLE;
                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = 'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS CONTABILIDAD';
                        $dcontrol->URL_ARCHIVO = $path;
                        $dcontrol->SIZE = filesize($file);
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                        //dd($nombre);
                    }
                }


                $nro_cuenta_contable = $request['nro_cuenta_contable'];


                FeDocumento::where('ID_DOCUMENTO', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADOO',
                            'NRO_CUENTA' => $nro_cuenta_contable,

                            'ind_email_adm' => 0,
                            'fecha_pr' => $this->fechaactual,
                            'usuario_pr' => Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();


                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                //geolocalización


                //whatsaap para administracion
                $fedocumento_w = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $ordencompra = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)->first();

                //$ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();

                $empresa = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR)->first();
                $mensaje = 'COMPROBANTE : ' . $fedocumento_w->ID_DOCUMENTO
                    . '%0D%0A' . 'EMPRESA : ' . $empresa->NOM_EMPR . '%0D%0A'
                    . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_EMISOR . '%0D%0A'
                    . 'ESTADO : ' . $fedocumento_w->TXT_ESTADO . '%0D%0A';


                DB::commit();
                Session::flash('operacion_id', 'NOTA_DEBITO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();

                Session::flash('operacion_id', 'NOTA_DEBITO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            //lectura del cdr
            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
            $lecturacdr = $this->lectura_cdr_archivo($idoc, $this->pathFiles, $prefijocarperta, $ordencompra->NRO_DOCUMENTO_CLIENTE);

            if ($fedocumento->nestadoCp === null) {

                $fechaemision = date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                $token = '';
                if ($prefijocarperta == 'II') {
                    $token = $this->generartoken_ii();
                } else {
                    $token = $this->generartoken_is();
                }
                $rvalidar = $this->validar_xml($token,
                    $fedocumento->ID_CLIENTE,
                    $fedocumento->RUC_PROVEEDOR,
                    $fedocumento->ID_TIPO_DOC,
                    $fedocumento->SERIE,
                    $fedocumento->NUMERO,
                    $fechaemision,
                    $fedocumento->TOTAL_VENTA_ORIG);
                $arvalidar = json_decode($rvalidar, true);
                if (isset($arvalidar['success'])) {

                    if ($arvalidar['success']) {


                        $datares = $arvalidar['data'];

                        if (!isset($datares['estadoCp'])) {
                            return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                        }

                        $estadoCp = $datares['estadoCp'];
                        $tablaestacp = Estado::where('tipo', '=', 'estadoCp')->where('codigo', '=', $estadoCp)->first();

                        $estadoRuc = '';
                        $txtestadoRuc = '';
                        $estadoDomiRuc = '';
                        $txtestadoDomiRuc = '';

                        if (isset($datares['estadoRuc'])) {
                            $tablaestaruc = Estado::where('tipo', '=', 'estadoRuc')->where('codigo', '=', $datares['estadoRuc'])->first();
                            $estadoRuc = $tablaestaruc->codigo;
                            $txtestadoRuc = $tablaestaruc->nombre;
                        }
                        if (isset($datares['condDomiRuc'])) {
                            $tablaestaDomiRuc = Estado::where('tipo', '=', 'condDomiRuc')->where('codigo', '=', $datares['condDomiRuc'])->first();
                            $estadoDomiRuc = $tablaestaDomiRuc->codigo;
                            $txtestadoDomiRuc = $tablaestaDomiRuc->nombre;
                        }

                        FeDocumento::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)
                            ->update(
                                [
                                    'success' => $arvalidar['success'],
                                    'message' => $arvalidar['message'],
                                    'estadoCp' => $tablaestacp->codigo,
                                    'nestadoCp' => $tablaestacp->nombre,
                                    'estadoRuc' => $estadoRuc,
                                    'nestadoRuc' => $txtestadoRuc,
                                    'condDomiRuc' => $estadoDomiRuc,
                                    'ncondDomiRuc' => $txtestadoDomiRuc,
                                ]);
                    } else {
                        FeDocumento::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)
                            ->update(
                                [
                                    'success' => $arvalidar['success'],
                                    'message' => $arvalidar['message']
                                ]);
                    }
                }

            }


            $detalleordencompra = $this->con_lista_detalle_producto_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->get();

            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idoc, $fedocumento->DOCUMENTO_ITEM);


            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();


            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();
            $codigo_sunat = 'N';


            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_GLOSA', '=', 'O')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            $archivosselect = Archivo::Join('CMP.CATEGORIA', 'TIPO_ARCHIVO', '=', 'COD_CATEGORIA')
                ->where('ID_DOCUMENTO', '=', $idoc)
                ->pluck('COD_CATEGORIA')
                ->toArray();

            $documentoscomprarepable = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_TIPO_REFERENCIA', '=', 'R')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO', 'ARCHIVO_VIRTUAL_FISICO' => 'ARCHIVO_VIRTUAL_FISICO');

            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            //$combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($anio_defecto, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio_defecto, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
            $periodo_defecto = $array_periodo_pc->COD_PERIODO;

            $sel_tipo_descuento = '';
            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $cod_contable = $fedocumento->ID_DOCUMENTO;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $centro_costo = '';
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            $asiento_compra = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':igv' => $igv,
                    ':ind_recalcular' => $ind_recalcular,
                    ':centro_costo' => $centro_costo,
                    ':ind_igv' => $ind_igv,
                    ':usuario' => $usuario
                ]
            );

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

            if (count($asiento_compra) <= 2) {
                array_push($asiento_compra, []);
            }

            //if ($respuesta === 'ASIENTO CORRECTO') {
            if (!empty($asiento_compra)) {

                $ind_reversion = 'R';

                $asiento_existe_reparable = WEBAsiento::where('COD_ESTADO', '=', 1)
                    ->where('TXT_REFERENCIA', '=', $cod_contable)
                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', 'TAS0000000000007')
                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                    ->where('TXT_TIPO_REFERENCIA', 'NOT LIKE', "%NAVASOFT%")
                    ->first();

                if ($asiento_existe_reparable) {
                    $asiento_reparable_reversion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':ind_reversion' => $ind_reversion,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_reparable_reversion = [[], [], []];
                }

                if ($fedocumento->MONTO_ANTICIPO_DESC > 0.0000) {
                    $asiento_deduccion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_DEDUCCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':igv' => $igv,
                            ':ind_recalcular' => $ind_recalcular,
                            ':centro_costo' => $centro_costo,
                            ':ind_igv' => $ind_igv,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_deduccion = [[], [], []];
                }

                if ($fedocumento->PERCEPCION > 0.0000) {
                    $asiento_percepcion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_PERCEPCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_percepcion = [[], [], []];
                }
            }

            $ind_reversion = 'N';

            $asiento_reparable = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':ind_recalcular' => $ind_recalcular,
                    ':ind_reversion' => $ind_reversion,
                    ':usuario' => $usuario
                ]
            );

            if (count($asiento_reparable) <= 2) {
                array_push($asiento_reparable, []);
            }
            //dd($asiento_compra, $asiento_reparable, $asiento_percepcion, $asiento_reparable_reversion, $asiento_deduccion);

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');
            $funciones = $this;

            return View::make('comprobante/aprobarconnotadebito',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,

                    'detalleordencompra' => $detalleordencompra,
                    'archivospdf' => $archivospdf,

                    'trabajador' => $trabajador,
                    'documentoscompra' => $documentoscompra,
                    'totalarchivos' => $totalarchivos,

                    'documentoscomprarepable' => $documentoscomprarepable,
                    'comboreparable' => $comboreparable,

                    //NUEVO
                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'defecto_anio' => $anio_defecto,
                    'defecto_periodo' => $periodo_defecto,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,
                    'combo_descuento' => $combo_descuento,
                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    'asiento_compra' => $asiento_compra,
                    'asiento_reparable_reversion' => $asiento_reparable_reversion,
                    'asiento_deduccion' => $asiento_deduccion,
                    'asiento_percepcion' => $asiento_percepcion,
                    'asiento_reparable' => $asiento_reparable,
                    // NUEVO

                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'archivosanulados' => $archivosanulados,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }


    public function actionAprobarContabilidadPG($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/

        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_pg_idoc($idoc);
        $detalleordencompra = $this->con_lista_detalle_pg_comprobante_idoc($idoc);


        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Aprobar Comprobante');

        if ($_POST) {


            try {

                DB::beginTransaction();

                $detalles = json_decode($request->input('asientosgenerados'), true);

                foreach ($detalles as $detalle) {

                    $cabeceras = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);
                    $generar = true;

                    foreach ($cabeceras as $cabecera) {

                        if ($cabecera['COD_CATEGORIA_TIPO_ASIENTO'] === 'TAS0000000000004') {
                            $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                ->where('COD_ESTADO', '=', 1)
                                ->where('TXT_GLOSA', 'LIKE', '%COMPRA%')
                                ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                ->first();
                        } else {
                            if (stripos($cabecera['TXT_GLOSA'], 'DEDUCCION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'LIKE', '%DEDUCCION%')
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                            } else {
                                if (stripos($cabecera['TXT_GLOSA'], 'PERCEPCION')) {
                                    $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                        ->where('COD_ESTADO', '=', 1)
                                        ->where('TXT_GLOSA', 'LIKE', '%PERCEPCION%')
                                        ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                        ->first();
                                } else {
                                    if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION') === false) {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    } else {
                                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                            ->where('COD_ESTADO', '=', 1)
                                            ->where('TXT_GLOSA', 'LIKE', "%REVERSION%")
                                            ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                            ->first();
                                    }
                                }
                            }
                        }

                        if (empty($asiento_busqueda)) {
                            if (stripos($cabecera['TXT_GLOSA'], 'REPARABLE') and stripos($cabecera['TXT_GLOSA'], 'REVERSION')) {
                                $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $cabecera['TXT_REFERENCIA'])
                                    ->where('COD_ESTADO', '=', 1)
                                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $cabecera['COD_CATEGORIA_TIPO_ASIENTO'])
                                    ->first();
                                if (empty($asiento_busqueda)) {
                                    break;
                                }
                            }
                        } else {
                            break;
                        }

                        $COD_ASIENTO = $cabecera['COD_ASIENTO'];
                        $COD_EMPR = $cabecera['COD_EMPR'];
                        $COD_EMPR_CLI = $cabecera['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $cabecera['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = !empty($cabecera['COD_CATEGORIA_TIPO_DOCUMENTO']) ? $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO'] : 'TDO0000000000066';
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $cabecera['NRO_SERIE'];
                        $NRO_DOC = $cabecera['NRO_DOC'];
                        $COD_CENTRO = $cabecera['COD_CENTRO'];
                        $COD_PERIODO = $cabecera['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $cabecera['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $cabecera['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $cabecera['NRO_ASIENTO'];
                        $FEC_ASIENTO = $cabecera['FEC_ASIENTO'];
                        $TXT_GLOSA = $cabecera['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $cabecera['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $cabecera['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $cabecera['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $cabecera['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $cabecera['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $cabecera['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $cabecera['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $cabecera['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $cabecera['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $cabecera['IND_EXTORNO'];
                        $IND_ANULADO = $cabecera['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $cabecera['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $cabecera['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $cabecera['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $cabecera['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $cabecera['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $cabecera['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $cabecera['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $cabecera['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $cabecera['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $cabecera['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $cabecera['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $cabecera['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $cabecera['FEC_DETRACCION'];
                        $NRO_DETRACCION = $cabecera['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $cabecera['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $cabecera['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $cabecera['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $cabecera['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $cabecera['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $cabecera['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $cabecera['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $cabecera['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $cabecera['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $cabecera['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $cabecera['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $cabecera['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $cabecera['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $cabecera['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $cabecera['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $cabecera['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $cabecera['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $cabecera['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $cabecera['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $cabecera['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $cabecera['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $cabecera['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();

                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if ($generar) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                'CEN0000000000001',
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();

                if ($fedocumento->ind_observacion == 1) {
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }

                $descripcion = $request['descripcion'];
                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();

                    //geolocalizacion
                    $device_info = $request['device_info'];
                    $this->con_datos_de_la_pc($device_info, $fedocumento, 'RECOMENDACION POR CONTABILIDAD');
                    //geolocalización


                }


                $filespdf = $request['otros'];
                if (!is_null($filespdf)) {
                    //PDF
                    foreach ($filespdf as $file) {

                        //
                        $contadorArchivos = Archivo::count();

                        $nombre = $ordencompra->COD_DOCUMENTO_CTBLE . '-' . $file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordencompra->NRO_DOCUMENTO;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf = $contadorArchivos . '-' . $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilepdf;
                        copy($file->getRealPath(), $rutacompleta);
                        $path = $rutacompleta;

                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $ordencompra->COD_DOCUMENTO_CTBLE;
                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = 'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS CONTABILIDAD';
                        $dcontrol->URL_ARCHIVO = $path;
                        $dcontrol->SIZE = filesize($file);
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                        //dd($nombre);
                    }
                }


                $nro_cuenta_contable = $request['nro_cuenta_contable'];


                FeDocumento::where('ID_DOCUMENTO', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADOO',
                            'NRO_CUENTA' => $nro_cuenta_contable,

                            'ind_email_adm' => 0,
                            'fecha_pr' => $this->fechaactual,
                            'usuario_pr' => Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'APROBADO POR CONTABILIDAD');
                //geolocalización


                //whatsaap para administracion
                $fedocumento_w = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $ordencompra = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)->first();

                //$ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();

                $empresa = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR)->first();
                $mensaje = 'COMPROBANTE : ' . $fedocumento_w->ID_DOCUMENTO
                    . '%0D%0A' . 'EMPRESA : ' . $empresa->NOM_EMPR . '%0D%0A'
                    . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_EMISOR . '%0D%0A'
                    . 'ESTADO : ' . $fedocumento_w->TXT_ESTADO . '%0D%0A';


                DB::commit();
                Session::flash('operacion_id', 'PROVISION_GASTO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();

                Session::flash('operacion_id', 'PROVISION_GASTO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $ordencompra = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $idoc)->first();
            //lectura del cdr
            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
            $lecturacdr = $this->lectura_cdr_archivo($idoc, $this->pathFiles, $prefijocarperta, $ordencompra->NRO_DOCUMENTO_CLIENTE);

            $detalleordencompra = $this->con_lista_detalle_pg_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->get();

            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = $this->lista_archivos_total($idoc, $fedocumento->DOCUMENTO_ITEM);
            $archivospdf = $this->lista_archivos_total_pdf($idoc, $fedocumento->DOCUMENTO_ITEM);


            $archivosanulados = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '0')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();
            $codigo_sunat = 'N';


            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_GLOSA', '=', 'O')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            $archivosselect = Archivo::Join('CMP.CATEGORIA', 'TIPO_ARCHIVO', '=', 'COD_CATEGORIA')
                ->where('ID_DOCUMENTO', '=', $idoc)
                ->pluck('COD_CATEGORIA')
                ->toArray();

            $documentoscomprarepable = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->where('TXT_TIPO_REFERENCIA', '=', 'R')
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO', 'ARCHIVO_VIRTUAL_FISICO' => 'ARCHIVO_VIRTUAL_FISICO');

            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            //$combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($anio_defecto, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio_defecto, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
            $periodo_defecto = $array_periodo_pc->COD_PERIODO;

            $sel_tipo_descuento = '';
            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $cod_contable = $fedocumento->ID_DOCUMENTO;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $centro_costo = '';
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            $asiento_compra = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':igv' => $igv,
                    ':ind_recalcular' => $ind_recalcular,
                    ':centro_costo' => $centro_costo,
                    ':ind_igv' => $ind_igv,
                    ':usuario' => $usuario
                ]
            );

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

            if (count($asiento_compra) <= 2) {
                array_push($asiento_compra, []);
            }

            //if ($respuesta === 'ASIENTO CORRECTO') {
            if (!empty($asiento_compra)) {

                $ind_reversion = 'R';

                $asiento_existe_reparable = WEBAsiento::where('COD_ESTADO', '=', 1)
                    ->where('TXT_REFERENCIA', '=', $cod_contable)
                    ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', 'TAS0000000000007')
                    ->where('TXT_GLOSA', 'NOT LIKE', "%REVERSION%")
                    ->where('TXT_GLOSA', 'LIKE', "%REPARABLE%")
                    ->where('TXT_TIPO_REFERENCIA', 'NOT LIKE', "%NAVASOFT%")
                    ->first();

                if ($asiento_existe_reparable) {
                    $asiento_reparable_reversion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':ind_reversion' => $ind_reversion,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_reparable_reversion = [[], [], []];
                }

                if ($fedocumento->MONTO_ANTICIPO_DESC > 0.0000) {
                    $asiento_deduccion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_DEDUCCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @ind_recalcular = :ind_recalcular,
                @centro_costo = :centro_costo,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':igv' => $igv,
                            ':ind_recalcular' => $ind_recalcular,
                            ':centro_costo' => $centro_costo,
                            ':ind_igv' => $ind_igv,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_deduccion = [[], [], []];
                }

                if ($fedocumento->PERCEPCION > 0.0000) {
                    $asiento_percepcion = $this->ejecutarSP(
                        "EXEC [WEB].[GENERAR_ASIENTO_PERCEPCION_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @cod_usuario_registra = :usuario",
                        [
                            ':anio' => $anio,
                            ':empresa' => $empresa,
                            ':cod_contable' => $cod_contable,
                            ':ind_anulado' => $ind_anulado,
                            ':ind_recalcular' => $ind_recalcular,
                            ':usuario' => $usuario
                        ]
                    );
                } else {
                    $asiento_percepcion = [[], [], []];
                }
            }

            $ind_reversion = 'N';

            $asiento_reparable = $this->ejecutarSP(
                "EXEC [WEB].[GENERAR_ASIENTO_REPARABLE_FE_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @ind_recalcular = :ind_recalcular,
                @ind_reversion = :ind_reversion,
                @cod_usuario_registra = :usuario",
                [
                    ':anio' => $anio,
                    ':empresa' => $empresa,
                    ':cod_contable' => $cod_contable,
                    ':ind_anulado' => $ind_anulado,
                    ':ind_recalcular' => $ind_recalcular,
                    ':ind_reversion' => $ind_reversion,
                    ':usuario' => $usuario
                ]
            );

            if (count($asiento_reparable) <= 2) {
                array_push($asiento_reparable, []);
            }
            //dd($asiento_compra, $asiento_reparable, $asiento_percepcion, $asiento_reparable_reversion, $asiento_deduccion);

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');
            $funciones = $this;

            return View::make('comprobante/aprobarconpg',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,

                    'detalleordencompra' => $detalleordencompra,
                    'archivospdf' => $archivospdf,

                    'trabajador' => $trabajador,
                    'documentoscompra' => $documentoscompra,
                    'totalarchivos' => $totalarchivos,

                    'documentoscomprarepable' => $documentoscomprarepable,
                    'comboreparable' => $comboreparable,

                    //NUEVO
                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'defecto_anio' => $anio_defecto,
                    'defecto_periodo' => $periodo_defecto,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,
                    'combo_descuento' => $combo_descuento,
                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    'asiento_compra' => $asiento_compra,
                    'asiento_reparable_reversion' => $asiento_reparable_reversion,
                    'asiento_deduccion' => $asiento_deduccion,
                    'asiento_percepcion' => $asiento_percepcion,
                    'asiento_reparable' => $asiento_reparable,
                    // NUEVO

                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'archivosanulados' => $archivosanulados,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }


    public function buscarProveedor(Request $request)
    {
        $q = $request->get('busqueda', '');

        return STDEmpresa::where('COD_ESTADO', '=', 1)
            ->where('IND_PROVEEDOR', '=', 1)
            ->where('NOM_EMPR', 'like', "%{$q}%")
            ->select('COD_EMPR as id', 'NOM_EMPR as text')
            ->limit(50)
            ->get();

    }

    public function actionAjaxComboPeriodoAnioEmpresa(Request $request)
    {
        $anio = $request['anio'];
//        dd($request);
        $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
        $periodo_defecto = '';
        $funcion = $this;

        return View::make('general/combo/cperiodo',
            [
                'array_periodo' => $combo_periodo,
                'defecto_periodo' => $periodo_defecto,
                'ajax' => true,
            ]);
    }

    public function actionAjaxComboPeriodoAnioEmpresaReparable(Request $request)
    {
        $anio = $request['anio'];
//        dd($request);
        $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($anio, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
        $periodo_defecto = '';
        $funcion = $this;

        return View::make('general/combo/cperiodoreparable',
            [
                'array_periodo' => $combo_periodo,
                'defecto_periodo' => $periodo_defecto,
                'ajax' => true,
            ]);
    }

    public function actionAgregarObservacionContabilidad($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Observar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivoob'];


                if ($fedocumento->ind_observacion == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }

                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('agregar-observacion-contabilidad/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                foreach ($archivoob as $index => $item) {

                    $docu_asoci = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                        ->where('COD_CATEGORIA_DOCUMENTO', '=', $item)->first();


                    if (count($docu_asoci) > 0) {

                        Archivo::where('ID_DOCUMENTO', '=', $idoc)
                            ->where('ACTIVO', '=', '1')
                            ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                            ->where('TIPO_ARCHIVO', '=', $item)
                            ->update(
                                [
                                    'ACTIVO' => 0,
                                    'EXTENSION' => 'OBS',
                                    'FECHA_MOD' => $this->fechaactual,
                                    'USUARIO_MOD' => Session::get('usuario')->id
                                ]
                            );

                    } else {

                        $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                        $docasociar = new CMPDocAsociarCompra;
                        $docasociar->COD_ORDEN = $idoc;
                        $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                        $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                        $docasociar->IND_OBLIGATORIO = 0;
                        $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                        $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                        $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                        $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                        $docasociar->COD_ESTADO = 1;
                        $docasociar->TIP_DOC = 'O';
                        $docasociar->save();

                    }


                }


                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR CONTABILIDAD';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'OBSERVADO POR CONTABILIDAD');
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ind_observacion' => 1,
                            'TXT_OBSERVADO' => 'OBSERVADO',
                            'area_observacion' => 'CONT'
                        ]
                    );


                DB::commit();
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' OBSERVADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $ordencompra_t = CMPOrden::where('COD_ORDEN', '=', $idoc)->first();

            $codigo_sunat = 'I';
            if ($ordencompra_t->IND_VARIAS_ENTREGAS == 0) {
                $codigo_sunat = 'N';
            }

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();
            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);

            return View::make('comprobante/observarcontabilidad',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionAgregarObservacionContabilidadReparable($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Observar Comprobante Reparable');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR CONTABILIDAD REPARABLE';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'OBSERVADO POR CONTABILIDAD REPARABLE');
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'IND_REPARABLE' => 1,
                            'IND_OBSERVACION_REPARABLE' => 1
                        ]
                    );
                $docasociados = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                    ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO'])
                    ->first();

                //dd($ordencompra);

                Archivo::where('ID_DOCUMENTO', $ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM', '=', $linea)->where('TIPO_ARCHIVO', '=', $docasociados->COD_CATEGORIA_DOCUMENTO)
                    ->update(
                        [
                            'ACTIVO' => '0'
                        ]
                    );

                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)
                //                         ->where('TXT_TELEFONO','<>','')
                //                         ->first();

                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE OBSERVADO REPARABLE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'MENSAJE : '.$descripcion.'%0D%0A';

                // //dd($trabajador);
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     if(count($trabajador)>0){
                //         $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     }
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }

                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-reparable/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' OBSERVADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-comprobantes-reparable/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        }

    }


    public function actionAgregarExtornoContratoContabilidad($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Extorno Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcionextorno'];

                //GUARDAR LA REFENCIA ORIGINAL DEL EXTORNO
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'TXT_REFERENCIA' => $idoc
                        ]
                    );
                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO EXTORNADO';
                $documento->MENSAJE = $descripcion;
                $documento->save();


                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO EXTORNADO');
                //geolocalización


                //ANULAR TODA LA OPERACION
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X',
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO',
                            'ind_observacion' => 0
                        ]
                    );
                FeDetalleDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );

                FeDocumentoHistorial::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                FeFormaPago::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                Archivo::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );

                $this->anular_asiento_sic(Session::get('empresas')->COD_EMPR,$idoc,Session::get('usuario')->id,'1901-01-01');

                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE REPARABLE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'MENSAJE : '.$descripcion.'%0D%0A';
                // //dd($trabajador);
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }

                DB::commit();
                Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'CONTRATO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }
    }

    public function actionAgregarExtornoNotaCreditoContabilidad($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_nota_credito_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_producto_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Extorno Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcionextorno'];

                //GUARDAR LA REFENCIA ORIGINAL DEL EXTORNO
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'TXT_REFERENCIA' => $idoc
                        ]
                    );
                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO EXTORNADO';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO EXTORNADO');
                //geolocalización


                //ANULAR TODA LA OPERACION
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X',
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO',
                            'ind_observacion' => 0
                        ]
                    );
                FeDetalleDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );

                FeDocumentoHistorial::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                FeFormaPago::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                Archivo::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                $this->anular_asiento_sic(Session::get('empresas')->COD_EMPR,$idoc,Session::get('usuario')->id,'1901-01-01');
                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE REPARABLE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'MENSAJE : '.$descripcion.'%0D%0A';
                // //dd($trabajador);
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }

                DB::commit();
                Session::flash('operacion_id', 'NOTA_CREDITO');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'NOTA_CREDITO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }
    }

    public function actionAgregarExtornoNotaDebitoContabilidad($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_nota_debito_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_producto_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Extorno Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcionextorno'];

                //GUARDAR LA REFENCIA ORIGINAL DEL EXTORNO
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'TXT_REFERENCIA' => $idoc
                        ]
                    );
                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO EXTORNADO';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO EXTORNADO');
                //geolocalización


                //ANULAR TODA LA OPERACION
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X',
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO',
                            'ind_observacion' => 0
                        ]
                    );
                FeDetalleDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );

                FeDocumentoHistorial::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                FeFormaPago::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                Archivo::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                $this->anular_asiento_sic(Session::get('empresas')->COD_EMPR,$idoc,Session::get('usuario')->id,'1901-01-01');
                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE REPARABLE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'MENSAJE : '.$descripcion.'%0D%0A';
                // //dd($trabajador);
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }

                DB::commit();
                Session::flash('operacion_id', 'NOTA_DEBITO');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'NOTA_DEBITO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }
    }

    public function actionAgregarExtornoPGContabilidad($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/

        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_pg_idoc($idoc);
        $detalleordencompra = $this->con_lista_detalle_pg_comprobante_idoc($idoc);


        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Extorno Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcionextorno'];

                //GUARDAR LA REFENCIA ORIGINAL DEL EXTORNO
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'TXT_REFERENCIA' => $idoc
                        ]
                    );
                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO EXTORNADO';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO EXTORNADO');
                //geolocalización


                //ANULAR TODA LA OPERACION
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X',
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO',
                            'ind_observacion' => 0
                        ]
                    );
                FeDetalleDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );

                FeDocumentoHistorial::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                FeFormaPago::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                Archivo::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );


                DB::commit();
                Session::flash('operacion_id', 'PROVISION_GASTO');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'PROVISION_GASTO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }
    }

    public function actionAgregarExtornoEstibaContabilidad($idopcion, $lote, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $lote;
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Extorno Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                $descripcion = $request['descripcionextorno'];

                //GUARDAR LA REFENCIA ORIGINAL DEL EXTORNO
                FeDocumento::where('ID_DOCUMENTO', $idoc)
                    ->update(
                        [
                            'TXT_REFERENCIA' => $idoc
                        ]
                    );
                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO EXTORNADO';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO EXTORNADO');
                //geolocalización


                //ANULAR TODA LA OPERACION
                FeDocumento::where('ID_DOCUMENTO', $idoc)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X',
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO',
                            'ind_observacion' => 0
                        ]
                    );
                FeDetalleDocumento::where('ID_DOCUMENTO', $idoc)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );

                FeDocumentoHistorial::where('ID_DOCUMENTO', $idoc)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                FeFormaPago::where('ID_DOCUMENTO', $idoc)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                Archivo::where('ID_DOCUMENTO', $idoc)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );

                FeRefAsoc::where('LOTE', '=', $idoc)
                    ->update(
                        [
                            'FECHA_MOD' => $this->fechaactual,
                            'USUARIO_MOD' => Session::get('usuario')->id,
                            'COD_ESTADO' => '0'
                        ]);
                $this->anular_asiento_sic(Session::get('empresas')->COD_EMPR,$idoc,Session::get('usuario')->id,'1901-01-01');
                DB::commit();
                Session::flash('operacion_id', $request['operacion_id']);
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $idoc . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', $request['operacion_id']);

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }
    }

    public function actionAgregarExtornoContabilidad($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Extornar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcionextorno'];
                $ordencompra_t = CMPOrden::where('COD_ORDEN', '=', $idoc)->first();

                // if($ordencompra_t->IND_MATERIAL_SERVICIO=='M'){
                //     DB::rollback();
                //     return Redirect::back()->with('errorurl', 'El comprobante no puede ser extornado porque tiene una Orden de Ingreso Ejecutada');
                // }

                //cambiar de estado aprobado la orden
                if ($ordencompra_t->IND_MATERIAL_SERVICIO == 'M') {
                    $ordencompra_t->COD_CATEGORIA_ESTADO_ORDEN = 'EOR0000000000016';
                    $ordencompra_t->TXT_CATEGORIA_ESTADO_ORDEN = 'APROBADO';
                    $ordencompra_t->save();
                }

                //dd($ordencompra_t->IND_MATERIAL_SERVICIO);
                //GUARDAR LA REFENCIA ORIGINAL DEL EXTORNO
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'TXT_REFERENCIA' => $idoc
                        ]
                    );
                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO EXTORNADO';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO EXTORNADO');
                //geolocalización


                //ANULAR TODA LA OPERACION
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X',
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO',
                            'ind_observacion' => 0
                        ]
                    );
                FeDetalleDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );

                FeDocumentoHistorial::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                FeFormaPago::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );
                Archivo::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ID_DOCUMENTO' => $idoc . 'X'
                        ]
                    );

                $this->anular_asiento_sic(Session::get('empresas')->COD_EMPR,$idoc,Session::get('usuario')->id,'1901-01-01');

                /*
                $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.LISTAR_FORMATO_ASIENTOS_VENTAS
                                                            @FECHA_INICIO = ?,
                                                            @FECHA_FIN = ?,
                                                            @COD_EMPRESA = ?,
                                                            @EMITIDA = ?');

                $stmt->bindParam(1, $fecha_inicio, PDO::PARAM_STR);
                $stmt->bindParam(2, $fecha_fin, PDO::PARAM_STR);
                $stmt->bindParam(3, $cod_empresa, PDO::PARAM_STR);
                $stmt->bindParam(4, $emitido, PDO::PARAM_STR);
                $stmt->execute();*/

                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE REPARABLE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'MENSAJE : '.$descripcion.'%0D%0A';
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }

                DB::commit();
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }

    }


    public function actionAgregarReparableContabilidad($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Reparar Comprobante');

        if ($_POST) {

            $asiento_cabecera_reparable = json_decode($request['asiento_cabecera_reparable'], true);
            $asiento_detalle_reparable = json_decode($request['asiento_detalle_reparable'], true);

            $anio_asiento = $request->input('anio_asiento_reparable');
            $periodo_asiento = $request->input('periodo_asiento_reparable');
            $moneda_asiento = $request->input('moneda_asiento_reparable');
            $tipo_cambio_asiento = $request->input('tipo_cambio_asiento_reparable');
            $empresa_asiento = $request->input('empresa_asiento_reparable');
            $fecha_asiento = $request->input('fecha_asiento_reparable');
            $tipo_documento_asiento = $request->input('tipo_documento_asiento_reparable');
            $serie_asiento = $request->input('serie_asiento_reparable');
            $numero_asiento = $request->input('numero_asiento_reparable');
            $tipo_documento_ref = $request->input('tipo_documento_ref_reparable');
            $serie_ref_asiento = $request->input('serie_ref_asiento_reparable');
            $numero_ref_asiento = $request->input('numero_ref_asiento_reparable');
            $glosa_asiento = $request->input('glosa_asiento_reparable');

            $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();
            $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();

            if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
            }

            $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $empresa_asiento)->first();
            $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_ref)->first();

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivore = $request['archivore'];
                $reparable = $request['reparable'];
                $archivofi = $request['archivofi'];


                if ($fedocumento->IND_REPARABLE == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento ya esta reparado no se puede reparar');
                }


                if (count($archivore) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                $modohibrido = '';
                $reparable_ori = $reparable;
                if ($reparable == 'ARCHIVO_VIRTUAL_FISICO') {
                    $reparable = 'ARCHIVO_VIRTUAL';
                }

                foreach ($archivore as $index => $item) {

                    $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                    $tipo_doc = $categoria->CODIGO_SUNAT;
                    if ($reparable_ori == 'ARCHIVO_VIRTUAL_FISICO') {
                        $tipo_doc = 'F';
                        $modohibrido = 'ARCHIVO_FISICO';
                    }
                    $docasociar = new CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN = $idoc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                    $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                    $docasociar->IND_OBLIGATORIO = 0;
                    $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                    $docasociar->TXT_ASIGNADO = $reparable;
                    $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                    $docasociar->COD_ESTADO = 1;
                    $docasociar->TIP_DOC = $tipo_doc;
                    $docasociar->save();
                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO ' . $reparable;
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO ' . $reparable);
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'IND_REPARABLE' => 1,
                            'MODO_REPARABLE' => $reparable,
                            'TXT_REPARABLE' => 'REPARABLE',
                            'MODO_REPARABLE_HIBRIDO' => $modohibrido
                        ]
                    );

                //GENERACION ASIENTOS
                if (count($asiento_cabecera_reparable) > 0 and count($asiento_detalle_reparable) > 0) {
                    $cod_tipo_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoCompra = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $glosa_asiento,
                        $cod_estado_asiento,
                        $des_estado_asiento,
                        $moneda_asiento_aux->COD_CATEGORIA,
                        $moneda_asiento_aux->NOM_CATEGORIA,
                        $tipo_cambio_asiento,
                        0.0000,
                        0.0000,
                        '',
                        '',
                        0,
                        $asiento_cabecera_reparable[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_reparable[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_reparable[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                        $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                        $serie_asiento,
                        $numero_asiento,
                        $this->fechaactual,
                        '',
                        0.0000,
                        0.0000,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoCompra)) {

                        $contador = 0;

                        foreach ($asiento_detalle_reparable as $asiento_detalle_compra_item) {
                            if (((int)$asiento_detalle_compra_item['COD_ESTADO']) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoCompra,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $asiento_detalle_compra_item['COD_ESTADO'],
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'],
                                    'codOrdenRef' => $asiento_detalle_compra_item['COD_ORDEN_REF'],
                                    'indProducto' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'] !== '' ? 1 : 0,
                                    'codProducto' => $asiento_detalle_compra_item['COD_PRODUCTO'],
                                    'txtNombreProducto' => $asiento_detalle_compra_item['TXT_NOMBRE_PRODUCTO'],
                                    'codLote' => $asiento_detalle_compra_item['COD_LOTE'],
                                    'nroLineaProducto' => $asiento_detalle_compra_item['NRO_LINEA_PRODUCTO'],
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoCompra, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoCompra);
                        $this->calcular_totales_compras($codAsientoCompra);
                    }
                }

                DB::commit();
                return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' REPARABLE CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        } else {

            $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $ordencompra_t = CMPOrden::where('COD_ORDEN', '=', $idoc)->first();

            $codigo_sunat = 'I';
            if ($ordencompra_t->IND_VARIAS_ENTREGAS == 0) {
                $codigo_sunat = 'N';
            }

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();
            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);

            return View::make('comprobante/observarcontabilidad',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionAgregarObservacionContabilidadContrato($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Observar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivoob'];


                if ($fedocumento->ind_observacion == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }


                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('agregar-observacion-contabilidad-contrato/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                foreach ($archivoob as $index => $item) {

                    $docu_asoci = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                        ->where('COD_CATEGORIA_DOCUMENTO', '=', $item)->first();
                    if (count($docu_asoci) > 0) {

                        Archivo::where('ID_DOCUMENTO', '=', $idoc)
                            ->where('ACTIVO', '=', '1')
                            ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                            ->where('TIPO_ARCHIVO', '=', $item)
                            ->update(
                                [
                                    'ACTIVO' => 0,
                                    'EXTENSION' => 'OBS',
                                    'FECHA_MOD' => $this->fechaactual,
                                    'USUARIO_MOD' => Session::get('usuario')->id
                                ]
                            );

                    } else {

                        $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                        $docasociar = new CMPDocAsociarCompra;
                        $docasociar->COD_ORDEN = $idoc;
                        $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                        $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                        $docasociar->IND_OBLIGATORIO = 0;
                        $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                        $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                        $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                        $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                        $docasociar->COD_ESTADO = 1;
                        $docasociar->TIP_DOC = 'O';
                        $docasociar->save();

                    }


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR CONTABILIDAD';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'OBSERVADO POR CONTABILIDAD');
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ind_observacion' => 1,
                            'TXT_OBSERVADO' => 'OBSERVADO',
                            'area_observacion' => 'CONT'
                        ]
                    );


                DB::commit();
                Session::flash('operacion_id', 'CONTRATO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' OBSERVADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'CONTRATO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $codigo_sunat = 'N';

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);

            return View::make('comprobante/observarcontabilidadcontrato',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionAgregarObservacionContabilidadNotaCredito($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_nota_credito_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_producto_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Observar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivoob'];


                if ($fedocumento->ind_observacion == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }


                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('agregar-observacion-contabilidad-contrato/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                foreach ($archivoob as $index => $item) {

                    $docu_asoci = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                        ->where('COD_CATEGORIA_DOCUMENTO', '=', $item)->first();
                    if (count($docu_asoci) > 0) {

                        Archivo::where('ID_DOCUMENTO', '=', $idoc)
                            ->where('ACTIVO', '=', '1')
                            ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                            ->where('TIPO_ARCHIVO', '=', $item)
                            ->update(
                                [
                                    'ACTIVO' => 0,
                                    'EXTENSION' => 'OBS',
                                    'FECHA_MOD' => $this->fechaactual,
                                    'USUARIO_MOD' => Session::get('usuario')->id
                                ]
                            );

                    } else {

                        $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                        $docasociar = new CMPDocAsociarCompra;
                        $docasociar->COD_ORDEN = $idoc;
                        $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                        $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                        $docasociar->IND_OBLIGATORIO = 0;
                        $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                        $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                        $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                        $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                        $docasociar->COD_ESTADO = 1;
                        $docasociar->TIP_DOC = 'O';
                        $docasociar->save();

                    }


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR CONTABILIDAD';
                $documento->MENSAJE = $descripcion;
                $documento->save();
                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'OBSERVADO POR CONTABILIDAD');
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ind_observacion' => 1,
                            'TXT_OBSERVADO' => 'OBSERVADO',
                            'area_observacion' => 'CONT'
                        ]
                    );

                DB::commit();
                Session::flash('operacion_id', 'NOTA_CREDITO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' OBSERVADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'NOTA_CREDITO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_producto_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $codigo_sunat = 'N';

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);

            return View::make('comprobante/observarcontabilidadcontrato',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionAgregarObservacionContabilidadNotaDebito($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_nota_debito_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_producto_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Observar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivoob'];


                if ($fedocumento->ind_observacion == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }


                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('agregar-observacion-contabilidad-contrato/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                foreach ($archivoob as $index => $item) {

                    $docu_asoci = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                        ->where('COD_CATEGORIA_DOCUMENTO', '=', $item)->first();
                    if (count($docu_asoci) > 0) {

                        Archivo::where('ID_DOCUMENTO', '=', $idoc)
                            ->where('ACTIVO', '=', '1')
                            ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                            ->where('TIPO_ARCHIVO', '=', $item)
                            ->update(
                                [
                                    'ACTIVO' => 0,
                                    'EXTENSION' => 'OBS',
                                    'FECHA_MOD' => $this->fechaactual,
                                    'USUARIO_MOD' => Session::get('usuario')->id
                                ]
                            );

                    } else {

                        $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                        $docasociar = new CMPDocAsociarCompra;
                        $docasociar->COD_ORDEN = $idoc;
                        $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                        $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                        $docasociar->IND_OBLIGATORIO = 0;
                        $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                        $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                        $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                        $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                        $docasociar->COD_ESTADO = 1;
                        $docasociar->TIP_DOC = 'O';
                        $docasociar->save();

                    }


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR CONTABILIDAD';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'OBSERVADO POR CONTABILIDAD');
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ind_observacion' => 1,
                            'TXT_OBSERVADO' => 'OBSERVADO',
                            'area_observacion' => 'CONT'
                        ]
                    );

                DB::commit();
                Session::flash('operacion_id', 'NOTA_DEBITO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' OBSERVADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'NOTA_DEBITO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_producto_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $codigo_sunat = 'N';

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);

            return View::make('comprobante/observarcontabilidadcontrato',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }


    public function actionAgregarObservacionContabilidadPG($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/

        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_pg_idoc($idoc);
        $detalleordencompra = $this->con_lista_detalle_pg_comprobante_idoc($idoc);

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Observar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivoob'];


                if ($fedocumento->ind_observacion == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }


                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-contabilidad-pg/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                foreach ($archivoob as $index => $item) {

                    $docu_asoci = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                        ->where('COD_CATEGORIA_DOCUMENTO', '=', $item)->first();
                    if (count($docu_asoci) > 0) {

                        Archivo::where('ID_DOCUMENTO', '=', $idoc)
                            ->where('ACTIVO', '=', '1')
                            ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                            ->where('TIPO_ARCHIVO', '=', $item)
                            ->update(
                                [
                                    'ACTIVO' => 0,
                                    'EXTENSION' => 'OBS',
                                    'FECHA_MOD' => $this->fechaactual,
                                    'USUARIO_MOD' => Session::get('usuario')->id
                                ]
                            );

                    } else {

                        $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                        $docasociar = new CMPDocAsociarCompra;
                        $docasociar->COD_ORDEN = $idoc;
                        $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                        $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                        $docasociar->IND_OBLIGATORIO = 0;
                        $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                        $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                        $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                        $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                        $docasociar->COD_ESTADO = 1;
                        $docasociar->TIP_DOC = 'O';
                        $docasociar->save();

                    }


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR CONTABILIDAD';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'OBSERVADO POR CONTABILIDAD');
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ind_observacion' => 1,
                            'TXT_OBSERVADO' => 'OBSERVADO',
                            'area_observacion' => 'CONT'
                        ]
                    );

                DB::commit();
                Session::flash('operacion_id', 'PROVISION_GASTO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' OBSERVADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'PROVISION_GASTO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        }


    }


    public function actionAgregarObservacionContabilidadEstiba($idopcion, $lote, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $lote;
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->get();
        View::share('titulo', 'Observar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivoob'];
                $operacion_id = $request['operacion_id'];


                if ($fedocumento->ind_observacion == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }

                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('agregar-observacion-contabilidad-estiba/' . $idopcion . '/' . $lote)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                foreach ($archivoob as $index => $item) {
                    $docu_asoci = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                        ->where('COD_CATEGORIA_DOCUMENTO', '=', $item)->first();
                    if (count($docu_asoci) > 0) {

                        Archivo::where('ID_DOCUMENTO', '=', $idoc)
                            ->where('ACTIVO', '=', '1')
                            ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                            ->where('TIPO_ARCHIVO', '=', $item)
                            ->update(
                                [
                                    'ACTIVO' => 0,
                                    'EXTENSION' => 'OBS',
                                    'FECHA_MOD' => $this->fechaactual,
                                    'USUARIO_MOD' => Session::get('usuario')->id
                                ]
                            );

                    } else {

                        $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                        $docasociar = new CMPDocAsociarCompra;
                        $docasociar->COD_ORDEN = $idoc;
                        $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                        $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                        $docasociar->IND_OBLIGATORIO = 0;
                        $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                        $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                        $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                        $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                        $docasociar->COD_ESTADO = 1;
                        $docasociar->TIP_DOC = 'O';
                        $docasociar->save();

                    }
                }
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR CONTABILIDAD';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'OBSERVADO POR CONTABILIDAD');
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO', $idoc)
                    ->update(
                        [
                            'ind_observacion' => 1,
                            'TXT_OBSERVADO' => 'OBSERVADO',
                            'area_observacion' => 'CONT'
                        ]
                    );

                DB::commit();
                Session::flash('operacion_id', $request['operacion_id']);
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $lote . ' OBSERVADO CON EXITO');


            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', $request['operacion_id']);

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $codigo_sunat = 'N';

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);

            return View::make('comprobante/observarcontabilidadcontrato',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,
                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionAgregarReparableContabilidadEstibaDIC($idopcion, $lote, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $lote;
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->get();
        View::share('titulo', 'Reparar Comprobante');

        if ($_POST) {

            $asiento_cabecera_reparable = json_decode($request['asiento_cabecera_reparable'], true);
            $asiento_detalle_reparable = json_decode($request['asiento_detalle_reparable'], true);

            $anio_asiento = $request->input('anio_asiento_reparable');
            $periodo_asiento = $request->input('periodo_asiento_reparable');
            $moneda_asiento = $request->input('moneda_asiento_reparable');
            $tipo_cambio_asiento = $request->input('tipo_cambio_asiento_reparable');
            $empresa_asiento = $request->input('empresa_asiento_reparable');
            $fecha_asiento = $request->input('fecha_asiento_reparable');
            $tipo_documento_asiento = $request->input('tipo_documento_asiento_reparable');
            $serie_asiento = $request->input('serie_asiento_reparable');
            $numero_asiento = $request->input('numero_asiento_reparable');
            $tipo_documento_ref = $request->input('tipo_documento_ref_reparable');
            $serie_ref_asiento = $request->input('serie_ref_asiento_reparable');
            $numero_ref_asiento = $request->input('numero_ref_asiento_reparable');
            $glosa_asiento = $request->input('glosa_asiento_reparable');

            $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();
            $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();

            if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
            }

            $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $empresa_asiento)->first();
            $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_ref)->first();

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivore'];
                $reparable = $request['reparable'];

                if ($fedocumento->IND_REPARABLE == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento ya esta reparado no se puede reparar');
                }

                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $lote)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                foreach ($archivoob as $index => $item) {
                    //dd($item);
                    $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                    $docasociar = new CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN = $idoc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                    $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                    $docasociar->IND_OBLIGATORIO = 0;
                    $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                    $docasociar->TXT_ASIGNADO = $reparable;
                    $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                    $docasociar->COD_ESTADO = 1;
                    $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
                    $docasociar->save();
                }
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO ' . $reparable;
                $documento->MENSAJE = $descripcion;
                $documento->save();
                FeDocumento::where('ID_DOCUMENTO', $idoc)
                    ->update(
                        [
                            'IND_REPARABLE' => 1,
                            'MODO_REPARABLE' => $reparable,
                            'TXT_REPARABLE' => 'REPARABLE'
                        ]
                    );

                //GENERACION ASIENTOS
                if (count($asiento_cabecera_reparable) > 0 and count($asiento_detalle_reparable) > 0) {
                    $cod_tipo_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoCompra = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $glosa_asiento,
                        $cod_estado_asiento,
                        $des_estado_asiento,
                        $moneda_asiento_aux->COD_CATEGORIA,
                        $moneda_asiento_aux->NOM_CATEGORIA,
                        $tipo_cambio_asiento,
                        0.0000,
                        0.0000,
                        '',
                        '',
                        0,
                        $asiento_cabecera_reparable[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_reparable[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_reparable[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                        $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                        $serie_asiento,
                        $numero_asiento,
                        $this->fechaactual,
                        '',
                        0.0000,
                        0.0000,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoCompra)) {

                        $contador = 0;

                        foreach ($asiento_detalle_reparable as $asiento_detalle_compra_item) {
                            if (((int)$asiento_detalle_compra_item['COD_ESTADO']) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoCompra,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $asiento_detalle_compra_item['COD_ESTADO'],
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'],
                                    'codOrdenRef' => $asiento_detalle_compra_item['COD_ORDEN_REF'],
                                    'indProducto' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'] !== '' ? 1 : 0,
                                    'codProducto' => $asiento_detalle_compra_item['COD_PRODUCTO'],
                                    'txtNombreProducto' => $asiento_detalle_compra_item['TXT_NOMBRE_PRODUCTO'],
                                    'codLote' => $asiento_detalle_compra_item['COD_LOTE'],
                                    'nroLineaProducto' => $asiento_detalle_compra_item['NRO_LINEA_PRODUCTO'],
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoCompra, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoCompra);
                        $this->calcular_totales_compras($codAsientoCompra);
                    }
                }

                DB::commit();
                Session::flash('operacion_id', 'DOCUMENTO_INTERNO_COMPRA');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $idoc . ' REPARABLE CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'DOCUMENTO_INTERNO_COMPRA');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $codigo_sunat = 'N';

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);

            return View::make('comprobante/reparablecontabilidadcontrato',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }


    public function actionAgregarReparableContabilidadEstiba($idopcion, $lote, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $lote;
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->get();
        View::share('titulo', 'Reparar Comprobante');

        if ($_POST) {

            $asiento_cabecera_reparable = json_decode($request['asiento_cabecera_reparable'], true);
            $asiento_detalle_reparable = json_decode($request['asiento_detalle_reparable'], true);

            $anio_asiento = $request->input('anio_asiento_reparable');
            $periodo_asiento = $request->input('periodo_asiento_reparable');
            $moneda_asiento = $request->input('moneda_asiento_reparable');
            $tipo_cambio_asiento = $request->input('tipo_cambio_asiento_reparable');
            $empresa_asiento = $request->input('empresa_asiento_reparable');
            $fecha_asiento = $request->input('fecha_asiento_reparable');
            $tipo_documento_asiento = $request->input('tipo_documento_asiento_reparable');
            $serie_asiento = $request->input('serie_asiento_reparable');
            $numero_asiento = $request->input('numero_asiento_reparable');
            $tipo_documento_ref = $request->input('tipo_documento_ref_reparable');
            $serie_ref_asiento = $request->input('serie_ref_asiento_reparable');
            $numero_ref_asiento = $request->input('numero_ref_asiento_reparable');
            $glosa_asiento = $request->input('glosa_asiento_reparable');

            $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();
            $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();

            if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
            }

            $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $empresa_asiento)->first();
//            $tipo_doc_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_asiento)->first();
//            $tipo_doc_ref_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_ref)->first();
            $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_ref)->first();

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivore'];
                $reparable = $request['reparable'];
                $archivofi = $request['archivofi'];

                if ($fedocumento->IND_REPARABLE == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento ya esta reparado no se puede reparar');
                }

                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $lote)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                $modohibrido = '';
                $reparable_ori = $reparable;
                if ($reparable == 'ARCHIVO_VIRTUAL_FISICO') {
                    $reparable = 'ARCHIVO_VIRTUAL';
                }

                foreach ($archivoob as $index => $item) {
                    $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                    $tipo_doc = $categoria->CODIGO_SUNAT;
                    if ($reparable_ori == 'ARCHIVO_VIRTUAL_FISICO') {
                        $tipo_doc = 'F';
                        $modohibrido = 'ARCHIVO_FISICO';
                    }

                    $docasociar = new CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN = $idoc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                    $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                    $docasociar->IND_OBLIGATORIO = 0;
                    $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                    $docasociar->TXT_ASIGNADO = $reparable;
                    $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                    $docasociar->COD_ESTADO = 1;
                    $docasociar->TIP_DOC = $tipo_doc;
                    $docasociar->save();
                }


                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO ' . $reparable;
                $documento->MENSAJE = $descripcion;
                $documento->save();


                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO ' . $reparable);
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO', $idoc)
                    ->update(
                        [
                            'IND_REPARABLE' => 1,
                            'MODO_REPARABLE' => $reparable,
                            'TXT_REPARABLE' => 'REPARABLE',
                            'MODO_REPARABLE_HIBRIDO' => $modohibrido
                        ]
                    );


                //GENERACION ASIENTOS
                if (count($asiento_cabecera_reparable) > 0 and count($asiento_detalle_reparable) > 0) {
//                DD($asiento_cabecera_compra[0]['COD_CATEGORIA_TIPO_ASIENTO']);
                    $cod_tipo_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoCompra = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $glosa_asiento,
                        $cod_estado_asiento,
                        $des_estado_asiento,
                        $moneda_asiento_aux->COD_CATEGORIA,
                        $moneda_asiento_aux->NOM_CATEGORIA,
                        $tipo_cambio_asiento,
                        0.0000,
                        0.0000,
                        '',
                        '',
                        0,
                        $asiento_cabecera_reparable[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_reparable[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_reparable[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                        $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                        $serie_asiento,
                        $numero_asiento,
                        $this->fechaactual,
                        '',
                        0.0000,
                        0.0000,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoCompra)) {

                        $contador = 0;

                        foreach ($asiento_detalle_reparable as $asiento_detalle_compra_item) {
                            if (((int)$asiento_detalle_compra_item['COD_ESTADO']) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoCompra,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $asiento_detalle_compra_item['COD_ESTADO'],
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'],
                                    'codOrdenRef' => $asiento_detalle_compra_item['COD_ORDEN_REF'],
                                    'indProducto' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'] !== '' ? 1 : 0,
                                    'codProducto' => $asiento_detalle_compra_item['COD_PRODUCTO'],
                                    'txtNombreProducto' => $asiento_detalle_compra_item['TXT_NOMBRE_PRODUCTO'],
                                    'codLote' => $asiento_detalle_compra_item['COD_LOTE'],
                                    'nroLineaProducto' => $asiento_detalle_compra_item['NRO_LINEA_PRODUCTO'],
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoCompra, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoCompra);
                        $this->calcular_totales_compras($codAsientoCompra);
                    }
                }

                DB::commit();
                Session::flash('operacion_id', 'ESTIBA');
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $idoc . ' REPARABLE CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'CONTRATO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $codigo_sunat = 'N';

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);

            return View::make('comprobante/reparablecontabilidadcontrato',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionAgregarReparableContabilidadContrato($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Observar Comprobante');

        if ($_POST) {

            $asiento_cabecera_reparable = json_decode($request['asiento_cabecera_reparable'], true);
            $asiento_detalle_reparable = json_decode($request['asiento_detalle_reparable'], true);

            $anio_asiento = $request->input('anio_asiento_reparable');
            $periodo_asiento = $request->input('periodo_asiento_reparable');
            $moneda_asiento = $request->input('moneda_asiento_reparable');
            $tipo_cambio_asiento = $request->input('tipo_cambio_asiento_reparable');
            $empresa_asiento = $request->input('empresa_asiento_reparable');
            $fecha_asiento = $request->input('fecha_asiento_reparable');
            $tipo_documento_asiento = $request->input('tipo_documento_asiento_reparable');
            $serie_asiento = $request->input('serie_asiento_reparable');
            $numero_asiento = $request->input('numero_asiento_reparable');
            $tipo_documento_ref = $request->input('tipo_documento_ref_reparable');
            $serie_ref_asiento = $request->input('serie_ref_asiento_reparable');
            $numero_ref_asiento = $request->input('numero_ref_asiento_reparable');
            $glosa_asiento = $request->input('glosa_asiento_reparable');

            $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();
            $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();

            if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
            }

            $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $empresa_asiento)->first();
            $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_ref)->first();

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivore'];
                $reparable = $request['reparable'];
                $archivofi = $request['archivofi'];


                if ($fedocumento->IND_REPARABLE == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento ya esta reparado no se puede reparar');
                }

                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                $modohibrido = '';
                $reparable_ori = $reparable;
                if ($reparable == 'ARCHIVO_VIRTUAL_FISICO') {
                    $reparable = 'ARCHIVO_VIRTUAL';
                }

                foreach ($archivoob as $index => $item) {
                    $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                    $tipo_doc = $categoria->CODIGO_SUNAT;
                    if ($reparable_ori == 'ARCHIVO_VIRTUAL_FISICO') {
                        $tipo_doc = 'F';
                        $modohibrido = 'ARCHIVO_FISICO';
                    }

                    $docasociar = new CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN = $idoc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                    $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                    $docasociar->IND_OBLIGATORIO = 0;
                    $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                    $docasociar->TXT_ASIGNADO = $reparable;
                    $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                    $docasociar->COD_ESTADO = 1;
                    $docasociar->TIP_DOC = $tipo_doc;
                    $docasociar->save();
                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO ' . $reparable;
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO ' . $reparable);

                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'IND_REPARABLE' => 1,
                            'MODO_REPARABLE' => $reparable,
                            'TXT_REPARABLE' => 'REPARABLE',
                            'MODO_REPARABLE_HIBRIDO' => $modohibrido
                        ]
                    );


                //GENERACION ASIENTOS
                if (count($asiento_cabecera_reparable) > 0 and count($asiento_detalle_reparable) > 0) {

                    $cod_tipo_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoCompra = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $glosa_asiento,
                        $cod_estado_asiento,
                        $des_estado_asiento,
                        $moneda_asiento_aux->COD_CATEGORIA,
                        $moneda_asiento_aux->NOM_CATEGORIA,
                        $tipo_cambio_asiento,
                        0.0000,
                        0.0000,
                        '',
                        '',
                        0,
                        $asiento_cabecera_reparable[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_reparable[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_reparable[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                        $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                        $serie_asiento,
                        $numero_asiento,
                        $this->fechaactual,
                        '',
                        0.0000,
                        0.0000,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoCompra)) {

                        $contador = 0;

                        foreach ($asiento_detalle_reparable as $asiento_detalle_compra_item) {
                            if (((int)$asiento_detalle_compra_item['COD_ESTADO']) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoCompra,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $asiento_detalle_compra_item['COD_ESTADO'],
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'],
                                    'codOrdenRef' => $asiento_detalle_compra_item['COD_ORDEN_REF'],
                                    'indProducto' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'] !== '' ? 1 : 0,
                                    'codProducto' => $asiento_detalle_compra_item['COD_PRODUCTO'],
                                    'txtNombreProducto' => $asiento_detalle_compra_item['TXT_NOMBRE_PRODUCTO'],
                                    'codLote' => $asiento_detalle_compra_item['COD_LOTE'],
                                    'nroLineaProducto' => $asiento_detalle_compra_item['NRO_LINEA_PRODUCTO'],
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoCompra, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoCompra);
                        $this->calcular_totales_compras($codAsientoCompra);
                    }
                }

                DB::commit();
                Session::flash('operacion_id', 'CONTRATO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' REPARABLE CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'CONTRATO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $codigo_sunat = 'N';

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->where('CODIGO_SUNAT', '=', $codigo_sunat)
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            return View::make('comprobante/reparablecontabilidadcontrato',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }


    public function actionAgregarReparableContabilidadPg($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Reparable Comprobante');

        if ($_POST) {

            $asiento_cabecera_reparable = json_decode($request['asiento_cabecera_reparable'], true);
            $asiento_detalle_reparable = json_decode($request['asiento_detalle_reparable'], true);

            $anio_asiento = $request->input('anio_asiento_reparable');
            $periodo_asiento = $request->input('periodo_asiento_reparable');
            $moneda_asiento = $request->input('moneda_asiento_reparable');
            $tipo_cambio_asiento = $request->input('tipo_cambio_asiento_reparable');
            $empresa_asiento = $request->input('empresa_asiento_reparable');
            $fecha_asiento = $request->input('fecha_asiento_reparable');
            $tipo_documento_asiento = $request->input('tipo_documento_asiento_reparable');
            $serie_asiento = $request->input('serie_asiento_reparable');
            $numero_asiento = $request->input('numero_asiento_reparable');
            $tipo_documento_ref = $request->input('tipo_documento_ref_reparable');
            $serie_ref_asiento = $request->input('serie_ref_asiento_reparable');
            $numero_ref_asiento = $request->input('numero_ref_asiento_reparable');
            $glosa_asiento = $request->input('glosa_asiento_reparable');

            $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();
            $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();

            if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
            }

            $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $empresa_asiento)->first();
            $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_ref)->first();

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivore'];
                $reparable = $request['reparable'];
                $archivofi = $request['archivofi'];


                if ($fedocumento->IND_REPARABLE == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento ya esta reparado no se puede reparar');
                }

                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                $modohibrido = '';
                $reparable_ori = $reparable;
                if ($reparable == 'ARCHIVO_VIRTUAL_FISICO') {
                    $reparable = 'ARCHIVO_VIRTUAL';
                }

                foreach ($archivoob as $index => $item) {
                    $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                    $tipo_doc = $categoria->CODIGO_SUNAT;
                    if ($reparable_ori == 'ARCHIVO_VIRTUAL_FISICO') {
                        $tipo_doc = 'F';
                        $modohibrido = 'ARCHIVO_FISICO';
                    }

                    $docasociar = new CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN = $idoc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                    $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                    $docasociar->IND_OBLIGATORIO = 0;
                    $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                    $docasociar->TXT_ASIGNADO = $reparable;
                    $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                    $docasociar->COD_ESTADO = 1;
                    $docasociar->TIP_DOC = $tipo_doc;
                    $docasociar->save();
                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO ' . $reparable;
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO ' . $reparable);

                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'IND_REPARABLE' => 1,
                            'MODO_REPARABLE' => $reparable,
                            'TXT_REPARABLE' => 'REPARABLE',
                            'MODO_REPARABLE_HIBRIDO' => $modohibrido
                        ]
                    );

                //GENERACION ASIENTOS
                if (count($asiento_cabecera_reparable) > 0 and count($asiento_detalle_reparable) > 0) {
                    $cod_tipo_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoCompra = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $glosa_asiento,
                        $cod_estado_asiento,
                        $des_estado_asiento,
                        $moneda_asiento_aux->COD_CATEGORIA,
                        $moneda_asiento_aux->NOM_CATEGORIA,
                        $tipo_cambio_asiento,
                        0.0000,
                        0.0000,
                        '',
                        '',
                        0,
                        $asiento_cabecera_reparable[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_reparable[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_reparable[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                        $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                        $serie_asiento,
                        $numero_asiento,
                        $this->fechaactual,
                        '',
                        0.0000,
                        0.0000,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoCompra)) {

                        $contador = 0;

                        foreach ($asiento_detalle_reparable as $asiento_detalle_compra_item) {
                            if (((int)$asiento_detalle_compra_item['COD_ESTADO']) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoCompra,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $asiento_detalle_compra_item['COD_ESTADO'],
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'],
                                    'codOrdenRef' => $asiento_detalle_compra_item['COD_ORDEN_REF'],
                                    'indProducto' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'] !== '' ? 1 : 0,
                                    'codProducto' => $asiento_detalle_compra_item['COD_PRODUCTO'],
                                    'txtNombreProducto' => $asiento_detalle_compra_item['TXT_NOMBRE_PRODUCTO'],
                                    'codLote' => $asiento_detalle_compra_item['COD_LOTE'],
                                    'nroLineaProducto' => $asiento_detalle_compra_item['NRO_LINEA_PRODUCTO'],
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoCompra, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoCompra);
                        $this->calcular_totales_compras($codAsientoCompra);
                    }
                }

                DB::commit();
                Session::flash('operacion_id', 'PROVISION_GASTO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $fedocumento->ID_DOCUMENTO . ' REPARABLE CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'PROVISION_GASTO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        }
    }

    public function actionAgregarReparableContabilidadNC($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Reparable Comprobante');

        if ($_POST) {

            $asiento_cabecera_reparable = json_decode($request['asiento_cabecera_reparable'], true);
            $asiento_detalle_reparable = json_decode($request['asiento_detalle_reparable'], true);

            $anio_asiento = $request->input('anio_asiento_reparable');
            $periodo_asiento = $request->input('periodo_asiento_reparable');
            $moneda_asiento = $request->input('moneda_asiento_reparable');
            $tipo_cambio_asiento = $request->input('tipo_cambio_asiento_reparable');
            $empresa_asiento = $request->input('empresa_asiento_reparable');
            $fecha_asiento = $request->input('fecha_asiento_reparable');
            $tipo_documento_asiento = $request->input('tipo_documento_asiento_reparable');
            $serie_asiento = $request->input('serie_asiento_reparable');
            $numero_asiento = $request->input('numero_asiento_reparable');
            $tipo_documento_ref = $request->input('tipo_documento_ref_reparable');
            $serie_ref_asiento = $request->input('serie_ref_asiento_reparable');
            $numero_ref_asiento = $request->input('numero_ref_asiento_reparable');
            $glosa_asiento = $request->input('glosa_asiento_reparable');

            $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();
            $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();

            if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
            }

            $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $empresa_asiento)->first();
            $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_ref)->first();

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivore'];
                $reparable = $request['reparable'];
                $archivofi = $request['archivofi'];


                if ($fedocumento->IND_REPARABLE == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento ya esta reparado no se puede reparar');
                }

                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                $modohibrido = '';
                $reparable_ori = $reparable;
                if ($reparable == 'ARCHIVO_VIRTUAL_FISICO') {
                    $reparable = 'ARCHIVO_VIRTUAL';
                }

                foreach ($archivoob as $index => $item) {
                    $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                    $tipo_doc = $categoria->CODIGO_SUNAT;
                    if ($reparable_ori == 'ARCHIVO_VIRTUAL_FISICO') {
                        $tipo_doc = 'F';
                        $modohibrido = 'ARCHIVO_FISICO';
                    }

                    $docasociar = new CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN = $idoc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                    $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                    $docasociar->IND_OBLIGATORIO = 0;
                    $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                    $docasociar->TXT_ASIGNADO = $reparable;
                    $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                    $docasociar->COD_ESTADO = 1;
                    $docasociar->TIP_DOC = $tipo_doc;
                    $docasociar->save();
                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO ' . $reparable;
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO ' . $reparable);

                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'IND_REPARABLE' => 1,
                            'MODO_REPARABLE' => $reparable,
                            'TXT_REPARABLE' => 'REPARABLE',
                            'MODO_REPARABLE_HIBRIDO' => $modohibrido
                        ]
                    );

                //GENERACION ASIENTOS
                if (count($asiento_cabecera_reparable) > 0 and count($asiento_detalle_reparable) > 0) {
                    $cod_tipo_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoCompra = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $glosa_asiento,
                        $cod_estado_asiento,
                        $des_estado_asiento,
                        $moneda_asiento_aux->COD_CATEGORIA,
                        $moneda_asiento_aux->NOM_CATEGORIA,
                        $tipo_cambio_asiento,
                        0.0000,
                        0.0000,
                        '',
                        '',
                        0,
                        $asiento_cabecera_reparable[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_reparable[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_reparable[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                        $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                        $serie_asiento,
                        $numero_asiento,
                        $this->fechaactual,
                        '',
                        0.0000,
                        0.0000,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoCompra)) {

                        $contador = 0;

                        foreach ($asiento_detalle_reparable as $asiento_detalle_compra_item) {
                            if (((int)$asiento_detalle_compra_item['COD_ESTADO']) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoCompra,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $asiento_detalle_compra_item['COD_ESTADO'],
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'],
                                    'codOrdenRef' => $asiento_detalle_compra_item['COD_ORDEN_REF'],
                                    'indProducto' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'] !== '' ? 1 : 0,
                                    'codProducto' => $asiento_detalle_compra_item['COD_PRODUCTO'],
                                    'txtNombreProducto' => $asiento_detalle_compra_item['TXT_NOMBRE_PRODUCTO'],
                                    'codLote' => $asiento_detalle_compra_item['COD_LOTE'],
                                    'nroLineaProducto' => $asiento_detalle_compra_item['NRO_LINEA_PRODUCTO'],
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoCompra, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoCompra);
                        $this->calcular_totales_compras($codAsientoCompra);
                    }
                }

                DB::commit();
                Session::flash('operacion_id', 'NOTA_CREDITO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $fedocumento->ID_DOCUMENTO . ' REPARABLE CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'NOTA_CREDITO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        }
    }

    public function actionAgregarReparableContabilidadND($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Reparable Comprobante');

        if ($_POST) {

            $asiento_cabecera_reparable = json_decode($request['asiento_cabecera_reparable'], true);
            $asiento_detalle_reparable = json_decode($request['asiento_detalle_reparable'], true);

            $anio_asiento = $request->input('anio_asiento_reparable');
            $periodo_asiento = $request->input('periodo_asiento_reparable');
            $moneda_asiento = $request->input('moneda_asiento_reparable');
            $tipo_cambio_asiento = $request->input('tipo_cambio_asiento_reparable');
            $empresa_asiento = $request->input('empresa_asiento_reparable');
            $fecha_asiento = $request->input('fecha_asiento_reparable');
            $tipo_documento_asiento = $request->input('tipo_documento_asiento_reparable');
            $serie_asiento = $request->input('serie_asiento_reparable');
            $numero_asiento = $request->input('numero_asiento_reparable');
            $tipo_documento_ref = $request->input('tipo_documento_ref_reparable');
            $serie_ref_asiento = $request->input('serie_ref_asiento_reparable');
            $numero_ref_asiento = $request->input('numero_ref_asiento_reparable');
            $glosa_asiento = $request->input('glosa_asiento_reparable');

            $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();
            $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();

            if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
            }

            $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $empresa_asiento)->first();
            $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipo_documento_ref)->first();

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivore'];
                $reparable = $request['reparable'];
                $archivofi = $request['archivofi'];


                if ($fedocumento->IND_REPARABLE == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento ya esta reparado no se puede reparar');
                }

                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }


                $modohibrido = '';
                $reparable_ori = $reparable;
                if ($reparable == 'ARCHIVO_VIRTUAL_FISICO') {
                    $reparable = 'ARCHIVO_VIRTUAL';
                }

                foreach ($archivoob as $index => $item) {
                    $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item)->first();
                    $tipo_doc = $categoria->CODIGO_SUNAT;
                    if ($reparable_ori == 'ARCHIVO_VIRTUAL_FISICO') {
                        $tipo_doc = 'F';
                        $modohibrido = 'ARCHIVO_FISICO';
                    }

                    $docasociar = new CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN = $idoc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                    $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                    $docasociar->IND_OBLIGATORIO = 0;
                    $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                    $docasociar->TXT_ASIGNADO = $reparable;
                    $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                    $docasociar->COD_ESTADO = 1;
                    $docasociar->TIP_DOC = $tipo_doc;
                    $docasociar->save();
                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO ' . $reparable;
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'DOCUMENTO ' . $reparable);

                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'IND_REPARABLE' => 1,
                            'MODO_REPARABLE' => $reparable,
                            'TXT_REPARABLE' => 'REPARABLE',
                            'MODO_REPARABLE_HIBRIDO' => $modohibrido
                        ]
                    );

                //GENERACION ASIENTOS
                if (count($asiento_cabecera_reparable) > 0 and count($asiento_detalle_reparable) > 0) {
                    $cod_tipo_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_reparable[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_reparable[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoCompra = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $glosa_asiento,
                        $cod_estado_asiento,
                        $des_estado_asiento,
                        $moneda_asiento_aux->COD_CATEGORIA,
                        $moneda_asiento_aux->NOM_CATEGORIA,
                        $tipo_cambio_asiento,
                        0.0000,
                        0.0000,
                        '',
                        '',
                        0,
                        $asiento_cabecera_reparable[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_reparable[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_reparable[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                        $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                        $serie_asiento,
                        $numero_asiento,
                        $this->fechaactual,
                        '',
                        0.0000,
                        0.0000,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoCompra)) {

                        $contador = 0;

                        foreach ($asiento_detalle_reparable as $asiento_detalle_compra_item) {
                            if (((int)$asiento_detalle_compra_item['COD_ESTADO']) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoCompra,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $asiento_detalle_compra_item['COD_ESTADO'],
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'],
                                    'codOrdenRef' => $asiento_detalle_compra_item['COD_ORDEN_REF'],
                                    'indProducto' => $asiento_detalle_compra_item['COD_DOC_CTBLE_REF'] !== '' ? 1 : 0,
                                    'codProducto' => $asiento_detalle_compra_item['COD_PRODUCTO'],
                                    'txtNombreProducto' => $asiento_detalle_compra_item['TXT_NOMBRE_PRODUCTO'],
                                    'codLote' => $asiento_detalle_compra_item['COD_LOTE'],
                                    'nroLineaProducto' => $asiento_detalle_compra_item['NRO_LINEA_PRODUCTO'],
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoCompra, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoCompra);
                        $this->calcular_totales_compras($codAsientoCompra);
                    }
                }

                DB::commit();
                Session::flash('operacion_id', 'NOTA_DEBITO');

                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $fedocumento->ID_DOCUMENTO . ' REPARABLE CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'NOTA_DEBITO');

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        }
    }

    public function actionAgregarRecomendacionContabilidad($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Recomendar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();


                $descripcion = $request['descripcion'];

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'RECOMENDACION POR CONTABILIDAD');
                //geolocalización


                DB::commit();
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' RECOMENDACION CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if ($fedocumento->ind_observacion == 1) {

                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);

            return View::make('comprobante/recomendacioncontabilidad',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }

    public function actionAgregarRecomendacionContabilidadContrato($idopcion, $linea, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $this->funciones->decodificarmaestraprefijo_contrato($idordencompra, $prefijo);
        $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_contrato_comprobante_idoc($idoc);

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Recomendar Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'RECOMENDACION POR CONTABILIDAD';
                $documento->MENSAJE = $descripcion;
                $documento->save();


                //geolocalizacion
                $device_info = $request['device_info'];
                $this->con_datos_de_la_pc($device_info, $fedocumento, 'RECOMENDACION POR CONTABILIDAD');
                //geolocalización


                DB::commit();

                //Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('/aprobar-comprobante-contabilidad-contrato/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' RECOMENDACION CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                //Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('aprobar-comprobante-contabilidad-contrato/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {

            $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                //->where('IND_OBLIGATORIO','=',1)
                ->where('TXT_ASIGNADO', '=', 'CONTACTO')
                ->get();


            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();


            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $documentoscompra = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->where('COD_ESTADO', '=', 1)
                ->get();

            $totalarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                ->pluck('COD_CATEGORIA_DOCUMENTO')
                ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);

            return View::make('comprobante/recomendacioncontabilidadcontrato',
                [
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'linea' => $linea,
                    'documentoscompra' => $documentoscompra,
                    'detalleordencompra' => $detalleordencompra,
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'totalarchivos' => $totalarchivos,
                    'trabajador' => $trabajador,

                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
                ]);


        }
    }


    public function actionRegistrarActivoFijoCategoria($idoc, $COD_PRODUCTO, Request $request)
    {
        $COD_CAT_ACTFIJO = $request['COD_CATEGORIA_AF'];
        $COD_PRODUCTO = $request['COD_PRODUCTO'];
        $COD_TABLA = $request['COD_TABLA'];
        $NRO_LINEA = $request['NRO_LINEA'];
        $COD_LOTE = $request['COD_LOTE'];
        $CAN_PRODUCTO = $request['CAN_PRODUCTO'];
        $TXT_DETALLE_PRODUCTO = $request['TXT_DETALLE_PRODUCTO'];
        $TXT_NOMBRE_PRODUCTO = $request['TXT_NOMBRE_PRODUCTO'];
        $idcheckbox = $request['idcheckbox'];
        $error = false;
        $mensaje = 'REGISTRO CATEGORIA EXITOSO';

        try {

            $oeExiste = CMPDetalleProductoAF::where('COD_TABLA', $COD_TABLA)->where('COD_PRODUCTO', $COD_PRODUCTO)->where('NRO_LINEA', $NRO_LINEA)->first();
            if ($oeExiste) {
                // VALIDAR QUE NO ESTE YA SIENDO PROCESADO O CALCULADO SU DEPRECIACION
                if (1 == 0) {
                    $error = true;
                    $mensaje = 'YA SE ESTA DEPRECIANDO';
                } else {
                    $oeExiste->COD_PRODUCTO = $COD_PRODUCTO;
                    $oeExiste->COD_TABLA = $COD_TABLA;
                    $oeExiste->COD_LOTE = $COD_LOTE;
                    $oeExiste->NRO_LINEA = $NRO_LINEA;
                    $oeExiste->TXT_DETALLE_PRODUCTO = $TXT_DETALLE_PRODUCTO;
                    $oeExiste->TXT_NOMBRE_PRODUCTO = $TXT_NOMBRE_PRODUCTO;
                    $oeExiste->CAN_PRODUCTO = $CAN_PRODUCTO;
                    $oeExiste->COD_CAT_ACTFIJO = $COD_CAT_ACTFIJO;
                    $oeExiste->save();
                }
            } else {
                $oeRegistro = new CMPDetalleProductoAF;
                $oeRegistro->COD_PRODUCTO = $COD_PRODUCTO;
                $oeRegistro->COD_TABLA = $COD_TABLA;
                $oeRegistro->COD_LOTE = $COD_LOTE;
                $oeRegistro->NRO_LINEA = $NRO_LINEA;
                $oeRegistro->TXT_DETALLE_PRODUCTO = $TXT_DETALLE_PRODUCTO;
                $oeRegistro->TXT_NOMBRE_PRODUCTO = $TXT_NOMBRE_PRODUCTO;
                $oeRegistro->CAN_PRODUCTO = $CAN_PRODUCTO;
                $oeRegistro->COD_CAT_ACTFIJO = $COD_CAT_ACTFIJO;
                $oeRegistro->save();
            }
        } catch (\Exception $ex) {
            $error = true;
            $mensaje = 'ocurrio un error inesperado ' . $ex;
        }

        $datos = [
            'error' => $error,
            'mensaje' => $mensaje,
            'idcheckbox' => $idcheckbox
        ];
        // $rpta = json_encode($datos,true);
        return response()->json($datos);

        // return $rpta;

    }


    public function actionAjaxModalActivoFijoCategoria(Request $request)
    {
        // ajax-modal-detalle-deuda-contrato
        $idopcion = $request['idopcion'];
        $COD_PRODUCTO = $request['codprod'];
        $CAN_PRODUCTO = $request['cantprod'];
        $COD_LOTE = $request['codlote'];
        $NRO_LINEA = $request['nrolinea'];
        $TXT_NOMBRE_PRODUCTO = $request['txtnombprod'];
        $TXT_DETALLE_PRODUCTO = $request['txtdetprod'];
        $idoc = $request['idoc'];
        $idcheckbox = $request['idcheckbox'];

        $oeProducto = CMPDetalleProducto::where('COD_PRODUCTO', $COD_PRODUCTO)->where('COD_TABLA', $idoc)->where('COD_LOTE', $COD_LOTE)->where('NRO_LINEA', $NRO_LINEA)->first();
        $combo_categoria_activo_fijo = ['' => 'SELECCIONE OPCION'] + $this->funciones->combo_categoria_activo_fijo();
        $oeProductoAF = CMPDetalleProductoAF::where('COD_PRODUCTO', $COD_PRODUCTO)->where('COD_TABLA', $idoc)->where('NRO_LINEA', $oeProducto->NRO_LINEA)->first();
        $select_categoria_id = ($oeProductoAF) ? $oeProductoAF->COD_CAT_ACTFIJO : '';
        return View::make('comprobante/modal/ajax/mcategoriaactivofijo',
            [
                'COD_PRODUCTO' => $COD_PRODUCTO,
                'CAN_PRODUCTO' => $CAN_PRODUCTO,
                'COD_LOTE' => $COD_LOTE,
                'NRO_LINEA' => $NRO_LINEA,
                'TXT_DETALLE_PRODUCTO' => $TXT_DETALLE_PRODUCTO,
                'TXT_NOMBRE_PRODUCTO' => $TXT_NOMBRE_PRODUCTO,
                'combo_categoria_activo_fijo' => $combo_categoria_activo_fijo,
                'select_categoria_id' => $select_categoria_id,
                'idopcion' => $idopcion,
                'oeProducto' => $oeProducto,
                'idcheckbox' => $idcheckbox,
                'idoc' => $idoc,
                'ajax' => true,
            ]);

    }

    public function actionEliminarActivoFijoCategoria($idoc, $COD_PRODUCTO, $COD_LOTE, $NRO_LINEA, Request $request)
    {
        // $COD_CAT_ACTFIJO        =   $request['COD_CATEGORIA_AF'];
        $COD_PRODUCTO = $request['codprod'];
        $COD_TABLA = $request['idoc'];
        $NRO_LINEA = $request['nrolinea'];
        $COD_LOTE = $request['codlote'];
        $idcheckbox = $request['idcheckbox'];
        $error = false;
        $mensaje = 'ELIMINACION DE CATEGORIA AF EXITOSA';

        try {

            $oeExiste = CMPDetalleProductoAF::where('COD_TABLA', $COD_TABLA)->where('COD_PRODUCTO', $COD_PRODUCTO)->where('NRO_LINEA', $NRO_LINEA)->first();
            if ($oeExiste) {
                // VALIDAR QUE NO ESTE YA SIENDO PROCESADO O CALCULADO SU DEPRECIACION
                if (1 == 0) {
                    $error = true;
                    $mensaje = 'YA SE ESTA DEPRECIANDO';
                } else {
                    $oeExiste->delete();
                }
            }

        } catch (\Exception $ex) {
            $error = true;
            $mensaje = 'ocurrio un error inesperado ' . $ex;
        }

        $datos = [
            'error' => $error,
            'mensaje' => $mensaje,
            'idcheckbox' => $idcheckbox
        ];
        return response()->json($datos);
    }


}
