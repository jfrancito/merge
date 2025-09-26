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
use App\Traits\CuartaCategoriaTraits;
use App\Traits\ComprobanteTraits;



use Hashids;
use SplFileInfo;
use Excel;

class GestionCuartaCategoriaController extends Controller
{
    use GeneralesTraits;
    use CuartaCategoriaTraits;
    use ComprobanteTraits;

    public function actionAgregarCuartaCategoria($idopcion,Request $request)
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

                    if($centro_id == 'CEN0000000000003'){
                        $centro_id = 'CEN0000000000001';
                    }

                    if (Session::get('usuario')->id == '1CIX00000040') {
                        $centro_id = 'CEN0000000000001';
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
            $empresa_id     =   "";
            $combo_empresa  =   array();

            $tarchivos      =   CMPCategoria::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->where('COD_ESTADO','=',1)
                                        ->whereIn('TXT_FORMATO', ['PDF'])
                                        ->get();


            return View::make('cuartacategoria.agregarcuartacategoria',
                             [


                                'empresa_id' => $empresa_id,
                                'combo_empresa' => $combo_empresa,


                                'idopcion' => $idopcion
                             ]);
        }   
    }


    public function actionListarSuspensionCuarta($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Renta 4ta Categoria');
        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;

        $lrentacuartacategoria  =   $this->pla_lista_renta_cuarta_categoria();
        $funcion            =   $this;

        return View::make('cuartacategoria/listacuartacategoria',
                         [
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                            'lrentacuartacategoria' =>  $lrentacuartacategoria,
                         ]);
    }

}
