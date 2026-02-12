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
use App\Traits\AcopioTraits;

use Hashids;
use SplFileInfo;

class GestionOCAcopioController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;
    use AcopioTraits;


    public function actionListarComprobanteAcopio($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista comprobantes por aprobar acopio');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto
        $operacion_id       =   'LIQUIDACION_COMPRA_ANTICIPO';
        $tab_id             =   'oc';
        if(isset($request['operacion_id'])){
            $operacion_id       =   $request['operacion_id'];
        }
        if(Session::has('operacion_id')){
            $operacion_id           =   Session::get('operacion_id');
        }
        if(isset($request['tab_id'])){
            $tab_id             =   $request['tab_id'];
        }
        $combo_operacion    =   array(
                                        'DOCUMENTO_INTERNO_COMPRA' => 'DOCUMENTO INTERNO COMPRA',
                                        'LIQUIDACION_COMPRA_ANTICIPO' => 'LIQUIDACION DE COMPRA ANTICIPO'
                                    );
       $array_canjes               =   $this->con_array_canjes();     
        if($operacion_id=='LIQUIDACION_COMPRA_ANTICIPO'){
            $listadatos         =   $this->aco_lista_cabecera_comprobante_total_acopio_liquidacion_compra_anticipo($cod_empresa);
            $listadatos_obs     =   $this->aco_lista_cabecera_comprobante_total_acopio_liquidacion_compra_anticipo_obs($cod_empresa);
            $listadatos_obs_le  =   $this->aco_lista_cabecera_comprobante_total_acopio_liquidacion_compra_anticipo_obs_levantadas($cod_empresa);
        }else{
            if (in_array($operacion_id, $array_canjes)) {
                $categoria_id       =   $this->con_categoria_canje($operacion_id);
                $listadatos         =   $this->aco_lista_cabecera_comprobante_total_acopio_estiba($cod_empresa,$operacion_id);
                $listadatos_obs     =   $this->aco_lista_cabecera_comprobante_total_acopio_estiba_obs($cod_empresa,$operacion_id);
                $listadatos_obs_le  =   $this->aco_lista_cabecera_comprobante_total_acopio_estiba_obs_levantadas($cod_empresa,$operacion_id);
            }
        }

        $funcion        =   $this;
        return View::make('acopio/listaacopiocompras',
                         [
                            'listadatos'        =>  $listadatos,
                            'listadatos_obs'    =>  $listadatos_obs,
                            'listadatos_obs_le' =>  $listadatos_obs_le,
                            'tab_id'            =>  $tab_id,
                            'funcion'           =>  $funcion,
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }


    public function actionListarAjaxBuscarDocumentoAcopio(Request $request) {

        $operacion_id   =   $request['operacion_id'];
        $idopcion       =   $request['idopcion'];

        $tab_id             =   'oc';

        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        if($operacion_id=='LIQUIDACION_COMPRA_ANTICIPO'){
            $listadatos         =   $this->aco_lista_cabecera_comprobante_total_acopio_liquidacion_compra_anticipo($cod_empresa);                    
            $listadatos_obs     =   $this->aco_lista_cabecera_comprobante_total_acopio_liquidacion_compra_anticipo_obs($cod_empresa);
            $listadatos_obs_le  =   $this->aco_lista_cabecera_comprobante_total_acopio_liquidacion_compra_anticipo_obs_levantadas($cod_empresa);
        }else{
            
            $listadatos         =   $this->aco_lista_cabecera_comprobante_total_acopio_estiba($cod_empresa,$operacion_id);
            $listadatos_obs     =   $this->aco_lista_cabecera_comprobante_total_acopio_estiba_obs($cod_empresa,$operacion_id);
            $listadatos_obs_le  =   $this->aco_lista_cabecera_comprobante_total_acopio_estiba_obs_levantadas($cod_empresa,$operacion_id);
        }
   
        $procedencia        =   'CONT';
        $funcion                =   $this;
        return View::make('acopio/ajax/mergelistaareaacopio',
                         [
                            'operacion_id'          =>  $operacion_id,
                            'tab_id'          =>  $tab_id,

                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'listadatos_obs'    =>  $listadatos_obs,
                            'listadatos_obs_le'    =>  $listadatos_obs_le,
                            
                            'procedencia'           =>  $procedencia,
                            'ajax'                  =>  true,

                            'funcion'               =>  $funcion
                         ]);
    }



    public function actionAprobarAcopioLiquidacionCompraAnticipo($idopcion, $linea,$prefijo, $idordenpago,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idop                   =   $this->funciones->decodificarmaestraprefijo($idordenpago,$prefijo);        
        $ordenpago              =   $this->con_lista_comprobante_orden_pago_idoc_actual($idop);

        $idoc                   =   $ordenpago->COD_DOCUMENTO_CTBLE;
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);
        
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Aprobar  Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();


                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$linea)->first();

                if($fedocumento->ind_observacion==1){
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }


                $descripcion        =   $request['descripcion'];
                if(rtrim(ltrim($descripcion)) != ''){
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'RECOMENDACION POR JEFE DE ACOPIO';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();
                }




                $filespdf          =   $request['otros'];
                if(!is_null($filespdf)){
                    //PDF
                    foreach($filespdf as $file){

                            //
                            $contadorArchivos = Archivo::count();
                        
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta =      $this->prefijo_empresa($ordenpago->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordenpago->NRO_DOC;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefilepdf;
                        copy($file->getRealPath(),$rutacompleta);
                        $path            =      $rutacompleta;

                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();

                        $dcontrol                   =   new Archivo;
                        $dcontrol->ID_DOCUMENTO     =   $ordenpago->COD_AUTORIZACION;
                        $dcontrol->DOCUMENTO_ITEM   =   $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO     =   'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO   =   $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'OTROS JEFE ACOPIO';
                        $dcontrol->URL_ARCHIVO      =   $path;
                        $dcontrol->SIZE             =   filesize($file);
                        $dcontrol->EXTENSION        =   $extension;
                        $dcontrol->ACTIVO           =   1;
                        $dcontrol->FECHA_CREA       =   $this->fechaactual;
                        $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                        $dcontrol->save();                        
                    }
                }

                FeDocumento::where('ID_DOCUMENTO',$idop)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000004',
                                    'TXT_ESTADO'=>'POR APROBAR ADMINISTRACION',
                                    'IND_EMAIL_ADMINISTRACION_ACOPIO'=>0,
                                    'ind_email_clap'=>0,
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
                $documento->TIPO                        =   'APROBADO POR JEFE DE ACOPIO';
                $documento->MENSAJE                     =   '';
                $documento->save();                

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'APROBADO POR JEFE ACOPIO');
                //geolocalización

                DB::commit();

                Session::flash('operacion_id', 'LIQUIDACION_COMPRA_ANTICIPO');
                return Redirect::to('/gestion-de-acopio-liquidacion-compra/'.$idopcion)->with('bienhecho', 'Comprobante : '.$idoc.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                Session::flash('operacion_id', 'LIQUIDACION_COMPRA_ANTICIPO');
                return Redirect::to('gestion-de-acopio-liquidacion-compra/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idop)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   $this->lista_archivos_total($idop,$fedocumento->DOCUMENTO_ITEM);
            $archivospdf            =   $this->lista_archivos_total_pdf($idop,$fedocumento->DOCUMENTO_ITEM);


            $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idop)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();            

            if($fedocumento->TXT_INGRESO_LIQ=='SI'){
                $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                            ->where('COD_ESTADO','=',1)                                        
                                            ->whereIn('COD_CATEGORIA', ['DCC0000000000039','DCC0000000000040','DCC0000000000041','DCC0000000000044','DCC0000000000045'])
                                            ->get();                
            }else{
                if($ordenpago->COD_CENTRO == 'CEN0000000000004' || $ordenpago->COD_CENTRO == 'CEN0000000000006'){ //rioja o bellavista
                    $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                ->where('COD_ESTADO','=',1)                                        
                                                ->whereIn('COD_CATEGORIA', ['DCC0000000000041','DCC0000000000044','DCC0000000000045','DCC0000000000046'])
                                                ->get();                
                }else{
                    $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                ->where('COD_ESTADO','=',1)                                        
                                                ->whereIn('COD_CATEGORIA', ['DCC0000000000041','DCC0000000000044','DCC0000000000045'])
                                                ->get();
                }                
            }            

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idop)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();
            
            //Archivo multiple


            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-fileliquidacioncompraanticipo', ['file' => $archivo->NOMBRE_ARCHIVO]);
            }
            $initialPreviewConfig = [];
            foreach ($archivospdf as $key => $archivo) {
                $initialPreviewConfig[] = [
                    'type'          => "pdf",
                    'caption' => $archivo->NOMBRE_ARCHIVO,
                    'downloadUrl' => route('serve-fileliquidacioncompraanticipo', ['file' => $archivo->NOMBRE_ARCHIVO])
                ];
            }


            return View::make('acopio/aprobaracopioliquidacioncompraanticipo', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordenpago'             =>  $ordenpago,
                                'ordencompra'           =>  $ordencompra,                                
                                'initialPreview'        => json_encode($initialPreview),
                                'initialPreviewConfig'  => json_encode($initialPreviewConfig),


                                'linea'                 =>  $linea,
                                'archivos'              =>  $archivos,
                                'archivosanulados'      =>  $archivosanulados,                                

                                'trabajador'            =>  $trabajador,
                                'documentoscompra'      =>  $documentoscompra,
                                'totalarchivos'         =>  $totalarchivos,


                                'documentohistorial'    =>  $documentohistorial,
                                'archivospdf'           =>  $archivospdf,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'tarchivos'             =>  $tarchivos,
                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



    public function actionAgregarObservacionAcopioLiquidacionCompraAnticipo($idopcion, $linea, $prefijo, $idordenpago,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idop                   =   $this->funciones->decodificarmaestraprefijo($idordenpago,$prefijo);        
        $ordenpago              =   $this->con_lista_comprobante_orden_pago_idoc_actual($idop);

        $idoc                   =   $ordenpago->COD_DOCUMENTO_CTBLE;

        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);    

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Observar Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();
                $descripcion        =   $request['descripcion'];
                $archivoob          =   $request['archivoob'];

                if($fedocumento->ind_observacion==1){
                    DB::rollback(); 
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }

                if(count($archivoob)<=0){
                    DB::rollback(); 
                    return Redirect::to('aprobar-comprobante-acopio-liquidacion-compra-anticipo/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordenpago)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }

                foreach($archivoob as $index=>$item){


                    $docu_asoci                             =    CMPDocAsociarCompra::where('COD_ORDEN','=',$idop)->where('COD_ESTADO','=',1)
                                                                ->where('COD_CATEGORIA_DOCUMENTO','=',$item)->first();
                    if(count($docu_asoci)>0){

                        Archivo::where('ID_DOCUMENTO','=',$idop)
                                ->where('ACTIVO','=','1')
                                ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                ->where('TIPO_ARCHIVO','=',$item)
                                    ->update(
                                        [
                                            'ACTIVO'=>0,
                                            'FECHA_MOD'=>$this->fechaactual,
                                            'USUARIO_MOD'=>Session::get('usuario')->id
                                        ]
                                    );

                    }else{

                        $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item)->first();
                        $docasociar                              =   New CMPDocAsociarCompra;
                        $docasociar->COD_ORDEN                   =   $idop;
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

                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'OBSERVADO POR JEFE ACOPIO';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'OBSERVADO POR JEFE ACOPIO');
                //geolocalización



                FeDocumento::where('ID_DOCUMENTO',$idop)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'ind_observacion'=>1,
                                    'TXT_OBSERVADO'=>'OBSERVADO',
                                    'area_observacion'=>'CONT'
                                ]
                            );

                DB::commit();

                Session::flash('operacion_id', 'LIQUIDACION_COMPRA_ANTICIPO');

                return Redirect::to('/gestion-de-acopio-liquidacion-compra/'.$idopcion)->with('bienhecho', 'Comprobante : '.$idop.' OBSERVADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 

                Session::flash('operacion_id', 'LIQUIDACION_COMPRA_ANTICIPO');

                return Redirect::to('gestion-de-acopio-liquidacion-compra/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        
        }
    }



    public function actionAprobarAcopioEstiba($idopcion, $lote,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $lote;

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Aprobar  Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();


                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();

                if($fedocumento->ind_observacion==1){
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede aprobar');
                }


                $descripcion        =   $request['descripcion'];
                if(rtrim(ltrim($descripcion)) != ''){
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'RECOMENDACION POR JEFE DE ACOPIO';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save(); 
                }


                $filespdf          =   $request['otros'];
                if(!is_null($filespdf)){
                    //PDF
                    foreach($filespdf as $file){

                        //
                        $contadorArchivos = Archivo::count();
                        $nombre          =      $idoc.'-'.$file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$idoc;
                        //$nombrefilepdf   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        $nombrefilepdf   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefilepdf;
                        copy($file->getRealPath(),$rutacompleta);
                        $path            =      $rutacompleta;

                        $nombreoriginal             =   $file->getClientOriginalName();
                        $info                       =   new SplFileInfo($nombreoriginal);
                        $extension                  =   $info->getExtension();

                        $dcontrol                   =   new Archivo;
                        $dcontrol->ID_DOCUMENTO     =   $idoc;
                        $dcontrol->DOCUMENTO_ITEM   =   $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO     =   'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO   =   $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'OTROS JEFE DE ACOPIO';
                        $dcontrol->URL_ARCHIVO      =   $path;
                        $dcontrol->SIZE             =   filesize($file);
                        $dcontrol->EXTENSION        =   $extension;
                        $dcontrol->ACTIVO           =   1;
                        $dcontrol->FECHA_CREA       =   $this->fechaactual;
                        $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                        $dcontrol->save();
                        //dd($nombre);
                    }
                }


                FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000004',
                                    'TXT_ESTADO'=>'POR APROBAR ADMINISTRACION',
                                    'IND_EMAIL_ADMINISTRACION_ACOPIO'=>0,
                                    'ind_email_clap'=>0,
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
                $documento->TIPO                        =   'APROBADO POR JEFE DE ACOPIO';
                $documento->MENSAJE                     =   '';
                $documento->save();
 
                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'APROBADO POR JEFE ACOPIO');
                //geolocalización


                DB::commit();

                Session::flash('operacion_id', $request['operacion_id']);
                return Redirect::to('/gestion-de-acopio-liquidacion-compra/'.$idopcion)->with('bienhecho', 'Comprobante : '.$pedido_id.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                Session::flash('operacion_id', $request['operacion_id']);
                return Redirect::to('/gestion-de-acopio-liquidacion-compra/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();
            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();
            $archivos               =   $this->lista_archivos_total($idoc,$fedocumento->DOCUMENTO_ITEM);
            $archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);
            $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
            $codigo_sunat           =   'N';
            $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->where('COD_ESTADO','=',1)
                                        ->where('CODIGO_SUNAT','=',$codigo_sunat)
                                        ->whereNotIn('COD_CATEGORIA',['DCC0000000000003','DCC0000000000004'])
                                        ->get();
            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();

            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-fileestiba', ['file' => $archivo->NOMBRE_ARCHIVO]);
            }
            $initialPreviewConfig = [];
            foreach ($archivospdf as $key => $archivo) {
                $initialPreviewConfig[] = [
                    'type'          => "pdf",
                    'caption' => $archivo->NOMBRE_ARCHIVO,
                    'downloadUrl' => route('serve-fileestiba', ['file' => $archivo->NOMBRE_ARCHIVO])
                ];
            }

            $fereftop1              =   FeRefAsoc::where('lote','=',$idoc)->first();

            $lotes                  =   FeRefAsoc::where('lote','=',$idoc)                                        
                                        ->pluck('ID_DOCUMENTO')
                                        ->toArray();
            $documento_asociados    =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->get();
            $documento_top          =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->first();
            $funciones = $this;

            return View::make('acopio/aprobaracopioestiba', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'fereftop1'             =>  $fereftop1,
                                'initialPreview'        =>  json_encode($initialPreview),
                                'initialPreviewConfig'  =>  json_encode($initialPreviewConfig),
                                'archivos'              =>  $archivos,
                                'archivosanulados'      =>  $archivosanulados,
                                'trabajador'            =>  $trabajador,
                                'documento_asociados'   =>  $documento_asociados,
                                'documento_top'         =>  $documento_top,

                                'documentoscompra'      =>  $documentoscompra,
                                'totalarchivos'         =>  $totalarchivos,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivospdf'           =>  $archivospdf,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'tarchivos'             =>  $tarchivos,
                                'lote'                  =>  $idoc,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                                'funciones' => $funciones,
                                'funcion' => $funciones,
                                
                            ]);


        }
    }


    public function actionAgregarObservacionAcopioEstiba($idopcion, $lote,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $lote;
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('TXT_PROCEDENCIA','<>','SUE')->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Observar Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('TXT_PROCEDENCIA','<>','SUE')->first();
                $descripcion        =   $request['descripcion'];
                $archivoob          =   $request['archivoob'];

                if($fedocumento->ind_observacion==1){
                    DB::rollback(); 
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }

                if(count($archivoob)<=0){
                    DB::rollback(); 
                    return Redirect::to('aprobar-comprobante-acopio-estiba/'.$idopcion.'/'.$idoc)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }

                foreach($archivoob as $index=>$item){

                    $docu_asoci                             =    CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)                                                                ->where('COD_CATEGORIA_DOCUMENTO','=',$item)->first();
                    if(count($docu_asoci)>0){

                        Archivo::where('ID_DOCUMENTO','=',$idoc)
                                ->where('ACTIVO','=','1')
                                ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                ->where('TIPO_ARCHIVO','=',$item)
                                    ->update(
                                        [
                                            'ACTIVO'=>0,
                                            'FECHA_MOD'=>$this->fechaactual,
                                            'USUARIO_MOD'=>Session::get('usuario')->id
                                        ]
                                    );

                    }else{

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

                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'OBSERVADO POR JEFE ACOPIO';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'OBSERVADO POR JEFE ACOPIO');
                //geolocalización



                FeDocumento::where('ID_DOCUMENTO',$idoc)
                            ->update(
                                [
                                    'ind_observacion'=>1,
                                    'TXT_OBSERVADO'=>'OBSERVADO',
                                    'area_observacion'=>'CONT'
                                ]
                            );

                DB::commit();

                Session::flash('operacion_id', $request['operacion_id']);

                return Redirect::to('/gestion-de-acopio-liquidacion-compra/'.$idopcion)->with('bienhecho', 'Comprobante : '.$idoc.' OBSERVADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 

                Session::flash('operacion_id', $request['operacion_id']);

                return Redirect::to('gestion-de-acopio-liquidacion-compra/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        
        }

    }



}
