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

class GestionOCController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;

   public function actionValidarXML($idopcion, $prefijo, $idordencompra,Request $request)
    {

        $file                   =   $request['inputxml'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $contacto_id       =   $request['contacto_id'];
                $filescdm          =   $request['cdm'];
                if(!is_null($filescdm)){
                    //CDR
                    foreach($filescdm as $file){

                        $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                        copy($file->getRealPath(),$rutacompleta);
                        $path            =      $rutacompleta;
                        //dd($nombre);
                    }
                }else{
                    return Redirect::to('detalle-comprobante-oc/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo XML a Importar ');
                }

                $filespdf          =   $request['pdf'];
                if(!is_null($filespdf)){
                    //CDR
                    foreach($filespdf as $file){

                        $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefilepdf;
                        copy($file->getRealPath(),$rutacompleta);
                        $path            =      $rutacompleta;
                        //dd($nombre);
                    }
                }else{
                    return Redirect::to('detalle-comprobante-oc/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo XML a Importar ');
                }

                $contacto                             =   User::where('id','=',$contacto_id)->first();
                $fedocumento                          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();

                $fedocumento->ARCHIVO_CDR             =   $nombrefilecdr;
                $fedocumento->ARCHIVO_PDF             =   $nombrefilepdf;
                $fedocumento->COD_ESTADO              =   'ETM0000000000002';
                $fedocumento->TXT_ESTADO              =   'PENDIENTE DE APROBAR';
                $fedocumento->COD_CONTACTO            =   $contacto->id;
                $fedocumento->ind_email_uc            =   0;
                $fedocumento->TXT_CONTACTO            =   $contacto->nombre;
                $fedocumento->fecha_pa                =   $this->fechaactual;
                $fedocumento->usuario_pa              =   Session::get('usuario')->id;
                $fedocumento->save();

                //LE LLEGA AL USUARIO DE CONTACTO
                $mensaje            =   'COMPROBANTE : '.$fedocumento->ID_DOCUMENTO.'%0D%0A'.'Proveedor : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'.'Estado : '.$fedocumento->TXT_ESTADO.'%0D%0A';
                $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');

                DB::commit();

            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('detalle-comprobante-oc/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

            return Redirect::to('gestion-de-oc-proveedores/'.$idopcion)->with('bienhecho', 'Se valido el xml correctamente');

        }
    }
   


    public function actionListarOC($idopcion)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Ordenes de Compra');

        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $listadatos     =   $this->con_lista_cabecera_comprobante($cod_empresa);
        $funcion        =   $this;

        //dd($listadatos);

        return View::make('comprobante/listaoc',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }


    public function actionDetalleComprobanteOC($idopcion, $prefijo, $idordencompra, Request $request) {

        View::share('titulo','REGISTRO DE COMPROBANTE');
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();
        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);
        $xmlarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'xml';


        $contacto               =   DB::table('users')->where('ind_contacto','=',1)->pluck('nombre','id')->toArray();
        $combocontacto          =   array('' => "Seleccione Contacto") + $contacto;

        $funcion                =   $this;

        return View::make('comprobante/registrocomprobante',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'xmlarchivo'            =>  $xmlarchivo,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }


   public function actionCargarXML($idopcion, $prefijo, $idordencompra,Request $request)
    {

        $file                   =   $request['inputxml'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);

        if($_POST)
        {
            if (!empty($file)) 
            {
                try{    
                        DB::beginTransaction();

                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      $file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;
                        copy($file->getRealPath(),$rutacompleta);
                        $path            =   $rutacompleta;


                        /****************************************  LEER EL XML Y GUARDAR   *********************************/
                        $parser = new InvoiceParser();
                        $xml = file_get_contents($path);
                        $factura = $parser->parse($xml);


                        DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->delete();
                        DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->delete();
                        DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->delete();


                        //REGISTRO DEL XML LEIDO
                        $documento                          =   new FeDocumento;
                        $documento->ID_DOCUMENTO            =   $ordencompra->COD_ORDEN;
                        $documento->ESTADO                  =   'A';
                        $documento->RUC_PROVEEDOR           =   $factura->getcompany()->getruc();

                        $documento->TIPO_CLIENTE            =   $factura->getClient()->gettipoDoc();
                        $documento->ID_CLIENTE              =   $factura->getClient()->getnumDoc();
                        $documento->NOMBRE_CLIENTE          =   $factura->getClient()->getrznSocial();
                        $documento->DIRECCION_CLIENTE       =   '';
                        $documento->SERIE                   =   $factura->getserie();
                        $documento->NUMERO                  =   $factura->getcorrelativo();
                        $documento->ID_TIPO_DOC             =   $factura->gettipoDoc();
                        $documento->FEC_VENTA               =   $factura->getfechaEmision()->format('Ymd');
                        $documento->FEC_VENCI_PAGO          =   $factura->getfecVencimiento()->format('Ymd');
                        $documento->FORMA_PAGO              =   $factura->getcondicionPago();
                        $documento->MONEDA                  =   $factura->gettipoMoneda();
                        $documento->VALOR_IGV_ORIG          =   $factura->getmtoIGV();
                        $documento->VALOR_IGV_SOLES         =   $factura->getmtoIGV();

                        $documento->SUB_TOTAL_VENTA_ORIG    =   $factura->getmtoOperGravadas();
                        $documento->SUB_TOTAL_VENTA_SOLES   =   $factura->getmtoOperGravadas();

                        $documento->TOTAL_VENTA_ORIG        =   $factura->getmtoImpVenta();
                        $documento->TOTAL_VENTA_SOLES       =   $factura->getmtoImpVenta();

                        $documento->HORA_EMISION            =   $factura->gethoraEmision();
                        $documento->IMPUESTO_2              =   $factura->getmtoOtrosTributos();
                        $documento->TIPO_DETRACCION         =   $factura->getdetraccion()->gettipoDet();
                        $documento->PORC_DETRACCION         =   $factura->getdetraccion()->getporcDet();
                        $documento->MONTO_DETRACCION        =   $factura->getdetraccion()->getbaseDetr();
                        $documento->MONTO_ANTICIPO          =   $factura->getdestotalAnticipos();
                        $documento->OBSERVACION             =   $factura->getobservacion();
                        $documento->NRO_ORDEN_COMP          =   $factura->getcompra();              
                        $documento->NUM_GUIA                =   $factura->getguiaEmbebida();
                        $documento->estadoCp                =   0;
                        $documento->ARCHIVO_XML             =   $nombrefile;
                        $documento->ARCHIVO_CDR             =   '';
                        $documento->ARCHIVO_PDF             =   '';
                        $documento->COD_CONTACTO            =   '';
                        $documento->TXT_CONTACTO            =   '';

                        $documento->ind_email_uc            =   -1;
                        $documento->ind_email_ap            =   -1;
                        $documento->ind_email_adm           =   -1;
                        $documento->ind_email_ba            =   -1;
                        $documento->ind_email_clap          =   -1;

                        $documento->save();


                        /**********DETALLE*********/
                        foreach ($factura->getdetails() as $indexdet => $itemdet) {

                                $producto                           = str_replace("<![CDATA[","",$itemdet->getdescripcion());
                                $producto                           = str_replace("]]>","",$producto);


                                $linea = str_pad($indexdet+1, 3, "0", STR_PAD_LEFT); 
                                $detalle                        =   new FeDetalleDocumento;
                                $detalle->ID_DOCUMENTO          =   $ordencompra->COD_ORDEN;
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
                                $forma->ID_DOCUMENTO            =   $ordencompra->COD_ORDEN;
                                $forma->ID_CUOTA                =   $itemfor->getnumCuota();
                                $forma->ID_MONEDA               =   $itemfor->getmoneda();
                                $forma->MONTO_CUOTA             =   (float)$itemfor->getmonto();
                                $forma->FECHA_PAGO              =   $fechapago;
                                $forma->save();

                        }

                        /****************************************  VALIDAR SI EL ARCHIVO ESTA ACEPTADO POR SUNAT  *********************************/
                        $token = '';
                        if($prefijocarperta =='II'){
                            $token           =      $this->generartoken_ii();
                        }else{
                            $token           =      $this->generartoken_is();
                        }

                        $fedocumento         =      FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->first();
                        $fechaemision        =      date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->get();

                        //VALIDAR QUE ALGUNOS CAMPOS SEAN IGUALES
                        $this->con_validar_documento($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento);

                        //dd($fechaemision);
                        $rvalidar = $this->validar_xml( $token,
                                                        $fedocumento->ID_CLIENTE,
                                                        $fedocumento->RUC_PROVEEDOR,
                                                        $fedocumento->ID_TIPO_DOC,
                                                        $fedocumento->SERIE,
                                                        $fedocumento->NUMERO,
                                                        $fechaemision,
                                                        $fedocumento->TOTAL_VENTA_ORIG);
                        $arvalidar = json_decode($rvalidar, true);

                        if(isset($arvalidar['success'])){

                            if($arvalidar['success']){

                                $datares              = $arvalidar['data'];
                                $estadoCp             = $datares['estadoCp'];
                                $tablaestacp          = Estado::where('tipo','=','estadoCp')->where('codigo','=',$estadoCp)->first();

                                $estadoRuc            = '';
                                $txtestadoRuc         = '';
                                $estadoDomiRuc        = '';
                                $txtestadoDomiRuc     = '';

                                if(isset($datares['estadoRuc'])){
                                    $tablaestaruc          = Estado::where('tipo','=','estadoRuc')->where('codigo','=',$datares['estadoRuc'])->first();
                                    $estadoRuc             = $tablaestaruc->codigo;
                                    $txtestadoRuc          = $tablaestaruc->nombre;
                                }
                                if(isset($datares['condDomiRuc'])){
                                    $tablaestaDomiRuc       = Estado::where('tipo','=','condDomiRuc')->where('codigo','=',$datares['condDomiRuc'])->first();
                                    $estadoDomiRuc          = $tablaestaDomiRuc->codigo;
                                    $txtestadoDomiRuc       = $tablaestaDomiRuc->nombre;
                                }

                                FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
                                            ->update(
                                                    [
                                                        'success'=>$arvalidar['success'],
                                                        'message'=>$arvalidar['message'],
                                                        'estadoCp'=>$tablaestacp->codigo,
                                                        'nestadoCp'=>$tablaestacp->nombre,
                                                        'estadoRuc'=>$estadoRuc,
                                                        'nestadoRuc'=>$txtestadoRuc,
                                                        'condDomiRuc'=>$estadoDomiRuc,
                                                        'ncondDomiRuc'=>$txtestadoDomiRuc,
                                                    ]);
                            }else{
                                FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
                                            ->update(
                                                    [
                                                        'success'=>$arvalidar['success'],
                                                        'message'=>$arvalidar['message']
                                                    ]);
                            }
                        }

                        //dd($rvalidar);
                        DB::commit();

                }catch(\Exception $ex){
                    DB::rollback(); 
                    return Redirect::to('detalle-comprobante-oc/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
                }
                return Redirect::to('detalle-comprobante-oc/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Se valido el xml');
            }else{
                return Redirect::to('detalle-comprobante-oc/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo XML a Importar ');
            }

        }
    }
    

}
