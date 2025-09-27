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


use Carbon\Carbon;
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

                    $empresa_id                        =   $request['empresa_id'];
                    $fecha_constancia                  =   $request['fecha_constancia'];
                    $nro_operacion                     =   $request['nro_operacion'];
                    $fechaActual = $fecha_constancia;
                    $fecha = Carbon::parse($fechaActual);

                    // Obtener el fin de año
                    $finDeAnio = $fecha->copy()->endOfYear(); // 2025-12-31 23:59:59

                    // Obtener solo el año
                    $anio = $fecha->year; // 2025

                    // Formatear si necesitas
                    $finDeAnioFormateado = $finDeAnio->format('Y-m-d'); // 2025-12-31
                    $anioFormateado = $anio; // 2025
                    $partes = explode(" - ", $empresa_id);
                    $ruc = '';
                    $td = '01';
                    if (count($partes) > 1) {
                        $ruc = trim($partes[0]);
                    }
                    $empresa = STDEmpresa::where('NRO_DOCUMENTO', '=', $ruc)->first();

                    $idcab                              =   $this->funciones->getCreateIdMaestradocpla('PRO_RENTA_CUARTA_CATEGORIA','RECU');

                    $cabecera                           =   new ProRentaCuartaCategoria;
                    $cabecera->ID_DOCUMENTO             =   $idcab;
                    $cabecera->FECHA_CONSTANCIA         =   date_format(date_create($fecha_constancia), 'Ymd');
                    $cabecera->FECHA_CADUCIDAD          =   date_format(date_create($finDeAnioFormateado), 'Ymd');
                    $cabecera->ANIO                     =   $anio;
                    $cabecera->COD_EMPRESA              =   $empresa->COD_EMPR;
                    $cabecera->RUC                      =   $empresa->NRO_DOCUMENTO;
                    $cabecera->RAZON_SOCIAL             =   $empresa->NOM_EMPR;
                    $cabecera->NUMERO_OPERACION         =   $nro_operacion;
                    $cabecera->COD_ESTADO               =   'ETM0000000000004';
                    $cabecera->TXT_ESTADO               =   'POR APROBAR ADMINISTRACION';
                    $cabecera->ACTIVO                   =   1;
                    $cabecera->FECHA_CREA               =   $this->fechaactual;
                    $cabecera->USUARIO_CREA             =   Session::get('usuario')->id;
                    $cabecera->save();

                    $tarchivos                          =   CMPCategoria::where('COD_CATEGORIA','=','DCC0000000000034')->where('COD_ESTADO','=',1)
                                                            ->get();

                    //GUARDAR 4TA RENTA
                    foreach($tarchivos as $index => $item){

                        $filescdm          =   $request[$item->COD_CATEGORIA];
                        if(!is_null($filescdm)){
                            //CDR
                            foreach($filescdm as $file){

                                $contadorArchivos = Archivo::count();
                                $nombre           =      $idcab.'-'.$file->getClientOriginalName();
                                /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                $prefijocarperta =      'RENTACUARTA';
                                $rutafile        =      $this->pathFiles.'\\comprobantes\\'.$prefijocarperta;
                                $nombrefilecdr   =      $contadorArchivos.'-'.$file->getClientOriginalName();
                                $rutacompleta    =      $rutafile.'\\'.$nombrefilecdr;
                                copy($file->getRealPath(),$rutacompleta);
                                $path            =      $rutacompleta;

                                $nombreoriginal             =   $file->getClientOriginalName();
                                $info                       =   new SplFileInfo($nombreoriginal);
                                $extension                  =   $info->getExtension();

                                $dcontrol                       =   new Archivo;
                                $dcontrol->ID_DOCUMENTO         =   $idcab;
                                $dcontrol->DOCUMENTO_ITEM       =   1;
                                $dcontrol->TIPO_ARCHIVO         =   $item->COD_CATEGORIA;
                                $dcontrol->NOMBRE_ARCHIVO       =   $nombrefilecdr;
                                $dcontrol->DESCRIPCION_ARCHIVO  =   $item->NOM_CATEGORIA;
                                $dcontrol->URL_ARCHIVO      =   $path;
                                $dcontrol->SIZE             =   filesize($file);
                                $dcontrol->EXTENSION        =   $extension;
                                $dcontrol->ACTIVO           =   1;
                                $dcontrol->FECHA_CREA       =   $this->fechaactual;
                                $dcontrol->USUARIO_CREA     =   Session::get('usuario')->id;
                                $dcontrol->save();
                            }
                        }
                    }
                DB::commit();
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('gestion-de-suspension-ta-categoria/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
                $iddocumento                            =   Hashids::encode(substr($idcab, -8));
                return Redirect::to('gestion-de-suspension-ta-categoria/'.$idopcion)->with('bienhecho', 'Renta 4ta Categoria '.$idcab.' registrado con exito');
        }else{

            $anio           =   $this->anio;
            $mes            =   $this->mes;
            $empresa_id     =   "";
            $combo_empresa  =   array();

            $tarchivos      =   CMPCategoria::where('COD_CATEGORIA','=','DCC0000000000034')->where('COD_ESTADO','=',1)
                                ->get();


            return View::make('cuartacategoria.agregarcuartacategoria',
                             [

                                'empresa_id' => $empresa_id,
                                'combo_empresa' => $combo_empresa,
                                'tarchivos' => $tarchivos,
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
        $funcion                =   $this;

        return View::make('cuartacategoria/listacuartacategoria',
                         [
                            'funcion'               =>  $funcion,
                            'idopcion'              =>  $idopcion,
                            'lrentacuartacategoria' =>  $lrentacuartacategoria,
                         ]);
    }

}
