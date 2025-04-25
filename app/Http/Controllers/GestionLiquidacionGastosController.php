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

use Hashids;
use SplFileInfo;
use Excel;



class GestionLiquidacionGastosController extends Controller
{
    use GeneralesTraits;
    use PlanillaTraits;
    use LiquidacionGastoTraits;
    use ComprobanteTraits;


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
        $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();
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
        return View::make('liquidaciongasto/detallelgvalidado', 
                        [
                            'liquidaciongastos'     =>  $liquidaciongastos,
                            'tdetliquidaciongastos' =>  $tdetliquidaciongastos,
                            'detdocumentolg'        =>  $detdocumentolg,
                            'documentohistorial'    =>  $documentohistorial,
                            'idopcion'              =>  $idopcion,
                            'idcab'                 =>  $idcab,
                            'iddocumento'           =>  $iddocumento,
                            'initialPreview'        => json_encode($initialPreview),
                            'initialPreviewConfig'  => json_encode($initialPreviewConfig),      
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
                $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();
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
                $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();
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
            $NUMERO                 =   (int)$factura->getcorrelativo()+1;
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
            foreach ($factura->getdetails() as $indexdet => $itemdet) {
                $producto = str_replace("<![CDATA[","",$itemdet->getdescripcion());
                $producto = str_replace("]]>","",$producto);
                $producto = preg_replace('/[^A-Za-z0-9\s]/', '', $producto);
                $linea = str_pad($indexdet + 1, 3, "0", STR_PAD_LEFT);
                $ind_igv = 'NO';
                if((float) $itemdet->getigv()>0){
                    $ind_igv = 'SI';
                }


                $DETALLES[] = [
                    'LINEID'             => $linea,
                    'CODPROD'            => $itemdet->getcodProducto(),
                    'PRODUCTO'           => $producto,
                    'UND_PROD'           => $itemdet->getunidad(),
                    'CANTIDAD'           => (float) $itemdet->getcantidad(),
                    'PRECIO_UNIT'        => (float) $itemdet->getmtoValorUnitario(),
                    'VAL_IGV_ORIG'       => $ind_igv,
                    'VAL_IGV_SOL'        => (float) $itemdet->getigv(),
                    'VAL_SUBTOTAL_ORIG'  => (float) $itemdet->getmtoValorVenta(),
                    'VAL_SUBTOTAL_SOL'   => (float) $itemdet->getmtoValorVenta(),
                    'VAL_VENTA_ORIG'     => (float) $itemdet->getigv() + (float) $itemdet->getmtoValorVenta(),
                    'VAL_VENTA_SOL'      => (float) $itemdet->getigv() + (float) $itemdet->getmtoValorVenta(),
                    'PRECIO_ORIG'        => (float) $itemdet->getmtoPrecioUnitario(),
                ];
            }


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




    public function actionModalSelectDocumentoPlanillaLG(Request $request) {

        $documento_planilla        =       $request['documento_planilla'];

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


        return response()->json([
            'EMPRESA'       => 'PLANILLA DE MOVILIDAD SIN COMPROBANTE',
            'SERIE'         => $planillamovilidad->SERIE,
            'NUMERO'        => $planillamovilidad->NUMERO,
            'COD_CUENTA'    => $COD_CUENTA,
            'TXT_CUENTA'    => $TXT_CUENTA,
            'COD_SUBCUENTA'    => $COD_SUBCUENTA,
            'TXT_SUBCUENTA'    => $TXT_SUBCUENTA,
            'COD_PLANILLA'     => $planillamovilidad->ID_DOCUMENTO,
            'FECHA_EMI'     => date_format(date_create($planillamovilidad->FECHA_EMI), 'd-m-Y'),
            'TOTAL'         => $planillamovilidad->TOTAL
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
                                    ->where('COD_EMPRESA', $detliquidaciongasto->COD_EMPRESA)
                                    ->whereNotIn('ID_DOCUMENTO', function($query) {
                                        $query->select(DB::raw('ISNULL(COD_PLA_MOVILIDAD, \'\')'))
                                              ->from('LQG_DETLIQUIDACIONGASTO');
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
                $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();


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
            $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
            $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
            $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();

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


            return View::make('liquidaciongasto/aprobaradministracionlg', 
                            [
                                'liquidaciongastos'     =>  $liquidaciongastos,
                                'tdetliquidaciongastos' =>  $tdetliquidaciongastos,
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
        $listadatos_obs     =   array();
        $listadatos_obs_le  =   array();

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
                $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();

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
                $documento->TIPO                        =   'APROBADO POR EL JEFE';
                $documento->MENSAJE                     =   '';
                $documento->save();

                DB::commit();
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gasto-jefe/'.$idopcion)->with('bienhecho', 'Planilla de Movilidad : '.$liquidaciongastos->CODIGO.' APROBADO CON EXITO');
            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('/gestion-de-aprobacion-liquidacion-gasto-jefe/'.$idopcion)->with('errorbd', $ex.' Ocurrio un error inesperado');
            }
        }
        else{

            $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
            $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
            $detdocumentolg         =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
            $documentohistorial     =   LqgDocumentoHistorial::where('ID_DOCUMENTO','=',$iddocumento)->get();
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


            return View::make('liquidaciongasto/aprobarjefelg', 
                            [
                                'liquidaciongastos'     =>  $liquidaciongastos,
                                'tdetliquidaciongastos' =>  $tdetliquidaciongastos,
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
        $listadatos_obs     =   array();
        $listadatos_obs_le  =   array();

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


    public function actionEmitirLiquidacionGasto($idopcion,$iddocumento,Request $request)
    {
        $idcab       = $iddocumento;
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');

        if($_POST)
        {

            try{    
                DB::beginTransaction();
                $liquidaciongastos      =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
                $tdetliquidaciongastos  =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();
                $usuario_id             =   $request['autoriza_id'];
                $usuario                =   User::where('id','=',$usuario_id)->first();

                if(count($tdetliquidaciongastos)<=0){
                    return Redirect::to('modificar-liquidacion-gastos/'.$idopcion.'/'.$idcab.'/0')->with('errorbd','Para poder emitir tiene que cargar sus documentos');
                }

                LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)
                            ->update(
                                    [
                                        'COD_USUARIO_AUTORIZA'=> $usuario->id,
                                        'TXT_USUARIO_AUTORIZA'=> $usuario->nombre,
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

                    //CUANDO ES PLANILLA DE MOVILIDAd
                    if(ltrim(rtrim($cod_planila))!=''){
                        $planillamovilidad              =   DB::table('PLA_MOVILIDAD')
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
                        $flujo_id                           =   $request['flujo_id'];
                        $gasto_id                           =   $request['gasto_id'];
                        $costo_id                           =   $request['costo_id'];
                        $cuenta_id                          =   $COD_CUENTA;
                        $subcuenta_id                       =   $COD_SUBCUENTA;
                        $item_id                            =   $request['item_id'];
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
                            $flujo_id                           =   $request['flujo_id'];
                            $gasto_id                           =   $request['gasto_id'];
                            $costo_id                           =   $request['costo_id'];
                            $cuenta_id                          =   $request['cuenta_id'];
                            $subcuenta_id                       =   $request['subcuenta_id'];
                            $item_id                            =   $request['item_id'];
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
                            $flujo_id                           =   $request['flujo_id'];
                            $gasto_id                           =   $request['gasto_id'];
                            $costo_id                           =   $request['costo_id'];
                            $cuenta_id                          =   $request['cuenta_id'];
                            $subcuenta_id                       =   $request['subcuenta_id'];
                            $item_id                            =   $request['item_id'];
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

                        if($seriepl=='E'){
                            $tarchivos                      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                                ->whereIn('COD_CATEGORIA', ['DCC0000000000036'])->get();

                        }else{

                            $tarchivos                      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                                                ->whereIn('COD_CATEGORIA', ['DCC0000000000036','DCC0000000000004'])->get();

                        }
                        $extractedFile = '';
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
                                    if($factura_cdr_id == $nombre_doc || $factura_cdr_id == $nombre_doc_sinceros){
                                        $sw = 1;
                                    }
                                }

                            }

                            //DD($codigocdr);
                        } else {
                            $respuestacdr  = 'Error al intentar descomprimir el CDR';
                        }
                        if($sw == 0){
                            $respuestacdr  = 'El CDR ('.$factura_cdr_id.') no coincide con la factura ('.$nombre_doc.')';
                        }
                        if (strpos($respuestacdr, 'observaciones') !== false) {
                            $respuestacdr  = 'El CDR ('.$factura_cdr_id.') tiene observaciones';
                        }

                        LqgDetLiquidacionGasto::where('ID_DOCUMENTO',$iddocumento)->where('ITEM',$item)
                                    ->update(
                                        [
                                            'CODIGO_CDR'=>$codigocdr,
                                            'RESPUESTA_CDR'=>$respuestacdr
                                        ]
                                    );

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



    public function actionModificarLiquidacionGastos($idopcion,$iddocumento,$valor,Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion,'Modificar');
        if($validarurl <> 'true'){return $validarurl;}
        /******************************************************/
        $iddocumento = $this->funciones->decodificarmaestrapre($iddocumento,'LIQG');
        View::share('titulo','Agregar Detalle Liquidacion de Gastos');
        $liquidaciongastos          =   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $tdetliquidaciongastos      =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();


        if($liquidaciongastos->COD_ESTADO!='ETM0000000000001'){
            return Redirect::to('gestion-de-liquidacion-gastos/'.$idopcion)->with('errorbd', 'Ya no puede modificar esta LIQUIDACION DE GASTOS');
        }
        $fecha_emision                  =   $this->hoy_sh;
        $ajax                           =   false;
        $valor_nuevo                    =   '';
        if($valor=='-1'){
            $valor_nuevo                =   $valor;
            $valor                      =   '0'; 
        }

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
            $costo_id                   =   "";
            $combo_costo                =   $this->lg_combo_costo("Seleccione Costo");
            $tdetliquidacionitem        =   array();
            $tdetdocliquidacionitem     =   array();
            $archivos     =   array();

            if($valor_nuevo=='-1'){
                $active                     =   "registro";   
            }


        }else{


            $active                     =   "registro";
            $tdetliquidacionitem        =   LqgDetLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$valor)->first();
            $tdetdocliquidacionitem     =   LqgDetDocumentoLiquidacionGasto::where('ID_DOCUMENTO','=',$iddocumento)->where('ITEM','=',$valor)->get();



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
            $costo_id                   =   $tdetliquidacionitem->COD_COSTO;
            $combo_costo                =   $this->lg_combo_costo("Seleccione Costo");
            $ajax                       =   true;
            $archivos                   =   Archivo::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->where('DOCUMENTO_ITEM','=',$valor)->get();

        }

        $tarchivos                      =   CMPCategoria::where('TXT_GRUPO','=','DOCUMENTOS_COMPRA')
                                            ->whereIn('COD_CATEGORIA', ['DCC0000000000036','DCC0000000000004'])->get();

        $autoriza_id                    =   '';
        $combo_autoriza                 =   $this->gn_combo_usuarios();
        $array_detalle_producto         =   array();


        return View::make('liquidaciongasto.modificarliquidaciongastos',
                         [
                            'liquidaciongastos'     => $liquidaciongastos,
                            'tdetliquidaciongastos' => $tdetliquidaciongastos,
                            'tdetliquidacionitem'   => $tdetliquidacionitem,
                            'tdetdocliquidacionitem'=> $tdetdocliquidacionitem,
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

                    $codigo                             =   $this->funciones->generar_codigo('LQG_LIQUIDACION_GASTO',8);
                    $idcab                              =   $this->funciones->getCreateIdMaestradocpla('LQG_LIQUIDACION_GASTO','LIQG');
                    $empresa_trab                       =   STDEmpresa::where('COD_EMPR','=',$empresa_id)->first();
                    $cuenta                             =   CMPContrato::where('COD_CONTRATO','=',$cuenta_id)->first();
                    $subcuenta                          =   CMPContratoCultivo::where('COD_CONTRATO','=',$subcuenta_id)->first();
                    $centro                             =   ALMCentro::where('NOM_CENTRO','=',$centro_txt)->first();



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




                    //dd($periodo);

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
                    $cabecera->COD_CENTRO               =   $centro->COD_CENTRO;
                    $cabecera->TXT_CENTRO               =   $centro->NOM_CENTRO;
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
                $cuenta_id      =   "";
                $combo_cuenta   =   $this->lg_combo_cuenta("Seleccione una Cuenta","","TCO0000000000069",$centro_id,$empresa_id);
                $cuenta         =   $this->lg_cuenta("Seleccione una Cuenta","","TCO0000000000069",$centro_id,$empresa_id);
                if(count($cuenta)>0){
                    $cod_contrato       =   $cuenta->COD_CONTRATO;
                }
                $combo_subcuenta    =   $this->lg_combo_subcuenta("Seleccione SubCuenta",$cod_contrato);
            }
            $fecha_creacion      =   $this->hoy;
            $combo_arendir       =   array('' => "SELECCIONE SI TIENE A RENDIR",'SI' => "SI",'NO' => "NO");
            $arendir_id          =   "";
            $centro              =   ALMCentro::where('COD_CENTRO','=',$centro_id)->first();
            //dd($centro);
            return View::make('liquidaciongasto.agregarliquidaciongastos',
                             [
                                'combo_empresa' => $combo_empresa,
                                'empresa_id'    => $empresa_id,
                                'cuenta_id'     => $cuenta_id,
                                'combo_cuenta'  => $combo_cuenta,
                                'subcuenta_id'  => $subcuenta_id,
                                'combo_subcuenta'=> $combo_subcuenta,
                                'combo_arendir'  => $combo_arendir,
                                'arendir_id'    => $arendir_id,
                                'centro'        => $centro,
                                'fecha_creacion'=> $fecha_creacion,
                                'anio'          => $anio,
                                'mes'           => $mes,
                                'idopcion'      => $idopcion
                             ]);
        }   
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
