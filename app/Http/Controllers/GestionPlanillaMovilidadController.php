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
use App\Modelos\STDEmpresa;
use App\Modelos\CONPeriodo;

use App\Modelos\FePlanillaEntregable;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\Archivo;
use App\Modelos\Firma;


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
use PDF;
use App\Traits\GeneralesTraits;
use App\Traits\PlanillaTraits;
use App\Traits\ComprobanteTraits;



use Hashids;
use SplFileInfo;
use Excel;

class GestionPlanillaMovilidadController extends Controller
{
    use GeneralesTraits;
    use PlanillaTraits;
    use ComprobanteTraits;

    public function actionAgregarExtornoFirma($idopcion, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $idordencompra;
        $iddocumento = $this->funciones->decodificarmaestrapre($idordencompra, 'FIRM');
        View::share('titulo', 'Extornar Firma');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $descripcion = $request['descripcionextorno'];
                $firma = Firma::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                //ANULAR TODA LA OPERACION
                Firma::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO',
                            'TXT_EXTORNO' => $descripcion
                        ]
                    );

                DB::commit();
                return Redirect::to('gestion-de-aprobacion-firma-administracion/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $firma->ID_DOCUMENTO . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-aprobacion-firma-administracion/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }

    }

    public function actionAprobarAdministracionFirma($idopcion, $iddocumento, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'FIRM');
        View::share('titulo', 'Aprobar Firma');

        if ($_POST) {
            try {

                DB::beginTransaction();
                $firma = Firma::where('ID_DOCUMENTO', '=', $iddocumento)->first();

                Firma::where('ID_DOCUMENTO', $firma->ID_DOCUMENTO)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADO',
                            'USUARIO_MOD' => Session::get('usuario')->id,
                            'FECHA_MOD' => $this->fechaactual
                        ]
                    );


                $origen = '\\\\10.1.50.2\\comprobantes\\FIRMA\\'.$firma->NOMBRE_ARCHIVO;
                $destino = public_path('firmas/'.$firma->NOMBRE_ARCHIVO);

                // Reemplazar las barras invertidas por barras normales (por si acaso)
                $origen = str_replace('\\', '/', $origen);

                // Verificar si el archivo existe en el origen
                if (file_exists($origen)) {
                    // Copiar el archivo a la carpeta local
                    if (!copy($origen, $destino)) {
                        return Redirect::to('/gestion-de-aprobacion-firma-administracion/' . $idopcion)->with('errorbd', $ex . ' Error al copiar el archivo.');
                    }
                } else {
                    return Redirect::to('/gestion-de-aprobacion-firma-administracion/' . $idopcion)->with('errorbd', $ex . ' El archivo de origen no existe');
                }


                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-firma-administracion/' . $idopcion)->with('bienhecho', 'FIRMA : ' . $firma->DNI . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('/gestion-de-aprobacion-firma-administracion/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        } else {


            $archivospdf = Firma::where('ID_DOCUMENTO', '=', $iddocumento)->get();

            $ocultar = "";
            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-filefirma', ['file' => $archivo->NOMBRE_ARCHIVO]);
            }
            $initialPreviewConfig = [];

            foreach ($archivospdf as $key => $archivo) {
                $valor = '';
                if ($key > 0) {
                    $valor = 'ocultar';
                }
                $initialPreviewConfig[] = [
                    'type' => "pdf",
                    'caption' => $archivo->NOMBRE_ARCHIVO,
                    'downloadUrl' => route('serve-filefirma', ['file' => $archivo->NOMBRE_ARCHIVO]),
                    'frameClass' => $archivo->ID_DOCUMENTO . ' ' . $valor //
                ];
            }

            //dd($initialPreviewConfig);
            $archivos = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
            $firma = Firma::where('ID_DOCUMENTO', '=', $iddocumento)->first();
            return View::make('planillamovilidad/aprobaradministracionfirma',
                [
                    'firma' => $firma,
                    'archivos' => $archivos,
                    'idopcion' => $idopcion,
                    'idcab' => $idcab,
                    'iddocumento' => $iddocumento,
                    'initialPreview' => json_encode($initialPreview),
                    'initialPreviewConfig' => json_encode($initialPreviewConfig),
                ]);


        }
    }



    public function actionAprobarFirma($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista firma (administracion)');
        $tab_id = 'oc';
        if (isset($request['tab_id'])) {
            $tab_id = $request['tab_id'];
        }

        $listadatos = $this->plm_lista_cabecera_comprobante_total_firma();

        $funcion = $this;
        return View::make('planillamovilidad/listamovilidadafirma',
            [
                'listadatos' => $listadatos,
                'tab_id' => $tab_id,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
            ]);
    }



    public function actionAgregarExtornoContabilidadPLA($idopcion, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $idordencompra;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($idordencompra,'CPLA');
        View::share('titulo','Extornar Planilla');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $feplanillaentrega      =   FePlanillaEntregable::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $descripcion            =   $request['descripcionextorno'];


                //dd($descripcion);
                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento                              =   new PlaDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $feplanillaentrega->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'DOCUMENTO EXTORNADO';
                $documento->MENSAJE                     =   $descripcion;
                $documento->save();

                //ANULAR TODA LA OPERACION
                FePlanillaEntregable::where('ID_DOCUMENTO',$iddocumento)
                            ->update(
                                [
                                    'COD_CATEGORIA_ESTADO'=>'ETM0000000000006',
                                    'TXT_CATEGORIA_ESTADO'=>'RECHAZADO'
                                ]
                            );


                DB::table('PLA_MOVILIDAD')
                    ->where('FOLIO', $feplanillaentrega->FOLIO)
                    ->update([
                        'FOLIO_EXTORNO' => DB::raw("FOLIO_EXTORNO + ','")
                    ]);

                DB::table('PLA_MOVILIDAD')
                    ->where('FOLIO', $feplanillaentrega->FOLIO)
                    ->update([
                        'FOLIO' => '',
                        'FOLIO_RESERVA' => ''
                    ]);

                DB::commit();
                return Redirect::to('gestion-de-aprobar-planilla-consolidada/'.$idopcion)->with('bienhecho', 'Comprobante : '.$feplanillaentrega->ID_DOCUMENTO.' EXTORNADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-aprobar-planilla-consolidada/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
 
    }



    public function actionAprobarContabilidadPLARevisada($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'CPLA');
        View::share('titulo','Revisar Planilla Movilidad Contabilidad');

        $feplanillaentrega      =   FePlanillaEntregable::where('ID_DOCUMENTO','=',$iddocumento)->first();

        $usercre                =   User::where('id','=',$feplanillaentrega->COD_USUARIO_EMITE)->first();
        $trabajadorcrea         =   STDTrabajador::where('COD_TRAB','=',$usercre->usuarioosiris_id)->first();
        $dni                    =   $trabajadorcrea->NRO_DOCUMENTO;
        $planillamovilidad      =   PlaMovilidad::where('FOLIO','=',$feplanillaentrega->FOLIO)
                                    ->pluck('ID_DOCUMENTO')
                                    ->toArray();
        $detplanillamovilidad   =   PlaDetMovilidad::whereIn('ID_DOCUMENTO', $planillamovilidad)
                                    ->where('ACTIVO','=','1')->orderby('FECHA_GASTO','ASC')->get();
        $nombre_responsable     =   $trabajadorcrea->TXT_NOMBRES.' '.$trabajadorcrea->TXT_APE_PATERNO.' '.$trabajadorcrea->TXT_APE_MATERNO;
        $empresa                =   STDEmpresa::where('COD_EMPR','=',$feplanillaentrega->COD_EMPRESA)->first();
        $ruc                    =   $empresa->NRO_DOCUMENTO;
        $direccion              =   $this->gn_direccion_fiscal();
        $lugares_trabajo        =   DB::table('PLA_MOVILIDAD')
                                    ->selectRaw("STUFF((
                                        SELECT DISTINCT ' / ' + TXT_DIRECCION
                                        FROM PLA_MOVILIDAD p2
                                        WHERE p2.FOLIO = PLA_MOVILIDAD.FOLIO
                                        FOR XML PATH('')
                                    ), 1, 3, '') AS DIRECCIONES_CONCATENADAS")
                                    ->where('FOLIO', $feplanillaentrega->FOLIO)
                                    ->first();

        $planillamovilidadglosas =   PlaMovilidad::where('FOLIO','=',$feplanillaentrega->FOLIO)
                                    ->get();
        $documentohistorial     =   PlaDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();
        $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('EXTENSION', 'like', '%'.'pdf'.'%')->get();
        $ocultar                =   "";
        // Construir el array de URLs
        $initialPreview = [];
        foreach ($archivospdf as $archivo) {
            $initialPreview[] = route('serve-filepla', ['file' => $archivo->NOMBRE_ARCHIVO]);
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


        return View::make('planillamovilidad/aprobarcontabilidadplarevisar', 
                        [
                            'feplanillaentrega'     =>  $feplanillaentrega,
                            'documentohistorial'    =>  $documentohistorial,
                            'idopcion'              =>  $idopcion,
                            'idcab'                 =>  $idcab,
                            'iddocumento'           =>  $iddocumento,
                            'initialPreview'        => json_encode($initialPreview),
                            'initialPreviewConfig'  => json_encode($initialPreviewConfig),      
                        ]);


    }


    public function actionAprobarContabilidadPLA($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'CPLA');
        View::share('titulo','Aprobar Planilla Movilidad Contabilidad');

        if($_POST)
        {
            try{    
            
                DB::beginTransaction();
                $feplanillaentrega      =   FePlanillaEntregable::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $descripcion            =   $request['descripcion'];
                $nro_cuenta_contable    =   $request['nro_cuenta_contable'];


                if(rtrim(ltrim($descripcion)) != ''){
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new PlaDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $feplanillaentrega->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   1;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'ACOTACION POR CONTABILIDAD';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();
                }

                FePlanillaEntregable::where('ID_DOCUMENTO',$feplanillaentrega->ID_DOCUMENTO)
                            ->update(
                                [
                                    'COD_CATEGORIA_ESTADO'=>'ETM0000000000005',
                                    'TXT_CATEGORIA_ESTADO'=>'APROBADO',
                                    'COD_USUARIO_CONTA'=>Session::get('usuario')->id,
                                    'TXT_USUARIO_CONTA'=>Session::get('usuario')->nombre,
                                    'FECHA_CONTABILIDAD'=>$this->fechaactual
                                ]
                            );

                PlaMovilidad::where('FOLIO',$feplanillaentrega->FOLIO)
                            ->update(
                                [
                                    'NRO_CUENTA'=>$nro_cuenta_contable
                                ]
                            );


                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new PlaDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $feplanillaentrega->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE                     =   '';
                $documento->save();

                DB::commit();
                return Redirect::to('/gestion-de-aprobar-planilla-consolidada/'.$idopcion)->with('bienhecho', 'Planilla Movilidad : '.$feplanillaentrega->CODIGO.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-aprobar-planilla-consolidada/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
        else{


            $feplanillaentrega      =   FePlanillaEntregable::where('ID_DOCUMENTO','=',$iddocumento)->first();

            $usercre                =   User::where('id','=',$feplanillaentrega->COD_USUARIO_EMITE)->first();
            $trabajadorcrea         =   STDTrabajador::where('COD_TRAB','=',$usercre->usuarioosiris_id)->first();
            $dni                    =   $trabajadorcrea->NRO_DOCUMENTO;
            $planillamovilidad      =   PlaMovilidad::where('FOLIO','=',$feplanillaentrega->FOLIO)
                                        ->pluck('ID_DOCUMENTO')
                                        ->toArray();
            $detplanillamovilidad   =   PlaDetMovilidad::whereIn('ID_DOCUMENTO', $planillamovilidad)
                                        ->where('ACTIVO','=','1')->orderby('FECHA_GASTO','ASC')->get();
            $nombre_responsable     =   $trabajadorcrea->TXT_NOMBRES.' '.$trabajadorcrea->TXT_APE_PATERNO.' '.$trabajadorcrea->TXT_APE_MATERNO;
            $empresa                =   STDEmpresa::where('COD_EMPR','=',$feplanillaentrega->COD_EMPRESA)->first();
            $ruc                    =   $empresa->NRO_DOCUMENTO;
            $direccion              =   $this->gn_direccion_fiscal();
            $lugares_trabajo        =   DB::table('PLA_MOVILIDAD')
                                        ->selectRaw("STUFF((
                                            SELECT DISTINCT ' / ' + TXT_DIRECCION
                                            FROM PLA_MOVILIDAD p2
                                            WHERE p2.FOLIO = PLA_MOVILIDAD.FOLIO
                                            FOR XML PATH('')
                                        ), 1, 3, '') AS DIRECCIONES_CONCATENADAS")
                                        ->where('FOLIO', $feplanillaentrega->FOLIO)
                                        ->first();

            $planillamovilidadglosas =   PlaMovilidad::where('FOLIO','=',$feplanillaentrega->FOLIO)
                                        ->get();
            $documentohistorial     =   PlaDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->orderby('FECHA','DESC')->get();
            $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('EXTENSION', 'like', '%'.'pdf'.'%')->get();
            $ocultar                =   "";
            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-filepla', ['file' => $archivo->NOMBRE_ARCHIVO]);
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

            //dd($initialPreviewConfig);

            return View::make('planillamovilidad/aprobarcontabilidadpla', 
                            [
                                'feplanillaentrega'     =>  $feplanillaentrega,
                                'documentohistorial'    =>  $documentohistorial,
                                'idopcion'              =>  $idopcion,
                                'idcab'                 =>  $idcab,
                                'iddocumento'           =>  $iddocumento,
                                'initialPreview'        => json_encode($initialPreview),
                                'initialPreviewConfig'  => json_encode($initialPreviewConfig),      
                            ]);


        }
    }




    public function actionAprobarPlanillaMovilidadContabilidad($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Planilla de Movilidad Consolidada (contabilidad)');
        $tab_id             =   'oc';
        if(isset($request['tab_id'])){
            $tab_id             =   $request['tab_id'];
        }
        $empresa_id     =   Session::get('empresas')->COD_EMPR;


        $listadatos         =   $this->pl_lista_cabecera_comprobante_total_contabilidad($empresa_id);
        $listadatos_obs     =   $this->pl_lista_cabecera_comprobante_total_contabilidad_revisadas($empresa_id);
        $listadatos_obs_le  =   $this->pl_lista_cabecera_comprobante_total_contabilidad_historial($empresa_id);
        $funcion            =   $this;
        return View::make('planillamovilidad/listaplanillaconsolidadacontabilidad',
                         [
                            'listadatos'        =>  $listadatos,
                            'listadatos_obs'    =>  $listadatos_obs,
                            'listadatos_obs_le' =>  $listadatos_obs_le,
                            'tab_id'            =>  $tab_id,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }



    public function actionGuardarComprobanteconsolidado($idopcion, $idordencompra,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idoc                   =   $idordencompra;
        $fedocumento            =   FePlanillaEntregable::where('ID_DOCUMENTO','=',$idoc)->first();
        View::share('titulo','Subir Comprobante Consolidado');

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();
                $pedido_id          =   $idoc;
                $fedocumento        =   FePlanillaEntregable::where('ID_DOCUMENTO','=',$pedido_id)->first();
                $tarchivos          =   CMPDocAsociarCompra::where('COD_ORDEN','=',$pedido_id)->where('COD_ESTADO','=',1)
                                        ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000038')
                                        ->get();
                foreach($tarchivos as $index => $item){
                    $filescdm          =   $request[$item->COD_CATEGORIA_DOCUMENTO];
                    if(!is_null($filescdm)){
                        foreach($filescdm as $file){
                            $TIPO_ARCHIVO = $item->COD_CATEGORIA_DOCUMENTO;
                            $DESCRIPCION_ARCHIVO = $item->NOM_CATEGORIA_DOCUMENTO;
                            $contadorArchivos = Archivo::count();
                            $nombre          =      $pedido_id.'-'.$file->getClientOriginalName();
                            /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                            $prefijocarperta =      $this->prefijo_empresa($fedocumento->COD_EMPRESA);
                            $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$pedido_id;
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
                            $dcontrol->ID_DOCUMENTO         =   $pedido_id;
                            $dcontrol->DOCUMENTO_ITEM       =   1;
                            $dcontrol->TIPO_ARCHIVO         =   $TIPO_ARCHIVO;
                            $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO  =   $DESCRIPCION_ARCHIVO;
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


                FePlanillaEntregable::where('ID_DOCUMENTO',$pedido_id)
                ->update(
                    [
                        'COD_CATEGORIA_ESTADO'=>'ETM0000000000003',
                        'TXT_CATEGORIA_ESTADO'=>'POR APROBAR CONTABILIDAD'
                    ]
                );
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new PlaDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $pedido_id;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'PDF CONSOLIDADO ADJUNTADO';
                $documento->MENSAJE                     =   '';
                $documento->save();

                DB::commit();
                return Redirect::to('/gestion-de-planilla-consolidada/'.$idopcion)->with('bienhecho', 'Comprobante : '.$pedido_id.' ADJUNTADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-planilla-consolidada/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

        }

    }





    public function actionListarAjaxModalPLanillaConsolidadoSubir(Request $request)
    {
        
        $cod_orden              =   $request['data_requerimiento_id'];
        $idopcion               =   $request['idopcion'];
        $feplanillaentrega      =   FePlanillaEntregable::where('ID_DOCUMENTO','=',$cod_orden)->first();
        $archivosdelfe          =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                    ->whereIn('COD_CATEGORIA', ['DCC0000000000038'])
                                    ->get();

        DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN','=',$cod_orden)
                                           ->where('COD_CATEGORIA_DOCUMENTO','=','DCC0000000000038')->delete();

        foreach($archivosdelfe as $index=>$item){
                $categoria                               =   CMPCategoria::where('COD_CATEGORIA','=',$item->COD_CATEGORIA)->first();
                $docasociar                              =   New CMPDocAsociarCompra;
                $docasociar->COD_ORDEN                   =   $cod_orden;
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

        $tarchivos              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$cod_orden)->where('COD_ESTADO','=',1)
                                    ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000038'])
                                    ->get();

        return View::make('planillamovilidad/modal/ajax/magregarpdfplanillaconsolidado',
                         [          
                            'cod_orden'             => $cod_orden,
                            'idopcion'              => $idopcion,
                            'feplanillaentrega'     => $feplanillaentrega,
                            'tarchivos'             => $tarchivos,
                            'ajax'                  => true,                            
                         ]);
    }






    public function actionListarEntregaDocumentoFolioPla($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista de Folio de Planilla Movilidad');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $empresa_id     =   Session::get('empresas')->COD_EMPR;

        $listadatos     =   $this->pl_lista_planilla_moilidad_consolidado($empresa_id);

        $funcion        =   $this;
        return View::make('planillamovilidad/listaentregadocumentofoliopla',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }


    public function actionPDFPlanillaMovilidadConsolidada($iddocumento,Request $request)
    {
        $idcab                  =   $iddocumento;
        $iddocumento            =   $idcab;
        $feplanillaentrega      =   FePlanillaEntregable::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $usercre                =   User::where('id','=',$feplanillaentrega->COD_USUARIO_EMITE)->first();
        $trabajadorcrea         =   STDTrabajador::where('COD_TRAB','=',$usercre->usuarioosiris_id)->first();
        $dni                    =   $trabajadorcrea->NRO_DOCUMENTO;
        $nombre                 =   $trabajadorcrea->TXT_NOMBRES.' '.$trabajadorcrea->TXT_APE_PATERNO.' '.$trabajadorcrea->TXT_APE_MATERNO;

        $planillamovilidad      =   PlaMovilidad::where('FOLIO','=',$feplanillaentrega->FOLIO)
                                    ->pluck('ID_DOCUMENTO')
                                    ->toArray();
        $detplanillamovilidad   =   PlaDetMovilidad::whereIn('ID_DOCUMENTO', $planillamovilidad)
                                    ->where('ACTIVO','=','1')->orderby('FECHA_GASTO','ASC')->get();
        $nombre_responsable     =   $trabajadorcrea->TXT_NOMBRES.' '.$trabajadorcrea->TXT_APE_PATERNO.' '.$trabajadorcrea->TXT_APE_MATERNO;
        $empresa                =   STDEmpresa::where('COD_EMPR','=',$feplanillaentrega->COD_EMPRESA)->first();
        $ruc                    =   $empresa->NRO_DOCUMENTO;
        $direccion              =   $this->gn_direccion_fiscal();
        $lugares_trabajo        =   DB::table('PLA_MOVILIDAD')
                                    ->selectRaw("STUFF((
                                        SELECT DISTINCT ' / ' + TXT_DIRECCION
                                        FROM PLA_MOVILIDAD p2
                                        WHERE p2.FOLIO = PLA_MOVILIDAD.FOLIO
                                        FOR XML PATH('')
                                    ), 1, 3, '') AS DIRECCIONES_CONCATENADAS")
                                    ->where('FOLIO', $feplanillaentrega->FOLIO)
                                    ->first();

        $planillamovilidadglosas =   PlaMovilidad::where('FOLIO','=',$feplanillaentrega->FOLIO)
                                    ->get();

        


        $pdf = PDF::loadView('pdffa.planillamovilidadconsolidada', [ 
                'iddocumento'           => $iddocumento,
                'feplanillaentrega'     => $feplanillaentrega, 
                'dni'                   => $dni,
                'nombre'                => $nombre,
                'planillamovilidad'     => $planillamovilidad,
                'detplanillamovilidad'  => $detplanillamovilidad,
                'ruc'                   => $ruc,
                'nombre_responsable'    => $nombre_responsable,
                'lugares_trabajo'       => $lugares_trabajo,
                'planillamovilidadglosas'       => $planillamovilidadglosas,
                'direccion'             => $direccion,
            ])->setPaper('a4', 'landscape'); 

        return $pdf->stream($feplanillaentrega->ID_DOCUMENTO.'.pdf');

    }





    public function actionEntregableGuardarFolioEntregablePla($idopcion,Request $request)
    {
        try{
            DB::beginTransaction();

            $folio                                  =   $request['folio'];
            $glosa_g                                =   $request['glosa_g'];
            $id_documento                           =   $request['ID_DOCUMENTO'];


            FePlanillaEntregable::where('FOLIO','=',$folio)
                        ->update(
                            [
                                'SELECCION'=>0,
                                'FEC_EMISION'=>$this->fecha_sin_hora,
                                'COD_USUARIO_EMITE'=>Session::get('usuario')->id,
                                'TXT_USUARIO_EMITE'=>Session::get('usuario')->nombre,
                                'TXT_GLOSA'=>$glosa_g,
                                'COD_CATEGORIA_ESTADO'=>'ETM0000000000011',
                                'TXT_CATEGORIA_ESTADO'=>'POR SUBIR CONSOLIDADO',
                                'USUARIO_MOD'=>Session::get('usuario')->id,
                                'FECHA_MOD'=>$this->fechaactual
                            ]
                        );

            PlaMovilidad::where('FOLIO_RESERVA',$folio)
                        ->update(
                            [
                                'FOLIO'=>$folio
                            ]
                        );

            $documento                              =   new PlaDocumentoHistorial;
            $documento->ID_DOCUMENTO                =   $id_documento;
            $documento->DOCUMENTO_ITEM              =   1;
            $documento->FECHA                       =   $this->fechaactual;
            $documento->USUARIO_ID                  =   Session::get('usuario')->id;
            $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
            $documento->TIPO                        =   'EMITIDO POR EL USUARIO';
            $documento->MENSAJE                     =   '';
            $documento->save();

            DB::commit();
            return Redirect::to('gestion-de-consolidar-planilla/'.$idopcion)->with('bienhecho', 'Folio '.$folio.' creado con exito');
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('gestion-de-consolidar-planilla/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }
    }



    public function actionEntregableDetalleFolioPagoPla(Request $request)
    {
        $data_folio             =   $request['data_folio'];
        $lfedocumento           =   PlaMovilidad::where('FOLIO_RESERVA','=',$data_folio)->orderby('TXT_TRABAJADOR','asc')->get();

        $mensaje                =   "";
        $entregagle_a           =   FePlanillaEntregable::where('FOLIO','=',$data_folio)->first();
        $funcion                =   $this;
        return View::make('planillamovilidad/modal/ajax/mdetallefoliopla',
                         [
                            'lfedocumento'      =>  $lfedocumento,
                            'data_folio'        =>  $data_folio,
                            'entregagle_a'      =>  $entregagle_a,
                            'mensaje'           =>  $mensaje,
                            'funcion'           =>  $funcion
                         ]);
    }



    public function actionEntregableCrearFolioPla(Request $request)
    {

        $check                  =   $request['check'];
        $id                     =   $request['id'];
        $folio_sel              =   $request['folio_sel'];
        $data                   =   array();
        $mensaje                =   "";
        $ope_ind                =   "0";
        $lote_ver               =   "";

        $entregable             =   FePlanillaEntregable::where('FOLIO','=',$folio_sel)
                                    ->first();
        $fedocumento_encontro   =   PlaMovilidad::where('ID_DOCUMENTO',$id)->first();

        if($check==1){
            //validacion si ya esta en otro folio
                //SI NO ESTA NULL O VACIO TIENE ALGO
            if (!empty($fedocumento_encontro->FOLIO_RESERVA)) {
                $mensaje            =   "Este Documento ya tiene un folio asigando ".$fedocumento_encontro->FOLIO_RESERVA;
                $ope_ind            =   "1";
            }
            if($entregable->COD_PERIODO != $fedocumento_encontro->COD_PERIODO){
                $mensaje            =   "Este Documento esta no pertenece al Periodo del LOTE";
                $ope_ind            =   "1";
            }
        }

        if($ope_ind=="0"){

            if($check==1){

                PlaMovilidad::where('ID_DOCUMENTO','=',$fedocumento_encontro->ID_DOCUMENTO)
                            ->update(
                                [
                                    'FOLIO_RESERVA'=>$folio_sel
                                ]
                            );
                $fedocumentos =  PlaMovilidad::where('FOLIO_RESERVA','=',$folio_sel)->get();
                FePlanillaEntregable::where('FOLIO','=',$folio_sel)
                            ->update(
                                [
                                    'CAN_FOLIO'=>count($fedocumentos)
                                ]
                            );
                $lote_ver               =   $entregable->FOLIO . ' ('.count($fedocumentos).')';

            }else{

                PlaMovilidad::where('ID_DOCUMENTO','=',$fedocumento_encontro->ID_DOCUMENTO)
                            ->update(
                                [
                                    'FOLIO_RESERVA'=>''
                                ]
                            );

                $fedocumentos =  PlaMovilidad::where('FOLIO_RESERVA','=',$folio_sel)->get();
                FePlanillaEntregable::where('FOLIO','=',$folio_sel)
                            ->update(
                                [
                                    'CAN_FOLIO'=>count($fedocumentos)
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



    public function actionEntregableExtornoFolioPagoPla(Request $request)
    {
        $data_folio             =   $request['data_folio'];
        FePlanillaEntregable::where('FOLIO','=',$data_folio)
                    ->update(
                        [
                            'COD_ESTADO'=>0,
                            'COD_CATEGORIA_ESTADO'=>'ETM0000000000006',
                            'TXT_CATEGORIA_ESTADO'=>'RECHAZADO'
                        ]
                    );
        PlaMovilidad::where('FOLIO_RESERVA','=',$data_folio)
                    ->update(
                        [
                            'FOLIO_RESERVA'=>''
                        ]
                    );
    }


    public function actionEntregableSelectFolioPagoLg(Request $request)
    {

        $data_folio             =   $request['data_folio'];
        FePlanillaEntregable::where('COD_CATEGORIA_ESTADO','=','ETM0000000000001')
                    ->where('COD_ESTADO','=','1')
                    ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                    ->update(
                        [
                            'SELECCION'=>0
                        ]
                    );

        $feentregable           =   FePlanillaEntregable::where('FOLIO','=',$data_folio)
                                    ->first();
        $feentregable->SELECCION = 1;
        $feentregable->save();
    }



    public function actionEntregableCrearFolioEntregablePla($idopcion,Request $request)
    {
        try{

            DB::beginTransaction();
            $periodo_id                             =   $request['periodo_id'];
            $glosa                                  =   $request['glosa'];
            $empresa_id                             =   Session::get('empresas')->COD_EMPR;
            $periodo                                =   CONPeriodo::where('COD_PERIODO','=',$periodo_id)->first();

            $trabajador                             =   DB::table('STD.TRABAJADOR')
                                                        ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                                        ->first();
            $dni                                    =   '';
            $centro_id                              =   '';
            $anio                                   =   $this->anio;
            $mes                                    =   $this->mes;
            if(count($trabajador)>0){
                $dni        =       $trabajador->NRO_DOCUMENTO;
            }
            $trabajadorespla    =   DB::table('WEB.platrabajadores')
                                    ->where('situacion_id', 'PRMAECEN000000000002')
                                    ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                    ->where('dni', $dni)
                                    ->first();
            if(count($trabajador)>0){
                $centro_id      =       $trabajadorespla->centro_osiris_id;
            }

            if($centro_id == 'CEN0000000000003'){
                $centro_id = 'CEN0000000000001';
            }
            
            if (Session::get('usuario')->id == '1CIX00000040') {
                $centro_id = 'CEN0000000000001';
            }


            if (Session::get('usuario')->id == '1CIX00000380') {
                $centro_id = 'CEN0000000000002';
            }
            if (Session::get('usuario')->id == '1CIX00000391') {
                $centro_id = 'CEN0000000000002';
            }

            $serie          =   $this->gn_serie($anio, $mes,$centro_id);
            $numero         =   $this->gn_numero_pl($serie,$centro_id);

            $centrot        =   DB::table('ALM.CENTRO')
                                ->where('COD_CENTRO', $centro_id)
                                ->first();

            $idcab                                  =   $this->funciones->getCreateIdMaestradocpla('FE_PLANILLA_ENTREGABLE','CPLA');
            $codigo                                 =   $this->funciones->generar_folio('FE_PLANILLA_ENTREGABLE',8);
            $documento                              =   new FePlanillaEntregable;
            $documento->ID_DOCUMENTO                =   $idcab;
            $documento->FOLIO                       =   $codigo;
            $documento->CAN_FOLIO                   =   0;
            $documento->SERIE                       =   $serie;
            $documento->NUMERO                      =   $numero;
            $documento->COD_ESTADO                  =   1;
            $documento->USUARIO_CREA                =   Session::get('usuario')->id;
            $documento->FECHA_CREA                  =   $this->fechaactual;
            $documento->COD_CENTRO                  =   $centrot->COD_CENTRO;
            $documento->TXT_CENTRO                  =   $centrot->NOM_CENTRO;
            $documento->COD_EMPRESA                 =   $empresa_id;
            $documento->TXT_EMPRESA                 =   Session::get('empresas')->NOM_EMPR;
            $documento->COD_PERIODO                 =   $periodo->COD_PERIODO;
            $documento->TXT_PERIODO                 =   $periodo->TXT_NOMBRE;
            $documento->COD_USUARIO_EMITE           =   Session::get('usuario')->id;
            $documento->TXT_USUARIO_EMITE           =   Session::get('usuario')->nombre;
            $documento->COD_CATEGORIA_ESTADO        =   'ETM0000000000001';
            $documento->TXT_CATEGORIA_ESTADO        =   'GENERADO';
            $documento->SELECCION                   =   0;
            $documento->TXT_GLOSA                   =   $glosa;
            $documento->save();
            DB::commit();

            return Redirect::to('gestion-de-consolidar-planilla/'.$idopcion)->with('bienhecho', 'Folio '.$codigo.' creado con exito');
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('gestion-de-consolidar-planilla/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }


    }



    public function actionEntregableModalDetalleFolioPla(Request $request)
    {

        $idopcion               =   $request['idopcion'];
        $listadatos             =   FePlanillaEntregable::where('COD_CATEGORIA_ESTADO','=','ETM0000000000001')
                                    ->where('COD_ESTADO','=','1')
                                    ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->get();

        $periodo_id             =   "";
        $combo_periodo          =   $this->gn_combo_periodo_xempresa(Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');

        $lfedocumento           =   array();
        $array_retencion        =   array();
        $mensaje                =   "";
        $funcion                =   $this;

        return View::make('planillamovilidad/modal/ajax/madetallefoliocreacionpla',
                         [
                            'listadatos'        =>  $listadatos,
                            'lfedocumento'      =>  $lfedocumento,
                            'array_retencion'   =>  $array_retencion,
                            'periodo_id'        =>  $periodo_id,
                            'combo_periodo'     =>  $combo_periodo,

                            'mensaje'           =>  $mensaje,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'periodo_id'        =>  $periodo_id,
                            'ajax'              =>  true,
                         ]);

    }
    public function actionListarAjaxBuscarDocumentoEntregablePla(Request $request) {

        $fecha_inicio   =   $request['fecha_inicio'];
        $fecha_fin      =   $request['fecha_fin'];
        $empresa_id     =   $request['empresa_id'];  
        $idopcion       =   $request['idopcion'];
        $listadatos     =   $this->pl_lista_planilla_moilidad_sinconsolidar($fecha_inicio,$fecha_fin,$empresa_id);
        $funcion        =   $this;

        $entregable_sel =   FePlanillaEntregable::where('COD_CATEGORIA_ESTADO','=','ETM0000000000001')
                            ->where('COD_ESTADO','=','1')
                            ->where('SELECCION','=','1')
                            ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                            ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                            ->first();


        return View::make('planillamovilidad/ajax/ajaxlistaplanillaconsolidada',
                         [
                            'fecha_inicio'          =>  $fecha_inicio,
                            'entregable_sel'        =>  $entregable_sel,
                            'fecha_fin'             =>  $fecha_fin,
                            'empresa_id'            =>  $empresa_id,
                            'idopcion'              =>  $idopcion,
                            'listadatos'            =>  $listadatos,
                            'ajax'                  =>  true,
                            'funcion'               =>  $funcion
                         ]);
    }


    public function actionListarConsolidarPlanilla($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Consolidar Planillas de Movilidad');
        $cod_empresa    =   Session::get('usuario')->usuarioosiris_id;
        $fecha_inicio   =   $this->fecha_menos_diez_dias;
        $fecha_fin      =   $this->fecha_sin_hora;
        $empresa_id     =   Session::get('empresas')->COD_EMPR;
        $combo_empresa  =   $this->gn_combo_empresa_empresa($empresa_id);
        $listadatos     =   $this->pl_lista_planilla_moilidad_sinconsolidar($fecha_inicio,$fecha_fin,$empresa_id);
        $funcion        =   $this;

        $entregable_sel =   FePlanillaEntregable::where('COD_CATEGORIA_ESTADO','=','ETM0000000000001')
                            ->where('COD_ESTADO','=','1')
                            ->where('SELECCION','=','1')
                            ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                            ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                            ->first();

        return View::make('planillamovilidad/listaconsolidarplanilla',
                         [
                            'listadatos'        =>  $listadatos,

                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin,
                            'empresa_id'        =>  $empresa_id,
                            'combo_empresa'     =>  $combo_empresa,
                            'entregable_sel'    =>  $entregable_sel,

                         ]);
    }






    public function actionAprobarPlanillaMovilidadAdministracion($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista planillas de movilidad (administracion)');
        $tab_id             =   'oc';
        if(isset($request['tab_id'])){
            $tab_id             =   $request['tab_id'];
        }

        $listadatos         =   $this->pla_lista_cabecera_comprobante_total_administracion();
        $listadatos_obs     =   $this->pla_lista_cabecera_comprobante_total_administracion();
        $listadatos_obs_le  =   $this->pla_lista_cabecera_comprobante_total_administracion();

        $funcion        =   $this;
        return View::make('planillamovilidad/listaplanillamovilidadadministracion',
                         [
                            'listadatos'        =>  $listadatos,
                            'listadatos_obs'    =>  $listadatos_obs,
                            'listadatos_obs_le' =>  $listadatos_obs_le,
                            'tab_id'            =>  $tab_id,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }


    public function actionAprobarAdministracion($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'PLAM');
        View::share('titulo','Aprobar Planilla Movilidad Administracion');

        if($_POST)
        {
            try{    
            
                DB::beginTransaction();
                $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
                $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $documentohistorial     =   PlaDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();
                $descripcion        =   $request['descripcion'];
                if(rtrim(ltrim($descripcion)) != ''){
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new PlaDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $planillamovilidad->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   1;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'ACOTACION POR EL ADMINISTRACION';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();
                }
                $nro_cuenta_contable=   $request['nro_cuenta_contable'];
                PlaMovilidad::where('ID_DOCUMENTO',$planillamovilidad->ID_DOCUMENTO)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000005',
                                    'TXT_ESTADO'=>'APROBADO'
                                ]
                            );
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new PlaDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $planillamovilidad->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR ADMINISTRACION';
                $documento->MENSAJE                     =   '';
                $documento->save();
                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-planilla-movilidad-administracion/'.$idopcion)->with('bienhecho', 'Planilla de Movilidad : '.$planillamovilidad->ID_DOCUMENTO.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-aprobacion-planilla-movilidad-administracion/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
        else{

            $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
            $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
            $documentohistorial     =   PlaDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();


            return View::make('planillamovilidad/aprobaradministracion', 
                            [
                                'planillamovilidad'     =>  $planillamovilidad,
                                'tdetplanillamovilidad' =>  $tdetplanillamovilidad,
                                'documentohistorial'    =>  $documentohistorial,
                                'idopcion'              =>  $idopcion,
                                'idcab'                 =>  $idcab,
                                'iddocumento'           =>  $iddocumento,
                            ]);


        }
    }


    public function actionAprobarJefe($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'PLAM');
        View::share('titulo','Aprobar Planilla Movilidad Jefe');

        if($_POST)
        {
            try{    
            
                DB::beginTransaction();

                $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
                $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $documentohistorial     =   PlaDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();
                $descripcion        =   $request['descripcion'];
                if(rtrim(ltrim($descripcion)) != ''){
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento                              =   new PlaDocumentoHistorial;
                    $documento->ID_DOCUMENTO                =   $planillamovilidad->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM              =   1;
                    $documento->FECHA                       =   $this->fechaactual;
                    $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                    $documento->TIPO                        =   'ACOTACION POR EL JEFE';
                    $documento->MENSAJE                     =   $descripcion;
                    $documento->save();
                }

                $nro_cuenta_contable=   $request['nro_cuenta_contable'];
                PlaMovilidad::where('ID_DOCUMENTO',$planillamovilidad->ID_DOCUMENTO)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000004',
                                    'TXT_ESTADO'=>'POR APROBAR ADMINISTRACION'
                                ]
                            );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new PlaDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $planillamovilidad->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   1;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'APROBADO POR EL JEFE';
                $documento->MENSAJE                     =   '';
                $documento->save();


                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-planilla-movilidad-jefe/'.$idopcion)->with('bienhecho', 'Planilla de Movilidad : '.$planillamovilidad->ID_DOCUMENTO.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-aprobacion-planilla-movilidad-jefe/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
        else{

            $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
            $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
            $documentohistorial     =   PlaDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();


            return View::make('planillamovilidad/aprobarjefe', 
                            [
                                'planillamovilidad'     =>  $planillamovilidad,
                                'tdetplanillamovilidad' =>  $tdetplanillamovilidad,
                                'documentohistorial'    =>  $documentohistorial,
                                'idopcion'              =>  $idopcion,
                                'idcab'                 =>  $idcab,
                                'iddocumento'           =>  $iddocumento,
                            ]);


        }
    }



    public function actionAprobarPlanillaMovilidadJefe($idopcion,Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista planillas de movilidad (jefe)');
        $tab_id             =   'oc';
        if(isset($request['tab_id'])){
            $tab_id             =   $request['tab_id'];
        }

        $listadatos         =   $this->pla_lista_cabecera_comprobante_total_jefe();
        $listadatos_obs     =   $this->pla_lista_cabecera_comprobante_total_jefe();
        $listadatos_obs_le  =   $this->pla_lista_cabecera_comprobante_total_jefe();

        $funcion        =   $this;
        return View::make('planillamovilidad/listaplanillamovilidadjefe',
                         [
                            'listadatos'        =>  $listadatos,
                            'listadatos_obs'    =>  $listadatos_obs,
                            'listadatos_obs_le' =>  $listadatos_obs_le,
                            'tab_id'            =>  $tab_id,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                         ]);
    }



    public function actionListarPlanillaMovilidadMobil(Request $request) {

        $fecha_inicio   =   $request['fecha_inicio'];
        $fecha_fin      =   $request['fecha_fin'];
        $idopcion       =   $request['idopcion'];
        $funcion        =   $this;

        $planillamovilidad  =   $this->pla_lista_planilla_movilidad_personal($fecha_inicio,$fecha_fin);

        return View::make('planillamovilidad/ajax/alistaplanillamovilidad',
                         [
                            'fecha_inicio'          =>  $fecha_inicio,
                            'fecha_fin'             =>  $fecha_fin,
                            'idopcion'              =>  $idopcion,
                            'planillamovilidad'     =>  $planillamovilidad,
                            'ajax'                  =>  true,
                            'funcion'               =>  $funcion
                         ]);
    }


    public function actionListarPlanillaMovilidad($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Planillas de Movilidad');
        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        $fecha_inicio       =   $this->fecha_menos_diez_dias;
        $fecha_fin          =   $this->fecha_sin_hora;

        $planillamovilidad  =   $this->pla_lista_planilla_movilidad_personal($fecha_inicio,$fecha_fin);
        $trabajador =   DB::table('STD.TRABAJADOR')
                        ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                        ->first();

        $ruta = public_path('firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg');
        $mensaje_firma = "SI CUENTA CON FIRMA PUEDE REGISTRAR SU PLANILLA DE MOVILIDAD";
        if (!file_exists($ruta)) {

            $mensaje_firma  = "NO CUENTA CON FIRMA PUEDE REGISTRAR SU PLANILLA DE MOVILIDAD";
            $firma          =   DB::table('FIRMAS')
                                ->where('DNI', $trabajador->NRO_DOCUMENTO)
                                ->orderBy('FECHA_MOD','DESC')
                                ->first();
            if (count($firma)>0) {
                $mensaje_firma  = "SU ULTIMA SOLICITUD DE FIRMA ESTA EN ESTADO ".$firma->TXT_ESTADO; 
            }

        }

        $listadatos     =   array();
        $funcion        =   $this;
        return View::make('planillamovilidad/listaplanillamovilidad',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'mensaje_firma'     =>  $mensaje_firma,
                            'planillamovilidad' =>  $planillamovilidad,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin
                         ]);
    }


    public function actionPDFPlanillaMovilidad($iddocumento,Request $request)
    {
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'PLAM');
        $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
        $detplanillamovilidad   =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->orderby('FECHA_GASTO','ASC')->get();
        $trabajador             =   STDTrabajador::where('COD_TRAB','=',$planillamovilidad->COD_TRABAJADOR)->first();

        $imgresponsable         =   'firmas/blanco.jpg';
        $nombre_responsable     =   $trabajador->TXT_NOMBRES.' '.$trabajador->TXT_APE_PATERNO.' '.$trabajador->TXT_APE_MATERNO;
        $rutaImagen             =   public_path('firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg');
        if (file_exists($rutaImagen)){
            $imgresponsable         =   'firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg';
            $nombre_responsable     =   $trabajador->TXT_NOMBRES.' '.$trabajador->TXT_APE_PATERNO.' '.$trabajador->TXT_APE_MATERNO;
        }
        $imgaprueba             =   'firmas/blanco.jpg';
        $nombre_aprueba         =   '';
        $existeImagen           =   file_exists($rutaImagen);
        $empresa                =   STDEmpresa::where('COD_EMPR','=',$planillamovilidad->COD_EMPRESA)->first();
        $ruc                    =   $empresa->NRO_DOCUMENTO;
        $direccion              =   $this->gn_direccion_fiscal();

        $pdf = PDF::loadView('pdffa.planillamovilidad', [ 
                'iddocumento'           => $iddocumento, 
                'planillamovilidad'     => $planillamovilidad,
                'detplanillamovilidad'  => $detplanillamovilidad,
                'ruc'                   => $ruc,
                'imgresponsable'        => $imgresponsable, 
                'nombre_responsable'    => $nombre_responsable,
                'imgaprueba'            => $imgaprueba,
                'nombre_aprueba'        => $nombre_aprueba,
                'direccion'             => $direccion,
            ])->setPaper('a4', 'landscape'); // 👈 esta línea pone el PDF en horizontal

        return $pdf->stream($planillamovilidad->ID_DOCUMENTO.'.pdf');

    }




    public function actionEmitirDetallePlanillaMovilidad($idopcion,$iddocumento,Request $request)
    {
        $idcab       = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'PLAM');

        if($_POST)
        {

            try{    
                DB::beginTransaction();

                $glosa                  =    $request['glosa'];

                $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
                $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();

                //para que emita la planilla tiene que tener
                $trabajador             =   STDTrabajador::where('COD_TRAB','=',$planillamovilidad->COD_TRABAJADOR)->first();
                $imgresponsable         =   'firmas/blanco.jpg';
                $nombre_responsable     =   $trabajador->TXT_NOMBRES.' '.$trabajador->TXT_APE_PATERNO.' '.$trabajador->TXT_APE_MATERNO;
                $rutaImagen             =   public_path('firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg');
                if (!file_exists($rutaImagen)){
                    return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd','No puede emitir la Planilla porque no cuenta firma');
                }

                if(count($tdetplanillamovilidad)<=0){
                    return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd','Para poder emitir tiene que cargar sus movilidades');
                }

                PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)
                            ->update(
                                    [
                                        'FECHA_EMI'=> $this->fechaactual,
                                        'FECHA_MOD'=> $this->fechaactual,
                                        'USUARIO_MOD'=> Session::get('usuario')->id,
                                        'COD_ESTADO'=> 'ETM0000000000008',
                                        'TXT_GLOSA'=> $glosa,
                                        'TXT_ESTADO'=> 'TERMINADA'
                                    ]);

                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('bienhecho', 'Planilla Movilidad '.$planillamovilidad->SERIE.'-'.$planillamovilidad->NUMERO.' emitido con exito, ingrese sus comprobantes');
        }  
    }


    public function actionAgregarPlanillaMovilidad($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();


                    $anio           =   $this->anio;
                    $mes            =   $this->mes;
                    $periodo        =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);


                    $trabajador     =   DB::table('STD.TRABAJADOR')
                                        ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                        ->first();
                    $dni            =       '';
                    $centro_id      =       '';
                    if(count($trabajador)>0){
                        $dni        =       $trabajador->NRO_DOCUMENTO;
                    }



                    $trabajadorespla    =   DB::table('WEB.platrabajadores')
                                            ->where('situacion_id', 'PRMAECEN000000000002')
                                            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                            ->where('dni', $dni)
                                            ->first();


                    if(count($trabajadorespla)>0){
                        $centro_id      =       $trabajadorespla->centro_osiris_id;
                    }

                    $terceros   =   DB::table('TERCEROS')
                                ->where('USER_ID', Session::get('usuario')->id)
                                ->where('ACTIVO', 1)
                                ->first();
                    if (count($terceros) > 0) {
                        $centro_id = $terceros->COD_CENTRO;
                    }

                    $serie          =   $this->gn_serie($anio, $mes,$centro_id);
                    $numero         =   $this->gn_numero($serie,$centro_id);


                    $centrot        =   DB::table('ALM.CENTRO')
                                        ->where('COD_CENTRO', $centro_id)
                                        ->first();

                    $txttrabajador  =   '';
                    $codtrabajador  =   '';
                    $doctrabajador  =   '';
                    $fecha_creacion =   $this->hoy;
                    $dtrabajador    =   STDTrabajador::where('COD_TRAB','=',Session::get('usuario')->usuarioosiris_id)->first();
                    if(count($dtrabajador)>0){
                        $txttrabajador  =   $dtrabajador->TXT_APE_PATERNO.' '.$dtrabajador->TXT_APE_MATERNO.' '.$dtrabajador->TXT_NOMBRES;
                        $doctrabajador  =   $dtrabajador->NRO_DOCUMENTO;
                        $codtrabajador  =   $dtrabajador->COD_TRAB;
                    }
                    $idcab                              =   $this->funciones->getCreateIdMaestradocpla('PLA_MOVILIDAD','PLAM');
                    $codigo                             =   $this->funciones->generar_codigo('PLA_MOVILIDAD',8);

                    $direcion_id                        =   $request['direccion_id'];
                    $direccion                          =   $this->gn_generacion_combo_direccion_lg_top($direcion_id);



                    $cabecera                           =   new PlaMovilidad;
                    $cabecera->ID_DOCUMENTO             =   $idcab;
                    $cabecera->CODIGO                   =   $codigo;
                    $cabecera->SERIE                    =   $serie;
                    $cabecera->NUMERO                   =   $numero;
                    $cabecera->COD_TRABAJADOR           =   $codtrabajador;
                    $cabecera->TXT_TRABAJADOR           =   $txttrabajador;
                    $cabecera->COD_EMPRESA              =   Session::get('empresas')->COD_EMPR;
                    $cabecera->TXT_EMPRESA              =   Session::get('empresas')->NOM_EMPR;
                    $cabecera->DOCUMENTO_TRABAJADOR     =   $doctrabajador;
                    $cabecera->COD_PERIODO              =   $periodo->COD_PERIODO;
                    $cabecera->TXT_PERIODO              =   $periodo->TXT_NOMBRE;
                    $cabecera->COD_ESTADO               =   'ETM0000000000001';
                    $cabecera->TXT_ESTADO               =   'GENERADO';
                    $cabecera->COD_CENTRO               =   $centrot->COD_CENTRO;
                    $cabecera->TXT_CENTRO               =   $centrot->NOM_CENTRO;
                    $cabecera->COD_DIRECCION            =   $direccion->COD_DIRECCION;
                    $cabecera->TXT_DIRECCION            =   $direccion->DIRECCION;
                    $cabecera->IGV                      =   0;
                    $cabecera->SUBTOTAL                 =   0;
                    $cabecera->TOTAL                    =   0;
                    $cabecera->FECHA_CREA               =   $this->fechaactual;
                    $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                    $cabecera->save();


                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
                $iddocumento                            =   Hashids::encode(substr($idcab, -8));
                return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$iddocumento)->with('bienhecho', 'Planilla Movilidad '.$serie.'-'.$numero.' registrado con exito, ingrese sus comprobantes');
        }else{

            $anio           =   $this->anio;
            $mes            =   $this->mes;

            $trabajador     =   DB::table('STD.TRABAJADOR')
                                ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                ->first();
            $dni            =       '';
            $centro_id      =       '';
            if(count($trabajador)>0){
                $dni        =       $trabajador->NRO_DOCUMENTO;
            }

            $rutaImagen             =   public_path('firmas/'.$dni.'.jpg');
            if (!file_exists($rutaImagen)){
                //return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('errorbd','No cuenta con firma suba su firma');
            }

            //dd($dni);
            $trabajadorespla    =   DB::table('WEB.platrabajadores')
                                    ->where('situacion_id', 'PRMAECEN000000000002')
                                    ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                    ->where('dni', $dni)
                                    ->first();
                                    
            if(count($trabajadorespla)>0){
                $centro_id      =       $trabajadorespla->centro_osiris_id;
            }else{

                $terceros   =   DB::table('TERCEROS')
                                ->where('USER_ID', Session::get('usuario')->id)
                                ->where('ACTIVO', 1)
                                ->first();
                if (count($terceros) > 0) {
                    $centro_id = $terceros->COD_CENTRO;
                }else{
                    return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('errorbd', 'No puede realizar un registro porque no es la empresa a cual pertenece'); 
                }
            }

            $dtrabajador    =   STDTrabajador::where('COD_TRAB','=',Session::get('usuario')->usuarioosiris_id)->first();
            if (is_null($centro_id)) {
                $trabajadoresplasc    =     DB::table('WEB.platrabajadores')
                                            ->where('situacion_id', 'PRMAECEN000000000002')
                                            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                            ->where('dni', $dni)
                                            ->first();
                if(count($trabajadoresplasc)>0){
                    return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('errorbd', 'El trabajador '.$dtrabajador->TXT_APE_PATERNO.' '.$dtrabajador->TXT_APE_MATERNO.' '.$dtrabajador->TXT_NOMBRES. 'tiene una SEDE no identificada '.$trabajadoresplasc->cadlocal);
                }else{
                    return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('errorbd', 'El trabajador no esta en planilla');
                }
            }


            $periodo        =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);

            //dd($dni);

            $serie          =   $this->gn_serie($anio, $mes,$centro_id);
            $numero         =   $this->gn_numero($serie,$centro_id);


            $centrot        =   DB::table('ALM.CENTRO')
                                ->where('COD_CENTRO', $centro_id)
                                ->first();
            $centro         =   $centrot->NOM_CENTRO;
            $txttrabajador  =   '';
            $doctrabajador  =   '';
            $fecha_creacion =   $this->hoy;


            $dtrabajador    =   STDTrabajador::where('COD_TRAB','=',Session::get('usuario')->usuarioosiris_id)->first();
            if(count($dtrabajador)>0){
                $txttrabajador  =   $dtrabajador->TXT_APE_PATERNO.' '.$dtrabajador->TXT_APE_MATERNO.' '.$dtrabajador->TXT_NOMBRES;
                $doctrabajador  =   $dtrabajador->NRO_DOCUMENTO;
            }

            $combodireccion                 =       $this->gn_generacion_combo_direccion_lg("Seleccione Direccion",""); 
            $direccion_id                   =       '';


            return View::make('planillamovilidad.agregarplanillamovilidad',
                             [
                                'periodo' => $periodo,
                                'serie' => $serie,
                                'numero' => $numero,
                                'centro' => $centro,

                                'combodireccion' => $combodireccion,
                                'direccion_id' => $direccion_id,

                                'txttrabajador' => $txttrabajador,
                                'doctrabajador' => $doctrabajador,
                                'fecha_creacion' => $fecha_creacion,
                                'idopcion' => $idopcion
                             ]);
        }   
    }


    public function actionSubirFirma($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();

                    $files                      =   $request['firma'];
                    if(!is_null($files)){
                        foreach($files as $file){

                            $trabajador                 =   DB::table('STD.TRABAJADOR')
                                                            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                                            ->first();
                            $rutafile                   =      $this->pathFiles.'\\comprobantes\\FIRMA';
                            $nombrefilecdr              =      $trabajador->NRO_DOCUMENTO.'.jpg';
                            $rutacompleta               =      $rutafile.'\\'.$nombrefilecdr;
                            copy($file->getRealPath(),$rutacompleta);
                            $path                       =      $rutacompleta;

                            $nombreoriginal             =   $file->getClientOriginalName();
                            $info                       =   new SplFileInfo($nombreoriginal);
                            $extension                  =   $info->getExtension();
                            $idcab                      =   $this->funciones->getCreateIdMaestradocpla('FIRMAS','FIRM');

                            $dcontrol                   =   new Firma;
                            $dcontrol->ID_DOCUMENTO     =   $idcab;
                            $dcontrol->TXT_NOMBRE       =   Session::get('usuario')->nombre;
                            $dcontrol->DNI              =   $trabajador->NRO_DOCUMENTO;
                            $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                            $dcontrol->DESCRIPCION_ARCHIVO  =   'FIRMA';
                            $dcontrol->URL_ARCHIVO      =   $path;
                            $dcontrol->SIZE             =   filesize($file);
                            $dcontrol->EXTENSION        =   $extension;
                            $dcontrol->COD_ESTADO       =   'ETM0000000000004';
                            $dcontrol->TXT_ESTADO       =   'POR APROBAR ADMINISTRACION';                       
                            $dcontrol->ACTIVO           =   1;
                            $dcontrol->FECHA_CREA       =   $this->fechaactual;
                            $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                            $dcontrol->save();

                        }
                    }

                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
                $iddocumento                            =   Hashids::encode(substr($idcab, -8));
                return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('bienhecho', 'Su firma fue registrado con exito');
        }else{

            $trabajador =   DB::table('STD.TRABAJADOR')
                            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                            ->first();
            $ruta = public_path('firmas/'.$trabajador->NRO_DOCUMENTO.'.jpg');

            if (file_exists($ruta)) {
                return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('errorbd','Usted ya cuenta con una firma confirmada');
            }

            return View::make('planillamovilidad.agregarfirma',
                             [
                                'idopcion' => $idopcion
                             ]);
        }   
    }


    public function actionGuardarModificarDetallePlanillaMovilidad($idopcion,$iddocumento,$item,Request $request)
    {

        $idcab       = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'PLAM');

        try{    
            
            DB::beginTransaction();

                $fecha_gasto            =   $request['fecha_gasto'];    
                $motivo_id              =   $request['motivo_id'];   
                $lugarpartida           =   $request['lugarpartida'];   
                $lugarllegada           =   $request['lugarllegada'];   
                $total                  =   $request['total'];
                $activo                 =   $request['activo'];

                $detplanillamovilidad_item   =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$item)->first();
                //VALIDAR QUE SOLO SEA 45 SOLES DIARIOS
                $totaldia = DB::table('PLA_MOVILIDAD')
                    ->join('PLA_DETMOVILIDAD', 'PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'PLA_DETMOVILIDAD.ID_DOCUMENTO')
                    ->where('PLA_MOVILIDAD.COD_ESTADO', '<>', 'ETM0000000000006')
                    ->where('PLA_DETMOVILIDAD.ACTIVO', 1)
                    ->whereDate('FECHA_GASTO', $fecha_gasto)
                    ->where('PLA_DETMOVILIDAD.USUARIO_CREA', Session::get('usuario')->id)
                    ->sum('PLA_DETMOVILIDAD.TOTAL');
                $totaldiario =    (float)$total  + ($totaldia-$detplanillamovilidad_item->TOTAL);
                if($totaldiario>45){
                    return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd', 'Supero el maximo saldo de 45 soles al dia');
                }

                //VALIDAR QUE SOLO MENSUALMENTE SEA 1130
                $anio_v = date('Y', strtotime($fecha_gasto));
                $mes_v = date('m', strtotime($fecha_gasto));
                $totalmensual = DB::table('PLA_MOVILIDAD')
                    ->join('PLA_DETMOVILIDAD', 'PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'PLA_DETMOVILIDAD.ID_DOCUMENTO')
                    ->where('PLA_MOVILIDAD.COD_ESTADO', '<>', 'ETM0000000000006')
                    ->where('PLA_DETMOVILIDAD.ACTIVO', 1)
                    ->whereYear('FECHA_GASTO', $anio_v)
                    ->whereMonth('FECHA_GASTO', $mes_v)
                    ->where('PLA_DETMOVILIDAD.USUARIO_CREA', Session::get('usuario')->id)
                    ->sum('PLA_DETMOVILIDAD.TOTAL');
                $total_mensual =    (float)$total + ($totalmensual-$detplanillamovilidad_item->TOTAL);
                if($total_mensual>1130){
                    return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd', 'Supero el maximo saldo de 1130 soles al mes');
                }

                //VALIDAR QUE SOLO MENSUALMENTE SEA 1130
                $anio_v = date('Y', strtotime($fecha_gasto));
                $totalanual = DB::table('PLA_MOVILIDAD')
                    ->join('PLA_DETMOVILIDAD', 'PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'PLA_DETMOVILIDAD.ID_DOCUMENTO')
                    ->where('PLA_MOVILIDAD.COD_ESTADO', '<>', 'ETM0000000000006')
                    ->where('PLA_DETMOVILIDAD.ACTIVO', 1)
                    ->whereYear('FECHA_GASTO', $anio_v)
                    ->where('PLA_DETMOVILIDAD.USUARIO_CREA', Session::get('usuario')->id)
                    ->sum('PLA_DETMOVILIDAD.TOTAL');
                $total_anual =    (float)$total + ($totalanual-$detplanillamovilidad_item->TOTAL);
                if($total_anual>16425){
                    return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd', 'Supero el maximo saldo de 16425 soles al año');
                }




                $trabajador     =   DB::table('STD.TRABAJADOR')
                                    ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                    ->first();
                $dni            =       '';
                $centro_id      =       '';
                if(count($trabajador)>0){
                    $dni        =       $trabajador->NRO_DOCUMENTO;
                }
                $trabajadorespla    =   DB::table('WEB.platrabajadores')
                                        ->where('situacion_id', 'PRMAECEN000000000002')
                                        ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                        ->where('dni', $dni)
                                        ->first();
                if(count($trabajador)>0){
                    $centro_id      =       $trabajadorespla->centro_osiris_id;
                }

                if($centro_id == 'CEN0000000000003'){
                    $centro_id = 'CEN0000000000001';
                }

                if (Session::get('usuario')->id == '1CIX00000040') {
                    $centro_id = 'CEN0000000000001';
                }


                if (Session::get('usuario')->id == '1CIX00000380') {
                    $centro_id = 'CEN0000000000002';
                }
                if (Session::get('usuario')->id == '1CIX00000391') {
                    $centro_id = 'CEN0000000000002';
                }

                $anio                   =   $this->anio;
                $mes                    =   $this->mes;
                $periodo                =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
                $serie                  =   $this->gn_serie($anio, $mes,$centro_id);
                $numero                 =   $this->gn_numero($serie,$centro_id);

                $txttrabajador          =   '';
                $codtrabajador          =   '';
                $doctrabajador          =   '';
                $fecha_creacion         =   $this->hoy;
                $dtrabajador            =   STDTrabajador::where('COD_TRAB','=',Session::get('usuario')->usuarioosiris_id)->first();
                if(count($dtrabajador)>0){
                    $txttrabajador      =   $dtrabajador->TXT_APE_PATERNO.' '.$dtrabajador->TXT_APE_MATERNO.' '.$dtrabajador->TXT_NOMBRES;
                    $doctrabajador      =   $dtrabajador->NRO_DOCUMENTO;
                    $codtrabajador      =   $dtrabajador->COD_TRAB;;
                }
                $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
                $detplanillamovilidad   =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->get();

                $motivo                 =   CMPCategoria::where('COD_CATEGORIA','=',$motivo_id)->first();

                PlaDetMovilidad::where('ID_DOCUMENTO','=',$planillamovilidad->ID_DOCUMENTO)
                                    ->where('ITEM','=',$item)
                                    ->update(
                                        [
                                            'FECHA_GASTO'=> $fecha_gasto,
                                            'COD_MOTIVO'=> $motivo->COD_CATEGORIA,
                                            'TXT_MOTIVO'=> $motivo->NOM_CATEGORIA,
                                            'TXT_LUGARPARTIDA'=> $lugarpartida,
                                            'TXT_LUGARLLEGADA'=> $lugarllegada,
                                            'TOTAL'=> $total,
                                            'ACTIVO'=> $activo,
                                            'FECHA_MOD'=> $this->fechaactual,
                                            'USUARIO_MOD'=> Session::get('usuario')->id
                                        ]);

                $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();

                PlaMovilidad::where('ID_DOCUMENTO','=',$planillamovilidad->ID_DOCUMENTO)
                            ->update(
                                    [
                                        'TOTAL'=> $tdetplanillamovilidad->SUM('TOTAL')
                                    ]);


            DB::commit();
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }
            return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('bienhecho', 'Se Agrego un nuevo item con exito');
    }


    public function actionGuardarDetallePlanillaMovilidad($idopcion,$iddocumento,Request $request)
    {

        $idcab       = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'PLAM');

        try{    
            
            DB::beginTransaction();

                $fecha_gasto            =   $request['fecha_gasto'];    
                $motivo_id              =   $request['motivo_id'];   
                $lugarpartida           =   $request['lugarpartida'];   
                $lugarllegada           =   $request['lugarllegada'];   
                $total                  =   $request['total'];
                $total                  =   str_replace(',', '', $total);
                $anio                   =   $this->anio;
                $mes                    =   $this->mes;
                $periodo                =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);

                //VALIDAR QUE SOLO SEA 45 SOLES DIARIOS
                $totaldia = DB::table('PLA_MOVILIDAD')
                    ->join('PLA_DETMOVILIDAD', 'PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'PLA_DETMOVILIDAD.ID_DOCUMENTO')
                    ->where('PLA_MOVILIDAD.COD_ESTADO', '<>', 'ETM0000000000006')
                    ->where('PLA_DETMOVILIDAD.ACTIVO', 1)
                    ->whereDate('FECHA_GASTO', $fecha_gasto)
                    ->where('PLA_DETMOVILIDAD.USUARIO_CREA', Session::get('usuario')->id)
                    ->sum('PLA_DETMOVILIDAD.TOTAL');
                $totaldiario =    (float)$total + $totaldia;
                if($totaldiario>45){
                    return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd', 'Supero el maximo saldo de 45 soles al dia');
                }

                //VALIDAR QUE SOLO MENSUALMENTE SEA 1130
                $anio_v = date('Y', strtotime($fecha_gasto));
                $mes_v = date('m', strtotime($fecha_gasto));
                $totalmensual = DB::table('PLA_MOVILIDAD')
                    ->join('PLA_DETMOVILIDAD', 'PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'PLA_DETMOVILIDAD.ID_DOCUMENTO')
                    ->where('PLA_MOVILIDAD.COD_ESTADO', '<>', 'ETM0000000000006')
                    ->where('PLA_DETMOVILIDAD.ACTIVO', 1)
                    ->whereYear('FECHA_GASTO', $anio_v)
                    ->whereMonth('FECHA_GASTO', $mes_v)
                    ->where('PLA_DETMOVILIDAD.USUARIO_CREA', Session::get('usuario')->id)
                    ->sum('PLA_DETMOVILIDAD.TOTAL');
                $total_mensual =    (float)$total + $totalmensual;
                if($total_mensual>1130){
                    return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd', 'Supero el maximo saldo de 1130 soles al mes');
                }

                //VALIDAR QUE SOLO MENSUALMENTE SEA 1130
                $anio_v = date('Y', strtotime($fecha_gasto));
                $totalanual = DB::table('PLA_MOVILIDAD')
                    ->join('PLA_DETMOVILIDAD', 'PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'PLA_DETMOVILIDAD.ID_DOCUMENTO')
                    ->where('PLA_MOVILIDAD.COD_ESTADO', '<>', 'ETM0000000000006')
                    ->where('PLA_DETMOVILIDAD.ACTIVO', 1)
                    ->whereYear('FECHA_GASTO', $anio_v)
                    ->where('PLA_DETMOVILIDAD.USUARIO_CREA', Session::get('usuario')->id)
                    ->sum('PLA_DETMOVILIDAD.TOTAL');
                $total_anual =    (float)$total + $totalanual;
                if($total_anual>16425){
                    return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd', 'Supero el maximo saldo de 16425 soles al año');
                }

                $trabajador     =   DB::table('STD.TRABAJADOR')
                                    ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                    ->first();
                $dni            =       '';
                $centro_id      =       '';
                if(count($trabajador)>0){
                    $dni        =       $trabajador->NRO_DOCUMENTO;
                }
                $trabajadorespla    =   DB::table('WEB.platrabajadores')
                                        ->where('situacion_id', 'PRMAECEN000000000002')
                                        ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                        ->where('dni', $dni)
                                        ->first();
                if(count($trabajador)>0){
                    $centro_id      =       $trabajadorespla->centro_osiris_id;
                }

                if($centro_id == 'CEN0000000000003'){
                    $centro_id = 'CEN0000000000001';
                }


                if (Session::get('usuario')->id == '1CIX00000040') {
                    $centro_id = 'CEN0000000000001';
                }


                if (Session::get('usuario')->id == '1CIX00000380') {
                    $centro_id = 'CEN0000000000002';
                }
                if (Session::get('usuario')->id == '1CIX00000391') {
                    $centro_id = 'CEN0000000000002';
                }

                $serie                  =   $this->gn_serie($anio, $mes,$centro_id);
                $numero                 =   $this->gn_numero($serie,$centro_id);

                $centrot                =   DB::table('ALM.CENTRO')
                                            ->where('COD_CENTRO', $centro_id)
                                            ->first();
                $centro                 =   $centrot->NOM_CENTRO;

                $txttrabajador          =   '';
                $codtrabajador          =   '';
                $doctrabajador          =   '';
                $fecha_creacion         =   $this->hoy;
                $dtrabajador            =   STDTrabajador::where('COD_TRAB','=',Session::get('usuario')->usuarioosiris_id)->first();
                if(count($dtrabajador)>0){
                    $txttrabajador      =   $dtrabajador->TXT_APE_PATERNO.' '.$dtrabajador->TXT_APE_MATERNO.' '.$dtrabajador->TXT_NOMBRES;
                    $doctrabajador      =   $dtrabajador->NRO_DOCUMENTO;
                    $codtrabajador      =   $dtrabajador->COD_TRAB;;
                }
                $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
                $detplanillamovilidad   =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->get();
                $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $item                   =   count($detplanillamovilidad) + 1;
                $motivo                 =   CMPCategoria::where('COD_CATEGORIA','=',$motivo_id)->first();

                $departamentollegada_id =   $request['departamentollegada_id'];
                $provinciallegada_id    =   $request['provinciallegada_id']; 
                $distritollegada_id     =   $request['distritollegada_id'];

                $departamentopartida_id =   $request['departamentopartida_id'];
                $provinciapartida_id    =   $request['provinciapartida_id']; 
                $distritopartida_id     =   $request['distritopartida_id'];

                $departamentopartida    =   CMPCategoria::where('COD_CATEGORIA','=',$departamentopartida_id)->first();
                $provinciapartida       =   CMPCategoria::where('COD_CATEGORIA','=',$provinciapartida_id)->first();
                $distritopartida        =   CMPCategoria::where('COD_CATEGORIA','=',$distritopartida_id)->first();

                $departamentollegada    =   CMPCategoria::where('COD_CATEGORIA','=',$departamentollegada_id)->first();
                $provinciallegada       =   CMPCategoria::where('COD_CATEGORIA','=',$provinciallegada_id)->first();
                $distritollegada        =   CMPCategoria::where('COD_CATEGORIA','=',$distritollegada_id)->first();


                $cabecera                           =   new PlaDetMovilidad;
                $cabecera->ID_DOCUMENTO             =   $planillamovilidad->ID_DOCUMENTO;
                $cabecera->ITEM                     =   $item;
                $cabecera->FECHA_GASTO              =   $fecha_gasto;
                $cabecera->COD_MOTIVO               =   $motivo->COD_CATEGORIA;
                $cabecera->TXT_MOTIVO               =   $motivo->NOM_CATEGORIA;
                $cabecera->TXT_LUGARPARTIDA         =   $lugarpartida;
                $cabecera->TXT_LUGARLLEGADA         =   $lugarllegada;
                $cabecera->COD_EMPRESA              =   Session::get('empresas')->COD_EMPR;
                $cabecera->TXT_EMPRESA              =   Session::get('empresas')->NOM_EMPR;
                $cabecera->COD_CENTRO               =   $centrot->COD_CENTRO;
                $cabecera->TXT_CENTRO               =   $centrot->NOM_CENTRO;
                $cabecera->IGV                      =   0;
                $cabecera->SUBTOTAL                 =   $total;
                $cabecera->TOTAL                    =   $total;


                $cabecera->COD_DEPARTAMENTO_PARTIDA =   $departamentopartida->COD_CATEGORIA;
                $cabecera->TXT_DEPARTAMENTO_PARTIDA =   $departamentopartida->NOM_CATEGORIA;
                $cabecera->COD_PROVINCIA_PARTIDA    =   $provinciapartida->COD_CATEGORIA;
                $cabecera->TXT_PROVINCIA_PARTIDA    =   $provinciapartida->NOM_CATEGORIA;
                $cabecera->COD_DISTRITO_PARTIDA     =   $distritopartida->COD_CATEGORIA;
                $cabecera->TXT_DISTRITO_PARTIDA     =   $distritopartida->NOM_CATEGORIA;

                $cabecera->COD_DEPARTAMENTO_LLEGADA =   $departamentollegada->COD_CATEGORIA;
                $cabecera->TXT_DEPARTAMENTO_LLEGADA =   $departamentollegada->NOM_CATEGORIA;
                $cabecera->COD_PROVINCIA_LLEGADA    =   $provinciallegada->COD_CATEGORIA;
                $cabecera->TXT_PROVINCIA_LLEGADA    =   $provinciallegada->NOM_CATEGORIA;
                $cabecera->COD_DISTRITO_LLEGADA     =   $distritollegada->COD_CATEGORIA;
                $cabecera->TXT_DISTRITO_LLEGADA     =   $distritollegada->NOM_CATEGORIA;

                $cabecera->FECHA_CREA               =   $this->fechaactual;
                $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                $cabecera->save();


                $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)
                            ->update(
                                    [
                                        'TOTAL'=> $tdetplanillamovilidad->SUM('TOTAL'),
                                    ]);


            DB::commit();
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }
            return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('bienhecho', 'Se Agrego un nuevo item con exito');
    }


    public function actionExtornarPlanillaMovilidad($idopcion,$iddocumento,Request $request)
    {

        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'PLAM');
        View::share('titulo','Extonnar Planilla Movilidad');
        $planillamovilidad = PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first();
        if($planillamovilidad->COD_ESTADO!='ETM0000000000001'){
            return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('errorbd', 'Ya no puede extornar esta PLANILLA DE MOVILIDAD');
        }
        $planillamovilidad->ACTIVO = 0;
        $planillamovilidad->save();

        DB::table('PLA_DETMOVILIDAD')
            ->where('ID_DOCUMENTO', $iddocumento) // Reemplaza con el valor real
            ->update(['ACTIVO' => 0]);
        
        return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('bienhecho', 'Se extorno la PLANILLA DE MOVILIDAD ');

    }

    public function actionModificarPlanillaMovilidad($idopcion,$iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'PLAM');
        View::share('titulo','Agregar Detalle Planilla Movilidad');
        $planillamovilidad = PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $periodo_pm = CONPeriodo::where('COD_PERIODO','=',$planillamovilidad->COD_PERIODO)->first();


        if($planillamovilidad->COD_ESTADO!='ETM0000000000001'){
            return Redirect::to('gestion-de-planilla-movilidad/'.$idopcion)->with('errorbd', 'Ya no puede modificar esta PLANILLA DE MOVILIDAD');
        }

        $anio           =   $this->anio;
        $mes            =   $this->mes;
        $periodo        =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
        $trabajador     =   DB::table('STD.TRABAJADOR')
                            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                            ->first();
        $dni            =       '';
        $centro_id      =       '';
        if(count($trabajador)>0){
            $dni        =       $trabajador->NRO_DOCUMENTO;
        }
        $trabajadorespla    =   DB::table('WEB.platrabajadores')
                                ->where('situacion_id', 'PRMAECEN000000000002')
                                ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                ->where('dni', $dni)
                                ->first();
        if(count($trabajador)>0){
            $centro_id      =       $trabajadorespla->centro_osiris_id;
        }
        if($centro_id == 'CEN0000000000003'){
            $centro_id = 'CEN0000000000001';
        }

        if (Session::get('usuario')->id == '1CIX00000040') {
            $centro_id = 'CEN0000000000001';
        }

        if (Session::get('usuario')->id == '1CIX00000380') {
            $centro_id = 'CEN0000000000002';
        }
        if (Session::get('usuario')->id == '1CIX00000391') {
            $centro_id = 'CEN0000000000002';
        }

        $serie          =   $this->gn_serie($anio, $mes,$centro_id);
        $numero         =   $this->gn_numero($serie,$centro_id);

        $centrot        =   DB::table('ALM.CENTRO')
                            ->where('COD_CENTRO', $centro_id)
                            ->first();
        $centro         =   $centrot->NOM_CENTRO;

        $txttrabajador  =   '';
        $doctrabajador  =   '';
        $fecha_creacion =   $this->hoy;
        $dtrabajador    =   STDTrabajador::where('COD_TRAB','=',Session::get('usuario')->usuarioosiris_id)->first();
        if(count($dtrabajador)>0){
            $txttrabajador  =   $dtrabajador->TXT_APE_PATERNO.' '.$dtrabajador->TXT_APE_MATERNO.' '.$dtrabajador->TXT_NOMBRES;
            $doctrabajador  =   $dtrabajador->NRO_DOCUMENTO;
        }
        $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->orderby('FECHA_GASTO','asc')->orderby('ITEM','asc')->get();
        $combots                =   array('' => "SELECCIONE TIPO SOLICUTUD",'REEMBOLSO' => "REEMBOLSO",'RENDICION' => "RENDICIÓN");
        $combousuario           =   $this->gn_combo_usuarios();

        return View::make('planillamovilidad.modificarplanillamovilidad',
                         [
                            'periodo' => $periodo,
                            'serie' => $serie,
                            'numero' => $numero,
                            'centro' => $centro,
                            'txttrabajador' => $txttrabajador,
                            'combots'  =>  $combots,
                            'combousuario' =>  $combousuario,
                            'doctrabajador' => $doctrabajador,
                            'fecha_creacion' => $fecha_creacion,
                            'planillamovilidad' => $planillamovilidad,
                            'tdetplanillamovilidad' => $tdetplanillamovilidad,
                            'periodo_pm' => $periodo_pm,
                            'idopcion' => $idopcion
                         ]);

    }

    public function actionSelectComboProvinciaPartida(Request $request) {

        $departamentopartida_id         =       $request['departamentopartida_id'];
        $comboprovincia                 =       $this->gn_generacion_combo_categoria_xid('PROVINCIA','Seleccione Provincia','',$departamentopartida_id); 
        $provincia_id                   =       '';
        return View::make('general/ajax/comboprovinciapartida',
                         [
                            'comboprovincia'           =>  $comboprovincia,
                            'provincia_id'             =>  $provincia_id,
                            'ajax'                     =>  true,
                         ]);
    }

    public function actionSelectComboDistritoPartida(Request $request) {

        $departamentopartida_id         =       $request['departamentopartida_id'];
        $provinciapartida_id            =       $request['provinciapartida_id'];
        $combodistrito                 =       $this->gn_generacion_combo_categoria_xid('DISTRITO','Seleccione Distrito','',$provinciapartida_id); 
        $distrito_id                   =       '';
        return View::make('general/ajax/combodistritopartida',
                         [
                            'combodistrito'           =>  $combodistrito,
                            'distrito_id'             =>  $distrito_id,
                            'ajax'                     =>  true,
                         ]);
    }

    public function actionSelectComboProvinciaLlegada(Request $request) {

        $departamentollegada_id         =       $request['departamentollegada_id'];
        $comboprovinciall                 =       $this->gn_generacion_combo_categoria_xid('PROVINCIA','Seleccione Provincia','',$departamentollegada_id); 
        $provincia_idll                   =       '';
        return View::make('general/ajax/comboprovinciallegada',
                         [
                            'comboprovinciall'           =>  $comboprovinciall,
                            'provincia_idll'             =>  $provincia_idll,
                            'ajax'                     =>  true,
                         ]);
    }

    public function actionSelectComboDistritoLlegada(Request $request) {

        $departamentollegada_id         =       $request['departamentollegada_id'];
        $provinciallegada_id            =       $request['provinciallegada_id'];
        $combodistritoll                 =       $this->gn_generacion_combo_categoria_xid('DISTRITO','Seleccione Distrito','',$provinciallegada_id); 
        $distrito_idll                   =       '';
        return View::make('general/ajax/combodistritollegada',
                         [
                            'combodistritoll'           =>  $combodistritoll,
                            'distrito_idll'             =>  $distrito_idll,
                            'ajax'                     =>  true,
                         ]);
    }



    public function actionDetallePlanillaMovilidad(Request $request) {

        $iddocumento        =       $request['data_planilla_movilidad_id'];
        $idopcion           =       $request['idopcion'];

        $planillamovilidad  =       PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
        $funcion            =       $this;
        $fecha_fin          =       $this->fecha_sin_hora;

        $arraymotivo        =       DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','MOTIVO_MOVILIDAD')->where('COD_ESTADO','=','1')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combomotivo        =       array('' => "SELECCIONE MOTIVO") + $arraymotivo;
        $motivo_id          =       '';

        $combodepartamento  =       $this->gn_generacion_combo_categoria('DEPARTAMENTO','Seleccione Departamento',''); 
        $comboprovincia     =       array();
        $combodistrito      =       array();

        $departamento_id    =       '';
        $provincia_id       =       '';
        $distrito_id        =       '';
        

        $combodepartamentoll=       $this->gn_generacion_combo_categoria('DEPARTAMENTO','Seleccione Departamento',''); 
        $comboprovinciall   =       array();
        $combodistritoll    =       array();

        $departamento_idll  =       '';
        $provincia_idll     =       '';
        $distrito_idll      =       '';



        $departureQuery = DB::table('PLA_DETMOVILIDAD')
            ->select(
                'TXT_LUGARPARTIDA as location',
                'COD_DEPARTAMENTO_PARTIDA as department_code',
                'TXT_DEPARTAMENTO_PARTIDA as department_name',
                'COD_PROVINCIA_PARTIDA as province_code',
                'TXT_PROVINCIA_PARTIDA as province_name',
                'COD_DISTRITO_PARTIDA as district_code',
                'TXT_DISTRITO_PARTIDA as district_name'
            )
            ->where('USUARIO_CREA', Session::get('usuario')->id)
            ->where('ACTIVO', 1)
            ->groupBy(
                'TXT_LUGARPARTIDA',
                'COD_DEPARTAMENTO_PARTIDA',
                'TXT_DEPARTAMENTO_PARTIDA',
                'COD_PROVINCIA_PARTIDA',
                'TXT_PROVINCIA_PARTIDA',
                'COD_DISTRITO_PARTIDA',
                'TXT_DISTRITO_PARTIDA'
            );

        $arrivalQuery = DB::table('PLA_DETMOVILIDAD')
            ->select(
                'TXT_LUGARLLEGADA as location',
                'COD_DEPARTAMENTO_LLEGADA as department_code',
                'TXT_DEPARTAMENTO_LLEGADA as department_name',
                'COD_PROVINCIA_LLEGADA as province_code',
                'TXT_PROVINCIA_LLEGADA as province_name',
                'COD_DISTRITO_LLEGADA as district_code',
                'TXT_DISTRITO_LLEGADA as district_name'
            )
            ->where('USUARIO_CREA', Session::get('usuario')->id)
            ->where('ACTIVO', 1)
            ->groupBy(
                'TXT_LUGARLLEGADA',
                'COD_DEPARTAMENTO_LLEGADA',
                'TXT_DEPARTAMENTO_LLEGADA',
                'COD_PROVINCIA_LLEGADA',
                'TXT_PROVINCIA_LLEGADA',
                'COD_DISTRITO_LLEGADA',
                'TXT_DISTRITO_LLEGADA'
            );

        $ldirecciones = $departureQuery->union($arrivalQuery)->get();


        //dd($ldirecciones);
        return View::make('planillamovilidad/modal/ajax/magregardetalleplanillamovilidad',
                         [
                            'iddocumento'           =>  $iddocumento,
                            'idopcion'              =>  $idopcion,
                            'planillamovilidad'     =>  $planillamovilidad,
                            'fecha_fin'             =>  $fecha_fin,
                            'funcion'               =>  $funcion,
                            'combomotivo'           =>  $combomotivo,
                            'motivo_id'             =>  $motivo_id,
                            'ldirecciones'          =>  $ldirecciones,

                            'combodepartamento'     =>  $combodepartamento,
                            'comboprovincia'        =>  $comboprovincia,
                            'combodistrito'         =>  $combodistrito,
                            'departamento_id'       =>  $departamento_id,
                            'provincia_id'          =>  $provincia_id,
                            'distrito_id'           =>  $distrito_id,

                            'combodepartamentoll'   =>  $combodepartamentoll,
                            'comboprovinciall'      =>  $comboprovinciall,
                            'combodistritoll'       =>  $combodistritoll,
                            'departamento_idll'     =>  $departamento_idll,
                            'provincia_idll'        =>  $provincia_idll,
                            'distrito_idll'         =>  $distrito_idll,

                            'ajax'                  =>  true,
                         ]);
    }

    public function actionModificarDetallePlanillaMovilidad(Request $request) {

        $iddocumento        =       $request['data_iddocumento'];
        $data_item          =       $request['data_item'];
        $idopcion           =       $request['idopcion'];
        $planillamovilidad  =       PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
        $dplanillamovilidad =       PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$data_item)->first(); 
        $motivo_id          =       $dplanillamovilidad->COD_MOTIVO;
        $funcion            =       $this;
        $fecha_fin          =       $this->fecha_sin_hora;
        $arraymotivo        =       DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','MOTIVO_MOVILIDAD')->where('COD_ESTADO','=','1')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combomotivo        =       array('' => "SELECCIONE MOTIVO") + $arraymotivo;
        $comboestado        =       array('1' => "ACTIVO",'0' => "ELIMINAR");
        $activo             =       $dplanillamovilidad->ACTIVO;

        $combodepartamento  =       $this->gn_generacion_combo_categoria('DEPARTAMENTO','Seleccione Departamento',''); 
        $departamento_id    =       $dplanillamovilidad->COD_DEPARTAMENTO_PARTIDA;
        $comboprovincia     =       $this->gn_generacion_combo_categoria_xid('PROVINCIA','Seleccione Provincia','',$departamento_id); 
        $provincia_id       =       $dplanillamovilidad->COD_PROVINCIA_PARTIDA;
        $combodistrito      =       $this->gn_generacion_combo_categoria_xid('DISTRITO','Seleccione Distrito','',$provincia_id); 
        $distrito_id        =       $dplanillamovilidad->COD_DISTRITO_PARTIDA;


        $combodepartamentoll=       $this->gn_generacion_combo_categoria('DEPARTAMENTO','Seleccione Departamento',''); 
        $departamento_idll  =       $dplanillamovilidad->COD_DEPARTAMENTO_LLEGADA;
        $comboprovinciall   =       $this->gn_generacion_combo_categoria_xid('PROVINCIA','Seleccione Provincia','',$departamento_idll); 
        $provincia_idll     =       $dplanillamovilidad->COD_PROVINCIA_LLEGADA;
        $combodistritoll    =       $this->gn_generacion_combo_categoria_xid('DISTRITO','Seleccione Distrito','',$provincia_idll); 
        $distrito_idll      =       $dplanillamovilidad->COD_DISTRITO_LLEGADA;


        $departureQuery = DB::table('PLA_DETMOVILIDAD')
            ->select(
                'TXT_LUGARPARTIDA as location',
                'COD_DEPARTAMENTO_PARTIDA as department_code',
                'TXT_DEPARTAMENTO_PARTIDA as department_name',
                'COD_PROVINCIA_PARTIDA as province_code',
                'TXT_PROVINCIA_PARTIDA as province_name',
                'COD_DISTRITO_PARTIDA as district_code',
                'TXT_DISTRITO_PARTIDA as district_name'
            )
            ->where('USUARIO_CREA', Session::get('usuario')->id)
            ->where('ACTIVO', 1)
            ->groupBy(
                'TXT_LUGARPARTIDA',
                'COD_DEPARTAMENTO_PARTIDA',
                'TXT_DEPARTAMENTO_PARTIDA',
                'COD_PROVINCIA_PARTIDA',
                'TXT_PROVINCIA_PARTIDA',
                'COD_DISTRITO_PARTIDA',
                'TXT_DISTRITO_PARTIDA'
            );

        $arrivalQuery = DB::table('PLA_DETMOVILIDAD')
            ->select(
                'TXT_LUGARLLEGADA as location',
                'COD_DEPARTAMENTO_LLEGADA as department_code',
                'TXT_DEPARTAMENTO_LLEGADA as department_name',
                'COD_PROVINCIA_LLEGADA as province_code',
                'TXT_PROVINCIA_LLEGADA as province_name',
                'COD_DISTRITO_LLEGADA as district_code',
                'TXT_DISTRITO_LLEGADA as district_name'
            )
            ->where('USUARIO_CREA', Session::get('usuario')->id)
            ->where('ACTIVO', 1)
            ->groupBy(
                'TXT_LUGARLLEGADA',
                'COD_DEPARTAMENTO_LLEGADA',
                'TXT_DEPARTAMENTO_LLEGADA',
                'COD_PROVINCIA_LLEGADA',
                'TXT_PROVINCIA_LLEGADA',
                'COD_DISTRITO_LLEGADA',
                'TXT_DISTRITO_LLEGADA'
            );

        $ldirecciones       = $departureQuery->union($arrivalQuery)->get();

        return View::make('planillamovilidad/modal/ajax/magregardetalleplanillamovilidad',
                         [
                            'iddocumento'           =>  $iddocumento,
                            'idopcion'              =>  $idopcion,
                            'planillamovilidad'     =>  $planillamovilidad,
                            'dplanillamovilidad'    =>  $dplanillamovilidad,
                            'fecha_fin'             =>  $fecha_fin,
                            'funcion'               =>  $funcion,
                            'combomotivo'           =>  $combomotivo,
                            'motivo_id'             =>  $motivo_id,
                            'comboestado'           =>  $comboestado,
                            'ldirecciones'          =>  $ldirecciones,

                            'combodepartamento'     =>  $combodepartamento,
                            'departamento_id'       =>  $departamento_id,
                            'comboprovincia'        =>  $comboprovincia,
                            'provincia_id'          =>  $provincia_id,
                            'combodistrito'         =>  $combodistrito,
                            'distrito_id'           =>  $distrito_id,
                            'combodepartamentoll'   =>  $combodepartamentoll,
                            'departamento_idll'     =>  $departamento_idll,
                            'comboprovinciall'      =>  $comboprovinciall,
                            'provincia_idll'        =>  $provincia_idll,
                            'combodistritoll'       =>  $combodistritoll,
                            'distrito_idll'         =>  $distrito_idll,





                            'activo'                =>  $activo,
                            'ajax'                  =>  true,
                         ]);
    }




}
