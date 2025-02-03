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
use App\Modelos\TESCuentaBancaria;
use App\Modelos\CMPReferecenciaAsoc;
use App\Modelos\FeRefAsoc;

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
class GestionEstibaController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;

    public function actionValidarXMLEstibaAdministrator($idopcion, $lote,Request $request)
    {

        $file                   =   $request['inputxml'];
        $idoc                   =   $lote;

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

                        $larchivos       =      Archivo::get();
                        $zip = new ZipArchive;
                        $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$idoc;
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
                            return Redirect::to('detalle-comprobante-estiba-administrator/'.$idopcion.'/'.$lote)->with('errorbd', 'No se pudo abrir el archivo .zip');
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
                        return Redirect::to('detalle-comprobante-estiba-administrator/'.$idopcion.'/'.$lote)->with('errorurl', 'Error al intentar descomprimir el CDR');
                    }

                    if($sw == 0){
                        return Redirect::to('detalle-comprobante-estiba-administrator/'.$idopcion.'/'.$lote)->with('errorurl', 'El CDR ('.$factura_cdr_id.') no coincide con la factura ('.$nombre_doc.')');
                    }

                    if (strpos($respuestacdr, 'observaciones') !== false) {
                        return Redirect::to('detalle-comprobante-estiba-administrator/'.$idopcion.'/'.$lote)->with('errorurl', 'El CDR ('.$factura_cdr_id.') tiene observaciones');
                    }
                }

                //guardar los contratos
                $rutaorden       =   $request['rutaorden'];
                if($rutaorden!=''){

                    $aoc                            =       CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000026'])//cambiar
                                                            ->first();

                    $larchivos                      =       Archivo::get();
                    $nombrefilecdr                  =       count($larchivos).'-'.$idoc.'.pdf';//cambiar
                    $prefijocarperta                =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                    $rutafile                       =       $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$lote;//cambiar
                    $rutacompleta                   =       $rutafile.'\\'.$nombrefilecdr;
                    $valor                          =       $this->versicarpetanoexiste($rutafile);
                    $path                           =       $rutacompleta;


                    copy($rutaorden,$rutacompleta);
                    $dcontrol                       =       new Archivo;
                    $dcontrol->ID_DOCUMENTO         =       $idoc;
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
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                                ->get();
                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                                ->get();
                }


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $larchivos       =      Archivo::get();
                            $nombre          =      $idoc.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$idoc;
                            $nombrefilecdr   =      count($larchivos).'-'.$file->getClientOriginalName();
                            $valor           =      $this->versicarpetanoexiste($rutafile);
                            $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                            copy($file->getRealPath(),$rutacompleta);
                            $path            =      $rutacompleta;

                            $nombreoriginal                 =   $file->getClientOriginalName();
                            $info                           =   new SplFileInfo($nombreoriginal);
                            $extension                      =   $info->getExtension();

                            $dcontrol                       =   new Archivo;
                            $dcontrol->ID_DOCUMENTO         =   $idoc;
                            $dcontrol->DOCUMENTO_ITEM       =   $fedocumento->DOCUMENTO_ITEM;
                            $dcontrol->TIPO_ARCHIVO         =   $item->COD_CATEGORIA_DOCUMENTO;
                            $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO  =   $item->NOM_CATEGORIA_DOCUMENTO;
                            $dcontrol->URL_ARCHIVO          =   $path;
                            $dcontrol->SIZE                 =   filesize($file);
                            $dcontrol->EXTENSION            =   $extension;
                            $dcontrol->ACTIVO               =   1;
                            $dcontrol->FECHA_CREA           =   $this->fechaactual;
                            $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                            $dcontrol->save();
                        }
                    }
                }
 
                /////////////////////////////////////////////GUARDAR GUIAS REMITENTE /////////////////////////////////////////
                // //guardar las guias que ya existen
                // $arrayreferencia_guia       =   CMPReferecenciaAsoc::where('COD_TABLA','=',$idoc)
                //                                 ->where('COD_TABLA_ASOC', 'like', '%GRR%')
                //                                 ->where('COD_ESTADO','=',1)
                //                                 ->pluck('COD_TABLA_ASOC')
                //                                 ->toArray();
                // $lista_guias                 =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$arrayreferencia_guia)
                //                                 ->where('COD_ESTADO','=',1)
                //                                 ->get();


                // $array_guias                 =   array();                               
                // $rutaordenguia               =   "";

                // foreach ($lista_guias as $index=>$item) {

                //     $array_nuevo            =   array(); 
                //     $directorio = '\\\\10.1.0.201\cpe\Contratos';
                //     // Nombre del archivo que estás buscando
                //     $nombreArchivoBuscado = $item->COD_DOCUMENTO_CTBLE.'.pdf';
                //     // Escanea el directorio
                //     $archivos = scandir($directorio);
                //     // Inicializa una variable para almacenar el resultado
                //     $archivoEncontrado = false;
                //     // Recorre la lista de archivos
                //     foreach ($archivos as $archivo) {
                //         // Omite los elementos '.' y '..'
                //         if ($archivo != '.' && $archivo != '..') {
                //             // Verifica si el nombre del archivo coincide con el archivo buscado
                //             if ($archivo == $nombreArchivoBuscado) {
                //                 $archivoEncontrado = true;
                //                 break;
                //             }
                //         }
                //     }
                //     // Muestra el resultado
                //     if ($archivoEncontrado) {

                //         $rutaordenguia                  =       $directorio.'\\'.$nombreArchivoBuscado;

                //         $larchivos                      =       Archivo::get();
                //         $nombrefilecdr                  =       count($larchivos).'-'.$item->COD_DOCUMENTO_CTBLE.'.pdf';
                //         $prefijocarperta                =       $this->prefijo_empresa($ordencompra->COD_EMPR);
                //         $rutafile                       =       $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                //         $rutacompleta                   =       $rutafile.'\\'.$nombrefilecdr;
                //         $valor                          =       $this->versicarpetanoexiste($rutafile);
                //         $path                           =       $rutacompleta;

                //         //dd($rutacompleta);

                //         copy($rutaordenguia,$rutacompleta);
                //         $dcontrol                       =       new Archivo;
                //         $dcontrol->ID_DOCUMENTO         =       $ordencompra->COD_DOCUMENTO_CTBLE;
                //         $dcontrol->DOCUMENTO_ITEM       =       $fedocumento->DOCUMENTO_ITEM;
                //         $dcontrol->TIPO_ARCHIVO         =       $item->COD_DOCUMENTO_CTBLE;
                //         $dcontrol->NOMBRE_ARCHIVO       =       $nombrefilecdr;
                //         $dcontrol->DESCRIPCION_ARCHIVO  =       'GUIA REMITENTE '.$item->NRO_SERIE.'-'.$item->NRO_DOC;
                //         $dcontrol->URL_ARCHIVO          =       $path;
                //         $dcontrol->SIZE                 =       100;
                //         $dcontrol->EXTENSION            =       '.pdf';
                //         $dcontrol->ACTIVO               =       1;
                //         $dcontrol->FECHA_CREA           =       $this->fechaactual;
                //         $dcontrol->USUARIO_CREA         =       Session::get('usuario')->id;
                //         $dcontrol->save();
                //         $rutaordenguia                  =   $directorio.'\\'.$nombreArchivoBuscado;
                //     }else{
                //         $rutaordenguia           =  '';
                //         $array_nuevo             =  array(
                //                                         "COD_DOCUMENTO_CTBLE"       => $item->COD_DOCUMENTO_CTBLE,
                //                                         "NRO_SERIE"                 => $item->NRO_SERIE,
                //                                         "NRO_DOC"                   => $item->NRO_DOC,
                //                                         "rutaordenguia"             => $rutaordenguia,
                //                                     );
                //         array_push($array_guias,$array_nuevo);           
                //     }
                // }

                // //guardar guias remitentes del array
                // foreach ($array_guias as $index=>$item) {
                //     $filescdm          =   $request[$item['COD_DOCUMENTO_CTBLE']];
                //     if(!is_null($filescdm)){
                //         foreach($filescdm as $file){
                //             $larchivos       =      Archivo::get();
                //             $nombre          =      $item['COD_DOCUMENTO_CTBLE'].'-'.$file->getClientOriginalName();
                //             /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                //             $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                //             $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                //             // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                //             $nombrefilecdr   =      count($larchivos).'-'.$file->getClientOriginalName();
                //             $valor           =      $this->versicarpetanoexiste($rutafile);
                //             $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                //             copy($file->getRealPath(),$rutacompleta);
                //             $path            =      $rutacompleta;

                //             $nombreoriginal                 =   $file->getClientOriginalName();
                //             $info                           =   new SplFileInfo($nombreoriginal);
                //             $extension                      =   $info->getExtension();

                //             $dcontrol                       =   new Archivo;
                //             $dcontrol->ID_DOCUMENTO         =   $ordencompra->COD_DOCUMENTO_CTBLE;
                //             $dcontrol->DOCUMENTO_ITEM       =   $fedocumento->DOCUMENTO_ITEM;
                //             $dcontrol->TIPO_ARCHIVO         =   $item['COD_DOCUMENTO_CTBLE'];
                //             $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                //             $dcontrol->DESCRIPCION_ARCHIVO  =   'GUIA REMITENTE '.$item['NRO_SERIE'].'-'.$item['NRO_DOC'];


                //             $dcontrol->URL_ARCHIVO      =   $path;
                //             $dcontrol->SIZE             =   filesize($file);
                //             $dcontrol->EXTENSION        =   $extension;
                //             $dcontrol->ACTIVO           =   1;
                //             $dcontrol->FECHA_CREA       =   $this->fechaactual;
                //             $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                //             $dcontrol->save();
                //         }
                //     }
                // }

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
                    STDEmpresa::where('NRO_DOCUMENTO',$fedocumento->RUC_PROVEEDOR)
                                ->update(
                                    [
                                        'TXT_DETRACCION'=>$ctadetraccion
                                    ]
                                );
                }

                FeRefAsoc::where('LOTE','=',$idoc)
                            ->update(
                                    [
                                        'ESTATUS'=>'ON'
                                    ]);

                $lotes                  =   FeRefAsoc::where('lote','=',$idoc)                                        
                                            ->pluck('ID_DOCUMENTO')
                                            ->toArray();
                $documento_asociados    =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->get();
                $documento_top          =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->first();


                $monto_anticipo_txt     =   $request['monto_anticipo'];
                $MONTO_ANTICIPO_DESC    =   0.00;
                $COD_ANTICIPO           =   '';
                $SERIE_ANTICIPO         =   '';
                $NRO_ANTICIPO           =   '';

                $empresa_anti           =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();
                if($monto_anticipo_txt!=''){



                    $ordencompra_f          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();
                    $COD_EMPR               =   Session::get('empresas')->COD_EMPR;
                    $COD_CENTRO             =   '';
                    $FEC_CORTE              =   $this->hoy_sh;
                    $CLIENTE                =   $empresa_anti->COD_EMPR;
                    $COD_MONEDA             =   $documento_top->COD_CATEGORIA_MONEDA;
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



                //dd($MONTO_ANTICIPO_DESC);
                
                FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [

                                    'CTA_DETRACCION'=>$ctadetraccion,
                                    'VALOR_DETRACCION'=>$tipo_detraccion_id,
                                    'MONTO_DETRACCION_XML'=>$monto_detraccion,
                                    'MONTO_DETRACCION_RED'=>round($monto_detraccion),
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

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $idoc;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   date_format(date_create($documento_top->FEC_USUARIO_CREA_AUD), 'Ymd h:i:s');
                $documento->USUARIO_ID                  =   $contacto->COD_TRABAJADOR;
                $documento->USUARIO_NOMBRE              =   $contacto->NOM_TRABAJADOR;
                $documento->TIPO                        =   'CREO CONTRATO';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $idoc;
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


                //whatsaap para contabilidad
                $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
                $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                        .'%0D%0A'.'EMPRESA : '.Session::get('empresas')->NOM_EMPR.'%0D%0A'
                                        .'PROVEEDOR : '.$empresa_anti->NOM_EMPR.'%0D%0A'
                                        .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';
                if(1==0){
                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                }else{
                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    $this->insertar_whatsaap('51979659002','HAMILTON',$mensaje,'');
                    $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                    if($prefijocarperta=='II'){
                        $this->insertar_whatsaap('51965991360','ANGHIE',$mensaje,'');           //INTERNACIONAL
                        $this->insertar_whatsaap('51988650421','LUCELY',$mensaje,'');           //INTERNACIONAL
                    }else{
                        $this->insertar_whatsaap('51950638955','MIGUEL',$mensaje,'');           //COMERCIAL
                        $this->insertar_whatsaap('51935387084','VASQUEZ',$mensaje,'');          //COMERCIAL
                    }
                }

                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                //dd($ex);
                return Redirect::to('detalle-comprobante-estiba-administrator/'.$idopcion.'/'.$lote)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('bienhecho', 'Se valido el xml correctamente');

        }
    }



    public function actionDetalleSelectEstiba($idopcion,Request $request)
    {
        $jsondocumenos                          =    json_decode($request['jsondocumenos'],true);
        $operacion_id                           =    $request['operacion_sel'];
        $lote                                   =    $this->funciones->generar_lote('FE_REF_ASOC',8);

        $sw_sel                                 =    0;
        $sw_no_sel                              =    0;
        //si solo hay uno de los seleccionados
        foreach ($jsondocumenos as $key => $item) {
            $ID_DOCUMENTO = $item['data_requerimiento_id'];
            $feref = FeRefAsoc::where('ID_DOCUMENTO','=',$ID_DOCUMENTO)->where('COD_ESTADO','=','1')->first();
            if(count($feref)>0){
                $sw_sel                         =    $sw_sel + 1;  
            }else{
                $sw_no_sel                      =    $sw_no_sel + 1;
            }
        }
        if($sw_sel >= 1 && $sw_no_sel >=1){
            return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('errorbd', 'Has seleccionado Documentos que ya tienen lotes activos');  
        }

        foreach ($jsondocumenos as $key => $item) {
            $ID_DOCUMENTO = $item['data_requerimiento_id'];
            $feref = FeRefAsoc::where('ID_DOCUMENTO','=',$ID_DOCUMENTO)->where('COD_ESTADO','=','1')->first();
            if(count($feref)<=0){
                $docasociar                              =   New FeRefAsoc;
                $docasociar->LOTE                        =   $lote;
                $docasociar->ID_DOCUMENTO                =   $ID_DOCUMENTO;
                $docasociar->FECHA_CREA                  =   $this->fechaactual;
                $docasociar->COD_ESTADO                  =   1;
                $docasociar->ESTATUS                     =   'OFF';
                $docasociar->OPERACION                   =   $operacion_id;
                $docasociar->USUARIO_CREA                =   Session::get('usuario')->id;
                $docasociar->save();
            }else{
                $lote = $feref->LOTE;
            }
        }

        return Redirect::to('detalle-comprobante-estiba-administrator/'.$idopcion.'/'.$lote);
    }

    public function actionDetalleComprobanteestibaAdministrator($idopcion, $lote, Request $request) {

        $idoc                   =   $lote;
        $ferefeasoc             =   FeRefAsoc::where('lote','=',$lote)->get();
        $fereftop1              =   FeRefAsoc::where('lote','=',$lote)->first();


        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        View::share('titulo','REGISTRO DE COMPROBANTE '.$fereftop1->OPERACION.' : '.$lote);
        $tiposerie              =   '';
        $empresa                =   array();
        $combopagodetraccion    =   array();
        $usuario                =   SGDUsuario::where('COD_TRABAJADOR','=',Session::get('usuario')->usuarioosiris_id)->first();



        if(count($fedocumento)>0){

            $detallefedocumento =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tiposerie          =   substr($fedocumento->SERIE, 0, 1);
            $empresa            =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();
            $combopagodetraccion    =   array('' => "Seleccione Pago Detraccion",Session::get('empresas')->COD_EMPR => Session::get('empresas')->NOM_EMPR , $empresa->COD_EMPR => $empresa->NOM_EMPR);


        }else{
            $detallefedocumento =   array();


        }
        $contacto               =   DB::table('users')->where('ind_contacto','=',1)->pluck('nombre','id')->toArray();
        $combocontacto          =   array('' => "Seleccione Contacto") + $contacto;
        if($tiposerie == 'E'){
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                        ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004'])
                                        ->get();
        }else{
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                        ->where('COD_CATEGORIA_DOCUMENTO','<>','DCC0000000000003')
                                        ->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                        ->get();
        }
        //no encontro la orden de contrato
        $rutaorden                  =   "";
        $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;

        $cb_id                  =   '';
        $combocb                =   array('' => "Seleccione Cuenta Bancaria");
        $combodocumento         =   array('DCC0000000000002' => 'FACTURA ELECTRONICA' , 'DCC0000000000013' => 'RECIBO POR HONORARIO');
        $documento_id           =   'DCC0000000000013';
        $funcion                =   $this;


        $combotipodetraccion    =   array('' => "Seleccione Tipo Detraccion",'MONTO_REFERENCIAL' => 'MONTO REFERENCIAL' , 'MONTO_FACTURACION' => 'MONTO FACTURACION');

        $fedocumento_x          =   FeDocumento::where('TXT_REFERENCIA','=',$idoc)->first();


        $lotes                  =   FeRefAsoc::where('lote','=',$lote)                                        
                                    ->pluck('ID_DOCUMENTO')
                                    ->toArray();
        $documento_asociados    =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->get();
        $documento_top          =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->first();



        //ANTICIPO
        $COD_EMPR               =   Session::get('empresas')->COD_EMPR;
        $COD_CENTRO             =   '';
        $FEC_CORTE              =   $this->hoy_sh;
        $CLIENTE                =   $documento_top->COD_EMPR_EMISOR;
        $COD_MONEDA             =   $documento_top->COD_CATEGORIA_MONEDA;
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


        return View::make('comprobante/registrocomprobanteestibaadministrator',
                         [
                            'monto_anticipo'        =>  $monto_anticipo,
                            'comboant'              =>  $comboant,
                            'combotipodetraccion'   =>  $combotipodetraccion,
                            'combopagodetraccion'   =>  $combopagodetraccion,
                            'fedocumento_x'         =>  $fedocumento_x,
                            'empresa'               =>  $empresa,
                            'combobancos'           =>  $combobancos,
                            'documento_asociados'   =>  $documento_asociados,
                            'documento_top'         =>  $documento_top,
                            'usuario'               =>  $usuario,
                            'combotipodetraccion'   =>  $combotipodetraccion,
                            'cb_id'                 =>  $cb_id,
                            'idoc'                  =>  $idoc,
                            'combocb'               =>  $combocb,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'combocontacto'         =>  $combocontacto,
                            'tarchivos'             =>  $tarchivos,
                            'rutaorden'             =>  $rutaorden,
                            'combodocumento'        =>  $combodocumento,
                            'documento_id'          =>  $documento_id,
                            'funcion'               =>  $funcion,
                            'fereftop1'             =>  $fereftop1,
                            'idopcion'              =>  $idopcion,
                         ]);
    }



    public function actionCargarXMLEstibaAdministrator($idopcion, $lote,Request $request)
    {

        $file                   =   $request['inputxml'];
        $idoc                   =   $lote;
        $documento_id           =   $request['documento_id'];

        if($_POST)
        {
            if (!empty($file)) 
            {
                try{    

                        DB::beginTransaction();
                        $fedocumento_t          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
                        if(count($fedocumento_t)>0){
                            DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO','=',$idoc)->delete();
                            DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO','=',$idoc)->delete();
                            DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO','=',$idoc)->delete();
                            DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$idoc)->delete();
                            DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO','=',$idoc)->delete();
                        }

                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $larchivos       =      Archivo::get();
                        $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$lote;
                        $nombrefile      =      count($larchivos).'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;
                        $nombreoriginal  =      $file->getClientOriginalName();
                        $info            =      new SplFileInfo($nombreoriginal);
                        $extension       =      $info->getExtension();
                        copy($file->getRealPath(),$rutacompleta);
                        $path            =   $rutacompleta;

                        if($documento_id=='DCC0000000000002'){
                            //FACTURA
                            /****************************************  LEER EL XML Y GUARDAR   *********************************/
                            $parser             =   new InvoiceParser();
                            $xml                =   file_get_contents($path);
                            $factura            =   $parser->parse($xml);
                            $tipo_documento_le  =   $factura->gettipoDoc();
                            $moneda_le          =   $factura->gettipoMoneda();
                            $archivosdelfe      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                    ->whereIn('COD_CATEGORIA', ['DCC0000000000002','DCC0000000000003','DCC0000000000004','DCC0000000000006'])
                                                    ->get();

                        }else{

                            //RECIBO POR HONORARIO
                            $parser = new RHParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);  
                            $tipo_documento_le = 'R1';
                            $moneda_le = 'PEN';
                            $archivosdelfe      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                    ->whereIn('COD_CATEGORIA', ['DCC0000000000013','DCC0000000000003','DCC0000000000006'])->get();
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
                        $documentolinea                     =   $this->ge_linea_documento($idoc);
                        $cant_rentencion                    =   0;
                        //$cant_perception                    =   $factura->getperception();
                        $cant_perception                    =   0;

                        //REGISTRO DEL XML LEIDO
                        $documento                          =   new FeDocumento;
                        $documento->ID_DOCUMENTO            =   $idoc;
                        $documento->DOCUMENTO_ITEM          =   $documentolinea;
                        $documento->COD_EMPR                =   Session::get('empresas')->COD_EMPR;
                        $documento->TXT_EMPR                =   Session::get('empresas')->NOM_EMPR;
                        $documento->TXT_PROCEDENCIA         =   'ADM';
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
                        $documento->PORC_DETRACCION         =   floatval($factura->getdetraccion()->getporcDet());
                        $documento->MONTO_DETRACCION        =   (float)$factura->getdetraccion()->getbaseDetr();
                        $documento->MONTO_ANTICIPO          =   $factura->getdestotalAnticipos();
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
                        $documento->OPERACION               =   $request['operacion_id'];
                        $documento->save();

                        //ARCHIVO
                        $dcontrol                   =   new Archivo;
                        $dcontrol->ID_DOCUMENTO     =   $idoc;
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
                                $detalle->ID_DOCUMENTO          =   $idoc;
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
                                $forma->ID_DOCUMENTO            =   $idoc;
                                $forma->DOCUMENTO_ITEM          =   $documentolinea;
                                $forma->ID_CUOTA                =   $itemfor->getnumCuota();
                                $forma->ID_MONEDA               =   $itemfor->getmoneda();
                                $forma->MONTO_CUOTA             =   (float)$itemfor->getmonto();
                                $forma->FECHA_PAGO              =   $fechapago;
                                $forma->save();

                        }

                        /****************************************  VALIDAR SI EL ARCHIVO ESTA ACEPTADO POR SUNAT  *********************************/


                        $fedocumento         =      FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
                        $fechaemision        =      date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                        $detallefedocumento  =      FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
                        $lotes                  =   FeRefAsoc::where('lote','=',$idoc)                                        
                                                    ->pluck('ID_DOCUMENTO')
                                                    ->toArray();
                        $documento_asociados    =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->get();
                        $documento_top          =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->first();

                        //VALIDAR QUE ALGUNOS CAMPOS SEAN IGUALES
                        $this->con_validar_documento_proveedor_estiba($documento_asociados,$documento_top,$fedocumento,$detallefedocumento,$idoc);

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

                                FeDocumento::where('ID_DOCUMENTO','=',$idoc)
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
                                FeDocumento::where('ID_DOCUMENTO','=',$idoc)
                                            ->update(
                                                    [
                                                        'success'=>$arvalidar['success'],
                                                        'message'=>$arvalidar['message']
                                                    ]);
                            }
                        }
                        //ARCHIVOS
                        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN','=',$idoc)->delete();
                        foreach($archivosdelfe as $index=>$item){
                                $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item->COD_CATEGORIA)->first();
                                $docasociar                              =   New CMPDocAsociarCompra;
                                $docasociar->COD_ORDEN                   =   $idoc;
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
                    return Redirect::to('detalle-comprobante-estiba-administrator/'.$idopcion.'/'.$idoc)->with('errorbd', $ex.' Ocurrio un error inesperado');
                }
                return Redirect::to('detalle-comprobante-estiba-administrator/'.$idopcion.'/'.$idoc)->with('bienhecho', 'Se valido el xml');
            }else{
                return Redirect::to('detalle-comprobante-estiba-administrator/'.$idopcion.'/'.$idoc)->with('errorurl', 'Seleccione Archivo XML a Importar ');
            }

        }
    }

    public function actionCargarModalDetalleEstibas(Request $request) {

        $jsondocumenos                      =    json_decode($request['datastring'],true);
        $result = array_map(function($item) {
            return $item['data_requerimiento_id'];
        }, $jsondocumenos);

        $feasoc     = CMPDetalleProducto::whereIn('COD_TABLA',$result)->get();
        $funcion        =   $this;
        return View::make('comprobante/modal/ajax/mlistalotesestibadetalle',
                         [
                            'feasoc'                =>  $feasoc,
                            'funcion'               =>  $funcion
                         ]);
    }

    public function actionCargarModalDetalleLotes(Request $request) {

        $operacion_id   =   $request['operacion_sel'];
        $feasoc         =   FeRefAsoc::where('USUARIO_CREA','=',Session::get('usuario')->id)
                            ->where('COD_ESTADO','=','1')
                            ->where('ESTATUS','=','OFF')
                            ->where('OPERACION','=',$operacion_id)
                            ->select('LOTE','FECHA_CREA')
                            ->groupBy('LOTE')
                            ->groupBy('FECHA_CREA')
                            ->get();

        $funcion        =   $this;

        //dd($feasoc);

        return View::make('comprobante/modal/ajax/mlistalotesestiba',
                         [
                            'feasoc'                =>  $feasoc,
                            'operacion_id'          =>  $operacion_id,
                            'funcion'               =>  $funcion
                         ]);
    }


    public function actionEliminacionLoteEstiba(Request $request) {

        $lote           =   $request['lote'];
        FeRefAsoc::where('LOTE','=',$lote)
                    ->update(
                            [
                                'FECHA_MOD'=>$this->fechaactual,
                                'USUARIO_MOD'=>Session::get('usuario')->id,
                                'COD_ESTADO'=>'0'
                            ]);
        FeDocumento::where('ID_DOCUMENTO',$lote)
                    ->update(
                        [
                            'ID_DOCUMENTO'=>$lote.'X',
                            'COD_ESTADO'=>'ETM0000000000006',
                            'TXT_ESTADO'=>'RECHAZADO',
                            'ind_observacion'=>0
                        ]
                    );
        FeDetalleDocumento::where('ID_DOCUMENTO',$lote)
                    ->update(
                        [
                            'ID_DOCUMENTO'=>$lote.'X'
                        ]
                    );

        FeDocumentoHistorial::where('ID_DOCUMENTO',$lote)
                    ->update(
                        [
                            'ID_DOCUMENTO'=>$lote.'X'
                        ]
                    );
        FeFormaPago::where('ID_DOCUMENTO',$lote)
                    ->update(
                        [
                            'ID_DOCUMENTO'=>$lote.'X'
                        ]
                    );
        Archivo::where('ID_DOCUMENTO',$lote)
                    ->update(
                        [
                            'ID_DOCUMENTO'=>$lote.'X'
                        ]
                    );



        echo("exitoso");
    }

}
