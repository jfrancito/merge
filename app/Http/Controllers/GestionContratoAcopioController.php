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
use App\Modelos\ProRentaCuartaCategoria;
use App\Modelos\ContratoAnticipo;
use App\Modelos\ContratoAnticipoDetalle;
use App\Modelos\CMPContrato;
use App\Modelos\CMPContratoCultivo;
use App\Modelos\ALMCentro;



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
use App\Traits\ContratoAcopioTraits;
use App\Traits\ComprobanteTraits;


use Carbon\Carbon;
use Hashids;
use SplFileInfo;
use Excel;

class GestionContratoAcopioController  extends Controller
{
    use GeneralesTraits;
    use ContratoAcopioTraits;
    use ComprobanteTraits;

    public function actionListarContratoAcopio($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Ver');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Lista Contrato Acopio');
        $cod_empresa        =   Session::get('usuario')->usuarioosiris_id;
        $lcontratoacopio    =   $this->pla_lista_contrato_acopio();
        $funcion            =   $this;

        return View::make('contratoacopio/listacontratoacopio',
                         [
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                            'lcontratoacopio'       =>  $lcontratoacopio,
                         ]);
    }



    public function actionAgregarContratoAcopio($idopcion,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Anadir');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        View::share('titulo','Agregar Contrato Acopio');
        if($_POST)
        {
            try{    
                DB::beginTransaction();

                    $nro_contrato                        =   $request['nro_contrato'];
                    $empresa_id                          =   $request['empresa_id'];
                    $fecha_cosecha                       =   $request['fecha_cosecha'];
                    $variedad_id                         =   $request['variedad_id'];
                    $hectareas                           =   str_replace(',', '', $request['hectareas']);
                    $total                               =   str_replace(',', '', $request['total']);
                    $precio_referencia                   =   str_replace(',', '', $request['precio_referencia']);
                    $proyeccion                          =   str_replace(',', '', $request['proyeccion']);
                    $importe_habilitar                   =   str_replace(',', '', $request['importe_habilitar']);
                    $cuenta_id                           =   $request['cuenta_id'];
                    $subcuenta_id                        =   $request['subcuenta_id'];

                    $empresa                             =   STDEmpresa::where('COD_EMPR', '=', $empresa_id)->first();
                    $idcab                               =   $this->funciones->getCreateIdMaestradocpla('CONTRATO_ANTICIPO','COAN');

                    $cabecera                           =   new ContratoAnticipo;
                    $cabecera->ID_DOCUMENTO             =   $idcab;
                    $cabecera->FECHA_COSECHA            =   date_format(date_create($fecha_cosecha), 'Ymd');
                    $cabecera->COD_EMPRESA              =   $empresa->COD_EMPR;
                    $cabecera->RUC                      =   $empresa->NRO_DOCUMENTO;
                    $cabecera->RAZON_SOCIAL             =   $empresa->NOM_EMPR;
                    $cabecera->NUMERO_CONTRATO          =   $nro_contrato;
                    $cabecera->VARIEDAD_ID              =   $variedad_id;
                    $cabecera->HECTAREAS                =   $hectareas;
                    $cabecera->TOTAL_KG                 =   $total;
                    $cabecera->PRECIO_REFERENCIA        =   $precio_referencia;
                    $cabecera->PROYECCION               =   $proyeccion;
                    $cabecera->IMPORTE_HABILITAR        =   $importe_habilitar;
                    $cabecera->CUENTA_ID                =   $cuenta_id;
                    $cabecera->SUBCUENTA_ID             =   $subcuenta_id;
                    $cabecera->GLOSA                    =   $request['glosa'];
                    $cabecera->COD_ESTADO               =   'ETM0000000000003';
                    $cabecera->TXT_ESTADO               =   'POR APROBAR CONTABILIDAD';
                    $cabecera->ACTIVO                   =   1;
                    $cabecera->FECHA_CREA               =   $this->fechaactual;
                    $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                    $cabecera->save();

                    // GUARDAR DETALLE (PROYECCIÓN DE ANTICIPOS)
                    if(isset($request['fecha_detalle'])){
                        $fechas     = $request['fecha_detalle'];
                        $terceros   = $request['tercero_id_detalle'];
                        $importes   = $request['importe_detalle'];

                        foreach($fechas as $index => $fechaDte){
                            $tercero_id = $terceros[$index];
                            $importe    = str_replace(',', '', $importes[$index]);
                            
                            // Buscar datos de la empresa si es un COD_EMPR, de lo contrario tomar texto
                            $empresa_tercero = STDEmpresa::where('COD_EMPR', '=', $tercero_id)->first();
                            $razon_social = $empresa_tercero ? $empresa_tercero->NOM_EMPR : $tercero_id;
                            $ruc = $empresa_tercero ? $empresa_tercero->NRO_DOCUMENTO : '';

                            $detalle = new ContratoAnticipoDetalle;
                            $detalle->ID_DOCUMENTO   = $idcab;
                            $detalle->LINEA          = $index + 1;
                            $detalle->FECHA          = date_format(date_create($fechaDte), 'Ymd');
                            $detalle->TERCERO_ID     = $tercero_id;
                            $detalle->TERCERO_NOMBRE = $razon_social;
                            $detalle->IMPORTE        = $importe;
                            $detalle->ACTIVO         = 1;
                            $detalle->FECHA_CREA     = $this->fechaactual;
                            $detalle->USUARIO_CREA   = Session::get('usuario')->id;
                            $detalle->save();
                        }
                    }

                    $tarchivos                          =   CMPCategoria::where('COD_CATEGORIA','=','DCC0000000000046')->where('COD_ESTADO','=',1)
                                                            ->get();

                    foreach($tarchivos as $index => $item){

                        $filescdm          =   $request[$item->COD_CATEGORIA];
                        if(!is_null($filescdm)){
                            foreach($filescdm as $file){

                                $contadorArchivos = Archivo::count();
                                $nombre           =      $idcab.'-'.$file->getClientOriginalName();
                                $prefijocarperta =      'CONTRATOACOPIO';
                                $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta;
                                $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                                $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;

                                if (!file_exists($rutafile)) {
                                    mkdir($rutafile, 0777, true);
                                }

                                copy($file->getRealPath(),$rutacompleta);
                                $path            =      $rutacompleta;

                                $nombreoriginal                 =   $file->getClientOriginalName();
                                $info                           =   new SplFileInfo($nombreoriginal);
                                $extension                      =   $info->getExtension();

                                $dcontrol                       =   new Archivo;
                                $dcontrol->ID_DOCUMENTO         =   $idcab;
                                $dcontrol->DOCUMENTO_ITEM       =   1;
                                $dcontrol->TIPO_ARCHIVO         =   $item->COD_CATEGORIA;
                                $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                                $dcontrol->DESCRIPCION_ARCHIVO  =   $item->NOM_CATEGORIA;
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
                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('agregar-contrato-acopio/'.$idopcion)->with('errorbd', 'Ocurrio un error inesperado: ' . $ex->getMessage());
            }
                $iddocumento                            =   Hashids::encode(substr($idcab, -8));
                return Redirect::to('gestion-de-contrato-acopio/'.$idopcion)->with('bienhecho', 'Contrato Acopio '.$idcab.' registrado con exito');
        }else{

            $anio           =   $this->anio;
            $mes            =   $this->mes;
            $empresa_id     =   "";
            $combo_empresa  =   array();
            $cuenta_id      = "";
            $combo_cuenta   = array();
            $subcuenta_id   = "";
            $combo_subcuenta= array();

            $variedad_id    = "";
            $combo_variedad = $this->gn_generacion_combo_categoria('VARIEDAD', 'Seleccione Variedad', '');
            $tarchivos      =   CMPCategoria::where('COD_CATEGORIA','=','DCC0000000000046')->where('COD_ESTADO','=',1)
                                ->get();


            $trabajador = DB::table('STD.TRABAJADOR')
                ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                ->first();
            $dni = '';
            $centro_id = '';
            if (count($trabajador) > 0) {
                $dni = $trabajador->NRO_DOCUMENTO;
            }
            $trabajadorespla = DB::table('WEB.platrabajadores')
                ->where('situacion_id', 'PRMAECEN000000000002')
                ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                ->where('dni', $dni)
                ->first();


            if (count($trabajadorespla) > 0) {
                $centro_id = $trabajadorespla->centro_osiris_id;
            }
            
            $centro = ALMCentro::where('COD_CENTRO', '=', $centro_id)->first();


            return View::make('contratoacopio.agregarcontratoacopio',
                             [
                                'empresa_id' => $empresa_id,
                                'combo_empresa' => $combo_empresa,
                                'cuenta_id' => $cuenta_id,
                                'combo_cuenta' => $combo_cuenta,
                                'subcuenta_id' => $subcuenta_id,
                                'combo_subcuenta' => $combo_subcuenta,
                                'variedad_id' => $variedad_id,
                                'combo_variedad' => $combo_variedad,
                                'centro' => $centro,
                                'tarchivos' => $tarchivos,
                                'idopcion' => $idopcion
                             ]);
        }   
    }

}
