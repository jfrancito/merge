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
        $combo_empresa  =   $this->gn_combo_empresa('');
        $centro_id      =   'CEN0000000000001';
        $combo_centro   =   $this->gn_combo_centro_r('');
        $area_id      =   'TODO';
        $combo_area   =   $this->gn_combo_area_usuario($estado_id);
        //falta usuario contacto
        $operacion_id       =   'ORDEN_COMPRA';
        $combo_operacion    =   array('ORDEN_COMPRA' => 'ORDEN COMPRA','CONTRATO' => 'CONTRATO');

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
        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        $respuesta          =   json_decode($request['datastring'], true);

        try{    

            DB::beginTransaction();
            $codigo                                 =   $this->funciones->generar_folio('FE_DOCUMENTO_ENTREGABLE',8);
            $documento                              =   new FeDocumentoEntregable;
            $documento->FOLIO                       =   $codigo;
            $documento->CAN_FOLIO                   =   count($respuesta);
            $documento->COD_ESTADO                  =   1;
            $documento->USUARIO_CREA                =   Session::get('usuario')->id;
            $documento->FECHA_CREA                  =   $this->fechaactual;
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



    









}
