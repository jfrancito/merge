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
use App\Modelos\TESAutorizacion;
use App\Modelos\TESCuentaBancaria;
use App\Modelos\CMPReferecenciaAsoc;
use App\Modelos\WEBRol;





use App\Modelos\CMPOrden;
use Greenter\Parser\DocumentParserInterface;
use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;
use Greenter\Xml\Parser\PerceptionParser;
use Greenter\Xml\Parser\RHParser;
use Greenter\Xml\Parser\RetentionParser;
use Greenter\Xml\Parser\LiquiParser;
use Greenter\Xml\Parser\DespatchParser;


use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
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
use DateTime;
use Carbon\Carbon;
class GestionOCController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;

    public function actionSunatCDR()
    {
        $this->sunat_cdr();
    }


    public function actionAjaxBuscarCuentaBancariaOC(Request $request)
    {


        $entidadbanco_id        =   $request['entidadbanco_id'];
        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($orden_id,$prefijo_id);
        $ordencompra            =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);



        $tescuentabb            =   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$ordencompra->COD_EMPR_CLIENTE)
                                    ->where('COD_EMPR_BANCO','=',$entidadbanco_id)
                                    ->where('COD_ESTADO','=',1)
                                    ->select(DB::raw("
                                          TXT_NRO_CUENTA_BANCARIA,
                                          TXT_REFERENCIA + ' - '+ TXT_NRO_CUENTA_BANCARIA AS nombre")
                                        )
                                    ->pluck('nombre','TXT_NRO_CUENTA_BANCARIA')
                                    ->toArray();

        $combocb                =   array('' => "Seleccione Cuenta Bancaria") + $tescuentabb;
        $funcion                =   $this;

        return View::make('comprobante/combo/combo_cuenta_bancaria',
                         [
                            'combocb'                   =>  $combocb,
                            'entidadbanco_id'           =>  $entidadbanco_id,
                            'empresa_cliente_id'        =>  $ordencompra->COD_EMPR_CLIENTE,
                            'ajax'                      =>  true,
                         ]);
    }

    public function actionAjaxBuscarCuentaBancariaLiquidacionCompraAnticipo(Request $request)
    {


        $entidadbanco_id        =   $request['entidadbanco_id'];
        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($orden_id,$prefijo_id);
        $ordencompra            =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();

        $tescuentabb            =   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$ordencompra->COD_EMPR_EMISOR)
                                    ->where('COD_EMPR_BANCO','=',$entidadbanco_id)
                                    ->where('COD_ESTADO','=',1)
                                    ->select(DB::raw("
                                          TXT_NRO_CUENTA_BANCARIA,
                                          TXT_REFERENCIA + ' - '+ TXT_NRO_CUENTA_BANCARIA AS nombre")
                                        )
                                    ->pluck('nombre','TXT_NRO_CUENTA_BANCARIA')
                                    ->toArray();

        $combocb                =   array('' => "Seleccione Cuenta Bancaria") + $tescuentabb;
        $funcion                =   $this;

        return View::make('comprobante/combo/combo_cuenta_bancaria',
                         [
                            'combocb'                   =>  $combocb,
                            'entidadbanco_id'           =>  $entidadbanco_id,
                            'empresa_cliente_id'        =>  $ordencompra->COD_EMPR_CLIENTE,
                            'ajax'                      =>  true,
                         ]);
    }

    public function actionAjaxBuscarCuentaBancariaContrato(Request $request)
    {


        $entidadbanco_id        =   $request['entidadbanco_id'];
        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($orden_id,$prefijo_id);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $tescuentabb            =   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$ordencompra->COD_EMPR_EMISOR)
                                    ->where('COD_EMPR_BANCO','=',$entidadbanco_id)
                                    ->where('COD_ESTADO','=',1)
                                    ->select(DB::raw("
                                          TXT_NRO_CUENTA_BANCARIA,
                                          TXT_REFERENCIA + ' - '+ TXT_NRO_CUENTA_BANCARIA AS nombre")
                                        )
                                    ->pluck('nombre','TXT_NRO_CUENTA_BANCARIA')
                                    ->toArray();
        $combocb                =   array('' => "Seleccione Cuenta Bancaria") + $tescuentabb;
        $funcion                =   $this;

        return View::make('comprobante/combo/combo_cuenta_bancaria',
                         [
                            'combocb'                   =>  $combocb,
                            'ajax'                      =>  true,
                         ]);
    }


    public function actionAjaxBuscarCuentaBancariaPg(Request $request)
    {


        $entidadbanco_id        =   $request['entidadbanco_id'];
        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($orden_id,$prefijo_id);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_pg_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_pg_comprobante_idoc($idoc);


        $tescuentabb            =   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$ordencompra->COD_EMPR_EMISOR)
                                    ->where('COD_EMPR_BANCO','=',$entidadbanco_id)
                                    ->where('COD_ESTADO','=',1)
                                    ->select(DB::raw("
                                          TXT_NRO_CUENTA_BANCARIA,
                                          TXT_REFERENCIA + ' - '+ TXT_NRO_CUENTA_BANCARIA AS nombre")
                                        )
                                    ->pluck('nombre','TXT_NRO_CUENTA_BANCARIA')
                                    ->toArray();
        $combocb                =   array('' => "Seleccione Cuenta Bancaria") + $tescuentabb;
        $funcion                =   $this;

        return View::make('comprobante/combo/combo_cuenta_bancaria',
                         [
                            'combocb'                   =>  $combocb,
                            'ajax'                      =>  true,
                         ]);
    }


    public function actionAjaxMonedaAjaxCuenta(Request $request)
    {

        $txt_moneda                          =   '';
        $data_entidadbanco_id                =   $request['data_entidadbanco_id'];
        $data_empresa_cliente_id             =   $request['data_empresa_cliente_id'];
        $cb_id                               =   $request['cb_id'];

        $tescuentabb                         =   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$data_empresa_cliente_id)
                                                ->where('COD_EMPR_BANCO','=',$data_entidadbanco_id)
                                                ->where('TXT_NRO_CUENTA_BANCARIA','=',$cb_id)
                                                ->where('COD_ESTADO','=',1)
                                                ->first();
        if(count($tescuentabb)>0){
            $txt_moneda                      =   $tescuentabb->TXT_CATEGORIA_MONEDA;  
        }

        print_r($txt_moneda);

    }



   public function actionAjaxBuscarCuentaBancariaEstiba(Request $request)
    {


        $entidadbanco_id        =   $request['entidadbanco_id'];
        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $empresa_id             =   $request['empresa_id'];
        $idoc                   =   $orden_id;
        $documento              =   DB::table('FE_DOCUMENTO')
                                    ->where('ID_DOCUMENTO', $idoc)
                                    ->first();

        $empresa                =   DB::table('STD.EMPRESA')
                                    ->where('NRO_DOCUMENTO', $documento->RUC_PROVEEDOR)
                                    ->where('COD_ESTADO', 1)
                                    ->first();


        $tescuentabb            =   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$empresa->COD_EMPR)
                                    ->where('COD_EMPR_BANCO','=',$entidadbanco_id)
                                    ->where('COD_ESTADO','=',1)
                                    ->select(DB::raw("
                                          TXT_NRO_CUENTA_BANCARIA,
                                          TXT_REFERENCIA + ' - '+ TXT_NRO_CUENTA_BANCARIA AS nombre")
                                        )
                                    ->pluck('nombre','TXT_NRO_CUENTA_BANCARIA')
                                    ->toArray();


        $combocb                =   array('' => "Seleccione Cuenta Bancaria") + $tescuentabb;
        $funcion                =   $this;

        return View::make('comprobante/combo/combo_cuenta_bancaria',
                         [
                            'combocb'                   =>  $combocb,
                            'ajax'                      =>  true,
                         ]);
    }



    public function actionModalHistorialExtorno(Request $request)
    {

        $data_cod_extorno       =   $request['data_cod_extorno'];
        $idopcion               =   $request['idopcion'];
        $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$data_cod_extorno)
                                    ->orderBy('FECHA','DESC')
                                    ->get();

        $funcion        =   $this;
        return View::make('comprobante/modal/ajax/mhextorno',
                         [
                            'documentohistorial'        =>  $documentohistorial,
                            'data_cod_extorno'          =>  $data_cod_extorno,
                            'idopcion'                  =>  $idopcion,
                            'ajax'                      =>  true,
                         ]);
    }



    public function actionApiLeerXmlSap(Request $request)
    {


        header('Content-Type: text/html; charset=UTF-8');
        //$path = storage_path() . "/exports/FC26-00002985.XML";
        $path = storage_path() . "/exports/20602740278-04-E001-15252.xml";
        $parser = new InvoiceParser();
        $xml = file_get_contents($path);
        $factura = $parser->parse($xml);
        dd($factura);

    }

    public function actionApiLeerXmlSapLiqui(Request $request)
    {

        header('Content-Type: text/html; charset=UTF-8');
        //$path = storage_path() . "/exports/FC26-00002985.XML";
        $path = storage_path() . "/exports/20602740278-04-E001-15252.xml";
        $parser = new LiquiParser();
        $xml = file_get_contents($path);
        $factura = $parser->parse($xml);
        dd($factura);

    }
    public function actionApiLeerXmlSapGuia(Request $request)
    {

        header('Content-Type: text/html; charset=UTF-8');
        //$path = storage_path() . "/exports/FC26-00002985.XML";
        $path = storage_path() . "/exports/20481402892-31-EG03-63013.xml";
        $parser = new DespatchParser();
        $xml = file_get_contents($path);
        $factura = $parser->parse($xml);
        dd($factura);

    }

    public function actionApiLeerXmlSapNC(Request $request)
    {

        header('Content-Type: text/html; charset=UTF-8');
        //$path = storage_path() . "/exports/FC26-00002985.XML";
        $path = storage_path() . "/exports/20479729141-07-F006-00000165.xml";
        $parser = new NoteParser();
        $xml = file_get_contents($path);
        $factura = $parser->parse($xml);
        dd($factura);

    }


    public function actionApiLeerRHSap(Request $request)
    {

        header('Content-Type: text/html; charset=UTF-8');
        $path = storage_path() . "/exports/IICHAU0000011936.xml";
        //$path = storage_path() . "/exports/RHE1044061449953.xml";

        $parser = new RHParser();
        $xml = file_get_contents($path);
        $factura = $parser->parse($xml);
        dd($factura);

    }


        public function actionApiLeerRetencionSap(Request $request)
    {

        header('Content-Type: text/html; charset=UTF-8');
        $path = storage_path() . "/exports/20484002216-20-E001-2942.xml";
        //$path = storage_path() . "/exports/RHE1044061449953.xml";

        $parser = new RetentionParser();
        $xml = file_get_contents($path);
        $factura = $parser->parse($xml);
        dd($factura);

    }



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

                $codigocdr = '';
                $respuestacdr = '';
                $factura_cdr_id = '';
                $sw = 0;


                $nombre_doc      = $fedocumento->SERIE.'-'.$fedocumento->NUMERO;


                $numerototal     = $fedocumento->NUMERO;
                $numerototalsc    = ltrim($numerototal, '0');
                $nombre_doc_sinceros = $fedocumento->SERIE.'-'.$numerototalsc;


                if(!is_null($filescdr)){
                    //CDR
                    foreach($filescdr as $file){

                        //
                        $contadorArchivos = Archivo::count();
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


                    if (file_exists($extractedFile)) {

                        //cbc
                        $xml = simplexml_load_file($extractedFile);
                        $cbc = 0;
                        $namespaces = $xml->getNamespaces(true);
                        foreach ($namespaces as $prefix => $namespace) {
                            if('cbc'==$prefix){
                                $cbc = 1;  
                            }
                        }
                        
                        if($cbc>=1){
                            foreach($xml->xpath('//cbc:ResponseCode') as $ResponseCode)
                            {
                                $codigocdr  = (string)$ResponseCode;
                            }
                            foreach($xml->xpath('//cbc:Description') as $Description)
                            {
                                $respuestacdr  = $Description;
                            }
                            foreach($xml->xpath('//cbc:ID') as $ID)
                            {
                                $factura_cdr_id  = $ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }  
                        }else{

                            $xml_ns = simplexml_load_file($extractedFile);

                            // Namespace definitions
                            $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                            $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                            // Register namespaces
                            $xml_ns->registerXPathNamespace('ns4', $ns4);
                            $xml_ns->registerXPathNamespace('ns3', $ns3);
                            // Querying XML
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
                            {
                                $codigocdr  = (string)$ResponseCodes->ResponseCode;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
                            {
                                $respuestacdr  = $Description->Description;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentReference') as $ID)
                            {
                                $factura_cdr_id  = $ID->ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }

                        }

                        if($codigocdr!="0"){
                            return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Error de CDR');
                        }
                        //DD($codigocdr);
                    } else {
                        return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Error al intentar descomprimir el CDR');
                    }
                    
                    if($sw == 0){
                        return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') no coincide con la factura ('.$nombre_doc.')');
                    }

                    if (strpos($respuestacdr, 'observaciones') !== false) {
                        return Redirect::to('detalle-comprobante-oc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') tiene observaciones');
                    }

                }

                //dd("si conicide");
                /************************************************************************/
                $tiposerie              =   substr($fedocumento->SERIE, 0, 1);



                if($tiposerie == 'E'){
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                //->where('IND_OBLIGATORIO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                                ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                                ->get();
                //dd($tarchivos);

                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                //->where('IND_OBLIGATORIO','=',1)
                                                ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                                ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                                ->get();
                }


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
                        foreach($filescdm as $file){

                            //
                            $contadorArchivos = Archivo::count();
                            $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
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


                $ordencompra_tt                            =   CMPOrden::where('COD_ORDEN','=',$fedocumento->ID_DOCUMENTO)->first();
                $trabajador = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $ordencompra_tt->COD_TRABAJADOR_ENCARGADO)->first();
                $trabajadorcorreo = DB::table('WEB.ListaplatrabajadoresGenereal')->where('dni','=',$trabajador->NRO_DOCUMENTO)->first();

                if(count($trabajadorcorreo)>0){
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $ordencompra_tt->COD_ORDEN;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   date_format(date_create($ordencompra_tt->FEC_USUARIO_CREA_AUD), 'Ymd h:i:s');
                    $documento->USUARIO_ID                  =   $trabajadorcorreo->COD_TRAB;
                    $documento->USUARIO_NOMBRE              =   $trabajadorcorreo->apellidopaterno.' '.$trabajadorcorreo->apellidomaterno.' '.$trabajadorcorreo->nombres;;
                    $documento->TIPO                        =   'APRUEBA EN OSIRIS';
                    $documento->MENSAJE                     =   '';
                    $documento->save();
                }

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


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO DOCUMENTOS');
                //geolocalizacion

                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('COD_TRAB','=',$contacto->COD_TRABAJADOR)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE : '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A';
                // //dd($trabajador);                        
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                //     //$this->insertar_whatsaap('51914693880','JOSE CHERO',$mensaje,'');

                // }                       

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
        return View::make('comprobante/listaocproveedores',
                         [
                            'listadatos'        =>  $listadatos,
                            'procedencia'       =>  $procedencia,

                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }




    public function actionListarOCAdminMR($idopcion)
    {

        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC SCS_MERGE_PORTAL_RJ');
        $stmt->execute();

        return Redirect::to('gestion-de-orden-compra/'.$idopcion);

    }


    public function actionListarOCAdminMB($idopcion)
    {

        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC SCS_MERGE_PORTAL_BE');
        $stmt->execute();
        return Redirect::to('gestion-de-orden-compra/'.$idopcion);

    }


    public function actionListarOCAdmin($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Integracion de Comprobante');
        $operacion_id       =   'ORDEN_COMPRA';
        //$operacion_id       =   'DOCUMENTO_INTERNO_PRODUCCION';

        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }

        //$operacion_id       =   'PROVISION_GASTO';
        $combo_operacion    =   array(  'ORDEN_COMPRA' => 'ORDEN COMPRA',
                                        'CONTRATO' => 'CONTRATO',
                                        'ESTIBA' => 'ESTIBA',
                                        'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
                                        'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
                                        'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA',
                                        'DOCUMENTO_INTERNO_COMPRA' => 'DOCUMENTO INTERNO COMPRA',
                                        'LIQUIDACION_COMPRA_ANTICIPO' => 'LIQUIDACION DE COMPRA ANTICIPO',
                                        'PROVISION_GASTO' => 'PROVISION DE GASTOS',
                                        'NOTA_CREDITO' => 'NOTA DE CREDITO',
                                        'NOTA_DEBITO' => 'NOTA DE DEBITO'

                                    );

        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        $procedencia        =   'ADM';
        $funcion            =   $this;
        //AREA
        $estado_id          =   'TODO';        
        $area_id            =   'TODO';

        $combo_area         =    $this->gn_combo_area_usuario($estado_id);
        $rol                =    WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();



        if($rol->ind_uc == 1){
            $usuario    =   SGDUsuario::where('COD_USUARIO','=',Session::get('usuario')->name)->first();
            if(count($usuario)>0){
                $tp_area        =   CMPCategoria::where('COD_CATEGORIA','=',$usuario->COD_CATEGORIA_AREA)->first();
                $area_id        =   $tp_area->COD_CATEGORIA;
                $combo_area     =   array($tp_area->COD_CATEGORIA => $tp_area->NOM_CATEGORIA);
            }
        }

        $fecha_inicio               =   $this->fecha_menos_diez_dias;
        $fecha_fin                  =   $this->fecha_sin_hora;
        $combo_proveedor            =   array();
        $proveedor_id               =   '';

        $array_canjes               =   $this->con_array_canjes();


        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_administrativo($cod_empresa);
        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos         =   $this->con_lista_cabecera_contrato_administrativo($cod_empresa);
            }else{

                if($operacion_id=='PROVISION_GASTO'){
                    $listadatos         =   $this->con_lista_cabecera_provision_gasto_administrativo($cod_empresa);
                }else{
                    if (in_array($operacion_id, $array_canjes)) {
                        $categoria_id       =   $this->con_categoria_canje($operacion_id);
                        if($operacion_id=='DOCUMENTO_INTERNO_COMPRA'){
                            $listadatos         =   $this->con_lista_cabecera_estibas_administrativo_doc_int_com($cod_empresa,$area_id,$fecha_inicio,$fecha_fin,$proveedor_id,$categoria_id);
                        }else{
                            $listadatos         =   $this->con_lista_cabecera_estibas_administrativo($cod_empresa,$area_id,$fecha_inicio,$fecha_fin,$proveedor_id,$categoria_id);
                        }
                    }

                }

            }
        }


        return View::make('comprobante/listaocadministrador',
                         [
                            'listadatos'        =>  $listadatos,
                            'procedencia'       =>  $procedencia,
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin,
                            'area_id'           =>  $area_id,
                            'combo_area'        =>  $combo_area,
                            'combo_proveedor'   =>  $combo_proveedor,
                            'proveedor_id'      =>  $proveedor_id

                         ]);
    }


    public function actionEstibaProveedorEstiba(Request $request) {

        $operacion_id   =   $request['operacion_id'];
        $area_id        =   $request['area_id'];
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $combo_proveedor=   array();
        $proveedor_id   =   "";
        //AREA
        $estado_id          =   'TODO';        
        $area_id            =   'TODO';
        $rol                =    WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();
        if($rol->ind_uc == 1){
            $usuario    =   SGDUsuario::where('COD_USUARIO','=',Session::get('usuario')->name)->first();
            if(count($usuario)>0){
                $tp_area        =   CMPCategoria::where('COD_CATEGORIA','=',$usuario->COD_CATEGORIA_AREA)->first();
                $area_id        =   $tp_area->COD_CATEGORIA;
            }
        }

        $categoria_id   =   $this->con_categoria_canje($operacion_id);
        $combo_proveedor=   $this->con_combo_cabecera_estibas_administrativo($cod_empresa,$area_id,$categoria_id);
        $procedencia    =   'ADM';
        $funcion        =   $this;
        return View::make('comprobante/combo/combo_proveedor',
                         [
                            'operacion_id'          =>  $operacion_id,
                            'combo_proveedor'       =>  $combo_proveedor,
                            'proveedor_id'          =>  $proveedor_id,
                            'ajax'                  =>  true,
                            'funcion'               =>  $funcion
                         ]);
    }



    public function actionListarAjaxBuscarDocumentoAdmin(Request $request) {

        $operacion_id   =   $request['operacion_id'];
        $area_id        =   $request['area_id'];

        $fecha_inicio   =   $request['fecha_inicio'];
        $fecha_fin      =   $request['fecha_fin'];
        $proveedor_id   =   $request['proveedor_id'];


        $idopcion       =   $request['idopcion'];
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        $array_canjes               =   $this->con_array_canjes();

        if ($operacion_id == 'ORDEN_COMPRA') {
            $listadatos = $this->con_lista_cabecera_comprobante_administrativo($cod_empresa);
        } else {
            if ($operacion_id == 'CONTRATO') {
                $listadatos = $this->con_lista_cabecera_contrato_administrativo($cod_empresa);
            } else {

                  
                if($operacion_id=='PROVISION_GASTO'){
                    $listadatos         =   $this->con_lista_cabecera_provision_gasto_administrativo($cod_empresa);
                }
                if ($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO') {                    
                    $listadatos = $this->con_lista_cabecera_liquidacion_compra_anticipo_administrativo($cod_empresa);
                } else {
                    if ($operacion_id == 'NOTA_CREDITO') {                    
                        $listadatos = $this->con_lista_cabecera_nota_credito_administrativo($cod_empresa);
                    } else {
                        if ($operacion_id == 'NOTA_DEBITO') {                    
                            $listadatos = $this->con_lista_cabecera_nota_debito_administrativo($cod_empresa);
                        } else {
                            if (in_array($operacion_id, $array_canjes)) {
                                $categoria_id = $this->con_categoria_canje($operacion_id);

                                if($operacion_id=='DOCUMENTO_INTERNO_COMPRA'){
                                    $listadatos         =   $this->con_lista_cabecera_estibas_administrativo_doc_int_com($cod_empresa,$area_id,$fecha_inicio,$fecha_fin,$proveedor_id,$categoria_id);
                                }else{
                                    $listadatos         =   $this->con_lista_cabecera_estibas_administrativo($cod_empresa,$area_id,$fecha_inicio,$fecha_fin,$proveedor_id,$categoria_id);
                                }                        
                            }

                        }
                    }
                  
                }
            }
        }

        
        $procedencia        =   'ADM';
        $funcion                =   $this;
        return View::make('comprobante/ajax/mergelistaadministrador',
                         [
                            'operacion_id'          =>  $operacion_id,

                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'procedencia'           =>  $procedencia,
                            'ajax'                  =>  true,

                            'funcion'               =>  $funcion
                         ]);
    }





    public function actionListarOCFiltro($idopcion)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Filtro de Comprobante');
        $operacion_id       =   'ORDEN_COMPRA';
        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }
        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO');
        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        $procedencia        =   'ADM';
        $funcion            =   $this;

        $listadatos         =   $this->con_lista_cabecera_comprobante_administrativo_filtro($cod_empresa);

        return View::make('comprobante/listaocfiltro',
                         [
                            'listadatos'        =>  $listadatos,
                            'procedencia'       =>  $procedencia,
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);




    }


    public function actionGuardarOCFiltro(Request $request)
    {

        $ind_mobil                          =   $request['ind_mobil'];
        $producto_id                        =   $request['producto_id'];
        $txt_confirma                       =   '';

        if($ind_mobil=='1'){
            $txt_confirma                   =   Session::get('usuario')->nombre;
        }

        $producto                           =   CMPOrden::where('COD_ORDEN','=',$producto_id)->first();
        $producto->TXT_CONFORMIDAD          =   $txt_confirma;
        $producto->save();

    }


    public function actionDetalleComprobanteOC($procedencia,$idopcion, $prefijo, $idordencompra, Request $request) {


        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        //$ordencompra            =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();


        View::share('titulo','REGISTRO DE COMPROBANTE OC: '.$idoc);




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
        $rhxml                  =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                    //->where('IND_OBLIGATORIO','=',1)
                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                    ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                    ->first();

        if(count($rhxml)>0){
            $xmlfactura             =   $rhxml->NOM_CATEGORIA_DOCUMENTO;
        }



        if($tiposerie == 'E'){

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                        ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                        ->get();

        }else{
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                        ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                        ->get();
        }




        $funcion                =   $this;

        return View::make('comprobante/registrocomprobante',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'procedencia'           =>  $procedencia,
                            'xmlfactura'            =>  $xmlfactura,

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
                        $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
                        $fedocumento_t          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();


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

                        //     $contadorArchivos = Archivo::count();

                        //     $zip = new ZipArchive;
                        //     $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        //     $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        //     $nombrefile      =      $contadorArchivos.'-'.$file->getClientOriginalName();
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
                        //
                        $contadorArchivos = Archivo::count();
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      $contadorArchivos.'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;

                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();

                        copy($file->getRealPath(),$rutacompleta);
                        //dd($extractedFile);
                        $path            =   $rutacompleta;


                        $rh              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                                    ->where('COD_ESTADO','=',1)
                                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                                    ->get();


                        if(count($rh)<=0){
                            //FACTURA
                            /****************************************  LEER EL XML Y GUARDAR   *********************************/
                            $parser = new InvoiceParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);
                            $tipo_documento_le = $factura->gettipoDoc();
                            $moneda_le = $factura->gettipoMoneda();
                        }else{
                            //RECIBO POR HONORARIO
                            $parser = new RHParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);  

                            $tipo_documento_le = 'R1';
                            $moneda_le = 'PEN';
                        }



                        $fedocumento_e          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->whereNotIn('COD_ESTADO',['','ETM0000000000006'])
                                                    ->where('RUC_PROVEEDOR','=',$factura->getcompany()->getruc())
                                                    ->where('SERIE','=',$factura->getserie())
                                                    ->where('NUMERO','=',$factura->getcorrelativo())
                                                    ->where('ID_TIPO_DOC','=',$tipo_documento_le)
                                                    ->first();
                        if(count($fedocumento_e)>0){
                            return Redirect::back()->with('errorurl', 'Este XML ya fue integrado en otra orden de compra');
                        }


                        //VALIDAR QUE EL XML SEA DE LA EMPRESA
                        if($factura->getClient()->getnumDoc()!= Session::get('empresas')->NRO_DOCUMENTO){
                            return Redirect::back()->with('errorurl', 'El xml no corresponde a la empresa '.Session::get('empresas')->NRO_DOCUMENTO);
                        }







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
                        $documento->ID_TIPO_DOC             =   $tipo_documento_le;
                        $documento->FEC_VENTA               =   $factura->getfechaEmision()->format('Ymd');
                        $documento->FEC_VENCI_PAGO          =   $factura->getfecVencimiento()->format('Ymd');
                        $documento->FORMA_PAGO              =   $factura->getcondicionPago();
                        $documento->FORMA_PAGO_DIAS          =   $diasdefactura;

                        $documento->MONEDA                  =   $moneda_le;
                        $documento->VALOR_IGV_ORIG          =   $factura->getmtoIGV();
                        $documento->VALOR_IGV_SOLES         =   $factura->getmtoIGV();

                        $documento->SUB_TOTAL_VENTA_ORIG    =   $factura->getmtoOperGravadas();
                        $documento->SUB_TOTAL_VENTA_SOLES   =   $factura->getmtoOperGravadas();

                        $documento->TOTAL_VENTA_ORIG        =   $factura->getmtoImpVenta();
                        $documento->TOTAL_VENTA_SOLES       =   $factura->getmtoImpVenta();

                        $documento->TOTAL_VENTA_XML         =   $factura->getmtoImpVenta();


                        $documento->HORA_EMISION            =   $factura->gethoraEmision();
                        $documento->IMPUESTO_2              =   $factura->getmtoOtrosTributos();
                        $documento->TIPO_DETRACCION         =   $factura->getdetraccion()->gettipoDet();
                        $documento->PORC_DETRACCION         =   (float)$factura->getdetraccion()->getporcDet();
                        $documento->MONTO_DETRACCION        =   (float)$factura->getdetraccion()->getbaseDetr();
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
                        $documento->OPERACION               =   'ORDEN_COMPRA';
                        $documento->MONTO_NC                =   0.00;

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
                                $producto                           = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);

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

                                if (!isset($datares['estadoCp'])){
                                    return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                                }


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
    


    public function actionDetalleComprobanteOCProveedor($procedencia,$idopcion, $prefijo, $idordencompra, Request $request) {


        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        //$ordencompra            =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();

        View::share('titulo','REGISTRO DE COMPROBANTE OC: '.$idoc);

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
        $rhxml                  =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                    //->where('IND_OBLIGATORIO','=',1)
                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                    ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                    ->first();

        if(count($rhxml)>0){
            $xmlfactura             =   $rhxml->NOM_CATEGORIA_DOCUMENTO;
        }



        if($tiposerie == 'E'){

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004','DCC0000000000034'])
                                        ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                        ->get();

        }else{
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000034'])
                                        ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                        ->get();
        }

        $funcion                =   $this;

        $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;

        $cb_id                  =   '';
        $combocb                =   array('' => "Seleccione Cuenta Bancaria");

        $ordencompra_f          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
        $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra_f->COD_EMPR_CLIENTE)->first();
        $combocb                =   array('' => "Seleccione Cuenta Bancaria");
        $combopagodetraccion    =   array('' => "Seleccione Pago Detraccion", $ordencompra_f->COD_EMPR_CLIENTE => $ordencompra_f->TXT_EMPR_CLIENTE , $ordencompra_f->COD_EMPR => Session::get('empresas')->NOM_EMPR);

        return View::make('comprobante/registrocomprobanteproveedor',
                         [
                            'ordencompra'           =>  $ordencompra,

                            'combobancos'           =>  $combobancos,
                            'cb_id'                 =>  $cb_id,
                            'combocb'               =>  $combocb,

                            'ordencompra_f'         =>  $ordencompra_f,
                            'combocb'               =>  $combocb,
                            'empresa'               =>  $empresa,
                            'combopagodetraccion'   =>  $combopagodetraccion,

                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'procedencia'           =>  $procedencia,
                            'xmlfactura'            =>  $xmlfactura,

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
                        $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
                        $fedocumento_t          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();




                        if(count($fedocumento_t)>0){
                            DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                        }


                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        //
                        $contadorArchivos = Archivo::count();
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      $contadorArchivos.'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;

                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();

                        copy($file->getRealPath(),$rutacompleta);
                        //dd($extractedFile);
                        $path            =   $rutacompleta;





                        //SI TIENE DETRACCION ASIGNAR EL PDF
                        if($ordencompra_t->CAN_DETRACCION>0){

                            $autodetraccion             =       CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                                                ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000009'])
                                                                ->first();
                            if(count($autodetraccion)<=0){
                                $docasociar                              =   New CMPDocAsociarCompra;
                                $docasociar->COD_ORDEN                   =   $ordencompra_t->COD_ORDEN;
                                $docasociar->COD_CATEGORIA_DOCUMENTO     =   'DCC0000000000009';
                                $docasociar->NOM_CATEGORIA_DOCUMENTO     =   'CONSTANCIA DE AUTODETRACCIÓN';
                                $docasociar->IND_OBLIGATORIO             =   1;
                                $docasociar->TXT_FORMATO                 =   'PDF';
                                $docasociar->TXT_ASIGNADO                =   'PROVEEDOR';
                                $docasociar->COD_USUARIO_CREA_AUD        =   Session::get('usuario')->id;
                                $docasociar->FEC_USUARIO_CREA_AUD        =   $this->fechaactual;
                                $docasociar->COD_ESTADO                  =   1;
                                $docasociar->TIP_DOC                     =   'N';
                                $docasociar->save();
                            }
                        }




                        $rh              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                                    ->where('COD_ESTADO','=',1)
                                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                                    ->get();


                        if(count($rh)<=0){
                            //FACTURA
                            /****************************************  LEER EL XML Y GUARDAR   *********************************/
                            $parser = new InvoiceParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);
                            $tipo_documento_le = $factura->gettipoDoc();
                            $moneda_le = $factura->gettipoMoneda();
                        }else{
                            //RECIBO POR HONORARIO
                            $parser = new RHParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);  

                            $tipo_documento_le = 'R1';
                            $moneda_le = 'PEN';
                        }




                        $fedocumento_e          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->whereNotIn('COD_ESTADO',['','ETM0000000000006'])
                                                    ->where('RUC_PROVEEDOR','=',$factura->getcompany()->getruc())
                                                    ->where('SERIE','=',$factura->getserie())
                                                    ->where('NUMERO','=',$factura->getcorrelativo())
                                                    ->where('ID_TIPO_DOC','=',$tipo_documento_le)
                                                    ->first();
                        if(count($fedocumento_e)>0){
                            return Redirect::back()->with('errorurl', 'Este XML ya fue integrado en otra orden de compra');
                        }


                        //VALIDAR QUE EL XML SEA DE LA EMPRESA
                        if($factura->getClient()->getnumDoc()!= Session::get('empresas')->NRO_DOCUMENTO){
                            return Redirect::back()->with('errorurl', 'El xml no corresponde a la empresa '.Session::get('empresas')->NRO_DOCUMENTO);
                        }




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



                        $documentolinea                     =   $this->ge_linea_documento($ordencompra->COD_ORDEN);

                        //dd($documentolinea);


                        $documentolinea                     =   $this->ge_linea_documento($ordencompra->COD_ORDEN);
                        // $cant_rentencion                    =   $ordencompra_t->CAN_RETENCION;
                        // $cant_perception                    =   $factura->getperception();
                        $cant_rentencion                    =   $ordencompra_t->CAN_RETENCION;
                        $cant_rentencion_cuarta             =   $ordencompra_t->CAN_IMPUESTO_RENTA;
                        $cant_perception                    =   $ordencompra_t->CAN_PERCEPCION;




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
                        $documento->ID_TIPO_DOC             =   $tipo_documento_le;
                        $documento->FEC_VENTA               =   $factura->getfechaEmision()->format('Ymd');
                        $documento->FEC_VENCI_PAGO          =   $factura->getfecVencimiento()->format('Ymd');
                        $documento->FORMA_PAGO              =   $factura->getcondicionPago();
                        $documento->FORMA_PAGO_DIAS          =   $diasdefactura;

                        $documento->MONEDA                  =   $moneda_le;
                        $documento->VALOR_IGV_ORIG          =   $factura->getmtoIGV();
                        $documento->VALOR_IGV_SOLES         =   $factura->getmtoIGV();

                        $documento->SUB_TOTAL_VENTA_ORIG    =   $factura->getmtoOperGravadas();
                        $documento->SUB_TOTAL_VENTA_SOLES   =   $factura->getmtoOperGravadas();

                        $documento->PERCEPCION              =   $cant_perception;
                        $documento->MONTO_RETENCION         =   $cant_rentencion;
                        $documento->CAN_IMPUESTO_RENTA      =   $cant_rentencion_cuarta;

                        $documento->TOTAL_VENTA_ORIG        =   $factura->getmtoImpVenta();
                        $documento->TOTAL_VENTA_SOLES       =   $factura->getmtoImpVenta();
                        $documento->TOTAL_VENTA_XML         =   $factura->getmtoImpVenta();

                        $documento->HORA_EMISION            =   $factura->gethoraEmision();

                        $documento->IMPUESTO_2              =   $factura->getmtoOtrosTributos();
                        $documento->TIPO_DETRACCION         =   $factura->getdetraccion()->gettipoDet();
                        $documento->PORC_DETRACCION         =   (float)$factura->getdetraccion()->getporcDet();
                        $documento->MONTO_DETRACCION        =   (float)$factura->getdetraccion()->getbaseDetr();
                        $documento->MONTO_ANTICIPO          =   $factura->getdestotalAnticipos();
                        // $documento->OBSERVACION             =   $factura->getobservacion();
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
                        $documento->OPERACION               =   'ORDEN_COMPRA';
                        $documento->MONTO_NC                =   0.00;

                        $documento->save();

                        //DD("hola");

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
                                $producto                           = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);

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


                        $fedocumento         =      FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','<>','ETM0000000000006')->first();
                        $fechaemision        =      date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                        $detallefedocumento  =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

                        //VALIDAR QUE ALGUNOS CAMPOS SEAN IGUALES
                        $this->con_validar_documento_proveedor($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento);


                        /*
                        $token = '';
                        if($prefijocarperta =='II'){
                            $token           =      $this->generartoken_ii();
                        }else{
                            $token           =      $this->generartoken_is();
                        }
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
                        */

                        DB::commit();

                }catch(\Exception $ex){
                    DB::rollback(); 
                    return Redirect::to('detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
                }
                return Redirect::to('detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Se valido el xml');
            }else{
                return Redirect::to('detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo XML a Importar ');
            }

        }
    }

    
    public function actionValidarXMLProveedor($idopcion, $prefijo, $idordencompra,Request $request)
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
                $codigocdr = '';
                $respuestacdr = '';
                $factura_cdr_id = '';
                $sw = 0;
                $nombre_doc = $fedocumento->SERIE.'-'.$fedocumento->NUMERO;

                $numerototal     = $fedocumento->NUMERO;
                $numerototalsc    = ltrim($numerototal, '0');
                $nombre_doc_sinceros = $fedocumento->SERIE.'-'.$numerototalsc;

                //LECTURA DEL CDR
                if(!is_null($filescdr)){

                    foreach($filescdr as $file){

                        //
                        $contadorArchivos = Archivo::count();
                        $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
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
                        $dcontrol->TIPO_ARCHIVO         =   'DCC0000000000004';
                        $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'CDR';


                        $dcontrol->URL_ARCHIVO      =   $path;
                        $dcontrol->SIZE             =   filesize($file);
                        $dcontrol->EXTENSION        =   $extension;
                        $dcontrol->ACTIVO           =   1;
                        $dcontrol->FECHA_CREA       =   $this->fechaactual;
                        $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                        $dcontrol->save();
                    }


                    $extractedFile = $rutacompleta;

                    if (file_exists($extractedFile)) {

                        //cbc
                        $xml = simplexml_load_file($extractedFile);

                        //dd($xml);

                        $cbc = 0;
                        $namespaces = $xml->getNamespaces(true);
                        foreach ($namespaces as $prefix => $namespace) {
                            if('cbc'==$prefix){
                                $cbc = 1;  
                            }
                        }
                        $codigocdr = '';  
                        if($cbc>=1){
                            foreach($xml->xpath('//cbc:ResponseCode') as $ResponseCode)
                            {
                                $codigocdr  = (string)$ResponseCode;
                            }
                            foreach($xml->xpath('//cbc:Description') as $Description)
                            {
                                $respuestacdr  = $Description;
                            }
                            foreach($xml->xpath('//cbc:ID') as $ID)
                            {
                                $factura_cdr_id  = (string)$ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }  
                        }else{
                            //dd("hola2");
                            $xml_ns = simplexml_load_file($extractedFile);

                            // Namespace definitions
                            $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                            $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                            // Register namespaces
                            $xml_ns->registerXPathNamespace('ns4', $ns4);
                            $xml_ns->registerXPathNamespace('ns3', $ns3);
                            // Querying XML
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
                            {
                                $codigocdr  = (string)$ResponseCodes->ResponseCode;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
                            {
                                $respuestacdr  = $Description->Description;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentReference') as $ID)
                            {
                                $factura_cdr_id  = (string)$ID->ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }

                        }
                        if($codigocdr!="0"){
                            return Redirect::to('detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Error en la lectura CDR');
                        }
                    } else {
                        return Redirect::to('detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Error en el CDR');
                    }

                    if($sw == 0){
                        return Redirect::to('detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') no coincide con la factura ('.$nombre_doc.')');
                    }

                    if (strpos($respuestacdr, 'observaciones') !== false) {
                        return Redirect::to('detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') tiene observaciones');
                    }


                }







                //dd("si conicide");
                /************************************************************************/
                $tiposerie              =   substr($fedocumento->SERIE, 0, 1);
                if($tiposerie == 'E'){
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                //->where('IND_OBLIGATORIO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                                ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                                ->get();
                //dd($tarchivos);

                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                //->where('IND_OBLIGATORIO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                                ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                                ->get();
                }


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();
                            $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
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
                    }
                    // else{
                    //     return Redirect::to('detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo .ZIP a Importar ');
                    // }
                }

                $contacto                                 =   SGDUsuario::where('COD_TRABAJADOR','=',$contacto_id)->first();
                $trabajador                               =   STDTrabajador::where('COD_TRAB','=',$contacto->COD_TRABAJADOR)->first();
                //$contacto                               =   User::where('id','=',$contacto_id)->first();

                $ordencompra_t                          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();

                $entidadbanco_id                          =   $request['entidadbanco_id'];
                $bancocategoria                           =   CMPCategoria::where('COD_CATEGORIA','=',$entidadbanco_id)->first();
                $cb_id                                    =   $request['cb_id'];


                $ctadetraccion                            =   $request['ctadetraccion'];
                $monto_detraccion                         =   $request['monto_detraccion'];
                $pago_detraccion                          =   $request['pago_detraccion'];

                $empresa_sel                              =   STDEmpresa::where('COD_EMPR','=',$pago_detraccion)->first();
                $COD_PAGO_DETRACCION = '';
                $TXT_PAGO_DETRACCION = '';
                if(count($empresa_sel)>0){
                    $COD_PAGO_DETRACCION = $empresa_sel->COD_EMPR;
                    $TXT_PAGO_DETRACCION = $empresa_sel->NOM_EMPR;
                }

                if($ctadetraccion!=''){
                    STDEmpresa::where('COD_EMPR',$ordencompra_t->COD_EMPR_CLIENTE)
                                ->update(
                                    [
                                        'TXT_DETRACCION'=>$ctadetraccion
                                    ]
                                );
                }


                FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [

                                    'COD_CATEGORIA_BANCO'=>$bancocategoria->COD_CATEGORIA,
                                    'TXT_CATEGORIA_BANCO'=>$bancocategoria->NOM_CATEGORIA,
                                    'TXT_NRO_CUENTA_BANCARIA'=>$cb_id,
                                    
                                    'CTA_DETRACCION'=>$ctadetraccion,
                                    'MONTO_DETRACCION_XML'=>$monto_detraccion,
                                    'MONTO_DETRACCION_RED'=>round($monto_detraccion),
                                    'COD_PAGO_DETRACCION'=>$COD_PAGO_DETRACCION,
                                    'TXT_PAGO_DETRACCION'=>$TXT_PAGO_DETRACCION,


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


                $ordencompra_tt                            =   CMPOrden::where('COD_ORDEN','=',$fedocumento->ID_DOCUMENTO)->first();
                $trabajador = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $ordencompra_tt->COD_TRABAJADOR_ENCARGADO)->first();
                $trabajadorcorreo = DB::table('WEB.ListaplatrabajadoresGenereal')->where('dni','=',$trabajador->NRO_DOCUMENTO)->first();

                if(count($trabajadorcorreo)>0){
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $ordencompra_tt->COD_ORDEN;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   date_format(date_create($ordencompra_tt->FEC_USUARIO_CREA_AUD), 'Ymd h:i:s');
                    $documento->USUARIO_ID                  =   $trabajadorcorreo->COD_TRAB;
                    $documento->USUARIO_NOMBRE              =   $trabajadorcorreo->apellidopaterno.' '.$trabajadorcorreo->apellidomaterno.' '.$trabajadorcorreo->nombres;;
                    $documento->TIPO                        =   'APRUEBA EN OSIRIS';
                    $documento->MENSAJE                     =   '';
                    $documento->save();
                }

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

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO DOCUMENTOS');
                //geolocalizacion

                // $fedocumento_w       =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
                // //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('COD_TRAB','=',$contacto->COD_TRABAJADOR)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE : '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';
                // //dd($trabajador);                        
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                //     //$this->insertar_whatsaap('51914693880','JOSE CHERO',$mensaje,'');

                // }                       

                DB::commit();

            }catch(\Exception $ex){
                DB::rollback(); 
                //dd($ex);
                return Redirect::to('detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

            return Redirect::to('gestion-de-oc-proveedores/'.$idopcion)->with('bienhecho', 'Se valido el xml correctamente');

        }
    }

    public function actionDetalleComprobantecontratoAdministrator($procedencia,$idopcion, $prefijo, $idordencompra, Request $request) {


        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);

        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        //$ordencompra            =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
        View::share('titulo','REGISTRO DE COMPROBANTE CONTRATO: '.$idoc);
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
                                        ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                        ->get();

        }else{
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                        ->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                        ->get();
        }


        //encontrar la orden de compra
        $fileordencompra            =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)
                                        ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000026')
                                        ->where('COD_ESTADO','=','1')
                                        ->first();


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
        //dd($sourceFile);
            $destinationFile = '\\\\10.1.0.201\\cpe\\Contratos\\'.$ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
            // Intenta copiar el archivo
            //dd($sourceFile);
            if (file_exists($sourceFile)){
                copy($sourceFile, $destinationFile);
            }
        }

        $rutafila                   =   "";
        $rutaorden                  =   "";
        if(count($fileordencompra)>0){
            $directorio = '\\\\10.1.0.201\cpe\Contratos';
            // Nombre del archivo que estás buscando
            $nombreArchivoBuscado = $ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
            // Escanea el directorio
            $archivos = scandir($directorio);
            // Inicializa una variable para almacenar el resultado
            $archivoEncontrado = false;
            // Recorre la lista de archivos
            foreach ($archivos as $archivo) {
                // Omite los elementos '.' y '..'
                if ($archivo != '.' && $archivo != '..') {
                    // Verifica si el nombre del archivo coincide con el archivo buscado
                    if ($archivo == $nombreArchivoBuscado) {
                        $archivoEncontrado = true;
                        break;
                    }
                }
            }
            // Muestra el resultado
            if ($archivoEncontrado) {

                $rutafila            =   $directorio.'\\'.$nombreArchivoBuscado;
                $rutaorden           =   $rutafila;
            } 
        }

        //no encontro la orden de contrato
        $rutaorden                  =   "";


        //todas las guias relacionadas
        $arrayreferencia_guia       =   CMPReferecenciaAsoc::where('COD_TABLA','=',$ordencompra->COD_DOCUMENTO_CTBLE)
                                        ->where('COD_TABLA_ASOC', 'like', '%GRR%')
                                        ->where('COD_ESTADO','=',1)
                                        ->pluck('COD_TABLA_ASOC')
                                        ->toArray();
        $lista_guias                 =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$arrayreferencia_guia)
                                        ->where('COD_ESTADO','=',1)
                                        ->get();


        //dd($lista_guias);

        foreach ($lista_guias as $index=>$item) {
            $sourceFile = '\\\\10.1.0.201\cpe\Contratos';
            if($ordencompra_f->COD_CENTRO == 'CEN0000000000004' or $ordencompra_f->COD_CENTRO == 'CEN0000000000006'or $ordencompra_f->COD_CENTRO == 'CEN0000000000002'){
                if($ordencompra_f->COD_CENTRO == 'CEN0000000000004'){
                    $sourceFile = '\\\\10.1.7.200\\cpe\\Contratos\\'.$item->COD_DOCUMENTO_CTBLE.'.pdf';
                }
                if($ordencompra_f->COD_CENTRO == 'CEN0000000000006'){
                    $sourceFile = '\\\\10.1.9.43\\cpe\\Contratos\\'.$item->COD_DOCUMENTO_CTBLE.'.pdf';
                }
                if($ordencompra_f->COD_CENTRO == 'CEN0000000000002'){
                    $sourceFile = '\\\\10.1.4.201\\cpe\\Contratos\\'.$item->COD_DOCUMENTO_CTBLE.'.pdf';
                }

                $destinationFile = '\\\\10.1.0.201\\cpe\\Contratos\\'.$item->COD_DOCUMENTO_CTBLE.'.pdf';
                // Intenta copiar el archivo
                //dd($sourceFile);
                if (file_exists($sourceFile)){
                    copy($sourceFile, $destinationFile);
                }
            }
        }

        $array_guias                 =   array();                               
        $rutaordenguia               =   "";
        foreach ($lista_guias as $index=>$item) {
            $array_nuevo            =   array(); 

            $directorio = '\\\\10.1.0.201\cpe\Contratos';
            // Nombre del archivo que estás buscando
            $nombreArchivoBuscado = $item->COD_DOCUMENTO_CTBLE.'.pdf';
            // Escanea el directorio
            $archivos = scandir($directorio);
            // Inicializa una variable para almacenar el resultado
            $archivoEncontrado = false;
            // Recorre la lista de archivos
            foreach ($archivos as $archivo) {
                // Omite los elementos '.' y '..'
                if ($archivo != '.' && $archivo != '..') {
                    // Verifica si el nombre del archivo coincide con el archivo buscado
                    if ($archivo == $nombreArchivoBuscado) {
                        $archivoEncontrado = true;
                        break;
                    }
                }
            }
            // Muestra el resultado
            if ($archivoEncontrado) {
                $rutaordenguia           =   $directorio.'\\'.$nombreArchivoBuscado;
                $array_nuevo             =  array(
                                                "COD_DOCUMENTO_CTBLE"       => $item->COD_DOCUMENTO_CTBLE,
                                                "NRO_SERIE"                 => $item->NRO_SERIE,
                                                "NRO_DOC"                   => $item->NRO_DOC,
                                                "rutaordenguia"             => $rutaordenguia,
                                            );
                array_push($array_guias,$array_nuevo);
            }else{
                $rutaordenguia           =  '';
                $array_nuevo             =  array(
                                                "COD_DOCUMENTO_CTBLE"       => $item->COD_DOCUMENTO_CTBLE,
                                                "NRO_SERIE"                 => $item->NRO_SERIE,
                                                "NRO_DOC"                   => $item->NRO_DOC,
                                                "rutaordenguia"             => $rutaordenguia,
                                            );
                array_push($array_guias,$array_nuevo);            }
        }

        $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;

        $cb_id                  =   '';
        $combocb                =   array('' => "Seleccione Cuenta Bancaria");


        $combodocumento         =   array('DCC0000000000002' => 'FACTURA ELECTRONICA' , 'DCC0000000000013' => 'RECIBO POR HONORARIO');
        $documento_id           =   'DCC0000000000002';
        $funcion                =   $this;

        $user_orden             =   User::where('usuarioosiris_id','=',$ordencompra->COD_EMPR_EMISOR)->first();
        $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR_EMISOR)->first();

        $combotipodetraccion    =   array('' => "Seleccione Tipo Detraccion",'MONTO_REFERENCIAL' => 'MONTO REFERENCIAL' , 'MONTO_FACTURACION' => 'MONTO FACTURACION');
        $combopagodetraccion    =   array('' => "Seleccione Pago Detraccion",$ordencompra->COD_EMPR_EMISOR => $ordencompra->TXT_EMPR_EMISOR , $ordencompra->COD_EMPR_RECEPTOR => $ordencompra->TXT_EMPR_RECEPTOR);

        $fedocumento_x          =   FeDocumento::where('TXT_REFERENCIA','=',$idoc)->first();



        //ANTICIPO
        $COD_EMPR               =   Session::get('empresas')->COD_EMPR;
        $COD_CENTRO             =   '';
        $FEC_CORTE              =   $this->hoy_sh;
        $CLIENTE                =   $ordencompra->COD_EMPR_EMISOR;
        $COD_MONEDA             =   $ordencompra_f->COD_CATEGORIA_MONEDA;

        $monto_anticipo         =   0.00;

        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.OBTENER_ADELANTOS_PROVEEDOR_DETALLADO 
                                                                @COD_EMPR = ?,
                                                                @COD_CENTRO = ?,
                                                                @FEC_CORTE = ?,
                                                                @CLIENTE = ?,
                                                                @COD_MONEDA = ?'
                                                            );
        $stmt->bindParam(1, $COD_EMPR, PDO::PARAM_STR);
        $stmt->bindParam(2, $COD_CENTRO, PDO::PARAM_STR);
        $stmt->bindParam(3, $FEC_CORTE, PDO::PARAM_STR);
        $stmt->bindParam(4, $CLIENTE, PDO::PARAM_STR);
        $stmt->bindParam(5, $COD_MONEDA, PDO::PARAM_STR);
        $stmt->execute();
        $listaanticipo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arrayitem      = array();

        //ver si ya estan registrados algunos anticipos
        foreach ($listaanticipo as $index => $item) {
            
            $existeanticipo          =   FeDocumento::where('COD_ANTICIPO','=',$item['COD_HABILITACION'])
                                         ->whereIn('COD_ESTADO',['ETM0000000000002','ETM0000000000003','ETM0000000000004','ETM0000000000005','ETM0000000000008'])
                                         ->first();
            if(count($existeanticipo)<=0){
                $arrayitem               =   $arrayitem + array($item['COD_HABILITACION'] => $item['NRO_SERIE'].'-'.$item['NRO_DOC'].' // '.$item['CAN_SALDO']);
                $monto_anticipo          =   $monto_anticipo + (float)$item['CAN_SALDO'];  
            }

        }
        $comboant               =   array('' => "Seleccione Anticipo")+$arrayitem;

        return View::make('comprobante/registrocomprobantecontratoadministrator',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'user_orden'            =>  $user_orden,
                            'empresa'               =>  $empresa,

                            'combotipodetraccion'   =>  $combotipodetraccion,
                            'combopagodetraccion'   =>  $combopagodetraccion,
                            'ordencompra_f'         =>  $ordencompra_f,
                            'fedocumento_x'         =>  $fedocumento_x,


                            'comboant'              =>  $comboant,
                            'monto_anticipo'        =>  $monto_anticipo,



                            'combobancos'           =>  $combobancos,
                            'combotipodetraccion'   =>  $combotipodetraccion,
                            'detalleordencompra'    =>  $detalleordencompra,

                            'cb_id'                 =>  $cb_id,
                            'combocb'               =>  $combocb,

                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'procedencia'           =>  $procedencia,
                            'xmlfactura'            =>  $xmlfactura,
                            'tp'                    =>  $tp,
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tarchivos'             =>  $tarchivos,
                            'usuario'               =>  $usuario,
                            'rutaorden'             =>  $rutaorden,
                            'combodocumento'        =>  $combodocumento,
                            'documento_id'          =>  $documento_id,
                            'lista_guias'           =>  $lista_guias,
                            'array_guias'           =>  $array_guias,


                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }

    public function actionDetalleComprobanteNotaCreditoAdministrator($procedencia,$idopcion, $prefijo, $idordencompra, Request $request) {


        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);

        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_credito_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        //$ordencompra            =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
        View::share('titulo','REGISTRO DE COMPROBANTE NOTA DE CREDITO: '.$idoc);
        $tiposerie              =   '';

        if(count($fedocumento)>0){
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);
        }else{
            $detallefedocumento     =   array();
        }

        //dd($detallefedocumento);

        
        $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        //dd($tp);
        $contacto               =   DB::table('users')->where('ind_contacto','=',1)->pluck('nombre','id')->toArray();
        $combocontacto          =   array('' => "Seleccione Contacto") + $contacto;
        $usuario                =   SGDUsuario::where('COD_USUARIO','=',$ordencompra->COD_USUARIO_CREA_AUD)->first();



        $xmlfactura             =   'NOTA DE CREDITO';
        
        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                        ->get();

        $ordencompra_f            =      CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();       
        
        $funcion                =   $this;

        $user_orden             =   User::where('usuarioosiris_id','=',$ordencompra->COD_EMPR_EMISOR)->first();
        $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR_EMISOR)->first();

       

        $fedocumento_x          =   FeDocumento::where('TXT_REFERENCIA','=',$idoc)->first();     

        return View::make('comprobante/registrocomprobantenotacreditoadministrator',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'user_orden'            =>  $user_orden,
                            'empresa'               =>  $empresa,                            
                            'ordencompra_f'         =>  $ordencompra_f,
                            'fedocumento_x'         =>  $fedocumento_x,                            
                            'detalleordencompra'    =>  $detalleordencompra,                            
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'procedencia'           =>  $procedencia,
                            'xmlfactura'            =>  $xmlfactura,
                            'tp'                    =>  $tp,                            
                            'tarchivos'             =>  $tarchivos,
                            'usuario'               =>  $usuario,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }

    public function actionDetalleComprobanteNotaDebitoAdministrator($procedencia,$idopcion, $prefijo, $idordencompra, Request $request) {


        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);

        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_debito_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        //$ordencompra            =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
        View::share('titulo','REGISTRO DE COMPROBANTE NOTA DE DEBITO: '.$idoc);
        $tiposerie              =   '';

        if(count($fedocumento)>0){
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);
        }else{
            $detallefedocumento     =   array();
        }

        //dd($detallefedocumento);

        
        $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        //dd($tp);
        $contacto               =   DB::table('users')->where('ind_contacto','=',1)->pluck('nombre','id')->toArray();
        $combocontacto          =   array('' => "Seleccione Contacto") + $contacto;
        $usuario                =   SGDUsuario::where('COD_USUARIO','=',$ordencompra->COD_USUARIO_CREA_AUD)->first();



        $xmlfactura             =   'NOTA DE DEBITO';
        
        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                        ->get();

        $ordencompra_f            =      CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();       
        
        $funcion                =   $this;

        $user_orden             =   User::where('usuarioosiris_id','=',$ordencompra->COD_EMPR_EMISOR)->first();
        $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR_EMISOR)->first();

       

        $fedocumento_x          =   FeDocumento::where('TXT_REFERENCIA','=',$idoc)->first();     

        return View::make('comprobante/registrocomprobantenotadebitoadministrator',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'user_orden'            =>  $user_orden,
                            'empresa'               =>  $empresa,                            
                            'ordencompra_f'         =>  $ordencompra_f,
                            'fedocumento_x'         =>  $fedocumento_x,                            
                            'detalleordencompra'    =>  $detalleordencompra,                            
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'procedencia'           =>  $procedencia,
                            'xmlfactura'            =>  $xmlfactura,
                            'tp'                    =>  $tp,                            
                            'tarchivos'             =>  $tarchivos,
                            'usuario'               =>  $usuario,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }

    public function actionDetalleComprobanteLiquidacionCompraAnticipoAdministrator($procedencia,$idopcion, $prefijo, $idordenpago, Request $request) {


        $idop                   =   $this->funciones->decodificarmaestraprefijo($idordenpago,$prefijo);
        
        $ordenpago              =   $this->con_lista_comprobante_orden_pago_idoc($idop);

        $idoc                   =   $ordenpago->COD_DOCUMENTO_CTBLE;

        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        
        View::share('titulo','REGISTRO DE COMPROBANTE LIQUIDACION COMPRA ANTICIPO: '.$idop);
        
        $banco_id               =   '';
        if(count($fedocumento)>0){
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();        
            $ingresoliq_id           =   $fedocumento->TXT_INGRESO_LIQ;

            //EMPRESA RELACIONADA
            $empresa_relacionada    =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)
                                        ->where('IND_RELACIONADO','=',1)
                                        ->first();


            if(count($empresa_relacionada)>0){
                $banco_id               =   'BAM0000000000011';  
            }
        }else{
            $detallefedocumento     =   array();
            $ingresoliq_id           =   'NO';

            $empresa_relacionada    =   array();
        }

        //dd($detallefedocumento);

        $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        
        $contacto               =   DB::table('users')->where('ind_contacto','=',1)->pluck('nombre','id')->toArray();
        $combocontacto          =   array('' => "Seleccione Contacto") + $contacto;
        $usuario                =   SGDUsuario::where('COD_USUARIO','=',$ordenpago->COD_USUARIO_CREA_AUD)->first();

        $ordencompra_f          =      CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();

        $xmlfactura             =   'LIQUIDACION COMPRA';
        
        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idop)->where('COD_ESTADO','=',1)
                                        ->get();

        $comboingresoliq         =   array('SI' => 'CON INGRESO' , 'NO' => 'SIN INGRESO');
        
        $funcion                =   $this;

        $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;

        $cb_id                  =   '';        
        $combocb                =   array('' => "Seleccione Cuenta Bancaria");

        return View::make('comprobante/registrocomprobanteliquidacioncompraanticipoadministrator',
                         [
                            'ordenpago'             =>  $ordenpago,
                            'ordencompra'           =>  $ordencompra,
                            'banco_id'              =>  $banco_id,
                            'combobancos'           =>  $combobancos,
                            'ordencompra_f'           =>  $ordencompra_f,
                            'detalleordencompra'    =>  $detalleordencompra,

                            'cb_id'                 =>  $cb_id,
                            'combocb'               =>  $combocb,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'procedencia'           =>  $procedencia,
                            'xmlfactura'            =>  $xmlfactura,
                            'tp'                    =>  $tp,
                            
                            'tarchivos'             =>  $tarchivos,
                            'usuario'               =>  $usuario,
                            
                            'comboingresoliq'        =>  $comboingresoliq,
                            'ingresoliq_id'          =>  $ingresoliq_id,
                            
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }

    public function actionCargarXMLLiquidacionCompraAnticipoAdministrator($idopcion, $prefijo, $idordenpago,Request $request)
    {       

        $idop                   =   $this->funciones->decodificarmaestraprefijo($idordenpago,$prefijo);                

        $rutafila               =   "";
        $rutaorden              =   "";
        $directorio             = $this->pathFilesLiquidacion;


        $ordenpago              =   $this->con_lista_comprobante_orden_pago_idoc($idop);
        $idoc                   =   $ordenpago->COD_DOCUMENTO_CTBLE;
        $liquidacion            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        // Nombre del archivo que estás buscando
        $nombreArchivoBuscado = $idop.'.xml';
        $nombreArchivoBuscado = $liquidacion->COD_EMPR_EMISOR.'-04-'.$liquidacion->NRO_SERIE.'-'.$liquidacion->NRO_DOC.'.xml';        
        // Escanea el directorio
        $archivos = scandir($directorio);
        // Inicializa una variable para almacenar el resultado
        $archivoEncontrado = false;
        // Recorre la lista de archivos
        //dd($nombreArchivoBuscado);

        foreach ($archivos as $archivo) {
            // Omite los elementos '.' y '..'
            if ($archivo != '.' && $archivo != '..') {
                // Verifica si el nombre del archivo coincide con el archivo buscado
                if ($archivo == $nombreArchivoBuscado) {
                    $archivoEncontrado = true;
                    break;
                }
            }
        }
        // Muestra el resultado
        if ($archivoEncontrado) {

            $rutafila            =   $directorio.'\\'.$nombreArchivoBuscado;
            $rutaorden           =   $rutafila;
        } 


        if($_POST)
        {


                        $procedencia            =   $request['procedencia'];
            if ($rutaorden)
            {
                try{    
                        //dd("hola");
                        DB::beginTransaction();
                        $ordenpago              =   $this->con_lista_comprobante_orden_pago_idoc($idop);
                        $documentolinea         =   $this->ge_linea_documento($ordenpago->COD_AUTORIZACION);

                        $idoc                   =   $ordenpago->COD_DOCUMENTO_CTBLE;
                        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
                        //dd($idoc);
                        $detalleordencompra     =   $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);

                        //dd($detalleordencompra);

                        $ingresoliq_id          =   $request['ingresoliq_id'];                        
                        //dd($procedencia);
                        $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();

                        $moneda                 =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_MONEDA)->first();       

                        if($ingresoliq_id=='SI'){
                            $archivosdelfe          =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000040','DCC0000000000041','DCC0000000000043','DCC0000000000045'])
                                                        ->get();  
                        }else{                            
                            if($ordenpago->COD_CENTRO == 'CEN0000000000004' || $ordenpago->COD_CENTRO == 'CEN0000000000006'){ //rioja o bellavista
                                $archivosdelfe          =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000041','DCC0000000000043','DCC0000000000045','DCC0000000000046'])->get();  
                            }else{
                                $archivosdelfe          =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000041','DCC0000000000043','DCC0000000000045'])->get();  
                            }
                        }
                        

                        $fedocumento_t          =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('COD_ESTADO','<>','ETM0000000000006')->first();

                        if(count($fedocumento_t)>0){
                            DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();                            
                            DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();                            
                        }                      

                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $categorialiq                   =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                                ->where('COD_CATEGORIA','=','DCC0000000000003')
                                                                ->first();
                        
                        $contadorArchivos = Archivo::count();
                        $nombrefilecdr                  =       $contadorArchivos.'-LCA-'.$idop.'.xml';
                        $prefijocarperta                =       $this->prefijo_empresa($ordenpago->COD_EMPR);
                        $rutafile                       =       $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordenpago->NRO_DOC;
                        $rutacompleta                   =       $rutafile.'\\'.$nombrefilecdr;
                        $valor                          =       $this->versicarpetanoexiste($rutafile);
                        $path                           =       $rutacompleta;
                        //$directorio                     =       '\\\\10.1.0.201\cpe\Orden_Compra';
                        //$rutafila                       =       $directorio.'\\'.$nombreArchivoBuscado;
                        copy($rutaorden,$rutacompleta);
                        $dcontrol                       =       new Archivo;
                        $dcontrol->ID_DOCUMENTO         =       $ordenpago->COD_AUTORIZACION;
                        $dcontrol->DOCUMENTO_ITEM       =       $documentolinea;
                        $dcontrol->TIPO_ARCHIVO         =       $categorialiq->COD_CATEGORIA;
                        $dcontrol->NOMBRE_ARCHIVO       =       $nombrefilecdr;
                        $dcontrol->DESCRIPCION_ARCHIVO  =       $categorialiq->NOM_CATEGORIA;
                        $dcontrol->URL_ARCHIVO          =       $path;
                        $dcontrol->SIZE                 =       100;
                        $dcontrol->EXTENSION            =       '.xml';
                        $dcontrol->ACTIVO               =       1;
                        $dcontrol->FECHA_CREA           =       $this->fechaactual;
                        $dcontrol->USUARIO_CREA         =       Session::get('usuario')->id;
                        $dcontrol->save();

                        //REGISTRO DEL XML DESDE LIQUIDACION DE COMPRA (TABLA CMP.DOCUMENTO_CTBLE)
                        

                        $documento                          =   new FeDocumento;
                        $documento->ID_DOCUMENTO            =   $ordenpago->COD_AUTORIZACION;
                        $documento->DOCUMENTO_ITEM          =   $documentolinea;

                        $documento->COD_EMPR                =   $ordencompra->COD_EMPR;
                        $documento->TXT_EMPR                =   $ordencompra->NOM_EMPR;
                        $documento->TXT_PROCEDENCIA         =   $procedencia;
                        $documento->ESTADO                  =   'A';
                        $documento->RUC_PROVEEDOR           =   $ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $documento->RZ_PROVEEDOR            =   $ordencompra->TXT_EMPR_EMISOR;
                        $documento->TIPO_CLIENTE            =   6;
                        $documento->ID_CLIENTE              =   $empresa->NRO_DOCUMENTO;
                        $documento->NOMBRE_CLIENTE          =   $ordencompra->NOM_EMPR;
                        $documento->DIRECCION_CLIENTE       =   '';
                        $documento->SERIE                   =   $ordencompra->NRO_SERIE;
                        $documento->NUMERO                  =   $ordencompra->NRO_DOC;
                        $documento->ID_TIPO_DOC             =   '04';
                        $documento->FEC_VENTA               =   Carbon::parse($ordencompra->FEC_EMISION)->format('Ymd');
                        $documento->FEC_VENCI_PAGO          =   Carbon::parse($ordencompra->FEC_VENCIMIENTO)->format('Ymd');
                        $documento->FORMA_PAGO              =   '';
                        $documento->FORMA_PAGO_DIAS          =  0;
                        $documento->MONEDA                  =   $moneda->CODIGO_SUNAT;

                        $tc                                 =   (float)$ordencompra->CAN_TIPO_CAMBIO;        
                        
                        $documento->VALOR_IGV_ORIG          =   (float)$ordencompra->CAN_IMPUESTO_RENTA;
                        $documento->VALOR_IGV_SOLES         =   (float)$ordencompra->CAN_IMPUESTO_RENTA;
                        $documento->SUB_TOTAL_VENTA_ORIG    =   (float)$ordencompra->CAN_SUB_TOTAL;
                        $documento->SUB_TOTAL_VENTA_SOLES   =   (float)$ordencompra->CAN_SUB_TOTAL;
                        $documento->TOTAL_VENTA_XML         =   (float)$ordencompra->CAN_TOTAL;

                        $documento->TOTAL_VENTA_ORIG        =   (float)$ordencompra->CAN_TOTAL;
                        $documento->TOTAL_VENTA_SOLES       =   (float)$ordencompra->CAN_TOTAL;


                        $documento->PERCEPCION              =   (float)$ordencompra->CAN_PERCEPCION;
                        $documento->MONTO_RETENCION         =   (float)$ordencompra->CAN_RETENCION;

                        $documento->HORA_EMISION            =   Carbon::parse($ordencompra->FEC_EMISION)->format('H:i:s');
                        $documento->IMPUESTO_2              =   0.00;
                        $documento->TIPO_DETRACCION         =   '';
                        $documento->PORC_DETRACCION         =   0.00;
                        $documento->MONTO_DETRACCION        =   (float)$ordencompra->CAN_DETRACCION;
                        $documento->MONTO_ANTICIPO          =   (float)$ordencompra->CAN_ANTICIPO;                        
                        $documento->NRO_ORDEN_COMP          =   '';              
                        $documento->NUM_GUIA                =   '';


                        $documento->estadoCp                =   0;
                        $documento->ARCHIVO_XML             =   $nombrefilecdr;
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
                        $documento->OPERACION               =   'LIQUIDACION_COMPRA_ANTICIPO';
                        $documento->MONTO_NC                =   0.00;

                        $documento->TXT_INGRESO_LIQ         =   $ingresoliq_id;

                        $documento->ind_ruc                 =   1;
                        $documento->ind_rz                  =   1;
                        $documento->ind_moneda              =   1;
                        $documento->ind_total               =   1;
                        $documento->ind_cantidaditem        =   1;
                        $documento->ind_formapago           =   1;
                        $documento->ind_errototal           =   1;
                        $documento->CAN_CENTIMO             =   0;
                       
                        $documento->save();                        


                        //dd($detalleordencompra);

                        /**********DETALLE*********/
                        foreach ($detalleordencompra as $indexdet => $itemdet) {
                                
                                $linea = str_pad($indexdet+1, 3, "0", STR_PAD_LEFT); 
                                $detalle                        =   new FeDetalleDocumento;
                                $detalle->ID_DOCUMENTO          =   $ordenpago->COD_AUTORIZACION;
                                $detalle->DOCUMENTO_ITEM        =   $documentolinea;

                                $detalle->LINEID                =   $linea;
                                $detalle->CODPROD               =   $itemdet->COD_PRODUCTO;
                                $detalle->PRODUCTO              =   $itemdet->TXT_NOMBRE_PRODUCTO;
                                $detalle->UND_PROD              =   $itemdet->producto->unidadmedida->TXT_ABREVIATURA;
                                $detalle->CANTIDAD              =   (float)$itemdet->CAN_PRODUCTO;
                                $detalle->PRECIO_UNIT           =   (float)$itemdet->CAN_PRECIO_UNIT;
                                $detalle->VAL_IGV_ORIG          =   (float)$itemdet->CAN_TASA_IGV;
                                $detalle->VAL_IGV_SOL           =   (float)$itemdet->CAN_TASA_IGV;
                                $detalle->VAL_SUBTOTAL_ORIG     =   (float)$itemdet->CAN_VALOR_VTA;
                                $detalle->VAL_SUBTOTAL_SOL      =   (float)$itemdet->CAN_VALOR_VTA;
                                $detalle->VAL_VENTA_ORIG        =   (float)$itemdet->CAN_VALOR_VENTA_IGV;
                                $detalle->VAL_VENTA_SOL         =   (float)$itemdet->CAN_VALOR_VENTA_IGV;
                                $detalle->PRECIO_ORIG           =   (float)$itemdet->CAN_PRECIO_UNIT;
                                $detalle->save();

                        }
                        
                        //ARCHIVOS
                        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN','=',$ordenpago->COD_AUTORIZACION)->delete();

                        foreach($archivosdelfe as $index=>$item){

                                $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item->COD_CATEGORIA)->first();

                                $docasociar                              =   New CMPDocAsociarCompra;
                                $docasociar->COD_ORDEN                   =   $ordenpago->COD_AUTORIZACION;
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
                    return Redirect::to('detalle-comprobante-liquidacion-compra-anticipo-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordenpago)->with('errorbd', $ex.' Ocurrio un error inesperado');
                }
                return Redirect::to('detalle-comprobante-liquidacion-compra-anticipo-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordenpago)->with('bienhecho', 'Se valido el xml');
            }else{
                //dd("errpr");
                return Redirect::to('detalle-comprobante-liquidacion-compra-anticipo-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordenpago)->with('errorurl', 'Archivo XML de la Orden de Pago No Encontrado ');
            }

        }
    }

    public function actionValidarXMLLiquidacionCompraAnticipoAdministrator($idopcion, $prefijo, $idordenpago,Request $request)
    {        
        $idop                   =   $this->funciones->decodificarmaestraprefijo($idordenpago,$prefijo);
        $ordenpago              =   $this->con_lista_comprobante_orden_pago_idoc($idop);        

        $idoc                   =   $ordenpago->COD_DOCUMENTO_CTBLE;
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);


        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $contacto_id       =   $request['contacto_id'];
                $procedencia       =   $request['procedencia'];                

                $fedocumento       =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('COD_ESTADO','<>','ETM0000000000006')->first();                
                
                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idop)->where('COD_ESTADO','=',1)->get();                

                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();                            
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordenpago->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordenpago->NRO_DOC;                            
                            $nombrefilecdr   =      $contadorArchivos.'-LCA-'.$file->getClientOriginalName();
                            $valor           =      $this->versicarpetanoexiste($rutafile);
                            $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                            copy($file->getRealPath(),$rutacompleta);
                            $path            =      $rutacompleta;

                            $nombreoriginal             =   $file->getClientOriginalName();
                            $info                       =   new SplFileInfo($nombreoriginal);
                            $extension                  =   $info->getExtension();

                            $dcontrol                       =   new Archivo;
                            $dcontrol->ID_DOCUMENTO         =   $ordenpago->COD_AUTORIZACION;
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

                $entidadbanco_id   =   $request['entidadbanco_id'];
                $bancocategoria    =   CMPCategoria::where('COD_CATEGORIA','=',$entidadbanco_id)->first();
                $cb_id             =   $request['cb_id'];
                
                FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [                                    
                                    'COD_CATEGORIA_BANCO'=>$bancocategoria->COD_CATEGORIA,
                                    'TXT_CATEGORIA_BANCO'=>$bancocategoria->NOM_CATEGORIA,
                                    'TXT_NRO_CUENTA_BANCARIA'=>$cb_id,
                                    'ARCHIVO_CDR'=>'',
                                    'ARCHIVO_PDF'=>'',
                                    'COD_ESTADO'=>'ETM0000000000002',
                                    'TXT_ESTADO'=>'POR APROBAR USUARIO CONTACTO',
                                    'dni_usuariocontacto'=>$trabajador->NRO_DOCUMENTO,
                                    'COD_CONTACTO'=>$contacto->COD_TRABAJADOR,                                    
                                    'ind_email_uc'=>0,
                                    'TXT_CONTACTO'=>$contacto->NOM_TRABAJADOR,
                                    'fecha_pa'=>$this->fechaactual,
                                    'usuario_pa'=>Session::get('usuario')->id,
                                ]
                            );


                $ordenpago_t                          =   TESAutorizacion::where('COD_AUTORIZACION','=',$idop)->first();

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $idop;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   date_format(date_create($ordenpago_t->FEC_USUARIO_CREA_AUD), 'Ymd h:i:s');
                $documento->USUARIO_ID                  =   $contacto->COD_TRABAJADOR;
                $documento->USUARIO_NOMBRE              =   $contacto->NOM_TRABAJADOR;
                $documento->TIPO                        =   'CREO ORDEN PAGO';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $idop;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'SUBIO DOCUMENTOS';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO DOCUMENTOS');
                //geolocalizacion

                FeDocumento::where('ID_DOCUMENTO',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000012',
                                    'TXT_ESTADO'=>'POR APROBAR JEFE ACOPIO',
                                    'IND_EMAIL_JEFE_ACOPIO'=>0,
                                    'ind_email_ap'=>0,
                                    'fecha_uc'=>$this->fechaactual,
                                    'usuario_uc'=>Session::get('usuario')->id
                                ]
                            );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $idop;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR USUARIO CONTACTO';
                $documento->MENSAJE                     =   '';
                $documento->save();               


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'APROBADO POR USUARIO CONTACTO');
                //geolocalizacion



                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                //dd($ex);
                return Redirect::to('detalle-comprobante-liquidacion-compra-anticipo-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordenpago)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('bienhecho', 'Se valido el xml correctamente');

        }
    }

    public function actionDetalleComprobanteOCAdministrator($procedencia,$idopcion, $prefijo, $idordencompra, Request $request) {


        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        $ordencompra_n          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();

        $archivosdetalledoca    =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                    ->first();

        if(count($archivosdetalledoca)<=0){
            return Redirect::back()->with('errorbd', 'No tiene documentos asociados realize la migracion');
        }



        //SIN XML REDIRECCIONAR O OTRA VISTA
        //SERVICIO PUBLICO
        $comprobantesinxml      =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                    ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000027')
                                    ->where('COD_ESTADO','=','1')
                                    ->first();
        if(count($comprobantesinxml)>0){
            return Redirect::to('detalle-comprobante-oc-administrator-sin-xml/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra);
        }
        //IMPORTACION
        if($ordencompra_n->IND_VARIAS_ENTREGAS == 1){
            return Redirect::to('detalle-comprobante-oc-administrator-sin-xml/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra);
        }
        //TICKET
        $comprobantesinxmlt     =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                    ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000035')
                                    ->where('COD_ESTADO','=','1')
                                    ->first();

        if(count($comprobantesinxmlt)>0){
            return Redirect::to('detalle-comprobante-oc-administrator-sin-xml/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra);
        }


        View::share('titulo','REGISTRO DE COMPROBANTE OC: '.$idoc);
        $tiposerie              =   '';

        $banco_id               =   '';
        if(count($fedocumento)>0){
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            //EMPRESA RELACIONADA
            $empresa_relacionada    =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)
                                        ->where('IND_RELACIONADO','=',1)
                                        ->first();


            if(count($empresa_relacionada)>0){
                $banco_id               =   'BAM0000000000011';  
            }


        }else{
            $detallefedocumento     =   array();
            $empresa_relacionada    =   array();
            
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
        $rhxml                  =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                    //->where('IND_OBLIGATORIO','=',1)
                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                    ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                    ->first();


        //dd($rhxml);

        if(count($rhxml)>0){
            $xmlfactura             =   $rhxml->NOM_CATEGORIA_DOCUMENTO;
        }




        if($tiposerie == 'E'){

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                        ->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                        ->get();

        }else{
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                        ->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                        ->get();
        }

        //si es de bellavista y rioja copir la orden de compra
        $ordencompra_f            =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();


        $sourceFile = '\\\\10.1.0.201\cpe\Orden_Compra';
        if($ordencompra_f->COD_CENTRO == 'CEN0000000000004' or $ordencompra_f->COD_CENTRO == 'CEN0000000000006'){
            if($ordencompra_f->COD_CENTRO == 'CEN0000000000004'){
                $sourceFile = '\\\\10.1.7.200\\cpe\\Orden_Compra\\'.$ordencompra->COD_ORDEN.'.pdf';
            }
            if($ordencompra_f->COD_CENTRO == 'CEN0000000000006'){
                $sourceFile = '\\\\10.1.9.43\\cpe\\Orden_Compra\\'.$ordencompra->COD_ORDEN.'.pdf';
            }
            $destinationFile = '\\\\10.1.0.201\\cpe\\Orden_Compra\\'.$ordencompra->COD_ORDEN.'.pdf';

            //dd($sourceFile);

            // Intenta copiar el archivo
            if (file_exists($sourceFile)){
                copy($sourceFile, $destinationFile);
            }
        }

        //encontrar la orden de compra
        $fileordencompra            =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                        ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000001')
                                        ->where('COD_ESTADO','=','1')
                                        ->first();
        $rutafila                   =   "";
        $rutaorden                  =   "";
        //dd($fileordencompra);
        if(count($fileordencompra)>0){
            $directorio = '\\\\10.1.0.201\cpe\Orden_Compra';
            // Nombre del archivo que estás buscando
            $nombreArchivoBuscado = $ordencompra->COD_ORDEN.'.pdf';
            // Escanea el directorio
            $archivos = scandir($directorio);
            // Inicializa una variable para almacenar el resultado
            $archivoEncontrado = false;
            // Recorre la lista de archivos
            foreach ($archivos as $archivo) {
                // Omite los elementos '.' y '..'
                if ($archivo != '.' && $archivo != '..') {
                    // Verifica si el nombre del archivo coincide con el archivo buscado
                    if ($archivo == $nombreArchivoBuscado) {
                        $archivoEncontrado = true;
                        break;
                    }
                }
            }
            // Muestra el resultado
            if ($archivoEncontrado) {
                $rutafila         =   $directorio.'\\'.$nombreArchivoBuscado;
                $rutaorden           =  $rutafila;
            } 
        }

        $fedocumento_x          =   FeDocumento::where('TXT_REFERENCIA','=',$idoc)->first();

        $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;


        $eliminadodoc           =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                        ->where('TIP_DOC','=','E')
                                        ->where('COD_ESTADO','=','0')
                                        ->first();

        if(count($eliminadodoc)>0){
                $rutaorden           =  '';
        }

        $funcion                =   $this;


        $cb_id                  =   '';


        $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra_f->COD_EMPR_CLIENTE)->first();
        $combocb                =   array('' => "Seleccione Cuenta Bancaria");
        $combopagodetraccion    =   array('' => "Seleccione Pago Detraccion", $ordencompra_f->COD_EMPR_CLIENTE => $ordencompra_f->TXT_EMPR_CLIENTE , $ordencompra_f->COD_EMPR => Session::get('empresas')->NOM_EMPR);
        //ANTICIPO
        $COD_EMPR               =   Session::get('empresas')->COD_EMPR;
        $COD_CENTRO             =   '';
        $FEC_CORTE              =   $this->hoy_sh;
        $CLIENTE                =   $ordencompra_f->COD_EMPR_CLIENTE;
        $COD_MONEDA             =   $ordencompra_f->COD_CATEGORIA_MONEDA;
        $monto_anticipo         =   0.00;
        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.OBTENER_ADELANTOS_PROVEEDOR_DETALLADO 
                                                                @COD_EMPR = ?,
                                                                @COD_CENTRO = ?,
                                                                @FEC_CORTE = ?,
                                                                @CLIENTE = ?,
                                                                @COD_MONEDA = ?'
                                                            );
        $stmt->bindParam(1, $COD_EMPR, PDO::PARAM_STR);
        $stmt->bindParam(2, $COD_CENTRO, PDO::PARAM_STR);
        $stmt->bindParam(3, $FEC_CORTE, PDO::PARAM_STR);
        $stmt->bindParam(4, $CLIENTE, PDO::PARAM_STR);
        $stmt->bindParam(5, $COD_MONEDA, PDO::PARAM_STR);
        $stmt->execute();
        $listaanticipo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arrayitem      = array();

        foreach ($listaanticipo as $index => $item) {
            $existeanticipo          =   FeDocumento::where('COD_ANTICIPO','=',$item['COD_HABILITACION'])
                                         ->whereIn('COD_ESTADO',['ETM0000000000002','ETM0000000000003','ETM0000000000004','ETM0000000000005','ETM0000000000008'])
                                         ->first();
            if(count($existeanticipo)<=0){
                $arrayitem               =   $arrayitem + array($item['COD_HABILITACION'] => $item['NRO_SERIE'].'-'.$item['NRO_DOC'].' // '.$item['CAN_SALDO']);
                $monto_anticipo          =   $monto_anticipo + (float)$item['CAN_SALDO']; 
            }
        }
        $comboant               =   array('' => "Seleccione Anticipo")+$arrayitem;


        $rutasuspencion             =   '';
        $fedocumento_suspension     =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('ID_TIPO_DOC','=','R1')->first();
        //VALIDAR QUE SI TIENE CONSTANCIA DE SUSPENSION DE CUARTA LO SUBA SI NO QUE SUBA LA CONSTANCIA
        if(count($fedocumento_suspension)>0){

            if($ordencompra_f->CAN_TOTAL>1500 && $ordencompra_f->CAN_IMPUESTO_RENTA<=0){
                $empresa_susp = STDEmpresa::where('COD_EMPR','=',$ordencompra_f->COD_EMPR_CLIENTE)->first();
                $fecha_orden = $ordencompra_f->FEC_ORDEN;
                $fechaObj = new DateTime($fecha_orden);
                $anio = $fechaObj->format('Y');

                $rentas = DB::table('PRO_RENTA_CUARTA_CATEGORIA')
                    ->where('RUC', $empresa_susp->NRO_DOCUMENTO)
                    ->where('COD_ESTADO', 'ETM0000000000005')
                    ->where('ANIO', $anio)
                    ->first();

                if(count($rentas)<=0){
                    return Redirect::back()->with('errorurl', 'Este Comprobante necesita la suspension de 4ta categoria que este aprobado por contabilidad');
                }else{

                    $arentas = DB::table('ARCHIVOS')
                        ->where('ID_DOCUMENTO', $rentas->ID_DOCUMENTO)
                        ->first();
                    $rutasuspencion = $arentas->URL_ARCHIVO;

                    $doccompras     =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra_f->COD_ORDEN)
                                        ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000034')->where('COD_ESTADO','=',1)->first();
                    if(count($doccompras)<=0){
                        $docasociar                              =   New CMPDocAsociarCompra;
                        $docasociar->COD_ORDEN                   =   $ordencompra_f->COD_ORDEN;
                        $docasociar->COD_CATEGORIA_DOCUMENTO     =   'DCC0000000000034';
                        $docasociar->NOM_CATEGORIA_DOCUMENTO     =   'SUSPENSION DE 4TA CATEGORIA';
                        $docasociar->IND_OBLIGATORIO             =   0;
                        $docasociar->TXT_FORMATO                 =   'PDF';
                        $docasociar->TXT_ASIGNADO                =   'CONTACTO        ';
                        $docasociar->COD_USUARIO_CREA_AUD        =   Session::get('usuario')->id;
                        $docasociar->FEC_USUARIO_CREA_AUD        =   $this->fechaactual;
                        $docasociar->COD_ESTADO                  =   1;
                        $docasociar->TIP_DOC                     =   'N';
                        $docasociar->save();
                    }
                }

            }
            if($rutasuspencion!=''){
                if($tiposerie == 'E'){
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra_f->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004','DCC0000000000034'])
                                                ->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                                ->get();
                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra_f->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003','DCC0000000000034')
                                                ->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                                ->get();
                }  
            }


        }



        return View::make('comprobante/registrocomprobanteadministrator',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'banco_id'              =>  $banco_id,
                            'monto_anticipo'        =>  $monto_anticipo,
                            'comboant'              =>  $comboant,

                            'eliminadodoc'          =>  $eliminadodoc,
                            'combobancos'           =>  $combobancos,
                            'ordencompra_f'         =>  $ordencompra_f,
                            'cb_id'                 =>  $cb_id,
                            'combocb'               =>  $combocb,
                            'empresa'               =>  $empresa,
                            'combopagodetraccion'   =>  $combopagodetraccion,
                            'rutaorden'             =>  $rutaorden,
                            'rutasuspencion'        =>  $rutasuspencion,
                            'fedocumento_x'         =>  $fedocumento_x,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'procedencia'           =>  $procedencia,
                            'xmlfactura'            =>  $xmlfactura,
                            'tp'                    =>  $tp,
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tarchivos'             =>  $tarchivos,
                            'usuario'               =>  $usuario,
                            'rutaorden'             =>  $rutaorden,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }


    public function actionCargarXMLAdministrator($idopcion, $prefijo, $idordencompra,Request $request)
    {

        $file                   =   $request['inputxml'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $procedencia            =   $request['procedencia'];


        if($_POST)
        {
            if (!empty($file)) 
            {
                try{    

                        DB::beginTransaction();
                        $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
                        $fedocumento_t          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();


                        if(count($fedocumento_t)>0){
                            DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                        }


                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $contadorArchivos = Archivo::count();
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      $contadorArchivos.'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;

                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();

                        copy($file->getRealPath(),$rutacompleta);
                        //dd($extractedFile);
                        $path            =   $rutacompleta;


                        //SI TIENE DETRACCION ASIGNAR EL PDF
                        if($ordencompra_t->CAN_DETRACCION>0){
                            $docasociar                              =   New CMPDocAsociarCompra;
                            $docasociar->COD_ORDEN                   =   $ordencompra_t->COD_ORDEN;
                            $docasociar->COD_CATEGORIA_DOCUMENTO     =   'DCC0000000000009';
                            $docasociar->NOM_CATEGORIA_DOCUMENTO     =   'CONSTANCIA DE AUTODETRACCIÓN';
                            $docasociar->IND_OBLIGATORIO             =   1;
                            $docasociar->TXT_FORMATO                 =   'PDF';
                            $docasociar->TXT_ASIGNADO                =   'PROVEEDOR';
                            $docasociar->COD_USUARIO_CREA_AUD        =   Session::get('usuario')->id;
                            $docasociar->FEC_USUARIO_CREA_AUD        =   $this->fechaactual;
                            $docasociar->COD_ESTADO                  =   1;
                            $docasociar->TIP_DOC                     =   'N';
                            $docasociar->save();
                        }


                        $rh              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                                    ->where('COD_ESTADO','=',1)
                                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                                    ->get();


                        if(count($rh)<=0){
                            //FACTURA
                            /****************************************  LEER EL XML Y GUARDAR   *********************************/
                            $parser = new InvoiceParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);



                            $tipo_documento_le = $factura->gettipoDoc();
                            $moneda_le = $factura->gettipoMoneda();
                        }else{
                            //RECIBO POR HONORARIO
                            $parser = new RHParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);  

                            $tipo_documento_le = 'R1';
                            $moneda_le = 'PEN';


                            //VALIDAR QUE SI TIENE CONSTANCIA DE SUSPENSION DE CUARTA LO SUBA SI NO QUE SUBA LA CONSTANCIA
                            if($ordencompra_t->CAN_TOTAL>1500 && $ordencompra_t->CAN_IMPUESTO_RENTA<=0){
                                $empresa_susp = STDEmpresa::where('COD_EMPR','=',$ordencompra_t->COD_EMPR_CLIENTE)->first();
                                $fecha_orden = $ordencompra_t->FEC_ORDEN;
                                $fechaObj = new DateTime($fecha_orden);
                                $anio = $fechaObj->format('Y');
                                $rentas = DB::table('PRO_RENTA_CUARTA_CATEGORIA')
                                    ->where('RUC', $empresa_susp->NRO_DOCUMENTO)
                                    ->where('COD_ESTADO', 'ETM0000000000005')
                                    ->where('ANIO', $anio)
                                    ->first();
                                if(count($rentas)<=0){
                                    return Redirect::back()->with('errorurl', 'Este Comprobante necesita la suspension de 4ta categoria que este aprobado por contabilidad');
                                }

                            }

                        }


                        //dd($factura);


                        //VALIDAR QUE YA EXISTE ESTE XML

                        $fedocumento_e          =   FeDocumento::whereNotIn('COD_ESTADO',['','ETM0000000000006'])
                                                    ->where('RUC_PROVEEDOR','=',$factura->getcompany()->getruc())
                                                    ->where('SERIE','=',$factura->getserie())
                                                    ->where('NUMERO','=',$factura->getcorrelativo())
                                                    ->where('ID_TIPO_DOC','=',$tipo_documento_le)
                                                    ->first();

                        if(count($fedocumento_e)>0){
                            return Redirect::back()->with('errorurl', 'Este XML ya fue integrado en otra orden de compra');
                        }


                        //dd($factura->getClient()->getnumDoc());
                        //dd(Session::get('empresas')->NRO_DOCUMENTO);
                        //VALIDAR QUE EL XML SEA DE LA EMPRESA
                        if(strval($factura->getClient()->getnumDoc()) != strval(Session::get('empresas')->NRO_DOCUMENTO)){
                            return Redirect::back()->with('errorurl', 'El xml no corresponde a la empresa '.Session::get('empresas')->NRO_DOCUMENTO);
                        }
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



                        $rz_p                               =   str_replace(["![CDATA[", "]]"], "", $factura->getcompany()->getrazonSocial());
                        $rz_p                               =   str_replace("?", "Ñ", $rz_p);
                        $rz_p                               =   str_replace("ï¿½", "Ñ", $rz_p);


                        $documentolinea                     =   $this->ge_linea_documento($ordencompra->COD_ORDEN);
                        $cant_rentencion                    =   $ordencompra_t->CAN_RETENCION;
                        $cant_rentencion_cuarta             =   $ordencompra_t->CAN_IMPUESTO_RENTA;
                        $cant_perception                    =   $ordencompra_t->CAN_PERCEPCION;

                        //REGISTRO DEL XML LEIDO
                        $documento                          =   new FeDocumento;
                        $documento->ID_DOCUMENTO            =   $ordencompra->COD_ORDEN;
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
                        $documento->FORMA_PAGO_DIAS          =   $diasdefactura;

                        $documento->MONEDA                  =   $moneda_le;
                        $documento->VALOR_IGV_ORIG          =   $factura->getmtoIGV();
                        $documento->VALOR_IGV_SOLES         =   $factura->getmtoIGV();

                        $documento->SUB_TOTAL_VENTA_ORIG    =   $factura->getmtoOperGravadas();
                        $documento->SUB_TOTAL_VENTA_SOLES   =   $factura->getmtoOperGravadas();

                        $documento->TOTAL_VENTA_XML         =   $factura->getmtoImpVenta();
                        $documento->TOTAL_VENTA_ORIG        =   $ordencompra->CAN_TOTAL;
                        $documento->TOTAL_VENTA_SOLES       =   $factura->getmtoImpVenta();

                        $documento->PERCEPCION              =   $cant_perception;
                        $documento->MONTO_RETENCION         =   $cant_rentencion;
                        $documento->CAN_IMPUESTO_RENTA      =   $cant_rentencion_cuarta;

                        $documento->HORA_EMISION            =   $factura->gethoraEmision();
                        $documento->IMPUESTO_2              =   $factura->getmtoOtrosTributos();
                        $documento->TIPO_DETRACCION         =   $factura->getdetraccion()->gettipoDet();
                        $documento->PORC_DETRACCION         =   (float)$factura->getdetraccion()->getporcDet();
                        $documento->MONTO_DETRACCION        =   (float)$factura->getdetraccion()->getbaseDetr();
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
                        $documento->OPERACION               =   'ORDEN_COMPRA';
                        $documento->MONTO_NC                =   0.00;

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
                                $producto                           = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);
                                $codproducto                        = preg_replace('/[^A-Za-z0-9\s]/', '', $itemdet->getcodProducto());


                                $linea = str_pad($indexdet+1, 3, "0", STR_PAD_LEFT); 
                                $detalle                        =   new FeDetalleDocumento;
                                $detalle->ID_DOCUMENTO          =   $ordencompra->COD_ORDEN;
                                $detalle->DOCUMENTO_ITEM        =   $documentolinea;

                                $detalle->LINEID                =   $linea;
                                $detalle->CODPROD               =   $codproducto;
                                $detalle->PRODUCTO              =   $producto;
                                $detalle->UND_PROD              =   $itemdet->getunidad();
                                $detalle->CANTIDAD              =   (float)$itemdet->getcantidad();
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
                        //dd($factura->getdetails());
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


                        $fedocumento         =      FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','<>','ETM0000000000006')->first();
                        $fechaemision        =      date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                        $detallefedocumento  =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();



                        //VALIDAR QUE ALGUNOS CAMPOS SEAN IGUALES
                        $this->con_validar_documento_proveedor($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento);

                        $token = '';
                        if($prefijocarperta =='II'){
                            $token           =      $this->generartoken_ii();
                        }else{
                            $token           =      $this->generartoken_is();
                        }

                        if(count($rh)<=0){
                            //FACTURA
                            $rvalidar = $this->validar_xml( $token,
                                                            $fedocumento->ID_CLIENTE,
                                                            $fedocumento->RUC_PROVEEDOR,
                                                            $fedocumento->ID_TIPO_DOC,
                                                            $fedocumento->SERIE,
                                                            $fedocumento->NUMERO,
                                                            $fechaemision,
                                                            $fedocumento->TOTAL_VENTA_ORIG);
                        }else{
                            //RECIBO POR HONORARIO
                            $rvalidar = $this->validar_xml( $token,
                                                            $fedocumento->ID_CLIENTE,
                                                            $fedocumento->RUC_PROVEEDOR,
                                                            $fedocumento->ID_TIPO_DOC,
                                                            $fedocumento->SERIE,
                                                            $fedocumento->NUMERO,
                                                            $fechaemision,
                                                            $fedocumento->TOTAL_VENTA_ORIG+$fedocumento->MONTO_RETENCION);
                        }

                        $arvalidar = json_decode($rvalidar, true);
                        if(isset($arvalidar['success'])){

                            if($arvalidar['success']){

                                $datares              = $arvalidar['data'];
                                if (!isset($datares['estadoCp'])){
                                    return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                                }
                                
                                $estadoCp             = $datares['estadoCp'];


                                $tablaestacp          = Estado::where('tipo','=','estadoCp')->where('codigo','=',$estadoCp)->first();
                                //dd($tablaestacp);
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

                                if($tablaestacp->codigo =='0' && $fedocumento->ID_TIPO_DOC == 'R1'){

                                    FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
                                                ->update(
                                                        [
                                                            'success'=>$arvalidar['success'],
                                                            'message'=>$arvalidar['message'],
                                                            'estadoCp'=>'1',
                                                            'nestadoCp'=>'ACEPTADO',
                                                            'estadoRuc'=>'00',
                                                            'nestadoRuc'=>'ACTIVO',
                                                            'condDomiRuc'=>'00',
                                                            'ncondDomiRuc'=>'HABIDO',
                                                        ]);

                                }



                            }else{
                                FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
                                            ->update(
                                                    [
                                                        'success'=>$arvalidar['success'],
                                                        'message'=>$arvalidar['message']
                                                    ]);
                            }
                        }
                        
                        //dd("hola");
                        DB::commit();

                }catch(\Exception $ex){
                    DB::rollback(); 
                    return Redirect::to('detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
                }
                return Redirect::to('detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Se valido el xml');
            }else{
                return Redirect::to('detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo XML a Importar ');
            }

        }
    }

    public function actionCargarXMLContratoAdministrator($idopcion, $prefijo, $idordencompra,Request $request)
    {

        $file                   =   $request['inputxml'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $procedencia            =   $request['procedencia'];
        $documento_id           =   $request['documento_id'];

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
                        $contadorArchivos = Archivo::count();
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      $contadorArchivos.'-'.$file->getClientOriginalName();
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
                            $parser             = new InvoiceParser();
                            $xml                = file_get_contents($path);
                            $factura            = $parser->parse($xml);

                            $tipo_documento_le  = $factura->gettipoDoc();
                            $moneda_le          = $factura->gettipoMoneda();

                            $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                            ->whereIn('COD_CATEGORIA', ['DCC0000000000026','DCC0000000000002','DCC0000000000003','DCC0000000000004','DCC0000000000008','DCC0000000000009'])
                                                            ->get();


                        }else{

                            //RECIBO POR HONORARIO
                            $parser = new RHParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);  

                            $tipo_documento_le = 'R1';
                            $moneda_le = 'PEN';

                            $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                            ->whereIn('COD_CATEGORIA', ['DCC0000000000026','DCC0000000000013','DCC0000000000003','DCC0000000000008','DCC0000000000009'])->get();

                        }





                        //VALIDAR QUE YA EXISTE ESTE XML

                        $fedocumento_e          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->whereNotIn('COD_ESTADO',['','ETM0000000000006'])
                                                    ->where('RUC_PROVEEDOR','=',$factura->getcompany()->getruc())
                                                    ->where('SERIE','=',$factura->getserie())
                                                    ->where('NUMERO','=',$factura->getcorrelativo())
                                                    ->where('ID_TIPO_DOC','=',$tipo_documento_le)
                                                    ->first();
                        if(count($fedocumento_e)>0){
                            return Redirect::back()->with('errorurl', 'Este XML ya fue integrado en otra orden de compra');
                        }

                        //VALIDAR QUE EL XML SEA DE LA EMPRESA
                        if($factura->getClient()->getnumDoc()!= Session::get('empresas')->NRO_DOCUMENTO){
                            return Redirect::back()->with('errorurl', 'El xml no corresponde a la empresa '.Session::get('empresas')->NRO_DOCUMENTO);
                        }

                        $rz_p                               =   str_replace(["![CDATA[", "]]"], "", $factura->getcompany()->getrazonSocial());
                        $rz_p                               =    str_replace("?", "Ñ", $rz_p);
                        $rz_p                               =   str_replace("ï¿½", "Ñ", $rz_p);
                        $rz_p                               =   str_replace("MARILÑ", "MARILÚ", $rz_p);

                        $documentolinea                     =   $this->ge_linea_documento($ordencompra->COD_DOCUMENTO_CTBLE);
                        //$cant_rentencion                    =   $ordencompra_t->CAN_RETENCION;
                        //$cant_perception                    =   $factura->getperception();
                        $cant_perception                    =   0;
                        $cant_rentencion                    =   0;


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
                        $documento->TOTAL_VENTA_XML         =   $factura->getmtoImpVenta();

                        $documento->TOTAL_VENTA_ORIG        =   $ordencompra->CAN_TOTAL;
                        $documento->TOTAL_VENTA_SOLES       =   $factura->getmtoImpVenta();


                        $documento->PERCEPCION              =   $cant_perception;
                        $documento->MONTO_RETENCION         =   $cant_rentencion;

                        $documento->HORA_EMISION            =   $factura->gethoraEmision();
                        $documento->IMPUESTO_2              =   $factura->getmtoOtrosTributos();
                        $documento->TIPO_DETRACCION         =   $factura->getdetraccion()->gettipoDet();
                        $documento->PORC_DETRACCION         =   floatval($factura->getdetraccion()->getporcDet());
                        $documento->MONTO_DETRACCION        =   (float)$factura->getdetraccion()->getbaseDetr();
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
                        $documento->MONTO_NC                =   0.00;
                        
                        $documento->save();


                        //dd("entro");
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


                        $token = '';
                        if($prefijocarperta =='II'){
                            $token           =      $this->generartoken_ii();
                        }else{
                            $token           =      $this->generartoken_is();
                        }

                        //dd($token);

                        $rvalidar = $this->validar_xml( $token,
                                                        $fedocumento->ID_CLIENTE,
                                                        $fedocumento->RUC_PROVEEDOR,
                                                        $fedocumento->ID_TIPO_DOC,
                                                        $fedocumento->SERIE,
                                                        $fedocumento->NUMERO,
                                                        $fechaemision,
                                                        $fedocumento->TOTAL_VENTA_ORIG);

                        $arvalidar = json_decode($rvalidar, true);

                        //dd($arvalidar);

                        if(isset($arvalidar['success'])){

                            if($arvalidar['success']){



                                $datares              = $arvalidar['data'];

                                if (!isset($datares['estadoCp'])){
                                    return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                                }

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

                                FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)
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
                                FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)
                                            ->update(
                                                    [
                                                        'success'=>$arvalidar['success'],
                                                        'message'=>$arvalidar['message']
                                                    ]);
                            }
                        }
                        

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
                    return Redirect::to('detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
                }
                return Redirect::to('detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Se valido el xml');
            }else{
                return Redirect::to('detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo XML a Importar ');
            }

        }
    }

    public function actionCargarXMLNotaCreditoAdministrator($idopcion, $prefijo, $idordencompra,Request $request)
    {

        $file                   =   $request['inputxml'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_credito_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);
        $procedencia            =   $request['procedencia'];
        

        if($_POST)
        {
            if (!empty($file)) 
            {
                try{    

                        DB::beginTransaction();
                        $ordencompra_t          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();
                        $referenciaasoc         =   CMPReferecenciaAsoc::where('COD_TABLA','=',$idoc)->first();
                        $ordencompra_f          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$referenciaasoc->COD_TABLA_ASOC)->first();
                        
                        if($ordencompra_t->CAN_TOTAL>$ordencompra_f->CAN_TOTAL){
                            return Redirect::back()->with('errorurl', 'El importe de la nota de crédito no puede ser mayor a la factura relacionada');
                        }

                        if($ordencompra_t->COD_EMPR_EMISOR!=$ordencompra_f->COD_EMPR_EMISOR){
                            return Redirect::back()->with('errorurl', 'El RUC del proveedor en la Nota de crédito , debe ser igual al de la factura relacionada');
                        }

                        $fedocumento_t          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();

                        if(count($fedocumento_t)>0){
                            DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                        }

                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $contadorArchivos = Archivo::count();
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      $contadorArchivos.'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;

                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();

                        copy($file->getRealPath(),$rutacompleta);
                        //dd($extractedFile);
                        $path            =   $rutacompleta;


                        //FACTURA
                        /****************************************  LEER EL XML Y GUARDAR   *********************************/
                        $parser             = new NoteParser();
                        $xml                = file_get_contents($path);
                        $factura            = $parser->parse($xml);
                        //dd($factura);
                        $tipo_documento_le  = $factura->gettipoDoc();
                        $moneda_le          = $factura->gettipoMoneda();

                        if($ordencompra->COD_CATEGORIA_MOTIVO_EMISION=='MEM0000000000004' || $ordencompra->COD_CATEGORIA_MOTIVO_EMISION=='MEM0000000000007'){
                            $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000003','DCC0000000000004','DCC0000000000030','DCC0000000000007'])
                                                        ->get();
                        }else{                            
                            $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000003','DCC0000000000004','DCC0000000000030'])
                                                        ->get();
                        }


                        //VALIDAR QUE YA EXISTE ESTE XML

                        $fedocumento_e          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->whereNotIn('COD_ESTADO',['','ETM0000000000006'])
                                                    ->where('RUC_PROVEEDOR','=',$factura->getcompany()->getruc())
                                                    ->where('SERIE','=',$factura->getserie())
                                                    ->where('NUMERO','=',$factura->getcorrelativo())
                                                    ->where('ID_TIPO_DOC','=',$tipo_documento_le)
                                                    ->first();
                        if(count($fedocumento_e)>0){
                            return Redirect::back()->with('errorurl', 'Este XML ya fue integrado en otra orden de compra');
                        }

                        //VALIDAR QUE EL XML SEA DE LA EMPRESA
                        if($factura->getClient()->getnumDoc()!= Session::get('empresas')->NRO_DOCUMENTO){
                            return Redirect::back()->with('errorurl', 'El xml no corresponde a la empresa '.Session::get('empresas')->NRO_DOCUMENTO);
                        }

                        $rz_p                               =   str_replace(["![CDATA[", "]]"], "", $factura->getcompany()->getrazonSocial());
                        $rz_p                               =    str_replace("?", "Ñ", $rz_p);
                        $rz_p                               =   str_replace("ï¿½", "Ñ", $rz_p);
                        $rz_p                               =   str_replace("MARILÑ", "MARILÚ", $rz_p);

                        $documentolinea                     =   $this->ge_linea_documento($ordencompra->COD_DOCUMENTO_CTBLE);
                        //$cant_rentencion                    =   $ordencompra_t->CAN_RETENCION;
                        //$cant_perception                    =   $factura->getperception();
                        $cant_perception                    =   0;
                        $cant_rentencion                    =   0;


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
                        $documento->FEC_VENCI_PAGO          =   $factura->getfechaEmision()->format('Ymd');
                        //$documento->FORMA_PAGO              =   $factura->getcondicionPago();
                        $documento->FORMA_PAGO              =   '';
                        $documento->FORMA_PAGO_DIAS          =  0;
                        $documento->MONEDA                  =   $moneda_le;

                        $documento->VALOR_IGV_ORIG          =   $factura->getmtoIGV();
                        $documento->VALOR_IGV_SOLES         =   $factura->getmtoIGV();
                        $documento->SUB_TOTAL_VENTA_ORIG    =   $factura->getmtoOperGravadas();
                        $documento->SUB_TOTAL_VENTA_SOLES   =   $factura->getmtoOperGravadas();
                        $documento->TOTAL_VENTA_XML         =   $factura->getmtoImpVenta();

                        $documento->TOTAL_VENTA_ORIG        =   $ordencompra->CAN_TOTAL;
                        $documento->TOTAL_VENTA_SOLES       =   $factura->getmtoImpVenta();


                        $documento->PERCEPCION              =   $cant_perception;
                        $documento->MONTO_RETENCION         =   $cant_rentencion;

                        $documento->HORA_EMISION            =   $factura->gethoraEmision();
                        $documento->IMPUESTO_2              =   $factura->getmtoOtrosTributos();
                        //$documento->TIPO_DETRACCION         =   $factura->getdetraccion()->gettipoDet();
                        //$documento->PORC_DETRACCION         =   floatval($factura->getdetraccion()->getporcDet());
                        //$documento->MONTO_DETRACCION        =   (float)$factura->getdetraccion()->getbaseDetr();
                        //$documento->MONTO_ANTICIPO          =   $factura->getdestotalAnticipos();
                        //$documento->OBSERVACION             =   $factura->getobservacion();
                        //$documento->NRO_ORDEN_COMP          =   $factura->getcompra();              
                        //$documento->NUM_GUIA                =   $factura->getguiaEmbebida();


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
                        $documento->OPERACION               =   'NOTA_CREDITO';
                        $documento->MONTO_NC                =   0.00;
                        
                        $documento->save();


                        //dd("entro");
                        //ARCHIVO
                        $dcontrol                   =   new Archivo;
                        $dcontrol->ID_DOCUMENTO     =   $ordencompra->COD_DOCUMENTO_CTBLE;
                        $dcontrol->DOCUMENTO_ITEM   =   $documentolinea;
                        $dcontrol->TIPO_ARCHIVO     =   'DCC0000000000003';
                        $dcontrol->NOMBRE_ARCHIVO   =   $nombrefile;
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'XML DE NOTA DE CREDITO';
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

                        /****************************************  VALIDAR SI EL ARCHIVO ESTA ACEPTADO POR SUNAT  *********************************/


                        $fedocumento         =      FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','<>','ETM0000000000006')->first();
                        $fechaemision        =      date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                        $detallefedocumento  =      FeDetalleDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


                        //VALIDAR QUE ALGUNOS CAMPOS SEAN IGUALES
                        $this->con_validar_documento_proveedor_nota_credito($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento);


                        $token = '';
                        if($prefijocarperta =='II'){
                            $token           =      $this->generartoken_ii();
                        }else{
                            $token           =      $this->generartoken_is();
                        }

                        //dd($token);

                        $rvalidar = $this->validar_xml( $token,
                                                        $fedocumento->ID_CLIENTE,
                                                        $fedocumento->RUC_PROVEEDOR,
                                                        $fedocumento->ID_TIPO_DOC,
                                                        $fedocumento->SERIE,
                                                        $fedocumento->NUMERO,
                                                        $fechaemision,
                                                        $fedocumento->TOTAL_VENTA_ORIG);

                        $arvalidar = json_decode($rvalidar, true);

                        //dd($arvalidar);

                        if(isset($arvalidar['success'])){

                            if($arvalidar['success']){



                                $datares              = $arvalidar['data'];

                                if (!isset($datares['estadoCp'])){
                                    return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                                }

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

                                FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)
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
                                FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)
                                            ->update(
                                                    [
                                                        'success'=>$arvalidar['success'],
                                                        'message'=>$arvalidar['message']
                                                    ]);
                            }
                        }
                        

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
                    return Redirect::to('detalle-comprobante-nota-credito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
                }
                return Redirect::to('detalle-comprobante-nota-credito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Se valido el xml');
            }else{
                return Redirect::to('detalle-comprobante-nota-credito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo XML a Importar ');
            }

        }
    }

    public function actionCargarXMLNotaDebitoAdministrator($idopcion, $prefijo, $idordencompra,Request $request)
    {

        $file                   =   $request['inputxml'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_debito_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);
        $procedencia            =   $request['procedencia'];
        

        if($_POST)
        {
            if (!empty($file)) 
            {
                try{    

                        DB::beginTransaction();
                        $ordencompra_t          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();
                        $referenciaasoc         =   CMPReferecenciaAsoc::where('COD_TABLA','=',$idoc)->first();
                        $ordencompra_f          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$referenciaasoc->COD_TABLA_ASOC)->first();
                        
                        if($ordencompra_t->CAN_TOTAL>$ordencompra_f->CAN_TOTAL){
                            return Redirect::back()->with('errorurl', 'El importe de la nota de debito no puede ser mayor a la factura relacionada');
                        }

                        if($ordencompra_t->COD_EMPR_EMISOR!=$ordencompra_f->COD_EMPR_EMISOR){
                            return Redirect::back()->with('errorurl', 'El RUC del proveedor en la Nota de debito , debe ser igual al de la factura relacionada');
                        }

                        $fedocumento_t          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();

                        if(count($fedocumento_t)>0){
                            DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                            DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
                        }

                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $contadorArchivos = Archivo::count();
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      $contadorArchivos.'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;

                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();

                        copy($file->getRealPath(),$rutacompleta);
                        //dd($extractedFile);
                        $path            =   $rutacompleta;


                        //FACTURA
                        /****************************************  LEER EL XML Y GUARDAR   *********************************/
                        $parser             = new NoteParser();
                        $xml                = file_get_contents($path);
                        $factura            = $parser->parse($xml);
                        //dd($factura);
                        $tipo_documento_le  = $factura->gettipoDoc();
                        $moneda_le          = $factura->gettipoMoneda();

                        if($ordencompra->COD_CATEGORIA_MOTIVO_EMISION=='MEM0000000000004' || $ordencompra->COD_CATEGORIA_MOTIVO_EMISION=='MEM0000000000007'){
                            $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000003','DCC0000000000004','DCC0000000000030','DCC0000000000007'])
                                                        ->get();
                        }else{                            
                            $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000003','DCC0000000000004','DCC0000000000030'])
                                                        ->get();
                        }


                        //VALIDAR QUE YA EXISTE ESTE XML

                        $fedocumento_e          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->whereNotIn('COD_ESTADO',['','ETM0000000000006'])
                                                    ->where('RUC_PROVEEDOR','=',$factura->getcompany()->getruc())
                                                    ->where('SERIE','=',$factura->getserie())
                                                    ->where('NUMERO','=',$factura->getcorrelativo())
                                                    ->where('ID_TIPO_DOC','=',$tipo_documento_le)
                                                    ->first();
                        if(count($fedocumento_e)>0){
                            return Redirect::back()->with('errorurl', 'Este XML ya fue integrado en otra orden de compra');
                        }

                        //VALIDAR QUE EL XML SEA DE LA EMPRESA
                        if($factura->getClient()->getnumDoc()!= Session::get('empresas')->NRO_DOCUMENTO){
                            return Redirect::back()->with('errorurl', 'El xml no corresponde a la empresa '.Session::get('empresas')->NRO_DOCUMENTO);
                        }

                        $rz_p                               =   str_replace(["![CDATA[", "]]"], "", $factura->getcompany()->getrazonSocial());
                        $rz_p                               =    str_replace("?", "Ñ", $rz_p);
                        $rz_p                               =   str_replace("ï¿½", "Ñ", $rz_p);
                        $rz_p                               =   str_replace("MARILÑ", "MARILÚ", $rz_p);

                        $documentolinea                     =   $this->ge_linea_documento($ordencompra->COD_DOCUMENTO_CTBLE);
                        //$cant_rentencion                    =   $ordencompra_t->CAN_RETENCION;
                        //$cant_perception                    =   $factura->getperception();
                        $cant_perception                    =   0;
                        $cant_rentencion                    =   0;


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
                        $documento->FEC_VENCI_PAGO          =   $factura->getfechaEmision()->format('Ymd');
                        //$documento->FORMA_PAGO              =   $factura->getcondicionPago();
                        $documento->FORMA_PAGO              =   '';
                        $documento->FORMA_PAGO_DIAS          =  0;
                        $documento->MONEDA                  =   $moneda_le;

                        $documento->VALOR_IGV_ORIG          =   $factura->getmtoIGV();
                        $documento->VALOR_IGV_SOLES         =   $factura->getmtoIGV();
                        $documento->SUB_TOTAL_VENTA_ORIG    =   $factura->getmtoOperGravadas();
                        $documento->SUB_TOTAL_VENTA_SOLES   =   $factura->getmtoOperGravadas();
                        $documento->TOTAL_VENTA_XML         =   $factura->getmtoImpVenta();

                        $documento->TOTAL_VENTA_ORIG        =   $ordencompra->CAN_TOTAL;
                        $documento->TOTAL_VENTA_SOLES       =   $factura->getmtoImpVenta();


                        $documento->PERCEPCION              =   $cant_perception;
                        $documento->MONTO_RETENCION         =   $cant_rentencion;

                        $documento->HORA_EMISION            =   $factura->gethoraEmision();
                        $documento->IMPUESTO_2              =   $factura->getmtoOtrosTributos();
                        //$documento->TIPO_DETRACCION         =   $factura->getdetraccion()->gettipoDet();
                        //$documento->PORC_DETRACCION         =   floatval($factura->getdetraccion()->getporcDet());
                        //$documento->MONTO_DETRACCION        =   (float)$factura->getdetraccion()->getbaseDetr();
                        //$documento->MONTO_ANTICIPO          =   $factura->getdestotalAnticipos();
                        //$documento->OBSERVACION             =   $factura->getobservacion();
                        //$documento->NRO_ORDEN_COMP          =   $factura->getcompra();              
                        //$documento->NUM_GUIA                =   $factura->getguiaEmbebida();


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
                        $documento->OPERACION               =   'NOTA_DEBITO';
                        $documento->MONTO_NC                =   0.00;
                        
                        $documento->save();


                        //dd("entro");
                        //ARCHIVO
                        $dcontrol                   =   new Archivo;
                        $dcontrol->ID_DOCUMENTO     =   $ordencompra->COD_DOCUMENTO_CTBLE;
                        $dcontrol->DOCUMENTO_ITEM   =   $documentolinea;
                        $dcontrol->TIPO_ARCHIVO     =   'DCC0000000000003';
                        $dcontrol->NOMBRE_ARCHIVO   =   $nombrefile;
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'XML DE NOTA DE DEBITO';
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

                        /****************************************  VALIDAR SI EL ARCHIVO ESTA ACEPTADO POR SUNAT  *********************************/


                        $fedocumento         =      FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','<>','ETM0000000000006')->first();
                        $fechaemision        =      date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                        $detallefedocumento  =      FeDetalleDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


                        //VALIDAR QUE ALGUNOS CAMPOS SEAN IGUALES
                        $this->con_validar_documento_proveedor_nota_debito($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento);


                        $token = '';
                        if($prefijocarperta =='II'){
                            $token           =      $this->generartoken_ii();
                        }else{
                            $token           =      $this->generartoken_is();
                        }

                        //dd($token);

                        $rvalidar = $this->validar_xml( $token,
                                                        $fedocumento->ID_CLIENTE,
                                                        $fedocumento->RUC_PROVEEDOR,
                                                        $fedocumento->ID_TIPO_DOC,
                                                        $fedocumento->SERIE,
                                                        $fedocumento->NUMERO,
                                                        $fechaemision,
                                                        $fedocumento->TOTAL_VENTA_ORIG);

                        $arvalidar = json_decode($rvalidar, true);

                        //dd($arvalidar);

                        if(isset($arvalidar['success'])){

                            if($arvalidar['success']){



                                $datares              = $arvalidar['data'];

                                if (!isset($datares['estadoCp'])){
                                    return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                                }

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

                                FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)
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
                                FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)
                                            ->update(
                                                    [
                                                        'success'=>$arvalidar['success'],
                                                        'message'=>$arvalidar['message']
                                                    ]);
                            }
                        }
                        

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
                    return Redirect::to('detalle-comprobante-nota-debito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
                }
                return Redirect::to('detalle-comprobante-nota-debito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Se valido el xml');
            }else{
                return Redirect::to('detalle-comprobante-nota-debito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo XML a Importar ');
            }

        }
    }

    public function actionValidarXMLAdministrator($idopcion, $prefijo, $idordencompra,Request $request)
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

                //dd("hola");

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

                //LECTURA DEL CDR
                if(!is_null($filescdr)){

                    foreach($filescdr as $file){

                        $contadorArchivos = Archivo::count();
                        $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
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
                        $dcontrol->TIPO_ARCHIVO         =   'DCC0000000000004';
                        $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'CDR';


                        $dcontrol->URL_ARCHIVO      =   $path;
                        $dcontrol->SIZE             =   filesize($file);
                        $dcontrol->EXTENSION        =   $extension;
                        $dcontrol->ACTIVO           =   1;
                        $dcontrol->FECHA_CREA       =   $this->fechaactual;
                        $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                        $dcontrol->save();
                    }


                    $extractedFile = $rutacompleta;

                    if (file_exists($extractedFile)) {

                        //cbc
                        $xml = simplexml_load_file($extractedFile);

                        //dd($xml);

                        $cbc = 0;
                        $namespaces = $xml->getNamespaces(true);
                        foreach ($namespaces as $prefix => $namespace) {
                            if('cbc'==$prefix){
                                $cbc = 1;  
                            }
                        }
                        $codigocdr = '';  
                        if($cbc>=1){
                            foreach($xml->xpath('//cbc:ResponseCode') as $ResponseCode)
                            {
                                $codigocdr  = (string)$ResponseCode;
                            }
                            foreach($xml->xpath('//cbc:Description') as $Description)
                            {
                                $respuestacdr  = $Description;
                            }
                            foreach($xml->xpath('//cbc:ID') as $ID)
                            {
                                $factura_cdr_id  = (string)$ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }  
                        }else{
                            //dd("hola2");
                            $xml_ns = simplexml_load_file($extractedFile);

                            // Namespace definitions
                            $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                            $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                            // Register namespaces
                            $xml_ns->registerXPathNamespace('ns4', $ns4);
                            $xml_ns->registerXPathNamespace('ns3', $ns3);
                            // Querying XML
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
                            {
                                $codigocdr  = (string)$ResponseCodes->ResponseCode;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
                            {
                                $respuestacdr  = $Description->Description;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentReference') as $ID)
                            {
                                $factura_cdr_id  = (string)$ID->ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }

                        }
                        if($codigocdr!="0"){
                            return Redirect::to('detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Error en la lectura CDR');
                        }
                    } else {
                        return Redirect::to('detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Error en el CDR');
                    }

                    if($sw == 0){
                        return Redirect::to('detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') no coincide con la factura ('.$nombre_doc.')');
                    }


                    if (strpos($respuestacdr, 'observaciones') !== false) {
                        return Redirect::to('detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') tiene observaciones');
                    }


                }

                //guardar orden de compra precargada
                $rutaorden       =   $request['rutaorden'];
                if($rutaorden!=''){

                    $aoc                            =       CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000001'])
                                                            ->first();
                    $contadorArchivos = Archivo::count();
                    $nombrefilecdr                  =       $contadorArchivos.'-'.$ordencompra->COD_ORDEN.'.pdf';
                    $prefijocarperta                =       $this->prefijo_empresa($ordencompra->COD_EMPR);
                    $rutafile                       =       $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                    $rutacompleta                   =       $rutafile.'\\'.$nombrefilecdr;
                    $valor                          =       $this->versicarpetanoexiste($rutafile);
                    $path                           =       $rutacompleta;
                    //$directorio                     =       '\\\\10.1.0.201\cpe\Orden_Compra';
                    //$rutafila                       =       $directorio.'\\'.$nombreArchivoBuscado;
                    copy($rutaorden,$rutacompleta);
                    $dcontrol                       =       new Archivo;
                    $dcontrol->ID_DOCUMENTO         =       $ordencompra->COD_ORDEN;
                    $dcontrol->DOCUMENTO_ITEM       =       $fedocumento->DOCUMENTO_ITEM;
                    $dcontrol->TIPO_ARCHIVO         =       $aoc->COD_CATEGORIA_DOCUMENTO;
                    $dcontrol->NOMBRE_ARCHIVO       =       $nombrefilecdr;
                    $dcontrol->DESCRIPCION_ARCHIVO  =       $aoc->NOM_CATEGORIA_DOCUMENTO;
                    $dcontrol->URL_ARCHIVO          =       $path;
                    $dcontrol->SIZE                 =       100;
                    $dcontrol->EXTENSION            =       '.pdf';
                    $dcontrol->ACTIVO               =       1;
                    $dcontrol->FECHA_CREA           =       $this->fechaactual;
                    $dcontrol->USUARIO_CREA         =       Session::get('usuario')->id;
                    $dcontrol->save();

                }

                //guardar orden de compra precargada
                $rutasuspencion       =   $request['rutasuspencion'];
                if($rutasuspencion!=''){

                    $aoc                            =       CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000034'])
                                                            ->first();
                    $contadorArchivos               =       Archivo::count();
                    $nombrefilecdr                  =       $contadorArchivos.'-'.$ordencompra->COD_ORDEN.'.pdf';
                    $prefijocarperta                =       $this->prefijo_empresa($ordencompra->COD_EMPR);
                    $rutafile                       =       $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                    $rutacompleta                   =       $rutafile.'\\'.$nombrefilecdr;
                    $valor                          =       $this->versicarpetanoexiste($rutafile);
                    $path                           =       $rutacompleta;
                    //$directorio                     =       '\\\\10.1.0.201\cpe\Orden_Compra';
                    //$rutafila                       =       $directorio.'\\'.$nombreArchivoBuscado;
                    copy($rutasuspencion,$rutacompleta);
                    $dcontrol                       =       new Archivo;
                    $dcontrol->ID_DOCUMENTO         =       $ordencompra->COD_ORDEN;
                    $dcontrol->DOCUMENTO_ITEM       =       $fedocumento->DOCUMENTO_ITEM;
                    $dcontrol->TIPO_ARCHIVO         =       $aoc->COD_CATEGORIA_DOCUMENTO;
                    $dcontrol->NOMBRE_ARCHIVO       =       $nombrefilecdr;
                    $dcontrol->DESCRIPCION_ARCHIVO  =       $aoc->NOM_CATEGORIA_DOCUMENTO;
                    $dcontrol->URL_ARCHIVO          =       $path;
                    $dcontrol->SIZE                 =       100;
                    $dcontrol->EXTENSION            =       '.pdf';
                    $dcontrol->ACTIVO               =       1;
                    $dcontrol->FECHA_CREA           =       $this->fechaactual;
                    $dcontrol->USUARIO_CREA         =       Session::get('usuario')->id;
                    $dcontrol->save();

                }


                $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                if($tiposerie == 'E'){
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                //->where('IND_OBLIGATORIO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                                ->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                                ->get();
                //dd($tarchivos);

                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                //->where('IND_OBLIGATORIO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                                ->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                                ->get();
                }
                //dd($tarchivos);
                foreach($tarchivos as $index => $item){
                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();
                            $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
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
                    }
                }

                $contacto                                 =   SGDUsuario::where('COD_TRABAJADOR','=',$contacto_id)->first();
                $trabajador                               =   STDTrabajador::where('COD_TRAB','=',$contacto->COD_TRABAJADOR)->first();
                //$contacto                               =   User::where('id','=',$contacto_id)->first();

                $ordencompra_t                            =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();

                $entidadbanco_id   =   $request['entidadbanco_id'];
                $bancocategoria    =   CMPCategoria::where('COD_CATEGORIA','=',$entidadbanco_id)->first();
                $cb_id             =   $request['cb_id'];


                $ctadetraccion                            =   $request['ctadetraccion'];
                $monto_detraccion                         =   $request['monto_detraccion'];
                $pago_detraccion                          =   $request['pago_detraccion'];

                $empresa_sel                              =   STDEmpresa::where('COD_EMPR','=',$pago_detraccion)->first();
                $COD_PAGO_DETRACCION = '';
                $TXT_PAGO_DETRACCION = '';
                if(count($empresa_sel)>0){
                    $COD_PAGO_DETRACCION = $empresa_sel->COD_EMPR;
                    $TXT_PAGO_DETRACCION = $empresa_sel->NOM_EMPR;
                }

                if($ctadetraccion!=''){
                    STDEmpresa::where('COD_EMPR',$ordencompra_t->COD_EMPR_CLIENTE)
                                ->update(
                                    [
                                        'TXT_DETRACCION'=>$ctadetraccion
                                    ]
                                );
                }


                $monto_anticipo_txt     =   $request['monto_anticipo'];
                $MONTO_ANTICIPO_DESC    =   0.00;
                $COD_ANTICIPO           =   '';
                $SERIE_ANTICIPO         =   '';
                $NRO_ANTICIPO           =   '';


                if($monto_anticipo_txt!=''){

                    $COD_EMPR               =   Session::get('empresas')->COD_EMPR;
                    $COD_CENTRO             =   '';
                    $FEC_CORTE              =   $this->hoy_sh;
                    $CLIENTE                =   $ordencompra_t->COD_EMPR_CLIENTE;
                    $COD_MONEDA             =   $ordencompra_t->COD_CATEGORIA_MONEDA;
                    $monto_anticipo         =   0.00;
                    //print_r("entro");

                    $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.OBTENER_ADELANTOS_PROVEEDOR_DETALLADO 
                                                                            @COD_EMPR = ?,
                                                                            @COD_CENTRO = ?,
                                                                            @FEC_CORTE = ?,
                                                                            @CLIENTE = ?,
                                                                            @COD_MONEDA = ?'
                                                                        );
                    $stmt->bindParam(1, $COD_EMPR, PDO::PARAM_STR);
                    $stmt->bindParam(2, $COD_CENTRO, PDO::PARAM_STR);
                    $stmt->bindParam(3, $FEC_CORTE, PDO::PARAM_STR);
                    $stmt->bindParam(4, $CLIENTE, PDO::PARAM_STR);
                    $stmt->bindParam(5, $COD_MONEDA, PDO::PARAM_STR);
                    $stmt->execute();
                    $listaanticipo = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $arrayitem      = array();


                    foreach ($listaanticipo as $index => $item) {
                        if($item['COD_HABILITACION'] == $monto_anticipo_txt){
                            $MONTO_ANTICIPO_DESC = (float)$item['CAN_SALDO'];
                            $COD_ANTICIPO = $item['COD_HABILITACION'];
                            $SERIE_ANTICIPO = $item['NRO_SERIE'];
                            $NRO_ANTICIPO = $item['NRO_DOC'];
                        }
                    }
                }






                FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [
                                    'COD_CATEGORIA_BANCO'=>$bancocategoria->COD_CATEGORIA,
                                    'TXT_CATEGORIA_BANCO'=>$bancocategoria->NOM_CATEGORIA,
                                    'TXT_NRO_CUENTA_BANCARIA'=>$cb_id,
                                    'ARCHIVO_CDR'=>'',
                                    'ARCHIVO_PDF'=>'',

                                    'MONTO_ANTICIPO_DESC'=>$MONTO_ANTICIPO_DESC,
                                    'COD_ANTICIPO'=>$COD_ANTICIPO,
                                    'SERIE_ANTICIPO'=>$SERIE_ANTICIPO,
                                    'NRO_ANTICIPO'=>$NRO_ANTICIPO,


                                    'CTA_DETRACCION'=>$ctadetraccion,
                                    'MONTO_DETRACCION_XML'=>$monto_detraccion,
                                    'MONTO_DETRACCION_RED'=>round($monto_detraccion),
                                    'COD_PAGO_DETRACCION'=>$COD_PAGO_DETRACCION,
                                    'TXT_PAGO_DETRACCION'=>$TXT_PAGO_DETRACCION,

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


                $ordencompra_tt                            =   CMPOrden::where('COD_ORDEN','=',$fedocumento->ID_DOCUMENTO)->first();
                $trabajador = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $ordencompra_tt->COD_TRABAJADOR_ENCARGADO)->first();
                $trabajadorcorreo = DB::table('WEB.ListaplatrabajadoresGenereal')->where('dni','=',$trabajador->NRO_DOCUMENTO)->first();

                if(count($trabajadorcorreo)>0){
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $ordencompra_tt->COD_ORDEN;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   date_format(date_create($ordencompra_tt->FEC_USUARIO_CREA_AUD), 'Ymd h:i:s');
                    $documento->USUARIO_ID                  =   $trabajadorcorreo->COD_TRAB;
                    $documento->USUARIO_NOMBRE              =   $trabajadorcorreo->apellidopaterno.' '.$trabajadorcorreo->apellidomaterno.' '.$trabajadorcorreo->nombres;;
                    $documento->TIPO                        =   'APRUEBA EN OSIRIS';
                    $documento->MENSAJE                     =   '';
                    $documento->save();
                }

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


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO DOCUMENTOS');
                //geolocalizacion

                $orden                                  =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();


                $fedocumento_x                          =   FeDocumento::where('TXT_REFERENCIA','=',$idoc)->first();
                //cambiar el estado cuando es material y si tiene extonro
                if($orden->IND_MATERIAL_SERVICIO=='M' && count($fedocumento_x)>0){
                    //DETALLE PRODUCTO ACTUALIZAR
                    $conexionbd         = 'sqlsrv';
                    if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
                        $conexionbd         = 'sqlsrv_r';
                    }else{
                        if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                            $conexionbd         = 'sqlsrv_b';
                        }
                    }
                    DB::connection($conexionbd)->table('CMP.ORDEN')
                        ->where('COD_ORDEN', $idoc)
                        ->update(['COD_CATEGORIA_ESTADO_ORDEN' => 'EOR0000000000012','TXT_CATEGORIA_ESTADO_ORDEN'=>'ATENDIDO PARCIALMENTE']);
                }

                
                if($orden->IND_MATERIAL_SERVICIO=='M' && count($fedocumento_x)<=0){

                    $detalleproducto                    =   CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO','=',1)
                                                            ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$idoc)
                                                            ->orderBy('NRO_LINEA','ASC')
                                                            ->get();

                    //almacen lote                                
                    $this->insert_almacen_lote($orden,$detalleproducto);//insertar en almacen
                    $orden_id = $this->insert_orden($orden,$detalleproducto);//crea la orden de ingreso        
                    $this->insert_referencia_asoc($orden,$detalleproducto,$orden_id[0]);//crea la referencia
                    if (in_array($orden->COD_CATEGORIA_TIPO_ORDEN, ['TOR0000000000026','TOR0000000000022','TOR0000000000021'])) {
                        if($orden->COD_CENTRO != 'CEN0000000000002'){
                            $this->insert_detalle_producto_cascara($orden,$detalleproducto,$orden_id[0]);//crea detalle de la orden de ingresa   
                        }else{
                            $this->insert_detalle_producto($orden,$detalleproducto,$orden_id[0]);//crea detalle de la orden de ingresa
                        }
                    }else{
                        $this->insert_detalle_producto($orden,$detalleproducto,$orden_id[0]);//crea detalle de la orden de ingresa
                    }



                    // ejecutable en segundo plano que tod orden de ingreso que este genrado desde el merge siemplemente jale ese boton
                    //$ejecutarwfc = $this->actionGuardarOrdenWcf($orden,$detalleproducto,$orden_id[0]);

                    //DETALLE PRODUCTO ACTUALIZAR
                    $conexionbd         = 'sqlsrv';
                    if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
                        $conexionbd         = 'sqlsrv_r';
                    }else{
                        if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                            $conexionbd         = 'sqlsrv_b';
                        }
                    }

                    DB::connection($conexionbd)->table('CMP.DETALLE_PRODUCTO')
                        ->where('COD_TABLA', $idoc)
                        ->update(['CAN_PENDIENTE' => 0,'FEC_USUARIO_MODIF_AUD'=>$this->hoy]);

                    FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                ->update(
                                    [
                                        'COD_ESTADO'=>'ETM0000000000009',
                                        'TXT_ESTADO'=>'POR EJECUTAR ORDEN DE INGRESO',
                                        'fecha_uc'=>$this->fechaactual,
                                        'usuario_uc'=>Session::get('usuario')->id
                                    ]
                                );

                }else{

                
                    //SI ES SERVICIO PASA NORMAL
                    FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                ->update(
                                    [
                                        'COD_ESTADO'=>'ETM0000000000003',
                                        'TXT_ESTADO'=>'POR APROBAR CONTABILIDAD',
                                        'ind_email_ap'=>0,
                                        'fecha_uc'=>$this->fechaactual,
                                        'usuario_uc'=>Session::get('usuario')->id
                                    ]
                                );

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'APROBADO POR USUARIO CONTACTO';
                    $documento->MENSAJE                     =   '';
                    $documento->save();

                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'APROBADO POR USUARIO CONTACTO');
                    //geolocalizacion


                    //whatsaap para contabilidad
                    // $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
                    // $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();            
                    // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                    // $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                    //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                    //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                    //                         .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';

                    // if(1==0){
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    // }else{
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    //     $this->insertar_whatsaap('51979659002','HAMILTON',$mensaje,'');
                    //     $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                    //     //CONTABILIDAD
                    //     if($prefijocarperta=='II'){
                    //         $this->insertar_whatsaap('51965991360','ANGHIE',$mensaje,'');           //INTERNACIONAL
                    //         $this->insertar_whatsaap('51988650421','LUCELY',$mensaje,'');           //INTERNACIONAL
                    //     }else{
                    //         $this->insertar_whatsaap('51950638955','MIGUEL',$mensaje,'');           //COMERCIAL
                    //         $this->insertar_whatsaap('51935387084','VASQUEZ',$mensaje,'');          //COMERCIAL
                    //     }
                    // } 
                }

                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                //dd($ex);
                return Redirect::to('detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('bienhecho', 'Se valido el xml correctamente');

        }
    }

    public function actionValidarXMLContratoAdministrator($idopcion, $prefijo, $idordencompra,Request $request)
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
                $entidadbanco_id   =   $request['entidadbanco_id'];
                $bancocategoria    =   CMPCategoria::where('COD_CATEGORIA','=',$entidadbanco_id)->first();

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



                //LECTURA DEL CDR
                if(!is_null($filescdr)){
                    //CDR
                    foreach($filescdr as $file){

                        $contadorArchivos = Archivo::count();
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
                            return Redirect::to('detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'No se pudo abrir el archivo .zip');
                        }
                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();
                    }


                    if (file_exists($extractedFile)) {




                        //cbc
                        $xml = simplexml_load_file($extractedFile);

                        //dd($xml);

                        $cbc = 0;
                        $namespaces = $xml->getNamespaces(true);
                        foreach ($namespaces as $prefix => $namespace) {
                            if('cbc'==$prefix){
                                $cbc = 1;  
                            }
                        }
                        
                        if($cbc>=1){
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
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }  
                        }else{

                            $xml_ns = simplexml_load_file($extractedFile);

                            // Namespace definitions
                            $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                            $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                            // Register namespaces
                            $xml_ns->registerXPathNamespace('ns4', $ns4);
                            $xml_ns->registerXPathNamespace('ns3', $ns3);
                            // Querying XML
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
                            {
                                $codigocdr  = $ResponseCodes->ResponseCode;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
                            {
                                $respuestacdr  = $Description->Description;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentReference') as $ID)
                            {
                                $factura_cdr_id  = $ID->ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }

                        }

                        //DD($codigocdr);
                    } else {
                        return Redirect::to('detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Error al intentar descomprimir el CDR');
                    }

                    if($sw == 0){
                        return Redirect::to('detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') no coincide con la factura ('.$nombre_doc.')');
                    }

                    if (strpos($respuestacdr, 'observaciones') !== false) {
                        return Redirect::to('detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') tiene observaciones');
                    }



                }


                //guardar los contratos
                $rutaorden       =   $request['rutaorden'];
                if($rutaorden!=''){

                    $aoc                            =       CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000026'])
                                                            ->first();
                    $contadorArchivos = Archivo::count();
                    $nombrefilecdr                  =       $contadorArchivos.'-'.$ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
                    $prefijocarperta                =       $this->prefijo_empresa($ordencompra->COD_EMPR);
                    $rutafile                       =       $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                    $rutacompleta                   =       $rutafile.'\\'.$nombrefilecdr;
                    $valor                          =       $this->versicarpetanoexiste($rutafile);
                    $path                           =       $rutacompleta;
                    //$directorio                     =       '\\\\10.1.0.201\cpe\Orden_Compra';
                    //$rutafila                       =       $directorio.'\\'.$nombreArchivoBuscado;
                    copy($rutaorden,$rutacompleta);
                    $dcontrol                       =       new Archivo;
                    $dcontrol->ID_DOCUMENTO         =       $ordencompra->COD_DOCUMENTO_CTBLE;
                    $dcontrol->DOCUMENTO_ITEM       =       $fedocumento->DOCUMENTO_ITEM;
                    $dcontrol->TIPO_ARCHIVO         =       $aoc->COD_CATEGORIA_DOCUMENTO;
                    $dcontrol->NOMBRE_ARCHIVO       =       $nombrefilecdr;
                    $dcontrol->DESCRIPCION_ARCHIVO  =       $aoc->NOM_CATEGORIA_DOCUMENTO;
                    $dcontrol->URL_ARCHIVO          =       $path;
                    $dcontrol->SIZE                 =       100;
                    $dcontrol->EXTENSION            =       '.pdf';
                    $dcontrol->ACTIVO               =       1;
                    $dcontrol->FECHA_CREA           =       $this->fechaactual;
                    $dcontrol->USUARIO_CREA         =       Session::get('usuario')->id;
                    $dcontrol->save();

                }


                $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                if($tiposerie == 'E'){
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                //->where('IND_OBLIGATORIO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                                //->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                                ->get();
                //dd($tarchivos);

                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                //->where('IND_OBLIGATORIO','=',1)
                                                ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                                //->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                                ->get();
                }


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();
                            $nombre          =      $ordencompra->COD_DOCUMENTO_CTBLE.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
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




                /////////////////////////////////////////////GUARDAR GUIAS REMITENTE /////////////////////////////////////////

                //guardar las guias que ya existen
                $arrayreferencia_guia       =   CMPReferecenciaAsoc::where('COD_TABLA','=',$ordencompra->COD_DOCUMENTO_CTBLE)
                                                ->where('COD_TABLA_ASOC', 'like', '%GRR%')
                                                ->where('COD_ESTADO','=',1)
                                                ->pluck('COD_TABLA_ASOC')
                                                ->toArray();
                $lista_guias                 =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$arrayreferencia_guia)
                                                ->where('COD_ESTADO','=',1)
                                                ->get();


                $array_guias                 =   array();                               
                $rutaordenguia               =   "";

                foreach ($lista_guias as $index=>$item) {

                    $array_nuevo            =   array(); 
                    $directorio = '\\\\10.1.0.201\cpe\Contratos';
                    // Nombre del archivo que estás buscando
                    $nombreArchivoBuscado = $item->COD_DOCUMENTO_CTBLE.'.pdf';
                    // Escanea el directorio
                    $archivos = scandir($directorio);
                    // Inicializa una variable para almacenar el resultado
                    $archivoEncontrado = false;
                    // Recorre la lista de archivos
                    foreach ($archivos as $archivo) {
                        // Omite los elementos '.' y '..'
                        if ($archivo != '.' && $archivo != '..') {
                            // Verifica si el nombre del archivo coincide con el archivo buscado
                            if ($archivo == $nombreArchivoBuscado) {
                                $archivoEncontrado = true;
                                break;
                            }
                        }
                    }
                    // Muestra el resultado
                    if ($archivoEncontrado) {

                        $rutaordenguia                  =       $directorio.'\\'.$nombreArchivoBuscado;

                        $contadorArchivos = Archivo::count();
                        $nombrefilecdr                  =       $contadorArchivos.'-'.$item->COD_DOCUMENTO_CTBLE.'.pdf';
                        $prefijocarperta                =       $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile                       =       $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $rutacompleta                   =       $rutafile.'\\'.$nombrefilecdr;
                        $valor                          =       $this->versicarpetanoexiste($rutafile);
                        $path                           =       $rutacompleta;

                        //dd($rutacompleta);

                        copy($rutaordenguia,$rutacompleta);
                        $dcontrol                       =       new Archivo;
                        $dcontrol->ID_DOCUMENTO         =       $ordencompra->COD_DOCUMENTO_CTBLE;
                        $dcontrol->DOCUMENTO_ITEM       =       $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO         =       $item->COD_DOCUMENTO_CTBLE;
                        $dcontrol->NOMBRE_ARCHIVO       =       $nombrefilecdr;
                        $dcontrol->DESCRIPCION_ARCHIVO  =       'GUIA REMITENTE '.$item->NRO_SERIE.'-'.$item->NRO_DOC;
                        $dcontrol->URL_ARCHIVO          =       $path;
                        $dcontrol->SIZE                 =       100;
                        $dcontrol->EXTENSION            =       '.pdf';
                        $dcontrol->ACTIVO               =       1;
                        $dcontrol->FECHA_CREA           =       $this->fechaactual;
                        $dcontrol->USUARIO_CREA         =       Session::get('usuario')->id;
                        $dcontrol->save();
                        $rutaordenguia                  =   $directorio.'\\'.$nombreArchivoBuscado;
                    }else{
                        $rutaordenguia           =  '';
                        $array_nuevo             =  array(
                                                        "COD_DOCUMENTO_CTBLE"       => $item->COD_DOCUMENTO_CTBLE,
                                                        "NRO_SERIE"                 => $item->NRO_SERIE,
                                                        "NRO_DOC"                   => $item->NRO_DOC,
                                                        "rutaordenguia"             => $rutaordenguia,
                                                    );
                        array_push($array_guias,$array_nuevo);           
                    }
                }

                //guardar guias remitentes del array
                foreach ($array_guias as $index=>$item) {
                    $filescdm          =   $request[$item['COD_DOCUMENTO_CTBLE']];
                    if(!is_null($filescdm)){
                        foreach($filescdm as $file){
                            $contadorArchivos = Archivo::count();
                            $nombre          =      $item['COD_DOCUMENTO_CTBLE'].'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                            $valor           =      $this->versicarpetanoexiste($rutafile);
                            $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                            copy($file->getRealPath(),$rutacompleta);
                            $path            =      $rutacompleta;

                            $nombreoriginal                 =   $file->getClientOriginalName();
                            $info                           =   new SplFileInfo($nombreoriginal);
                            $extension                      =   $info->getExtension();

                            $dcontrol                       =   new Archivo;
                            $dcontrol->ID_DOCUMENTO         =   $ordencompra->COD_DOCUMENTO_CTBLE;
                            $dcontrol->DOCUMENTO_ITEM       =   $fedocumento->DOCUMENTO_ITEM;
                            $dcontrol->TIPO_ARCHIVO         =   $item['COD_DOCUMENTO_CTBLE'];
                            $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO  =   'GUIA REMITENTE '.$item['NRO_SERIE'].'-'.$item['NRO_DOC'];


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

                $cb_id                                    =   $request['cb_id'];
                $ctadetraccion                            =   $request['ctadetraccion'];
                $tipo_detraccion_id                       =   $request['tipo_detraccion_id'];
                $monto_detraccion                         =   $request['monto_detraccion'];
                $pago_detraccion                          =   $request['pago_detraccion'];

                $empresa_sel                              =   STDEmpresa::where('COD_EMPR','=',$pago_detraccion)->first();
                $COD_PAGO_DETRACCION = '';
                $TXT_PAGO_DETRACCION = '';
                if(count($empresa_sel)>0){
                    $COD_PAGO_DETRACCION = $empresa_sel->COD_EMPR;
                    $TXT_PAGO_DETRACCION = $empresa_sel->NOM_EMPR;
                }


                if($ctadetraccion!=''){
                    STDEmpresa::where('COD_EMPR',$ordencompra->COD_EMPR_EMISOR)
                                ->update(
                                    [
                                        'TXT_DETRACCION'=>$ctadetraccion
                                    ]
                                );
                }


                $monto_anticipo_txt     =   $request['monto_anticipo'];
                $MONTO_ANTICIPO_DESC    =   0.00;
                $COD_ANTICIPO           =   '';
                $SERIE_ANTICIPO         =   '';
                $NRO_ANTICIPO           =   '';


                if($monto_anticipo_txt!=''){

                    $ordencompra_f          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();
                    $COD_EMPR               =   Session::get('empresas')->COD_EMPR;
                    $COD_CENTRO             =   '';
                    $FEC_CORTE              =   $this->hoy_sh;
                    $CLIENTE                =   $ordencompra->COD_EMPR_EMISOR;
                    $COD_MONEDA             =   $ordencompra_f->COD_CATEGORIA_MONEDA;
                    $monto_anticipo         =   0.00;
                    //print_r("entro");

                    $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.OBTENER_ADELANTOS_PROVEEDOR_DETALLADO 
                                                                            @COD_EMPR = ?,
                                                                            @COD_CENTRO = ?,
                                                                            @FEC_CORTE = ?,
                                                                            @CLIENTE = ?,
                                                                            @COD_MONEDA = ?'
                                                                        );
                    $stmt->bindParam(1, $COD_EMPR, PDO::PARAM_STR);
                    $stmt->bindParam(2, $COD_CENTRO, PDO::PARAM_STR);
                    $stmt->bindParam(3, $FEC_CORTE, PDO::PARAM_STR);
                    $stmt->bindParam(4, $CLIENTE, PDO::PARAM_STR);
                    $stmt->bindParam(5, $COD_MONEDA, PDO::PARAM_STR);
                    $stmt->execute();
                    $listaanticipo = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $arrayitem      = array();


                    foreach ($listaanticipo as $index => $item) {
                        if($item['COD_HABILITACION'] == $monto_anticipo_txt){
                            $MONTO_ANTICIPO_DESC = (float)$item['CAN_SALDO'];
                            $COD_ANTICIPO = $item['COD_HABILITACION'];
                            $SERIE_ANTICIPO = $item['NRO_SERIE'];
                            $NRO_ANTICIPO = $item['NRO_DOC'];
                        }
                    }
                }


                
                FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [

                                    'CTA_DETRACCION'=>$ctadetraccion,
                                    'VALOR_DETRACCION'=>$tipo_detraccion_id,
                                    'MONTO_DETRACCION_XML'=>(float)$monto_detraccion,
                                    'MONTO_DETRACCION_RED'=>round((float)$monto_detraccion),
                                    'COD_PAGO_DETRACCION'=>$COD_PAGO_DETRACCION,
                                    'TXT_PAGO_DETRACCION'=>$TXT_PAGO_DETRACCION,

                                    'MONTO_ANTICIPO_DESC'=>$MONTO_ANTICIPO_DESC,
                                    'COD_ANTICIPO'=>$COD_ANTICIPO,
                                    'SERIE_ANTICIPO'=>$SERIE_ANTICIPO,
                                    'NRO_ANTICIPO'=>$NRO_ANTICIPO,


                                    'COD_CATEGORIA_BANCO'=>$bancocategoria->COD_CATEGORIA,
                                    'TXT_CATEGORIA_BANCO'=>$bancocategoria->NOM_CATEGORIA,
                                    'TXT_NRO_CUENTA_BANCARIA'=>$cb_id,
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

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO DOCUMENTOS');
                //geolocalizacion


                FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000003',
                                    'TXT_ESTADO'=>'POR APROBAR CONTABILIDAD',
                                    'ind_email_ap'=>0,
                                    'fecha_uc'=>$this->fechaactual,
                                    'usuario_uc'=>Session::get('usuario')->id
                                ]
                            );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR USUARIO CONTACTO';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'APROBADO POR USUARIO CONTACTO');
                //geolocalizacion


                //whatsaap para contabilidad
                // $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();


                // //$ordencompra        =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
                // $ordencompra        =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();

                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_EMISOR.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';

                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{


                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                //     $this->insertar_whatsaap('51979659002','HAMILTON',$mensaje,'');
                //     $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);


                //     //CONTABILIDAD
                //     if($prefijocarperta=='II'){
                //         $this->insertar_whatsaap('51965991360','ANGHIE',$mensaje,'');           //INTERNACIONAL
                //         $this->insertar_whatsaap('51988650421','LUCELY',$mensaje,'');           //INTERNACIONAL
                //     }else{
                //         $this->insertar_whatsaap('51950638955','MIGUEL',$mensaje,'');           //COMERCIAL
                //         $this->insertar_whatsaap('51935387084','VASQUEZ',$mensaje,'');          //COMERCIAL
                //     }



                // }



                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                //dd($ex);
                return Redirect::to('detalle-comprobante-contrato-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('bienhecho', 'Se valido el xml correctamente');

        }
    }

    public function actionValidarXMLNotaCreditoAdministrator($idopcion, $prefijo, $idordencompra,Request $request)
    {
        
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_credito_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);

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



                //LECTURA DEL CDR
                if(!is_null($filescdr)){
                    //CDR
                    foreach($filescdr as $file){

                        $contadorArchivos = Archivo::count();
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
                            return Redirect::to('detalle-comprobante-nota-credito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'No se pudo abrir el archivo .zip');
                        }
                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();
                    }


                    if (file_exists($extractedFile)) {




                        //cbc
                        $xml = simplexml_load_file($extractedFile);

                        //dd($xml);

                        $cbc = 0;
                        $namespaces = $xml->getNamespaces(true);
                        foreach ($namespaces as $prefix => $namespace) {
                            if('cbc'==$prefix){
                                $cbc = 1;  
                            }
                        }
                        
                        if($cbc>=1){
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
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }  
                        }else{

                            $xml_ns = simplexml_load_file($extractedFile);

                            // Namespace definitions
                            $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                            $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                            // Register namespaces
                            $xml_ns->registerXPathNamespace('ns4', $ns4);
                            $xml_ns->registerXPathNamespace('ns3', $ns3);
                            // Querying XML
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
                            {
                                $codigocdr  = $ResponseCodes->ResponseCode;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
                            {
                                $respuestacdr  = $Description->Description;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentReference') as $ID)
                            {
                                $factura_cdr_id  = $ID->ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }

                        }

                        //DD($codigocdr);
                    } else {
                        return Redirect::to('detalle-comprobante-nota-credito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Error al intentar descomprimir el CDR');
                    }

                    if($sw == 0){
                        return Redirect::to('detalle-comprobante-nota-credito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') no coincide con la factura ('.$nombre_doc.')');
                    }

                    if (strpos($respuestacdr, 'observaciones') !== false) {
                        return Redirect::to('detalle-comprobante-nota-credito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') tiene observaciones');
                    }



                }             

                $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003'])
                                                ->get();                                


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();
                            $nombre          =      $ordencompra->COD_DOCUMENTO_CTBLE.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
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


                $ordencompra_t                          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$ordencompra->COD_DOCUMENTO_CTBLE)->first();

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $ordencompra->COD_DOCUMENTO_CTBLE;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   date_format(date_create($ordencompra_t->FEC_USUARIO_CREA_AUD), 'Ymd h:i:s');
                $documento->USUARIO_ID                  =   $contacto->COD_TRABAJADOR;
                $documento->USUARIO_NOMBRE              =   $contacto->NOM_TRABAJADOR;
                $documento->TIPO                        =   'CREO NOTA DE CREDITO';
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


                FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000003',
                                    'TXT_ESTADO'=>'POR APROBAR CONTABILIDAD',
                                    'ind_email_ap'=>0,
                                    'fecha_uc'=>$this->fechaactual,
                                    'usuario_uc'=>Session::get('usuario')->id
                                ]
                            );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR USUARIO CONTACTO';
                $documento->MENSAJE                     =   '';
                $documento->save();

                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                //dd($ex);
                return Redirect::to('detalle-comprobante-nota-credito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('bienhecho', 'Se valido el xml correctamente');

        }
    }

    public function actionValidarXMLNotaDebitoAdministrator($idopcion, $prefijo, $idordencompra,Request $request)
    {
        
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_debito_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);

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



                //LECTURA DEL CDR
                if(!is_null($filescdr)){
                    //CDR
                    foreach($filescdr as $file){

                        $contadorArchivos = Archivo::count();
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
                            return Redirect::to('detalle-comprobante-nota-debito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'No se pudo abrir el archivo .zip');
                        }
                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();
                    }


                    if (file_exists($extractedFile)) {




                        //cbc
                        $xml = simplexml_load_file($extractedFile);

                        //dd($xml);

                        $cbc = 0;
                        $namespaces = $xml->getNamespaces(true);
                        foreach ($namespaces as $prefix => $namespace) {
                            if('cbc'==$prefix){
                                $cbc = 1;  
                            }
                        }
                        
                        if($cbc>=1){
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
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }  
                        }else{

                            $xml_ns = simplexml_load_file($extractedFile);

                            // Namespace definitions
                            $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                            $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                            // Register namespaces
                            $xml_ns->registerXPathNamespace('ns4', $ns4);
                            $xml_ns->registerXPathNamespace('ns3', $ns3);
                            // Querying XML
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
                            {
                                $codigocdr  = $ResponseCodes->ResponseCode;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
                            {
                                $respuestacdr  = $Description->Description;
                            }
                            foreach($xml_ns->xpath('//ns3:DocumentReference') as $ID)
                            {
                                $factura_cdr_id  = $ID->ID;
                                if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                    $sw = 1;
                                }
                            }

                        }

                        //DD($codigocdr);
                    } else {
                        return Redirect::to('detalle-comprobante-nota-debito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Error al intentar descomprimir el CDR');
                    }

                    if($sw == 0){
                        return Redirect::to('detalle-comprobante-nota-debito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') no coincide con la factura ('.$nombre_doc.')');
                    }

                    if (strpos($respuestacdr, 'observaciones') !== false) {
                        return Redirect::to('detalle-comprobante-nota-debito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'El CDR ('.$factura_cdr_id.') tiene observaciones');
                    }



                }             

                $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003'])
                                                ->get();                                


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();
                            $nombre          =      $ordencompra->COD_DOCUMENTO_CTBLE.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
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


                $ordencompra_t                          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$ordencompra->COD_DOCUMENTO_CTBLE)->first();

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $ordencompra->COD_DOCUMENTO_CTBLE;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   date_format(date_create($ordencompra_t->FEC_USUARIO_CREA_AUD), 'Ymd h:i:s');
                $documento->USUARIO_ID                  =   $contacto->COD_TRABAJADOR;
                $documento->USUARIO_NOMBRE              =   $contacto->NOM_TRABAJADOR;
                $documento->TIPO                        =   'CREO NOTA DE DEBITO';
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


                FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000003',
                                    'TXT_ESTADO'=>'POR APROBAR CONTABILIDAD',
                                    'ind_email_ap'=>0,
                                    'fecha_uc'=>$this->fechaactual,
                                    'usuario_uc'=>Session::get('usuario')->id
                                ]
                            );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR USUARIO CONTACTO';
                $documento->MENSAJE                     =   '';
                $documento->save();

                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                //dd($ex);
                return Redirect::to('detalle-comprobante-nota-debito-administrator/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('bienhecho', 'Se valido el xml correctamente');

        }
    }

    public function actionAgregarArchivoUC($procedencia,$idopcion, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);

        View::share('titulo','Observar Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $archivoob          =   $request['archivoob'];

                if(count($archivoob)<=0){
                    DB::rollback(); 
                    return Redirect::to('agregar-archivo-uc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }

                foreach($archivoob as $index=>$item){

                    $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item)->first();
                    $docasociar                              =   New CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN                   =   $idoc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO     =   $categoria->COD_CATEGORIA;
                    $docasociar->NOM_CATEGORIA_DOCUMENTO     =   $categoria->NOM_CATEGORIA;
                    $docasociar->IND_OBLIGATORIO             =   0;
                    $docasociar->TXT_FORMATO                 =   $categoria->COD_CTBLE;
                    $docasociar->TXT_ASIGNADO                =   $categoria->TXT_ABREVIATURA;
                    $docasociar->COD_USUARIO_CREA_AUD        =   Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD        =   $this->fechaactual;
                    $docasociar->COD_ESTADO                  =   1;
                    $docasociar->TIP_DOC                     =   $categoria->CODIGO_SUNAT;
                    $docasociar->save();

                }

                DB::commit();
                return Redirect::to('/gestion-de-orden-compra/'.$idopcion)->with('bienhecho', 'Archivo aosicado a la orden : '.$ordencompra->COD_ORDEN.' registrado con exito');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();


            $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();

            $codigo_sunat           =   'I';
            if($ordencompra_t->IND_VARIAS_ENTREGAS==0){
                $codigo_sunat           =   'N';
            }

            $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->where('COD_ESTADO','=',1)
                                        ->where('CODIGO_SUNAT','=',$codigo_sunat)
                                        ->get();

            // $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
            //                             ->where('COD_ESTADO','=',1)
            //                             ->get();

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();

            return View::make('comprobante/agregararchivo', 
                            [

                                'ordencompra'           =>  $ordencompra,
                                'procedencia'           =>  $procedencia,

                                'documentoscompra'      =>  $documentoscompra,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'tarchivos'             =>  $tarchivos,
                                'totalarchivos'         =>  $totalarchivos,
                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



    public function actionQuitarArchivoUC($procedencia,$idopcion, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);

        View::share('titulo','Quitar Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $archivoob          =   $request['archivoob'];

                if(count($archivoob)<=0){
                    DB::rollback(); 
                    return Redirect::to('quitar-archivo-uc/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }

                foreach($archivoob as $index=>$item){

                    $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item)->first();
                    $docasociar                              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_CATEGORIA_DOCUMENTO','=',$item)->first();

                    CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)
                            ->where('COD_CATEGORIA_DOCUMENTO','=',$item)
                                ->update(
                                    [
                                        'COD_ESTADO'=>0,
                                        'TIP_DOC'=>'E',
                                        'FEC_USUARIO_MODIF_AUD'=>$this->fechaactual,
                                        'COD_USUARIO_MODIF_AUD'=>Session::get('usuario')->id
                                    ]
                                );

                }

                DB::commit();
                return Redirect::to('/gestion-de-orden-compra/'.$idopcion)->with('bienhecho', 'Archivo aSosicado a la orden : '.$ordencompra->COD_ORDEN.' eliminado con exito');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();


            $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();

            $codigo_sunat           =   'I';
            if($ordencompra_t->IND_VARIAS_ENTREGAS==0){
                $codigo_sunat           =   'N';
            }

            $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->where('COD_ESTADO','=',1)
                                        ->where('COD_CTBLE','=','PDF')
                                        ->where('CODIGO_SUNAT','=',$codigo_sunat)
                                        ->get();

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();

            return View::make('comprobante/quitararchivo', 
                            [

                                'ordencompra'           =>  $ordencompra,
                                'procedencia'           =>  $procedencia,

                                'documentoscompra'      =>  $documentoscompra,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'tarchivos'             =>  $tarchivos,
                                'totalarchivos'         =>  $totalarchivos,
                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



    public function actionAgregarArchivoUCContrato($procedencia,$idopcion, $prefijo, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);

        View::share('titulo','Agregar Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $archivoob          =   $request['archivoob'];

                if(count($archivoob)<=0){
                    DB::rollback(); 
                    return Redirect::to('agregar-archivo-uc-contrato/'.$procedencia.'/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }

                foreach($archivoob as $index=>$item){

                    $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item)->first();
                    $docasociar                              =   New CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN                   =   $idoc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO     =   $categoria->COD_CATEGORIA;
                    $docasociar->NOM_CATEGORIA_DOCUMENTO     =   $categoria->NOM_CATEGORIA;
                    $docasociar->IND_OBLIGATORIO             =   0;
                    $docasociar->TXT_FORMATO                 =   $categoria->COD_CTBLE;
                    $docasociar->TXT_ASIGNADO                =   $categoria->TXT_ABREVIATURA;
                    $docasociar->COD_USUARIO_CREA_AUD        =   Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD        =   $this->fechaactual;
                    $docasociar->COD_ESTADO                  =   1;
                    $docasociar->TIP_DOC                     =   $categoria->CODIGO_SUNAT;
                    $docasociar->save();

                }

                DB::commit();
                return Redirect::to('/gestion-de-orden-compra/'.$idopcion)->with('bienhecho', 'Archivo aosicado a la orden : '.$ordencompra->COD_ORDEN.' registrado con exito');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{


            $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();
            $codigo_sunat           =   'N';
            $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->whereIn('COD_CATEGORIA',['DCC0000000000029','DCC0000000000033','DCC0000000000030'])
                                        ->where('COD_ESTADO','=',1)
                                        ->where('CODIGO_SUNAT','=',$codigo_sunat)
                                        ->get();

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();

            return View::make('comprobante/agregararchivocontrato', 
                            [

                                'ordencompra'           =>  $ordencompra,
                                'procedencia'           =>  $procedencia,

                                'documentoscompra'      =>  $documentoscompra,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'tarchivos'             =>  $tarchivos,
                                'totalarchivos'         =>  $totalarchivos,
                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }






    public function actionApiLeerCDR(Request $request)
    {


        
        $extractedFile = '\\\\10.1.50.2\comprobantes\II\20418453177\R-20418453177-01-F151-0047165.xml';
        $xml = simplexml_load_file($extractedFile);

        $namespaces = $xml->getNamespaces(true);
        foreach ($namespaces as $prefix => $namespace) {
            print_r($prefix);
        }


        // Namespace definitions
        $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
        $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
        // Register namespaces
        $xml->registerXPathNamespace('ns4', $ns4);
        $xml->registerXPathNamespace('ns3', $ns3);
        // Querying XML
        $UBLVersionID = $xml->UBLVersionID;
        foreach($xml->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
        {
            $codigocdr  = $ResponseCodes->ResponseCode;
        }
        foreach($xml->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
        {
            $respuestacdr  = $Description->Description;
        }
        foreach($xml->xpath('//ns3:DocumentReference') as $ID)
        {
            $factura_cdr_id  = $ID->ID;

            // if($factura_cdr_id == $nombre_doc){
            //     $sw = 1;
            // }
        }
        print_r($codigocdr);
        print_r($respuestacdr);
        print_r($factura_cdr_id);

        $extractedFile = '\\\\10.1.50.2\comprobantes\II\20418453177\R-20270453679-01-F002-64833.xml';
        $xml = simplexml_load_file($extractedFile);

        $namespaces = $xml->getNamespaces(true);
        foreach ($namespaces as $prefix => $namespace) {
            print_r($prefix);

            //$xml->registerXPathNamespace($prefix, $namespace);
        }

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
            // if($factura_cdr_id == $nombre_doc){
            //     $sw = 1;
            // }
        }
        print_r($codigocdr);
        print_r($respuestacdr);
        print_r($factura_cdr_id);
    } 

}
