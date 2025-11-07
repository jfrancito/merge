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
use App\Modelos\ALMCentro;
use App\Modelos\LqgDocumentoHistorial;
use App\Modelos\LoteImpulso;

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
use DateTime;
use Carbon\Carbon;

class GestionPlanillaMovilidadImpulsoController extends Controller
{
    use GeneralesTraits;
    use PlanillaTraits;
    use ComprobanteTraits;

    public function actionAgregarExtornoJefe($idopcion, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $idordencompra;
        $iddocumento = $this->funciones->decodificarmaestrapre($idordencompra, 'SEMI');
        View::share('titulo', 'Extornar Movilidad Impulso');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $semanaimpulso = SemanaImpulso::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                $tdetliquidaciongastos = DetalleSemanaImpulso::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
                $descripcion = $request['descripcionextorno'];

                SemanaImpulso::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'IND_OBSERVACION' => 1,
                            'COD_ESTADO' => 'ETM0000000000001',
                            'TXT_ESTADO' => 'GENERADO'
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO = $semanaimpulso->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = 1;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR JEFE';
                $documento->MENSAJE = $descripcion;
                $documento->save();


                DB::commit();
                return Redirect::to('gestion-de-aprobacion-movilidad-impulso-jefe/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $semanaimpulso->ID_DOCUMENTO . ' OBSERVADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-aprobacion-movilidad-impulso-jefe/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }

    }




    public function actionAprobarJefeMV($idopcion, $iddocumento, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'SEMI');
        View::share('titulo', 'Aprobar Movilidad Impulso Jefe');

