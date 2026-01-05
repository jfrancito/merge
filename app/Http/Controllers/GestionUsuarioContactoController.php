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
use App\Modelos\WEBRol;
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
use PDO;
use App\Traits\GeneralesTraits;
use App\Traits\ComprobanteTraits;
use App\Traits\WhatsappTraits;
use App\Traits\ComprobanteProvisionTraits;

use Hashids;
use SplFileInfo;
use DateTime;

class GestionUsuarioContactoController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;


    public function actionAprobarReparableMasivo($idopcion,Request $request)
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


                    $pedido_id              =   $itemc->id;
                    $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();
                    $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$pedido_id)
                                                ->where('ACTIVO','=','1')
                                                ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                                ->pluck('TIPO_ARCHIVO')
                                                ->toArray();

                    if($fedocumento->MODO_REPARABLE == 'ARCHIVO_VIRTUAL')
                    {

                        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$pedido_id)->where('COD_ESTADO','=',1)
                                                    ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                    ->get();

                        $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                        if($tiposerie == 'E'){
                            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$pedido_id)->where('COD_ESTADO','=',1)
                                                        ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                                                        ->get();

                        }else{
                            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$pedido_id)->where('COD_ESTADO','=',1)
                                                        ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                                                        ->get();
                        }

                        foreach($tarchivos as $index => $item){

                            $filescdm          =   $request['masivo'];
                            if(!is_null($filescdm)){
                                //CDR
                                foreach($filescdm as $file){

                                    $contadorArchivos = Archivo::count();

                                    $nombre          =      $pedido_id.'-'.$file->getClientOriginalName();
                                    /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                    $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                                    $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$fedocumento->RUC_PROVEEDOR;
                                    // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                                    $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                                    $valor           =      $this->versicarpetanoexiste($rutafile);
                                    $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                                    copy($file->getRealPath(),$rutacompleta);
                                    $path            =      $rutacompleta;

                                    $nombreoriginal             =   $file->getClientOriginalName();
                                    $info                       =   new SplFileInfo($nombreoriginal);
                                    $extension                  =   $info->getExtension();

                                    $dcontrol                   =   new Archivo;
                                    $dcontrol->ID_DOCUMENTO     =   $pedido_id;
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

                        FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                                    ->update(
                                        [
                                            'IND_REPARABLE'=>'2',
                                            'IND_OBSERVACION_REPARABLE' =>0
                                        ]
                                    );
                        //HISTORIAL DE DOCUMENTO APROBADO
                        $documento                              =   new FeDocumentoHistorial;
                        $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                        $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                        $documento->FECHA                       =   $this->fechaactual;
                        $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                        $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                        $documento->TIPO                        =   'RESOLVIO LOS REPARABLES';
                        $documento->MENSAJE                     =   '';
                        $documento->save();


                        //geolocalizacion
                        $device_info       =   $request['device_info'];
                        $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LOS REPARABLES');
                        //geolocalización



                    }
                }
                DB::commit();
                return Redirect::to('/gestion-de-tesoreria-aprobar/'.$idopcion)->with('bienhecho', 'Comprobantes Masivo Aprobado con exito');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-tesoreria-aprobar/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
     }



    public function actionListarAjaxModalReparableMasivo(Request $request)
    {
        

        $idopcion               =   $request['idopcion'];
        $datastring_n           =   $request['datastring'];
        $datastring             =   json_decode($request['datastring'], false);
        $ids                    =   collect($datastring)->pluck('id');
        $tarchivos              =   FeDocumento::whereIn('ID_DOCUMENTO', $ids)
                                    ->get();



        return View::make('comprobante/modal/ajax/magregarreparablemasivo',
                         [          
                            'datastring_n'          => $datastring_n,
                            'datastring'            => $datastring,
                            'idopcion'              => $idopcion,
                            'tarchivos'             => $tarchivos,
                            'ajax'                  => true,                            
                         ]);
    }



    public function actionListarComprobantesObservados($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Documentos Observados');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $operacion_id       =   'ORDEN_COMPRA';
        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO','ESTIBA' => 'ESTIBA');
        $combo_operacion    =   array(  'ORDEN_COMPRA' => 'ORDEN COMPRA',
                                        'CONTRATO' => 'CONTRATO',
                                        'ESTIBA' => 'ESTIBA',
                                        'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
                                        'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
                                        'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA',
                                        'DOCUMENTO_INTERNO_COMPRA' => 'DOCUMENTO INTERNO COMPRA',
                                        'LIQUIDACION_COMPRA_ANTICIPO' => 'LIQUIDACION DE COMPRA ANTICIPO',
                                        'PROVISION_GASTO' => 'PROVISION DE GASTO',
                                        'NOTA_CREDITO' => 'NOTA DE CREDITO',
                                        'NOTA_DEBITO' => 'NOTA DE DEBITO'
                                    );


        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }

       $array_canjes               =   $this->con_array_canjes();


        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados($cod_empresa);
        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_contrato($cod_empresa);
            }else{
                if (in_array($operacion_id, $array_canjes)) {
                    $categoria_id       =   $this->con_categoria_canje($operacion_id);
                    $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_estibas($cod_empresa,$operacion_id);
                }
            }
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
            if($operacion_id=='CONTRATO'){
                $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_contrato($cod_empresa);
            }else{
                if($operacion_id=='LIQUIDACION_COMPRA_ANTICIPO'){
                    $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_liquidacion_compra_anticipo($cod_empresa);
                }else{
                    if($operacion_id=='NOTA_CREDITO'){
                        $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_nota_credito($cod_empresa);
                    }else{
                        if($operacion_id=='NOTA_DEBITO'){
                            $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_nota_debito($cod_empresa);
                        }else{

                            if($operacion_id=='PROVISION_GASTO'){
                                $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_pg($cod_empresa);
                            }else{
                                $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_estibas($cod_empresa,$operacion_id);
                            }

                        }
                    }
                }
            }
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


    public function actionListarComprobantesReparable($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Documentos Reparable');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        CMPDocAsociarCompra::where('TXT_ASIGNADO', 'LIKE', 'ARCHIVO_%')
            ->where('COD_ESTADO', 0)
            ->update(['COD_ESTADO' => 1]);


        $operacion_id       =   'ORDEN_COMPRA';
        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO','ESTIBA' => 'ESTIBA');
        $combo_operacion    =   array(  'ORDEN_COMPRA' => 'ORDEN COMPRA',
                                        'CONTRATO' => 'CONTRATO',
                                        'ESTIBA' => 'ESTIBA',
                                        'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
                                        'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
                                        'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA'
                                    );

        $tipoarchivo_id     =   'TODO';
        $combo_tipoarchivo  =   array('TODO' => 'TODO','ARCHIVO_FISICO' => 'ARCHIVO FISICO','ARCHIVO_VIRTUAL' => 'ARCHIVO VIRTUAL');

        $estado_id          =   'TODO';
        $combo_estdo        =   array('TODO' => 'TODO','1' => 'EN PROCESO','2' => 'EN REVISION');
        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }
        if(Session::has('operacion_id')){
            $operacion_id           =   Session::get('operacion_id');
        }
        if(isset($request['operacion_id'])){
            $operacion_id       =   $request['operacion_id'];
        }
        if(isset($request['estado_id'])){
            $estado_id       =   $request['estado_id'];
        }

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable($cod_empresa,$tipoarchivo_id,$estado_id);
        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_contrato($cod_empresa,$tipoarchivo_id,$estado_id);
            }else{

               $array_canjes               =   $this->con_array_canjes();
                if (in_array($operacion_id, $array_canjes)) {
                    $categoria_id       =   $this->con_categoria_canje($operacion_id);
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,$tipoarchivo_id,$estado_id,$operacion_id);
                }


            }
        }

        $funcion        =   $this;
        return View::make('comprobante/listaocreparable',
                         [
                            'listadatos'        =>  $listadatos,
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,

                            'tipoarchivo_id'    =>  $tipoarchivo_id,
                            'combo_tipoarchivo' =>  $combo_tipoarchivo,

                            'estado_id'         =>  $estado_id,
                            'combo_estdo'       =>  $combo_estdo,


                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }

    public function actionListarComprobantesReparableAdmin($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Documentos Reparable Administracion');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        $operacion_id       =   'ORDEN_COMPRA';
        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO','ESTIBA' => 'ESTIBA');
        $combo_operacion    =   array(  'ORDEN_COMPRA' => 'ORDEN COMPRA',
                                        'CONTRATO' => 'CONTRATO',
                                        'ESTIBA' => 'ESTIBA',
                                        'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
                                        'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
                                        'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA'
                                    );

        $tipoarchivo_id     =   'ARCHIVO_VIRTUAL';
        $combo_tipoarchivo  =   array('ARCHIVO_VIRTUAL' => 'ARCHIVO VIRTUAL');
        $estado_id          =   'TODO';
        $combo_estdo        =   array('TODO' => 'TODO','1' => 'EN PROCESO','2' => 'EN REVISION');

        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }
        if(Session::has('operacion_id')){
            $operacion_id           =   Session::get('operacion_id');
        }
        if(isset($request['operacion_id'])){
            $operacion_id       =   $request['operacion_id'];
        }
        if(isset($request['estado_id'])){
            $estado_id       =   $request['estado_id'];
        }

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_admin($cod_empresa,$tipoarchivo_id,$estado_id);
        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_contrato($cod_empresa,$tipoarchivo_id,$estado_id);
            }else{

               $array_canjes               =   $this->con_array_canjes();
                if (in_array($operacion_id, $array_canjes)) {
                    $categoria_id       =   $this->con_categoria_canje($operacion_id);
                    $listadatos         =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,$tipoarchivo_id,$estado_id,$operacion_id);
                }

            }
        }

        $funcion        =   $this;
        return View::make('comprobante/listaocreparableadministracion',
                         [
                            'listadatos'        =>  $listadatos,
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,

                            'tipoarchivo_id'    =>  $tipoarchivo_id,
                            'combo_tipoarchivo' =>  $combo_tipoarchivo,

                            'estado_id'         =>  $estado_id,
                            'combo_estdo'       =>  $combo_estdo,


                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }



    public function actionListarAjaxBuscarDocumentoReparableAdmin(Request $request) {

        $operacion_id       =   $request['operacion_id'];
        $tipoarchivo_id     =   $request['tipoarchivo_id'];
        $estado_id          =   "";

        $idopcion           =   $request['idopcion'];
        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_admin($cod_empresa,$tipoarchivo_id,$estado_id);
        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_contrato_admin($cod_empresa,$tipoarchivo_id,$estado_id);
            }else{
                $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba_admin($cod_empresa,$tipoarchivo_id,$estado_id,$operacion_id);
            }
        }

        $funcion                =   $this;
        return View::make('comprobante/ajax/mergelistareparableadmin',
                         [
                            'operacion_id'          =>  $operacion_id,
                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'funcion'               =>  $funcion
                         ]);
    }



    public function actionListarAjaxBuscarDocumentoReparable(Request $request) {

        $operacion_id       =   $request['operacion_id'];
        $tipoarchivo_id     =   $request['tipoarchivo_id'];
        $estado_id          =   $request['estado_id'];

        $idopcion           =   $request['idopcion'];
        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable($cod_empresa,$tipoarchivo_id,$estado_id);
        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_contrato($cod_empresa,$tipoarchivo_id,$estado_id);
            }else{
                $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,$tipoarchivo_id,$estado_id,$operacion_id);
            }
        }

        $funcion                =   $this;
        return View::make('comprobante/ajax/mergelistareparable',
                         [
                            'operacion_id'          =>  $operacion_id,
                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'funcion'               =>  $funcion
                         ]);
    }



    public function actionListarComprobantesObservadosProveedores($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Documentos Observados');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_contrato_proveedores($cod_empresa);
        $funcion        =   $this;
        return View::make('comprobante/listaocobservadosproveedores',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }

    public function actionListarComprobantesObservadosOCProveedores($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Documentos Observados');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        //dd($cod_empresa);

        $listadatos     =   $this->con_lista_cabecera_comprobante_total_gestion_observados_oc_proveedor($cod_empresa);
  
        $funcion        =   $this;
        return View::make('comprobante/listaocobservadosocprovedor',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }







    public function actionObservarUCProvedor($idopcion,$linea , $prefijo, $idordencompra,Request $request)
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
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000001','DCC0000000000009'])
                                                //->where('TXT_ASIGNADO','=','CONTACTO')
                                                ->get();



                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000001','DCC0000000000009'])
                                                //->where('TXT_ASIGNADO','=','CONTACTO')
                                                ->get();
                }

                //dd($tarchivos);


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
                        foreach($filescdm as $file){

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
                        return Redirect::to('observacion-comprobante-uc-proveedor/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione los archivos Correspondientes');
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


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LAS OBSERVACIONES');
                //geolocalización


                DB::commit();
                return Redirect::to('/gestion-observados-oc-provedores/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-observados-oc-provedores/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
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
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000001','DCC0000000000009'])
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }else{

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000001','DCC0000000000009'])
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();
            }




            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $ordencompra_f          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();

            //dd($ordencompra_f);

            return View::make('comprobante/observarucprovedor', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'archivosanulados'           =>  $archivosanulados,
                                'ordencompra_f'           =>  $ordencompra_f,
                                
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
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004','DCC0000000000009'])
                                                ->whereNotIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])

                                                //->where('TXT_ASIGNADO','=','CONTACTO')
                                                ->get();



                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->whereNotIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000009'])
                                                //->where('TXT_ASIGNADO','=','CONTACTO')
                                                ->get();
                }

                if($fedocumento->OPERACION_DET == 'SIN_XML'){
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->whereNotIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000009'])
                                                ->whereIn('TXT_FORMATO', ['PDF'])
                                                ->get();
                }

                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
                        foreach($filescdm as $file){

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


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LAS OBSERVACIONES');
                //geolocalización



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
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004','DCC0000000000009'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            ->whereNotIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }else{

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->whereNotIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000009'])
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();
            
            //dd($tarchivos);


            }

            if($fedocumento->OPERACION_DET == 'SIN_XML'){
                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            ->whereNotIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000009'])
                                            ->whereIn('TXT_FORMATO', ['PDF'])
                                            ->get();
            }



            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $ordencompra_f          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();


            return View::make('comprobante/observaruc', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'ordencompra_f'           =>  $ordencompra_f,
                                'linea'                 =>  $linea,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'archivosanulados'      =>  $archivosanulados,
                                'tarchivos'             =>  $tarchivos,
                                'tp'                    =>  $tp,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }

    public function actionReparableUC($idopcion,$linea , $prefijo, $idordencompra,Request $request)
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
        View::share('titulo','Comprobante Reparable');

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


                //virtual

                if($fedocumento->MODO_REPARABLE == 'ARCHIVO_VIRTUAL')
                {

                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->get();

                    $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                    if($tiposerie == 'E'){
                        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                    ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                                    ->get();

                    }else{
                        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                    ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                                    ->get();
                    }

                    foreach($tarchivos as $index => $item){

                        $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                        if(!is_null($filescdm)){
                            //CDR
                            foreach($filescdm as $file){

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
                            return Redirect::to('reparable-comprobante-uc'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione los archivos Correspondientes');
                        }
                    }

                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                    ->update(
                        [
                            'IND_REPARABLE'=>'2',
                            'IND_CORREO_REPARABLE'=>'1',
                            'IND_OBSERVACION_REPARABLE' =>0
                        ]
                    );



                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'RESOLVIO LOS REPARABLES VIRTUAL';
                    $documento->MENSAJE                     =   '';
                    $documento->save();


                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LOS REPARABLES VIRTUAL');
                    //geolocalización




                }else{
                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                    ->update(
                        [
                            'IND_REPARABLE'=>'0'
                        ]
                    );

                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new FeDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'RESOLVIO LOS REPARABLES FISICO';
                    $documento->MENSAJE                     =   '';
                    $documento->save();


                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LOS REPARABLES FISICO');
                    //geolocalización




                }





                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-reparable/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobantes-reparable/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
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
                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                        ->get();
            }else{
                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                            ->get();
            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $rol                    =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();
            $archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);
            $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
            $ordencompra_f          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();


            return View::make('comprobante/reparableuc', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'trabajador'            =>  $trabajador,
                                'archivospdf'           =>  $archivospdf,
                                'archivosanulados'      =>  $archivosanulados,
                                'rol'                   =>  $rol,
                                'ordencompra'           =>  $ordencompra,
                                'ordencompra_f'         =>  $ordencompra_f,
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

    public function actionReparableUCAdmin($idopcion,$linea , $prefijo, $idordencompra,Request $request)
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
        View::share('titulo','Comprobante Reparable Administrador');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id              =   $idoc;
                $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();
                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'IND_REPARABLE_ADMIN'=>'0'
                                ]
                            );
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'REVISION DE REPARABLE ADMINISTRACION';
                $documento->MENSAJE                     =   '';
                $documento->save();


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'REVISION DE REPARABLE ADMINISTRACION');
                //geolocalización


                DB::commit();
                return Redirect::to('/gestion-de-reparable-admin/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-reparable-admin/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->pluck('TIPO_ARCHIVO')
                                        ->toArray();

            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            if($tiposerie == 'E'){
                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                                        ->get();
            }else{
                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                                            ->get();
            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $rol                    =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();
            $archivospdf            =   $this->lista_archivos_total_pdf($idoc,$fedocumento->DOCUMENTO_ITEM);
            $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
            $ordencompra_f          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();


            return View::make('comprobante/reparableucadmin', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'trabajador'            =>  $trabajador,
                                'archivospdf'           =>  $archivospdf,
                                'archivosanulados'      =>  $archivosanulados,
                                'rol'                   =>  $rol,
                                'ordencompra'           =>  $ordencompra,
                                'ordencompra_f'         =>  $ordencompra_f,
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


    public function actionReparableUCEstibaAdmin($idopcion,$lote,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $lote;
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();
        View::share('titulo','Comprobante Reparable');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id              =   $idoc;
                $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();


                FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                            ->update(
                                [
                                    'IND_REPARABLE_ADMIN'=>'0'
                                ]
                            );
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'REVISION DE REPARABLE ADMINISTRACION';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'REVISION DE REPARABLE ADMINISTRACION');
                //geolocalización


                DB::commit();
                return Redirect::to('/gestion-de-reparable-admin/'.$idopcion)->with('bienhecho', 'Comprobante : '.$idoc.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-reparable-admin/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->pluck('TIPO_ARCHIVO')
                                        ->toArray();
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);
            if($tiposerie == 'E'){
                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                                            ->get();
            }else{
                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                                            ->get();
            }
            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


            $rol                    =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();


            $lotes                  =   FeRefAsoc::where('lote','=',$idoc)                                        
                                        ->pluck('ID_DOCUMENTO')
                                        ->toArray();
            $documento_asociados    =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->get();
            $documento_top          =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->first();


            return View::make('comprobante/repararucestibaadmin', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'rol'                   =>  $rol,
                                'documento_asociados'   =>  $documento_asociados,
                                'documento_top'         =>  $documento_top,
                                'lote'                  =>  $idoc,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'tarchivos'             =>  $tarchivos,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }


    public function actionReparableUCEstiba($idopcion,$lote,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $lote;
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();
        View::share('titulo','Comprobante Reparable');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id              =   $idoc;
                $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();

                $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                            ->where('ACTIVO','=','1')
                                            ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                            ->pluck('TIPO_ARCHIVO')
                                            ->toArray();
                //virtual
                if($fedocumento->MODO_REPARABLE == 'ARCHIVO_VIRTUAL')
                {

                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->get();

                    $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                    if($tiposerie == 'E'){
                        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                    ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                                    ->get();

                    }else{
                        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                    ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                                    ->get();
                    }

                    foreach($tarchivos as $index => $item){

                        $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                        if(!is_null($filescdm)){
                            //CDR
                            foreach($filescdm as $file){

                                $contadorArchivos = Archivo::count();

                                $nombre          =      $idoc.'-'.$file->getClientOriginalName();
                                /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                                $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$idoc;
                                // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                                $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                                $valor           =      $this->versicarpetanoexiste($rutafile);
                                $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                                copy($file->getRealPath(),$rutacompleta);
                                $path            =      $rutacompleta;

                                $nombreoriginal             =   $file->getClientOriginalName();
                                $info                       =   new SplFileInfo($nombreoriginal);
                                $extension                  =   $info->getExtension();

                                $dcontrol                   =   new Archivo;
                                $dcontrol->ID_DOCUMENTO     =   $idoc;
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
                            return Redirect::to('reparable-comprobante-uc-estiba'.$idopcion.'/'.$idoc)->with('errorurl', 'Seleccione los archivos Correspondientes');
                        }
                    }



                }

                FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                            ->update(
                                [
                                    'IND_REPARABLE'=>'0'
                                ]
                            );
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'RESOLVIO LOS REPARABLES';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LOS REPARABLES');
                //geolocalización



                $tarchivoshibrido       =   CMPDocAsociarCompra::where('COD_ORDEN','=',$pedido_id)
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                                            ->where('TIP_DOC','=','F')
                                            ->get();

                //dd($tarchivoshibrido);
                foreach($tarchivoshibrido as $index => $item){

                    CMPDocAsociarCompra::where('COD_ORDEN',$pedido_id)->where('COD_CATEGORIA_DOCUMENTO','=',$item->COD_CATEGORIA_DOCUMENTO)
                                        ->where('TIP_DOC','=','F')
                                        ->update(
                                            [
                                                'TXT_ASIGNADO'=>'ARCHIVO_FISICO'
                                            ]
                                        );
                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                                ->update(
                                    [
                                        'IND_REPARABLE'=>'1',
                                        'MODO_REPARABLE'=>'ARCHIVO_FISICO'
                                    ]
                                );
                }



                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-reparable/'.$idopcion)->with('bienhecho', 'Comprobante : '.$idoc.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-comprobantes-reparable/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->pluck('TIPO_ARCHIVO')
                                        ->toArray();
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);
            if($tiposerie == 'E'){
                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                            ->get();
            }else{
                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                            ->get();
            }
            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


            $rol                    =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();


            $lotes                  =   FeRefAsoc::where('lote','=',$idoc)                                        
                                        ->pluck('ID_DOCUMENTO')
                                        ->toArray();
            $documento_asociados    =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->get();
            $documento_top          =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->first();


            return View::make('comprobante/repararucestiba', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'rol'                   =>  $rol,
                                'documento_asociados'   =>  $documento_asociados,
                                'documento_top'         =>  $documento_top,
                                'lote'                  =>  $idoc,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'tarchivos'             =>  $tarchivos,
                                'idopcion'              =>  $idopcion,
                                'idoc'                  =>  $idoc,
                            ]);


        }
    }

    public function actionReparableUCContratoAdmin($idopcion,$linea , $prefijo, $idordencompra,Request $request)
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
        View::share('titulo','Comprobante Reparable');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id              =   $idoc;
                $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)->first();



                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'IND_REPARABLE_ADMIN'=>'0'
                                ]
                            );
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'REVISION DE REPARABLE ADMINISTRACION';
                $documento->MENSAJE                     =   '';
                $documento->save();


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'REVISION DE REPARABLE ADMINISTRACION');
                //geolocalización


                DB::commit();
                return Redirect::to('/gestion-de-reparable-admin/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-reparable-admin/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
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
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                                            ->get();

            }else{

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                                            ->get();

            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


            $rol                    =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

            return View::make('comprobante/repararuccontratoadmin', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'rol'                   =>  $rol,
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


    public function actionReparableUCContrato($idopcion,$linea , $prefijo, $idordencompra,Request $request)
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
        View::share('titulo','Comprobante Reparable');

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
                //virtual
                if($fedocumento->MODO_REPARABLE == 'ARCHIVO_VIRTUAL')
                {

                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->get();

                    $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                    if($tiposerie == 'E'){
                        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                    ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                                    ->get();

                    }else{
                        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                    ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                                    ->get();
                    }

                    foreach($tarchivos as $index => $item){

                        $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                        if(!is_null($filescdm)){
                            //CDR
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
                            return Redirect::to('reparable-comprobante-uc-contrato'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione los archivos Correspondientes');
                        }
                    }
 

                }

                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'IND_REPARABLE'=>'0'
                                ]
                            );
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fedocumento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fedocumento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'RESOLVIO LOS REPARABLES';
                $documento->MENSAJE                     =   '';
                $documento->save();


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LAS REPARABLES');
                //geolocalización


                $tarchivoshibrido       =   CMPDocAsociarCompra::where('COD_ORDEN','=',$pedido_id)
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL'])
                                            ->where('TIP_DOC','=','F')
                                            ->get();

                //dd($tarchivoshibrido);
                foreach($tarchivoshibrido as $index => $item){

                    CMPDocAsociarCompra::where('COD_ORDEN',$pedido_id)->where('COD_CATEGORIA_DOCUMENTO','=',$item->COD_CATEGORIA_DOCUMENTO)
                                        ->where('TIP_DOC','=','F')
                                        ->update(
                                            [
                                                'TXT_ASIGNADO'=>'ARCHIVO_FISICO'
                                            ]
                                        );
                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                                ->update(
                                    [
                                        'IND_REPARABLE'=>'1',
                                        'MODO_REPARABLE'=>'ARCHIVO_FISICO'
                                    ]
                                );
                }



                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-reparable/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-comprobantes-reparable/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
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
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                            ->get();

            }else{

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereIn('TXT_ASIGNADO', ['ARCHIVO_VIRTUAL','ARCHIVO_FISICO'])
                                            ->get();

            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


            $rol                    =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

            return View::make('comprobante/repararuccontrato', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'rol'                   =>  $rol,
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

    public function actionObservarUCEstiba($idopcion,$lote,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $lote;
        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('ind_observacion','=',1)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->get();
        View::share('titulo','Comprobante Observado');

        if($_POST)
        {

            try{    
                

                DB::beginTransaction();
                $pedido_id              =   $idoc;
                $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$pedido_id)->first();

                $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                            ->where('ACTIVO','=','1')
                                            ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                            ->pluck('TIPO_ARCHIVO')
                                            ->toArray();

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            ->get();

                $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

                if($tiposerie == 'E'){

                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004','DCC0000000000032','DCC0000000000009'])
                                                ->get();

                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000032','DCC0000000000009'])
                                                ->get();
                }


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();
                            $nombre          =      $idoc.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$lote;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                            $valor           =      $this->versicarpetanoexiste($rutafile);
                            $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                            copy($file->getRealPath(),$rutacompleta);
                            $path            =      $rutacompleta;

                            $nombreoriginal             =   $file->getClientOriginalName();
                            $info                       =   new SplFileInfo($nombreoriginal);
                            $extension                  =   $info->getExtension();

                            $dcontrol                   =   new Archivo;
                            $dcontrol->ID_DOCUMENTO     =   $idoc;
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
                        return Redirect::to('observacion-comprobante-uc-contrato'.$idopcion.'/'.$lote)->with('errorurl', 'Seleccione los archivos Correspondientes');
                    }
                }



                $ctadetraccion                            =   $request['ctadetraccion'];
                $tipo_detraccion_id                       =   $request['tipo_detraccion_id'];
                $monto_detraccion                         =   $request['monto_detraccion'];
                $pago_detraccion                          =   $request['pago_detraccion'];

                $empresa_sel                              =   STDEmpresa::where('COD_EMPR','=',$pago_detraccion)->first();
                $COD_PAGO_DETRACCION = '';
                $TXT_PAGO_DETRACCION = '';
                if(count($empresa_sel)>0){
                    $COD_PAGO_DETRACCION = $empresa_sel->COD_EMPR;
                    $TXT_PAGO_DETRACCION = $empresa_sel->NOM_EMPR;
                }

                if($ctadetraccion!=''){
                    STDEmpresa::where('COD_EMPR',$fedocumento->RUC_PROVEEDOR)
                                ->update(
                                    [
                                        'TXT_DETRACCION'=>$ctadetraccion
                                    ]
                                );
                }


                FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                            ->update(
                                [
                                    'CTA_DETRACCION'=>$ctadetraccion,
                                    'VALOR_DETRACCION'=>$tipo_detraccion_id,
                                    'MONTO_DETRACCION_XML'=>$monto_detraccion,
                                    'MONTO_DETRACCION_RED'=>round($monto_detraccion),
                                    'COD_PAGO_DETRACCION'=>$COD_PAGO_DETRACCION,
                                    'TXT_PAGO_DETRACCION'=>$TXT_PAGO_DETRACCION,
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


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LAS OBSERVACIONES');
                //geolocalización


                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-observados/'.$idopcion)->with('bienhecho', 'Comprobante : '.$lote.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobantes-observados/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->pluck('TIPO_ARCHIVO')
                                        ->toArray();
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            if($tiposerie == 'E'){

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004','DCC0000000000032','DCC0000000000009'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }else{

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idoc)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000032','DCC0000000000009'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            $empresa                =   STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();

            $combotipodetraccion    =   array('' => "Seleccione Tipo Detraccion",'MONTO_REFERENCIAL' => 'MONTO REFERENCIAL' , 'MONTO_FACTURACION' => 'MONTO FACTURACION');
            $combopagodetraccion    =   array('' => "Seleccione Pago Detraccion",Session::get('empresas')->COD_EMPR => Session::get('empresas')->NOM_EMPR , $empresa->COD_EMPR => $empresa->NOM_EMPR);
            $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
            $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;

            $fereftop1              =   FeRefAsoc::where('lote','=',$idoc)->first();

            $lotes                  =   FeRefAsoc::where('lote','=',$idoc)                                        
                                        ->pluck('ID_DOCUMENTO')
                                        ->toArray();
            $documento_asociados    =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->get();
            $documento_top          =   CMPDocumentoCtble::whereIn('COD_DOCUMENTO_CTBLE',$lotes)->first();


            return View::make('comprobante/observarucestiba', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'fereftop1'             =>  $fereftop1,
                                'empresa'               =>  $empresa,
                                'lote'                  =>  $idoc,
                                'documento_asociados'   =>  $documento_asociados,
                                'documento_top'         =>  $documento_top,

                                'combotipodetraccion'   =>  $combotipodetraccion,
                                'combopagodetraccion'   =>  $combopagodetraccion,
                                'combobancos'           =>  $combobancos,
                                'combotipodetraccion'   =>  $combotipodetraccion,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'documentohistorial'    =>  $documentohistorial,
                                'archivos'              =>  $archivos,
                                'tarchivos'             =>  $tarchivos,
                                //'tp'                    =>  $tp,
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
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004','DCC0000000000032','DCC0000000000009'])
                                                ->get();

                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000032','DCC0000000000009'])
                                                ->get();
                }


                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
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



                $ctadetraccion                            =   $request['ctadetraccion'];
                $tipo_detraccion_id                       =   $request['tipo_detraccion_id'];
                $monto_detraccion                         =   $request['monto_detraccion'];
                $pago_detraccion                          =   $request['pago_detraccion'];

                $empresa_sel                              =   STDEmpresa::where('COD_EMPR','=',$pago_detraccion)->first();
                $COD_PAGO_DETRACCION = '';
                $TXT_PAGO_DETRACCION = '';
                if(count($empresa_sel)>0){
                    $COD_PAGO_DETRACCION = $empresa_sel->COD_EMPR;
                    $TXT_PAGO_DETRACCION = $empresa_sel->NOM_EMPR;
                }

                if($ctadetraccion!=''){
                    STDEmpresa::where('COD_EMPR',$ordencompra->COD_EMPR_EMISOR)
                                ->update(
                                    [
                                        'TXT_DETRACCION'=>$ctadetraccion
                                    ]
                                );
                }


                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'CTA_DETRACCION'=>$ctadetraccion,
                                    'VALOR_DETRACCION'=>$tipo_detraccion_id,
                                    'MONTO_DETRACCION_XML'=>$monto_detraccion,
                                    'MONTO_DETRACCION_RED'=>round($monto_detraccion),
                                    'COD_PAGO_DETRACCION'=>$COD_PAGO_DETRACCION,
                                    'TXT_PAGO_DETRACCION'=>$TXT_PAGO_DETRACCION,
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

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LAS OBSERVACIONES');
                //geolocalización

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

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004','DCC0000000000032','DCC0000000000009'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }else{

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000032','DCC0000000000009'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $user_orden             =   User::where('usuarioosiris_id','=',$ordencompra->COD_EMPR_EMISOR)->first();
            $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR_EMISOR)->first();

            $combotipodetraccion    =   array('' => "Seleccione Tipo Detraccion",'MONTO_REFERENCIAL' => 'MONTO REFERENCIAL' , 'MONTO_FACTURACION' => 'MONTO FACTURACION');
            $combopagodetraccion    =   array('' => "Seleccione Pago Detraccion",$ordencompra->COD_EMPR_EMISOR => $ordencompra->TXT_EMPR_EMISOR , $ordencompra->COD_EMPR_RECEPTOR => $ordencompra->TXT_EMPR_RECEPTOR);
            $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
            $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;



            return View::make('comprobante/observaruccontrato', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'empresa'               =>  $empresa,

                                'combotipodetraccion'   =>  $combotipodetraccion,
                                'combopagodetraccion'   =>  $combopagodetraccion,
                                'combobancos'           =>  $combobancos,
                                'combotipodetraccion'   =>  $combotipodetraccion,


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

    public function actionObservarUCContratoProveedor($idopcion,$linea , $prefijo, $idordencompra,Request $request)
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
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004','DCC0000000000026','DCC0000000000009'])
                                                ->get();



                }else{
                    $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                                ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000026','DCC0000000000009'])
                                                ->get();
                }



                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
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
                        return Redirect::to('observacion-comprobante-uc-contrato-proveedor/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione los archivos Correspondientes');
                    }
                }




                $ctadetraccion                            =   $request['ctadetraccion'];
                $tipo_detraccion_id                       =   $request['tipo_detraccion_id'];
                $monto_detraccion                         =   $request['monto_detraccion'];
                $pago_detraccion                          =   $request['pago_detraccion'];

                $empresa_sel                              =   STDEmpresa::where('COD_EMPR','=',$pago_detraccion)->first();
                $COD_PAGO_DETRACCION = '';
                $TXT_PAGO_DETRACCION = '';
                if(count($empresa_sel)>0){
                    $COD_PAGO_DETRACCION = $empresa_sel->COD_EMPR;
                    $TXT_PAGO_DETRACCION = $empresa_sel->NOM_EMPR;
                }

                if($ctadetraccion!=''){
                    STDEmpresa::where('COD_EMPR',$ordencompra->COD_EMPR_EMISOR)
                                ->update(
                                    [
                                        'TXT_DETRACCION'=>$ctadetraccion
                                    ]
                                );
                }


                FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'CTA_DETRACCION'=>$ctadetraccion,
                                    'VALOR_DETRACCION'=>$tipo_detraccion_id,
                                    'MONTO_DETRACCION_XML'=>$monto_detraccion,
                                    'MONTO_DETRACCION_RED'=>round($monto_detraccion),
                                    'COD_PAGO_DETRACCION'=>$COD_PAGO_DETRACCION,
                                    'TXT_PAGO_DETRACCION'=>$TXT_PAGO_DETRACCION,
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

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LAS OBSERVACIONES');
                //geolocalización


                // CUANDO EL WHATSAAP ES PARA EL USUARIO DEL CONTACTO

                DB::commit();
                return Redirect::to('/gestion-observados-contrato-provedores/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-observados-contrato-provedores/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
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

            //dd($arrayarchivos);

            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            if($tiposerie == 'E'){

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004','DCC0000000000009'])
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }else{

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000009'])
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR_EMISOR)->first();

            $combotipodetraccion    =   array('' => "Seleccione Tipo Detraccion",'MONTO_REFERENCIAL' => 'MONTO REFERENCIAL' , 'MONTO_FACTURACION' => 'MONTO FACTURACION');
            $combopagodetraccion    =   array('' => "Seleccione Pago Detraccion",$ordencompra->COD_EMPR_EMISOR => $ordencompra->TXT_EMPR_EMISOR , $ordencompra->COD_EMPR_RECEPTOR => $ordencompra->TXT_EMPR_RECEPTOR);
            $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
            $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;

            return View::make('comprobante/observaruccontratoproveedor', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'empresa'               =>  $empresa,

                                'combotipodetraccion'   =>  $combotipodetraccion,
                                'combopagodetraccion'   =>  $combopagodetraccion,
                                'combobancos'   =>  $combobancos,

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

    public function actionObservarUCLiquidacionCompraAnticipo($idopcion,$linea , $prefijo, $idordenpago,Request $request)
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

        $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('ind_observacion','=',1)->where('DOCUMENTO_ITEM','=',$linea)->first();
        $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
        View::share('titulo','Comprobante Observado');

        if($_POST)
        {

            try{    
                

                DB::beginTransaction();
                $pedido_id              =   $idoc;
                $fedocumento            =   FeDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$linea)->first();

                $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idop)
                                            ->where('ACTIVO','=','0')
                                            ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                            ->distinct()
                                            ->pluck('TIPO_ARCHIVO')
                                            ->toArray();

                $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idop)->where('COD_ESTADO','=',1)
                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            ->get();                

                foreach($tarchivos as $index => $item){

                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        //CDR
                        foreach($filescdm as $file){

                            $contadorArchivos = Archivo::count();
                            
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordenpago->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordenpago->NRO_DOC;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                            $valor           =      $this->versicarpetanoexiste($rutafile);
                            $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                            copy($file->getRealPath(),$rutacompleta);
                            $path            =      $rutacompleta;

                            $nombreoriginal             =   $file->getClientOriginalName();
                            $info                       =   new SplFileInfo($nombreoriginal);
                            $extension                  =   $info->getExtension();

                            $dcontrol                   =   new Archivo;
                            $dcontrol->ID_DOCUMENTO     =   $ordenpago->COD_AUTORIZACION;
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
                        return Redirect::to('observacion-comprobante-uc-liquidacion-compra-anticipo/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordenpago)->with('errorurl', 'Seleccione los archivos Correspondientes');
                    }
                }

                FeDocumento::where('ID_DOCUMENTO',$idop)->where('DOCUMENTO_ITEM','=',$linea)
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


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LAS OBSERVACIONES');
                //geolocalización


                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-observados/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobantes-observados/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_liquidacion_compra_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
 
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idop)
                                            ->where('ACTIVO','=','0')
                                            ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                            ->distinct()
                                            ->pluck('TIPO_ARCHIVO')
                                            ->toArray();

 
            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$idop)->where('COD_ESTADO','=',1)
                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            ->get();            

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$idop)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idop)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            return View::make('comprobante/observarucliquidacioncompraanticipo', 
                            [
                                'fedocumento'           =>  $fedocumento,                                
                                'ordenpago'             =>  $ordenpago,
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

    public function actionObservarUCNotaCredito($idopcion,$linea , $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_credito_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);
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
                        return Redirect::to('observacion-comprobante-uc-nota-credito'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione los archivos Correspondientes');
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

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LAS OBSERVACIONES');
                //geolocalización



                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-observados/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobantes-observados/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
 
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->pluck('TIPO_ARCHIVO')
                                        ->toArray();

 
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            if($tiposerie == 'E'){

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }else{

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $user_orden             =   User::where('usuarioosiris_id','=',$ordencompra->COD_EMPR_EMISOR)->first();
            $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR_EMISOR)->first();

            



            return View::make('comprobante/observarucnotacredito', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'empresa'               =>  $empresa,

                                


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

    public function actionObservarUCNotaDebito($idopcion,$linea , $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_nota_debito_idoc_actual($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);
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
                        return Redirect::to('observacion-comprobante-uc-nota-debito'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione los archivos Correspondientes');
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



                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LAS OBSERVACIONES');
                //geolocalización


                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-observados/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobantes-observados/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
 
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->pluck('TIPO_ARCHIVO')
                                        ->toArray();

 
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            if($tiposerie == 'E'){

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }else{

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $user_orden             =   User::where('usuarioosiris_id','=',$ordencompra->COD_EMPR_EMISOR)->first();
            $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR_EMISOR)->first();

            



            return View::make('comprobante/observarucnotadebito', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'empresa'               =>  $empresa,

                                


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

    public function actionObservarUCPG($idopcion,$linea , $prefijo, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/

        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_pg_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_pg_comprobante_idoc($idoc);


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

                            $contadorArchivos = Archivo::count();

                            $nombre          =      $ordencompra->COD_DOCUMENTO_CTBLE.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO;
                            // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                            $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
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
                        return Redirect::to('observacion-comprobante-uc-pg'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorurl', 'Seleccione los archivos Correspondientes');
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

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'RESOLVIO LAS OBSERVACIONES');
                //geolocalización


                DB::commit();
                return Redirect::to('/gestion-de-comprobantes-observados/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_DOCUMENTO_CTBLE.' RESUELTO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobantes-observados/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{

            $detalleordencompra     =   $this->con_lista_detalle_producto_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
 
            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->pluck('TIPO_ARCHIVO')
                                        ->toArray();

 
            $tiposerie              =   substr($fedocumento->SERIE, 0, 1);

            if($tiposerie == 'E'){

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000004'])
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }else{

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
                                            //->where('TXT_ASIGNADO','=','CONTACTO')
                                            ->get();

            }

            $documentohistorial     =   FeDocumentoHistorial::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->orderBy('FECHA','DESC')
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            $user_orden             =   User::where('usuarioosiris_id','=',$ordencompra->COD_EMPR_EMISOR)->first();
            $empresa                =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR_EMISOR)->first();

            



            return View::make('comprobante/observarucpg', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'empresa'               =>  $empresa,

                                


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

                    //return Redirect::back()->with('errorurl', 'No se puede integrar ningun documento hasta proximo aviso');

                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)
                                ->update(
                                    [
                                        'COD_ESTADO'=>'ETM0000000000004',
                                        'TXT_ESTADO'=>'POR APROBAR ADMINISTRACCION',
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


                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'APROBADO POR USUARIO CONTACTO');
                    //geolocalización



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

            //geolocalizacion
            $device_info       =   $request['device_info'];
            $this->con_datos_de_la_pc($device_info,$fedocumento,'RECHAZADO POR USUARIO CONTACTO');
            //geolocalización


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

                //return Redirect::back()->with('errorurl', 'No se puede integrar ningun documento hasta proximo aviso');
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
                    $documento->TIPO                        =   'RECOMENDACION POR USUARIO CONTACTO';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();

                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'RECOMENDACION POR USUARIO CONTACTO');
                    //geolocalización

                }


                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                            //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();

                $orden                      =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();

                $fedocumento_x                          =   FeDocumento::where('TXT_REFERENCIA','=',$idoc)->first();
                //cambiar el estado cuando es material y si tiene extonro
                if($orden->IND_MATERIAL_SERVICIO=='M' && count($fedocumento_x)>0){
                    //DETALLE PRODUCTO ACTUALIZAR
                    $conexionbd         = 'sqlsrv';
                    if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
                        $conexionbd         = 'sqlsrv_r';
                    }else{
                        if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                            $conexionbd         = 'sqlsrv_b';
                        }
                    }
                    DB::connection($conexionbd)->table('CMP.ORDEN')
                        ->where('COD_ORDEN', $idoc)
                        ->update(['COD_CATEGORIA_ESTADO_ORDEN' => 'EOR0000000000012','TXT_CATEGORIA_ESTADO_ORDEN'=>'ATENDIDO PARCIALMENTE']);
                }

                if($orden->IND_MATERIAL_SERVICIO=='M' && count($fedocumento_x)<=0){

                    $detalleproducto            =   CMPDetalleProducto::where('CMP.DETALLE_PRODUCTO.COD_ESTADO','=',1)
                                                    ->where('CMP.DETALLE_PRODUCTO.COD_TABLA','=',$pedido_id)
                                                    ->orderBy('NRO_LINEA','ASC')
                                                    ->get();
                    //  INSERTAR ORDEN DE INGRESO
                    //almacen lote                                
                    $this->insert_almacen_lote($orden,$detalleproducto);
                    $orden_id = $this->insert_orden($orden,$detalleproducto);                 
                    $this->insert_referencia_asoc($orden,$detalleproducto,$orden_id[0]);
                    //$this->insert_detalle_producto($orden,$detalleproducto,$orden_id[0]);


                    if (in_array($orden->COD_CATEGORIA_TIPO_ORDEN, ['TOR0000000000026','TOR0000000000022','TOR0000000000021'])) {
                        //dd("LLAMAR AL AREA DE SISTEMAS 979820173 PORFAVOR ESTAMOS REVISANDO ESTOS CASOS");
                        if($orden->COD_CENTRO != 'CEN0000000000002'){
                            $this->insert_detalle_producto_cascara($orden,$detalleproducto,$orden_id[0]);//crea detalle de la orden de ingresa   
                        }else{
                            $this->insert_detalle_producto($orden,$detalleproducto,$orden_id[0]);//crea detalle de la orden de ingresa
                        }
                    }else{
                        $this->insert_detalle_producto($orden,$detalleproducto,$orden_id[0]);//crea detalle de la orden de ingresa
                    }





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
                    $contadorArchivos = Archivo::count();
                    $nombrefilecdr                  =       $contadorArchivos.'-'.$ordencompra->COD_ORDEN.'.pdf';
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
                //guardar orden de compra precargada
                $rutasuspencion       =   $request['rutasuspencion'];
                if($rutasuspencion!=''){

                    $aoc                            =       CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000034'])
                                                            ->first();
                    $contadorArchivos               =       Archivo::count();
                    $nombrefilecdr                  =       $contadorArchivos.'-'.$ordencompra->COD_ORDEN.'.pdf';
                    $prefijocarperta                =       $this->prefijo_empresa($ordencompra->COD_EMPR);
                    $rutafile                       =       $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                    $rutacompleta                   =       $rutafile.'\\'.$nombrefilecdr;
                    $valor                          =       $this->versicarpetanoexiste($rutafile);
                    $path                           =       $rutacompleta;
                    //$directorio                     =       '\\\\10.1.0.201\cpe\Orden_Compra';
                    //$rutafila                       =       $directorio.'\\'.$nombreArchivoBuscado;
                    copy($rutasuspencion,$rutacompleta);
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



                $monto_anticipo_txt                     =   $request['monto_anticipo'];
                $MONTO_ANTICIPO_DESC                    =   0.00;
                $COD_ANTICIPO                           =   '';
                $SERIE_ANTICIPO                         =   '';
                $NRO_ANTICIPO                           =   '';


                if($monto_anticipo_txt!=''){
                    $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$pedido_id)->first();
                    //$ordencompra_t          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();
                    //dd($ordencompra_t);
                    $COD_EMPR               =   Session::get('empresas')->COD_EMPR;
                    $COD_CENTRO             =   '';
                    $FEC_CORTE              =   $this->hoy_sh;
                    $CLIENTE                =   $ordencompra_t->COD_EMPR_CLIENTE;
                    $COD_MONEDA             =   $ordencompra_t->COD_CATEGORIA_MONEDA;
                    $monto_anticipo         =   0.00;
                    //print_r("entro");

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


                    foreach ($listaanticipo as $index => $item) {



                        if($item['COD_HABILITACION'] == $monto_anticipo_txt){
                            $MONTO_ANTICIPO_DESC = (float)$item['CAN_SALDO'];
                            $COD_ANTICIPO = $item['COD_HABILITACION'];
                            $SERIE_ANTICIPO = $item['NRO_SERIE'];
                            $NRO_ANTICIPO = $item['NRO_DOC'];
                        }
                    }
                }




                // $entidadbanco_id   =   $request['entidadbanco_id'];
                // $bancocategoria    =   CMPCategoria::where('COD_CATEGORIA','=',$entidadbanco_id)->first();


                if($orden->IND_MATERIAL_SERVICIO=='M' && count($fedocumento_x)<=0){

                    FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                ->update(
                                    [
                                        // 'COD_CATEGORIA_BANCO'=>$bancocategoria->COD_CATEGORIA,
                                        // 'TXT_CATEGORIA_BANCO'=>$bancocategoria->NOM_CATEGORIA,


                                        'MONTO_ANTICIPO_DESC'=>$MONTO_ANTICIPO_DESC,
                                        'COD_ANTICIPO'=>$COD_ANTICIPO,
                                        'SERIE_ANTICIPO'=>$SERIE_ANTICIPO,
                                        'NRO_ANTICIPO'=>$NRO_ANTICIPO,

                                        'COD_ESTADO'=>'ETM0000000000009',
                                        'TXT_ESTADO'=>'POR EJECUTAR ORDEN DE INGRESO',
                                        'fecha_uc'=>$this->fechaactual,
                                        'usuario_uc'=>Session::get('usuario')->id
                                    ]
                                );

                }else{

                    //return Redirect::back()->with('errorurl', 'No se puede integrar ningun documento hasta proximo aviso');
                    FeDocumento::where('ID_DOCUMENTO',$pedido_id)->where('DOCUMENTO_ITEM','=',$linea)
                                ->update(
                                    [
                                        // 'COD_CATEGORIA_BANCO'=>$bancocategoria->COD_CATEGORIA,
                                        // 'TXT_CATEGORIA_BANCO'=>$bancocategoria->NOM_CATEGORIA,


                                        'MONTO_ANTICIPO_DESC'=>$MONTO_ANTICIPO_DESC,
                                        'COD_ANTICIPO'=>$COD_ANTICIPO,
                                        'SERIE_ANTICIPO'=>$SERIE_ANTICIPO,
                                        'NRO_ANTICIPO'=>$NRO_ANTICIPO,
                                        
                                        'COD_ESTADO'=>'ETM0000000000004',
                                        'TXT_ESTADO'=>'POR APROBAR ADMINISTRACCION',
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



                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'APROBADO POR USUARIO CONTACTO');
                    //geolocalización


                }

                DB::commit();
                return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobante-us/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }
        else{


            $prefijocarperta        =   $this->prefijo_empresa($ordencompra->COD_EMPR);
            $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);
            $detallefedocumento     =   FeDetalleDocumento::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();
            if($fedocumento->nestadoCp === null or $fedocumento->nestadoCp === 'NO EXISTE'){

                //dd("hola");
                $rh                     =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                            ->where('COD_ESTADO','=',1)
                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                            ->get();
                $fechaemision           =   date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y');

                $token = '';
                if($prefijocarperta =='II'){
                    $token           =      $this->generartoken_ii();
                }else{
                    $token           =      $this->generartoken_is();
                }


                //$numero              =      $fedocumento->NUMERO;
                $numero              =      ltrim($fedocumento->NUMERO, '0');

                //dd($numero);

                if(count($rh)<=0){
                    //FACTURA
                    $rvalidar = $this->validar_xml( $token,
                                                    $fedocumento->ID_CLIENTE,
                                                    $fedocumento->RUC_PROVEEDOR,
                                                    $fedocumento->ID_TIPO_DOC,
                                                    $fedocumento->SERIE,
                                                    $numero,
                                                    $fechaemision,
                                                    $fedocumento->TOTAL_VENTA_ORIG);
                }else{
                    //RECIBO POR HONORARIO
                    $rvalidar = $this->validar_xml( $token,
                                                    $fedocumento->ID_CLIENTE,
                                                    $fedocumento->RUC_PROVEEDOR,
                                                    $fedocumento->ID_TIPO_DOC,
                                                    $fedocumento->SERIE,
                                                    $numero,
                                                    $fechaemision,
                                                    $fedocumento->TOTAL_VENTA_ORIG+$fedocumento->MONTO_RETENCION);
                }

                $arvalidar = json_decode($rvalidar, true);
                if(isset($arvalidar['success'])){

                    if($arvalidar['success']){

                        $datares              = $arvalidar['data'];
                        if (!isset($datares['estadoCp'])){
                            return Redirect::back()->with('errorurl', 'Hay fallas en sunat para consultar el XML');
                        }
                        
                        $estadoCp             = $datares['estadoCp'];


                        $tablaestacp          = Estado::where('tipo','=','estadoCp')->where('codigo','=',$estadoCp)->first();
                        //dd($tablaestacp);
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


                        FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
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

                        if($tablaestacp->codigo =='0' && $fedocumento->ID_TIPO_DOC == 'R1'){

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



                    }else{
                        FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
                                    ->update(
                                            [
                                                'success'=>$arvalidar['success'],
                                                'message'=>$arvalidar['message']
                                            ]);
                    }
                }




            }



            $tp                     =   CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();

            $arrayarchivos          =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->pluck('TIPO_ARCHIVO')
                                        ->toArray();

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();


            $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->whereNotIn('COD_CATEGORIA_DOCUMENTO', $arrayarchivos)
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
                                        ->get();
            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();

            $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
            $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;
            $ordencompra_f          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();


            //ANTICIPO
            $COD_EMPR               =   Session::get('empresas')->COD_EMPR;
            $COD_CENTRO             =   '';
            $FEC_CORTE              =   $this->hoy_sh;
            $CLIENTE                =   $ordencompra_f->COD_EMPR_CLIENTE;
            $COD_MONEDA             =   $ordencompra_f->COD_CATEGORIA_MONEDA;
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



            $rutasuspencion             =   '';
            $fedocumento_suspension     =   FeDocumento::where('ID_DOCUMENTO','=',$idoc)->where('ID_TIPO_DOC','=','R1')->first();
            //VALIDAR QUE SI TIENE CONSTANCIA DE SUSPENSION DE CUARTA LO SUBA SI NO QUE SUBA LA CONSTANCIA
            if(count($fedocumento_suspension)>0){

                if($ordencompra_f->CAN_TOTAL>1500 && $ordencompra_f->CAN_IMPUESTO_RENTA<=0){
                    $empresa_susp = STDEmpresa::where('COD_EMPR','=',$ordencompra_f->COD_EMPR_CLIENTE)->first();
                    $fecha_orden = $ordencompra_f->FEC_ORDEN;
                    $fechaObj = new DateTime($fecha_orden);
                    $anio = $fechaObj->format('Y');

                    $rentas = DB::table('PRO_RENTA_CUARTA_CATEGORIA')
                        ->where('RUC', $empresa_susp->NRO_DOCUMENTO)
                        ->where('COD_ESTADO', 'ETM0000000000005')
                        ->where('ANIO', $anio)
                        ->first();
                        //dd($rentas);

                    if(count($rentas)<=0){
                        return Redirect::back()->with('errorurl', 'Este Comprobante necesita la suspension de 4ta categoria que este aprobado por contabilidad');
                    }else{

                        $arentas = DB::table('ARCHIVOS')
                            ->where('ID_DOCUMENTO', $rentas->ID_DOCUMENTO)
                            ->first();
                        $rutasuspencion = $arentas->URL_ARCHIVO;

                        $doccompras     =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra_f->COD_ORDEN)
                                            ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000034')->where('COD_ESTADO','=',1)->first();
                        if(count($doccompras)<=0){
                            $docasociar                              =   New CMPDocAsociarCompra;
                            $docasociar->COD_ORDEN                   =   $ordencompra_f->COD_ORDEN;
                            $docasociar->COD_CATEGORIA_DOCUMENTO     =   'DCC0000000000034';
                            $docasociar->NOM_CATEGORIA_DOCUMENTO     =   'SUSPENSION DE 4TA CATEGORIA';
                            $docasociar->IND_OBLIGATORIO             =   0;
                            $docasociar->TXT_FORMATO                 =   'PDF';
                            $docasociar->TXT_ASIGNADO                =   'CONTACTO        ';
                            $docasociar->COD_USUARIO_CREA_AUD        =   Session::get('usuario')->id;
                            $docasociar->FEC_USUARIO_CREA_AUD        =   $this->fechaactual;
                            $docasociar->COD_ESTADO                  =   1;
                            $docasociar->TIP_DOC                     =   'N';
                            $docasociar->save();
                        }
                    }

                }

            }



            return View::make('comprobante/aprobaruc', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'monto_anticipo'        =>  $monto_anticipo,
                                'comboant'              =>  $comboant,


                                'ordencompra'           =>  $ordencompra,
                                'combobancos'           =>  $combobancos,
                                'ordencompra_f'         =>  $ordencompra_f,
                                'linea'                 =>  $linea,
                                'detalleordencompra'    =>  $detalleordencompra,
                                'detallefedocumento'    =>  $detallefedocumento,
                                'documentohistorial'    =>  $documentohistorial,

                                'trabajador'            =>  $trabajador,
                                'documentoscompra'      =>  $documentoscompra,
                                'totalarchivos'         =>  $totalarchivos,
                                'ordencompra_t'         =>  $ordencompra_t,
                                'archivosanulados'      =>  $archivosanulados,

                                'rutasuspencion'        =>  $rutasuspencion,
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


    public function actionAgregarObservacionUC($idopcion, $linea, $prefijo, $idordencompra,Request $request)
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
                    return Redirect::to('aprobar-comprobante-uc/'.$idopcion.'/'.$linea.'/'.$prefijo.'/'.$idordencompra)->with('errorbd', 'Tiene que seleccionar almenos un item');
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
                $documento->TIPO                        =   'OBSERVADO POR USUARIO CONTACTO';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'OBSERVADO POR USUARIO CONTACTO');
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'ind_observacion'=>1,
                                    'TXT_OBSERVADO'=>'OBSERVADO',
                                    'area_observacion'=>'UCO'
                                ]
                            );


                DB::commit();
                return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('bienhecho', 'Comprobante : '.$ordencompra->COD_ORDEN.' OBSERVADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-comprobante-us/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
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


    public function actionAgregarObservacionUCContrato($idopcion, $linea, $prefijo, $idordencompra,Request $request)
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


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'OBSERVADO POR ADMINISTRACION');
                //geolocalización


                FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$linea)
                            ->update(
                                [
                                    'ind_observacion'=>1,
                                    'TXT_OBSERVADO'=>'OBSERVADO',
                                    'area_observacion'=>'UCO'
                                ]
                            );
 
                DB::commit();

                Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('/gestion-de-comprobante-us/'.$idopcion)->with('bienhecho', 'Comprobante : '.$idoc.' OBSERVADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 

                Session::flash('operacion_id', 'CONTRATO');
                return Redirect::to('gestion-de-comprobante-us/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
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
        View::share('titulo','Aprobar  Comprobante Contrato');



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
                    $documento->TIPO                        =   'RECOMENDACION POR USUARIO DE CONTACTO';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();

                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$fedocumento,'RECOMENDACION POR USUARIO DE CONTACTO');
                    //geolocalización

                    
                }

                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            //->where('IND_OBLIGATORIO','=',1)
                                        ->where('TXT_ASIGNADO','=','CONTACTO')
                                        ->get();

                $orden              =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$pedido_id)->first();  



                /***GUARDAR CONTRATO SI SE CARGA***/
                $tarchivos            =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                            ->whereNotIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000003','DCC0000000000004','DCC0000000000002','DCC0000000000008'])
                                            //->whereIn('TXT_ASIGNADO', ['PROVEEDOR','CONTACTO'])
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

                //******************************** guardar los contratos ***********************************//
                $rutaorden       =   $request['rutaorden'];
                if($rutaorden!=''){
                    $existelarchivos   =   Archivo::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('TIPO_ARCHIVO','=',$item->COD_CATEGORIA_DOCUMENTO)->where('ACTIVO','=','1')->first();
                    if(count($existelarchivos)<=0){

                        $aoc                            =       CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                                                ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000026'])
                                                                ->first();
                        $contadorArchivos = Archivo::count();
                        $nombrefilecdr                  =       $contadorArchivos.'-'.$ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
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
                    $rutaordenguia           =  '';
                    $array_nuevo             =  array(
                                                    "COD_DOCUMENTO_CTBLE"       => $item->COD_DOCUMENTO_CTBLE,
                                                    "NRO_SERIE"                 => $item->NRO_SERIE,
                                                    "NRO_DOC"                   => $item->NRO_DOC,
                                                    "rutaordenguia"             => $rutaordenguia,
                                                );
                    array_push($array_guias,$array_nuevo);
                }
                //guardar guias remitentes del array
                foreach ($array_guias as $index=>$item) {
                    $filescdm          =   $request[$item['COD_DOCUMENTO_CTBLE']];
                        if(!is_null($filescdm)){
                            foreach($filescdm as $file){
                                $contadorArchivos = Archivo::count();
                                $nombre          =      $item['COD_DOCUMENTO_CTBLE'].'-'.$file->getClientOriginalName();
                                /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                                $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                                // $nombrefilecdr   =      $ordencompra->COD_ORDEN.'-'.$file->getClientOriginalName();
                                $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
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


                foreach ($lista_guias as $index=>$item) {

                    $existelarchivos   =   Archivo::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('TIPO_ARCHIVO','=',$item->COD_DOCUMENTO_CTBLE)->where('ACTIVO','=','1')->first();

                    if(count($existelarchivos)<=0){
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

                            $contadorArchivos = Archivo::count();
                            $nombrefilecdr                  =       $contadorArchivos.'-'.$item->COD_DOCUMENTO_CTBLE.'.pdf';
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
                }





                $monto_anticipo_txt     =   $request['monto_anticipo'];
                $MONTO_ANTICIPO_DESC    =   0.00;
                $COD_ANTICIPO           =   '';
                $SERIE_ANTICIPO         =   '';
                $NRO_ANTICIPO           =   '';

                if($monto_anticipo_txt!=''){

                    $ordencompra_f          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();
                    $COD_EMPR               =   Session::get('empresas')->COD_EMPR;
                    $COD_CENTRO             =   '';
                    $FEC_CORTE              =   $this->hoy_sh;
                    $CLIENTE                =   $ordencompra_f->COD_EMPR_EMISOR;
                    $COD_MONEDA             =   $ordencompra_f->COD_CATEGORIA_MONEDA;
                    $monto_anticipo         =   0.00;
                    //print_r("entro");

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


                    foreach ($listaanticipo as $index => $item) {
                        if($item['COD_HABILITACION'] == $monto_anticipo_txt){
                            $MONTO_ANTICIPO_DESC = (float)$item['CAN_SALDO'];
                            $COD_ANTICIPO = $item['COD_HABILITACION'];
                            $SERIE_ANTICIPO = $item['NRO_SERIE'];
                            $NRO_ANTICIPO = $item['NRO_DOC'];
                        }
                    }
                }

                //return Redirect::back()->with('errorurl', 'No se puede integrar ningun documento hasta proximo aviso');
                FeDocumento::where('ID_DOCUMENTO',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000004',
                                    'TXT_ESTADO'=>'POR APROBAR ADMINISTRACCION',
                                    'ind_email_ap'=>0,


                                    'MONTO_ANTICIPO_DESC'=>$MONTO_ANTICIPO_DESC,
                                    'COD_ANTICIPO'=>$COD_ANTICIPO,
                                    'SERIE_ANTICIPO'=>$SERIE_ANTICIPO,
                                    'NRO_ANTICIPO'=>$NRO_ANTICIPO,



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


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$fedocumento,'APROBADO POR USUARIO CONTACTO');
                //geolocalización


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

                $destinationFile = '\\\\10.1.0.201\\cpe\\Contratos\\'.$ordencompra->COD_DOCUMENTO_CTBLE.'.pdf';
                // Intenta copiar el archivo

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
                //dd($rutaorden);
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
            $array_guias_no              =   array();  


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
                    array_push($array_guias_no,$array_nuevo);            }
            }

            $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$idoc)
                                        ->where('ACTIVO','=','1')
                                        ->where('EXTENSION', 'like', '%'.'pdf'.'%')
                                        ->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)
                                        ->get();

            $archivos               =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();

            //dd($archivos);                          

            $procedencia ='ADM';


            $trabajador             =   STDTrabajador::where('NRO_DOCUMENTO','=',$fedocumento->dni_usuariocontacto)->first();
            $codigo_sunat           =   'N';

            $documentoscompra       =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                        ->where('COD_ESTADO','=',1)
                                        ->where('CODIGO_SUNAT','=',$codigo_sunat)
                                        ->get();

            $totalarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_DOCUMENTO_CTBLE)->where('COD_ESTADO','=',1)
                                        ->pluck('COD_CATEGORIA_DOCUMENTO')
                                        ->toArray();
            $archivosanulados       =   Archivo::where('ID_DOCUMENTO','=',$idoc)->where('ACTIVO','=','0')->where('DOCUMENTO_ITEM','=',$fedocumento->DOCUMENTO_ITEM)->get();


            $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
            $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;




          //ANTICIPO
            $COD_EMPR               =   Session::get('empresas')->COD_EMPR;
            $COD_CENTRO             =   '';
            $FEC_CORTE              =   $this->hoy_sh;
            $CLIENTE                =   $ordencompra->COD_EMPR_EMISOR;
            $COD_MONEDA             =   $ordencompra_f->COD_CATEGORIA_MONEDA;
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


            return View::make('comprobante/aprobaruccontrato', 
                            [
                                'fedocumento'           =>  $fedocumento,
                                'ordencompra'           =>  $ordencompra,
                                'linea'                 =>  $linea,
                                'arraybancos'           =>  $arraybancos,
                                'combobancos'           =>  $combobancos,

                                'comboant'              =>  $comboant,
                                'monto_anticipo'        =>  $monto_anticipo,

                                'archivosanulados'      =>  $archivosanulados,
                                'trabajador'            =>  $trabajador,
                                'documentoscompra'      =>  $documentoscompra,
                                'totalarchivos'         =>  $totalarchivos,

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
                                'array_guias_no'        =>  $array_guias_no,

                                'procedencia'           =>  $procedencia,                                
                            ]);


        }
    }


}
