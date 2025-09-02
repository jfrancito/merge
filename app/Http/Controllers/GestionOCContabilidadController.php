<?php

namespace App\Http\Controllers;

use App\Modelos\CMPTipoCambio;
use App\Modelos\WEBAsiento;
use App\Modelos\WEBCuentaContable;
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
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\CMPReferecenciaAsoc;
use App\Modelos\FeRefAsoc;


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


use Hashids;
use SplFileInfo;

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
            'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA'
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
            if ($operacion_id == 'CONTRATO') {
                $listadatos = $this->con_lista_cabecera_comprobante_total_cont_contrato($cod_empresa);
                $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_contrato_obs($cod_empresa);
                $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_contrato_levantadas($cod_empresa);
            } else {

                if (in_array($operacion_id, $array_canjes)) {
                    $categoria_id = $this->con_categoria_canje($operacion_id);
                    $listadatos = $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa, $operacion_id);
                    $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa, $operacion_id);
                    $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa, $operacion_id);
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
            if ($operacion_id == 'CONTRATO') {
                $listadatos = $this->con_lista_cabecera_comprobante_total_cont_contrato($cod_empresa);
                $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_contrato_obs($cod_empresa);
                $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_contrato_levantadas($cod_empresa);
            } else {
                $array_canjes = $this->con_array_canjes();
                if (in_array($operacion_id, $array_canjes)) {
                    $listadatos = $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa, $operacion_id);
                    $listadatos_obs = $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa, $operacion_id);
                    $listadatos_obs_le = $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa, $operacion_id);
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
                                'COD_ESTADO' => 'ETM0000000000004',
                                'TXT_ESTADO' => 'POR APROBAR ADMINISTRACION',
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


                    //whatsaap para administracion
                    $fedocumento_w = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                    $ordencompra = CMPOrden::where('COD_ORDEN', '=', $pedido_id)->first();

                    $empresa = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR)->first();
                    $mensaje = 'COMPROBANTE : ' . $fedocumento_w->ID_DOCUMENTO
                        . '%0D%0A' . 'EMPRESA : ' . $empresa->NOM_EMPR . '%0D%0A'
                        . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_CLIENTE . '%0D%0A'
                        . 'ESTADO : ' . $fedocumento_w->TXT_ESTADO . '%0D%0A';


                    // if(1==0){
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    // }else{

                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    //     //ADMINISTRACION
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    //     $this->insertar_whatsaap('51971575452','GISELA',$mensaje,'');
                    //     $this->insertar_whatsaap('51920721827','JESSICA DEL PILAR',$mensaje,'');
                    //     //$this->insertar_whatsaap('51948634244','ELSA ANA BELEN',$mensaje,'');
                    // }

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
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Aprobar Comprobante');

        if ($_POST) {
            $asiento_cabecera_compra = json_decode($request['asiento_cabecera_compra'], true);
            $asiento_detalle_compra = json_decode($request['asiento_detalle_compra'], true);
            $asiento_cabecera_reparable_reversion = json_decode($request['asiento_cabecera_reparable_reversion'], true);
            $asiento_detalle_reparable_reversion = json_decode($request['asiento_detalle_reparable_reversion'], true);
            $asiento_cabecera_deduccion = json_decode($request['asiento_cabecera_deduccion'], true);
            $asiento_detalle_deduccion = json_decode($request['asiento_detalle_deduccion'], true);
            $asiento_cabecera_percepcion = json_decode($request['asiento_cabecera_percepcion'], true);
            $asiento_detalle_percepcion = json_decode($request['asiento_detalle_percepcion'], true);

            $anio_asiento = $request->input('anio_asiento');
            $periodo_asiento = $request->input('periodo_asiento');
            $moneda_asiento = $request->input('moneda_asiento');
            $tipo_cambio_asiento = $request->input('tipo_cambio_asiento');
            $empresa_asiento = $request->input('empresa_asiento');
            $tipo_asiento = $request->input('tipo_asiento');
            $fecha_asiento = $request->input('fecha_asiento');
            $tipo_documento_asiento = $request->input('tipo_documento_asiento');
            $serie_asiento = $request->input('serie_asiento');
            $numero_asiento = $request->input('numero_asiento');
            $tipo_documento_ref = $request->input('tipo_documento_ref');
            $serie_ref_asiento = $request->input('serie_ref_asiento');
            $numero_ref_asiento = $request->input('numero_ref_asiento');
            $glosa_asiento = $request->input('glosa_asiento');
            $const_detraccion_asiento = $request->input('const_detraccion_asiento');
            $fecha_detraccion_asiento = $request->input('fecha_detraccion_asiento');
            $porcentaje_detraccion = $request->input('porcentaje_detraccion');
            $total_detraccion_asiento = $request->input('total_detraccion_asiento');

            $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();
            $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();

            if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
            }

            $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $empresa_asiento)->first();
            $tipo_doc_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_ref)->first();
            $tipo_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_asiento)->first();

            try {

                DB::beginTransaction();


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
                            'COD_ESTADO' => 'ETM0000000000004',
                            'TXT_ESTADO' => 'POR APROBAR ADMINISTRACION',
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

                //whatsaap para administracion
                $fedocumento_w = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $ordencompra = CMPOrden::where('COD_ORDEN', '=', $pedido_id)->first();

                $empresa = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR)->first();
                $mensaje = 'COMPROBANTE : ' . $fedocumento_w->ID_DOCUMENTO
                    . '%0D%0A' . 'EMPRESA : ' . $empresa->NOM_EMPR . '%0D%0A'
                    . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_CLIENTE . '%0D%0A'
                    . 'ESTADO : ' . $fedocumento_w->TXT_ESTADO . '%0D%0A';

                //GENERACION ASIENTOS
                if (count($asiento_cabecera_compra) > 0 and count($asiento_detalle_compra) > 0) {
                    $cod_tipo_asiento = $asiento_cabecera_compra[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_compra[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_compra[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_compra[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoCompra = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $tipo_asiento_aux->COD_CATEGORIA,
                        $tipo_asiento_aux->NOM_CATEGORIA,
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
                        $asiento_cabecera_compra[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_compra[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_compra[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoCompra)) {

                        $contador = 0;

                        foreach ($asiento_detalle_compra as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
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

                if (count($asiento_cabecera_reparable_reversion) > 0 and count($asiento_detalle_reparable_reversion) > 0) {

                    $cod_tipo_asiento = $asiento_cabecera_reparable_reversion[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_reparable_reversion[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_reparable_reversion[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_reparable_reversion[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoReversion = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $asiento_cabecera_reparable_reversion[0]['TXT_GLOSA'],
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
                        $asiento_cabecera_reparable_reversion[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_reparable_reversion[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_reparable_reversion[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoReversion)) {

                        $contador_reversion = 0;

                        foreach ($asiento_detalle_reparable_reversion as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
                                $contador_reversion++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoReversion,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador_reversion,
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
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoReversion, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoReversion);
                        $this->calcular_totales_compras($codAsientoReversion);
                    }
                }

                if (count($asiento_cabecera_deduccion) > 0 and count($asiento_detalle_deduccion) > 0) {

                    $cod_tipo_asiento = $asiento_cabecera_deduccion[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_deduccion[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_deduccion[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_deduccion[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoDeduccion = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $asiento_cabecera_deduccion[0]['TXT_GLOSA'],
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
                        $asiento_cabecera_deduccion[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_deduccion[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_deduccion[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoDeduccion)) {

                        $contador_deduccion = 0;

                        foreach ($asiento_detalle_deduccion as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
                                $contador_deduccion++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoDeduccion,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador_deduccion,
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
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoDeduccion, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoDeduccion);
                        $this->calcular_totales_compras($codAsientoDeduccion);
                    }
                }

                if (count($asiento_cabecera_percepcion) > 0 and count($asiento_detalle_percepcion) > 0) {

                    $cod_tipo_asiento = $asiento_cabecera_percepcion[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_percepcion[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_percepcion[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_percepcion[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoPercepcion = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $asiento_cabecera_percepcion[0]['TXT_GLOSA'],
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
                        $asiento_cabecera_percepcion[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_percepcion[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_percepcion[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoPercepcion)) {

                        $contador_percepcion = 0;

                        foreach ($asiento_detalle_percepcion as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
                                $contador_percepcion++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoPercepcion,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador_percepcion,
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
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoPercepcion, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoPercepcion);
                        $this->calcular_totales_compras($codAsientoPercepcion);
                    }
                }


                DB::commit();
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-contabilidad-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }


        } else {


            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
            //$lecturacdr             =   $this->lectura_cdr_archivo($idoc,$this->pathFiles,$prefijocarperta,$ordencompra->NRO_DOCUMENTO_CLIENTE);
            //$lecturacdr             =   $this->lectu($idoc,$this->pathFiles,$prefijocarperta,$ordencompra->NRO_DOCUMENTO_CLIENTE);
            $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
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
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO');
            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
            $ordencompra_f = CMPOrden::where('COD_ORDEN', '=', $idoc)->first();

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');
            $combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tabla_osiris('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($this->anio, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($this->anio, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
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

            if ($respuesta === 'ASIENTO CORRECTO') {

                $ind_reversion = 'R';

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

                    'combo_empresa_proveedor' => $combo_empresa,
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
                    'documentohistorial' => $documentohistorial,
                    'archivos' => $archivos,
                    'archivosanulados' => $archivosanulados,

                    'archivospdf' => $archivospdf,
                    'detallefedocumento' => $detallefedocumento,
                    'tarchivos' => $tarchivos,
                    'tp' => $tp,
                    'idopcion' => $idopcion,
                    'idoc' => $idoc,
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

                $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();
                $empresa = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR)->first();
                $mensaje = 'COMPROBANTE: ' . $fedocumento->ID_DOCUMENTO
                    . '%0D%0A' . 'EMPRESA : ' . $empresa->NOM_EMPR . '%0D%0A'
                    . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_CLIENTE . '%0D%0A'
                    . 'ESTADO : ' . $fedocumento->TXT_ESTADO . '%0D%0A'
                    . 'APROBACION DEL DOCUMENTO REPARABLE' . '%0D%0A';
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }

                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-reparable/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-comprobantes-reparable/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

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

            $asiento_cabecera_compra = json_decode($request['asiento_cabecera_compra'], true);
            $asiento_detalle_compra = json_decode($request['asiento_detalle_compra'], true);
            $asiento_cabecera_reparable_reversion = json_decode($request['asiento_cabecera_reparable_reversion'], true);
            $asiento_detalle_reparable_reversion = json_decode($request['asiento_detalle_reparable_reversion'], true);
            $asiento_cabecera_deduccion = json_decode($request['asiento_cabecera_deduccion'], true);
            $asiento_detalle_deduccion = json_decode($request['asiento_detalle_deduccion'], true);
            $asiento_cabecera_percepcion = json_decode($request['asiento_cabecera_percepcion'], true);
            $asiento_detalle_percepcion = json_decode($request['asiento_detalle_percepcion'], true);

            $anio_asiento = $request->input('anio_asiento');
            $periodo_asiento = $request->input('periodo_asiento');
            $moneda_asiento = $request->input('moneda_asiento');
            $tipo_cambio_asiento = $request->input('tipo_cambio_asiento');
            $empresa_asiento = $request->input('empresa_asiento');
            $tipo_asiento = $request->input('tipo_asiento');

            $fecha_asiento = $request->input('fecha_asiento');
            $tipo_documento_asiento = $request->input('tipo_documento_asiento');
            $serie_asiento = $request->input('serie_asiento');
            $numero_asiento = $request->input('numero_asiento');
            $tipo_documento_ref = $request->input('tipo_documento_ref');
            $serie_ref_asiento = $request->input('serie_ref_asiento');
            $numero_ref_asiento = $request->input('numero_ref_asiento');
            $glosa_asiento = $request->input('glosa_asiento');
            $const_detraccion_asiento = $request->input('const_detraccion_asiento');
            $fecha_detraccion_asiento = $request->input('fecha_detraccion_asiento');
            $porcentaje_detraccion = $request->input('porcentaje_detraccion');
            $total_detraccion_asiento = $request->input('total_detraccion_asiento');

            $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();
            $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();

            if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
            }

            $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $empresa_asiento)->first();
            $tipo_doc_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_ref)->first();

            $tipo_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_asiento)->first();

            try {

                DB::beginTransaction();
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
                    //LE LLEGA AL USUARIO DE CONTACTO
                    $empresa_anti = STDEmpresa::where('NRO_DOCUMENTO', '=', $fedocumento->RUC_PROVEEDOR)->first();
                    $trabajador = STDTrabajador::where('NRO_DOCUMENTO', '=', $fedocumento->dni_usuariocontacto)->first();
                    $mensaje = 'COMPROBANTE: ' . $fedocumento->ID_DOCUMENTO
                        . '%0D%0A' . 'EMPRESA : ' . Session::get('empresas')->NOM_EMPR . '%0D%0A'
                        . 'PROVEEDOR : ' . $empresa_anti->NOM_EMPR . '%0D%0A'
                        . 'ESTADO : ' . $fedocumento->TXT_ESTADO . '%0D%0A'
                        . 'RECOMENDACION : ' . $descripcion . '%0D%0A';
                    // //dd($trabajador);
                    // if(1==0){
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    // }else{
                    //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    // }
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
                            'COD_ESTADO' => 'ETM0000000000004',
                            'TXT_ESTADO' => 'POR APROBAR ADMINISTRACION',
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

                //whatsaap para administracion
                $fedocumento_w = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->first();
                $empresa_anti = STDEmpresa::where('NRO_DOCUMENTO', '=', $fedocumento->RUC_PROVEEDOR)->first();
                $mensaje = 'COMPROBANTE : ' . $fedocumento_w->ID_DOCUMENTO
                    . '%0D%0A' . 'EMPRESA : ' . Session::get('empresas')->NOM_EMPR . '%0D%0A'
                    . 'PROVEEDOR : ' . $empresa_anti->NOM_EMPR . '%0D%0A'
                    . 'ESTADO : ' . $fedocumento_w->TXT_ESTADO . '%0D%0A';

                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                //     //CONTABILIDAD
                //     $this->insertar_whatsaap('51971575452','GISELA',$mensaje,'');
                //     $this->insertar_whatsaap('51920721827','JESSICA DEL PILAR',$mensaje,'');
                //     //$this->insertar_whatsaap('51948634244','ELSA ANA BELEN',$mensaje,'');
                // }

                //GENERACION ASIENTOS
                if (count($asiento_cabecera_compra) > 0 and count($asiento_detalle_compra) > 0) {
//                DD($asiento_cabecera_compra[0]['COD_CATEGORIA_TIPO_ASIENTO']);
                    $cod_tipo_asiento = $asiento_cabecera_compra[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_compra[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_compra[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_compra[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoCompra = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $tipo_asiento_aux->COD_CATEGORIA,
                        $tipo_asiento_aux->NOM_CATEGORIA,
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
                        $asiento_cabecera_compra[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_compra[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_compra[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoCompra)) {

                        $contador = 0;

                        foreach ($asiento_detalle_compra as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
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

                if (count($asiento_cabecera_reparable_reversion) > 0 and count($asiento_detalle_reparable_reversion) > 0) {

                    $cod_tipo_asiento = $asiento_cabecera_reparable_reversion[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_reparable_reversion[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_reparable_reversion[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_reparable_reversion[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoReversion = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $asiento_cabecera_reparable_reversion[0]['TXT_GLOSA'],
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
                        $asiento_cabecera_reparable_reversion[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_reparable_reversion[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_reparable_reversion[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoReversion)) {

                        $contador_reversion = 0;

                        foreach ($asiento_detalle_reparable_reversion as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
                                $contador_reversion++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoReversion,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador_reversion,
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
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoReversion, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoReversion);
                        $this->calcular_totales_compras($codAsientoReversion);
                    }
                }

                if (count($asiento_cabecera_deduccion) > 0 and count($asiento_detalle_deduccion) > 0) {

                    $cod_tipo_asiento = $asiento_cabecera_deduccion[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_deduccion[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_deduccion[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_deduccion[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoDeduccion = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $asiento_cabecera_deduccion[0]['TXT_GLOSA'],
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
                        $asiento_cabecera_deduccion[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_deduccion[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_deduccion[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoDeduccion)) {

                        $contador_deduccion = 0;

                        foreach ($asiento_detalle_deduccion as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
                                $contador_deduccion++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoDeduccion,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador_deduccion,
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
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoDeduccion, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoDeduccion);
                        $this->calcular_totales_compras($codAsientoDeduccion);
                    }
                }

                if (count($asiento_cabecera_percepcion) > 0 and count($asiento_detalle_percepcion) > 0) {

                    $cod_tipo_asiento = $asiento_cabecera_percepcion[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_percepcion[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_percepcion[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_percepcion[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoPercepcion = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $asiento_cabecera_percepcion[0]['TXT_GLOSA'],
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
                        $asiento_cabecera_percepcion[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_percepcion[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_percepcion[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoPercepcion)) {

                        $contador_percepcion = 0;

                        foreach ($asiento_detalle_percepcion as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
                                $contador_percepcion++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoPercepcion,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador_percepcion,
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
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoPercepcion, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoPercepcion);
                        $this->calcular_totales_compras($codAsientoPercepcion);
                    }
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
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO');

            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();

            $lotes = FeRefAsoc::where('lote', '=', $idoc)
                ->pluck('ID_DOCUMENTO')
                ->toArray();
            $documento_asociados = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->get();
            $documento_top = CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE', $lotes)->first();

            $linea = $fedocumento->DOCUMENTO_ITEM;

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            $combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tabla_osiris('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($this->anio, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($this->anio, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
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

            if ($respuesta === 'ASIENTO CORRECTO') {

                $ind_reversion = 'R';

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

                    'combo_empresa_proveedor' => $combo_empresa,
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

//            dd($request);

            $asiento_cabecera_compra = json_decode($request['asiento_cabecera_compra'], true);
            $asiento_detalle_compra = json_decode($request['asiento_detalle_compra'], true);
            $asiento_cabecera_reparable_reversion = json_decode($request['asiento_cabecera_reparable_reversion'], true);
            $asiento_detalle_reparable_reversion = json_decode($request['asiento_detalle_reparable_reversion'], true);
            $asiento_cabecera_deduccion = json_decode($request['asiento_cabecera_deduccion'], true);
            $asiento_detalle_deduccion = json_decode($request['asiento_detalle_deduccion'], true);
            $asiento_cabecera_percepcion = json_decode($request['asiento_cabecera_percepcion'], true);
            $asiento_detalle_percepcion = json_decode($request['asiento_detalle_percepcion'], true);

//            dd($asiento_cabecera_compra, $asiento_detalle_compra, $asiento_detalle_reparable_reversion, $asiento_detalle_deduccion, $asiento_detalle_percepcion, $asiento_cabecera_reparable_reversion, $asiento_cabecera_deduccion, $asiento_cabecera_percepcion);;

            $anio_asiento = $request->input('anio_asiento');
            $periodo_asiento = $request->input('periodo_asiento');
//            $comprobante_asiento = $request->input('comprobante_asiento');
            $moneda_asiento = $request->input('moneda_asiento');
            $tipo_cambio_asiento = $request->input('tipo_cambio_asiento');
            $empresa_asiento = $request->input('empresa_asiento');
            $tipo_asiento = $request->input('tipo_asiento');
            $fecha_asiento = $request->input('fecha_asiento');
            $tipo_documento_asiento = $request->input('tipo_documento_asiento');
            $serie_asiento = $request->input('serie_asiento');
            $numero_asiento = $request->input('numero_asiento');
            $tipo_documento_ref = $request->input('tipo_documento_ref');
            $serie_ref_asiento = $request->input('serie_ref_asiento');
            $numero_ref_asiento = $request->input('numero_ref_asiento');
            $glosa_asiento = $request->input('glosa_asiento');
//            $igv_xml = $request->input('igv_xml');
//            $subtotal_xml = $request->input('subtotal_xml');
//            $total_xml = $request->input('total_xml');
//            $tipo_descuento_asiento = $request->input('tipo_descuento_asiento');
            $const_detraccion_asiento = $request->input('const_detraccion_asiento');
            $fecha_detraccion_asiento = $request->input('fecha_detraccion_asiento');
            $porcentaje_detraccion = $request->input('porcentaje_detraccion');
            $total_detraccion_asiento = $request->input('total_detraccion_asiento');

            $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();
            $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_asiento)->first();

            if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
            }

            $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $empresa_asiento)->first();
            $tipo_doc_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_ref)->first();
            $tipo_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_asiento)->first();

//            DD($moneda_asiento_aux, $moneda_asiento_conversion_aux, $empresa_doc_asiento_aux, $tipo_doc_asiento_aux, $tipo_doc_ref_asiento_aux);

            try {

                DB::beginTransaction();


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
                        . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_EMISOR . '%0D%0A'
                        . 'ESTADO : ' . $fedocumento->TXT_ESTADO . '%0D%0A'
                        . 'RECOMENDACION : ' . $descripcion . '%0D%0A';
                    // //dd($trabajador);
                    // if(1==0){
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    // }else{
                    //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    // }
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
                            'COD_ESTADO' => 'ETM0000000000004',
                            'TXT_ESTADO' => 'POR APROBAR ADMINISTRACION',
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

                //whatsaap para administracion
                $fedocumento_w = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $ordencompra = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)->first();

                //$ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();

                $empresa = STDEmpresa::where('COD_EMPR', '=', $ordencompra->COD_EMPR)->first();
                $mensaje = 'COMPROBANTE : ' . $fedocumento_w->ID_DOCUMENTO
                    . '%0D%0A' . 'EMPRESA : ' . $empresa->NOM_EMPR . '%0D%0A'
                    . 'PROVEEDOR : ' . $ordencompra->TXT_EMPR_EMISOR . '%0D%0A'
                    . 'ESTADO : ' . $fedocumento_w->TXT_ESTADO . '%0D%0A';

                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{

                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                //     //CONTABILIDAD
                //     $this->insertar_whatsaap('51971575452','GISELA',$mensaje,'');
                //     $this->insertar_whatsaap('51920721827','JESSICA DEL PILAR',$mensaje,'');
                //     //$this->insertar_whatsaap('51948634244','ELSA ANA BELEN',$mensaje,'');

                // }

                //GENERACION ASIENTOS
                if (count($asiento_cabecera_compra) > 0 and count($asiento_detalle_compra) > 0) {
//                DD($asiento_cabecera_compra[0]['COD_CATEGORIA_TIPO_ASIENTO']);
                    $cod_tipo_asiento = $asiento_cabecera_compra[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_compra[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_compra[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_compra[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoCompra = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $tipo_asiento_aux->COD_CATEGORIA,
                        $tipo_asiento_aux->NOM_CATEGORIA,
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
                        $asiento_cabecera_compra[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_compra[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_compra[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoCompra)) {

                        $contador = 0;

                        foreach ($asiento_detalle_compra as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
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

                if (count($asiento_cabecera_reparable_reversion) > 0 and count($asiento_detalle_reparable_reversion) > 0) {

                    $cod_tipo_asiento = $asiento_cabecera_reparable_reversion[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_reparable_reversion[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_reparable_reversion[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_reparable_reversion[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoReversion = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $asiento_cabecera_reparable_reversion[0]['TXT_GLOSA'],
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
                        $asiento_cabecera_reparable_reversion[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_reparable_reversion[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_reparable_reversion[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoReversion)) {

                        $contador_reversion = 0;

                        foreach ($asiento_detalle_reparable_reversion as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
                                $contador_reversion++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoReversion,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador_reversion,
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
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoReversion, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoReversion);
                        $this->calcular_totales_compras($codAsientoReversion);
                    }
                }

                if (count($asiento_cabecera_deduccion) > 0 and count($asiento_detalle_deduccion) > 0) {

                    $cod_tipo_asiento = $asiento_cabecera_deduccion[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_deduccion[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_deduccion[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_deduccion[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoDeduccion = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $asiento_cabecera_deduccion[0]['TXT_GLOSA'],
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
                        $asiento_cabecera_deduccion[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_deduccion[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_deduccion[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoDeduccion)) {

                        $contador_deduccion = 0;

                        foreach ($asiento_detalle_deduccion as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
                                $contador_deduccion++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoDeduccion,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador_deduccion,
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
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoDeduccion, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoDeduccion);
                        $this->calcular_totales_compras($codAsientoDeduccion);
                    }
                }

                if (count($asiento_cabecera_percepcion) > 0 and count($asiento_detalle_percepcion) > 0) {

                    $cod_tipo_asiento = $asiento_cabecera_percepcion[0]['COD_CATEGORIA_TIPO_ASIENTO'];
                    $des_tipo_asiento = $asiento_cabecera_percepcion[0]['TXT_CATEGORIA_TIPO_ASIENTO'];
                    $cod_estado_asiento = $asiento_cabecera_percepcion[0]['COD_CATEGORIA_ESTADO_ASIENTO'];
                    $des_estado_asiento = $asiento_cabecera_percepcion[0]['TXT_CATEGORIA_ESTADO_ASIENTO'];

                    $codAsientoPercepcion = $this->ejecutarAsientosIUDConSalida(
                        'I',
                        Session::get('empresas')->COD_EMPR,
                        'CEN0000000000001',
                        $periodo_asiento,
                        $cod_tipo_asiento,
                        $des_tipo_asiento,
                        '',
                        $fecha_asiento,
                        $asiento_cabecera_percepcion[0]['TXT_GLOSA'],
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
                        $asiento_cabecera_percepcion[0]['COD_ASIENTO_MODELO'],
                        $asiento_cabecera_percepcion[0]['TXT_TIPO_REFERENCIA'],
                        $asiento_cabecera_percepcion[0]['TXT_REFERENCIA'],
                        1,
                        Session::get('usuario')->id,
                        '',
                        '',
                        $empresa_doc_asiento_aux->COD_EMPR,
                        $empresa_doc_asiento_aux->NOM_EMPR,
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $fecha_detraccion_asiento,
                        $const_detraccion_asiento,
                        $porcentaje_detraccion,
                        $total_detraccion_asiento,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                        $serie_ref_asiento,
                        $numero_ref_asiento,
                        $fecha_asiento,
                        0,
                        $moneda_asiento_conversion_aux->COD_CATEGORIA,
                        $moneda_asiento_conversion_aux->NOM_CATEGORIA
                    );

                    if (!empty($codAsientoPercepcion)) {

                        $contador_percepcion = 0;

                        foreach ($asiento_detalle_percepcion as $asiento_detalle_compra_item) {
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
                                $contador_percepcion++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsientoPercepcion,
                                    'cuenta' => $asiento_detalle_compra_item['COD_CUENTA_CONTABLE'],
                                    'txtCuenta' => $asiento_detalle_compra_item['TXT_CUENTA_CONTABLE'],
                                    'glosa' => $asiento_detalle_compra_item['TXT_GLOSA'],
                                    'debeMN' => $asiento_detalle_compra_item['CAN_DEBE_MN'],
                                    'haberMN' => $asiento_detalle_compra_item['CAN_HABER_MN'],
                                    'debeME' => $asiento_detalle_compra_item['CAN_DEBE_ME'],
                                    'haberME' => $asiento_detalle_compra_item['CAN_HABER_ME'],
                                    'linea' => $contador_percepcion,
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
                        $this->generar_destinos_compras($anio_asiento, Session::get('empresas')->COD_EMPR, $codAsientoPercepcion, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsientoPercepcion);
                        $this->calcular_totales_compras($codAsientoPercepcion);
                    }
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
            $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);
            //dd($idoc);
            $lecturacdr             =   $this->lectura_cdr_archivo($idoc,$this->pathFiles,$prefijocarperta,$ordencompra->NRO_DOCUMENTO_CLIENTE);

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
                ->whereNotIn('COD_CATEGORIA', ['DCC0000000000003', 'DCC0000000000004'])
                //->whereNotIn('COD_CATEGORIA',$archivosselect)
                ->get();

            $comboreparable = array('ARCHIVO_VIRTUAL' => 'ARCHIVO_VIRTUAL', 'ARCHIVO_FISICO' => 'ARCHIVO_FISICO');

            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            $combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tabla_osiris('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $anio_defecto = date('Y', strtotime($fedocumento->FEC_VENTA));
            $mes_defecto = date('m', strtotime($fedocumento->FEC_VENTA));

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $array_periodo_pc = $this->gn_periodo_actual_xanio_xempresa($this->anio, $mes_defecto, Session::get('empresas')->COD_EMPR);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($this->anio, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');
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

//            dd($asiento_compra);

            $respuesta = '';

            if (!empty($asiento_compra)) {
                $respuesta = $asiento_compra[0][0]['RESPUESTA'];
            }

//            dd($respuesta);

            if ($respuesta === 'ASIENTO CORRECTO') {

                $ind_reversion = 'R';

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
            }

//            dd($asiento_deduccion, $asiento_percepcion, $asiento_reparable_reversion);

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

//            dd($asiento_reparable);

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

                    'combo_empresa_proveedor' => $combo_empresa,
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

                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ind_observacion' => 1,
                            'TXT_OBSERVADO' => 'OBSERVADO',
                            'area_observacion' => 'CONT'
                        ]
                    );

                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)
                //                         ->where('TXT_TELEFONO','<>','')
                //                         ->first();

                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE OBSERVADO: '.$fedocumento->ID_DOCUMENTO
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

                //LE LLEGA AL USUARIO DE CONTACTO
                // $empresa_anti       =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $mensaje            =   'COMPROBANTE REPARABLE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.Session::get('empresas')->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$empresa_anti->NOM_EMPR.'%0D%0A'
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
                return Redirect::to('/gestion-de-contabilidad-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $idoc . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                Session::flash('operacion_id', 'CONTRATO');

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
            $tipo_doc_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_ref)->first();

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivore = $request['archivore'];
                $reparable = $request['reparable'];


                if ($fedocumento->IND_REPARABLE == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento ya esta reparado no se puede reparar');
                }


                if (count($archivore) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }

                foreach ($archivore as $index => $item) {
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

                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'IND_REPARABLE' => 1,
                            'MODO_REPARABLE' => $reparable,
                            'TXT_REPARABLE' => 'REPARABLE'
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
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $this->fechaactual,
                        '',
                        0.0000,
                        0.0000,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
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
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
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

                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'ind_observacion' => 1,
                            'TXT_OBSERVADO' => 'OBSERVADO',
                            'area_observacion' => 'CONT'
                        ]
                    );

                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE OBSERVADO: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_EMISOR.'%0D%0A'
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
                FeDocumento::where('ID_DOCUMENTO', $idoc)
                    ->update(
                        [
                            'ind_observacion' => 1,
                            'TXT_OBSERVADO' => 'OBSERVADO',
                            'area_observacion' => 'CONT'
                        ]
                    );
                // $empresa_anti       =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();
                // $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
                // //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $mensaje            =   'COMPROBANTE OBSERVADO: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.Session::get('empresas')->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$empresa_anti->NOM_EMPR.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'MENSAJE : '.$descripcion.'%0D%0A';

                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }
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
            $tipo_doc_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_ref)->first();

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
                //LE LLEGA AL USUARIO DE CONTACTO
                // $empresa_anti       =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $mensaje            =   'COMPROBANTE REPARABLE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.Session::get('empresas')->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$empresa_anti->NOM_EMPR.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'MENSAJE : '.$descripcion.'%0D%0A';

                // //dd($trabajador);
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }

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
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $this->fechaactual,
                        '',
                        0.0000,
                        0.0000,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
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
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
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
            $tipo_doc_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_asiento)->first();
            $tipo_doc_ref_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $tipo_documento_ref)->first();

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $descripcion = $request['descripcion'];
                $archivoob = $request['archivore'];
                $reparable = $request['reparable'];

                if ($fedocumento->IND_REPARABLE == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorurl', 'El documento ya esta reparado no se puede reparar');
                }

                if (count($archivoob) <= 0) {
                    DB::rollback();
                    return Redirect::to('aprobar-comprobante-contabilidad/' . $idopcion . '/' . $linea . '/' . $prefijo . '/' . $idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
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
                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'IND_REPARABLE' => 1,
                            'MODO_REPARABLE' => $reparable,
                            'TXT_REPARABLE' => 'REPARABLE'
                        ]
                    );
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
                        $tipo_doc_asiento_aux->COD_CATEGORIA,
                        $tipo_doc_asiento_aux->NOM_CATEGORIA,
                        $serie_asiento,
                        $numero_asiento,
                        $this->fechaactual,
                        '',
                        0.0000,
                        0.0000,
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                        isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
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
                            if ($asiento_detalle_compra_item['COD_ESTADO'] === "1") {
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

//                dd("todo ok");

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

                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'RECOMENDACION : '.$descripcion.'%0D%0A';

                // //dd($trabajador);
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }

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

                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'RECOMENDACION : '.$descripcion.'%0D%0A';

                // //dd($trabajador);
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }

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


}
