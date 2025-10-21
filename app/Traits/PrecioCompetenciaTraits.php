<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\Requerimiento;
use App\Modelos\Conei;
use App\Modelos\Certificado;
use App\Modelos\SuperPrecio;
use App\Modelos\FeToken;
use App\Modelos\SunatDocumento;
use App\Modelos\Archivo;
use App\Modelos\STDEmpresa;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\CMPOrden;




use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use DOMDocument;
use DOMXPath;
use ZipArchive;

trait PrecioCompetenciaTraits
{

	private function prefijo_empresa_pre($idempresa) {
		if($idempresa == 'IACHEM0000010394'){
			$prefijo = 'II';
		}else{
			$prefijo = 'IS';
		}
	 	return  $prefijo;
	}
	private function versicarpetanoexiste_pre($ruta) {
		$valor = false;
		if (!file_exists($ruta)) {
		    mkdir($ruta, 0777, true);
		    $valor=true;
		}
		return $valor;
	}

	private function guadarpdfoi() {
			
			$pathFiles='\\\\10.1.50.2';

			$documentos = DB::table('FE_DOCUMENTO')
			    ->join('CMP.ORDEN', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.ORDEN.COD_ORDEN')
			    ->where('COD_CATEGORIA_TIPO_ORDEN', 'TOR0000000000021')
			    ->whereIn('FE_DOCUMENTO.COD_ESTADO', ['ETM0000000000008', 'ETM0000000000005'])
			    ->whereRaw('ISNULL(IND_OI, 0) = 0')
			    //->where('ID_DOCUMENTO','=','ISLMCE0000000199')
			    ->orderBy('FEC_ORDEN', 'asc')
			    ->select('FE_DOCUMENTO.*')
			    ->get();

			//dd($documentos);


      foreach($documentos as $index=>$item){

					$archivos = DB::table('ARCHIVOS')
								    ->where('TIPO_ARCHIVO', 'DCC0000000000042')
								    ->where('ACTIVO', 1)
								    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
								    ->first();

					if(count($archivos)<=0){

						$compras = DB::table('CMP.DOC_ASOCIAR_COMPRA')
											    ->where('COD_ORDEN', $item->ID_DOCUMENTO)
											    ->where('COD_CATEGORIA_DOCUMENTO', 'DCC0000000000042')
											    ->first();

						if(count($compras)<=0){

                $docasociar                              =   New CMPDocAsociarCompra;
                $docasociar->COD_ORDEN                   =   $item->ID_DOCUMENTO;
                $docasociar->COD_CATEGORIA_DOCUMENTO     =   'DCC0000000000042';
                $docasociar->NOM_CATEGORIA_DOCUMENTO     =   'ORDEN DE INGRESO';
                $docasociar->IND_OBLIGATORIO             =   1;
                $docasociar->TXT_FORMATO                 =   'PDF';
                $docasociar->TXT_ASIGNADO                =   'CONTACTO';
                $docasociar->COD_USUARIO_CREA_AUD        =   'JNECIOSM';
                $docasociar->FEC_USUARIO_CREA_AUD        =   date('Ymd H:i:s');
                $docasociar->COD_ESTADO                  =   1;
                $docasociar->TIP_DOC                     =   'N';
                $docasociar->save();
						}

						//COPIAR ARCHIVO DE ORDEN DE INGRESO A LA REAL
            $ordencompra        =   CMPOrden::where('COD_ORDEN','=',$item->ID_DOCUMENTO)->first();
						$oingreso 					= 	DB::table('CMP.REFERENCIA_ASOC')
																    ->where('COD_TABLA', $item->ID_DOCUMENTO)
																    ->where('COD_TABLA_ASOC', 'LIKE', '%OI%')
																    ->first();

						if(count($oingreso)>0){
	            if($ordencompra->COD_CENTRO == 'CEN0000000000004' or $ordencompra->COD_CENTRO == 'CEN0000000000006'or $ordencompra->COD_CENTRO == 'CEN0000000000002'){
	                if($ordencompra->COD_CENTRO == 'CEN0000000000004'){
	                    $sourceFile = '\\\\10.1.7.200\\cpe\\Orden_Ingreso\\'.$oingreso->COD_TABLA_ASOC.'.pdf';
	                }
	                if($ordencompra->COD_CENTRO == 'CEN0000000000006'){
	                    $sourceFile = '\\\\10.1.9.43\\cpe\\Orden_Ingreso\\'.$oingreso->COD_TABLA_ASOC.'.pdf';
	                }
	                if($ordencompra->COD_CENTRO == 'CEN0000000000002'){
	                    $sourceFile = '\\\\10.1.4.201\\cpe\\Orden_Ingreso\\'.$oingreso->COD_TABLA_ASOC.'.pdf';
	                }
	                $destinationFile = '\\\\10.1.0.201\\cpe\\Orden_Ingreso\\'.$oingreso->COD_TABLA_ASOC.'.pdf';
	                if (file_exists($sourceFile)){
	                    copy($sourceFile, $destinationFile);
	                }
	            }
						}

	          $destinationFile = '\\\\10.1.0.201\\cpe\\Orden_Ingreso\\'.$oingreso->COD_TABLA_ASOC.'.pdf';

            if (file_exists($destinationFile)){

                $aoc                            =       CMPDocAsociarCompra::where('COD_ORDEN','=',$item->ID_DOCUMENTO)->where('COD_ESTADO','=',1)
                                                        ->whereIn('COD_CATEGORIA_DOCUMENTO', ['DCC0000000000042'])
                                                        ->first();

                $contadorArchivos 							= 		  Archivo::count();
                $nombrefilecdr                  =       $oingreso->COD_TABLA_ASOC.'.pdf';
                $prefijocarperta                =       $this->prefijo_empresa_pre($ordencompra->COD_EMPR);
                $rutafile                       =       $this->pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$item->RUC_PROVEEDOR;
                $rutacompleta                   =       $rutafile.'\\'.$nombrefilecdr;
                $valor                          =       $this->versicarpetanoexiste_pre($rutafile);
                $path                           =       $rutacompleta;
                copy($destinationFile, $rutacompleta);
                $dcontrol                       =       new Archivo;
                $dcontrol->ID_DOCUMENTO         =       $item->ID_DOCUMENTO;
                $dcontrol->DOCUMENTO_ITEM       =       $item->DOCUMENTO_ITEM;
                $dcontrol->TIPO_ARCHIVO         =       'DCC0000000000042';
                $dcontrol->NOMBRE_ARCHIVO       =       $nombrefilecdr;
                $dcontrol->DESCRIPCION_ARCHIVO  =       'ORDEN DE INGRESO';
                $dcontrol->URL_ARCHIVO          =       $path;
                $dcontrol->SIZE                 =       100;
                $dcontrol->EXTENSION            =       '.pdf';
                $dcontrol->ACTIVO               =       1;
                $dcontrol->FECHA_CREA           =       date('Ymd H:i:s');
                $dcontrol->USUARIO_CREA         =       'JNECIOSM';
                $dcontrol->save();

								DB::table('FE_DOCUMENTO')
						    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
						    ->update([
						        'IND_OI'     => '1'
						    ]);

            }else{
            	print_r("archivo no encontrado");
            }

					}else{
						DB::table('FE_DOCUMENTO')
				    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
				    ->update([
				        'IND_OI'     => '1'
				    ]);

					}
      }



	}	




	private function buscar_archivo_sunat_lg_nuevo_lg($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO,$documento,$IND) {

		$array_nombre_archivo = array();
		$curl = curl_init();
		// curl_setopt_array($curl, array(
		//   CURLOPT_URL => $urlxml,
		//   CURLOPT_RETURNTRANSFER => true,
		//   CURLOPT_ENCODING => '',
		//   CURLOPT_MAXREDIRS => 10,

		// 	CURLOPT_TIMEOUT => 15, // 👈 máximo 10 segundos para la respuesta
		// 	CURLOPT_CONNECTTIMEOUT => 10, // 👈 máximo 5 segundos para conectar

		//   CURLOPT_FOLLOWLOCATION => true,
		//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		//   CURLOPT_CUSTOMREQUEST => 'GET',
		//   CURLOPT_HTTPHEADER => array(
		//     'Authorization: Bearer '.$fetoken->TOKEN
		//   ),
		// ));

    curl_setopt_array($curl, array(
        CURLOPT_URL => $urlxml,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 15, // máximo 15 segundos para la respuesta
        CURLOPT_CONNECTTIMEOUT => 10, // máximo 10 segundos para conectar
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json, text/plain, */*',
            'Accept-Encoding: gzip, deflate, br, zstd',
            'Accept-Language: es-ES,es;q=0.9',
            'Origin: https://e-factura.sunat.gob.pe',
            'Referer: https://e-factura.sunat.gob.pe/',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) '
                . 'AppleWebKit/537.36 (KHTML, like Gecko) '
                . 'Chrome/141.0.0.0 Safari/537.36',
            'Authorization: Bearer '.$fetoken->TOKEN
        ),
    ));


		$response = curl_exec($curl);
		curl_close($curl);


		$response_array = json_decode($response, true);
		if (!isset($response_array['nomArchivo'])) {
			print_r("NO HAY");
		}else{
	        $fileName = $response_array['nomArchivo'];
	        $base64File = $response_array['valArchivo'];
	        $fileData = base64_decode($base64File);
            $rutafile        =      $pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ID_DOCUMENTO;
            $rutacompleta    =      $rutafile.'\\'.$fileName;
			file_put_contents($rutacompleta, $fileData);
			// Descomprimir el ZIP
			$zip = new ZipArchive;
			if ($zip->open($rutacompleta) === TRUE) {
			    if ($zip->numFiles > 0) {
			        // Obtener el primer archivo dentro del ZIP (puedes adaptarlo si hay más)
			        $archivoDescomprimido = $zip->getNameIndex(0); // nombre relativo dentro del zip
			        if($IND == 'IND_XML'){
			        	if(substr($archivoDescomprimido, 0, 1) == 'R'){
			        			$archivoDescomprimido = $zip->getNameIndex(1); // nombre relativo dentro del zip	
			        	}
			        }
			    }
			    $zip->extractTo($rutafile); // descomprime todo
			    $zip->close();
			    $rutacompleta    =      $rutafile.'\\'.$archivoDescomprimido;
			    print_r($IND);
			    if($IND == 'IND_XML'){


									DB::table('LQG_DETLIQUIDACIONGASTO')
							    ->where('ID_DOCUMENTO', $documento->ID_DOCUMENTO)
							    ->where('ITEM', $documento->ITEM)
							    ->update([
							        'IND_XML'     => '1',
							        'CONTADOR'    => DB::raw('ISNULL(CONTADOR,0) + 1'),
							    ]);

                  $dcontrol                       =   new Archivo;
                  $dcontrol->ID_DOCUMENTO         =   $documento->ID_DOCUMENTO;
                  $dcontrol->DOCUMENTO_ITEM       =   $documento->ITEM;
                  $dcontrol->TIPO_ARCHIVO         =   'DCC0000000000003';
                  $dcontrol->NOMBRE_ARCHIVO       =   $archivoDescomprimido;
                  $dcontrol->DESCRIPCION_ARCHIVO  =   'XML DEL COMPROBANTE DE COMPRA';
                  $dcontrol->URL_ARCHIVO          =   $rutacompleta;
                  $dcontrol->SIZE                 =   1000;
                  $dcontrol->EXTENSION            =   'pdf';
                  $dcontrol->ACTIVO               =   1;
                  $dcontrol->FECHA_CREA           =   date('Ymd H:i:s');
                  $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                  $dcontrol->save();

			    }

			    if($IND == 'IND_PDF'){

									DB::table('LQG_DETLIQUIDACIONGASTO')
							    ->where('ID_DOCUMENTO', $documento->ID_DOCUMENTO)
							    ->where('ITEM', $documento->ITEM)
							    ->update([
							        'IND_PDF'     => '1',
							        'CONTADOR'    => DB::raw('ISNULL(CONTADOR,0) + 1'),
							    ]);

                  $dcontrol                       =   new Archivo;
                  $dcontrol->ID_DOCUMENTO         =   $documento->ID_DOCUMENTO;
                  $dcontrol->DOCUMENTO_ITEM       =   $documento->ITEM;
                  $dcontrol->TIPO_ARCHIVO         =   'DCC0000000000036';
                  $dcontrol->NOMBRE_ARCHIVO       =   $archivoDescomprimido;
                  $dcontrol->DESCRIPCION_ARCHIVO  =   'COMPROBANTE ELECTRONICO SUNAT API';
                  $dcontrol->URL_ARCHIVO          =   $rutacompleta;
                  $dcontrol->SIZE                 =   1000;
                  $dcontrol->EXTENSION            =   'pdf';
                  $dcontrol->ACTIVO               =   1;
                  $dcontrol->FECHA_CREA           =   date('Ymd H:i:s');
                  $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                  $dcontrol->save();

			    }


			    if($IND == 'IND_CDR'){
									DB::table('LQG_DETLIQUIDACIONGASTO')
							    ->where('ID_DOCUMENTO', $documento->ID_DOCUMENTO)
							    ->where('ITEM', $documento->ITEM)
							    ->update([
							        'IND_CDR'     => '1',
							        'CONTADOR'    => DB::raw('ISNULL(CONTADOR,0) + 1'),
							    ]);

                  $dcontrol                       =   new Archivo;
                  $dcontrol->ID_DOCUMENTO         =   $documento->ID_DOCUMENTO;
                  $dcontrol->DOCUMENTO_ITEM       =   $documento->ITEM;
                  $dcontrol->TIPO_ARCHIVO         =   'DCC0000000000004';
                  $dcontrol->NOMBRE_ARCHIVO       =   $archivoDescomprimido;
                  $dcontrol->DESCRIPCION_ARCHIVO  =   'CDR';
                  $dcontrol->URL_ARCHIVO          =   $rutacompleta;
                  $dcontrol->SIZE                 =   1000;
                  $dcontrol->EXTENSION            =   'pdf';
                  $dcontrol->ACTIVO               =   1;
                  $dcontrol->FECHA_CREA           =   date('Ymd H:i:s');
                  $dcontrol->USUARIO_CREA         =   Session::get('usuario')->id;
                  $dcontrol->save();


			    }

					$array_nombre_archivo = [
						'cod_error' => 0,
						'nombre_archivo' => $response_array['nomArchivo'],
						'ruta_completa' => $rutacompleta,
						'nombre_archivo' => $archivoDescomprimido,
						'mensaje' => 'encontrado con exito'
					];
			} else {
				$array_nombre_archivo = [
					'cod_error' => 1,
					'nombre_archivo' => '',
					'mensaje' => 'Error al abrir el archivo ZIP'
				];
			}
		}

	 	return  $array_nombre_archivo;

	}

	private function documentolgautomaticonuevo() {
			
			$pathFiles='\\\\10.1.50.2';

			$listasunattareas 	= 		DB::table('LQG_DETLIQUIDACIONGASTO')
														    ->select([
														        'LQG_DETLIQUIDACIONGASTO.*'
														    ])
														    ->join('LQG_LIQUIDACION_GASTO', 'LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO', '=', 'LQG_LIQUIDACION_GASTO.ID_DOCUMENTO')
														    ->where('LQG_DETLIQUIDACIONGASTO.ACTIVO', 1)
														    ->where('LQG_DETLIQUIDACIONGASTO.COD_TIPODOCUMENTO', 'TDO0000000000001')
														    ->whereNotIn('LQG_LIQUIDACION_GASTO.COD_ESTADO', ['ETM0000000000006', 'ETM0000000000001'])
														    ->whereRaw('ISNULL(LQG_DETLIQUIDACIONGASTO.IND_TOTAL, 0) = 0')
														    ->orderBy('FECHA_EMI', 'asc')
														    ->get();

			//dd($listasunattareas);

      foreach($listasunattareas as $index=>$item){

						DB::table('LQG_DETLIQUIDACIONGASTO')
						    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
						    ->where('ITEM', $item->ITEM)
						    ->update([
						        'FECHA_MOD' => date('Ymd H:i:s'),  // Better date format
						        'BUSQUEDAD' => DB::raw('ISNULL(BUSQUEDAD,0) + 1')  // Correct way to increment
						    ]);
      	
          try{  

              set_time_limit(0);
              $numero              				=   ltrim($item->NUMERO, '0');
        			$proveedor             			=   STDEmpresa::where('COD_EMPR','=',$item->COD_EMPRESA_PROVEEDOR)->first();
              $ruc                        =   $proveedor->NRO_DOCUMENTO;
              $td                         =   '01';
              $serie                      =   $item->SERIE;
              $correlativo                =   $numero;
              $ID_DOCUMENTO               =   $item->ID_DOCUMENTO;
              $fetoken                    =   FeToken::where('COD_EMPR','=',$item->COD_EMPRESA)->where('TIPO','=','COMPROBANTE_PAGO')->first();

              //buscar xml
              $primeraLetra               =   substr($serie, 0, 1);
              $prefijocarperta            =   $this->prefijo_empresa_lg($item->COD_EMPRESA);
              $rutafile                   =   $pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ID_DOCUMENTO;
              $valor                      =   $this->versicarpetanoexiste_lg($rutafile);

              $ruta_xml                   =   "";
              $ruta_pdf                   =   "";
              $ruta_cdr                   =   "";
              $nombre_xml                 =   "";
              $nombre_pdf                 =   "";
              $nombre_cdr                 =   "";


              if($item->IND_XML==0){
                  $urlxml                 =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/02';
                  $respuetaxml            =   $this->buscar_archivo_sunat_lg_nuevo_lg($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO,$item,'IND_XML');
              }
              if($item->IND_PDF==0){
	              $urlxml                   =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/01';
	              $respuetapdf              =   $this->buscar_archivo_sunat_lg_nuevo_lg($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO,$item,'IND_PDF');
              }

              if($primeraLetra == 'F'){

              	  if($item->IND_CDR==0){
	                  $urlxml                     =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/03';
	                  $respuetacdr                =   $this->buscar_archivo_sunat_lg_nuevo_lg($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO,$item,'IND_CDR');
                  }

									DB::table('LQG_DETLIQUIDACIONGASTO')
									    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
									    ->where('ITEM', $item->ITEM)
									    ->where('CONTADOR','=', '3')
									    ->update([
									        'IND_TOTAL'     => '1'
									    ]);

              }else{

									DB::table('LQG_DETLIQUIDACIONGASTO')
									    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
									    ->where('ITEM', $item->ITEM)
									    ->where('CONTADOR','=', '2')
									    ->update([
									        'IND_TOTAL'     => '1'
									    ]);

              }

          }catch(\Exception $ex){
              //DB::rollback();
              //dd($ex);
          }


      }



	}	



	private function documentolgautomatico() {
			
			$pathFiles='\\\\10.1.50.2';

			$listasunattareas = DB::table('LQG_LIQUIDACION_GASTO')
			    ->select('SUNAT_DOCUMENTO.*')
			    ->distinct()
			    ->join('SUNAT_DOCUMENTO', 'SUNAT_DOCUMENTO.ID_DOCUMENTO', '=', 'LQG_LIQUIDACION_GASTO.ID_DOCUMENTO')
			    ->where('LQG_LIQUIDACION_GASTO.ID_DOCUMENTO', 'LIQG00000105')
			    ->where('LQG_LIQUIDACION_GASTO.ACTIVO', 1)
			    ->where('LQG_LIQUIDACION_GASTO.COD_ESTADO', 'ETM0000000000001')
			    ->where('SUNAT_DOCUMENTO.ACTIVO', 1)
			    ->where('SUNAT_DOCUMENTO.IND_TOTAL', 0)
			    ->get();

      //dd($listasunattareas);
      foreach($listasunattareas as $index=>$item){

					DB::table('SUNAT_DOCUMENTO')
					    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
					    ->where('RUC', $item->RUC)
					    ->where('TIPODOCUMENTO_ID', $item->TIPODOCUMENTO_ID)
					    ->where('SERIE', $item->SERIE)
					    ->where('NUMERO', $item->NUMERO)
					    ->update([
					        'FECHA_MOD'     => date('Ymd H:i:s')
					    ]);
      	
          try{  
              //DB::beginTransaction();
              set_time_limit(0);
              $numero              				=   ltrim($item->NUMERO, '0');
              $ruc                        =   $item->RUC;
              $td                         =   $item->TIPODOCUMENTO_ID;
              $serie                      =   $item->SERIE;
              $correlativo                =   $numero;
              $ID_DOCUMENTO               =   $item->ID_DOCUMENTO;
              $fetoken                    =   FeToken::where('COD_EMPR','=',$item->EMPRESA_ID)->where('TIPO','=','COMPROBANTE_PAGO')->first();

              //buscar xml
              $primeraLetra               =   substr($serie, 0, 1);
              $prefijocarperta            =   $this->prefijo_empresa_lg($item->EMPRESA_ID);
              $rutafile                   =   $pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ID_DOCUMENTO;
              $valor                      =   $this->versicarpetanoexiste_lg($rutafile);

              $ruta_xml                   =   "";
              $ruta_pdf                   =   "";
              $ruta_cdr                   =   "";
              $nombre_xml                 =   "";
              $nombre_pdf                 =   "";
              $nombre_cdr                 =   "";



              if($item->IND_XML==0){
                  $urlxml                 =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/02';
                  $respuetaxml            =   $this->buscar_archivo_sunat_lg_nuevo($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO,$item,'IND_XML');
              }
              if($item->IND_PDF==0){
	              $urlxml                   =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/01';
	              $respuetapdf              =   $this->buscar_archivo_sunat_lg_nuevo($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO,$item,'IND_PDF');
              }

              if($primeraLetra == 'F'){
              	  if($item->IND_CDR==0){
	                  $urlxml                     =   'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/03';
	                  $respuetacdr                =   $this->buscar_archivo_sunat_lg_nuevo($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO,$item,'IND_CDR');
                  }


									DB::table('SUNAT_DOCUMENTO')
									    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
									    ->where('RUC', $item->RUC)
									    ->where('TIPODOCUMENTO_ID', $item->TIPODOCUMENTO_ID)
									    ->where('SERIE', $item->SERIE)
									    ->where('NUMERO', $item->NUMERO)
									    ->where('CONTADOR','=', '3')
									    ->update([
									        'IND_TOTAL'     => '1'
									    ]);

									$documentos = DB::table('SUNAT_DOCUMENTO')
									    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
									    ->where('RUC', $item->RUC)
									    ->where('TIPODOCUMENTO_ID', $item->TIPODOCUMENTO_ID)
									    ->where('SERIE', $item->SERIE)
									    ->where('NUMERO', $item->NUMERO)
									    ->where('CONTADOR', 3)
									    ->get();

									if(count($documentos)>0){
										$usuario = DB::table('users')
										    ->select(DB::raw("ISNULL(celular_contacto, '') AS celular_contacto"))
										    ->where('id', $item->USUARIO_ID)
										    ->first();
										if(count($usuario)>0){
												if($usuario->celular_contacto <> ''){

													DB::connection('sqlsrv_isl')->table('whatsapp')->insert([
													    'NumeroContacto'   => '51'.$usuario->celular_contacto,
													    'NombreContacto'   => $item->USUARIO_NOMBRE,
													    'Mensaje'          => '¡Hola! Buen día %0D%0AEncontrammos tu documento que dejaste rastreando en busquedad de la APP.*%0D%0A* Datos del documento : '.$item->RUC.' // '.$item->SERIE.'-'.$item->NUMERO.'*%0D%0A*',
													    'IndArchivo'       => 0,
													    'RutaArchivo'      => '',
													    'SizeArchivo'      => 0,
													    'NombreProyecto'   => 'MERGE',
													    'IndProgramado'    => 0,
													    'IndManual'        => 0,
													    'IndEnvio'         => 0,
													    'FechaCreacion'    => DB::raw('GETDATE()'),
													    'Activo'           => 1,
													    'indgrupo'         => 0,
													]);
												}
										}
									}



              }else{
									DB::table('SUNAT_DOCUMENTO')
									    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
									    ->where('RUC', $item->RUC)
									    ->where('TIPODOCUMENTO_ID', $item->TIPODOCUMENTO_ID)
									    ->where('SERIE', $item->SERIE)
									    ->where('NUMERO', $item->NUMERO)
									    ->where('CONTADOR','=', '2')
									    ->update([
									        'IND_TOTAL'     => '1'
									    ]);

										$documentos = DB::table('SUNAT_DOCUMENTO')
										    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
										    ->where('RUC', $item->RUC)
										    ->where('TIPODOCUMENTO_ID', $item->TIPODOCUMENTO_ID)
										    ->where('SERIE', $item->SERIE)
										    ->where('NUMERO', $item->NUMERO)
										    ->where('CONTADOR', 2)
										    ->get();

										if(count($documentos)>0){
											$usuario = DB::table('users')
											    ->select(DB::raw("ISNULL(celular_contacto, '') AS celular_contacto"))
											    ->where('id', $item->USUARIO_ID)
											    ->first();
											if(count($usuario)>0){
													if($usuario->celular_contacto <> ''){

														DB::connection('sqlsrv_isl')->table('whatsapphub')->insert([
														    'NumeroContacto'   => $usuario->celular_contacto,
														    'NombreContacto'   => $item->USUARIO_NOMBRE,
														    'Mensaje'          => '¡Hola! Buen día %0D%0AEncontrammos tu documento que dejaste rastreando en busquedad de la APP.*%0D%0A* Datos del documento : '.$item->RUC.' // '.$item->SERIE.'-'.$item->NUMERO.'*%0D%0A*',
														    'IndArchivo'       => 0,
														    'RutaArchivo'      => '',
														    'SizeArchivo'      => 0,
														    'NombreProyecto'   => 'MERGE',
														    'IndProgramado'    => 0,
														    'IndManual'        => 0,
														    'IndEnvio'         => 0,
														    'FechaCreacion'    => DB::raw('GETDATE()'),
														    'Activo'           => 1,
														    'indgrupo'         => 0,
														]);
													}
											}
										}




              }


							DB::table('SUNAT_DOCUMENTO')
							    ->where('ID_DOCUMENTO', $item->ID_DOCUMENTO)
							    ->where('RUC', $item->RUC)
							    ->where('TIPODOCUMENTO_ID', $item->TIPODOCUMENTO_ID)
							    ->where('SERIE', $item->SERIE)
							    ->where('NUMERO', $item->NUMERO)
							    ->update([
							        'FECHA_MOD'     => date('Ymd H:i:s')
							    ]);


              //DB::commit();

          }catch(\Exception $ex){
              //DB::rollback();
              //dd($ex);
          }


      }



	}	


	private function buscar_archivo_sunat_lg_nuevo_pdf($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO) {

		$array_nombre_archivo = array();
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $urlxml,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,

			CURLOPT_TIMEOUT => 15, // 👈 máximo 10 segundos para la respuesta
			CURLOPT_CONNECTTIMEOUT => 10, // 👈 máximo 5 segundos para conectar

		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Bearer '.$fetoken->TOKEN
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);


		$response_array = json_decode($response, true);
		if (!isset($response_array['nomArchivo'])) {
				$array_nombre_archivo = [
					'cod_error' => 1,
					'nombre_archivo' => '',
					'mensaje' => 'Sunat esta fallando para encontrar el pdf'
				];
		}else{

	    $fileName = $response_array['nomArchivo'];
	    $base64File = $response_array['valArchivo'];
	    $fileData = base64_decode($base64File);
      $rutafile        =      $pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ID_DOCUMENTO;
      $rutacompleta    =      $rutafile.'\\'.$fileName;
			file_put_contents($rutacompleta, $fileData);
			// Descomprimir el ZIP
			$zip = new ZipArchive;
			if ($zip->open($rutacompleta) === TRUE) {
			    if ($zip->numFiles > 0) {
			        $archivoDescomprimido = $zip->getNameIndex(0); // nombre relativo dentro del zip
			    }
			    $zip->extractTo($rutafile); // descomprime todo
			    $zip->close();
			    $rutacompleta    =      $rutafile.'\\'.$archivoDescomprimido;
					$array_nombre_archivo = [
						'cod_error' => 0,
						'nombre_archivo' => $response_array['nomArchivo'],
						'ruta_completa' => $rutacompleta,
						'nombre_archivo' => $archivoDescomprimido,
						'mensaje' => 'encontrado con exito'
					];
			} else {
				$array_nombre_archivo = [
					'cod_error' => 1,
					'nombre_archivo' => '',
					'mensaje' => 'Error al abrir el archivo ZIP'
				];
			}
		}

	 	return  $array_nombre_archivo;

	}



	private function buscar_archivo_sunat_lg_nuevo($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO,$documento,$IND) {

		$array_nombre_archivo = array();
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $urlxml,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,

			CURLOPT_TIMEOUT => 15, // 👈 máximo 10 segundos para la respuesta
			CURLOPT_CONNECTTIMEOUT => 10, // 👈 máximo 5 segundos para conectar

		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Bearer '.$fetoken->TOKEN
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);


		$response_array = json_decode($response, true);
		if (!isset($response_array['nomArchivo'])) {
			print_r("NO HAY");
		}else{
	        $fileName = $response_array['nomArchivo'];
	        $base64File = $response_array['valArchivo'];
	        $fileData = base64_decode($base64File);
            $rutafile        =      $pathFiles.'\\comprobantes\\'.$prefijocarperta.'\\'.$ID_DOCUMENTO;
            $rutacompleta    =      $rutafile.'\\'.$fileName;
			file_put_contents($rutacompleta, $fileData);
			// Descomprimir el ZIP
			$zip = new ZipArchive;
			if ($zip->open($rutacompleta) === TRUE) {
			    if ($zip->numFiles > 0) {
			        // Obtener el primer archivo dentro del ZIP (puedes adaptarlo si hay más)
			        $archivoDescomprimido = $zip->getNameIndex(0); // nombre relativo dentro del zip
			        if($IND == 'IND_XML'){
			        	if(substr($archivoDescomprimido, 0, 1) == 'R'){
			        			$archivoDescomprimido = $zip->getNameIndex(1); // nombre relativo dentro del zip	
			        	}
			        }
			    }
			    $zip->extractTo($rutafile); // descomprime todo
			    $zip->close();
			    $rutacompleta    =      $rutafile.'\\'.$archivoDescomprimido;
			    print_r($IND);
			    if($IND == 'IND_XML'){
							DB::table('SUNAT_DOCUMENTO')
							    ->where('ID_DOCUMENTO', $documento->ID_DOCUMENTO)
							    ->where('RUC', $documento->RUC)
							    ->where('TIPODOCUMENTO_ID', $documento->TIPODOCUMENTO_ID)
							    ->where('SERIE', $documento->SERIE)
							    ->where('NUMERO', $documento->NUMERO)
							    ->update([
							        'IND_XML'     => '1',
							        'NOMBRE_XML'  => $archivoDescomprimido,
							        'RUTA_XML'    => $rutacompleta,
							        'CONTADOR'    => DB::raw('CONTADOR + 1'),
							    ]);
			    }

			    if($IND == 'IND_PDF'){
							DB::table('SUNAT_DOCUMENTO')
							    ->where('ID_DOCUMENTO', $documento->ID_DOCUMENTO)
							    ->where('RUC', $documento->RUC)
							    ->where('TIPODOCUMENTO_ID', $documento->TIPODOCUMENTO_ID)
							    ->where('SERIE', $documento->SERIE)
							    ->where('NUMERO', $documento->NUMERO)
							    ->update([
							        'IND_PDF'     => '1',
							        'NOMBRE_PDF'  => $archivoDescomprimido,
							        'RUTA_PDF'    => $rutacompleta,
							        'CONTADOR'    => DB::raw('CONTADOR + 1'),
							    ]);
			    }


			    if($IND == 'IND_CDR'){
							DB::table('SUNAT_DOCUMENTO')
							    ->where('ID_DOCUMENTO', $documento->ID_DOCUMENTO)
							    ->where('RUC', $documento->RUC)
							    ->where('TIPODOCUMENTO_ID', $documento->TIPODOCUMENTO_ID)
							    ->where('SERIE', $documento->SERIE)
							    ->where('NUMERO', $documento->NUMERO)
							    ->update([
							        'IND_CDR'     => '1',
							        'NOMBRE_CDR'  => $archivoDescomprimido,
							        'RUTA_CDR'    => $rutacompleta,
							        'CONTADOR'    => DB::raw('CONTADOR + 1'),
							    ]);
			    }

					$array_nombre_archivo = [
						'cod_error' => 0,
						'nombre_archivo' => $response_array['nomArchivo'],
						'ruta_completa' => $rutacompleta,
						'nombre_archivo' => $archivoDescomprimido,
						'mensaje' => 'encontrado con exito'
					];
			} else {
				$array_nombre_archivo = [
					'cod_error' => 1,
					'nombre_archivo' => '',
					'mensaje' => 'Error al abrir el archivo ZIP'
				];
			}
		}

	 	return  $array_nombre_archivo;

	}




	private function prefijo_empresa_lg($idempresa) {
		if($idempresa == 'IACHEM0000010394'){
			$prefijo = 'II';
		}else{
			$prefijo = 'IS';
		}
	 	return  $prefijo;
	}

	private function versicarpetanoexiste_lg($ruta) {
		$valor = false;
		if (!file_exists($ruta)) {
		    mkdir($ruta, 0777, true);
		    $valor=true;
		}
		return $valor;
	}



















	private function scrapear_wong($supermercado) {

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://www.wong.pe/abarrotes/arroz?__pickRuntime=appsEtag%2Cblocks%2CblocksTree%2Ccomponents%2CcontentMap%2Cextensions%2Cmessages%2Cpage%2Cpages%2Cquery%2CqueryData%2Croute%2CruntimeMeta%2Csettings',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: VtexWorkspace=master%3A-; janus_sid=63244439-8888-45f4-89ad-fba9a36e7b42'
		  ),
		));

		$response = curl_exec($curl);
		$array_data 	= json_decode($response,true);
		$array_data2 	= json_decode($array_data['queryData'][0]['data'],true);
		//primera pagina
		foreach ($array_data2['productSearch']['products'] as $product) {

			//dd($product);
			if (strpos($product['productName'], 'Carmencita') === false) {
				// Convertir el resultado en una cadena
				$marca = strtoupper($product['brand']);
				if($marca==''){
					$marca = 'GENERICO';
				}
				$precio = $product['priceRange']['sellingPrice']['highPrice'];
				// Dividir la cadena por espacios
				preg_match('/(\d+)\s*(kg|g)/i', $product['productName'], $matches);
				//preg_match('/(\d+)(\D+)/', $ump, $matches);
				// Obtener el valor numérico y el texto
				$peso = 0; // 5
				$unidad = ''; // kg
				if(isset($matches[1])){
					$peso = $matches[1]; // 5
				}
				if(isset($matches[2])){
					$unidad = $matches[2]; // kg
				}
	            $tabla                       	=   new SuperPrecio;
	            $tabla->MARCA         	 		=   $marca;
	            $tabla->SUPERMERCADO      		=   $supermercado;
	            $tabla->FECHA      	     		=   date('Ymd');
	            $tabla->FECHA_TIME        		=   date('Ymd h:i:s');
	            $tabla->NOMBRE_PRODUCTO   		=   $product['productName'];
	            $tabla->DESCRIPCION_PRODUCTO 	=   '';
	            $tabla->PRECIO            		=   (float)$precio;
	            $tabla->UNIDAD_MEDIDA     		=   $unidad;
	            $tabla->PESO        		 	=   (float)$peso;
	            $tabla->save();

        	}
		}

	}




	private function scrapear_tottus($supermercado) {

		// Ruta para almacenar cookies temporalmente
		$cookieFile = __DIR__ . '/cookies.txt';
		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_URL => 'https://tottus.falabella.com.pe/tottus-pe/category/CATG14739/Arroz',
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => '',
		    CURLOPT_MAXREDIRS => 10,
		    CURLOPT_TIMEOUT => 0,
		    CURLOPT_FOLLOWLOCATION => true,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => 'GET',
		    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
		    CURLOPT_COOKIEFILE => $cookieFile, // Archivo para leer cookies
		    CURLOPT_COOKIEJAR => $cookieFile, // Archivo para guardar cookies
		));
		$response = curl_exec($curl);
		curl_close($curl);
		preg_match('/<script id="__NEXT_DATA__" type="application\/json">(.*?)<\/script>/', $response, $string);
		$array_data 	= json_decode($string[1],true);
		// Cargar el HTML en DOMDocument
		//primera pagina
		foreach ($array_data['props']['pageProps']['results'] as $product) {



			if (strpos($product['displayName'], 'Pack') === false) {
				// Convertir el resultado en una cadena

				//dd($product);
				$marca = strtoupper($product['brand']);
				if($marca==''){
					$marca = 'GENERICO';
				}
				$precio = $product['prices'][0]['price'][0];
				// Dividir la cadena por espacios
				preg_match('/(\d+)\s*(kg|g|k)/i', $product['displayName'], $matches);
				//preg_match('/(\d+)(\D+)/', $ump, $matches);
				// Obtener el valor numérico y el texto
				$peso = 0; // 5
				$unidad = ''; // kg
				if(isset($matches[2])){
					$unidad = $matches[2]; // kg
					if($unidad =='k'){
						$unidad = 'kg';
					}

				}
				if(isset($matches[1])){
					$peso = $matches[1]; // 5
				}else{
					if (preg_match('/(\d+)(kg|g)/i', $product['url'], $matches)) {
					    $peso = (int)$matches[1]; // Extrae el número
					    $unidad = $matches[2];       // Extrae la unidad (kg o g)
					}
				}

        $tabla                       	=   new SuperPrecio;
        $tabla->MARCA         	 			=   $marca;
        $tabla->SUPERMERCADO      		=   $supermercado;
        $tabla->FECHA      	     			=   date('Ymd');
        $tabla->FECHA_TIME        		=   date('Ymd h:i:s');
        $tabla->NOMBRE_PRODUCTO   		=   $product['displayName'];
        $tabla->DESCRIPCION_PRODUCTO 	=   '';
        $tabla->PRECIO            		=   (float)$precio;
        $tabla->UNIDAD_MEDIDA     		=   $unidad;
        $tabla->PESO        		 			=   (float)$peso;
        $tabla->save();

      }
		}

	}

	private function scrapear_metro($supermercado) {

		$url = "https://www.metro.pe/_v/segment/graphql/v1?workspace=master&maxAge=short&appsEtag=remove&domain=store&locale=es-PE&__bindingId=893de73e-7d5d-4f4e-9c7a-a32f1b2d77cb&operationName=productSearchV3&variables=%7B%7D&extensions=%7B%22persistedQuery%22%3A%7B%22version%22%3A1%2C%22sha256Hash%22%3A%229177ba6f883473505dc99fcf2b679a6e270af6320a157f0798b92efeab98d5d3%22%2C%22sender%22%3A%22vtex.store-resources%400.x%22%2C%22provider%22%3A%22vtex.search-graphql%400.x%22%7D%2C%22variables%22%3A%22eyJoaWRlVW5hdmFpbGFibGVJdGVtcyI6dHJ1ZSwic2t1c0ZpbHRlciI6IkFMTCIsInNpbXVsYXRpb25CZWhhdmlvciI6ImRlZmF1bHQiLCJpbnN0YWxsbWVudENyaXRlcmlhIjoiTUFYX1dJVEhPVVRfSU5URVJFU1QiLCJwcm9kdWN0T3JpZ2luVnRleCI6ZmFsc2UsIm1hcCI6ImMsYyIsInF1ZXJ5IjoiYWJhcnJvdGVzL2Fycm96Iiwib3JkZXJCeSI6Ik9yZGVyQnlTY29yZURFU0MiLCJmcm9tIjowLCJ0byI6NTksInNlbGVjdGVkRmFjZXRzIjpbeyJrZXkiOiJjIiwidmFsdWUiOiJhYmFycm90ZXMifSx7ImtleSI6ImMiLCJ2YWx1ZSI6ImFycm96In1dLCJvcGVyYXRvciI6ImFuZCIsImZ1enp5IjoiMCIsInNlYXJjaFN0YXRlIjpudWxsLCJmYWNldHNCZWhhdmlvciI6IlN0YXRpYyIsImNhdGVnb3J5VHJlZUJlaGF2aW9yIjoiZGVmYXVsdCIsIndpdGhGYWNldHMiOmZhbHNlLCJhZHZlcnRpc2VtZW50T3B0aW9ucyI6eyJzaG93U3BvbnNvcmVkIjp0cnVlLCJzcG9uc29yZWRDb3VudCI6MywiYWR2ZXJ0aXNlbWVudFBsYWNlbWVudCI6InRvcF9zZWFyY2giLCJyZXBlYXRTcG9uc29yZWRQcm9kdWN0cyI6dHJ1ZX19%22%7D";
		// Inicializar cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// Ejecutar la solicitud
		$html = curl_exec($ch);
		curl_close($ch);
		// Cargar el HTML en DOMDocument
		$array_data 	= json_decode($html,true);
		//primera pagina
		foreach ($array_data['data']['productSearch']['products'] as $product) {
			if (strpos($product['productName'], 'Pack') === false) {
				// Convertir el resultado en una cadena
				$marca = strtoupper($product['brand']);
				if($marca==''){
					$marca = 'GENERICO';
				}
				$precio = $product['priceRange']['sellingPrice']['highPrice'];
				// Dividir la cadena por espacios
				preg_match('/(\d+)\s*(kg|g)/i', $product['productName'], $matches);
				//preg_match('/(\d+)(\D+)/', $ump, $matches);
				// Obtener el valor numérico y el texto
				$peso = 0; // 5
				$unidad = ''; // kg
				if(isset($matches[1])){
					$peso = $matches[1]; // 5
				}
				if(isset($matches[2])){
					$unidad = $matches[2]; // kg
				}
	            $tabla                       	=   new SuperPrecio;
	            $tabla->MARCA         	 		=   $marca;
	            $tabla->SUPERMERCADO      		=   $supermercado;
	            $tabla->FECHA      	     		=   date('Ymd');
	            $tabla->FECHA_TIME        		=   date('Ymd h:i:s');
	            $tabla->NOMBRE_PRODUCTO   		=   $product['productName'];
	            $tabla->DESCRIPCION_PRODUCTO 	=   '';
	            $tabla->PRECIO            		=   (float)$precio;
	            $tabla->UNIDAD_MEDIDA     		=   $unidad;
	            $tabla->PESO        		 	=   (float)$peso;
	            $tabla->save();

        	}
		}
		//segunda pagina
		$url = "https://www.metro.pe/_v/segment/graphql/v1?workspace=master&maxAge=short&appsEtag=remove&domain=store&locale=es-PE&__bindingId=893de73e-7d5d-4f4e-9c7a-a32f1b2d77cb&operationName=productSearchV3&variables=%7B%7D&extensions=%7B%22persistedQuery%22%3A%7B%22version%22%3A1%2C%22sha256Hash%22%3A%229177ba6f883473505dc99fcf2b679a6e270af6320a157f0798b92efeab98d5d3%22%2C%22sender%22%3A%22vtex.store-resources%400.x%22%2C%22provider%22%3A%22vtex.search-graphql%400.x%22%7D%2C%22variables%22%3A%22eyJoaWRlVW5hdmFpbGFibGVJdGVtcyI6dHJ1ZSwic2t1c0ZpbHRlciI6IkFMTCIsInNpbXVsYXRpb25CZWhhdmlvciI6ImRlZmF1bHQiLCJpbnN0YWxsbWVudENyaXRlcmlhIjoiTUFYX1dJVEhPVVRfSU5URVJFU1QiLCJwcm9kdWN0T3JpZ2luVnRleCI6ZmFsc2UsIm1hcCI6ImMsYyIsInF1ZXJ5IjoiYWJhcnJvdGVzL2Fycm96Iiwib3JkZXJCeSI6Ik9yZGVyQnlTY29yZURFU0MiLCJmcm9tIjo2MCwidG8iOjExOSwic2VsZWN0ZWRGYWNldHMiOlt7ImtleSI6ImMiLCJ2YWx1ZSI6ImFiYXJyb3RlcyJ9LHsia2V5IjoiYyIsInZhbHVlIjoiYXJyb3oifV0sIm9wZXJhdG9yIjoiYW5kIiwiZnV6enkiOiIwIiwic2VhcmNoU3RhdGUiOm51bGwsImZhY2V0c0JlaGF2aW9yIjoiU3RhdGljIiwiY2F0ZWdvcnlUcmVlQmVoYXZpb3IiOiJkZWZhdWx0Iiwid2l0aEZhY2V0cyI6ZmFsc2UsImFkdmVydGlzZW1lbnRPcHRpb25zIjp7InNob3dTcG9uc29yZWQiOnRydWUsInNwb25zb3JlZENvdW50IjozLCJhZHZlcnRpc2VtZW50UGxhY2VtZW50IjoidG9wX3NlYXJjaCIsInJlcGVhdFNwb25zb3JlZFByb2R1Y3RzIjp0cnVlfX0%3D%22%7D";
				// Inicializar cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// Ejecutar la solicitud
		$html = curl_exec($ch);
		curl_close($ch);
		// Cargar el HTML en DOMDocument
		$array_data 	= json_decode($html,true);

		//dd($array_data);

		//primera pagina
		foreach ($array_data['data']['productSearch']['products'] as $product) {
			if (strpos($product['productName'], 'Pack') === false) {
				// Convertir el resultado en una cadena
				$marca = strtoupper($product['brand']);
				if($marca==''){
					$marca = 'GENERICO';
				}
				$precio = $product['priceRange']['sellingPrice']['highPrice'];
				// Dividir la cadena por espacios
				preg_match('/(\d+)\s*(kg|g)/i', $product['productName'], $matches);
				//preg_match('/(\d+)(\D+)/', $ump, $matches);
				// Obtener el valor numérico y el texto
				$peso = 0; // 5
				$unidad = ''; // kg
				if(isset($matches[1])){
					$peso = $matches[1]; // 5
				}
				if(isset($matches[2])){
					$unidad = $matches[2]; // kg
				}
	            $tabla                       	=   new SuperPrecio;
	            $tabla->MARCA         	 		=   $marca;
	            $tabla->SUPERMERCADO      		=   $supermercado;
	            $tabla->FECHA      	     		=   date('Ymd');
	            $tabla->FECHA_TIME        		=   date('Ymd h:i:s');
	            $tabla->NOMBRE_PRODUCTO   		=   $product['productName'];
	            $tabla->DESCRIPCION_PRODUCTO 	=   '';
	            $tabla->PRECIO            		=   (float)$precio;
	            $tabla->UNIDAD_MEDIDA     		=   $unidad;
	            $tabla->PESO        		 	=   (float)$peso;
	            $tabla->save();

        	}
		}
	}
	private function scrapear_plazavea($supermercado) {

		$url = "https://www.plazavea.com.pe/api/catalog_system/pub/products/search?fq=C:/431/432/&_from=0&_to=49&O=OrderByScoreDESC&";
		// Inicializar cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// Ejecutar la solicitud
		$html = curl_exec($ch);
		curl_close($ch);
		// Cargar el HTML en DOMDocument
		$array_data 	= json_decode($html,true);
		foreach ($array_data as $product) {
			// Extraer solo las letras mayúsculas
			preg_match_all('/\b[A-Z]+\b/', $product['productName'], $mayusculas);
			// Convertir el resultado en una cadena
			$marca = implode('', $mayusculas[0]);
			if($marca==''){
				$marca = 'GENERICO';
			}
			$precio = $product['items'][0]['sellers'][0]['commertialOffer']['Price'];
			// Dividir la cadena por espacios
			$ultimap = explode(' ', $product['productName']);
			// Obtener el último elemento
			$ump = end($ultimap);
			preg_match('/(\d+)(\D+)/', $ump, $matches);
			// Obtener el valor numérico y el texto
			$peso = $matches[1]; // 5
			$unidad = $matches[2]; // kg

            $tabla                       	=   new SuperPrecio;
            $tabla->MARCA         	 		=   $marca;
            $tabla->SUPERMERCADO      		=   $supermercado;
            $tabla->FECHA      	     		=   date('Ymd');
            $tabla->FECHA_TIME        		=   date('Ymd h:i:s');
            $tabla->NOMBRE_PRODUCTO   		=   $product['productName'];
            $tabla->DESCRIPCION_PRODUCTO 	=   $product['metaTagDescription'];
            $tabla->PRECIO            		=   (float)$precio;
            $tabla->UNIDAD_MEDIDA     		=   $unidad;
            $tabla->PESO        		 	=   (float)$peso;
            $tabla->save();
		}
	}
	public function buscar_curl($urlxml) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $urlxml,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET'
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response_array = json_decode($response, true);


        return  $response_array;
    }

}