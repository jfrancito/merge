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

use App\Modelos\DetalleSemanaImpulso;
use App\Modelos\ConfiguracionImpulso;
use App\Modelos\SemanaImpulso;

use App\Modelos\FePlanillaEntregable;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\Archivo;

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

class GestionPlanillaMovilidadImpulsoController extends Controller
{
    use GeneralesTraits;
    use PlanillaTraits;
    use ComprobanteTraits;

    public function actionListarPlanillaMovilidadImpulso($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Movilidad Impulso');
        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        $fecha_inicio       =   $this->fecha_menos_diez_dias;
        $fecha_fin          =   $this->fecha_sin_hora;
        $planillamovilidad  =   array();
        $listadatos         =   array();
        $funcion            =   $this;

        return View::make('planillamovilidadimpulso/listamovilidadimpulso',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'planillamovilidad' =>  $planillamovilidad,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin
                         ]);
    }


    public function actionAgregarMovilidadImpulso($idopcion,Request $request)
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
                    $trabajador     =   DB::table('STD.TRABAJADOR')
                                        ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                                        ->first();
                    $dni            =   '';
                    $centro_id      =   '';
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
                    $idcab                              =   $this->funciones->getCreateIdMaestradocpla('SEMANA_IMPULSO','SEMI');


                    $semana_id                          =   $request['semana_id'];



    [ID_DOCUMENTO] [varchar](20) NOT NULL,
    [ANIO] [varchar](20) NULL,
    [NRO_SEMANA] INT NULL,
    [FECHA_INICIO] [date] NULL,
    [FECHA_FIN] [date] NULL,
    [COD_EMPRESA] [varchar](20) NULL,
    [TXT_EMPRESA] [varchar](200) NULL,
    [COD_EMPRESA_TRABAJADOR] [varchar](20) NULL,
    [TXT_EMPRESA_TRABAJADOR] [varchar](1000) NULL,
    [MONTO] [decimal](18, 2) NULL,
    [COD_ESTADO] [varchar](20) NULL,
    [TXT_ESTADO] [varchar](200) NULL,
    [ACTIVO] [int] NOT NULL DEFAULT ((1)),
    [FECHA_CREA] [datetime] NOT NULL,
    [USUARIO_CREA] [varchar](20) NOT NULL,
    [FECHA_MOD] [datetime] NULL,
    [USUARIO_MOD] [varchar](20) NULL

                    $cabecera                           =   new SemanaImpulso;
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
                return Redirect::to('gestion-movilidad-impulso/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
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
                return Redirect::to('gestion-movilidad-impulso/'.$idopcion)->with('errorbd', 'No puede realizar un registro porque no es la empresa a cual pertenece');
            }

            $dtrabajador    =   STDTrabajador::where('COD_TRAB','=',Session::get('usuario')->usuarioosiris_id)->first();
            if (is_null($centro_id)) {
                $trabajadoresplasc    =     DB::table('WEB.platrabajadores')
                                            ->where('situacion_id', 'PRMAECEN000000000002')
                                            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                                            ->where('dni', $dni)
                                            ->first();
                if(count($trabajadoresplasc)>0){
                    return Redirect::to('gestion-movilidad-impulso/'.$idopcion)->with('errorbd', 'El trabajador '.$dtrabajador->TXT_APE_PATERNO.' '.$dtrabajador->TXT_APE_MATERNO.' '.$dtrabajador->TXT_NOMBRES. 'tiene una SEDE no identificada '.$trabajadoresplasc->cadlocal);
                }else{
                    return Redirect::to('gestion-movilidad-impulso/'.$idopcion)->with('errorbd', 'El trabajador no esta en planilla');
                }
            }
            $area_id = $trabajadorespla->area_id;
            $area_id = 'PRMAECEN000000000155';//ELIMINAR
            $configuracion      =   DB::table('CONFIGURACION_IMPULSO')
                                    ->where('AREA_ID', $area_id)
                                    ->where('ACTIVO', 1)
                                    ->where('CENTRO_ID', $centro_id)
                                    ->get();

            if(count($configuracion)<=0){
                return Redirect::to('gestion-movilidad-impulso/'.$idopcion)->with('errorbd', 'No existe Configuracion de Impulso Para este Trabajador');
            }


            $combosemana                 =       $this->gn_generacion_combo_semana("Seleccione Semana",""); 
            $semana_id                   =       '';
            $fecha_creacion =   $this->hoy;


            return View::make('planillamovilidadimpulso.agregarmovilidadimpulso',
                             [
                                'combosemana' => $combosemana,
                                'semana_id' => $semana_id,
                                'fecha_creacion' => $fecha_creacion,
                                'idopcion' => $idopcion
                             ]);
        }   
    }




}
