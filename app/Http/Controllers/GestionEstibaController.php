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

    public function actionDetalleSelectEstiba($idopcion,Request $request)
    {
        $jsondocumenos                          =    json_decode($request['jsondocumenos'],true);
        $lote                                   =    $this->funciones->generar_lote('FE_REF_ASOC',8);
        $sw                                     =    0;
        foreach ($jsondocumenos as $key => $item) {
            $ID_DOCUMENTO = $item['data_requerimiento_id'];
            $feref = FeRefAsoc::where('ID_DOCUMENTO','=',$ID_DOCUMENTO)->where('COD_ESTADO','=','1')->first();
            if(count($feref)>0){
                $sw                             =    1;  
            }
        }
        if($sw==1){
            return Redirect::to('gestion-de-orden-compra/'.$idopcion)->with('errorbd', 'Has seleccionado Documentos que ya tienen lotes activos');  
        }



        foreach ($jsondocumenos as $key => $item) {
            $ID_DOCUMENTO = $item['data_requerimiento_id'];
            $docasociar                              =   New FeRefAsoc;
            $docasociar->LOTE                        =   $lote;
            $docasociar->ID_DOCUMENTO                =   $ID_DOCUMENTO;
            $docasociar->FECHA_CREA                  =   $this->fechaactual;
            $docasociar->COD_ESTADO                  =   1;
            $docasociar->USUARIO_CREA                =   Session::get('usuario')->id;
            $docasociar->save();

        }


        return Redirect::to('detalle-comprobante-estiba-administrator/'.$idopcion.'/'.$lote);
    }

    public function actionDetalleComprobanteestibaAdministrator($idopcion, $lote, Request $request) {

        $idoc                   =   $lote;
        $ferefeasoc             =   FeRefAsoc::where('lote','=',$lote)->get();
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')->first();
        View::share('titulo','REGISTRO DE COMPROBANTE ESTIBA :'.$lote);
        $tiposerie              =   '';
        $empresa                =   array();

        $usuario                =   SGDUsuario::where('COD_TRABAJADOR','=',Session::get('usuario')->usuarioosiris_id)->first();



        if(count($fedocumento)>0){

            $detallefedocumento =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tiposerie          =   substr($fedocumento->SERIE, 0, 1);
            $empresa            =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();

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
        $combopagodetraccion    =   array();//array('' => "Seleccione Pago Detraccion",$ordencompra->COD_EMPR_EMISOR => $ordencompra->TXT_EMPR_EMISOR , $ordencompra->COD_EMPR_RECEPTOR => $ordencompra->TXT_EMPR_RECEPTOR);
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
                                                    ->whereIn('COD_CATEGORIA', ['DCC0000000000002','DCC0000000000003','DCC0000000000004'])
                                                    ->get();

                        }else{

                            //RECIBO POR HONORARIO
                            $parser = new RHParser();
                            $xml = file_get_contents($path);
                            $factura = $parser->parse($xml);  
                            $tipo_documento_le = 'R1';
                            $moneda_le = 'PEN';
                            $archivosdelfe      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                    ->whereIn('COD_CATEGORIA', ['DCC0000000000013','DCC0000000000003'])->get();
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
                        $cant_perception                    =   $factura->getperception();
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
                        $documento->OPERACION               =   'ESTIBA';
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

    public function actionCargarModalDetalleLotes(Request $request) {

        $feasoc         =   FeRefAsoc::where('','','')->get();
        $funcion        =   $this;

        return View::make('entregadocumento/modal',
                         [
                            'fecha_inicio'          =>  $fecha_inicio,
                            'fecha_fin'             =>  $fecha_fin,
                            'empresa_id'            =>  $empresa_id,
                            'centro_id'             =>  $centro_id,
                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'operacion_id'            =>  $operacion_id,
                            'funcion'               =>  $funcion
                         ]);
    }


}
