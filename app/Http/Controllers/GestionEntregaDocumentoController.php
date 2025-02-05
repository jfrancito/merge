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
use App\Modelos\FeDocumentoEntregable;
use App\Modelos\STDEmpresa;
use App\Modelos\SGDUsuario;
use App\Modelos\WEBRol;
use App\Modelos\DeudaTotalMerge;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\CONRegistroCompras;


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
use Excel;

class GestionEntregaDocumentoController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;


    public function actionEntregableMasivoExcel($operacion_id,$idopcion)
    {
        set_time_limit(0);
        $cod_empresa            =   Session::get('usuario')->usuarioosiris_id;
        $fechadia               =   date_format(date_create(date('d-m-Y')), 'd-m-Y');
        $fecha_actual           =   date("Y-m-d");
        $titulo                 =   'Comprobantes-sin-folio-'.$operacion_id;
        $funcion                =   $this;
        $empresa_id             =   Session::get('empresas')->COD_EMPR;
        $area_id                =   'TODO';
        $rol                    =    WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();
        if($rol->ind_uc == 1 && (Session::get('usuario')->id != '1CIX00000075') ){
            $usuario    =   SGDUsuario::where('COD_USUARIO','=',Session::get('usuario')->name)->first();
            if(count($usuario)>0){
                $tp_area        =   CMPCategoria::where('COD_CATEGORIA','=',$usuario->COD_CATEGORIA_AREA)->first();
                $area_id        =   $tp_area->COD_CATEGORIA;
            }
        }
        if(Session::get('usuario')->id == '1CIX00000217'){
            $area_id        =   'TODO';
        }
        if($operacion_id=='ORDEN_COMPRA'){

            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_sinfolio($empresa_id,$area_id);
            Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
                $excel->sheet('ORDEN COMPRA', function($sheet) use ($listadatos,$titulo,$funcion) {

                    $sheet->loadView('reporte/excel/entregable/listaentregablemasivo')->with('listadatos',$listadatos)
                                                                       ->with('titulo',$titulo)
                                                                       ->with('funcion',$funcion);                                               
                });
            })->export('xls');

        }else{

            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_contrato_sinfolio($cod_empresa,$empresa_id);
            Excel::create($titulo.'-('.$fecha_actual.')', function($excel) use ($listadatos,$titulo,$funcion) {
                $excel->sheet('CONTRATO', function($sheet) use ($listadatos,$titulo,$funcion) {
                    $sheet->loadView('reporte/excel/entregable/listaentregablemasivocontrato')->with('listadatos',$listadatos)
                                                                       ->with('titulo',$titulo)
                                                                       ->with('funcion',$funcion);                                               
                });
            })->export('xls');

        }





    }



    public function actionListarEntregaDocumento($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Documentos para entrega');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        $fecha_inicio   =   $this->fecha_menos_diez_dias;
        $fecha_fin      =   $this->fecha_sin_hora;
        $proveedor_id   =   'TODO';
        $combo_proveedor=   $this->gn_combo_proveedor_fe_documento($proveedor_id);
        $estado_id      =   'TODO';
        $combo_estado   =   $this->gn_combo_estado_fe_documento($estado_id);
        $empresa_id     =   Session::get('empresas')->COD_EMPR;

        $combo_empresa  =   $this->gn_combo_empresa_empresa($empresa_id);
        $centro_id      =   'TODO';
        $combo_centro   =   $this->gn_combo_centro_r('TODO');


        $banco_id       =   'BAM0000000000001';
        $arraybancos    =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combobancos    =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;

        $area_id        =   'TODO';
        $combo_area     =   $this->gn_combo_area_usuario($estado_id);
        $rol            =    WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();



        if($rol->ind_uc == 1 && (Session::get('usuario')->id != '1CIX00000075') ){
            $usuario    =   SGDUsuario::where('COD_USUARIO','=',Session::get('usuario')->name)->first();
            if(count($usuario)>0){
                $tp_area        =   CMPCategoria::where('COD_CATEGORIA','=',$usuario->COD_CATEGORIA_AREA)->first();
                $area_id        =   $tp_area->COD_CATEGORIA;
                $combo_area     =   array($tp_area->COD_CATEGORIA => $tp_area->NOM_CATEGORIA);
            }
        }


        if(Session::get('usuario')->id == '1CIX00000217'){
            $area_id        =   'TODO';
            $combo_area     =   $this->gn_combo_area_usuario($estado_id);

        }

        $operacion_id       =   'ORDEN_COMPRA';

        //$operacion_id       =   'ESTIBA';

        //falta usuario contacto
        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }
        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO','ESTIBA' => 'ESTIBA');
        $combo_operacion    =   array(  'ORDEN_COMPRA' => 'ORDEN COMPRA',
                                        'CONTRATO' => 'CONTRATO',
                                        'ESTIBA' => 'ESTIBA',
                                        'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
                                        'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
                                        'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA'
                                    );


        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA');
        $array_canjes               =   $this->con_array_canjes();



        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$banco_id);
        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$banco_id);
            }else{
                if (in_array($operacion_id, $array_canjes)) {
                    $categoria_id       =   $this->con_categoria_canje($operacion_id);
                    $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_estiba($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$banco_id,$operacion_id);
                }
            }
        }

        $entregable_sel                 =   FeDocumentoEntregable::where('COD_CATEGORIA_ESTADO','=','ETM0000000000001')
                                            ->where('COD_ESTADO','=','1')
                                            ->where('SELECCION','=','1')
                                            ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                            ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                            ->first();

        $funcion        =   $this;
        return View::make('entregadocumento/listaentregadocumento',
                         [
                            'listadatos'        =>  $listadatos,
                            'entregable_sel'    =>  $entregable_sel,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin,
                            'proveedor_id'      =>  $proveedor_id,
                            'combo_proveedor'   =>  $combo_proveedor,
                            'estado_id'         =>  $estado_id,
                            'combo_estado'      =>  $combo_estado,
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,
                            'empresa_id'        =>  $empresa_id,
                            'combo_empresa'     =>  $combo_empresa,
                            'centro_id'         =>  $centro_id,
                            'combo_centro'      =>  $combo_centro,

                            'banco_id'          =>  $banco_id,
                            'combobancos'       =>  $combobancos,

                            'area_id'           =>  $area_id,
                            'combo_area'        =>  $combo_area
                         ]);
    }



    public function actionListarAjaxBuscarDocumentoEntregable(Request $request) {

        $fecha_inicio   =   $request['fecha_inicio'];
        $fecha_fin      =   $request['fecha_fin'];
        $empresa_id     =   $request['empresa_id'];  
        $centro_id      =   $request['centro_id'];
        $idopcion       =   $request['idopcion'];

        $operacion_id   =   $request['operacion_id'];
        $area_id        =   $request['area_id'];
        $banco_id        =   $request['banco_id'];


        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$banco_id);
        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$banco_id);
            }else{
                $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_estiba($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$banco_id,$operacion_id);
            }
        }

        $funcion        =   $this;

        $entregable_sel                 =   FeDocumentoEntregable::where('COD_CATEGORIA_ESTADO','=','ETM0000000000001')
                                            ->where('COD_ESTADO','=','1')
                                            ->where('SELECCION','=','1')
                                            ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                            ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                            ->first();


        return View::make('entregadocumento/ajax/mergelistaentregable',
                         [
                            'fecha_inicio'          =>  $fecha_inicio,
                            'entregable_sel'        =>  $entregable_sel,
                            'fecha_fin'             =>  $fecha_fin,
                            'empresa_id'            =>  $empresa_id,
                            'centro_id'             =>  $centro_id,
                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'operacion_id'            =>  $operacion_id,
                            'funcion'               =>  $funcion
                         ]);
    }



    public function actionListarAjaxModalMasivoEntregable(Request $request) {

        $datastring     =   $request['datastring'];
        $funcion        =   $this;

        return View::make('entregadocumento/modal',
                         [
                            'fecha_inicio'          =>  $fecha_inicio,
                            'fecha_fin'             =>  $fecha_fin,
                            'empresa_id'            =>  $empresa_id,
                            'centro_id'             =>  $centro_id,
                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'operacion_id'            =>  $operacion_id,
                            'funcion'               =>  $funcion
                         ]);
    }



    public function actionGuardarMavisoEntregable(Request $request) {





        $fecha_inicio       =   $request['fecha_inicio'];
        $fecha_fin          =   $request['fecha_fin'];  
        $area_id            =   $request['area_id'];
        $empresa_id         =   $request['empresa_id'];
        $centro_id          =   $request['centro_id'];
        $operacion_id       =   $request['operacion_id'];
        $idopcion           =   $request['idopcion'];
        $glosa              =   $request['glosa'];

        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        $respuesta          =   json_decode($request['datastring'], true);


        //dd($respuesta);

        try{    

            DB::beginTransaction();
            foreach($respuesta as $obj){
                $ID_DOCUMENTO_ENCONTRO             =   $obj['data_requerimiento_id'];
            }

            //dd($ID_DOCUMENTO_ENCONTRO);

            $empresa_id     =   Session::get('empresas')->COD_EMPR;
            $fedocumento_encontro                   =   FeDocumento::where('ID_DOCUMENTO',$ID_DOCUMENTO_ENCONTRO)->first();
            if(count($fedocumento_encontro)<=0){

            }

            $codigo                                 =   $this->funciones->generar_folio('FE_DOCUMENTO_ENTREGABLE',8);
            $documento                              =   new FeDocumentoEntregable;
            $documento->FOLIO                       =   $codigo;
            $documento->CAN_FOLIO                   =   count($respuesta);
            $documento->COD_ESTADO                  =   1;
            $documento->USUARIO_CREA                =   Session::get('usuario')->id;
            $documento->FECHA_CREA                  =   $this->fechaactual;
            $documento->OPERACION                   =   $fedocumento_encontro->OPERACION;
            $documento->COD_EMPRESA                 =   $empresa_id;
            $documento->COD_CATEGORIA_BANCO         =   $fedocumento_encontro->COD_CATEGORIA_BANCO;
            $documento->TXT_CATEGORIA_BANCO         =   $fedocumento_encontro->TXT_CATEGORIA_BANCO;
            $documento->TXT_GLOSA                   =   $glosa;
            $documento->save();
            foreach($respuesta as $obj){
                $ID_DOCUMENTO                       =   $obj['data_requerimiento_id'];
                FeDocumento::where('ID_DOCUMENTO',$ID_DOCUMENTO)
                            ->update(
                                [
                                    'FOLIO'=>$codigo
                                ]
                            );
            }

            DB::commit();
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('gestion-de-entrega-documentos/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$fedocumento_encontro->COD_CATEGORIA_BANCO);
        }else{
            if($operacion_id=='CONTRATO'){
                $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$fedocumento_encontro->COD_CATEGORIA_BANCO);
            }else{
                $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_estiba($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id,$fedocumento_encontro->COD_CATEGORIA_BANCO);
            }
        }

        $funcion        =   $this;
        $mensaje        =   'Se realizo la integracion en el folio : '.$codigo; 

        return View::make('entregadocumento/ajax/mergelistaentregable',
                         [
                            'fecha_inicio'          =>  $fecha_inicio,
                            'fecha_fin'             =>  $fecha_fin,
                            'empresa_id'            =>  $empresa_id,
                            'centro_id'             =>  $centro_id,
                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'operacion_id'          =>  $operacion_id,
                            'mensaje'               =>  $mensaje,
                            'funcion'               =>  $funcion
                         ]);
    }



    


    public function actionListarEntregaDocumentoFolio($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista de Folio de Documentos');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $empresa_id     =   Session::get('empresas')->COD_EMPR;

        $rol            =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

        $operacion_id       =   'ORDEN_COMPRA';
        //falta usuario contacto
        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }

        if($rol->ind_uc == 1){
            $listadatos     =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->where('OPERACION','like','%'.$operacion_id.'%')
                                ->where('COD_ESTADO','=','1')
                                ->where('COD_CATEGORIA_ESTADO','=','ETM0000000000005')
                                ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                ->orderBy('FE_DOCUMENTO_ENTREGABLE.FECHA_CREA','DESC')
                                ->get();
        }else{
            $listadatos     =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->where('OPERACION','like','%'.$operacion_id.'%')
                                ->where('COD_ESTADO','=','1')
                                ->where('COD_CATEGORIA_ESTADO','=','ETM0000000000005')
                                ->orderBy('FE_DOCUMENTO_ENTREGABLE.FECHA_CREA','DESC')
                                ->get();
        }

        $usuario_id     =   Session::get('usuario')->id;
        $array_jefes    =   $this->array_usuario_jefes_folio();

        if(in_array($usuario_id, $array_jefes)){
            $listadatos     =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->where('COD_ESTADO','=','1')
                                //->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                ->where('OPERACION','=','ORDEN_COMPRA')
                                ->orderBy('FE_DOCUMENTO_ENTREGABLE.FECHA_CREA','DESC')
                                ->get();
        }

        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO','ESTIBA' => 'ESTIBA');

        $combo_operacion    =   array(  'ORDEN_COMPRA' => 'ORDEN COMPRA',
                                        'CONTRATO' => 'CONTRATO',
                                        'ESTIBA' => 'ESTIBA',
                                        'DOCUMENTO_INTERNO_PRODUCCION' => 'DOCUMENTO INTERNO PRODUCCION',
                                        'DOCUMENTO_INTERNO_SECADO' => 'DOCUMENTO INTERNO SECADO',
                                        'DOCUMENTO_SERVICIO_BALANZA' => 'DOCUMENTO POR SERVICIO DE BALANZA'
                                    );

        $funcion        =   $this;
        return View::make('entregadocumento/listaentregadocumentofolio',
                         [
                            'listadatos'        =>  $listadatos,
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }



    public function actionListarAjaxBuscarDocumentoEntregableFolio(Request $request) {

        $idopcion       =   $request['idopcion'];
        $operacion_id   =   $request['operacion_id'];
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $empresa_id     =   Session::get('empresas')->COD_EMPR;

        $rol            =   WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();



        if($rol->ind_uc == 1){
            $listadatos     =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->where('OPERACION','like','%'.$operacion_id.'%')
                                ->where('COD_ESTADO','=','1')
                                ->where('COD_CATEGORIA_ESTADO','=','ETM0000000000005')
                                ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                ->orderBy('FE_DOCUMENTO_ENTREGABLE.FECHA_CREA','DESC')
                                ->get();
        }else{
            $listadatos     =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->where('OPERACION','like','%'.$operacion_id.'%')
                                ->where('COD_ESTADO','=','1')
                                ->where('COD_CATEGORIA_ESTADO','=','ETM0000000000005')
                                ->orderBy('FE_DOCUMENTO_ENTREGABLE.FECHA_CREA','DESC')
                                ->get();
        }
        $funcion        =   $this;

        return View::make('entregadocumento/ajax/listafoliosdocumentos',
                         [

                            'empresa_id'            =>  $empresa_id,
                            'idopcion'              =>  $idopcion,
                            'cod_empresa'           =>  $cod_empresa,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'operacion_id'            =>  $operacion_id,
                            'funcion'               =>  $funcion
                         ]);
    }



    public function actionDescargarDocumentoFolio($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                    ->where('FOLIO','=',$folio_codigo)->first();

        $listadatossolesotro    =   array();
        $listadatosdolarotro    =   array();

        if($folio->OPERACION=='ORDEN_COMPRA'){
            $listadatossoles    =   $this->con_lista_cabecera_comprobante_entregable_modal_moneda($folio->FOLIO,'MON0000000000001');

            //dd($listadatossoles);
            $listadatosdolar    =   $this->con_lista_cabecera_comprobante_entregable_modal_moneda($folio->FOLIO,'MON0000000000002');
            $listadatossolesotro=   $this->con_lista_cabecera_comprobante_entregable_estiba_modal_moneda_union($folio->FOLIO,'MON0000000000001');
            $listadatosdolarotro=   $this->con_lista_cabecera_comprobante_entregable_estiba_modal_moneda_union($folio->FOLIO,'MON0000000000002');
        }else{
            if($folio->OPERACION=='CONTRATO'){
                $listadatossoles    =   $this->con_lista_cabecera_comprobante_entregable_contrato_modal_moneda($folio->FOLIO,'MON0000000000001');
                $listadatosdolar    =   $this->con_lista_cabecera_comprobante_entregable_contrato_modal_moneda($folio->FOLIO,'MON0000000000002');
            }else{
                $listadatossoles    =   $this->con_lista_cabecera_comprobante_entregable_modal_moneda($folio->FOLIO,'MON0000000000001');
                $listadatosdolar    =   $this->con_lista_cabecera_comprobante_entregable_modal_moneda($folio->FOLIO,'MON0000000000002');
                $listadatossolesotro=   $this->con_lista_cabecera_comprobante_entregable_estiba_modal_moneda_union($folio->FOLIO,'MON0000000000001');
                $listadatosdolarotro=   $this->con_lista_cabecera_comprobante_entregable_estiba_modal_moneda_union($folio->FOLIO,'MON0000000000002');
            }
        }
        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'FOLIO('.$folio_codigo.') '.$empresa->NOM_EMPR;
        $funcion                =   $this;

        Excel::create($titulo, function($excel) use ($listadatossoles,$listadatosdolar,$listadatossolesotro,$listadatosdolarotro,$operacion_id,$funcion,$folio,$empresa) {

            $excel->sheet('Soles', function($sheet) use ($listadatossoles,$listadatossolesotro,$operacion_id,$funcion,$folio,$empresa){

                $sheet->setSelectedCells('C1');

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 40);
                $sheet->setWidth('E', 40);
                $sheet->setWidth('F', 30);
                $sheet->setWidth('G', 30);
                $sheet->setWidth('H', 30);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 30);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);
                $sheet->setWidth('O', 20);


                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });

                $sheet->loadView('entregadocumento/excel/eentregable')->with('listadatos',$listadatossoles)
                                                                      ->with('listadatosotro',$listadatossolesotro)
                                                                      ->with('funcion',$funcion)
                                                                      ->with('folio',$folio)
                                                                      ->with('empresa',$empresa)
                                                                      ->with('operacion_id',$operacion_id);         
            });

            $excel->sheet('Dolares', function($sheet) use ($listadatosdolar,$listadatosdolarotro,$operacion_id,$funcion,$folio,$empresa){

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 40);
                $sheet->setWidth('E', 40);
                $sheet->setWidth('F', 30);
                $sheet->setWidth('G', 30);
                $sheet->setWidth('H', 30);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 30);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);
                $sheet->setWidth('O', 20);
                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });

                $sheet->loadView('entregadocumento/excel/eentregable')->with('listadatos',$listadatosdolar)
                                                                      ->with('listadatosotro',$listadatosdolarotro)
                                                                      ->with('funcion',$funcion)
                                                                       ->with('folio',$folio)
                                                                       ->with('empresa',$empresa)
                                                                      ->with('operacion_id',$operacion_id);       
            });

        })->setActiveSheetIndex(0)->export('xls');


    }

    public function actionDescargarPagoFolioBcp($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::where('FOLIO','=',$folio_codigo)->first();
        $lista_proveedores      =   $this->con_lista_proveedores_folio($folio->FOLIO);
        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'DETALLE FOLIO ('.$folio_codigo.') '.$empresa->NOM_EMPR;
        $funcion                =   $this;


        Excel::create($titulo, function($excel) use ($lista_proveedores,$operacion_id,$folio,$empresa,$funcion) {

            foreach($lista_proveedores as $index => $item){

                $empresa_item   =    STDEmpresa::where('COD_EMPR','=',$item->COD_EMPR_EMISOR)->first();
                $fedocumento    =    FeDocumento::where('FOLIO','=',$folio->FOLIO)->where('RUC_PROVEEDOR','=',$empresa_item->NRO_DOCUMENTO)->first();


                $listadocumento =    $this->con_lista_documentos_proveedores_folio($folio->FOLIO,$empresa_item->NRO_DOCUMENTO);
                $npestania = substr($item->TXT_EMPR_EMISOR, 0, 30);
                $excel->sheet($npestania, function($sheet) use ($item,$operacion_id,$folio,$empresa,$empresa_item,$fedocumento,$listadocumento,$funcion){

                    $sheet->mergeCells('B2:D2');
                    $sheet->mergeCells('B3:D3');
                    $sheet->mergeCells('B4:D4');
                    $sheet->mergeCells('B6:D6');
                    $sheet->mergeCells('A9:G9');

                    $sheet->setWidth('A', 20);
                    $sheet->setWidth('B', 20);
                    $sheet->setWidth('C', 20);
                    $sheet->setWidth('D', 20);
                    $sheet->setWidth('E', 20);
                    $sheet->setWidth('F', 20);
                    $sheet->setWidth('G', 20);
                    $sheet->setWidth('H', 20);
                    $sheet->setWidth('I', 20);
                    $sheet->setWidth('J', 20);
                    $sheet->setWidth('K', 20);

                    $sheet->cell('A1', function($cell) {
                                $cell->setFontColor('#FFFFFF');   // Texto blanco
                            });


                    $sheet->loadView('entregadocumento/excel/contratopagosbcp')->with('proveedor',$item)
                                                                               ->with('folio',$folio)
                                                                               ->with('funcion',$funcion)
                                                                               ->with('empresa',$empresa)
                                                                               ->with('empresa_item',$empresa_item)
                                                                               ->with('fedocumento',$fedocumento)
                                                                               ->with('listadocumento',$listadocumento)
                                                                               ->with('operacion_id',$operacion_id);         
                });
            }

        })->export('xls');
    }

    public function actionDescargarPagoFolioEstibaBcp($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::where('FOLIO','=',$folio_codigo)->first();
        $lista_proveedores      =   $this->con_lista_proveedores_estiba_folio($folio->FOLIO);
        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'DETALLE FOLIO ('.$folio_codigo.') '.$empresa->NOM_EMPR;
        $funcion                =   $this;


        Excel::create($titulo, function($excel) use ($lista_proveedores,$operacion_id,$folio,$empresa,$funcion) {

            foreach($lista_proveedores as $index => $item){

                $empresa_item   =    STDEmpresa::where('COD_EMPR','=',$item->COD_EMPR_EMISOR)->first();
                $fedocumento    =    FeDocumento::where('FOLIO','=',$folio->FOLIO)->where('RUC_PROVEEDOR','=',$empresa_item->NRO_DOCUMENTO)->first();

                $listadocumento =    $this->con_lista_documentos_proveedores_estiba_folio($folio->FOLIO,$empresa_item->NRO_DOCUMENTO);
                $npestania = substr($item->TXT_EMPR_EMISOR, 0, 30);
                $excel->sheet($npestania, function($sheet) use ($item,$operacion_id,$folio,$empresa,$empresa_item,$fedocumento,$listadocumento,$funcion){

                    $sheet->mergeCells('B2:D2');
                    $sheet->mergeCells('B3:D3');
                    $sheet->mergeCells('B4:D4');
                    $sheet->mergeCells('B6:D6');
                    $sheet->mergeCells('A9:G9');

                    $sheet->setWidth('A', 20);
                    $sheet->setWidth('B', 20);
                    $sheet->setWidth('C', 20);
                    $sheet->setWidth('D', 20);
                    $sheet->setWidth('E', 20);
                    $sheet->setWidth('F', 20);
                    $sheet->setWidth('G', 20);
                    $sheet->setWidth('H', 20);
                    $sheet->setWidth('I', 20);
                    $sheet->setWidth('J', 20);
                    $sheet->setWidth('K', 20);

                    $sheet->cell('A1', function($cell) {
                                $cell->setFontColor('#FFFFFF');   // Texto blanco
                            });


                    $sheet->loadView('entregadocumento/excel/contratopagosestibabcp')->with('proveedor',$item)
                                                                               ->with('folio',$folio)
                                                                               ->with('funcion',$funcion)
                                                                               ->with('empresa',$empresa)
                                                                               ->with('empresa_item',$empresa_item)
                                                                               ->with('fedocumento',$fedocumento)
                                                                               ->with('listadocumento',$listadocumento)
                                                                               ->with('operacion_id',$operacion_id);         
                });
            }

        })->export('xls');
    }


    public function actionDescargarPagoMacroEstibaBbva($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                    ->where('FOLIO','=',$folio_codigo)->first();
        $listadocumento         =    $this->con_lista_documentos_estiba_folio($folio->FOLIO);

        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO BBVA ('.$folio_codigo.') '.$empresa->NOM_EMPR;
        $funcion                =   $this;


        Excel::create($titulo, function($excel) use ($listadocumento,$operacion_id,$folio,$empresa,$funcion) {

            $excel->sheet('bbva', function($sheet) use ($operacion_id,$folio,$empresa,$listadocumento,$funcion){


                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 20);
                $sheet->setWidth('E', 20);
                $sheet->setWidth('F', 20);
                $sheet->setWidth('G', 20);
                $sheet->setWidth('H', 20);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 20);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });
                $sheet->loadView('entregadocumento/excel/contratopagosbbvamacro')->with('folio',$folio)
                                                                                ->with('empresa',$empresa)
                                                                                ->with('funcion',$funcion)
                                                                                ->with('listadocumento',$listadocumento)
                                                                                ->with('operacion_id',$operacion_id);         
            });

        })->export('xls');
    }

    public function actionDescargarPagoMacroBbva($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                    ->where('FOLIO','=',$folio_codigo)->first();
        $listadocumento         =    $this->con_lista_documentos_contrato_folio($folio->FOLIO);

        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO BBVA ('.$folio_codigo.') '.$empresa->NOM_EMPR;
        $funcion                =   $this;


        Excel::create($titulo, function($excel) use ($listadocumento,$operacion_id,$folio,$empresa,$funcion) {

            $excel->sheet('bbva', function($sheet) use ($operacion_id,$folio,$empresa,$listadocumento,$funcion){


                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 20);
                $sheet->setWidth('E', 20);
                $sheet->setWidth('F', 20);
                $sheet->setWidth('G', 20);
                $sheet->setWidth('H', 20);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 20);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });
                $sheet->loadView('entregadocumento/excel/contratopagosbbvamacro')->with('folio',$folio)
                                                                                ->with('empresa',$empresa)
                                                                                ->with('funcion',$funcion)
                                                                                ->with('listadocumento',$listadocumento)
                                                                                ->with('operacion_id',$operacion_id);         
            });

        })->export('xls');
    }

    public function actionDescargarPagoMacroBbvaOC($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                    ->where('FOLIO','=',$folio_codigo)->first();
        $listadocumento         =    $this->con_lista_documentos_contrato_folio_oc($folio->FOLIO);
        $listaotros             =    $this->con_lista_documentos_estiba_folio($folio->FOLIO);

        $operacion_id           =    $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO BBVA ('.$folio_codigo.') '.$empresa->NOM_EMPR;
        $funcion                =   $this;


        Excel::create($titulo, function($excel) use ($listadocumento,$listaotros,$operacion_id,$folio,$empresa,$funcion) {

            $excel->sheet('bbva', function($sheet) use ($operacion_id,$folio,$empresa,$listadocumento,$listaotros,$funcion){


                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 20);
                $sheet->setWidth('E', 20);
                $sheet->setWidth('F', 20);
                $sheet->setWidth('G', 20);
                $sheet->setWidth('H', 20);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 20);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });
                $sheet->loadView('entregadocumento/excel/contratopagosbbvamacrooc')->with('folio',$folio)
                                                                                ->with('empresa',$empresa)
                                                                                ->with('funcion',$funcion)
                                                                                ->with('listadocumento',$listadocumento)
                                                                                ->with('listaotros',$listaotros)
                                                                                ->with('operacion_id',$operacion_id);         
            });

        })->export('xls');
    }


    public function actionDescargarPagoMacroSBK($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                    ->where('FOLIO','=',$folio_codigo)->first();
        $listadocumento         =    $this->con_lista_documentos_contrato_folio($folio->FOLIO);

        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO SBK ('.$folio_codigo.') '.$empresa->NOM_EMPR;
        $funcion                =   $this;


        Excel::create($titulo, function($excel) use ($listadocumento,$operacion_id,$folio,$empresa,$funcion) {

            $excel->sheet('bbva', function($sheet) use ($operacion_id,$folio,$empresa,$listadocumento,$funcion){

                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 20);
                $sheet->setWidth('E', 20);
                $sheet->setWidth('F', 20);
                $sheet->setWidth('G', 20);
                $sheet->setWidth('H', 20);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 20);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });
                $sheet->loadView('entregadocumento/excel/contratopagossbkmacro')->with('folio',$folio)
                                                                                ->with('empresa',$empresa)
                                                                                ->with('funcion',$funcion)
                                                                                ->with('listadocumento',$listadocumento)
                                                                                ->with('operacion_id',$operacion_id);         
            });

        })->export('xls');
    }


    public function actionDescargarPagoMacroEstibaSBK($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                    ->where('FOLIO','=',$folio_codigo)->first();
        $listadocumento         =    $this->con_lista_documentos_estiba_folio($folio->FOLIO);

        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO SBK ('.$folio_codigo.') '.$empresa->NOM_EMPR;
        $funcion                =   $this;


        Excel::create($titulo, function($excel) use ($listadocumento,$operacion_id,$folio,$empresa,$funcion) {

            $excel->sheet('sbk', function($sheet) use ($operacion_id,$folio,$empresa,$listadocumento,$funcion){

                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 20);
                $sheet->setWidth('E', 20);
                $sheet->setWidth('F', 20);
                $sheet->setWidth('G', 20);
                $sheet->setWidth('H', 20);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 20);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });
                $sheet->loadView('entregadocumento/excel/contratopagossbkmacro')->with('folio',$folio)
                                                                                ->with('empresa',$empresa)
                                                                                ->with('funcion',$funcion)
                                                                                ->with('listadocumento',$listadocumento)
                                                                                ->with('operacion_id',$operacion_id);         
            });

        })->export('xls');
    }

    public function actionDescargarPagoMacroSBKOC($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                    ->where('FOLIO','=',$folio_codigo)->first();
        $listadocumento         =    $this->con_lista_documentos_contrato_folio_oc($folio->FOLIO);
        $listaotros             =    $this->con_lista_documentos_estiba_folio($folio->FOLIO);


        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO SBK ('.$folio_codigo.') '.$empresa->NOM_EMPR;
        $funcion                =   $this;


        Excel::create($titulo, function($excel) use ($listadocumento,$listaotros,$operacion_id,$folio,$empresa,$funcion) {

            $excel->sheet('skb', function($sheet) use ($operacion_id,$folio,$empresa,$listadocumento,$listaotros,$funcion){

                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 20);
                $sheet->setWidth('E', 20);
                $sheet->setWidth('F', 20);
                $sheet->setWidth('G', 20);
                $sheet->setWidth('H', 20);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 20);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });
                $sheet->loadView('entregadocumento/excel/contratopagossbkmacrooc')->with('folio',$folio)
                                                                                ->with('empresa',$empresa)
                                                                                ->with('funcion',$funcion)
                                                                                ->with('listadocumento',$listadocumento)
                                                                                ->with('listaotros',$listaotros)
                                                                                ->with('operacion_id',$operacion_id);         
            });

        })->export('xls');
    }


    public function actionDescargarPagoMacrosInterbank($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                    ->where('FOLIO','=',$folio_codigo)->first();
        $listadocumento         =    $this->con_lista_documentos_contrato_folio($folio->FOLIO);

        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO INTERBANK ('.$folio_codigo.') '.$empresa->NOM_EMPR;

        $funcion                =   $this;

        Excel::create($titulo, function($excel) use ($listadocumento,$operacion_id,$folio,$empresa,$funcion) {

            $excel->sheet('interbank', function($sheet) use ($operacion_id,$folio,$empresa,$listadocumento,$funcion){

                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 20);
                $sheet->setWidth('E', 20);
                $sheet->setWidth('F', 20);
                $sheet->setWidth('G', 20);
                $sheet->setWidth('H', 20);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 20);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });
                $sheet->loadView('entregadocumento/excel/contratopagosinterbankmacro')->with('folio',$folio)
                                                                                ->with('empresa',$empresa)
                                                                                ->with('funcion',$funcion)
                                                                                ->with('listadocumento',$listadocumento)
                                                                                ->with('operacion_id',$operacion_id);         
            });

        })->export('xls');
    }

    public function actionDescargarPagoMacrosEstibaInterbank($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                    ->where('FOLIO','=',$folio_codigo)->first();
        $listadocumento         =    $this->con_lista_documentos_estiba_folio($folio->FOLIO);

        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO INTERBANK ('.$folio_codigo.') '.$empresa->NOM_EMPR;

        $funcion                =   $this;

        Excel::create($titulo, function($excel) use ($listadocumento,$operacion_id,$folio,$empresa,$funcion) {

            $excel->sheet('interbank', function($sheet) use ($operacion_id,$folio,$empresa,$listadocumento,$funcion){

                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 20);
                $sheet->setWidth('E', 20);
                $sheet->setWidth('F', 20);
                $sheet->setWidth('G', 20);
                $sheet->setWidth('H', 20);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 20);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });
                $sheet->loadView('entregadocumento/excel/contratopagosinterbankmacro')->with('folio',$folio)
                                                                                ->with('empresa',$empresa)
                                                                                ->with('funcion',$funcion)
                                                                                ->with('listadocumento',$listadocumento)
                                                                                ->with('operacion_id',$operacion_id);         
            });

        })->export('xls');
    }

    public function actionDescargarPagoMacrosInterbankOC($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                    ->where('FOLIO','=',$folio_codigo)->first();

        $listadocumento         =    $this->con_lista_documentos_contrato_folio_oc($folio->FOLIO);
        $listaotros             =    $this->con_lista_documentos_estiba_folio($folio->FOLIO);

        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO INTERBANK ('.$folio_codigo.') '.$empresa->NOM_EMPR;

        $funcion                =   $this;

        Excel::create($titulo, function($excel) use ($listadocumento,$listaotros,$operacion_id,$folio,$empresa,$funcion) {

            $excel->sheet('interbank', function($sheet) use ($operacion_id,$folio,$empresa,$listadocumento,$listaotros,$funcion){

                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('B3:C3');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');

                $sheet->setWidth('A', 20);
                $sheet->setWidth('B', 20);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 20);
                $sheet->setWidth('E', 20);
                $sheet->setWidth('F', 20);
                $sheet->setWidth('G', 20);
                $sheet->setWidth('H', 20);
                $sheet->setWidth('I', 20);
                $sheet->setWidth('J', 20);
                $sheet->setWidth('K', 20);
                $sheet->setWidth('L', 20);
                $sheet->setWidth('M', 20);
                $sheet->setWidth('N', 20);

                $sheet->cell('A1', function($cell) {
                            $cell->setFontColor('#FFFFFF');   // Texto blanco
                        });
                $sheet->loadView('entregadocumento/excel/contratopagosinterbankmacrooc')->with('folio',$folio)
                                                                                ->with('empresa',$empresa)
                                                                                ->with('funcion',$funcion)
                                                                                ->with('listadocumento',$listadocumento)
                                                                                ->with('listaotros',$listaotros)
                                                                                ->with('operacion_id',$operacion_id);         
            });

        })->export('xls');
    }


    public function actionDescargarPagoFolioMacroEstiba($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::where('FOLIO','=',$folio_codigo)->first();
        $lista_bancos           =   $this->con_lista_bancos_estiba_folio($folio->FOLIO);

        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO FOLIO ('.$folio_codigo.') '.$empresa->NOM_EMPR;

        Excel::create($titulo, function($excel) use ($lista_bancos,$operacion_id,$folio,$empresa) {

            foreach($lista_bancos as $index => $item){

                $txt_banco = 'SIN BANCO';
                if (is_null($item->TXT_CATEGORIA_BANCO) or $item->TXT_CATEGORIA_BANCO == '') {
                    $txt_banco = 'SIN BANCO';
                }else{
                    $txt_banco = $item->TXT_CATEGORIA_BANCO;
                }
                $fedocumento    =    FeDocumento::where('FOLIO','=',$folio->FOLIO)->where('TXT_CATEGORIA_BANCO','=',$item->TXT_CATEGORIA_BANCO)->first();
                
                $listafedocu    =   $this->con_lista_proveedores_banco_estiba_folio($folio->FOLIO,$item->TXT_CATEGORIA_BANCO);
                $countfedocu    =    str_pad(count($listafedocu), 6, '0', STR_PAD_LEFT);
                $listadocumento =   $this->con_lista_doc_proveedor_banco_estiba_folio($folio->FOLIO,$item->TXT_CATEGORIA_BANCO);




                $npestania = substr($txt_banco, 0, 30);

                $excel->sheet($npestania, function($sheet) use ($item,$operacion_id,$folio,$empresa,$fedocumento,$listadocumento,$txt_banco,$countfedocu){

                    $sheet->setWidth('A', 20);
                    $sheet->setWidth('B', 20);
                    $sheet->setWidth('C', 20);
                    $sheet->setWidth('D', 20);
                    $sheet->setWidth('E', 20);
                    $sheet->setWidth('F', 20);
                    $sheet->setWidth('G', 20);
                    $sheet->setWidth('H', 20);
                    $sheet->setWidth('I', 20);
                    $sheet->setWidth('J', 20);
                    $sheet->setWidth('K', 20);

                    $sheet->setCellValueExplicit('E8', $empresa->NRO_CUENTA_BANCARIA, \PHPExcel_Cell_DataType::TYPE_STRING);


                    $sheet->cell('A1', function($cell) {
                                $cell->setFontColor('#FFFFFF');   // Texto blanco
                            });

                    $sheet->loadView('entregadocumento/excel/contratopagosmacro')->with('banco',$item)
                                                                               ->with('folio',$folio)
                                                                               ->with('empresa',$empresa)
                                                                               ->with('txt_banco',$txt_banco)
                                                                               ->with('countfedocu',$countfedocu)
                                                                               ->with('fedocumento',$fedocumento)
                                                                               ->with('listadocumento',$listadocumento)
                                                                               ->with('operacion_id',$operacion_id);         
                });
            }

        })->export('xls');
    }



    public function actionDescargarPagoFolioMacro($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::where('FOLIO','=',$folio_codigo)->first();
        $lista_bancos           =   $this->con_lista_bancos_folio($folio->FOLIO);
        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO FOLIO ('.$folio_codigo.') '.$empresa->NOM_EMPR;

        Excel::create($titulo, function($excel) use ($lista_bancos,$operacion_id,$folio,$empresa) {

            foreach($lista_bancos as $index => $item){

                $txt_banco = 'SIN BANCO';
                if (is_null($item->TXT_CATEGORIA_BANCO) or $item->TXT_CATEGORIA_BANCO == '') {
                    $txt_banco = 'SIN BANCO';
                }else{
                    $txt_banco = $item->TXT_CATEGORIA_BANCO;
                }
                $fedocumento    =    FeDocumento::where('FOLIO','=',$folio->FOLIO)->where('TXT_CATEGORIA_BANCO','=',$item->TXT_CATEGORIA_BANCO)->first();
                
                $listafedocu    =   $this->con_lista_proveedores_banco_folio($folio->FOLIO,$item->TXT_CATEGORIA_BANCO);
                $countfedocu    =    str_pad(count($listafedocu), 6, '0', STR_PAD_LEFT);
                $listadocumento =   $this->con_lista_doc_proveedor_banco_folio($folio->FOLIO,$item->TXT_CATEGORIA_BANCO);


                //dd($listadocumento->sum('TOTAL'));


                $npestania = substr($txt_banco, 0, 30);

                $excel->sheet($npestania, function($sheet) use ($item,$operacion_id,$folio,$empresa,$fedocumento,$listadocumento,$txt_banco,$countfedocu){

                    $sheet->setWidth('A', 20);
                    $sheet->setWidth('B', 20);
                    $sheet->setWidth('C', 20);
                    $sheet->setWidth('D', 20);
                    $sheet->setWidth('E', 20);
                    $sheet->setWidth('F', 20);
                    $sheet->setWidth('G', 20);
                    $sheet->setWidth('H', 20);
                    $sheet->setWidth('I', 20);
                    $sheet->setWidth('J', 20);
                    $sheet->setWidth('K', 20);

                    $sheet->setCellValueExplicit('E8', $empresa->NRO_CUENTA_BANCARIA, \PHPExcel_Cell_DataType::TYPE_STRING);


                    $sheet->cell('A1', function($cell) {
                                $cell->setFontColor('#FFFFFF');   // Texto blanco
                            });

                    $sheet->loadView('entregadocumento/excel/contratopagosmacro')->with('banco',$item)
                                                                               ->with('folio',$folio)
                                                                               ->with('empresa',$empresa)
                                                                               ->with('txt_banco',$txt_banco)
                                                                               ->with('countfedocu',$countfedocu)
                                                                               ->with('fedocumento',$fedocumento)
                                                                               ->with('listadocumento',$listadocumento)
                                                                               ->with('operacion_id',$operacion_id);         
                });
            }

        })->export('xls');
    }



    public function actionDescargarPagoFolioMacroOC($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::where('FOLIO','=',$folio_codigo)->first();
        $lista_bancos           =   $this->con_lista_bancos_folio_oc_union($folio->FOLIO);

        //dd($lista_bancos);

        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'MACRO FOLIO ('.$folio_codigo.') '.$empresa->NOM_EMPR;
        $funcion                =   $this;

        Excel::create($titulo, function($excel) use ($lista_bancos,$operacion_id,$folio,$empresa,$funcion) {

            foreach($lista_bancos as $index => $item){

                $txt_banco = 'SIN BANCO';
                if (is_null($item->TXT_CATEGORIA_BANCO) or $item->TXT_CATEGORIA_BANCO == '') {
                    $txt_banco = 'SIN BANCO';
                }else{
                    $txt_banco = $item->TXT_CATEGORIA_BANCO;
                }
                $fedocumento    =    FeDocumento::where('FOLIO','=',$folio->FOLIO)->where('TXT_CATEGORIA_BANCO','=',$item->TXT_CATEGORIA_BANCO)->first();
                
                $listafedocu    =   $this->con_lista_proveedores_banco_folio_oc_union($folio->FOLIO,$item->TXT_CATEGORIA_BANCO);
                $countfedocu    =    str_pad(count($listafedocu), 6, '0', STR_PAD_LEFT);
                $listadocumento =   $this->con_lista_doc_proveedor_banco_folio_oc_union($folio->FOLIO,$item->TXT_CATEGORIA_BANCO);

                //dd($listadocumento);

                $npestania = substr($txt_banco, 0, 30);



                $excel->sheet($npestania, function($sheet) use ($item,$operacion_id,$folio,$empresa,$fedocumento,$listadocumento,$txt_banco,$countfedocu,$funcion){

                    $sheet->setWidth('A', 20);
                    $sheet->setWidth('B', 20);
                    $sheet->setWidth('C', 20);
                    $sheet->setWidth('D', 20);
                    $sheet->setWidth('E', 20);
                    $sheet->setWidth('F', 20);
                    $sheet->setWidth('G', 20);
                    $sheet->setWidth('H', 20);
                    $sheet->setWidth('I', 20);
                    $sheet->setWidth('J', 20);
                    $sheet->setWidth('K', 20);

                    $sheet->setCellValueExplicit('E8', $empresa->NRO_CUENTA_BANCARIA, \PHPExcel_Cell_DataType::TYPE_STRING);


                    $sheet->cell('A1', function($cell) {
                                $cell->setFontColor('#FFFFFF');   // Texto blanco
                            });

                    $sheet->loadView('entregadocumento/excel/contratopagosmacrooc')->with('banco',$item)
                                                                               ->with('folio',$folio)
                                                                               ->with('empresa',$empresa)
                                                                               ->with('funcion',$funcion)
                                                                               ->with('txt_banco',$txt_banco)
                                                                               ->with('countfedocu',$countfedocu)
                                                                               ->with('fedocumento',$fedocumento)
                                                                               ->with('listadocumento',$listadocumento)
                                                                               ->with('operacion_id',$operacion_id);         
                });
            }

        })->export('xls');
    }




    public function actionModalEntregaDocumentoFolio(Request $request)
    {

        $data_requerimiento_id  =   $request['data_requerimiento_id'];
        $idopcion               =   $request['idopcion'];
        $folio                  =   FeDocumentoEntregable::where('FOLIO','=',$data_requerimiento_id)->first();

        //dd($data_requerimiento_id);

        if($folio->OPERACION=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_modal($folio->FOLIO);
        }else{
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_contrato_modal($folio->FOLIO);
        }


        $funcion        =   $this;
        return View::make('entregadocumento/modal/ajax/mafoliodetalle',
                         [
                            'listadatos'        =>  $listadatos,
                            'folio'             =>  $folio,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'operacion_id'      =>  $folio->OPERACION,
                            'ajax'                  =>  true,

                         ]);
    }



    public function actionModaDetalleDeudaContrato(Request $request)
    {

        $data_id_doc            =   $request['data_id_doc'];
        $idopcion               =   $request['idopcion'];

        $empresa                =   STDEmpresa::where('COD_EMPR','=',$data_id_doc)->first();

        $listadatos = DB::table(DB::raw('(SELECT * FROM DEUDA_TOTAL_MERGE WHERE COD_EMPR_CLIENTE = ?) AS X'))
            ->select(
                'X.NOM_CLIENTE',
                'X.NRO_CONTRATO',
                'X.TIPO_CONTRATO',
                DB::raw('MIN(X.Centro) AS Centro'),
                DB::raw('MIN(X.TipoDocumento) AS TipoDocumento'),
                DB::raw('MIN(X.NroDocumento) AS NroDocumento'),
                DB::raw('MIN(X.JEFE_VENTA) AS JEFE_VENTA'),
                DB::raw('SUM(CAN_CAPITAL_SALDO + CAN_INTERES_SALDO) AS SALDO')
            )
            ->groupBy('X.NOM_CLIENTE', 'X.NRO_CONTRATO', 'X.TIPO_CONTRATO')
            ->setBindings([$data_id_doc]) // Para pasar el parámetro de manera segura
            ->get();

        $funcion        =   $this;
        return View::make('entregadocumento/modal/ajax/madeudadetalle',
                         [
                            'listadatos'        =>  $listadatos,
                            'empresa'           =>  $empresa,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'ajax'                  =>  true,
                         ]);
    }



    public function actionEntregableCrearFolio(Request $request)
    {

        $check                  =   $request['check'];
        $id                     =   $request['id'];
        $folio_sel              =   $request['folio_sel'];
        $data                   =   array();
        $mensaje                =   "";
        $ope_ind                =   "0";
        $lote_ver               =   "";

        $entregable             =   FeDocumentoEntregable::where('FOLIO','=',$folio_sel)
                                    ->first();
        $fedocumento_encontro   =   FeDocumento::where('ID_DOCUMENTO',$id)->first();

        if($check==1){

            //validacion si ya esta en otro folio
                //SI NO ESTA NULL O VACIO TIENE ALGO
            if (!empty($fedocumento_encontro->FOLIO_RESERVA)) {
                $mensaje            =   "Este Documento ya tiene un folio asigando ".$fedocumento_encontro->FOLIO_RESERVA;
                $ope_ind            =   "1";
            }

            if($entregable->COD_CATEGORIA_BANCO != $fedocumento_encontro->COD_CATEGORIA_BANCO){
                $mensaje            =   "Este Documento esta asigando en diferente BANCO";
                $ope_ind            =   "1";
            }


            //validacion que el folio sea del mismo banco
            if($entregable->COD_CATEGORIA_BANCO != $fedocumento_encontro->COD_CATEGORIA_BANCO){
                $mensaje            =   "Este Documento esta asigando en diferente BANCO";
                $ope_ind            =   "1";
            }
            //OPERACION
            if($entregable->OPERACION != ""){
                //validacion que el folio sea difenrente contrato con canjes o oc
                if($fedocumento_encontro->OPERACION == "CONTRATO"){
                    if($entregable->OPERACION != "CONTRATO"){
                        $mensaje            =   "Este Documento no es de un contrato";
                        $ope_ind            =   "1";
                    }
                }else{
                    if($entregable->OPERACION == "CONTRATO"){
                        $mensaje            =   "Este Documento tiene que ser de un contrato";
                        $ope_ind            =   "1";
                    }
                }
            }

        }


        if($ope_ind=="0"){

            if($check==1){

                FeDocumento::where('ID_DOCUMENTO','=',$fedocumento_encontro->ID_DOCUMENTO)
                            ->update(
                                [
                                    'FOLIO_RESERVA'=>$folio_sel
                                ]
                            );

                $operaciones =  DB::table('FE_DOCUMENTO')
                                ->where('FOLIO_RESERVA','=',$folio_sel)
                                ->pluck('OPERACION') // Obtiene solo la columna OPERACION como array
                                ->unique() // Elimina duplicados
                                ->implode(', ');
                $fedocumentos =  FeDocumento::where('FOLIO_RESERVA','=',$folio_sel)->get();
                FeDocumentoEntregable::where('FOLIO','=',$folio_sel)
                            ->update(
                                [
                                    'CAN_FOLIO'=>count($fedocumentos),
                                    'OPERACION'=>$operaciones
                                ]
                            );
                $lote_ver               =   $entregable->FOLIO . ' ('.count($fedocumentos).')';

            }else{

                FeDocumento::where('ID_DOCUMENTO','=',$fedocumento_encontro->ID_DOCUMENTO)
                            ->update(
                                [
                                    'FOLIO_RESERVA'=>''
                                ]
                            );

                $operaciones =  DB::table('FE_DOCUMENTO')
                                ->where('FOLIO_RESERVA','=',$folio_sel)
                                ->pluck('OPERACION') // Obtiene solo la columna OPERACION como array
                                ->unique() // Elimina duplicados
                                ->implode(', ');

                $fedocumentos =  FeDocumento::where('FOLIO_RESERVA','=',$folio_sel)->get();
                FeDocumentoEntregable::where('FOLIO','=',$folio_sel)
                            ->update(
                                [
                                    'CAN_FOLIO'=>count($fedocumentos),
                                    'OPERACION'=>$operaciones
                                ]
                            );
                $lote_ver               =   $entregable->FOLIO . ' ('.count($fedocumentos).')';

            }

            $mensaje                =   "Este Documento tiene que ser de un contrato";    
            $data                   =   [
                                            'mensaje'   => $mensaje,
                                            'lote_ver'  => $lote_ver,
                                            'check'     => $check,
                                            'ope_ind'   => $ope_ind
                                        ];

        }else{

            $data                   =   [
                                            'mensaje'   => $mensaje, 
                                            'lote_ver'  => $lote_ver,
                                            'check'     => $check,
                                            'ope_ind'   => $ope_ind
                                        ];


        }

        return response()->json($data); // Enviar la respuesta como JSON


    }


    public function actionEntregableGuardarFolioEntregable($idopcion,Request $request)
    {
        try{
            DB::beginTransaction();
            $folio                                  =   $request['folio'];
            $glosa_g                                =   $request['glosa_g'];

            $array_retencion                        =   $this->con_si_hay_retencion_lista($folio);
            //modificar las retenciones

            foreach ($array_retencion as $documento) {

                //FE_DOCUMENTO
                FeDocumento::where('ID_DOCUMENTO','=',$documento["ID_DOCUMENTO"])
                            ->update(
                                [
                                    'MONTO_RETENCION'=>(float)$documento["RETENCION"]
                                ]
                            );
                //OC
                CMPOrden::where('COD_ORDEN','=',$documento["ID_DOCUMENTO"])
                            ->update(
                                [
                                    'CAN_RETENCION'=>(float)$documento["RETENCION"],
                                    'CAN_DSCTO'=>3,
                                    'CAN_NETO_PAGAR' => \DB::raw('CAN_TOTAL - ' . (float) $documento["RETENCION"])
                                ]
                            );

                $documento02      =   DB::table('CMP.DOCUMENTO_CTBLE')
                                    ->join('CMP.REFERENCIA_ASOC', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                                    ->select(DB::raw('CMP.DOCUMENTO_CTBLE.*'))
                                    ->where('CMP.DOCUMENTO_CTBLE.COD_ESTADO','=','1')
                                    ->where('CMP.REFERENCIA_ASOC.COD_ESTADO','=','1')
                                    ->where('CMP.REFERENCIA_ASOC.COD_TABLA','=',$documento["ID_DOCUMENTO"])
                                    ->whereIn('CMP.DOCUMENTO_CTBLE.COD_CATEGORIA_TIPO_DOC', [
                                        'TDO0000000000001',
                                        'TDO0000000000003',
                                        'TDO0000000000002'
                                    ])->first();

                if(count($documento02)>0){
                    CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$documento02->COD_DOCUMENTO_CTBLE)
                                ->update(
                                    [
                                        'CAN_RETENCION'=>(float)$documento["RETENCION"],
                                        'CAN_DCTO'=>3
                                    ]
                                );
                    CONRegistroCompras::where('COD_DOCUMENTO_CTBLE','=',$documento02->COD_DOCUMENTO_CTBLE)
                                ->update(
                                    [
                                        'CAN_RETENCION_MONTO'=>(float)$documento["RETENCION"],
                                        'CAN_RETENCION_PORCENTAJE'=>3
                                    ]
                                );
                }

            }





            FeDocumentoEntregable::where('FOLIO','=',$folio)
                        ->update(
                            [
                                'SELECCION'=>0,
                                'FEC_PAGO'=>$this->fecha_sin_hora,
                                'TXT_GLOSA'=>$glosa_g,
                                'COD_CATEGORIA_ESTADO'=>'ETM0000000000005',
                                'TXT_CATEGORIA_ESTADO'=>'APROBADO',
                                'USUARIO_MOD'=>Session::get('usuario')->id,
                                'FECHA_MOD'=>$this->fechaactual
                            ]
                        );
            FeDocumento::where('FOLIO_RESERVA',$folio)
                        ->update(
                            [
                                'FOLIO'=>$folio
                            ]
                        );

            DB::commit();
            return Redirect::to('gestion-de-entrega-documentos/'.$idopcion)->with('bienhecho', 'Folio '.$folio.' aprobado con exito');
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('gestion-de-entrega-documentos/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }
    }


    public function actionEntregableCrearFolioEntregable($idopcion,Request $request)
    {
        try{

            DB::beginTransaction();
            $banco_id                               =   $request['banco_id'];
            $glosa                                  =   $request['glosa'];
            $empresa_id                             =   Session::get('empresas')->COD_EMPR;
            $banco                                  =   CMPCategoria::where('COD_CATEGORIA','=',$banco_id)->first();
            $codigo                                 =   $this->funciones->generar_folio('FE_DOCUMENTO_ENTREGABLE',8);
            $documento                              =   new FeDocumentoEntregable;
            $documento->FOLIO                       =   $codigo;
            $documento->CAN_FOLIO                   =   0;
            $documento->COD_ESTADO                  =   1;
            $documento->USUARIO_CREA                =   Session::get('usuario')->id;
            $documento->FECHA_CREA                  =   $this->fechaactual;
            $documento->OPERACION                   =   '';
            $documento->COD_EMPRESA                 =   $empresa_id;
            $documento->COD_CATEGORIA_BANCO         =   $banco->COD_CATEGORIA;
            $documento->TXT_CATEGORIA_BANCO         =   $banco->NOM_CATEGORIA;
            $documento->COD_CATEGORIA_ESTADO        =   'ETM0000000000001';
            $documento->TXT_CATEGORIA_ESTADO        =   'GENERADO';
            $documento->SELECCION                   =   0;
            $documento->TXT_GLOSA                   =   $glosa;
            $documento->save();
            DB::commit();

            return Redirect::to('gestion-de-entrega-documentos/'.$idopcion)->with('bienhecho', 'Folio '.$codigo.' creado con exito');
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('gestion-de-entrega-documentos/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }


    }

    public function actionEntregableSelectFolioPago(Request $request)
    {

        $data_folio             =   $request['data_folio'];
        FeDocumentoEntregable::where('COD_CATEGORIA_ESTADO','=','ETM0000000000001')
                    ->where('COD_ESTADO','=','1')
                    ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                    ->update(
                        [
                            'SELECCION'=>0
                        ]
                    );

        $feentregable           =   FeDocumentoEntregable::where('FOLIO','=',$data_folio)
                                    ->first();
        $feentregable->SELECCION = 1;
        $feentregable->save();
    }

    public function actionEntregableExtornoFolioPago(Request $request)
    {

        $data_folio             =   $request['data_folio'];
        FeDocumentoEntregable::where('FOLIO','=',$data_folio)
                    ->update(
                        [
                            'COD_ESTADO'=>0,
                            'COD_CATEGORIA_ESTADO'=>'ETM0000000000006',
                            'TXT_CATEGORIA_ESTADO'=>'RECHAZADO'
                        ]
                    );
        FeDocumento::where('FOLIO_RESERVA','=',$data_folio)
                    ->update(
                        [
                            'FOLIO_RESERVA'=>''
                        ]
                    );
    }

    public function actionEntregableDetalleFolioPago(Request $request)
    {
        $data_folio             =   $request['data_folio'];
        $lfedocumento           =   FeDocumento::where('FOLIO_RESERVA','=',$data_folio)->orderby('RZ_PROVEEDOR','asc')->get();

        $mensaje                =   "No hay ningun cambio en sus documentos";
        //validar si hay que tener que retener
        $array_retencion        =   $this->con_si_hay_retencion_lista($data_folio);
        //dd($array_retencion);
        if(count($array_retencion)>0){
            $mensaje            =   "Hay documentos que tienen retencion que se van agregar";
        }
        $entregagle_a           =   FeDocumentoEntregable::where('FOLIO','=',$data_folio)->first();
        //dd($entregagle);

        $funcion                =   $this;
        return View::make('entregadocumento/modal/ajax/mdetallefolio',
                         [
                            'lfedocumento'      =>  $lfedocumento,
                            'array_retencion'   =>  $array_retencion,
                            'data_folio'        =>  $data_folio,
                            'entregagle_a'      =>  $entregagle_a,
                            'mensaje'           =>  $mensaje,
                            'funcion'           =>  $funcion
                         ]);
    }

    public function actionValidarDetalleFolioPago(Request $request)
    {
        $data_folio             =   $request['data_folio'];
        $lfedocumento           =   FeDocumento::where('FOLIO_RESERVA','=',$data_folio)->get();
        $entregagle             =   FeDocumentoEntregable::where('FOLIO','=',$data_folio)->first();




        $funcion                =   $this;
        return View::make('entregadocumento/modal/ajax/mdetallefolio',
                         [
                            'lfedocumento'      =>  $lfedocumento,
                            'data_folio'        =>  $data_folio,
                            'funcion'           =>  $funcion
                         ]);
    }




    public function actionEntregableModalDetalleFolio(Request $request)
    {

        $idopcion               =   $request['idopcion'];
        $listadatos             =   FeDocumentoEntregable::where('COD_CATEGORIA_ESTADO','=','ETM0000000000001')
                                    ->where('COD_ESTADO','=','1')
                                    ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->get();

        $banco_id               =   'BAM0000000000001';
        $arraybancos            =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combobancos            =   array('' => "Seleccione Entidad Bancaria") + $arraybancos;
        $lfedocumento           =   array();
        $array_retencion        =   array();
        $mensaje                =   "";
        $funcion                =   $this;
        return View::make('entregadocumento/modal/ajax/madetallefoliocreacion',
                         [
                            'listadatos'        =>  $listadatos,
                            'lfedocumento'      =>  $lfedocumento,
                            'array_retencion'   =>  $array_retencion,
                            'mensaje'           =>  $mensaje,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'arraybancos'       =>  $arraybancos,
                            'combobancos'       =>  $combobancos,
                            'banco_id'          =>  $banco_id,
                            'ajax'              =>  true,
                         ]);
    }





}
