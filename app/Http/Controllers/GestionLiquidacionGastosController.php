<?php

namespace App\Http\Controllers;

use App\Modelos\WEBAsiento;
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
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\TESCuentaBancaria;
use App\Modelos\WEBValeRendir;

use App\Modelos\SemanaImpulso;
use App\Modelos\CONPeriodo;


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
use App\Traits\PrecioCompetenciaTraits;

use PDF;
use Hashids;
use SplFileInfo;
use Excel;
use Carbon\Carbon;

class GestionLiquidacionGastosController extends Controller
{
    use GeneralesTraits;
    use PlanillaTraits;
    use LiquidacionGastoTraits;
    use ComprobanteTraits;
    use PrecioCompetenciaTraits;


    public function actionListarLiquidacionGastosFaltante($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista Liquidación Gasto - Faltantes');
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        $fecha_inicio = $this->fecha_menos_diez_dias;
        $fecha_fin = $this->fecha_sin_hora;

        $listacabecera = DB::table('LQG_DETLIQUIDACIONGASTO')
            ->select([
                'LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO',
                'LQG_LIQUIDACION_GASTO.FECHA_EMI',
                'LQG_DETLIQUIDACIONGASTO.SERIE',
                'LQG_DETLIQUIDACIONGASTO.NUMERO',
                'LQG_DETLIQUIDACIONGASTO.FECHA_EMISION as FECHA_EMISIONDOC',
                'LQG_DETLIQUIDACIONGASTO.TXT_EMPRESA_PROVEEDOR',
                'LQG_DETLIQUIDACIONGASTO.TOTAL',
                'LQG_DETLIQUIDACIONGASTO.IND_PDF',
                'LQG_DETLIQUIDACIONGASTO.IND_XML',
                'LQG_DETLIQUIDACIONGASTO.IND_CDR',
                'LQG_DETLIQUIDACIONGASTO.BUSQUEDAD'
            ])
            ->join('LQG_LIQUIDACION_GASTO', 'LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO', '=', 'LQG_LIQUIDACION_GASTO.ID_DOCUMENTO')
            ->where('LQG_DETLIQUIDACIONGASTO.ACTIVO', 1)
            ->where('LQG_DETLIQUIDACIONGASTO.COD_TIPODOCUMENTO', 'TDO0000000000001')
            ->where('LQG_DETLIQUIDACIONGASTO.COD_EMPRESA', Session::get('empresas')->COD_EMPR)
            ->whereNotIn('LQG_LIQUIDACION_GASTO.COD_ESTADO', ['ETM0000000000006', 'ETM0000000000001'])
            ->whereRaw('ISNULL(LQG_DETLIQUIDACIONGASTO.IND_TOTAL, 0) = 0')
            ->orderby('LQG_LIQUIDACION_GASTO.FECHA_EMI', 'ASC')
            ->get();


        $listadatos = array();
        $funcion = $this;
        return View::make('liquidaciongasto/listaliquidaciongastofaltantes',
            [
                'listadatos' => $listadatos,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
                'listacabecera' => $listacabecera
            ]);
    }


    public function actionTutorialLiquidacionGastos($nombreVideo, Request $request)
    {

        // USAR URL CORRECTA PARA TU CONFIGURACIÓN LOCAL
        $rutaVideo = url('public/firmas/' . $nombreVideo);
        $rutaCompleta = public_path('firmas/' . $nombreVideo);

        // Información completa de debug
        $debug = [
            'archivo_existe' => file_exists($rutaCompleta),
            'es_legible' => is_readable($rutaCompleta),
            'tamaño' => file_exists($rutaCompleta) ? filesize($rutaCompleta) : 0,
            'ruta_publica' => $rutaVideo,
            'ruta_fisica' => $rutaCompleta,
            'permisos' => file_exists($rutaCompleta) ? substr(sprintf('%o', fileperms($rutaCompleta)), -4) : 'N/A',
            'mime_type' => file_exists($rutaCompleta) ? mime_content_type($rutaCompleta) : 'Desconocido',
            'es_video' => file_exists($rutaCompleta) ? (strpos(mime_content_type($rutaCompleta), 'video') !== false) : false
        ];

        // Información para la vista
        $infoVideo = [
            'existe' => file_exists($rutaCompleta) && filesize($rutaCompleta) > 0,
            'tamaño' => file_exists($rutaCompleta) ? filesize($rutaCompleta) : 0,
            'url' => $rutaVideo,
            'nombre' => $nombreVideo
        ];

        return view('liquidaciongasto.tutorial', compact('rutaVideo', 'infoVideo', 'debug'));


    }

    public function actionPdfSunatPersonal(Request $request)
    {

        $serie = $request['serie'];
        $correlativo = ltrim($request['numero'], '0');
        $empresa_id = $request['empresa_id'];
        $ID_DOCUMENTO = $request['ID_DOCUMENTO'];
        $partes = explode(" - ", $empresa_id);
        $ruc = '';
        $td = '01';
        if (count($partes) > 1) {
            $ruc = trim($partes[0]);
        }

        $prefijocarperta = $this->prefijo_empresa_lg(Session::get('empresas')->COD_EMPR);
        $pathFiles = '\\\\10.1.50.2';
        $rutafile = $pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ID_DOCUMENTO;
        $fetoken = FeToken::where('COD_EMPR', '=', Session::get('empresas')->COD_EMPR)->where('TIPO', '=', 'COMPROBANTE_PAGO')->first();

        $urlxml = 'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/' . $ruc . '-' . $td . '-' . $serie . '-' . $correlativo . '-2/01';
        $respuetapdf = $this->buscar_archivo_sunat_lg_nuevo_pdf($urlxml, $fetoken, $pathFiles, $prefijocarperta, $ID_DOCUMENTO);


        return response()->json($respuetapdf);

    }


    public function actionAjaxBuscarCuentaBancariaLQ(Request $request)
    {


        $entidadbanco_id = $request['entidadbanco_id'];
        $ID_DOCUMENTO = $request['ID_DOCUMENTO'];

        $idoc = $ID_DOCUMENTO;
        $ordencompra = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $idoc)->first();

        $tescuentabb = TESCuentaBancaria::where('COD_EMPR_TITULAR', '=', $ordencompra->COD_EMPRESA_TRABAJADOR)
            ->where('COD_EMPR_BANCO', '=', $entidadbanco_id)
            ->where('TXT_CATEGORIA_MONEDA', '=', $ordencompra->TXT_CATEGORIA_MONEDA)
            ->where('COD_ESTADO', '=', 1)
            ->select(DB::raw("
                                          TXT_NRO_CUENTA_BANCARIA,
                                          TXT_REFERENCIA + ' - '+ TXT_NRO_CUENTA_BANCARIA AS nombre")
            )
            ->pluck('nombre', 'TXT_NRO_CUENTA_BANCARIA')
            ->toArray();

        $combocb = array('' => "Seleccione Cuenta Bancaria") + $tescuentabb;
        $funcion = $this;
        $cuentaco_id = "";

        return View::make('liquidaciongasto/combo/combo_cuenta_bancaria',
            [
                'combocb' => $combocb,
                'entidadbanco_id' => $entidadbanco_id,
                'cuentaco_id' => $cuentaco_id,
                'empresa_cliente_id' => $ordencompra->COD_EMPRESA_TRABAJADOR,
                'ajax' => true,
            ]);
    }


    public function actionLiquidacionValidezComprobantePdf(Request $request)
    {

        $datos = [
            'ruc_emisor' => '',
            'tipo_comprobante' => '',
            'serie' => '',
            'numero' => '',
            'tipo_documento' => '',
            'documento_receptor' => '',
            'fecha_emision' => '',
            'importe_total' => ''
        ];

        $pdf = PDF::loadView('pdffa.validezsunat', [
            'datos' => $datos,
            'mostrar_resultado' => false
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('formulario-consulta.pdf');

        // $pdf = PDF::loadView('pdffa.validezsunat');
        // return $pdf->stream('download.pdf');
    }


    public function actionLiquidacionViajePdf($idopcion, $iddocumento, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');

        $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
        $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
        $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
        $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
        $tdetliquidaciongastosel = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '0')->get();
        $archivospdf = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('EXTENSION', 'like', '%' . 'pdf' . '%')->get();
        $ocultar = "";
        $codigoosiris = "";
        $documento = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $liquidaciongastos->COD_OSIRIS)->first();
        if (count($documento) > 0) {
            $codigoosiris = $documento->NRO_SERIE . "-" . $documento->NRO_DOC;
        }

        $detalleVale = DB::table('WEB.VALE_RENDIR_DETALLE')
            ->where('ID', $liquidaciongastos->ARENDIR_ID)
            ->get();
        $lugarviaje = "";
        $motivoviaje = "";
        $cadenaFechas = "";

        if (count($detalleVale) > 0) {

            $fechas = DB::table('WEB.VALE_RENDIR_DETALLE')
                ->select(
                    DB::raw("MIN(FEC_INICIO) as fecha_minima"),
                    DB::raw("MAX(FEC_FIN) as fecha_maxima")
                )
                ->where('ID', $liquidaciongastos->ARENDIR_ID)
                ->first();
            $cadenaFechas = $fechas->fecha_minima . ' / ' . $fechas->fecha_maxima;
            $Vale = DB::table('WEB.VALE_RENDIR')
                ->where('ID', $liquidaciongastos->ARENDIR_ID)
                ->first();

            $destinos = DB::table('WEB.VALE_RENDIR_DETALLE')
                ->where('ID', $liquidaciongastos->ARENDIR_ID)
                ->pluck('NOM_DESTINO'); // Obtiene una colección solo con los valores de NOM_DESTINO
            $lugarviaje = $destinos->implode(' - ');
            $motivoviaje = $Vale->TXT_GLOSA;


        }


        $arendir = DB::table('WEB.VALE_RENDIR')
            ->where('ID', $liquidaciongastos->ARENDIR_ID)
            ->first();

        $productosagru = DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO AS DLG')
            ->select(
                'P.TXT_DESCRIPCION',
                'DLG.TXT_PRODUCTO',
                'LG.COD_TIPODOCUMENTO',
                'LG.TXT_TIPODOCUMENTO',
                DB::raw('SUM(LG.TOTAL) AS CANTIDAD_TC'),
                DB::raw('SUM(LG.TOTAL) AS TOTAL')
            )
            ->join('LQG_DETLIQUIDACIONGASTO AS LG', function ($join) {
                $join->on('DLG.ID_DOCUMENTO', '=', 'LG.ID_DOCUMENTO')
                    ->on('DLG.ITEM', '=', 'LG.ITEM');
            })
            ->join('ALM.PRODUCTO AS P', 'P.COD_PRODUCTO', '=', 'DLG.COD_PRODUCTO')
            ->where('DLG.ID_DOCUMENTO', $iddocumento)
            ->where('DLG.ACTIVO', 1)
            ->groupBy(
                'P.TXT_DESCRIPCION',
                'DLG.TXT_PRODUCTO',
                'LG.COD_TIPODOCUMENTO',
                'LG.TXT_TIPODOCUMENTO'
            )
            ->get();
        $resultado = [];
        $tiposDocumento = [];

        foreach ($productosagru as $item) {
            if (!in_array($item->TXT_TIPODOCUMENTO, $tiposDocumento)) {
                $tiposDocumento[] = $item->TXT_TIPODOCUMENTO;
            }
        }

        // Luego organizar los datos
        foreach ($productosagru as $item) {
            $desc = $item->TXT_DESCRIPCION;
            $prod = $item->TXT_PRODUCTO;
            $tipo = $item->TXT_TIPODOCUMENTO;

            // Inicializar si no existe
            if (!isset($resultado[$desc])) {
                $resultado[$desc] = [];
            }
            if (!isset($resultado[$desc][$prod])) {
                $resultado[$desc][$prod] = [];
                // Inicializar todos los tipos con 0
                foreach ($tiposDocumento as $t) {
                    $resultado[$desc][$prod][$t] = 0;
                }
                $resultado[$desc][$prod]['TOTAL'] = 0;
            }

            // Asignar valores (ASEGURAR QUE SON NÚMEROS, NO ARRAYS)
            $resultado[$desc][$prod][$tipo] = (int)$item->CANTIDAD_TC;
            $resultado[$desc][$prod]['TOTAL'] += (float)$item->TOTAL;
        }


        $trabajador = STDEmpresa::where('COD_EMPR', '=', $liquidaciongastos->COD_EMPRESA_TRABAJADOR)->first();
        $imgresponsable = 'firmas/blanco.jpg';
        $nombre_responsable = '';
        $rutaImagen = public_path('firmas/' . $trabajador->NRO_DOCUMENTO . '.jpg');
        if (file_exists($rutaImagen)) {
            $imgresponsable = 'firmas/' . $trabajador->NRO_DOCUMENTO . '.jpg';
            $nombre_responsable = $trabajador->NOM_EMPR;
        }

        $useario_autoriza = User::where('id', '=', $liquidaciongastos->COD_USUARIO_AUTORIZA)->first();
        $trabajadorap = STDTrabajador::where('COD_TRAB', '=', $useario_autoriza->usuarioosiris_id)->first();
        $imgaprueba = 'firmas/blanco.jpg';
        $nombre_aprueba = '';
        $rutaImagen = public_path('firmas/' . $trabajadorap->NRO_DOCUMENTO . '.jpg');
        if (file_exists($rutaImagen)) {
            $imgaprueba = 'firmas/' . $trabajadorap->NRO_DOCUMENTO . '.jpg';
            $nombre_aprueba = $trabajadorap->TXT_NOMBRES . ' ' . $trabajadorap->TXT_APE_PATERNO . ' ' . $trabajadorap->TXT_APE_MATERNO;
        }


        $direccion = $this->gn_direccion_fiscal();


        $pdf = PDF::loadView('pdffa.liquidaciongastos', [
            'iddocumento' => $iddocumento,
            'liquidaciongastos' => $liquidaciongastos,
            'tdetliquidaciongastos' => $tdetliquidaciongastos,
            'detdocumentolg' => $detdocumentolg,
            'documentohistorial' => $documentohistorial,
            'tdetliquidaciongastosel' => $tdetliquidaciongastosel,
            'productosagru' => $productosagru,
            'imgresponsable' => $imgresponsable,
            'nombre_responsable' => $nombre_responsable,
            'imgaprueba' => $imgaprueba,
            'nombre_aprueba' => $nombre_aprueba,
            'datos' => $resultado,
            'tipos_documento' => $tiposDocumento,
            'arendir' => $arendir,
            'direccion' => $direccion,
            'codigoosiris' => $codigoosiris,
            'lugarviaje' => $lugarviaje,
            'motivoviaje' => $motivoviaje,
            'cadenaFechas' => $cadenaFechas,
        ]);

        return $pdf->stream('download.pdf');
    }


