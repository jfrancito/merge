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

    public function actionListarOCValidado($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Ordenes de Compra');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion($cod_empresa);

        $funcion        =   $this;
        return View::make('comprobante/listaocvalidado',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }


    public function actionListarOCHistorial($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Historial Ordenes de Compra');
        $cod_empresa    =   Session::get('usuario')->id;
        $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_historial($cod_empresa);
        $funcion        =   $this;
        return View::make('comprobante/listaocvalidado',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }




    public function actionDetalleComprobanteOCValidado($idopcion,$linea, $prefijo, $idordencompra, Request $request) {

        View::share('titulo','Detalle de Comprobante');

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);

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
        $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        $funcion                =   $this;

        return View::make('comprobante/registrocomprobantevalidado',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'documentohistorial'    =>  $documentohistorial,
                            'archivos'              =>  $archivos,
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tp'                    =>  $tp,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }

    public function actionDescargar($tipo,$idopcion, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);


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
