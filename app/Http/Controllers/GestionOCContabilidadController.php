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
use App\Modelos\FeDocumentoHistorial;
use App\Modelos\SGDUsuario;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use App\Modelos\CMPCategoria;
use App\Modelos\CMPDocAsociarCompra;
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
use App\Traits\WhatsappTraits;


use Hashids;
use SplFileInfo;

class GestionOCContabilidadController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    

    public function actionListarComprobanteContabilidad($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista comprobantes por aprobar (Contailidad)');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto
        $listadatos     =   $this->con_lista_cabecera_comprobante_total_cont($cod_empresa);
        $funcion        =   $this;
        return View::make('comprobante/listacontabilidad',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }

    public function actionListarAprobarUsuarioContacto($idopcion,Request $request)
    {

        if($_POST)
        {
            $msjarray           = array();
            $respuesta          = json_decode($request['pedido'], true);
            $conts              = 0;
            $contw              = 0;
            $contd              = 0;
        
            //dd("hola");
            foreach($respuesta as $obj){

                $pedido_id          =   $obj['id'];
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();
                if($fedocumento->COD_ESTADO == 'ETM0000000000003'){ 

                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                                ->update(
                                    [
                                        'COD_ESTADO'=>'ETM0000000000004',
                                        'TXT_ESTADO'=>'POR APROBAR ADMINISTRACION',
                                        'ind_email_adm'=>0,
                                        'fecha_ap'=>$this->fechaactual,
                                        'usuario_ap'=>Session::get('usuario')->id
                                    ]
                                );

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'APROBADO POR CONTABILIDAD';
                    $documento->MENSAJE                     =   '';
                    $documento->save();


                    //whatsaap para administracion
                    $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();
                    $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();

                    $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                    $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                            .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                            .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                                            .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';

                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    $this->insertar_whatsaap('51971575452','GISELA',$mensaje,'');
                    $this->insertar_whatsaap('51920721827','JESSICA DEL PILAR',$mensaje,'');
                    $this->insertar_whatsaap('51948634244','ELSA ANA BELEN',$mensaje,'');

                    $msjarray[]                             =   array(  "data_0" => $fedocumento->ID_DOCUMENTO, 
                                                                        "data_1" => 'COMPROBANTE APROBADO POR CONTABILIDAD', 
                                                                        "tipo" => 'S');
                    $conts                                  =   $conts + 1;
                    $codigo                                 =   $fedocumento->ID_DOCUMENTO;

                }else{
                    /**** ERROR DE PROGRMACION O SINTAXIS ****/
                    $msjarray[] = array("data_0" => $fedocumento->ID_DOCUMENTO, 
                                        "data_1" => 'ESTE COMPROBANTE YA ESTA APROBADO POR CONTABILIDAD', 
                                        "tipo" => 'D');
                    $contd      =   $contd + 1;

                }

            }


            /************** MENSAJES DEL DETALLE PEDIDO  ******************/
            $msjarray[] = array("data_0" => $conts, 
                                "data_1" => 'COMPROBANTE APROBADO POR CONTABILIDAD', 
                                "tipo" => 'TS');

            $msjarray[] = array("data_0" => $contw, 
                                "data_1" => 'COMPROBANTE APROBADO POR CONTABILIDAD', 
                                "tipo" => 'TW');     

            $msjarray[] = array("data_0" => $contd, 
                                "data_1" => 'COMPROBANTES ERRADOS', 
                                "tipo" => 'TD');

            $msjjson = json_encode($msjarray);


            return Redirect::to('/gestion-de-contabilidad-aprobar/'.$idopcion)->with('xmlmsj', $msjjson);

        
        }
    }



     public function actionExtornarAprobar($idopcion, $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();
        View::share('titulo','Extornar  Comprobante');


        if($_POST)
        {
            $descripcion     =   $request['descripcion'];                
            FeDocumento::where('ID_DOCUMENTO',$idoc)
                        ->update(
                            [
                                'COD_ESTADO'=>'ETM0000000000001',
                                'TXT_ESTADO'=>'GENERADO',
                                'ind_email_ba'=>0,
                                
                                'mensaje_exap'=>$descripcion,
                                'fecha_ex'=>$this->fechaactual,
                                'usuario_ex'=>Session::get('usuario')->id
                            ]
                        );

            return Redirect::to('/gestion-de-contabilidad-aprobar/'.$idopcion)->with('bienhecho', 'Comprobantes Lote: '.$ordencompra->COD_ORDEN.' EXTORNADA con EXITO');
        
        }
        else{

                  
            return View::make('comprobante/extornarcontabilidad', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



    public function actionAprobarContabilidad($idopcion, $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();
        View::share('titulo','Aprobar  Comprobante');

        if($_POST)
        {
            $pedido_id          =   $idoc;
            $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();


            $filespdf          =   $request['otros'];
            if(!is_null($filespdf)){
                //PDF
                foreach($filespdf as $file){

                        $larchivos       =      Archivo::get();


                    $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                    /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                    $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                    $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                    //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                    $nombrefilepdf   =      count($larchivos).'-'.$file->getClientOriginalName();
                    $valor           =      $this->versicarpetanoexiste($rutafile);
                    $rutacompleta    =      $rutafile.'\\'.$nombrefilepdf;
                    copy($file->getRealPath(),$rutacompleta);
                    $path            =      $rutacompleta;

                    $nombreoriginal             =   $file->getClientOriginalName();
                    $info                       =   new SplFileInfo($nombreoriginal);
                    $extension                  =   $info->getExtension();

                    $dcontrol                   =   new Archivo;
                    $dcontrol->ID_DOCUMENTO     =   $ordencompra->COD_ORDEN;
                    $dcontrol->DOCUMENTO_ITEM   =   $fedocumento->DOCUMENTO_ITEM;
                    $dcontrol->TIPO_ARCHIVO     =   'OTROS_UC';
                    $dcontrol->NOMBRE_ARCHIVO   =   $nombrefilepdf;
                    $dcontrol->DESCRIPCION_ARCHIVO  =   'OTROS CONTABILIDAD';
                    $dcontrol->URL_ARCHIVO      =   $path;
                    $dcontrol->SIZE             =   filesize($file);
                    $dcontrol->EXTENSION        =   $extension;
                    $dcontrol->ACTIVO           =   1;
                    $dcontrol->FECHA_CREA       =   $this->fechaactual;
                    $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                    $dcontrol->save();
                    //dd($nombre);
                }
            }else{
                return Redirect::to('gestion-de-contabilidad-aprobar/'.$idopcion)->with('errorurl', 'Seleccione Archivo PDF a Importar ');
            }


                FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000004',
                                    'TXT_ESTADO'=>'POR APROBAR ADMINISTRACION',
                                    'ind_email_adm'=>0,
                                    'fecha_ap'=>$this->fechaactual,
                                    'usuario_ap'=>Session::get('usuario')->id
                                ]
                            );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE                     =   '';
                $documento->save();


                //whatsaap para administracion
                $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();
                $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();

                $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                        .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                        .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                                        .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';
                $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                //$this->insertar_whatsaap('51971575452','GISELA',$mensaje,'');




            return Redirect::to('/gestion-de-contabilidad-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' APROBADO CON EXITO');
        
        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();

            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                        ->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();

            return View::make('comprobante/aprobarcon', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'tarchivos'             =>  $tarchivos,
                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



}
