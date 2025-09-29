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

    public function actionAgregarExtornoContabilidadRC($idopcion, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $idordencompra;
        $iddocumento = $this->funciones->decodificarmaestrapre($idordencompra, 'RECU');
        View::share('titulo', 'Extornar RENTA CUARTA');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $cuartacategoria        =   ProRentaCuartaCategoria::where('ID_DOCUMENTO','=',$iddocumento)->first();   
                $descripcion = $request['descripcionextorno'];
                //ANULAR TODA LA OPERACION
                ProRentaCuartaCategoria::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'OBSERVACION' => $descripcion,
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO',
                            'USUARIO_MOD' => Session::get('usuario')->id,
                            'FECHA_MOD' => $this->fechaactual
                        ]
                    );

                DB::commit();
                return Redirect::to('gestion-de-aprobar-cuarta-categoria/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $cuartacategoria->ID_DOCUMENTO . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-aprobar-cuarta-categoria/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }

    }


    public function actionGestionContabilidadRC($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'RECU');
        View::share('titulo','Gestion Renta de 4ta Categoria Contabilidad');

        $cuartacategoria        =   ProRentaCuartaCategoria::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('EXTENSION', 'like', '%'.'pdf'.'%')->where('ACTIVO','=','1')->get();
        $ocultar                =   "";
        // Construir el array de URLs
        $initialPreview = [];
        foreach ($archivospdf as $archivo) {
            $initialPreview[] = route('serve-filerc', ['file' => $archivo->NOMBRE_ARCHIVO]);
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
                'downloadUrl'   => route('serve-filerc', ['file' => $archivo->NOMBRE_ARCHIVO]),
                'frameClass'    => $archivo->ID_DOCUMENTO.$archivo->DOCUMENTO_ITEM.' '.$valor //
            ];
        }
        return View::make('cuartacategoria/gestioncontabilidadcc', 
                        [
                            'cuartacategoria'       =>  $cuartacategoria,
                            'idopcion'              =>  $idopcion,
                            'idcab'                 =>  $idcab,
                            'iddocumento'           =>  $iddocumento,
                            'initialPreview'        => json_encode($initialPreview),
                            'initialPreviewConfig'  => json_encode($initialPreviewConfig),      
                        ]);

    }


    public function actionAprobarContabilidadRC($idopcion, $iddocumento,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $idcab                  =   $iddocumento;
        $iddocumento            =   $this->funciones->decodificarmaestrapre($iddocumento,'RECU');
        View::share('titulo','Aprobar Renta de 4ta Categoria Contabilidad');

        if($_POST)
        {
            try{    
                DB::beginTransaction();
                $cuartacategoria        =   ProRentaCuartaCategoria::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $descripcion            =   $request['descripcion'];
                ProRentaCuartaCategoria::where('ID_DOCUMENTO',$cuartacategoria->ID_DOCUMENTO)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000005',
                                    'TXT_ESTADO'=>'APROBADO',
                                    'OBSERVACION'=>$descripcion,
                                    'COD_USUARIO_CON_APRUEBA'=>Session::get('usuario')->id,
                                    'TXT_USUARIO_CON_APRUEBA'=>Session::get('usuario')->nombre,
                                    'FECHA_MOD'=>$this->fechaactual
                                ]
                            );

                DB::commit();
                return Redirect::to('/gestion-de-aprobar-cuarta-categoria/'.$idopcion)->with('bienhecho', 'Liquidacion de Gastos : '.$cuartacategoria->ID_DOCUMENTO.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-aprobar-cuarta-categoria/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
        else{


            $cuartacategoria        =   ProRentaCuartaCategoria::where('ID_DOCUMENTO','=',$iddocumento)->first();
            $archivospdf            =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('EXTENSION', 'like', '%'.'pdf'.'%')->where('ACTIVO','=','1')->get();
            $ocultar                =   "";
            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-filerc', ['file' => $archivo->NOMBRE_ARCHIVO]);
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
                    'downloadUrl'   => route('serve-filerc', ['file' => $archivo->NOMBRE_ARCHIVO]),
                    'frameClass'    => $archivo->ID_DOCUMENTO.$archivo->DOCUMENTO_ITEM.' '.$valor //
                ];
            }

            return View::make('cuartacategoria/aprobarcontabilidadcc', 
                            [
                                'cuartacategoria'       =>  $cuartacategoria,
                                'idopcion'              =>  $idopcion,
                                'idcab'                 =>  $idcab,
                                'iddocumento'           =>  $iddocumento,
                                'initialPreview'        => json_encode($initialPreview),
                                'initialPreviewConfig'  => json_encode($initialPreviewConfig),      
                            ]);


        }
    }



    public function actionAprobarRentaCuartaContabilidad($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista Renta 4ta Categoria (contabilidad)');
        $tab_id = 'oc';
        if (isset($request['tab_id'])) {
            $tab_id = $request['tab_id'];
        }
        $lrentacuartacategoria = $this->pla_lista_renta_cuarta_categoria_contabilidad();
        $funcion = $this;
        return View::make('cuartacategoria/listacuartacategoriacontabilidad',
            [
                'lrentacuartacategoria' => $lrentacuartacategoria,
                'tab_id' => $tab_id,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
            ]);
    }

    public function actionRentaCuartaContabilidad($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Gestion Renta 4ta Categoria');
        $tab_id = 'oc';
        if (isset($request['tab_id'])) {
            $tab_id = $request['tab_id'];
        }
        $lrentacuartacategoria = $this->pla_lista_renta_cuarta_categoria_contabilidad_gestion();
        $funcion = $this;
        return View::make('cuartacategoria/listacuartacategoriacontabilidadgestion',
            [
                'lrentacuartacategoria' => $lrentacuartacategoria,
                'tab_id' => $tab_id,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
            ]);
    }


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

                    $rentacuarta_existe  = ProRentaCuartaCategoria::where('ACTIVO','=','1')->where('RUC','=',$empresa->NRO_DOCUMENTO)
                                           ->where('COD_ESTADO','<>','ETM0000000000006')->where('ANIO','=',$anio)->get();


                    if (count($rentacuarta_existe) >= 1) {
                        return Redirect::back()->with('errorurl', 'Este Una Renta de cuarta ya registrada esta año para este proveedor');
                    }


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
