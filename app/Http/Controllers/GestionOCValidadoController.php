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
use App\Modelos\FeRefAsoc;
use App\Modelos\CMPDocumentoCtble;


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


    public function actionModelosComprobantes($idopcion,Request $request) {

        View::share('titulo','Modelos de Comprobante');
        $funcion                =   $this;
        $archivospdf            =   Archivo::where('ID_DOCUMENTO','=','MODELOS000000001')->where('ACTIVO','=','1')->get();

        //dd($archivos);
        return View::make('comprobante/modelocomprobantevalidado',
                         [
                            'archivospdf'           =>  $archivospdf,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }



    public function actionEliminarItemContrato($tipo,$nombrearchivo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);

        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        //dd($ordencompra);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('NOMBRE_ARCHIVO','=',$nombrearchivo)
                                    ->where('TIPO_ARCHIVO','=',$tipo)
                                    ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->first();
        

        Archivo::where('ID_DOCUMENTO','=',$idoc)
                ->where('ACTIVO','=','1')
                ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                ->where('NOMBRE_ARCHIVO','=',$nombrearchivo)
                ->where('TIPO_ARCHIVO','=',$tipo)
                    ->update(
                        [
                            'ACTIVO'=>0,
                            'FECHA_MOD'=>$this->fechaactual,
                            'USUARIO_MOD'=>Session::get('usuario')->id
                        ]
                    );

        $ordencompra_t                          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();
        $documento                              =   new FeDocumentoHistorial;
        $documento->ID_DOCUMENTO                =   $ordencompra->COD_DOCUMENTO_CTBLE;
        $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
        $documento->FECHA                       =   $this->fechaactual;
        $documento->USUARIO_ID                  =   Session::get('usuario')->id;
        $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
        $documento->TIPO                        =   'ELIMINO ITEM '.$archivo->DESCRIPCION_ARCHIVO;
        $documento->MENSAJE                     =   '';
        $documento->save();

        //geolocalizacion
        $device_info       =   $request['device_info'];
        $this->con_datos_de_la_pc($device_info,$fedocumento,'ELIMINO ITEM '.$archivo->DESCRIPCION_ARCHIVO);
        //geolocalizacion


        return Redirect::to('aprobar-comprobante-contabilidad-contrato/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Item : '.$archivo->DESCRIPCION_ARCHIVO.' Elimino CON EXITO');;


    }

    public function actionEliminarItemNotaCredito($tipo,$nombrearchivo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);

        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_credito_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        //dd($ordencompra);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('NOMBRE_ARCHIVO','=',$nombrearchivo)
                                    ->where('TIPO_ARCHIVO','=',$tipo)
                                    ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->first();
        

        Archivo::where('ID_DOCUMENTO','=',$idoc)
                ->where('ACTIVO','=','1')
                ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                ->where('NOMBRE_ARCHIVO','=',$nombrearchivo)
                ->where('TIPO_ARCHIVO','=',$tipo)
                    ->update(
                        [
                            'ACTIVO'=>0,
                            'FECHA_MOD'=>$this->fechaactual,
                            'USUARIO_MOD'=>Session::get('usuario')->id
                        ]
                    );

        $ordencompra_t                          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();
        $documento                              =   new FeDocumentoHistorial;
        $documento->ID_DOCUMENTO                =   $ordencompra->COD_DOCUMENTO_CTBLE;
        $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
        $documento->FECHA                       =   $this->fechaactual;
        $documento->USUARIO_ID                  =   Session::get('usuario')->id;
        $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
        $documento->TIPO                        =   'ELIMINO ITEM '.$archivo->DESCRIPCION_ARCHIVO;
        $documento->MENSAJE                     =   '';
        $documento->save();

        return Redirect::to('aprobar-comprobante-contabilidad-nota-credito/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Item : '.$archivo->DESCRIPCION_ARCHIVO.' Elimino CON EXITO');;


    }

    public function actionEliminarItemNotaDebito($tipo,$nombrearchivo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);

        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_debito_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        //dd($ordencompra);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('NOMBRE_ARCHIVO','=',$nombrearchivo)
                                    ->where('TIPO_ARCHIVO','=',$tipo)
                                    ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->first();
        

        Archivo::where('ID_DOCUMENTO','=',$idoc)
                ->where('ACTIVO','=','1')
                ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                ->where('NOMBRE_ARCHIVO','=',$nombrearchivo)
                ->where('TIPO_ARCHIVO','=',$tipo)
                    ->update(
                        [
                            'ACTIVO'=>0,
                            'FECHA_MOD'=>$this->fechaactual,
                            'USUARIO_MOD'=>Session::get('usuario')->id
                        ]
                    );

        $ordencompra_t                          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();
        $documento                              =   new FeDocumentoHistorial;
        $documento->ID_DOCUMENTO                =   $ordencompra->COD_DOCUMENTO_CTBLE;
        $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
        $documento->FECHA                       =   $this->fechaactual;
        $documento->USUARIO_ID                  =   Session::get('usuario')->id;
        $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
        $documento->TIPO                        =   'ELIMINO ITEM '.$archivo->DESCRIPCION_ARCHIVO;
        $documento->MENSAJE                     =   '';
        $documento->save();

        return Redirect::to('aprobar-comprobante-contabilidad-nota-debito/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Item : '.$archivo->DESCRIPCION_ARCHIVO.' Elimino CON EXITO');;


    }

    public function actionEliminarItem($tipo,$nombrearchivo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('NOMBRE_ARCHIVO','=',$nombrearchivo)
                                    ->where('TIPO_ARCHIVO','=',$tipo)
                                    ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->first();
        
        Archivo::where('ID_DOCUMENTO','=',$idoc)
                ->where('ACTIVO','=','1')
                ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                ->where('NOMBRE_ARCHIVO','=',$nombrearchivo)
                ->where('TIPO_ARCHIVO','=',$tipo)
                    ->update(
                        [
                            'ACTIVO'=>0,
                            'FECHA_MOD'=>$this->fechaactual,
                            'USUARIO_MOD'=>Session::get('usuario')->id
                        ]
                    );

        $ordencompra_t                          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();
        $documento                              =   new FeDocumentoHistorial;
        $documento->ID_DOCUMENTO                =   $ordencompra->COD_ORDEN;
        $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
        $documento->FECHA                       =   $this->fechaactual;
        $documento->USUARIO_ID                  =   Session::get('usuario')->id;
        $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
        $documento->TIPO                        =   'ELIMINO ITEM '.$archivo->DESCRIPCION_ARCHIVO;
        $documento->MENSAJE                     =   '';
        $documento->save();

        //geolocalizacion
        $device_info       =   $request['device_info'];
        $this->con_datos_de_la_pc($device_info,$fedocumento,'ELIMINO ITEM '.$archivo->DESCRIPCION_ARCHIVO);
        //geolocalizacion

        return Redirect::to('aprobar-comprobante-contabilidad/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('bienhecho', 'Item : '.$archivo->DESCRIPCION_ARCHIVO.' Elimino CON EXITO');;

    }



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
        $ordencompra_f          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
        //dd($archivos);
        return View::make('comprobante/registrocomprobantevalidado',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'ordencompra_f'           =>  $ordencompra_f,
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
        //$operacion_id       =   'ESTIBA';

        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }

        $combo_operacion    =   array(  'ORDEN_COMPRA' => 'ORDEN COMPRA',
                                        'CONTRATO' => 'CONTRATO',
                                        'ESTIBA' => 'ESTIBA',
                                        'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
                                        'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
                                        'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA',
                                        'DOCUMENTO_INTERNO_COMPRA' => 'DOCUMENTO INTERNO COMPRA',
                                        'COMISION' => 'COMISION',                                        
                                        'LIQUIDACION_COMPRA_ANTICIPO' => 'LIQUIDACION DE COMPRA ANTICIPO',
                                        'NOTA_CREDITO' => 'NOTA DE CREDITO',
                                        'NOTA_DEBITO' => 'NOTA DE DEBITO'
                                    );

        $filtrofecha_id     =   'RE';
        $combo_filtrofecha  =   array('RE' => 'REGISTRO','REA' => 'APROBACION');

        $array_canjes               =   $this->con_array_canjes();
        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id);
        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id);
            }else{
                if (in_array($operacion_id, $array_canjes)) {
                    $categoria_id       =   $this->con_categoria_canje($operacion_id);
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_estiba($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id,$operacion_id);
                }
            }
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
                            'filtrofecha_id'         =>  $filtrofecha_id,
                            'combo_filtrofecha'      =>  $combo_filtrofecha,

                         ]);
    }



    public function actionListarAjaxBuscarDocumento(Request $request) {

        $fecha_inicio   =   $request['fecha_inicio'];
        $fecha_fin      =   $request['fecha_fin'];
        $proveedor_id   =   $request['proveedor_id'];  
        $estado_id      =   $request['estado_id'];
        $idopcion       =   $request['idopcion'];
        $operacion_id   =   $request['operacion_id'];
        $filtrofecha_id =   $request['filtrofecha_id'];

        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id);
        }else{
           if($operacion_id=='CONTRATO'){
                $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id);
            }else{
                if($operacion_id=='LIQUIDACION_COMPRA_ANTICIPO'){
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_liquidacion_compra_anticipo($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id);
                }else{
                    if($operacion_id=='NOTA_CREDITO'){
                        $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_nota_credito($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id);
                    }else{
                        if($operacion_id=='NOTA_DEBITO'){
                            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_nota_debito($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id);
                        }else{
                            $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_estiba($cod_empresa,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id,$filtrofecha_id,$operacion_id);
                        }
                    }
                }
            }
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
        //transferencia   
        // Verificar si la cadena contiene 'TPS' o 'TPL'

        $resultado = '';
        if (strpos($ordencompra->NRO_ITT, 'TPS') !== false || strpos($ordencompra->NRO_ITT, 'TPL') !== false) {
            $partes = explode(' / ', $ordencompra->NRO_ITT);
            $resultado = $partes[0];
        }
        $transferencia          =   CMPOrden::where('COD_ORDEN','=',$resultado)->first();    

        $transferencia_doc      =   DB::table('CMP.REFERENCIA_ASOC')
                                    ->where('COD_TABLA', $resultado)
                                    ->where(function ($query) {
                                        $query->where('COD_TABLA_ASOC', 'like', '%TPS%')
                                              ->orWhere('COD_TABLA_ASOC', 'like', '%TPL%');
                                    })
                                    ->where('COD_ESTADO', 1)
                                    ->first();



        //dd($archivos);
        return View::make('comprobante/registrocomprobantevalidadocontrato',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'transferencia'         =>  $transferencia,
                            'transferencia_doc'     =>  $transferencia_doc,
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

    public function actionDetalleComprobanteOCValidadoLiquidacionCompraAnticipo($idopcion,$linea, $prefijo, $idordenpago, Request $request) {

        View::share('titulo','Detalle de Comprobante');

        $idop                   =   $this->funciones->decodificarmaestraprefijo($idordenpago,$prefijo);        
        $ordenpago              =   $this->con_lista_comprobante_orden_pago_idoc_actual($idop);

        $idoc                   =   $ordenpago->COD_DOCUMENTO_CTBLE;
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

        $prefijocarperta        =   $this->prefijo_empresa($ordenpago->COD_EMPR);

        $xmlarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordenpago->NRO_DOC.'\\'.$fedocumento->ARCHIVO_XML;
        
        $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->orderBy('FECHA','DESC')
                                    ->get();
        //dd($documentohistorial);

        $funcion                =   $this;

        $archivos               =   $this->lista_archivos_total($idop,$fedocumento->DOCUMENTO_ITEM);
        $archivospdf            =   $this->lista_archivos_total_pdf($idop,$fedocumento->DOCUMENTO_ITEM);



        $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idop)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

        //dd($archivos);
        return View::make('comprobante/registrocomprobantevalidadoliquidacioncompraanticipo',
                         [
                            'ordencompra'           =>  $ordencompra,                            
                            'ordenpago'             =>  $ordenpago,                            
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'documentohistorial'    =>  $documentohistorial,
                            'archivos'              =>  $archivos,
                            'archivosanulados'      =>  $archivosanulados,
                            'linea'                 =>  $linea,
                            'archivospdf'           =>  $archivospdf,                         
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tp'                    =>  $tp,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }

    public function actionDetalleComprobanteOCValidadoNotaCredito($idopcion,$linea, $prefijo, $idordencompra, Request $request) {

        View::share('titulo','Detalle de Comprobante');

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_credito_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);
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
        //transferencia   
        // Verificar si la cadena contiene 'TPS' o 'TPL'

        $resultado = '';
        



        //dd($archivos);
        return View::make('comprobante/registrocomprobantevalidadonotacredito',
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

    public function actionDetalleComprobanteOCValidadoNotaDebito($idopcion,$linea, $prefijo, $idordencompra, Request $request) {

        View::share('titulo','Detalle de Comprobante');

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_debito_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);
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
        //transferencia   
        // Verificar si la cadena contiene 'TPS' o 'TPL'

        $resultado = '';
        



        //dd($archivos);
        return View::make('comprobante/registrocomprobantevalidadonotadebito',
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

    public function actionDetalleComprobanteOCValidadoEstiba($idopcion,$lote, Request $request) {

        View::share('titulo','Detalle de Comprobante');

        $idoc                   =   $lote;

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

        $prefijocarperta        =   $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);

        $xmlarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$lote.'\\'.$fedocumento->ARCHIVO_XML;
        $cdrarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$lote.'\\'.$fedocumento->ARCHIVO_CDR;
        $pdfarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$lote.'\\'.$fedocumento->ARCHIVO_PDF;
        $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$lote)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->orderBy('FECHA','DESC')
                                    ->get();
        $funcion                =   $this;
        $archivos               =   $this->lista_archivos_total($idoc,$fedocumento->DOCUMENTO_ITEM);
        $archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);
        $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

        $fereftop1              =   FeRefAsoc::where('lote','=',$idoc)->first();

        $lotes                  =   FeRefAsoc::where('lote','=',$idoc)                                        
                                    ->pluck('ID_DOCUMENTO')
                                    ->toArray();
        $documento_asociados    =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->get();
        $documento_top          =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->first();

        return View::make('comprobante/registrocomprobantevalidadoestiba',
                         [
                            'fedocumento'           =>  $fedocumento,
                            'fereftop1'             =>  $fereftop1,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'documento_asociados'   =>  $documento_asociados,
                            'documento_top'         =>  $documento_top,
                            'lote'                  =>  $lote,
                            'documentohistorial'    =>  $documentohistorial,
                            'archivos'              =>  $archivos,
                            'archivosanulados'      =>  $archivosanulados,
                            'archivospdf'           =>  $archivospdf,                         
                            'xmlarchivo'            =>  $xmlarchivo,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }


    public function actionDetalleComprobanteOCValidadoComision($idopcion,$lote, Request $request) {

        View::share('titulo','Detalle de Comprobante');

        $idoc                   =   $lote;

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

        $prefijocarperta        =   $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);

        $xmlarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$lote.'\\'.$fedocumento->ARCHIVO_XML;
        $cdrarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$lote.'\\'.$fedocumento->ARCHIVO_CDR;
        $pdfarchivo             =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$lote.'\\'.$fedocumento->ARCHIVO_PDF;
        $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$lote)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                    ->orderBy('FECHA','DESC')
                                    ->get();
        $funcion                =   $this;
        $archivos               =   $this->lista_archivos_total($idoc,$fedocumento->DOCUMENTO_ITEM);
        $archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);
        $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        $lotes                  =   FeRefAsoc::where('lote','=',$idoc)                                        
                                    ->pluck('ID_DOCUMENTO')
                                    ->toArray();
        $documento_asociados    =   $this->gn_lista_comision_asociados_atendidos($lotes,$idoc);
        $documento_top          =   $this->gn_lista_comision_asociados_top($lotes);


        return View::make('comprobante/registrocomprobantevalidadocomision',
                         [
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'documento_asociados'   =>  $documento_asociados,
                            'documento_top'         =>  $documento_top,
                            'lote'                  =>  $lote,
                            'documentohistorial'    =>  $documentohistorial,
                            'archivos'              =>  $archivos,
                            'archivosanulados'      =>  $archivosanulados,
                            'archivospdf'           =>  $archivospdf,                         
                            'xmlarchivo'            =>  $xmlarchivo,
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



            //dd($fedocumento->estadoCp);
        if($fedocumento->estadoCp === null || $fedocumento->estadoCp == 0) {

            $token = '';
            if($prefijocarperta =='II'){
                $token           =      $this->generartoken_ii();
            }else{
                $token           =      $this->generartoken_is();
            }


            $fechaemision        =      date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');
            $rvalidar            =      $this->validar_xml( $token,
                                            $fedocumento->ID_CLIENTE,
                                            $fedocumento->RUC_PROVEEDOR,
                                            $fedocumento->ID_TIPO_DOC,
                                            $fedocumento->SERIE,
                                            $fedocumento->NUMERO,
                                            $fechaemision,
                                            $fedocumento->TOTAL_VENTA_ORIG);

            $arvalidar = json_decode($rvalidar, true);

            if($arvalidar['success'] == 1){

                FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
                            ->update(
                                    [
                                        'success'=>$arvalidar['success'],
                                        'message'=>$arvalidar['message'],
                                        'estadoCp'=>'1',
                                        'nestadoCp'=>'ACEPTADO',
                                        'estadoRuc'=>'00',
                                        'nestadoRuc'=>'ACTIVO',
                                        'condDomiRuc'=>'00',
                                        'ncondDomiRuc'=>'HABIDO',
                                    ]);

            }
        }

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
        $ordencompra_f          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();


        //dd($archivos);
        return View::make('comprobante/registrocomprobantevalidado',
                         [
                            'ordencompra'           =>  $ordencompra,
                            'archivospdf'           =>  $archivospdf,
                            'ordeningreso'          =>  $ordeningreso,
                            'detalleordencompra'    =>  $detalleordencompra,
                            'fedocumento'           =>  $fedocumento,
                            'detallefedocumento'    =>  $detallefedocumento,
                            'documentohistorial'    =>  $documentohistorial,
                            'archivos'              =>  $archivos,
                            'archivosanulados'      =>  $archivosanulados,
                            'ordencompra_f'         =>  $ordencompra_f,
                            'linea'                 =>  $linea,
                            
                            'xmlarchivo'            =>  $xmlarchivo,
                            'tp'                    =>  $tp,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                         ]);
    }


    public function actionDescargarLG($tipo,$idopcion,$linea, $idordencompra, Request $request)
    {

        $prefijocarperta        =   $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idordencompra)->where('ACTIVO','=','1')->where('TIPO_ARCHIVO','=',$tipo)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $nombrearchivo          =   trim($archivo->NOMBRE_ARCHIVO);
        $nombrefile             =   basename($nombrearchivo);
        $file                   =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$idordencompra.'\\'.basename($archivo->NOMBRE_ARCHIVO);


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


    public function actionDescargar($tipo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);


        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('TIPO_ARCHIVO','=',$tipo)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
        

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


    public function actionDescargarAnulado($tipo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);


        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('TIPO_ARCHIVO','=',$tipo)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
        

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

   public function actionDescargarEstiba($tipo,$idopcion,$lote, Request $request)
    {

        $idoc                   =   $lote;
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();
        $prefijocarperta        =   $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('TIPO_ARCHIVO','=',$tipo)
                                    ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();

        $nombrearchivo          =   trim($archivo->NOMBRE_ARCHIVO);
        $nombrefile             =   basename($nombrearchivo);
        $file                   =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$lote.'\\'.basename($archivo->NOMBRE_ARCHIVO);

        //dd($file);

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

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('TIPO_ARCHIVO','=',$tipo)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
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

    public function actionDescargarNotaCredito($tipo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);


        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_credito_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);


        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        //dd($ordencompra);

        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);


        //dd($idoc);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('TIPO_ARCHIVO','=',$tipo)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
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

    public function actionDescargarNotaDebito($tipo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);


        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_debito_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);


        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        //dd($ordencompra);

        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);


        //dd($idoc);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('TIPO_ARCHIVO','=',$tipo)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
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

    public function actionDescargarLiquidacionCompraAnticipo($tipo,$idopcion,$linea, $prefijo, $idordenpago, Request $request)
    {

        $idop                   =   $this->funciones->decodificarmaestraprefijo($idordenpago,$prefijo);
        $ordenpago              =   $this->con_lista_comprobante_orden_pago_idoc_actual($idop);

        $idoc                   =   $ordenpago->COD_DOCUMENTO_CTBLE;
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);


        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$linea)->first();        

        $prefijocarperta        =   $this->prefijo_empresa($ordenpago->COD_EMPR);


        //dd($idoc);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idop)->where('ACTIVO','=','1')->where('TIPO_ARCHIVO','=',$tipo)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
        $nombrearchivo          =   trim($archivo->NOMBRE_ARCHIVO);
        $nombrefile             =   basename($nombrearchivo);
        $file                   =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordenpago->NRO_DOC.'\\'.basename($archivo->NOMBRE_ARCHIVO);


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

    public function actionDescargarLiquidacionCompraAnticipoAnulado($tipo,$idopcion,$linea, $prefijo, $idordenpago, Request $request)
    {

        $idop                   =   $this->funciones->decodificarmaestraprefijo($idordenpago,$prefijo);
        $ordenpago              =   $this->con_lista_comprobante_orden_pago_idoc_actual($idop);

        $idoc                   =   $ordenpago->COD_DOCUMENTO_CTBLE;
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);


        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        //dd($ordencompra);

        $prefijocarperta        =   $this->prefijo_empresa($ordenpago->COD_EMPR);


        //dd($idoc);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idop)->where('TIPO_ARCHIVO','=',$tipo)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
        $nombrearchivo          =   trim($archivo->NOMBRE_ARCHIVO);
        $nombrefile             =   basename($nombrearchivo);
        $file                   =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordenpago->NRO_DOC.'\\'.basename($archivo->NOMBRE_ARCHIVO);


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

    public function actionDescargarContratoAnulado($tipo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);


        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);


        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        //dd($ordencompra);

        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);


        //dd($idoc);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('TIPO_ARCHIVO','=',$tipo)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
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

    public function actionDescargarNotaCreditoAnulado($tipo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);


        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_credito_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);


        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        //dd($ordencompra);

        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);


        //dd($idoc);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('TIPO_ARCHIVO','=',$tipo)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
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

    public function actionDescargarNotaDebitoAnulado($tipo,$idopcion,$linea, $prefijo, $idordencompra, Request $request)
    {

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);


        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_debito_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);


        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        //dd($ordencompra);

        $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);


        //dd($idoc);

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('TIPO_ARCHIVO','=',$tipo)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->first();
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
