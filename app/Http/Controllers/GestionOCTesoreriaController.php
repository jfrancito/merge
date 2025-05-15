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

class GestionOCTesoreriaController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;
    

    public function actionEliminarItemPP(Request $request)
    {

        $tipo                     =   $request['data_tipoarchivo'];
        $nombrearchivo            =   $request['data_nombrearchivo'];
        $linea                    =   $request['data_linea'];
        $idoc                     =   $request['data_iddocumento'];

        $fedocumento              =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $archivo                  =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('NOMBRE_ARCHIVO','=',$nombrearchivo)
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

        $documento                              =   new FeDocumentoHistorial;
        $documento->ID_DOCUMENTO                =   $idoc;
        $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
        $documento->FECHA                       =   $this->fechaactual;
        $documento->USUARIO_ID                  =   Session::get('usuario')->id;
        $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
        $documento->TIPO                        =   'ELIMINO ITEM '.$archivo->DESCRIPCION_ARCHIVO;
        $documento->MENSAJE                     =   '';
        $documento->save();

        print_r("bien");

    }


    public function actionListarAjaxModalTesoreriaPagoContrato(Request $request)
    {
        
        $cod_orden              =   $request['data_requerimiento_id'];
        $linea                  =   $request['data_linea'];
        $idopcion               =   $request['idopcion'];

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$cod_orden)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $ordencompra            =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$cod_orden)->first();

        //ARCHIVOS
        $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
                                        ->get();

        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN','=',$cod_orden)
                                           ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')->delete();

        foreach($archivosdelfe as $index=>$item){
                $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item->COD_CATEGORIA)->first();
                $docasociar                              =   New CMPDocAsociarCompra;
                $docasociar->COD_ORDEN                   =   $ordencompra->COD_DOCUMENTO_CTBLE;
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

        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
                                    ->get();


        return View::make('comprobante/modal/ajax/magregarpagotesoreriacontrato',
                         [          
                            'cod_orden'             => $cod_orden,
                            'linea'                 => $linea,
                            'idopcion'              => $idopcion,
                            'fedocumento'           => $fedocumento,
                            'ordencompra'           => $ordencompra,
                            'tarchivos'             => $tarchivos,
                            'ajax'                  => true,                            
                         ]);
    }


    public function actionListarAjaxModalTesoreriaPagoEstiba(Request $request)
    {
        
        $cod_orden              =   $request['data_requerimiento_id'];
        $linea                  =   $request['data_linea'];
        $idopcion               =   $request['idopcion'];

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$cod_orden)->where('DOCUMENTO_ITEM','=',$linea)->first();
        //ARCHIVOS
        $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
                                        ->get();

        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN','=',$cod_orden)
                                           ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')->delete();

        foreach($archivosdelfe as $index=>$item){
                $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item->COD_CATEGORIA)->first();
                $docasociar                              =   New CMPDocAsociarCompra;
                $docasociar->COD_ORDEN                   =   $fedocumento->ID_DOCUMENTO;
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

        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$fedocumento->ID_DOCUMENTO)->where('COD_ESTADO','=',1)
                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
                                    ->get();


        return View::make('comprobante/modal/ajax/magregarpagotesoreriaestiba',
                         [          
                            'cod_orden'             => $cod_orden,
                            'linea'                 => $linea,
                            'idopcion'              => $idopcion,
                            'fedocumento'           => $fedocumento,
                            'tarchivos'             => $tarchivos,
                            'ajax'                  => true,                            
                         ]);
    }


    public function actionListarComprobanteTesoreria($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista comprobantes por integrar pago tesoreria');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto

        $operacion_id       =   'ORDEN_COMPRA';
        $estadopago_id      =   'PAGADO';
        if(Session::has('operacion_id')){
            $operacion_id           =   Session::get('operacion_id');
        }
        $combo_operacion    =   array(  'ORDEN_COMPRA' => 'ORDEN COMPRA',
                                        'CONTRATO' => 'CONTRATO',
                                        'ESTIBA' => 'ESTIBA',
                                        'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
                                        'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
                                        'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA'
                                    );

        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO');
        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA');
        $combo_estado       =   array('PAGADO' => 'PAGADO','SIN_PAGAR' => 'SIN PAGAR');
        $proveedor_id       =   'TODO';
        $combo_proveedor    =   $this->gn_combo_proveedor_fe_documento_xestado($proveedor_id,'ETM0000000000005');

        if($operacion_id=='ORDEN_COMPRA'){
            if($estadopago_id == 'PAGADO'){
                $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes($cod_empresa,$proveedor_id);
            }else{
                $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_sp($cod_empresa,$proveedor_id);
            }
        }else{
            if($operacion_id=='CONTRATO'){
                if($estadopago_id == 'PAGADO'){
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_contrato($cod_empresa,$proveedor_id);
                }else{
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_contrato_sp($cod_empresa,$proveedor_id);
                }
            }else{
                if($estadopago_id == 'PAGADO'){
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_estiba($cod_empresa,$proveedor_id,$operacion_id);
                }else{
                    $listadatos         =   array();
                }
            }
        }
        $funcion        =   $this;

        return View::make('comprobante/listatesoreria',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'proveedor_id'      =>  $proveedor_id,
                            'combo_proveedor'   =>  $combo_proveedor,
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,
                            'estadopago_id'     =>  $estadopago_id,
                            'combo_estado'      =>  $combo_estado,
                            'idopcion'          =>  $idopcion,
                         ]);

    }

    public function actionListarAjaxBuscarDocumentoTesoreria(Request $request) {

        $operacion_id   =   $request['operacion_id'];
        $estadopago_id  =   $request['estadopago_id'];
        $proveedor_id   =   $request['proveedor_id'];

        $idopcion       =   $request['idopcion'];
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $proveedor_id   =   $request['proveedor_id'];

        if($operacion_id=='ORDEN_COMPRA'){
            if($estadopago_id == 'PAGADO'){
                $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes($cod_empresa,$proveedor_id);
            }else{
                $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_sp($cod_empresa,$proveedor_id);
            }
        }else{
            if($operacion_id=='CONTRATO'){
                if($estadopago_id == 'PAGADO'){
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_contrato($cod_empresa,$proveedor_id);
                }else{
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_contrato_sp($cod_empresa,$proveedor_id);
                }
            }else{
                if($estadopago_id == 'PAGADO'){
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_estiba($cod_empresa,$proveedor_id,$operacion_id);
                }else{
                    $listadatos         =   array();
                }
            }
        }


        $procedencia            =   'ADM';
        $funcion                =   $this;
        return View::make('comprobante/ajax/mergelistatesoreria',
                         [
                            'operacion_id'          =>  $operacion_id,

                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'procedencia'           =>  $procedencia,
                            'ajax'                  =>  true,
                            'estadopago_id'         =>  $estadopago_id,
                            'funcion'               =>  $funcion
                         ]);
    }


    public function actionListarComprobanteTesoreriaPago($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista comprobantes con pagos asociados');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        //falta usuario contacto
        $operacion_id       =   'ORDEN_COMPRA';
        if(Session::has('operacion_id')){
            $operacion_id           =   Session::get('operacion_id');
        }
        $fecha_inicio       =   $this->fecha_menos_diez_dias;
        $fecha_fin          =   $this->fecha_sin_hora;
        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO');
        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA');

        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA');
        $proveedor_id       =   'TODO';
        $combo_proveedor    =   $this->gn_combo_proveedor_fe_documento_xestado($proveedor_id,'ETM0000000000008');
        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_pagado($cod_empresa,$proveedor_id,$fecha_inicio,$fecha_fin);
        }else{
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_contrato_pagado($cod_empresa,$proveedor_id,$fecha_inicio,$fecha_fin);
        }
        $funcion        =   $this;

        return View::make('comprobante/listatesoreriapagado',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,

                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin,

                            'proveedor_id'      =>  $proveedor_id,
                            'combo_proveedor'   =>  $combo_proveedor,
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,
                            'idopcion'          =>  $idopcion,
                         ]);

    }


    public function actionListarAjaxBuscarDocumentoTesoreriaPago(Request $request) {

        $operacion_id   =   $request['operacion_id'];
        $fecha_inicio   =   $request['fecha_inicio'];
        $fecha_fin      =   $request['fecha_fin'];
        $proveedor_id   =   $request['proveedor_id'];
        $idopcion       =   $request['idopcion'];
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $proveedor_id   =   $request['proveedor_id'];
        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_pagado($cod_empresa,$proveedor_id,$fecha_inicio,$fecha_fin);
        }else{
            $listadatos         =   $this->con_lista_cabecera_comprobante_total_tes_contrato_pagado($cod_empresa,$proveedor_id,$fecha_inicio,$fecha_fin);
        }
        $procedencia            =   'ADM';
        $funcion                =   $this;
        return View::make('comprobante/ajax/mergelistatesoreriapagado',
                         [
                            'operacion_id'          =>  $operacion_id,

                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'procedencia'           =>  $procedencia,
                            'ajax'                  =>  true,
                            'funcion'               =>  $funcion
                         ]);
    }


    public function actionListarAjaxModalTesoreriaPagoPagado(Request $request)
    {
        
        $cod_orden              =   $request['data_requerimiento_id'];
        $linea                  =   $request['data_linea'];
        $idopcion               =   $request['idopcion'];

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$cod_orden)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $ordencompra            =   CMPOrden::where('COD_ORDEN','=',$cod_orden)->first();

        //ARCHIVOS
        $archivosdelfe          =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
                                        ->get();

        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
                                        ->get();
        if(count($tarchivos)<=0){
            foreach($archivosdelfe as $index=>$item){
                    $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item->COD_CATEGORIA)->first();
                    $docasociar                              =   New CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN                   =   $ordencompra->COD_ORDEN;
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
        }

        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
                                        ->get();

        $archivo                =   Archivo::where('ID_DOCUMENTO','=',$cod_orden)->where('TIPO_ARCHIVO','=','DCC0000000000028')->first();


        return View::make('comprobante/modal/ajax/magregarpagotesoreriapagado',
                         [          
                            'cod_orden'             => $cod_orden,
                            'linea'                 => $linea,
                            'idopcion'              => $idopcion,
                            'fedocumento'           => $fedocumento,
                            'ordencompra'           => $ordencompra,
                            'tarchivos'             => $tarchivos,
                            'archivo'               => $archivo,
                            'ajax'                  => true,                            
                         ]);
    }




    public function actionListarAjaxModalTesoreriaPago(Request $request)
    {
        
        $cod_orden              =   $request['data_requerimiento_id'];
        $linea                  =   $request['data_linea'];
        $idopcion               =   $request['idopcion'];

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$cod_orden)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $ordencompra            =   CMPOrden::where('COD_ORDEN','=',$cod_orden)->first();

        //ARCHIVOS

        $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
                                        ->get();

        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN','=',$cod_orden)
                                           ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')->delete();

        foreach($archivosdelfe as $index=>$item){
                $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item->COD_CATEGORIA)->first();
                $docasociar                              =   New CMPDocAsociarCompra;
                $docasociar->COD_ORDEN                   =   $ordencompra->COD_ORDEN;
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

        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
                                    ->get();

        $archivospp             =   DB::table('ARCHIVOS')
                                    ->where('ID_DOCUMENTO', $cod_orden)
                                    ->where('ACTIVO', 1)
                                    ->where('TIPO_ARCHIVO', 'DCC0000000000037')
                                    ->get();


        return View::make('comprobante/modal/ajax/magregarpagotesoreria',
                         [          
                            'cod_orden'             => $cod_orden,
                            'archivospp'            => $archivospp,
                            'linea'                 => $linea,
                            'idopcion'              => $idopcion,
                            'fedocumento'           => $fedocumento,
                            'ordencompra'           => $ordencompra,
                            'tarchivos'             => $tarchivos,
                            'ajax'                  => true,                            
                         ]);
    }

    public function actionListarAjaxModalTesoreriaPagoMasivo(Request $request)
    {
        

        $idopcion               =   $request['idopcion'];
        $datastring_n           =   $request['datastring'];
        $datastring             =   json_decode($request['datastring'], false);

        $archivosdelfe          =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                    ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
                                    ->get();

        foreach ($datastring as $index_asiento => $item1) {

            DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN','=',$item1->id)
                                               ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')->delete();

            foreach($archivosdelfe as $index=>$item){
                    $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item->COD_CATEGORIA)->first();
                    $docasociar                              =   New CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN                   =   $item1->id;
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

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$item1->id)->where('COD_ESTADO','=',1)
                                        ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
                                        ->get();

        }


        return View::make('comprobante/modal/ajax/magregarpagotesoreriamasivo',
                         [          
                            'datastring_n'          => $datastring_n,
                            'datastring'            => $datastring,
                            'idopcion'              => $idopcion,
                            'tarchivos'             => $tarchivos,
                            'ajax'                  => true,                            
                         ]);
    }


    public function actionAprobarTesoreriaMasivo($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/

        View::share('titulo','Aprobar  Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $datastring         =   json_decode($request['datastring'], false);

                foreach ($datastring as $index_asiento => $itemc) {
                    $pedido_id          =   $itemc->id;
                    $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('COD_ESTADO','=','ETM0000000000005')->first();


                    //ORDEN COMPRA
                    if($fedocumento->OPERACION == 'ORDEN_COMPRA'){

                        $orden              =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();
                        $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$pedido_id)->where('COD_ESTADO','=',1)
                                                ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')
                                                ->get();
                        $ordencompra        =   $this->con_lista_cabecera_comprobante_idoc_actual($pedido_id);
                        foreach($tarchivos as $index => $item){

                            $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                            if(!is_null($filescdm)){

                                foreach($filescdm as $file){

                                    $contadorArchivos = Archivo::count();
                                    $nombre          =      $pedido_id.'-'.$file->getClientOriginalName();
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

                    }else{

                        //CONTRATO

                        if($fedocumento->OPERACION == 'CONTRATO'){
                            $orden              =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$pedido_id)->first();
                            $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$pedido_id)->where('COD_ESTADO','=',1)
                                                    ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')
                                                    ->get();
                            $ordencompra        =   $this->con_lista_cabecera_comprobante_contrato_idoc_actual($pedido_id);
                            foreach($tarchivos as $index => $item){

                                $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                                if(!is_null($filescdm)){

                                    foreach($filescdm as $file){

                                        $contadorArchivos = Archivo::count();
                                        $nombre          =      $pedido_id.'-'.$file->getClientOriginalName();
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


                        }else{


                            $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$pedido_id)->where('COD_ESTADO','=',1)
                                                    ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')
                                                    ->get();
                            foreach($tarchivos as $index => $item){

                                $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                                if(!is_null($filescdm)){

                                    foreach($filescdm as $file){

                                        $contadorArchivos = Archivo::count();
                                        $nombre          =      $pedido_id.'-'.$file->getClientOriginalName();
                                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                        $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$pedido_id;
                                        $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                                        $valor           =      $this->versicarpetanoexiste($rutafile);
                                        $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                                        copy($file->getRealPath(),$rutacompleta);
                                        $path            =      $rutacompleta;

                                        $nombreoriginal             =   $file->getClientOriginalName();
                                        $info                       =   new SplFileInfo($nombreoriginal);
                                        $extension                  =   $info->getExtension();

                                        $dcontrol                       =   new Archivo;
                                        $dcontrol->ID_DOCUMENTO         =   $pedido_id;
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
                        }

                    }
                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('COD_ESTADO','=','ETM0000000000005')
                                ->update(
                                    [
                                        'COD_ESTADO'=>'ETM0000000000008',
                                        'TXT_ESTADO'=>'TERMINADA',
                                        'fecha_tes'=>$this->fechaactual,
                                        'usuario_tes'=>Session::get('usuario')->id
                                    ]
                                );

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'SUBIO COMPROBANTE DE PAGO';
                    $documento->MENSAJE                     =   '';
                    $documento->save();
                }

                DB::commit();
                Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('/gestion-de-tesoreria-aprobar/'.$idopcion)->with('bienhecho', 'Comprobantes Masivo Aprobado con exito');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-tesoreria-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
 
    }


    public function actionExtornoTesoreriaPagado($idordencompra,$idopcion,Request $request)
    {

        $idoc                   =   $idordencompra;
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();
        try{    
            
            DB::beginTransaction();



            $pedido_id          =   $idoc;
            $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                    ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')
                                    ->get();

            FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                        ->update(
                            [
                                'COD_ESTADO'=>'ETM0000000000005',
                                'TXT_ESTADO'=>'APROBADO'
                            ]
                        );

            Archivo::where('ID_DOCUMENTO',$pedido_id)->where('TIPO_ARCHIVO','=','DCC0000000000028')
                        ->update(
                            [
                                'ACTIVO'=>'0'
                            ]
                        );

            $documento                              =   new FeDocumentoHistorial;
            $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
            $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
            $documento->FECHA                       =   $this->fechaactual;
            $documento->USUARIO_ID                  =   Session::get('usuario')->id;
            $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
            $documento->TIPO                        =   'EXTORNO COMPROBANTE DE PAGO';
            $documento->MENSAJE                     =   '';
            $documento->save();

            DB::commit();
            return Redirect::to('/gestion-de-comprobante-pago-tesoreria/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' Extornado con exito');
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('gestion-de-comprobante-pago-tesoreria/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }



    }


    public function actionAprobarTesoreriaPagado($idopcion, $linea,$prefijo, $idordencompra,Request $request)
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
        View::share('titulo','Modificar Comprobante Pago');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();
                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')
                                        ->get();

                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];

                    //dd($filescdm);

                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();
                            $nombre                         =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();

                            $prefijocarperta                =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile                       =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                            $nombrefilecdr                  =      $contadorArchivos.'-'.$file->getClientOriginalName();
                            $valor                          =      $this->versicarpetanoexiste($rutafile);
                            $rutacompleta                   =      $rutafile.'\\'.$nombrefilecdr;
                            copy($file->getRealPath(),$rutacompleta);
                            $path                           =      $rutacompleta;

                            $nombreoriginal                 =       $file->getClientOriginalName();
                            $info                           =       new SplFileInfo($nombreoriginal);
                            $extension                      =       $info->getExtension();

                            $dcontrol                       =       Archivo::where('ID_DOCUMENTO','=',$fedocumento->ID_DOCUMENTO)->where('TIPO_ARCHIVO','=','DCC0000000000028')->first();
                            $dcontrol->NOMBRE_ARCHIVO       =       $nombrefilecdr;
                            $dcontrol->URL_ARCHIVO          =       $path;
                            $dcontrol->SIZE                 =       filesize($file);
                            $dcontrol->EXTENSION            =       $extension;
                            $dcontrol->ACTIVO               =       1;
                            $dcontrol->FECHA_MOD            =       $this->fechaactual;
                            $dcontrol->USUARIO_MOD         =        Session::get('usuario')->id;
                            $dcontrol->save();


                        }
                    }
                }

                DB::commit();
                return Redirect::to('/gestion-de-comprobante-pago-tesoreria/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' Modificado CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobante-pago-tesoreria/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }


    }



    public function actionAprobarTesoreria($idopcion, $linea,$prefijo, $idordencompra,Request $request)
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
                $partepago          =   $request['partepago'];



                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();
                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')
                                        ->get();

                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $TIPO_ARCHIVO = $item->COD_CATEGORIA_DOCUMENTO;
                            $DESCRIPCION_ARCHIVO = $item->NOM_CATEGORIA_DOCUMENTO;
                            if($partepago=='on'){
                                $TIPO_ARCHIVO = 'DCC0000000000037';
                                $DESCRIPCION_ARCHIVO = 'PARTE COMPROBANTE DE PAGO';
                            }

                            //dd($TIPO_ARCHIVO);

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
                            $dcontrol->TIPO_ARCHIVO         =   $TIPO_ARCHIVO;
                            $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO  =   $DESCRIPCION_ARCHIVO;


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

                $orden                      =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();
                $detalleproducto            =   CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO','=',1)
                                                ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$pedido_id)
                                                ->orderBy('NRO_LINEA','ASC')
                                                ->get();


                IF($TIPO_ARCHIVO == 'DCC0000000000037'){

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'SUBIO PARTE COMPROBANTE DE PAGO';
                    $documento->MENSAJE                     =   '';
                    $documento->save();


                }ELSE{

                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                    ->update(
                        [
                            'COD_ESTADO'=>'ETM0000000000008',
                            'TXT_ESTADO'=>'TERMINADA',
                            'fecha_tes'=>$this->fechaactual,
                            'usuario_tes'=>Session::get('usuario')->id
                        ]
                    );

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'SUBIO COMPROBANTE DE PAGO';
                    $documento->MENSAJE                     =   '';
                    $documento->save();


                }





                DB::commit();
                return Redirect::to('/gestion-de-tesoreria-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-tesoreria-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('EXTENSION', 'like', '%'.'pdf'.'%')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->get();


            //orden de ingreso
            $referencia             =   CMPReferecenciaAsoc::where('COD_TABLA','=',$ordencompra->COD_ORDEN)
                                        ->where('COD_TABLA_ASOC','like','%OI%')->first();
            $ordeningreso           =   array();
            if(count($referencia)>0){
                $ordeningreso       =   CMPOrden::where('COD_ORDEN','=',$referencia->COD_TABLA_ASOC)->first();   
            }                          



            $archivosdelfe          =      CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                            ->whereIn('COD_CATEGORIA', ['DCC0000000000028'])
                                            ->get();


            //ARCHIVOS
            DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                               ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')->delete();

            foreach($archivosdelfe as $index=>$item){
                    $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item->COD_CATEGORIA)->first();
                    $docasociar                              =   New CMPDocAsociarCompra;
                    $docasociar->COD_ORDEN                   =   $ordencompra->COD_ORDEN;
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

            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000028'])
                                        ->get();

            return View::make('comprobante/aprobartes', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'ordeningreso'          =>  $ordeningreso,
                                'linea'                 =>  $linea,
                                'archivos'              =>  $archivos,
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

    public function actionAprobarTesoreriaContrato($idopcion, $linea,$prefijo, $idordencompra,Request $request)
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
                                        ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')
                                        ->get();

                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();
                            $nombre          =      $ordencompra->COD_DOCUMENTO_CTBLE.'-'.$file->getClientOriginalName();
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

                $orden                      =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$pedido_id)->first();
                $detalleproducto            =   CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO','=',1)
                                                ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$pedido_id)
                                                ->orderBy('NRO_LINEA','ASC')
                                                ->get();

                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000008',
                                    'TXT_ESTADO'=>'TERMINADA',
                                    'fecha_tes'=>$this->fechaactual,
                                    'usuario_tes'=>Session::get('usuario')->id
                                ]
                            );


                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'SUBIO COMPROBANTE DE PAGO';
                $documento->MENSAJE                     =   '';
                $documento->save();


                DB::commit();
                Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('/gestion-de-tesoreria-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-tesoreria-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            dd("desarrollo");


        }
    }

    public function actionAprobarTesoreriaEstiba($idopcion, $linea, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $idordencompra;
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Aprobar  Comprobante');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();

                $pedido_id          =   $idoc;
                $fedocumento        =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();
                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$fedocumento->ID_DOCUMENTO)->where('COD_ESTADO','=',1)
                                        ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000028')
                                        ->get();

                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){

                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();
                            $nombre          =      $fedocumento->ID_DOCUMENTO.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$fedocumento->ID_DOCUMENTO;
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
                            $dcontrol->ID_DOCUMENTO         =   $fedocumento->ID_DOCUMENTO;
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

                $orden                      =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$pedido_id)->first();
                $detalleproducto            =   CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO','=',1)
                                                ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$pedido_id)
                                                ->orderBy('NRO_LINEA','ASC')
                                                ->get();

                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000008',
                                    'TXT_ESTADO'=>'TERMINADA',
                                    'fecha_tes'=>$this->fechaactual,
                                    'usuario_tes'=>Session::get('usuario')->id
                                ]
                            );


                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'SUBIO COMPROBANTE DE PAGO';
                $documento->MENSAJE                     =   '';
                $documento->save();


                DB::commit();
                Session::flash('operacion_id', 'ESTIBA');
                return Redirect::to('/gestion-de-tesoreria-aprobar/'.$idopcion)->with('bienhecho', 'Comprobante : '.$fedocumento->ID_DOCUMENTO.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-tesoreria-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            dd("desarrollo");


        }
    }


}
