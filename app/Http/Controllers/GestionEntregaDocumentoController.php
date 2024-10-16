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


        $area_id        =   'TODO';
        $combo_area     =   $this->gn_combo_area_usuario($estado_id);
        $rol            =    WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

        if($rol->ind_uc == 1 && Session::get('usuario')->id != '1CIX00000075'){
            $usuario    =   SGDUsuario::where('COD_USUARIO','=',Session::get('usuario')->name)->first();
            if(count($usuario)>0){
                $tp_area        =   CMPCategoria::where('COD_CATEGORIA','=',$usuario->COD_CATEGORIA_AREA)->first();
                $area_id        =   $tp_area->COD_CATEGORIA;
                $combo_area     =   array($tp_area->COD_CATEGORIA => $tp_area->NOM_CATEGORIA);
            }
        }
        $operacion_id       =   'ORDEN_COMPRA';
        //falta usuario contacto
        $array_contrato     =   $this->array_rol_contrato();
        if (in_array(Session::get('usuario')->rol_id, $array_contrato)) {
            $operacion_id       =   'CONTRATO';
        }
        

        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO');
        //$combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA');

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id);
        }else{
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id);
        }
        $funcion        =   $this;
        return View::make('entregadocumento/listaentregadocumento',
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
                            'operacion_id'      =>  $operacion_id,
                            'combo_operacion'   =>  $combo_operacion,
                            'empresa_id'        =>  $empresa_id,
                            'combo_empresa'     =>  $combo_empresa,
                            'centro_id'         =>  $centro_id,
                            'combo_centro'      =>  $combo_centro,
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




        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        if($operacion_id=='ORDEN_COMPRA'){
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id);
        }else{
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id);
        }

        $funcion        =   $this;

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

            $empresa_id     =   Session::get('empresas')->COD_EMPR;
            $fedocumento_encontro                   =   FeDocumento::where('ID_DOCUMENTO',$ID_DOCUMENTO_ENCONTRO)->first();

            $codigo                                 =   $this->funciones->generar_folio('FE_DOCUMENTO_ENTREGABLE',8);
            $documento                              =   new FeDocumentoEntregable;
            $documento->FOLIO                       =   $codigo;
            $documento->CAN_FOLIO                   =   count($respuesta);
            $documento->COD_ESTADO                  =   1;
            $documento->USUARIO_CREA                =   Session::get('usuario')->id;
            $documento->FECHA_CREA                  =   $this->fechaactual;
            $documento->OPERACION                   =   $fedocumento_encontro->OPERACION;
            $documento->COD_EMPRESA                 =   $empresa_id;
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
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id);
        }else{
            $listadatos         =   $this->con_lista_cabecera_comprobante_entregable_contrato($cod_empresa,$fecha_inicio,$fecha_fin,$empresa_id,$centro_id,$area_id);
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
        if($rol->ind_uc == 1){
            $listadatos     =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                ->orderBy('FE_DOCUMENTO_ENTREGABLE.FECHA_CREA','DESC')
                                ->get();
        }else{
            $listadatos     =   FeDocumentoEntregable::join('users','users.id','=','FE_DOCUMENTO_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->orderBy('FE_DOCUMENTO_ENTREGABLE.FECHA_CREA','DESC')
                                ->get();
        }

        $funcion        =   $this;
        return View::make('entregadocumento/listaentregadocumentofolio',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }


    public function actionDescargarDocumentoFolio($folio_codigo)
    {

        $folio                  =   FeDocumentoEntregable::where('FOLIO','=',$folio_codigo)->first();
        if($folio->OPERACION=='ORDEN_COMPRA'){
            $listadatossoles    =   $this->con_lista_cabecera_comprobante_entregable_modal_moneda($folio->FOLIO,'MON0000000000001');
            $listadatosdolar    =   $this->con_lista_cabecera_comprobante_entregable_modal_moneda($folio->FOLIO,'MON0000000000002');
        }else{
            $listadatossoles    =   $this->con_lista_cabecera_comprobante_entregable_contrato_modal_moneda($folio->FOLIO,'MON0000000000001');
            $listadatosdolar    =   $this->con_lista_cabecera_comprobante_entregable_contrato_modal_moneda($folio->FOLIO,'MON0000000000002');

        }

        $operacion_id           =   $folio->OPERACION;
        $empresa                =    STDEmpresa::where('COD_EMPR','=',$folio->COD_EMPRESA)->first();
        $titulo                 =   'FOLIO('.$folio_codigo.') '.$empresa->NOM_EMPR;

        Excel::create($titulo, function($excel) use ($listadatossoles,$listadatosdolar,$operacion_id) {

            $excel->sheet('Soles', function($sheet) use ($listadatossoles,$operacion_id){
                $sheet->loadView('entregadocumento/excel/eentregable')->with('listadatos',$listadatossoles)
                                                                      ->with('operacion_id',$operacion_id);         
            });

            $excel->sheet('Dolares', function($sheet) use ($listadatosdolar,$operacion_id){
                $sheet->loadView('entregadocumento/excel/eentregable')->with('listadatos',$listadatosdolar)
                                                                      ->with('operacion_id',$operacion_id);       
            });

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









}
