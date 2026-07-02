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
use App\Modelos\CMPOrden;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\FeDocumentoHistorial;
use App\Modelos\SGDUsuario;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\Archivo;
use App\Modelos\CMPCategoria;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\CMPReferecenciaAsoc;
use App\Modelos\FeRefAsoc;
use App\Modelos\TESOperacionCaja;


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
use App\Traits\UserTraits;

use Storage;
use ZipArchive;
use Hashids;
use SplFileInfo;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class GestionOCTesoreriaController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;
    use UserTraits;

    public function actionEliminacionLoteComision(Request $request)
    {

        $lote = $request['lote'];

        DB::table('TES.OPERACION_CAJA as OC')
            ->join('FE_REF_ASOC as REF', 'REF.ID_DOCUMENTO', '=', 'OC.COD_OPERACION_CAJA')
            ->where('REF.LOTE', $lote)
            ->update([
                'OC.ATENDIDO' => DB::raw('OC.ATENDIDO - REF.ATENDIDO')
            ]);


        FeRefAsoc::where('LOTE', '=', $lote)
            ->update(
                [
                    'FECHA_MOD' => $this->fechaactual,
                    'USUARIO_MOD' => Session::get('usuario')->id,
                    'COD_ESTADO' => '0'
                ]);
        FeDocumento::where('ID_DOCUMENTO', $lote)
            ->update(
                [
                    'ID_DOCUMENTO' => $lote . 'X',
                    'COD_ESTADO' => 'ETM0000000000006',
                    'TXT_ESTADO' => 'RECHAZADO',
                    'ind_observacion' => 0
                ]
            );
        FeDetalleDocumento::where('ID_DOCUMENTO', $lote)
            ->update(
                [
                    'ID_DOCUMENTO' => $lote . 'X'
                ]
            );

        FeDocumentoHistorial::where('ID_DOCUMENTO', $lote)
            ->update(
                [
                    'ID_DOCUMENTO' => $lote . 'X'
                ]
            );
        FeFormaPago::where('ID_DOCUMENTO', $lote)
            ->update(
                [
                    'ID_DOCUMENTO' => $lote . 'X'
                ]
            );


        Archivo::where('ID_DOCUMENTO', $lote)
            ->update(
                [
                    'ID_DOCUMENTO' => $lote . 'X'
                ]
            );


        echo("exitoso");
    }


    public function actionValidarXMLComisionAdministrator($idopcion, $lote, Request $request)
    {

        $file = $request['inputxml'];
        $idoc = $lote;

        if ($_POST) {

            try {

                DB::beginTransaction();
                $contacto_id = $request['contacto_id'];
                $procedencia = $request['procedencia'];
                $entidadbanco_id = $request['entidadbanco_id'];

                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('COD_ESTADO', '<>', 'ETM0000000000006')->first();

                /**************************** VALIDAR CDR Y LEER RESPUESTA ******************************/
                $filescdr = $request['DCC0000000000004'];
                $codigocdr = '';
                $respuestacdr = '';
                $factura_cdr_id = '';
                $sw = 0;
                $nombre_doc = $fedocumento->SERIE . '-' . $fedocumento->NUMERO;
                $numerototal = $fedocumento->NUMERO;
                $numerototalsc = ltrim($numerototal, '0');
                $nombre_doc_sinceros = $fedocumento->SERIE . '-' . $numerototalsc;
                //LECTURA DEL CDR
                if (!is_null($filescdr)) {
                    //CDR
                    foreach ($filescdr as $file) {

                        //$contadorArchivos = Archivo::count();
                        $contadorArchivos = Archivo::count();

                        $zip = new ZipArchive;
                        $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $idoc;
                        $nombrefile = $file->getClientOriginalName();
                        $valor = $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefile;
                        // Copia el archivo .zip a la carpeta compartida
                        copy($file->getRealPath(), $rutacompleta);
                        $rutacompletaxml = $rutafile . '\\';
                        // Abre el archivo .zip
                        if ($zip->open($file->getPathname()) === TRUE) {
                            // Extrae cada archivo del .zip
                            for ($i = 0; $i < $zip->numFiles; $i++) {
                                $filename = $zip->getNameIndex($i);
                                $fileInfo = pathinfo($filename);

                                // Verifica si el archivo es un archivo regular
                                if ($fileInfo['filename'] != '.' && $fileInfo['filename'] != '..') {
                                    // Extrae el archivo a la carpeta compartida
                                    $extractedFile = $rutacompletaxml . $fileInfo['basename'];
                                    copy("zip://" . $file->getPathname() . "#$filename", $extractedFile);
                                }
                            }
                            // Cierra el archivo .zip
                            $zip->close();
                        } else {
                            DB::rollback();
                            return Redirect::to('detalle-comprobante-estiba-administrator/' . $idopcion . '/' . $lote)->with('errorbd', 'No se pudo abrir el archivo .zip');
                        }
                        $nombreoriginal = $file->getClientOriginalName();
                        $info = new SplFileInfo($nombreoriginal);
                        $extension = $info->getExtension();
                    }


                    if (file_exists($extractedFile)) {


                        //cbc
                        $xml = simplexml_load_file($extractedFile);

                        //dd($xml);

                        $cbc = 0;
                        $namespaces = $xml->getNamespaces(true);
                        foreach ($namespaces as $prefix => $namespace) {
                            if ('cbc' == $prefix) {
                                $cbc = 1;
                            }
                        }

                        if ($cbc >= 1) {
                            foreach ($xml->xpath('//cbc:ResponseCode') as $ResponseCode) {
                                $codigocdr = $ResponseCode;
                            }
                            foreach ($xml->xpath('//cbc:Description') as $Description) {
                                $respuestacdr = $Description;
                            }
                            foreach ($xml->xpath('//cbc:ID') as $ID) {
                                $factura_cdr_id = $ID;
                                if ($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros) {
                                    $sw = 1;
                                }
                            }
                        } else {

                            $xml_ns = simplexml_load_file($extractedFile);

                            // Namespace definitions
                            $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                            $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                            // Register namespaces
                            $xml_ns->registerXPathNamespace('ns4', $ns4);
                            $xml_ns->registerXPathNamespace('ns3', $ns3);
                            // Querying XML
                            foreach ($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes) {
                                $codigocdr = $ResponseCodes->ResponseCode;
                            }
                            foreach ($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description) {
                                $respuestacdr = $Description->Description;
                            }
                            foreach ($xml_ns->xpath('//ns3:DocumentReference') as $ID) {
                                $factura_cdr_id = $ID->ID;
                                if ($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros) {
                                    $sw = 1;
                                }
                            }

                        }

                        //DD($codigocdr);
                    } else {
                        return Redirect::to('detalle-comprobante-estiba-administrator/' . $idopcion . '/' . $lote)->with('errorurl', 'Error al intentar descomprimir el CDR');
                    }

                    if ($sw == 0) {
                        return Redirect::to('detalle-comprobante-estiba-administrator/' . $idopcion . '/' . $lote)->with('errorurl', 'El CDR (' . $factura_cdr_id . ') no coincide con la factura (' . $nombre_doc . ')');
                    }

                    if (strpos($respuestacdr, 'observaciones') !== false) {
                        return Redirect::to('detalle-comprobante-estiba-administrator/' . $idopcion . '/' . $lote)->with('errorurl', 'El CDR (' . $factura_cdr_id . ') tiene observaciones');
                    }
                }

                $tiposerie = substr($fedocumento->SERIE, 0, 1);
                if ($tiposerie == 'E') {
                    $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                        ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003', 'DCC0000000000004'])
                        ->get();
                } else {
                    $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                        ->where('COD_CATEGORIA_DOCUMENTO', '<>', 'DCC0000000000003')
                        ->get();
                }
                foreach ($tarchivos as $index => $item) {

                    $filescdm = $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if (!is_null($filescdm)) {

                        foreach ($filescdm as $file) {

                            //
                            $contadorArchivos = Archivo::count();


                            $nombre = $idoc . '-' . $file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $idoc;
                            $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                            $valor = $this->versicarpetanoexiste($rutafile);
                            $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                            copy($file->getRealPath(), $rutacompleta);
                            $path = $rutacompleta;

                            $nombreoriginal = $file->getClientOriginalName();
                            $info = new SplFileInfo($nombreoriginal);
                            $extension = $info->getExtension();

                            $dcontrol = new Archivo;
                            $dcontrol->ID_DOCUMENTO = $idoc;
                            $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                            $dcontrol->TIPO_ARCHIVO = $item->COD_CATEGORIA_DOCUMENTO;
                            $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO = $item->NOM_CATEGORIA_DOCUMENTO;
                            $dcontrol->URL_ARCHIVO = $path;
                            $dcontrol->SIZE = filesize($file);
                            $dcontrol->EXTENSION = $extension;
                            $dcontrol->ACTIVO = 1;
                            $dcontrol->FECHA_CREA = $this->fechaactual;
                            $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                            $dcontrol->save();
                        }
                    }
                }


                $contacto = SGDUsuario::where('COD_TRABAJADOR', '=', $contacto_id)->first();
                $trabajador = STDTrabajador::where('COD_TRAB', '=', $contacto->COD_TRABAJADOR)->first();
                //$contacto                               =   User::where('id','=',$contacto_id)->first();
                FeRefAsoc::where('LOTE', '=', $idoc)
                    ->update(
                        [
                            'ESTATUS' => 'ON',
                            'TXT_ESTADO' => 'TERMINADA'
                        ]);

                $lotes = FeRefAsoc::where('lote', '=', $idoc)
                    ->pluck('ID_DOCUMENTO')
                    ->toArray();

                $documento_asociados = $this->gn_lista_comision_asociados($lotes);
                $documento_top = $this->gn_lista_comision_asociados_top($lotes);

                FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                    ->update(
                        [
                            'ARCHIVO_CDR' => '',
                            'ARCHIVO_PDF' => '',
                            'COD_ESTADO' => 'ETM0000000000003',
                            'TXT_ESTADO' => 'POR APROBAR CONTABILIDAD',
                            'dni_usuariocontacto' => $trabajador->NRO_DOCUMENTO,
                            'COD_CONTACTO' => $contacto->COD_TRABAJADOR,
                            'CODIGO_CDR' => $codigocdr,
                            'RESPUESTA_CDR' => $respuestacdr,
                            'ind_email_uc' => 0,
                            'TXT_CONTACTO' => $contacto->NOM_TRABAJADOR,
                            'fecha_pa' => $this->fechaactual,
                            'usuario_pa' => Session::get('usuario')->id,
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $idoc;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'SUBIO DOCUMENTOS';
                $documento->MENSAJE = '';
                $documento->save();


                FeDocumento::where('ID_DOCUMENTO', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                    ->update(
                        [
                            'ind_email_ap' => 0,
                            'fecha_uc' => $this->fechaactual,
                            'usuario_uc' => Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR TESORERIA';
                $documento->MENSAJE = '';
                $documento->save();


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'APROBADO POR TESORERIA');
                //geolocalización
                $this->update_serie_correlativo_cpe();


                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                //dd($ex);
                return Redirect::to('detalle-comprobante-comision-administrator/' . $idopcion . '/' . $lote)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-de-integracion-comisiones/' . $idopcion)->with('bienhecho', 'Se valido el xml correctamente');

        }
    }


    public function actionCargarXMLComisionAdministrator($idopcion, $lote, Request $request)
    {

        $file = $request['inputxml'];
        $idoc = $lote;
        $documento_id = $request['documento_id'];
        $respuesta = '';

        if ($_POST) {

                try {
                    DB::beginTransaction();


                    $fedocumento_t = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('COD_ESTADO', '<>', 'ETM0000000000006')->first();
                    if (count($fedocumento_t) > 0) {
                        DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO', '=', $idoc)->delete();
                        DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO', '=', $idoc)->delete();
                        DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO', '=', $idoc)->delete();
                        DB::table('ARCHIVOS')->where('ID_DOCUMENTO', '=', $idoc)->delete();
                        DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO', '=', $idoc)->delete();
                        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', '=', $idoc)->delete();
                    }

                    if($documento_id == 'DCC0000000000048'){

                        $lotes = FeRefAsoc::where('lote', '=', $idoc)
                            ->pluck('ID_DOCUMENTO')
                            ->toArray();
                        $documento_asociados = $this->gn_lista_comision_asociados_atendidos($lotes, $lote);
                        //dd($documento_asociados);
                        $total = 0;
                        foreach ($documento_asociados as $index => $item) {

                            $empresa    =           DB::table('STD.EMPRESA')
                                                    ->where('COD_EMPR', $item->COD_BANCO)
                                                    ->first();
                            $total      =           $total + $item->MONTOATENDIDOREAL;


                        }

                        //REGISTRO DEL XML LEIDO
                        $documento                          =   new FeDocumento;
                        $documento->ID_DOCUMENTO            =   $idoc;
                        $documento->DOCUMENTO_ITEM          =   1;
                        $documento->COD_EMPR                =   Session::get('empresas')->COD_EMPR;
                        $documento->TXT_EMPR                =   Session::get('empresas')->NOM_EMPR;
                        $documento->TXT_PROCEDENCIA         =   'ADM';
                        $documento->ESTADO                  =   'A';
                        $documento->RUC_PROVEEDOR           =   $empresa->NRO_DOCUMENTO;
                        $documento->RZ_PROVEEDOR            =   $empresa->NOM_EMPR;
                        $documento->TIPO_CLIENTE            =   '';
                        $documento->ID_CLIENTE              =   Session::get('empresas')->NRO_DOCUMENTO;
                        $documento->NOMBRE_CLIENTE          =   Session::get('empresas')->NOM_EMPR;
                        $documento->DIRECCION_CLIENTE       =   '';
                        $documento->SERIE                   =   'SS00';
                        $documento->NUMERO                  =   '0000000000';
                        $documento->ID_TIPO_DOC             =   '';
                        $documento->FEC_VENTA               =   date('Ymd');
                        $documento->FEC_VENCI_PAGO          =   date('Ymd');
                        $documento->FORMA_PAGO              =   '';
                        $documento->FORMA_PAGO_DIAS         =   0;
                        $documento->MONEDA                  =   '';
                        $documento->VALOR_IGV_ORIG          =   0;
                        $documento->VALOR_IGV_SOLES         =   0;
                        $documento->SUB_TOTAL_VENTA_ORIG    =   $total;
                        $documento->SUB_TOTAL_VENTA_SOLES   =   $total;
                        $documento->TOTAL_VENTA_ORIG        =   $total;
                        $documento->TOTAL_VENTA_SOLES       =   $total;
                        $documento->PERCEPCION              =   0;
                        $documento->MONTO_RETENCION         =   0;
                        $documento->HORA_EMISION            =   '';
                        $documento->IMPUESTO_2              =   0;
                        $documento->TIPO_DETRACCION         =   '';
                        $documento->PORC_DETRACCION         =   0;
                        $documento->MONTO_DETRACCION        =   0;
                        $documento->MONTO_ANTICIPO          =   0;
                        $documento->NRO_ORDEN_COMP          =   '';
                        $documento->NUM_GUIA                =   '';
                        $documento->estadoCp                =   0;
                        $documento->ARCHIVO_XML             =   '';
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
                        $documento->ind_ruc                 =   1;
                        $documento->ind_rz                  =   1;
                        $documento->ind_moneda              =   1;
                        $documento->ind_total               =   1;
                        $documento->ind_cantidaditem        =   1;
                        $documento->ind_formapago           =   1;
                        $documento->ind_errototal           =   1;
                        $documento->OPERACION               =   'COMISION';
                        $documento->OPERACION_DET           =   'SIN_XML';
                        $documento->MONTO_NC                =   0.00;
                        $documento->save();

                        $contacto               =   DB::table('users')->where('ind_contacto','=',1)->pluck('nombre','id')->toArray();
                        $combocontacto          =   array('' => "Seleccione Contacto") + $contacto;
                        $xmlfactura             =   'FACTURA';
                        $rhxml                  =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                                    ->where('TXT_ASIGNADO','=','PROVEEDOR')
                                                    ->first();
                        if(count($rhxml)>0){
                            $xmlfactura         =   $rhxml->NOM_CATEGORIA_DOCUMENTO;
                        }

                        $docasociar                              =   New CMPDocAsociarCompra;
                        $docasociar->COD_ORDEN                   =   $idoc;
                        $docasociar->COD_CATEGORIA_DOCUMENTO     =   'DCC0000000000048';
                        $docasociar->NOM_CATEGORIA_DOCUMENTO     =   'OTROS DOCUMENTOS';
                        $docasociar->IND_OBLIGATORIO             =   1;
                        $docasociar->TXT_FORMATO                 =   'PDF';
                        $docasociar->TXT_ASIGNADO                =   'CONTACTO';
                        $docasociar->COD_USUARIO_CREA_AUD        =   Session::get('usuario')->id;
                        $docasociar->FEC_USUARIO_CREA_AUD        =   $this->fechaactual;
                        $docasociar->COD_ESTADO                  =   1;
                        $docasociar->TIP_DOC                     =   'N';
                        $docasociar->save();

                        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                    ->whereIn('TXT_FORMATO', ['PDF'])
                                                    ->get();


                    }else{
                        if (!empty($file)) {
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            //
                            $contadorArchivos = Archivo::count();
                            $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $lote;
                            $nombrefile = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                            $valor = $this->versicarpetanoexiste($rutafile);
                            $rutacompleta = $rutafile . '\\' . $nombrefile;
                            $nombreoriginal = $file->getClientOriginalName();
                            $info = new SplFileInfo($nombreoriginal);
                            $extension = $info->getExtension();
                            copy($file->getRealPath(), $rutacompleta);
                            $path = $rutacompleta;

                            if ($documento_id == 'DCC0000000000002') {
                                //FACTURA
                                /****************************************  LEER EL XML Y GUARDAR   *********************************/
                                $parser = new InvoiceParser();
                                $xml = file_get_contents($path);
                                $factura = $parser->parse($xml);
                                $tipo_documento_le = $factura->gettipoDoc();
                                $moneda_le = $factura->gettipoMoneda();
                                $archivosdelfe = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                                    ->whereIn('COD_CATEGORIA', ['DCC0000000000002', 'DCC0000000000003', 'DCC0000000000004'])
                                    ->get();

                            } else {

                                //RECIBO POR HONORARIO
                                $parser = new RHParser();
                                $xml = file_get_contents($path);
                                $factura = $parser->parse($xml);
                                $tipo_documento_le = 'R1';
                                $moneda_le = 'PEN';
                                $archivosdelfe = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                                    ->whereIn('COD_CATEGORIA', ['DCC0000000000013', 'DCC0000000000003'])->get();
                            }
                            //VALIDAR QUE YA EXISTE ESTE XML
                            $fedocumento_e = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->whereNotIn('COD_ESTADO', ['', 'ETM0000000000006'])
                                ->where('RUC_PROVEEDOR', '=', $factura->getcompany()->getruc())
                                ->where('SERIE', '=', $factura->getserie())
                                ->where('NUMERO', '=', $factura->getcorrelativo())
                                ->where('ID_TIPO_DOC', '=', $tipo_documento_le)
                                ->first();
                            if (count($fedocumento_e) > 0) {
                                return Redirect::back()->with('errorurl', 'Este XML ya fue integrado en otra orden de compra');
                            }

                            //VALIDAR QUE EL XML SEA DE LA EMPRESA
                            if ($factura->getClient()->getnumDoc() != Session::get('empresas')->NRO_DOCUMENTO) {
                                return Redirect::back()->with('errorurl', 'El xml no corresponde a la empresa ' . Session::get('empresas')->NRO_DOCUMENTO);
                            }

                            $rz_p = str_replace(["![CDATA[", "]]"], "", $factura->getcompany()->getrazonSocial());
                            $rz_p = str_replace("?", "Ñ", $rz_p);
                            $rz_p = str_replace("ï¿½", "Ñ", $rz_p);
                            $rz_p = str_replace("MARILÑ", "MARILÚ", $rz_p);
                            $documentolinea = $this->ge_linea_documento($idoc);
                            $cant_rentencion = 0;
                            //$cant_perception                    =   $factura->getperception();
                            $cant_perception = 0;

                            //REGISTRO DEL XML LEIDO
                            $documento = new FeDocumento;
                            $documento->ID_DOCUMENTO = $idoc;
                            $documento->DOCUMENTO_ITEM = $documentolinea;
                            $documento->COD_EMPR = Session::get('empresas')->COD_EMPR;
                            $documento->TXT_EMPR = Session::get('empresas')->NOM_EMPR;
                            $documento->TXT_PROCEDENCIA = 'ADM';
                            $documento->ESTADO = 'A';
                            $documento->RUC_PROVEEDOR = $factura->getcompany()->getruc();
                            $documento->RZ_PROVEEDOR = $rz_p;
                            $documento->TIPO_CLIENTE = $factura->getClient()->gettipoDoc();
                            $documento->ID_CLIENTE = $factura->getClient()->getnumDoc();
                            $documento->NOMBRE_CLIENTE = $factura->getClient()->getrznSocial();
                            $documento->DIRECCION_CLIENTE = '';
                            $documento->SERIE = $factura->getserie();
                            $documento->NUMERO = $factura->getcorrelativo();
                            $documento->ID_TIPO_DOC = $tipo_documento_le;
                            $documento->FEC_VENTA = $factura->getfechaEmision()->format('Ymd');
                            $documento->FEC_VENCI_PAGO = $factura->getfecVencimiento()->format('Ymd');
                            $documento->FORMA_PAGO = $factura->getcondicionPago();
                            $documento->FORMA_PAGO_DIAS = 0;
                            $documento->MONEDA = $moneda_le;

                            $documento->VALOR_IGV_ORIG = $factura->getmtoIGV();
                            $documento->VALOR_IGV_SOLES = $factura->getmtoIGV();
                            $documento->SUB_TOTAL_VENTA_ORIG = $factura->getmtoOperGravadas();
                            $documento->SUB_TOTAL_VENTA_SOLES = $factura->getmtoOperGravadas();
                            $documento->TOTAL_VENTA_ORIG = $factura->getmtoImpVenta();
                            $documento->TOTAL_VENTA_SOLES = $factura->getmtoImpVenta();


                            $documento->PERCEPCION = $cant_perception;
                            $documento->MONTO_RETENCION = $cant_rentencion;

                            $documento->HORA_EMISION = $factura->gethoraEmision();
                            $documento->IMPUESTO_2 = $factura->getmtoOtrosTributos();
                            $documento->TIPO_DETRACCION = $factura->getdetraccion()->gettipoDet();
                            $documento->PORC_DETRACCION = floatval($factura->getdetraccion()->getporcDet());
                            $documento->MONTO_DETRACCION = (float)$factura->getdetraccion()->getbaseDetr();
                            $documento->MONTO_ANTICIPO = $factura->getdestotalAnticipos();
                            $documento->NRO_ORDEN_COMP = $factura->getcompra();
                            $documento->NUM_GUIA = $factura->getguiaEmbebida();
                            $documento->estadoCp = 0;
                            $documento->ARCHIVO_XML = $nombrefile;
                            $documento->ARCHIVO_CDR = '';
                            $documento->ARCHIVO_PDF = '';
                            $documento->COD_CONTACTO = '';
                            $documento->TXT_CONTACTO = '';
                            $documento->COD_ESTADO = '';
                            $documento->TXT_ESTADO = '';
                            $documento->ind_email_uc = -1;
                            $documento->ind_email_ap = -1;
                            $documento->ind_email_adm = -1;
                            $documento->ind_email_ba = -1;
                            $documento->ind_email_clap = -1;
                            $documento->OPERACION = $request['operacion_id'];
                            $documento->MONTO_NC = 0.00;

                            $documento->save();

                            //ARCHIVO
                            $dcontrol = new Archivo;
                            $dcontrol->ID_DOCUMENTO = $idoc;
                            $dcontrol->DOCUMENTO_ITEM = $documentolinea;
                            $dcontrol->TIPO_ARCHIVO = 'DCC0000000000003';
                            $dcontrol->NOMBRE_ARCHIVO = $nombrefile;
                            $dcontrol->DESCRIPCION_ARCHIVO = 'XML DEL COMPROBANTE DE COMPRA';
                            $dcontrol->URL_ARCHIVO = $path;
                            $dcontrol->SIZE = filesize($file);
                            $dcontrol->EXTENSION = $extension;
                            $dcontrol->ACTIVO = 1;
                            $dcontrol->FECHA_CREA = $this->fechaactual;
                            $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                            $dcontrol->save();

                            /**********DETALLE*********/
                            foreach ($factura->getdetails() as $indexdet => $itemdet) {

                                $producto = str_replace("<![CDATA[", "", $itemdet->getdescripcion());
                                $producto = str_replace("]]>", "", $producto);
                                $producto = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);

                                $linea = str_pad($indexdet + 1, 3, "0", STR_PAD_LEFT);
                                $detalle = new FeDetalleDocumento;
                                $detalle->ID_DOCUMENTO = $idoc;
                                $detalle->DOCUMENTO_ITEM = $documentolinea;

                                $detalle->LINEID = $linea;
                                $detalle->CODPROD = $itemdet->getcodProducto();
                                $detalle->PRODUCTO = $producto;
                                $detalle->UND_PROD = $itemdet->getunidad();
                                $detalle->CANTIDAD = $itemdet->getcantidad();
                                $detalle->PRECIO_UNIT = (float)$itemdet->getmtoValorUnitario();
                                $detalle->VAL_IGV_ORIG = (float)$itemdet->getigv();
                                $detalle->VAL_IGV_SOL = (float)$itemdet->getigv();
                                $detalle->VAL_SUBTOTAL_ORIG = (float)$itemdet->getmtoValorVenta();
                                $detalle->VAL_SUBTOTAL_SOL = (float)$itemdet->getmtoValorVenta();
                                $detalle->VAL_VENTA_ORIG = (float)$itemdet->getigv() + (float)$itemdet->getmtoValorVenta();
                                $detalle->VAL_VENTA_SOL = (float)$itemdet->getigv() + (float)$itemdet->getmtoValorVenta();
                                $detalle->PRECIO_ORIG = (float)$itemdet->getmtoPrecioUnitario();
                                $detalle->save();
                            }


                            /**********FORMA DE PAGO*********/
                            foreach ($factura->getFormaPago() as $indexfor => $itemfor) {
                                $fechapago = date_format(date_create($itemfor->getfecha()), 'Ymd');
                                $forma = new FeFormaPago;
                                $forma->ID_DOCUMENTO = $idoc;
                                $forma->DOCUMENTO_ITEM = $documentolinea;
                                $forma->ID_CUOTA = $itemfor->getnumCuota();
                                $forma->ID_MONEDA = $itemfor->getmoneda();
                                $forma->MONTO_CUOTA = (float)$itemfor->getmonto();
                                $forma->FECHA_PAGO = $fechapago;
                                $forma->save();

                            }

                            /****************************************  VALIDAR SI EL ARCHIVO ESTA ACEPTADO POR SUNAT  *********************************/

                                        
                            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('COD_ESTADO', '<>', 'ETM0000000000006')->first();
                            $fechaemision = date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
                            $lotes = FeRefAsoc::where('lote', '=', $idoc)
                                ->pluck('ID_DOCUMENTO')
                                ->toArray();


                            $documento_asociados = $this->gn_lista_comision_asociados_atendidos($lotes, $idoc);
                            $documento_top = $this->gn_lista_comision_asociados_top_terminado($lotes, $idoc);
                            //dd($documento_asociados);
                            /****************************************  VALIDAR SI EL ARCHIVO ESTA ACEPTADO POR SUNAT  *********************************/
                            //dd($documento_top);

                            $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('COD_ESTADO', '<>', 'ETM0000000000006')->first();
                            $fechaemision = date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
                            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
                            $lotes = FeRefAsoc::where('lote', '=', $idoc)
                                ->pluck('ID_DOCUMENTO')
                                ->toArray();


                            $documento_asociados = $this->gn_lista_comision_asociados_atendidos($lotes, $idoc);
                            $documento_top = $this->gn_lista_comision_asociados_top_terminado($lotes, $idoc);
                            //dd($documento_top);
                            //VALIDAR QUE ALGUNOS CAMPOS SEAN IGUALES
                            $this->con_validar_documento_proveedor_comision($documento_asociados, $documento_top, $fedocumento, $detallefedocumento, $idoc);
                                        //dd("hola");
                            $token = '';
                            if ($prefijocarperta == 'II') {
                                $token = $this->generartoken_ii();
                            } else {
                                $token = $this->generartoken_is();
                            }

                            //dd($token);

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

                                    FeDocumento::where('ID_DOCUMENTO', '=', $idoc)
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
                                    FeDocumento::where('ID_DOCUMENTO', '=', $idoc)
                                        ->update(
                                            [
                                                'success' => $arvalidar['success'],
                                                'message' => $arvalidar['message']
                                            ]);
                                }
                            }
                            //ARCHIVOS
                            DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', '=', $idoc)->delete();
                            foreach ($archivosdelfe as $index => $item) {
                                $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA)->first();
                                $docasociar = new CMPDocAsociarCompra;
                                $docasociar->COD_ORDEN = $idoc;
                                $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                                $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                                $docasociar->IND_OBLIGATORIO = $categoria->IND_DOCUMENTO_VAL;
                                $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                                $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                                $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                                $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                                $docasociar->COD_ESTADO = 1;
                                $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
                                $docasociar->save();
                            }

                        } else {
                                return Redirect::to('detalle-comprobante-comision-administrator/' . $idopcion . '/' . $idoc)->with('errorurl', 'Seleccione Archivo XML a Importar');
                        }


                    }


                    /*
                    $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('COD_ESTADO', '<>', 'ETM0000000000006')->first();
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

                    if (!empty($asiento_compra)) {

                        $respuesta = $asiento_compra[0][0]['RESPUESTA'];

                        if ($respuesta === 'ASIENTO CORRECTO') {

                            $cabecera = $asiento_compra[1];
                            $detalle_asiento = $asiento_compra[2];

                            foreach ($cabecera as $detalle) {
                                $COD_ASIENTO = $detalle['COD_ASIENTO'];
                                $COD_EMPR = $detalle['COD_EMPR'];
                                $COD_EMPR_CLI = $detalle['COD_EMPR_CLI'];
                                $TXT_EMPR_CLI = $detalle['TXT_EMPR_CLI'];
                                $COD_CATEGORIA_TIPO_DOCUMENTO = $detalle['COD_CATEGORIA_TIPO_DOCUMENTO'];
                                $TXT_CATEGORIA_TIPO_DOCUMENTO = $detalle['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                                $NRO_SERIE = $detalle['NRO_SERIE'];
                                $NRO_DOC = $detalle['NRO_DOC'];
                                $COD_CENTRO = $detalle['COD_CENTRO'];
                                $COD_PERIODO = $detalle['COD_PERIODO'];
                                $COD_CATEGORIA_TIPO_ASIENTO = $detalle['COD_CATEGORIA_TIPO_ASIENTO'];
                                $TXT_CATEGORIA_TIPO_ASIENTO = $detalle['TXT_CATEGORIA_TIPO_ASIENTO'];
                                $NRO_ASIENTO = $detalle['NRO_ASIENTO'];
                                $FEC_ASIENTO = $detalle['FEC_ASIENTO'];
                                $TXT_GLOSA = $detalle['TXT_GLOSA'];
                                $COD_CATEGORIA_ESTADO_ASIENTO = $detalle['COD_CATEGORIA_ESTADO_ASIENTO'];
                                $TXT_CATEGORIA_ESTADO_ASIENTO = $detalle['TXT_CATEGORIA_ESTADO_ASIENTO'];
                                $COD_CATEGORIA_MONEDA = $detalle['COD_CATEGORIA_MONEDA'];
                                $TXT_CATEGORIA_MONEDA = $detalle['TXT_CATEGORIA_MONEDA'];
                                $CAN_TIPO_CAMBIO = $detalle['CAN_TIPO_CAMBIO'];
                                $CAN_TOTAL_DEBE = $detalle['CAN_TOTAL_DEBE'];
                                $CAN_TOTAL_HABER = $detalle['CAN_TOTAL_HABER'];
                                $COD_ASIENTO_EXTORNO = $detalle['COD_ASIENTO_EXTORNO'];
                                $COD_ASIENTO_EXTORNADO = $detalle['COD_ASIENTO_EXTORNADO'];
                                $IND_EXTORNO = $detalle['IND_EXTORNO'];
                                $IND_ANULADO = $detalle['IND_ANULADO'];
                                $COD_ASIENTO_MODELO = $detalle['COD_ASIENTO_MODELO'];
                                $COD_OBJETO_ORIGEN = $detalle['COD_OBJETO_ORIGEN'];
                                $TXT_TIPO_REFERENCIA = $detalle['TXT_TIPO_REFERENCIA'];
                                $TXT_REFERENCIA = $detalle['TXT_REFERENCIA'];
                                $COD_USUARIO_CREA_AUD = $detalle['COD_USUARIO_CREA_AUD'];
                                $FEC_USUARIO_CREA_AUD = $detalle['FEC_USUARIO_CREA_AUD'];
                                $COD_USUARIO_MODIF_AUD = $detalle['COD_USUARIO_MODIF_AUD'];
                                $FEC_USUARIO_MODIF_AUD = $detalle['FEC_USUARIO_MODIF_AUD'];
                                $COD_ESTADO = $detalle['COD_ESTADO'];
                                $COD_MOTIVO_EXTORNO = $detalle['COD_MOTIVO_EXTORNO'];
                                $GLOSA_EXTORNO = $detalle['GLOSA_EXTORNO'];
                                $COD_CATEGORIA_TIPO_DETRACCION = $detalle['COD_CATEGORIA_TIPO_DETRACCION'];
                                $FEC_DETRACCION = $detalle['FEC_DETRACCION'];
                                $NRO_DETRACCION = $detalle['NRO_DETRACCION'];
                                $CAN_DESCUENTO_DETRACCION = $detalle['CAN_DESCUENTO_DETRACCION'];
                                $CAN_TOTAL_DETRACCION = $detalle['CAN_TOTAL_DETRACCION'];
                                $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $detalle['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                                $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $detalle['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                                $NRO_SERIE_REF = $detalle['NRO_SERIE_REF'];
                                $NRO_DOC_REF = $detalle['NRO_DOC_REF'];
                                $FEC_VENCIMIENTO = $detalle['FEC_VENCIMIENTO'];
                                $IND_AFECTO = $detalle['IND_AFECTO'];
                                $COD_ASIENTO_PAGO_COBRO = $detalle['COD_ASIENTO_PAGO_COBRO'];
                                $SALDO = $detalle['SALDO'];
                                $COD_CATEGORIA_MONEDA_CONVERSION = $detalle['COD_CATEGORIA_MONEDA_CONVERSION'];
                                $TXT_CATEGORIA_MONEDA_CONVERSION = $detalle['TXT_CATEGORIA_MONEDA_CONVERSION'];
                                $IND_MIGRACION_NAVASOFT = $detalle['IND_MIGRACION_NAVASOFT'];
                                $COND_ASIENTO = $detalle['COND_ASIENTO'];
                                $CODIGO_CONTABLE = $detalle['CODIGO_CONTABLE'];
                                $TOTAL_BASE_IMPONIBLE = $detalle['TOTAL_BASE_IMPONIBLE'];
                                $TOTAL_BASE_IMPONIBLE_10 = $detalle['TOTAL_BASE_IMPONIBLE_10'];
                                $TOTAL_BASE_INAFECTA = $detalle['TOTAL_BASE_INAFECTA'];
                                $TOTAL_BASE_EXONERADA = $detalle['TOTAL_BASE_EXONERADA'];
                                $TOTAL_IGV = $detalle['TOTAL_IGV'];
                                $TOTAL_AFECTO_IVAP = $detalle['TOTAL_AFECTO_IVAP'];
                                $TOTAL_IVAP = $detalle['TOTAL_IVAP'];
                                $TOTAL_OTROS_IMPUESTOS = $detalle['TOTAL_OTROS_IMPUESTOS'];

                                $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                                $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                                if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                                    $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                                    $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                                }

                                $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();
                                $tipo_doc_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                                $tipo_doc_ref_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                                $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

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
                                    $tipo_doc_asiento_aux->COD_CATEGORIA,
                                    $tipo_doc_asiento_aux->NOM_CATEGORIA,
                                    $NRO_SERIE,
                                    $NRO_DOC,
                                    $FEC_DETRACCION,
                                    $NRO_DETRACCION,
                                    $CAN_DESCUENTO_DETRACCION,
                                    $CAN_TOTAL_DETRACCION,
                                    isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_CATEGORIA : '',
                                    isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->NOM_CATEGORIA : '',
                                    $NRO_SERIE_REF,
                                    $NRO_DOC_REF,
                                    $FEC_VENCIMIENTO,
                                    0,
                                    $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                    $moneda_asiento_conversion_aux->NOM_CATEGORIA
                                );
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

                    } else {
                        $respuesta = 'GENERACIÓN INCORRECTA ASIENTO';
                    }*/

                    DB::commit();
                } catch (\Exception $ex) {
                    DB::rollback();
                    return Redirect::to('detalle-comprobante-comision-administrator/' . $idopcion . '/' . $idoc)->with('errorbd', $ex . ' Ocurrio un error inesperado - ' . $respuesta);
                }
                return Redirect::to('detalle-comprobante-comision-administrator/' . $idopcion . '/' . $idoc)->with('bienhecho', 'Se valido el xml - ' . $respuesta);

        }
    }


    public function actionDetalleComprobanteComisionAdministrator($idopcion, $lote, Request $request)
    {

        $idoc = $lote;
        $ferefeasoc = FeRefAsoc::where('lote', '=', $lote)->get();
        $fereftop1 = FeRefAsoc::where('lote', '=', $lote)->first();


        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('COD_ESTADO', '<>', 'ETM0000000000006')->first();
        View::share('titulo', 'REGISTRO DE COMPROBANTE ' . $fereftop1->OPERACION . ' : ' . $lote);
        $tiposerie = '';
        $empresa = array();
        $combopagodetraccion = array();
        $usuario = SGDUsuario::where('COD_TRABAJADOR', '=', Session::get('usuario')->usuarioosiris_id)->first();

        //dd($usuario);


        $banco_id = '';
        if (count($fedocumento) > 0) {

            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
            $tiposerie = substr($fedocumento->SERIE, 0, 1);
            $empresa = STDEmpresa::where('NRO_DOCUMENTO', '=', $fedocumento->RUC_PROVEEDOR)->first();

            if (count($empresa) > 0) {
                $combopagodetraccion = array('' => "Seleccione Pago Detraccion", Session::get('empresas')->COD_EMPR => Session::get('empresas')->NOM_EMPR, $empresa->COD_EMPR => $empresa->NOM_EMPR);
            } else {
                $combopagodetraccion = array('' => "Seleccione Pago Detraccion");
            }


            //EMPRESA RELACIONADA
            $empresa_relacionada = STDEmpresa::where('NRO_DOCUMENTO', '=', $fedocumento->RUC_PROVEEDOR)
                ->where('IND_RELACIONADO', '=', 1)
                ->first();


            if (count($empresa_relacionada) > 0) {
                $banco_id = 'BAM0000000000011';
            }


        } else {
            $detallefedocumento = array();
            $empresa_relacionada = array();

        }


        $contacto = DB::table('users')->where('ind_contacto', '=', 1)->pluck('nombre', 'id')->toArray();
        $combocontacto = array('' => "Seleccione Contacto") + $contacto;
        if ($tiposerie == 'E') {
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003', 'DCC0000000000004'])
                ->get();
        } else {
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $idoc)->where('COD_ESTADO', '=', 1)
                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003', 'DCC0000000000004'])
                ->whereIn('TXT_ASIGNADO', ['PROVEEDOR', 'CONTACTO'])
                ->get();
        }
        //no encontro la orden de contrato
        $rutaorden = "";
        $arraybancos = DB::table('CMP.CATEGORIA')->where('TXT_GRUPO', '=', 'BANCOS_MERGE')->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')->toArray();
        $combobancos = array('' => "Seleccione Entidad Bancaria") + $arraybancos;

        $cb_id = '';
        $combocb = array('' => "Seleccione Cuenta Bancaria");
        $combodocumento = array('DCC0000000000002' => 'FACTURA ELECTRONICA', 'DCC0000000000013' => 'RECIBO POR HONORARIO', 'DCC0000000000048' => 'OTROS DOCUMENTOS');
        $documento_id = 'DCC0000000000002';
        $funcion = $this;


        $combotipodetraccion = array('' => "Seleccione Tipo Detraccion", 'MONTO_REFERENCIAL' => 'MONTO REFERENCIAL', 'MONTO_FACTURACION' => 'MONTO FACTURACION');

        $fedocumento_x = FeDocumento::where('TXT_REFERENCIA', '=', $idoc)->first();


        $lotes = FeRefAsoc::where('lote', '=', $lote)
            ->pluck('ID_DOCUMENTO')
            ->toArray();


        $documento_asociados = $this->gn_lista_comision_asociados_atendidos($lotes, $lote);
        $documento_top = $this->gn_lista_comision_asociados_top($lotes);

        $archivospdf = Archivo::where('ID_DOCUMENTO', '=', $idoc)
            ->where('ACTIVO', '=', 1)
            ->where('EXTENSION', 'like', '%'.'pdf'.'%')
            ->get();

        //dd($documento_asociados);
        return View::make('comision/registrocomprobantecomisionadministrator',
            [
                'combotipodetraccion' => $combotipodetraccion,
                'combopagodetraccion' => $combopagodetraccion,
                'fedocumento_x' => $fedocumento_x,
                'empresa' => $empresa,
                'combobancos' => $combobancos,
                'documento_asociados' => $documento_asociados,
                'documento_top' => $documento_top,
                'usuario' => $usuario,
                'combotipodetraccion' => $combotipodetraccion,
                'cb_id' => $cb_id,
                'banco_id' => $banco_id,
                'idoc' => $idoc,
                'combocb' => $combocb,
                'fedocumento' => $fedocumento,
                'detallefedocumento' => $detallefedocumento,
                'combocontacto' => $combocontacto,
                'tarchivos' => $tarchivos,
                'rutaorden' => $rutaorden,
                'combodocumento' => $combodocumento,
                'documento_id' => $documento_id,
                'funcion' => $funcion,
                'fereftop1' => $fereftop1,
                'idopcion' => $idopcion,
                'archivospdf' => $archivospdf,
            ]);
    }


    public function actionDetalleComprobanteComisionAdministratorMasivo($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/

        // Limpiar registro temporal 'MASIVO%' si no venimos de una redirección de subida de XML
        if (!session('xml_cargado_masivo')) {
            DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
            DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
            DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
            DB::table('ARCHIVOS')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
            DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
            DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', 'like', 'MASIVO%')->delete();
        }

        $jsondocumenos = $request->input('jsondocumenos', session('jsondocumenos'));
        $jsondocumenos_array = json_decode($jsondocumenos, true) ?: [];
        $lotes = array_column($jsondocumenos_array, 'data_requerimiento_id');
        
        $atender_map = [];
        foreach ($jsondocumenos_array as $item) {
            $atender_map[$item['data_requerimiento_id']] = $item['atender'];
        }

        $documento_asociados = [];
        if (!empty($lotes)) {
            $documento_asociados = DB::table('TES.OPERACION_CAJA as TES')
                ->leftJoin('STD.EMPRESA as EMS', 'TES.COD_EMPR', '=', 'EMS.COD_EMPR')
                ->leftJoin('TES.CAJA_BANCO as TCB', 'TES.COD_CAJA_BANCO', '=', 'TCB.COD_CAJA_BANCO')
                ->leftJoin('CMP.CATEGORIA as CMD', 'TES.COD_CATEGORIA_MONEDA', '=', 'CMD.COD_CATEGORIA')
                ->select(
                    'TES.COD_OPERACION_CAJA',
                    'TES.COD_EMPR',
                    'EMS.NOM_EMPR',
                    'TES.COD_CAJA_BANCO',
                    DB::raw("CASE WHEN TCB.IND_CAJA = 0 THEN TCB.TXT_BANCO ELSE TCB.TXT_CAJA_BANCO END as NOMBRE_BANCO_CAJA"),
                    'TCB.TXT_CAJA_BANCO as CUENTA',
                    'TES.NRO_CUENTA_BANCARIA',
                    'CMD.NOM_CATEGORIA as MONEDA',
                    DB::raw("
                        CASE 
                            WHEN CMD.NOM_CATEGORIA = 'SOLES' THEN (TES.CAN_HABER_MN - TES.CAN_DEBE_MN)
                            ELSE (TES.CAN_HABER_ME - TES.CAN_DEBE_ME)
                        END AS MONTO
                    ")
                )
                ->whereIn('TES.COD_OPERACION_CAJA', $lotes)
                ->get();

            // Asignar el valor de atender como MONTOATENDIDOREAL
            foreach ($documento_asociados as $doc) {
                $doc->MONTOATENDIDOREAL = isset($atender_map[$doc->COD_OPERACION_CAJA]) ? $atender_map[$doc->COD_OPERACION_CAJA] : 0;
            }
        }
        $documento_asociados = collect($documento_asociados);

        View::share('titulo', 'REGISTRO MASIVO DE COMPROBANTE COMISION');

        $combodocumento = array(
            'DCC0000000000002' => 'FACTURA ELECTRONICA', 
            'DCC0000000000013' => 'RECIBO POR HONORARIO', 
            'DCC0000000000048' => 'OTROS DOCUMENTOS'
        );
        $documento_id = $request->input('documento_id', session('documento_id_subido', 'DCC0000000000002'));
        $idoc = 'MASIVO';
        
        $fedocumentos = FeDocumento::where('ID_DOCUMENTO', 'like', 'MASIVO%')->get();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', 'like', 'MASIVO%')->get();
        
        $documento_top = null;
        if (!empty($lotes)) {
            $primer_req_id = reset($lotes);
            $primer_op = DB::table('TES.OPERACION_CAJA as TES')
                ->leftJoin('TES.CAJA_BANCO as TCB', 'TES.COD_CAJA_BANCO', '=', 'TCB.COD_CAJA_BANCO')
                ->leftJoin('CMP.CATEGORIA as CMD', 'TES.COD_CATEGORIA_MONEDA', '=', 'CMD.COD_CATEGORIA')
                ->select('TES.*', 'TCB.TXT_BANCO', 'TCB.COD_BANCO', 'CMD.NOM_CATEGORIA as MONEDA_NAME')
                ->where('TES.COD_OPERACION_CAJA', $primer_req_id)
                ->first();
            if ($primer_op) {
                $empresa_banco = DB::table('STD.EMPRESA')
                    ->where('COD_EMPR', $primer_op->COD_BANCO)
                    ->first();
                if ($empresa_banco) {
                    $documento_top = new \stdClass();
                    $documento_top->RUC = $empresa_banco->NRO_DOCUMENTO;
                    $documento_top->MONEDA = ($primer_op->MONEDA_NAME == 'SOLES' || $primer_op->MONEDA_NAME == 'PEN') ? 'SOLES' : 'DOLARES';
                }
            }
        }
        if (!$documento_top) {
            $documento_top = new \stdClass();
            $documento_top->RUC = Session::get('empresas')->NRO_DOCUMENTO;
            $documento_top->MONEDA = 'SOLES';
        }

        $fereftop1 = new \stdClass();
        $fereftop1->OPERACION = 'COMISION';

        return View::make('comision/registrocomprobantecomisionadministratormasivo', [
            'idopcion' => $idopcion,
            'jsondocumenos' => $jsondocumenos,
            'combodocumento' => $combodocumento,
            'documento_id' => $documento_id,
            'idoc' => $idoc,
            'documento_asociados' => $documento_asociados,
            'fedocumentos' => $fedocumentos,
            'detallefedocumento' => $detallefedocumento,
            'documento_top' => $documento_top,
            'fereftop1' => $fereftop1,
        ]);
    }


    public function actionCargarXMLComisionAdministratorMasivo($idopcion, $lote, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/

        // Limpiar registros previos de 'MASIVO%'
        DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
        DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
        DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
        DB::table('ARCHIVOS')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
        DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', 'like', 'MASIVO%')->delete();

        $files = $request->file('inputxml');
        $documento_id = $request->input('documento_id');

        if (!empty($files)) {
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $index => $file) {
                $idoc = 'MASIVO_' . $index;

                try {
                    DB::beginTransaction();

                    $xml_content = file_get_contents($file->getRealPath());
                    $factura = null;
                    if ($documento_id == 'DCC0000000000002') {
                        // FACTURA
                        $parser = new InvoiceParser();
                        $factura = $parser->parse($xml_content);
                        $tipo_doc = $factura->gettipoDoc();
                        $moneda_le = $factura->gettipoMoneda();
                    } else {
                        // RECIBO POR HONORARIO
                        $parser = new RHParser();
                        $factura = $parser->parse($xml_content);
                        $tipo_doc = 'R1';
                        $moneda_le = 'PEN';
                    }

                    if (!$factura) {
                        throw new \Exception("Formato XML no soportado o corrupto.");
                    }

                    // VALIDAR QUE EL XML SEA DE LA EMPRESA
                    if ($factura->getClient()->getnumDoc() != Session::get('empresas')->NRO_DOCUMENTO) {
                        throw new \Exception('El xml no corresponde a la empresa ' . Session::get('empresas')->NRO_DOCUMENTO);
                    }

                    $ruc = $factura->getcompany()->getruc();
                    $serie = $factura->getserie();
                    $numero = $factura->getcorrelativo();

                    $rz_p = str_replace(["![CDATA[", "]]"], "", $factura->getcompany()->getrazonSocial());
                    $rz_p = str_replace("?", "Ñ", $rz_p);
                    $rz_p = str_replace("ï¿½", "Ñ", $rz_p);
                    $rz_p = str_replace("MARILÑ", "MARILÚ", $rz_p);

                    $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                    $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $idoc;
                    $this->versicarpetanoexiste($rutafile);
                    
                    $nombrefile = ($index + 1) . '-' . $this->limpiarTildes($file->getClientOriginalName());
                    $rutacompleta = $rutafile . '\\' . $nombrefile;
                    copy($file->getRealPath(), $rutacompleta);
                    $path = $rutacompleta;
                    $extension = $file->getClientOriginalExtension() ?: 'xml';

                    // Insertar FeDocumento temporal
                    $documento = new FeDocumento;
                    $documento->ID_DOCUMENTO = $idoc;
                    $documento->DOCUMENTO_ITEM = 1;
                    $documento->COD_EMPR = Session::get('empresas')->COD_EMPR;
                    $documento->TXT_EMPR = Session::get('empresas')->NOM_EMPR;
                    $documento->TXT_PROCEDENCIA = 'ADM';
                    $documento->ESTADO = 'A';
                    $documento->RUC_PROVEEDOR = $ruc;
                    $documento->RZ_PROVEEDOR = $rz_p;
                    $documento->TIPO_CLIENTE = $factura->getClient()->gettipoDoc();
                    $documento->ID_CLIENTE = $factura->getClient()->getnumDoc();
                    $documento->NOMBRE_CLIENTE = $factura->getClient()->getrznSocial();
                    $documento->DIRECCION_CLIENTE = '';
                    $documento->SERIE = $serie;
                    $documento->NUMERO = $numero;
                    $documento->ID_TIPO_DOC = $tipo_doc;
                    $documento->FEC_VENTA = $factura->getfechaEmision()->format('Ymd');
                    $documento->FEC_VENCI_PAGO = $factura->getfecVencimiento() ? $factura->getfecVencimiento()->format('Ymd') : date('Ymd');
                    $documento->FORMA_PAGO = $factura->getcondicionPago();
                    $documento->FORMA_PAGO_DIAS = 0;
                    $documento->MONEDA = $moneda_le;
                    $documento->VALOR_IGV_ORIG = (float)$factura->getmtoIGV();
                    $documento->VALOR_IGV_SOLES = (float)$factura->getmtoIGV();
                    $documento->SUB_TOTAL_VENTA_ORIG = (float)$factura->getmtoOperGravadas();
                    $documento->SUB_TOTAL_VENTA_SOLES = (float)$factura->getmtoOperGravadas();
                    $documento->TOTAL_VENTA_ORIG = (float)$factura->getmtoImpVenta();
                    $documento->TOTAL_VENTA_SOLES = (float)$factura->getmtoImpVenta();
                    $documento->PERCEPCION = 0;
                    $documento->MONTO_RETENCION = 0;
                    $documento->HORA_EMISION = $factura->gethoraEmision();
                    $documento->IMPUESTO_2 = $factura->getmtoOtrosTributos();
                    $documento->TIPO_DETRACCION = $factura->getdetraccion() ? $factura->getdetraccion()->gettipoDet() : '';
                    $documento->PORC_DETRACCION = $factura->getdetraccion() ? floatval($factura->getdetraccion()->getporcDet()) : 0;
                    $documento->MONTO_DETRACCION = $factura->getdetraccion() ? (float)$factura->getdetraccion()->getbaseDetr() : 0;
                    $documento->MONTO_ANTICIPO = $factura->getdestotalAnticipos();
                    $documento->NRO_ORDEN_COMP = $factura->getcompra();
                    $documento->NUM_GUIA = $factura->getguiaEmbebida();
                    $documento->estadoCp = 0;
                    $documento->ARCHIVO_XML = $nombrefile;
                    $documento->ARCHIVO_CDR = '';
                    $documento->ARCHIVO_PDF = '';
                    $documento->COD_CONTACTO = '';
                    $documento->TXT_CONTACTO = '';
                    $documento->COD_ESTADO = '';
                    $documento->TXT_ESTADO = '';
                    $documento->ind_email_uc = -1;
                    $documento->ind_email_ap = -1;
                    $documento->ind_email_adm = -1;
                    $documento->ind_email_ba = -1;
                    $documento->ind_email_clap = -1;
                    $documento->ind_ruc = 0;
                    $documento->ind_rz = 0;
                    $documento->ind_moneda = 0;
                    $documento->ind_total = 0;
                    $documento->ind_cantidaditem = 0;
                    $documento->ind_formapago = 0;
                    $documento->ind_errototal = 0;
                    $documento->OPERACION = 'COMISION';
                    $documento->OPERACION_DET = 'CON_XML';
                    $documento->MONTO_NC = 0.00;
                    $documento->save();

                    // Guardar en ARCHIVOS
                    $dcontrol = new Archivo;
                    $dcontrol->ID_DOCUMENTO = $idoc;
                    $dcontrol->DOCUMENTO_ITEM = 1;
                    $dcontrol->TIPO_ARCHIVO = 'DCC0000000000003';
                    $dcontrol->NOMBRE_ARCHIVO = $nombrefile;
                    $dcontrol->DESCRIPCION_ARCHIVO = 'XML DEL COMPROBANTE DE COMPRA';
                    $dcontrol->URL_ARCHIVO = $path;
                    $dcontrol->SIZE = filesize($file->getRealPath());
                    $dcontrol->EXTENSION = $extension;
                    $dcontrol->ACTIVO = 1;
                    $dcontrol->FECHA_CREA = $this->fechaactual;
                    $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                    $dcontrol->save();

                    // DETALLE
                    foreach ($factura->getdetails() as $indexdet => $itemdet) {
                        $producto = str_replace(["<![CDATA[", "]]>"], "", $itemdet->getdescripcion());
                        $producto = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);
                        $linea_det = str_pad($indexdet + 1, 3, "0", STR_PAD_LEFT);

                        $detalle = new FeDetalleDocumento;
                        $detalle->ID_DOCUMENTO = $idoc;
                        $detalle->DOCUMENTO_ITEM = 1;
                        $detalle->LINEID = $linea_det;
                        $detalle->CODPROD = $itemdet->getcodProducto();
                        $detalle->PRODUCTO = $producto;
                        $detalle->UND_PROD = $itemdet->getunidad();
                        $detalle->CANTIDAD = $itemdet->getcantidad();
                        $detalle->PRECIO_UNIT = (float)$itemdet->getmtoValorUnitario();
                        $detalle->VAL_IGV_ORIG = (float)$itemdet->getigv();
                        $detalle->VAL_IGV_SOL = (float)$itemdet->getigv();
                        $detalle->VAL_SUBTOTAL_ORIG = (float)$itemdet->getmtoValorVenta();
                        $detalle->VAL_SUBTOTAL_SOL = (float)$itemdet->getmtoValorVenta();
                        $detalle->VAL_VENTA_ORIG = (float)$itemdet->getigv() + (float)$itemdet->getmtoValorVenta();
                        $detalle->VAL_VENTA_SOL = (float)$itemdet->getigv() + (float)$itemdet->getmtoValorVenta();
                        $detalle->PRECIO_ORIG = (float)$itemdet->getmtoPrecioUnitario();
                        $detalle->save();
                    }

                    // CONSULTA API SUNAT
                    $prefijo_emp = $this->prefijo_empresa($documento->COD_EMPR);
                    if ($prefijo_emp == 'II') {
                        $token = $this->generartoken_ii();
                    } else {
                        $token = $this->generartoken_is();
                    }

                    $fechaemision = date_format(date_create($documento->FEC_VENTA), 'd/m/Y');
                    $rvalidar = $this->validar_xml(
                        $token,
                        $documento->ID_CLIENTE,
                        $documento->RUC_PROVEEDOR,
                        $documento->ID_TIPO_DOC,
                        $documento->SERIE,
                        $documento->NUMERO,
                        $fechaemision,
                        $documento->TOTAL_VENTA_ORIG
                    );

                    $arvalidar = json_decode($rvalidar, true);
                    if ($arvalidar['success'] == 1) {
                        FeDocumento::where('ID_DOCUMENTO', '=', $idoc)
                            ->update([
                                'success' => $arvalidar['success'],
                                'message' => $arvalidar['message'],
                                'estadoCp' => '1',
                                'nestadoCp' => 'ACEPTADO',
                                'estadoRuc' => '00',
                                'nestadoRuc' => 'ACTIVO',
                                'condDomiRuc' => '00',
                                'ncondDomiRuc' => 'HABIDO',
                            ]);
                    } else {
                        FeDocumento::where('ID_DOCUMENTO', '=', $idoc)
                            ->update([
                                'success' => $arvalidar['success'],
                                'message' => $arvalidar['message'],
                                'estadoCp' => '0',
                                'nestadoCp' => 'RECHAZADO',
                                'estadoRuc' => '00',
                                'nestadoRuc' => 'INACTIVO',
                                'condDomiRuc' => '00',
                                'ncondDomiRuc' => 'NO HABIDO',
                            ]);
                    }

                    // VALIDAR RUC, MONEDA Y TOTAL
                    $jsondocumenos_array = json_decode($request->input('jsondocumenos'), true) ?: [];
                    $lotes_val = array_column($jsondocumenos_array, 'data_requerimiento_id');
                    
                    $banco_ruc = '';
                    $op_moneda = 'SOLES';
                    
                    if (!empty($lotes_val)) {
                        $primer_req_id = reset($lotes_val);
                        $primer_op = DB::table('TES.OPERACION_CAJA as TES')
                            ->leftJoin('TES.CAJA_BANCO as TCB', 'TES.COD_CAJA_BANCO', '=', 'TCB.COD_CAJA_BANCO')
                            ->leftJoin('CMP.CATEGORIA as CMD', 'TES.COD_CATEGORIA_MONEDA', '=', 'CMD.COD_CATEGORIA')
                            ->select('TES.*', 'TCB.TXT_BANCO', 'TCB.COD_BANCO', 'CMD.NOM_CATEGORIA as MONEDA_NAME')
                            ->where('TES.COD_OPERACION_CAJA', $primer_req_id)
                            ->first();
                        if ($primer_op) {
                            $empresa_banco = DB::table('STD.EMPRESA')
                                ->where('COD_EMPR', $primer_op->COD_BANCO)
                                ->first();
                            if ($empresa_banco) {
                                $banco_ruc = $empresa_banco->NRO_DOCUMENTO;
                            }
                            $op_moneda = ($primer_op->MONEDA_NAME == 'SOLES' || $primer_op->MONEDA_NAME == 'PEN') ? 'SOLES' : 'DOLARES';
                        }
                    }
                    
                    // Buscar una operación que coincida en monto con este XML
                    $matched_op = null;
                    foreach ($jsondocumenos_array as $op_item) {
                        if (abs((float)$op_item['atender'] - $documento->TOTAL_VENTA_ORIG) <= 0.05) {
                            $matched_op = $op_item;
                            break;
                        }
                    }
                    $target_total = $matched_op ? (float)$matched_op['atender'] : ($jsondocumenos_array ? (float)$jsondocumenos_array[0]['atender'] : 0);

                    $ind_ruc = ($documento->RUC_PROVEEDOR == $banco_ruc) ? 1 : 0;
                    
                    $xml_moneda = ($documento->MONEDA == 'PEN' || $documento->MONEDA == 'SOLES') ? 'SOLES' : 'DOLARES';
                    $ind_moneda = ($xml_moneda == $op_moneda) ? 1 : 0;
                    
                    $ind_total = (abs($target_total - $documento->TOTAL_VENTA_ORIG) <= 0.09) ? 1 : 0;
                    $ind_errototal = ($ind_ruc == 1 && $ind_moneda == 1 && $ind_total == 1) ? 1 : 0;
                    
                    FeDocumento::where('ID_DOCUMENTO', '=', $idoc)
                        ->update([
                            'ind_ruc' => $ind_ruc,
                            'ind_moneda' => $ind_moneda,
                            'ind_total' => $ind_total,
                            'ind_errototal' => $ind_errototal,
                            'ind_cantidaditem' => 1,
                            'ind_formapago' => 1,
                        ]);

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    // Log or handle error for individual XML
                }
            }
        }

        return redirect()->back()
            ->with('bienhecho', 'XMLs subidos y validados correctamente ante SUNAT.')
            ->with('xml_cargado_masivo', true)
            ->with('jsondocumenos', $request->input('jsondocumenos'))
            ->with('documento_id_subido', $request->input('documento_id'));
    }


    public function actionSubirPDFMasivoComisionAdministrator($idopcion, $lote, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/

        return redirect()->back()
            ->with('bienhecho', 'PDFs subidos correctamente (Modo Masivo)')
            ->with('jsondocumenos', $request->input('jsondocumenos'));
    }


    public function actionGuardarComisionMasivo($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return response()->json(['success' => false, 'message' => 'No tiene permisos para esta acción']);
        }
        /******************************************************/

        try {
            DB::beginTransaction();

            $jsondocumenos = json_decode($request->input('jsondocumenos'), true) ?: [];
            $pdfs_info = json_decode($request->input('pdfs_info'), true) ?: [];
            $documento_id = $request->input('documento_id');

            if (empty($jsondocumenos)) {
                return response()->json(['success' => false, 'message' => 'No hay documentos asociados seleccionados.']);
            }
            if ($documento_id == 'DCC0000000000048' && empty($pdfs_info)) {
                return response()->json(['success' => false, 'message' => 'No se ha cargado la información de los comprobantes PDFs.']);
            }

            if ($documento_id != 'DCC0000000000048') { // MODO XML
                $fedocs_temp = FeDocumento::where('ID_DOCUMENTO', 'like', 'MASIVO%')->get();
                if ($fedocs_temp->isEmpty()) {
                    return response()->json(['success' => false, 'message' => 'No se ha cargado/validado ningún XML.']);
                }

                $ultimo_lote = $this->funciones->generar_lote('FE_REF_ASOC', 8);
                $lote_num = (int)$ultimo_lote;


                $xml_counter = 0;
                foreach ($fedocs_temp as $fedoc_temp) {
                    $id_doc = str_pad($lote_num + $xml_counter, 8, "0", STR_PAD_LEFT);

                    // Copiar FeDocumento
                    $documento = new FeDocumento;
                    $documento->ID_DOCUMENTO = $id_doc;
                    $documento->DOCUMENTO_ITEM = 1;
                    $documento->COD_EMPR = $fedoc_temp->COD_EMPR;
                    $documento->TXT_EMPR = $fedoc_temp->TXT_EMPR;
                    $documento->TXT_PROCEDENCIA = $fedoc_temp->TXT_PROCEDENCIA;
                    $documento->ESTADO = $fedoc_temp->ESTADO;
                    $documento->RUC_PROVEEDOR = $fedoc_temp->RUC_PROVEEDOR;
                    $documento->RZ_PROVEEDOR = $fedoc_temp->RZ_PROVEEDOR;
                    $documento->TIPO_CLIENTE = $fedoc_temp->TIPO_CLIENTE;
                    $documento->ID_CLIENTE = $fedoc_temp->ID_CLIENTE;
                    $documento->NOMBRE_CLIENTE = $fedoc_temp->NOMBRE_CLIENTE;
                    $documento->DIRECCION_CLIENTE = $fedoc_temp->DIRECCION_CLIENTE;
                    $documento->SERIE = $fedoc_temp->SERIE;
                    $documento->NUMERO = $fedoc_temp->NUMERO;
                    $documento->ID_TIPO_DOC = $fedoc_temp->ID_TIPO_DOC;
                    $documento->FEC_VENTA = $fedoc_temp->FEC_VENTA;
                    $documento->FEC_VENCI_PAGO = $fedoc_temp->FEC_VENCI_PAGO;
                    $documento->FORMA_PAGO = $fedoc_temp->FORMA_PAGO;
                    $documento->FORMA_PAGO_DIAS = $fedoc_temp->FORMA_PAGO_DIAS;
                    $documento->MONEDA = $fedoc_temp->MONEDA;
                    $documento->VALOR_IGV_ORIG = $fedoc_temp->VALOR_IGV_ORIG;
                    $documento->VALOR_IGV_SOLES = $fedoc_temp->VALOR_IGV_SOLES;
                    $documento->SUB_TOTAL_VENTA_ORIG = $fedoc_temp->SUB_TOTAL_VENTA_ORIG;
                    $documento->SUB_TOTAL_VENTA_SOLES = $fedoc_temp->SUB_TOTAL_VENTA_SOLES;
                    $documento->TOTAL_VENTA_ORIG = $fedoc_temp->TOTAL_VENTA_ORIG;
                    $documento->TOTAL_VENTA_SOLES = $fedoc_temp->TOTAL_VENTA_SOLES;
                    $documento->PERCEPCION = $fedoc_temp->PERCEPCION;
                    $documento->MONTO_RETENCION = $fedoc_temp->MONTO_RETENCION;
                    $documento->HORA_EMISION = $fedoc_temp->HORA_EMISION;
                    $documento->IMPUESTO_2 = $fedoc_temp->IMPUESTO_2;
                    $documento->TIPO_DETRACCION = $fedoc_temp->TIPO_DETRACCION;
                    $documento->PORC_DETRACCION = $fedoc_temp->PORC_DETRACCION;
                    $documento->MONTO_DETRACCION = $fedoc_temp->MONTO_DETRACCION;
                    $documento->MONTO_ANTICIPO = $fedoc_temp->MONTO_ANTICIPO;
                    $documento->NRO_ORDEN_COMP = $fedoc_temp->NRO_ORDEN_COMP;
                    $documento->NUM_GUIA = $fedoc_temp->NUM_GUIA;
                    $documento->estadoCp = $fedoc_temp->estadoCp;
                    $documento->nestadoCp = $fedoc_temp->nestadoCp;
                    $documento->estadoRuc = $fedoc_temp->estadoRuc;
                    $documento->nestadoRuc = $fedoc_temp->nestadoRuc;
                    $documento->condDomiRuc = $fedoc_temp->condDomiRuc;
                    $documento->ncondDomiRuc = $fedoc_temp->ncondDomiRuc;
                    $documento->success = $fedoc_temp->success;
                    $documento->message = $fedoc_temp->message;
                    $documento->ARCHIVO_XML = $fedoc_temp->ARCHIVO_XML;
                    $documento->ARCHIVO_CDR = $fedoc_temp->ARCHIVO_CDR;
                    $documento->ARCHIVO_PDF = $fedoc_temp->ARCHIVO_PDF;
                    $documento->COD_CONTACTO = $fedoc_temp->COD_CONTACTO;
                    $documento->TXT_CONTACTO = $fedoc_temp->TXT_CONTACTO;
                    $documento->COD_ESTADO = $fedoc_temp->COD_ESTADO;
                    $documento->TXT_ESTADO = $fedoc_temp->TXT_ESTADO;
                    $documento->ind_email_uc = $fedoc_temp->ind_email_uc;
                    $documento->ind_email_ap = $fedoc_temp->ind_email_ap;
                    $documento->ind_email_adm = $fedoc_temp->ind_email_adm;
                    $documento->ind_email_ba = $fedoc_temp->ind_email_ba;
                    $documento->ind_email_clap = $fedoc_temp->ind_email_clap;
                    $documento->ind_ruc = $fedoc_temp->ind_ruc;
                    $documento->ind_rz = $fedoc_temp->ind_rz;
                    $documento->ind_moneda = $fedoc_temp->ind_moneda;
                    $documento->ind_total = $fedoc_temp->ind_total;
                    $documento->ind_cantidaditem = $fedoc_temp->ind_cantidaditem;
                    $documento->ind_formapago = $fedoc_temp->ind_formapago;
                    $documento->ind_errototal = $fedoc_temp->ind_errototal;
                    $documento->OPERACION = 'COMISION';
                    $documento->OPERACION_DET = $fedoc_temp->OPERACION_DET;
                    $documento->MONTO_NC = $fedoc_temp->MONTO_NC;

                    // Guardar PDF asociado si se envió alguno en modo XML (antes del save para evitar doble guardado)
                    if ($request->hasFile('inputpdf')) {
                        $pdf_files = $request->file('inputpdf');
                        if (!is_array($pdf_files)) {
                            $pdf_files = [$pdf_files];
                        }
                        $matched_pdf = null;
                        foreach ($pdf_files as $file_pdf) {
                            $clean_pdf_name = strtolower($file_pdf->getClientOriginalName());
                            $xml_serie = strtolower($fedoc_temp->SERIE);
                            $xml_numero = (int)$fedoc_temp->NUMERO;
                            if (strpos($clean_pdf_name, $xml_serie) !== false && strpos($clean_pdf_name, (string)$xml_numero) !== false) {
                                $matched_pdf = $file_pdf;
                                break;
                            }
                        }

                        if (!$matched_pdf && isset($pdf_files[$xml_counter])) {
                            $matched_pdf = $pdf_files[$xml_counter];
                        }

                        if ($matched_pdf) {
                            $ext_pdf = $matched_pdf->getClientOriginalExtension();
                            $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                            
                            $nom_pdf = $id_doc . '-' . $documento->RUC_PROVEEDOR . '-' . $documento->ID_TIPO_DOC . '-' . $documento->SERIE . '-' . $documento->NUMERO . '.' . $ext_pdf;
                            
                            // Crear la carpeta física si no existe
                            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $id_doc;
                            $this->versicarpetanoexiste($rutafile);
                            
                            $path_pdf = $rutafile . '\\' . $nom_pdf;
                            copy($matched_pdf->getRealPath(), $path_pdf);

                            $dcontrol_pdf = new Archivo;
                            $dcontrol_pdf->ID_DOCUMENTO = $id_doc;
                            $dcontrol_pdf->DOCUMENTO_ITEM = 2; // ITEM 2 para PDF
                            $dcontrol_pdf->TIPO_ARCHIVO = 'DCC0000000000002'; // PDF
                            $dcontrol_pdf->NOMBRE_ARCHIVO = $nom_pdf;
                            $dcontrol_pdf->DESCRIPCION_ARCHIVO = 'PDF DEL COMPROBANTE DE COMPRA';
                            $dcontrol_pdf->URL_ARCHIVO = $path_pdf;
                            $dcontrol_pdf->SIZE = filesize($matched_pdf->getRealPath());
                            $dcontrol_pdf->EXTENSION = $ext_pdf;
                            $dcontrol_pdf->ACTIVO = 1;
                            $dcontrol_pdf->FECHA_CREA = $this->fechaactual;
                            $dcontrol_pdf->USUARIO_CREA = Session::get('usuario')->id;
                            $dcontrol_pdf->save();
                            
                            // Asignar ARCHIVO_PDF en FeDocumento antes del primer save
                            $documento->ARCHIVO_PDF = $nom_pdf;
                        }
                    }

                    $documento->save();

                    // Registrar el tipo de documento en CMPDocAsociarCompra
                    $docasociar = new CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN = $id_doc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO = $documento_id; // DCC0000000000002 o DCC0000000000013
                    $docasociar->NOM_CATEGORIA_DOCUMENTO = ($documento_id == 'DCC0000000000002') ? 'FACTURA ELECTRONICA' : 'RECIBO POR HONORARIO';
                    $docasociar->IND_OBLIGATORIO = 1;
                    $docasociar->TXT_FORMATO = 'XML';
                    $docasociar->TXT_ASIGNADO = 'CONTACTO';
                    $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                    $docasociar->COD_ESTADO = 1;
                    $docasociar->TIP_DOC = 'N';
                    $docasociar->save();

                    // Copiar FeDetalleDocumento
                    $dets_temp = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $fedoc_temp->ID_DOCUMENTO)->get();
                    foreach ($dets_temp as $det_temp) {
                        $detalle = new FeDetalleDocumento;
                        $detalle->ID_DOCUMENTO = $id_doc;
                        $detalle->DOCUMENTO_ITEM = 1;
                        $detalle->LINEID = $det_temp->LINEID;
                        $detalle->CODPROD = $det_temp->CODPROD;
                        $detalle->PRODUCTO = $det_temp->PRODUCTO;
                        $detalle->UND_PROD = $det_temp->UND_PROD;
                        $detalle->CANTIDAD = $det_temp->CANTIDAD;
                        $detalle->PRECIO_UNIT = $det_temp->PRECIO_UNIT;
                        $detalle->VAL_IGV_ORIG = $det_temp->VAL_IGV_ORIG;
                        $detalle->VAL_IGV_SOL = $det_temp->VAL_IGV_SOL;
                        $detalle->VAL_SUBTOTAL_ORIG = $det_temp->VAL_SUBTOTAL_ORIG;
                        $detalle->VAL_SUBTOTAL_SOL = $det_temp->VAL_SUBTOTAL_SOL;
                        $detalle->VAL_VENTA_ORIG = $det_temp->VAL_VENTA_ORIG;
                        $detalle->VAL_VENTA_SOL = $det_temp->VAL_VENTA_SOL;
                        $detalle->PRECIO_ORIG = $det_temp->PRECIO_ORIG;
                        $detalle->save();
                    }

                    // Copiar el Archivo XML en BD
                    $archivos_temp = Archivo::where('ID_DOCUMENTO', '=', $fedoc_temp->ID_DOCUMENTO)->get();
                    foreach ($archivos_temp as $archivo_temp) {
                        $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $id_doc;
                        $this->versicarpetanoexiste($rutafile);
                        $new_xml_path = $rutafile . '\\' . $archivo_temp->NOMBRE_ARCHIVO;

                        // Copiar el archivo físico
                        if (file_exists($archivo_temp->URL_ARCHIVO)) {
                            copy($archivo_temp->URL_ARCHIVO, $new_xml_path);
                        }

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $id_doc;
                        $dcontrol->DOCUMENTO_ITEM = $archivo_temp->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO = $archivo_temp->TIPO_ARCHIVO;
                        $dcontrol->NOMBRE_ARCHIVO = $archivo_temp->NOMBRE_ARCHIVO;
                        $dcontrol->DESCRIPCION_ARCHIVO = $archivo_temp->DESCRIPCION_ARCHIVO;
                        $dcontrol->URL_ARCHIVO = $new_xml_path;
                        $dcontrol->SIZE = $archivo_temp->SIZE;
                        $dcontrol->EXTENSION = $archivo_temp->EXTENSION;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                    }

                    // Registrar en FeDocumentoHistorial
                    $historial = new FeDocumentoHistorial;
                    $historial->ID_DOCUMENTO = $id_doc;
                    $historial->DOCUMENTO_ITEM = 1;
                    $historial->FECHA = $this->fechaactual;
                    $historial->USUARIO_ID = Session::get('usuario')->id;
                    $historial->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $historial->TIPO = 'SUBIO DOCUMENTOS';
                    $historial->MENSAJE = '';
                    $historial->save();

                    // Asociar este comprobante con todas las operaciones de caja seleccionadas (con el valor completo)
                    foreach ($jsondocumenos as $op_item) {
                        $ref = new FeRefAsoc;
                        $ref->LOTE = $id_doc;
                        $ref->ID_DOCUMENTO = $op_item['data_requerimiento_id'];
                        $ref->FECHA_CREA = $this->fechaactual;
                        $ref->COD_ESTADO = 1;
                        $ref->ESTATUS = 'ON';
                        $ref->TXT_ESTADO = 'TERMINADA';
                        $ref->OPERACION = 'COMISION';
                        $ref->ATENDIDO = (float)$op_item['atender'];
                        $ref->USUARIO_CREA = Session::get('usuario')->id;
                        $ref->save();
                    }
                    $xml_counter++;
                }

                // Limpiar registros temporales 'MASIVO%'
                DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
                DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
                DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
                DB::table('ARCHIVOS')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
                DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO', 'like', 'MASIVO%')->delete();
                DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', 'like', 'MASIVO%')->delete();
            } else {
                // MODO PDFs (OTROS DOCUMENTOS)
                // Obtener el primer documento asociado para identificar el banco y su empresa asociada
                $primer_doc = reset($jsondocumenos);
                $req_id = $primer_doc['data_requerimiento_id'];
                
                // Consultar la operación de caja para extraer el COD_BANCO y buscar la empresa
                $primer_op = DB::table('TES.OPERACION_CAJA as TES')
                    ->leftJoin('TES.CAJA_BANCO as TCB', 'TES.COD_CAJA_BANCO', '=', 'TCB.COD_CAJA_BANCO')
                    ->where('TES.COD_OPERACION_CAJA', $req_id)
                    ->first();

                if (!$primer_op) {
                    return response()->json(['success' => false, 'message' => 'No se encontró la transacción bancaria original.']);
                }

                $empresa = DB::table('STD.EMPRESA')
                    ->where('COD_EMPR', $primer_op->COD_BANCO)
                    ->first();

                if (!$empresa) {
                    // Si no se encuentra empresa asociada al banco, usar los datos de la empresa actual de la sesión
                    $empresa = Session::get('empresas');
                }


                // Obtener el lote inicial desde la base de datos
                $ultimo_lote = $this->funciones->generar_lote('FE_REF_ASOC', 8);
                $lote_num = (int)$ultimo_lote;

                // Procesar cada comprobante PDF enviado
                foreach ($pdfs_info as $index => $pdf) {
                    $filename = $pdf['filename'];
                    $total_pdf = (float)$pdf['total'];
                    $subtotal_pdf = (float)$pdf['subtotal'];
                    $igv_pdf = (float)$pdf['igv'];
                    $serie_pdf = strtoupper($pdf['serie']);
                    $numero_pdf = str_pad($pdf['numero'], 10, '0', STR_PAD_LEFT);

                    // 1. Generar el lote correlativo sumando en memoria para evitar colisiones
                    $id_doc = str_pad($lote_num + $index, 8, "0", STR_PAD_LEFT);

                    // 2. Registrar el documento en FE_DOCUMENTO
                    $documento = new FeDocumento;
                    $documento->ID_DOCUMENTO = $id_doc;
                    $documento->DOCUMENTO_ITEM = 1;
                    $documento->COD_EMPR = Session::get('empresas')->COD_EMPR;
                    $documento->TXT_EMPR = Session::get('empresas')->NOM_EMPR;
                    $documento->TXT_PROCEDENCIA = 'ADM';
                    $documento->ESTADO = 'A';
                    $documento->RUC_PROVEEDOR = $empresa->NRO_DOCUMENTO;
                    $documento->RZ_PROVEEDOR = $empresa->NOM_EMPR;
                    $documento->TIPO_CLIENTE = '';
                    $documento->ID_CLIENTE = Session::get('empresas')->NRO_DOCUMENTO;
                    $documento->NOMBRE_CLIENTE = Session::get('empresas')->NOM_EMPR;
                    $documento->DIRECCION_CLIENTE = '';
                    $documento->SERIE = $serie_pdf;
                    $documento->NUMERO = $numero_pdf;
                    $documento->ID_TIPO_DOC = '01'; // Factura electrónica por defecto
                    $documento->FEC_VENTA = date('Ymd');
                    $documento->FEC_VENCI_PAGO = date('Ymd');
                    $documento->FORMA_PAGO = '';
                    $documento->FORMA_PAGO_DIAS = 0;
                    $documento->MONEDA = 'SOLES';
                    $documento->VALOR_IGV_ORIG = $igv_pdf;
                    $documento->VALOR_IGV_SOLES = $igv_pdf;
                    $documento->SUB_TOTAL_VENTA_ORIG = $subtotal_pdf;
                    $documento->SUB_TOTAL_VENTA_SOLES = $subtotal_pdf;
                    $documento->TOTAL_VENTA_ORIG = $total_pdf;
                    $documento->TOTAL_VENTA_SOLES = $total_pdf;
                    $documento->PERCEPCION = 0;
                    $documento->MONTO_RETENCION = 0;
                    $documento->HORA_EMISION = '';
                    $documento->IMPUESTO_2 = 0;
                    $documento->TIPO_DETRACCION = '';
                    $documento->PORC_DETRACCION = 0;
                    $documento->MONTO_DETRACCION = 0;
                    $documento->MONTO_ANTICIPO = 0;
                    $documento->NRO_ORDEN_COMP = '';
                    $documento->NUM_GUIA = '';
                    $documento->estadoCp = 0;
                    $documento->ARCHIVO_XML = '';
                    $documento->ARCHIVO_CDR = '';
                    $documento->ARCHIVO_PDF = '';
                    $documento->COD_CONTACTO = '';
                    $documento->TXT_CONTACTO = '';
                    $documento->COD_ESTADO = '';
                    $documento->TXT_ESTADO = '';
                    $documento->ind_email_uc = -1;
                    $documento->ind_email_ap = -1;
                    $documento->ind_email_adm = -1;
                    $documento->ind_email_ba = -1;
                    $documento->ind_email_clap = -1;
                    $documento->ind_ruc = 1;
                    $documento->ind_rz = 1;
                    $documento->ind_moneda = 1;
                    $documento->ind_total = 1;
                    $documento->ind_cantidaditem = 1;
                    $documento->ind_formapago = 1;
                    $documento->ind_errototal = 1;
                    $documento->OPERACION = 'COMISION';
                    $documento->OPERACION_DET = 'SIN_XML';
                    $documento->MONTO_NC = 0.00;
                    $documento->save();

                    // Registrar el tipo de documento en CMPDocAsociarCompra
                    $docasociar = new CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN = $id_doc;
                    $docasociar->COD_CATEGORIA_DOCUMENTO = 'DCC0000000000048'; // OTROS DOCUMENTOS
                    $docasociar->NOM_CATEGORIA_DOCUMENTO = 'OTROS DOCUMENTOS';
                    $docasociar->IND_OBLIGATORIO = 1;
                    $docasociar->TXT_FORMATO = 'PDF';
                    $docasociar->TXT_ASIGNADO = 'CONTACTO';
                    $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                    $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                    $docasociar->COD_ESTADO = 1;
                    $docasociar->TIP_DOC = 'N';
                    $docasociar->save();

                    // Registrar las 2 líneas de detalle en FE_DETALLE_DOCUMENTO
                    // Línea 1: INTERES ADELANTADO
                    $interes_sub = isset($pdf['interes']['subtotal']) ? (float)$pdf['interes']['subtotal'] : 0;
                    $interes_igv = isset($pdf['interes']['igv']) ? (float)$pdf['interes']['igv'] : 0;
                    $interes_tot = isset($pdf['interes']['total']) ? (float)$pdf['interes']['total'] : 0;

                    $detalle1 = new FeDetalleDocumento;
                    $detalle1->ID_DOCUMENTO = $id_doc;
                    $detalle1->DOCUMENTO_ITEM = 1;
                    $detalle1->LINEID = '001';
                    $detalle1->CODPROD = '';
                    $detalle1->PRODUCTO = 'INTERES ADELANTADO';
                    $detalle1->UND_PROD = 'ZZ';
                    $detalle1->CANTIDAD = 1;
                    $detalle1->PRECIO_UNIT = $interes_sub;
                    $detalle1->VAL_IGV_ORIG = $interes_igv;
                    $detalle1->VAL_IGV_SOL = $interes_igv;
                    $detalle1->VAL_SUBTOTAL_ORIG = $interes_sub;
                    $detalle1->VAL_SUBTOTAL_SOL = $interes_sub;
                    $detalle1->VAL_VENTA_ORIG = $interes_tot;
                    $detalle1->VAL_VENTA_SOL = $interes_tot;
                    $detalle1->PRECIO_ORIG = $interes_tot;
                    $detalle1->save();

                    // Línea 2: COMISIONES
                    $comision_sub = isset($pdf['comisiones']['subtotal']) ? (float)$pdf['comisiones']['subtotal'] : 0;
                    $comision_igv = isset($pdf['comisiones']['igv']) ? (float)$pdf['comisiones']['igv'] : 0;
                    $comision_tot = isset($pdf['comisiones']['total']) ? (float)$pdf['comisiones']['total'] : 0;

                    $detalle2 = new FeDetalleDocumento;
                    $detalle2->ID_DOCUMENTO = $id_doc;
                    $detalle2->DOCUMENTO_ITEM = 1;
                    $detalle2->LINEID = '002';
                    $detalle2->CODPROD = '';
                    $detalle2->PRODUCTO = 'COMISIONES';
                    $detalle2->UND_PROD = 'ZZ';
                    $detalle2->CANTIDAD = 1;
                    $detalle2->PRECIO_UNIT = $comision_sub;
                    $detalle2->VAL_IGV_ORIG = $comision_igv;
                    $detalle2->VAL_IGV_SOL = $comision_igv;
                    $detalle2->VAL_SUBTOTAL_ORIG = $comision_sub;
                    $detalle2->VAL_SUBTOTAL_SOL = $comision_sub;
                    $detalle2->VAL_VENTA_ORIG = $comision_tot;
                    $detalle2->VAL_VENTA_SOL = $comision_tot;
                    $detalle2->PRECIO_ORIG = $comision_tot;
                    $detalle2->save();

                    // 3. Asociar el archivo PDF físico si corresponde
                    $file = null;
                    if ($request->hasFile("inputpdf")) {
                        $uploaded_files = $request->file("inputpdf");
                        if (!is_array($uploaded_files)) {
                            $uploaded_files = [$uploaded_files];
                        }
                        foreach ($uploaded_files as $f) {
                            if ($f->getClientOriginalName() == $filename) {
                                $file = $f;
                                break;
                            }
                        }
                    }

                    if ($file) {
                        $contadorArchivos = Archivo::count();
                        $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $id_doc;
                        $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                        $this->versicarpetanoexiste($rutafile);
                        $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                        
                        // Copiar archivo físico
                        copy($file->getRealPath(), $rutacompleta);

                        // Insertar en ARCHIVOS
                        $extension = $file->getClientOriginalExtension() ?: 'pdf';
                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $id_doc;
                        $dcontrol->DOCUMENTO_ITEM = 1;
                        $dcontrol->TIPO_ARCHIVO = 'DCC0000000000048'; // OTROS DOCUMENTOS
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'OTROS DOCUMENTOS';
                        $dcontrol->URL_ARCHIVO = $rutacompleta;
                        $dcontrol->SIZE = filesize($file->getRealPath());
                        $dcontrol->EXTENSION = $extension;
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();
                    }

                    // Registrar en FeDocumentoHistorial
                    $historial = new FeDocumentoHistorial;
                    $historial->ID_DOCUMENTO = $id_doc;
                    $historial->DOCUMENTO_ITEM = 1;
                    $historial->FECHA = $this->fechaactual;
                    $historial->USUARIO_ID = Session::get('usuario')->id;
                    $historial->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $historial->TIPO = 'SUBIO DOCUMENTOS';
                    $historial->MENSAJE = '';
                    $historial->save();

                    // 4. Asociar este lote con todas las operaciones caja seleccionadas (con el valor completo)
                    foreach ($jsondocumenos as $op_item) {
                        $ref = new FeRefAsoc;
                        $ref->LOTE = $id_doc;
                        $ref->ID_DOCUMENTO = $op_item['data_requerimiento_id'];
                        $ref->FECHA_CREA = $this->fechaactual;
                        $ref->COD_ESTADO = 1;
                        $ref->ESTATUS = 'ON';
                        $ref->TXT_ESTADO = 'TERMINADA';
                        $ref->OPERACION = 'COMISION';
                        $ref->ATENDIDO = (float)$op_item['atender'];
                        $ref->USUARIO_CREA = Session::get('usuario')->id;
                        $ref->save();
                    }
                }
            }

            // 5. Actualizar monto atendido en la tabla original de operaciones caja (una sola vez por transacción)
            foreach ($jsondocumenos as $op_item) {
                $op_id = $op_item['data_requerimiento_id'];
                $monto_atender = (float)$op_item['atender'];
                TESOperacionCaja::where('COD_OPERACION_CAJA', $op_id)
                    ->update([
                        'ATENDIDO' => DB::raw("ISNULL(ATENDIDO, 0) + $monto_atender")
                    ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Procesamiento y guardado masivo exitoso.']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error al guardar los documentos: ' . $e->getMessage() . ' en ' . $e->getFile() . ' L:' . $e->getLine()]);
        }
    }


    public function actionDetalleSelectComision($idopcion, Request $request)
    {
        $jsondocumenos = json_decode($request['jsondocumenos'], true);
        $lote = $this->funciones->generar_lote('FE_REF_ASOC', 8);
        $sw_sel = 0;
        $sw_no_sel = 0;
        //si solo hay uno de los seleccionados
        foreach ($jsondocumenos as $key => $item) {
            $ID_DOCUMENTO = $item['data_requerimiento_id'];
            $feref = FeRefAsoc::where('ID_DOCUMENTO', '=', $ID_DOCUMENTO)
                ->where('COD_ESTADO', '=', '1')->WhereNull('FE_REF_ASOC.TXT_ESTADO')->orwhere('FE_REF_ASOC.TXT_ESTADO', '=', '')->first();
            if (count($feref) > 0) {
                $sw_sel = $sw_sel + 1;
            } else {
                $sw_no_sel = $sw_no_sel + 1;
            }
        }
        if ($sw_sel >= 1 && $sw_no_sel >= 1) {
            return Redirect::to('gestion-de-integracion-comisiones/' . $idopcion)->with('errorbd', 'Has seleccionado Documentos que ya tienen lotes activos');
        }

        foreach ($jsondocumenos as $key => $item) {
            $ID_DOCUMENTO = $item['data_requerimiento_id'];
            $atender = $item['atender'];
            $feref = FeRefAsoc::where('ID_DOCUMENTO', '=', $ID_DOCUMENTO)->where('COD_ESTADO', '=', '1')->WhereNull('FE_REF_ASOC.TXT_ESTADO')->orwhere('FE_REF_ASOC.TXT_ESTADO', '=', '')->first();
            if (count($feref) <= 0) {
                $docasociar = new FeRefAsoc;
                $docasociar->LOTE = $lote;
                $docasociar->ID_DOCUMENTO = $ID_DOCUMENTO;
                $docasociar->FECHA_CREA = $this->fechaactual;
                $docasociar->COD_ESTADO = 1;
                $docasociar->ESTATUS = 'OFF';
                $docasociar->OPERACION = 'COMISION';
                $docasociar->ATENDIDO = $atender;
                $docasociar->USUARIO_CREA = Session::get('usuario')->id;
                $docasociar->save();
                TESOperacionCaja::where('COD_OPERACION_CAJA', $ID_DOCUMENTO)
                    ->update([
                        'ATENDIDO' => DB::raw("ISNULL(ATENDIDO, 0) + $atender")
                    ]);
            } else {
                $lote = $feref->LOTE;
            }
        }

        return Redirect::to('detalle-comprobante-comision-administrator/' . $idopcion . '/' . $lote);
    }


    public function actionCargarModalDetalleLotesComision(Request $request)
    {

        $operacion_id = $request['operacion_sel'];
        $feasoc = FeRefAsoc::where('USUARIO_CREA', '=', Session::get('usuario')->id)
            ->where('COD_ESTADO', '=', '1')
            ->where('ESTATUS', '=', 'OFF')
            ->where('OPERACION', '=', $operacion_id)
            ->select('LOTE', 'FECHA_CREA')
            ->groupBy('LOTE')
            ->groupBy('FECHA_CREA')
            ->get();

        $funcion = $this;

        //dd($feasoc);

        return View::make('comision/modal/ajax/mlistalotescomision',
            [
                'feasoc' => $feasoc,
                'operacion_id' => $operacion_id,
                'funcion' => $funcion
            ]);
    }


    public function actionCargarModalDetalleComision(Request $request)
    {

        $jsondocumenos = json_decode($request['datastring'], true);
        $result = array_map(function ($item) {
            return $item['data_requerimiento_id'];
        }, $jsondocumenos);

        $feasoc = CMPDetalleProducto::whereIn('COD_TABLA', $result)->get();
        $funcion = $this;
        return View::make('comision/modal/ajax/mlistalotescomisiondetalle',
            [
                'feasoc' => $feasoc,
                'funcion' => $funcion
            ]);
    }


    public function actionListarComisionAdmin($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Integracion de Comisiones');

        $banco_id = '';
        $combo_banco = $this->gn_combo_banco_comision();
        $listadatos = array();
        $fecha_inicio = $this->fecha_menos_diez_dias;
        $fecha_fin = $this->fecha_sin_hora;

        $funcion = $this;
        return View::make('comision/listacomisionadministrador',
            [
                'banco_id' => $banco_id,
                'combo_banco' => $combo_banco,
                'listadatos' => $listadatos,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
            ]);
    }


    public function actionAjaxListarComisionAdmin(Request $request)
    {

        $banco_id = $request['banco_id'];
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        $idopcion = $request['idopcion'];
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        $listadatos = $this->gn_lista_comision($fecha_inicio, $fecha_fin, $banco_id);
        $funcion = $this;
        return View::make('comision/ajax/alistacomisionadministrador',
            [
                'idopcion' => $idopcion,
                'cod_empresa' => $cod_empresa,
                'listadatos' => $listadatos,
                'ajax' => true,
                'funcion' => $funcion
            ]);
    }


    public function actionComprobanteMasivoTesoreriaComisionExcel($fecha_inicio,$fecha_fin,$banco_id,$idopcion)
    {
        set_time_limit(0);

        $cod_empresa            =   Session::get('usuario')->usuarioosiris_id;
        $fechadia               =   date_format(date_create(date('d-m-Y')), 'd-m-Y');
        $fecha_actual           =   date("Y-m-d");
        $titulo                 =   'Comprobantes-Comision-Faltantes-Integrar';
        $funcion                =   $this;

        if($banco_id == 'TODO'){
            $listadatos             =   $this->gn_lista_comision_todo($fecha_inicio, $fecha_fin, $banco_id);
        }else{
            $listadatos             =   $this->gn_lista_comision($fecha_inicio, $fecha_fin, $banco_id);
        }




        Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
            $excel->sheet('COMPROBANTE', function($sheet) use ($listadatos,$titulo,$funcion) {
                $sheet->loadView('reporte/excel/listacomprobantemasivotesoreriacomision')->with('listadatos',$listadatos)
                                                                   ->with('titulo',$titulo)
                                                                   ->with('funcion',$funcion);
            });
        })->export('xls');


    }


    public function actionEliminarItemPP(Request $request)
    {

        $tipo = $request['data_tipoarchivo'];
        $nombrearchivo = $request['data_nombrearchivo'];
        $linea = $request['data_linea'];
        $idoc = $request['data_iddocumento'];

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $archivo = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('NOMBRE_ARCHIVO', '=', $nombrearchivo)
            ->where('TIPO_ARCHIVO', '=', $tipo)
            ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
            ->first();

        Archivo::where('ID_DOCUMENTO', '=', $idoc)
            ->where('ACTIVO', '=', '1')
            ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
            ->where('NOMBRE_ARCHIVO', '=', $nombrearchivo)
            ->where('TIPO_ARCHIVO', '=', $tipo)
            ->update(
                [
                    'ACTIVO' => 0,
                    'FECHA_MOD' => $this->fechaactual,
                    'USUARIO_MOD' => Session::get('usuario')->id
                ]
            );

        $documento = new FeDocumentoHistorial;
        $documento->ID_DOCUMENTO = $idoc;
        $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
        $documento->FECHA = $this->fechaactual;
        $documento->USUARIO_ID = Session::get('usuario')->id;
        $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
        $documento->TIPO = 'ELIMINO ITEM ' . $archivo->DESCRIPCION_ARCHIVO;
        $documento->MENSAJE = '';
        $documento->save();

        //geolocalizacion
        $device_info       =   $request['device_info'];
        $this->con_datos_de_la_pc($device_info,$fedocumento,'ELIMINO ITEM ' . $archivo->DESCRIPCION_ARCHIVO);
        //geolocalización


        print_r("bien");

    }


    public function actionListarAjaxModalTesoreriaPagoEstiba(Request $request)
    {

        $cod_orden = $request['data_requerimiento_id'];
        $linea = $request['data_linea'];
        $idopcion = $request['idopcion'];
        $operacion_id = $request['operacion_id'];


        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $cod_orden)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        //ARCHIVOS
        $archivosdelfe = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
            ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
            ->get();

        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', '=', $cod_orden)
            ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')->delete();

        foreach ($archivosdelfe as $index => $item) {
            $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA)->first();
            $docasociar = new CMPDocAsociarCompra;
            $docasociar->COD_ORDEN = $fedocumento->ID_DOCUMENTO;
            $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
            $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
            $docasociar->IND_OBLIGATORIO = $categoria->IND_DOCUMENTO_VAL;
            $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
            $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
            $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
            $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
            $docasociar->COD_ESTADO = 1;
            $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
            $docasociar->save();
        }

        $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $fedocumento->ID_DOCUMENTO)->where('COD_ESTADO', '=', 1)
            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
            ->get();


        return View::make('comprobante/modal/ajax/magregarpagotesoreriaestiba',
            [
                'cod_orden' => $cod_orden,
                'linea' => $linea,
                'idopcion' => $idopcion,
                'fedocumento' => $fedocumento,
                'tarchivos' => $tarchivos,
                'operacion_id' => $operacion_id,
                'ajax' => true,
            ]);
    }


    public function actionListarComprobanteTesoreria($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista comprobantes por integrar pago tesoreria');
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto

        $fecha_inicio = $this->fecha_menos_diez_dias;
        $fecha_fin = $this->fecha_sin_hora;

        $operacion_id = 'ORDEN_COMPRA';
        $estadopago_id = 'PAGADO';
        if (Session::has('operacion_id')) {
            $operacion_id = Session::get('operacion_id');
        }
        $combo_operacion = array('ORDEN_COMPRA' => 'ORDEN COMPRA',
            'CONTRATO' => 'CONTRATO',
            'ESTIBA' => 'ESTIBA',
            'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
            'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
            'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA',
            'DOCUMENTO_INTERNO_COMPRA' => 'DOCUMENTO INTERNO COMPRA',
            'LIQUIDACION_COMPRA_ANTICIPO' => 'LIQUIDACION DE COMPRA ANTICIPO',
            'PROVISION_GASTO' => 'PROVISION DE GASTO',
            'NOTA_CREDITO' => 'NOTA DE CREDITO',
            'NOTA_DEBITO' => 'NOTA DE DEBITO',
            'ORDEN_COMPRA_ANTICIPO'         => 'ORDEN COMPRA ANTICIPO',
        );

        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO');
        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA');
        $combo_estado = array('PAGADO' => 'PAGADO', 'SIN_PAGAR' => 'SIN PAGAR');
        $proveedor_id = 'TODO';
        $combo_proveedor = $this->gn_combo_proveedor_fe_documento_xestado($proveedor_id, 'ETM0000000000005');

        if ($operacion_id == 'ORDEN_COMPRA') {
            if ($estadopago_id == 'PAGADO') {
                $listadatos = $this->con_lista_cabecera_comprobante_total_tes($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
            } else {
                $listadatos = $this->con_lista_cabecera_comprobante_total_tes_sp($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
            }
        } else {
            if ($operacion_id == 'CONTRATO') {
                if ($estadopago_id == 'PAGADO') {
                    $listadatos = $this->con_lista_cabecera_comprobante_total_tes_contrato($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
                } else {
                    $listadatos = $this->con_lista_cabecera_comprobante_total_tes_contrato_sp($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
                }
            } else {
                if ($estadopago_id == 'PAGADO') {
                    $listadatos = $this->con_lista_cabecera_comprobante_total_tes_estiba($cod_empresa, $proveedor_id, $operacion_id, $fecha_inicio, $fecha_fin);
                } else {
                    $listadatos = array();
                }
            }
        }
        $funcion = $this;

        return View::make('comprobante/listatesoreria',
            [
                'listadatos' => $listadatos,
                'funcion' => $funcion,
                'proveedor_id' => $proveedor_id,
                'combo_proveedor' => $combo_proveedor,
                'operacion_id' => $operacion_id,
                'combo_operacion' => $combo_operacion,
                'estadopago_id' => $estadopago_id,
                'combo_estado' => $combo_estado,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,

                'idopcion' => $idopcion,
            ]);

    }

    public function actionListarAjaxBuscarDocumentoTesoreria(Request $request)
    {

        $operacion_id = $request['operacion_id'];
        $estadopago_id = $request['estadopago_id'];
        $proveedor_id = $request['proveedor_id'];
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];


        $idopcion = $request['idopcion'];
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        $proveedor_id = $request['proveedor_id'];

        if ($operacion_id == 'ORDEN_COMPRA') {
            if ($estadopago_id == 'PAGADO') {
                $listadatos = $this->con_lista_cabecera_comprobante_total_tes($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
            } else {
                $listadatos = $this->con_lista_cabecera_comprobante_total_tes_sp($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
            }
        } else {
            if ($operacion_id == 'CONTRATO') {
                if ($estadopago_id == 'PAGADO') {
                    $listadatos = $this->con_lista_cabecera_comprobante_total_tes_contrato($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
                } else {
                    $listadatos = $this->con_lista_cabecera_comprobante_total_tes_contrato_sp($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
                }
            } else {
                if ($estadopago_id == 'PAGADO') {
                    $listadatos = $this->con_lista_cabecera_comprobante_total_tes_estiba($cod_empresa, $proveedor_id, $operacion_id, $fecha_inicio, $fecha_fin);
                } else {
                    $listadatos = array();
                }
            }
        }


        $procedencia = 'ADM';
        $funcion = $this;
        return View::make('comprobante/ajax/mergelistatesoreria',
            [
                'operacion_id' => $operacion_id,

                'idopcion' => $idopcion,
                'cod_empresa' => $cod_empresa,
                'listadatos' => $listadatos,
                'procedencia' => $procedencia,
                'ajax' => true,
                'estadopago_id' => $estadopago_id,
                'funcion' => $funcion
            ]);
    }


    public function actionListarComprobanteTesoreriaPago($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista comprobantes con pagos asociados');
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto
        $operacion_id = 'ORDEN_COMPRA';
        if (Session::has('operacion_id')) {
            $operacion_id = Session::get('operacion_id');
        }


        if (Session::has('operacion_id')) {
            $operacion_id = Session::get('operacion_id');
        }
        $fecha_inicio = $this->fecha_menos_diez_dias;
        $fecha_fin = $this->fecha_sin_hora;
        $combo_operacion = array('ORDEN_COMPRA' => 'ORDEN COMPRA', 'CONTRATO' => 'CONTRATO', 'COMISION' => 'COMISION');
        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA');

        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA');
        $proveedor_id = 'TODO';
        $combo_proveedor = $this->gn_combo_proveedor_fe_documento_xestado($proveedor_id, 'ETM0000000000008');
        if ($operacion_id == 'ORDEN_COMPRA') {
            $listadatos = $this->con_lista_cabecera_comprobante_total_tes_pagado($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
        } else {
            $listadatos = $this->con_lista_cabecera_comprobante_total_tes_contrato_pagado($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
        }
        $funcion = $this;

        return View::make('comprobante/listatesoreriapagado',
            [
                'listadatos' => $listadatos,
                'funcion' => $funcion,

                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,

                'proveedor_id' => $proveedor_id,
                'combo_proveedor' => $combo_proveedor,
                'operacion_id' => $operacion_id,
                'combo_operacion' => $combo_operacion,
                'idopcion' => $idopcion,
            ]);

    }


    public function actionListarAjaxBuscarDocumentoTesoreriaPago(Request $request)
    {

        $operacion_id = $request['operacion_id'];
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        $proveedor_id = $request['proveedor_id'];
        $idopcion = $request['idopcion'];
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        $proveedor_id = $request['proveedor_id'];

        if ($operacion_id == 'ORDEN_COMPRA') {
            $listadatos = $this->con_lista_cabecera_comprobante_total_tes_pagado($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
        } else {
            if ($operacion_id == 'CONTRATO') {
                $listadatos = $this->con_lista_cabecera_comprobante_total_tes_contrato_pagado($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
            } else {
                $listadatos = $this->con_lista_cabecera_comprobante_total_tes_comision_pagado($cod_empresa, $proveedor_id, $fecha_inicio, $fecha_fin);
            }
        }

        $procedencia = 'ADM';
        $funcion = $this;
        return View::make('comprobante/ajax/mergelistatesoreriapagado',
            [
                'operacion_id' => $operacion_id,

                'idopcion' => $idopcion,
                'cod_empresa' => $cod_empresa,
                'listadatos' => $listadatos,
                'procedencia' => $procedencia,
                'ajax' => true,
                'funcion' => $funcion
            ]);
    }

    public function actionListarAjaxModalTesoreriaPagoPagadoContrato(Request $request)
    {

        $cod_orden = $request['data_requerimiento_id'];
        $linea = $request['data_linea'];
        $idopcion = $request['idopcion'];

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $cod_orden)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        //$ordencompra            =   CMPOrden::where('COD_ORDEN','=',$cod_orden)->first();
        //ARCHIVOS
        $archivosdelfe = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
            ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
            ->get();
        $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $cod_orden)->where('COD_ESTADO', '=', 1)
            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
            ->get();
        if (count($tarchivos) <= 0) {
            foreach ($archivosdelfe as $index => $item) {
                $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA)->first();
                $docasociar = new CMPDocAsociarCompra;
                $docasociar->COD_ORDEN = $cod_orden;
                $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                $docasociar->IND_OBLIGATORIO = $categoria->IND_DOCUMENTO_VAL;
                $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                $docasociar->COD_ESTADO = 1;
                $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
                $docasociar->save();
            }
        }

        $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $cod_orden)->where('COD_ESTADO', '=', 1)
            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
            ->get();

        $archivo = Archivo::where('ID_DOCUMENTO', '=', $cod_orden)->where('TIPO_ARCHIVO', '=', 'DCC0000000000028')->first();


        return View::make('comprobante/modal/ajax/magregarpagotesoreriapagadocontrato',
            [
                'cod_orden' => $cod_orden,
                'linea' => $linea,
                'idopcion' => $idopcion,
                'fedocumento' => $fedocumento,
                'tarchivos' => $tarchivos,
                'archivo' => $archivo,
                'ajax' => true,
            ]);
    }


    public function actionListarAjaxModalTesoreriaPagoPagadoComision(Request $request)
    {

        $cod_orden = $request['data_requerimiento_id'];
        $linea = $request['data_linea'];
        $idopcion = $request['idopcion'];

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $cod_orden)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        //$ordencompra            =   CMPOrden::where('COD_ORDEN','=',$cod_orden)->first();
        //ARCHIVOS
        $archivosdelfe = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
            ->whereIn('COD_CATEGORIA', ['DCC0000000000002'])
            ->get();
        $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $cod_orden)->where('COD_ESTADO', '=', 1)
            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000002'])
            ->get();
        if (count($tarchivos) <= 0) {
            foreach ($archivosdelfe as $index => $item) {
                $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA)->first();
                $docasociar = new CMPDocAsociarCompra;
                $docasociar->COD_ORDEN = $cod_orden;
                $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                $docasociar->IND_OBLIGATORIO = $categoria->IND_DOCUMENTO_VAL;
                $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                $docasociar->COD_ESTADO = 1;
                $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
                $docasociar->save();
            }
        }

        $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $cod_orden)->where('COD_ESTADO', '=', 1)
            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000002'])
            ->get();

        $archivo = Archivo::where('ID_DOCUMENTO', '=', $cod_orden)->where('TIPO_ARCHIVO', '=', 'DCC0000000000002')->first();


        return View::make('comprobante/modal/ajax/magregarpagotesoreriapagadocomision',
            [
                'cod_orden' => $cod_orden,
                'linea' => $linea,
                'idopcion' => $idopcion,
                'fedocumento' => $fedocumento,
                'tarchivos' => $tarchivos,
                'archivo' => $archivo,
                'ajax' => true,
            ]);
    }


    public function actionListarAjaxModalTesoreriaPagoPagado(Request $request)
    {

        $cod_orden = $request['data_requerimiento_id'];
        $linea = $request['data_linea'];
        $idopcion = $request['idopcion'];

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $cod_orden)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        //$ordencompra            =   CMPOrden::where('COD_ORDEN','=',$cod_orden)->first();
        //ARCHIVOS
        $archivosdelfe = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
            ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
            ->get();
        $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $cod_orden)->where('COD_ESTADO', '=', 1)
            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
            ->get();
        if (count($tarchivos) <= 0) {
            foreach ($archivosdelfe as $index => $item) {
                $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA)->first();
                $docasociar = new CMPDocAsociarCompra;
                $docasociar->COD_ORDEN = $cod_orden;
                $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                $docasociar->IND_OBLIGATORIO = $categoria->IND_DOCUMENTO_VAL;
                $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                $docasociar->COD_ESTADO = 1;
                $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
                $docasociar->save();
            }
        }

        $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $cod_orden)->where('COD_ESTADO', '=', 1)
            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
            ->get();

        $archivo = Archivo::where('ID_DOCUMENTO', '=', $cod_orden)->where('TIPO_ARCHIVO', '=', 'DCC0000000000028')->first();


        return View::make('comprobante/modal/ajax/magregarpagotesoreriapagado',
            [
                'cod_orden' => $cod_orden,
                'linea' => $linea,
                'idopcion' => $idopcion,
                'fedocumento' => $fedocumento,
                'tarchivos' => $tarchivos,
                'archivo' => $archivo,
                'ajax' => true,
            ]);
    }


    public function actionListarAjaxModalTesoreriaPagoContrato(Request $request)
    {

        $cod_orden = $request['data_requerimiento_id'];
        $linea = $request['data_linea'];
        $idopcion = $request['idopcion'];

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $cod_orden)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $ordencompra = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $cod_orden)->first();

        //ARCHIVOS
        $archivosdelfe = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
            ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
            ->get();

        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', '=', $cod_orden)
            ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')->delete();

        foreach ($archivosdelfe as $index => $item) {
            $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA)->first();
            $docasociar = new CMPDocAsociarCompra;
            $docasociar->COD_ORDEN = $ordencompra->COD_DOCUMENTO_CTBLE;
            $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
            $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
            $docasociar->IND_OBLIGATORIO = $categoria->IND_DOCUMENTO_VAL;
            $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
            $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
            $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
            $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
            $docasociar->COD_ESTADO = 1;
            $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
            $docasociar->save();
        }

        $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
            ->get();


        return View::make('comprobante/modal/ajax/magregarpagotesoreriacontrato',
            [
                'cod_orden' => $cod_orden,
                'linea' => $linea,
                'idopcion' => $idopcion,
                'fedocumento' => $fedocumento,
                'ordencompra' => $ordencompra,
                'tarchivos' => $tarchivos,
                'ajax' => true,
            ]);
    }


    public function actionListarAjaxModalTesoreriaPago(Request $request)
    {

        $cod_orden = $request['data_requerimiento_id'];
        $linea = $request['data_linea'];
        $idopcion = $request['idopcion'];

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $cod_orden)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $ordencompra = CMPOrden::where('COD_ORDEN', '=', $cod_orden)->first();

        //ARCHIVOS

        $archivosdelfe = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
            ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
            ->get();

        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', '=', $cod_orden)
            ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')->delete();

        foreach ($archivosdelfe as $index => $item) {
            $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA)->first();
            $docasociar = new CMPDocAsociarCompra;
            $docasociar->COD_ORDEN = $ordencompra->COD_ORDEN;
            $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
            $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
            $docasociar->IND_OBLIGATORIO = $categoria->IND_DOCUMENTO_VAL;
            $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
            $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
            $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
            $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
            $docasociar->COD_ESTADO = 1;
            $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
            $docasociar->save();
        }

        $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
            ->get();

        $archivospp = DB::table('ARCHIVOS')
            ->where('ID_DOCUMENTO', $cod_orden)
            ->where('ACTIVO', 1)
            ->where('TIPO_ARCHIVO', 'DCC0000000000037')
            ->get();


        return View::make('comprobante/modal/ajax/magregarpagotesoreria',
            [
                'cod_orden' => $cod_orden,
                'archivospp' => $archivospp,
                'linea' => $linea,
                'idopcion' => $idopcion,
                'fedocumento' => $fedocumento,
                'ordencompra' => $ordencompra,
                'tarchivos' => $tarchivos,
                'ajax' => true,
            ]);
    }

    public function actionListarAjaxModalTesoreriaPagoMasivo(Request $request)
    {


        $idopcion = $request['idopcion'];
        $datastring_n = $request['datastring'];
        $operacion_id = $request['operacion_id'];

        $datastring = json_decode($request['datastring'], false);

        $archivosdelfe = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
            ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
            ->get();

        foreach ($datastring as $index_asiento => $item1) {

            DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', '=', $item1->id)
                ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')->delete();

            foreach ($archivosdelfe as $index => $item) {
                $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA)->first();
                $docasociar = new CMPDocAsociarCompra;
                $docasociar->COD_ORDEN = $item1->id;
                $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                $docasociar->IND_OBLIGATORIO = $categoria->IND_DOCUMENTO_VAL;
                $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                $docasociar->COD_ESTADO = 1;
                $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
                $docasociar->save();
            }

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $item1->id)->where('COD_ESTADO', '=', 1)
                ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
                ->get();

        }


        return View::make('comprobante/modal/ajax/magregarpagotesoreriamasivo',
            [
                'datastring_n' => $datastring_n,
                'datastring' => $datastring,
                'idopcion' => $idopcion,
                'tarchivos' => $tarchivos,
                'operacion_id' => $operacion_id,

                'ajax' => true,
            ]);
    }


    public function actionAprobarTesoreriaMasivo($idopcion, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Aprobar  Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $datastring = json_decode($request['datastring'], false);
                $operacion = $request['operacion'];


                foreach ($datastring as $index_asiento => $itemc) {
                    $pedido_id = $itemc->id;
                    $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('COD_ESTADO', '=', 'ETM0000000000005')->first();


                    //ORDEN COMPRA
                    if ($fedocumento->OPERACION == 'ORDEN_COMPRA') {

                        $orden = CMPOrden::where('COD_ORDEN', '=', $pedido_id)->first();
                        $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $pedido_id)->where('COD_ESTADO', '=', 1)
                            ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')
                            ->get();
                        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($pedido_id);
                        foreach ($tarchivos as $index => $item) {

                            $filescdm = $request[$item->COD_CATEGORIA_DOCUMENTO];
                            if (!is_null($filescdm)) {

                                foreach ($filescdm as $file) {

                                    $contadorArchivos = Archivo::count();
                                    $nombre = $pedido_id . '-' . $file->getClientOriginalName();
                                    /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                    $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                                    $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordencompra->NRO_DOCUMENTO_CLIENTE;
                                    // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                                    $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                                    $valor = $this->versicarpetanoexiste($rutafile);
                                    $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                                    copy($file->getRealPath(), $rutacompleta);
                                    $path = $rutacompleta;

                                    $nombreoriginal = $file->getClientOriginalName();
                                    $info = new SplFileInfo($nombreoriginal);
                                    $extension = $info->getExtension();

                                    $dcontrol = new Archivo;
                                    $dcontrol->ID_DOCUMENTO = $ordencompra->COD_ORDEN;
                                    $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                                    $dcontrol->TIPO_ARCHIVO = $item->COD_CATEGORIA_DOCUMENTO;
                                    $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                                    $dcontrol->DESCRIPCION_ARCHIVO = $item->NOM_CATEGORIA_DOCUMENTO;


                                    $dcontrol->URL_ARCHIVO = $path;
                                    $dcontrol->SIZE = filesize($file);
                                    $dcontrol->EXTENSION = $extension;
                                    $dcontrol->ACTIVO = 1;
                                    $dcontrol->FECHA_CREA = $this->fechaactual;
                                    $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                                    $dcontrol->save();
                                }
                            }
                        }

                    } else {

                        //CONTRATO

                        if ($fedocumento->OPERACION == 'CONTRATO') {
                            $orden = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)->first();
                            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $pedido_id)->where('COD_ESTADO', '=', 1)
                                ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')
                                ->get();
                            $ordencompra = $this->con_lista_cabecera_comprobante_contrato_idoc_actual($pedido_id);
                            foreach ($tarchivos as $index => $item) {

                                $filescdm = $request[$item->COD_CATEGORIA_DOCUMENTO];
                                if (!is_null($filescdm)) {

                                    foreach ($filescdm as $file) {

                                        $contadorArchivos = Archivo::count();
                                        $nombre = $pedido_id . '-' . $file->getClientOriginalName();
                                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                        $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordencompra->NRO_DOCUMENTO_CLIENTE;
                                        // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                                        $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                                        $valor = $this->versicarpetanoexiste($rutafile);
                                        $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                                        copy($file->getRealPath(), $rutacompleta);
                                        $path = $rutacompleta;

                                        $nombreoriginal = $file->getClientOriginalName();
                                        $info = new SplFileInfo($nombreoriginal);
                                        $extension = $info->getExtension();

                                        $dcontrol = new Archivo;
                                        $dcontrol->ID_DOCUMENTO = $ordencompra->COD_DOCUMENTO_CTBLE;
                                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                                        $dcontrol->TIPO_ARCHIVO = $item->COD_CATEGORIA_DOCUMENTO;
                                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                                        $dcontrol->DESCRIPCION_ARCHIVO = $item->NOM_CATEGORIA_DOCUMENTO;


                                        $dcontrol->URL_ARCHIVO = $path;
                                        $dcontrol->SIZE = filesize($file);
                                        $dcontrol->EXTENSION = $extension;
                                        $dcontrol->ACTIVO = 1;
                                        $dcontrol->FECHA_CREA = $this->fechaactual;
                                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                                        $dcontrol->save();
                                    }
                                }
                            }


                        } else {


                            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $pedido_id)->where('COD_ESTADO', '=', 1)
                                ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')
                                ->get();
                            foreach ($tarchivos as $index => $item) {

                                $filescdm = $request[$item->COD_CATEGORIA_DOCUMENTO];
                                if (!is_null($filescdm)) {

                                    foreach ($filescdm as $file) {

                                        $contadorArchivos = Archivo::count();
                                        $nombre = $pedido_id . '-' . $file->getClientOriginalName();
                                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                        $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                                        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $pedido_id;
                                        $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                                        $valor = $this->versicarpetanoexiste($rutafile);
                                        $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                                        copy($file->getRealPath(), $rutacompleta);
                                        $path = $rutacompleta;

                                        $nombreoriginal = $file->getClientOriginalName();
                                        $info = new SplFileInfo($nombreoriginal);
                                        $extension = $info->getExtension();

                                        $dcontrol = new Archivo;
                                        $dcontrol->ID_DOCUMENTO = $pedido_id;
                                        $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                                        $dcontrol->TIPO_ARCHIVO = $item->COD_CATEGORIA_DOCUMENTO;
                                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                                        $dcontrol->DESCRIPCION_ARCHIVO = $item->NOM_CATEGORIA_DOCUMENTO;


                                        $dcontrol->URL_ARCHIVO = $path;
                                        $dcontrol->SIZE = filesize($file);
                                        $dcontrol->EXTENSION = $extension;
                                        $dcontrol->ACTIVO = 1;
                                        $dcontrol->FECHA_CREA = $this->fechaactual;
                                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                                        $dcontrol->save();
                                    }
                                }
                            }
                        }

                    }
                    FeDocumento::where('ID_DOCUMENTO', $pedido_id)->where('COD_ESTADO', '=', 'ETM0000000000005')
                        ->update(
                            [
                                'COD_ESTADO' => 'ETM0000000000008',
                                'TXT_ESTADO' => 'TERMINADA',
                                'fecha_tes' => $this->fechaactual,
                                'usuario_tes' => Session::get('usuario')->id
                            ]
                        );

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'SUBIO COMPROBANTE DE PAGO';
                    $documento->MENSAJE = '';
                    $documento->save();


                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO COMPROBANTE DE PAGO');
                    //geolocalización


                }

                DB::commit();
                Session::flash('operacion_id', $operacion);
                return Redirect::to('/gestion-de-tesoreria-aprobar/' . $idopcion)->with('bienhecho', 'Comprobantes Masivo Aprobado con exito');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-tesoreria-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

        }

    }


    public function actionExtornoTesoreriaPagadoContrato($idordencompra, $idopcion, Request $request)
    {

        $idoc = $idordencompra;
        $ordencompra = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $idoc)->first();

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->get();
        try {

            DB::beginTransaction();

            $pedido_id = $idoc;
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')
                ->get();

            FeDocumento::where('ID_DOCUMENTO', $pedido_id)
                ->update(
                    [
                        'COD_ESTADO' => 'ETM0000000000005',
                        'TXT_ESTADO' => 'APROBADO'
                    ]
                );

            Archivo::where('ID_DOCUMENTO', $pedido_id)->where('TIPO_ARCHIVO', '=', 'DCC0000000000028')
                ->update(
                    [
                        'ACTIVO' => '0'
                    ]
                );

            $documento = new FeDocumentoHistorial;
            $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
            $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
            $documento->FECHA = $this->fechaactual;
            $documento->USUARIO_ID = Session::get('usuario')->id;
            $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
            $documento->TIPO = 'EXTORNO COMPROBANTE DE PAGO';
            $documento->MENSAJE = '';
            $documento->save();


            //geolocalizacion
            $device_info       =   $request['device_info'];
            $this->con_datos_de_la_pc($device_info,$fedocumento,'EXTORNO COMPROBANTE DE PAGO');
            //geolocalización



            Session::flash('operacion_id', 'CONTRATO');
            DB::commit();
            return Redirect::to('/gestion-de-comprobante-pago-tesoreria/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' Extornado con exito');
        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect::to('gestion-de-comprobante-pago-tesoreria/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
        }


    }


    public function actionExtornoTesoreriaPagado($idordencompra, $idopcion, Request $request)
    {

        $idoc = $idordencompra;
        $ordencompra = $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->get();
        try {

            DB::beginTransaction();

            $pedido_id = $idoc;
            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')
                ->get();

            FeDocumento::where('ID_DOCUMENTO', $pedido_id)
                ->update(
                    [
                        'COD_ESTADO' => 'ETM0000000000005',
                        'TXT_ESTADO' => 'APROBADO'
                    ]
                );

            Archivo::where('ID_DOCUMENTO', $pedido_id)->where('TIPO_ARCHIVO', '=', 'DCC0000000000028')
                ->update(
                    [
                        'ACTIVO' => '0'
                    ]
                );

            $documento = new FeDocumentoHistorial;
            $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
            $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
            $documento->FECHA = $this->fechaactual;
            $documento->USUARIO_ID = Session::get('usuario')->id;
            $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
            $documento->TIPO = 'EXTORNO COMPROBANTE DE PAGO';
            $documento->MENSAJE = '';
            $documento->save();

            //geolocalizacion
            $device_info       =   $request['device_info'];
            $this->con_datos_de_la_pc($device_info,$fedocumento,'EXTORNO COMPROBANTE DE PAGO');
            //geolocalización

            DB::commit();
            return Redirect::to('/gestion-de-comprobante-pago-tesoreria/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' Extornado con exito');
        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect::to('gestion-de-comprobante-pago-tesoreria/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
        }


    }


    public function actionAprobarTesoreriaPagadoComision($idopcion, $linea, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $idordencompra;
        //$ordencompra            =   TESOperacionCaja::where('COD_OPERACION_CAJA','=',$idoc)->first();
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Modificar Comprobante Pago');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;


                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $fedocumento->ID_DOCUMENTO)->where('COD_ESTADO', '=', 1)
                    ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000002')
                    ->get();


                foreach ($tarchivos as $index => $item) {

                    $filescdm = $request[$item->COD_CATEGORIA_DOCUMENTO];

                    //dd($filescdm);

                    if (!is_null($filescdm)) {

                        foreach ($filescdm as $file) {

                            $contadorArchivos = Archivo::count();

                            $nombre = $fedocumento->ID_DOCUMENTO . '-' . $file->getClientOriginalName();

                            $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $fedocumento->ID_DOCUMENTO;
                            $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                            $valor = $this->versicarpetanoexiste($rutafile);
                            $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                            copy($file->getRealPath(), $rutacompleta);
                            $path = $rutacompleta;

                            $nombreoriginal = $file->getClientOriginalName();
                            $info = new SplFileInfo($nombreoriginal);
                            $extension = $info->getExtension();


                            Archivo::where('ID_DOCUMENTO', $fedocumento->ID_DOCUMENTO)
                                ->where('TIPO_ARCHIVO', 'DCC0000000000002')
                                ->update([
                                    'NOMBRE_ARCHIVO' => $nombrefilecdr,
                                    'URL_ARCHIVO' => $path,
                                    'SIZE' => filesize($file),
                                    'EXTENSION' => $extension,
                                    'ACTIVO' => 1,
                                    'FECHA_MOD' => $this->fechaactual,
                                    'USUARIO_MOD' => Session::get('usuario')->id
                                ]);

                        }
                    }
                }

                DB::commit();
                return Redirect::to('/gestion-de-comprobante-pago-tesoreria/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $fedocumento->ID_DOCUMENTO . ' Modificado CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-comprobante-pago-tesoreria/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

        }


    }


    public function actionAprobarTesoreriaPagadoContrato($idopcion, $linea, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $idordencompra;
        $ordencompra = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $idoc)->first();

        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Modificar Comprobante Pago');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;


                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                    ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')
                    ->get();


                foreach ($tarchivos as $index => $item) {

                    $filescdm = $request[$item->COD_CATEGORIA_DOCUMENTO];

                    //dd($filescdm);

                    if (!is_null($filescdm)) {

                        foreach ($filescdm as $file) {

                            $contadorArchivos = Archivo::count();

                            $empresa = DB::table('STD.EMPRESA')
                                ->where('COD_EMPR', $ordencompra->COD_EMPR_EMISOR)
                                ->first();

                            $nombre = $ordencompra->COD_DOCUMENTO_CTBLE . '-' . $file->getClientOriginalName();

                            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $empresa->NRO_DOCUMENTO;
                            $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                            $valor = $this->versicarpetanoexiste($rutafile);
                            $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                            copy($file->getRealPath(), $rutacompleta);
                            $path = $rutacompleta;

                            $nombreoriginal = $file->getClientOriginalName();
                            $info = new SplFileInfo($nombreoriginal);
                            $extension = $info->getExtension();


                            Archivo::where('ID_DOCUMENTO', $fedocumento->ID_DOCUMENTO)
                                ->where('TIPO_ARCHIVO', 'DCC0000000000028')
                                ->update([
                                    'NOMBRE_ARCHIVO' => $nombrefilecdr,
                                    'URL_ARCHIVO' => $path,
                                    'SIZE' => filesize($file),
                                    'EXTENSION' => $extension,
                                    'ACTIVO' => 1,
                                    'FECHA_MOD' => $this->fechaactual,
                                    'USUARIO_MOD' => Session::get('usuario')->id
                                ]);

                        }
                    }
                }

                DB::commit();
                return Redirect::to('/gestion-de-comprobante-pago-tesoreria/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' Modificado CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-comprobante-pago-tesoreria/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

        }


    }


    public function actionAprobarTesoreriaPagado($idopcion, $linea, $prefijo, $idordencompra, Request $request)
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
        View::share('titulo', 'Modificar Comprobante Pago');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                    ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')
                    ->get();

                foreach ($tarchivos as $index => $item) {

                    $filescdm = $request[$item->COD_CATEGORIA_DOCUMENTO];

                    //dd($filescdm);

                    if (!is_null($filescdm)) {

                        foreach ($filescdm as $file) {

                            $contadorArchivos = Archivo::count();
                            $nombre = $ordencompra->COD_ORDEN . '-' . $file->getClientOriginalName();

                            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordencompra->NRO_DOCUMENTO_CLIENTE;
                            $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                            $valor = $this->versicarpetanoexiste($rutafile);
                            $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                            copy($file->getRealPath(), $rutacompleta);
                            $path = $rutacompleta;

                            $nombreoriginal = $file->getClientOriginalName();
                            $info = new SplFileInfo($nombreoriginal);
                            $extension = $info->getExtension();

                            Archivo::where('ID_DOCUMENTO', $fedocumento->ID_DOCUMENTO)
                                ->where('TIPO_ARCHIVO', 'DCC0000000000028')
                                ->update([
                                    'NOMBRE_ARCHIVO' => $nombrefilecdr,
                                    'URL_ARCHIVO' => $path,
                                    'SIZE' => filesize($file),
                                    'EXTENSION' => $extension,
                                    'ACTIVO' => 1,
                                    'FECHA_MOD' => $this->fechaactual,
                                    'USUARIO_MOD' => Session::get('usuario')->id
                                ]);


                        }
                    }
                }

                DB::commit();
                return Redirect::to('/gestion-de-comprobante-pago-tesoreria/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' Modificado CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-comprobante-pago-tesoreria/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

        }


    }


    public function actionAprobarTesoreria($idopcion, $linea, $prefijo, $idordencompra, Request $request)
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
        View::share('titulo', 'Aprobar  Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();

                $pedido_id = $idoc;
                $partepago = $request['partepago'];


                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                    ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')
                    ->get();

                foreach ($tarchivos as $index => $item) {

                    $filescdm = $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if (!is_null($filescdm)) {

                        foreach ($filescdm as $file) {

                            $TIPO_ARCHIVO = $item->COD_CATEGORIA_DOCUMENTO;
                            $DESCRIPCION_ARCHIVO = $item->NOM_CATEGORIA_DOCUMENTO;
                            if ($partepago == 'on') {
                                $TIPO_ARCHIVO = 'DCC0000000000037';
                                $DESCRIPCION_ARCHIVO = 'PARTE COMPROBANTE DE PAGO';
                            }

                            //dd($TIPO_ARCHIVO);

                            $contadorArchivos = Archivo::count();
                            $nombre = $ordencompra->COD_ORDEN . '-' . $file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                            $valor = $this->versicarpetanoexiste($rutafile);
                            $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                            copy($file->getRealPath(), $rutacompleta);
                            $path = $rutacompleta;

                            $nombreoriginal = $file->getClientOriginalName();
                            $info = new SplFileInfo($nombreoriginal);
                            $extension = $info->getExtension();

                            $dcontrol = new Archivo;
                            $dcontrol->ID_DOCUMENTO = $ordencompra->COD_ORDEN;
                            $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                            $dcontrol->TIPO_ARCHIVO = $TIPO_ARCHIVO;
                            $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO = $DESCRIPCION_ARCHIVO;


                            $dcontrol->URL_ARCHIVO = $path;
                            $dcontrol->SIZE = filesize($file);
                            $dcontrol->EXTENSION = $extension;
                            $dcontrol->ACTIVO = 1;
                            $dcontrol->FECHA_CREA = $this->fechaactual;
                            $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                            $dcontrol->save();
                        }
                    }
                }

                $orden = CMPOrden::where('COD_ORDEN', '=', $pedido_id)->first();
                $detalleproducto = CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO', '=', 1)
                    ->where('CMP.DETALLE_PRODUCTO.COD_TABLA', '=', $pedido_id)
                    ->orderBy('NRO_LINEA', 'ASC')
                    ->get();


                if ($TIPO_ARCHIVO == 'DCC0000000000037') {

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'SUBIO PARTE COMPROBANTE DE PAGO';
                    $documento->MENSAJE = '';
                    $documento->save();

                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO PARTE COMPROBANTE DE PAGO');
                    //geolocalización




                } else {

                    FeDocumento::where('ID_DOCUMENTO', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)
                        ->update(
                            [
                                'COD_ESTADO' => 'ETM0000000000008',
                                'TXT_ESTADO' => 'TERMINADA',
                                'fecha_tes' => $this->fechaactual,
                                'usuario_tes' => Session::get('usuario')->id
                            ]
                        );

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'SUBIO COMPROBANTE DE PAGO';
                    $documento->MENSAJE = '';
                    $documento->save();


                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO COMPROBANTE DE PAGO');
                    //geolocalización



                }


                DB::commit();
                return Redirect::to('/gestion-de-tesoreria-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_ORDEN . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-tesoreria-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

        } else {

            $detalleordencompra = $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $tp = CMPCategoria::where('COD_CATEGORIA', '=', $ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            $documentohistorial = FeDocumentoHistorial::where('ID_DOCUMENTO', '=', $ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->orderBy('FECHA', 'DESC')
                ->get();

            $archivos = Archivo::where('ID_DOCUMENTO', '=', $idoc)->where('ACTIVO', '=', '1')->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();

            $archivospdf = Archivo::where('ID_DOCUMENTO', '=', $idoc)
                ->where('ACTIVO', '=', '1')
                ->where('EXTENSION', 'like', '%' . 'pdf' . '%')
                ->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)
                ->get();


            //orden de ingreso
            $referencia = CMPReferecenciaAsoc::where('COD_TABLA', '=', $ordencompra->COD_ORDEN)
                ->where('COD_TABLA_ASOC', 'like', '%OI%')->first();
            $ordeningreso = array();
            if (count($referencia) > 0) {
                $ordeningreso = CMPOrden::where('COD_ORDEN', '=', $referencia->COD_TABLA_ASOC)->first();
            }


            $archivosdelfe = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
                ->get();


            //ARCHIVOS
            DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)
                ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')->delete();

            foreach ($archivosdelfe as $index => $item) {
                $categoria = CMPCategoria::where('COD_CATEGORIA', '=', $item->COD_CATEGORIA)->first();
                $docasociar = new CMPDocAsociarCompra;
                $docasociar->COD_ORDEN = $ordencompra->COD_ORDEN;
                $docasociar->COD_CATEGORIA_DOCUMENTO = $categoria->COD_CATEGORIA;
                $docasociar->NOM_CATEGORIA_DOCUMENTO = $categoria->NOM_CATEGORIA;
                $docasociar->IND_OBLIGATORIO = $categoria->IND_DOCUMENTO_VAL;
                $docasociar->TXT_FORMATO = $categoria->COD_CTBLE;
                $docasociar->TXT_ASIGNADO = $categoria->TXT_ABREVIATURA;
                $docasociar->COD_USUARIO_CREA_AUD = Session::get('usuario')->id;
                $docasociar->FEC_USUARIO_CREA_AUD = $this->fechaactual;
                $docasociar->COD_ESTADO = 1;
                $docasociar->TIP_DOC = $categoria->CODIGO_SUNAT;
                $docasociar->save();
            }

            $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_ORDEN)->where('COD_ESTADO', '=', 1)
                ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
                ->get();


            $ordencompra_f = CMPOrden::where('COD_ORDEN', '=', $idoc)->first();
            return View::make('comprobante/aprobartes',
                [
                    'ordencompra_f' => $ordencompra_f,
                    'fedocumento' => $fedocumento,
                    'ordencompra' => $ordencompra,
                    'ordeningreso' => $ordeningreso,
                    'linea' => $linea,
                    'archivos' => $archivos,
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


    public function actionAprobarTesoreriaContrato($idopcion, $linea, $prefijo, $idordencompra, Request $request)
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
        View::share('titulo', 'Aprobar  Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();

                $pedido_id = $idoc;
                $partepago = $request['partepago'];

                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO', '=', 1)
                    ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')
                    ->get();

                foreach ($tarchivos as $index => $item) {

                    $filescdm = $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if (!is_null($filescdm)) {

                        foreach ($filescdm as $file) {

                            $TIPO_ARCHIVO = $item->COD_CATEGORIA_DOCUMENTO;
                            $DESCRIPCION_ARCHIVO = $item->NOM_CATEGORIA_DOCUMENTO;
                            if ($partepago == 'on') {
                                $TIPO_ARCHIVO = 'DCC0000000000037';
                                $DESCRIPCION_ARCHIVO = 'PARTE COMPROBANTE DE PAGO';
                            }

                            $contadorArchivos = Archivo::count();
                            $nombre = $ordencompra->COD_DOCUMENTO_CTBLE . '-' . $file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                            $valor = $this->versicarpetanoexiste($rutafile);
                            $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                            copy($file->getRealPath(), $rutacompleta);
                            $path = $rutacompleta;

                            $nombreoriginal = $file->getClientOriginalName();
                            $info = new SplFileInfo($nombreoriginal);
                            $extension = $info->getExtension();

                            $dcontrol = new Archivo;
                            $dcontrol->ID_DOCUMENTO = $ordencompra->COD_DOCUMENTO_CTBLE;
                            $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                            $dcontrol->TIPO_ARCHIVO = $TIPO_ARCHIVO;
                            $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO = $DESCRIPCION_ARCHIVO;


                            $dcontrol->URL_ARCHIVO = $path;
                            $dcontrol->SIZE = filesize($file);
                            $dcontrol->EXTENSION = $extension;
                            $dcontrol->ACTIVO = 1;
                            $dcontrol->FECHA_CREA = $this->fechaactual;
                            $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                            $dcontrol->save();
                        }
                    }
                }

                $orden = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)->first();
                $detalleproducto = CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO', '=', 1)
                    ->where('CMP.DETALLE_PRODUCTO.COD_TABLA', '=', $pedido_id)
                    ->orderBy('NRO_LINEA', 'ASC')
                    ->get();


                if ($TIPO_ARCHIVO == 'DCC0000000000037') {

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'SUBIO PARTE COMPROBANTE DE PAGO';
                    $documento->MENSAJE = '';
                    $documento->save();

                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO PARTE COMPROBANTE DE PAGO');
                    //geolocalización




                } else {

                    FeDocumento::where('ID_DOCUMENTO', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)
                        ->update(
                            [
                                'COD_ESTADO' => 'ETM0000000000008',
                                'TXT_ESTADO' => 'TERMINADA',
                                'fecha_tes' => $this->fechaactual,
                                'usuario_tes' => Session::get('usuario')->id
                            ]
                        );


                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'SUBIO COMPROBANTE DE PAGO';
                    $documento->MENSAJE = '';
                    $documento->save();


                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO COMPROBANTE DE PAGO');
                    //geolocalización



                }

                DB::commit();
                Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('/gestion-de-tesoreria-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $ordencompra->COD_DOCUMENTO_CTBLE . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-tesoreria-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

        } else {

            dd("desarrollo");


        }
    }

    public function actionAprobarTesoreriaEstiba($idopcion, $linea, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idoc = $idordencompra;
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $linea)->first();
        $detallefedocumento = FeDetalleDocumento::where('ID_DOCUMENTO', '=', $idoc)->where('DOCUMENTO_ITEM', '=', $fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo', 'Aprobar  Comprobante');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $operacion = $request['operacion'];
                $pedido_id = $idoc;
                $fedocumento = FeDocumento::where('ID_DOCUMENTO', '=', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)->first();
                $tarchivos = CMPDocAsociarCompra::where('COD_ORDEN', '=', $fedocumento->ID_DOCUMENTO)->where('COD_ESTADO', '=', 1)
                    ->where('COD_CATEGORIA_DOCUMENTO', '=', 'DCC0000000000028')
                    ->get();

                foreach ($tarchivos as $index => $item) {

                    $filescdm = $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if (!is_null($filescdm)) {

                        foreach ($filescdm as $file) {

                            $contadorArchivos = Archivo::count();
                            $nombre = $fedocumento->ID_DOCUMENTO . '-' . $file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $fedocumento->ID_DOCUMENTO;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr = $contadorArchivos . '-' . $this->limpiarTildes($file->getClientOriginalName());
                            $valor = $this->versicarpetanoexiste($rutafile);
                            $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                            copy($file->getRealPath(), $rutacompleta);
                            $path = $rutacompleta;

                            $nombreoriginal = $file->getClientOriginalName();
                            $info = new SplFileInfo($nombreoriginal);
                            $extension = $info->getExtension();

                            $dcontrol = new Archivo;
                            $dcontrol->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                            $dcontrol->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                            $dcontrol->TIPO_ARCHIVO = $item->COD_CATEGORIA_DOCUMENTO;
                            $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO = $item->NOM_CATEGORIA_DOCUMENTO;


                            $dcontrol->URL_ARCHIVO = $path;
                            $dcontrol->SIZE = filesize($file);
                            $dcontrol->EXTENSION = $extension;
                            $dcontrol->ACTIVO = 1;
                            $dcontrol->FECHA_CREA = $this->fechaactual;
                            $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                            $dcontrol->save();
                        }
                    }
                }

                $orden = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $pedido_id)->first();
                $detalleproducto = CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO', '=', 1)
                    ->where('CMP.DETALLE_PRODUCTO.COD_TABLA', '=', $pedido_id)
                    ->orderBy('NRO_LINEA', 'ASC')
                    ->get();

                FeDocumento::where('ID_DOCUMENTO', $pedido_id)->where('DOCUMENTO_ITEM', '=', $linea)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000008',
                            'TXT_ESTADO' => 'TERMINADA',
                            'fecha_tes' => $this->fechaactual,
                            'usuario_tes' => Session::get('usuario')->id
                        ]
                    );


                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO = $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'SUBIO COMPROBANTE DE PAGO';
                $documento->MENSAJE = '';
                $documento->save();


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'SUBIO COMPROBANTE DE PAGO');
                //geolocalización



                DB::commit();
                Session::flash('operacion_id', $operacion);
                return Redirect::to('/gestion-de-tesoreria-aprobar/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $fedocumento->ID_DOCUMENTO . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-tesoreria-aprobar/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

        } else {

            dd("desarrollo");


        }
    }


}
