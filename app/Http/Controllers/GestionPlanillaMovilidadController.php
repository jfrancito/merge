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

use Hashids;
use SplFileInfo;
use Excel;

class GestionPlanillaMovilidadController extends Controller
{
    use GeneralesTraits;
    use PlanillaTraits;


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

        $planillamovilidad  =   PlaMovilidad::where('ACTIVO','=','1')
                                ->whereRaw("CAST(FECHA_CREA  AS DATE) >= ? and CAST(FECHA_CREA  AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                ->orderby('FECHA_CREA','DESC')->get();

        $listadatos     =   array();
        $funcion        =   $this;
        return View::make('planillamovilidad/listaplanillamovilidad',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'planillamovilidad' =>  $planillamovilidad,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin
                         ]);
    }


    public function actionEmitirDetallePlanillaMovilidad($idopcion,$iddocumento,Request $request)
    {
        $idcab       = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'PLAM');

        if($_POST)
        {

            try{    
                DB::beginTransaction();
                $planillamovilidad      =   PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
                $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();

                if(count($tdetplanillamovilidad)<=0){
                    return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd','Para poder emitir tiene que cargar sus movilidades');
                }

                PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)
                            ->update(
                                    [
                                        'FECHA_EMI'=> $this->fechaactual,
                                        'TIPO_SUSTENTO'=> $request['tipo_solicitud'],
                                        'FECHA_MOD'=> $this->fechaactual,
                                        'USUARIO_MOD'=> Session::get('usuario')->id,
                                        'COD_ESTADO'=> 'ETM0000000000008',
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
                    if(count($trabajador)>0){
                        $centro_id      =       $trabajadorespla->centro_osiris_id;
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
                        $codtrabajador  =   $dtrabajador->COD_TRAB;;
                    }
                    $idcab                              =   $this->funciones->getCreateIdMaestradocpla('PLA_MOVILIDAD','PLAM');
                    $codigo                             =   $this->funciones->generar_codigo('PLA_MOVILIDAD',8);

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


            $periodo        =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
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


            return View::make('planillamovilidad.agregarplanillamovilidad',
                             [
                                'periodo' => $periodo,
                                'serie' => $serie,
                                'numero' => $numero,
                                'centro' => $centro,
                                'txttrabajador' => $txttrabajador,
                                'doctrabajador' => $doctrabajador,
                                'fecha_creacion' => $fecha_creacion,
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
                $anio                   =   $this->anio;
                $mes                    =   $this->mes;
                $periodo                =   $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
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
                $cabecera->FECHA_CREA               =   $this->fechaactual;
                $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                $cabecera->save();

                PlaMovilidad::where('ID_DOCUMENTO','=',$planillamovilidad->ID_DOCUMENTO)
                            ->update(
                                    [
                                        'TOTAL'=> $tdetplanillamovilidad->SUM('TOTAL') + $total,
                                        'TOTAL'=> $tdetplanillamovilidad->SUM('SUBTOTAL') + $total
                                    ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }
            return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('bienhecho', 'Se Agrego un nuevo item con exito');
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
        $tdetplanillamovilidad  =   PlaDetMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->orderby('FECHA_GASTO','asc')->get();
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
                            'idopcion' => $idopcion
                         ]);

    }

    public function actionDetallePlanillaMovilidad(Request $request) {

        $iddocumento        =       $request['data_planilla_movilidad_id'];
        $idopcion           =       $request['idopcion'];

        $planillamovilidad  =       PlaMovilidad::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
        $funcion            =       $this;
        $fecha_fin          =       $this->fecha_sin_hora;

        $arraymotivo        =       DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','MOTIVO_MOVILIDAD')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combomotivo        =       array('' => "SELECCIONE MOTIVO") + $arraymotivo;
        $motivo_id          =       '';

        return View::make('planillamovilidad/modal/ajax/magregardetalleplanillamovilidad',
                         [
                            'iddocumento'           =>  $iddocumento,
                            'idopcion'              =>  $idopcion,
                            'planillamovilidad'     =>  $planillamovilidad,
                            'fecha_fin'             =>  $fecha_fin,
                            'funcion'               =>  $funcion,
                            'combomotivo'           =>  $combomotivo,
                            'motivo_id'             =>  $motivo_id,
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
        $arraymotivo        =       DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','MOTIVO_MOVILIDAD')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
        $combomotivo        =       array('' => "SELECCIONE MOTIVO") + $arraymotivo;
        $comboestado        =       array('1' => "ACTIVO",'0' => "ELIMINAR");
        $activo             =       $dplanillamovilidad->ACTIVO;


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


                            'activo'                =>  $activo,

                            'ajax'                  =>  true,
                         ]);
    }




}
