<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Modelos\Grupoopcion;
use App\Modelos\Opcion;
use App\Modelos\Rol;
use App\Modelos\RolOpcion;
use App\Modelos\PlaMovilidad;
use App\Modelos\PlaDetMovilidad;
use App\Modelos\PlaSerie;
use App\Modelos\STDTrabajador;
use App\Modelos\CMPCategoria;
use App\Modelos\PlaDocumentoHistorial;
use App\Modelos\STDTipoDocumento;
use App\Modelos\Archivo;

use App\Modelos\STDEmpresa;
use App\Modelos\CMPContrato;
use App\Modelos\CMPContratoCultivo;
use App\Modelos\ALMCentro;
use App\Modelos\Estado;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\FeToken;
use App\Modelos\CMPZona;
use App\Modelos\SunatDocumento;






use App\Modelos\LqgLiquidacionGasto;
use App\Modelos\LqgDocumentoHistorial;
use App\Modelos\LqgDetLiquidacionGasto;
use App\Modelos\LqgDetDocumentoLiquidacionGasto;

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
use App\Traits\PlanillaTraits;
use App\Traits\LiquidacionGastoTraits;
use App\Traits\ComprobanteTraits;
use PDF;
use Hashids;
use SplFileInfo;
use Excel;



class GestionLiquidacionGastosController extends Controller
{
    use GeneralesTraits;
    use PlanillaTraits;
    use LiquidacionGastoTraits;
    use ComprobanteTraits;







    public function actionLiquidacionViajePdf($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');

        $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
        $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
        $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();
        $tdetliquidaciongastosel=   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','0')->get();
        $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('EXTENSION', 'like', '%'.'pdf'.'%')->get();
        $ocultar                =   "";
        $productosagru          =   DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
                                    ->join('LQG_DETLIQUIDACIONGASTO', function($join) {
                                        $join->on('LQG_DETDOCUMENTOLIQUIDACIONGASTO.ID_DOCUMENTO', '=', 'LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO')
                                             ->on('LQG_DETDOCUMENTOLIQUIDACIONGASTO.ITEM', '=', 'LQG_DETLIQUIDACIONGASTO.ITEM'); // Condición adicional
                                    })
                                    ->select('*','LQG_DETDOCUMENTOLIQUIDACIONGASTO.TOTAL AS CAN_TOTAL_DETALLE')
                                    ->join('ALM.PRODUCTO','ALM.PRODUCTO.COD_PRODUCTO','=','LQG_DETDOCUMENTOLIQUIDACIONGASTO.COD_PRODUCTO')
                                    ->where('LQG_DETDOCUMENTOLIQUIDACIONGASTO.ID_DOCUMENTO', $iddocumento)
                                    ->where('LQG_DETDOCUMENTOLIQUIDACIONGASTO.ACTIVO', 1)
                                    ->orderBy('ALM.PRODUCTO.TXT_DESCRIPCION','asc')
                                    ->get();

        $trabajador             =   STDEmpresa::where('COD_EMPR','=',$liquidaciongastos->COD_EMPRESA_TRABAJADOR)->first();
        $imgresponsable         =   'firmas/blanco.jpg';
        $nombre_responsable     =   '';
        $rutaImagen             =   public_path('firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg');
        if (file_exists($rutaImagen)){
            $imgresponsable         =   'firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg';
            $nombre_responsable     =   $trabajador->NOM_EMPR;
        }

        $useario_autoriza       =   User::where('id','=',$liquidaciongastos->COD_USUARIO_AUTORIZA)->first();
        $trabajadorap           =   STDTrabajador::where('COD_TRAB','=',$useario_autoriza->usuarioosiris_id)->first();
        $imgaprueba             =   'firmas/blanco.jpg';
        $nombre_aprueba         =   '';
        $rutaImagen             =   public_path('firmas/'.$trabajadorap->NRO_DOCUMENTO.'.jpg');
        if (file_exists($rutaImagen)){
            $imgaprueba         =   'firmas/'.$trabajadorap->NRO_DOCUMENTO.'.jpg';
            $nombre_aprueba     =   $trabajadorap->TXT_NOMBRES.' '.$trabajadorap->TXT_APE_PATERNO.' '.$trabajadorap->TXT_APE_MATERNO;
        }


        $direccion              =   $this->gn_direccion_fiscal();


        $pdf = PDF::loadView('pdffa.liquidaciongastos', [ 
                                                'iddocumento'                   => $iddocumento , 
                                                'liquidaciongastos'             => $liquidaciongastos,
                                                'tdetliquidaciongastos'         => $tdetliquidaciongastos,
                                                'detdocumentolg'                => $detdocumentolg,
                                                'documentohistorial'            => $documentohistorial , 
                                                'tdetliquidaciongastosel'       => $tdetliquidaciongastosel,
                                                'productosagru'                 => $productosagru,
                                                'imgresponsable'                => $imgresponsable , 
                                                'nombre_responsable'            => $nombre_responsable,
                                                'imgaprueba'                    => $imgaprueba,
                                                'nombre_aprueba'                => $nombre_aprueba,
                                                'direccion'                     => $direccion,
                                              ]);

        return $pdf->stream('download.pdf');


    }



    public function actionGuardarEmpresaProveedor($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Guardar Empresa');
        if($_POST)
        {
            try{    
                
                $ruc                    =   $request['ruc'];
                $rz                     =   $request['rz'];
                $direccion              =   $request['direccion'];
                $departamento           =   $request['departamento'];
                $provincia              =   $request['provincia'];
                $distrito               =   $request['distrito'];

                $trabajador             =   DB::table('STD.TRABAJADOR')
                                            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                            ->first();     

                $centro_id              =   '';
                if(count($trabajador)>0){
                    $dni                =   $trabajador->NRO_DOCUMENTO;
                }
                $trabajadorespla        =   DB::table('WEB.platrabajadores')
                                            ->where('situacion_id', 'PRMAECEN000000000002')
                                            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                            ->where('dni', $dni)
                                            ->first();
                if(count($trabajador)>0){
                    $centro_id      =       $trabajadorespla->centro_osiris_id;
                }


  
                if($centro_id==''){
                    return Redirect::to('gestion-de-empresa-proveedor/'.$idopcion)->with('errorbd','No tienes un Centro Asignado');
                }

                $centro                 =   ALMCentro::where('COD_CENTRO', $centro_id)
                                            ->first();  
                $zona                   =   CMPZona::where('TXT_NOMBRE', $centro->NOM_CENTRO)->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                            ->where('COD_ESTADO','=','1')
                                            ->orderBy('COD_ZONA','ASC')
                                            ->first();
 
                $zona02                 =   CMPZona::where('TXT_NOMBRE', $centro->NOM_CENTRO)->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                            ->where('COD_ESTADO','=','1')
                                            ->where('COD_ZONA_SUP','<>','')
                                            ->first();

                if(count($zona)<=0){
                    return Redirect::to('gestion-de-empresa-proveedor/'.$idopcion)->with('errorbd','No existe Zona en el osiris');
                }
                if(count($zona02)<=0){
                    return Redirect::to('gestion-de-empresa-proveedor/'.$idopcion)->with('errorbd','No existe Zona 02 en el osiris');
                }


                $departamentos   =       CMPCategoria::where('TXT_GRUPO','=','DEPARTAMENTO')->where('NOM_CATEGORIA','=',$departamento)->first();
                if(count($departamentos)<=0){
                    return Redirect::to('gestion-de-empresa-proveedor/'.$idopcion)->with('errorbd','No existe Departamento en el osiris');
                }
                $provincias   =       CMPCategoria::where('TXT_GRUPO','=','PROVINCIA')->where('NOM_CATEGORIA','=',$provincia)->first();
                if(count($provincias)<=0){
                    return Redirect::to('gestion-de-empresa-proveedor/'.$idopcion)->with('errorbd','No existe Provincia en el osiris');
                }

                $distritos   =       CMPCategoria::where('TXT_GRUPO','=','DISTRITO')->where('NOM_CATEGORIA','=',$distrito)->first();
                if(count($distritos)<=0){
                    return Redirect::to('gestion-de-empresa-proveedor/'.$idopcion)->with('errorbd','No existe Distrito en el osiris');
                }


                $ind_empresa              =   $request['ind_empresa'];
                $ind_contrato             =   $request['ind_contrato'];

                DB::beginTransaction();
                $empresa_id     =       Session::get('empresas')->COD_EMPR;

                $cod_empresa    =       $this->lg_enviar_osiris_empresa($centro_id,$empresa_id,$rz,$ruc,$direccion,$departamentos->COD_CATEGORIA,$provincias->COD_CATEGORIA,$distritos->COD_CATEGORIA,$zona,$zona02,$ind_empresa,$ind_contrato);

                DB::commit();
                return Redirect::to('gestion-de-empresa-proveedor/'.$idopcion)->with('bienhecho', 'Empresa : '.$rz.' REGISTRO CON EXITO' );
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-empresa-proveedor/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
 
    }


    public function actionBuscarSunatRuc($idopcion,Request $request)
    {

        $ruc_buscar           =   $request['ruc_buscar'];
        $urlxml               =   'https://dniruc.apisperu.com/api/v1/ruc/'.$ruc_buscar.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImhlbnJyeWluZHVAZ21haWwuY29tIn0.m3cyXSejlDWl0BLcphHPUTfPNqpa5kXWoBcmQ6WvkII';
        $respuetaxml          =   $this->buscar_ruc_sunat_lg($urlxml);
        $empresa_id           =   '';


        $empresa              =   STDEmpresa::where('NRO_DOCUMENTO','=',$ruc_buscar)->first();
        if(count($empresa)>0){
            $empresa_id           =   $empresa->COD_EMPR;
        }
        $trabajador           =   DB::table('STD.TRABAJADOR')
                                    ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                    ->first();     
        $centro_id            =   '';
        if(count($trabajador)>0){
            $dni                =   $trabajador->NRO_DOCUMENTO;
        }
        $trabajadorespla        =   DB::table('WEB.platrabajadores')
                                    ->where('situacion_id', 'PRMAECEN000000000002')
                                    ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                    ->where('dni', $dni)
                                    ->first();
        if(count($trabajador)>0){
            $centro_id          =       $trabajadorespla->centro_osiris_id;
        }

        $contratos              =   DB::table('CMP.CONTRATO')
                                    ->where('TXT_CATEGORIA_TIPO_CONTRATO', 'PROVEEDOR')
                                    ->where('COD_EMPR_CLIENTE', $empresa_id)
                                    ->where('COD_ESTADO', 1)
                                    ->where('COD_CENTRO', $centro_id)
                                    ->get();

        if(count($contratos)>0){
            return Redirect::to('gestion-de-empresa-proveedor/'.$idopcion)->with('errorbd','Empresa '.$empresa->NOM_EMPR.' ya existe y tiene contrato');
        }
        $response_array = json_decode($respuetaxml, true);
        if(isset($response_array['success'])){
            return Redirect::to('gestion-de-empresa-proveedor/'.$idopcion)->with('errorbd','No se encontraron resultados.');  
        }

        Session::flash('ruc', $response_array['ruc']);
        Session::flash('rz', $response_array['razonSocial']);
        Session::flash('direccion', $response_array['direccion']);
        Session::flash('departamento', $response_array['departamento']);
        Session::flash('provincia', $response_array['provincia']);
        Session::flash('distrito', $response_array['distrito']);
        $texto_empresa = 'No cuenta con ningun registro de empresa ';
        if(count($empresa)>0){
            $texto_empresa = 'Ya Cuenta con un registro de una empresa';
            Session::flash('texto_empresa', $texto_empresa);
            Session::flash('ind_empresa', 1);
        }else{
            Session::flash('texto_empresa', $texto_empresa);
            Session::flash('ind_empresa', 0);
        }
        $texto_contrato = 'No cuenta con ningun registro de contrato';
        if(count($contratos)>0){
            $texto_contrato = 'Ya Cuenta con un registro de contrato en el centro';
            Session::flash('texto_contrato', $texto_contrato);
            Session::flash('ind_contrato', 1);
        }else{
            Session::flash('texto_contrato', $texto_contrato);
            Session::flash('ind_contrato', 0);
        }
        return Redirect::to('/gestion-de-empresa-proveedor/'.$idopcion)->with('bienhecho', 'Documento Encontrado');


    }



    public function actionGestionEmpresaProveedor($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Guardar Empresa Proveedor');

        $ruc                        =   "";
        $rz                         =   "";
        $direccion                  =   "";
        $departamento               =   "";
        $provincia                  =   "";
        $distrito                   =   "";
        $texto_empresa              =   "";
        $texto_contrato             =   "";
        $ind_empresa                =   0;
        $ind_contrato               =   0;





        if(Session::has('ruc')){
            $ruc                    =   Session::get('ruc');
        }
        if(Session::has('rz')){
            $rz                     =   Session::get('rz');
        }
        if(Session::has('direccion')){
            $direccion              =   Session::get('direccion');
        }
        if(Session::has('departamento')){
            $departamento           =   Session::get('departamento');
        }
        if(Session::has('provincia')){
            $provincia              =   Session::get('provincia');
        }
        if(Session::has('distrito')){
            $distrito               =   Session::get('distrito');
        }

        if(Session::has('texto_empresa')){
            $texto_empresa          =   Session::get('texto_empresa');
        }
        if(Session::has('texto_contrato')){
            $texto_contrato         =   Session::get('texto_contrato');
        }
        if(Session::has('ind_empresa')){
            $ind_empresa            =   Session::get('ind_empresa');
        }
        if(Session::has('ind_contrato')){
            $ind_contrato           =   Session::get('ind_contrato');
        }



        return View::make('liquidaciongasto/buscarempresaproveedor',
                    [         
                        'idopcion'      => $idopcion,
                        'ruc'           => $ruc,
                        'rz'            => $rz,
                        'direccion'     => $direccion,
                        'departamento'  => $departamento,
                        'provincia'     => $provincia,
                        'distrito'      => $distrito,
                        'texto_empresa' => $texto_empresa,
                        'texto_contrato'=> $texto_contrato,
                        'ind_empresa' => $ind_empresa,
                        'ind_contrato'=> $ind_contrato
                    ]);

    }



    public function actionTareasCpeSunatLg(Request $request)
    {
            $ruc                                =   $request['ruc'];
            $td                                 =   $request['td'];
            $serie                              =   $request['serie'];
            $correlativo                        =   $request['correlativo'];
            $ID_DOCUMENTO                       =   $request['ID_DOCUMENTO'];
            $tipodocumento                      =   CMPCategoria::where('TXT_GRUPO','=','TIPO_DOCUMENTO')->where('CODIGO_SUNAT','=',$td)->first();

            $mensaje                            =   '';
            $sunatdocumento                     =   DB::table('SUNAT_DOCUMENTO')
                                                    ->where('EMPRESA_ID', Session::get('empresas')->COD_EMPR)
                                                    ->where('ID_DOCUMENTO', $ID_DOCUMENTO)
                                                    ->where('MODULO', 'LIQUIDACION_GASTO')
                                                    ->where('RUC', $ruc)
                                                    ->where('TIPODOCUMENTO_ID','=',$td)
                                                    ->where('SERIE','=',$serie)
                                                    ->where('NUMERO','=',$correlativo)
                                                    ->where('ACTIVO', 1)
                                                    ->where('USUARIO_ID', Session::get('usuario')->id)
                                                    ->first();

            if(count($sunatdocumento)>0){
                $mensaje                            =   'Ya existe un documento con estos campos como tarea programada';
            }else{
                $documento                          =   new SunatDocumento;
                $documento->ID_DOCUMENTO            =   $ID_DOCUMENTO;
                $documento->EMPRESA_ID              =   Session::get('empresas')->COD_EMPR;
                $documento->EMPRESA_NOMBRE          =   Session::get('empresas')->NOM_EMPR;
                $documento->RUC                     =   $ruc;
                $documento->TIPODOCUMENTO_ID        =   $tipodocumento->CODIGO_SUNAT;
                $documento->TIPODOCUMENTO_NOMBRE    =   $tipodocumento->NOM_CATEGORIA;
                $documento->SERIE                   =   $serie;
                $documento->NUMERO                  =   $correlativo;
                $documento->MODULO                  =   'LIQUIDACION_GASTO';
                $documento->NOMBRE_PDF              =   '';
                $documento->RUTA_PDF                =   '';
                $documento->IND_PDF                 =   0;
                $documento->NOMBRE_XML              =   '';
                $documento->RUTA_XML                =   '';
                $documento->IND_XML                 =   0;
                $documento->NOMBRE_CDR              =   '';
                $documento->RUTA_CDR                =   '';
                $documento->IND_CDR                 =   0;
                $documento->IND_TOTAL               =   0;
                $documento->CONTADOR                =   0;
                $documento->ACTIVO                  =   1;
                $documento->FECHA_CREA              =   $this->fechaactual;
                $documento->USUARIO_ID              =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE          =   Session::get('usuario')->nombre;
                $documento->save();
            }
            $listasunattareas                   =   DB::table('SUNAT_DOCUMENTO')
                                                    ->where('EMPRESA_ID', Session::get('empresas')->COD_EMPR)
                                                    ->where('ID_DOCUMENTO', $ID_DOCUMENTO)
                                                    ->where('MODULO', 'LIQUIDACION_GASTO')
                                                    ->where('ACTIVO', 1)
                                                    ->where('USUARIO_ID', Session::get('usuario')->id)
                                                    ->get();
            $funcion                            =    $this;

            return View::make('liquidaciongasto/ajax/alistatareassunat',
                             [
                                'ID_DOCUMENTO'          =>  $ID_DOCUMENTO,
                                'listasunattareas'      =>  $listasunattareas,
                                'funcion'               =>  $funcion,
                                'mensaje'               =>  $mensaje,
                                'ajax'                  =>  true,
                             ]);





    }


    public function actionElimnarCpeSunatLgPersonal(Request $request)
    {
            $ruc                        =   $request['data_ruc'];
            $td                         =   $request['data_td'];
            $serie                      =   $request['data_serie'];
            $correlativo                =   $request['data_numero'];
            $ID_DOCUMENTO               =   $request['data_id'];

            DB::table('SUNAT_DOCUMENTO')
                ->where('ID_DOCUMENTO', $ID_DOCUMENTO)
                ->where('RUC', $ruc)
                ->where('TIPODOCUMENTO_ID', $td)
                ->where('SERIE', $serie)
                ->where('NUMERO', $correlativo)
                ->update([
                    'ACTIVO'     => '0'
                ]);
            print_r("hola");
    }


    public function actionBuscarCpeSunatLgPersonal(Request $request)
    {
            $ruc                        =   $request['data_ruc'];
            $td                         =   $request['data_td'];
            $serie                      =   $request['data_serie'];
            $correlativo                =   $request['data_numero'];
            $ID_DOCUMENTO               =   $request['data_id'];

            $fetoken                    =   FeToken::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)->where('TIPO','=','COMPROBANTE_PAGO')->first();
            //buscar xml
            $primeraLetra               =   substr($serie, 0, 1);

            $prefijocarperta            =   $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
            $rutafile                   =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ID_DOCUMENTO;
            $valor                      =   $this->versicarpetanoexiste($rutafile);

            $ruta_xml                   =   "";
            $ruta_pdf                   =   "";
            $ruta_cdr                   =   "";
            $nombre_xml                 =   "";
            $nombre_pdf                 =   "";
            $nombre_cdr                 =   "";

            $sunattareas                =   DB::table('SUNAT_DOCUMENTO')
                                            ->where('EMPRESA_ID', Session::get('empresas')->COD_EMPR)
                                            ->where('ID_DOCUMENTO', $ID_DOCUMENTO)
                                            ->where('RUC', $ruc)
                                            ->where('TIPODOCUMENTO_ID', $td)
                                            ->where('SERIE', $serie)
                                            ->where('NUMERO', $correlativo)
                                            ->first();

            //dd($ID_DOCUMENTO);


            if($sunattareas->IND_CDR==1){
                $ruta_cdr = $sunattareas->RUTA_CDR;
                $nombre_cdr = $sunattareas->NOMBRE_CDR;
            }
            if($sunattareas->IND_XML==1){
                $ruta_xml = $sunattareas->RUTA_XML;
                $nombre_xml = $sunattareas->NOMBRE_XML;
            }
            if($sunattareas->IND_PDF==1){
                $ruta_pdf = $sunattareas->RUTA_PDF;
                $nombre_pdf = $sunattareas->NOMBRE_PDF;
            }

            return response()->json([
                'ruta_cdr'      => $ruta_cdr,
                'ruta_xml'      => $ruta_xml,
                'ruta_pdf'      => $ruta_pdf,
                'nombre_xml'    => $nombre_xml,
                'nombre_pdf'    => $nombre_pdf,
                'nombre_cdr'    => $nombre_cdr,

            ]);

    }


    public function actionGuardarNumeroWhatsapp(Request $request)
    {
            $whatsapp                   =   $request['whatsapp'];
            User::where('id','=',Session::get('usuario')->id)
                        ->update(
                            [
                                'celular_contacto'=>$whatsapp
                            ]
                        );


    }


    public function actionBuscarCpeSunatLg(Request $request)
    {
            $ruc                        =   $request['ruc'];
            $td                         =   $request['td'];
            $serie                      =   $request['serie'];
            $correlativo                =   $request['correlativo'];
            $ID_DOCUMENTO               =   $request['ID_DOCUMENTO'];

            $fetoken                    =   FeToken::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)->where('TIPO','=','COMPROBANTE_PAGO')->first();
            //buscar xml
            $primeraLetra               =   substr($serie, 0, 1);

            $prefijocarperta            =   $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
            $rutafile                   =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ID_DOCUMENTO;
            $valor                      =   $this->versicarpetanoexiste($rutafile);

            $ruta_xml                   =   "";
            $ruta_pdf                   =   "";
            $ruta_cdr                   =   "";
            $nombre_xml                 =   "";
            $nombre_pdf                 =   "";
            $nombre_cdr                 =   "";

            $urlxml                     =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/02';
            $respuetaxml                =   $this->buscar_archivo_sunat_lg_indicador($urlxml,$fetoken,$this->pathFiles,$prefijocarperta,$ID_DOCUMENTO,'IND_XML');
            $urlxml                     =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/01';
            $respuetapdf                =   $this->buscar_archivo_sunat_lg($urlxml,$fetoken,$this->pathFiles,$prefijocarperta,$ID_DOCUMENTO);
            
            if($primeraLetra == 'F'){
                $urlxml                     =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/03';
                $respuetacdr                =   $this->buscar_archivo_sunat_lg($urlxml,$fetoken,$this->pathFiles,$prefijocarperta,$ID_DOCUMENTO);
                if($respuetacdr['cod_error']==0){
                    $ruta_cdr = $respuetacdr['ruta_completa'];
                    $nombre_cdr = $respuetacdr['nombre_archivo'];
                }
            }
            if($respuetaxml['cod_error']==0){
                $ruta_xml = $respuetaxml['ruta_completa'];
                $nombre_xml = $respuetaxml['nombre_archivo'];
            }
            if($respuetapdf['cod_error']==0){
                $ruta_pdf = $respuetapdf['ruta_completa'];
                $nombre_pdf = $respuetapdf['nombre_archivo'];
            }

            return response()->json([
                'ruta_cdr'      => $ruta_cdr,
                'ruta_xml'      => $ruta_xml,
                'ruta_pdf'      => $ruta_pdf,
                'nombre_xml'    => $nombre_xml,
                'nombre_pdf'    => $nombre_pdf,
                'nombre_cdr'    => $nombre_cdr,

            ]);

    }



