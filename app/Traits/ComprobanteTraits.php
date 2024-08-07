<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\VMergeOC;
use App\Modelos\FeDocumento;
use App\Modelos\CMPCategoria;
use App\Modelos\CMPOrden;
use App\Modelos\STDTrabajador;
use App\Modelos\SGDUsuario;
use App\Modelos\VMergeActual;
use App\Modelos\Archivo;
use App\Modelos\VMergeDocumento;
use App\Modelos\VMergeDocumentoActual;
use App\Modelos\CMPDocAsociarCompra;



use App\Modelos\Estado;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\ViewDPagar;
use App\Modelos\FeDocumentoHistorial;
use App\Modelos\STDEmpresa;
use App\Modelos\CMPReferecenciaAsoc;
use App\Modelos\Whatsapp;
use App\User;


use ZipArchive;
use SplFileInfo;
use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;

trait ComprobanteTraits
{


    private function orden_ingreso_ejecutada() {

        $listafedocumentos      =   FeDocumento::where('COD_ESTADO','=','ETM0000000000009')->get();
        $COD_ORDEN_COMPRA = '';
        $pathFiles='\\\\10.1.50.2';
        foreach($listafedocumentos as $index=>$item){

            $orden                  =   CMPOrden::where('COD_ORDEN','=',$item->ID_DOCUMENTO)->first();
            $fechaactual            = date('Ymd H:i:s');
            $conexionbd         = 'sqlsrv';
            if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
                $conexionbd         = 'sqlsrv_r';
            }else{
                if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                    $conexionbd         = 'sqlsrv_b';
                }
            }
            $referenciaasoc = DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->Join('CMP.ORDEN', 'CMP.ORDEN.COD_ORDEN', '=', 'CMP.REFERENCIA_ASOC.COD_TABLA_ASOC')
                              ->where('CMP.REFERENCIA_ASOC.COD_TABLA','=',$item->ID_DOCUMENTO)
                              ->where('CMP.REFERENCIA_ASOC.COD_ESTADO','=','1')
                              ->where('CMP.REFERENCIA_ASOC.COD_TABLA_ASOC','like','%'.'OI'.'%')
                              ->where('CMP.ORDEN.COD_CATEGORIA_ESTADO_ORDEN','=','EOR0000000000003')
                              ->first();
            if(count($referenciaasoc)>0){

                //SI ES MATERIAL
                FeDocumento::where('ID_DOCUMENTO',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)
                            ->update(
                                [
                                    'COD_ESTADO'=>'ETM0000000000003',
                                    'TXT_ESTADO'=>'POR APROBAR CONTABILIDAD',
                                    'ind_email_ap'=>0,
                                    'fecha_uc'=>$fechaactual,
                                    'usuario_uc'=>$item->usuario_uc
                                ]
                            );

                $usuario        = User::where('id','=',$item->usuario_uc)->first();

                //HISTORIAL DE DOCUMENTO APROBADO
                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $item->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $item->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $fechaactual;
                $documento->USUARIO_ID                  =   $usuario->id;
                $documento->USUARIO_NOMBRE              =   $usuario->nombre;
                $documento->TIPO                        =   'APROBADO POR USUARIO CONTACTO';
                $documento->MENSAJE                     =   '';
                $documento->save();

                //whatsaap para contabilidad
                $fedocumento_w      =   FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)->first();
                $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$item->ID_DOCUMENTO)->first();            
                $empresa            =   STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR)->first();
                $mensaje            =   'COMPROBANTE : '.$fedocumento_w->ID_DOCUMENTO
                                        .'%0D%0A'.'EMPRESA : '.$empresa->NOM_EMPR.'%0D%0A'
                                        .'PROVEEDOR : '.$ordencompra->TXT_EMPR_CLIENTE.'%0D%0A'
                                        .'ESTADO : '.$fedocumento_w->TXT_ESTADO.'%0D%0A';

                if($_ENV['APP_PRODUCCION']==0){
                    $this->insertar_whatsaap_sp('51979820173','JORGE FRANCELLI',$mensaje,'');
                }else{
                    $this->insertar_whatsaap_sp('51979820173','JORGE FRANCELLI',$mensaje,'');
                    $this->insertar_whatsaap_sp('51979659002','HAMILTON',$mensaje,'');
                    $prefijocarperta =      $this->prefijo_empresa($ordencompra->COD_EMPR);
                    //CONTABILIDAD
                    if($prefijocarperta=='II'){
                        $this->insertar_whatsaap_sp('51965991360','ANGHIE',$mensaje,'');//INTERNACIONAL
                    }else{
                        $this->insertar_whatsaap_sp('51950638955','MIGUEL',$mensaje,'');//COMERCIAL
                    }
                } 

            }
            print_r("EJECUTO ORDEN DE INGRESO");
 
        }

    }

    public function insertar_whatsaap_sp($numero,$nombre,$mensaje,$rutaimagen){
            $cabecera                   =   new Whatsapp;
            $cabecera->numero_contacto  =   $numero;
            $cabecera->nombre_contacto  =   $nombre;
            $cabecera->mensaje          =   $mensaje;
            $cabecera->ruta_imagen      =   $rutaimagen;
            $cabecera->ind_envio        =   0;
            $cabecera->nombre_proyecto  =   'MERGE';
            $cabecera->fecha_crea       =   date('d-m-Y H:i:s');
            $cabecera->activo           =   1;
            $cabecera->save();
    }

    private function sunat_cdr() {

        $listafedocumentos      =   FeDocumento::where('COD_ESTADO','=','ETM0000000000007')->get();
        //dd($listafedocumentos);

        $COD_ORDEN_COMPRA = '';
        $pathFiles='\\\\10.1.50.2';

        foreach($listafedocumentos as $index=>$item){

                $COD_ORDEN_COMPRA       = '';
                $sw_opecion             =   0;
                $sw                     = 0;
                $codigocdr              = '';
                $respuestacdr              = '';


                $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc_actual($item->ID_DOCUMENTO);
                $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$item->ID_DOCUMENTO)->first();
                $prefijocarperta        =   $this->prefijo_empresa($item->ID_DOCUMENTO);
                $fechaemision           =   date_format(date_create($item->FEC_VENTA), 'd/m/Y');
                $nombre_doc             =   $item->SERIE.'-'.$item->NUMERO;


                $numerototal     = $item->NUMERO;
                $numerototalsc    = ltrim($numerototal, '0');
                $nombre_doc_sinceros = $item->SERIE.'-'.$numerototalsc;




                if($item->ID_TIPO_DOC == 'R1'){

                    //LECTURA DE CDR
                    $archivo                =   Archivo::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                                                ->where('TIPO_ARCHIVO','=','DCC0000000000004')
                                                ->first();

                    if(count($archivo)>0){


                        $rutafile        =      $pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ordencompra->NRO_DOCUMENTO_CLIENTE;
                        $nombrefile      =      $archivo->NOMBRE_ARCHIVO;
                        $valor           =      $this->versicarpetanoexiste($rutafile);
                        $rutacompleta    =      $rutafile.'\\'.$nombrefile;

                        $zipFilePath = $archivo->URL_ARCHIVO;
                        $extractPath = $rutafile;

                        $zip = new ZipArchive;
                        $fileNames = '';
                        if ($zip->open($zipFilePath) === TRUE) {
                            if ($zip->extractTo($extractPath)) {
                                for ($i = 0; $i < $zip->numFiles; $i++) {
                                    $fileNames = $zip->getNameIndex($i);
                                }
                            } else {
                                echo 'Hubo un error al descomprimir el archivo.';
                            }
                            $zip->close();
                        } else {
                            echo 'No se pudo abrir el archivo zip.';
                        }

                        $extractedFile = $extractPath.'\\'.$fileNames;
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
                        } 

                    }else{
                        $sw = 1;
                    }

                }else{
                        $sw = 1;
                }





                //LECTURA A SUNAT
                $token = '';
                $estadoCp = '';
                $swlectur = 0;
                if($prefijocarperta =='II'){
                    $token           =      $this->generartoken_ii();
                }else{
                    $token           =      $this->generartoken_is();
                }


                $rh              =   CMPDocAsociarCompra::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)
                                            ->where('COD_ESTADO','=',1)
                                            ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000013'])
                                            ->get();

                if(count($rh)<=0){
                    //FACTURA
                    $rvalidar = $this->validar_xml( $token,
                                                    $item->ID_CLIENTE,
                                                    $item->RUC_PROVEEDOR,
                                                    $item->ID_TIPO_DOC,
                                                    $item->SERIE,
                                                    $item->NUMERO,
                                                    $fechaemision,
                                                    $item->TOTAL_VENTA_ORIG);
                }else{
                    //RECIBO POR HONORARIO
                    $rvalidar = $this->validar_xml( $token,
                                                    $item->ID_CLIENTE,
                                                    $item->RUC_PROVEEDOR,
                                                    $item->ID_TIPO_DOC,
                                                    $item->SERIE,
                                                    $item->NUMERO,
                                                    $fechaemision,
                                                    $item->TOTAL_VENTA_ORIG+$item->MONTO_RETENCION);
                }


                $arvalidar = json_decode($rvalidar, true);
                if(isset($arvalidar['success'])){

                    if($arvalidar['success']){

                        $datares              = $arvalidar['data'];
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

                        FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                                    ->update(
                                            [
                                                'success'=>$arvalidar['success'],
                                                'message'=>$arvalidar['message'],
                                                'estadoCp'=>$tablaestacp->codigo,
                                                'nestadoCp'=>$tablaestacp->nombre,
                                                'estadoRuc'=>$estadoRuc,
                                                'nestadoRuc'=>$txtestadoRuc,
                                                'condDomiRuc'=>$estadoDomiRuc,
                                                'ncondDomiRuc'=>$txtestadoDomiRuc,
                                            ]);
                        $swlectur = 1;
                    }else{
                        FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)
                                    ->update(
                                            [
                                                'success'=>$arvalidar['success'],
                                                'message'=>$arvalidar['message']
                                            ]);
                    }
                }
                //PASAR PARA EL USUARIO DE CONTACTO REALIZE SU APLICACION
                //el cdr es el de la factura

                if($sw==1 and $swlectur==1){
                    FeDocumento::where('ID_DOCUMENTO','=',$item->ID_DOCUMENTO)->where('DOCUMENTO_ITEM','=',$item->DOCUMENTO_ITEM)
                                ->update(
                                    [
                                        'COD_ESTADO'=>'ETM0000000000002',
                                        'TXT_ESTADO'=>'POR APROBAR USUARIO CONTACTO',
                                        'CODIGO_CDR'=>$codigocdr,
                                        'RESPUESTA_CDR'=>$respuestacdr
                                    ]
                                );
                }
        }

        print_r('Exitoso '. $COD_ORDEN_COMPRA);

    }

	private function con_lista_cabecera_comprobante_provisionar($cliente_id) {

		$listadatos 	= 	VMergeOC::leftJoin('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
							->whereIn('COD_ESTADO', ['ETM0000000000005'])
                            //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
							->select(DB::raw('	COD_ORDEN,
												FEC_ORDEN,
												TXT_CATEGORIA_MONEDA,
												TXT_EMPR_CLIENTE,
												MAX(CAN_TOTAL) CAN_TOTAL,
												MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
												MAX(COD_ESTADO) AS COD_ESTADO,
												MAX(TXT_ESTADO) AS TXT_ESTADO
											'))
							->groupBy('COD_ORDEN')
							->groupBy('FEC_ORDEN')
							->groupBy('TXT_CATEGORIA_MONEDA')
							->groupBy('TXT_EMPR_CLIENTE')
							->get();

	 	return  $listadatos;
	}


	private function con_lista_cabecera_comprobante_total_uc($cliente_id) {

		//HACER UNA UNION DE TODAS LOS ID DE TRABAJADORES QUE TIENE ESTE USUARIO
		$trabajador 		 = 		STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
		$array_trabajadores  =		STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
									->pluck('COD_TRAB')
									->toArray();
	
		$listadatos 		= 		FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
									//->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
									->whereIn('FE_DOCUMENTO.COD_CONTACTO',$array_trabajadores)
                                    //->where('TXT_PROCEDENCIA','<>','SUE')
									->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
									->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
									->whereIn('FE_DOCUMENTO.COD_ESTADO',['ETM0000000000002','ETM0000000000007'])
									//->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000002')
									->get();

	 	return  $listadatos;
	}


	private function con_lista_cabecera_comprobante_total_cont($cliente_id) {

		$listadatos 	= 	FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
							//->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
							->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
							->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
							->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->orderBy('fecha_uc','asc')
							->get();

	 	return  $listadatos;
	}

    private function con_lista_cabecera_comprobante_total_cont_contrato($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','CONTRATO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000003')
                            ->get();

        return  $listadatos;
    }



    private function con_lista_cabecera_comprobante_total_tes($cliente_id) {

        $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            ->leftJoin('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                            ->select(DB::raw('FE_DOCUMENTO.*,CMP.Orden.* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->whereNull('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000005')
                            ->orderBy('fecha_uc','asc')
                            ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_tes_sp($cliente_id) {

        $listadatos     =   FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            ->Join('LISTA_DOCUMENTOS_PAGAR_PROGRAMACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'LISTA_DOCUMENTOS_PAGAR_PROGRAMACION.COD_ORDEN')
                            ->select(DB::raw('FE_DOCUMENTO.*,CMP.Orden.* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000005')
                            ->orderBy('fecha_uc','asc')
                            ->get();

        return  $listadatos;
    }



	private function con_lista_cabecera_comprobante_total_adm($cliente_id) {

		$listadatos 	= 	FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
							//->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
							->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','ORDEN_COMPRA')
							->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
							//->where('TXT_PROCEDENCIA','<>','SUE')
							->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->orderBy('fecha_pr','asc')
							->get();

	 	return  $listadatos;
	}

    private function con_lista_cabecera_comprobante_total_adm_contrato($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','CONTRATO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            //->where('TXT_PROCEDENCIA','<>','SUE')
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000004')
                            ->get();

        return  $listadatos;
    }


    private function con_lista_cabecera_comprobante_total_tes_contrato($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','CONTRATO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            //->where('TXT_PROCEDENCIA','<>','SUE')
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000005')
                            ->get();

        return  $listadatos;
    }


	private function con_lista_cabecera_comprobante_total_gestion($cliente_id,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id) {


		$listadatos 	= 	CMPOrden::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
                            //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
							->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
							//->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
							->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('OPERACION','=','ORDEN_COMPRA')
							->Proveedor($proveedor_id)
							->Estado($estado_id)
							->where('FE_DOCUMENTO.COD_ESTADO','<>','')
							->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->orderBy('fecha_uc','asc')
							->get();

	 	return  $listadatos;


	}

    private function con_lista_cabecera_comprobante_total_gestion_contrato($cliente_id,$fecha_inicio,$fecha_fin,$proveedor_id,$estado_id) {


        $listadatos     =   CMPDocumentoCtble::join('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                            ->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('OPERACION','=','CONTRATO')
                            ->Proveedor($proveedor_id)
                            ->Estado($estado_id)
                            ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->orderBy('fecha_pa', 'desc')
                            ->get();

        return  $listadatos;


    }




    private function con_lista_cabecera_comprobante_total_gestion_agrupado($cliente_id) {


        $listadatos     =   FeDocumento::where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                            ->where('OPERACION','=','ORDEN_COMPRA')
                            ->select(DB::raw('TXT_ESTADO,COUNT(TXT_ESTADO) AS CANT'))
                            ->groupBy('TXT_ESTADO')
                            ->get();

        return  $listadatos;


    }

    private function con_lista_cabecera_comprobante_total_gestion_agrupado_con($cliente_id) {


        $listadatos     =   FeDocumento::where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                            ->where('OPERACION','=','CONTRATO')
                            ->select(DB::raw('TXT_ESTADO,COUNT(TXT_ESTADO) AS CANT'))
                            ->groupBy('TXT_ESTADO')
                            ->get();

        return  $listadatos;


    }





    private function gn_combo_proveedor_fe_documento($todo) {

		$array 						= 	FeDocumento::join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
										->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
										->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                                        //->where('TXT_PROCEDENCIA','<>','SUE')
										->select(DB::raw('COD_EMPR_CLIENTE,TXT_EMPR_CLIENTE'))
										->groupBy('COD_EMPR_CLIENTE')
										->groupBy('TXT_EMPR_CLIENTE')
                                        ->pluck('TXT_EMPR_CLIENTE','COD_EMPR_CLIENTE')
                                        ->toArray();
                                        
        if($todo=='TODO'){
            $combo                  =   array($todo => $todo) + $array;
        }else{
            $combo                  =   $array;
        }
        return  $combo;                             
    }


    private function gn_combo_estado_fe_documento($todo) {

		$array 							= 	DB::table('CMP.CATEGORIA')
        									->where('COD_ESTADO','=',1)
        									->where('TXT_GRUPO','=','ESTADO_MERGE')
		        							->pluck('NOM_CATEGORIA','COD_CATEGORIA')
											->toArray();
		if($todo=='TODO'){
			$combo  				= 	array($todo => $todo) + $array;
		}else{
			$combo  				= 	$array;
		}
	 	return  $combo;	                   
    }



	private function con_lista_cabecera_comprobante_total_gestion_observados($cliente_id) {

		$listadatos 	= 	FeDocumento::Join('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
							->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
							->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
							->where('FE_DOCUMENTO.COD_ESTADO','<>','')
							->where('FE_DOCUMENTO.ind_observacion','=','1')
							->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
							->get();

	 	return  $listadatos;
	}

    private function con_lista_cabecera_comprobante_total_gestion_observados_contrato($cliente_id) {

        $listadatos     =   FeDocumento::Join('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            //->where('FE_DOCUMENTO.COD_CONTACTO','=',$cliente_id)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
                            ->where('FE_DOCUMENTO.ind_observacion','=','1')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->get();

        return  $listadatos;
    }

	private function con_lista_cabecera_comprobante_total_gestion_historial($cliente_id) {



		$listadatos 	= 	FeDocumento::leftJoin('CMP.Orden', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.Orden.COD_ORDEN')
							->where('FE_DOCUMENTO.RUC_PROVEEDOR','=',$cliente_id)
                            //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                            ->where('FE_DOCUMENTO.COD_ESTADO','<>','')
							->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
							->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
							->get();



	 	return  $listadatos;
	}



	private function con_validar_documento($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento){

		$ind_ruc 			=	0;
		$ind_rz 			=	0;
		$ind_moneda 		=	0;
		$ind_total 			=	0;
		$ind_cantidaditem 	=	0;
		$ind_formapago 		=	0;
		$ind_errototal 		=	1;
		//ruc
		if($ordencompra->NRO_DOCUMENTO_CLIENTE == $fedocumento->RUC_PROVEEDOR){
			$ind_ruc 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }

		if(ltrim(rtrim(strtoupper($ordencompra->TXT_EMPR_CLIENTE))) == ltrim(rtrim(strtoupper($fedocumento->RZ_PROVEEDOR)))){
			$ind_rz 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }


		//moneda
		$txtmoneda 			=	'';
		if($fedocumento->MONEDA == 'PEN'){
			$txtmoneda 			=	'SOLES';	
		}else{
			$txtmoneda 			=	'DOLARES';
		}
		if($ordencompra->TXT_CATEGORIA_MONEDA == $txtmoneda){
			$ind_moneda 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }
		//total
		if(number_format($ordencompra->CAN_TOTAL, 4, '.', '') == number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', '')){
			$ind_total 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }


        $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();

		if($ordencompra_t->IND_MATERIAL_SERVICIO == 'S'){
			$ind_cantidaditem 			=	1;	
		}else{
			//numero_items
			if(count($detalleordencompra) == count($detallefedocumento)){
				$ind_cantidaditem 			=	1;	
			}else{ 	$ind_errototal 		=	0;  }

		}

		$tp = CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
		//print($tp->CODIGO_SUNAT);
		//dd(substr(strtoupper(ltrim(rtrim($fedocumento->FORMA_PAGO))), 0, 3));

		if($tp->CODIGO_SUNAT == substr(strtoupper(ltrim(rtrim($fedocumento->FORMA_PAGO))), 0, 3)){
			$ind_formapago 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }




		// if($tp->CODIGO_SUNAT == substr(strtoupper($fedocumento->FORMA_PAGO), 0, 3)){

		// 	if( $tp->CODIGO_SUNAT == 'CRE' ){
		// 		$ind_formapago 			=	1;	
		// 		$diasdeorden = $tp->COD_CTBLE;
		// 		if($fedocumento->FORMA_PAGO_DIAS != $diasdeorden){
		// 			$ind_formapago 			=	0;
		// 			$ind_errototal 			=	0; 
		// 		}
		// 	}
		// }else{ 	$ind_errototal 		=	0;  }


        FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
                    ->update(
                            [
                                'ind_ruc'=>$ind_ruc,
                                'ind_rz'=>$ind_rz,
                                
                                'ind_moneda'=>$ind_moneda,
                                'ind_total'=>$ind_total,
                                'ind_cantidaditem'=>$ind_cantidaditem,
                                'ind_formapago'=>$ind_formapago,
                                'ind_errototal'=>$ind_errototal,
                            ]);

	}

	private function con_validar_documento_proveedor($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento){

		$ind_ruc 			=	0;
		$ind_rz 			=	0;
		$ind_moneda 		=	0;
		$ind_total 			=	0;
		$ind_cantidaditem 	=	0;
		$ind_formapago 		=	0;
		$ind_errototal 		=	1;
		//ruc
		if($ordencompra->NRO_DOCUMENTO_CLIENTE == $fedocumento->RUC_PROVEEDOR){
			$ind_ruc 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }

        $fe_rz =str_replace('  ', ' ', $fedocumento->RZ_PROVEEDOR);
		if(ltrim(rtrim(strtoupper($ordencompra->TXT_EMPR_CLIENTE))) == ltrim(rtrim(strtoupper($fe_rz)))){
			$ind_rz 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }

		//moneda
		$txtmoneda 			=	'';
		if($fedocumento->MONEDA == 'PEN'){
			$txtmoneda 			=	'SOLES';	
		}else{
			$txtmoneda 			=	'DOLARES';
		}
		if($ordencompra->TXT_CATEGORIA_MONEDA == $txtmoneda){
			$ind_moneda 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }
		//total
		if(number_format($ordencompra->CAN_TOTAL, 4, '.', '') == number_format($fedocumento->TOTAL_VENTA_ORIG+$fedocumento->PERCEPCION+$fedocumento->MONTO_RETENCION, 4, '.', '')){
			$ind_total 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }


        $ordencompra_t          =   CMPOrden::where('COD_ORDEN','=',$ordencompra->COD_ORDEN)->first();

		if($ordencompra_t->IND_MATERIAL_SERVICIO == 'S'){
			$ind_cantidaditem 			=	1;	
		}else{

            if($ordencompra_t->TXT_CONFORMIDAD != ''){
                $ind_cantidaditem           =   1;  
            }else{
                //numero_items
                if(count($detalleordencompra) == count($detallefedocumento)){
                    $ind_cantidaditem           =   1;  
                }else{  $ind_errototal      =   0;  }

            }

		}

		$tp = CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
		if($tp->CODIGO_SUNAT == substr(strtoupper(ltrim(rtrim($fedocumento->FORMA_PAGO))), 0, 3)){
			$ind_formapago 			=	1;	
		}else{ 	$ind_errototal 		=	0;  }



        FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_ORDEN)
                    ->update(
                            [
                                'ind_ruc'=>$ind_ruc,
                                'ind_rz'=>$ind_rz,
                                
                                'ind_moneda'=>$ind_moneda,
                                'ind_total'=>$ind_total,
                                'ind_cantidaditem'=>$ind_cantidaditem,
                                'ind_formapago'=>$ind_formapago,
                                'ind_errototal'=>$ind_errototal,
                            ]);

	}


    private function con_validar_documento_proveedor_contrato($ordencompra,$fedocumento,$detalleordencompra,$detallefedocumento){

        $ind_ruc            =   0;
        $ind_rz             =   0;
        $ind_moneda         =   0;
        $ind_total          =   0;
        $ind_cantidaditem   =   0;
        $ind_formapago      =   0;
        $ind_errototal      =   1;
        //ruc
        if($ordencompra->NRO_DOCUMENTO_CLIENTE == $fedocumento->RUC_PROVEEDOR){
            $ind_ruc            =   1;  
        }else{  $ind_errototal      =   0;  }

        if(ltrim(rtrim(strtoupper($ordencompra->TXT_EMPR_EMISOR))) == ltrim(rtrim(strtoupper($fedocumento->RZ_PROVEEDOR)))){
            $ind_rz             =   1;  
        }else{  $ind_errototal      =   0;  }


        //moneda
        $txtmoneda          =   '';
        if($fedocumento->MONEDA == 'PEN'){
            $txtmoneda          =   'SOLES';    
        }else{
            $txtmoneda          =   'DOLARES';
        }
        if($ordencompra->TXT_CATEGORIA_MONEDA == $txtmoneda){
            $ind_moneda             =   1;  
        }else{  $ind_errototal      =   0;  }
        //total
        if(number_format($ordencompra->CAN_TOTAL, 4, '.', '') == number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', '')){
            $ind_total          =   1;  
        }else{  $ind_errototal      =   0;  }

        $ordencompra_t          =   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$ordencompra->COD_DOCUMENTO_CTBLE)->first();


        if($ordencompra_t->IND_MATERIAL_SERVICIO == 'S'){
            $ind_cantidaditem           =   1;  
        }else{
            //numero_items
            if(count($detalleordencompra) == count($detallefedocumento)){
                $ind_cantidaditem           =   1;  
            }else{  $ind_errototal      =   0;  }

        }

        $tp = CMPCategoria::where('COD_CATEGORIA','=',$ordencompra->COD_CATEGORIA_TIPO_PAGO)->first();
        if($tp->CODIGO_SUNAT == substr(strtoupper(ltrim(rtrim($fedocumento->FORMA_PAGO))), 0, 3)){
            $ind_formapago          =   1;  
        }else{  $ind_errototal      =   0;  }



        FeDocumento::where('ID_DOCUMENTO','=',$ordencompra->COD_DOCUMENTO_CTBLE)
                    ->update(
                            [
                                'ind_ruc'=>$ind_ruc,
                                'ind_rz'=>$ind_rz,
                                
                                'ind_moneda'=>$ind_moneda,
                                'ind_total'=>$ind_total,
                                'ind_cantidaditem'=>$ind_cantidaditem,
                                'ind_formapago'=>$ind_formapago,
                                'ind_errototal'=>$ind_errototal,
                            ]);

    }


    private function array_rol_contrato() {
        $array = ['1CIX00000003'];
        return $array;
    }

	private function con_lista_cabecera_comprobante($cliente_id) {

		$estado_no      =   'ETM0000000000006';

		$listadatos 	= 	VMergeOC:://leftJoin('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
						    leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
								        $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
								            ->where('COD_ESTADO', '<>', 'ETM0000000000006');
								    })
							->where('COD_EMPR_CLIENTE','=',$cliente_id)
							->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
							//->where('VMERGEOC.COD_ORDEN','=','IICHCT0000002218')

							->where(function ($query) {
							    $query->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000001')
							    	  ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
							    	  ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
							})
                            //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
							->select(DB::raw('	COD_ORDEN,
												FEC_ORDEN,
												TXT_CATEGORIA_MONEDA,
												TXT_EMPR_CLIENTE,
												MAX(CAN_TOTAL) CAN_TOTAL,
												MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
												MAX(COD_ESTADO) AS COD_ESTADO,
												MAX(TXT_ESTADO) AS TXT_ESTADO
											'))
							->groupBy('COD_ORDEN')
							->groupBy('FEC_ORDEN')
							->groupBy('TXT_CATEGORIA_MONEDA')
							->groupBy('TXT_EMPR_CLIENTE')
							//->havingRaw("MAX(COD_ESTADO) <> 'ETM0000000000006'")
							->get();
        //dd($listadatos);
	 	return  $listadatos;
	}



	private function con_lista_cabecera_comprobante_administrativo($cliente_id) {

		$trabajador 		 = 		STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
		$array_trabajadores  =		STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
									->pluck('COD_TRAB')
									->toArray();

		$array_usuarios  	 =		SGDUsuario::whereIn('COD_TRABAJADOR',$array_trabajadores)
									->pluck('COD_USUARIO')
									->toArray();
		$estado_no      =   'ETM0000000000006';

        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos     =   VMergeOC::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                                ->where('COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                //->whereIn('VMERGEOC.COD_USUARIO_CREA_AUD',$array_usuarios)
                                ->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where(function ($query) {
                                    $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                          ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                          ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                })
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->select(DB::raw('  COD_ORDEN,
                                                    FEC_ORDEN,
                                                    TXT_CATEGORIA_MONEDA,
                                                    TXT_EMPR_CLIENTE,
                                                    COD_USUARIO_CREA_AUD,
                                                    MAX(CAN_TOTAL) CAN_TOTAL,
                                                    MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
                                                    MAX(COD_ESTADO) AS COD_ESTADO,
                                                    MAX(TXT_ESTADO) AS TXT_ESTADO
                                                '))
                                ->groupBy('COD_ORDEN')
                                ->groupBy('FEC_ORDEN')
                                ->groupBy('TXT_CATEGORIA_MONEDA')
                                ->groupBy('TXT_EMPR_CLIENTE')
                                ->groupBy('COD_USUARIO_CREA_AUD')
                                ->get();

        }else{

            $listadatos     =   VMergeOC::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                                ->where('COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                ->whereIn('VMERGEOC.COD_USUARIO_CREA_AUD',$array_usuarios)
                                ->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where(function ($query) {
                                    $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                          ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                          ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                })
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->select(DB::raw('  COD_ORDEN,
                                                    FEC_ORDEN,
                                                    TXT_CATEGORIA_MONEDA,
                                                    TXT_EMPR_CLIENTE,
                                                    COD_USUARIO_CREA_AUD,
                                                    MAX(CAN_TOTAL) CAN_TOTAL,
                                                    MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
                                                    MAX(COD_ESTADO) AS COD_ESTADO,
                                                    MAX(TXT_ESTADO) AS TXT_ESTADO
                                                '))
                                ->groupBy('COD_ORDEN')
                                ->groupBy('FEC_ORDEN')
                                ->groupBy('TXT_CATEGORIA_MONEDA')
                                ->groupBy('TXT_EMPR_CLIENTE')
                                ->groupBy('COD_USUARIO_CREA_AUD')
                                ->get();

        }


	 	return  $listadatos;
	}


    private function con_lista_cabecera_comprobante_administrativo_filtro($cliente_id) {

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $array_trabajadores  =      STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
                                    ->pluck('COD_TRAB')
                                    ->toArray();

        $array_usuarios      =      SGDUsuario::whereIn('COD_TRABAJADOR',$array_trabajadores)
                                    ->pluck('COD_USUARIO')
                                    ->toArray();
        $estado_no          =       'ETM0000000000006';


        $listadatos         =   VMergeOC::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                        $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                            ->where('COD_ESTADO', '<>', 'ETM0000000000006');
                                    })
                                //->whereIn('VMERGEOC.COD_USUARIO_CREA_AUD',$array_usuarios)
                                ->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where(function ($query) {
                                    $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                          ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                          ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                })
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->select(DB::raw('  COD_ORDEN,
                                                    FEC_ORDEN,
                                                    TXT_CATEGORIA_MONEDA,
                                                    TXT_EMPR_CLIENTE,
                                                    COD_USUARIO_CREA_AUD,
                                                    MAX(CAN_TOTAL) CAN_TOTAL,
                                                    MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
                                                    MAX(COD_ESTADO) AS COD_ESTADO,
                                                    MAX(TXT_ESTADO) AS TXT_ESTADO,
                                                    MAX(TXT_CONFORMIDAD) AS TXT_CONFORMIDAD
                                                '))
                                ->groupBy('COD_ORDEN')
                                ->groupBy('FEC_ORDEN')
                                ->groupBy('TXT_CATEGORIA_MONEDA')
                                ->groupBy('TXT_EMPR_CLIENTE')
                                ->groupBy('COD_USUARIO_CREA_AUD')
                                ->get();



        return  $listadatos;
    }


    private function con_lista_cabecera_contrato_administrativo($cliente_id) {

        $trabajador          =      STDTrabajador::where('COD_TRAB','=',$cliente_id)->first();
        $array_trabajadores  =      STDTrabajador::where('NRO_DOCUMENTO','=',$trabajador->NRO_DOCUMENTO)
                                    ->pluck('COD_TRAB')
                                    ->toArray();

        $array_usuarios      =      SGDUsuario::whereIn('COD_TRABAJADOR',$array_trabajadores)
                                    ->pluck('COD_USUARIO')
                                    ->toArray();
                                    
        $estado_no          =       'ETM0000000000006';
        $centro_id          =       'CEN0000000000001';
        $tipodoc_id         =       'TDO0000000000014';

        $listadatos         =       VMergeDocumento::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                        $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                            ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                    })
                                    //->whereIn('VMERGEDOCUMENTOS.COD_USUARIO_CREA_AUD',$array_usuarios)
                                    ->where('VMERGEDOCUMENTOS.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                    ->where(function ($query) {
                                        $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                              ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                              ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                    })
                                    ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                    ->where('COD_CENTRO','=',$centro_id)
                                    ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                    ->select(DB::raw('  COD_DOCUMENTO_CTBLE,
                                                        FEC_EMISION,
                                                        TXT_CATEGORIA_MONEDA,
                                                        TXT_EMPR_EMISOR,
                                                        COD_USUARIO_CREA_AUD,
                                                        CAN_TOTAL,
                                                        NRO_SERIE,
                                                        NRO_DOC,
                                                        
                                                        FE_DOCUMENTO.ID_DOCUMENTO,
                                                        FE_DOCUMENTO.COD_ESTADO,
                                                        FE_DOCUMENTO.TXT_ESTADO
                                                    '))
                                    ->get();

        return  $listadatos;
    }








    private function con_lista_cabecera_comprobante_administrativo_total() {

        $estado_no          =   'ETM0000000000006';
        $toarray            =   VMergeOC::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                            $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
                                                ->where('COD_ESTADO', '<>', 'ETM0000000000006');
                                        })
                                ->leftJoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'VMERGEOC.COD_USUARIO_CREA_AUD')
                                ->where('VMERGEOC.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                ->where(function ($query) {
                                    $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                          ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                          ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                })
                                //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
                                ->select(DB::raw('  COD_ORDEN,
                                                    SGD.USUARIO.NOM_TRABAJADOR
                                                '))
                                ->groupBy('COD_ORDEN')
                                ->groupBy('SGD.USUARIO.NOM_TRABAJADOR')
                                //->pluck('NOM_TRABAJADOR','COD_ORDEN')
                                ->get()->toArray();


        $groupbyarray       =   $this->groupBy($toarray, 'NOM_TRABAJADOR');


        $togroupbyarray       =   $this->sortGroupsBySize($groupbyarray);
        //dd($togroupbyarray);


        return  $groupbyarray;
    }



    private function con_lista_cabecera_comprobante_administrativo_total_contrato() {


        $estado_no          =       'ETM0000000000006';
        $centro_id          =       'CEN0000000000001';
        $tipodoc_id         =       'TDO0000000000014';

        $toarray         =          VMergeDocumento::leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
                                        $leftJoin->on('ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE')
                                            ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
                                    })
                                    ->leftJoin('SGD.USUARIO', 'SGD.USUARIO.COD_USUARIO', '=', 'VMERGEDOCUMENTOS.COD_USUARIO_CREA_AUD')
                                    ->where('VMERGEDOCUMENTOS.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                                    ->where(function ($query) {
                                        $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
                                              ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
                                              ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
                                    })
                                    ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                    ->where('COD_CENTRO','=',$centro_id)
                                    ->where('COD_CATEGORIA_TIPO_DOC','=',$tipodoc_id)
                                    ->select(DB::raw('  COD_DOCUMENTO_CTBLE,
                                                        SGD.USUARIO.NOM_TRABAJADOR
                                                    '))
                                    ->groupBy('COD_DOCUMENTO_CTBLE')
                                    ->groupBy('SGD.USUARIO.NOM_TRABAJADOR')
                                    ->get()->toArray();



        $groupbyarray       =   $this->groupBy($toarray, 'NOM_TRABAJADOR');


        $togroupbyarray       =   $this->sortGroupsBySize($groupbyarray);
        //dd($togroupbyarray);


        return  $groupbyarray;
    }





    // Función para agrupar un array por una clave
    function groupBy(array $array, $key) {
        return array_reduce($array, function($result, $item) use ($key) {
            $result[$item[$key]][] = $item;
            return $result;
        }, []);
    }

    function sortGroupsBySize(array &$groups) {

        uasort($groups, function($a, $b) {
            return count($b) - count($a);
        });

        return $groups;

        //dd($groups);

    }

	private function con_lista_cabecera_comprobante_total($cliente_id) {

		$listadatos 	= 	VMergeOC::leftJoin('FE_DOCUMENTO', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'VMERGEOC.COD_ORDEN')
							//->where('COD_ESTADO','=','ETM0000000000002')
							->whereIn('COD_ESTADO', ['ETM0000000000001', 'ETM0000000000002', 'ETM0000000000003', 'ETM0000000000004', 'ETM0000000000005', 'ETM0000000000006'])
                            //->where('FE_DOCUMENTO.TXT_PROCEDENCIA','<>','SUE')
							->select(DB::raw('	COD_ORDEN,
												FEC_ORDEN,
												TXT_CATEGORIA_MONEDA,
												TXT_EMPR_CLIENTE,
												MAX(CAN_TOTAL) CAN_TOTAL,
												MAX(ID_DOCUMENTO) AS ID_DOCUMENTO,
												MAX(COD_ESTADO) AS COD_ESTADO,
												MAX(TXT_ESTADO) AS TXT_ESTADO
											'))
							->groupBy('COD_ORDEN')
							->groupBy('FEC_ORDEN')
							->groupBy('TXT_CATEGORIA_MONEDA')
							->groupBy('TXT_EMPR_CLIENTE')
							->get();

	 	return  $listadatos;
	}


	private function con_lista_cabecera_comprobante_idoc_actual($idoc) {


		$oc 	= 	VMergeActual::where('COD_ORDEN','=',$idoc)
							->select(DB::raw('COD_ORDEN,COD_EMPR,NOM_EMPR,TXT_CATEGORIA_MONEDA,NRO_DOCUMENTO,FEC_ORDEN,
												TXT_CATEGORIA_MONEDA,TXT_EMPR_CLIENTE,NRO_DOCUMENTO_CLIENTE,MAX(CAN_TOTAL) CAN_TOTAL,COD_CATEGORIA_TIPO_PAGO
												,COD_USUARIO_CREA_AUD'))
							->groupBy('COD_ORDEN')
							->groupBy('FEC_ORDEN')
							->groupBy('TXT_CATEGORIA_MONEDA')
							->groupBy('TXT_EMPR_CLIENTE')
							->groupBy('NRO_DOCUMENTO_CLIENTE')
							->groupBy('NRO_DOCUMENTO')
							->groupBy('COD_EMPR')
							->groupBy('NOM_EMPR')
							->groupBy('TXT_CATEGORIA_MONEDA')
							->groupBy('COD_CATEGORIA_TIPO_PAGO')
							->groupBy('COD_USUARIO_CREA_AUD')
							->first();

	 	return  $oc;
	}


	private function con_lista_cabecera_comprobante_idoc($idoc) {

		$oc 	             = 	VMergeOC::where('COD_ORDEN','=',$idoc)
    							->select(DB::raw('COD_ORDEN,COD_EMPR,NOM_EMPR,TXT_CATEGORIA_MONEDA,NRO_DOCUMENTO,FEC_ORDEN,
    												TXT_CATEGORIA_MONEDA,TXT_EMPR_CLIENTE,NRO_DOCUMENTO_CLIENTE,MAX(CAN_TOTAL) CAN_TOTAL,COD_CATEGORIA_TIPO_PAGO
    												,COD_USUARIO_CREA_AUD'))
    							->groupBy('COD_ORDEN')
    							->groupBy('FEC_ORDEN')
    							->groupBy('TXT_CATEGORIA_MONEDA')
    							->groupBy('TXT_EMPR_CLIENTE')
    							->groupBy('NRO_DOCUMENTO_CLIENTE')
    							->groupBy('NRO_DOCUMENTO')
    							->groupBy('COD_EMPR')
    							->groupBy('NOM_EMPR')
    							->groupBy('TXT_CATEGORIA_MONEDA')
    							->groupBy('COD_CATEGORIA_TIPO_PAGO')
    							->groupBy('COD_USUARIO_CREA_AUD')
    							->first();

	 	return  $oc;
	}


    private function con_lista_cabecera_comprobante_contrato_idoc($idoc) {


        $contrato                =      VMergeDocumento::where('COD_ESTADO','=','1')
                                            ->where('COD_DOCUMENTO_CTBLE','=',$idoc)
                                            ->first();

        return  $contrato;
    }

    private function con_lista_cabecera_comprobante_contrato_idoc_actual($idoc) {


        $contrato                =      VMergeDocumentoActual::where('COD_ESTADO','=','1')
                                            ->where('COD_DOCUMENTO_CTBLE','=',$idoc)
                                            ->first();

        return  $contrato;
    }

    private function con_lista_detalle_contrato_comprobante_idoc($idoc) {

        $doc                    =   CMPDetalleProducto::where('COD_TABLA','=',$idoc)
                                    ->where('COD_ESTADO','=',1)
                                    ->where('IND_MATERIAL_SERVICIO','=','S')
                                    ->get();

        return  $doc;

    }




	private function con_lista_detalle_comprobante_idoc($idoc) {

		$doc 	= 	VMergeOC::where('COD_ORDEN','=',$idoc)
							->get();

	 	return  $doc;

	}

	private function con_lista_detalle_comprobante_idoc_actual($idoc) {

		$doc 	= 	VMergeActual::where('COD_ORDEN','=',$idoc)

							->get();

	 	return  $doc;

	}

	private function prefijo_empresa($idempresa) {
		if($idempresa == 'IACHEM0000010394'){
			$prefijo = 'II';
		}else{
			$prefijo = 'IS';
		}
	 	return  $prefijo;
	}

	private function versicarpetanoexiste($ruta) {
		$valor = false;
		if (!file_exists($ruta)) {
		    mkdir($ruta, 0777, true);
		    $valor=true;
		}
		return $valor;
	}


	private function generartoken_ii() {

		$cliente_id = 'fb4f07e7-7ef4-4345-b434-11f3b1fd9f02';
		$client_secret = '6BnfVO7Uc0bSAPU/FcfkIw==';
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-seguridad.sunat.gob.pe/v1/clientesextranet/'.$cliente_id.'/oauth2/token/',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_POST => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_AUTOREFERER => true,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=https%3A%2F%2Fapi.sunat.gob.pe%2Fv1%2Fcontribuyente%2Fcontribuyentes&client_id='.$cliente_id.'&client_secret='.$client_secret,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded',
		    'Cookie: BIGipServerpool-e-plataformaunica-https=!npyoItrPwoiiUEHNnEfW6R1uaTqJDv+jJpdnaYgKdF+RvWima7xHYkuTAfphnUd/q7rgRvf+p/i4jA==; TS019e7fc2=019edc9eb870d9467c32c316be86f95256352673bd84f6776735f1a4bd678d04918fc02cf3d561b81ca4461a95d35151850b9e2387'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$atoken = json_decode($response, true);
		$token = $this->existe_vacio($atoken,'access_token');

		return $token;

	}


	private function generartoken_is() {
		
		$cliente_id = '1649d1ba-1fc9-45b9-a506-ebe0cc16393f';
		$client_secret = 'WJgOtY9fz91iHv6NZuWeew==';
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-seguridad.sunat.gob.pe/v1/clientesextranet/'.$cliente_id.'/oauth2/token/',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_POST => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_AUTOREFERER => true,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=https%3A%2F%2Fapi.sunat.gob.pe%2Fv1%2Fcontribuyente%2Fcontribuyentes&client_id='.$cliente_id.'&client_secret='.$client_secret,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded',
		    'Cookie: BIGipServerpool-e-plataformaunica-https=!npyoItrPwoiiUEHNnEfW6R1uaTqJDv+jJpdnaYgKdF+RvWima7xHYkuTAfphnUd/q7rgRvf+p/i4jA==; TS019e7fc2=019edc9eb870d9467c32c316be86f95256352673bd84f6776735f1a4bd678d04918fc02cf3d561b81ca4461a95d35151850b9e2387'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$atoken = json_decode($response, true);
		$token = $this->existe_vacio($atoken,'access_token');
		return $token;

	}

	private function validar_xml($token,$ruc,$numRuc,$codComp,$numeroSerie,$numero,$fechaEmision,$monto) {

		$json 				= 	'{
								    "numRuc" : "'.$numRuc.'",
								    "codComp" : "'.$codComp.'",
								    "numeroSerie" : "'.$numeroSerie.'",
								    "numero" : "'.$numero.'",
								    "fechaEmision" : "'.$fechaEmision.'",
								    "monto" : "'.round($monto,4).'"
								}';

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes/'.$ruc.'/validarcomprobante',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_POST => true,

		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_AUTOREFERER => true,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>$json,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Bearer '.$token,
		    'Cookie: TS012c881c=019edc9eb8ff55ad0feefbb4565864996e15bb9e987323078781cb5b85100d034c66c76db2bb1bf9ccf4a82c15d22272160b5a62d6'
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		
		return $response;


	}



	public function existe_vacio($item,$nombre)
	{
		$valor = '';
		if(!isset($item[$nombre])){
			$valor  = 	'';
		}else{
			$valor  = 	rtrim(ltrim($item[$nombre]));
		}
		return $valor;

	}






}