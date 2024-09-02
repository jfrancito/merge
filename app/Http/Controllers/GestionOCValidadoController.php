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
use App\Modelos\Archivo;
use App\Modelos\CMPReferecenciaAsoc;
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
use Hashids;
use SplFileInfo;

class GestionOCValidadoController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;

    public function actionDetalleComprobanteOCValidadoContratoHistorial($idopcion,$linea, $prefijo, $idordencompra, Request $request) {

        View::share('titulo','Detalle de Comprobante Historial');

        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);

        $xmlarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_XML;
        $cdrarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_CDR;
        $pdfarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_PDF;
        $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->orderBy('FECHA','DESC')
                                    ->get();
        //dd($documentohistorial);

        $funcion                =   $this;

        $archivos               =   $this->lista_archivos_total_sin_voucher($idoc,$fedocumento->DOCUMENTO_ITEM);
        $archivospdf            =   $this->lista_archivos_total_pdf_sin_voucher($idoc,$fedocumento->DOCUMENTO_ITEM);



        $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


        //dd($archivos);
        return View::make('comprobante/registrocomprobantevalidadocontrato',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'documentohistorial'    =>  $documentohistorial,
                            'archivos'              =>  $archivos,
                            'archivosanulados'              =>  $archivosanulados,
                            'linea'                 =>  $linea,
                            'archivospdf'           =>  $archivospdf,                         
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tp'                    =>  $tp,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }


    public function actionDetalleComprobanteOCValidadoHitorial($idopcion,$linea, $prefijo, $idordencompra, Request $request) {

        View::share('titulo','Detalle de Comprobante Historial');

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();

        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);

        $xmlarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_XML;
        $cdrarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_CDR;
        $pdfarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_PDF;
        $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->orderBy('FECHA','DESC')
                                    ->get();
        //dd($documentohistorial);

        $funcion                =   $this;
        $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


        $archivos               =   $this->lista_archivos_total_sin_voucher($idoc,$fedocumento->DOCUMENTO_ITEM);
        $archivospdf            =   $this->lista_archivos_total_pdf_sin_voucher($idoc,$fedocumento->DOCUMENTO_ITEM);

        //orden de ingreso
        $referencia             =   CMPReferecenciaAsoc::where('COD_TABLA','=',$ordencompra->COD_ORDEN)
                                    ->where('COD_TABLA_ASOC','like','%OI%')->first();
        $ordeningreso           =   array();
        if(count($referencia)>0){
            $ordeningreso       =   CMPOrden::where('COD_ORDEN','=',$referencia->COD_TABLA_ASOC)->first();   
        }    

        //dd($archivos);
        return View::make('comprobante/registrocomprobantevalidado',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'archivospdf'           =>  $archivospdf,
                            'ordeningreso'           =>  $ordeningreso,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'documentohistorial'    =>  $documentohistorial,
                            'archivos'              =>  $archivos,
                            'archivosanulados'      =>  $archivosanulados,

                            'linea'                 =>  $linea,
                            
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tp'                    =>  $tp,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }



    public function actionListarOCValidado($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Ordenes de Compra');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        $fecha_inicio   =   $this->fecha_menos_diez_dias;
        $fecha_fin      =   $this->fecha_sin_hora;
        $proveedor_id   =   'TODO';
        $combo_proveedor=   $this->gn_combo_proveedor_fe_documento($proveedor_id);

        $estado_id      =   'TODO';
        $combo_estado   =   $this->gn_combo_estado_fe_documento($estado_id);


        //falta usuario contacto
        $operacion_id       =   'ORDEN_COMPRA';
        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }

        
        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO');

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);
        }else{
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);
        }


        $funcion        =   $this;
        return View::make('comprobante/listaocvalidado',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin,
                            'proveedor_id'      =>  $proveedor_id,
                            'combo_proveedor'   =>  $combo_proveedor,
                            'estado_id'         =>  $estado_id,
                            'combo_estado'      =>  $combo_estado,
                            'operacion_id'         =>  $operacion_id,
                            'combo_operacion'      =>  $combo_operacion,
                         ]);
    }



    public function actionListarAjaxBuscarDocumento(Request $request) {

        $fecha_inicio   =   $request['fecha_inicio'];
        $fecha_fin      =   $request['fecha_fin'];
        $proveedor_id   =   $request['proveedor_id'];  
        $estado_id      =   $request['estado_id'];
        $idopcion       =   $request['idopcion'];
        $operacion_id   =   $request['operacion_id'];

        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);
        }else{
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);
        }

        $funcion        =   $this;

        return View::make('comprobante/ajax/mergelistaocvalidado',
                         [
                            'fecha_inicio'          =>  $fecha_inicio,
                            'fecha_fin'             =>  $fecha_fin,
                            'proveedor_id'          =>  $proveedor_id,
                            'estado_id'             =>  $estado_id,
                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'operacion_id'            =>  $operacion_id,
                            'funcion'               =>  $funcion
                         ]);
    }






    public function actionListarOCHistorial($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Historial Comprobante');
        $cod_empresa    =   Session::get('usuario')->name;

        //falta usuario contacto
        $operacion_id       =   'ORDEN_COMPRA';
        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO TRANSPORTE CARGA');

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_historial($cod_empresa);
        }else{
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_historial_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);
        }

        $funcion        =   $this;

        //dd($listadatos);

        return View::make('comprobante/listaocvalidadohistorial',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'operacion_id'           =>  $operacion_id,
                            'combo_operacion'          =>  $combo_operacion,


                         ]);
    }



    public function actionListarAjaxBuscarDocumentoHistorial(Request $request) {


        $idopcion       =   $request['idopcion'];
        $operacion_id   =   $request['operacion_id'];
        $cod_empresa    =   Session::get('usuario')->name;

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_historial($cod_empresa);
        }else{


            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_historial_contrato($cod_empresa);
        }

        $funcion        =   $this;

        return View::make('comprobante/ajax/mergelistaocvalidadohistorial',
                         [

                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'operacion_id'            =>  $operacion_id,
                            'funcion'               =>  $funcion
                         ]);
    }


    public function actionDetalleComprobanteOCValidadoContrato($idopcion,$linea, $prefijo, $idordencompra, Request $request) {

        View::share('titulo','Detalle de Comprobante');

        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);

        $xmlarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_XML;
        $cdrarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_CDR;
        $pdfarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_PDF;
        $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->orderBy('FECHA','DESC')
                                    ->get();
        //dd($documentohistorial);

        $funcion                =   $this;

        $archivos               =   $this->lista_archivos_total($idoc,$fedocumento->DOCUMENTO_ITEM);
        $archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);



        $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


        //dd($archivos);
        return View::make('comprobante/registrocomprobantevalidadocontrato',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'documentohistorial'    =>  $documentohistorial,
                            'archivos'              =>  $archivos,
                            'archivosanulados'              =>  $archivosanulados,
                            'linea'                 =>  $linea,
                            'archivospdf'           =>  $archivospdf,                         
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tp'                    =>  $tp,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }


    public function actionDetalleComprobanteOCValidado($idopcion,$linea, $prefijo, $idordencompra, Request $request) {

        View::share('titulo','Detalle de Comprobante');

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();

        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);



        $xmlarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_XML;
        $cdrarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_CDR;
        $pdfarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.$fedocumento->ARCHIVO_PDF;
        $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->orderBy('FECHA','DESC')
                                    ->get();
        //dd($documentohistorial);

        $funcion                =   $this;
        $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


        $archivos               =   $this->lista_archivos_total($idoc,$fedocumento->DOCUMENTO_ITEM);
        $archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);


        //orden de ingreso
        $referencia             =   CMPReferecenciaAsoc::where('COD_TABLA','=',$ordencompra->COD_ORDEN)
                                    ->where('COD_TABLA_ASOC','like','%OI%')->first();
        $ordeningreso           =   array();
        if(count($referencia)>0){
            $ordeningreso       =   CMPOrden::where('COD_ORDEN','=',$referencia->COD_TABLA_ASOC)->first();   
        }    

        //dd($archivos);
        return View::make('comprobante/registrocomprobantevalidado',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'archivospdf'           =>  $archivospdf,
                            'ordeningreso'           =>  $ordeningreso,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'documentohistorial'    =>  $documentohistorial,
                            'archivos'              =>  $archivos,
                            'archivosanulados'      =>  $archivosanulados,

                            'linea'                 =>  $linea,
                            
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tp'                    =>  $tp,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }

    public function actionDescargar($tipo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);


        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('TIPO_ARCHIVO','=',$tipo)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
        

        $nombrearchivo          =   trim($archivo->NOMBRE_ARCHIVO);


        $nombrefile             =   basename($nombrearchivo);
        $file                   =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.basename($archivo->NOMBRE_ARCHIVO);


        if(file_exists($file)){


            $remoteFile = str_replace('\\', '/', $file);

            // Obtener el nombre del archivo desde la ruta
            $fileName = basename($remoteFile);

            // Intentar abrir el archivo remoto
            if ($remoteHandle = fopen($remoteFile, 'rb')) {
                // Enviar los encabezados necesarios para la descarga del archivo
                header('Content-Description: File Transfer');
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($remoteFile));
                
                // Limpiar el búfer de salida
                ob_clean();
                flush();

                // Leer el archivo remoto y enviarlo al navegador
                while (!feof($remoteHandle)) {
                    echo fread($remoteHandle, 8192);
                }

                // Cerrar el manejador de archivo
                fclose($remoteHandle);
                exit;
            } else {
                echo 'No se pudo acceder al archivo remoto.';
            }



            // dd($file);
            // header("Cache-Control: public");
            // header("Content-Description: File Transfer");
            // header("Content-Disposition: attachment; filename=$nombrefile");
            // header("Content-Type: application/xml");
            // header("Content-Transfer-Encoding: binary");


            // readfile($file);


            exit;
        }else{
            dd('Documento no encontrado');
        }

    }

    public function actionDescargarContrato($tipo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);


        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);


        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        //dd($ordencompra);

        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);


        //dd($idoc);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('TIPO_ARCHIVO','=',$tipo)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
        $nombrearchivo          =   trim($archivo->NOMBRE_ARCHIVO);
        $nombrefile             =   basename($nombrearchivo);
        $file                   =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.basename($archivo->NOMBRE_ARCHIVO);


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



    public function actionDescargarXML($idopcion, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);

        $nombrearchivo  =   trim($fedocumento->ARCHIVO_XML);
        $nombrefile     =   basename($nombrearchivo);
        $file           =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.basename($fedocumento->ARCHIVO_XML);


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

    public function actionDescargarCDR($idopcion, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);

        $nombrearchivo  =   trim($fedocumento->ARCHIVO_CDR);
        $nombrefile     =   basename($nombrearchivo);
        $file           =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.basename($fedocumento->ARCHIVO_CDR);


        if(file_exists($file)){
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$nombrefile");
            header("Content-Type: application/ZIP");
            header("Content-Transfer-Encoding: binary");
            readfile($file);
            exit;
        }else{
            dd('Documento no encontrado');
        }

    }


    public function actionDescargarPDF($idopcion, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);

        $nombrearchivo  =   trim($fedocumento->ARCHIVO_PDF);
        $nombrefile     =   basename($nombrearchivo);
        $file           =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE.'\\'.basename($fedocumento->ARCHIVO_PDF);



        if(file_exists($file)){
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$nombrefile");
            header("Content-Type: application/pdf");
            header("Content-Transfer-Encoding: binary");
            readfile($file);
            exit;
        }else{
            dd('Documento no encontrado');
        }

    }



}