    public function actionGuardarEmpresaProveedor($idopcion, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Guardar Empresa');
        if ($_POST) {
            try {

                $ruc = $request['ruc'];
                $rz = $request['rz'];
                $direccion = $request['direccion'];
                $departamento = $request['departamento'];
                $provincia = $request['provincia'];
                $distrito = $request['distrito'];

                $trabajador = DB::table('STD.TRABAJADOR')
                    ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                    ->first();

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

                $terceros   =   DB::table('TERCEROS')
                                ->where('USER_ID', Session::get('usuario')->id)
                                ->where('ACTIVO', 1)
                                ->first();
                if (count($terceros) > 0) {
                    $centro_id = $terceros->COD_CENTRO;
                }



                if ($centro_id == '') {
                    return Redirect::to('gestion-de-empresa-proveedor/' . $idopcion)->with('errorbd', 'No tienes un Centro Asignado');
                }

                $centro = ALMCentro::where('COD_CENTRO', $centro_id)
                    ->first();
                $zona = CMPZona::where('TXT_NOMBRE', $centro->NOM_CENTRO)->where('COD_EMPR', '=', Session::get('empresas')->COD_EMPR)
                    ->where('COD_ESTADO', '=', '1')
                    ->orderBy('COD_ZONA', 'ASC')
                    ->first();

                $zona02 = CMPZona::where('TXT_NOMBRE', $centro->NOM_CENTRO)->where('COD_EMPR', '=', Session::get('empresas')->COD_EMPR)
                    ->where('COD_ESTADO', '=', '1')
                    ->where('COD_ZONA_SUP', '<>', '')
                    ->first();

                if (count($zona) <= 0) {
                    return Redirect::to('gestion-de-empresa-proveedor/' . $idopcion)->with('errorbd', 'No existe Zona en el osiris');
                }
                if (count($zona02) <= 0) {
                    return Redirect::to('gestion-de-empresa-proveedor/' . $idopcion)->with('errorbd', 'No existe Zona 02 en el osiris');
                }

                $departamentos = CMPCategoria::where('TXT_GRUPO', '=', 'DEPARTAMENTO')->where('NOM_CATEGORIA', '=', $departamento)->first();
                if (count($departamentos) <= 0) {
                    return Redirect::to('gestion-de-empresa-proveedor/' . $idopcion)->with('errorbd', 'No existe Departamento en el osiris');
                }
                $provincias = CMPCategoria::where('TXT_GRUPO', '=', 'PROVINCIA')->where('NOM_CATEGORIA', '=', $provincia)->first();
                if (count($provincias) <= 0) {
                    return Redirect::to('gestion-de-empresa-proveedor/' . $idopcion)->with('errorbd', 'No existe Provincia en el osiris');
                }

                $distritos = CMPCategoria::where('TXT_GRUPO', '=', 'DISTRITO')->where('NOM_CATEGORIA', '=', $distrito)->first();
                if (count($distritos) <= 0) {
                    return Redirect::to('gestion-de-empresa-proveedor/' . $idopcion)->with('errorbd', 'No existe Distrito en el osiris');
                }


                $ind_empresa = $request['ind_empresa'];
                $ind_contrato = $request['ind_contrato'];

                DB::beginTransaction();
                $empresa_id = Session::get('empresas')->COD_EMPR;

                $cod_empresa = $this->lg_enviar_osiris_empresa($centro_id, $empresa_id, $rz, $ruc, $direccion, $departamentos->COD_CATEGORIA, $provincias->COD_CATEGORIA, $distritos->COD_CATEGORIA, $zona, $zona02, $ind_empresa, $ind_contrato);

                DB::commit();
                return Redirect::to('gestion-de-empresa-proveedor/' . $idopcion)->with('bienhecho', 'Empresa : ' . $rz . ' REGISTRO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-empresa-proveedor/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }

    }


    public function actionBuscarSunatRuc($idopcion, Request $request)
    {

        $ruc_buscar = $request['ruc_buscar'];
        $urlxml = 'https://dniruc.apisperu.com/api/v1/ruc/' . $ruc_buscar . '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImhlbnJyeWluZHVAZ21haWwuY29tIn0.m3cyXSejlDWl0BLcphHPUTfPNqpa5kXWoBcmQ6WvkII';
        $respuetaxml = $this->buscar_ruc_sunat_lg($urlxml);

        $trabajador = DB::table('STD.TRABAJADOR')
            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
            ->first();

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

        $terceros   =   DB::table('TERCEROS')
                        ->where('USER_ID', Session::get('usuario')->id)
                        ->where('ACTIVO', 1)
                        ->first();
        if (count($terceros) > 0) {
            $centro_id = $terceros->COD_CENTRO;
        }

        $conexionbd         = 'sqlsrv';
        if($centro_id == 'CEN0000000000004'){ //rioja
            $conexionbd         = 'sqlsrv_r';
        }else{
            if($centro_id == 'CEN0000000000006'){ //bellavista
                $conexionbd         = 'sqlsrv_b';
            }
        }

        $empresa_id = '';
        $empresa = DB::connection($conexionbd)->table('STD.EMPRESA')->where('NRO_DOCUMENTO', '=', $ruc_buscar)->first();

        if (count($empresa) > 0) {
            $empresa_id = $empresa->COD_EMPR;
        }

        $contratos = DB::connection($conexionbd)->table('CMP.CONTRATO')
            ->where('TXT_CATEGORIA_TIPO_CONTRATO', 'PROVEEDOR')
            ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
            ->where('COD_EMPR_CLIENTE', $empresa_id)
            ->where('COD_ESTADO', 1)
            ->where('COD_CATEGORIA_ESTADO_CONTRATO','!=','ECO0000000000005')
            ->where('COD_CENTRO', $centro_id)
            ->get();


        if (count($contratos) > 0) {
            return Redirect::to('gestion-de-empresa-proveedor/' . $idopcion)->with('errorbd', 'Empresa ' . $empresa->NOM_EMPR . ' ya existe y tiene contrato');
        }
        $response_array = json_decode($respuetaxml, true);


        $departamento = $response_array['departamento'] ?? 'LAMBAYEQUE';
        $provincia = $response_array['departamento'] ?? 'CHICLAYO';
        $distrito = $response_array['departamento'] ?? 'CHICLAYO';

        $direccion = $response_array['direccion'] ?? 'CHICLAYO';


        if (isset($response_array['success'])) {
            return Redirect::to('gestion-de-empresa-proveedor/' . $idopcion)->with('errorbd', 'No se encontraron resultados.');
        }

        Session::flash('ruc', $response_array['ruc']);
        Session::flash('rz', $response_array['razonSocial']);
        Session::flash('direccion', $direccion);
        Session::flash('departamento', $departamento);
        Session::flash('provincia', $provincia);
        Session::flash('distrito', $distrito);


        $texto_empresa = 'No cuenta con ningun registro de empresa ';
        if (count($empresa) > 0) {
            $texto_empresa = 'Ya Cuenta con un registro de una empresa';
            Session::flash('texto_empresa', $texto_empresa);
            Session::flash('ind_empresa', 1);
        } else {
            Session::flash('texto_empresa', $texto_empresa);
            Session::flash('ind_empresa', 0);
        }
        $texto_contrato = 'No cuenta con ningun registro de contrato';
        if (count($contratos) > 0) {
            $texto_contrato = 'Ya Cuenta con un registro de contrato en el centro';
            Session::flash('texto_contrato', $texto_contrato);
            Session::flash('ind_contrato', 1);
        } else {
            Session::flash('texto_contrato', $texto_contrato);
            Session::flash('ind_contrato', 0);
        }
        return Redirect::to('/gestion-de-empresa-proveedor/' . $idopcion)->with('bienhecho', 'Documento Encontrado');


    }


    public function actionGestionEmpresaProveedor($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Anadir');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Guardar Empresa Proveedor');

        $ruc = "";
        $rz = "";
        $direccion = "";
        $departamento = "";
        $provincia = "";
        $distrito = "";
        $texto_empresa = "";
        $texto_contrato = "";
        $ind_empresa = 0;
        $ind_contrato = 0;


        if (Session::has('ruc')) {
            $ruc = Session::get('ruc');
        }
        if (Session::has('rz')) {
            $rz = Session::get('rz');
        }
        if (Session::has('direccion')) {
            $direccion = Session::get('direccion');
        }
        if (Session::has('departamento')) {
            $departamento = Session::get('departamento');
        }
        if (Session::has('provincia')) {
            $provincia = Session::get('provincia');
        }
        if (Session::has('distrito')) {
            $distrito = Session::get('distrito');
        }

        if (Session::has('texto_empresa')) {
            $texto_empresa = Session::get('texto_empresa');
        }
        if (Session::has('texto_contrato')) {
            $texto_contrato = Session::get('texto_contrato');
        }
        if (Session::has('ind_empresa')) {
            $ind_empresa = Session::get('ind_empresa');
        }
        if (Session::has('ind_contrato')) {
            $ind_contrato = Session::get('ind_contrato');
        }


        return View::make('liquidaciongasto/buscarempresaproveedor',
            [
                'idopcion' => $idopcion,
                'ruc' => $ruc,
                'rz' => $rz,
                'direccion' => $direccion,
                'departamento' => $departamento,
                'provincia' => $provincia,
                'distrito' => $distrito,
                'texto_empresa' => $texto_empresa,
                'texto_contrato' => $texto_contrato,
                'ind_empresa' => $ind_empresa,
                'ind_contrato' => $ind_contrato
            ]);

    }


    public function actionTareasCpeSunatLg(Request $request)
    {
        $ruc = $request['ruc'];
        $td = $request['td'];
        $serie = $request['serie'];
        $serie = strtoupper($serie);

        $correlativo = $request['correlativo'];
        $correlativo = ltrim($correlativo, '0');
        $ID_DOCUMENTO = $request['ID_DOCUMENTO'];
        $tipodocumento = CMPCategoria::where('TXT_GRUPO', '=', 'TIPO_DOCUMENTO')->where('CODIGO_SUNAT', '=', $td)->first();

        $mensaje = '';
        $sunatdocumento = DB::table('SUNAT_DOCUMENTO')
            ->where('EMPRESA_ID', Session::get('empresas')->COD_EMPR)
            ->where('ID_DOCUMENTO', $ID_DOCUMENTO)
            ->where('MODULO', 'LIQUIDACION_GASTO')
            ->where('RUC', $ruc)
            ->where('TIPODOCUMENTO_ID', '=', $td)
            ->where('SERIE', '=', $serie)
            ->where('NUMERO', '=', $correlativo)
            ->where('ACTIVO', 1)
            ->where('USUARIO_ID', Session::get('usuario')->id)
            ->first();

        if (count($sunatdocumento) > 0) {
            $mensaje = 'Ya existe un documento con estos campos como tarea programada';
        } else {
            $documento = new SunatDocumento;
            $documento->ID_DOCUMENTO = $ID_DOCUMENTO;
            $documento->EMPRESA_ID = Session::get('empresas')->COD_EMPR;
            $documento->EMPRESA_NOMBRE = Session::get('empresas')->NOM_EMPR;
            $documento->RUC = $ruc;
            $documento->TIPODOCUMENTO_ID = $tipodocumento->CODIGO_SUNAT;
            $documento->TIPODOCUMENTO_NOMBRE = $tipodocumento->NOM_CATEGORIA;
            $documento->SERIE = $serie;
            $documento->NUMERO = $correlativo;
            $documento->MODULO = 'LIQUIDACION_GASTO';
            $documento->NOMBRE_PDF = '';
            $documento->RUTA_PDF = '';
            $documento->IND_PDF = 0;
            $documento->NOMBRE_XML = '';
            $documento->RUTA_XML = '';
            $documento->IND_XML = 0;
            $documento->NOMBRE_CDR = '';
            $documento->RUTA_CDR = '';
            $documento->IND_CDR = 0;
            $documento->IND_TOTAL = 0;
            $documento->CONTADOR = 0;
            $documento->ACTIVO = 1;
            $documento->FECHA_CREA = $this->fechaactual;
            $documento->USUARIO_ID = Session::get('usuario')->id;
            $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
            $documento->save();
        }
        $listasunattareas = DB::table('SUNAT_DOCUMENTO')
            ->where('EMPRESA_ID', Session::get('empresas')->COD_EMPR)
            ->where('ID_DOCUMENTO', $ID_DOCUMENTO)
            ->where('MODULO', 'LIQUIDACION_GASTO')
            ->where('ACTIVO', 1)
            ->where('USUARIO_ID', Session::get('usuario')->id)
            ->get();
        $funcion = $this;

        return View::make('liquidaciongasto/ajax/alistatareassunat',
            [
                'ID_DOCUMENTO' => $ID_DOCUMENTO,
                'listasunattareas' => $listasunattareas,
                'funcion' => $funcion,
                'mensaje' => $mensaje,
                'ajax' => true,
            ]);


    }


    public function actionElimnarCpeSunatLgPersonal(Request $request)
    {
        $ruc = $request['data_ruc'];
        $td = $request['data_td'];
        $serie = $request['data_serie'];
        $correlativo = $request['data_numero'];
        $ID_DOCUMENTO = $request['data_id'];

        DB::table('SUNAT_DOCUMENTO')
            ->where('ID_DOCUMENTO', $ID_DOCUMENTO)
            ->where('RUC', $ruc)
            ->where('TIPODOCUMENTO_ID', $td)
            ->where('SERIE', $serie)
            ->where('NUMERO', $correlativo)
            ->update([
                'ACTIVO' => '0'
            ]);
        print_r("hola");
    }


    public function actionBuscarCpeSunatLgPersonal(Request $request)
    {
        $ruc = $request['data_ruc'];
        $td = $request['data_td'];
        $serie = $request['data_serie'];
        $correlativo = $request['data_numero'];
        $ID_DOCUMENTO = $request['data_id'];

        $fetoken = FeToken::where('COD_EMPR', '=', Session::get('empresas')->COD_EMPR)->where('TIPO', '=', 'COMPROBANTE_PAGO')->first();
        //buscar xml
        $primeraLetra = substr($serie, 0, 1);

        $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ID_DOCUMENTO;
        $valor = $this->versicarpetanoexiste($rutafile);

        $ruta_xml = "";
        $ruta_pdf = "";
        $ruta_cdr = "";
        $nombre_xml = "";
        $nombre_pdf = "";
        $nombre_cdr = "";

        $sunattareas = DB::table('SUNAT_DOCUMENTO')
            ->where('EMPRESA_ID', Session::get('empresas')->COD_EMPR)
            ->where('ID_DOCUMENTO', $ID_DOCUMENTO)
            ->where('RUC', $ruc)
            ->where('TIPODOCUMENTO_ID', $td)
            ->where('SERIE', $serie)
            ->where('NUMERO', $correlativo)
            ->first();

        //dd($ID_DOCUMENTO);


        if ($sunattareas->IND_CDR == 1) {
            $ruta_cdr = $sunattareas->RUTA_CDR;
            $nombre_cdr = $sunattareas->NOMBRE_CDR;
        }
        if ($sunattareas->IND_XML == 1) {
            $ruta_xml = $sunattareas->RUTA_XML;
            $nombre_xml = $sunattareas->NOMBRE_XML;
        }
        if ($sunattareas->IND_PDF == 1) {
            $ruta_pdf = $sunattareas->RUTA_PDF;
            $nombre_pdf = $sunattareas->NOMBRE_PDF;
        }

        return response()->json([
            'ruta_cdr' => $ruta_cdr,
            'ruta_xml' => $ruta_xml,
            'ruta_pdf' => $ruta_pdf,
            'nombre_xml' => $nombre_xml,
            'nombre_pdf' => $nombre_pdf,
            'nombre_cdr' => $nombre_cdr,

        ]);

    }


    public function actionGuardarNumeroWhatsapp(Request $request)
    {
        $whatsapp = $request['whatsapp'];
        User::where('id', '=', Session::get('usuario')->id)
            ->update(
                [
                    'celular_contacto' => $whatsapp
                ]
            );


    }


    public function actionBuscarCpeSunatLg(Request $request)
    {
        $ruc = $request['ruc'];
        $td = $request['td'];
        $serie = $request['serie'];
        $correlativo = $request['correlativo'];
        $ID_DOCUMENTO = $request['ID_DOCUMENTO'];

        $fetoken = FeToken::where('COD_EMPR', '=', Session::get('empresas')->COD_EMPR)->where('TIPO', '=', 'COMPROBANTE_PAGO')->first();
        //buscar xml
        $primeraLetra = substr($serie, 0, 1);

        $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ID_DOCUMENTO;
        $valor = $this->versicarpetanoexiste($rutafile);

        $ruta_xml = "";
        $ruta_pdf = "";
        $ruta_cdr = "";
        $nombre_xml = "";
        $nombre_pdf = "";
        $nombre_cdr = "";

        $urlxml = 'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/' . $ruc . '-' . $td . '-' . $serie . '-' . $correlativo . '-2/02';
        $respuetaxml = $this->buscar_archivo_sunat_lg_indicador($urlxml, $fetoken, $this->pathFiles, $prefijocarperta, $ID_DOCUMENTO, 'IND_XML');
        $urlxml = 'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/' . $ruc . '-' . $td . '-' . $serie . '-' . $correlativo . '-2/01';
        $respuetapdf = $this->buscar_archivo_sunat_lg($urlxml, $fetoken, $this->pathFiles, $prefijocarperta, $ID_DOCUMENTO);

        if ($primeraLetra == 'F') {
            $urlxml = 'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/' . $ruc . '-' . $td . '-' . $serie . '-' . $correlativo . '-2/03';
            $respuetacdr = $this->buscar_archivo_sunat_lg($urlxml, $fetoken, $this->pathFiles, $prefijocarperta, $ID_DOCUMENTO);
            if ($respuetacdr['cod_error'] == 0) {
                $ruta_cdr = $respuetacdr['ruta_completa'];
                $nombre_cdr = $respuetacdr['nombre_archivo'];
            }
        }
        if ($respuetaxml['cod_error'] == 0) {
            $ruta_xml = $respuetaxml['ruta_completa'];
            $nombre_xml = $respuetaxml['nombre_archivo'];
        }
        if ($respuetapdf['cod_error'] == 0) {
            $ruta_pdf = $respuetapdf['ruta_completa'];
            $nombre_pdf = $respuetapdf['nombre_archivo'];
        }

        return response()->json([
            'ruta_cdr' => $ruta_cdr,
            'ruta_xml' => $ruta_xml,
            'ruta_pdf' => $ruta_pdf,
            'nombre_xml' => $nombre_xml,
            'nombre_pdf' => $nombre_pdf,
            'nombre_cdr' => $nombre_cdr,

        ]);

    }


    public function actionModalBuscarFacturaSunat(Request $request)
    {

        $ID_DOCUMENTO = $request['ID_DOCUMENTO'];
        $combotd = array('01' => 'FACTURA');
        $idopcion = $request['idopcion'];
        $funcion = $this;

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

        $user = User::where('id', '=', Session::get('usuario')->id)->first();


        $mensaje = '';

        return View::make('liquidaciongasto/modal/ajax/mbuscardocumentosunat',
            [
                'ID_DOCUMENTO' => $ID_DOCUMENTO,
                'user' => $user,
                'idopcion' => $idopcion,
                'listasunattareas' => $listasunattareas,
                'combotd' => $combotd,
                'mensaje' => $mensaje,
                'funcion' => $funcion,
                'ajax' => true,
            ]);
    }

    public function actionModalBuscarFacturaSunatTarea(Request $request)
    {

        $combotd = array('01' => 'FACTURA');
        $idopcion = $request['idopcion'];
        $funcion = $this;
        $usuario = Session::get('usuario')->id;

        $listasunattareas = DB::table('SUNAT_DOCUMENTO as sd')
            ->where('sd.EMPRESA_ID', Session::get('empresas')->COD_EMPR)
            ->where('sd.MODULO', 'LIQUIDACION_GASTO')
            ->where('sd.ACTIVO', 1)
            ->where('sd.USUARIO_ID', Session::get('usuario')->id)
            ->whereNotExists(function ($query) use ($usuario) {
                $query->select(DB::raw(1))
                    ->from('LQG_DETLIQUIDACIONGASTO as lqg')
                    ->join('STD.EMPRESA as e', 'lqg.COD_EMPRESA_PROVEEDOR', '=', 'e.COD_EMPR')
                    ->whereRaw('lqg.SERIE = sd.SERIE')
                    ->whereRaw('CAST(lqg.NUMERO AS INT) = CAST(sd.NUMERO AS INT)')
                    ->whereRaw('e.NRO_DOCUMENTO = sd.RUC')
                    ->where('lqg.USUARIO_CREA', $usuario)
                    ->where('lqg.ACTIVO', 1)
                    ->where('lqg.TXT_TIPODOCUMENTO', 'FACTURA');
            })
            ->orderBy('ID_DOCUMENTO', 'desc')
            ->get();

        $user = User::where('id', '=', Session::get('usuario')->id)->first();


        $mensaje = '';

        return View::make('liquidaciongasto/modal/ajax/mbuscardocumentosunattareas',
            [
                'user' => $user,
                'idopcion' => $idopcion,
                'listasunattareas' => $listasunattareas,
                'combotd' => $combotd,
                'mensaje' => $mensaje,
                'funcion' => $funcion,
                'ajax' => true,
            ]);
    }


    public function actionDetallaComprobanteLGValidado($idopcion, $iddocumento, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        View::share('titulo', 'Detalle Liquidacion de Gastos Administracion');
        $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
        $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
        $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
        $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
        $archivospdf = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('EXTENSION', 'like', '%' . 'pdf' . '%')->get();
        $ocultar = "";
        // Construir el array de URLs
        $initialPreview = [];
        foreach ($archivospdf as $archivo) {
            $initialPreview[] = route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]);
        }

        //dd($initialPreview);
        $initialPreviewConfig = [];

        foreach ($archivospdf as $key => $archivo) {
            $valor = '';
            if ($key > 0) {
                $valor = 'ocultar';
            }
            $initialPreviewConfig[] = [
                'type' => "pdf",
                'caption' => $archivo->NOMBRE_ARCHIVO,
                'downloadUrl' => route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]),
                'frameClass' => $archivo->ID_DOCUMENTO . $archivo->DOCUMENTO_ITEM . ' ' . $valor //
            ];
        }

        $productosagru = DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
            ->select('COD_PRODUCTO', 'TXT_PRODUCTO', DB::raw('SUM(CANTIDAD) as CANTIDAD'), DB::raw('SUM(TOTAL) as TOTAL'))
            ->where('ID_DOCUMENTO', $iddocumento)
            ->where('ACTIVO', 1)
            ->groupBy('COD_PRODUCTO', 'TXT_PRODUCTO')
            ->get();


        $archivos = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();


        $indicador = 0;
        $listaarendirlg = $this->lg_lista_arendirlg($liquidaciongastos,$indicador);
        //dd($listaarendirlg);
            $valearendir_info = $this->lq_valearendir($liquidaciongastos->ID_DOCUMENTO);
                    
        return View::make('liquidaciongasto/detallelgvalidado',
            [
                'liquidaciongastos' => $liquidaciongastos,
                'valearendir_info' => $valearendir_info,
                'tdetliquidaciongastos' => $tdetliquidaciongastos,
                'productosagru' => $productosagru,
                'listaarendirlg' => $listaarendirlg,
                'archivos' => $archivos,
                'detdocumentolg' => $detdocumentolg,
                'documentohistorial' => $documentohistorial,
                'idopcion' => $idopcion,
                'idcab' => $idcab,
                'iddocumento' => $iddocumento,
                'initialPreview' => json_encode($initialPreview),
                'initialPreviewConfig' => json_encode($initialPreviewConfig),
            ]);


    }

    public function actionAjaxUCListarLiquidacionGastos(Request $request)
    {

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        $idopcion = $request['idopcion'];
        $listacabecera = $this->lg_lista_liquidacion_gastos($fecha_inicio, $fecha_fin);

        $funcion = $this;

        return View::make('liquidaciongasto/ajax/alistaliquidaciongasto',
            [
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'idopcion' => $idopcion,
                'listacabecera' => $listacabecera,
                'ajax' => true,
                'funcion' => $funcion
            ]);
    }


    public function actionListarAjaxBuscarDocumentoLG(Request $request)
    {

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        $proveedor_id = $request['proveedor_id'];
        $estado_id = $request['estado_id'];
        $idopcion = $request['idopcion'];


        $listadatos = $this->lg_lista_cabecera_comprobante_total_validado($fecha_inicio, $fecha_fin, $proveedor_id, $estado_id);
        $funcion = $this;

        return View::make('liquidaciongasto/ajax/alistalgvalidado',
            [
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'proveedor_id' => $proveedor_id,
                'estado_id' => $estado_id,
                'idopcion' => $idopcion,
                'listadatos' => $listadatos,
                'ajax' => true,
                'funcion' => $funcion
            ]);
    }


    public function actionComprobanteMasivoExcelLg($fecha_inicio, $fecha_fin, $proveedor_id, $estado_id, $idopcion)
    {
        set_time_limit(0);

        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        $fechadia = date_format(date_create(date('d-m-Y')), 'd-m-Y');
        $fecha_actual = date("Y-m-d");
        $titulo = 'Liquidacion-Gastos-Merge';
        $funcion = $this;

        $listadatos = $this->lg_lista_cabecera_comprobante_total_gestion_excel($cod_empresa, $fecha_inicio, $fecha_fin, $proveedor_id, $estado_id);
        Excel::create($titulo . '-(' . $fecha_actual . ')', function ($excel) use ($listadatos, $titulo, $funcion) {
            $excel->sheet('LIQUIDACION', function ($sheet) use ($listadatos, $titulo, $funcion) {

                $sheet->loadView('reporte/excel/listacomprobantemasivolq')->with('listadatos', $listadatos)
                    ->with('titulo', $titulo)
                    ->with('funcion', $funcion);
            });
        })->export('xls');


    }


    public function actionListarLGValidado($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista Liquidación de Gastos');
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;

        $fecha_inicio = $this->fecha_menos_diez_dias;
        $fecha_fin = $this->fecha_sin_hora;
        $proveedor_id = 'TODO';
        $combo_proveedor = $this->lg_combo_trabajador_fe_documento($proveedor_id);
        $estado_id = 'TODO';
        $combo_estado = $this->gn_combo_estado_fe_documento($estado_id);
        $listadatos = $this->lg_lista_cabecera_comprobante_total_validado($fecha_inicio, $fecha_fin, $proveedor_id, $estado_id);

        $funcion = $this;
        return View::make('liquidaciongasto/listalgvalidado',
            [
                'listadatos' => $listadatos,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'proveedor_id' => $proveedor_id,
                'combo_proveedor' => $combo_proveedor,
                'estado_id' => $estado_id,
                'combo_estado' => $combo_estado
            ]);
    }


    public function actionAgregarExtornoAdministracion($idopcion, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $idordencompra;
        $iddocumento = $this->funciones->decodificarmaestrapre($idordencompra, 'LIQG');
        View::share('titulo', 'Extornar Liquidacion');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
                $descripcion = $request['descripcionextorno'];

                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento = new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $liquidaciongastos->ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO EXTORNADO';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'DOCUMENTO EXTORNADO');
                //geolocalización


                //ANULAR TODA LA OPERACION
                LqgLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO'
                        ]
                    );

                LqgDetLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'ACTIVO' => '0'
                        ]
                    );


                DB::commit();
                return Redirect::to('gestion-de-aprobacion-liquidacion-gastos-administracion/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $liquidaciongastos->ID_DOCUMENTO . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-aprobacion-liquidacion-gastos-administracion/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }

    }

    public function actionAgregarExtornoContabilidadLG($idopcion, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $idordencompra;
        $iddocumento = $this->funciones->decodificarmaestrapre($idordencompra, 'LIQG');
        View::share('titulo', 'Extornar Liquidacion');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
                $descripcion = $request['descripcionextorno'];

                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento = new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $liquidaciongastos->ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO EXTORNADO';
                $documento->MENSAJE = $descripcion;
                $documento->save();


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'DOCUMENTO EXTORNADO');
                //geolocalización

                //ANULAR TODA LA OPERACION
                LqgLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO'
                        ]
                    );

                //LIBERAR TODOS LOS DOCUMENTO
                LqgDetLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'ACTIVO' => '0'
                        ]
                    );


                DB::commit();
                return Redirect::to('gestion-de-aprobacion-liquidacion-gastos-contabilidad/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $liquidaciongastos->ID_DOCUMENTO . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-aprobacion-liquidacion-gastos-contabilidad/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }

    }


    public function actionAgregarExtornoJefe($idopcion, $idordencompra, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $idordencompra;
        $iddocumento = $this->funciones->decodificarmaestrapre($idordencompra, 'LIQG');
        View::share('titulo', 'Extornar Liquidacion');

        if ($_POST) {

            try {

                DB::beginTransaction();
                $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
                $descripcion = $request['descripcionextorno'];

                //GUARDAR EN EL HISTORIAL QUE SE EXTORNO UN VEZ
                $documento = new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = $liquidaciongastos->ITEM;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'DOCUMENTO EXTORNADO';
                $documento->MENSAJE = $descripcion;
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'DOCUMENTO EXTORNADO');
                //geolocalización


                //ANULAR TODA LA OPERACION
                LqgLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000006',
                            'TXT_ESTADO' => 'RECHAZADO'
                        ]
                    );

                LqgDetLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'ACTIVO' => '0'
                        ]
                    );


                DB::commit();
                return Redirect::to('gestion-de-aprobacion-liquidacion-gasto-jefe/' . $idopcion)->with('bienhecho', 'Comprobante : ' . $liquidaciongastos->ID_DOCUMENTO . ' EXTORNADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-aprobacion-liquidacion-gasto-jefe/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }

    }


    public function actionAjaxLeerXmlLGValidar(Request $request)
    {


        $serie = $request['serie'];
        $numero = ltrim($request['numero'], '0');
        $fecha_emision = $request['fecha_emision'];
        $totaldetalle = $request['totaldetalle'];
        $empresa_id = $request['empresa_id'];
        $partes = explode(" - ", $empresa_id);
        $ruc_b = '';
        if (count($partes) > 1) {
            $ruc_b = trim($partes[0]);
        }

        $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);

        $token = '';
        if ($prefijocarperta == 'II') {
            $token = $this->generartoken_ii();
        } else {
            $token = $this->generartoken_is();
        }

        $fechaemision = date_format(date_create(date_format(date_create($fecha_emision), 'Ymd')), 'd/m/Y');
        $rvalidar = $this->validar_xml($token,
            Session::get('empresas')->NRO_DOCUMENTO,
            $ruc_b,
            '01',
            $serie,
            $numero,
            $fechaemision,
            $totaldetalle);

        $arvalidar = json_decode($rvalidar, true);
        if (isset($arvalidar['success'])) {
            if ($arvalidar['success']) {
                $datares = $arvalidar['data'];
                if (!isset($datares['estadoCp'])) {
                    return response()->json(
                        [
                            'mensaje' => 'Hay fallas en sunat para consultar el XML',
                            'error' => '1'
                        ]);
                }
                $estadoCp = $datares['estadoCp'];
                $tablaestacp = Estado::where('tipo', '=', 'estadoCp')->where('codigo', '=', $estadoCp)->first();
                $estadoRuc = '';
                $txtestadoRuc = '';
                $estadoDomiRuc = '';
                $txtestadoDomiRuc = '';
                if (isset($datares['estadoRuc'])) {
                    $tablaestaruc = Estado::where('tipo', '=', 'estadoRuc')->where('codigo', '=', $datares['estadoRuc'])->first();
                    $estadoRuc = $tablaestaruc->codigo;
                    $txtestadoRuc = $tablaestaruc->nombre;
                }
                if (isset($datares['condDomiRuc'])) {
                    $tablaestaDomiRuc = Estado::where('tipo', '=', 'condDomiRuc')->where('codigo', '=', $datares['condDomiRuc'])->first();
                    $estadoDomiRuc = $tablaestaDomiRuc->codigo;
                    $txtestadoDomiRuc = $tablaestaDomiRuc->nombre;
                }

                $SUCCESS = $arvalidar['success'];
                $MESSAGE = $arvalidar['message'];
                $ESTADOCP = $tablaestacp->codigo;
                $NESTADOCP = $tablaestacp->nombre;
                $ESTADORUC = $estadoRuc;
                $NESTADORUC = $txtestadoRuc;
                $CONDDOMIRUC = $estadoDomiRuc;
                $NCONDDOMIRUC = $txtestadoDomiRuc;

            } else {

                $SUCCESS = $arvalidar['success'];
                $MESSAGE = $arvalidar['message'];
            }
        }

        return response()->json([
            'mensaje' => 'Archivo recibido correctamente',
            'error' => '0',
            'SUCCESS' => $SUCCESS,
            'MESSAGE' => $MESSAGE,
            'ESTADOCP' => $ESTADOCP,
            'NESTADOCP' => $NESTADOCP,
            'ESTADORUC' => $ESTADORUC,
            'NESTADORUC' => $NESTADORUC,
            'CONDDOMIRUC' => $CONDDOMIRUC,
            'NCONDDOMIRUC' => $NCONDDOMIRUC
        ]);


    }


    public function actionAjaxLeerXmlLG(Request $request)
    {

        if ($request->hasFile('inputxml')) {
            $file = $request->file('inputxml');
            $ID_DOCUMENTO = $request['ID_DOCUMENTO'];


            //
            $contadorArchivos = Archivo::count();

            $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);

            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ID_DOCUMENTO;
            $nombrefile = $contadorArchivos . '-' . $file->getClientOriginalName();
            $valor = $this->versicarpetanoexiste($rutafile);
            $rutacompleta = $rutafile . '\\' . $nombrefile;
            $nombreoriginal = $file->getClientOriginalName();
            $info = new SplFileInfo($nombreoriginal);
            $extension = $info->getExtension();
            copy($file->getRealPath(), $rutacompleta);
            $path = $rutacompleta;
            $parser = new InvoiceParser();
            $xml = file_get_contents($path);
            $factura = $parser->parse($xml);

            if ($factura->getClient()->getnumDoc() != Session::get('empresas')->NRO_DOCUMENTO) {
                return response()->json(
                    [
                        'mensaje' => 'El xml no corresponde a la empresa ' . Session::get('empresas')->NRO_DOCUMENTO,
                        'error' => '1'
                    ]);
            }

            $COD_EMPRESA = '';
            $TXT_EMPRESA = '';
            $SUCCESS = '';
            $MESSAGE = '';
            $ESTADOCP = '';
            $NESTADOCP = '';
            $ESTADORUC = '';
            $NESTADORUC = '';
            $CONDDOMIRUC = '';
            $NCONDDOMIRUC = '';
            $CODIGO_CDR = '';
            $RESPUESTA_CDR = '';

            $empresa_trab = STDEmpresa::where('NRO_DOCUMENTO', '=', $factura->getcompany()->getruc())->first();
            if (count($empresa_trab) > 0) {
                $COD_EMPRESA = $empresa_trab->COD_EMPR;
                $TXT_EMPRESA = $factura->getcompany()->getruc() . ' - ' . $empresa_trab->NOM_EMPR;
            }
            $NUMERO = (int)$factura->getcorrelativo();
            $CORRELATIVO = str_pad($NUMERO, '10', "0", STR_PAD_LEFT);


            $token = '';
            if ($prefijocarperta == 'II') {
                $token = $this->generartoken_ii();
            } else {
                $token = $this->generartoken_is();
            }


            $fechaemision = date_format(date_create($factura->getfechaEmision()->format('Ymd')), 'd/m/Y');
            $rvalidar = $this->validar_xml($token,
                Session::get('empresas')->NRO_DOCUMENTO,
                $factura->getcompany()->getruc(),
                $factura->gettipoDoc(),
                $factura->getserie(),
                $factura->getcorrelativo(),
                $fechaemision,
                $factura->getmtoImpVenta());

            $arvalidar = json_decode($rvalidar, true);
            if (isset($arvalidar['success'])) {
                if ($arvalidar['success']) {
                    $datares = $arvalidar['data'];
                    if (!isset($datares['estadoCp'])) {
                        return response()->json(
                            [
                                'mensaje' => 'Hay fallas en sunat para consultar el XML',
                                'error' => '1'
                            ]);
                    }
                    $estadoCp = $datares['estadoCp'];
                    $tablaestacp = Estado::where('tipo', '=', 'estadoCp')->where('codigo', '=', $estadoCp)->first();
                    $estadoRuc = '';
                    $txtestadoRuc = '';
                    $estadoDomiRuc = '';
                    $txtestadoDomiRuc = '';
                    if (isset($datares['estadoRuc'])) {
                        $tablaestaruc = Estado::where('tipo', '=', 'estadoRuc')->where('codigo', '=', $datares['estadoRuc'])->first();
                        $estadoRuc = $tablaestaruc->codigo;
                        $txtestadoRuc = $tablaestaruc->nombre;
                    }
                    if (isset($datares['condDomiRuc'])) {
                        $tablaestaDomiRuc = Estado::where('tipo', '=', 'condDomiRuc')->where('codigo', '=', $datares['condDomiRuc'])->first();
                        $estadoDomiRuc = $tablaestaDomiRuc->codigo;
                        $txtestadoDomiRuc = $tablaestaDomiRuc->nombre;
                    }

                    $SUCCESS = $arvalidar['success'];
                    $MESSAGE = $arvalidar['message'];
                    $ESTADOCP = $tablaestacp->codigo;
                    $NESTADOCP = $tablaestacp->nombre;
                    $ESTADORUC = $estadoRuc;
                    $NESTADORUC = $txtestadoRuc;
                    $CONDDOMIRUC = $estadoDomiRuc;
                    $NCONDDOMIRUC = $txtestadoDomiRuc;

                } else {

                    $SUCCESS = $arvalidar['success'];
                    $MESSAGE = $arvalidar['message'];
                }
            }

            $DETALLES = [];
            $ind_igv = 'NO';
            $igv = 0;
            $subventa = 0;
            $venta = 0;

            foreach ($factura->getdetails() as $indexdet => $itemdet) {
                $producto = str_replace("<![CDATA[", "", $itemdet->getdescripcion());
                $producto = str_replace("]]>", "", $producto);
                $producto = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);
                $linea = str_pad($indexdet + 1, 3, "0", STR_PAD_LEFT);
                if ((float)$itemdet->getigv() > 0) {
                    $ind_igv = 'SI';
                }
                $igv = $igv + (float)$itemdet->getigv();
                $subventa = $subventa + (float)$itemdet->getmtoValorVenta();
                $venta = $venta + (float)$itemdet->getmtoValorVenta();

            }

            if ($venta == 0) {
                $venta = $factura->getmtoImpVenta();
            }
            $igv = 0;
            if ($ind_igv == 'SI') {
                $igv = $factura->getmtoImpVenta() - $factura->getmtoIGV();
            }
            $subtotal = 0;
            if ($ind_igv == 'SI') {
                $subtotal = $factura->getmtoImpVenta() - $factura->getmtoIGV();
            } else {
                $subtotal = $factura->getmtoImpVenta();
            }


            $linea = str_pad(1, 3, "0", STR_PAD_LEFT);


            $DETALLES[] = [
                'LINEID' => $linea,
                'CODPROD' => '0000001',
                'PRODUCTO' => 'SERVICIO DE FACTURA',
                'UND_PROD' => 'UND',
                'CANTIDAD' => 1,
                'PRECIO_UNIT' => 1,
                'VAL_IGV_ORIG' => $ind_igv,
                'VAL_IGV_SOL' => $igv,
                'VAL_SUBTOTAL_ORIG' => $subtotal,
                'VAL_SUBTOTAL_SOL' => $subtotal,
                'VAL_VENTA_ORIG' => $factura->getmtoImpVenta(),
                'VAL_VENTA_SOL' => $factura->getmtoImpVenta(),
                'PRECIO_ORIG' => $factura->getmtoImpVenta()
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

    public function actionAjaxLeerXmlLGSunat(Request $request)
    {

        $file = $request->file('inputxml');
        $ID_DOCUMENTO = $request['ID_DOCUMENTO'];
        $RUTAXML = $request['RUTAXML'];
        $RUTAPDF = $request['RUTAPDF'];
        $RUTACDR = $request['RUTACDR'];
        $exml = $request['exml'];
        $epdf = $request['epdf'];
        $ecdr = $request['ecdr'];

        $path = $RUTAXML;

        $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);

        $parser = new InvoiceParser();
        $xml = file_get_contents($path);
        $factura = $parser->parse($xml);

        if ($factura->getClient()->getnumDoc() != Session::get('empresas')->NRO_DOCUMENTO) {
            return response()->json(
                [
                    'mensaje' => 'El xml no corresponde a la empresa ' . Session::get('empresas')->NRO_DOCUMENTO,
                    'error' => '1'
                ]);
        }

        $COD_EMPRESA = '';
        $TXT_EMPRESA = '';
        $SUCCESS = '';
        $MESSAGE = '';
        $ESTADOCP = '';
        $NESTADOCP = '';
        $ESTADORUC = '';
        $NESTADORUC = '';
        $CONDDOMIRUC = '';
        $NCONDDOMIRUC = '';
        $CODIGO_CDR = '';
        $RESPUESTA_CDR = '';

        $empresa_trab = STDEmpresa::where('NRO_DOCUMENTO', '=', $factura->getcompany()->getruc())->first();
        if (count($empresa_trab) > 0) {
            $COD_EMPRESA = $empresa_trab->COD_EMPR;
            $TXT_EMPRESA = $factura->getcompany()->getruc() . ' - ' . $empresa_trab->NOM_EMPR;
        }
        $NUMERO = (int)$factura->getcorrelativo();
        $CORRELATIVO = str_pad($NUMERO, '10', "0", STR_PAD_LEFT);


        $token = '';
        if ($prefijocarperta == 'II') {
            $token = $this->generartoken_ii();
        } else {
            $token = $this->generartoken_is();
        }


        $fechaemision = date_format(date_create($factura->getfechaEmision()->format('Ymd')), 'd/m/Y');
        $rvalidar = $this->validar_xml($token,
            Session::get('empresas')->NRO_DOCUMENTO,
            $factura->getcompany()->getruc(),
            $factura->gettipoDoc(),
            $factura->getserie(),
            $factura->getcorrelativo(),
            $fechaemision,
            $factura->getmtoImpVenta());

        $arvalidar = json_decode($rvalidar, true);
        if (isset($arvalidar['success'])) {
            if ($arvalidar['success']) {
                $datares = $arvalidar['data'];
                if (!isset($datares['estadoCp'])) {
                    return response()->json(
                        [
                            'mensaje' => 'Hay fallas en sunat para consultar el XML',
                            'error' => '1'
                        ]);
                }
                $estadoCp = $datares['estadoCp'];
                $tablaestacp = Estado::where('tipo', '=', 'estadoCp')->where('codigo', '=', $estadoCp)->first();
                $estadoRuc = '';
                $txtestadoRuc = '';
                $estadoDomiRuc = '';
                $txtestadoDomiRuc = '';
                if (isset($datares['estadoRuc'])) {
                    $tablaestaruc = Estado::where('tipo', '=', 'estadoRuc')->where('codigo', '=', $datares['estadoRuc'])->first();
                    $estadoRuc = $tablaestaruc->codigo;
                    $txtestadoRuc = $tablaestaruc->nombre;
                }
                if (isset($datares['condDomiRuc'])) {
                    $tablaestaDomiRuc = Estado::where('tipo', '=', 'condDomiRuc')->where('codigo', '=', $datares['condDomiRuc'])->first();
                    $estadoDomiRuc = $tablaestaDomiRuc->codigo;
                    $txtestadoDomiRuc = $tablaestaDomiRuc->nombre;
                }

                $SUCCESS = $arvalidar['success'];
                $MESSAGE = $arvalidar['message'];
                $ESTADOCP = $tablaestacp->codigo;
                $NESTADOCP = $tablaestacp->nombre;
                $ESTADORUC = $estadoRuc;
                $NESTADORUC = $txtestadoRuc;
                $CONDDOMIRUC = $estadoDomiRuc;
                $NCONDDOMIRUC = $txtestadoDomiRuc;

            } else {

                $SUCCESS = $arvalidar['success'];
                $MESSAGE = $arvalidar['message'];
            }
        }

        $DETALLES = [];
        $UNIDAD = "";
        $getmtoValorVenta = 0;
        $getigv = 0;


        $otrostributos = (float)$factura->getmtoOtrosTributos();

        foreach ($factura->getdetails() as $indexdet => $itemdet) {
            $producto = str_replace("<![CDATA[", "", $itemdet->getdescripcion());
            $producto = str_replace("]]>", "", $producto);
            $producto = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);
            $linea = str_pad($indexdet + 1, 3, "0", STR_PAD_LEFT);
            $ind_igv = 'NO';
            if ((float)$itemdet->getigv() > 0) {
                $ind_igv = 'SI';
            }
            $UNIDAD = $itemdet->getunidad();
            $getmtoValorVenta = $getmtoValorVenta + $itemdet->getmtoValorVenta();
            $getigv = $getigv + $itemdet->getigv();

        }

        $DETALLES[] = [
            'LINEID' => '001',
            'CODPROD' => "PRD000000000001",
            'PRODUCTO' => "DETALLE DE LA FACTURA",
            'UND_PROD' => $UNIDAD,
            'CANTIDAD' => 1,
            'PRECIO_UNIT' => (float)$getmtoValorVenta,
            'VAL_IGV_ORIG' => $ind_igv,
            'VAL_IGV_SOL' => (float)$getigv,
            'VAL_SUBTOTAL_ORIG' => (float)$getmtoValorVenta,
            'VAL_SUBTOTAL_SOL' => (float)$getmtoValorVenta,
            'VAL_VENTA_ORIG' => (float)$getigv + (float)$getmtoValorVenta + $otrostributos,
            'VAL_VENTA_SOL' => (float)$getigv + (float)$getmtoValorVenta + $otrostributos,
            'PRECIO_ORIG' => (float)$getmtoValorVenta
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
            'TOTAL_VENTA_ORIG' => (float)$getigv + (float)$getmtoValorVenta + $otrostributos,
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


    public function actionAgregarNuevoFormato(Request $request)
    {

        $resultado = DB::table('LQG_DETLIQUIDACIONGASTO as lqg')
            ->join('PLA_MOVILIDAD as pla', 'lqg.COD_PLA_MOVILIDAD', '=', 'pla.ID_DOCUMENTO')
            ->where('lqg.COD_TIPODOCUMENTO', 'TDO0000000000070')
            //->where('lqg.ID_DOCUMENTO','=','LIQG00000052')
            ->select('lqg.*') // o select específico si necesitas columnas concretas
            ->get();

        //dd($resultado);

        foreach ($resultado as $index => $item) {

            $documento_planilla = $item->COD_PLA_MOVILIDAD;
            $data_iddocumento = $item->ID_DOCUMENTO;

            $detliquidaciongasto = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $data_iddocumento)->first();
            $useario_autoriza = User::where('id', '=', $detliquidaciongasto->COD_USUARIO_AUTORIZA)->first();
            $planillamovilidad = DB::table('PLA_MOVILIDAD')
                ->where('ID_DOCUMENTO', $documento_planilla)
                ->first();
            $COD_CUENTA = '';
            $TXT_CUENTA = '';


            $contratos = DB::table('CMP.CONTRATO')
                ->where('COD_EMPR_CLIENTE', 'IACHEM0000009164')
                ->where('COD_EMPR', $planillamovilidad->COD_EMPRESA)
                ->where('COD_CENTRO', $planillamovilidad->COD_CENTRO)
                ->first();


            if (count($contratos) > 0) {
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
                $COD_CUENTA = $contratos->COD_CONTRATO;
                $TXT_CUENTA = $contrato;
                $subcontrato = DB::table('CMP.CONTRATO_CULTIVO')
                    ->selectRaw("
                                                        COD_CONTRATO,
                                                        TXT_ZONA_COMERCIAL+'-'+TXT_ZONA_CULTIVO as TXT_CULTIVO
                                                    ")
                    ->where('COD_CONTRATO', $COD_CUENTA)
                    ->first();
                $COD_SUBCUENTA = $subcontrato->COD_CONTRATO;
                $TXT_SUBCUENTA = $subcontrato->TXT_CULTIVO;
            }

            //GUARDAR PDF
            $iddocumento = $documento_planilla;
            $planillamovilidad = PlaMovilidad::where('ID_DOCUMENTO', '=', $iddocumento)->first();
            $detplanillamovilidad = PlaDetMovilidad::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->orderby('FECHA_GASTO', 'ASC')->get();
            $empresa = STDEmpresa::where('COD_EMPR', '=', $planillamovilidad->COD_EMPRESA)->first();
            $ruc = $empresa->NRO_DOCUMENTO;
            $prefijocarperta = $this->prefijo_empresa($item->COD_EMPRESA);
            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $data_iddocumento;
            $valor = $this->versicarpetanoexiste($rutafile);
            $rutacompleta = $rutafile . '\\' . $planillamovilidad->SERIE . '-' . $planillamovilidad->NUMERO . '.pdf';
            $nombrearchivo = $planillamovilidad->SERIE . '-' . $planillamovilidad->NUMERO . '.pdf';
            $glosa = $planillamovilidad->TXT_GLOSA;

            $trabajador = STDTrabajador::where('COD_TRAB', '=', $planillamovilidad->COD_TRABAJADOR)->first();
            $imgresponsable = 'firmas/blanco.jpg';
            $nombre_responsable = '';
            $rutaImagen = public_path('firmas/' . $trabajador->NRO_DOCUMENTO . '.jpg');
            $sw = 0;
            if (file_exists($rutaImagen)) {
                $imgresponsable = 'firmas/' . $trabajador->NRO_DOCUMENTO . '.jpg';
                $nombre_responsable = $trabajador->TXT_NOMBRES . ' ' . $trabajador->TXT_APE_PATERNO . ' ' . $trabajador->TXT_APE_MATERNO;
            } else {
                $sw = 1;
                print_r('TRABAJADOR : ' . $trabajador->TXT_NOMBRES . ' ' . $trabajador->TXT_APE_PATERNO . ' ' . $trabajador->TXT_APE_MATERNO . '<br>');
            }

            $trabajadorap = STDTrabajador::where('COD_TRAB', '=', $useario_autoriza->usuarioosiris_id)->first();
            $imgaprueba = 'firmas/blanco.jpg';
            $nombre_aprueba = '';
            $rutaImagen = public_path('firmas/' . $trabajadorap->NRO_DOCUMENTO . '.jpg');


            $direccion = $this->gn_direccion_fiscal();
            //DD($rutacompleta);
            $pdf = PDF::loadView('pdffa.planillamovilidad', [
                'iddocumento' => $iddocumento,
                'planillamovilidad' => $planillamovilidad,
                'detplanillamovilidad' => $detplanillamovilidad,
                'ruc' => $ruc,
                'imgresponsable' => $imgresponsable,
                'nombre_responsable' => $nombre_responsable,
                'imgaprueba' => $imgaprueba,
                'nombre_aprueba' => $nombre_aprueba,
                'direccion' => $direccion,

            ])->setPaper('A4', 'landscape');

            $pdf->save($rutacompleta);


        }

    }


    public function actionModalSelectDocumentoPlanillaLG(Request $request)
    {

        $documento_planilla = $request['documento_planilla'];
        $data_iddocumento = $request['data_iddocumento'];
        $detliquidaciongasto = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $data_iddocumento)->first();


        $useario_autoriza = User::where('id', '=', $detliquidaciongasto->COD_USUARIO_AUTORIZA)->first();


        $planillamovilidad = DB::table('PLA_MOVILIDAD')
            ->where('ID_DOCUMENTO', $documento_planilla)
            ->first();

        $COD_CUENTA = '';
        $TXT_CUENTA = '';


        $contratos = DB::table('CMP.CONTRATO')
            ->where('COD_EMPR_CLIENTE', 'IACHEM0000009164')
            ->where('COD_EMPR', $planillamovilidad->COD_EMPRESA)
            ->where('COD_CENTRO', $planillamovilidad->COD_CENTRO)
            ->first();


        if (count($contratos) > 0) {
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
            $COD_CUENTA = $contratos->COD_CONTRATO;
            $TXT_CUENTA = $contrato;
            $subcontrato = DB::table('CMP.CONTRATO_CULTIVO')
                ->selectRaw("
                                                    COD_CONTRATO,
                                                    TXT_ZONA_COMERCIAL+'-'+TXT_ZONA_CULTIVO as TXT_CULTIVO
                                                ")
                ->where('COD_CONTRATO', $COD_CUENTA)
                ->first();
            $COD_SUBCUENTA = $subcontrato->COD_CONTRATO;
            $TXT_SUBCUENTA = $subcontrato->TXT_CULTIVO;
        }

        //GUARDAR PDF
        $iddocumento = $documento_planilla;
        $planillamovilidad = PlaMovilidad::where('ID_DOCUMENTO', '=', $iddocumento)->first();
        $detplanillamovilidad = PlaDetMovilidad::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->orderby('FECHA_GASTO', 'ASC')->get();
        $empresa = STDEmpresa::where('COD_EMPR', '=', $planillamovilidad->COD_EMPRESA)->first();
        $ruc = $empresa->NRO_DOCUMENTO;
        $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $data_iddocumento;
        $valor = $this->versicarpetanoexiste($rutafile);
        $rutacompleta = $rutafile . '\\' . $planillamovilidad->SERIE . '-' . $planillamovilidad->NUMERO . '.pdf';
        $nombrearchivo = $planillamovilidad->SERIE . '-' . $planillamovilidad->NUMERO . '.pdf';
        $glosa = $planillamovilidad->TXT_GLOSA;

        $trabajador = STDTrabajador::where('COD_TRAB', '=', $planillamovilidad->COD_TRABAJADOR)->first();
        $imgresponsable = 'firmas/blanco.jpg';
        $nombre_responsable = '';
        $rutaImagen = public_path('firmas/' . $trabajador->NRO_DOCUMENTO . '.jpg');
        if (file_exists($rutaImagen)) {
            $imgresponsable = 'firmas/' . $trabajador->NRO_DOCUMENTO . '.jpg';
            $nombre_responsable = $trabajador->TXT_NOMBRES . ' ' . $trabajador->TXT_APE_PATERNO . ' ' . $trabajador->TXT_APE_MATERNO;
        }
        $trabajadorap = STDTrabajador::where('COD_TRAB', '=', $useario_autoriza->usuarioosiris_id)->first();
        $imgaprueba = 'firmas/blanco.jpg';
        $nombre_aprueba = '';
        $rutaImagen = public_path('firmas/' . $trabajadorap->NRO_DOCUMENTO . '.jpg');
        if (file_exists($rutaImagen)) {
            $imgaprueba = 'firmas/' . $trabajadorap->NRO_DOCUMENTO . '.jpg';
            $nombre_aprueba = $trabajadorap->TXT_NOMBRES . ' ' . $trabajadorap->TXT_APE_PATERNO . ' ' . $trabajadorap->TXT_APE_MATERNO;
        }
        $direccion = $this->gn_direccion_fiscal();


        $pdf = PDF::loadView('pdffa.planillamovilidad', [
            'iddocumento' => $iddocumento,
            'planillamovilidad' => $planillamovilidad,
            'detplanillamovilidad' => $detplanillamovilidad,
            'ruc' => $ruc,
            'imgresponsable' => $imgresponsable,
            'nombre_responsable' => $nombre_responsable,
            'imgaprueba' => $imgaprueba,
            'nombre_aprueba' => $nombre_aprueba,
            'direccion' => $direccion,
        ])->setPaper('A4', 'landscape');

        $pdf->save($rutacompleta);


        return response()->json([
            'EMPRESA' => 'PLANILLA DE MOVILIDAD SIN COMPROBANTE',
            'SERIE' => $planillamovilidad->SERIE,
            'NUMERO' => $planillamovilidad->NUMERO,
            'COD_CUENTA' => $COD_CUENTA,
            'TXT_CUENTA' => $TXT_CUENTA,
            'COD_SUBCUENTA' => $COD_SUBCUENTA,
            'TXT_SUBCUENTA' => $TXT_SUBCUENTA,
            'COD_PLANILLA' => $planillamovilidad->ID_DOCUMENTO,
            'FECHA_EMI' => date_format(date_create($planillamovilidad->FECHA_EMI), 'd-m-Y'),
            'TOTAL' => $planillamovilidad->TOTAL,
            'rutacompleta' => $rutacompleta,
            'glosa' => $glosa,
            'nombrearchivo' => $nombrearchivo
        ]);


    }


    public function actionModalBuscarPlanillaLG(Request $request)
    {

        $iddocumento = $request['data_iddocumento'];
        $idopcion = $request['idopcion'];
        $detliquidaciongasto = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
        $funcion = $this;
        $fecha_fin = $this->fecha_sin_hora;

        $lpmovilidades = DB::table('PLA_MOVILIDAD')
            ->where('USUARIO_CREA', Session::get('usuario')->id)
            ->where('ACTIVO', '=', '1')
            ->where('COD_ESTADO', '=', 'ETM0000000000008')
            ->where('COD_EMPRESA', $detliquidaciongasto->COD_EMPRESA)
            ->whereNotIn('ID_DOCUMENTO', function ($query) {
                $query->select(DB::raw('ISNULL(COD_PLA_MOVILIDAD, \'\')'))
                    ->from('LQG_DETLIQUIDACIONGASTO')
                    ->where('ACTIVO', '=', '1'); // Agregar esta condición
            })
            ->get();


        return View::make('liquidaciongasto/modal/ajax/mlistaplanillamovilidad',
            [
                'iddocumento' => $iddocumento,
                'idopcion' => $idopcion,
                'lpmovilidades' => $lpmovilidades,
                'funcion' => $funcion,
                'ajax' => true,
            ]);
    }


    public function actionAprobarAdministracionLG($idopcion, $iddocumento, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        View::share('titulo', 'Aprobar Liquidacion de Gastos Administracion');

        if ($_POST) {
            try {

                DB::beginTransaction();



                $fedocumento_ap = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('COD_ESTADO','<>','ETM0000000000004')->first();
                if (count($fedocumento_ap)>0) {
                    return Redirect::back()->with('errorurl', 'El documento esta aprobado');
                }



                $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();


                if ($liquidaciongastos->IND_OBSERVACION == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }
                //VALIDAR SI TIENE SERIE
                $COD_TRAB = '';
                $SERIE = '';

                $trabajadormerge = DB::table('STD.TRABAJADOR')
                    ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                    ->first();
                $trabajador = DB::table('STD.TRABAJADOR')
                    ->where('NRO_DOCUMENTO', $trabajadormerge->NRO_DOCUMENTO)
                    ->where('COD_EMPR', $liquidaciongastos->COD_EMPRESA)
                    ->first();
                if (count($trabajador) > 0) {
                    $COD_TRAB = $trabajador->COD_TRAB;
                }
                $resultados_serie = DB::table('CMP.REFERENCIA_ASOC as RA')
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

                if (count($resultados_serie) <= 0) {

                    return Redirect::to('aprobar-liquidacion-gasto-administracion/' . $idopcion . '/' . $idcab)->with('errorbd', 'Su Usuario no cuenta con serie para esta CENTRO Y EMPRESA');
                }

                $NUMERO = 0;
                $SERIE = $resultados_serie->NRO_SERIE;


                $conexionbd         = 'sqlsrv';
                if($liquidaciongastos->COD_CENTRO == 'CEN0000000000004'){ //rioja
                    $conexionbd         = 'sqlsrv_r';
                }else{
                    if($liquidaciongastos->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                        $conexionbd         = 'sqlsrv_b';
                    }
                }

                $resultado_correlativo = DB::connection($conexionbd)->table('CMP.DOCUMENTO_CTBLE as TBL')
                    ->select('TBL.COD_DOCUMENTO_CTBLE', 'TBL.NRO_SERIE', 'TBL.NRO_DOC')
                    ->where('TBL.COD_DOCUMENTO_CTBLE', function ($query) use ($liquidaciongastos, $resultados_serie) {
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


                $NUMERO = (int)$resultado_correlativo->NRO_DOC + 1;
                $CORRELATIVO = str_pad($NUMERO, '10', "0", STR_PAD_LEFT);
                $descripcion = $request['descripcion'];
                if (rtrim(ltrim($descripcion)) != '') {
                    //HISTORIAL DE DOCUMENTO APROBADO
                    $documento = new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                    $documento->DOCUMENTO_ITEM = 1;
                    $documento->FECHA = $this->fechaactual;
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'ACOTACION POR EL ADMINISTRACION';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();
                }

                LqgLiquidacionGasto::where('ID_DOCUMENTO', $liquidaciongastos->ID_DOCUMENTO)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000005',
                            'TXT_ESTADO' => 'APROBADO',
                            'COD_ADM_APRUEBA' => Session::get('usuario')->id,
                            'TXT_ADM_APRUEBA' => Session::get('usuario')->nombre,
                            'FECHA_ADM_APRUEBA' => $this->fechaactual
                        ]
                    );
                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = 1;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR ADMINISTRACION';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'APROBADO POR ADMINISTRACION');
                //geolocalización


                $anio = $this->anio;
                $mes = $this->mes;
                $periodo = $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);

                $tdetliquidaciongastos_sinaereo = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->whereRaw("ISNULL(IND_OSIRIS, 0) <> 1")->where('ACTIVO', '=', '1')->get();

                $osiris = $this->lg_enviar_osiris($liquidaciongastos, $tdetliquidaciongastos_sinaereo, $detdocumentolg, $SERIE, $CORRELATIVO, $periodo);

                LqgLiquidacionGasto::where('ID_DOCUMENTO', $liquidaciongastos->ID_DOCUMENTO)
                    ->update(
                        [
                            'COD_OSIRIS' => $osiris,
                        ]
                    );
                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-administracion/' . $idopcion)->with('bienhecho', 'LIQUIDACION DE GASTOS (' . $osiris . ') : ' . $liquidaciongastos->CODIGO . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('/aprobar-liquidacion-gasto-administracion/' . $idopcion . '/' . $idcab)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        } else {


            $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
            //$tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();

            $tdetliquidaciongastos = DB::table('LQG_DETLIQUIDACIONGASTO')
                ->join('CMP.CONTRATO', 'LQG_DETLIQUIDACIONGASTO.COD_CUENTA', '=', 'CMP.CONTRATO.COD_CONTRATO')
                ->select('CMP.CONTRATO.TXT_CATEGORIA_MONEDA', 'LQG_DETLIQUIDACIONGASTO.*', 'CMP.CONTRATO.COD_CONTRATO')
                ->where('LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO', '=', $iddocumento)
                ->where('LQG_DETLIQUIDACIONGASTO.ACTIVO', '=', '1')
                ->get();


            $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
            $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
            $tdetliquidaciongastosel = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '0')->get();
            $archivospdf = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('EXTENSION', 'like', '%' . 'pdf' . '%')->get();
            $ocultar = "";
            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]);
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
                    'downloadUrl' => route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]),
                    'frameClass' => $archivo->ID_DOCUMENTO . $archivo->DOCUMENTO_ITEM . ' ' . $valor //
                ];
            }


            $productosagru = DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
                ->select('COD_PRODUCTO', 'TXT_PRODUCTO', DB::raw('SUM(CANTIDAD) as CANTIDAD'), DB::raw('SUM(TOTAL) as TOTAL'))
                ->where('ID_DOCUMENTO', $iddocumento)
                ->where('ACTIVO', 1)
                ->groupBy('COD_PRODUCTO', 'TXT_PRODUCTO')
                ->get();

            $archivos = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
            $indicador = 0;
            $listaarendirlg = $this->lg_lista_arendirlg($liquidaciongastos,$indicador);
            //dd($listaarendirlg);

            $valearendir_info = $this->lq_valearendir($liquidaciongastos->ID_DOCUMENTO);


            return View::make('liquidaciongasto/aprobaradministracionlg',
                [
                    'liquidaciongastos' => $liquidaciongastos,
                    'indicador' => $indicador,
                    'valearendir_info' => $valearendir_info,
                    'listaarendirlg' => $listaarendirlg,
                    'tdetliquidaciongastos' => $tdetliquidaciongastos,
                    'tdetliquidaciongastosel' => $tdetliquidaciongastosel,
                    'productosagru' => $productosagru,
                    'archivos' => $archivos,
                    'detdocumentolg' => $detdocumentolg,
                    'documentohistorial' => $documentohistorial,
                    'idopcion' => $idopcion,
                    'idcab' => $idcab,
                    'iddocumento' => $iddocumento,
                    'initialPreview' => json_encode($initialPreview),
                    'initialPreviewConfig' => json_encode($initialPreviewConfig),
                ]);


        }
    }


    public function actionRegularizarVacios(Request $request)
    {

        $iddocumento = 'IILMLG0000006967';
        $liquidaciongastos = LqgLiquidacionGasto::where('COD_OSIRIS', '=', $iddocumento)->first();
        $iddocumento = $liquidaciongastos->ID_DOCUMENTO;        
        $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
        $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
        $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
        $tdetliquidaciongastos_sinaereo = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->whereRaw("ISNULL(IND_OSIRIS, 0) <> 1")->where('ACTIVO', '=', '1')->get();
        $documento = DB::table('CMP.DOCUMENTO_CTBLE')
            ->select('COD_PERIODO', DB::raw('*'))
            ->where('COD_DOCUMENTO_CTBLE', $liquidaciongastos->COD_OSIRIS)
            ->first();
        $periodo = CONPeriodo::where('COD_PERIODO', '=', $documento->COD_PERIODO)->first();
        $osiris = $this->lg_enviar_osiris_vacios($liquidaciongastos, $tdetliquidaciongastos_sinaereo, $detdocumentolg,$periodo);

    }

    public function actionAprobarContabilidadLG($idopcion, $iddocumento, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        View::share('titulo', 'Aprobar Liquidacion de Gastos Contabilidad');

        $contador_cabecera = 0;

        if ($_POST) {
            try {

                DB::beginTransaction();


                $fedocumento_ap = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('COD_ESTADO','<>','ETM0000000000003')->first();
                if (count($fedocumento_ap)>0) {
                    return Redirect::back()->with('errorurl', 'El documento esta aprobado');
                }


                $detalles = $request->input('detalles');

                $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();

                foreach ($detalles as $detalle) {

                    $cabecera = json_decode($detalle['cabecera'], true);
                    $detalle_asiento = json_decode($detalle['detalle'], true);

                    foreach ($cabecera as $detalle) {

                        $asiento_busqueda = WEBAsiento::where('TXT_REFERENCIA', '=', $detalle['TXT_REFERENCIA'])
                            ->where('COD_ESTADO', '=', 1)
                            ->where('COD_ASIENTO_MODELO', '=', $detalle['COD_ASIENTO_MODELO'])
                            ->where('COD_CATEGORIA_TIPO_ASIENTO', '=', $detalle['COD_CATEGORIA_TIPO_ASIENTO'])
                            ->first();

                        $contador_cabecera = $contador_cabecera + 1;
                        $COD_ASIENTO = $detalle['COD_ASIENTO'];
                        $COD_EMPR = $detalle['COD_EMPR'];
                        $COD_EMPR_CLI = $detalle['COD_EMPR_CLI'];
                        $TXT_EMPR_CLI = $detalle['TXT_EMPR_CLI'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO = $detalle['COD_CATEGORIA_TIPO_DOCUMENTO'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO = $detalle['TXT_CATEGORIA_TIPO_DOCUMENTO'];
                        $NRO_SERIE = $detalle['NRO_SERIE'];
                        $NRO_DOC = $detalle['NRO_DOC'];
                        $COD_CENTRO = $detalle['COD_CENTRO'];
                        $COD_PERIODO = $detalle['COD_PERIODO'];
                        $COD_CATEGORIA_TIPO_ASIENTO = $detalle['COD_CATEGORIA_TIPO_ASIENTO'];
                        $TXT_CATEGORIA_TIPO_ASIENTO = $detalle['TXT_CATEGORIA_TIPO_ASIENTO'];
                        $NRO_ASIENTO = $detalle['NRO_ASIENTO'];
                        $FEC_ASIENTO = $detalle['FEC_ASIENTO'];
                        $TXT_GLOSA = $detalle['TXT_GLOSA'];
                        $COD_CATEGORIA_ESTADO_ASIENTO = $detalle['COD_CATEGORIA_ESTADO_ASIENTO'];
                        $TXT_CATEGORIA_ESTADO_ASIENTO = $detalle['TXT_CATEGORIA_ESTADO_ASIENTO'];
                        $COD_CATEGORIA_MONEDA = $detalle['COD_CATEGORIA_MONEDA'];
                        $TXT_CATEGORIA_MONEDA = $detalle['TXT_CATEGORIA_MONEDA'];
                        $CAN_TIPO_CAMBIO = $detalle['CAN_TIPO_CAMBIO'];
                        $CAN_TOTAL_DEBE = $detalle['CAN_TOTAL_DEBE'];
                        $CAN_TOTAL_HABER = $detalle['CAN_TOTAL_HABER'];
                        $COD_ASIENTO_EXTORNO = $detalle['COD_ASIENTO_EXTORNO'];
                        $COD_ASIENTO_EXTORNADO = $detalle['COD_ASIENTO_EXTORNADO'];
                        $IND_EXTORNO = $detalle['IND_EXTORNO'];
                        $IND_ANULADO = $detalle['IND_ANULADO'];
                        $COD_ASIENTO_MODELO = $detalle['COD_ASIENTO_MODELO'];
                        $COD_OBJETO_ORIGEN = $detalle['COD_OBJETO_ORIGEN'];
                        $TXT_TIPO_REFERENCIA = $detalle['TXT_TIPO_REFERENCIA'];
                        $TXT_REFERENCIA = $detalle['TXT_REFERENCIA'];
                        $COD_USUARIO_CREA_AUD = $detalle['COD_USUARIO_CREA_AUD'];
                        $FEC_USUARIO_CREA_AUD = $detalle['FEC_USUARIO_CREA_AUD'];
                        $COD_USUARIO_MODIF_AUD = $detalle['COD_USUARIO_MODIF_AUD'];
                        $FEC_USUARIO_MODIF_AUD = $detalle['FEC_USUARIO_MODIF_AUD'];
                        $COD_ESTADO = $detalle['COD_ESTADO'];
                        $COD_MOTIVO_EXTORNO = $detalle['COD_MOTIVO_EXTORNO'];
                        $GLOSA_EXTORNO = $detalle['GLOSA_EXTORNO'];
                        $COD_CATEGORIA_TIPO_DETRACCION = $detalle['COD_CATEGORIA_TIPO_DETRACCION'];
                        $FEC_DETRACCION = $detalle['FEC_DETRACCION'];
                        $NRO_DETRACCION = $detalle['NRO_DETRACCION'];
                        $CAN_DESCUENTO_DETRACCION = $detalle['CAN_DESCUENTO_DETRACCION'];
                        $CAN_TOTAL_DETRACCION = $detalle['CAN_TOTAL_DETRACCION'];
                        $COD_CATEGORIA_TIPO_DOCUMENTO_REF = $detalle['COD_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $TXT_CATEGORIA_TIPO_DOCUMENTO_REF = $detalle['TXT_CATEGORIA_TIPO_DOCUMENTO_REF'];
                        $NRO_SERIE_REF = $detalle['NRO_SERIE_REF'];
                        $NRO_DOC_REF = $detalle['NRO_DOC_REF'];
                        $FEC_VENCIMIENTO = $detalle['FEC_VENCIMIENTO'];
                        $IND_AFECTO = $detalle['IND_AFECTO'];
                        $COD_ASIENTO_PAGO_COBRO = $detalle['COD_ASIENTO_PAGO_COBRO'];
                        $SALDO = $detalle['SALDO'];
                        $COD_CATEGORIA_MONEDA_CONVERSION = $detalle['COD_CATEGORIA_MONEDA_CONVERSION'];
                        $TXT_CATEGORIA_MONEDA_CONVERSION = $detalle['TXT_CATEGORIA_MONEDA_CONVERSION'];
                        $IND_MIGRACION_NAVASOFT = $detalle['IND_MIGRACION_NAVASOFT'];
                        $COND_ASIENTO = $detalle['COND_ASIENTO'];
                        $CODIGO_CONTABLE = $detalle['CODIGO_CONTABLE'];
                        $TOTAL_BASE_IMPONIBLE = $detalle['TOTAL_BASE_IMPONIBLE'];
                        $TOTAL_BASE_IMPONIBLE_10 = $detalle['TOTAL_BASE_IMPONIBLE_10'];
                        $TOTAL_BASE_INAFECTA = $detalle['TOTAL_BASE_INAFECTA'];
                        $TOTAL_BASE_EXONERADA = $detalle['TOTAL_BASE_EXONERADA'];
                        $TOTAL_IGV = $detalle['TOTAL_IGV'];
                        $TOTAL_AFECTO_IVAP = $detalle['TOTAL_AFECTO_IVAP'];
                        $TOTAL_IVAP = $detalle['TOTAL_IVAP'];
                        $TOTAL_OTROS_IMPUESTOS = $detalle['TOTAL_OTROS_IMPUESTOS'];

                        $moneda_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();
                        $moneda_asiento_conversion_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_MONEDA)->first();

                        if ($moneda_asiento_aux->CODIGO_SUNAT !== 'PEN') {
                            $moneda_asiento_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'PEN')->first();
                            $moneda_asiento_conversion_aux = CMPCategoria::where('TXT_GRUPO', '=', 'MONEDA')->where('COD_ESTADO', '=', 1)->where('CODIGO_SUNAT', '=', 'USD')->first();
                        }

                        $empresa_doc_asiento_aux = STDEmpresa::where('COD_ESTADO', '=', 1)->where('COD_EMPR', '=', $COD_EMPR_CLI)->first();
//                        $tipo_doc_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
//                        $tipo_doc_ref_asiento_aux = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_doc_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO)->first();
                        $tipo_doc_ref_asiento_aux = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $COD_CATEGORIA_TIPO_DOCUMENTO_REF)->first();
                        $tipo_asiento = CMPCategoria::where('COD_CATEGORIA', '=', $COD_CATEGORIA_TIPO_ASIENTO)->first();

                        if (empty($asiento_busqueda)) {
                            $codAsiento = $this->ejecutarAsientosIUDConSalida(
                                'I',
                                Session::get('empresas')->COD_EMPR,
                                $liquidaciongastos->COD_CENTRO,
                                $COD_PERIODO,
                                $tipo_asiento->COD_CATEGORIA,
                                $tipo_asiento->NOM_CATEGORIA,
                                '',
                                $FEC_ASIENTO,
                                $TXT_GLOSA,
                                $COD_CATEGORIA_ESTADO_ASIENTO,
                                $TXT_CATEGORIA_ESTADO_ASIENTO,
                                $moneda_asiento_aux->COD_CATEGORIA,
                                $moneda_asiento_aux->NOM_CATEGORIA,
                                $CAN_TIPO_CAMBIO,
                                0.0000,
                                0.0000,
                                '',
                                '',
                                0,
                                $COD_ASIENTO_MODELO,
                                $TXT_TIPO_REFERENCIA,
                                $TXT_REFERENCIA . '-' . $CODIGO_CONTABLE,
                                1,
                                Session::get('usuario')->id,
                                '',
                                '',
                                $empresa_doc_asiento_aux->COD_EMPR,
                                $empresa_doc_asiento_aux->NOM_EMPR,
                                $tipo_doc_asiento_aux->COD_TIPO_DOCUMENTO,
                                $tipo_doc_asiento_aux->TXT_TIPO_DOCUMENTO,
                                $NRO_SERIE,
                                $NRO_DOC,
                                $FEC_DETRACCION,
                                $NRO_DETRACCION,
                                $CAN_DESCUENTO_DETRACCION,
                                $CAN_TOTAL_DETRACCION,
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->COD_TIPO_DOCUMENTO : '',
                                isset($tipo_doc_ref_asiento_aux) ? $tipo_doc_ref_asiento_aux->TXT_TIPO_DOCUMENTO : '',
                                $NRO_SERIE_REF,
                                $NRO_DOC_REF,
                                $FEC_VENCIMIENTO,
                                0,
                                $moneda_asiento_conversion_aux->COD_CATEGORIA,
                                $moneda_asiento_conversion_aux->NOM_CATEGORIA
                            );
                        } else {
                            $codAsiento = '';
                        }
                    }

                    if (!empty($codAsiento)) {
                        $contador = 0;
                        foreach ($detalle_asiento as $movimiento) {
                            $COD_ASIENTO_MOVIMIENTO = $movimiento['COD_ASIENTO_MOVIMIENTO'];
                            $COD_EMPR = $movimiento['COD_EMPR'];
                            $COD_CENTRO = $movimiento['COD_CENTRO'];
                            $COD_ASIENTO = $movimiento['COD_ASIENTO'];
                            $COD_CUENTA_CONTABLE = $movimiento['COD_CUENTA_CONTABLE'];
                            $IND_PRODUCTO = $movimiento['IND_PRODUCTO'];
                            $TXT_CUENTA_CONTABLE = $movimiento['TXT_CUENTA_CONTABLE'];
                            $TXT_GLOSA = $movimiento['TXT_GLOSA'];
                            $CAN_DEBE_MN = $movimiento['CAN_DEBE_MN'];
                            $CAN_HABER_MN = $movimiento['CAN_HABER_MN'];
                            $CAN_DEBE_ME = $movimiento['CAN_DEBE_ME'];
                            $CAN_HABER_ME = $movimiento['CAN_HABER_ME'];
                            $NRO_LINEA = $movimiento['NRO_LINEA'];
                            $COD_CUO = $movimiento['COD_CUO'];
                            $IND_EXTORNO = $movimiento['IND_EXTORNO'];
                            $TXT_TIPO_REFERENCIA = $movimiento['TXT_TIPO_REFERENCIA'];
                            $TXT_REFERENCIA = $movimiento['TXT_REFERENCIA'];
                            $COD_USUARIO_CREA_AUD = $movimiento['COD_USUARIO_CREA_AUD'];
                            $FEC_USUARIO_CREA_AUD = $movimiento['FEC_USUARIO_CREA_AUD'];
                            $COD_USUARIO_MODIF_AUD = $movimiento['COD_USUARIO_MODIF_AUD'];
                            $FEC_USUARIO_MODIF_AUD = $movimiento['FEC_USUARIO_MODIF_AUD'];
                            $COD_ESTADO = $movimiento['COD_ESTADO'];
                            $COD_DOC_CTBLE_REF = $movimiento['COD_DOC_CTBLE_REF'];
                            $COD_ORDEN_REF = $movimiento['COD_ORDEN_REF'];
                            $COD_PRODUCTO = $movimiento['COD_PRODUCTO'];
                            $TXT_NOMBRE_PRODUCTO = $movimiento['TXT_NOMBRE_PRODUCTO'];
                            $COD_LOTE = $movimiento['COD_LOTE'];
                            $NRO_LINEA_PRODUCTO = $movimiento['NRO_LINEA_PRODUCTO'];
                            $COD_EMPR_CLI_REF = $movimiento['COD_EMPR_CLI_REF'];
                            $TXT_EMPR_CLI_REF = $movimiento['TXT_EMPR_CLI_REF'];
                            $DOCUMENTO_REF = $movimiento['DOCUMENTO_REF'];
                            $CODIGO_CONTABLE = $movimiento['CODIGO_CONTABLE'];
                            if (((int)$COD_ESTADO) === 1) {
                                $contador++;

                                $params = array(
                                    'op' => 'I',
                                    'empresa' => Session::get('empresas')->COD_EMPR,
                                    'centro' => 'CEN0000000000001',
                                    'asiento' => $codAsiento,
                                    'cuenta' => $COD_CUENTA_CONTABLE,
                                    'txtCuenta' => $TXT_CUENTA_CONTABLE,
                                    'glosa' => $TXT_GLOSA,
                                    'debeMN' => $CAN_DEBE_MN,
                                    'haberMN' => $CAN_HABER_MN,
                                    'debeME' => $CAN_DEBE_ME,
                                    'haberME' => $CAN_HABER_ME,
                                    'linea' => $contador,
                                    'codCuo' => '',
                                    'indExtorno' => 0,
                                    'txtTipoReferencia' => '',
                                    'txtReferencia' => '',
                                    'codEstado' => $COD_ESTADO,
                                    'codUsuario' => Session::get('usuario')->id,
                                    'codDocCtableRef' => $COD_DOC_CTBLE_REF,
                                    'codOrdenRef' => $COD_ORDEN_REF,
                                    'indProducto' => $COD_DOC_CTBLE_REF !== '' ? 1 : 0,
                                    'codProducto' => $COD_PRODUCTO,
                                    'txtNombreProducto' => $TXT_NOMBRE_PRODUCTO,
                                    'codLote' => $COD_LOTE,
                                    'nroLineaProducto' => $NRO_LINEA_PRODUCTO,
                                );

                                $this->ejecutarAsientosMovimientosIUDConSalida($params);
                            }
                        }
                        $this->generar_destinos_compras($this->anio, Session::get('empresas')->COD_EMPR, $codAsiento, '', Session::get('usuario')->id);
                        $this->gn_generar_total_asientos($codAsiento);
                        $this->calcular_totales_compras($codAsiento);
                    }
                }

                $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
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
                    $documento->TIPO = 'ACOTACION POR CONTABILIDAD';
                    $documento->MENSAJE = $descripcion;
                    $documento->save();
                }

                LqgLiquidacionGasto::where('ID_DOCUMENTO', $liquidaciongastos->ID_DOCUMENTO)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000004',
                            'TXT_ESTADO' => 'POR APROBAR ADMINISTRACION',
                            'COD_JEFE_APRUEBA' => Session::get('usuario')->id,
                            'TXT_JEFE_APRUEBA' => Session::get('usuario')->nombre,
                            'FECHA_JEFE_APRUEBA' => $this->fechaactual
                        ]
                    );

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = 1;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'APROBADO POR CONTABILIDAD';
                $documento->MENSAJE = '';
                $documento->save();

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'APROBADO POR CONTABILIDAD');
                //geolocalización




                DB::commit();
                //DB::rollback();
