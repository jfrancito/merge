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


use Hashids;
use SplFileInfo;

class GestionOCAdministracionController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;
    
    public function actionListarComprobanteAdministracion($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista comprobantes por aprobar administracion');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto
        $operacion_id       =   'ORDEN_COMPRA';
        $tab_id             =   'oc';
        //dd($request['operacion_id']);

        if(isset($request['operacion_id'])){
            $operacion_id       =   $request['operacion_id'];
        }
        if(Session::has('operacion_id')){
            $operacion_id           =   Session::get('operacion_id');
        }
        if(isset($request['tab_id'])){
            $tab_id             =   $request['tab_id'];
        }


        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO','ESTIBA' => 'ESTIBA');

        $combo_operacion    =   array(  'ORDEN_COMPRA' => 'ORDEN COMPRA',
                                        'CONTRATO' => 'CONTRATO',
                                        'ESTIBA' => 'ESTIBA',
                                        'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
                                        'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
                                        'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA'
                                    );

       $array_canjes               =   $this->con_array_canjes();
        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_adm($cod_empresa);
            $listadatos_obs     =   $this->con_lista_cabecera_comprobante_total_adm_obs($cod_empresa);
            $listadatos_obs_le  =   $this->con_lista_cabecera_comprobante_total_adm_obs_levantadas($cod_empresa);
        }else{

            if($operacion_id=='CONTRATO'){
                $listadatos         =   $this->con_lista_cabecera_comprobante_total_adm_contrato($cod_empresa);
                $listadatos_obs     =   $this->con_lista_cabecera_comprobante_total_adm_contrato_obs($cod_empresa);
                $listadatos_obs_le  =   $this->con_lista_cabecera_comprobante_total_adm_contrato_obs_levantadas($cod_empresa);
            }else{
                
                if (in_array($operacion_id, $array_canjes)) {
                    $categoria_id       =   $this->con_categoria_canje($operacion_id);
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_adm_estiba($cod_empresa,$operacion_id);
                    $listadatos_obs     =   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs($cod_empresa,$operacion_id);
                    $listadatos_obs_le  =   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs_levantadas($cod_empresa,$operacion_id);
                }


            }

        }

        $funcion        =   $this;
        return View::make('comprobante/listaadministracion',
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

    public function actionListarAjaxBuscarDocumentoAdministracion(Request $request) {

        $operacion_id   =   $request['operacion_id'];
        $idopcion       =   $request['idopcion'];

        $tab_id             =   'oc';

        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_adm($cod_empresa);
            $listadatos_obs     =   $this->con_lista_cabecera_comprobante_total_adm_obs($cod_empresa);
            $listadatos_obs_le  =   $this->con_lista_cabecera_comprobante_total_adm_obs_levantadas($cod_empresa);


        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos         =   $this->con_lista_cabecera_comprobante_total_adm_contrato($cod_empresa);
                $listadatos_obs     =   $this->con_lista_cabecera_comprobante_total_adm_contrato_obs($cod_empresa);
                $listadatos_obs_le  =   $this->con_lista_cabecera_comprobante_total_adm_contrato_obs_levantadas($cod_empresa);
            }else{
                
                $listadatos         =   $this->con_lista_cabecera_comprobante_total_adm_estiba($cod_empresa,$operacion_id);
                $listadatos_obs     =   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs($cod_empresa,$operacion_id);
                $listadatos_obs_le  =   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs_levantadas($cod_empresa,$operacion_id);
            }
        }
        //dd($listadatos);

        $procedencia        =   'ADM';
        $funcion                =   $this;
        return View::make('comprobante/ajax/mergelistaareaadministracion',
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




    public function actionAgregarObservacionAdministracion($idopcion, $linea, $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Observar Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();
                $descripcion        =   $request['descripcion'];
                $archivoob          =   $request['archivoob'];


                if($fedocumento->ind_observacion==1){
                    DB::rollback(); 
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }

                if(count($archivoob)<=0){
                    DB::rollback(); 
                    return Redirect::to('aprobar-comprobante-administracion/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }

                foreach($archivoob as $index=>$item){


                    $docu_asoci                             =    CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                                ->where('COD_CATEGORIA_DOCUMENTO','=',$item)->first();
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
                $documento->TIPO                        =   'OBSERVADO POR ADMINISTRACION';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'ind_observacion'=>1,
                                    'TXT_OBSERVADO'=>'OBSERVADO',
                                    'area_observacion'=>'ADM'
                                ]
                            );

                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE OBSERVADO: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'MENSAJE : '.$descripcion.'%0D%0A';

                // //dd($trabajador);                        
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                // }  

                DB::commit();
                return Redirect::to('/gestion-de-administracion-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' OBSERVADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        
        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if($fedocumento->ind_observacion == 1){

                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();


            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();
            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();

            $codigo_sunat           =   'I';
            if($ordencompra_t->IND_VARIAS_ENTREGAS==0){
                $codigo_sunat           =   'N';
            }

            $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->where('COD_ESTADO','=',1)
                                        ->where('CODIGO_SUNAT','=',$codigo_sunat)
                                        ->whereNotIn('COD_CATEGORIA',['DCC0000000000003','DCC0000000000004'])
                                        ->get();

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();

            //dd($totalarchivos);
            //dd($documentoscompra);
                                        
            return View::make('comprobante/observaradministracion', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'documentoscompra'      =>  $documentoscompra,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'tarchivos'             =>  $tarchivos,
                                'totalarchivos'         =>  $totalarchivos,
                                'trabajador'            =>  $trabajador,

                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



    public function actionAgregarObservacionAdministracionContrato($idopcion, $linea, $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Observar Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();
                $descripcion        =   $request['descripcion'];
                $archivoob          =   $request['archivoob'];



                if($fedocumento->ind_observacion==1){
                    DB::rollback(); 
                    return Redirect::back()->with('errorurl', 'El documento esta observado no se puede observar');
                }

                if(count($archivoob)<=0){
                    DB::rollback(); 
                    return Redirect::to('aprobar-comprobante-administracion/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
                }

                foreach($archivoob as $index=>$item){


                    $docu_asoci                             =    CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                                ->where('COD_CATEGORIA_DOCUMENTO','=',$item)->first();
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
                $documento->TIPO                        =   'OBSERVADO POR ADMINISTRACION';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'ind_observacion'=>1,
                                    'TXT_OBSERVADO'=>'OBSERVADO',
                                    'area_observacion'=>'ADM'
                                ]
                            );

                //LE LLEGA AL USUARIO DE CONTACTO
               // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
               //  $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
               //  $mensaje            =   'COMPROBANTE OBSERVADO: '.$fedocumento->ID_DOCUMENTO
               //                          .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
               //                          .'PROVEEDOR : '.$ordencompra->TXT_EMPR_EMISOR.'%0D%0A'
               //                          .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
               //                          .'MENSAJE : '.$descripcion.'%0D%0A'; 

                //dd($trabajador);                        
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                // }  

                DB::commit();

                Session::flash('operacion_id', 'CONTRATO');

                return Redirect::to('/gestion-de-administracion-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' OBSERVADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 

                Session::flash('operacion_id', 'CONTRATO');

                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        
        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if($fedocumento->ind_observacion == 1){

                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();


            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   $this->lista_archivos_total($idoc,$fedocumento->DOCUMENTO_ITEM);
            //$archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);


            $codigo_sunat           =   'N';
            $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->where('COD_ESTADO','=',1)
                                        ->where('CODIGO_SUNAT','=',$codigo_sunat)
                                        ->whereNotIn('COD_CATEGORIA',['DCC0000000000003','DCC0000000000004'])
                                        ->get();

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();

                                        
            return View::make('comprobante/observaradministracioncontrato', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'documentoscompra'      =>  $documentoscompra,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'tarchivos'             =>  $tarchivos,
                                'totalarchivos'         =>  $totalarchivos,
                                'trabajador'            =>  $trabajador,

                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }

    public function actionAgregarObservacionAdministracionEstiba($idopcion, $lote,Request $request)
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
                    return Redirect::to('aprobar-comprobante-administracion/'.$idopcion.'/'.$idoc)->with('errorbd', 'Tiene que seleccionar almenos un item');
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
                $documento->TIPO                        =   'OBSERVADO POR ADMINISTRACION';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                FeDocumento::where('ID_DOCUMENTO',$idoc)
                            ->update(
                                [
                                    'ind_observacion'=>1,
                                    'TXT_OBSERVADO'=>'OBSERVADO',
                                    'area_observacion'=>'ADM'
                                ]
                            );

                //LE LLEGA AL USUARIO DE CONTACTO
                // $empresa_anti       =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();

                // $mensaje            =   'COMPROBANTE OBSERVADO: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.Session::get('empresas')->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$empresa_anti->NOM_EMPR.'%0D%0A'
                //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                //                         .'MENSAJE : '.$descripcion.'%0D%0A';

                //dd($trabajador);                        
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                // }  

                DB::commit();

                Session::flash('operacion_id', $request['operacion_id']);

                return Redirect::to('/gestion-de-administracion-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$idoc.' OBSERVADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 

                Session::flash('operacion_id', $request['operacion_id']);

                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        
        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            if($fedocumento->ind_observacion == 1){

                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', 'Existen Observaciones pendientes por atender');
            }

            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();


            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   $this->lista_archivos_total($idoc,$fedocumento->DOCUMENTO_ITEM);
            //$archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);


            $codigo_sunat           =   'N';
            $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->where('COD_ESTADO','=',1)
                                        ->where('CODIGO_SUNAT','=',$codigo_sunat)
                                        ->whereNotIn('COD_CATEGORIA',['DCC0000000000003','DCC0000000000004'])
                                        ->get();

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();

                                        
            return View::make('comprobante/observaradministracioncontrato', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'documentoscompra'      =>  $documentoscompra,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'tarchivos'             =>  $tarchivos,
                                'totalarchivos'         =>  $totalarchivos,
                                'trabajador'            =>  $trabajador,

                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }


    public function actionModificarContratos($idopcion, $linea, $prefijo, $idordencompra,Request $request)
    {

            try{    
                
                DB::beginTransaction();
                $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
                $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
                $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
                $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();
                $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


                $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                            ->where('TIPO_ARCHIVO','like','%GRR%')
                                            ->get();

                //dd($archivos);

                $sourceFile             =   '\\\\10.1.0.201\\cpe\\Contratos';

                foreach ($archivos as $item) {
                    $filePath = $sourceFile . '\\' . $item->TIPO_ARCHIVO.'.pdf';  // Asumiendo que tienes un campo NOMBRE_ARCHIVO

                    // Verificar si el archivo existe en la ruta original
                    if (file_exists($filePath)) {
                        // Mover el archivo a la nueva ruta
                        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $newFilePath            =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $newFilePath            =   $newFilePath.'\\'.$item->NOMBRE_ARCHIVO;

                        //dd($newFilePath);
                        if (copy($filePath, $newFilePath)) {
                            print_r("e movio correctaente");
                        } else {
                            // Manejo de errores si la operación de renombrar/mover falla
                            dd("Error al mover el archivo: " . $item->NOMBRE_ARCHIVO);
                        }
                    } else {
                        // El archivo no existe en la ruta original
                        dd("Archivo no encontrado: " . $filePath);
                    }
                }

                FeDocumento::where('ID_DOCUMENTO','=',$idoc)
                            ->update(
                                    [
                                        'ind_observacion'=>0,
                                    ]);

                DB::commit();
                return Redirect::to('/detalle-comprobante-oc-validado-contrato/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'PDF ACTUALIZADO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/detalle-comprobante-oc-validado-contrato/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        
        

    }





    public function actionAgregarRecomendacionAdministracion($idopcion, $linea, $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Recomendacion del Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();

                $descripcion        =   $request['descripcion'];

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'RECOMENDACION POR ADMINISTRACION';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'RECOMENDACION : '.$descripcion.'%0D%0A';

                //dd($trabajador);                        
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                // }  
                DB::commit();
                return Redirect::to('/gestion-de-administracion-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' RECOMENDACION CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();
            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();
            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
            $codigo_sunat           =   'I';
            if($ordencompra_t->IND_VARIAS_ENTREGAS==0){
                $codigo_sunat           =   'N';
            }
            $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->where('COD_ESTADO','=',1)
                                        ->where('CODIGO_SUNAT','=',$codigo_sunat)
                                        ->whereNotIn('COD_CATEGORIA',['DCC0000000000003','DCC0000000000004'])
                                        ->get();
            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();
     
            return View::make('comprobante/recomendacionadministracion', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'documentoscompra'      =>  $documentoscompra,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'tarchivos'             =>  $tarchivos,
                                'totalarchivos'         =>  $totalarchivos,
                                'trabajador'            =>  $trabajador,

                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }

    public function actionAgregarRecomendacionAdministracionContrato($idopcion, $linea, $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Recomendacion del Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->where('TXT_PROCEDENCIA','<>','SUE')->first();

                $descripcion        =   $request['descripcion'];

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'RECOMENDACION POR ADMINISTRACION';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                // //LE LLEGA AL USUARIO DE CONTACTO
                // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                // $mensaje            =   'COMPROBANTE: '.$fedocumento->ID_DOCUMENTO
                //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                //                         .'RECOMENDACION : '.$descripcion.'%0D%0A';

                // //dd($trabajador);                        
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                // }  
                DB::commit();
                Session::flash('operacion_id', 'CONTRATO');

                return Redirect::to('/gestion-de-administracion-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' RECOMENDACION CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                Session::flash('operacion_id', 'CONTRATO');
                
                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
        else{

            //$detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();
            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();
            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();
     
            return View::make('comprobante/recomendacionadministracioncontrato', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'tarchivos'             =>  $tarchivos,
                                'totalarchivos'         =>  $totalarchivos,
                                'trabajador'            =>  $trabajador,

                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



    public function actionListarAprobarAdministracion($idopcion,Request $request)
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
                if($fedocumento->COD_ESTADO == 'ETM0000000000004'){ 


                    $orden                      =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();
                    CMPOrden::where('COD_ORDEN','=',$orden->COD_ORDEN)
                                ->update(
                                        [
                                            'COD_OPERACION'=>1
                                        ]);


                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'APROBADO POR ADMINISTRACION';
                    $documento->MENSAJE                     =   '';
                    $documento->save();

                    // //HISTORIAL DE DOCUMENTO APROBADO
                    // $documento                              =   new FeDocumentoHistorial;
                    // $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    // $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    // $documento->FECHA                       =   $this->fechaactual;
                    // $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    // $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    // $documento->TIPO                        =   'PROVISIONADO';
                    // $documento->MENSAJE                     =   '';
                    // $documento->save();

                    //whatsaap para administracion
                    // $trabajador         =   STDTrabajador::where('COD_TRAB','=',$fedocumento->COD_CONTACTO)->first();
                    $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();
                    // $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();  
                    // $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();
                    // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                    // $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                    //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                    //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                    //                         .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';

                    // $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    // $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');

                    $msjarray[]                             =   array(  "data_0" => $fedocumento->ID_DOCUMENTO, 
                                                                        "data_1" => 'Comprobante Aprobado', 
                                                                        "tipo" => 'S');
                    $conts                                  =   $conts + 1;
                    $codigo                                 =   $fedocumento->ID_DOCUMENTO;

                }else{
                    /**** ERROR DE PROGRMACION O SINTAXIS ****/
                    $msjarray[] = array("data_0" => $fedocumento->ID_DOCUMENTO, 
                                        "data_1" => 'este comprobante ya esta Aprobado', 
                                        "tipo" => 'D');
                    $contd      =   $contd + 1;

                }

            }


            /************** MENSAJES DEL DETALLE PEDIDO  ******************/
            $msjarray[] = array("data_0" => $conts, 
                                "data_1" => 'Comprobantes Aprobado', 
                                "tipo" => 'TS');

            $msjarray[] = array("data_0" => $contw, 
                                "data_1" => 'Comprobantes Aprobado', 
                                "tipo" => 'TW');     

            $msjarray[] = array("data_0" => $contd, 
                                "data_1" => 'Comprobantes errados', 
                                "tipo" => 'TD');

            $msjjson = json_encode($msjarray);


            return Redirect::to('/gestion-de-administracion-aprobar/'.$idopcion)->with('xmlmsj', $msjjson);

        
        }
    }


     public function actionExtornarAprobar($idopcion, $linea,$prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
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
            $documento->TIPO                        =   'RECHAZADO POR ADMINISTRACION';
            $documento->MENSAJE                     =   '';
            $documento->save();

            return Redirect::to('/gestion-de-administracion-aprobar/'.$idopcion)->with('bienhecho', 'Comprobantes Lote: '.$ordencompra->COD_ORDEN.' EXTORNADA con EXITO');
        
        }
        else{

                  
            return View::make('comprobante/extornaradministracion', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }


    public function actionModalDetalleDocumento(Request $request)
    {

        $data_doc               =   $request['data_doc'];
        $orden                  =   CMPOrden::where('COD_ORDEN','=',$data_doc)->first();
        $conexionbd             = 'sqlsrv';
        if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
            $conexionbd         = 'sqlsrv_r';
        }else{
            if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                $conexionbd         = 'sqlsrv_b';
            }
        }

        $detalledocumento = CMPDetalleProducto::on($conexionbd)
            ->where('COD_TABLA', '=', $data_doc)
            ->where('COD_ESTADO', '=', 1)
            ->get();

        $funcion        =   $this;
        return View::make('comprobante/modal/ajax/mdetalledocumento',
                         [
                            'detalledocumento'          =>  $detalledocumento,
                            'data_doc'                  =>  $data_doc,
                            'ajax'                      =>  true,
                         ]);


    }





    public function actionAprobarAdministracion($idopcion, $linea,$prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Aprobar  Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();

                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();
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
                    $documento->TIPO                        =   'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();
                    //LE LLEGA AL USUARIO DE CONTACTO
                    // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                    // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                    // $mensaje            =   'COMPROBANTE: '.$fedocumento->ID_DOCUMENTO
                    //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                    //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_EMISOR.'%0D%0A'
                    //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                    //                         .'RECOMENDACION : '.$descripcion.'%0D%0A';
                    // //dd($trabajador);                        
                    // if(1==0){
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    // }else{
                    //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                    // }  

                }

                $filespdf          =   $request['otros'];
                if(!is_null($filespdf)){
                    //PDF
                    foreach($filespdf as $file){

                            //
                            $contadorArchivos = Archivo::count();

                        $nombre          =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
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
                        $dcontrol->ID_DOCUMENTO     =   $ordencompra->COD_ORDEN;
                        $dcontrol->DOCUMENTO_ITEM   =   $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO     =   'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO   =   $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'OTROS ADMINISTRACION';
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


                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000005',
                                    'TXT_ESTADO'=>'APROBADO',
                                    'ind_email_clap'=>0,
                                    'fecha_ap'=>$this->fechaactual,
                                    'usuario_ap'=>Session::get('usuario')->id
                                ]
                            );

                $orden                      =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();
                $detalleproducto            =   CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO','=',1)
                                                ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$pedido_id)
                                                ->orderBy('NRO_LINEA','ASC')
                                                ->get();

                $conexionbd         = 'sqlsrv';
                if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
                    $conexionbd         = 'sqlsrv_r';
                }else{
                    if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                        $conexionbd         = 'sqlsrv_b';
                    }
                }

                DB::connection($conexionbd)->table('CMP.ORDEN')
                    ->where('COD_ORDEN', $orden->COD_ORDEN)
                    ->update(['COD_OPERACION' => 1,'FEC_USUARIO_MODIF_AUD'=>$this->hoy]);


                //enviar tablas de fe_documento y fe_detalledocuemto
                if($orden->COD_CENTRO == 'CEN0000000000004' || $orden->COD_CENTRO == 'CEN0000000000006'){ //rioja
                    //dd($conexionbd);
                    //FE_DOCUENTO
                    $referenciaAsocQuery = FeDocumento::select('ID_DOCUMENTO'
                                              ,'DOCUMENTO_ITEM'
                                              ,'RUC_PROVEEDOR'
                                              ,'RZ_PROVEEDOR'
                                              ,'TIPO_CLIENTE'
                                              ,'ID_CLIENTE'
                                              ,'NOMBRE_CLIENTE'
                                              ,'DIRECCION_CLIENTE'
                                              ,'NUM_DOC_VENTA'
                                              ,'SERIE'
                                              ,'NUMERO'
                                              ,'ID_TIPO_DOC'
                                              ,'FEC_VENTA'
                                              ,'FEC_VENCI_PAGO'
                                              ,'FORMA_PAGO'
                                              ,'FORMA_PAGO_DIAS'
                                              ,'MONEDA'
                                              ,'VALOR_TIPO_CAMBIO'
                                              ,'VALOR_IGV_ORIG'
                                              ,'VALOR_IGV_SOLES'
                                              ,'SUB_TOTAL_VENTA_ORIG'
                                              ,'SUB_TOTAL_VENTA_SOLES'
                                              ,'TOTAL_VENTA_ORIG'
                                              ,'TOTAL_VENTA_SOLES'
                                              ,'V_EXONERADO'
                                              ,'ESTADO'
                                              ,'NUM_DOC_ELECT'
                                              ,'ES_TRANS_GRATUITA'
                                              ,'DES_COM'
                                              ,'ES_ANULADO'
                                              ,'ENVIADO_EMAIL'
                                              ,'ENVIADO_EXTERNO'
                                              ,'NRO_ORDEN_COMP'
                                              ,'NUM_GUIA'
                                              ,'TIPO_DOC_REL'
                                              ,'CON_DETRACCION'
                                              ,'OBSERVACION'
                                              ,'HORA_EMISION'
                                              ,'ES_TURISTICO'
                                              ,'ES_EXONERADO'
                                              ,'GUIA_CLIENTE'
                                              ,'GLOSA_DETALE'
                                              ,'VALIDACION_SUNAT'
                                              ,'ID_MOTIVO_EMISION'
                                              ,'MOTIVO_EMISION'
                                              ,'MONTO_IMP_BOLSA'
                                              ,'MONTO_DETRACCION'
                                              ,'MONTO_RETENCION'
                                              ,'MONTO_NETO_PAGO'
                                              ,'DESCUENTO_I'
                                              ,'DESCUENTO'
                                              ,'IMPUESTO_2'
                                              ,'TIPO_DETRACCION'
                                              ,'PORC_DETRACCION'
                                              ,'MONTO_ANTICIPO'
                                              ,'COD_ESTADO'
                                              ,'TXT_ESTADO'
                                              ,'COD_EMPR'
                                              ,'TXT_EMPR'
                                              ,'COD_CONTACTO'
                                              ,'TXT_CONTACTO'
                                              ,'TXT_PROCEDENCIA'
                                              ,'ARCHIVO_XML'
                                              ,'ARCHIVO_CDR'
                                              ,'ARCHIVO_PDF'
                                              ,'success'
                                              ,'message'
                                              ,'estadoCp'
                                              ,'nestadoCp'
                                              ,'estadoRuc'
                                              ,'nestadoRuc'
                                              ,'condDomiRuc'
                                              ,'ncondDomiRuc'
                                              ,'CODIGO_CDR'
                                              ,'RESPUESTA_CDR'
                                              ,'ind_ruc'
                                              ,'ind_rz'
                                              ,'ind_moneda'
                                              ,'ind_total'
                                              ,'ind_cantidaditem'
                                              ,'ind_formapago'
                                              ,'ind_errototal'
                                              ,'dni_usuariocontacto'
                                              ,'usuario_pa'
                                              ,'usuario_uc'
                                              ,'usuario_ap'
                                              ,'usuario_pr'
                                              ,'usuario_ex'
                                              ,'mensaje_exuc'
                                              ,'mensaje_exap'
                                              ,'mensaje_exadm'
                                              ,'ind_email_uc'
                                              ,'ind_email_ap'
                                              ,'ind_email_adm'
                                              ,'ind_email_clap'
                                              ,'ind_email_ba'
                                              ,'ind_observacion'
                                              ,'area_observacion'
                                              ,'OPERACION'
                                              ,'PERCEPCION'
                                              ,'usuario_tes'
                                              ,'LOTE')
                        ->where('ID_DOCUMENTO', '=', $orden->COD_ORDEN)
                        ->get();

                        
                    //dd($referenciaAsocQuery);
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsert = $referenciaAsocQuery->toArray();
                    //dd($dataToInsert);

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DOCUMENTO')->insert($dataToInsert);

                    //FE_DETALLE_DOCUENTO
                    $referenciaAsocQueryd = FeDetalleDocumento::select('*')
                        ->where('ID_DOCUMENTO', '=', $orden->COD_ORDEN)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertd = $referenciaAsocQueryd->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DETALLE_DOCUMENTO')->insert($dataToInsertd);


                    //FE_FORMAPAGO
                    $referenciaAsocQueryfp = FeFormaPago::select('ID_DOCUMENTO','DOCUMENTO_ITEM','ID_CUOTA','ID_MONEDA','MONTO_CUOTA','FECHA_PAGO')
                        ->where('ID_DOCUMENTO', '=', $orden->COD_ORDEN)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    //$dataToInsertfp = $referenciaAsocQueryfp->toArray();


                    $dataToInsertfp = $referenciaAsocQueryfp->map(function ($item) {
                        if ($item['FECHA_PAGO']) {
                            $item['FECHA_PAGO'] = date('Ymd', strtotime($item['FECHA_PAGO']));
                        }
                        return $item;
                    })->toArray();

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_FORMAPAGO')->insert($dataToInsertfp);



                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR ADMINISTRACION';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //whatsaap para administracion
                // $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();
                $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();            
                // $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO.'%0D%0A'.'Proveedor : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'.'Estado : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';
                // $trabajador         =   STDTrabajador::where('COD_TRAB','=',$fedocumento_w->COD_CONTACTO)->first();
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');          
                // }    

                DB::commit();
                return Redirect::to('/gestion-de-administracion-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{


            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   $this->lista_archivos_total($idoc,$fedocumento->DOCUMENTO_ITEM);
            $archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);


            //orden de ingreso
            $orden_f                =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();   
            $conexionbd         = 'sqlsrv';
            if($orden_f->COD_CENTRO == 'CEN0000000000004'){ //rioja
                $conexionbd         = 'sqlsrv_r';
            }else{
                if($orden_f->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                    $conexionbd         = 'sqlsrv_b';
                }
            }
            $referencia             =   DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->where('COD_TABLA','=',$ordencompra->COD_ORDEN)
                                        ->orderBy('COD_TABLA_ASOC','desc')
                                        ->where('COD_TABLA_ASOC','like','%OI%')->first();
                                        
            $ordeningreso           =   array();
            if(count($referencia)>0){
                $ordeningreso       =   DB::connection($conexionbd)->table('CMP.ORDEN')->where('COD_ORDEN','=',$referencia->COD_TABLA_ASOC)->first();   
            }                 




            //ORDEN DE SALIDA

            $empresa_relacionada    =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)
                                        ->where('IND_RELACIONADO','=',1)
                                        ->first();
            $ordensalida            =   array();


            if(count($empresa_relacionada)>0){

                $documento_venta    =   DB::connection($conexionbd)->table('CMP.DOCUMENTO_CTBLE')
                                        ->where('NRO_SERIE','=',$fedocumento->SERIE)
                                        ->where('NRO_DOC','=',$fedocumento->NUMERO)
                                        ->where('COD_EMPR_EMISOR','=',$empresa_relacionada->COD_EMPR)
                                        ->first();

                if(count($documento_venta)>0){


                    $referencia_venta       =   DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->where('COD_TABLA','=',$documento_venta->COD_DOCUMENTO_CTBLE)
                                                ->where(function($query) {
                                                    $query->where('COD_TABLA_ASOC', 'like', '%VR%')
                                                          ->orWhere('COD_TABLA_ASOC', 'like', '%VL%');
                                                })->first();

                    if(count($referencia_venta)>0){
                        $referencia_os        =   DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->where('COD_TABLA','=',$referencia_venta->COD_TABLA_ASOC)
                                                    ->where('COD_TABLA_ASOC','like','%OS%')->first();



                        if(count($referencia_os)>0){
                            $ordensalida       =   DB::connection($conexionbd)->table('CMP.ORDEN')->where('COD_ORDEN','=',$referencia_os->COD_TABLA_ASOC)->first(); 
                        }
                    }
                }
            }                 


            $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
            $codigo_sunat           =   'I';
            if($ordencompra_t->IND_VARIAS_ENTREGAS==0){
                $codigo_sunat           =   'N';
            }
            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();

            $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->where('COD_ESTADO','=',1)
                                        ->where('CODIGO_SUNAT','=',$codigo_sunat)
                                        ->whereNotIn('COD_CATEGORIA',['DCC0000000000003','DCC0000000000004'])
                                        ->get();
            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();

            $ordencompra_f          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();


            //Archivo multiple


            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-file', ['file' => $archivo->NOMBRE_ARCHIVO]);
            }
            $initialPreviewConfig = [];
            foreach ($archivospdf as $key => $archivo) {
                $initialPreviewConfig[] = [
                    'type'          => "pdf",
                    'caption' => $archivo->NOMBRE_ARCHIVO,
                    'downloadUrl' => route('serve-file', ['file' => $archivo->NOMBRE_ARCHIVO])
                ];
            }

            //dd($initialPreviewConfig);





            return View::make('comprobante/aprobaradm', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'empresa_relacionada'   =>  $empresa_relacionada,
                                'ordensalida'           =>  $ordensalida,


                                'initialPreview'        => json_encode($initialPreview),
                                'initialPreviewConfig'  => json_encode($initialPreviewConfig),

                                'ordeningreso'          =>  $ordeningreso,
                                'linea'                 =>  $linea,
                                'archivos'              =>  $archivos,
                                'ordencompra_f'         =>  $ordencompra_f,

                                'trabajador'            =>  $trabajador,
                                'documentoscompra'      =>  $documentoscompra,
                                'totalarchivos'         =>  $totalarchivos,
                                'ordencompra_t'         =>  $ordencompra_t,


                                'documentohistorial'    =>  $documentohistorial,
                                'archivospdf'           =>  $archivospdf,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'tarchivos'             =>  $tarchivos,

                                'archivosanulados'      =>  $archivosanulados,

                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }



    public function actionAprobarAdministracionContrato($idopcion, $linea,$prefijo, $idordencompra,Request $request)
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
                    $documento->TIPO                        =   'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();
                    //LE LLEGA AL USUARIO DE CONTACTO
                    // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                    // $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                    // $mensaje            =   'COMPROBANTE: '.$fedocumento->ID_DOCUMENTO
                    //                         .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                    //                         .'PROVEEDOR : '.$ordencompra->TXT_EMPR_EMISOR.'%0D%0A'
                    //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                    //                         .'RECOMENDACION : '.$descripcion.'%0D%0A';
                    // //dd($trabajador);                        
                    // if(1==0){
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    // }else{
                    //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                    // }  
                }




                $filespdf          =   $request['otros'];
                if(!is_null($filespdf)){
                    //PDF
                    foreach($filespdf as $file){

                            //
                            $contadorArchivos = Archivo::count();

                        $nombre          =      $ordencompra->COD_DOCUMENTO_CTBLE.'-'.$file->getClientOriginalName();
                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                        $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
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
                        $dcontrol->ID_DOCUMENTO     =   $ordencompra->COD_DOCUMENTO_CTBLE;
                        $dcontrol->DOCUMENTO_ITEM   =   $fedocumento->DOCUMENTO_ITEM;
                        $dcontrol->TIPO_ARCHIVO     =   'OTROS_UC';
                        $dcontrol->NOMBRE_ARCHIVO   =   $nombrefilepdf;
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'OTROS ADMINISTRACION';
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


                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000005',
                                    'TXT_ESTADO'=>'APROBADO',
                                    'ind_email_clap'=>0,
                                    'fecha_ap'=>$this->fechaactual,
                                    'usuario_ap'=>Session::get('usuario')->id
                                ]
                            );

                $orden                      =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$pedido_id)->first();


                $conexionbd         = 'sqlsrv';
                if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
                    $conexionbd         = 'sqlsrv_r';
                }else{
                    if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                        $conexionbd         = 'sqlsrv_b';
                    }
                }

                DB::connection($conexionbd)->table('CMP.DOCUMENTO_CTBLE')
                ->where('COD_DOCUMENTO_CTBLE','=',$pedido_id)
                            ->update(
                                    [
                                        'IND_NOTIFICACION_CLIENTE'=>1
                                    ]);

                //enviar tablas de fe_documento y fe_detalledocuemto
                if($orden->COD_CENTRO == 'CEN0000000000004' || $orden->COD_CENTRO == 'CEN0000000000006'){ //rioja
                    //dd($conexionbd);
                    //FE_DOCUENTO
                    $referenciaAsocQuery = FeDocumento::select('ID_DOCUMENTO'
                                              ,'DOCUMENTO_ITEM'
                                              ,'RUC_PROVEEDOR'
                                              ,'RZ_PROVEEDOR'
                                              ,'TIPO_CLIENTE'
                                              ,'ID_CLIENTE'
                                              ,'NOMBRE_CLIENTE'
                                              ,'DIRECCION_CLIENTE'
                                              ,'NUM_DOC_VENTA'
                                              ,'SERIE'
                                              ,'NUMERO'
                                              ,'ID_TIPO_DOC'
                                              ,'FEC_VENTA'
                                              ,'FEC_VENCI_PAGO'
                                              ,'FORMA_PAGO'
                                              ,'FORMA_PAGO_DIAS'
                                              ,'MONEDA'
                                              ,'VALOR_TIPO_CAMBIO'
                                              ,'VALOR_IGV_ORIG'
                                              ,'VALOR_IGV_SOLES'
                                              ,'SUB_TOTAL_VENTA_ORIG'
                                              ,'SUB_TOTAL_VENTA_SOLES'
                                              ,'TOTAL_VENTA_ORIG'
                                              ,'TOTAL_VENTA_SOLES'
                                              ,'V_EXONERADO'
                                              ,'ESTADO'
                                              ,'NUM_DOC_ELECT'
                                              ,'ES_TRANS_GRATUITA'
                                              ,'DES_COM'
                                              ,'ES_ANULADO'
                                              ,'ENVIADO_EMAIL'
                                              ,'ENVIADO_EXTERNO'
                                              ,'NRO_ORDEN_COMP'
                                              ,'NUM_GUIA'
                                              ,'TIPO_DOC_REL'
                                              ,'CON_DETRACCION'
                                              ,'OBSERVACION'
                                              ,'HORA_EMISION'
                                              ,'ES_TURISTICO'
                                              ,'ES_EXONERADO'
                                              ,'GUIA_CLIENTE'
                                              ,'GLOSA_DETALE'
                                              ,'VALIDACION_SUNAT'
                                              ,'ID_MOTIVO_EMISION'
                                              ,'MOTIVO_EMISION'
                                              ,'MONTO_IMP_BOLSA'
                                              ,'MONTO_DETRACCION'
                                              ,'MONTO_RETENCION'
                                              ,'MONTO_NETO_PAGO'
                                              ,'DESCUENTO_I'
                                              ,'DESCUENTO'
                                              ,'IMPUESTO_2'
                                              ,'TIPO_DETRACCION'
                                              ,'PORC_DETRACCION'
                                              ,'MONTO_ANTICIPO'
                                              ,'COD_ESTADO'
                                              ,'TXT_ESTADO'
                                              ,'COD_EMPR'
                                              ,'TXT_EMPR'
                                              ,'COD_CONTACTO'
                                              ,'TXT_CONTACTO'
                                              ,'TXT_PROCEDENCIA'
                                              ,'ARCHIVO_XML'
                                              ,'ARCHIVO_CDR'
                                              ,'ARCHIVO_PDF'
                                              ,'success'
                                              ,'message'
                                              ,'estadoCp'
                                              ,'nestadoCp'
                                              ,'estadoRuc'
                                              ,'nestadoRuc'
                                              ,'condDomiRuc'
                                              ,'ncondDomiRuc'
                                              ,'CODIGO_CDR'
                                              ,'RESPUESTA_CDR'
                                              ,'ind_ruc'
                                              ,'ind_rz'
                                              ,'ind_moneda'
                                              ,'ind_total'
                                              ,'ind_cantidaditem'
                                              ,'ind_formapago'
                                              ,'ind_errototal'
                                              ,'dni_usuariocontacto'
                                              ,'usuario_pa'
                                              ,'usuario_uc'
                                              ,'usuario_ap'
                                              ,'usuario_pr'
                                              ,'usuario_ex'
                                              ,'mensaje_exuc'
                                              ,'mensaje_exap'
                                              ,'mensaje_exadm'
                                              ,'ind_email_uc'
                                              ,'ind_email_ap'
                                              ,'ind_email_adm'
                                              ,'ind_email_clap'
                                              ,'ind_email_ba'
                                              ,'ind_observacion'
                                              ,'area_observacion'
                                              ,'OPERACION'
                                              ,'PERCEPCION'
                                              ,'usuario_tes'
                                              ,'LOTE')
                        ->where('ID_DOCUMENTO', '=', $orden->COD_DOCUMENTO_CTBLE)
                        ->get();

                        
                    //dd($referenciaAsocQuery);
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsert = $referenciaAsocQuery->toArray();
                    //dd($dataToInsert);

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DOCUMENTO')->insert($dataToInsert);

                    //FE_DETALLE_DOCUENTO
                    $referenciaAsocQueryd = FeDetalleDocumento::select('*')
                        ->where('ID_DOCUMENTO', '=', $orden->COD_DOCUMENTO_CTBLE)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertd = $referenciaAsocQueryd->toArray();

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DETALLE_DOCUMENTO')->insert($dataToInsertd);

                    //CMPDocAsociarCompra
                    $referenciaAsocQueryac = CMPDocAsociarCompra::select('COD_ORDEN','COD_CATEGORIA_DOCUMENTO','NOM_CATEGORIA_DOCUMENTO','IND_OBLIGATORIO','TXT_FORMATO','TXT_ASIGNADO','COD_USUARIO_CREA_AUD','COD_ESTADO','TIP_DOC')
                        ->where('COD_ORDEN', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInserac = $referenciaAsocQueryac->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('CMP.DOC_ASOCIAR_COMPRA')->insert($dataToInserac);
                    

                }

                
                $detalleproducto            =   CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO','=',1)
                                                ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$pedido_id)
                                                ->orderBy('NRO_LINEA','ASC')
                                                ->get();




                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR ADMINISTRACION';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //whatsaap para administracion
                // $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();
                $ordencompra        =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$pedido_id)->first();

                // //$ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();            
                // $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO.'%0D%0A'.'Proveedor : '.$ordencompra->TXT_EMPR_EMISOR.'%0D%0A'.'Estado : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';
                // $trabajador         =   STDTrabajador::where('COD_TRAB','=',$fedocumento_w->COD_CONTACTO)->first();
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');          
                // }    

                DB::commit();

                Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('/gestion-de-administracion-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
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

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();


            //transferencia   
            $resultado = '';
            // Verificar si la cadena contiene 'TPS' o 'TPL'
            if (strpos($ordencompra->NRO_ITT, 'TPS') !== false || strpos($ordencompra->NRO_ITT, 'TPL') !== false) {
                $partes = explode(' / ', $ordencompra->NRO_ITT);
                $resultado = $partes[0];
            }
            $transferencia        =   CMPOrden::where('COD_ORDEN','=',$resultado)->first();    



            $transferencia_doc      =   DB::table('CMP.REFERENCIA_ASOC')
                                        ->where('COD_TABLA', $resultado)
                                        ->where(function ($query) {
                                            $query->where('COD_TABLA_ASOC', 'like', '%TPS%')
                                                  ->orWhere('COD_TABLA_ASOC', 'like', '%TPL%');
                                        })
                                        ->where('COD_ESTADO', 1)
                                        ->first();



            //Archivo multiple


            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-filecontrato', ['file' => $archivo->NOMBRE_ARCHIVO]);
            }
            $initialPreviewConfig = [];
            foreach ($archivospdf as $key => $archivo) {
                $initialPreviewConfig[] = [
                    'type'          => "pdf",
                    'caption' => $archivo->NOMBRE_ARCHIVO,
                    'downloadUrl' => route('serve-filecontrato', ['file' => $archivo->NOMBRE_ARCHIVO])
                ];
            }




            return View::make('comprobante/aprobaradmcontrato', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'initialPreview'        => json_encode($initialPreview),
                                'initialPreviewConfig'  => json_encode($initialPreviewConfig),


                                'linea'                 =>  $linea,
                                'archivos'              =>  $archivos,
                                'archivosanulados'      =>  $archivosanulados,
                                'transferencia'         =>  $transferencia,
                                'transferencia_doc'     =>  $transferencia_doc,

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


    public function actionAprobarAdministracionEstiba($idopcion, $lote,Request $request)
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
                    $documento->TIPO                        =   'RECOMENDACION POR CONTABILIDAD';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();
                    //LE LLEGA AL USUARIO DE CONTACTO
                    // $empresa_anti       =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();
                    // $trabajador         =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
                    // $mensaje            =   'COMPROBANTE: '.$fedocumento->ID_DOCUMENTO
                    //                         .'%0D%0A'.'EMPRESA : '.Session::get('empresas')->NOM_EMPR.'%0D%0A'
                    //                         .'PROVEEDOR : '.$empresa_anti->NOM_EMPR.'%0D%0A'
                    //                         .'ESTADO : '.$fedocumento->TXT_ESTADO.'%0D%0A'
                    //                         .'RECOMENDACION : '.$descripcion.'%0D%0A';
                    // //dd($trabajador);                        
                    // if(1==0){
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                    // }else{
                    //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                    //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,''); 
                    // }  
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
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'OTROS ADMINISTRACION';
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
                                    'COD_ESTADO'=>'ETM0000000000005',
                                    'TXT_ESTADO'=>'APROBADO',
                                    'ind_email_clap'=>0,
                                    'fecha_ap'=>$this->fechaactual,
                                    'usuario_ap'=>Session::get('usuario')->id
                                ]
                            );

                $lotes                  =   FeRefAsoc::where('lote','=',$idoc)                                        
                                            ->pluck('ID_DOCUMENTO')
                                            ->toArray();
                $documento_asociados    =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->get();
                $documento_top          =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->first();
                $conexionbd                 = 'sqlsrv';
                if($documento_top->COD_CENTRO == 'CEN0000000000004'){ //rioja
                    $conexionbd         = 'sqlsrv_r';
                }else{
                    if($documento_top->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                        $conexionbd         = 'sqlsrv_b';
                    }
                }


                DB::connection($conexionbd)->table('CMP.DOCUMENTO_CTBLE')
                ->where('COD_DOCUMENTO_CTBLE','=',$pedido_id)
                            ->update(
                                    [
                                        'IND_NOTIFICACION_CLIENTE'=>1
                                    ]);
                //enviar tablas de fe_documento y fe_detalledocuemto
                if($documento_top->COD_CENTRO == 'CEN0000000000004' || $documento_top->COD_CENTRO == 'CEN0000000000006'){ //rioja
                    //dd($conexionbd);
                    //FE_DOCUENTO
                    $referenciaAsocQuery = FeDocumento::select('ID_DOCUMENTO'
                                              ,'DOCUMENTO_ITEM'
                                              ,'RUC_PROVEEDOR'
                                              ,'RZ_PROVEEDOR'
                                              ,'TIPO_CLIENTE'
                                              ,'ID_CLIENTE'
                                              ,'NOMBRE_CLIENTE'
                                              ,'DIRECCION_CLIENTE'
                                              ,'NUM_DOC_VENTA'
                                              ,'SERIE'
                                              ,'NUMERO'
                                              ,'ID_TIPO_DOC'
                                              ,'FEC_VENTA'
                                              ,'FEC_VENCI_PAGO'
                                              ,'FORMA_PAGO'
                                              ,'FORMA_PAGO_DIAS'
                                              ,'MONEDA'
                                              ,'VALOR_TIPO_CAMBIO'
                                              ,'VALOR_IGV_ORIG'
                                              ,'VALOR_IGV_SOLES'
                                              ,'SUB_TOTAL_VENTA_ORIG'
                                              ,'SUB_TOTAL_VENTA_SOLES'
                                              ,'TOTAL_VENTA_ORIG'
                                              ,'TOTAL_VENTA_SOLES'
                                              ,'V_EXONERADO'
                                              ,'ESTADO'
                                              ,'NUM_DOC_ELECT'
                                              ,'ES_TRANS_GRATUITA'
                                              ,'DES_COM'
                                              ,'ES_ANULADO'
                                              ,'ENVIADO_EMAIL'
                                              ,'ENVIADO_EXTERNO'
                                              ,'NRO_ORDEN_COMP'
                                              ,'NUM_GUIA'
                                              ,'TIPO_DOC_REL'
                                              ,'CON_DETRACCION'
                                              ,'OBSERVACION'
                                              ,'HORA_EMISION'
                                              ,'ES_TURISTICO'
                                              ,'ES_EXONERADO'
                                              ,'GUIA_CLIENTE'
                                              ,'GLOSA_DETALE'
                                              ,'VALIDACION_SUNAT'
                                              ,'ID_MOTIVO_EMISION'
                                              ,'MOTIVO_EMISION'
                                              ,'MONTO_IMP_BOLSA'
                                              ,'MONTO_DETRACCION'
                                              ,'MONTO_RETENCION'
                                              ,'MONTO_NETO_PAGO'
                                              ,'DESCUENTO_I'
                                              ,'DESCUENTO'
                                              ,'IMPUESTO_2'
                                              ,'TIPO_DETRACCION'
                                              ,'PORC_DETRACCION'
                                              ,'MONTO_ANTICIPO'
                                              ,'COD_ESTADO'
                                              ,'TXT_ESTADO'
                                              ,'COD_EMPR'
                                              ,'TXT_EMPR'
                                              ,'COD_CONTACTO'
                                              ,'TXT_CONTACTO'
                                              ,'TXT_PROCEDENCIA'
                                              ,'ARCHIVO_XML'
                                              ,'ARCHIVO_CDR'
                                              ,'ARCHIVO_PDF'
                                              ,'success'
                                              ,'message'
                                              ,'estadoCp'
                                              ,'nestadoCp'
                                              ,'estadoRuc'
                                              ,'nestadoRuc'
                                              ,'condDomiRuc'
                                              ,'ncondDomiRuc'
                                              ,'CODIGO_CDR'
                                              ,'RESPUESTA_CDR'
                                              ,'ind_ruc'
                                              ,'ind_rz'
                                              ,'ind_moneda'
                                              ,'ind_total'
                                              ,'ind_cantidaditem'
                                              ,'ind_formapago'
                                              ,'ind_errototal'
                                              ,'dni_usuariocontacto'
                                              ,'usuario_pa'
                                              ,'usuario_uc'
                                              ,'usuario_ap'
                                              ,'usuario_pr'
                                              ,'usuario_ex'
                                              ,'mensaje_exuc'
                                              ,'mensaje_exap'
                                              ,'mensaje_exadm'
                                              ,'ind_email_uc'
                                              ,'ind_email_ap'
                                              ,'ind_email_adm'
                                              ,'ind_email_clap'
                                              ,'ind_email_ba'
                                              ,'ind_observacion'
                                              ,'area_observacion'
                                              ,'OPERACION'
                                              ,'PERCEPCION'
                                              ,'usuario_tes'
                                              ,'LOTE')
                        ->where('ID_DOCUMENTO', '=', $idoc)
                        ->get();

                        
                    //dd($referenciaAsocQuery);
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsert = $referenciaAsocQuery->toArray();
                    //dd($dataToInsert);

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DOCUMENTO')->insert($dataToInsert);



                    //FE_DETALLE_DOCUENTO
                    $referenciaAsocQueryd = FeDetalleDocumento::select('*')
                        ->where('ID_DOCUMENTO', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertd = $referenciaAsocQueryd->toArray();

                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_DETALLE_DOCUMENTO')->insert($dataToInsertd);


                    //FE_REFENCIA_DOC
                    $referenciaAsocQueryr = FeRefAsoc::select('LOTE','ID_DOCUMENTO','ESTATUS','COD_ESTADO','OPERACION')
                        ->where('LOTE', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInsertr = $referenciaAsocQueryr->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('FE_REF_ASOC')->insert($dataToInsertr);

                    //CMPDocAsociarCompra
                    $referenciaAsocQueryac = CMPDocAsociarCompra::select('COD_ORDEN','COD_CATEGORIA_DOCUMENTO','NOM_CATEGORIA_DOCUMENTO','IND_OBLIGATORIO','TXT_FORMATO','TXT_ASIGNADO','COD_USUARIO_CREA_AUD','COD_ESTADO','TIP_DOC')
                        ->where('COD_ORDEN', '=', $idoc)
                        ->get();
                    // Convertir el resultado en un array para poder insertarlo más adelante
                    $dataToInserac = $referenciaAsocQueryac->toArray();
                    // Paso 2: Insertar los datos en la segunda base de datos
                    DB::connection($conexionbd)->table('CMP.DOC_ASOCIAR_COMPRA')->insert($dataToInserac);



                }

                $detalleproducto            =   CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO','=',1)
                                                ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$pedido_id)
                                                ->orderBy('NRO_LINEA','ASC')
                                                ->get();
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR ADMINISTRACION';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //whatsaap para administracion
                // $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();
                // $empresa_anti       =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();

                // //$ordencompra        =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();            
                // $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                //                         .'%0D%0A'.'Proveedor : '.$empresa_anti->NOM_EMPR
                //                         .'%0D%0A'.'Estado : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';
                // $trabajador         =   STDTrabajador::where('COD_TRAB','=',$fedocumento_w->COD_CONTACTO)->first();
                // if(1==0){
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');
                // }else{
                //     $this->insertar_whatsaap('51'.$trabajador->TXT_TELEFONO,$trabajador->TXT_NOMBRES,$mensaje,'');
                //     $this->insertar_whatsaap('51979820173','JORGE FRANCELLI',$mensaje,'');          
                // }    

                DB::commit();

                Session::flash('operacion_id', $request['operacion_id']);
                return Redirect::to('/gestion-de-administracion-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$pedido_id.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                Session::flash('operacion_id', $request['operacion_id']);
                return Redirect::to('gestion-de-administracion-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
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

            $lotes                  =   FeRefAsoc::where('lote','=',$idoc)                                        
                                        ->pluck('ID_DOCUMENTO')
                                        ->toArray();
            $documento_asociados    =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->get();
            $documento_top          =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->first();

            return View::make('comprobante/aprobaradmestiba', 
                            [
                                'fedocumento'           =>  $fedocumento,
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
                            ]);


        }
    }



}