    public function actionModalBuscarFacturaSunat(Request $request) {

        $ID_DOCUMENTO           =       $request['ID_DOCUMENTO'];
        $combotd                =       array('01' => 'FACTURA');
        $idopcion               =       $request['idopcion'];
        $funcion                =       $this;

        $listasunattareas = DB::table('SUNAT_DOCUMENTO as sd')
            ->where('sd.EMPRESA_ID', Session::get('empresas')->COD_EMPR)
            ->where('sd.MODULO', 'LIQUIDACION_GASTO')
            ->where('sd.ACTIVO', 1)
            ->where('sd.USUARIO_ID', Session::get('usuario')->id)
            ->where('sd.ID_DOCUMENTO', $ID_DOCUMENTO)
            ->whereNotExists(function ($query) use ($ID_DOCUMENTO) {
                $query->select(DB::raw(1))
                    ->from('LQG_DETLIQUIDACIONGASTO as lqg')
                    ->join('STD.EMPRESA as e', 'lqg.COD_EMPRESA_PROVEEDOR', '=', 'e.COD_EMPR')
                    ->whereRaw('lqg.SERIE = sd.SERIE')
                    ->whereRaw('CAST(lqg.NUMERO AS INT) = CAST(sd.NUMERO AS INT)')
                    ->whereRaw('e.NRO_DOCUMENTO = sd.RUC')
                    ->where('lqg.ID_DOCUMENTO', $ID_DOCUMENTO)
                    ->where('lqg.ACTIVO', 1)
                    ->where('lqg.TXT_TIPODOCUMENTO', 'FACTURA');
            })
            ->get();

        $user = User::where('id','=',Session::get('usuario')->id)->first();


        $mensaje                =       '';

        return View::make('liquidaciongasto/modal/ajax/mbuscardocumentosunat',
                         [
                            'ID_DOCUMENTO'          =>  $ID_DOCUMENTO,
                            'user'                  =>  $user,
                            'idopcion'              =>  $idopcion,
                            'listasunattareas'      =>  $listasunattareas,
                            'combotd'               =>  $combotd,
                            'mensaje'               =>  $mensaje,
                            'funcion'               =>  $funcion,
                            'ajax'                  =>  true,
                         ]);
    }