//                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/' . $idopcion)->with('bienhecho', 'Liquidacion de Gastos : ' . ' APROBADO CON EXITO');
                return response()->json([
                    'status' => 'success',
                    //'mensaje' => json_encode($detalles),
                    'mensaje' => 'LIQUIDACIÓN DE GASTOS: ' . $liquidaciongastos->ID_DOCUMENTO . ' APROBADO CON EXITO',
                    'redirect' => url('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/' . $idopcion)
                ]);
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json([
                    'status' => 'error',
                    'mensaje' => 'OCURRIÓ UN ERROR INESPERADO FILA ASIENTO GENERAR: ' . $contador_cabecera . ' ERROR DESCRICPION: ' . $ex,
                    //'mensaje' => json_encode($cabecera),
                    'redirect' => url('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/' . $idopcion)
                ]);
//                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        } else {


            $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
            $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
            $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
            $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
            $tdetliquidaciongastosel = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '0')->get();
            $archivospdf = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('EXTENSION', 'like', '%' . 'pdf' . '%')->get();
            $ocultar = "";
            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]);
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
                    'downloadUrl' => route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]),
                    'frameClass' => $archivo->ID_DOCUMENTO . $archivo->DOCUMENTO_ITEM . ' ' . $valor //
                ];
            }

            $productosagru = DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
                ->select('COD_PRODUCTO', 'TXT_PRODUCTO', DB::raw('SUM(CANTIDAD) as CANTIDAD'), DB::raw('SUM(TOTAL) as TOTAL'))
                ->where('ID_DOCUMENTO', $iddocumento)
                ->where('ACTIVO', 1)
                ->groupBy('COD_PRODUCTO', 'TXT_PRODUCTO')
                ->get();

            $archivos = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();

            $anio = $this->anio;
            $empresa = Session::get('empresas')->COD_EMPR;
            $ind_anulado = 0;
            $igv = 0;
            $ind_recalcular = 0;
            $ind_igv = 0;
            $usuario = Session::get('usuario')->id;

            foreach ($tdetliquidaciongastos as $key => $documentolg) {
                $cod_contable = $documentolg->ID_DOCUMENTO;
                $item = $documentolg->ITEM;
                $asiento = $this->ejecutarSP(
                    "EXEC [WEB].[GENERAR_ASIENTO_COMPRAS_LG_DOCUMENTO]
                @anio = :anio,
                @empresa = :empresa,
                @cod_contable = :cod_contable,
                @ind_anulado = :ind_anulado,
                @igv = :igv,
                @item = :item,
                @ind_recalcular = :ind_recalcular,
                @ind_igv = :ind_igv,
                @cod_usuario_registra = :usuario",
                    [
                        ':anio' => $anio,
                        ':empresa' => $empresa,
                        ':cod_contable' => $cod_contable,
                        ':ind_anulado' => $ind_anulado,
                        ':igv' => $igv,
                        ':item' => $item,
                        ':ind_recalcular' => $ind_recalcular,
                        ':ind_igv' => $ind_igv,
                        ':usuario' => $usuario
                    ]
                );
                $respuesta = '';

                if (!empty($asiento)) {
                    $respuesta = $asiento[0][0]['RESPUESTA'];
                }

                if ($respuesta === 'ASIENTO CORRECTO') {
                    $documentolg->TXT_CENTRO = json_encode($asiento[1]);
                    $documentolg->TOKEN = json_encode($asiento[2]);
                    $documentolg->BUSQUEDAD = 1;
                } else {
                    $documentolg->TXT_CENTRO = '[]';
                    $documentolg->TOKEN = '[]';
                    $documentolg->BUSQUEDAD = 0;
                }
            }

            $combo_moneda = $this->gn_generacion_combo_categoria('MONEDA', 'Seleccione moneda', '');
            $combo_empresa = $this->gn_combo_empresa_xcliprov('Seleccione Proveedor', '', 'P');
            $combo_tipo_documento = $this->gn_generacion_combo_tipo_documento_sunat('STD.TIPO_DOCUMENTO', 'COD_TIPO_DOCUMENTO', 'TXT_TIPO_DOCUMENTO', 'Seleccione tipo documento', '');

            $array_anio_pc = $this->pc_array_anio_cuentas_contable(Session::get('empresas')->COD_EMPR);
            $combo_anio_pc = $this->gn_generacion_combo_array('Seleccione año', '', $array_anio_pc);
            $combo_periodo = $this->gn_combo_periodo_xanio_xempresa($this->anio, Session::get('empresas')->COD_EMPR, '', 'Seleccione periodo');

            $combo_descuento = $this->co_generacion_combo_detraccion('DESCUENTO', 'Seleccione tipo descuento', '');

            $array_nivel_pc = $this->pc_array_nivel_cuentas_contable(Session::get('empresas')->COD_EMPR, $anio);
            $combo_nivel_pc = $this->gn_generacion_combo_array('Seleccione nivel', '', $array_nivel_pc);

            $array_cuenta = $this->pc_array_nro_cuentas_nombre_xnivel(Session::get('empresas')->COD_EMPR, '6', $anio);
            $combo_cuenta = $this->gn_generacion_combo_array('Seleccione cuenta contable', '', $array_cuenta);

            $combo_partida = $this->gn_generacion_combo_categoria('CONTABILIDAD_PARTIDA', 'Seleccione partida', '');

            $combo_tipo_igv = $this->gn_generacion_combo_categoria('CONTABILIDAD_IGV', 'Seleccione tipo igv', '');

            $combo_porc_tipo_igv = array('' => 'Seleccione porcentaje', '0' => '0%', '10' => '10%', '18' => '18%');

            $combo_activo = array('1' => 'ACTIVO', '0' => 'ELIMINAR');

            $combo_tipo_asiento = $this->gn_generacion_combo_categoria('TIPO_ASIENTO', 'Seleccione tipo asiento', '');


            $indicador = 0;
            $listaarendirlg = $this->lg_lista_arendirlg($liquidaciongastos,$indicador);
            //dd($listaarendirlg);

            $valearendir_info = $this->lq_valearendir($liquidaciongastos->ID_DOCUMENTO);


            return View::make('liquidaciongasto/aprobarcontabilidadlg',
                [
                    'indicador' => $indicador,
                    'listaarendirlg' => $listaarendirlg,
                    'valearendir_info' => $valearendir_info,
                    'liquidaciongastos' => $liquidaciongastos,
                    'tdetliquidaciongastos' => $tdetliquidaciongastos,
                    'tdetliquidaciongastosel' => $tdetliquidaciongastosel,
                    'productosagru' => $productosagru,
                    'archivos' => $archivos,
                    'detdocumentolg' => $detdocumentolg,
                    'documentohistorial' => $documentohistorial,
                    'idopcion' => $idopcion,
                    'idcab' => $idcab,
                    'iddocumento' => $iddocumento,
                    'initialPreview' => json_encode($initialPreview),
                    'initialPreviewConfig' => json_encode($initialPreviewConfig),

                    //NUEVO
                    'array_anio' => $combo_anio_pc,
                    'array_periodo' => $combo_periodo,

                    'combo_empresa_proveedor' => $combo_empresa,
                    'combo_tipo_documento' => $combo_tipo_documento,
                    'combo_moneda_asiento' => $combo_moneda,
                    'combo_descuento' => $combo_descuento,
                    'combo_tipo_asiento' => $combo_tipo_asiento,

                    'combo_nivel_pc' => $combo_nivel_pc,
                    'combo_cuenta' => $combo_cuenta,
                    'combo_partida' => $combo_partida,
                    'combo_tipo_igv' => $combo_tipo_igv,
                    'combo_porc_tipo_igv' => $combo_porc_tipo_igv,
                    'combo_activo' => $combo_activo,

                    // NUEVO

                ]);


        }
    }


    public function actionAprobarLiquidacionGastoAdministracion($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista liquidacion de gastos (administracion)');
        $tab_id = 'oc';
        if (isset($request['tab_id'])) {
            $tab_id = $request['tab_id'];
        }

        $listadatos = $this->lg_lista_cabecera_comprobante_total_administracion();
        $listadatos_obs = $this->lg_lista_cabecera_comprobante_total_obs_administracion();
        $listadatos_obs_le = $this->lg_lista_cabecera_comprobante_total_obs_le_administracion();

        $funcion = $this;
        return View::make('liquidaciongasto/listaliquidaciongastoadministracion',
            [
                'listadatos' => $listadatos,
                'listadatos_obs' => $listadatos_obs,
                'listadatos_obs_le' => $listadatos_obs_le,
                'tab_id' => $tab_id,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
            ]);
    }


    public function actionObservarJefeLG($idopcion, $iddocumento, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        View::share('titulo', 'Observar Liquidacion de Gastos');

        if ($_POST) {

            try {
                DB::beginTransaction();
                $data_archivo = json_decode($request['data_observacion'], true);
                $descripcion = $request['descripcion'];
                $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();

                if ($liquidaciongastos->IND_OBSERVACION == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }


                if (count($data_archivo) <= 0) {
                    DB::rollback();
                    return Redirect::back()->with('errorbd', 'Tiene que seleccionar almenos un item');
                }
                LqgLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'IND_OBSERVACION' => 1,
                            'TXT_OBSERVACION' => 'OBSERVADO',
                            'AREA_OBSERVACION' => 'JEFE'
                        ]
                    );
                foreach ($data_archivo as $key => $obj) {
                    $data_id = $obj['data_id'];
                    $data_item = $obj['data_item'];
                    LqgDetLiquidacionGasto::where('ID_DOCUMENTO', $data_id)->where('ITEM', '=', $data_item)
                        ->update(
                            [
                                'IND_OBSERVACION' => 1,
                                'AREA_OBSERVACION' => 'JEFE',
                                'ACTIVO' => 0,
                            ]
                        );

                    LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', $data_id)->where('ITEM', '=', $data_item)
                        ->update(
                            [
                                'ACTIVO' => 0,
                            ]
                        );


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = 1;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR JEFE';
                $documento->MENSAJE = $descripcion;
                $documento->save();
                $this->lg_calcular_total_observar($iddocumento);

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'OBSERVADO POR JEFE');
                //geolocalización


                DB::commit();


                return Redirect::to('/gestion-de-aprobacion-liquidacion-gasto-jefe/' . $idopcion)->with('bienhecho', 'Liquidacion Gastos : ' . $liquidaciongastos->CODIGO . ' Observado con Exito');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gasto-jefe/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }
    }

    public function actionObservarAdministradorLG($idopcion, $iddocumento, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        View::share('titulo', 'Observar Liquidacion de Gastos');

        if ($_POST) {

            try {
                DB::beginTransaction();
                $data_archivo = json_decode($request['data_observacion'], true);
                $descripcion = $request['descripcion'];
                $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();

                if ($liquidaciongastos->IND_OBSERVACION == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }


                if (count($data_archivo) <= 0) {
                    DB::rollback();
                    return Redirect::back()->with('errorbd', 'Tiene que seleccionar almenos un item');
                }
                LqgLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'IND_OBSERVACION' => 1,
                            'TXT_OBSERVACION' => 'OBSERVADO',
                            'AREA_OBSERVACION' => 'ADM'
                        ]
                    );
                foreach ($data_archivo as $key => $obj) {
                    $data_id = $obj['data_id'];
                    $data_item = $obj['data_item'];
                    LqgDetLiquidacionGasto::where('ID_DOCUMENTO', $data_id)->where('ITEM', '=', $data_item)
                        ->update(
                            [
                                'IND_OBSERVACION' => 1,
                                'AREA_OBSERVACION' => 'ADM',
                                'ACTIVO' => 0,
                            ]
                        );

                    LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', $data_id)->where('ITEM', '=', $data_item)
                        ->update(
                            [
                                'ACTIVO' => 0,
                            ]
                        );


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = 1;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR ADMINISTRACION';
                $documento->MENSAJE = $descripcion;
                $documento->save();
                $this->lg_calcular_total_observar($iddocumento);


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'OBSERVADO POR ADMINISTRACION');
                //geolocalización



                DB::commit();


                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-administracion/' . $idopcion)->with('bienhecho', 'Liquidacion Gastos : ' . $liquidaciongastos->CODIGO . ' Observado con Exito');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-administracion/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }
    }


    public function actionObservarContabilidadLG($idopcion, $iddocumento, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        View::share('titulo', 'Observar Liquidacion de Gastos');

        if ($_POST) {

            try {
                DB::beginTransaction();
                $data_archivo = json_decode($request['data_observacion'], true);
                $descripcion = $request['descripcion'];
                $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();

                if ($liquidaciongastos->IND_OBSERVACION == 1) {
                    DB::rollback();
                    return Redirect::back()->with('errorbd', 'El documento esta observado no se puede observar');
                }


                if (count($data_archivo) <= 0) {
                    DB::rollback();
                    return Redirect::back()->with('errorbd', 'Tiene que seleccionar almenos un item');
                }
                LqgLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)
                    ->update(
                        [
                            'IND_OBSERVACION' => 1,
                            'TXT_OBSERVACION' => 'OBSERVADO',
                            'AREA_OBSERVACION' => 'CONT'
                        ]
                    );
                foreach ($data_archivo as $key => $obj) {
                    $data_id = $obj['data_id'];
                    $data_item = $obj['data_item'];
                    LqgDetLiquidacionGasto::where('ID_DOCUMENTO', $data_id)->where('ITEM', '=', $data_item)
                        ->update(
                            [
                                'IND_OBSERVACION' => 1,
                                'AREA_OBSERVACION' => 'CONT',
                                'ACTIVO' => 0,
                            ]
                        );

                    LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', $data_id)->where('ITEM', '=', $data_item)
                        ->update(
                            [
                                'ACTIVO' => 0,
                            ]
                        );


                }

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento = new LqgDocumentoHistorial;
                $documento->ID_DOCUMENTO = $liquidaciongastos->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM = 1;
                $documento->FECHA = $this->fechaactual;
                $documento->USUARIO_ID = Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                $documento->TIPO = 'OBSERVADO POR CONTABILIDAD';
                $documento->MENSAJE = $descripcion;
                $documento->save();
                $this->lg_calcular_total_observar($iddocumento);


                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'OBSERVADO POR CONTABILIDAD');
                //geolocalización


                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/' . $idopcion)->with('bienhecho', 'Liquidacion Gastos : ' . $liquidaciongastos->CODIGO . ' Observado con Exito');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        }
    }

    public function actionAprobarJefeLG($idopcion, $iddocumento, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        View::share('titulo', 'Aprobar Liquidacion de Gasto Jefe');

        if ($_POST) {
            try {

                DB::beginTransaction();

                $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
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

                LqgLiquidacionGasto::where('ID_DOCUMENTO', $liquidaciongastos->ID_DOCUMENTO)
                    ->update(
                        [
                            'COD_ESTADO' => 'ETM0000000000003',
                            'TXT_ESTADO' => 'POR APROBAR CONTABILIDAD',
                            'COD_JEFE_APRUEBA' => Session::get('usuario')->id,
                            'TXT_JEFE_APRUEBA' => Session::get('usuario')->nombre,
                            'FECHA_JEFE_APRUEBA' => $this->fechaactual
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

                //geolocalizacion
                $device_info       =   $request['device_info'];
                $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'APROBADO POR EL JEFE');
                //geolocalización



                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gasto-jefe/' . $idopcion)->with('bienhecho', 'Liquidacion de Gastos : ' . $liquidaciongastos->CODIGO . ' APROBADO CON EXITO');
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gasto-jefe/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
        } else {

            $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
            $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();

            $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
            $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
            $archivospdf = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('EXTENSION', 'like', '%' . 'pdf' . '%')->get();

            $tdetliquidaciongastosel = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '0')->get();


            $ocultar = "";
            // Construir el array de URLs
            $initialPreview = [];
            foreach ($archivospdf as $archivo) {
                $initialPreview[] = route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]);
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
                    'downloadUrl' => route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]),
                    'frameClass' => $archivo->ID_DOCUMENTO . $archivo->DOCUMENTO_ITEM . ' ' . $valor //
                ];
            }

            //dd($tdetliquidaciongastos);
            $productosagru = DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
                ->select('COD_PRODUCTO', 'TXT_PRODUCTO', DB::raw('SUM(CANTIDAD) as CANTIDAD'), DB::raw('SUM(TOTAL) as TOTAL'))
                ->where('ID_DOCUMENTO', $iddocumento)
                ->where('ACTIVO', 1)
                ->groupBy('COD_PRODUCTO', 'TXT_PRODUCTO')
                ->get();

            $archivos = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();

            $indicador = 0;
            $listaarendirlg = $this->lg_lista_arendirlg($liquidaciongastos,$indicador);
            //dd($listaarendirlg);


            return View::make('liquidaciongasto/aprobarjefelg',
                [
                    'liquidaciongastos' => $liquidaciongastos,
                    'indicador' => $indicador,
                    'listaarendirlg' => $listaarendirlg,
                    'tdetliquidaciongastos' => $tdetliquidaciongastos,
                    'tdetliquidaciongastosel' => $tdetliquidaciongastosel,
                    'productosagru' => $productosagru,
                    'archivos' => $archivos,
                    'detdocumentolg' => $detdocumentolg,
                    'documentohistorial' => $documentohistorial,
                    'idopcion' => $idopcion,
                    'idcab' => $idcab,
                    'iddocumento' => $iddocumento,
                    'initialPreview' => json_encode($initialPreview),
                    'initialPreviewConfig' => json_encode($initialPreviewConfig),
                ]);


        }
    }

    public function actionAprobarJefeLGHistorial($idopcion, $iddocumento, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        View::share('titulo', 'Revisar Liquidacion de Gasto Jefe');


        $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
        $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();

        $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
        $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();
        $archivospdf = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('EXTENSION', 'like', '%' . 'pdf' . '%')->get();

        $tdetliquidaciongastosel = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '0')->get();


        $ocultar = "";
        // Construir el array de URLs
        $initialPreview = [];
        foreach ($archivospdf as $archivo) {
            $initialPreview[] = route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]);
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
                'downloadUrl' => route('serve-filelg', ['file' => $archivo->NOMBRE_ARCHIVO]),
                'frameClass' => $archivo->ID_DOCUMENTO . $archivo->DOCUMENTO_ITEM . ' ' . $valor //
            ];
        }

        //dd($tdetliquidaciongastos);
        $productosagru = DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
            ->select('COD_PRODUCTO', 'TXT_PRODUCTO', DB::raw('SUM(CANTIDAD) as CANTIDAD'), DB::raw('SUM(TOTAL) as TOTAL'))
            ->where('ID_DOCUMENTO', $iddocumento)
            ->where('ACTIVO', 1)
            ->groupBy('COD_PRODUCTO', 'TXT_PRODUCTO')
            ->get();

        $archivos = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();

        $indicador = 0;
        $listaarendirlg = $this->lg_lista_arendirlg($liquidaciongastos,$indicador);
        //dd($listaarendirlg);


        return View::make('liquidaciongasto/aprobarjefelghis',
            [
                'liquidaciongastos' => $liquidaciongastos,
                'indicador' => $indicador,
                'listaarendirlg' => $listaarendirlg,
                'tdetliquidaciongastos' => $tdetliquidaciongastos,
                'tdetliquidaciongastosel' => $tdetliquidaciongastosel,
                'productosagru' => $productosagru,
                'archivos' => $archivos,
                'detdocumentolg' => $detdocumentolg,
                'documentohistorial' => $documentohistorial,
                'idopcion' => $idopcion,
                'idcab' => $idcab,
                'iddocumento' => $iddocumento,
                'initialPreview' => json_encode($initialPreview),
                'initialPreviewConfig' => json_encode($initialPreviewConfig),
            ]);


        
    }


    public function actionAprobarLiquidacionGastoJefe($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista liquidacion de gastos (jefe)');
        $tab_id = 'oc';
        if (isset($request['tab_id'])) {
            $tab_id = $request['tab_id'];
        }

        $listadatos = $this->lg_lista_cabecera_comprobante_total_jefe();
        $listadatos_obs = $this->lg_lista_cabecera_comprobante_total_obs_jefe();
        $listadatos_obs_le = $this->lg_lista_cabecera_comprobante_total_obs_le_jefe();
        $listadatos_his_le = $this->lg_lista_cabecera_comprobante_total_historial_le_jefe();

        $funcion = $this;
        return View::make('liquidaciongasto/listaliquidaciongastojefe',
            [
                'listadatos' => $listadatos,
                'listadatos_obs' => $listadatos_obs,
                'listadatos_obs_le' => $listadatos_obs_le,
                'listadatos_his_le' => $listadatos_his_le,
                'tab_id' => $tab_id,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
            ]);
    }


    public function actionAprobarLiquidacionGastoContabilidad($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista liquidacion de gastos (contabilidad)');
        $tab_id = 'oc';
        if (isset($request['tab_id'])) {
            $tab_id = $request['tab_id'];
        }

        $listadatos = $this->lg_lista_cabecera_comprobante_total_contabilidad();
        $listadatos_obs = $this->lg_lista_cabecera_comprobante_total_obs_contabilidad();
        $listadatos_obs_le = $this->lg_lista_cabecera_comprobante_total_obs_le_contabilidad();
        $funcion = $this;
        return View::make('liquidaciongasto/listaliquidaciongastocontabilidad',
            [
                'listadatos' => $listadatos,
                'listadatos_obs' => $listadatos_obs,
                'listadatos_obs_le' => $listadatos_obs_le,
                'tab_id' => $tab_id,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
            ]);
    }


    public function actionEmitirLiquidacionGasto($idopcion, $iddocumento, Request $request)
    {
        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');

        if ($_POST) {

            try {
                DB::beginTransaction();

                $liquidaciongastos  =   LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();

                $ldetallearendir    =   DB::table('WEB.VALE_RENDIR_DETALLE')
                                        ->where('ID', $liquidaciongastos->ARENDIR_ID)
                                        ->where('COD_ESTADO', 1)
                                        ->where('IND_AEREO','=',1)
                                        ->first();


                //VALIDAR QUE LOS DOCUMENTOS QUE ESTAN ASOCIANDO NO SE REPITAN ENTRE SI EN LA MISMA LIQUIDACION

                $mismaliquidacion =     DB::table('LQG_DETLIQUIDACIONGASTO')
                                        ->select('COD_EMPRESA_PROVEEDOR', 'TXT_EMPRESA_PROVEEDOR', 'SERIE', 'NUMERO', 'COD_TIPODOCUMENTO')
                                        ->selectRaw('COUNT(COD_EMPRESA_PROVEEDOR) AS REPETIDO')
                                        ->where('ID_DOCUMENTO', $iddocumento)
                                        ->where('ACTIVO', 1)
                                        ->groupBy('COD_EMPRESA_PROVEEDOR', 'TXT_EMPRESA_PROVEEDOR', 'SERIE', 'NUMERO', 'COD_TIPODOCUMENTO')
                                        ->havingRaw('COUNT(COD_EMPRESA_PROVEEDOR) > 1')
                                        ->get();

               if (count($mismaliquidacion) > 0) {
                    return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')
                    ->with('errorbd', 'HAY DOCUMENTOS QUE ESTAN DUPLICADOS EN TU LIQUIDACION');
                }

                //VALIDAR QUE LOS DOCUMENTOS NO SE REPITAN CON OTROS INGRESADOS

                $existenDuplicados = DB::table('LQG_DETLIQUIDACIONGASTO AS nuevo')
                    ->where('nuevo.ID_DOCUMENTO', $iddocumento)
                    ->where('nuevo.ACTIVO', 1)
                    ->where('nuevo.COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                    ->whereExists(function ($query) use ($iddocumento) {
                        $query->select(DB::raw(1))
                              ->from('LQG_DETLIQUIDACIONGASTO AS existente')
                              ->join('LQG_LIQUIDACION_GASTO', 'existente.ID_DOCUMENTO', '=', 'LQG_LIQUIDACION_GASTO.ID_DOCUMENTO')
                              ->whereRaw('existente.COD_EMPRESA_PROVEEDOR = nuevo.COD_EMPRESA_PROVEEDOR')
                              ->whereRaw('existente.SERIE = nuevo.SERIE')
                              ->whereRaw('existente.NUMERO = nuevo.NUMERO')
                              ->whereRaw('existente.COD_TIPODOCUMENTO = nuevo.COD_TIPODOCUMENTO')
                              ->where('LQG_LIQUIDACION_GASTO.ACTIVO', 1)
                              ->where('existente.ACTIVO', 1)
                              ->where('LQG_LIQUIDACION_GASTO.COD_ESTADO', '!=', 'ETM0000000000006')
                              ->where('existente.COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                              ->where('existente.ID_DOCUMENTO', '<>', $iddocumento);
                    })
                    ->get(); // Esto devuelve true si existe al menos uno
                //dd($existenDuplicados);
                if (count($existenDuplicados)>0) {
                    return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')
                    ->with('errorbd', 'No se puede registrar el documento. Existen documentos duplicados en la base de datos.');
                }


                //VALIDAR QUE LOS VALES NO SE REPITAN ENTRE SI 


                $arendir    = DB::table('LQG_LIQUIDACION_GASTO')
                                ->where('ACTIVO', 1)
                                ->where('COD_ESTADO', '!=', 'ETM0000000000006')
                                ->where('ARENDIR_ID', $liquidaciongastos->ARENDIR_ID)
                                ->where('ID_DOCUMENTO', '<>', $iddocumento)
                                ->get();

                if (count($arendir)>0) {
                    return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')
                    ->with('errorbd', 'YA EXISTE ESTE CODIGO DE ARENDIR EN OTRA LIQUIDACION');
                }


                //VALIDAR QUE TODOS LOS DETALLES TENGAN VALOR MAYOR A CERO

                $detallescero           =   DB::table('LQG_DETLIQUIDACIONGASTO')
                                        ->where('ID_DOCUMENTO', $iddocumento)
                                        ->where('ACTIVO','=','1')
                                        ->where('TOTAL', '<=', 0)
                                        ->first();
               if (count($detallescero) > 0) {
                    return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')
                    ->with('errorbd', 'Su '.$detallescero->TXT_TIPODOCUMENTO.' : '.$detallescero->SERIE.'-'.$detallescero->NUMERO.' TIENE UN VALOR CERO INGRESE VALOR');
                }

                if (count($ldetallearendir) > 0) {

                    $productospasajeaereo  =    DB::table('LQG_DETDOCUMENTOLIQUIDACIONGASTO')
                                                ->where('ID_DOCUMENTO', $iddocumento)
                                                ->where('COD_PRODUCTO','=','PRD0000000024431')
                                                ->where('ACTIVO', 1)
                                                ->get();

                    if (count($productospasajeaereo) <= 0) {                       
                        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')->with('errorbd', 'Su vale tiene indicador de PASAJE AEREO debe subir tambien en la Liquidacion');
                    }
                }

                $tipopago_id = $request['tipopago_id'];
                $entidadbanco_id = $request['entidadbanco_id'];
                $banco_e_id = $request['banco_e_id'];

                $cb_id = $request['cb_id'];

                $tipopago = CMPCategoria::where('COD_CATEGORIA', '=', $tipopago_id)->first();
                $entidadbanco = CMPCategoria::where('COD_CATEGORIA', '=', $banco_e_id)->first();
                $cb = CMPCategoria::where('COD_CATEGORIA', '=', $cb_id)->first();


                $entidadbancaria_id = '';
                $entidadbancaria_txt = '';

                $tipocuenta_id = '';
                $tipocuenta_txt = '';

                $cuentanro = '';
                $cuentanrocci = '';

                if ($tipopago_id == 'MPC0000000000002') {

                    $entidadbancaria_id = $entidadbanco->COD_CATEGORIA;
                    $entidadbancaria_txt = $entidadbanco->NOM_CATEGORIA;
                    $cuentanro = $request['numero_cuenta'];

                }


                //validar que tenga la firma quien
                $detliquidaciongasto = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                $useario_autoriza = User::where('id', '=', $detliquidaciongasto->COD_USUARIO_AUTORIZA)->first();
                //dd($useario_autoriza);
                $trabajadorap = STDTrabajador::where('COD_TRAB', '=', $useario_autoriza->usuarioosiris_id)->first();
                $imgaprueba = 'firmas/blanco.jpg';
                $nombre_aprueba = '';
                $rutaImagen = public_path('firmas/' . $trabajadorap->NRO_DOCUMENTO . '.jpg');
                //dd($rutaImagen);
                // if (!file_exists($rutaImagen)){
                //     return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/0')->with('errorbd','No se puede emitir ya que el que autoriza no cuenta con firma llamar a sistemas');
                // }


                //CUANDO ESTA OBSEVADOS
                if ($liquidaciongastos->IND_OBSERVACION == 1) {
                    LqgLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)
                        ->update(
                            [
                                'IND_OBSERVACION' => 0,
                                'COD_CATEGORIA_TIPOPAGO' => $tipopago->COD_CATEGORIA,
                                'TXT_CATEGORIA_TIPOPAGO' => $tipopago->NOM_CATEGORIA,
                                'COD_CATEGORIA_BANCARIO' => $entidadbancaria_id,
                                'TXT_CATEGORIA_BANCARIO' => $entidadbancaria_txt,
                                'COD_CATEGORIA_TIPOCUENTA' => $tipocuenta_id,
                                'TXT_CATEGORIA_TIPOCUENTA' => $tipocuenta_txt,
                                'CUENTA_BANCARIA' => $cuentanro,
                                'CCI_CUENTA_BANCARIA' => $cuentanrocci,
                                'TXT_GLOSA' => $request['glosa'],
                            ]
                        );
                    $documento = new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $iddocumento;
                    $documento->DOCUMENTO_ITEM = 1;
                    $documento->FECHA = date_format(date_create(date('Ymd h:i:s')), 'Ymd h:i:s');
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'SE LEVANTARON LAS OBSERVACIONES';
                    $documento->MENSAJE = '';
                    $documento->save();

                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'SE LEVANTARON LAS OBSERVACIONES');
                    //geolocalización


                } else {

                    $arendri            =   DB::table('WEB.VALE_RENDIR')
                                            ->where('ID', $liquidaciongastos->ARENDIR_ID)
                                            ->first();
                    $diasarendir        =   1;                       
                    if(count($arendri)>0){
                        $diasarendir    = $arendri->AUMENTO_DIAS ?? 0;;  
                    }

                    //solo 2 dias
                    $fechaDada = $request['ULTIMA_FECHA_RENDICION'];
                    $fechaSumada = $this->addBusinessDays($fechaDada, 4 + $diasarendir, true);
                    $fechaActual = Carbon::now();
                    if ($fechaSumada->lessThan($fechaActual)) {
                        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')->with('errorbd', 'La ultima fecha para emitir esta Liquidacion de Gastos debio ser es hasta '.$fechaSumada);
                    }

                    //dd($request['ULTIMA_FECHA_RENDICION']);

                    $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();
                    if (count($tdetliquidaciongastos) <= 0) {
                        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')->with('errorbd', 'Para poder emitir tiene que cargar sus documentos');
                    }


                    LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)
                        ->update(
                            [
                                'TXT_GLOSA' => $request['glosa'],
                                'FECHA_EMI' => $this->fechaactual,
                                'FECHA_MOD' => $this->fechaactual,

                                'COD_CATEGORIA_TIPOPAGO' => $tipopago->COD_CATEGORIA,
                                'TXT_CATEGORIA_TIPOPAGO' => $tipopago->NOM_CATEGORIA,
                                'COD_CATEGORIA_BANCARIO' => $entidadbancaria_id,
                                'TXT_CATEGORIA_BANCARIO' => $entidadbancaria_txt,
                                'COD_CATEGORIA_TIPOCUENTA' => $tipocuenta_id,
                                'TXT_CATEGORIA_TIPOCUENTA' => $tipocuenta_txt,
                                'CUENTA_BANCARIA' => $cuentanro,
                                'CCI_CUENTA_BANCARIA' => $cuentanrocci,


                                'USUARIO_MOD' => Session::get('usuario')->id,
                                'COD_ESTADO' => 'ETM0000000000010',
                                'TXT_ESTADO' => 'POR APROBAR AUTORIZACION'
                            ]);

                    $documento = new LqgDocumentoHistorial;
                    $documento->ID_DOCUMENTO = $iddocumento;
                    $documento->DOCUMENTO_ITEM = 1;
                    $documento->FECHA = date_format(date_create(date('Ymd h:i:s')), 'Ymd h:i:s');
                    $documento->USUARIO_ID = Session::get('usuario')->id;
                    $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
                    $documento->TIPO = 'CREO LIQUIDACION DE GASTO';
                    $documento->MENSAJE = '';
                    $documento->save();

                    //geolocalizacion
                    $device_info       =   $request['device_info'];
                    $this->con_datos_de_la_pc($device_info,$liquidaciongastos,'CREO LIQUIDACION DE GASTO');
                    //geolocalización




                }


                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
            return Redirect::to('gestion-de-liquidacion-gastos/' . $idopcion)->with('bienhecho', 'Liquidacion de Gatos ' . $liquidaciongastos->CODIGO . ' emitido con exito');
        }
    }


    public function actionGuardarModificarDetalleDocumentoLG($idopcion, $iddocumento, $item, $itemdocumento, Request $request)
    {

        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');

        try {

            DB::beginTransaction();

            $producto_id = $request['producto_id'];
            $importe = (float)$request['importe'];
            $igv_id = $request['igv_id'];
            $anio = $this->anio;
            $mes = $this->mes;
            $periodo = $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
            $detliquidaciongasto = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $item)->first();
            $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $item)->get();
            $detdocumentolgtop = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $item)->first();


            $resta = 0;
            $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
            $referencia_asoc =  DB::table('CMP.REFERENCIA_ASOC')
                                ->where('TXT_DESCRIPCION', 'ARENDIR')
                                ->where('TXT_TABLA_ASOC', $producto_id)
                                ->first();

            if ($liquidaciongastos->ARENDIR == 'REEMBOLSO') {
                $ldetallearendir = DB::table('WEB.VALE_RENDIR_DETALLE_REEMBOLSO')
                                    ->where('ID', $liquidaciongastos->ARENDIR_ID)
                                    ->where('COD_ESTADO', 1)
                                    ->get();

            }else{
                $ldetallearendir = DB::table('WEB.VALE_RENDIR_DETALLE')
                    ->where('ID', $liquidaciongastos->ARENDIR_ID)
                    ->where('COD_ESTADO', 1)
                    ->get();
            }

            if(count($ldetallearendir)>0){

                if(count($referencia_asoc)>0){
                    $mensaje_error_vale = $this->validar_reembolso_supere_monto($liquidaciongastos,$liquidaciongastos->ARENDIR,$referencia_asoc->COD_TABLA,$importe,$producto_id,$resta);
                    if($mensaje_error_vale!=''){
                        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', $mensaje_error_vale); 
                    }
                }else{
                    return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', 'Este producto no esta relacionado en la tabla referencia');
                }

            }

            $itemdet = count($detdocumentolg) + 1;
            $producto = DB::table('ALM.PRODUCTO')->where('NOM_PRODUCTO', '=', $producto_id)->first();
            $fecha_creacion = $this->hoy;
            $cantidad = 1;
            $subtotal = $importe;
            $total = $importe;
            if ($igv_id == '1') {
                $subtotal = $importe / 1.18;
            }
            $activo = $request['activo'];

            LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $detliquidaciongasto->ID_DOCUMENTO)
                ->where('ITEM', '=', $item)
                ->where('ITEMDOCUMENTO', '=', $itemdocumento)
                ->update(
                    [
                        'COD_PRODUCTO' => $producto->COD_PRODUCTO,
                        'TXT_PRODUCTO' => $producto->NOM_PRODUCTO,
                        'CANTIDAD' => $cantidad,
                        'PRECIO' => $importe,
                        'IND_IGV' => $igv_id,
                        'SUBTOTAL' => $subtotal,
                        'TOTAL' => $total,
                        'ACTIVO' => $activo,
                        'FECHA_MOD' => $this->fechaactual,
                        'USUARIO_MOD' => Session::get('usuario')->id
                    ]);

            //CALCULAR TOTALES
            $this->lg_calcular_total($iddocumento, $item);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', $ex . ' Ocurrio un error inesperado');
        }
        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('bienhecho', 'Se Modifico el item con exito');
    }


    public function actionModificarDetalleDocumentoLG(Request $request)
    {

        $iddocumento = $request['data_iddocumento'];
        $data_item = $request['data_item'];
        $data_item_documento = $request['data_item_documento'];
        $idopcion = $request['idopcion'];

        $detliquidaciongasto = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $data_item)->first();
        $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $data_item)->where('ITEMDOCUMENTO', '=', $data_item_documento)->first();
        $producto_id = $detdocumentolg->TXT_PRODUCTO;
        $comboproducto = array($detdocumentolg->TXT_PRODUCTO => $detdocumentolg->TXT_PRODUCTO);
        $igv_id = $detdocumentolg->IND_IGV;
        $combo_igv = array('' => "¿SELECCIONE SI TIENE IGV?", '1' => "SI", '0' => "NO");

        $funcion = $this;
        $comboestado = array('1' => "ACTIVO", '0' => "ELIMINAR");
        $activo = $detdocumentolg->ACTIVO;


        return View::make('liquidaciongasto/modal/ajax/magregardetalledocumentolg',
            [
                'iddocumento' => $iddocumento,
                'idopcion' => $idopcion,
                'detdocumentolg' => $detdocumentolg,
                'detliquidaciongasto' => $detliquidaciongasto,
                'funcion' => $funcion,
                'producto_id' => $producto_id,
                'comboproducto' => $comboproducto,
                'igv_id' => $igv_id,
                'combo_igv' => $combo_igv,
                'comboestado' => $comboestado,
                'activo' => $activo,
                'ajax' => true,
            ]);
    }


    public function actionRelacionarDetalleDocumentoLG(Request $request)
    {

        $data_item = $request['data_item'];
        $data_producto = $request['data_producto'];
        $idopcion = $request['idopcion'];
        $producto_id = "";
        $comboproducto = array();
        $funcion = $this;

        return View::make('liquidaciongasto/modal/ajax/marelacionardetalledocumentolg',
            [
                'comboproducto' => $comboproducto,
                'idopcion' => $idopcion,
                'data_item' => $data_item,
                'data_producto' => $data_producto,
                'funcion' => $funcion,
                'producto_id' => $producto_id,
                'comboproducto' => $comboproducto,
                'ajax' => true,
            ]);
    }


    public function actionGuardarDetalleDocumentoLG($idopcion, $iddocumento, $item, Request $request)
    {

        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');

        try {

            DB::beginTransaction();

            $producto_id = $request['producto_id'];
            $importe = (float)$request['importe'];
            $igv_id = $request['igv_id'];
            $anio = $this->anio;
            $mes = $this->mes;

            $periodo = $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
            $detliquidaciongasto = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $item)->first();
            $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $item)->get();

            
            $itemdet = count($detdocumentolg) + 1;
            $producto = DB::table('ALM.PRODUCTO')->where('NOM_PRODUCTO', '=', $producto_id)->first();
            $fecha_creacion = $this->hoy;
            $cantidad = 1;
            $subtotal = $importe;

            $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
            $referencia_asoc =  DB::table('CMP.REFERENCIA_ASOC')
                                ->where('TXT_DESCRIPCION', 'ARENDIR')
                                ->where('TXT_TABLA_ASOC', $producto_id)
                                ->first();
            $resta = 0;



            if ($liquidaciongastos->ARENDIR == 'REEMBOLSO') {
                $ldetallearendir = DB::table('WEB.VALE_RENDIR_DETALLE_REEMBOLSO')
                                    ->where('ID', $liquidaciongastos->ARENDIR_ID)
                                    ->where('COD_ESTADO', 1)
                                    ->get();

            }else{
                $ldetallearendir = DB::table('WEB.VALE_RENDIR_DETALLE')
                    ->where('ID', $liquidaciongastos->ARENDIR_ID)
                    ->where('COD_ESTADO', 1)
                    ->get();
            }

            if($detliquidaciongasto->COD_TIPODOCUMENTO !='TDO0000000000010'){
                if($request['producto_id'] == 'SERVICIO DE TRANSPORTE AEREO'){
                    return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', 'Este producto solo se puede registrar con ticket');
                }
            }

            $IND_OSIRIS = 0;
            if($detliquidaciongasto->COD_TIPODOCUMENTO =='TDO0000000000010'){
                if($request['producto_id'] == 'SERVICIO DE TRANSPORTE AEREO'){

                    $arendri            =   DB::table('WEB.VALE_RENDIR')
                                            ->where('ID', $liquidaciongastos->ARENDIR_ID)
                                            ->first(); 

                    if(count($arendri)>0){
                        if($arendri->TIPO_MOTIVO == 'TIP0000000000003'){
                            $IND_OSIRIS = 1;
                            LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM', '=', $item)
                                        ->update(
                                                [
                                                    'IND_OSIRIS'=> 1
                                                ]); 
                        }
                    }



                }
            }

            if($request['producto_id'] == 'MOVILIDAD AEROPUERTO'){
                return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', 'Este producto solo se puede registrar con factura');
            }


            if($request['producto_id'] != 'SERVICIO DE TRANSPORTE AEREO'){
                if(count($ldetallearendir)>0){
                    if(count($referencia_asoc)>0){
                        $mensaje_error_vale = $this->validar_reembolso_supere_monto($liquidaciongastos,$liquidaciongastos->ARENDIR,$referencia_asoc->COD_TABLA,$importe,$producto_id,0);
                        if($mensaje_error_vale!=''){
                            return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', $mensaje_error_vale); 
                        }
                    }else{
                        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', 'Este producto no esta relacionado en la tabla referencia');
                    }
                }
            }      

            $total = $importe;
            if ($igv_id == '1') {
                $subtotal = $importe / 1.18;
            }





            $cabecera = new LqgDetDocumentoLiquidacionGasto;
            $cabecera->ID_DOCUMENTO = $iddocumento;
            $cabecera->ITEM = $detliquidaciongasto->ITEM;
            $cabecera->ITEMDOCUMENTO = $itemdet;
            $cabecera->COD_PRODUCTO = $producto->COD_PRODUCTO;
            $cabecera->TXT_PRODUCTO = $producto->NOM_PRODUCTO;
            $cabecera->CANTIDAD = $cantidad;
            $cabecera->PRECIO = $importe;
            $cabecera->IND_IGV = $igv_id;
            $cabecera->IGV = $total - $subtotal;
            $cabecera->SUBTOTAL = $subtotal;
            $cabecera->TOTAL = $total;
            $cabecera->COD_EMPRESA = Session::get('empresas')->COD_EMPR;
            $cabecera->TXT_EMPRESA = Session::get('empresas')->NOM_EMPR;
            $cabecera->COD_CENTRO = $detliquidaciongasto->COD_CENTRO;
            $cabecera->TXT_CENTRO = $detliquidaciongasto->TXT_CENTRO;
            $cabecera->FECHA_CREA = $this->fechaactual;
            $cabecera->USUARIO_CREA = Session::get('usuario')->id;
            $cabecera->IND_OSIRIS = $IND_OSIRIS;

            $cabecera->save();

            //CALCULAR TOTALES
            $this->lg_calcular_total($iddocumento, $item);


            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', $ex . ' Ocurrio un error inesperado');
        }
        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('bienhecho', 'Se Agrego un nuevo item con exito');
    }


    public function actionDetalleDocumentoLG(Request $request)
    {

        $iddocumento = $request['data_iddocumento'];
        $item = $request['data_item'];
        $idopcion = $request['idopcion'];

        $detliquidaciongasto = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $item)->first();
        $funcion = $this;
        $fecha_fin = $this->fecha_sin_hora;
        $producto_id = "";
        $comboproducto = array();
        $igv_id = "";
        $combo_igv = array('' => "¿SELECCIONE SI TIENE IGV?", '1' => "SI", '0' => "NO");

        return View::make('liquidaciongasto/modal/ajax/magregardetalledocumentolg',
            [
                'iddocumento' => $iddocumento,
                'item' => $item,
                'idopcion' => $idopcion,
                'detliquidaciongasto' => $detliquidaciongasto,
                'funcion' => $funcion,
                'producto_id' => $producto_id,
                'comboproducto' => $comboproducto,
                'igv_id' => $igv_id,
                'combo_igv' => $combo_igv,
                'ajax' => true,
            ]);
    }


    public function actionGuardarDetalleLiquidacionGastos($idopcion, $iddocumento, Request $request)
    {

        $idcab = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
        $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->get();

        if ($_POST) {
            try {

                DB::beginTransaction();

                $anio = $this->anio;
                $mes = $this->mes;
                $periodo = $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
                $cod_planila = $request['cod_planila'];
                $tipodoc_id = $request['tipodoc_id'];
                $TOTAL_T = 0;

                $SUCCESS = '';
                $MESSAGE = '';
                $ESTADOCP = '';
                $NESTADOCP = '';
                $ESTADORUC = '';
                $NESTADORUC = '';
                $CONDDOMIRUC = '';
                $NCONDDOMIRUC = '';
                $CODIGO_CDR = '';
                $RESPUESTA_CDR = '';
                $NOMBREFILE = '';
                $array_detalle_producto = '';

                if (Session::get('empresas')->COD_EMPR == 'IACHEM0000010394') {
                    $flujo_txt_id = 'IICHFC0000000018';
                    $gasto_txt_id = 'IICH000000026203';
                    $item_txt_id = 'IICHIM0000000106';
                } else {
                    $flujo_txt_id = 'ISCHFC0000000018';
                    $gasto_txt_id = 'ISCH000000034709';
                    $item_txt_id = 'ISCHIM0000000038';
                }

                $empresa_id_b = $request['empresa_id'] . $request['EMPRESAID'];
                $cadena = $empresa_id_b;
                $partes = explode(" - ", $cadena);
                $ruc_b = '';
                if (count($partes) > 1) {
                    $ruc_b = trim($partes[0]);
                }
                //VALIDAR QUE DOCUMENTO EMITE EL PROVEEDOR
                $urlxml = 'https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias?accion=consPorRuc&razSoc=null&nroRuc=' . $ruc_b . '&nrodoc=null&token=go6mleec9llv1vd4htmikni2ffds38hu9u5ohoez6r5mh53poabe&contexto=ti-it&modo=1&rbtnTipo=1&search1=' . $ruc_b . '&tipdoc=1&search2=null&search3=null&codigo=null';
                $html = $this->buscar_archivo_sunat_td($urlxml);

                // 2) Instancia y carga el HTML (silenciamos warnings)
                $dom = new \DOMDocument;
                @$dom->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR);

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

                $tieneFactura = !empty(array_filter($comprobantes, function ($item) {
                    return stripos($item, 'FACTURA') !== false;
                }));

                $tieneFactura = in_array('FACTURA', $comprobantes);


                if (!in_array($tipodoc_id, ['TDO0000000000001', 'TDO0000000000010'])) {
                    if ($tieneFactura == 1) {
                        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/-1')->with('errorbd', 'Este proveedor emite FACTURA');
                    }
                }
                $token = '';

                $PRIMERA_FECHA_RENDICION_DET =     $request['PRIMERA_FECHA_RENDICION_DET'];
                $ULTIMA_FECHA_RENDICION_DET  =     $request['ULTIMA_FECHA_RENDICION_DET'];

                $fechaMinima = '';
                $fechaMaxima = '';

                //CUANDO ES PLANILLA DE MOVILIDAd
                if (ltrim(rtrim($cod_planila)) != '') {

                    $detalleplanillam = DB::table('PLA_DETMOVILIDAD')
                        ->selectRaw('MIN(FECHA_GASTO) as fecha_minima, MAX(FECHA_GASTO) as fecha_maxima')
                        ->where('ID_DOCUMENTO', $cod_planila)
                        ->where('ACTIVO', 1)
                        ->first();

                    if ($detalleplanillam) {
                        $fechaMinima = $detalleplanillam->fecha_minima;
                        $fechaMaxima = $detalleplanillam->fecha_maxima;
                    }

                    if($ULTIMA_FECHA_RENDICION_DET!=''){


                        $fechaInicio = Carbon::parse($PRIMERA_FECHA_RENDICION_DET)->startOfDay();
                        $fechaFin = Carbon::parse($ULTIMA_FECHA_RENDICION_DET)->endOfDay();
                        $fechaMin = Carbon::parse($fechaMinima)->startOfDay();
                        $fechaMax = Carbon::parse($fechaMaxima)->endOfDay();

                        // $fechaInicio = Carbon::parse($PRIMERA_FECHA_RENDICION_DET);
                        // $fechaFin = Carbon::parse($ULTIMA_FECHA_RENDICION_DET);
                        // $fechaMin = Carbon::parse($fechaMinima);
                        // $fechaMax = Carbon::parse($fechaMaxima);
                        // Validar que estén dentro del rango

                        if($liquidaciongastos->REEMBOLSO != 'REEMBOLSO'){
                            if (!($fechaMin->between($fechaInicio, $fechaFin) && $fechaMax->between($fechaInicio, $fechaFin))) {
                                return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/-1')
                                       ->with('errorbd', 'Las fechas de movilidad no están dentro del rango a rendir (' . $fechaInicio->format('Y-m-d') . ' / ' . $fechaFin->format('Y-m-d') . ')');
                            }   
                        }


                    }

                    $planillamovilidad = DB::table('PLA_MOVILIDAD')
                        ->where('ID_DOCUMENTO', $cod_planila)
                        ->first();
                    $COD_CUENTA = '';
                    $TXT_CUENTA = '';

                    $contratos = DB::table('CMP.CONTRATO')
                        ->where('COD_EMPR_CLIENTE', 'IACHEM0000009164')
                        ->where('COD_EMPR', $planillamovilidad->COD_EMPRESA)
                        ->where('COD_CENTRO', $planillamovilidad->COD_CENTRO)
                        ->first();

                    if (count($contratos) > 0) {
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
                        $COD_CUENTA = $contratos->COD_CONTRATO;
                        $TXT_CUENTA = $contrato;
                        $subcontrato = DB::table('CMP.CONTRATO_CULTIVO')
                            ->selectRaw("
                                                                    COD_CONTRATO,
                                                                    TXT_ZONA_COMERCIAL+'-'+TXT_ZONA_CULTIVO as TXT_CULTIVO
                                                                ")
                            ->where('COD_CONTRATO', $COD_CUENTA)
                            ->first();
                        $COD_SUBCUENTA = $subcontrato->COD_CONTRATO;
                        $TXT_SUBCUENTA = $subcontrato->TXT_CULTIVO;
                        $TOTAL_T = $planillamovilidad->TOTAL;


                    }

                    $tipodoc_id = $request['tipodoc_id'];
                    $serie = $planillamovilidad->SERIE;
                    $numero = $planillamovilidad->NUMERO;
                    $fecha_emision = date_format(date_create($planillamovilidad->FECHA_EMI), 'd-m-Y');
                    $empresa_id = $request['empresa_id'];


                    $flujo_id = $flujo_txt_id;
                    $gasto_id = $gasto_txt_id;
                    $item_id = $item_txt_id;


                    $costo_id = $request['costo_id'];
                    $cuenta_id = $COD_CUENTA;
                    $subcuenta_id = $COD_SUBCUENTA;

                    $glosadet = $request['glosadet'];
                    //$empresa_trab                       =   'PLANILLA DE MOVILIDAD SIN COMPROBANTE';
                    $empresa_trab = STDEmpresa::where('NOM_EMPR', '=', 'PLANILLA DE MOVILIDAD SIN COMPROBANTE')->where('COD_ESTADO', '=', '1')->first();
                } else {

                    if ($tipodoc_id == 'TDO0000000000001') {

                        //MOVILIDAD AEROPUERTO

                        if($request['producto_id_factura'] != 'SERVICIO DE TRANSPORTE AEREO'){
                            
                            if($request['producto_id_factura'] != 'SERVICIO DE TRANSPORTE DE PASAJEROS'){
                            if (!empty($ULTIMA_FECHA_RENDICION_DET)) {

                                //$fechaInicio = Carbon::parse($PRIMERA_FECHA_RENDICION_DET);
                                //$fechaFin = Carbon::parse($ULTIMA_FECHA_RENDICION_DET);
                                $fechaInicio = Carbon::parse($PRIMERA_FECHA_RENDICION_DET)->startOfDay();
                                $fechaFin = Carbon::parse($ULTIMA_FECHA_RENDICION_DET)->endOfDay();
                                $fechaMin = Carbon::parse($request['fecha_emision']);

                                if($liquidaciongastos->ARENDIR != 'REEMBOLSO'){
                                    // Validar si está dentro del rango
                                    if (!$fechaMin->between($fechaInicio, $fechaFin)) {

                                        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/-1')
                                               ->with('errorbd', 'La fecha de emisión (' . $fechaMin->format('Y-m-d') . ') no está dentro del rango a rendir (' . 
                                               $fechaInicio->format('Y-m-d') . ' / ' . $fechaFin->format('Y-m-d') . ')');
                                    }
                                }

                            }

                            }

                        }



                        $fetoken = FeToken::where('COD_EMPR', '=', Session::get('empresas')->COD_EMPR)->where('TIPO', '=', 'COMPROBANTE_PAGO')->first();
                        $token = $fetoken->TOKEN;
                        $tipodoc_id = $request['tipodoc_id'];
                        $serie = $request['serie'];
                        $numero = $request['numero'];
                        $fecha_emision = $request['fecha_emision'];
                        $empresa_id = $request['empresa_id'];

                        $flujo_id = $flujo_txt_id;
                        $gasto_id = $gasto_txt_id;
                        $item_id = $item_txt_id;


                        $costo_id = $request['costo_id'];
                        $cuenta_id = $request['cuenta_id'];
                        $subcuenta_id = $request['subcuenta_id'];

                        $glosadet = $request['glosadet'];
                        $TOTAL_T = $request['totaldetalle'];


                        $SUCCESS = $request['SUCCESS'];
                        $MESSAGE = $request['MESSAGE'];
                        $ESTADOCP = $request['ESTADOCP'];
                        $NESTADOCP = $request['NESTADOCP'];
                        $ESTADORUC = $request['ESTADORUC'];
                        $NESTADORUC = $request['NESTADORUC'];
                        $CONDDOMIRUC = $request['CONDDOMIRUC'];
                        $NCONDDOMIRUC = $request['NCONDDOMIRUC'];
                        $cod_planila = '';


                        //dd($empresa_id);
                        $cadena = $empresa_id;
                        $partes = explode(" - ", $cadena);
                        $nombre = '';
                        if (count($partes) > 1) {
                            $nombre = trim($partes[0]);
                        }
                        $empresa_trab = STDEmpresa::where('NRO_DOCUMENTO', '=', $nombre)->where('COD_TIPO_DOCUMENTO','=','TDI0000000000006')->where('COD_ESTADO', '=', '1')->first();


                    } else {

                        if (!empty($ULTIMA_FECHA_RENDICION_DET)) {

                            // $fechaInicio = Carbon::parse($PRIMERA_FECHA_RENDICION_DET);
                            // $fechaFin = Carbon::parse($ULTIMA_FECHA_RENDICION_DET);
                            // $fechaMin = Carbon::parse($request['fecha_emision']);

                            $fechaInicio = Carbon::parse($PRIMERA_FECHA_RENDICION_DET)->startOfDay();
                            $fechaFin = Carbon::parse($ULTIMA_FECHA_RENDICION_DET)->endOfDay();
                            $fechaMin = Carbon::parse($request['fecha_emision']);

                            if($request['producto_id_factura'] != 'SERVICIO DE TRANSPORTE AEREO'){
                                if($request['producto_id_factura'] != 'SERVICIO DE TRANSPORTE DE PASAJEROS'){
                                    if($liquidaciongastos->ARENDIR != 'REEMBOLSO'){
                                        if (!$fechaMin->between($fechaInicio, $fechaFin)) {
                                            return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/-1')
                                                   ->with('errorbd', 'La fecha de emisión (' . $fechaMin->format('Y-m-d') . ') no está dentro del rango a rendir (' . $fechaInicio->format('Y-m-d') . ' / ' . $fechaFin->format('Y-m-d') . ')');
                                        }
                                    }
                                }
                            }
                        }

                        $tipodoc_id = $request['tipodoc_id'];
                        $serie = $request['serie'];
                        $numero = $request['numero'];
                        $fecha_emision = $request['fecha_emision'];
                        $empresa_id = $request['empresa_id'];

                        $flujo_id = $flujo_txt_id;
                        $gasto_id = $gasto_txt_id;
                        $item_id = $item_txt_id;

                        $costo_id = $request['costo_id'];
                        $cuenta_id = $request['cuenta_id'];
                        $subcuenta_id = $request['subcuenta_id'];

                        $glosadet = $request['glosadet'];
                        $cod_planila = '';


                        $cadena = $empresa_id;
                        $partes = explode(" - ", $cadena);
                        $nombre = '';
                        if (count($partes) > 1) {
                            $nombre = trim($partes[0]);
                        }
                        $empresa_trab = STDEmpresa::where('NRO_DOCUMENTO', '=', $nombre)->where('COD_TIPO_DOCUMENTO','=','TDI0000000000006')->where('COD_ESTADO', '=', '1')->first();

                    }
                }
                $tipodoc_id = $request['tipodoc_id'];
                $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->get();
                $item = count($tdetliquidaciongastos) + 1;
                $cuenta = CMPContrato::where('COD_CONTRATO', '=', $cuenta_id)->first();
                $subcuenta = CMPContratoCultivo::where('COD_CONTRATO', '=', $subcuenta_id)->first();
                $tipodocumento = STDTipoDocumento::where('COD_TIPO_DOCUMENTO', '=', $tipodoc_id)->first();
                $flujocaja = DB::table('CON.FLUJO_CAJA')->where('COD_FLUJO_CAJA', '=', $flujo_id)->first();
                $gasto = DB::table('CON.CUENTA_CONTABLE')->where('COD_CUENTA_CONTABLE', '=', $gasto_id)->first();
                $costo = DB::table('CON.CENTRO_COSTO')->where('COD_CENTRO_COSTO', '=', $costo_id)->first();
                $items = DB::table('CON.FLUJO_CAJA_ITEM_MOV')->where('COD_ITEM_MOV', '=', $item_id)->first();
                $nombre_doc_sinceros = $serie . '-' . $numero;
                $numero = str_pad($numero, 10, "0", STR_PAD_LEFT);
                $nombre_doc = $serie . '-' . $numero;
                $empresa_id = $request['empresa_id'];

                //dd($empresa_id);
                $cadena = $empresa_id;
                $partes = explode(" - ", $cadena);
                $nombre = '';
                if (count($partes) > 1) {
                    $nombre = trim($partes[0]);

                }



                $bliquidacion = DB::table('LQG_DETLIQUIDACIONGASTO')
                    ->where('SERIE', $serie)
                    ->where('NUMERO', $numero)
                    ->where('COD_TIPODOCUMENTO', $tipodocumento->COD_TIPO_DOCUMENTO)
                    ->where('COD_EMPRESA_PROVEEDOR', $empresa_trab->COD_EMPR)
                    ->where('COD_EMPRESA', Session::get('empresas')->COD_EMPR)
                    ->where('ACTIVO', 1)
                    ->first();

                if (count($bliquidacion) > 0) {
                    return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/-1')->with('errorbd', 'Este documento ya esta registrado en la Liquidacion ' . $bliquidacion->ID_DOCUMENTO);
                }


                //dd($empresa_trab);
                $cabecera = new LqgDetLiquidacionGasto;
                $cabecera->ID_DOCUMENTO = $iddocumento;
                $cabecera->ITEM = $item;
                $cabecera->FECHA_EMISION = $fecha_emision;
                $cabecera->SERIE = $serie;
                $cabecera->NUMERO = $numero;
                $cabecera->COD_TIPODOCUMENTO = $tipodocumento->COD_TIPO_DOCUMENTO;
                $cabecera->TXT_TIPODOCUMENTO = $tipodocumento->TXT_TIPO_DOCUMENTO;
                $cabecera->COD_FLUJO = $flujocaja->COD_FLUJO_CAJA;
                $cabecera->TXT_FLUJO = $flujocaja->TXT_NOMBRE;
                $cabecera->COD_GASTO = $gasto->COD_CUENTA_CONTABLE;
                $cabecera->TXT_GASTO = $gasto->TXT_DESCRIPCION;
                $cabecera->COD_COSTO = $costo->COD_CENTRO_COSTO;
                $cabecera->TXT_COSTO = $costo->TXT_NOMBRE;
                $cabecera->COD_ITEM = $items->COD_ITEM_MOV;
                $cabecera->TXT_ITEM = $items->TXT_ITEM_MOV;
                $cabecera->COD_EMPRESA_PROVEEDOR = $empresa_trab->COD_EMPR;
                $cabecera->TXT_EMPRESA_PROVEEDOR = $empresa_trab->NOM_EMPR;
                $cabecera->COD_CUENTA = $cuenta->COD_CONTRATO;
                $cabecera->TXT_CUENTA = $cuenta->TXT_EMPR_CLIENTE;
                $cabecera->COD_SUBCUENTA = $subcuenta->COD_CONTRATO;
                $cabecera->TXT_SUBCUENTA = $subcuenta->TXT_ZONA_COMERCIAL . '-' . $subcuenta->TXT_ZONA_CULTIVO;
                $cabecera->COD_EMPRESA = Session::get('empresas')->COD_EMPR;
                $cabecera->TXT_EMPRESA = Session::get('empresas')->NOM_EMPR;
                $cabecera->COD_CENTRO = $liquidaciongastos->COD_CENTRO;
                $cabecera->TXT_CENTRO = $liquidaciongastos->NOM_CENTRO;

                $cabecera->SUCCESS = $SUCCESS;
                $cabecera->MESSAGE = $MESSAGE;
                $cabecera->ESTADOCP = $ESTADOCP;
                $cabecera->NESTADOCP = $NESTADOCP;
                $cabecera->ESTADORUC = $ESTADORUC;
                $cabecera->NESTADORUC = $NESTADORUC;
                $cabecera->CONDDOMIRUC = $CONDDOMIRUC;
                $cabecera->NCONDDOMIRUC = $NCONDDOMIRUC;
                $cabecera->CODIGO_CDR = $CODIGO_CDR;
                $cabecera->RESPUESTA_CDR = $RESPUESTA_CDR;

                $cabecera->COD_PLA_MOVILIDAD = $cod_planila;
                $cabecera->TXT_GLOSA = $glosadet;

                $cabecera->IND_OBSERVACION = 0;
                $cabecera->AREA_OBSERVACION = '';

                $cabecera->IGV = 0;
                $cabecera->SUBTOTAL = $TOTAL_T;
                $cabecera->TOTAL = $TOTAL_T;
                $cabecera->TOKEN = $token;

                $cabecera->FECHA_CREA = $this->fechaactual;
                $cabecera->USUARIO_CREA = Session::get('usuario')->id;
                $cabecera->save();


                if ($tipodoc_id == 'TDO0000000000001') {


                    $rutapdfencontrada = $request['RUTACOMPLETAPDF'];


                    if ($rutapdfencontrada == "") {
                        $tarchivos = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                            ->whereIn('COD_CATEGORIA', ['DCC0000000000036'])->get();
                        foreach ($tarchivos as $index => $itema) {
                            $filescdm = $request[$itema->COD_CATEGORIA];
                            if (!is_null($filescdm)) {
                                //CDR
                                foreach ($filescdm as $file) {
                                    //
                                    $contadorArchivos = Archivo::count();

                                    /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                    $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                                    $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $iddocumento;
                                    $nombrefilecdr = $contadorArchivos . '-' . $file->getClientOriginalName();
                                    $valor = $this->versicarpetanoexiste($rutafile);
                                    $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                                    copy($file->getRealPath(), $rutacompleta);
                                    $path = $rutacompleta;
                                    $nombreoriginal = $file->getClientOriginalName();
                                    $info = new SplFileInfo($nombreoriginal);
                                    $extension = $info->getExtension();
                                    $dcontrol = new Archivo;
                                    $dcontrol->ID_DOCUMENTO = $iddocumento;
                                    $dcontrol->DOCUMENTO_ITEM = $item;
                                    $dcontrol->TIPO_ARCHIVO = $itema->COD_CATEGORIA;
                                    $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                                    $dcontrol->DESCRIPCION_ARCHIVO = $itema->NOM_CATEGORIA;
                                    $dcontrol->URL_ARCHIVO = $path;
                                    $dcontrol->SIZE = filesize($file);
                                    $dcontrol->EXTENSION = $extension;
                                    $dcontrol->ACTIVO = 1;
                                    $dcontrol->FECHA_CREA = $this->fechaactual;
                                    $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                                    $dcontrol->save();
                                }
                            }
                        }
                    } else {

                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $iddocumento;
                        $dcontrol->DOCUMENTO_ITEM = $item;
                        $dcontrol->TIPO_ARCHIVO = 'DCC0000000000036';
                        $dcontrol->NOMBRE_ARCHIVO = $request['NOMBREPDF'];
                        $dcontrol->DESCRIPCION_ARCHIVO = 'COMPROBANTE ELECTRONICO';
                        $dcontrol->URL_ARCHIVO = $request['RUTACOMPLETAPDF'];
                        $dcontrol->SIZE = 1000;
                        $dcontrol->EXTENSION = 'pdf';
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();

                    }


                    $producto = DB::table('ALM.PRODUCTO')->where('NOM_PRODUCTO', '=', $request['producto_id_factura'])->first();
                                       
                    if($request['producto_id_factura'] != 'MOVILIDAD AEROPUERTO'){

                        $importe = $request['totaldetalle'];
                        $resta = 0;
                        $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();

                        $referencia_asoc =  DB::table('CMP.REFERENCIA_ASOC')
                                            ->where('TXT_DESCRIPCION', 'ARENDIR')
                                            ->where('TXT_TABLA_ASOC', $producto->NOM_PRODUCTO)
                                            ->first();

                        $producto_id = $producto->NOM_PRODUCTO;
                        //DD($referencia_asoc);
                        if (!empty($ULTIMA_FECHA_RENDICION_DET)) {
                            if(count($referencia_asoc)>0){
                                
                                $mensaje_error_vale = $this->validar_reembolso_supere_monto($liquidaciongastos,$liquidaciongastos->ARENDIR,$referencia_asoc->COD_TABLA,$importe,$producto_id,$resta);
                                if($mensaje_error_vale!=''){
                                    return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/-1')->with('errorbd', $mensaje_error_vale); 
                                }
                            }else{
                                return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/-1')->with('errorbd', 'Este producto no esta relacionado en la tabla referencia');
                            }
                        }
                    }



                    //dd($producto);
                    $fecha_creacion = $this->hoy;
                    $cantidad = 1;
                    $subtotal = $request['totaldetalle'];
                    $total = $request['totaldetalle'];
                    $igv_id = $request['igv_id_factura'];
                    if ($igv_id == '1') {
                        $subtotal = $total / 1.18;
                    }

                    $cabecera = new LqgDetDocumentoLiquidacionGasto;
                    $cabecera->ID_DOCUMENTO = $iddocumento;
                    $cabecera->ITEM = $item;
                    $cabecera->ITEMDOCUMENTO = 1;
                    $cabecera->COD_PRODUCTO = $producto->COD_PRODUCTO;
                    $cabecera->TXT_PRODUCTO = $producto->NOM_PRODUCTO;
                    $cabecera->CANTIDAD = $cantidad;
                    $cabecera->PRECIO = $total;
                    $cabecera->IND_IGV = $igv_id;
                    $cabecera->IGV = $total - $subtotal;
                    $cabecera->SUBTOTAL = $subtotal;
                    $cabecera->TOTAL = $total;
                    $cabecera->COD_EMPRESA = Session::get('empresas')->COD_EMPR;
                    $cabecera->TXT_EMPRESA = Session::get('empresas')->NOM_EMPR;
                    $cabecera->COD_CENTRO = $liquidaciongastos->COD_CENTRO;
                    $cabecera->TXT_CENTRO = $liquidaciongastos->TXT_CENTRO;
                    $cabecera->FECHA_CREA = $this->fechaactual;
                    $cabecera->USUARIO_CREA = Session::get('usuario')->id;
                    $cabecera->save();


                } else {
                    if ($tipodoc_id == 'TDO0000000000070') {

                        $rutacompleta = $request['rutacompleta'];
                        $nombrearchivo = $request['nombrearchivo'];
                        $nombrefilecdr = $nombrearchivo;
                        $dcontrol = new Archivo;
                        $dcontrol->ID_DOCUMENTO = $iddocumento;
                        $dcontrol->DOCUMENTO_ITEM = $item;
                        $dcontrol->TIPO_ARCHIVO = 'DCC0000000000036';
                        $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                        $dcontrol->DESCRIPCION_ARCHIVO = 'COMPROBANTE ELECTRONICO';
                        $dcontrol->URL_ARCHIVO = $rutacompleta;
                        $dcontrol->SIZE = 100;
                        $dcontrol->EXTENSION = 'pdf';
                        $dcontrol->ACTIVO = 1;
                        $dcontrol->FECHA_CREA = $this->fechaactual;
                        $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                        $dcontrol->save();

                    } else {

                        $tarchivos = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
                            ->whereIn('COD_CATEGORIA', ['DCC0000000000036'])->get();
                        foreach ($tarchivos as $index => $itema) {
                            $filescdm = $request[$itema->COD_CATEGORIA];
                            if (!is_null($filescdm)) {
                                //CDR
                                foreach ($filescdm as $file) {
                                    //
                                    $contadorArchivos = Archivo::count();

                                    /****************************************  COPIAR EL XML EN LA CARPETA COMPARTIDA  *********************************/
                                    $prefijocarperta = $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
                                    $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $iddocumento;
                                    $nombrefilecdr = $contadorArchivos . '-' . $file->getClientOriginalName();
                                    $valor = $this->versicarpetanoexiste($rutafile);
                                    $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
                                    copy($file->getRealPath(), $rutacompleta);
                                    $path = $rutacompleta;
                                    $nombreoriginal = $file->getClientOriginalName();
                                    $info = new SplFileInfo($nombreoriginal);
                                    $extension = $info->getExtension();
                                    $dcontrol = new Archivo;
                                    $dcontrol->ID_DOCUMENTO = $iddocumento;
                                    $dcontrol->DOCUMENTO_ITEM = $item;

                                    $dcontrol->TIPO_ARCHIVO = $itema->COD_CATEGORIA;
                                    $dcontrol->NOMBRE_ARCHIVO = $nombrefilecdr;
                                    $dcontrol->DESCRIPCION_ARCHIVO = $itema->NOM_CATEGORIA;
                                    $dcontrol->URL_ARCHIVO = $path;
                                    $dcontrol->SIZE = filesize($file);
                                    $dcontrol->EXTENSION = $extension;
                                    $dcontrol->ACTIVO = 1;
                                    $dcontrol->FECHA_CREA = $this->fechaactual;
                                    $dcontrol->USUARIO_CREA = Session::get('usuario')->id;
                                    $dcontrol->save();
                                }
                            }
                        }

                        //AGREGAR DETALLE DE TICKET Y BOLETA

                        $producto_id = $request['producto_id_factura'];
                        $importe = (float)$request['totaldetalle'];
                        $igv_id = $request['igv_id_factura'];
                        $anio = $this->anio;
                        $mes = $this->mes;

                        $periodo = $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
                        $detliquidaciongasto = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $item)->first();
                        $detdocumentolg = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $item)->get();

                        
                        $itemdet = count($detdocumentolg) + 1;
                        $producto = DB::table('ALM.PRODUCTO')->where('NOM_PRODUCTO', '=', $producto_id)->first();
                        $fecha_creacion = $this->hoy;
                        $cantidad = 1;
                        $subtotal = $importe;

                        $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
                        $referencia_asoc =  DB::table('CMP.REFERENCIA_ASOC')
                                            ->where('TXT_DESCRIPCION', 'ARENDIR')
                                            ->where('TXT_TABLA_ASOC', $producto_id)
                                            ->first();
                        $resta = 0;

                        if ($liquidaciongastos->ARENDIR == 'REEMBOLSO') {
                            $ldetallearendir = DB::table('WEB.VALE_RENDIR_DETALLE_REEMBOLSO')
                                                ->where('ID', $liquidaciongastos->ARENDIR_ID)
                                                ->where('COD_ESTADO', 1)
                                                ->get();

                        }else{
                            $ldetallearendir = DB::table('WEB.VALE_RENDIR_DETALLE')
                                ->where('ID', $liquidaciongastos->ARENDIR_ID)
                                ->where('COD_ESTADO', 1)
                                ->get();
                        }

                        if($detliquidaciongasto->COD_TIPODOCUMENTO !='TDO0000000000010'){
                            if($request['producto_id_factura'] == 'SERVICIO DE TRANSPORTE AEREO'){
                                return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', 'Este producto solo se puede registrar con ticket');
                            }
                        }

                        $IND_OSIRIS = 0;
                        if($detliquidaciongasto->COD_TIPODOCUMENTO =='TDO0000000000010'){
                            if($request['producto_id_factura'] == 'SERVICIO DE TRANSPORTE AEREO'){

                                $arendri            =   DB::table('WEB.VALE_RENDIR')
                                                        ->where('ID', $liquidaciongastos->ARENDIR_ID)
                                                        ->first(); 

                                if(count($arendri)>0){
                                    if($arendri->TIPO_MOTIVO == 'TIP0000000000003'){
                                        $IND_OSIRIS = 1;
                                        LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM', '=', $item)
                                                    ->update(
                                                            [
                                                                'IND_OSIRIS'=> 1
                                                            ]); 
                                    }
                                }


                            }
                        }

                        if($request['producto_id_factura'] == 'MOVILIDAD AEROPUERTO'){
                            return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', 'Este producto solo se puede registrar con factura');
                        }


                        if($request['producto_id_factura'] != 'SERVICIO DE TRANSPORTE AEREO'){
                            if(count($ldetallearendir)>0){
                                if(count($referencia_asoc)>0){
                                    $mensaje_error_vale = $this->validar_reembolso_supere_monto($liquidaciongastos,$liquidaciongastos->ARENDIR,$referencia_asoc->COD_TABLA,$importe,$producto_id,0);
                                    if($mensaje_error_vale!=''){
                                        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', $mensaje_error_vale); 
                                    }
                                }else{
                                    return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $item)->with('errorbd', 'Este producto no esta relacionado en la tabla referencia');
                                }
                            }
                        }      

                        $total = $importe;
                        if ($igv_id == '1') {
                            $subtotal = $importe / 1.18;
                        }


                        $cabecera = new LqgDetDocumentoLiquidacionGasto;
                        $cabecera->ID_DOCUMENTO = $iddocumento;
                        $cabecera->ITEM = $detliquidaciongasto->ITEM;
                        $cabecera->ITEMDOCUMENTO = $itemdet;
                        $cabecera->COD_PRODUCTO = $producto->COD_PRODUCTO;
                        $cabecera->TXT_PRODUCTO = $producto->NOM_PRODUCTO;
                        $cabecera->CANTIDAD = $cantidad;
                        $cabecera->PRECIO = $importe;
                        $cabecera->IND_IGV = $igv_id;
                        $cabecera->IGV = $total - $subtotal;
                        $cabecera->SUBTOTAL = $subtotal;
                        $cabecera->TOTAL = $total;
                        $cabecera->COD_EMPRESA = Session::get('empresas')->COD_EMPR;
                        $cabecera->TXT_EMPRESA = Session::get('empresas')->NOM_EMPR;
                        $cabecera->COD_CENTRO = $detliquidaciongasto->COD_CENTRO;
                        $cabecera->TXT_CENTRO = $detliquidaciongasto->TXT_CENTRO;
                        $cabecera->FECHA_CREA = $this->fechaactual;
                        $cabecera->USUARIO_CREA = Session::get('usuario')->id;
                        $cabecera->IND_OSIRIS = $IND_OSIRIS;
                        $cabecera->save();

                    }
                }


                //GUARDAR EL DETALLE SI VIENE DE UNA PLANILLA DE MOVILIDAD
                if (ltrim(rtrim($cod_planila)) != '') {
                    $planillamovilidad = DB::table('PLA_MOVILIDAD')
                        ->where('ID_DOCUMENTO', $cod_planila)
                        ->first();
                    $producto_id = 'PRD0000000003866';
                    $importe = $planillamovilidad->TOTAL;
                    $producto = DB::table('ALM.PRODUCTO')->where('COD_PRODUCTO', '=', $producto_id)->first();
                    $cantidad = 1;
                    $igv_id = 0;
                    $subtotal = $importe;

                    $cabeceradet = new LqgDetDocumentoLiquidacionGasto;
                    $cabeceradet->ID_DOCUMENTO = $iddocumento;
                    $cabeceradet->ITEM = $item;
                    $cabeceradet->ITEMDOCUMENTO = 1;
                    $cabeceradet->COD_PRODUCTO = $producto->COD_PRODUCTO;
                    $cabeceradet->TXT_PRODUCTO = $producto->NOM_PRODUCTO;
                    $cabeceradet->CANTIDAD = $cantidad;
                    $cabeceradet->PRECIO = $importe;
                    $cabeceradet->IND_IGV = 0;
                    $cabeceradet->IGV = 0;
                    $cabeceradet->SUBTOTAL = $subtotal;
                    $cabeceradet->TOTAL = $importe;
                    $cabeceradet->COD_EMPRESA = Session::get('empresas')->COD_EMPR;
                    $cabeceradet->TXT_EMPRESA = Session::get('empresas')->NOM_EMPR;
                    $cabeceradet->COD_CENTRO = $planillamovilidad->COD_CENTRO;
                    $cabeceradet->TXT_CENTRO = $planillamovilidad->TXT_CENTRO;
                    $cabeceradet->FECHA_CREA = $this->fechaactual;
                    $cabeceradet->USUARIO_CREA = Session::get('usuario')->id;
                    $cabeceradet->save();
                }
                $itemsel = $item;
                if ($tipodoc_id == 'TDO0000000000070' || $tipodoc_id == 'TDO0000000000001') {
                    $itemsel = '0';
                }
                                    //dd("entro02");

                $this->lg_calcular_total($iddocumento, $item);
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();

                //DD("ERROR");
                return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
            return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/' . $itemsel)->with('bienhecho', 'Documento ' . $serie . '-' . $numero . ' registrado con exito');
        }

    }


    public function actionExtornarLiquidacionGastos($idopcion, $iddocumento, Request $request)
    {

        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');

        View::share('titulo', 'Agregar Detalle Liquidacion de Gastos');
        $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
        $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', 1)->get();
        $tdetliquidaciongastosobs = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', 0)->get();

        if ($liquidaciongastos->COD_ESTADO != 'ETM0000000000001' && $liquidaciongastos->IND_OBSERVACION == 0) {
            return Redirect::to('gestion-de-liquidacion-gastos/' . $idopcion)->with('errorbd', 'Ya no puede extornar esta LIQUIDACION DE GASTOS');
        }




        $liquidaciongastos->ACTIVO = 0;
        $liquidaciongastos->save();

        DB::table('LQG_DETLIQUIDACIONGASTO')
            ->where('ID_DOCUMENTO', $iddocumento) // ID vacío
            ->update(['ACTIVO' => 0]);

        return Redirect::to('gestion-de-liquidacion-gastos/' . $idopcion)->with('bienhecho', 'Se extorno la LIQUIDACION DE GASTOS');

    }


    public function actionExtornarLiquidacionGastosDetalle($idopcion, $item, $iddocumento, Request $request)
    {
        $idcab = $iddocumento;


        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        View::share('titulo', 'Extonar Detalle Liquidacion de Gastos');
        $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
        if ($liquidaciongastos->COD_ESTADO != 'ETM0000000000001' && $liquidaciongastos->IND_OBSERVACION == 0) {
            return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')->with('errorbd', 'Ya no puede extornar esta LIQUIDACION DE GASTOS');
        }
        LqgDetLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)->where('ITEM', $item)
            ->update(
                [
                    'ACTIVO' => 0,
                    'FECHA_MOD' => $this->fechaactual,
                    'USUARIO_MOD' => Session::get('usuario')->id
                ]
            );
        LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', $iddocumento)->where('ITEM', $item)
            ->update(
                [
                    'ACTIVO' => 0,
                    'FECHA_MOD' => $this->fechaactual,
                    'USUARIO_MOD' => Session::get('usuario')->id
                ]
            );
        $this->lg_calcular_total_detalle($iddocumento);

        return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $idcab . '/0')->with('bienhecho', 'Documento ' . $iddocumento . ' extornado con exito');
    }


    public function actionModificarLiquidacionGastos($idopcion, $iddocumento, $valor, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento, 'LIQG');
        View::share('titulo', 'Agregar Detalle Liquidacion de Gastos');
        $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->first();
        $tdetliquidaciongastos = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', 1)->orderby('FECHA_CREA', 'desc')->get();
        $tdetliquidaciongastosobs = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', 0)->get();


        if ($liquidaciongastos->COD_ESTADO != 'ETM0000000000001' && $liquidaciongastos->IND_OBSERVACION == 0) {
            return Redirect::to('gestion-de-liquidacion-gastos/' . $idopcion)->with('errorbd', 'Ya no puede modificar esta LIQUIDACION DE GASTOS');
        }
        $fecha_emision = $this->hoy_sh;
        $ajax = false;
        $valor_nuevo = '';
        if ($valor == '-1') {
            $valor_nuevo = $valor;
            $valor = '0';
        }
        $trabajador = DB::table('STD.TRABAJADOR')
            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
            ->first();
        $dni = '';
        if (count($trabajador) > 0) {
            $dni = $trabajador->NRO_DOCUMENTO;
        }

        $trabajadorespla = DB::table('WEB.platrabajadores')
            ->where('situacion_id', 'PRMAECEN000000000002')
            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
            ->where('dni', $dni)
            ->first();

        $terceros   =   DB::table('TERCEROS')
                        ->where('USER_ID', Session::get('usuario')->id)
                        ->where('ACTIVO', 1)
                        ->first();
     
        if (count($terceros) <= 0) {
            if (count($trabajadorespla) <= 0) {
                return Redirect::to('gestion-de-liquidacion-gastos/' . $idopcion)->with('errorbd', 'No existe registro en planilla');
            }
        }


        $tipopago_id = $liquidaciongastos->COD_CATEGORIA_TIPOPAGO;
        $banco_id = $liquidaciongastos->COD_CATEGORIA_BANCARIO;
        $cuentaco_id = $liquidaciongastos->CUENTA_BANCARIA;



        $doc_arendri        =   '';
        $doc_monto          =   '';
        $fechasarendir      =   '';
        $ultimafechaar      =   '';
        $primerafechaar      =   '';

        $arendir        =   WEBValeRendir::where('ID','=',$liquidaciongastos->ARENDIR_ID)->first();

        if ($liquidaciongastos->ARENDIR == 'SI' || $liquidaciongastos->ARENDIR == 'NO') {
            if (count($arendir)>0) {
                $doc_arendri    =   $arendir->TXT_SERIE.'-'.$arendir->TXT_NUMERO;
                $doc_monto      =   $arendir->CAN_TOTAL_IMPORTE;

                $arendirdetalle =   DB::table('WEB.VALE_RENDIR_DETALLE')
                                    ->where('ID','=',$liquidaciongastos->ARENDIR_ID)
                                    ->selectRaw('MIN(FEC_INICIO) as fecha_minima, MAX(FEC_FIN) as fecha_maxima')
                                    ->first();
                if ($arendirdetalle) {
                    $fechasarendir = $arendirdetalle->fecha_minima . ' / ' . $arendirdetalle->fecha_maxima;

                    $primerafechaar= $arendirdetalle->fecha_minima;
                    $ultimafecha   = $arendirdetalle->fecha_maxima;

                } 
            }
        }else{
            if ($liquidaciongastos->ARENDIR == 'VALE') {
                $arendir        =   WEBValeRendir::where('ID','=',$liquidaciongastos->ARENDIR_ID)->first();
                $doc_arendri    =   $arendir->TXT_SERIE.'-'.$arendir->TXT_NUMERO;
                $doc_monto      =   $arendir->CAN_TOTAL_IMPORTE;
                $arendirdetalle =   DB::table('WEB.VALE_RENDIR_DETALLE')
                                    ->where('ID','=',$liquidaciongastos->ARENDIR_ID)
                                    ->selectRaw('MIN(FEC_INICIO) as fecha_minima, MAX(FEC_FIN) as fecha_maxima')
                                    ->first();
                if ($arendirdetalle) {
                    $fechasarendir = $arendirdetalle->fecha_minima . ' / ' . $arendirdetalle->fecha_maxima;
                    $primerafechaar= $arendirdetalle->fecha_minima;
                    $ultimafecha   = $arendirdetalle->fecha_maxima;

                }
            }else{


                if ($liquidaciongastos->ARENDIR == 'IMPULSO') {

                    $arendir        =   SemanaImpulso::where('ID_DOCUMENTO','=',$liquidaciongastos->ARENDIR_ID)->first();
                    $doc_arendri    =   $arendir->ID_DOCUMENTO;
                    $doc_monto      =   $arendir->MONTO;


                    $fechasarendir = $arendir->FECHA_INICIO . ' / ' . $arendir->FECHA_FIN;
                    $primerafechaar= $arendir->FECHA_INICIO;
                    $ultimafecha   = $arendir->FECHA_FIN;

                }else{
                    $arendir        =   DB::table('WEB.VALE_RENDIR_REEMBOLSO')->where('ID','=',$liquidaciongastos->ARENDIR_ID)->first();
                    $doc_arendri    =   $arendir->TXT_SERIE.'-'.$arendir->TXT_NUMERO;
                    $doc_monto      =   $arendir->CAN_TOTAL_IMPORTE;
                    $arendirdetalle =   DB::table('WEB.VALE_RENDIR_DETALLE_REEMBOLSO')
                                        ->where('ID','=',$liquidaciongastos->ARENDIR_ID)
                                        ->selectRaw('MIN(FEC_INICIO) as fecha_minima, MAX(FEC_FIN) as fecha_maxima')
                                        ->first();
                    if ($arendirdetalle) {
                        $fechasarendir = $arendirdetalle->fecha_minima . ' / ' . $arendirdetalle->fecha_maxima;
                        $primerafechaar= $arendirdetalle->fecha_minima;
                        $ultimafecha   = $arendirdetalle->fecha_maxima;
                    }
                }

            }
        }


        if ($valor == '0') {

            $active = "documentos";
            $tipodoc_id = '';
            if($liquidaciongastos->ARENDIR == 'IMPULSO'){
                $combo_tipodoc = $this->lg_combo_tipodocumento_impulso("Seleccione Tipo Documento",'TDO0000000000070');
            }else{
                $combo_tipodoc = $this->lg_combo_tipodocumento("Seleccione Tipo Documento");
            }



            $empresa_id = "";
            $combo_empresa = array();
            $cuenta_id = "";
            $combo_cuenta = array();
            $subcuenta_id = "";
            $combo_subcuenta = array();
            $flujo_id = "";
            $combo_flujo = $this->lg_combo_flujo("Seleccione Flujo");
            $item_id = "";
            $combo_item = array();
            $gasto_id = "";
            $combo_gasto = $this->lg_combo_gasto("Seleccione Gasto");


            //terceros
            $terceros   =   DB::table('TERCEROS')
                            ->where('USER_ID', Session::get('usuario')->id)
                            ->where('ACTIVO', 1)
                            ->first();
         
            if (count($terceros) > 0) {
                $area_planilla = $terceros->TXT_AREA;
                //dd($area_planilla);

                $centrocosto = DB::table('CON.CENTRO_COSTO')
                    ->where('COD_ESTADO', 1)
                    ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                    ->where('TXT_NOMBRE', '=', $area_planilla)
                    ->where('IND_MOVIMIENTO', 1)
                    ->first();

                    $combo_costo = $this->lg_combo_costo_xtrabajador_tercero_nombre("Seleccione Costo", $area_planilla);


            }else{
                $area_planilla = $trabajadorespla->cadarea;
                $centrocosto = DB::table('CON.CENTRO_COSTO')
                    ->where('COD_ESTADO', 1)
                    ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                    ->where('TXT_REFERENCIA_PLANILLA', 'LIKE', '%' . $trabajadorespla->cadarea . '%')
                    //->where('TXT_REFERENCIA_PLANILLA', $trabajadorespla->cadarea)
                    ->where('IND_MOVIMIENTO', 1)->first();
                $combo_costo = $this->lg_combo_costo_xtrabajador("Seleccione Costo", $area_planilla);

            }


            $costo_id = "";
            if (count($centrocosto) > 0) {
                $costo_id = $centrocosto->COD_CENTRO_COSTO;
            }


            $tdetliquidacionitem = array();
            $tdetdocliquidacionitem = array();
            $archivos = array();

            if ($valor_nuevo == '-1') {
                $active = "registro";
            }
            //dd($combo_costo);

        } else {


            $active = "registro";
            $tdetliquidacionitem = LqgDetLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ITEM', '=', $valor)->first();
            $tdetdocliquidacionitem = LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->where('ITEM', '=', $valor)->get();

            //dd($tdetliquidacionitem);
            if($liquidaciongastos->ARENDIR == 'IMPULSO'){
                $tipodoc_id = $tdetliquidacionitem->COD_TIPODOCUMENTO;
                $combo_tipodoc = $this->lg_combo_tipodocumento_impulso("Seleccione Tipo Documento",'TDO0000000000070');
            }else{
                $tipodoc_id = $tdetliquidacionitem->COD_TIPODOCUMENTO;
                $combo_tipodoc = $this->lg_combo_tipodocumento("Seleccione Tipo Documento");
            }

            $empresa_id = $tdetliquidacionitem->TXT_EMPRESA_PROVEEDOR;
            $combo_empresa = array($tdetliquidacionitem->TXT_EMPRESA_PROVEEDOR => $tdetliquidacionitem->TXT_EMPRESA_PROVEEDOR);
            $cuenta_id = $tdetliquidacionitem->COD_CUENTA;
            $combo_cuenta = $this->lg_combo_cuenta_lg('Seleccione una Cuenta', '', '', $tdetliquidacionitem->COD_CENTRO, $tdetliquidacionitem->TXT_EMPRESA_PROVEEDOR);

            $subcuenta_id = $tdetliquidacionitem->COD_SUBCUENTA;
            $combo_subcuenta = $this->lg_combo_subcuenta("Seleccione SubCuenta", $tdetliquidacionitem->COD_CUENTA);
            $flujo_id = $tdetliquidacionitem->COD_FLUJO;
            $combo_flujo = $this->lg_combo_flujo("Seleccione Flujo");
            $item_id = $tdetliquidacionitem->COD_ITEM;
            $combo_item = $this->lg_combo_item("Seleccione Item", $tdetliquidacionitem->COD_FLUJO);
            $gasto_id = $tdetliquidacionitem->COD_GASTO;
            $combo_gasto = $this->lg_combo_gasto("Seleccione Gasto");

            $tipopago_id = $liquidaciongastos->COD_CATEGORIA_TIPOPAGO;

            //dd($trabajadorespla);
            $costo_id = $tdetliquidacionitem->COD_COSTO;

            //terceros
            $terceros   =   DB::table('TERCEROS')
                            ->where('USER_ID', Session::get('usuario')->id)
                            ->where('ACTIVO', 1)
                            ->first();
         
            if (count($terceros) > 0) {
                $area_planilla = $terceros->TXT_AREA;
                // $centrocosto = DB::table('CON.CENTRO_COSTO')
                //     ->where('COD_ESTADO', 1)
                //     ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                //     ->where('COD_CENTRO_COSTO', '=', $terceros->COD_AREA)
                //     ->where('IND_MOVIMIENTO', 1)->first();
                //     $combo_costo = $this->lg_combo_costo_xtrabajador_tercero("Seleccione Costo", $terceros->COD_AREA);

                $centrocosto = DB::table('CON.CENTRO_COSTO')
                    ->where('COD_ESTADO', 1)
                    ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                    ->where('TXT_NOMBRE', '=', $area_planilla)
                    ->where('IND_MOVIMIENTO', 1)
                    ->first();

                    $combo_costo = $this->lg_combo_costo_xtrabajador_tercero_nombre("Seleccione Costo", $area_planilla);



            }else{
                $area_planilla = $trabajadorespla->cadarea;
                $centrocosto = DB::table('CON.CENTRO_COSTO')
                    ->where('COD_ESTADO', 1)
                    ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                    ->where('TXT_REFERENCIA_PLANILLA', 'LIKE', '%' . $trabajadorespla->cadarea . '%')
                    //->where('TXT_REFERENCIA_PLANILLA', $trabajadorespla->cadarea)
                    ->where('IND_MOVIMIENTO', 1)->first();
                $combo_costo = $this->lg_combo_costo_xtrabajador("Seleccione Costo", $trabajadorespla->cadarea);
            }


            $ajax = true;
            $archivos = Archivo::where('ID_DOCUMENTO', '=', $iddocumento)->where('ACTIVO', '=', '1')->where('DOCUMENTO_ITEM', '=', $valor)->get();

        }


        $tarchivos = CMPCategoria::where('TXT_GRUPO', '=', 'DOCUMENTOS_COMPRA')
            ->whereIn('COD_CATEGORIA', ['DCC0000000000036', 'DCC0000000000004'])->get();


        $autoriza_id = $liquidaciongastos->COD_USUARIO_AUTORIZA;
        $combo_autoriza = $this->gn_combo_usuarios();
        $array_detalle_producto = array();
        $documentohistorial = LqgDocumentoHistorial::where('ID_DOCUMENTO', '=', $iddocumento)->orderby('FECHA', 'DESC')->get();

        $producto_id = "";
        $arrayproducto = DB::table('ALM.PRODUCTO')
            ->where('ALM.PRODUCTO.COD_ESTADO', '=', 1)
            ->where('ALM.PRODUCTO.IND_DISPONIBLE', '=', 1)
            ->where('ALM.PRODUCTO.IND_MATERIAL_SERVICIO', '=', 'S')
            ->where('COD_CATEGORIA_CLASE', '=', '1')
            ->pluck('NOM_PRODUCTO', 'NOM_PRODUCTO')->toArray();

        $comboproducto = array('' => "SELECCIONE PRODUCTO") + $arrayproducto;

        $igv_id = "";
        $combo_igv = array('' => "¿SELECCIONE SI TIENE IGV?", '1' => "SI", '0' => "NO");


        $combo_tp = array('' => "SELECCIONE TIPO DE PAGO", 'MPC0000000000001' => "EFECTIVO", 'MPC0000000000002' => "TRANSFERENCIA");

        $arraybancos = DB::table('CMP.CATEGORIA')->where('TXT_GRUPO', '=', 'BANCOS_MERGE')->where('COD_ESTADO', '=', '1')->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')->toArray();
        $combobancos = array('' => "Seleccione Entidad Bancaria") + $arraybancos;

        $numero_cuenta ="";
        $banco_nombre ="";
        $banco_e_id ="";

        $cod_empr               =   Session::get('empresas')->COD_EMPR;
        $values                 =   [$dni,$cod_empr];
        $datoscuentasueldo      =   DB::select('exec ListaTrabajadorCuentaSueldo ?,?',$values);
        $txt_categoria_banco    =   '';
        $numero_cuenta          =   '';
        $txt_categoria_banco    =   $datoscuentasueldo[0]->entidad ?? null;
        $numero_cuenta          =   $datoscuentasueldo[0]->numcuenta ?? null;
        $banco                  =   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO', 'BANCOS_MERGE')->where('TXT_REFERENCIA', $txt_categoria_banco)->first();
        if(count($banco)>0){
            $banco_nombre =$banco->NOM_CATEGORIA;
            $banco_e_id =$banco->COD_CATEGORIA;
        }



        if ($tipopago_id == 'MPC0000000000002') {

            $cuentas = DB::table('TES.CUENTA_BANCARIA')
                ->where('COD_EMPR_TITULAR', $liquidaciongastos->COD_EMPRESA_TRABAJADOR)
                ->where('TXT_NRO_CUENTA_BANCARIA', $liquidaciongastos->CUENTA_BANCARIA)
                ->first();

            $combocb = array('' => "Seleccione Cuenta Bancaria", $cuentas->TXT_NRO_CUENTA_BANCARIA => $cuentas->TXT_REFERENCIA . ' - ' . $cuentas->TXT_NRO_CUENTA_BANCARIA);

        } else {
            $combocb = array('' => "Seleccione Cuenta Bancaria");
        }

        if($liquidaciongastos->ARENDIR != 'REEMBOLSO'){
            $tipopago_id = 'MPC0000000000001';
        }



        //dd($combo_costo);
        return View::make('liquidaciongasto.modificarliquidaciongastos',
            [
                'liquidaciongastos' => $liquidaciongastos,
                'tdetliquidaciongastos' => $tdetliquidaciongastos,

                'tipopago_id' => $tipopago_id,
                'combo_tp' => $combo_tp,
                'banco_id' => $banco_id,
                'doc_arendri' => $doc_arendri,
                'doc_monto' => $doc_monto,
                'fechasarendir' => $fechasarendir,
                'primerafechaar' => $primerafechaar,
                'ultimafecha' => $ultimafecha,
                'banco_nombre' => $banco_nombre,
                'banco_e_id' => $banco_e_id,

                'numero_cuenta' => $numero_cuenta,
                'combobancos' => $combobancos,
                'cuenta_id' => $cuenta_id,
                'combocb' => $combocb,
                'cuentaco_id' => $cuentaco_id,
                'igv_id' => $igv_id,
                'combo_igv' => $combo_igv,
                'producto_id' => $producto_id,
                'comboproducto' => $comboproducto,

                'tdetliquidaciongastosobs' => $tdetliquidaciongastosobs,
                'tdetliquidacionitem' => $tdetliquidacionitem,
                'tdetdocliquidacionitem' => $tdetdocliquidacionitem,
                'documentohistorial' => $documentohistorial,
                'tarchivos' => $tarchivos,
                'fecha_emision' => $fecha_emision,
                'active' => $active,
                'empresa_id' => $empresa_id,
                'combo_empresa' => $combo_empresa,
                'cuenta_id' => $cuenta_id,
                'combo_cuenta' => $combo_cuenta,
                'subcuenta_id' => $subcuenta_id,
                'combo_subcuenta' => $combo_subcuenta,
                'array_detalle_producto' => $array_detalle_producto,
                'archivos' => $archivos,
                'autoriza_id' => $autoriza_id,
                'combo_autoriza' => $combo_autoriza,


                'flujo_id' => $flujo_id,
                'combo_flujo' => $combo_flujo,
                'item_id' => $item_id,
                'combo_item' => $combo_item,

                'gasto_id' => $gasto_id,
                'combo_gasto' => $combo_gasto,
                'costo_id' => $costo_id,
                'combo_costo' => $combo_costo,

                'tipodoc_id' => $tipodoc_id,
                'combo_tipodoc' => $combo_tipodoc,

                'idopcion' => $idopcion,


            ]);


    }


    public function actionAgregarLiquidacionGastos($idopcion, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Anadir');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/

        if ($_POST) {

            try {

                DB::beginTransaction();

                $anio = $this->anio;
                $mes = $this->mes;
                $periodo = $this->gn_periodo_actual_xanio_xempresa($anio, $mes, Session::get('empresas')->COD_EMPR);
                $empresa_id = $request['empresa_id'];
                $arendir_id = $request['arendir_id'];
                $glosa = $request['glosa'];
                $cuenta_id = $request['cuenta_id'];
                $subcuenta_id = $request['subcuenta_id'];
                $centro_txt = $request['centro_txt'];
                $arendir_sel_id = $request['arendir_sel_id'];
                $moneda_sel_id = $request['moneda_sel_c_id'];

                if ($arendir_id == 'REEMBOLSO') {
                    $vale = DB::table('WEB.VALE_RENDIR_REEMBOLSO')->where('ID', $arendir_sel_id)->first();
                    $fechavale = $vale->FEC_USUARIO_CREA_AUD;

                    list($aniovale, $mesvale, $diavale) = explode('-', $fechavale);
                    $aniosistemas = date("Y");
                    $messistemas = date("m");
                    // if ($aniovale != $aniosistemas && $mesvale != $messistemas) {
                    //     return Redirect::to('agregar-liquidacion-gastos/' . $idopcion)->with('errorbd', 'La fecha del arendir no corresponde esta dentro del periodo de la Liquidacion de Gasto');
                    // }

                } else {

                    if ($arendir_id == 'IMPULSO') {
                        $vale = DB::table('SEMANA_IMPULSO')->where('ID_DOCUMENTO', $arendir_sel_id)->first();
                        $fechavale = $vale->FECHA_EMI;
                        list($aniovale, $mesvale, $diavale) = explode('-', $fechavale);
                        $aniosistemas = date("Y");
                        $messistemas = date("m");
                        if ($aniovale != $aniosistemas && $mesvale != $messistemas) {
                            return Redirect::to('agregar-liquidacion-gastos/' . $idopcion)->with('errorbd', 'La fecha del impulso no corresponde esta dentro del periodo de la Liquidacion de Gasto');
                        }

                    } else {

                        $vale = DB::table('WEB.VALE_RENDIR')->where('ID', $arendir_sel_id)->first();
                        $fechavale = $vale->FEC_AUTORIZACION;
                        list($aniovale, $mesvale, $diavale) = explode('-', $fechavale);
                        $aniosistemas = date("Y");
                        $messistemas = date("m");
                        if ($aniovale != $aniosistemas && $mesvale != $messistemas) {
                            return Redirect::to('agregar-liquidacion-gastos/' . $idopcion)->with('errorbd', 'La fecha del arendir no corresponde esta dentro del periodo de la Liquidacion de Gasto');
                        }

                    }



                }

                $codigo = $this->funciones->generar_codigo('LQG_LIQUIDACION_GASTO', 8);
                $idcab = $this->funciones->getCreateIdMaestradocpla('LQG_LIQUIDACION_GASTO', 'LIQG');
                $empresa_trab = STDEmpresa::where('COD_EMPR', '=', $empresa_id)->first();
                $cuenta = CMPContrato::where('COD_CONTRATO', '=', $cuenta_id)->first();
                $subcuenta = CMPContratoCultivo::where('COD_CONTRATO', '=', $subcuenta_id)->first();
                $centro = ALMCentro::where('NOM_CENTRO', '=', $centro_txt)->first();
                $moneda = CMPCategoria::where('COD_CATEGORIA', '=', $moneda_sel_id)->first();

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
                $usuario_id = $request['autoriza_id'];
                $usuario = User::where('id', '=', $usuario_id)->first();


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

                //terceros
                $terceros   =   DB::table('TERCEROS')
                                ->where('USER_ID', Session::get('usuario')->id)
                                ->where('ACTIVO', 1)
                                ->first();
             
                if (count($terceros) > 0) {
                    $area_planilla = $terceros->TXT_AREA;
                    $centrocosto = DB::table('CON.CENTRO_COSTO')
                        ->where('COD_ESTADO', 1)
                        ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                        ->where('TXT_NOMBRE', '=', $area_planilla)
                        ->where('IND_MOVIMIENTO', 1)->first();
                }else{
                    $area_planilla = $trabajadorespla->cadarea;
                    $centrocosto = DB::table('CON.CENTRO_COSTO')
                        ->where('COD_ESTADO', 1)
                        ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                        //->where('TXT_REFERENCIA_PLANILLA', $trabajadorespla->cadarea)
                        ->where('TXT_REFERENCIA_PLANILLA', 'LIKE', '%' . $trabajadorespla->cadarea . '%')
                        ->where('IND_MOVIMIENTO', 1)->first();
                }

                $area_id = "";
                $area_txt = "";

                //hola
                if (count($centrocosto) > 0) {
                    $area_id = $centrocosto->COD_CENTRO_COSTO;
                    $area_txt = $centrocosto->TXT_NOMBRE;
                }

                //dd($moneda);
                $cabecera = new LqgLiquidacionGasto;
                $cabecera->ID_DOCUMENTO = $idcab;
                $cabecera->CODIGO = $codigo;
                $cabecera->COD_EMPRESA_TRABAJADOR = $empresa_trab->COD_EMPR;
                $cabecera->TXT_EMPRESA_TRABAJADOR = $empresa_trab->NOM_EMPR;
                $cabecera->COD_CUENTA = $cuenta->COD_CONTRATO;
                $cabecera->TXT_CUENTA = $contrato;
                $cabecera->COD_SUBCUENTA = $subcuenta->COD_CONTRATO;
                $cabecera->TXT_SUBCUENTA = $subcuenta->TXT_ZONA_COMERCIAL . '-' . $subcuenta->TXT_ZONA_CULTIVO;
                $cabecera->ARENDIR = $arendir_id;
                $cabecera->TXT_GLOSA = $glosa;
                $cabecera->COD_EMPRESA = Session::get('empresas')->COD_EMPR;
                $cabecera->TXT_EMPRESA = Session::get('empresas')->NOM_EMPR;
                $cabecera->COD_PERIODO = $periodo->COD_PERIODO;
                $cabecera->TXT_PERIODO = $periodo->TXT_NOMBRE;
                $cabecera->COD_ESTADO = 'ETM0000000000001';
                $cabecera->TXT_ESTADO = 'GENERADO';
                $cabecera->ARENDIR_ID = $arendir_sel_id;

                $cabecera->COD_CATEGORIA_MONEDA = $moneda->COD_CATEGORIA;
                $cabecera->TXT_CATEGORIA_MONEDA = $moneda->NOM_CATEGORIA;
                $cabecera->COD_AREA = $area_id;
                $cabecera->TXT_AREA = $area_txt;

                $cabecera->COD_CENTRO = $centro->COD_CENTRO;
                $cabecera->TXT_CENTRO = $centro->NOM_CENTRO;
                $cabecera->COD_USUARIO_AUTORIZA = $usuario->id;
                $cabecera->TXT_USUARIO_AUTORIZA = $usuario->nombre;
                $cabecera->IND_OBSERVACION = 0;
                $cabecera->AREA_OBSERVACION = '';
                $cabecera->TXT_OBSERVACION = '';
                $cabecera->TOTAL = 0;
                $cabecera->FECHA_CREA = $this->fechaactual;
                $cabecera->USUARIO_CREA = Session::get('usuario')->id;
                $cabecera->save();

                //dd("hola");

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('gestion-de-liquidacion-gastos/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
            $iddocumento = Hashids::encode(substr($idcab, -8));
            return Redirect::to('modificar-liquidacion-gastos/' . $idopcion . '/' . $iddocumento . '/' . '0')->with('bienhecho', 'Liquidacion de Gastos ' . $codigo . ' registrado con exito, ingrese sus comprobantes');
        } else {


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
            } else {
                //terceros
                $terceros   =   DB::table('TERCEROS')
                                ->where('USER_ID', Session::get('usuario')->id)
                                ->where('ACTIVO', 1)
                                ->first();
                if (count($terceros) <= 0) {
                    return Redirect::to('gestion-de-liquidacion-gastos/' . $idopcion)->with('errorbd', 'No puede realizar un registro porque no es la empresa a cual pertenece');
                }

            }

            $terceros   =   DB::table('TERCEROS')
                            ->where('USER_ID', Session::get('usuario')->id)
                            ->where('ACTIVO', 1)
                            ->first();
            if (count($terceros) > 0) {
                $centro_id = $terceros->COD_CENTRO;
            }

            $trabajador = DB::table('STD.TRABAJADOR')
                ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                ->first();

            $dni = '';
            if (count($trabajador) > 0) {
                $dni = $trabajador->NRO_DOCUMENTO;
            }

            $trabajadorespla = DB::table('WEB.platrabajadores')
                ->where('situacion_id', 'PRMAECEN000000000002')
                ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
                ->where('dni', $dni)
                ->first();

            //terceros
            $terceros   =   DB::table('TERCEROS')
                            ->where('USER_ID', Session::get('usuario')->id)
                            ->where('ACTIVO', 1)
                            ->first();

            if (count($terceros) > 0) {
                $area_planilla = $terceros->TXT_AREA;

                $centrocosto = DB::table('CON.CENTRO_COSTO')
                    ->where('COD_ESTADO', 1)
                    ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                    ->where('TXT_NOMBRE', '=', $area_planilla)
                    ->where('IND_MOVIMIENTO', 1)->first();

            }else{
                $area_planilla = $trabajadorespla->cadarea;
                $centrocosto = DB::table('CON.CENTRO_COSTO')
                    ->where('COD_ESTADO', 1)
                    ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                    ->where('TXT_REFERENCIA_PLANILLA', 'LIKE', '%' . $trabajadorespla->cadarea . '%')
                    ->where('IND_MOVIMIENTO', 1)->first();

            }


            $anio = $this->anio;
            $mes = $this->mes;



            $area_id = "";
            $area_txt = "";
            //hola
            if (count($centrocosto) > 0) {
                $area_id = $centrocosto->COD_CENTRO_COSTO;
                $area_txt = $centrocosto->TXT_NOMBRE;
            }

            $empresa = DB::table('STD.EMPRESA')
                ->where('NRO_DOCUMENTO', $dni)
                ->first();


            $empresa_id = "";
            $combo_empresa = array();
            $cuenta_id = "";
            $combo_cuenta = array();
            $subcuenta_id = "";
            $combo_subcuenta = array();
            $cod_contrato = "";
            if (count($empresa) > 0) {
                $empresa_id = $empresa->COD_EMPR;
                $combo_empresa = array($empresa->COD_EMPR => $empresa->NOM_EMPR);

                $cuenta_id = $this->lg_cuenta_top_1("Seleccione una Cuenta", "", "TCO0000000000069", $centro_id, $empresa_id);
                $combo_cuenta = $this->lg_combo_cuenta("Seleccione una Cuenta", "", "TCO0000000000069", $centro_id, $empresa_id);
                $cuenta_id = "";
                $combo_cuenta = array();
                $cuenta = $this->lg_cuenta("Seleccione una Cuenta", "", "TCO0000000000069", $centro_id, $empresa_id);
                if (count($cuenta) > 0) {
                    $cod_contrato = $cuenta->COD_CONTRATO;
                }
                //dd($cod_contrato);
                $subcuenta_id = $this->lg_subcuenta_top1("Seleccione SubCuenta", $cod_contrato);
                $combo_subcuenta = $this->lg_combo_subcuenta("Seleccione SubCuenta", $cod_contrato);
            }
            $fecha_creacion = $this->hoy;

            $vale = DB::table('WEB.VALE_RENDIR')
                ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                ->where('COD_USUARIO_CREA_AUD', Session::get('usuario')->id)
                ->where('COD_CATEGORIA_ESTADO_VALE', 'ETM0000000000007')
                ->get();


            if (count($vale) > 0) {
                $combo_arendir = array('' => "SELECCIONE SI TIENE A RENDIR", 'SI' => "SI");
            } else {
                $combo_arendir = array('' => "SELECCIONE SI TIENE A RENDIR", 'NO' => "NO");
            }
            $combo_arendir = array('' => "SELECCIONE UN A RENDIR", 'VALE' => "VALE A RENDIR", 'REEMBOLSO' => "REEMBOLSO", 'IMPULSO' => "MOVILIDAD IMPULSO");
            $combo_arendir = array('' => "SELECCIONE UN A RENDIR", 'VALE' => "VALE A RENDIR", 'REEMBOLSO' => "REEMBOLSO");

            //$combo_arendir       =   array('' => "SELECCIONE SI TIENE A RENDIR",'NO' => "NO");
            $arendir_id = "";
            $centro = ALMCentro::where('COD_CENTRO', '=', $centro_id)->first();

            $autoriza_id = '';
            $combo_autoriza = $this->gn_combo_usuarios();
            $arendir_sel_id = '';
            $combo_arendir_sel = array();

            $moneda_sel_id = '';
            $combo_moneda_sel = $this->gn_generacion_combo_categoria('MONEDA', "SELECCIONE MONEDA", '');


            return View::make('liquidaciongasto.agregarliquidaciongastos',
                [
                    'combo_empresa' => $combo_empresa,
                    'combo_arendir' => $combo_arendir,
                    'empresa_id' => $empresa_id,
                    'cuenta_id' => $cuenta_id,
                    'combo_cuenta' => $combo_cuenta,

                    'moneda_sel_id' => $moneda_sel_id,
                    'combo_moneda_sel' => $combo_moneda_sel,
                    'area_id' => $area_id,
                    'area_txt' => $area_txt,
                    'area_planilla' => $area_planilla,


                    'autoriza_id' => $autoriza_id,
                    'combo_autoriza' => $combo_autoriza,

                    'subcuenta_id' => $subcuenta_id,
                    'combo_subcuenta' => $combo_subcuenta,

                    'combo_arendir_sel' => $combo_arendir_sel,
                    'arendir_id' => $arendir_id,
                    'arendir_sel_id' => $arendir_sel_id,
                    'centro' => $centro,
                    'fecha_creacion' => $fecha_creacion,
                    'anio' => $anio,
                    'mes' => $mes,
                    'idopcion' => $idopcion
                ]);
        }
    }


    public function actionAjaxComboCuentaXMoneda(Request $request)
    {

        $empresa_id = $request['empresa_id'];
        $moneda_sel_id = $request['moneda_sel_id'];


        $cuenta_id = "";
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

        $terceros   =   DB::table('TERCEROS')
                        ->where('USER_ID', Session::get('usuario')->id)
                        ->where('ACTIVO', 1)
                        ->first();
        if (count($terceros) > 0) {
            $centro_id = $terceros->COD_CENTRO;
        }


        $cadena = $empresa_id;
        $partes = explode(" - ", $cadena);
        $nombre = '';
        if (count($partes) > 1) {
            $nombre = trim($partes[1]);
        }


        $combo_cuenta = $this->lg_combo_cuenta_moneda("Seleccione una Cuenta", "", "TCO0000000000069", $centro_id, $empresa_id, $moneda_sel_id);
        //$combo_cuenta           =   $this->lg_combo_cuenta_lg_moneda('Seleccione una Cuenta','','',$centro_id,$empresa_id,$moneda_sel_id);


        return View::make('general/ajax/combocuenta',
            [

                'cuenta_id' => $cuenta_id,
                'combo_cuenta' => $combo_cuenta,
                'ajax' => true,
            ]);
    }

    public function actionAjaxComboCuenta(Request $request)
    {

        $empresa_id = $request['empresa_id'];
        $cuenta_id = "";
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

        $terceros   =   DB::table('TERCEROS')
                        ->where('USER_ID', Session::get('usuario')->id)
                        ->where('ACTIVO', 1)
                        ->first();
        if (count($terceros) > 0) {
            $centro_id = $terceros->COD_CENTRO;
        }

        //dd($empresa_id);

        $cadena = $empresa_id;
        $partes = explode(" - ", $cadena);
        $nombre = '';
        $ruc = '';        
        if (count($partes) > 1) {
            $ruc = trim($partes[0]);
            $nombre = trim($partes[1]);
        }

        $empresa   =   DB::table('STD.EMPRESA ')
                        ->where('NRO_DOCUMENTO', $ruc)
                        ->where('COD_ESTADO', 1)
                        ->first();
        //DD($empresa->COD_EMPR);

        $combo_cuenta = $this->lg_combo_cuenta_lg_nuevo('Seleccione una Cuenta', '', '', $centro_id, $empresa->COD_EMPR);


        return View::make('general/ajax/combocuenta',
            [

                'cuenta_id' => $cuenta_id,
                'combo_cuenta' => $combo_cuenta,
                'ajax' => true,
            ]);
    }


    public function actionAjaxComboSubCuenta(Request $request)
    {

        $cuenta_id = $request['cuenta_id'];

        //dd($cuenta_id);

        $subcuenta_id = "";
        $combo_subcuenta = $this->lg_combo_subcuenta("Seleccione SubCuenta", $cuenta_id);

        return View::make('general/ajax/combosubcuenta',
            [
                'subcuenta_id' => $subcuenta_id,
                'combo_subcuenta' => $combo_subcuenta,
                'ajax' => true,
            ]);

    }

    public function actionAjaxModalComparativa(Request $request)
    {
        $id_documento = $request['id_documento'];
        $liquidaciongastos = LqgLiquidacionGasto::where('ID_DOCUMENTO', '=', $id_documento)->first();
        $indicador = 0;
        $listaarendirlg = $this->lg_lista_arendirlg($liquidaciongastos,$indicador);

        return View::make('liquidaciongasto/modal/ajax/mlistacomparativa',
            [
                'listaarendirlg' => $listaarendirlg,
                'liquidaciongastos' => $liquidaciongastos,
                'ajax' => true,
            ]);

    }



    public function actionAjaxComboArendir(Request $request)
    {

        $arendir_id = $request['arendir_id'];
        $moneda_sel_c_id = $request['moneda_sel_c_id'];
        $arendir_sel_id = '';
        if($arendir_id=='VALE'){
            $combo_arendir_sel = $this->gn_combo_arendir_restante_nuevo($moneda_sel_c_id);       
        }else{
        if($arendir_id=='IMPULSO'){
            $combo_arendir_sel = $this->gn_combo_arendir_restante_impulso();       
        }else{
                $combo_arendir_sel = $this->gn_combo_arendir_restante_reembolso();
            }     
        }

        return View::make('liquidaciongasto/ajax/comboarendir',
            [
                'arendir_sel_id' => $arendir_sel_id,
                'combo_arendir_sel' => $combo_arendir_sel,
                'ajax' => true,
            ]);

    }



    public function actionAjaxComboAutoriza(Request $request)
    {

        $arendir_sel_id = $request['arendir_sel_id'];
        $arendir_id = $request['arendir_id'];

        $vale = DB::table('WEB.VALE_RENDIR')
            ->where('ID', $arendir_sel_id)
            ->first();
        $usuario_id = '';
        if (count($vale) > 0) {
            $usuario = DB::table('users')
                ->where('usuarioosiris_id', $vale->USUARIO_AUTORIZA)
                ->first();
            $usuario_id = $usuario->id;

        }
        $autoriza_id = $usuario_id;
        $combo_autoriza = $this->gn_combo_usuarios_id($autoriza_id);

        if($arendir_id=='REEMBOLSO'){
            $combo_autoriza = $this->gn_combo_usuarios();
        }

        if($arendir_id=='IMPULSO'){
            $vale   =       DB::table('SEMANA_IMPULSO')
                            ->where('ID_DOCUMENTO', $arendir_sel_id)
                            ->first();
            $usuario_id = '';
            if (count($vale) > 0) {
                $usuario = DB::table('users')
                    ->where('id', $vale->USUARIO_MOD)
                    ->first();
                $usuario_id = $usuario->id;
            }

            //dd($usuario_id);
            $autoriza_id = $usuario_id;
            $combo_autoriza = $this->gn_combo_usuarios_id($autoriza_id);

        }


        return View::make('liquidaciongasto/ajax/comboautoriza',
            [
                'autoriza_id' => $autoriza_id,
                'combo_autoriza' => $combo_autoriza,
                'ajax' => true,
            ]);

    }


    public function actionAjaxComboItem(Request $request)
    {

        $flujo_id = $request['flujo_id'];
        $item_id = "";
        $combo_item = $this->lg_combo_item("Seleccione Item", $flujo_id);

        return View::make('general/ajax/comboitem',
            [
                'item_id' => $item_id,
                'combo_item' => $combo_item,
                'ajax' => true,
            ]);

    }


    public function actionListarLiquidacionGastos($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Lista Liquidación Gasto');
        $cod_empresa = Session::get('usuario')->usuarioosiris_id;
        $fecha_inicio = $this->fecha_menos_diez_dias;
        $fecha_fin = $this->fecha_sin_hora;
        $listacabecera = $this->lg_lista_liquidacion_gastos($fecha_inicio, $fecha_fin);

        //dd(Session::get('usuario')->id);

        $listadatos = array();
        $funcion = $this;
        return View::make('liquidaciongasto/listaliquidaciongasto',
            [
                'listadatos' => $listadatos,
                'funcion' => $funcion,
                'idopcion' => $idopcion,
                'listacabecera' => $listacabecera,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin
            ]);
    }


}
