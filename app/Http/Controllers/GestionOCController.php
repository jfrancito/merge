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
use App\Modelos\CMPOrden;
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

use ZipArchive;
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
                $procedencia       =   $request['procedencia'];
                
                $fedocumento       =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();


                /**************************** VALIDAR CDR Y LEER RESPUESTA ******************************/
                $filescdr          =   $request['DCC0000000000004'];
                if(!is_null($filescdr)){
                    //CDR
                    foreach($filescdr as $file){

                        $larchivos       =      Archivo::get();
                        $zip = new ZipArchive;
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      $file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;
                        // Copia el archivo .zip a la carpeta compartida
                        copy($file->getRealPath(),$rutacompleta);
                        $rutacompletaxml =      $rutafile.'\\';
                        // Abre el archivo .zip
                        if ($zip->open($file->getPathname()) === TRUE) {
                            // Extrae cada archivo del .zip
                            for ($i = 0; $i < $zip->numFiles; $i++) {
                                $filename = $zip->getNameIndex($i);
                                $fileInfo = pathinfo($filename);

                                // Verifica si el archivo es un archivo regular
                                if ($fileInfo['filename'] != '.' && $fileInfo['filename'] != '..') {
                                    // Extrae el archivo a la carpeta compartida
                                    $extractedFile = $rutacompletaxml.$fileInfo['basename'];
                                    copy("zip://" . $file->getPathname() . "#$filename", $extractedFile);
                                }
                            }
                            // Cierra el archivo .zip
                            $zip->close();
                        } else {
                            DB::rollback(); 
                            return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'No se pudo abrir el archivo .zip');
                        }
                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();
                    }
                }
                $codigocdr = '';
                $respuestacdr = '';
                $factura_cdr_id = '';
                $sw = 0;
                $nombre_doc = $fedocumento->SERIE.'-'.$fedocumento->NUMERO;


                if (file_exists($extractedFile)) {
                    $xml = simplexml_load_file($extractedFile);
                    foreach($xml->xpath('//cbc:ResponseCode') as $ResponseCode)
                    {
                        $codigocdr  = $ResponseCode;
                    }
                    foreach($xml->xpath('//cbc:Description') as $Description)
                    {
                        $respuestacdr  = $Description;
                    }
                    foreach($xml->xpath('//cbc:ID') as $ID)
                    {
                        $factura_cdr_id  = $ID;
                        if($factura_cdr_id == $nombre_doc){
                            $sw = 1;
                        }
                    }
                    //DD($codigocdr);
                } else {
                    return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Error al intentar descomprimir el CDR');
                }

                if($sw == 0){
                    return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') no coincide con la factura ('.$nombre_doc.')');
                }

                //dd("si conicide");


                /************************************************************************/


                $tarchivos         =    CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                        ->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                        ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                        ->get();


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
                        foreach($filescdm as $file){

                            $larchivos       =      Archivo::get();
                            $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
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
                            $dcontrol->ID_DOCUMENTO         =   $ordencompra->COD_ORDEN;
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
                    }else{
                        return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo .ZIP a Importar ');
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
                                    'COD_ESTADO'=>'ETM0000000000002',
                                    'TXT_ESTADO'=>'POR APROBAR USUARIO CONTACTO',
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

                $ordencompra_t                          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $ordencompra->COD_ORDEN;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   date_format(date_create($ordencompra_t->FEC_USUARIO_CREA_AUD), 'Ymd h:i:s');
                $documento->USUARIO_ID                  =   $contacto->COD_TRABAJADOR;
                $documento->USUARIO_NOMBRE              =   $contacto->NOM_TRABAJADOR;
                $documento->TIPO                        =   'CREO ORDEN COMPRA';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $ordencompra->COD_ORDEN;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'SUBIO DOCUMENTOS';
                $documento->MENSAJE                     =   '';
                $documento->save();


                //LE LLEGA AL USUARIO DE CONTACTO
                $trabajador         =   STDTrabajador::where('COD_TRAB','=',$contacto->COD_TRABAJADOR)->first();
                $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                $mensaje            =   'COMPROBANTE : '.$fedocumento->ID_DOCUMENTO
                                        .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                        .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                                        .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A';
                //dd($trabajador);                        
                if($_ENV['APP_PRODUCCION']==0){
                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                }else{
                    $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');          
                }                       

                DB::commit();

            }catch(\Exception $ex){
                DB::rollback(); 

                //dd($ex);
                return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
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
        $procedencia    =   'PRO';
        //dd($listadatos);
        //dd($listadatos);
        return View::make('comprobante/listaoc',
                         [
                            'listadatos'        =>  $listadatos,
                            'procedencia'       =>  $procedencia,

                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }


    public function actionListarOCAdmin($idopcion)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Gestion Ordenes de Compra');

        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $listadatos     =   $this->con_lista_cabecera_comprobante_administrativo($cod_empresa);
        $funcion        =   $this;
        $procedencia    =   'ADM';

        //dd($listadatos);

        //dd($_ENV['APP_PRODUCCION']);

        return View::make('comprobante/listaoc',
                         [
                            'listadatos'        =>  $listadatos,
                            'procedencia'       =>  $procedencia,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }




    public function actionDetalleComprobanteOC($procedencia,$idopcion, $prefijo, $idordencompra, Request $request) {

        View::share('titulo','REGISTRO DE COMPROBANTE');
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();

        if(count($fedocumento)>0){
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
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

        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                    ->where('IND_OBLIGATORIO','=',1)
                                    ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                    ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                    ->get();

        $funcion                =   $this;

        return View::make('comprobante/registrocomprobante',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'procedencia'           =>  $procedencia,

                            'tp'                    =>  $tp,
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tarchivos'             =>  $tarchivos,
                            'usuario'               =>  $usuario,
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

        $procedencia            =   $request['procedencia'];

        //dd("hola");


        if($_POST)
        {
            if (!empty($file)) 
            {
                try{    

                        DB::beginTransaction();
                        $ordencompra_t        =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
                        $fedocumento_t          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();

                        //dd($fedocumento_t);

                        if(count($fedocumento_t)>0){
                            DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                        }





                        // /****************************************  COPIAR EL XML .ZIP EN LA CARPETA COMPARTIDA  *********************************/
                        // $extension = $file->getClientOriginalExtension();
                        // if(strtoupper($extension) == 'ZIP'){
                        //     // Crea una instancia de ZipArchive

                        //     $larchivos       =      Archivo::get();

                        //     $zip = new ZipArchive;
                        //     $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        //     $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        //     $nombrefile      =      count($larchivos).'-'.$file->getClientOriginalName();
                        //     $valor           =      $this->versicarpetanoexiste($rutafile);
                        //     $rutacompleta    =      $rutafile.'\\'.$nombrefile;
                        //     // Copia el archivo .zip a la carpeta compartida
                        //     copy($file->getRealPath(),$rutacompleta);
                        //     $rutacompletaxml =      $rutafile.'\\';
                        //     // Abre el archivo .zip
                        //     if ($zip->open($file->getPathname()) === TRUE) {
                        //         // Extrae cada archivo del .zip
                        //         for ($i = 0; $i < $zip->numFiles; $i++) {
                        //             $filename = $zip->getNameIndex($i);
                        //             $fileInfo = pathinfo($filename);

                        //             // Verifica si el archivo es un archivo regular
                        //             if ($fileInfo['filename'] != '.' && $fileInfo['filename'] != '..') {
                        //                 // Extrae el archivo a la carpeta compartida
                        //                 $extractedFile = $rutacompletaxml.$fileInfo['basename'];
                        //                 copy("zip://" . $file->getPathname() . "#$filename", $extractedFile);
                        //             }
                        //         }
                        //         // Cierra el archivo .zip
                        //         $zip->close();
                        //     } else {
                        //         DB::rollback(); 
                        //         return Redirect::to('detalle-comprobante-oc/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'No se pudo abrir el archivo .zip');
                        //     }

                        //     $nombreoriginal             =   $file->getClientOriginalName();
                        //     $info                       =   new SplFileInfo($nombreoriginal);
                        //     $extension                  =   $info->getExtension();

                        // }

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
                        /****************************************  LEER EL XML Y GUARDAR   *********************************/
                        $parser = new InvoiceParser();
                        $xml = file_get_contents($path);
                        $factura = $parser->parse($xml);

                        //dd($factura);
                        /****************************************  DIAS DE CREDITO *****************************************/
                        $diasdefactura = 0;
                        $tp = CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
                        if( $tp->CODIGO_SUNAT == 'CRE' ){
                            $datetime1 = date_create($factura->getfechaEmision()->format('Ymd'));
                            $datetime2 = date_create($factura->getfecVencimiento()->format('Ymd'));
                            $contador = date_diff($datetime1, $datetime2);
                            $differenceFormat = '%a';
                            $diasdefactura = $contador->format($differenceFormat);
                        }

                        //DD($factura);

                        $documentolinea                     =   $this->ge_linea_documento($ordencompra->COD_ORDEN);

                        //dd($documentolinea);

                        //REGISTRO DEL XML LEIDO
                        $documento                          =   new FeDocumento;
                        $documento->ID_DOCUMENTO            =   $ordencompra->COD_ORDEN;
                        $documento->DOCUMENTO_ITEM          =   $documentolinea;

                        $documento->COD_EMPR                =   $ordencompra->COD_EMPR;
                        $documento->TXT_EMPR                =   $ordencompra->NOM_EMPR;
                        $documento->TXT_PROCEDENCIA         =   $procedencia;
                        $documento->ESTADO                  =   'A';
                        $documento->RUC_PROVEEDOR           =   $factura->getcompany()->getruc();
                        $documento->RZ_PROVEEDOR            =   $factura->getcompany()->getrazonSocial();

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
                        $documento->FORMA_PAGO_DIAS          =   $diasdefactura;

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

                        $documento->COD_ESTADO              =   '';
                        $documento->TXT_ESTADO              =   '';

                        $documento->ind_email_uc            =   -1;
                        $documento->ind_email_ap            =   -1;
                        $documento->ind_email_adm           =   -1;
                        $documento->ind_email_ba            =   -1;
                        $documento->ind_email_clap          =   -1;

                        $documento->save();


                        //ARCHIVO
                        $dcontrol                   =   new Archivo;
                        $dcontrol->ID_DOCUMENTO     =   $ordencompra->COD_ORDEN;
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


                                $linea = str_pad($indexdet+1, 3, "0", STR_PAD_LEFT); 
                                $detalle                        =   new FeDetalleDocumento;
                                $detalle->ID_DOCUMENTO          =   $ordencompra->COD_ORDEN;
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
                                $forma->ID_DOCUMENTO            =   $ordencompra->COD_ORDEN;
                                $forma->DOCUMENTO_ITEM          =   $documentolinea;
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

                        $fedocumento         =      FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','<>','ETM0000000000006')->first();
                        $fechaemision        =      date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

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
                    return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
                }
                return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Se valido el xml');
            }else{
                return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo XML a Importar ');
            }

        }
    }
    

}