        if ($_POST) {
            try {

                DB::beginTransaction();

                $liquidaciongastos = SemanaImpulso::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                $tdetliquidaciongastos = DetalleSemanaImpulso::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();


                if ($liquidaciongastos->IND_OBSERVACION == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }


                $descripcion = $request['descripcion'];
                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = 1;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'ACOTACION POR EL JEFE';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();
                }

                SemanaImpulso::where('ID_DOCUMENTO', $liquidaciongastos->ID_DOCUMENTO)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADO',
                            'FECHA_MOD'=> $this->fechaactual,
                            'USUARIO_MOD'=> Session::get('usuario')->id
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = 1;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR EL JEFE';
                $documento->MENSAJE = '';
                $documento->save();

                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-movilidad-impulso-jefe/' . $idopcion)->with('bienhecho', 'Liquidacion de Gastos : ' . $liquidaciongastos->ID_DOCUMENTO . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('/gestion-de-aprobacion-movilidad-impulso-jefe/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        } else {

            $semanaimpulso          = SemanaImpulso::where('ID_DOCUMENTO', '=', $iddocumento)->first();
            $detallesemanaimpulso   = DetalleSemanaImpulso::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
            $documentohistorial     = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();

            $indicador              = 0;

            //ASIGNADO
            $datos              =   DB::table('SEMANA_IMPULSO')
                                    ->join('DETALLE_SEMANA_IMPULSO', 'SEMANA_IMPULSO.ID_DOCUMENTO', '=', 'DETALLE_SEMANA_IMPULSO.ID_DOCUMENTO')
                                    ->where('DETALLE_SEMANA_IMPULSO.TIPO', 'ASIGNADO')
                                    ->select('DETALLE_SEMANA_IMPULSO.*','SEMANA_IMPULSO.TXT_EMPRESA_TRABAJADOR','SEMANA_IMPULSO.FECHA_INICIO','SEMANA_IMPULSO.FECHA_FIN')
                                    ->where('SEMANA_IMPULSO.ID_DOCUMENTO','=',$iddocumento)
                                    ->get();

            // Agrupar por ID_DOCUMENTO
            $datosAgrupados = $datos->groupBy('ID_DOCUMENTO')->map(function ($grupo) {
                $fila = [
                    'ID_DOCUMENTO' => $grupo->first()->ID_DOCUMENTO,
                    'TIPO' => $grupo->first()->TIPO,
                    'COD_CONFIGURACION' => $grupo->first()->COD_CONFIGURACION,
                    'COD_CATEGORIA_IMPULSO' => $grupo->first()->COD_CATEGORIA_IMPULSO,
                    'TXT_CATEGORIA_IMPULSO' => $grupo->first()->TXT_CATEGORIA_IMPULSO,
                    'TXT_PREFIJO_IMPULSO' => $grupo->first()->TXT_PREFIJO_IMPULSO,
                    'MONTO' => $grupo->first()->MONTO,
                    'ACTIVO' => $grupo->first()->ACTIVO,
                    'TXT_EMPRESA_TRABAJADOR' => $grupo->first()->TXT_EMPRESA_TRABAJADOR,
                    'FECHA_INICIO' => $grupo->first()->FECHA_INICIO,
                    'FECHA_FIN' => $grupo->first()->FECHA_FIN,

                    'dias' => []
                ];
                
                // Mapear días con sus fechas
                foreach ($grupo as $item) {
                    $nombreDia = $this->obtenerNombreDia($item->DIA);
                    $fila['dias'][$item->DIA] = [
                        'nombre' => $nombreDia,
                        'fecha' => $item->FECHA,
                        'data' => $item
                    ];
                }
                
                return $fila;
            });


            //ADICIONAL
            $datosadicional     =   DB::table('SEMANA_IMPULSO')
                                    ->join('DETALLE_SEMANA_IMPULSO', 'SEMANA_IMPULSO.ID_DOCUMENTO', '=', 'DETALLE_SEMANA_IMPULSO.ID_DOCUMENTO')
                                    ->where('DETALLE_SEMANA_IMPULSO.TIPO', 'ADICIONAL')
                                    ->select('DETALLE_SEMANA_IMPULSO.*','SEMANA_IMPULSO.TXT_EMPRESA_TRABAJADOR','SEMANA_IMPULSO.FECHA_INICIO','SEMANA_IMPULSO.FECHA_FIN')
                                    ->where('SEMANA_IMPULSO.ID_DOCUMENTO','=',$iddocumento)
                                    ->get();

            // Agrupar por ID_DOCUMENTO
            $datosAgrupadosadicional = $datosadicional->groupBy('ID_DOCUMENTO')->map(function ($grupo) {
                $fila = [
                    'ID_DOCUMENTO' => $grupo->first()->ID_DOCUMENTO,
                    'TIPO' => $grupo->first()->TIPO,
                    'COD_CONFIGURACION' => $grupo->first()->COD_CONFIGURACION,
                    'COD_CATEGORIA_IMPULSO' => $grupo->first()->COD_CATEGORIA_IMPULSO,
                    'TXT_CATEGORIA_IMPULSO' => $grupo->first()->TXT_CATEGORIA_IMPULSO,
                    'TXT_PREFIJO_IMPULSO' => $grupo->first()->TXT_PREFIJO_IMPULSO,
                    'MONTO' => $grupo->first()->MONTO,
                    'ACTIVO' => $grupo->first()->ACTIVO,
                    'TXT_EMPRESA_TRABAJADOR' => $grupo->first()->TXT_EMPRESA_TRABAJADOR,
                    'FECHA_INICIO' => $grupo->first()->FECHA_INICIO,
                    'FECHA_FIN' => $grupo->first()->FECHA_FIN,

                    'dias' => []
                ];
                // Mapear días con sus fechas
                foreach ($grupo as $item) {
                    $nombreDia = $this->obtenerNombreDia($item->DIA);
                    $fila['dias'][$item->DIA] = [
                        'nombre' => $nombreDia,
                        'fecha' => $item->FECHA,
                        'data' => $item
                    ];
                }
                return $fila;
            });




            return View::make('planillamovilidadimpulso/aprobarjefemv',
                [
                    'semanaimpulso' => $semanaimpulso,
                    'detallesemanaimpulso' => $detallesemanaimpulso,
                    'documentohistorial' => $documentohistorial,
                    'datosAgrupados' => $datosAgrupados,
                    'datosAgrupadosadicional' => $datosAgrupadosadicional,

                    'idopcion' => $idopcion,
                    'idcab' => $idcab,
                    'iddocumento' => $iddocumento
                ]);


        }
    }


    public function actionAprobarMovilidadImpulsoJefe($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista movilidad impulso (jefe)');
        $tab_id = 'oc';
        if (isset($request['tab_id'])) {
            $tab_id = $request['tab_id'];
        }

        $listadatos = $this->plm_lista_cabecera_comprobante_total_jefe();
        $listadatos_obs = $this->plm_lista_cabecera_comprobante_total_obs_jefe();
        $listadatos_obs_le = $this->plm_lista_cabecera_comprobante_total_obs_le_jefe();


        $funcion = $this;
        return View::make('planillamovilidadimpulso/listamovilidadimpulsojefe',
            [
                'listadatos' => $listadatos,
                'listadatos_obs' => $listadatos_obs,
                'listadatos_obs_le' => $listadatos_obs_le,
                'tab_id' => $tab_id,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
            ]);
    }


    public function actionEmitirDetalleMovilidadImpulso($idopcion,$iddocumento,Request $request)
    {
        $idcab       = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'SEMI');
        if($_POST)
        {
            try{ 
                DB::beginTransaction();
                $planillamovilidad      =   SemanaImpulso::where('ID_DOCUMENTO','=',$iddocumento)->first(); 
                if($planillamovilidad->MOMTO>0){
                    return Redirect::to('modificar-planilla-movilidad/'.$idopcion.'/'.$idcab)->with('errorbd','Para poder emitir el monto tiene que ser mayor que cero');
                }
                SemanaImpulso::where('ID_DOCUMENTO','=',$iddocumento)
                            ->update(
                                    [
                                        'FECHA_MOD'=> $this->fechaactual,
                                        'FECHA_EMI'=> $this->fechaactual,
                                        'USUARIO_MOD'=> Session::get('usuario')->id,
                                        'IND_OBSERVACION' => 0,
                                        'COD_ESTADO'=> 'ETM0000000000010',
                                        'TXT_ESTADO'=> 'POR APROBAR AUTORIZACION'
                                    ]);
                if ($planillamovilidad->IND_OBSERVACION == 1) {

                    $documento = new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $iddocumento;
                    $documento->DOCUMENTO_ITEM = 1;
                    $documento->FECHA = date_format(date_create(date('Ymd h:i:s')), 'Ymd h:i:s');
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'SE LEVANTARON LAS OBSERVACIONES';
                    $documento->MENSAJE = '';
                    $documento->save();


                }else{
                    $documento = new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $iddocumento;
                    $documento->DOCUMENTO_ITEM = 1;
                    $documento->FECHA = date_format(date_create(date('Ymd h:i:s')), 'Ymd h:i:s');
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'CREO MOVILIDAD DE IMPULSO';
                    $documento->MENSAJE = '';
                    $documento->save();
                }



                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('modificar-movilidad-impulso/'.$idopcion.'/'.$idcab)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-movilidad-impulso/'.$idopcion)->with('bienhecho', 'Movilidad Impulso'.$idcab.' emitido con exito, ingrese sus comprobantes');
        }  
    }


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
        $planillamovilidad  =   $this->pla_lista_planilla_movilidad_impulso_personal($fecha_inicio,$fecha_fin);
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

    public function actionListarPlanillaMovilidadImpulsoMasivo($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Movilidad Impulso');
        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        $fecha_inicio       =   $this->fecha_menos_diez_dias;
        $fecha_fin          =   $this->fecha_sin_hora;
        //$planillamovilidad  =   $this->pla_lista_planilla_movilidad_impulso_personal($fecha_inicio,$fecha_fin);
        $planillamovilidad  =   array();
        $listadatos         =   array();
        $funcion            =   $this;

        return View::make('planillamovilidadimpulso/listamovilidadimpulsomasivo',
                         [
                            'listadatos'        =>  $listadatos,
                            'funcion'           =>  $funcion,
                            'idopcion'          =>  $idopcion,
                            'planillamovilidad' =>  $planillamovilidad,
                            'fecha_inicio'      =>  $fecha_inicio,
                            'fecha_fin'         =>  $fecha_fin
                         ]);
    }


    public function actionAgregarMovilidadImpulsoMasivo($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/

        if($_POST)
        {

            try{    
                
                DB::beginTransaction();


                    $idcab              =   $this->funciones->getCreateIdMaestradocpla('LOTE_IMPULSO','LOIM');
                    $fecha_inicio       =   $request['fecha_inicio'];
                    $fecha_fin          =   $request['fecha_fin'];
                    // Convertir a objetos Carbon
                    $inicio = Carbon::parse($fecha_inicio);
                    $fin = Carbon::parse($fecha_fin);
                    // Extraer año y mes
                    $anio_inicio = $inicio->year;
                    $mes_inicio = $inicio->month;
                    $anio_fin = $fin->year;
                    $mes_fin = $fin->month;
                    // Validar que estén en el mismo periodo (mismo año y mes)
                    if (!($anio_inicio === $anio_fin && $mes_inicio === $mes_fin)) {
                        return Redirect::back()->withInput()->with('errorurl', 'Las fechas deben estar en el mismo periodo');
                    }

                    $anio               =   $inicio->year;
                    $mes                =   $inicio->month;

                    $cabecera                           =   new LoteImpulso;
                    $cabecera->ID_DOCUMENTO             =   $idcab;
                    $cabecera->ANIO                     =   $anio;
                    $cabecera->MES                      =   $mes;
                    $cabecera->FECHA_INICIO             =   $fecha_inicio;
                    $cabecera->FECHA_FIN                =   $fecha_fin;
                    $cabecera->COD_EMPRESA              =   Session::get('empresas')->COD_EMPR;
                    $cabecera->TXT_EMPRESA              =   Session::get('empresas')->NOM_EMPR;
                    $cabecera->MONTO                    =   0;
                    $cabecera->COD_ESTADO               =   'ETM0000000000001';
                    $cabecera->TXT_ESTADO               =   'GENERADO';
                    $cabecera->FECHA_CREA               =   $this->fechaactual;
                    $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                    $cabecera->save();

                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-movilidad-impulso-masivo/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
                $iddocumento                            =   Hashids::encode(substr($idcab, -8));
                return Redirect::to('modificar-movilidad-impulso-masivo/'.$idopcion.'/'.$iddocumento)->with('bienhecho', 'Movilidad Impulso '.$idcab.' registrado con exito, ingrese sus comprobantes');
        }else{

            $anio           =   $this->anio;
            $mes            =   $this->mes;
            $combosemana                 =       $this->gn_generacion_combo_semana("Seleccione Semana",""); 
            $semana_id                   =       '';
            $fecha_creacion              =       $this->hoy;
            $fecha_inicio                =       $this->fecha_sin_hora;
            $fecha_fin                   =       $this->fecha_sin_hora;

            return View::make('planillamovilidadimpulso.agregarmovilidadimpulsomasivo',
                             [
                                'combosemana'       => $combosemana,
                                'semana_id'         => $semana_id,
                                'fecha_creacion'    => $fecha_creacion,
                                'fecha_inicio'      => $fecha_inicio,
                                'fecha_fin'         => $fecha_fin,
                                'idopcion'          => $idopcion
                             ]);
        }   
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
                    if(count($trabajadorespla)>0){
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
                    $idcab              =   $this->funciones->getCreateIdMaestradocpla('SEMANA_IMPULSO','SEMI');
                    $fecha_inicio       =   $request['fecha_inicio'];
                    $fecha_fin          =   $request['fecha_fin'];
                    // Convertir a objetos Carbon
                    $inicio = Carbon::parse($fecha_inicio);
                    $fin = Carbon::parse($fecha_fin);
                    // Extraer año y mes
                    $anio_inicio = $inicio->year;
                    $mes_inicio = $inicio->month;
                    $anio_fin = $fin->year;
                    $mes_fin = $fin->month;
                    // Validar que estén en el mismo periodo (mismo año y mes)
                    if (!($anio_inicio === $anio_fin && $mes_inicio === $mes_fin)) {
                        return Redirect::back()->withInput()->with('errorurl', 'Las fechas deben estar en el mismo periodo');
                    }


                    $anio               =   $inicio->year;
                    $mes                =   $inicio->month;

                    $area_id            =   $request['area_id'];
                    $area_nombre        =   $request['area_nombre'];
                    $centro_id          =   $request['centro_id'];
                    $centro             =   ALMCentro::where('COD_CENTRO', '=', $centro_id)->first();


                    $cabecera                           =   new SemanaImpulso;
                    $cabecera->ID_DOCUMENTO             =   $idcab;
                    $cabecera->ANIO                     =   $anio;
                    $cabecera->MES                      =   $mes;
                    $cabecera->FECHA_INICIO             =   $fecha_inicio;
                    $cabecera->FECHA_FIN                =   $fecha_fin;
                    $cabecera->COD_EMPRESA              =   Session::get('empresas')->COD_EMPR;
                    $cabecera->TXT_EMPRESA              =   Session::get('empresas')->NOM_EMPR;
                    $cabecera->COD_EMPRESA_TRABAJADOR   =   $codtrabajador;
                    $cabecera->TXT_EMPRESA_TRABAJADOR   =   $txttrabajador;
                    $cabecera->AREA_ID                  =   $area_id;
                    $cabecera->AREA_TXT                 =   $area_nombre;
                    $cabecera->CENTRO_ID                =   $centro->COD_CENTRO;
                    $cabecera->CENTRO_TXT               =   $centro->NOM_CENTRO;
                    $cabecera->IND_OBSERVACION          =   0;
                    $cabecera->MONTO                    =   0;
                    $cabecera->COD_ESTADO               =   'ETM0000000000001';
                    $cabecera->TXT_ESTADO               =   'GENERADO';
                    $cabecera->FECHA_CREA               =   $this->fechaactual;
                    $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                    $cabecera->save();


                    $fechaInicio = new DateTime($fecha_inicio);
                    $fechaFin = new DateTime($fecha_fin);
                    $cont = 1;
                    // Recorremos día por día
                    while ($fechaInicio <= $fechaFin) {


                        $detalle                           =   new DetalleSemanaImpulso;
                        $detalle->ID_DOCUMENTO             =   $idcab;
                        $detalle->DIA                      =   $cont;
                        $detalle->FECHA                    =   $fechaInicio->format('Y-m-d');
                        $detalle->TIPO                     =   'ASIGNADO';
                        $detalle->MONTO                    =   0;
                        $detalle->FECHA_CREA               =   $this->fechaactual;
                        $detalle->USUARIO_CREA             =   Session::get('usuario')->id;
                        $detalle->save();

                        $detalle                           =   new DetalleSemanaImpulso;
                        $detalle->ID_DOCUMENTO             =   $idcab;
                        $detalle->DIA                      =   $cont;
                        $detalle->FECHA                    =   $fechaInicio->format('Y-m-d');
                        $detalle->TIPO                     =   'ADICIONAL';
                        $detalle->MONTO                    =   0;
                        $detalle->FECHA_CREA               =   $this->fechaactual;
                        $detalle->USUARIO_CREA             =   Session::get('usuario')->id;
                        $detalle->save();
                        $cont = $cont + 1;
                        // Sumar un día
                        $fechaInicio->modify('+1 day');
                    }



                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-movilidad-impulso/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
                $iddocumento                            =   Hashids::encode(substr($idcab, -8));
                return Redirect::to('modificar-movilidad-impulso/'.$idopcion.'/'.$iddocumento)->with('bienhecho', 'Movilidad Impulso '.$idcab.' registrado con exito, ingrese sus comprobantes');
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
            $area_nombre = $trabajadorespla->cadarea;

            //IMPULSADORA
            // $area_id = 'PRMAECEN000000000155';//ELIMINAR
            // $area_nombre = 'AUTOSERVICIOS';//ELIMINAR

            //VENDEDOR
            $area_id = 'PRMAECEN000000000172';//ELIMINAR
            $area_nombre = 'VENTAS';//ELIMINAR

            
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
            $fecha_creacion              =       $this->hoy;
            $fecha_inicio                =       $this->fecha_sin_hora;
            $fecha_fin                   =       $this->fecha_sin_hora;

            return View::make('planillamovilidadimpulso.agregarmovilidadimpulso',
                             [
                                'combosemana'       => $combosemana,
                                'semana_id'         => $semana_id,
                                'fecha_creacion'    => $fecha_creacion,

                                'fecha_inicio'      => $fecha_inicio,
                                'fecha_fin'         => $fecha_fin,

                                'area_id'           => $area_id,
                                'area_nombre'       => $area_nombre,
                                'centro_id'         => $centro_id,
                                'centro_id'         => $centro_id,
                                'idopcion'          => $idopcion
                             ]);
        }   
    }


    public function actionGuardarDetalleMovilidadImpulso($idopcion,$iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'SEMI');
        if($_POST)
        {

            try{    
                
                DB::beginTransaction();

                $datos = $request->input('datos');
                $datosadicional = $request->input('datosadicional');
                $movilidad          =   SemanaImpulso::where('ID_DOCUMENTO','=',$iddocumento)->first();
                //MONTO
                foreach ($datos as $registro) {
                    $idDocumento = $registro['id_documento'];
                    
                    // Si hay días configurados
                    if (isset($registro['dias'])) {
                        foreach ($registro['dias'] as $diaNumero => $diaData) {

                            $configuracion      =   DB::table('CONFIGURACION_IMPULSO')->where('ID_CONFIGURACION','=',$diaData['configuracion'])->first();
                            $dia                =   Carbon::parse($diaData['fecha'])->day;
                            $diaNumero_c        =   $dia;

                            if(count($configuracion)>0){


                                $categoriaimpulso      =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','PLANILLA_IMPULSO')->where('COD_CATEGORIA','=',$configuracion->CATEGORIA_ID)->first();
                                //dd($configuracion);
                                DetalleSemanaImpulso::where('ID_DOCUMENTO','=',$idDocumento)->where('DIA','=',$diaNumero)->where('TIPO','=','ASIGNADO')
                                            ->update(
                                                    [

                                                        'COD_CONFIGURACION'=>$configuracion->ID_CONFIGURACION,
                                                        'COD_CATEGORIA_IMPULSO'=>$categoriaimpulso->COD_CATEGORIA,
                                                        'TXT_CATEGORIA_IMPULSO'=>$categoriaimpulso->NOM_CATEGORIA,
                                                        'TXT_PREFIJO_IMPULSO'=>$categoriaimpulso->TXT_PREFIJO,
                                                        'FECHA_MOD'=>$this->fechaactual,
                                                        'MONTO'=>$configuracion->MONTO,
                                                        'USUARIO_MOD'=>Session::get('usuario')->id

                                                    ]);

                                $this->calcular_total_movilidad_impulso($iddocumento);

                            }

                        }
                    }
                }




                //MONTO
                foreach ($datosadicional as $registro) {
                    $idDocumento = $registro['id_documento'];

                    $movilidad          =   SemanaImpulso::where('ID_DOCUMENTO','=',$idDocumento)->first();
                    // Si hay días configurados
                    if (isset($registro['dias'])) {
                        foreach ($registro['dias'] as $diaNumero => $diaData) {

                            $configuracion      =   DB::table('CONFIGURACION_IMPULSO')->where('CATEGORIA_TXT','=','ADICIONAL')
                                                    ->where('AREA_ID','=',$movilidad->AREA_ID)
                                                    ->where('CENTRO_ID','=',$movilidad->CENTRO_ID)
                                                    ->first();
                            $dia                =   Carbon::parse($diaData['fecha'])->day;
                            $diaNumero_c        =   $dia;
                            //dd($diaData);

                            if(count($configuracion)>0){

                                $categoriaimpulso      =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','PLANILLA_IMPULSO')->where('COD_CATEGORIA','=',$configuracion->CATEGORIA_ID)->first();

                                DetalleSemanaImpulso::where('ID_DOCUMENTO','=',$idDocumento)->where('DIA','=',$diaNumero)->where('TIPO','=','ADICIONAL')
                                            ->update(
                                                    [

                                                        'COD_CONFIGURACION'=>$configuracion->ID_CONFIGURACION,
                                                        'COD_CATEGORIA_IMPULSO'=>$categoriaimpulso->COD_CATEGORIA,
                                                        'TXT_CATEGORIA_IMPULSO'=>$categoriaimpulso->NOM_CATEGORIA,
                                                        'TXT_PREFIJO_IMPULSO'=>$categoriaimpulso->TXT_PREFIJO,
                                                        'FECHA_MOD'=>$this->fechaactual,
                                                        'MONTO'=>$diaData['configuracion'],
                                                        'USUARIO_MOD'=>Session::get('usuario')->id

                                                    ]);

                                $this->calcular_total_movilidad_impulso($iddocumento);

                            }

                        }
                    }
                }



                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-movilidad-impulso/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
                $idcab = $iddocumento;
                $iddocumento                            =   Hashids::encode(substr($iddocumento, -8));

                return Redirect::to('modificar-movilidad-impulso/'.$idopcion.'/'.$iddocumento)->with('bienhecho', 'Movilidad Impulso '.$idcab.' registrado con exito, ingrese sus comprobantes');
        }   
    }

    public function actionGuardarDetalleMovilidadImpulsoMasivo($idopcion,$iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LOIM');
        if($_POST)
        {

            try{    
                
                DB::beginTransaction();

                $datos = $request->input('datos');
                $lote          =   LoteImpulso::where('ID_DOCUMENTO','=',$iddocumento)->first();
                //MONTO
                //dd($datos);

                foreach ($datos as $registro) {

                    $idDocumento = $registro['id_documento'];
                    $tipo = $registro['tipo'];

                    // Si hay días configurados
                    if (isset($registro['dias'])) {
                        foreach ($registro['dias'] as $diaNumero => $diaData) {
                            if($tipo == 'ASIGNADO'){
                                $configuracion      =   DB::table('CONFIGURACION_IMPULSO')->where('ID_CONFIGURACION','=',$diaData['configuracion'])->first();
                                $dia                =   Carbon::parse($diaData['fecha'])->day;
                                $diaNumero_c        =   $dia;

                                if(count($configuracion)>0){

                                    $categoriaimpulso      =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','PLANILLA_IMPULSO')->where('COD_CATEGORIA','=',$configuracion->CATEGORIA_ID)->first();
                                    DetalleSemanaImpulso::where('ID_DOCUMENTO','=',$idDocumento)->where('DIA','=',$diaNumero)->where('TIPO','=',$tipo)
                                                ->update(
                                                        [

                                                            'COD_CONFIGURACION'=>$configuracion->ID_CONFIGURACION,
                                                            'COD_CATEGORIA_IMPULSO'=>$categoriaimpulso->COD_CATEGORIA,
                                                            'TXT_CATEGORIA_IMPULSO'=>$categoriaimpulso->NOM_CATEGORIA,
                                                            'TXT_PREFIJO_IMPULSO'=>$categoriaimpulso->TXT_PREFIJO,
                                                            'FECHA_MOD'=>$this->fechaactual,
                                                            'MONTO'=>$configuracion->MONTO,
                                                            'USUARIO_MOD'=>Session::get('usuario')->id

                                                        ]);

                                    $this->calcular_total_movilidad_impulso_masivo($iddocumento,$idDocumento);

                                }

                            }else{

                                $movilidad          =   SemanaImpulso::where('ID_DOCUMENTO','=',$idDocumento)->first();
                                $configuracion      =   DB::table('CONFIGURACION_IMPULSO')->where('CATEGORIA_TXT','=','ADICIONAL')
                                                        ->where('AREA_ID','=',$movilidad->AREA_ID)
                                                        ->where('CENTRO_ID','=',$movilidad->CENTRO_ID)
                                                        ->first();
                                $dia                =   Carbon::parse($diaData['fecha'])->day;
                                $diaNumero_c        =   $dia;


                                if(count($configuracion)>0){

                                    $categoriaimpulso      =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','PLANILLA_IMPULSO')->where('COD_CATEGORIA','=',$configuracion->CATEGORIA_ID)->first();
                                    DetalleSemanaImpulso::where('ID_DOCUMENTO','=',$idDocumento)->where('DIA','=',$diaNumero)->where('TIPO','=',$tipo)
                                                ->update(
                                                        [

                                                            'COD_CONFIGURACION'=>$configuracion->ID_CONFIGURACION,
                                                            'COD_CATEGORIA_IMPULSO'=>$categoriaimpulso->COD_CATEGORIA,
                                                            'TXT_CATEGORIA_IMPULSO'=>$categoriaimpulso->NOM_CATEGORIA,
                                                            'TXT_PREFIJO_IMPULSO'=>$categoriaimpulso->TXT_PREFIJO,
                                                            'FECHA_MOD'=>$this->fechaactual,
                                                            'MONTO'=>$diaData['valor_texto'],
                                                            'USUARIO_MOD'=>Session::get('usuario')->id

                                                        ]);


                                    $this->calcular_total_movilidad_impulso_masivo($iddocumento,$idDocumento);

                                }


                            }





                        }
                    }
                }


                // //MONTO
                // foreach ($datosadicional as $registro) {
                //     $idDocumento = $registro['id_documento'];

                //     $movilidad          =   SemanaImpulso::where('ID_DOCUMENTO','=',$idDocumento)->first();
                //     // Si hay días configurados
                //     if (isset($registro['dias'])) {
                //         foreach ($registro['dias'] as $diaNumero => $diaData) {

                //             $configuracion      =   DB::table('CONFIGURACION_IMPULSO')->where('CATEGORIA_TXT','=','ADICIONAL')
                //                                     ->where('AREA_ID','=',$movilidad->AREA_ID)
                //                                     ->where('CENTRO_ID','=',$movilidad->CENTRO_ID)
                //                                     ->first();
                //             $dia                =   Carbon::parse($diaData['fecha'])->day;
                //             $diaNumero_c        =   $dia;
                //             //dd($diaData);

                //             if(count($configuracion)>0){

                //                 $categoriaimpulso      =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','PLANILLA_IMPULSO')->where('COD_CATEGORIA','=',$configuracion->CATEGORIA_ID)->first();

                //                 DetalleSemanaImpulso::where('ID_DOCUMENTO','=',$idDocumento)->where('DIA','=',$diaNumero)->where('TIPO','=','ADICIONAL')
                //                             ->update(
                //                                     [

                //                                         'COD_CONFIGURACION'=>$configuracion->ID_CONFIGURACION,
                //                                         'COD_CATEGORIA_IMPULSO'=>$categoriaimpulso->COD_CATEGORIA,
                //                                         'TXT_CATEGORIA_IMPULSO'=>$categoriaimpulso->NOM_CATEGORIA,
                //                                         'TXT_PREFIJO_IMPULSO'=>$categoriaimpulso->TXT_PREFIJO,
                //                                         'FECHA_MOD'=>$this->fechaactual,
                //                                         'MONTO'=>$diaData['configuracion'],
                //                                         'USUARIO_MOD'=>Session::get('usuario')->id

                //                                     ]);

                //                 $this->calcular_total_movilidad_impulso($iddocumento);

                //             }

                //         }
                //     }
                // }



                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-movilidad-impulso-masivo/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
                $idcab = $iddocumento;
                $iddocumento                            =   Hashids::encode(substr($iddocumento, -8));

                return Redirect::to('modificar-movilidad-impulso-masivo/'.$idopcion.'/'.$iddocumento)->with('bienhecho', 'Movilidad Impulso '.$idcab.' registrado con exito, ingrese sus comprobantes');
        }   
    }



    public function actionModificarMovilidadImpulso($idopcion,$iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'SEMI');
        View::share('titulo','Agregar Detalle Movilidad Impulso');

        $movilidad          =   SemanaImpulso::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $detallemovilidad   =   DetalleSemanaImpulso::where('ID_DOCUMENTO','=',$iddocumento)->first();

        if($movilidad->COD_ESTADO!='ETM0000000000001'){
            return Redirect::to('gestion-movilidad-impulso/'.$idopcion)->with('errorbd', 'Ya no puede modificar esta MOVILIDAD DE IMPULSO');
        }
        $combosemana        =   $this->gn_generacion_combo_semana("Seleccione Semana",""); 
        $semana_id          =   $movilidad->ANIO.' - '.$movilidad->NRO_SEMANA;

        //ASIGNADO
        $datos = DB::table('SEMANA_IMPULSO')
            ->join('DETALLE_SEMANA_IMPULSO', 'SEMANA_IMPULSO.ID_DOCUMENTO', '=', 'DETALLE_SEMANA_IMPULSO.ID_DOCUMENTO')
            ->where('DETALLE_SEMANA_IMPULSO.TIPO', 'ASIGNADO')
            ->select('DETALLE_SEMANA_IMPULSO.*','SEMANA_IMPULSO.TXT_EMPRESA_TRABAJADOR','SEMANA_IMPULSO.FECHA_INICIO','SEMANA_IMPULSO.FECHA_FIN')
            ->where('SEMANA_IMPULSO.ID_DOCUMENTO','=',$iddocumento)
            ->get();

        // Calcular días del rango
        $fechaInicio = \Carbon\Carbon::parse($datos->first()->FECHA_INICIO);
        $fechaFin = \Carbon\Carbon::parse($datos->first()->FECHA_FIN);
        $totalDias = $fechaInicio->diffInDays($fechaFin) + 1;

        // Agrupar por ID_DOCUMENTO
        $datosAgrupados = $datos->groupBy('ID_DOCUMENTO')->map(function ($grupo) use ($fechaInicio, $fechaFin, $totalDias) {
            $fila = [
                'ID_DOCUMENTO' => $grupo->first()->ID_DOCUMENTO,
                'TIPO' => $grupo->first()->TIPO,
                'COD_CONFIGURACION' => $grupo->first()->COD_CONFIGURACION,
                'COD_CATEGORIA_IMPULSO' => $grupo->first()->COD_CATEGORIA_IMPULSO,
                'TXT_CATEGORIA_IMPULSO' => $grupo->first()->TXT_CATEGORIA_IMPULSO,
                'TXT_PREFIJO_IMPULSO' => $grupo->first()->TXT_PREFIJO_IMPULSO,
                'MONTO' => $grupo->first()->MONTO,
                'ACTIVO' => $grupo->first()->ACTIVO,
                'TXT_EMPRESA_TRABAJADOR' => $grupo->first()->TXT_EMPRESA_TRABAJADOR,
                'FECHA_INICIO' => $grupo->first()->FECHA_INICIO,
                'FECHA_FIN' => $grupo->first()->FECHA_FIN,
                'total_dias' => $totalDias,
                'dias' => []
            ];
            
            // Crear array con todas las fechas del rango
            $fechaActual = $fechaInicio->copy();
            $contadorDia = 1;
            
            while ($fechaActual <= $fechaFin) {
                // Buscar el día usando where (compatible con Laravel 5.4)
                $diaEncontrado = $grupo->where('DIA', $contadorDia)->first();
                
                $fila['dias'][$contadorDia] = [
                    'nombre' => $this->obtenerNombreDiaDinamico($fechaActual),
                    'fecha' => $fechaActual->format('Y-m-d'),
                    'fecha_formateada' => $fechaActual->format('d/m'),
                    'data' => $diaEncontrado,
                    'numero_dia' => $contadorDia
                ];
                
                $fechaActual->addDay();
                $contadorDia++;
            }
            
            return $fila;
        });

        //dd($datosAgrupados);


        //ADICIONAL
        $datosadicional = DB::table('SEMANA_IMPULSO')
            ->join('DETALLE_SEMANA_IMPULSO', 'SEMANA_IMPULSO.ID_DOCUMENTO', '=', 'DETALLE_SEMANA_IMPULSO.ID_DOCUMENTO')
            ->where('DETALLE_SEMANA_IMPULSO.TIPO', 'ADICIONAL')
            ->select('DETALLE_SEMANA_IMPULSO.*','SEMANA_IMPULSO.TXT_EMPRESA_TRABAJADOR','SEMANA_IMPULSO.FECHA_INICIO','SEMANA_IMPULSO.FECHA_FIN')
            ->where('SEMANA_IMPULSO.ID_DOCUMENTO','=',$iddocumento)
            ->get();

        // Calcular días del rango
        $fechaInicio = \Carbon\Carbon::parse($datos->first()->FECHA_INICIO);
        $fechaFin = \Carbon\Carbon::parse($datos->first()->FECHA_FIN);
        $totalDias = $fechaInicio->diffInDays($fechaFin) + 1;

        // Agrupar por ID_DOCUMENTO
        $datosAgrupadosadicional = $datosadicional->groupBy('ID_DOCUMENTO')->map(function ($grupo) use ($fechaInicio, $fechaFin, $totalDias) {
            $fila = [
                'ID_DOCUMENTO' => $grupo->first()->ID_DOCUMENTO,
                'TIPO' => $grupo->first()->TIPO,
                'COD_CONFIGURACION' => $grupo->first()->COD_CONFIGURACION,
                'COD_CATEGORIA_IMPULSO' => $grupo->first()->COD_CATEGORIA_IMPULSO,
                'TXT_CATEGORIA_IMPULSO' => $grupo->first()->TXT_CATEGORIA_IMPULSO,
                'TXT_PREFIJO_IMPULSO' => $grupo->first()->TXT_PREFIJO_IMPULSO,
                'MONTO' => $grupo->first()->MONTO,
                'ACTIVO' => $grupo->first()->ACTIVO,
                'TXT_EMPRESA_TRABAJADOR' => $grupo->first()->TXT_EMPRESA_TRABAJADOR,
                'FECHA_INICIO' => $grupo->first()->FECHA_INICIO,
                'FECHA_FIN' => $grupo->first()->FECHA_FIN,
                'total_dias' => $totalDias,
                'dias' => []
            ];
            
            // Crear array con todas las fechas del rango
            $fechaActual = $fechaInicio->copy();
            $contadorDia = 1;
            
            while ($fechaActual <= $fechaFin) {
                // Buscar el día usando where (compatible con Laravel 5.4)
                $diaEncontrado = $grupo->where('DIA', $contadorDia)->first();
                
                $fila['dias'][$contadorDia] = [
                    'nombre' => $this->obtenerNombreDiaDinamico($fechaActual),
                    'fecha' => $fechaActual->format('Y-m-d'),
                    'fecha_formateada' => $fechaActual->format('d/m'),
                    'data' => $diaEncontrado,
                    'numero_dia' => $contadorDia
                ];
                
                $fechaActual->addDay();
                $contadorDia++;
            }
            
            return $fila;
        });

        $area_id                    =  $movilidad->AREA_ID;
        $area_nombre                =  $movilidad->AREA_TXT;
        $centro_id                  =  $movilidad->CENTRO_ID;

        $documentohistorial         =   LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
        $sw_adicional               =   0;
        $usuario                    =   Session::get('usuario')->id;

        //VENDEDOR 
        if($area_id  == 'PRMAECEN000000000172'){
            $sw_adicional               =   1;
            $comboconfiguracion         =  $this->gn_generacion_combo_impulso_vendedor($area_id,$centro_id,"Seleccione","",$usuario); 
            $configuracion_id           =  "";

        }else{
            $comboconfiguracion         =  $this->gn_generacion_combo_impulso($area_id,$centro_id,"Seleccione",""); 
            $configuracion_id           =  "";
        }

        return View::make('planillamovilidadimpulso.modificarmovilidadimpulso',
                         [
                            'movilidad' => $movilidad,
                            'sw_adicional' => $sw_adicional,
                            'detallemovilidad' => $detallemovilidad,
                            'documentohistorial' => $documentohistorial,
                            'datosAgrupados' => $datosAgrupados,
                            'datosAgrupadosadicional' => $datosAgrupadosadicional,
                            'combosemana' => $combosemana,
                            'semana_id' => $semana_id,
                            'configuracion_id' => $configuracion_id,
                            'area_id' => $area_id,
                            'area_nombre' => $area_nombre,
                            'comboconfiguracion' => $comboconfiguracion,
                            'configuracion_id' => $configuracion_id,
                            'totalDias' => $totalDias,
                            'centro_id' => $centro_id,
                            'idopcion' => $idopcion
                         ]);

    }



    public function actionModificarMovilidadImpulsoMasivo($idopcion,$iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LOIM');
        View::share('titulo','Agregar Detalle Movilidad Impulso Masivo');
        $lote          =   LoteImpulso::where('ID_DOCUMENTO','=',$iddocumento)->first();
        if($lote->COD_ESTADO!='ETM0000000000001'){
            return Redirect::to('gestion-movilidad-impulso/'.$idopcion)->with('errorbd', 'Ya no puede modificar esta MOVILIDAD DE IMPULSO');
        }


        // //ASIGNADO
        // $datos = DB::table('SEMANA_IMPULSO')
        //     ->join('DETALLE_SEMANA_IMPULSO', 'SEMANA_IMPULSO.ID_DOCUMENTO', '=', 'DETALLE_SEMANA_IMPULSO.ID_DOCUMENTO')
        //     ->select('DETALLE_SEMANA_IMPULSO.*','SEMANA_IMPULSO.*')
        //     ->where('SEMANA_IMPULSO.LOTE_IMPULSO_ID','=',$iddocumento)
        //     ->get();

        // // Calcular días del rango
        // $fechaInicio = \Carbon\Carbon::parse($datos->first()->FECHA_INICIO);
        // $fechaFin = \Carbon\Carbon::parse($datos->first()->FECHA_FIN);
        // $totalDias = $fechaInicio->diffInDays($fechaFin) + 1;

        // // Agrupar por ID_DOCUMENTO y generar combos para cada grupo
        // $datosAgrupados = $datos->groupBy('ID_DOCUMENTO')->map(function ($grupo) use ($fechaInicio, $fechaFin, $totalDias) {
        //     $area_id = $grupo->first()->AREA_ID;
        //     $centro_id = $grupo->first()->CENTRO_ID;
            
        //     // Generar el combo para este grupo específico
        //     $comboConfiguracion = $this->gn_generacion_combo_impulso($area_id, $centro_id, "Seleccione", "");
            
        //     $fila = [
        //         'ID_DOCUMENTO' => $grupo->first()->ID_DOCUMENTO,
        //         'TIPO' => $grupo->first()->TIPO,
        //         'AREA_ID' => $area_id,
        //         'CENTRO_ID' => $centro_id,
        //         'COD_CONFIGURACION' => $grupo->first()->COD_CONFIGURACION,
        //         'COD_CATEGORIA_IMPULSO' => $grupo->first()->COD_CATEGORIA_IMPULSO,
        //         'TXT_CATEGORIA_IMPULSO' => $grupo->first()->TXT_CATEGORIA_IMPULSO,
        //         'TXT_PREFIJO_IMPULSO' => $grupo->first()->TXT_PREFIJO_IMPULSO,
        //         'MONTO' => $grupo->first()->MONTO,
        //         'ACTIVO' => $grupo->first()->ACTIVO,
        //         'TXT_EMPRESA_TRABAJADOR' => $grupo->first()->TXT_EMPRESA_TRABAJADOR,
        //         'FECHA_INICIO' => $grupo->first()->FECHA_INICIO,
        //         'FECHA_FIN' => $grupo->first()->FECHA_FIN,
        //         'total_dias' => $totalDias,
        //         'combo_configuracion' => $comboConfiguracion, // Aquí pasamos el combo generado
        //         'dias' => []
        //     ];
            
        //     // Crear array con todas las fechas del rango
        //     $fechaActual = $fechaInicio->copy();
        //     $contadorDia = 1;
            
        //     while ($fechaActual <= $fechaFin) {
        //         $diaEncontrado = $grupo->where('DIA', $contadorDia)->first();
                
        //         $fila['dias'][$contadorDia] = [
        //             'nombre' => $this->obtenerNombreDiaDinamico($fechaActual),
        //             'fecha' => $fechaActual->format('Y-m-d'),
        //             'fecha_formateada' => $fechaActual->format('d/m'),
        //             'data' => $diaEncontrado,
        //             'numero_dia' => $contadorDia
        //         ];
                
        //         $fechaActual->addDay();
        //         $contadorDia++;
        //     }
            
        //     return $fila;
        // });



        // Obtener datos agrupados por ID_DOCUMENTO y TIPO
        $datos = DB::table('SEMANA_IMPULSO')
            ->join('DETALLE_SEMANA_IMPULSO', 'SEMANA_IMPULSO.ID_DOCUMENTO', '=', 'DETALLE_SEMANA_IMPULSO.ID_DOCUMENTO')
            ->where('SEMANA_IMPULSO.LOTE_IMPULSO_ID','=',$iddocumento)
            ->select('DETALLE_SEMANA_IMPULSO.*','SEMANA_IMPULSO.*')
            ->get();
        $datosAgrupados     = [];
        $datosParaVista     = [];
        $totalDias          = "";

        if(count($datos)>0){
            // Calcular días del rango
            $fechaInicio = \Carbon\Carbon::parse($datos->first()->FECHA_INICIO);
            $fechaFin = \Carbon\Carbon::parse($datos->first()->FECHA_FIN);
            $totalDias = $fechaInicio->diffInDays($fechaFin) + 1;

            // Agrupar primero por ID_DOCUMENTO (trabajador) y luego por TIPO
            $datosAgrupados = $datos->groupBy('ID_DOCUMENTO')->map(function ($grupoTrabajador) use ($fechaInicio, $fechaFin, $totalDias) {
                
                $area_id = $grupoTrabajador->first()->AREA_ID;
                $centro_id = $grupoTrabajador->first()->CENTRO_ID;
                
                // Generar combos para este trabajador
                $comboConfiguracion = $this->gn_generacion_combo_impulso($area_id, $centro_id, "Seleccione", "");
                
                // Agrupar por TIPO dentro del mismo trabajador
                $tiposAgrupados = $grupoTrabajador->groupBy('TIPO')->map(function ($grupoTipo) use ($fechaInicio, $fechaFin, $totalDias, $comboConfiguracion, $area_id, $centro_id) {
                    
                    $fila = [
                        'ID_DOCUMENTO' => $grupoTipo->first()->ID_DOCUMENTO,
                        'TIPO' => $grupoTipo->first()->TIPO,
                        'AREA_ID' => $area_id,
                        'CENTRO_ID' => $centro_id,
                        'COD_CONFIGURACION' => $grupoTipo->first()->COD_CONFIGURACION,
                        'COD_CATEGORIA_IMPULSO' => $grupoTipo->first()->COD_CATEGORIA_IMPULSO,
                        'TXT_CATEGORIA_IMPULSO' => $grupoTipo->first()->TXT_CATEGORIA_IMPULSO,
                        'TXT_PREFIJO_IMPULSO' => $grupoTipo->first()->TXT_PREFIJO_IMPULSO,
                        'MONTO' => $grupoTipo->first()->MONTO,
                        'ACTIVO' => $grupoTipo->first()->ACTIVO,
                        'TXT_EMPRESA_TRABAJADOR' => $grupoTipo->first()->TXT_EMPRESA_TRABAJADOR,
                        'FECHA_INICIO' => $grupoTipo->first()->FECHA_INICIO,
                        'FECHA_FIN' => $grupoTipo->first()->FECHA_FIN,
                        'total_dias' => $totalDias,
                        'combo_configuracion' => $comboConfiguracion,
                        'dias' => []
                    ];
                    
                    // Crear array con todas las fechas del rango
                    $fechaActual = $fechaInicio->copy();
                    $contadorDia = 1;
                    
                    while ($fechaActual <= $fechaFin) {
                        $diaEncontrado = $grupoTipo->where('DIA', $contadorDia)->first();
                        
                        $fila['dias'][$contadorDia] = [
                            'nombre' => $this->obtenerNombreDiaDinamico($fechaActual),
                            'fecha' => $fechaActual->format('Y-m-d'),
                            'fecha_formateada' => $fechaActual->format('d/m'),
                            'data' => $diaEncontrado,
                            'numero_dia' => $contadorDia
                        ];
                        
                        $fechaActual->addDay();
                        $contadorDia++;
                    }
                    
                    return $fila;
                });
                
                return $tiposAgrupados;
            });



            // Aplanar la estructura para facilitar el recorrido en la vista
            $datosParaVista = [];
            foreach ($datosAgrupados as $idDocumento => $tipos) {
                foreach ($tipos as $tipo => $fila) {
                    $datosParaVista[] = $fila;
                }
            }            
        }    

        return View::make('planillamovilidadimpulso.modificarmovilidadimpulsomasivo',
                         [
                            'lote' => $lote,
                            'datosParaVista' => $datosParaVista,
                            'totalDias' => $totalDias,
                            'idopcion' => $idopcion
                         ]);

    }

    public function actionDetallePlanillaMovilidadImpulso(Request $request) {

        $iddocumento        =       $request['data_planilla_movilidad_id'];
        $idopcion           =       $request['idopcion'];
        $planillamovilidad  =       LoteImpulso::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $funcion            =       $this;
        $fecha_fin          =       $this->fecha_sin_hora;

        $arraymotivo        =       DB::table('users')->join('STD.TRABAJADOR', 'users.usuarioosiris_id', '=', 'STD.TRABAJADOR.COD_TRAB')->where('activo','=','1')->where('users.rol_id', '1CIX00000047')
                                    ->pluck('nombre','COD_TRAB')->toArray();
        $combotrabajador    =       array('' => "SELECCIONE TRABAJADOR") + $arraymotivo;
        $trabajador_id      =       '';


        return View::make('planillamovilidadimpulso/modal/ajax/magregardetallemovilidadimpulso',
                         [
                            'iddocumento'           =>  $iddocumento,
                            'idopcion'              =>  $idopcion,
                            'planillamovilidad'     =>  $planillamovilidad,
                            'funcion'               =>  $funcion,
                            'combotrabajador'       =>  $combotrabajador,
                            'trabajador_id'         =>  $trabajador_id,
                            'ajax'                  =>  true,
                         ]);
    }


    public function actionGuardarMovilidadTrabajador($idopcion,$iddocumento,Request $request)
    {

        $idcabdoc       = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LOIM');

        try{    
            
            DB::beginTransaction();
                $lote           =   LoteImpulso::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $trabajador_id  =   $request['trabajador_id']; 
                $anio           =   $this->anio;
                $mes            =   $this->mes;
                $trabajador     =   DB::table('STD.TRABAJADOR')
                                    ->where('COD_TRAB', $trabajador_id)
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

                if(count($trabajadorespla)<=0){
                    return Redirect::back()->withInput()->with('errorurl', 'El trabajador no pertenece a esta empresa');
                }
                $centro_id = $trabajadorespla->centro_osiris_id;
                $area_id = $trabajadorespla->area_id;
                $area_nombre = $trabajadorespla->cadarea;
                $configuracion      =   DB::table('CONFIGURACION_IMPULSO')
                                        ->where('AREA_ID', $area_id)
                                        ->where('ACTIVO', 1)
                                        ->where('CENTRO_ID', $centro_id)
                                        ->get();
                if(count($configuracion)<=0){
                    return Redirect::back()->with('errorbd', 'No existe Configuracion de Impulso Para este Trabajador');
                }

                $centrot        =   DB::table('ALM.CENTRO')
                                    ->where('COD_CENTRO', $centro_id)
                                    ->first();

                $txttrabajador  =   '';
                $codtrabajador  =   '';
                $doctrabajador  =   '';
                $fecha_creacion =   $this->hoy;
                $dtrabajador    =   STDTrabajador::where('COD_TRAB','=',$trabajador_id)->first();
                if(count($dtrabajador)>0){
                    $txttrabajador  =   $dtrabajador->TXT_APE_PATERNO.' '.$dtrabajador->TXT_APE_MATERNO.' '.$dtrabajador->TXT_NOMBRES;
                    $doctrabajador  =   $dtrabajador->NRO_DOCUMENTO;
                    $codtrabajador  =   $dtrabajador->COD_TRAB;
                }
                $idcab              =   $this->funciones->getCreateIdMaestradocpla('SEMANA_IMPULSO','SEMI');
                $fecha_inicio       =   $lote->FECHA_INICIO;
                $fecha_fin          =   $lote->FECHA_FIN;
                // Convertir a objetos Carbon
                $inicio = Carbon::parse($fecha_inicio);
                $fin = Carbon::parse($fecha_fin);
                // Extraer año y mes
                $anio_inicio = $inicio->year;
                $mes_inicio = $inicio->month;
                $anio_fin = $fin->year;
                $mes_fin = $fin->month;
                // Validar que estén en el mismo periodo (mismo año y mes)
                if (!($anio_inicio === $anio_fin && $mes_inicio === $mes_fin)) {
                    return Redirect::back()->with('errorbd', 'Las fechas deben estar en el mismo periodo');
                }

                $anio               =   $inicio->year;
                $mes                =   $inicio->month;
                $centro             =   ALMCentro::where('COD_CENTRO', '=', $centro_id)->first();

                //dd($centro);


                $cabecera                           =   new SemanaImpulso;
                $cabecera->ID_DOCUMENTO             =   $idcab;
                $cabecera->LOTE_IMPULSO_ID          =   $lote->ID_DOCUMENTO;
                $cabecera->ANIO                     =   $anio;
                $cabecera->MES                      =   $mes;
                $cabecera->FECHA_INICIO             =   $fecha_inicio;
                $cabecera->FECHA_FIN                =   $fecha_fin;
                $cabecera->COD_EMPRESA              =   Session::get('empresas')->COD_EMPR;
                $cabecera->TXT_EMPRESA              =   Session::get('empresas')->NOM_EMPR;
                $cabecera->COD_EMPRESA_TRABAJADOR   =   $codtrabajador;
                $cabecera->TXT_EMPRESA_TRABAJADOR   =   $txttrabajador;
                $cabecera->AREA_ID                  =   $area_id;
                $cabecera->AREA_TXT                 =   $area_nombre;
                $cabecera->CENTRO_ID                =   $centro->COD_CENTRO;
                $cabecera->CENTRO_TXT               =   $centro->NOM_CENTRO;
                $cabecera->IND_OBSERVACION          =   0;
                $cabecera->MONTO                    =   0;
                $cabecera->COD_ESTADO               =   'ETM0000000000001';
                $cabecera->TXT_ESTADO               =   'GENERADO';
                $cabecera->FECHA_CREA               =   $this->fechaactual;
                $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                $cabecera->save();


                $fechaInicio = new DateTime($fecha_inicio);
                $fechaFin = new DateTime($fecha_fin);
                $cont = 1;
                // Recorremos día por día
                while ($fechaInicio <= $fechaFin) {


                    $detalle                           =   new DetalleSemanaImpulso;
                    $detalle->ID_DOCUMENTO             =   $idcab;
                    $detalle->LOTE_IMPULSO_ID          =   $lote->ID_DOCUMENTO;
                    $detalle->DIA                      =   $cont;
                    $detalle->FECHA                    =   $fechaInicio->format('Y-m-d');
                    $detalle->TIPO                     =   'ASIGNADO';
                    $detalle->MONTO                    =   0;
                    $detalle->FECHA_CREA               =   $this->fechaactual;
                    $detalle->USUARIO_CREA             =   Session::get('usuario')->id;
                    $detalle->save();

                    $detalle                           =   new DetalleSemanaImpulso;
                    $detalle->ID_DOCUMENTO             =   $idcab;
                    $detalle->LOTE_IMPULSO_ID          =   $lote->ID_DOCUMENTO;
                    $detalle->DIA                      =   $cont;
                    $detalle->FECHA                    =   $fechaInicio->format('Y-m-d');
                    $detalle->TIPO                     =   'ADICIONAL';
                    $detalle->MONTO                    =   0;
                    $detalle->FECHA_CREA               =   $this->fechaactual;
                    $detalle->USUARIO_CREA             =   Session::get('usuario')->id;
                    $detalle->save();
                    $cont = $cont + 1;
                    // Sumar un día
                    $fechaInicio->modify('+1 day');
                }


            DB::commit();
        }catch(\Exception $ex){
            DB::rollback(); 
            return Redirect::to('modificar-movilidad-impulso-masivo/'.$idopcion.'/'.$idcabdoc)->with('errorbd', $ex.' Ocurrio un error inesperado');
        }
            return Redirect::to('modificar-movilidad-impulso-masivo/'.$idopcion.'/'.$idcabdoc)->with('bienhecho', 'Se Agrego un nuevo trabajador con exito');
    }


}
