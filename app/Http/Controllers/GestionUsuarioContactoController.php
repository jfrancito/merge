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
use App\Modelos\Archivo;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\CMPCategoria;



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

class GestionUsuarioContactoController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;


    public function actionListarComprobanteUsuarioContacto($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista comprobantes por aprobar (Usuario Contacto)');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto
        $listadatos     =   $this->con_lista_cabecera_comprobante_total_uc($cod_empresa);
        $funcion        =   $this;
        return View::make('comprobante/listausuariocontacto',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }

    public function actionListarPreAprobarUsuarioContacto($idopcion,Request $request)
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


                if($fedocumento->COD_ESTADO == 'ETM0000000000002'){ 

                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)
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
                    $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();
                    $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();            

                    $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                    $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                            .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                            .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                                            .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';

                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    $this->insertar_whatsaap('51959266298','INGRID JHOSELIT',$mensaje,'');
                    $this->insertar_whatsaap('51988650421','LUCELY YESMITH',$mensaje,'');
                    $this->insertar_whatsaap('51944132248','JAIRO ALONSO',$mensaje,'');
                    $this->insertar_whatsaap('51979659002','HAMILTON',$mensaje,'');


                    $msjarray[]                             =   array(  "data_0" => $fedocumento->ID_DOCUMENTO, 
                                                                        "data_1" => 'COMPROBANTE APROBADO POR USUARIO CONTACTO', 
                                                                        "tipo" => 'S');
                    $conts                                  =   $conts + 1;
                    $codigo                                 =   $fedocumento->ID_DOCUMENTO;

                }else{
                    /**** ERROR DE PROGRMACION O SINTAXIS ****/
                    $msjarray[] = array("data_0" => $fedocumento->ID_DOCUMENTO, 
                                        "data_1" => 'ESTE COMPROBANTE YA ESTA APROBADO POR USUARIO CONTACTO', 
                                        "tipo" => 'D');
                    $contd      =   $contd + 1;

                }

            }


            /************** MENSAJES DEL DETALLE PEDIDO  ******************/
            $msjarray[] = array("data_0" => $conts, 
                                "data_1" => 'COMPROBANTE APROBADO POR USUARIO CONTACTO', 
                                "tipo" => 'TS');

            $msjarray[] = array("data_0" => $contw, 
                                "data_1" => 'COMPROBANTE APROBADO POR USUARIO CONTACTO', 
                                "tipo" => 'TW');     

            $msjarray[] = array("data_0" => $contd, 
                                "data_1" => 'COMPROBANTES ERRADOS', 
                                "tipo" => 'TD');

            $msjjson = json_encode($msjarray);


            return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('xmlmsj', $msjjson);

        
        }
    }



     public function actionExtornarPreAprobar($idopcion, $prefijo, $idordencompra,Request $request)
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
                                'mensaje_exuc'=>$descripcion,
                                'fecha_ex'=>$this->fechaactual,
                                'usuario_ex'=>Session::get('usuario')->id
                            ]
                        );

            DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->delete();
            DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->delete();

            return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('bienhecho', 'Comprobantes Lote: '.$ordencompra->COD_ORDEN.' EXTORNADA con EXITO');
        
        }
        else{

                  
            return View::make('comprobante/extornar', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



    public function actionAprobarUC($idopcion, $prefijo, $idordencompra,Request $request)
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

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                        ->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
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

                        $dcontrol                   =   new Archivo;
                        $dcontrol->ID_DOCUMENTO     =   $ordencompra->COD_ORDEN;
                        $dcontrol->DOCUMENTO_ITEM   =   $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO     =   $item->COD_CATEGORIA_DOCUMENTO;
                        $dcontrol->NOMBRE_ARCHIVO   =   $nombrefilecdr;
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
                    return Redirect::to('detalle-comprobante-oc/'.$idopcion.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione Archivo .ZIP a Importar ');
                }
            }




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
                    $dcontrol->DESCRIPCION_ARCHIVO  =   'OTROS USUARIO DE CONTACTOS';
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
                return Redirect::to('gestion-de-comprobante-us/'.$idopcion)->with('errorurl', 'Seleccione Archivo PDF a Importar ');
            }

            FeDocumento::where('ID_DOCUMENTO',$pedido_id)
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
            $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();
            $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();            

            $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
            $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                    .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                    .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                                    .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';

            $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
            //$this->insertar_whatsaap('51979659002','HAMILTON',$mensaje,'');

            return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' APROBADO CON EXITO');
        
        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();

            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                        ->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();

            return View::make('comprobante/aprobaruc', 
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
