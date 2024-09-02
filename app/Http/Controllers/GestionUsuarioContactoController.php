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
use App\Modelos\CMPDetalleProducto;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\CMPReferecenciaAsoc;



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
use App\Traits\ComprobanteProvisionTraits;

use Hashids;
use SplFileInfo;

class GestionUsuarioContactoController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;

    public function actionListarComprobantesObservados($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Documentos Observados');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        $operacion_id       =   'ORDEN_COMPRA';
        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO');

        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados($cod_empresa);
        }else{
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_contrato($cod_empresa);
        }

        $funcion        =   $this;
        return View::make('comprobante/listaocobservados',
                         [
                            'listadatos'        =>  $listadatos,
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }




    public function actionListarAjaxBuscarDocumentoObservados(Request $request) {

        $operacion_id   =   $request['operacion_id'];
        $idopcion       =   $request['idopcion'];
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_observados($cod_empresa);
        }else{
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_observados_contrato($cod_empresa);
        }
        $funcion                =   $this;
        return View::make('comprobante/ajax/mergelistaobservados',
                         [
                            'operacion_id'          =>  $operacion_id,
                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'funcion'               =>  $funcion
                         ]);
    }



    public function actionObservarUC($idopcion,$linea , $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('ind_observacion','=',1)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Comprobante Observado');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id              =   $idoc;
                $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();

                $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                            ->where('ACTIVO','=','1')
                                            ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                            ->pluck('TIPO_ARCHIVO')
                                            ->toArray();

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

                $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                if($tiposerie == 'E'){

                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004'])
                                                //->where('TXT_ASIGNADO','=','CONTACTO')
                                                ->get();



                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                //->where('TXT_ASIGNADO','=','CONTACTO')
                                                ->get();
                }



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
                        return Redirect::to('observacion-comprobante-uc'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione los archivos Correspondientes');
                    }
                }

                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'ind_observacion'=>'0'
                                ]
                            );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'RESOLVIO LAS OBSERVACIONES';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //whatsaap para contabilidad
                $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();
                $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();            

                $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                        .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                        .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                                        .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A'
                                        .'MENSAJE : '.'RESOLVIO LAS OBSERVACIONES'.'%0D%0A';

                //dd($fedocumento_w);
                // CUANDO EL WHATSAAP ES PARA EL USUARIO DEL CONTACTO
                if($fedocumento_w->area_observacion == 'CONT'){
                    if(1==0){
                        $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    }else{

                        $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                        $this->insertar_whatsaap('51979659002','HAMILTON',$mensaje,'');
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        //CONTABILIDAD
                        if($prefijocarperta=='II'){
                            //$this->insertar_whatsaap('51988650421','LUCELY YESMITH',$mensaje,'');   //INTERNACIONAL
                            //$this->insertar_whatsaap('51959266298','INGRID JHOSELIT',$mensaje,'');  //INTERNACIONAL
                            $this->insertar_whatsaap('51965991360','ANGHIE',$mensaje,'');           //INTERNACIONAL
                        }else{
                            $this->insertar_whatsaap('51950638955','MIGUEL',$mensaje,'');           //COMERCIAL
                            //$this->insertar_whatsaap('51944132248','JAIRO ALONSO',$mensaje,'');     //COMERCIAL
                            //$this->insertar_whatsaap('51977624444','DINO CRISTOPHER',$mensaje,'');  //COMERCIAL
                        }

                    }  
                }else{
                    if(1==0){
                        $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    }else{
                        $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                        //CONTABILIDAD
                        $this->insertar_whatsaap('51971575452','GISELA',$mensaje,'');
                        $this->insertar_whatsaap('51920721827','JESSICA DEL PILAR',$mensaje,'');
                        //$this->insertar_whatsaap('51948634244','ELSA ANA BELEN',$mensaje,'');
                    }   
                }


                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-observados/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobantes-observados/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            //$ordencompra            =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();  


            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->pluck('TIPO_ARCHIVO')
                                        ->toArray();

 
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            if($tiposerie == 'E'){



                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();




            }else{

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }




            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();



            return View::make('comprobante/observaruc', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'tarchivos'             =>  $tarchivos,
                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }


    public function actionObservarUCContrato($idopcion,$linea , $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('ind_observacion','=',1)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Comprobante Observado');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id              =   $idoc;
                $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();

                $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                            ->where('ACTIVO','=','1')
                                            ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                            ->pluck('TIPO_ARCHIVO')
                                            ->toArray();

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            ->get();

                $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                if($tiposerie == 'E'){

                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004'])
                                                ->get();



                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->get();
                }



                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
                        foreach($filescdm as $file){

                            $larchivos       =      Archivo::get();

                            $nombre          =      $ordencompra->COD_DOCUMENTO_CTBLE.'-'.$file->getClientOriginalName();
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
                            $dcontrol->ID_DOCUMENTO     =   $ordencompra->COD_DOCUMENTO_CTBLE;
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
                        return Redirect::to('observacion-comprobante-uc-contrato'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione los archivos Correspondientes');
                    }
                }

                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'ind_observacion'=>'0'
                                ]
                            );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'RESOLVIO LAS OBSERVACIONES';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //whatsaap para contabilidad
                $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();
                $ordencompra        =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$pedido_id)->first();            

                $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                        .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                        .'PROVEEDOR : '.$ordencompra->TXT_EMPR_EMISOR.'%0D%0A'
                                        .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A'
                                        .'MENSAJE : '.'RESOLVIO LAS OBSERVACIONES'.'%0D%0A';

                // CUANDO EL WHATSAAP ES PARA EL USUARIO DEL CONTACTO
                if($fedocumento_w->area_observacion == 'CONT'){
                    if(1==0){
                        $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    }else{

                        $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                        $this->insertar_whatsaap('51979659002','HAMILTON',$mensaje,'');
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        //CONTABILIDAD
                        if($prefijocarperta=='II'){
                            $this->insertar_whatsaap('51965991360','ANGHIE',$mensaje,'');           //INTERNACIONAL
                        }else{
                            $this->insertar_whatsaap('51950638955','MIGUEL',$mensaje,'');           //COMERCIAL
                        }

                    }  
                }else{
                    if(1==0){
                        $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    }else{
                        $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                        //CONTABILIDAD
                        $this->insertar_whatsaap('51971575452','GISELA',$mensaje,'');
                        $this->insertar_whatsaap('51920721827','JESSICA DEL PILAR',$mensaje,'');
                    }   
                }


                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-observados/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobantes-observados/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
 
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->pluck('TIPO_ARCHIVO')
                                        ->toArray();

 
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            if($tiposerie == 'E'){

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }else{

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            return View::make('comprobante/observaruccontrato', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'tarchivos'             =>  $tarchivos,
                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }







    public function actionListarComprobanteUsuarioContacto($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista comprobantes por aprobar (Usuario Contacto)');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto

        $operacion_id       =   'ORDEN_COMPRA';
        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO');
        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_uc($cod_empresa);
        }else{
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_contrato_uc($cod_empresa);
        }

        $funcion            =   $this;
        return View::make('comprobante/listausuariocontacto',
                         [
                            'listadatos'        =>  $listadatos,
                            'combo_operacion'   =>  $combo_operacion,
                            'operacion_id'      =>  $operacion_id,
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
                                        'COD_ESTADO'=>'ETM0000000000005',
                                        'TXT_ESTADO'=>'APROBADO',
                                        'ind_email_clap'=>0,
                                        'fecha_uc'=>$this->fechaactual,
                                        'usuario_uc'=>Session::get('usuario')->id
                                    ]
                                );

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
                    $this->insertar_whatsaap('51979659002','HAMILTON',$mensaje,'');
                    $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                    //CONTABILIDAD
                    if($prefijocarperta=='II'){
                        //$this->insertar_whatsaap('51988650421','LUCELY YESMITH',$mensaje,'');   //INTERNACIONAL
                        //$this->insertar_whatsaap('51959266298','INGRID JHOSELIT',$mensaje,'');  //INTERNACIONAL
                        $this->insertar_whatsaap('51965991360','ANGHIE',$mensaje,'');           //INTERNACIONAL
                    }else{
                        $this->insertar_whatsaap('51950638955','MIGUEL',$mensaje,'');           //COMERCIAL
                        //$this->insertar_whatsaap('51944132248','JAIRO ALONSO',$mensaje,'');     //COMERCIAL
                        //$this->insertar_whatsaap('51977624444','DINO CRISTOPHER',$mensaje,'');  //COMERCIAL
                    }


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



     public function actionExtornarPreAprobar($idopcion,$linea, $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Extornar  Comprobante');

        if($_POST)
        {
                        
            $descripcion     =   $request['descripcion'];
            
            FeDocumento::where('ID_DOCUMENTO',$idoc)->where('COD_ESTADO','<>','ETM0000000000006')
                        ->update(
                            [
                                'COD_ESTADO'=>'ETM0000000000006',
                                'TXT_ESTADO'=>'RECHAZADO',
                                'ind_email_ba'=>0,
                                'mensaje_exuc'=>$descripcion,
                                'mensaje_exap'=>'',
                                'mensaje_exadm'=>'',
                                'fecha_ex'=>$this->fechaactual,
                                'usuario_ex'=>Session::get('usuario')->id
                            ]
                        );


            $ordencompra_t                          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();
            //HISTORIAL DE DOCUMENTO APROBADO
            $documento                              =   new FeDocumentoHistorial;
            $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
            $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
            $documento->FECHA                       =   $this->fechaactual;
            $documento->USUARIO_ID                  =   Session::get('usuario')->id;
            $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
            $documento->TIPO                        =   'RECHAZADO POR USUARIO CONTACTO';
            $documento->MENSAJE                     =   '';
            $documento->save();

            // DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->delete();
            // DB::table('ARCHIVOS')->where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->delete();

            return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('bienhecho', 'Comprobantes Lote: '.$ordencompra->COD_ORDEN.' EXTORNADA con EXITO');
        
        }
        else{

                  
            return View::make('comprobante/extornar', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'idopcion'              =>  $idopcion,
                                'linea'                 =>  $linea,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



    public function actionAprobarUC($idopcion,$linea , $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Aprobar  Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();

                $orden                      =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();

                if($orden->IND_MATERIAL_SERVICIO=='M'){

                    $detalleproducto            =   CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO','=',1)
                                                    ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$pedido_id)
                                                    ->orderBy('NRO_LINEA','ASC')
                                                    ->get();
                    //  INSERTAR ORDEN DE INGRESO
                    //almacen lote                                
                    $this->insert_almacen_lote($orden,$detalleproducto);
                    $orden_id = $this->insert_orden($orden,$detalleproducto);                 
                    $this->insert_referencia_asoc($orden,$detalleproducto,$orden_id[0]);
                    $this->insert_detalle_producto($orden,$detalleproducto,$orden_id[0]);


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


                }


                //guardar orden de compra precargada
                $rutaorden       =   $request['rutaorden'];
                if($rutaorden!=''){

                    $aoc                            =       CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000001'])
                                                            ->first();
                    $larchivos                      =       Archivo::get();
                    $nombrefilecdr                  =       count($larchivos).'-'.$ordencompra->COD_ORDEN.'.pdf';
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
                    }
                }

                // $filespdf          =   $request['otros'];
                // if(!is_null($filespdf)){
                //     //PDF
                //     foreach($filespdf as $file){

                //             $larchivos       =      Archivo::get();


                //         $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                //         /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                //         $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                //         $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                //         //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                //         $nombrefilepdf   =      count($larchivos).'-'.$file->getClientOriginalName();
                //         $valor           =      $this->versicarpetanoexiste($rutafile);
                //         $rutacompleta    =      $rutafile.'\\'.$nombrefilepdf;
                //         copy($file->getRealPath(),$rutacompleta);
                //         $path            =      $rutacompleta;

                //         $nombreoriginal             =   $file->getClientOriginalName();
                //         $info                       =   new SplFileInfo($nombreoriginal);
                //         $extension                  =   $info->getExtension();

                //         $dcontrol                   =   new Archivo;
                //         $dcontrol->ID_DOCUMENTO     =   $ordencompra->COD_ORDEN;
                //         $dcontrol->DOCUMENTO_ITEM   =   $fedocumento->DOCUMENTO_ITEM;
                //         $dcontrol->TIPO_ARCHIVO     =   'OTROS_UC';
                //         $dcontrol->NOMBRE_ARCHIVO   =   $nombrefilepdf;
                //         $dcontrol->DESCRIPCION_ARCHIVO  =   'OTROS USUARIO DE CONTACTOS';
                //         $dcontrol->URL_ARCHIVO      =   $path;
                //         $dcontrol->SIZE             =   filesize($file);
                //         $dcontrol->EXTENSION        =   $extension;
                //         $dcontrol->ACTIVO           =   1;
                //         $dcontrol->FECHA_CREA       =   $this->fechaactual;
                //         $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                //         $dcontrol->save();
                //         //dd($nombre);
                //     }
                // }



                if($orden->IND_MATERIAL_SERVICIO=='M'){

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

                  
                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
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
                    $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();
                    $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();            

                    $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                    $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                            .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                            .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                                            .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';

                    if(1==0){
                        $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    }else{

                        $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                        $this->insertar_whatsaap('51979659002','HAMILTON',$mensaje,'');
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        //CONTABILIDAD
                        if($prefijocarperta=='II'){
                            $this->insertar_whatsaap('51965991360','ANGHIE',$mensaje,'');           //INTERNACIONAL
                        }else{
                            $this->insertar_whatsaap('51950638955','MIGUEL',$mensaje,'');           //COMERCIAL
                        }
                    }    

                }






                DB::commit();
                return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobante-us/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();
            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


            //encontrar la orden de compra
            $fileordencompra            =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                            ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000001')
                                            ->where('COD_ESTADO','=','1')
                                            ->first();
            $rutafila                   =   "";
            $rutaorden                  =   "";

            if(count($fileordencompra)>0){
                $directorio = '\\\\10.1.0.201\cpe\Orden_Compra';
                // Nombre del archivo que estás buscando
                $nombreArchivoBuscado = $ordencompra->COD_ORDEN.'.pdf';
                // Escanea el directorio
                $archivose = scandir($directorio);
                // Inicializa una variable para almacenar el resultado
                $archivoEncontrado = false;
                // Recorre la lista de archivos
                foreach ($archivose as $archivo) {
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

                    
            $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('EXTENSION', 'like', '%'.'pdf'.'%')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->get();


            return View::make('comprobante/aprobaruc', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'documentohistorial'    =>  $documentohistorial,
                                'rutaorden'             =>  $rutaorden,
                                'archivospdf'           =>  $archivospdf,
                                'archivos'              =>  $archivos,
                                'tarchivos'             =>  $tarchivos,
                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



    public function actionAprobarUCContrato($idopcion,$linea , $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Aprobar  Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();

                $orden              =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$pedido_id)->first();  


                //******************************** guardar los contratos ***********************************//
                $rutaorden       =   $request['rutaorden'];
                if($rutaorden!=''){

                    $aoc                            =       CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000026'])
                                                            ->first();
                    $larchivos                      =       Archivo::get();
                    $nombrefilecdr                  =       count($larchivos).'-'.$ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
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
                /***GUARDAR CONTRATO SI SE CARGA***/
                $tarchivos            =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004','DCC0000000000002','DCC0000000000008'])
                                            //->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                            ->get();
                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $larchivos       =      Archivo::get();
                            $nombre          =      $ordencompra->COD_DOCUMENTO_CTBLE.'-'.$file->getClientOriginalName();
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

                        $larchivos                      =       Archivo::get();
                        $nombrefilecdr                  =       count($larchivos).'-'.$item->COD_DOCUMENTO_CTBLE.'.pdf';
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
                            $larchivos       =      Archivo::get();
                            $nombre          =      $item['COD_DOCUMENTO_CTBLE'].'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      count($larchivos).'-'.$file->getClientOriginalName();
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


                //$ordencompra        =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
                $ordencompra        =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();

                $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                        .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                        .'PROVEEDOR : '.$ordencompra->TXT_EMPR_EMISOR.'%0D%0A'
                                        .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';

                if(1==0){
                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                }else{


                    $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    $this->insertar_whatsaap('51979659002','HAMILTON',$mensaje,'');
                    $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                    //CONTABILIDAD
                    if($prefijocarperta=='II'){
                        $this->insertar_whatsaap('51965991360','ANGHIE',$mensaje,'');           //INTERNACIONAL
                    }else{
                        $this->insertar_whatsaap('51950638955','MIGUEL',$mensaje,'');           //COMERCIAL
                    }
                }


                DB::commit();
                return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobante-us/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tiposerie              =   '';
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            if($tiposerie == 'E'){
                $tarchivos_g            =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004','DCC0000000000002','DCC0000000000008'])
                                            ->get();

            }else{
                $tarchivos_g            =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004','DCC0000000000002','DCC0000000000008'])
                                            //->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
                                            ->get();
            }

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();




    

            //encontrar la orden de compra
            $fileordencompra            =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)
                                            ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000026')
                                            ->where('COD_ESTADO','=','1')
                                            ->first();

            $rutafila                   =   "";
            $rutaorden                  =   "";



            $ordencompra_f            =      CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$ordencompra->COD_DOCUMENTO_CTBLE)->first();

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


            if(count($fileordencompra)>0){
                $directorio = '\\\\10.1.0.201\cpe\Contratos';
                // Nombre del archivo que estás buscando
                $nombreArchivoBuscado = $ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
                // Escanea el directorio
                $archivos = scandir($directorio);
                //dd($ordencompra);
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

            //por ahora que le pida el cotrato
            //$rutaorden                  =   "";


            //todas las guias relacionadas
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

            $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('EXTENSION', 'like', '%'.'pdf'.'%')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            //dd($archivos);                          

            $procedencia ='ADM';

            return View::make('comprobante/aprobaruccontrato', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'documentohistorial'    =>  $documentohistorial,
                                'rutaorden'             =>  $rutaorden,
                                'archivospdf'           =>  $archivospdf,
                                'archivos'              =>  $archivos,
                                'tarchivos'             =>  $tarchivos,
                                'tarchivos_g'             =>  $tarchivos_g,
                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                                'lista_guias'           =>  $lista_guias,
                                'array_guias'           =>  $array_guias,
                                'procedencia'           =>  $procedencia,                                
                            ]);


        }
    }


}