    public function actionDetallaComprobanteLGValidado($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        View::share('titulo','Detalle Liquidacion de Gastos Administracion');
        $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
        $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
        $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();
        $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('EXTENSION', 'like', '%'.'pdf'.'%')->get();
        $ocultar                =   "";
        // Construir el array de URLs
        $initialPreview = [];
        foreach ($archivospdf as $archivo) {
            $initialPreview[] = route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]);
        }

        //dd($initialPreview);
        $initialPreviewConfig = [];

        foreach ($archivospdf as $key => $archivo) {
            $valor                = '';
            if($key>0){
                $valor            = 'ocultar';
            }
            $initialPreviewConfig[] = [
                'type'          => "pdf",
                'caption'       => $archivo->NOMBRE_ARCHIVO,
                'downloadUrl'   => route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]),
                'frameClass'    => $archivo->ID_DOCUMENTO.$archivo->DOCUMENTO_ITEM.' '.$valor //
            ];
        }

        $productosagru      =   DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
                        ->select('COD_PRODUCTO', 'TXT_PRODUCTO', DB::raw('SUM(CANTIDAD) as CANTIDAD'), DB::raw('SUM(TOTAL) as TOTAL'))
                        ->where('ID_DOCUMENTO', $iddocumento)
                        ->where('ACTIVO', 1)
                        ->groupBy('COD_PRODUCTO', 'TXT_PRODUCTO')
                        ->get();

        return View::make('liquidaciongasto/detallelgvalidado', 
                        [
                            'liquidaciongastos'     =>  $liquidaciongastos,
                            'tdetliquidaciongastos' =>  $tdetliquidaciongastos,
                            'productosagru' =>  $productosagru,
                            'detdocumentolg'        =>  $detdocumentolg,
                            'documentohistorial'    =>  $documentohistorial,
                            'idopcion'              =>  $idopcion,
                            'idcab'                 =>  $idcab,
                            'iddocumento'           =>  $iddocumento,
                            'initialPreview'        => json_encode($initialPreview),
                            'initialPreviewConfig'  => json_encode($initialPreviewConfig),      
                        ]);


    }
    public function actionAjaxUCListarLiquidacionGastos(Request $request) {

        $fecha_inicio   =   $request['fecha_inicio'];
        $fecha_fin      =   $request['fecha_fin'];
        $idopcion       =   $request['idopcion'];

        $listacabecera      =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                ->whereRaw("CAST(FECHA_CREA  AS DATE) >= ? and CAST(FECHA_CREA  AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                ->orderby('FECHA_CREA','DESC')->get();
        $funcion        =   $this;

        return View::make('liquidaciongasto/ajax/alistaliquidaciongasto',
                         [
                            'fecha_inicio'          =>  $fecha_inicio,
                            'fecha_fin'             =>  $fecha_fin,
                            'idopcion'              =>  $idopcion,
                            'listacabecera'         =>  $listacabecera,
                            'ajax'                  =>  true,
                            'funcion'               =>  $funcion
                         ]);
    }



    public function actionListarAjaxBuscarDocumentoLG(Request $request) {

        $fecha_inicio   =   $request['fecha_inicio'];
        $fecha_fin      =   $request['fecha_fin'];
        $proveedor_id   =   $request['proveedor_id'];  
        $estado_id      =   $request['estado_id'];
        $idopcion       =   $request['idopcion'];


        $listadatos     =   $this->lg_lista_cabecera_comprobante_total_validado($fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);
        $funcion        =   $this;

        return View::make('liquidaciongasto/ajax/alistalgvalidado',
                         [
                            'fecha_inicio'          =>  $fecha_inicio,
                            'fecha_fin'             =>  $fecha_fin,
                            'proveedor_id'          =>  $proveedor_id,
                            'estado_id'             =>  $estado_id,
                            'idopcion'              =>  $idopcion,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'funcion'               =>  $funcion
                         ]);
    }



    public function actionListarLGValidado($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Liquidación de Gastos');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;

        $fecha_inicio   =   $this->fecha_menos_diez_dias;
        $fecha_fin      =   $this->fecha_sin_hora;
        $proveedor_id   =   'TODO';
        $combo_proveedor=   $this->lg_combo_trabajador_fe_documento($proveedor_id);
        $estado_id      =   'TODO';
        $combo_estado   =   $this->gn_combo_estado_fe_documento($estado_id);
        $listadatos      =   $this->lg_lista_cabecera_comprobante_total_validado($fecha_inicio,$fecha_fin,$proveedor_id,$estado_id);

        $funcion        =   $this;
        return View::make('liquidaciongasto/listalgvalidado',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin,
                            'proveedor_id'      =>  $proveedor_id,
                            'combo_proveedor'   =>  $combo_proveedor,
                            'estado_id'         =>  $estado_id,
                            'combo_estado'      =>  $combo_estado
                         ]);
    }



    public function actionAgregarExtornoAdministracion($idopcion, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $idordencompra;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($idordencompra,'LIQG');
        View::share('titulo','Extornar Liquidacion');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();
                $descripcion            =   $request['descripcionextorno'];

                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento                              =   new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $liquidaciongastos->ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'DOCUMENTO EXTORNADO';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                //ANULAR TODA LA OPERACION
                LqgLiquidacionGasto::where('ID_DOCUMENTO',$iddocumento)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000006',
                                    'TXT_ESTADO'=>'RECHAZADO'
                                ]
                            );

                DB::commit();
                return Redirect::to('gestion-de-aprobacion-liquidacion-gastos-administracion/'.$idopcion)->with('bienhecho', 'Comprobante : '.$liquidaciongastos->ID_DOCUMENTO.' EXTORNADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-aprobacion-liquidacion-gastos-administracion/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
 
    }

    public function actionAgregarExtornoContabilidadLG($idopcion, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $idordencompra;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($idordencompra,'LIQG');
        View::share('titulo','Extornar Liquidacion');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();
                $descripcion            =   $request['descripcionextorno'];

                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento                              =   new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $liquidaciongastos->ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'DOCUMENTO EXTORNADO';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                //ANULAR TODA LA OPERACION
                LqgLiquidacionGasto::where('ID_DOCUMENTO',$iddocumento)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000006',
                                    'TXT_ESTADO'=>'RECHAZADO'
                                ]
                            );

                DB::commit();
                return Redirect::to('gestion-de-aprobacion-liquidacion-gastos-contabilidad/'.$idopcion)->with('bienhecho', 'Comprobante : '.$liquidaciongastos->ID_DOCUMENTO.' EXTORNADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-aprobacion-liquidacion-gastos-contabilidad/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
 
    }



    public function actionAgregarExtornoJefe($idopcion, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $idordencompra;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($idordencompra,'LIQG');
        View::share('titulo','Extornar Liquidacion');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();
                $descripcion            =   $request['descripcionextorno'];

                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento                              =   new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $liquidaciongastos->ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'DOCUMENTO EXTORNADO';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                //ANULAR TODA LA OPERACION
                LqgLiquidacionGasto::where('ID_DOCUMENTO',$iddocumento)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000006',
                                    'TXT_ESTADO'=>'RECHAZADO'
                                ]
                            );

                DB::commit();
                return Redirect::to('gestion-de-aprobacion-liquidacion-gasto-jefe/'.$idopcion)->with('bienhecho', 'Comprobante : '.$liquidaciongastos->ID_DOCUMENTO.' EXTORNADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-aprobacion-liquidacion-gasto-jefe/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
 
    }


    public function actionAjaxLeerXmlLG(Request $request) {

        if ($request->hasFile('inputxml')) {
            $file            =      $request->file('inputxml');
            $ID_DOCUMENTO    =      $request['ID_DOCUMENTO'];


            //
            $contadorArchivos = Archivo::count();

            $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);

            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ID_DOCUMENTO;
            $nombrefile      =      $contadorArchivos.'-'.$file->getClientOriginalName();
            $valor           =      $this->versicarpetanoexiste($rutafile);
            $rutacompleta    =      $rutafile.'\\'.$nombrefile;
            $nombreoriginal  =      $file->getClientOriginalName();
            $info            =      new SplFileInfo($nombreoriginal);
            $extension       =      $info->getExtension();
            copy($file->getRealPath(),$rutacompleta);
            $path            =      $rutacompleta;
            $parser          =      new InvoiceParser();
            $xml             =      file_get_contents($path);
            $factura         =      $parser->parse($xml);

            if($factura->getClient()->getnumDoc()!= Session::get('empresas')->NRO_DOCUMENTO){
                return response()->json(
                    [
                        'mensaje' => 'El xml no corresponde a la empresa '.Session::get('empresas')->NRO_DOCUMENTO,
                        'error' => '1'
                    ]);
            }

            $COD_EMPRESA            =   '';
            $TXT_EMPRESA            =   '';
            $SUCCESS                =   '';
            $MESSAGE                =   '';
            $ESTADOCP               =   '';
            $NESTADOCP              =   '';
            $ESTADORUC              =   '';
            $NESTADORUC             =   '';
            $CONDDOMIRUC            =   '';
            $NCONDDOMIRUC           =   '';
            $CODIGO_CDR             =   '';
            $RESPUESTA_CDR          =   '';    

            $empresa_trab           =   STDEmpresa::where('NRO_DOCUMENTO','=',$factura->getcompany()->getruc())->first();
            if(count($empresa_trab)>0){
                $COD_EMPRESA            =   $empresa_trab->COD_EMPR;
                $TXT_EMPRESA            =   $factura->getcompany()->getruc().' - '.$empresa_trab->NOM_EMPR;    
            }
            $NUMERO                 =   (int)$factura->getcorrelativo();
            $CORRELATIVO            =   str_pad($NUMERO, '10', "0", STR_PAD_LEFT);


            $token = '';
            if($prefijocarperta =='II'){
                $token           =      $this->generartoken_ii();
            }else{
                $token           =      $this->generartoken_is();
            }


            $fechaemision        =      date_format(date_create($factura->getfechaEmision()->format('Ymd')), 'd/m/Y');
            $rvalidar            =      $this->validar_xml( $token,
                                            Session::get('empresas')->NRO_DOCUMENTO,
                                            $factura->getcompany()->getruc(),
                                            $factura->gettipoDoc(),
                                            $factura->getserie(),
                                            $factura->getcorrelativo(),
                                            $fechaemision,
                                            $factura->getmtoImpVenta());

            $arvalidar = json_decode($rvalidar, true);
            if(isset($arvalidar['success'])){
                if($arvalidar['success']){
                    $datares              = $arvalidar['data'];
                    if (!isset($datares['estadoCp'])){
                        return response()->json(
                            [
                                'mensaje' => 'Hay fallas en sunat para consultar el XML',
                                'error' => '1'
                            ]);
                    }
                    $estadoCp             = $datares['estadoCp'];
                    $tablaestacp          = Estado::where('tipo','=','estadoCp')->where('codigo','=',$estadoCp)->first();
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

                    $SUCCESS                =   $arvalidar['success'];
                    $MESSAGE                =   $arvalidar['message'];
                    $ESTADOCP               =   $tablaestacp->codigo;
                    $NESTADOCP              =   $tablaestacp->nombre;
                    $ESTADORUC              =   $estadoRuc;
                    $NESTADORUC             =   $txtestadoRuc;
                    $CONDDOMIRUC            =   $estadoDomiRuc;
                    $NCONDDOMIRUC           =   $txtestadoDomiRuc;

                }else{

                    $SUCCESS                =   $arvalidar['success'];
                    $MESSAGE                =   $arvalidar['message'];
                }
            }

            $DETALLES = [];
            $ind_igv = 'NO';
            $igv = 0;
            $subventa = 0;
            $venta = 0;

            foreach ($factura->getdetails() as $indexdet => $itemdet) {
                $producto = str_replace("<![CDATA[","",$itemdet->getdescripcion());
                $producto = str_replace("]]>","",$producto);
                $producto = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);
                $linea = str_pad($indexdet + 1, 3, "0", STR_PAD_LEFT);
                if((float) $itemdet->getigv()>0){
                    $ind_igv = 'SI';
                }
                $igv = $igv + (float) $itemdet->getigv();
                $subventa = $subventa + (float) $itemdet->getmtoValorVenta();
                $venta = $venta + (float) $itemdet->getmtoValorVenta();

            }

            if($venta == 0){
                $venta = $factura->getmtoImpVenta();
            }
            $igv = 0;
            if($ind_igv == 'SI'){
                $igv = $factura->getmtoImpVenta() - $factura->getmtoIGV();
            }


            $linea = str_pad(1, 3, "0", STR_PAD_LEFT);

            $DETALLES[] = [
                'LINEID'             => $linea,
                'CODPROD'            => '0000001',
                'PRODUCTO'           => 'SERVICIO DE FACTURA',
                'UND_PROD'           => 'UND',
                'CANTIDAD'           => 1,
                'PRECIO_UNIT'        => 1,
                'VAL_IGV_ORIG'       => $factura->getmtoIGV(),
                'VAL_IGV_SOL'        => $factura->getmtoIGV(),
                'VAL_SUBTOTAL_ORIG'  => $igv,
                'VAL_SUBTOTAL_SOL'   => $igv,
                'VAL_VENTA_ORIG'     => $factura->getmtoImpVenta(),
                'VAL_VENTA_SOL'      => $factura->getmtoImpVenta(),
                'PRECIO_ORIG'        => $factura->getmtoImpVenta()
            ];

            // Ejemplo: devolver una parte del XML
            return response()->json([
                'mensaje' => 'Archivo recibido correctamente',
                'error' => '0',
                'RUC_PROVEEDOR' => $factura->getcompany()->getruc(),
                'RZ_PROVEEDOR' => $factura->getcompany()->getrazonSocial(),
                'COD_EMPRESA' => $COD_EMPRESA,
                'TXT_EMPRESA' => $TXT_EMPRESA,
                'SERIE' => $factura->getserie(),
                'NUMERO' => $CORRELATIVO,
                'FEC_VENTA' => $factura->getfechaEmision()->format('d-m-Y'),
                'TOTAL_VENTA_ORIG' => $factura->getmtoImpVenta(),
                'SUCCESS' => $SUCCESS,
                'MESSAGE' => $MESSAGE,
                'ESTADOCP' => $ESTADOCP,
                'NESTADOCP' => $NESTADOCP,
                'ESTADORUC' => $ESTADORUC,
                'NESTADORUC' => $NESTADORUC,
                'CONDDOMIRUC' => $CONDDOMIRUC,
                'NCONDDOMIRUC' => $NCONDDOMIRUC,
                'NOMBREFILE' => $nombrefile,
                'RUTACOMPLETA' => $rutacompleta,
                'DETALLE' => $DETALLES
            ]);
        }

        return response()->json(
            [
                'mensaje' => 'Archivo no encontrado',
                'error' => '1'
            ]);

    }

    public function actionAjaxLeerXmlLGSunat(Request $request) {

        $file            =      $request->file('inputxml');
        $ID_DOCUMENTO    =      $request['ID_DOCUMENTO'];
        $RUTAXML         =      $request['RUTAXML'];
        $RUTAPDF         =      $request['RUTAPDF'];
        $RUTACDR         =      $request['RUTACDR'];
        $exml            =      $request['exml'];
        $epdf            =      $request['epdf'];
        $ecdr            =      $request['ecdr'];

        $path            =      $RUTAXML;

        $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);

        $parser          =      new InvoiceParser();
        $xml             =      file_get_contents($path);
        $factura         =      $parser->parse($xml);

        if($factura->getClient()->getnumDoc()!= Session::get('empresas')->NRO_DOCUMENTO){
            return response()->json(
                [
                    'mensaje' => 'El xml no corresponde a la empresa '.Session::get('empresas')->NRO_DOCUMENTO,
                    'error' => '1'
                ]);
        }

        $COD_EMPRESA            =   '';
        $TXT_EMPRESA            =   '';
        $SUCCESS                =   '';
        $MESSAGE                =   '';
        $ESTADOCP               =   '';
        $NESTADOCP              =   '';
        $ESTADORUC              =   '';
        $NESTADORUC             =   '';
        $CONDDOMIRUC            =   '';
        $NCONDDOMIRUC           =   '';
        $CODIGO_CDR             =   '';
        $RESPUESTA_CDR          =   '';    

        $empresa_trab           =   STDEmpresa::where('NRO_DOCUMENTO','=',$factura->getcompany()->getruc())->first();
        if(count($empresa_trab)>0){
            $COD_EMPRESA            =   $empresa_trab->COD_EMPR;
            $TXT_EMPRESA            =   $factura->getcompany()->getruc().' - '.$empresa_trab->NOM_EMPR;    
        }
        $NUMERO                 =   (int)$factura->getcorrelativo();
        $CORRELATIVO            =   str_pad($NUMERO, '10', "0", STR_PAD_LEFT);


        $token = '';
        if($prefijocarperta =='II'){
            $token           =      $this->generartoken_ii();
        }else{
            $token           =      $this->generartoken_is();
        }


        $fechaemision        =      date_format(date_create($factura->getfechaEmision()->format('Ymd')), 'd/m/Y');
        $rvalidar            =      $this->validar_xml( $token,
                                        Session::get('empresas')->NRO_DOCUMENTO,
                                        $factura->getcompany()->getruc(),
                                        $factura->gettipoDoc(),
                                        $factura->getserie(),
                                        $factura->getcorrelativo(),
                                        $fechaemision,
                                        $factura->getmtoImpVenta());

        $arvalidar = json_decode($rvalidar, true);
        if(isset($arvalidar['success'])){
            if($arvalidar['success']){
                $datares              = $arvalidar['data'];
                if (!isset($datares['estadoCp'])){
                    return response()->json(
                        [
                            'mensaje' => 'Hay fallas en sunat para consultar el XML',
                            'error' => '1'
                        ]);
                }
                $estadoCp             = $datares['estadoCp'];
                $tablaestacp          = Estado::where('tipo','=','estadoCp')->where('codigo','=',$estadoCp)->first();
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

                $SUCCESS                =   $arvalidar['success'];
                $MESSAGE                =   $arvalidar['message'];
                $ESTADOCP               =   $tablaestacp->codigo;
                $NESTADOCP              =   $tablaestacp->nombre;
                $ESTADORUC              =   $estadoRuc;
                $NESTADORUC             =   $txtestadoRuc;
                $CONDDOMIRUC            =   $estadoDomiRuc;
                $NCONDDOMIRUC           =   $txtestadoDomiRuc;

            }else{

                $SUCCESS                =   $arvalidar['success'];
                $MESSAGE                =   $arvalidar['message'];
            }
        }

        $DETALLES = [];
        $UNIDAD = "";
        $getmtoValorVenta = 0;
        $getigv = 0;  


        $otrostributos       =   (float) $factura->getmtoOtrosTributos();

        foreach ($factura->getdetails() as $indexdet => $itemdet) {
            $producto = str_replace("<![CDATA[","",$itemdet->getdescripcion());
            $producto = str_replace("]]>","",$producto);
            $producto = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);
            $linea = str_pad($indexdet + 1, 3, "0", STR_PAD_LEFT);
            $ind_igv = 'NO';
            if((float) $itemdet->getigv()>0){
                $ind_igv = 'SI';
            }
            $UNIDAD = $itemdet->getunidad();
            $getmtoValorVenta = $getmtoValorVenta + $itemdet->getmtoValorVenta();
            $getigv = $getigv + $itemdet->getigv();

        }

        $DETALLES[] = [
            'LINEID'             => '001',
            'CODPROD'            => "PRD000000000001",
            'PRODUCTO'           => "DETALLE DE LA FACTURA",
            'UND_PROD'           => $UNIDAD,
            'CANTIDAD'           => 1,
            'PRECIO_UNIT'        => (float) $getmtoValorVenta,
            'VAL_IGV_ORIG'       => $ind_igv,
            'VAL_IGV_SOL'        => (float) $getigv,
            'VAL_SUBTOTAL_ORIG'  => (float) $getmtoValorVenta,
            'VAL_SUBTOTAL_SOL'   => (float) $getmtoValorVenta,
            'VAL_VENTA_ORIG'     => (float) $getigv + (float) $getmtoValorVenta + $otrostributos,
            'VAL_VENTA_SOL'      => (float) $getigv + (float) $getmtoValorVenta + $otrostributos,
            'PRECIO_ORIG'        => (float) $getmtoValorVenta
        ];



        // Ejemplo: devolver una parte del XML
        return response()->json([
            'mensaje' => 'Archivo recibido correctamente',
            'error' => '0',
            'RUC_PROVEEDOR' => $factura->getcompany()->getruc(),
            'RZ_PROVEEDOR' => $factura->getcompany()->getrazonSocial(),
            'COD_EMPRESA' => $COD_EMPRESA,
            'TXT_EMPRESA' => $TXT_EMPRESA,
            'SERIE' => $factura->getserie(),
            'NUMERO' => $CORRELATIVO,
            'FEC_VENTA' => $factura->getfechaEmision()->format('d-m-Y'),
            'TOTAL_VENTA_ORIG' => (float) $getigv + (float) $getmtoValorVenta + $otrostributos,
            'SUCCESS' => $SUCCESS,
            'MESSAGE' => $MESSAGE,
            'ESTADOCP' => $ESTADOCP,
            'NESTADOCP' => $NESTADOCP,
            'ESTADORUC' => $ESTADORUC,
            'NESTADORUC' => $NESTADORUC,
            'CONDDOMIRUC' => $CONDDOMIRUC,
            'NCONDDOMIRUC' => $NCONDDOMIRUC,
            'NOMBREFILE' => $exml,
            'RUTACOMPLETA' => $RUTAXML,
            'DETALLE' => $DETALLES,
            'RUTAXML' => $RUTAXML,
            'RUTAPDF' => $RUTAPDF,
            'RUTACDR' => $RUTACDR,
            'exml' => $exml,
            'epdf' => $epdf,
            'ecdr' => $ecdr
        ]);


    }


    public function actionAgregarNuevoFormato(Request $request) {

        $resultado = DB::table('LQG_DETLIQUIDACIONGASTO as lqg')
            ->join('PLA_MOVILIDAD as pla', 'lqg.COD_PLA_MOVILIDAD', '=', 'pla.ID_DOCUMENTO')
            ->where('lqg.COD_TIPODOCUMENTO', 'TDO0000000000070')
            //->where('lqg.ID_DOCUMENTO','=','LIQG00000052')
            ->select('lqg.*') // o select específico si necesitas columnas concretas
            ->get();

        //dd($resultado);    

        foreach ($resultado as $index => $item) {

            $documento_planilla        =       $item->COD_PLA_MOVILIDAD;
            $data_iddocumento          =       $item->ID_DOCUMENTO;

            $detliquidaciongasto       =       LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$data_iddocumento)->first();
            $useario_autoriza          =       User::where('id','=',$detliquidaciongasto->COD_USUARIO_AUTORIZA)->first();
            $planillamovilidad         =       DB::table('PLA_MOVILIDAD')
                                               ->where('ID_DOCUMENTO', $documento_planilla)
                                               ->first();
            $COD_CUENTA                 =       '';   
            $TXT_CUENTA                 =       '';


            $contratos                 =        DB::table('CMP.CONTRATO')
                                                ->where('COD_EMPR_CLIENTE', 'IACHEM0000009164')
                                                ->where('COD_EMPR', $planillamovilidad->COD_EMPRESA)
                                                ->where('COD_CENTRO', $planillamovilidad->COD_CENTRO)
                                                ->first();


            if(count($contratos)>0){
                $cod_contrato = $contratos->COD_CONTRATO; // Ejemplo de contrato
                $cod_categoria_moneda = $contratos->COD_CATEGORIA_MONEDA; // Ejemplo de moneda
                $txt_categoria_tipo_contrato = $contratos->TXT_CATEGORIA_TIPO_CONTRATO; // Ejemplo de categoría
                // Obtener los primeros 6 caracteres
                $parte1 = substr($cod_contrato, 0, 6);
                // Obtener los últimos 10 caracteres y convertir a entero
                $parte2 = intval(substr($cod_contrato, -10));
                // Determinar el símbolo de la moneda
                $simbolo = ($cod_categoria_moneda === 'MON0000000000001') ? 'S/' : '$';
                // Concatenar todo
                $contrato = $parte1 . '-0' . $parte2 . ' -- ' . $simbolo . ' ' . $txt_categoria_tipo_contrato;
                $COD_CUENTA                 =       $contratos->COD_CONTRATO;   
                $TXT_CUENTA                 =       $contrato; 
                $subcontrato                =       DB::table('CMP.CONTRATO_CULTIVO')
                                                    ->selectRaw("
                                                        COD_CONTRATO,
                                                        TXT_ZONA_COMERCIAL+'-'+TXT_ZONA_CULTIVO as TXT_CULTIVO
                                                    ")
                                                    ->where('COD_CONTRATO', $COD_CUENTA)
                                                    ->first();
                $COD_SUBCUENTA                 =       $subcontrato->COD_CONTRATO;   
                $TXT_SUBCUENTA                 =       $subcontrato->TXT_CULTIVO;
            }

            //GUARDAR PDF
            $iddocumento            =   $documento_planilla;
            $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
            $detplanillamovilidad   =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->orderby('FECHA_GASTO','ASC')->get();
            $empresa                =   STDEmpresa::where('COD_EMPR','=',$planillamovilidad->COD_EMPRESA)->first();
            $ruc                    =   $empresa->NRO_DOCUMENTO;
            $prefijocarperta        =   $this->prefijo_empresa($item->COD_EMPRESA);
            $rutafile               =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$data_iddocumento;
            $valor                  =   $this->versicarpetanoexiste($rutafile);
            $rutacompleta           =   $rutafile . '\\' . $planillamovilidad->SERIE . '-' . $planillamovilidad->NUMERO . '.pdf';
            $nombrearchivo          =   $planillamovilidad->SERIE . '-' . $planillamovilidad->NUMERO . '.pdf';
            $glosa                  =   $planillamovilidad->TXT_GLOSA;

            $trabajador             =   STDTrabajador::where('COD_TRAB','=',$planillamovilidad->COD_TRABAJADOR)->first();
            $imgresponsable         =   'firmas/blanco.jpg';
            $nombre_responsable     =   '';
            $rutaImagen             =   public_path('firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg');
            $sw = 0;
            if (file_exists($rutaImagen)){
                $imgresponsable         =   'firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg';
                $nombre_responsable     =   $trabajador->TXT_NOMBRES.' '.$trabajador->TXT_APE_PATERNO.' '.$trabajador->TXT_APE_MATERNO;
            }else{
                $sw = 1;
                print_r('TRABAJADOR : '.$trabajador->TXT_NOMBRES.' '.$trabajador->TXT_APE_PATERNO.' '.$trabajador->TXT_APE_MATERNO.'<br>');
            }

            $trabajadorap           =   STDTrabajador::where('COD_TRAB','=',$useario_autoriza->usuarioosiris_id)->first();
            $imgaprueba             =   'firmas/blanco.jpg';
            $nombre_aprueba         =   '';
            $rutaImagen             =   public_path('firmas/'.$trabajadorap->NRO_DOCUMENTO.'.jpg');


            $direccion              =   $this->gn_direccion_fiscal();
            //DD($rutacompleta);
            $pdf = PDF::loadView('pdffa.planillamovilidad', [ 
                                                    'iddocumento'           => $iddocumento , 
                                                    'planillamovilidad'     => $planillamovilidad,
                                                    'detplanillamovilidad'  => $detplanillamovilidad,
                                                    'ruc'                   => $ruc,
                                                    'imgresponsable'        => $imgresponsable , 
                                                    'nombre_responsable'    => $nombre_responsable,
                                                    'imgaprueba'            => $imgaprueba,
                                                    'nombre_aprueba'        => $nombre_aprueba,
                                                    'direccion'                     => $direccion,

                                                 ])->setPaper('A4', 'landscape');

            $pdf->save($rutacompleta);



        }

    }


    


    public function actionModalSelectDocumentoPlanillaLG(Request $request) {

        $documento_planilla        =       $request['documento_planilla'];
        $data_iddocumento          =       $request['data_iddocumento'];
        $detliquidaciongasto       =       LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$data_iddocumento)->first();

        $useario_autoriza          =       User::where('id','=',$detliquidaciongasto->COD_USUARIO_AUTORIZA)->first();



        $planillamovilidad         =       DB::table('PLA_MOVILIDAD')
                                           ->where('ID_DOCUMENTO', $documento_planilla)
                                           ->first();

        $COD_CUENTA                 =       '';   
        $TXT_CUENTA                 =       '';


        $contratos                 =        DB::table('CMP.CONTRATO')
                                            ->where('COD_EMPR_CLIENTE', 'IACHEM0000009164')
                                            ->where('COD_EMPR', $planillamovilidad->COD_EMPRESA)
                                            ->where('COD_CENTRO', $planillamovilidad->COD_CENTRO)
                                            ->first();



        if(count($contratos)>0){
            $cod_contrato = $contratos->COD_CONTRATO; // Ejemplo de contrato
            $cod_categoria_moneda = $contratos->COD_CATEGORIA_MONEDA; // Ejemplo de moneda
            $txt_categoria_tipo_contrato = $contratos->TXT_CATEGORIA_TIPO_CONTRATO; // Ejemplo de categoría
            // Obtener los primeros 6 caracteres
            $parte1 = substr($cod_contrato, 0, 6);
            // Obtener los últimos 10 caracteres y convertir a entero
            $parte2 = intval(substr($cod_contrato, -10));
            // Determinar el símbolo de la moneda
            $simbolo = ($cod_categoria_moneda === 'MON0000000000001') ? 'S/' : '$';
            // Concatenar todo
            $contrato = $parte1 . '-0' . $parte2 . ' -- ' . $simbolo . ' ' . $txt_categoria_tipo_contrato;
            $COD_CUENTA                 =       $contratos->COD_CONTRATO;   
            $TXT_CUENTA                 =       $contrato; 
            $subcontrato                =       DB::table('CMP.CONTRATO_CULTIVO')
                                                ->selectRaw("
                                                    COD_CONTRATO,
                                                    TXT_ZONA_COMERCIAL+'-'+TXT_ZONA_CULTIVO as TXT_CULTIVO
                                                ")
                                                ->where('COD_CONTRATO', $COD_CUENTA)
                                                ->first();
            $COD_SUBCUENTA                 =       $subcontrato->COD_CONTRATO;   
            $TXT_SUBCUENTA                 =       $subcontrato->TXT_CULTIVO;
        }

        //GUARDAR PDF
        $iddocumento            =   $documento_planilla;
        $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
        $detplanillamovilidad   =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->orderby('FECHA_GASTO','ASC')->get();
        $empresa                =   STDEmpresa::where('COD_EMPR','=',$planillamovilidad->COD_EMPRESA)->first();
        $ruc                    =   $empresa->NRO_DOCUMENTO;
        $prefijocarperta        =   $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $rutafile               =   $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$data_iddocumento;
        $valor                  =   $this->versicarpetanoexiste($rutafile);
        $rutacompleta           =   $rutafile . '\\' . $planillamovilidad->SERIE . '-' . $planillamovilidad->NUMERO . '.pdf';
        $nombrearchivo          =   $planillamovilidad->SERIE . '-' . $planillamovilidad->NUMERO . '.pdf';
        $glosa                  =   $planillamovilidad->TXT_GLOSA;

        $trabajador             =   STDTrabajador::where('COD_TRAB','=',$planillamovilidad->COD_TRABAJADOR)->first();
        $imgresponsable         =   'firmas/blanco.jpg';
        $nombre_responsable     =   '';
        $rutaImagen             =   public_path('firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg');
        if (file_exists($rutaImagen)){
            $imgresponsable         =   'firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg';
            $nombre_responsable     =   $trabajador->TXT_NOMBRES.' '.$trabajador->TXT_APE_PATERNO.' '.$trabajador->TXT_APE_MATERNO;
        }
        $trabajadorap           =   STDTrabajador::where('COD_TRAB','=',$useario_autoriza->usuarioosiris_id)->first();
        $imgaprueba             =   'firmas/blanco.jpg';
        $nombre_aprueba         =   '';
        $rutaImagen             =   public_path('firmas/'.$trabajadorap->NRO_DOCUMENTO.'.jpg');
        if (file_exists($rutaImagen)){
            $imgaprueba         =   'firmas/'.$trabajadorap->NRO_DOCUMENTO.'.jpg';
            $nombre_aprueba     =   $trabajadorap->TXT_NOMBRES.' '.$trabajadorap->TXT_APE_PATERNO.' '.$trabajadorap->TXT_APE_MATERNO;
        }
        $direccion              =   $this->gn_direccion_fiscal();



        $pdf = PDF::loadView('pdffa.planillamovilidad', [ 
                                                'iddocumento'           => $iddocumento , 
                                                'planillamovilidad'     => $planillamovilidad,
                                                'detplanillamovilidad'  => $detplanillamovilidad,
                                                'ruc'                   => $ruc,
                                                'imgresponsable'        => $imgresponsable , 
                                                'nombre_responsable'    => $nombre_responsable,
                                                'imgaprueba'            => $imgaprueba,
                                                'nombre_aprueba'        => $nombre_aprueba,
                                                'direccion'                     => $direccion,
                                              ])->setPaper('A4', 'landscape');

        $pdf->save($rutacompleta);




        return response()->json([
            'EMPRESA'       => 'PLANILLA DE MOVILIDAD SIN COMPROBANTE',
            'SERIE'         => $planillamovilidad->SERIE,
            'NUMERO'        => $planillamovilidad->NUMERO,
            'COD_CUENTA'    => $COD_CUENTA,
            'TXT_CUENTA'    => $TXT_CUENTA,
            'COD_SUBCUENTA' => $COD_SUBCUENTA,
            'TXT_SUBCUENTA' => $TXT_SUBCUENTA,
            'COD_PLANILLA'  => $planillamovilidad->ID_DOCUMENTO,
            'FECHA_EMI'     => date_format(date_create($planillamovilidad->FECHA_EMI), 'd-m-Y'),
            'TOTAL'         => $planillamovilidad->TOTAL,
            'rutacompleta'  => $rutacompleta,
            'glosa'         => $glosa,
            'nombrearchivo' => $nombrearchivo
        ]);


    }


    public function actionModalBuscarPlanillaLG(Request $request) {

        $iddocumento        =       $request['data_iddocumento'];
        $idopcion           =       $request['idopcion'];
        $detliquidaciongasto=       LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $funcion            =       $this;
        $fecha_fin          =       $this->fecha_sin_hora;

        $lpmovilidades      =       DB::table('PLA_MOVILIDAD')
                                    ->where('USUARIO_CREA', Session::get('usuario')->id)
                                    ->where('ACTIVO','=','1')
                                    ->where('COD_ESTADO','=','ETM0000000000008')
                                    ->where('COD_EMPRESA', $detliquidaciongasto->COD_EMPRESA)
                                    ->whereNotIn('ID_DOCUMENTO', function($query) {
                                        $query->select(DB::raw('ISNULL(COD_PLA_MOVILIDAD, \'\')'))
                                              ->from('LQG_DETLIQUIDACIONGASTO')
                                              ->where('ACTIVO', '=', '1'); // Agregar esta condición
                                    })
                                    ->get();

        return View::make('liquidaciongasto/modal/ajax/mlistaplanillamovilidad',
                         [
                            'iddocumento'           =>  $iddocumento,
                            'idopcion'              =>  $idopcion,
                            'lpmovilidades'         =>  $lpmovilidades,
                            'funcion'               =>  $funcion,
                            'ajax'                  =>  true,
                         ]);
    }


    public function actionAprobarAdministracionLG($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        View::share('titulo','Aprobar Liquidacion de Gastos Administracion');

        if($_POST)
        {
            try{    
            
                DB::beginTransaction();
                $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();


                if($liquidaciongastos->IND_OBSERVACION==1){
                    DB::rollback(); 
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }
                //VALIDAR SI TIENE SERIE
                $COD_TRAB               =   '';
                $SERIE                  =   '';

                $trabajadormerge        =   DB::table('STD.TRABAJADOR')
                                            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                            ->first();
                $trabajador             =   DB::table('STD.TRABAJADOR')
                                            ->where('NRO_DOCUMENTO', $trabajadormerge->NRO_DOCUMENTO)
                                            ->where('COD_EMPR', $liquidaciongastos->COD_EMPRESA)
                                            ->first();
                if(count($trabajador)>0){
                    $COD_TRAB           =   $trabajador->COD_TRAB;
                }
                $resultados_serie       =   DB::table('CMP.REFERENCIA_ASOC as RA')
                                            ->join('STD.TRABAJADOR as T', function ($join) {
                                                $join->on('T.COD_TRAB', '=', 'RA.COD_TABLA_ASOC')
                                                     ->where('T.COD_ESTADO', '=', 1);
                                            })
                                            ->join('STD.DOCUMENTO_SERIE as TBL', function ($join) {
                                                $join->on('TBL.COD_DOC_SERIE', '=', 'RA.COD_TABLA')
                                                     ->where('TBL.COD_ESTADO', '=', 1);
                                            })
                                            ->leftJoin('CMP.CATEGORIA as TD', function ($join) {
                                                $join->on('TD.COD_CATEGORIA', '=', 'TBL.COD_CATEGORIA_TIPO_DOCUMENTO')
                                                     ->where('TD.TXT_GRUPO', '=', 'TIPO_DOCUMENTO')
                                                     ->where('TD.COD_ESTADO', '=', 1);
                                            })
                                            ->select(
                                                'TBL.COD_EMPR',
                                                'TBL.COD_CENTRO',
                                                'TBL.COD_CATEGORIA_TIPO_DOCUMENTO',
                                                'TD.NOM_CATEGORIA as CATEGORIA_TIPO_DOCUMENTO',
                                                'TBL.NRO_SERIE'
                                            )
                                            ->where('TBL.COD_CATEGORIA_TIPO_DOCUMENTO', 'TDO0000000000028')
                                            ->where('TBL.COD_EMPR', $liquidaciongastos->COD_EMPRESA)
                                            ->where('TBL.COD_CENTRO', $liquidaciongastos->COD_CENTRO)
                                            ->where('T.COD_TRAB', $COD_TRAB)
                                            ->where('TBL.IND_OPERACION', 'C')
                                            ->where('RA.COD_ESTADO', 1)
                                            ->first();

                if(count($resultados_serie)<=0){
    
                    return Redirect::to('aprobar-liquidacion-gasto-administracion/'.$idopcion.'/'.$idcab)->with('errorbd','Su Usuario no cuenta con serie para esta CENTRO Y EMPRESA');
                }

                $NUMERO                 =   0;
                $SERIE                  =   $resultados_serie->NRO_SERIE;
                $resultado_correlativo  =   DB::table('CMP.DOCUMENTO_CTBLE as TBL')
                                            ->select('TBL.COD_DOCUMENTO_CTBLE', 'TBL.NRO_SERIE', 'TBL.NRO_DOC')
                                            ->where('TBL.COD_DOCUMENTO_CTBLE', function ($query) use($liquidaciongastos,$resultados_serie) {
                                                $query->select('DOC.COD_DOCUMENTO_CTBLE')
                                                      ->from('CMP.DOCUMENTO_CTBLE as DOC')
                                                      ->where('DOC.COD_ESTADO', 1)
                                                      ->where('DOC.COD_EMPR', $liquidaciongastos->COD_EMPRESA)
                                                      ->where('DOC.NRO_SERIE', $resultados_serie->NRO_SERIE)
                                                      ->where('DOC.COD_CATEGORIA_TIPO_DOC', 'TDO0000000000028')
                                                      ->where('DOC.IND_COMPRA_VENTA', 'C')
                                                      ->orderByDesc('DOC.NRO_DOC')
                                                      ->limit(1);
                                            })
                                            ->limit(1)
                                            ->first();


                $NUMERO                 =   (int)$resultado_correlativo->NRO_DOC+1;
                $CORRELATIVO            =   str_pad($NUMERO, '10', "0", STR_PAD_LEFT);
                $descripcion        =   $request['descripcion'];
                if(rtrim(ltrim($descripcion)) != ''){
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   1;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'ACOTACION POR EL ADMINISTRACION';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();
                }

                LqgLiquidacionGasto::where('ID_DOCUMENTO',$liquidaciongastos->ID_DOCUMENTO)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000005',
                                    'TXT_ESTADO'=>'APROBADO',
                                    'COD_ADM_APRUEBA'=>Session::get('usuario')->id,
                                    'TXT_ADM_APRUEBA'=>Session::get('usuario')->nombre,
                                    'FECHA_ADM_APRUEBA'=>$this->fechaactual
                                ]
                            );
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR ADMINISTRACION';
                $documento->MENSAJE                     =   '';
                $documento->save();

                $anio                   =   $this->anio;
                $mes                    =   $this->mes;
                $periodo                =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
                $osiris                 =   $this->lg_enviar_osiris($liquidaciongastos,$tdetliquidaciongastos,$detdocumentolg,$SERIE,$CORRELATIVO,$periodo);
                LqgLiquidacionGasto::where('ID_DOCUMENTO',$liquidaciongastos->ID_DOCUMENTO)
                            ->update(
                                [
                                    'COD_OSIRIS'=>$osiris,
                                ]
                            );
                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-administracion/'.$idopcion)->with('bienhecho', 'LIQUIDACION DE GASTOS ('.$osiris.') : '.$liquidaciongastos->CODIGO.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/aprobar-liquidacion-gasto-administracion/'.$idopcion.'/'.$idcab)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
        else{


            $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
            //$tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();

            $tdetliquidaciongastos  =   DB::table('LQG_DETLIQUIDACIONGASTO')
                                        ->join('CMP.CONTRATO', 'LQG_DETLIQUIDACIONGASTO.COD_CUENTA', '=', 'CMP.CONTRATO.COD_CONTRATO')
                                        ->select('CMP.CONTRATO.TXT_CATEGORIA_MONEDA', 'LQG_DETLIQUIDACIONGASTO.*', 'CMP.CONTRATO.COD_CONTRATO')
                                        ->where('LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO', '=', $iddocumento)
                                        ->where('LQG_DETLIQUIDACIONGASTO.ACTIVO', '=', '1')
                                        ->get();



            $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
            $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();
            $tdetliquidaciongastosel=   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','0')->get();
            $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('EXTENSION', 'like', '%'.'pdf'.'%')->get();
            $ocultar                =   "";
            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]);
            }
            $initialPreviewConfig = [];



            foreach ($archivospdf as $key => $archivo) {
                $valor                = '';
                if($key>0){
                    $valor            = 'ocultar';
                }
                $initialPreviewConfig[] = [
                    'type'          => "pdf",
                    'caption'       => $archivo->NOMBRE_ARCHIVO,
                    'downloadUrl'   => route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]),
                    'frameClass'    => $archivo->ID_DOCUMENTO.$archivo->DOCUMENTO_ITEM.' '.$valor //
                ];
            }


            $productosagru      =   DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
                            ->select('COD_PRODUCTO', 'TXT_PRODUCTO', DB::raw('SUM(CANTIDAD) as CANTIDAD'), DB::raw('SUM(TOTAL) as TOTAL'))
                            ->where('ID_DOCUMENTO', $iddocumento)
                            ->where('ACTIVO', 1)
                            ->groupBy('COD_PRODUCTO', 'TXT_PRODUCTO')
                            ->get();

            return View::make('liquidaciongasto/aprobaradministracionlg', 
                            [
                                'liquidaciongastos'     =>  $liquidaciongastos,
                                'tdetliquidaciongastos' =>  $tdetliquidaciongastos,
                                'tdetliquidaciongastosel' =>  $tdetliquidaciongastosel,
                                'productosagru' =>  $productosagru,
                                'detdocumentolg'        =>  $detdocumentolg,
                                'documentohistorial'    =>  $documentohistorial,
                                'idopcion'              =>  $idopcion,
                                'idcab'                 =>  $idcab,
                                'iddocumento'           =>  $iddocumento,
                                'initialPreview'        => json_encode($initialPreview),
                                'initialPreviewConfig'  => json_encode($initialPreviewConfig),      
                            ]);


        }
    }


    public function actionAprobarContabilidadLG($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        View::share('titulo','Aprobar Liquidacion de Gastos Contabilidad');

        if($_POST)
        {
            try{    
            
                DB::beginTransaction();

                $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();


                if($liquidaciongastos->IND_OBSERVACION==1){
                    DB::rollback(); 
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }



                $descripcion        =   $request['descripcion'];
                if(rtrim(ltrim($descripcion)) != ''){
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   1;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'ACOTACION POR CONTABILIDAD';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();
                }

                LqgLiquidacionGasto::where('ID_DOCUMENTO',$liquidaciongastos->ID_DOCUMENTO)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000004',
                                    'TXT_ESTADO'=>'POR APROBAR ADMINISTRACION',
                                    'COD_JEFE_APRUEBA'=>Session::get('usuario')->id,
                                    'TXT_JEFE_APRUEBA'=>Session::get('usuario')->nombre,
                                    'FECHA_JEFE_APRUEBA'=>$this->fechaactual
                                ]
                            );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE                     =   '';
                $documento->save();

                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/'.$idopcion)->with('bienhecho', 'Liquidacion de Gastos : '.$liquidaciongastos->CODIGO.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
        else{


            $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
            $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
            $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
            $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();
            $tdetliquidaciongastosel=   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','0')->get();
            $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('EXTENSION', 'like', '%'.'pdf'.'%')->get();
            $ocultar                =   "";
            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]);
            }
            $initialPreviewConfig = [];



            foreach ($archivospdf as $key => $archivo) {
                $valor                = '';
                if($key>0){
                    $valor            = 'ocultar';
                }
                $initialPreviewConfig[] = [
                    'type'          => "pdf",
                    'caption'       => $archivo->NOMBRE_ARCHIVO,
                    'downloadUrl'   => route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]),
                    'frameClass'    => $archivo->ID_DOCUMENTO.$archivo->DOCUMENTO_ITEM.' '.$valor //
                ];
            }

            $productosagru      =   DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
                            ->select('COD_PRODUCTO', 'TXT_PRODUCTO', DB::raw('SUM(CANTIDAD) as CANTIDAD'), DB::raw('SUM(TOTAL) as TOTAL'))
                            ->where('ID_DOCUMENTO', $iddocumento)
                            ->where('ACTIVO', 1)
                            ->groupBy('COD_PRODUCTO', 'TXT_PRODUCTO')
                            ->get();

            //dd($tdetliquidaciongastos);

            return View::make('liquidaciongasto/aprobarcontabilidadlg', 
                            [
                                'liquidaciongastos'     =>  $liquidaciongastos,
                                'tdetliquidaciongastos' =>  $tdetliquidaciongastos,
                                'tdetliquidaciongastosel' =>  $tdetliquidaciongastosel,
                                'productosagru' =>  $productosagru,
                                'detdocumentolg'        =>  $detdocumentolg,
                                'documentohistorial'    =>  $documentohistorial,
                                'idopcion'              =>  $idopcion,
                                'idcab'                 =>  $idcab,
                                'iddocumento'           =>  $iddocumento,
                                'initialPreview'        => json_encode($initialPreview),
                                'initialPreviewConfig'  => json_encode($initialPreviewConfig),      
                            ]);


        }
    }



    public function actionAprobarLiquidacionGastoAdministracion($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista liquidacion de gastos (administracion)');
        $tab_id             =   'oc';
        if(isset($request['tab_id'])){
            $tab_id             =   $request['tab_id'];
        }

        $listadatos         =   $this->lg_lista_cabecera_comprobante_total_administracion();
        $listadatos_obs     =   $this->lg_lista_cabecera_comprobante_total_obs_administracion();
        $listadatos_obs_le  =   $this->lg_lista_cabecera_comprobante_total_obs_le_administracion();

        $funcion        =   $this;
        return View::make('liquidaciongasto/listaliquidaciongastoadministracion',
                         [
                            'listadatos'        =>  $listadatos,
                            'listadatos_obs'    =>  $listadatos_obs,
                            'listadatos_obs_le' =>  $listadatos_obs_le,
                            'tab_id'            =>  $tab_id,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }


    public function actionObservarJefeLG($idopcion, $iddocumento,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        View::share('titulo','Observar Liquidacion de Gastos');

        if($_POST)
        {

            try{    
                DB::beginTransaction();
                $data_archivo                  =   json_decode($request['data_observacion'], true);
                $descripcion                   =   $request['descripcion'];
                $liquidaciongastos             =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();

                if($liquidaciongastos->IND_OBSERVACION==1){
                    DB::rollback(); 
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }


                if(count($data_archivo)<=0){
                    DB::rollback(); 
                    return Redirect::back()->with('errorbd', 'Tiene que seleccionar almenos un item');
                }
                LqgLiquidacionGasto::where('ID_DOCUMENTO',$iddocumento)
                            ->update(
                                [
                                    'IND_OBSERVACION'=>1,
                                    'TXT_OBSERVACION'=>'OBSERVADO',
                                    'AREA_OBSERVACION'=>'JEFE'
                                ]
                            );
                foreach($data_archivo as $key => $obj){
                    $data_id         =   $obj['data_id'];
                    $data_item       =   $obj['data_item'];
                    LqgDetLiquidacionGasto::where('ID_DOCUMENTO',$data_id)->where('ITEM','=',$data_item)
                                ->update(
                                    [
                                        'IND_OBSERVACION'=>1,
                                        'AREA_OBSERVACION'=>'JEFE',
                                        'ACTIVO'=>0,
                                    ]
                                );

                    LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO',$data_id)->where('ITEM','=',$data_item)
                                ->update(
                                    [
                                        'ACTIVO'=>0,
                                    ]
                                );


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'OBSERVADO POR JEFE';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();
                $this->lg_calcular_total_observar($iddocumento);

                DB::commit();


                return Redirect::to('/gestion-de-aprobacion-liquidacion-gasto-jefe/'.$idopcion)->with('bienhecho', 'Liquidacion Gastos : '.$liquidaciongastos->CODIGO.' Observado con Exito');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gasto-jefe/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
    }

    public function actionObservarAdministradorLG($idopcion, $iddocumento,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        View::share('titulo','Observar Liquidacion de Gastos');

        if($_POST)
        {

            try{    
                DB::beginTransaction();
                $data_archivo                  =   json_decode($request['data_observacion'], true);
                $descripcion                   =   $request['descripcion'];
                $liquidaciongastos             =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();

                if($liquidaciongastos->IND_OBSERVACION==1){
                    DB::rollback(); 
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }


                if(count($data_archivo)<=0){
                    DB::rollback(); 
                    return Redirect::back()->with('errorbd', 'Tiene que seleccionar almenos un item');
                }
                LqgLiquidacionGasto::where('ID_DOCUMENTO',$iddocumento)
                            ->update(
                                [
                                    'IND_OBSERVACION'=>1,
                                    'TXT_OBSERVACION'=>'OBSERVADO',
                                    'AREA_OBSERVACION'=>'ADM'
                                ]
                            );
                foreach($data_archivo as $key => $obj){
                    $data_id         =   $obj['data_id'];
                    $data_item       =   $obj['data_item'];
                    LqgDetLiquidacionGasto::where('ID_DOCUMENTO',$data_id)->where('ITEM','=',$data_item)
                                ->update(
                                    [
                                        'IND_OBSERVACION'=>1,
                                        'AREA_OBSERVACION'=>'ADM',
                                        'ACTIVO'=>0,
                                    ]
                                );

                    LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO',$data_id)->where('ITEM','=',$data_item)
                                ->update(
                                    [
                                        'ACTIVO'=>0,
                                    ]
                                );


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'OBSERVADO POR ADMINISTRACION';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();
                $this->lg_calcular_total_observar($iddocumento);

                DB::commit();


                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-administracion/'.$idopcion)->with('bienhecho', 'Liquidacion Gastos : '.$liquidaciongastos->CODIGO.' Observado con Exito');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-administracion/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
    }


    public function actionObservarContabilidadLG($idopcion, $iddocumento,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        View::share('titulo','Observar Liquidacion de Gastos');

        if($_POST)
        {

            try{    
                DB::beginTransaction();
                $data_archivo                  =   json_decode($request['data_observacion'], true);
                $descripcion                   =   $request['descripcion'];
                $liquidaciongastos             =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();

                if($liquidaciongastos->IND_OBSERVACION==1){
                    DB::rollback(); 
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }


                if(count($data_archivo)<=0){
                    DB::rollback(); 
                    return Redirect::back()->with('errorbd', 'Tiene que seleccionar almenos un item');
                }
                LqgLiquidacionGasto::where('ID_DOCUMENTO',$iddocumento)
                            ->update(
                                [
                                    'IND_OBSERVACION'=>1,
                                    'TXT_OBSERVACION'=>'OBSERVADO',
                                    'AREA_OBSERVACION'=>'CONT'
                                ]
                            );
                foreach($data_archivo as $key => $obj){
                    $data_id         =   $obj['data_id'];
                    $data_item       =   $obj['data_item'];
                    LqgDetLiquidacionGasto::where('ID_DOCUMENTO',$data_id)->where('ITEM','=',$data_item)
                                ->update(
                                    [
                                        'IND_OBSERVACION'=>1,
                                        'AREA_OBSERVACION'=>'CONT',
                                        'ACTIVO'=>0,
                                    ]
                                );

                    LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO',$data_id)->where('ITEM','=',$data_item)
                                ->update(
                                    [
                                        'ACTIVO'=>0,
                                    ]
                                );


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'OBSERVADO POR CONTABILIDAD';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();
                $this->lg_calcular_total_observar($iddocumento);

                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/'.$idopcion)->with('bienhecho', 'Liquidacion Gastos : '.$liquidaciongastos->CODIGO.' Observado con Exito');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
    }

    public function actionAprobarJefeLG($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        View::share('titulo','Aprobar Liquidacion de Gasto Jefe');

        if($_POST)
        {
            try{    
            
                DB::beginTransaction();

                $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();


                if($liquidaciongastos->IND_OBSERVACION==1){
                    DB::rollback(); 
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }



                $descripcion        =   $request['descripcion'];
                if(rtrim(ltrim($descripcion)) != ''){
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   1;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'ACOTACION POR EL JEFE';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();
                }

                LqgLiquidacionGasto::where('ID_DOCUMENTO',$liquidaciongastos->ID_DOCUMENTO)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000003',
                                    'TXT_ESTADO'=>'POR APROBAR CONTABILIDAD',
                                    'COD_JEFE_APRUEBA'=>Session::get('usuario')->id,
                                    'TXT_JEFE_APRUEBA'=>Session::get('usuario')->nombre,
                                    'FECHA_JEFE_APRUEBA'=>$this->fechaactual
                                ]
                            );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR EL JEFE';
                $documento->MENSAJE                     =   '';
                $documento->save();

                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gasto-jefe/'.$idopcion)->with('bienhecho', 'Liquidacion de Gastos : '.$liquidaciongastos->CODIGO.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gasto-jefe/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
        else{

            $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
            $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();

            $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
            $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();
            $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('EXTENSION', 'like', '%'.'pdf'.'%')->get();

            $tdetliquidaciongastosel=   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','0')->get();


            $ocultar                =   "";
            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]);
            }
            $initialPreviewConfig = [];



            foreach ($archivospdf as $key => $archivo) {
                $valor                = '';
                if($key>0){
                    $valor            = 'ocultar';
                }
                $initialPreviewConfig[] = [
                    'type'          => "pdf",
                    'caption'       => $archivo->NOMBRE_ARCHIVO,
                    'downloadUrl'   => route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]),
                    'frameClass'    => $archivo->ID_DOCUMENTO.$archivo->DOCUMENTO_ITEM.' '.$valor //
                ];
            }

            //dd($tdetliquidaciongastos);
            $productosagru      =   DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
                            ->select('COD_PRODUCTO', 'TXT_PRODUCTO', DB::raw('SUM(CANTIDAD) as CANTIDAD'), DB::raw('SUM(TOTAL) as TOTAL'))
                            ->where('ID_DOCUMENTO', $iddocumento)
                            ->where('ACTIVO', 1)
                            ->groupBy('COD_PRODUCTO', 'TXT_PRODUCTO')
                            ->get();

            return View::make('liquidaciongasto/aprobarjefelg', 
                            [
                                'liquidaciongastos'     =>  $liquidaciongastos,
                                'tdetliquidaciongastos' =>  $tdetliquidaciongastos,
                                'tdetliquidaciongastosel'=>  $tdetliquidaciongastosel,
                                'productosagru' =>  $productosagru,
                                'detdocumentolg'        =>  $detdocumentolg,
                                'documentohistorial'    =>  $documentohistorial,
                                'idopcion'              =>  $idopcion,
                                'idcab'                 =>  $idcab,
                                'iddocumento'           =>  $iddocumento,
                                'initialPreview'        => json_encode($initialPreview),
                                'initialPreviewConfig'  => json_encode($initialPreviewConfig),
                            ]);


        }
    }



    public function actionAprobarLiquidacionGastoJefe($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista liquidacion de gastos (jefe)');
        $tab_id             =   'oc';
        if(isset($request['tab_id'])){
            $tab_id             =   $request['tab_id'];
        }

        $listadatos         =   $this->lg_lista_cabecera_comprobante_total_jefe();
        $listadatos_obs     =   $this->lg_lista_cabecera_comprobante_total_obs_jefe();
        $listadatos_obs_le  =   $this->lg_lista_cabecera_comprobante_total_obs_le_jefe();


        $funcion        =   $this;
        return View::make('liquidaciongasto/listaliquidaciongastojefe',
                         [
                            'listadatos'        =>  $listadatos,
                            'listadatos_obs'    =>  $listadatos_obs,
                            'listadatos_obs_le' =>  $listadatos_obs_le,
                            'tab_id'            =>  $tab_id,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }


    public function actionAprobarLiquidacionGastoContabilidad($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista liquidacion de gastos (contabilidad)');
        $tab_id             =   'oc';
        if(isset($request['tab_id'])){
            $tab_id             =   $request['tab_id'];
        }

        $listadatos         =   $this->lg_lista_cabecera_comprobante_total_contabilidad();
        $listadatos_obs     =   $this->lg_lista_cabecera_comprobante_total_obs_contabilidad();
        $listadatos_obs_le  =   $this->lg_lista_cabecera_comprobante_total_obs_le_contabilidad();
        $funcion            =   $this;
        return View::make('liquidaciongasto/listaliquidaciongastocontabilidad',
                         [
                            'listadatos'        =>  $listadatos,
                            'listadatos_obs'    =>  $listadatos_obs,
                            'listadatos_obs_le' =>  $listadatos_obs_le,
                            'tab_id'            =>  $tab_id,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }



    public function actionEmitirLiquidacionGasto($idopcion,$iddocumento,Request $request)
    {
        $idcab       = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');

        if($_POST)
        {

            try{    
                DB::beginTransaction();
                $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
                //validar que tenga la firma quien
                $detliquidaciongasto    =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $useario_autoriza       =   User::where('id','=',$detliquidaciongasto->COD_USUARIO_AUTORIZA)->first();
                //dd($useario_autoriza);
                $trabajadorap           =   STDTrabajador::where('COD_TRAB','=',$useario_autoriza->usuarioosiris_id)->first();
                $imgaprueba             =   'firmas/blanco.jpg';
                $nombre_aprueba         =   '';
                $rutaImagen             =   public_path('firmas/'.$trabajadorap->NRO_DOCUMENTO.'.jpg');
                //dd($rutaImagen);
                // if (!file_exists($rutaImagen)){
                //     return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/0')->with('errorbd','No se puede emitir ya que el que autoriza no cuenta con firma llamar a sistemas');
                // }
                //CUANDO ESTA OBSEVADOS
                if($liquidaciongastos->IND_OBSERVACION==1){
                    LqgLiquidacionGasto::where('ID_DOCUMENTO',$iddocumento)
                                ->update(
                                    [
                                        'IND_OBSERVACION'=>0
                                    ]
                                );
                    $documento                              =   new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $iddocumento;
                    $documento->DOCUMENTO_ITEM              =   1;
                    $documento->FECHA                       =   date_format(date_create(date('Ymd h:i:s')), 'Ymd h:i:s');
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'SE LEVANTARON LAS OBSERVACIONES';
                    $documento->MENSAJE                     =   '';
                    $documento->save();

                }else{
                    $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();


                    if(count($tdetliquidaciongastos)<=0){
                        return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/0')->with('errorbd','Para poder emitir tiene que cargar sus documentos');
                    }

                    LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)
                                ->update(
                                        [
                                            'TXT_GLOSA'=> $request['glosa'],
                                            'FECHA_EMI'=> $this->fechaactual,
                                            'FECHA_MOD'=> $this->fechaactual,
                                            'USUARIO_MOD'=> Session::get('usuario')->id,
                                            'COD_ESTADO'=> 'ETM0000000000010',
                                            'TXT_ESTADO'=> 'POR APROBAR AUTORIZACION'
                                        ]);

                    $documento                              =   new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $iddocumento;
                    $documento->DOCUMENTO_ITEM              =   1;
                    $documento->FECHA                       =   date_format(date_create(date('Ymd h:i:s')), 'Ymd h:i:s');
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'CREO LIQUIDACION DE GASTO';
                    $documento->MENSAJE                     =   '';
                    $documento->save();
                }





                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/0')->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-de-liquidacion-gastos/'.$idopcion)->with('bienhecho', 'Liquidacion de Gatos '.$liquidaciongastos->CODIGO.' emitido con exito');
        }  
    }


    public function actionGuardarModificarDetalleDocumentoLG($idopcion,$iddocumento,$item,$itemdocumento,Request $request)
    {

        $idcab       = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');

        try{    
            
            DB::beginTransaction();

                $producto_id            =   $request['producto_id'];    
                $importe                =   (float)$request['importe'];   
                $igv_id                 =   $request['igv_id'];   
                $anio                   =   $this->anio;
                $mes                    =   $this->mes;
                $periodo                =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
                $detliquidaciongasto    =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$item)->first(); 
                $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$item)->get();
                $itemdet                =   count($detdocumentolg) + 1;
                $producto               =   DB::table('ALM.PRODUCTO')->where('NOM_PRODUCTO','=',$producto_id)->first();
                $fecha_creacion         =   $this->hoy;
                $cantidad               =   1;
                $subtotal               =   $importe;
                $total                  =   $importe;
                if($igv_id=='1'){
                    $subtotal               =   $importe/1.18;
                }
                $activo                 =   $request['activo'];

                LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$detliquidaciongasto->ID_DOCUMENTO)
                                    ->where('ITEM','=',$item)
                                    ->where('ITEMDOCUMENTO','=',$itemdocumento)
                                    ->update(
                                        [
                                            'COD_PRODUCTO'=> $producto->COD_PRODUCTO,
                                            'TXT_PRODUCTO'=> $producto->NOM_PRODUCTO,
                                            'CANTIDAD'=> $cantidad,
                                            'PRECIO'=> $importe,
                                            'IND_IGV'=> $igv_id,
                                            'SUBTOTAL'=> $subtotal,
                                            'TOTAL'=> $total,
                                            'ACTIVO'=> $activo,
                                            'FECHA_MOD'=> $this->fechaactual,
                                            'USUARIO_MOD'=> Session::get('usuario')->id
                                        ]);

                //CALCULAR TOTALES
                $this->lg_calcular_total($iddocumento,$item);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/'.$item)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }
            return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/'.$item)->with('bienhecho', 'Se Modifico el item con exito');
    }


    public function actionModificarDetalleDocumentoLG(Request $request) {

        $iddocumento        =       $request['data_iddocumento'];
        $data_item          =       $request['data_item'];
        $data_item_documento=       $request['data_item_documento'];
        $idopcion           =       $request['idopcion'];

        $detliquidaciongasto    =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$data_item)->first();
        $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$data_item)->where('ITEMDOCUMENTO','=',$data_item_documento)->first();
        $producto_id        =       $detdocumentolg->TXT_PRODUCTO;
        $comboproducto      =       array($detdocumentolg->TXT_PRODUCTO => $detdocumentolg->TXT_PRODUCTO);
        $igv_id             =       $detdocumentolg->IND_IGV;
        $combo_igv          =       array('' => "¿SELECCIONE SI TIENE IGV?",'1' => "SI",'0' => "NO");

        $funcion            =       $this; 
        $comboestado        =       array('1' => "ACTIVO",'0' => "ELIMINAR");
        $activo             =       $detdocumentolg->ACTIVO;


        return View::make('liquidaciongasto/modal/ajax/magregardetalledocumentolg',
                         [
                            'iddocumento'           =>  $iddocumento,
                            'idopcion'              =>  $idopcion,
                            'detdocumentolg'        =>  $detdocumentolg,
                            'detliquidaciongasto'   =>  $detliquidaciongasto,
                            'funcion'               =>  $funcion,
                            'producto_id'           =>  $producto_id,
                            'comboproducto'         =>  $comboproducto,
                            'igv_id'                =>  $igv_id,
                            'combo_igv'             =>  $combo_igv,
                            'comboestado'           =>  $comboestado,
                            'activo'                =>  $activo,
                            'ajax'                  =>  true,
                         ]);
    }


    public function actionRelacionarDetalleDocumentoLG(Request $request) {

        $data_item          =       $request['data_item'];
        $data_producto      =       $request['data_producto'];
        $idopcion           =       $request['idopcion'];
        $producto_id        =       "";
        $comboproducto      =       array();
        $funcion            =       $this; 

        return View::make('liquidaciongasto/modal/ajax/marelacionardetalledocumentolg',
                         [
                            'comboproducto'          =>  $comboproducto,
                            'idopcion'               =>  $idopcion,
                            'data_item'              =>  $data_item,
                            'data_producto'          =>  $data_producto,
                            'funcion'                =>  $funcion,
                            'producto_id'            =>  $producto_id,
                            'comboproducto'          =>  $comboproducto,
                            'ajax'                   =>  true,
                         ]);
    }



    public function actionGuardarDetalleDocumentoLG($idopcion,$iddocumento,$item,Request $request)
    {

        $idcab       = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');

        try{    
            
            DB::beginTransaction();

                $producto_id            =   $request['producto_id'];    
                $importe                =   (float)$request['importe'];   
                $igv_id                 =   $request['igv_id'];   
                $anio                   =   $this->anio;
                $mes                    =   $this->mes;
                $periodo                =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
                $detliquidaciongasto    =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$item)->first(); 
                $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$item)->get();
                $itemdet                =   count($detdocumentolg) + 1;
                $producto               =   DB::table('ALM.PRODUCTO')->where('NOM_PRODUCTO','=',$producto_id)->first();
                $fecha_creacion         =   $this->hoy;
                $cantidad               =   1;
                $subtotal               =   $importe;

                $total                  =   $importe;
                if($igv_id=='1'){
                    $subtotal               =   $importe/1.18;
                }

  
                $cabecera                           =   new LqgDetDocumentoLiquidacionGasto;
                $cabecera->ID_DOCUMENTO             =   $iddocumento;
                $cabecera->ITEM                     =   $detliquidaciongasto->ITEM;
                $cabecera->ITEMDOCUMENTO            =   $itemdet;
                $cabecera->COD_PRODUCTO             =   $producto->COD_PRODUCTO;
                $cabecera->TXT_PRODUCTO             =   $producto->NOM_PRODUCTO;
                $cabecera->CANTIDAD                 =   $cantidad;
                $cabecera->PRECIO                   =   $importe;
                $cabecera->IND_IGV                  =   $igv_id;
                $cabecera->IGV                      =   $total-$subtotal;   
                $cabecera->SUBTOTAL                 =   $subtotal;
                $cabecera->TOTAL                    =   $total;
                $cabecera->COD_EMPRESA              =   Session::get('empresas')->COD_EMPR;
                $cabecera->TXT_EMPRESA              =   Session::get('empresas')->NOM_EMPR;
                $cabecera->COD_CENTRO               =   $detliquidaciongasto->COD_CENTRO;
                $cabecera->TXT_CENTRO               =   $detliquidaciongasto->TXT_CENTRO;
                $cabecera->FECHA_CREA               =   $this->fechaactual;
                $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                $cabecera->save();

                //CALCULAR TOTALES
                $this->lg_calcular_total($iddocumento,$item);


            DB::commit();
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/'.$item)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }
            return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/'.$item)->with('bienhecho', 'Se Agrego un nuevo item con exito');
    }





    public function actionDetalleDocumentoLG(Request $request) {

        $iddocumento        =       $request['data_iddocumento'];
        $item               =       $request['data_item'];
        $idopcion           =       $request['idopcion'];

        $detliquidaciongasto=       LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$item)->first(); 
        $funcion            =       $this;
        $fecha_fin          =       $this->fecha_sin_hora;
        $producto_id        =       "";
        $comboproducto      =       array();
        $igv_id             =       "";
        $combo_igv          =       array('' => "¿SELECCIONE SI TIENE IGV?",'1' => "SI",'0' => "NO");

        return View::make('liquidaciongasto/modal/ajax/magregardetalledocumentolg',
                         [
                            'iddocumento'           =>  $iddocumento,
                            'item'                  =>  $item,
                            'idopcion'              =>  $idopcion,
                            'detliquidaciongasto'   =>  $detliquidaciongasto,
                            'funcion'               =>  $funcion,
                            'producto_id'           =>  $producto_id,
                            'comboproducto'         =>  $comboproducto,
                            'igv_id'                =>  $igv_id,
                            'combo_igv'             =>  $combo_igv,
                            'ajax'                  =>  true,
                         ]);
    }



    public function actionGuardarDetalleLiquidacionGastos($idopcion,$iddocumento,Request $request)
    {

        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        $liquidaciongastos          =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $tdetliquidaciongastos      =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();

        if($_POST)
        {
            try{    

                DB::beginTransaction();

                    $anio                               =   $this->anio;
                    $mes                                =   $this->mes;
                    $periodo                            =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
                    $cod_planila                        =   $request['cod_planila'];
                    $tipodoc_id                         =   $request['tipodoc_id'];
                    $TOTAL_T                            =   0;

                    $SUCCESS                            =   '';
                    $MESSAGE                            =   '';
                    $ESTADOCP                           =   '';
                    $NESTADOCP                          =   '';
                    $ESTADORUC                          =   '';
                    $NESTADORUC                         =   '';
                    $CONDDOMIRUC                        =   '';
                    $NCONDDOMIRUC                       =   '';
                    $CODIGO_CDR                         =   '';
                    $RESPUESTA_CDR                      =   '';
                    $NOMBREFILE                         =   '';
                    $array_detalle_producto             =   '';

                    if(Session::get('empresas')->COD_EMPR == 'IACHEM0000010394'){
                        $flujo_txt_id                           =   'IICHFC0000000018';
                        $gasto_txt_id                           =   'IICH000000026203';
                        $item_txt_id                            =   'IICHIM0000000106';
                    }else{
                        $flujo_txt_id                           =   'ISCHFC0000000018';
                        $gasto_txt_id                           =   'ISCH000000034709';
                        $item_txt_id                            =   'ISCHIM0000000038';
                    }

                    $empresa_id_b                       =   $request['empresa_id'].$request['EMPRESAID'];
                    $cadena                             =   $empresa_id_b;
                    $partes                             =   explode(" - ", $cadena);
                    $ruc_b                              =   '';
                    if (count($partes) > 1) {
                        $ruc_b                          =   trim($partes[0]);
                    }
                    //VALIDAR QUE DOCUMENTO EMITE EL PROVEEDOR
                    $urlxml                             =   'https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias?accion=consPorRuc&razSoc=null&nroRuc='.$ruc_b.'&nrodoc=null&token=go6mleec9llv1vd4htmikni2ffds38hu9u5ohoez6r5mh53poabe&contexto=ti-it&modo=1&rbtnTipo=1&search1='.$ruc_b.'&tipdoc=1&search2=null&search3=null&codigo=null';
                    $html                           =   $this->buscar_archivo_sunat_td($urlxml);

                    // 2) Instancia y carga el HTML (silenciamos warnings)
                    $dom = new \DOMDocument;
                    @$dom->loadHTML($html, LIBXML_NOWARNING|LIBXML_NOERROR);

                    // 3) Preparamos XPath para buscar los <td> dentro de la tabla tblResultado
                    $xpath = new \DOMXPath($dom);
                    $tds = $xpath->query("//table[contains(@class,'tblResultado')]//tbody//tr/td");

                    // 4) Recorremos los nodos y extraemos el texto
                    $comprobantes = [];
                    foreach ($tds as $td) {
                        $texto = trim($td->textContent);
                        if ($texto !== '') {
                            $comprobantes[] = $texto;
                        }
                    }

                    $tieneFactura = !empty(array_filter($comprobantes, function($item) {
                        return stripos($item, 'FACTURA') !== false;
                    }));

                    //$tieneFactura = in_array('FACTURA', $comprobantes);



                    if (!in_array($tipodoc_id, ['TDO0000000000001', 'TDO0000000000010'])) {
                        if($tieneFactura == 1){
                            return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/-1')->with('errorbd','Este proveedor emite FACTURA');
                        }
                    }


                    //CUANDO ES PLANILLA DE MOVILIDAd
                    if(ltrim(rtrim($cod_planila))!=''){

                        $planillamovilidad              =       DB::table('PLA_MOVILIDAD')
                                                                ->where('ID_DOCUMENTO', $cod_planila)
                                                                ->first();
                        $COD_CUENTA                     =       '';   
                        $TXT_CUENTA                     =       '';

                        $contratos                      =        DB::table('CMP.CONTRATO')
                                                                ->where('COD_EMPR_CLIENTE', 'IACHEM0000009164')
                                                                ->where('COD_EMPR', $planillamovilidad->COD_EMPRESA)
                                                                ->where('COD_CENTRO', $planillamovilidad->COD_CENTRO)
                                                                ->first();

                        if(count($contratos)>0){
                            $cod_contrato = $contratos->COD_CONTRATO; // Ejemplo de contrato
                            $cod_categoria_moneda = $contratos->COD_CATEGORIA_MONEDA; // Ejemplo de moneda
                            $txt_categoria_tipo_contrato = $contratos->TXT_CATEGORIA_TIPO_CONTRATO; // Ejemplo de categoría
                            // Obtener los primeros 6 caracteres
                            $parte1 = substr($cod_contrato, 0, 6);
                            // Obtener los últimos 10 caracteres y convertir a entero
                            $parte2 = intval(substr($cod_contrato, -10));
                            // Determinar el símbolo de la moneda
                            $simbolo = ($cod_categoria_moneda === 'MON0000000000001') ? 'S/' : '$';
                            // Concatenar todo
                            $contrato = $parte1 . '-0' . $parte2 . ' -- ' . $simbolo . ' ' . $txt_categoria_tipo_contrato;
                            $COD_CUENTA                 =       $contratos->COD_CONTRATO;   
                            $TXT_CUENTA                 =       $contrato; 
                            $subcontrato                =       DB::table('CMP.CONTRATO_CULTIVO')
                                                                ->selectRaw("
                                                                    COD_CONTRATO,
                                                                    TXT_ZONA_COMERCIAL+'-'+TXT_ZONA_CULTIVO as TXT_CULTIVO
                                                                ")
                                                                ->where('COD_CONTRATO', $COD_CUENTA)
                                                                ->first();
                            $COD_SUBCUENTA                 =       $subcontrato->COD_CONTRATO;   
                            $TXT_SUBCUENTA                 =       $subcontrato->TXT_CULTIVO;
                            $TOTAL_T                       =      $planillamovilidad->TOTAL;


                        }

                        $tipodoc_id                         =   $request['tipodoc_id'];
                        $serie                              =   $planillamovilidad->SERIE;
                        $numero                             =   $planillamovilidad->NUMERO;
                        $fecha_emision                      =   date_format(date_create($planillamovilidad->FECHA_EMI), 'd-m-Y');
                        $empresa_id                         =   $request['empresa_id'];


                        $flujo_id                           =   $flujo_txt_id;
                        $gasto_id                           =   $gasto_txt_id;
                        $item_id                            =   $item_txt_id;


                        $costo_id                           =   $request['costo_id'];
                        $cuenta_id                          =   $COD_CUENTA;
                        $subcuenta_id                       =   $COD_SUBCUENTA;

                        $glosadet                           =   $request['glosadet'];
                        //$empresa_trab                       =   'PLANILLA DE MOVILIDAD SIN COMPROBANTE';
                        $empresa_trab                       =   STDEmpresa::where('NOM_EMPR','=','PLANILLA DE MOVILIDAD SIN COMPROBANTE')->first();
                    }else{
                        if($tipodoc_id=='TDO0000000000001'){

                            $tipodoc_id                         =   $request['tipodoc_id'];
                            $serie                              =   $request['serie'];
                            $numero                             =   $request['numero'];
                            $fecha_emision                      =   $request['fecha_emision'];
                            $empresa_id                         =   $request['EMPRESAID'];

                            $flujo_id                           =   $flujo_txt_id;
                            $gasto_id                           =   $gasto_txt_id;
                            $item_id                            =   $item_txt_id;


                            $costo_id                           =   $request['costo_id'];
                            $cuenta_id                          =   $request['cuenta_id'];
                            $subcuenta_id                       =   $request['subcuenta_id'];

                            $glosadet                           =   $request['glosadet'];
                            $TOTAL_T                            =   $request['totaldetalle'];



                            $SUCCESS                            =   $request['SUCCESS'];
                            $MESSAGE                            =   $request['MESSAGE'];
                            $ESTADOCP                           =   $request['ESTADOCP'];
                            $NESTADOCP                          =   $request['NESTADOCP'];
                            $ESTADORUC                          =   $request['ESTADORUC'];
                            $NESTADORUC                         =   $request['NESTADORUC'];
                            $CONDDOMIRUC                        =   $request['CONDDOMIRUC'];
                            $NCONDDOMIRUC                       =   $request['NCONDDOMIRUC'];
                            $cod_planila                        =   '';


                            $cadena = $empresa_id;
                            $partes = explode(" - ", $cadena);
                            $nombre = '';
                            if (count($partes) > 1) {
                                $nombre = trim($partes[1]);
                            }
                            $empresa_trab                       =   STDEmpresa::where('NOM_EMPR','=',$nombre)->first();




                        }else{

                            $tipodoc_id                         =   $request['tipodoc_id'];
                            $serie                              =   $request['serie'];
                            $numero                             =   $request['numero'];
                            $fecha_emision                      =   $request['fecha_emision'];
                            $empresa_id                         =   $request['empresa_id'];

                            $flujo_id                           =   $flujo_txt_id;
                            $gasto_id                           =   $gasto_txt_id;
                            $item_id                            =   $item_txt_id;

                            $costo_id                           =   $request['costo_id'];
                            $cuenta_id                          =   $request['cuenta_id'];
                            $subcuenta_id                       =   $request['subcuenta_id'];

                            $glosadet                           =   $request['glosadet'];
                            $cod_planila                        =   '';


                            $cadena = $empresa_id;
                            $partes = explode(" - ", $cadena);
                            $nombre = '';
                            if (count($partes) > 1) {
                                $nombre = trim($partes[1]);
                            }
                            $empresa_trab                       =   STDEmpresa::where('NOM_EMPR','=',$nombre)->first();

                        }
                    }

                    $tdetliquidaciongastos              =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->get();
                    $item                               =   count($tdetliquidaciongastos) + 1;
                    $cuenta                             =   CMPContrato::where('COD_CONTRATO','=',$cuenta_id)->first();
                    $subcuenta                          =   CMPContratoCultivo::where('COD_CONTRATO','=',$subcuenta_id)->first();
                    $tipodocumento                      =   STDTipoDocumento::where('COD_TIPO_DOCUMENTO','=',$tipodoc_id)->first();
                    $flujocaja                          =   DB::table('CON.FLUJO_CAJA')->where('COD_FLUJO_CAJA','=',$flujo_id)->first();
                    $gasto                              =   DB::table('CON.CUENTA_CONTABLE')->where('COD_CUENTA_CONTABLE','=',$gasto_id)->first();
                    $costo                              =   DB::table('CON.CENTRO_COSTO')->where('COD_CENTRO_COSTO','=',$costo_id)->first();
                    $items                              =   DB::table('CON.FLUJO_CAJA_ITEM_MOV')->where('COD_ITEM_MOV','=',$item_id)->first();
                    $nombre_doc_sinceros                =   $serie.'-'.$numero;
                    $numero                             =   str_pad($numero, 10, "0", STR_PAD_LEFT); 
                    $nombre_doc                         =   $serie.'-'.$numero;

                    //dd($empresa_trab);
                    $cabecera                           =   new LqgDetLiquidacionGasto;
                    $cabecera->ID_DOCUMENTO             =   $iddocumento;
                    $cabecera->ITEM                     =   $item;
                    $cabecera->FECHA_EMISION            =   $fecha_emision;
                    $cabecera->SERIE                    =   $serie;
                    $cabecera->NUMERO                   =   $numero;
                    $cabecera->COD_TIPODOCUMENTO        =   $tipodocumento->COD_TIPO_DOCUMENTO;
                    $cabecera->TXT_TIPODOCUMENTO        =   $tipodocumento->TXT_TIPO_DOCUMENTO;
                    $cabecera->COD_FLUJO                =   $flujocaja->COD_FLUJO_CAJA;
                    $cabecera->TXT_FLUJO                =   $flujocaja->TXT_NOMBRE;
                    $cabecera->COD_GASTO                =   $gasto->COD_CUENTA_CONTABLE;
                    $cabecera->TXT_GASTO                =   $gasto->TXT_DESCRIPCION;
                    $cabecera->COD_COSTO                =   $costo->COD_CENTRO_COSTO;
                    $cabecera->TXT_COSTO                =   $costo->TXT_NOMBRE;
                    $cabecera->COD_ITEM                 =   $items->COD_ITEM_MOV;
                    $cabecera->TXT_ITEM                 =   $items->TXT_ITEM_MOV;
                    $cabecera->COD_EMPRESA_PROVEEDOR    =   $empresa_trab->COD_EMPR;
                    $cabecera->TXT_EMPRESA_PROVEEDOR    =   $empresa_trab->NOM_EMPR;
                    $cabecera->COD_CUENTA               =   $cuenta->COD_CONTRATO;
                    $cabecera->TXT_CUENTA               =   $cuenta->TXT_EMPR_CLIENTE;
                    $cabecera->COD_SUBCUENTA            =   $subcuenta->COD_CONTRATO;
                    $cabecera->TXT_SUBCUENTA            =   $subcuenta->TXT_ZONA_COMERCIAL.'-'.$subcuenta->TXT_ZONA_CULTIVO;
                    $cabecera->COD_EMPRESA              =   Session::get('empresas')->COD_EMPR;
                    $cabecera->TXT_EMPRESA              =   Session::get('empresas')->NOM_EMPR;
                    $cabecera->COD_CENTRO               =   $liquidaciongastos->COD_CENTRO;
                    $cabecera->TXT_CENTRO               =   $liquidaciongastos->NOM_CENTRO;

                    $cabecera->SUCCESS                  =   $SUCCESS;
                    $cabecera->MESSAGE                  =   $MESSAGE;
                    $cabecera->ESTADOCP                 =   $ESTADOCP;
                    $cabecera->NESTADOCP                =   $NESTADOCP;
                    $cabecera->ESTADORUC                =   $ESTADORUC;
                    $cabecera->NESTADORUC               =   $NESTADORUC;
                    $cabecera->CONDDOMIRUC              =   $CONDDOMIRUC;
                    $cabecera->NCONDDOMIRUC             =   $NCONDDOMIRUC;
                    $cabecera->CODIGO_CDR               =   $CODIGO_CDR;
                    $cabecera->RESPUESTA_CDR            =   $RESPUESTA_CDR;


                    $cabecera->COD_PLA_MOVILIDAD        =   $cod_planila;
                    $cabecera->TXT_GLOSA                =   $glosadet;

                    $cabecera->IND_OBSERVACION          =   0;
                    $cabecera->AREA_OBSERVACION         =   '';


                    $cabecera->IGV                      =   0;
                    $cabecera->SUBTOTAL                 =   $TOTAL_T;
                    $cabecera->TOTAL                    =   $TOTAL_T;
                    $cabecera->FECHA_CREA               =   $this->fechaactual;
                    $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                    $cabecera->save();


                    //DETALLE SI ES QUE ES FACTURA
                    if($tipodoc_id=='TDO0000000000001'){
                        $array_detalle_producto_request     =   json_decode($request['array_detalle_producto'],true);
                        foreach ($array_detalle_producto_request as $key => $itemd) {
                            $producto                               =   DB::table('ALM.PRODUCTO')->where('NOM_PRODUCTO','=',$itemd['TXT_PRODUCTO_OSIRIS'])->first();
                            $IND_IGV = 0;
                            if($itemd['INDIGV']=='SI'){
                                $IND_IGV = 1;
                            }
                            $cabeceradet                           =   new LqgDetDocumentoLiquidacionGasto;
                            $cabeceradet->ID_DOCUMENTO             =   $iddocumento;
                            $cabeceradet->ITEM                     =   $item;
                            $cabeceradet->ITEMDOCUMENTO            =   $key+1;
                            $cabeceradet->COD_PRODUCTO             =   $producto->COD_PRODUCTO;
                            $cabeceradet->TXT_PRODUCTO             =   $producto->NOM_PRODUCTO;
                            $cabeceradet->TXT_PRODUCTO_XML         =   $itemd['TXT_PRODUCTO_XML'];
                            $cabeceradet->CANTIDAD                 =   $itemd['CANTIDAD'];
                            $cabeceradet->PRECIO                   =   $itemd['PRECIO'];
                            $cabeceradet->IND_IGV                  =   $IND_IGV;
                            $cabeceradet->IGV                      =   $itemd['IGV'];   
                            $cabeceradet->SUBTOTAL                 =   $itemd['SUBTOTAL'];
                            $cabeceradet->TOTAL                    =   $itemd['TOTAL'];
                            $cabeceradet->COD_EMPRESA              =   Session::get('empresas')->COD_EMPR;
                            $cabeceradet->TXT_EMPRESA              =   Session::get('empresas')->NOM_EMPR;
                            $cabeceradet->COD_CENTRO               =   $liquidaciongastos->COD_CENTRO;
                            $cabeceradet->TXT_CENTRO               =   $liquidaciongastos->TXT_CENTRO;
                            $cabeceradet->FECHA_CREA               =   $this->fechaactual;
                            $cabeceradet->USUARIO_CREA             =   Session::get('usuario')->id;
                            $cabeceradet->save();

                        }

                    }


                    if($tipodoc_id=='TDO0000000000001'){

                        $NOMBREFILE                     =   $request['NOMBREFILE'];
                        $RUTACOMPLETA                   =   $request['RUTACOMPLETA'];
                        //GUARDAR EL XML
                        $dcontrol                       =   new Archivo;
                        $dcontrol->ID_DOCUMENTO         =   $iddocumento;
                        $dcontrol->DOCUMENTO_ITEM       =   $item;
                        $dcontrol->TIPO_ARCHIVO         =   'DCC0000000000003';
                        $dcontrol->NOMBRE_ARCHIVO       =   $NOMBREFILE;
                        $dcontrol->DESCRIPCION_ARCHIVO  =   'XML DEL COMPROBANTE DE COMPRA';
                        $dcontrol->URL_ARCHIVO          =   $RUTACOMPLETA;
                        $dcontrol->SIZE                 =   13180;
                        $dcontrol->EXTENSION            =   'xml';
                        $dcontrol->ACTIVO               =   1;
                        $dcontrol->FECHA_CREA           =   $this->fechaactual;
                        $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                        $dcontrol->save();
                        //GUARDAR ARCHIVOS FACTURA
                        $filescdr           =   $request['DCC0000000000004'];
                        $seriepl            =   substr($serie, 0, 1);

                        $RUTAXML            =   $request['RUTAXML'];
                        $RUTAPDF            =   $request['RUTAPDF'];
                        $RUTACDR            =   $request['RUTACDR'];
                        $NOMBREXML          =   $request['NOMBREXML'];
                        $NOMBREPDF          =   $request['NOMBREPDF'];
                        $NOMBRECDR          =   $request['NOMBRECDR'];

                        $extractedFile = '';

                        if($RUTAXML==''){
                            if($seriepl=='E'){
                                $tarchivos                      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                                    ->whereIn('COD_CATEGORIA', ['DCC0000000000036'])->get();
                            }else{
                                $tarchivos                      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                                    ->whereIn('COD_CATEGORIA', ['DCC0000000000036','DCC0000000000004'])->get();
                            }
                        }else{

                            if($seriepl=='E'){
                                $array_categorias = array();
                                if($RUTAPDF==''){
                                    $array_categorias[] = 'DCC0000000000036';
                                }else{
                                    $dcontrol                       =   new Archivo;
                                    $dcontrol->ID_DOCUMENTO         =   $iddocumento;
                                    $dcontrol->DOCUMENTO_ITEM       =   $item;
                                    $dcontrol->TIPO_ARCHIVO         =   'DCC0000000000036';
                                    $dcontrol->NOMBRE_ARCHIVO       =   $NOMBREPDF;
                                    $dcontrol->DESCRIPCION_ARCHIVO  =   'COMPROBANTE ELECTRONICO';
                                    $dcontrol->URL_ARCHIVO          =   $RUTAPDF;
                                    $dcontrol->SIZE                 =   100;
                                    $dcontrol->EXTENSION            =   'pdf';
                                    $dcontrol->ACTIVO               =   1;
                                    $dcontrol->FECHA_CREA           =   $this->fechaactual;
                                    $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                                    $dcontrol->save();
                                }
                                $tarchivos                      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                                    ->whereIn('COD_CATEGORIA', $array_categorias)->get();
                            }else{
                                $array_categorias = array();
                                if($RUTAPDF==''){
                                    $array_categorias[] = 'DCC0000000000036';
                                }else{
                                    $dcontrol                       =   new Archivo;
                                    $dcontrol->ID_DOCUMENTO         =   $iddocumento;
                                    $dcontrol->DOCUMENTO_ITEM       =   $item;
                                    $dcontrol->TIPO_ARCHIVO         =   'DCC0000000000036';
                                    $dcontrol->NOMBRE_ARCHIVO       =   $NOMBREPDF;
                                    $dcontrol->DESCRIPCION_ARCHIVO  =   'COMPROBANTE ELECTRONICO';
                                    $dcontrol->URL_ARCHIVO          =   $RUTAPDF;
                                    $dcontrol->SIZE                 =   100;
                                    $dcontrol->EXTENSION            =   'pdf';
                                    $dcontrol->ACTIVO               =   1;
                                    $dcontrol->FECHA_CREA           =   $this->fechaactual;
                                    $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                                    $dcontrol->save();
                                }
                                if($RUTACDR==''){
                                    $array_categorias[] = 'DCC0000000000004';
                                }else{

                                 $dcontrol                       =   new Archivo;
                                    $dcontrol->ID_DOCUMENTO         =   $iddocumento;
                                    $dcontrol->DOCUMENTO_ITEM       =   $item;
                                    $dcontrol->TIPO_ARCHIVO         =   'DCC0000000000004';
                                    $dcontrol->NOMBRE_ARCHIVO       =   $NOMBRECDR;
                                    $dcontrol->DESCRIPCION_ARCHIVO  =   'CDR';
                                    $dcontrol->URL_ARCHIVO          =   $RUTACDR;
                                    $dcontrol->SIZE                 =   100;
                                    $dcontrol->EXTENSION            =   'xml';
                                    $dcontrol->ACTIVO               =   1;
                                    $dcontrol->FECHA_CREA           =   $this->fechaactual;
                                    $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                                    $dcontrol->save();
                                    $extractedFile = $RUTACDR;

                                }
                                $tarchivos                      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                                    ->whereIn('COD_CATEGORIA', $array_categorias)->get();
                            }
                        }



                        $sw = 0;
                        foreach($tarchivos as $index => $itema){
                            $filescdm          =   $request[$itema->COD_CATEGORIA];
                            if(!is_null($filescdm)){
                                //CDR
                                foreach($filescdm as $file){
                                    //
                                    $contadorArchivos = Archivo::count();

                                    /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                    $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                                    $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$iddocumento;
                                    $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                                    $valor           =      $this->versicarpetanoexiste($rutafile);
                                    $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                                    copy($file->getRealPath(),$rutacompleta);
                                    $path            =      $rutacompleta;
                                    $nombreoriginal             =   $file->getClientOriginalName();
                                    $info                       =   new SplFileInfo($nombreoriginal);
                                    $extension                  =   $info->getExtension();
                                    $dcontrol                       =   new Archivo;
                                    $dcontrol->ID_DOCUMENTO         =   $iddocumento;
                                    $dcontrol->DOCUMENTO_ITEM       =   $item;

                                    $dcontrol->TIPO_ARCHIVO         =   $itema->COD_CATEGORIA;
                                    $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                                    $dcontrol->DESCRIPCION_ARCHIVO  =   $itema->NOM_CATEGORIA;
                                    $dcontrol->URL_ARCHIVO          =   $path;
                                    $dcontrol->SIZE                 =   filesize($file);
                                    $dcontrol->EXTENSION            =   $extension;
                                    $dcontrol->ACTIVO               =   1;
                                    $dcontrol->FECHA_CREA           =   $this->fechaactual;
                                    $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                                    $dcontrol->save();

                                    if($itema->COD_CATEGORIA=='DCC0000000000004'){
                                        $extractedFile = $rutacompleta;
                                    }

                                }
                            }
                        }


                        //CDR LECTURA
                        $respuestacdr = '';
                        $codigocdr = '';
                        $factura_cdr_id='';

                        $numerototal     = $numero;
                        $numerototalsc    = ltrim($numerototal, '0');
                        $nombre_doc_sinceros = $serie.'-'.$numerototalsc;


                        //dd($nombre_doc_sinceros);

                        if (file_exists($extractedFile)) {
                            //cbc
                            $xml = simplexml_load_file($extractedFile);
                            $cbc = 0;
                            $namespaces = $xml->getNamespaces(true);
                            foreach ($namespaces as $prefix => $namespace) {
                                if('cbc'==$prefix){
                                    $cbc = 1;  
                                }
                            }


                            if($cbc>=1){


                                foreach($xml->xpath('//cbc:ResponseCode') as $ResponseCode)
                                {
                                    $codigocdr  = $ResponseCode;
                                }
                                foreach($xml->xpath('//cbc:Description') as $Description)
                                {
                                    $respuestacdr  = $Description;
                                }

                                foreach($xml->xpath('//cbc:ID') as $ID)
                                {
                                    $factura_cdr_id  = $ID;
                                    $factura_cdr_id = preg_replace('/-0+/', '-', $factura_cdr_id);
                                    if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                        $sw = 1;
                                    }
                                }  
                                    
                            }else{
                                $xml_ns = simplexml_load_file($extractedFile);
                                // Namespace definitions
                                $ns4 = "urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2";
                                $ns3 = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
                                // Register namespaces
                                $xml_ns->registerXPathNamespace('ns4', $ns4);
                                $xml_ns->registerXPathNamespace('ns3', $ns3);
                                // Querying XML
                                foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $ResponseCodes)
                                {
                                    $codigocdr  = $ResponseCodes->ResponseCode;
                                }
                                foreach($xml_ns->xpath('//ns3:DocumentResponse/ns3:Response') as $Description)
                                {
                                    $respuestacdr  = $Description->Description;
                                }
                                foreach($xml_ns->xpath('//ns3:DocumentReference') as $ID)
                                {
                                    $factura_cdr_id  = $ID->ID;
                                    $factura_cdr_id = preg_replace('/-0+/', '-', $factura_cdr_id);
                                    if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                        $sw = 1;
                                    }
                                }

                            }
                        } else {
                            $respuestacdr  = 'Error al intentar descomprimir el CDR';
                        }
                        if($seriepl=='F'){
                            if($sw == 0){
                                $respuestacdr  = 'El CDR ('.$factura_cdr_id.') no coincide con la factura ('.$nombre_doc.')';
                                return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/-1')->with('errorbd',$respuestacdr);
                            }    
                        }else{
                            $respuestacdr  = '';
                        }

                        // if (strpos($respuestacdr, 'observaciones') !== false) {
                        //     $respuestacdr  = 'El CDR ('.$factura_cdr_id.') tiene observaciones';
                        //     return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/-1')->with('errorbd',$respuestacdr);
                        // }
                        LqgDetLiquidacionGasto::where('ID_DOCUMENTO',$iddocumento)->where('ITEM',$item)
                                    ->update(
                                        [
                                            'CODIGO_CDR'=>$codigocdr,
                                            'RESPUESTA_CDR'=>$respuestacdr
                                        ]
                                    );

                    }else{
                        if($tipodoc_id=='TDO0000000000070'){

                            $rutacompleta                   =   $request['rutacompleta'];
                            $nombrearchivo                  =   $request['nombrearchivo'];
                            $nombrefilecdr                  =   $nombrearchivo;
                            $dcontrol                       =   new Archivo;
                            $dcontrol->ID_DOCUMENTO         =   $iddocumento;
                            $dcontrol->DOCUMENTO_ITEM       =   $item;
                            $dcontrol->TIPO_ARCHIVO         =   'DCC0000000000036';
                            $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO  =   'COMPROBANTE ELECTRONICO';
                            $dcontrol->URL_ARCHIVO          =   $rutacompleta;
                            $dcontrol->SIZE                 =   100;
                            $dcontrol->EXTENSION            =   'pdf';
                            $dcontrol->ACTIVO               =   1;
                            $dcontrol->FECHA_CREA           =   $this->fechaactual;
                            $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                            $dcontrol->save();

                        }else{

                            $tarchivos                      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                                ->whereIn('COD_CATEGORIA', ['DCC0000000000036'])->get();
                            foreach($tarchivos as $index => $itema){
                                $filescdm          =   $request[$itema->COD_CATEGORIA];
                                if(!is_null($filescdm)){
                                    //CDR
                                    foreach($filescdm as $file){
                                        //
                                        $contadorArchivos = Archivo::count();

                                        /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                        $prefijocarperta =      $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                                        $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$iddocumento;
                                        $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                                        $valor           =      $this->versicarpetanoexiste($rutafile);
                                        $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                                        copy($file->getRealPath(),$rutacompleta);
                                        $path            =      $rutacompleta;
                                        $nombreoriginal             =   $file->getClientOriginalName();
                                        $info                       =   new SplFileInfo($nombreoriginal);
                                        $extension                  =   $info->getExtension();
                                        $dcontrol                       =   new Archivo;
                                        $dcontrol->ID_DOCUMENTO         =   $iddocumento;
                                        $dcontrol->DOCUMENTO_ITEM       =   $item;

                                        $dcontrol->TIPO_ARCHIVO         =   $itema->COD_CATEGORIA;
                                        $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                                        $dcontrol->DESCRIPCION_ARCHIVO  =   $itema->NOM_CATEGORIA;
                                        $dcontrol->URL_ARCHIVO          =   $path;
                                        $dcontrol->SIZE                 =   filesize($file);
                                        $dcontrol->EXTENSION            =   $extension;
                                        $dcontrol->ACTIVO               =   1;
                                        $dcontrol->FECHA_CREA           =   $this->fechaactual;
                                        $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                                        $dcontrol->save();
                                    }
                                }
                            }
                        }
                    }


                    //GUARDAR EL DETALLE SI VIENE DE UNA PLANILLA DE MOVILIDAD
                    if(ltrim(rtrim($cod_planila))!=''){
                        $planillamovilidad              =   DB::table('PLA_MOVILIDAD')
                                                            ->where('ID_DOCUMENTO', $cod_planila)
                                                            ->first();
                        $producto_id            =   'PRD0000000003866';    
                        $importe                =   $planillamovilidad->TOTAL; 
                        $producto               =   DB::table('ALM.PRODUCTO')->where('COD_PRODUCTO','=',$producto_id)->first();
                        $cantidad               =   1;
                        $igv_id                 =   0;   
                        $subtotal               =   $importe;
          
                        $cabeceradet                           =   new LqgDetDocumentoLiquidacionGasto;
                        $cabeceradet->ID_DOCUMENTO             =   $iddocumento;
                        $cabeceradet->ITEM                     =   $item;
                        $cabeceradet->ITEMDOCUMENTO            =   1;
                        $cabeceradet->COD_PRODUCTO             =   $producto->COD_PRODUCTO;
                        $cabeceradet->TXT_PRODUCTO             =   $producto->NOM_PRODUCTO;
                        $cabeceradet->CANTIDAD                 =   $cantidad;
                        $cabeceradet->PRECIO                   =   $importe;
                        $cabeceradet->IND_IGV                  =   0;
                        $cabeceradet->IGV                      =   0;   
                        $cabeceradet->SUBTOTAL                 =   $subtotal;
                        $cabeceradet->TOTAL                    =   $importe;
                        $cabeceradet->COD_EMPRESA              =   Session::get('empresas')->COD_EMPR;
                        $cabeceradet->TXT_EMPRESA              =   Session::get('empresas')->NOM_EMPR;
                        $cabeceradet->COD_CENTRO               =   $planillamovilidad->COD_CENTRO;
                        $cabeceradet->TXT_CENTRO               =   $planillamovilidad->TXT_CENTRO;
                        $cabeceradet->FECHA_CREA               =   $this->fechaactual;
                        $cabeceradet->USUARIO_CREA             =   Session::get('usuario')->id;
                        $cabeceradet->save();
                    }
                    $itemsel = $item;
                    if($tipodoc_id=='TDO0000000000001' || $tipodoc_id=='TDO0000000000070'){
                        $itemsel = '0';
                    }


                    $this->lg_calcular_total($iddocumento,$item);
                DB::commit();
            }catch(\Exception $ex){
                DB::rollback();
                return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/0')->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/'.$itemsel)->with('bienhecho', 'Documento '.$serie.'-'.$numero.' registrado con exito');
        }

    }


    public function actionExtornarLiquidacionGastos($idopcion,$iddocumento,Request $request)
    {


        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        View::share('titulo','Agregar Detalle Liquidacion de Gastos');
        $liquidaciongastos          =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $tdetliquidaciongastos      =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=',1)->get();
        $tdetliquidaciongastosobs   =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=',0)->get();

        if($liquidaciongastos->COD_ESTADO!='ETM0000000000001'){
            return Redirect::to('gestion-de-liquidacion-gastos/'.$idopcion)->with('errorbd', 'Ya no puede extornar esta LIQUIDACION DE GASTOS');
        }
        $liquidaciongastos->ACTIVO = 0;
        $liquidaciongastos->save();
        return Redirect::to('gestion-de-liquidacion-gastos/'.$idopcion)->with('bienhecho', 'Se extorno la LIQUIDACION DE GASTOS');



    }



    public function actionModificarLiquidacionGastos($idopcion,$iddocumento,$valor,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        View::share('titulo','Agregar Detalle Liquidacion de Gastos');
        $liquidaciongastos          =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $tdetliquidaciongastos      =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=',1)->orderby('FECHA_CREA','desc')->get();
        $tdetliquidaciongastosobs   =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=',0)->get();


        if($liquidaciongastos->COD_ESTADO!='ETM0000000000001' && $liquidaciongastos->IND_OBSERVACION ==0){
            return Redirect::to('gestion-de-liquidacion-gastos/'.$idopcion)->with('errorbd', 'Ya no puede modificar esta LIQUIDACION DE GASTOS');
        }
        $fecha_emision                  =   $this->hoy_sh;
        $ajax                           =   false;
        $valor_nuevo                    =   '';
        if($valor=='-1'){
            $valor_nuevo                =   $valor;
            $valor                      =   '0'; 
        }
        $trabajador                     =   DB::table('STD.TRABAJADOR')
                                            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                            ->first();
        $dni                            =   '';
        if(count($trabajador)>0){
            $dni                        =   $trabajador->NRO_DOCUMENTO;
        }
        $trabajadorespla                =   DB::table('WEB.platrabajadores')
                                            ->where('situacion_id', 'PRMAECEN000000000002')
                                            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                            ->where('dni', $dni)
                                            ->first();

        if(count($trabajadorespla)<=0){
            return Redirect::to('gestion-de-liquidacion-gastos/'.$idopcion)->with('errorbd', 'No existe registro en planilla');
        }


        //dd($liquidaciongastos);

        if($valor=='0'){

            $active                     =   "documentos";
            $tipodoc_id                 =   '';
            $combo_tipodoc              =   $this->lg_combo_tipodocumento("Seleccione Tipo Documento");
            $empresa_id                 =   "";
            $combo_empresa              =   array();
            $cuenta_id                  =   "";
            $combo_cuenta               =   array();
            $subcuenta_id               =   "";
            $combo_subcuenta            =   array();
            $flujo_id                   =   "";
            $combo_flujo                =   $this->lg_combo_flujo("Seleccione Flujo");
            $item_id                    =   "";
            $combo_item                 =   array();
            $gasto_id                   =   "";
            $combo_gasto                =   $this->lg_combo_gasto("Seleccione Gasto");
 
            $centrocosto                =   DB::table('CON.CENTRO_COSTO')
                                            ->where('COD_ESTADO', 1)
                                            ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                                            ->where('TXT_REFERENCIA_PLANILLA' ,'LIKE', '%'.$trabajadorespla->cadarea.'%')
                                            //->where('TXT_REFERENCIA_PLANILLA', $trabajadorespla->cadarea)
                                            ->where('IND_MOVIMIENTO', 1)->first();

            //dd($centrocosto);

            $costo_id                   =   "";
            if(count($centrocosto)>0){
                $costo_id                   =   $centrocosto->COD_CENTRO_COSTO;
            }
            $combo_costo                =   $this->lg_combo_costo_xtrabajador("Seleccione Costo",$trabajadorespla->cadarea);
            $tdetliquidacionitem        =   array();
            $tdetdocliquidacionitem     =   array();
            $archivos                   =   array();

            if($valor_nuevo=='-1'){
                $active                     =   "registro";   
            }


        }else{


            $active                     =   "registro";
            $tdetliquidacionitem        =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$valor)->first();
            $tdetdocliquidacionitem     =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->where('ITEM','=',$valor)->get();

            $tipodoc_id                 =   $tdetliquidacionitem->COD_TIPODOCUMENTO;


            $combo_tipodoc              =   $this->lg_combo_tipodocumento("Seleccione Tipo Documento");
            $empresa_id                 =   $tdetliquidacionitem->TXT_EMPRESA_PROVEEDOR;
            $combo_empresa              =   array($tdetliquidacionitem->TXT_EMPRESA_PROVEEDOR => $tdetliquidacionitem->TXT_EMPRESA_PROVEEDOR);
            $cuenta_id                  =   $tdetliquidacionitem->COD_CUENTA;
            $combo_cuenta               =   $this->lg_combo_cuenta_lg('Seleccione una Cuenta','','',$tdetliquidacionitem->COD_CENTRO,$tdetliquidacionitem->TXT_EMPRESA_PROVEEDOR);

            $subcuenta_id               =   $tdetliquidacionitem->COD_SUBCUENTA;
            $combo_subcuenta            =   $this->lg_combo_subcuenta("Seleccione SubCuenta",$tdetliquidacionitem->COD_CUENTA);
            $flujo_id                   =   $tdetliquidacionitem->COD_FLUJO;
            $combo_flujo                =   $this->lg_combo_flujo("Seleccione Flujo");
            $item_id                    =   $tdetliquidacionitem->COD_ITEM;
            $combo_item                 =   $this->lg_combo_item("Seleccione Item",$tdetliquidacionitem->COD_FLUJO);
            $gasto_id                   =   $tdetliquidacionitem->COD_GASTO;
            $combo_gasto                =   $this->lg_combo_gasto("Seleccione Gasto");

            //dd("hola");
            $costo_id                   =   $tdetliquidacionitem->COD_COSTO;
            $combo_costo                =   $this->lg_combo_costo_xtrabajador("Seleccione Costo",$trabajadorespla->cadarea);
            $ajax                       =   true;
            $archivos                   =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$valor)->get();

        }

        $tarchivos                      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                            ->whereIn('COD_CATEGORIA', ['DCC0000000000036','DCC0000000000004'])->get();


        $autoriza_id                    =   $liquidaciongastos->COD_USUARIO_AUTORIZA;
        $combo_autoriza                 =   $this->gn_combo_usuarios();
        $array_detalle_producto         =   array();
        $documentohistorial             =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();

        //dd($tdetliquidaciongastos);
        return View::make('liquidaciongasto.modificarliquidaciongastos',
                         [
                            'liquidaciongastos'     => $liquidaciongastos,
                            'tdetliquidaciongastos' => $tdetliquidaciongastos,

                            'tdetliquidaciongastosobs' => $tdetliquidaciongastosobs,
                            'tdetliquidacionitem'   => $tdetliquidacionitem,
                            'tdetdocliquidacionitem'=> $tdetdocliquidacionitem,
                            'documentohistorial'=> $documentohistorial,
                            'tarchivos'             => $tarchivos,
                            'fecha_emision'         => $fecha_emision,
                            'active'                => $active,
                            'empresa_id'            => $empresa_id,
                            'combo_empresa'         => $combo_empresa,
                            'cuenta_id'             => $cuenta_id,
                            'combo_cuenta'          => $combo_cuenta,
                            'subcuenta_id'          => $subcuenta_id,
                            'combo_subcuenta'       => $combo_subcuenta,
                            'array_detalle_producto'=> $array_detalle_producto,
                            'archivos'              => $archivos,
                            'autoriza_id'           => $autoriza_id,
                            'combo_autoriza'        => $combo_autoriza,


                            'flujo_id'              => $flujo_id,
                            'combo_flujo'           => $combo_flujo,
                            'item_id'               => $item_id,
                            'combo_item'            => $combo_item,

                            'gasto_id'              => $gasto_id,
                            'combo_gasto'           => $combo_gasto,
                            'costo_id'              => $costo_id,
                            'combo_costo'           => $combo_costo,

                            'tipodoc_id'            => $tipodoc_id,
                            'combo_tipodoc'         => $combo_tipodoc,

                            'idopcion'              => $idopcion,


                         ]);



    }



    public function actionAgregarLiquidacionGastos($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();

                    $anio                               =   $this->anio;
                    $mes                                =   $this->mes;
                    $periodo                            =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
                    $empresa_id                         =   $request['empresa_id'];
                    $arendir_id                         =   $request['arendir_id'];
                    $glosa                              =   $request['glosa'];
                    $cuenta_id                          =   $request['cuenta_id'];
                    $subcuenta_id                       =   $request['subcuenta_id'];
                    $centro_txt                         =   $request['centro_txt'];
                    $arendir_sel_id                     =   $request['arendir_sel_id'];
                    $moneda_sel_id                      =   $request['moneda_sel_c_id'];


                    if($arendir_id=='NO'){
                        $arendir_sel_id = '';
                    }else{
                        $vale = DB::table('WEB.VALE_RENDIR')->where('ID', $arendir_sel_id)->first();
                        $fechavale = $vale->FEC_AUTORIZACION;
                        list($aniovale, $mesvale, $diavale) = explode('-', $fechavale);
                        $aniosistemas  = date("Y");    
                        $messistemas   = date("m");    

                        if($aniovale!=$aniosistemas && $mesvale!=$messistemas){
                            return Redirect::to('agregar-liquidacion-gastos/'.$idopcion)->with('errorbd', 'La fecha del arendir no corresponde esta dentro del periodo de la Liquidacion de Gasto');
                        }

                    }

                    $codigo                             =   $this->funciones->generar_codigo('LQG_LIQUIDACION_GASTO',8);
                    $idcab                              =   $this->funciones->getCreateIdMaestradocpla('LQG_LIQUIDACION_GASTO','LIQG');
                    $empresa_trab                       =   STDEmpresa::where('COD_EMPR','=',$empresa_id)->first();
                    $cuenta                             =   CMPContrato::where('COD_CONTRATO','=',$cuenta_id)->first();
                    $subcuenta                          =   CMPContratoCultivo::where('COD_CONTRATO','=',$subcuenta_id)->first();
                    $centro                             =   ALMCentro::where('NOM_CENTRO','=',$centro_txt)->first();
                    $moneda                             =   CMPCategoria::where('COD_CATEGORIA','=',$moneda_sel_id)->first();

                    $cod_contrato = $cuenta->COD_CONTRATO; // Ejemplo de contrato
                    $cod_categoria_moneda = $cuenta->COD_CATEGORIA_MONEDA; // Ejemplo de moneda
                    $txt_categoria_tipo_contrato = $cuenta->TXT_CATEGORIA_TIPO_CONTRATO; // Ejemplo de categoría
                    // Obtener los primeros 6 caracteres
                    $parte1 = substr($cod_contrato, 0, 6);
                    // Obtener los últimos 10 caracteres y convertir a entero
                    $parte2 = intval(substr($cod_contrato, -10));
                    // Determinar el símbolo de la moneda
                    $simbolo = ($cod_categoria_moneda === 'MON0000000000001') ? 'S/' : '$';
                    // Concatenar todo
                    $contrato = $parte1 . '-0' . $parte2 . ' -- ' . $simbolo . ' ' . $txt_categoria_tipo_contrato;
                    $usuario_id             =   $request['autoriza_id'];
                    $usuario                =   User::where('id','=',$usuario_id)->first();


                    $trabajador             =   DB::table('STD.TRABAJADOR')
                                                ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                                ->first();
                    $dni                    =   '';
                    $centro_id              =   '';
                    if(count($trabajador)>0){
                        $dni            =       $trabajador->NRO_DOCUMENTO;
                    }
                    $trabajadorespla            =   DB::table('WEB.platrabajadores')
                                                    ->where('situacion_id', 'PRMAECEN000000000002')
                                                    ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                                    ->where('dni', $dni)
                                                    ->first();
                    $centrocosto                =   DB::table('CON.CENTRO_COSTO')
                                                    ->where('COD_ESTADO', 1)
                                                    ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                                                    //->where('TXT_REFERENCIA_PLANILLA', $trabajadorespla->cadarea)
                                                    ->where('TXT_REFERENCIA_PLANILLA' ,'LIKE', '%'.$trabajadorespla->cadarea.'%')
                                                    ->where('IND_MOVIMIENTO', 1)->first();
                    $area_id                    =   "";
                    $area_txt                   =   "";

                    //hola
                    if(count($centrocosto)>0){
                        $area_id                    =   $centrocosto->COD_CENTRO_COSTO;
                        $area_txt                   =   $centrocosto->TXT_NOMBRE;
                    }

                    //dd($moneda);
                    $cabecera                           =   new LqgLiquidacionGasto;
                    $cabecera->ID_DOCUMENTO             =   $idcab;
                    $cabecera->CODIGO                   =   $codigo;
                    $cabecera->COD_EMPRESA_TRABAJADOR   =   $empresa_trab->COD_EMPR;
                    $cabecera->TXT_EMPRESA_TRABAJADOR   =   $empresa_trab->NOM_EMPR;
                    $cabecera->COD_CUENTA               =   $cuenta->COD_CONTRATO;
                    $cabecera->TXT_CUENTA               =   $contrato;
                    $cabecera->COD_SUBCUENTA            =   $subcuenta->COD_CONTRATO;
                    $cabecera->TXT_SUBCUENTA            =   $subcuenta->TXT_ZONA_COMERCIAL.'-'.$subcuenta->TXT_ZONA_CULTIVO;
                    $cabecera->ARENDIR                  =   $arendir_id;
                    $cabecera->TXT_GLOSA                =   $glosa;
                    $cabecera->COD_EMPRESA              =   Session::get('empresas')->COD_EMPR;
                    $cabecera->TXT_EMPRESA              =   Session::get('empresas')->NOM_EMPR;
                    $cabecera->COD_PERIODO              =   $periodo->COD_PERIODO;
                    $cabecera->TXT_PERIODO              =   $periodo->TXT_NOMBRE;
                    $cabecera->COD_ESTADO               =   'ETM0000000000001';
                    $cabecera->TXT_ESTADO               =   'GENERADO';
                    $cabecera->ARENDIR_ID               =   $arendir_sel_id;

                    $cabecera->COD_CATEGORIA_MONEDA     =   $moneda->COD_CATEGORIA;
                    $cabecera->TXT_CATEGORIA_MONEDA     =   $moneda->NOM_CATEGORIA;
                    $cabecera->COD_AREA                 =   $area_id;
                    $cabecera->TXT_AREA                 =   $area_txt;

                    $cabecera->COD_CENTRO               =   $centro->COD_CENTRO;
                    $cabecera->TXT_CENTRO               =   $centro->NOM_CENTRO;
                    $cabecera->COD_USUARIO_AUTORIZA     =   $usuario->id;
                    $cabecera->TXT_USUARIO_AUTORIZA     =   $usuario->nombre;
                    $cabecera->IND_OBSERVACION          =   0;
                    $cabecera->AREA_OBSERVACION         =   '';
                    $cabecera->TXT_OBSERVACION          =   '';
                    $cabecera->TOTAL                    =   0;
                    $cabecera->FECHA_CREA               =   $this->fechaactual;
                    $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                    $cabecera->save();

                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-liquidacion-gastos/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            $iddocumento                               =   Hashids::encode(substr($idcab, -8));
            return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$iddocumento.'/'.'0')->with('bienhecho', 'Liquidacion de Gastos '.$codigo.' registrado con exito, ingrese sus comprobantes');
        }else{


            $trabajador                     =   DB::table('STD.TRABAJADOR')
                                                ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                                ->first();
            $dni                            =   '';
            if(count($trabajador)>0){
                $dni                        =   $trabajador->NRO_DOCUMENTO;
            }
            $trabajadorespla                =   DB::table('WEB.platrabajadores')
                                                ->where('situacion_id', 'PRMAECEN000000000002')
                                                ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                                ->where('dni', $dni)
                                                ->first();

            $centrocosto                =   DB::table('CON.CENTRO_COSTO')
                                            ->where('COD_ESTADO', 1)
                                            ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                                            ->where('TXT_REFERENCIA_PLANILLA' ,'LIKE', '%'.$trabajadorespla->cadarea.'%')
                                            ->where('IND_MOVIMIENTO', 1)->first();
            $area_id                    =   "";
            $area_txt                   =   "";
            //hola
            if(count($centrocosto)>0){
                $area_id                    =   $centrocosto->COD_CENTRO_COSTO;
                $area_txt                   =   $centrocosto->TXT_NOMBRE;
            }

            //dd($area_txt);
            //dd($trabajadorespla->cadarea);

            $area_planilla      =   $trabajadorespla->cadarea;

            $anio               =   $this->anio;
            $mes                =   $this->mes;
            $trabajador         =   DB::table('STD.TRABAJADOR')
                                    ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                    ->first();
            $dni                =       '';
            $centro_id          =       '';
            if(count($trabajador)>0){
                $dni            =       $trabajador->NRO_DOCUMENTO;
            }
            $trabajadorespla    =   DB::table('WEB.platrabajadores')
                                    ->where('situacion_id', 'PRMAECEN000000000002')
                                    ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                    ->where('dni', $dni)
                                    ->first();

            if(count($trabajadorespla)>0){
                $centro_id      =       $trabajadorespla->centro_osiris_id;
            }else{
                return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('errorbd', 'No puede realizar un registro porque no es la empresa a cual pertenece');
            }



            $empresa            =   DB::table('STD.EMPRESA')
                                    ->where('NRO_DOCUMENTO', $dni)
                                    ->first();

            $empresa_id         =   "";
            $combo_empresa      =   array();
            $cuenta_id          =   "";
            $combo_cuenta       =   array();
            $subcuenta_id       =   "";
            $combo_subcuenta    =   array();
            $cod_contrato       =   "";
            if(count($empresa)>0){
                $empresa_id     =   $empresa->COD_EMPR;
                $combo_empresa  =   array($empresa->COD_EMPR=>$empresa->NOM_EMPR);

                $cuenta_id      =   $this->lg_cuenta_top_1("Seleccione una Cuenta","","TCO0000000000069",$centro_id,$empresa_id);
                $combo_cuenta   =   $this->lg_combo_cuenta("Seleccione una Cuenta","","TCO0000000000069",$centro_id,$empresa_id);
                $cuenta_id          =   "";
                $combo_cuenta       =   array();

                $cuenta         =   $this->lg_cuenta("Seleccione una Cuenta","","TCO0000000000069",$centro_id,$empresa_id);
                if(count($cuenta)>0){
                    $cod_contrato       =   $cuenta->COD_CONTRATO;
                }

                $subcuenta_id       =   $this->lg_subcuenta_top1("Seleccione SubCuenta",$cod_contrato);
                $combo_subcuenta    =   $this->lg_combo_subcuenta("Seleccione SubCuenta",$cod_contrato);
            }
            $fecha_creacion      =   $this->hoy;

            $vale                =      DB::table('WEB.VALE_RENDIR')
                                        ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                                        ->where('COD_USUARIO_CREA_AUD', Session::get('usuario')->id)
                                        ->where('COD_CATEGORIA_ESTADO_VALE', 'ETM0000000000007')
                                        ->get();


            if(count($vale)>0){
                $combo_arendir       =   array('' => "SELECCIONE SI TIENE A RENDIR",'SI' => "SI");
            }else{
                $combo_arendir       =   array('' => "SELECCIONE SI TIENE A RENDIR",'NO' => "NO");
            }

            $combo_arendir       =   array('' => "SELECCIONE SI TIENE A RENDIR",'SI' => "SI",'NO' => "NO");

            //$combo_arendir       =   array('' => "SELECCIONE SI TIENE A RENDIR",'NO' => "NO");
            $arendir_id          =   "";
            $centro              =   ALMCentro::where('COD_CENTRO','=',$centro_id)->first();

            $autoriza_id         =   '';
            $combo_autoriza      =   $this->gn_combo_usuarios();
            $arendir_sel_id      =   '';
            $combo_arendir_sel   =   $this->gn_combo_arendir();

            $moneda_sel_id       =   '';
            $combo_moneda_sel    =   $this->gn_generacion_combo_categoria('MONEDA',"SELECCIONE MONEDA",'');


            //dd($combo_arendir_sel);
            return View::make('liquidaciongasto.agregarliquidaciongastos',
                             [
                                'combo_empresa' => $combo_empresa,
                                'combo_arendir' => $combo_arendir,
                                'empresa_id'    => $empresa_id,
                                'cuenta_id'     => $cuenta_id,
                                'combo_cuenta'  => $combo_cuenta,

                                'moneda_sel_id'   => $moneda_sel_id,
                                'combo_moneda_sel'=> $combo_moneda_sel,
                                'area_id'         => $area_id,
                                'area_txt'        => $area_txt,
                                'area_planilla'   => $area_planilla,


                                'autoriza_id'   => $autoriza_id,
                                'combo_autoriza'=> $combo_autoriza,

                                'subcuenta_id'  => $subcuenta_id,
                                'combo_subcuenta'=> $combo_subcuenta,

                                'combo_arendir_sel'  => $combo_arendir_sel,
                                'arendir_id'    => $arendir_id,
                                'arendir_sel_id'    => $arendir_sel_id,
                                'centro'        => $centro,
                                'fecha_creacion'=> $fecha_creacion,
                                'anio'          => $anio,
                                'mes'           => $mes,
                                'idopcion'      => $idopcion
                             ]);
        }   
    }


    public function actionAjaxComboCuentaXMoneda(Request $request)
    {

        $empresa_id             =   $request['empresa_id'];
        $moneda_sel_id          =   $request['moneda_sel_id'];



        $cuenta_id              =   "";
        $trabajador             =   DB::table('STD.TRABAJADOR')
                                    ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                    ->first();

        $dni                    =   '';
        $centro_id              =   '';
        if(count($trabajador)>0){
            $dni                =   $trabajador->NRO_DOCUMENTO;
        }
        $trabajadorespla        =   DB::table('WEB.platrabajadores')
                                    ->where('situacion_id', 'PRMAECEN000000000002')
                                    ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                    ->where('dni', $dni)
                                    ->first();
        if(count($trabajador)>0){
            $centro_id      =       $trabajadorespla->centro_osiris_id;
        }

        $cadena = $empresa_id;
        $partes = explode(" - ", $cadena);
        $nombre = '';
        if (count($partes) > 1) {
            $nombre = trim($partes[1]);
        }


        $combo_cuenta   =   $this->lg_combo_cuenta_moneda("Seleccione una Cuenta","","TCO0000000000069",$centro_id,$empresa_id,$moneda_sel_id);
        //$combo_cuenta           =   $this->lg_combo_cuenta_lg_moneda('Seleccione una Cuenta','','',$centro_id,$empresa_id,$moneda_sel_id);
        

        return View::make('general/ajax/combocuenta',
                         [          

                            'cuenta_id'                     => $cuenta_id,
                            'combo_cuenta'                  => $combo_cuenta,
                            'ajax'                          => true,                            
                         ]);
    }

    public function actionAjaxComboCuenta(Request $request)
    {

        $empresa_id             =   $request['empresa_id'];
        $cuenta_id              =   "";
        $trabajador             =   DB::table('STD.TRABAJADOR')
                                    ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                    ->first();

        $dni                    =   '';
        $centro_id              =   '';
        if(count($trabajador)>0){
            $dni                =   $trabajador->NRO_DOCUMENTO;
        }
        $trabajadorespla        =   DB::table('WEB.platrabajadores')
                                    ->where('situacion_id', 'PRMAECEN000000000002')
                                    ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                    ->where('dni', $dni)
                                    ->first();
        if(count($trabajador)>0){
            $centro_id      =       $trabajadorespla->centro_osiris_id;
        }

        $cadena = $empresa_id;
        $partes = explode(" - ", $cadena);
        $nombre = '';
        if (count($partes) > 1) {
            $nombre = trim($partes[1]);
        }


        $combo_cuenta           =   $this->lg_combo_cuenta_lg('Seleccione una Cuenta','','',$centro_id,$nombre);
        

        return View::make('general/ajax/combocuenta',
                         [          

                            'cuenta_id'                     => $cuenta_id,
                            'combo_cuenta'                  => $combo_cuenta,
                            'ajax'                          => true,                            
                         ]);
    }



    public function actionAjaxComboSubCuenta(Request $request)
    {

        $cuenta_id              =   $request['cuenta_id'];

        //dd($cuenta_id);

        $subcuenta_id           =   "";
        $combo_subcuenta        =   $this->lg_combo_subcuenta("Seleccione SubCuenta",$cuenta_id);

        return View::make('general/ajax/combosubcuenta',
                         [          
                            'subcuenta_id'    => $subcuenta_id,
                            'combo_subcuenta' => $combo_subcuenta,
                            'ajax'            => true,                            
                         ]);

    }

    public function actionAjaxComboAutoriza(Request $request)
    {

        $arendir_sel_id         =   $request['arendir_sel_id'];
        $vale                   =   DB::table('WEB.VALE_RENDIR')
                                    ->where('ID', $arendir_sel_id)
                                    ->first();
        $usuario_id             =   '';
        if(count($vale)>0){
            $usuario            =   DB::table('users')
                                    ->where('usuarioosiris_id', $vale->USUARIO_AUTORIZA)
                                    ->first();
            $usuario_id         =   $usuario->id;

        }
        $autoriza_id         =   $usuario_id;
        $combo_autoriza      =   $this->gn_combo_usuarios_id($autoriza_id);

        return View::make('liquidaciongasto/ajax/comboautoriza',
                         [          
                            'autoriza_id'    => $autoriza_id,
                            'combo_autoriza' => $combo_autoriza,
                            'ajax'              => true,                            
                         ]);

    }



    public function actionAjaxComboItem(Request $request)
    {

        $flujo_id               =   $request['flujo_id'];
        $item_id                =   "";
        $combo_item             =   $this->lg_combo_item("Seleccione Item",$flujo_id);

        return View::make('general/ajax/comboitem',
                         [          
                            'item_id'           => $item_id,
                            'combo_item'        => $combo_item,
                            'ajax'              => true,                            
                         ]);

    }



    public function actionListarLiquidacionGastos($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Liquidación Gasto');
        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        $fecha_inicio       =   $this->fecha_menos_diez_dias;
        $fecha_fin          =   $this->fecha_sin_hora;

        $listacabecera      =   LqgLiquidacionGasto::where('ACTIVO','=','1')
                                ->whereRaw("CAST(FECHA_CREA  AS DATE) >= ? and CAST(FECHA_CREA  AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                ->orderby('FECHA_CREA','DESC')->get();

        $listadatos         =   array();
        $funcion            =   $this;
        return View::make('liquidaciongasto/listaliquidaciongasto',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'listacabecera'     =>  $listacabecera,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin
                         ]);
    }



}
