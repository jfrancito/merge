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
use App\Modelos\SGDUsuario;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use App\Modelos\Archivo;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\VMergeDocumento;



use App\Modelos\CMPOrden;
use Greenter\Parser\DocumentParserInterface;
use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;
use Greenter\Xml\Parser\PerceptionParser;
use Greenter\Xml\Parser\RHParser;


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
use App\Traits\DocumentoTraits;

use Storage;
use ZipArchive;
use Hashids;
use SplFileInfo;

class GestionDocumentoCanjesController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;
    use WhatsappTraits;
    use ComprobanteProvisionTraits;
    use DocumentoTraits;

    public function actionListarCanjesDOC($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Documentos Canjeados');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $listadatos     =   array();
        $funcion        =   $this;
        $procedencia    =   'SUE';//documentos sueltos

        return View::make('documento/listadocumentoscanjeados',
                         [
                            'listadatos'        =>  $listadatos,
                            'procedencia'       =>  $procedencia,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }


    public function actionCanjearDocumentos($procedencia,$idopcion,$prefijo, $iddocumento, Request $request) {

        View::share('titulo','CANJEAR DOCUMENTOS');
        $funcion                    =   $this;


        $array_tipo_doc             =   ['TDO0000000000014'];    
        $combo_tipodoc              =   $this->gn_combo_categoria_array('Seleccione Tipo Documento','',$array_tipo_doc);
        $tipodoc_id                 =   '';
        $combo_centro               =   $this->gn_combo_centro('Seleccione Centro','');
        $centro_id                  =   '';

        $listapersonal              =   DB::table('STD.EMPRESA')
                                        ->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
                                        ->where('STD.EMPRESA.COD_ESTADO','=',1)
                                        ->select('STD.EMPRESA.COD_EMPR','STD.EMPRESA.NOM_EMPR')
                                        ->select(DB::raw("
                                          STD.EMPRESA.COD_EMPR,
                                          STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
                                        )
                                        ->pluck('NOMBRE','NOMBRE')
                                        ->take(10)
                                        ->toArray();

        $combo_empresa              =   array('' => "Seleccione empresa") + $listapersonal;
        $empresa_id                 =   '';

        $combo_tiposervicio         =   array('' => 'Seleccione tipo servicio' , 'C' => 'Material', 'S' => 'Servicio');
        $tiposervicio_id            =   '';

        $fecha_inicio               =   $this->fecha_menos_diez_dias;
        $fecha_fin                  =   $this->fecha_sin_hora;
        $array_detalle_osiris       =   [];
        $array_detalle_merge        =   [];


        return View::make('documento/registrodocumentocanjear',
                         [

                            'procedencia'           =>  $procedencia,
                            'prefijo'               =>  $prefijo,
                            'iddocumento'           =>  $iddocumento,
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                            'combo_tipodoc'         =>  $combo_tipodoc,
                            'tipodoc_id'            =>  $tipodoc_id,
                            'combo_centro'          =>  $combo_centro,
                            'centro_id'             =>  $centro_id,

                            'combo_empresa'         =>  $combo_empresa,
                            'empresa_id'            =>  $empresa_id,

                            'combo_tiposervicio'    =>  $combo_tiposervicio,
                            'tiposervicio_id'       =>  $tiposervicio_id,

                            'fecha_inicio'          =>  $fecha_inicio,
                            'fecha_fin'             =>  $fecha_fin,
                            'array_detalle_osiris'  =>  $array_detalle_osiris,
                            'array_detalle_merge'   =>  $array_detalle_merge,

                         ]);
    }




    public function actionAjaxModalListaDocumentoOsiris(Request $request)
    {


        $tipodoc_id                     =   $request['tipodoc_id'];
        $centro_id                      =   $request['centro_id'];
        $empresa_id                     =   $request['empresa_id'];
        $tiposervicio_id                =   $request['tiposervicio_id'];
        $fecha_inicio                   =   $request['fecha_inicio'];
        $fecha_fin                      =   $request['fecha_fin'];

        $arraypersonal                  =   explode("-", $empresa_id);
        $ruc                            =   $arraypersonal[0];

        $empresa                        =   STDEmpresa::where('NRO_DOCUMENTO','=',$ruc)->first();

        $COD_EMPR                       =   Session::get('empresas')->COD_EMPR;
        $NOM_EMPR                       =   Session::get('empresas')->NOM_EMPR;

        $funcion                        =   $this;

        $listadocumentos                =   VMergeDocumento::where('COD_ESTADO','=','1')
                                            ->where('COD_EMPR','=',$COD_EMPR)
                                            ->where('COD_CENTRO','=',$centro_id)
                                            ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                            ->where('COD_CATEGORIA_MONEDA','=','MON0000000000001')
                                            ->where('IND_COMPRA_VENTA','=',$tiposervicio_id)
                                            ->where('COD_EMPR_EMISOR','=',$empresa->COD_EMPR)
                                            ->where('FEC_EMISION','>=',$fecha_inicio)
                                            ->where('FEC_EMISION','<=',$fecha_fin)
                                            ->get();


        return View::make('documento/modal/ajax/listadocumentoosiris',
                         [
                            'listadocumentos'           => $listadocumentos,
                            'ajax'                      => true,
                         ]);


    }


    public function actionAjaxModalListaDocumentoMerge(Request $request)
    {

        $fecha_inicio                   =   $request['fecha_inicio'];
        $fecha_fin                      =   $request['fecha_fin'];

        $COD_EMPR                       =   Session::get('empresas')->COD_EMPR;
        $NOM_EMPR                       =   Session::get('empresas')->NOM_EMPR;

        $funcion                        =   $this;


        $listadocumentos                =   FeDocumento::where('FE_DOCUMENTO.COD_EMPR','=',$COD_EMPR)
                                            ->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                            ->where('TXT_PROCEDENCIA','=','SUE')
                                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000002')
                                            ->get();

        return View::make('documento/modal/ajax/listadocumentomerge',
                         [
                            'listadocumentos'           => $listadocumentos,
                            'ajax'                      => true,
                         ]);


    }




    public function actionAjaxModalAgregarDocumentoOsiris(Request $request)
    {

        $data_documento                     =   $request['data_documento'];

        $array_detalle_osiris_request       =   json_decode($request['array_detalle_osiris'],true);
        $array_detalle_osiris               =   array();


        foreach($data_documento as $obj){

            $documento_id                   =   $obj['documento_id'];
            $array_nuevo_producto           =   $this->llenar_array_productos($documento_id);
            array_push($array_detalle_osiris,$array_nuevo_producto);
        }

        if(count($array_detalle_osiris_request)>0){
            foreach ($array_detalle_osiris_request as $key => $item) {
                array_push($array_detalle_osiris,$item);
            }
        }

        $funcion    =   $this;


        return View::make('documento/ajax/adocumentososiris',
                         [
                            'array_detalle_osiris'                  => $array_detalle_osiris,
                            'funcion'                               => $funcion,
                            'ajax'                                  => true,
                         ]);

    }



    public function actionAjaxModalAgregarDocumentoMerge(Request $request)
    {

        $data_documento                     =   $request['data_documento'];

        $array_detalle_merge_request       =   json_decode($request['array_detalle_merge'],true);
        $array_detalle_merge               =   array();


        foreach($data_documento as $obj){

            $documento_id                   =   $obj['documento_id'];
            $array_nuevo_producto           =   $this->llenar_array_productos_merge($documento_id);
            array_push($array_detalle_merge,$array_nuevo_producto);
        }

        if(count($array_detalle_merge_request)>0){
            foreach ($array_detalle_merge_request as $key => $item) {
                array_push($array_detalle_merge,$item);
            }
        }

        $funcion    =   $this;


        return View::make('documento/ajax/adocumentosmerge',
                         [
                            'array_detalle_merge'                  => $array_detalle_merge,
                            'funcion'                               => $funcion,
                            'ajax'                                  => true,
                         ]);

    }






}
