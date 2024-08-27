<?php

namespace App\Http\Controllers;

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
use App\Modelos\CMPCategoria;
use App\Modelos\FeDocumentoHistorial;
use App\Modelos\SGDUsuario;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use App\Modelos\Archivo;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\CMPDocumentoCtble;

use App\Modelos\CMPReferecenciaAsoc;




use App\Modelos\CMPOrden;
use Greenter\Parser\DocumentParserInterface;
use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;
use Greenter\Xml\Parser\PerceptionParser;
use Greenter\Xml\Parser\RHParser;


use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use App\Traits\GeneralesTraits;
use App\Traits\ComprobanteTraits;
use App\Traits\WhatsappTraits;
use App\Traits\ComprobanteProvisionTraits;
use PDO;

use Storage;
use ZipArchive;
use Hashids;
use SplFileInfo;
use Carbon\Carbon;
class GestionTCController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;


    public function actionListarOC($idopcion)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Contrato Transporte de Carga');

        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $listadatos     =   $this->con_lista_cabecera_comprobante_contrato($cod_empresa);
        $funcion        =   $this;
        $procedencia    =   'PRO';
        //dd($listadatos);
        //dd($listadatos);
        return View::make('comprobante/listacontratoproveedores',
                         [
                            'listadatos'        =>  $listadatos,
                            'procedencia'       =>  $procedencia,

                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }




    public function actionDescargarComprobanteOCProveedor($procedencia,$idopcion, $prefijo, $idordencompra, Request $request) {


        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();

        $ordencompra_f            =      CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();

        $sourceFile = '\\\\10.1.0.201\cpe\Contratos';
        if($ordencompra_f->COD_CENTRO == 'CEN0000000000004' or $ordencompra_f->COD_CENTRO == 'CEN0000000000006'or $ordencompra_f->COD_CENTRO == 'CEN0000000000002'){
            if($ordencompra_f->COD_CENTRO == 'CEN0000000000004'){
                $sourceFile = '\\\\10.1.7.200\\cpe\\Contratos\\'.$ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
            }
            if($ordencompra_f->COD_CENTRO == 'CEN0000000000006'){
                $sourceFile = '\\\\10.1.9.43\\cpe\\Contratos\\'.$ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
            }
            if($ordencompra_f->COD_CENTRO == 'CEN0000000000002'){
                $sourceFile = '\\\\10.1.4.201\\cpe\\Contratos\\'.$ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
            }

            $destinationFile = '\\\\10.1.0.201\\cpe\\Contratos\\'.$ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
            // Intenta copiar el archivo
            //dd($sourceFile);
            if (file_exists($sourceFile)){
                copy($sourceFile, $destinationFile);
            }
        }

        $sourceFile = '\\\\10.1.0.201\cpe\Contratos';

        $nombrearchivo          =   trim($idoc);
        $nombrefile             =   basename($nombrearchivo.'.pdf');
        $file                   =   $sourceFile.'\\'.basename($nombrearchivo.'.pdf');
        //dd($file);

        if(file_exists($file)){
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$nombrefile");
            header("Content-Type: application/xml");
            header("Content-Transfer-Encoding: binary");
            readfile($file);
            exit;
        }else{
            dd('Documento no encontrado');
        }



    }



    public function actionDetalleComprobanteOCProveedor($procedencia,$idopcion, $prefijo, $idordencompra, Request $request) {


        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();

        View::share('titulo','REGISTRO DE COMPROBANTE CONTRATO TRANSPORTE CARGA: '.$idoc);

        $tiposerie              =   '';

        if(count($fedocumento)>0){
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);
        }else{
            $detallefedocumento     =   array();
        }

        //dd($detallefedocumento);

        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);
        $xmlarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'xml';
        $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        //dd($tp);
        $contacto               =   DB::table('users')->where('ind_contacto','=',1)->pluck('nombre','id')->toArray();
        $combocontacto          =   array('' => "Seleccione Contacto") + $contacto;
        $usuario                =   SGDUsuario::where('COD_USUARIO','=',$ordencompra->COD_USUARIO_CREA_AUD)->first();


        $xmlfactura             =   'FACTURA';
        // $rhxml                  =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
        //                             //->where('IND_OBLIGATORIO','=',1)
        //                             ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
        //                             ->where('TXT_ASIGNADO','=','PROVEEDOR')
        //                             ->first();

        // if(count($rhxml)>0){
        //     $xmlfactura             =   $rhxml->NOM_CATEGORIA_DOCUMENTO;
        // }



        if($tiposerie == 'E'){

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004','DCC0000000000026'])
                                        ->get();

        }else{
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)

                                        ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000026'])
                                        ->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                        ->get();
        }

        $combodocumento             =   array('DCC0000000000002' => 'FACTURA ELECTRONICA' , 'DCC0000000000013' => 'RECIBO POR HONORARIO');
        $documento_id               =   'DCC0000000000002';
        $funcion                    =   $this;

        return View::make('comprobante/registrocomprobantecontratoproveedor',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'procedencia'           =>  $procedencia,
                            'xmlfactura'            =>  $xmlfactura,

                            'combodocumento'         =>  $combodocumento,
                            'documento_id'           =>  $documento_id,


                            'tp'                    =>  $tp,
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tarchivos'             =>  $tarchivos,
                            'usuario'               =>  $usuario,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }




    public function actionCargarXMLProveedor($idopcion, $prefijo, $idordencompra,Request $request)
    {

        $file                   =   $request['inputxml'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);

        $procedencia            =   $request['procedencia'];
        $documento_id           =   $request['documento_id'];
        //dd("hola");


        if($_POST)
        {
            if (!empty($file)) 
            {
                try{    

                        DB::beginTransaction();
                        $ordencompra_t          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();
                        $fedocumento_t          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();


                        if(count($fedocumento_t)>0){
                            DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                        }


                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $larchivos       =      Archivo::get();
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      count($larchivos).'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;

                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();

                        copy($file->getRealPath(),$rutacompleta);
                        //dd($extractedFile);
                        $path            =   $rutacompleta;


                        if($documento_id=='DCC0000000000002'){
                            //FACTURA
                            /****************************************  LEER EL XML Y GUARDAR   *********************************/
                            $parser = new InvoiceParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);
                            $tipo_documento_le = $factura->gettipoDoc();
                            $moneda_le = $factura->gettipoMoneda();


                            $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                            ->whereIn('COD_CATEGORIA', ['DCC0000000000026','DCC0000000000002','DCC0000000000003','DCC0000000000004','DCC0000000000008'])
                                                            ->get();



                        }else{
                            //RECIBO POR HONORARIO
                            $parser = new RHParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);  
                            $tipo_documento_le = 'R1';
                            $moneda_le = 'PEN';

                            $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                            ->whereIn('COD_CATEGORIA', ['DCC0000000000026','DCC0000000000013','DCC0000000000003','DCC0000000000008'])->get();
                        }


                        //dd($factura);


                        $rz_p                               =   str_replace(["![CDATA[", "]]"], "", $factura->getcompany()->getrazonSocial());
                        $rz_p                               =    str_replace("?", "Ñ", $rz_p);

                        $documentolinea                     =   $this->ge_linea_documento($ordencompra->COD_DOCUMENTO_CTBLE);
                        $cant_rentencion                    =   $ordencompra_t->CAN_RETENCION;
                        $cant_perception                    =   $factura->getperception();

                        //REGISTRO DEL XML LEIDO
                        $documento                          =   new FeDocumento;
                        $documento->ID_DOCUMENTO            =   $ordencompra->COD_DOCUMENTO_CTBLE;
                        $documento->DOCUMENTO_ITEM          =   $documentolinea;

                        $documento->COD_EMPR                =   $ordencompra->COD_EMPR;
                        $documento->TXT_EMPR                =   $ordencompra->NOM_EMPR;
                        $documento->TXT_PROCEDENCIA         =   $procedencia;
                        $documento->ESTADO                  =   'A';
                        $documento->RUC_PROVEEDOR           =   $factura->getcompany()->getruc();
                        $documento->RZ_PROVEEDOR            =   $rz_p;

                        $documento->TIPO_CLIENTE            =   $factura->getClient()->gettipoDoc();
                        $documento->ID_CLIENTE              =   $factura->getClient()->getnumDoc();
                        $documento->NOMBRE_CLIENTE          =   $factura->getClient()->getrznSocial();
                        $documento->DIRECCION_CLIENTE       =   '';
                        $documento->SERIE                   =   $factura->getserie();
                        $documento->NUMERO                  =   $factura->getcorrelativo();
                        $documento->ID_TIPO_DOC             =   $tipo_documento_le;
                        $documento->FEC_VENTA               =   $factura->getfechaEmision()->format('Ymd');
                        $documento->FEC_VENCI_PAGO          =   $factura->getfecVencimiento()->format('Ymd');
                        $documento->FORMA_PAGO              =   $factura->getcondicionPago();
                        $documento->FORMA_PAGO_DIAS          =  0;
                        $documento->MONEDA                  =   $moneda_le;
                        $documento->VALOR_IGV_ORIG          =   $factura->getmtoIGV();
                        $documento->VALOR_IGV_SOLES         =   $factura->getmtoIGV();
                        $documento->SUB_TOTAL_VENTA_ORIG    =   $factura->getmtoOperGravadas();
                        $documento->SUB_TOTAL_VENTA_SOLES   =   $factura->getmtoOperGravadas();
                        $documento->TOTAL_VENTA_ORIG        =   $factura->getmtoImpVenta();
                        $documento->TOTAL_VENTA_SOLES       =   $factura->getmtoImpVenta();

                        $documento->PERCEPCION              =   $cant_perception;
                        $documento->MONTO_RETENCION         =   $cant_rentencion;

                        $documento->HORA_EMISION            =   $factura->gethoraEmision();
                        $documento->IMPUESTO_2              =   $factura->getmtoOtrosTributos();
                        $documento->TIPO_DETRACCION         =   $factura->getdetraccion()->gettipoDet();
                        $documento->PORC_DETRACCION         =   $factura->getdetraccion()->getporcDet();
                        $documento->MONTO_DETRACCION        =   $factura->getdetraccion()->getbaseDetr();
                        $documento->MONTO_ANTICIPO          =   $factura->getdestotalAnticipos();
                        //$documento->OBSERVACION             =   $factura->getobservacion();
                        $documento->NRO_ORDEN_COMP          =   $factura->getcompra();              
                        $documento->NUM_GUIA                =   $factura->getguiaEmbebida();
                        $documento->estadoCp                =   0;
                        $documento->ARCHIVO_XML             =   $nombrefile;
                        $documento->ARCHIVO_CDR             =   '';
                        $documento->ARCHIVO_PDF             =   '';
                        $documento->COD_CONTACTO            =   '';
                        $documento->TXT_CONTACTO            =   '';
                        $documento->COD_ESTADO              =   '';
                        $documento->TXT_ESTADO              =   '';
                        $documento->ind_email_uc            =   -1;
                        $documento->ind_email_ap            =   -1;
                        $documento->ind_email_adm           =   -1;
                        $documento->ind_email_ba            =   -1;
                        $documento->ind_email_clap          =   -1;
                        $documento->OPERACION               =   'CONTRATO';
                        $documento->save();



                        //ARCHIVO
                        $dcontrol                   =   new Archivo;
                        $dcontrol->ID_DOCUMENTO     =   $ordencompra->COD_DOCUMENTO_CTBLE;
                        $dcontrol->DOCUMENTO_ITEM   =   $documentolinea;
                        $dcontrol->TIPO_ARCHIVO     =   'DCC0000000000003';
                        $dcontrol->NOMBRE_ARCHIVO   =   $nombrefile;
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'XML DEL COMPROBANTE DE COMPRA';
                        $dcontrol->URL_ARCHIVO      =   $path;
                        $dcontrol->SIZE             =   filesize($file);
                        $dcontrol->EXTENSION        =   $extension;
                        $dcontrol->ACTIVO           =   1;
                        $dcontrol->FECHA_CREA       =   $this->fechaactual;
                        $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                        $dcontrol->save();


                        /**********DETALLE*********/
                        foreach ($factura->getdetails() as $indexdet => $itemdet) {

                                $producto                           = str_replace("<![CDATA[","",$itemdet->getdescripcion());
                                $producto                           = str_replace("]]>","",$producto);
                                $producto                           = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);

                                $linea = str_pad($indexdet+1, 3, "0", STR_PAD_LEFT); 
                                $detalle                        =   new FeDetalleDocumento;
                                $detalle->ID_DOCUMENTO          =   $ordencompra->COD_DOCUMENTO_CTBLE;
                                $detalle->DOCUMENTO_ITEM        =   $documentolinea;

                                $detalle->LINEID                =   $linea;
                                $detalle->CODPROD               =   $itemdet->getcodProducto();
                                $detalle->PRODUCTO              =   $producto;
                                $detalle->UND_PROD              =   $itemdet->getunidad();
                                $detalle->CANTIDAD              =   $itemdet->getcantidad();
                                $detalle->PRECIO_UNIT           =   (float)$itemdet->getmtoValorUnitario();
                                $detalle->VAL_IGV_ORIG          =   (float)$itemdet->getigv();
                                $detalle->VAL_IGV_SOL           =   (float)$itemdet->getigv();
                                $detalle->VAL_SUBTOTAL_ORIG     =   (float)$itemdet->getmtoValorVenta();
                                $detalle->VAL_SUBTOTAL_SOL      =   (float)$itemdet->getmtoValorVenta();
                                $detalle->VAL_VENTA_ORIG        =   (float)$itemdet->getigv()+(float)$itemdet->getmtoValorVenta();
                                $detalle->VAL_VENTA_SOL         =   (float)$itemdet->getigv()+(float)$itemdet->getmtoValorVenta();
                                $detalle->PRECIO_ORIG           =   (float)$itemdet->getmtoPrecioUnitario();
                                $detalle->save();

                        }

                        /**********FORMA DE PAGO*********/
                        foreach ($factura->getFormaPago() as $indexfor => $itemfor) {

                                $fechapago                      =   date_format(date_create($itemfor->getfecha()), 'Ymd');

                                $forma                          =   new FeFormaPago;
                                $forma->ID_DOCUMENTO            =   $ordencompra->COD_DOCUMENTO_CTBLE;
                                $forma->DOCUMENTO_ITEM          =   $documentolinea;
                                $forma->ID_CUOTA                =   $itemfor->getnumCuota();
                                $forma->ID_MONEDA               =   $itemfor->getmoneda();
                                $forma->MONTO_CUOTA             =   (float)$itemfor->getmonto();
                                $forma->FECHA_PAGO              =   $fechapago;
                                $forma->save();

                        }

                        /****************************************  VALIDAR SI EL ARCHIVO ESTA ACEPTADO POR SUNAT  *********************************/



                        $fedocumento         =      FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','<>','ETM0000000000006')->first();
                        $fechaemision        =      date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                        $detallefedocumento  =      FeDetalleDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


                        //VALIDAR QUE ALGUNOS CAMPOS SEAN IGUALES
                        $this->con_validar_documento_proveedor_contrato($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento);

                        //ARCHIVOS
                        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->delete();

                        foreach($archivosdelfe as $index=>$item){

                                $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item->COD_CATEGORIA)->first();

                                $docasociar                              =   New CMPDocAsociarCompra;
                                $docasociar->COD_ORDEN                   =   $ordencompra->COD_DOCUMENTO_CTBLE;
                                $docasociar->COD_CATEGORIA_DOCUMENTO     =   $categoria->COD_CATEGORIA;
                                $docasociar->NOM_CATEGORIA_DOCUMENTO     =   $categoria->NOM_CATEGORIA;
                                $docasociar->IND_OBLIGATORIO             =   $categoria->IND_DOCUMENTO_VAL;
                                $docasociar->TXT_FORMATO                 =   $categoria->COD_CTBLE;
                                $docasociar->TXT_ASIGNADO                =   $categoria->TXT_ABREVIATURA;
                                $docasociar->COD_USUARIO_CREA_AUD        =   Session::get('usuario')->id;
                                $docasociar->FEC_USUARIO_CREA_AUD        =   $this->fechaactual;
                                $docasociar->COD_ESTADO                  =   1;
                                $docasociar->TIP_DOC                     =   $categoria->CODIGO_SUNAT;
                                $docasociar->save();
                        }



                        DB::commit();

                }catch(\Exception $ex){
                    DB::rollback(); 
                    return Redirect::to('detalle-comprobante-contrato-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
                }
                return Redirect::to('detalle-comprobante-contrato-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Se valido el xml');
            }else{
                return Redirect::to('detalle-comprobante-contrato-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo XML a Importar ');
            }

        }
    }





    public function actionValidarXMLProveedor($idopcion, $prefijo, $idordencompra,Request $request)
    {

        $file                   =   $request['inputxml'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $contacto_id       =   $request['contacto_id'];
                $procedencia       =   $request['procedencia'];
                
                $fedocumento       =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();


                /**************************** VALIDAR CDR Y LEER RESPUESTA ******************************/
                $filescdr          =   $request['DCC0000000000004'];

                $codigocdr = '';
                $respuestacdr = '';
                $factura_cdr_id = '';
                $sw = 0;
                $nombre_doc = $fedocumento->SERIE.'-'.$fedocumento->NUMERO;

                $numerototal     = $fedocumento->NUMERO;
                $numerototalsc    = ltrim($numerototal, '0');
                $nombre_doc_sinceros = $fedocumento->SERIE.'-'.$numerototalsc;


                /************************************************************************/
                $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                if($tiposerie == 'E'){
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004','DCC0000000000026'])
                                                ->get();
                //dd($tarchivos);

                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000026'])
                                                ->get();
                }


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
                        foreach($filescdm as $file){

                            $larchivos       =      Archivo::get();
                            $nombre          =      $ordencompra->COD_DOCUMENTO_CTBLE.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      count($larchivos).'-'.$file->getClientOriginalName();
                            $valor           =      $this->versicarpetanoexiste($rutafile);
                            $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                            copy($file->getRealPath(),$rutacompleta);
                            $path            =      $rutacompleta;

                            $nombreoriginal             =   $file->getClientOriginalName();
                            $info                       =   new SplFileInfo($nombreoriginal);
                            $extension                  =   $info->getExtension();

                            $dcontrol                       =   new Archivo;
                            $dcontrol->ID_DOCUMENTO         =   $ordencompra->COD_DOCUMENTO_CTBLE;
                            $dcontrol->DOCUMENTO_ITEM       =   $fedocumento->DOCUMENTO_ITEM;
                            $dcontrol->TIPO_ARCHIVO         =   $item->COD_CATEGORIA_DOCUMENTO;
                            $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO  =   $item->NOM_CATEGORIA_DOCUMENTO;


                            $dcontrol->URL_ARCHIVO      =   $path;
                            $dcontrol->SIZE             =   filesize($file);
                            $dcontrol->EXTENSION        =   $extension;
                            $dcontrol->ACTIVO           =   1;
                            $dcontrol->FECHA_CREA       =   $this->fechaactual;
                            $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                            $dcontrol->save();
                        }
                    }
                }

                $contacto                                 =   SGDUsuario::where('COD_TRABAJADOR','=',$contacto_id)->first();
                $trabajador                               =   STDTrabajador::where('COD_TRAB','=',$contacto->COD_TRABAJADOR)->first();
                //$contacto                               =   User::where('id','=',$contacto_id)->first();

                FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [
                                    'ARCHIVO_CDR'=>'',
                                    'ARCHIVO_PDF'=>'',
                                    'COD_ESTADO'=>'ETM0000000000007',
                                    'TXT_ESTADO'=>'POR VALIDAR SUNAT',
                                    'dni_usuariocontacto'=>$trabajador->NRO_DOCUMENTO,
                                    'COD_CONTACTO'=>$contacto->COD_TRABAJADOR,
                                    'CODIGO_CDR'=>$codigocdr,
                                    'RESPUESTA_CDR'=>$respuestacdr,
                                    'ind_email_uc'=>0,
                                    'TXT_CONTACTO'=>$contacto->NOM_TRABAJADOR,
                                    'fecha_pa'=>$this->fechaactual,
                                    'usuario_pa'=>Session::get('usuario')->id,

                                ]
                            );


                $ordencompra_t                          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$ordencompra->COD_DOCUMENTO_CTBLE)->first();
                //HISTORIAL DE DOCUMENTO APROBADO

                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $ordencompra->COD_DOCUMENTO_CTBLE;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   date_format(date_create($ordencompra_t->FEC_USUARIO_CREA_AUD), 'Ymd h:i:s');
                $documento->USUARIO_ID                  =   $contacto->COD_TRABAJADOR;
                $documento->USUARIO_NOMBRE              =   $contacto->NOM_TRABAJADOR;
                $documento->TIPO                        =   'CREO CONTRATO';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $ordencompra->COD_DOCUMENTO_CTBLE;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'SUBIO DOCUMENTOS';
                $documento->MENSAJE                     =   '';
                $documento->save();


                $fedocumento_w       =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
                //LE LLEGA AL USUARIO DE CONTACTO
                $trabajador         =   STDTrabajador::where('COD_TRAB','=',$contacto->COD_TRABAJADOR)->first();
                $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                $mensaje            =   'COMPROBANTE : '.$fedocumento->ID_DOCUMENTO
                                        .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                        .'PROVEEDOR : '.$ordencompra->TXT_EMPR_EMISOR.'%0D%0A'
                                        .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';
                //dd($trabajador);                        
                if(1==0){
                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                }else{
                    $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                    $this->insertar_whatsaap('51914693880','JOSE CHERO',$mensaje,'');

                }                       

                DB::commit();

            }catch(\Exception $ex){
                DB::rollback(); 
                //dd($ex);
                return Redirect::to('detalle-comprobante-contrato-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

            return Redirect::to('gestion-de-transporte-carga/'.$idopcion)->with('bienhecho', 'Se valido el xml correctamente');

        }
    }


}
