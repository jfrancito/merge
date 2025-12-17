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
class GestionOCSXController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;

    public function actionSunatCDR()
    {
        $this->sunat_cdr();
    }

    public function actionDetalleComprobanteOCAdministratorSinXML($procedencia,$idopcion, $prefijo, $idordencompra, Request $request) {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        $ordencompra_n          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
        View::share('titulo','REGISTRO DE COMPROBANTE OC SIN XML: '.$idoc);
        $tiposerie              =   '';
        $fedocumento_t          =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        if(count($fedocumento_t)>0){
            DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
            DB::table('FE_DETALLE_DOCUMENTO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
            DB::table('FE_FORMAPAGO')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
            DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
            DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO','=',$fedocumento_t->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$fedocumento_t->DOCUMENTO_ITEM)->delete();
        }

        $documentolinea                     =   $this->ge_linea_documento($ordencompra->COD_ORDEN);
        //REGISTRO DEL XML LEIDO
        $documento                          =   new FeDocumento;
        $documento->ID_DOCUMENTO            =   $ordencompra->COD_ORDEN;
        $documento->DOCUMENTO_ITEM          =   $documentolinea;
        $documento->COD_EMPR                =   $ordencompra->COD_EMPR;
        $documento->TXT_EMPR                =   $ordencompra->NOM_EMPR;
        $documento->TXT_PROCEDENCIA         =   $procedencia;
        $documento->ESTADO                  =   'A';
        $documento->RUC_PROVEEDOR           =   $ordencompra->NRO_DOCUMENTO_CLIENTE;
        $documento->RZ_PROVEEDOR            =   $ordencompra->TXT_EMPR_CLIENTE;
        $documento->TIPO_CLIENTE            =   '';
        $documento->ID_CLIENTE              =   $ordencompra->NRO_DOCUMENTO;
        $documento->NOMBRE_CLIENTE          =   $ordencompra->NOM_EMPR;
        $documento->DIRECCION_CLIENTE       =   '';
        $documento->SERIE                   =   '';
        $documento->NUMERO                  =   '';
        $documento->ID_TIPO_DOC             =   '';
        $documento->FEC_VENTA               =   date_format(date_create($ordencompra_n->FEC_ORDEN), 'Ymd');
        $documento->FEC_VENCI_PAGO          =   date_format(date_create($ordencompra_n->FEC_ORDEN), 'Ymd');
        $documento->FORMA_PAGO              =   '';
        $documento->FORMA_PAGO_DIAS         =   0;
        $documento->MONEDA                  =   '';
        $documento->VALOR_IGV_ORIG          =   0;
        $documento->VALOR_IGV_SOLES         =   0;
        $documento->SUB_TOTAL_VENTA_ORIG    =   $ordencompra_n->CAN_SUB_TOTAL;
        $documento->SUB_TOTAL_VENTA_SOLES   =   $ordencompra_n->CAN_SUB_TOTAL;
        $documento->TOTAL_VENTA_ORIG        =   $ordencompra_n->CAN_TOTAL;
        $documento->TOTAL_VENTA_SOLES       =   $ordencompra_n->CAN_TOTAL;
        $documento->PERCEPCION              =   0;
        $documento->MONTO_RETENCION         =   0;
        $documento->HORA_EMISION            =   date_format(date_create($ordencompra_n->FEC_ORDEN), 'h:i:s');
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
        $documento->OPERACION               =   'ORDEN_COMPRA';
        $documento->OPERACION_DET           =   'SIN_XML';
        $documento->MONTO_NC                =   0.00;

        $documento->save();


        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);
        $xmlarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'xml';
        $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
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
            $xmlfactura         =   $rhxml->NOM_CATEGORIA_DOCUMENTO;
        }
        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                    ->whereIn('TXT_FORMATO', ['PDF'])
                                    ->get();

        //si es de bellavista y rioja copir la orden de compra
        $ordencompra_f          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
        $sourceFile = '\\\\10.1.0.201\cpe\Orden_Compra';
        if($ordencompra_f->COD_CENTRO == 'CEN0000000000004' or $ordencompra_f->COD_CENTRO == 'CEN0000000000006' or $ordencompra_f->COD_CENTRO == 'CEN0000000000002'){
            if($ordencompra_f->COD_CENTRO == 'CEN0000000000004'){
                $sourceFile = '\\\\10.1.7.200\\cpe\\Orden_Compra\\'.$ordencompra->COD_ORDEN.'.pdf';
            }
            if($ordencompra_f->COD_CENTRO == 'CEN0000000000006'){
                $sourceFile = '\\\\10.1.9.43\\cpe\\Orden_Compra\\'.$ordencompra->COD_ORDEN.'.pdf';
            }
            if($ordencompra_f->COD_CENTRO == 'CEN0000000000002'){
                $sourceFile = '\\\\10.1.4.201\\cpe\\Orden_Compra\\'.$ordencompra->COD_ORDEN.'.pdf';
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

        $funcion                =   $this;
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

        $cb_id                  =   '';
        $combocb                =   array('' => "Seleccione Cuenta Bancaria");
        $user_orden             =   User::where('usuarioosiris_id','=',$ordencompra->COD_EMPR_CLIENTE)->first();
        $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra_f->COD_EMPR_CLIENTE)->first();


        //dd($ordencompra);

        $combotipodetraccion    =   array('' => "Seleccione Tipo Detraccion",'MONTO_REFERENCIAL' => 'MONTO REFERENCIAL' , 'MONTO_FACTURACION' => 'MONTO FACTURACION');
        $combopagodetraccion    =   array('' => "Seleccione Pago Detraccion",$ordencompra_f->COD_EMPR_CLIENTE => $ordencompra_f->TXT_EMPR_CLIENTE , $ordencompra->COD_EMPR => $ordencompra->NOM_EMPR);

        //dd($combopagodetraccion);

        $fedocumento_x          =   FeDocumento::where('TXT_REFERENCIA','=',$idoc)->first();


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
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        

        return View::make('comprobantesx/registrocomprobanteadministratorsx',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento_x'         =>  $fedocumento_x,
                            'ordencompra_f'         =>  $ordencompra_f,
                            'combobancos'           =>  $combobancos,
                            'combocb'               =>  $combocb,
                            'empresa'               =>  $empresa,
                            'eliminadodoc'          =>  $eliminadodoc,

                            'comboant'              =>  $comboant,
                            'monto_anticipo'        =>  $monto_anticipo,
                            'combotipodetraccion'   =>  $combotipodetraccion,
                            'combopagodetraccion'   =>  $combopagodetraccion,

                            'fedocumento'           =>  $fedocumento,
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


    public function actionValidarXMLAdministratorSX($idopcion, $prefijo, $idordencompra,Request $request)
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

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            ->whereIn('TXT_FORMATO', ['PDF'])
                                            ->get();

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
                $ordencompra_t                            =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();
                $entidadbanco_id                          =   $request['entidadbanco_id'];
                $bancocategoria                           =   CMPCategoria::where('COD_CATEGORIA','=',$entidadbanco_id)->first();
                $cb_id                                    =   $request['cb_id'];
                $ctadetraccion                            =   $request['ctadetraccion'];
                $monto_detraccion                         =   $request['monto_detraccion'];
                $pago_detraccion                          =   $request['pago_detraccion'];
                $empresa_sel                              =   STDEmpresa::where('COD_EMPR','=',$pago_detraccion)->first();
                $COD_PAGO_DETRACCION                      =   '';
                $TXT_PAGO_DETRACCION                      =   '';
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

                $serie                  =   $request['serie'];
                $numero                 =   $request['numero'];
                $fechaventa             =   $request['fechaventa'];
                $fechavencimiento       =   $request['fechavencimiento'];

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

                                    'SERIE'=>$serie,
                                    'NUMERO'=>$numero,
                                    'FEC_VENTA'=>$fechaventa,
                                    'FEC_VENCI_PAGO'=>$fechavencimiento,

                                    'CTA_DETRACCION'=>$ctadetraccion,
                                    'MONTO_DETRACCION_XML'=>$monto_detraccion,
                                    'MONTO_DETRACCION_RED'=>round($monto_detraccion),
                                    'COD_PAGO_DETRACCION'=>$COD_PAGO_DETRACCION,
                                    'TXT_PAGO_DETRACCION'=>$TXT_PAGO_DETRACCION,

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
                    //$this->insert_detalle_producto($orden,$detalleproducto,$orden_id[0]);//crea detalle de la orden de ingresa
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





}
