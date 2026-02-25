<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\FeToken;
use App\Modelos\DocumentoSunat;
use App\Modelos\DocumentoSunatDetalle;

use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use File;


trait SunatTraits
{

	private function sunatarchivos() {


		$empresas 					= 	DB::table('FE_TOKEN')
										//->where('COD_EMPR','=','IACHEM0000010394')
										->where('TIPO','=','COMPROBANTE_PAGO')
									    ->select('COD_EMPR', 'TXT_EMPR')
									    ->groupBy('COD_EMPR', 'TXT_EMPR')
									    ->get();

		foreach ($empresas as $indexe=>$item2) {

			$documentos 	=   DocumentoSunat::where('RUC_EMPRESA','=',$item2->COD_EMPR)
								->whereRaw('ISNULL(IND_DETALLE, 0) = 0')
								//->whereRaw('ISNULL(CONTADOR,0) < 2')
								->whereRaw("COD_TIPODOCUMENTO IN ('01','02')")
								->orderby('CONTADOR','asc')
								->take(1000)
						    	->get();

			$fetoken 		=	FeToken::where('COD_EMPR','=',$item2->COD_EMPR)->where('TIPO','=','COMPROBANTE_PAGO')->first();

			foreach($documentos as $index=>$item){

				$indpdf 		= 	$item->IND_PDF;
				$indxml 		= 	$item->IND_XML;

				$ruc 			= trim($item->RUC_EMPRESA_PROVEEDOR);
				$serie 			= trim($item->SERIE);
				$correlativo 	= trim($item->NUMERO);
				$td 			= trim($item->COD_TIPODOCUMENTO);
				//$serie 			= trim('G001');

				if($td == '07'){
					$td = 'F7';
				}

				$urlxml 					= 	'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2';
				$respuetapdf 				=	$this->buscar_archivo_sunat_nuevo_fa($urlxml,$fetoken);

				//dd($respuetapdf);

				if($respuetapdf['cod_error'] == '0'){

					if($td=='02'){
						//RECIBO
		                $items = $respuetapdf['informacionItems']['comprobantes'][0];

		                $detalle = new DocumentoSunatDetalle();
	                    $detalle->ID = $item->ID; // Implementa tu lógica para generar ID
	                    $detalle->cntItems = 1;

	                    $detalle->codUnidadMedida = 'NIU';
	                    $detalle->desCodigo = '';
	                    $detalle->desItem = $items['desConcepto'];
	                    $detalle->desUnidadMedida = 'UNIDAD';
	                    $detalle->mtoDesc = 0;
	                    $detalle->mtoICBPER = 0;
	                    $detalle->mtoImpTotal = $this->limpiarNumero($items['mtoTotalRecibido'] ?? 0);
	                    $detalle->mtoValUnitario = $this->limpiarNumero($items['mtoTotalRecibido'] ?? 0);
	                    // Guardar en la base de datos
	                    $detalle->save();

					}else{
						//FACTURA
		                $items = $respuetapdf['informacionItems']['comprobantes'][0]['informacionItems'];

		                foreach ($items as $itemdet) {
		                    // Crear nuevo registro en DocumentoSunatDetalle
		                    $detalle = new DocumentoSunatDetalle();
		                    
		                    // Asignar valores del array al modelo
		                    $detalle->ID = $item->ID; // Implementa tu lógica para generar ID
		                    $detalle->cntItems = $this->limpiarNumero($itemdet['cntItems'] ?? 0);
		                    $detalle->codUnidadMedida = $itemdet['codUnidadMedida'] ?? null;
		                    $detalle->desCodigo = $itemdet['desCodigo'] ?? null;
		                    $detalle->desItem = $itemdet['desItem'] ?? null;
		                    $detalle->desUnidadMedida = $itemdet['desUnidadMedida'] ?? null;
		                    $detalle->mtoDesc = $this->limpiarNumero($itemdet['mtoDesc'] ?? 0);
		                    $detalle->mtoICBPER = $this->limpiarNumero($itemdet['mtoICBPER'] ?? 0);
		                    $detalle->mtoImpTotal = $this->limpiarNumero($itemdet['mtoImpTotal'] ?? 0);
		                    $detalle->mtoValUnitario = $this->limpiarNumero($itemdet['mtoValUnitario'] ?? 0);
		                    // Guardar en la base de datos
		                    $detalle->save();
		                }


					}


					DB::table('DOCUMENTO_SUNAT')
					    ->where('RUC_EMPRESA_PROVEEDOR', $item->RUC_EMPRESA_PROVEEDOR)
					    ->where('SERIE', $item->SERIE)
					    ->where('NUMERO', $item->NUMERO)
					    ->where('COD_TIPODOCUMENTO', $item->COD_TIPODOCUMENTO)
					    ->update([
					        'IND_DETALLE' => 1
					    ]);

				}else{


					DB::table('DOCUMENTO_SUNAT')
					    ->where('RUC_EMPRESA_PROVEEDOR', $item->RUC_EMPRESA_PROVEEDOR)
					    ->where('SERIE', $item->SERIE)
					    ->where('NUMERO', $item->NUMERO)
					    ->where('COD_TIPODOCUMENTO', $item->COD_TIPODOCUMENTO)
					    ->update([
					        'CONTADOR' => DB::raw('ISNULL(CONTADOR,0) + 1')
					    ]);
					//dd($item->ID);
					print_r("x");

				}
			}
		}
	}

    private function limpiarNumero($valor)
    {
        if (is_numeric($valor)) {
            return (float) $valor;
        }
        
        // Si viene como string con formato, limpiarlo
        $valorLimpio = str_replace(',', '', (string) $valor);
        return (float) $valorLimpio;
    }
	private function sut_traer_data_sunat($empresa_id)
	{
	    $empresas = DB::table('FE_TOKEN')
	        ->select('COD_EMPR', 'TXT_EMPR')
	        ->where('COD_EMPR','=',$empresa_id)
	        ->where('TIPO','=','SIRE')
	        ->groupBy('COD_EMPR', 'TXT_EMPR')
	        ->get();

	    foreach ($empresas as $item) {
	        $fetoken = FeToken::where('COD_EMPR','=',$item->COD_EMPR)
	            ->where('TIPO','=','SIRE')
	            ->first();
	        
	        if (!$fetoken) {
	            \Log::error("No hay token para empresa: " . $item->COD_EMPR);
	            continue;
	        }

			$periodo_actual = \Carbon\Carbon::now()->format('Ym');
			//$periodo_actual = '202312';

			// Convertir a Carbon y calcular periodo anterior
			$fechaActual = \Carbon\Carbon::createFromFormat('Ym', $periodo_actual);
			$fechaAnterior = $fechaActual->copy()->subMonth();
			$periodos = [
			    $fechaAnterior->format('Ym'), // 202510
			    $fechaActual->format('Ym')    // 202511
			];

			//dd($periodos);
	        
	        foreach ($periodos as $periodo) {
	            $pagina = 1;
	            $perPage = 100;
	            $totalRegistros = 0;
	            $maxPaginas = 50; // Límite de seguridad (50 * 100 = 5000 registros)
	            $registrosAnteriores = []; // Para detectar duplicados
	            $intentosFallidos = 0;
	            $maxIntentosFallidos = 3;
	            
	            while ($pagina <= $maxPaginas) {
	                
	                // Verificar tiempo de ejecución
	                if (time() > $_SERVER['REQUEST_TIME'] + 240) { // 4 minutos máximos
	                    \Log::warning("Tiempo de ejecución excedido. Deteniendo.");
	                    break 2;
	                }
	                
	                $url = 'https://api-sire.sunat.gob.pe/v1/contribuyente/migeigv/libros/rce/propuesta/web/propuesta/' . $periodo . '/busqueda?codTipoOpe=1&page=' . $pagina . '&perPage=' . $perPage;
	                
	                \Log::info("Consultando página {$pagina}: " . $url);
	                
	                $respuesta = $this->sut_buscar_archivo_sunat_compra($url, $fetoken);
	                
	                // Verificar si hay error en la respuesta
	                if (isset($respuesta['error'])) {
	                    \Log::error("Error en API: " . json_encode($respuesta));
	                    $intentosFallidos++;
	                    
	                    if ($intentosFallidos >= $maxIntentosFallidos) {
	                        \Log::error("Demasiados errores consecutivos. Deteniendo.");
	                        break;
	                    }
	                    
	                    sleep(2); // Esperar antes de reintentar
	                    continue;
	                }
	                
	                // Verificar estructura de la respuesta
	                if (!isset($respuesta['registros'])) {
	                    \Log::error("Respuesta sin campo 'registros': " . json_encode($respuesta));
	                    break;
	                }
	                
	                $cantidadRegistros = count($respuesta['registros']);
	                \Log::info("→ Recibidos {$cantidadRegistros} registros en página {$pagina}");
	                
	                // --- MÚLTIPLES CONDICIONES DE SALIDA ---
	                
	                // Condición 1: No hay registros
	                if ($cantidadRegistros === 0) {
	                    \Log::info("→ No hay registros. Fin de paginación.");
	                    break;
	                }
	                
	                // Condición 2: Menos de 100 registros (última página real)
	                if ($cantidadRegistros < $perPage) {
	                    \Log::info("→ Última página alcanzada (menos de {$perPage} registros). Total: {$totalRegistros}");
	                    
	                    // Procesar estos últimos registros
	                    foreach ($respuesta['registros'] as $valorsire) {
	                        $this->procesarRegistro($valorsire, $item);
	                    }
	                    $totalRegistros += $cantidadRegistros;
	                    break;
	                }
	                
	                // Condición 3: Detectar duplicados (posible reinicio de paginación)
	                $primerRegistro = $respuesta['registros'][0]['id'] ?? null;
	                if ($primerRegistro && in_array($primerRegistro, $registrosAnteriores)) {
	                    \Log::warning("→ Detectado posible reinicio de paginación. Deteniendo.");
	                    break;
	                }
	                if ($primerRegistro) {
	                    $registrosAnteriores[] = $primerRegistro;
	                    // Mantener solo los últimos 5 IDs para memoria
	                    if (count($registrosAnteriores) > 5) {
	                        array_shift($registrosAnteriores);
	                    }
	                }
	                
	                // Procesar registros de página normal
	                foreach ($respuesta['registros'] as $valorsire) {
	                    $this->procesarRegistro($valorsire, $item);
	                }
	                
	                $totalRegistros += $cantidadRegistros;
	                
	                // Preparar siguiente página
	                $pagina++;
	                
	                // Pausa para no saturar la API
	                sleep(1); // 1 segundo entre páginas
	                
	                // Resetear contador de errores si llegamos aquí
	                $intentosFallidos = 0;
	            }
	            
	            \Log::info("Periodo {$periodo} completado. TOTAL REGISTROS PROCESADOS: {$totalRegistros}");
	        }
	    }
	}

	/**
	 * Función auxiliar para procesar cada registro
	 */
	private function procesarRegistro($valorsire, $item)
	{
	    try {
	        $documento = DocumentoSunat::where('RUC_EMPRESA_PROVEEDOR', '=', $valorsire['numDocIdentidadProveedor'])
	            ->where('SERIE', '=', $valorsire['numSerieCDP'])
	            ->where('NUMERO', '=', $valorsire['numCDP'])
	            ->where('COD_TIPODOCUMENTO', '=', $valorsire['codTipoCDP'])
	            ->where('RUC_EMPRESA', '=', $item->COD_EMPR)
	            ->first();
	        
	        if (!$documento) {
	            $fecha = $valorsire['fecEmision'];
	            $anioMes = date('Ym', strtotime($fecha));
	            
	            $cabecera = new DocumentoSunat;
	            $cabecera->ID = $valorsire['id'];
	            $cabecera->RUC_EMPRESA = $item->COD_EMPR;
	            $cabecera->TXT_EMPRESA = $item->TXT_EMPR;
	            $cabecera->RUC_EMPRESA_PROVEEDOR = $valorsire['numDocIdentidadProveedor'];
	            $cabecera->TXT_EMPRESA_PROVEEDOR = $valorsire['nomRazonSocialProveedor'];
	            $cabecera->COD_TIPODOCUMENTO = $valorsire['codTipoCDP'];
	            $cabecera->TXT_TIPODOCUMENTO = $valorsire['desTipoCDP'];
	            $cabecera->SERIE = $valorsire['numSerieCDP'];
	            $cabecera->NUMERO = $valorsire['numCDP'];
	            $cabecera->PERIODO = $anioMes;
	            $cabecera->FECHA_EMISION = $valorsire['fecEmision'];
	            $cabecera->FECHA_VENCIMIENTO = $valorsire['fecVencPag'] ?? null;
	            $cabecera->MONEDA = $valorsire['codMoneda'];
	            $cabecera->ESTADO = $valorsire['desEstadoComprobante'];
	            $cabecera->TOTAL = $valorsire['montos']['mtoTotalCp'] ?? 0;
	            $cabecera->IND_REGISTRO = 'SUNAT';

	            $cabecera->save();
	            
	            return true;
	        }
	        return false; // Ya existía
	    } catch (\Exception $e) {
	        \Log::error("Error procesando registro: " . $e->getMessage());
	        return false;
	    }
	}

    private function sut_traer_data_sunat_otro()
    {

		$empresas 					= 	DB::table('FE_TOKEN')
									    ->select('COD_EMPR', 'TXT_EMPR')
									    ->groupBy('COD_EMPR', 'TXT_EMPR')
									    ->get();

		foreach ($empresas as $indexe=>$item) {

			$periodo_actual = \Carbon\Carbon::now()->format('Ym');
			//$periodo_actual = '202312';

			// Convertir a Carbon y calcular periodo anterior
			$fechaActual = \Carbon\Carbon::createFromFormat('Ym', $periodo_actual);
			$fechaAnterior = $fechaActual->copy()->subMonth();
			$periodos = [
			    $fechaAnterior->format('Ym'), // 202510
			    $fechaActual->format('Ym')    // 202511
			];

			$periodos = [
			    '202403', // 202510
			    '202404'    // 202511
			];

			// Recorrer con foreach
			foreach ($periodos as $periodo) {
				$fetoken 					=	FeToken::where('COD_EMPR','=',$item->COD_EMPR)->where('TIPO','=','SIRE')->first();
				$valores 					= 	[1,2,4,8,16,32];
				foreach ($valores as $index=>$valor) {
					$array_nuevo_producto 		=	array();
					$urlxml 					= 	'https://api-sire.sunat.gob.pe/v1/contribuyente/migeigv/libros/rce/propuesta/web/propuesta/'.$periodo.'/busqueda?codTipoOpe=1&page='.$valor.'&perPage=100';
					$respuetaxml 				=	$this->sut_buscar_archivo_sunat_compra($urlxml,$fetoken);

					if(isset($respuetaxml['registros'])){

						foreach ($respuetaxml['registros'] as $valorsire) {


								$documento 							=	DocumentoSunat::where('RUC_EMPRESA_PROVEEDOR','=',$valorsire['numDocIdentidadProveedor'])
																		->where('SERIE','=',$valorsire['numSerieCDP'])->where('NUMERO','=',$valorsire['numCDP'])
																		->where('COD_TIPODOCUMENTO','=',$valorsire['codTipoCDP'])
																		->where('RUC_EMPRESA','=',$item->COD_EMPR)
																		->first();
								if(count($documento)<=0){

									$fecha = $valorsire['fecEmision'];
									$anioMes = date('Ym', strtotime($fecha));

									$cabecera     						= 	new DocumentoSunat;
									$cabecera->ID      				 	= 	$valorsire['id'];
									$cabecera->RUC_EMPRESA     			= 	$item->COD_EMPR;	
									$cabecera->TXT_EMPRESA     			= 	$item->TXT_EMPR;

									$cabecera->RUC_EMPRESA_PROVEEDOR     = 	$valorsire['numDocIdentidadProveedor'];	
									$cabecera->TXT_EMPRESA_PROVEEDOR     = 	$valorsire['nomRazonSocialProveedor'];	
									$cabecera->COD_TIPODOCUMENTO      	 = 	$valorsire['codTipoCDP'];
									$cabecera->TXT_TIPODOCUMENTO      	 = 	$valorsire['desTipoCDP'];
									$cabecera->SERIE      				 = 	$valorsire['numSerieCDP'];	
									$cabecera->NUMERO       			 = 	$valorsire['numCDP'];
									$cabecera->PERIODO      		 	 = 	$anioMes;

									$cabecera->FECHA_EMISION      		 = 	$valorsire['fecEmision'];
									$cabecera->FECHA_VENCIMIENTO      	 = 	$valorsire['fecVencPag'];
									$cabecera->MONEDA      			     = 	$valorsire['codMoneda'];	
									$cabecera->ESTADO       			 = 	$valorsire['desEstadoComprobante'];	
									$cabecera->TOTAL       			 	 = 	$valorsire['montos']['mtoTotalCp'];	
									$cabecera->save();
								}
						}
					}
				}	
			}
		}
    }

    private function con_lista_cabecera_comprobante_sunat($empresa_id,$periodo) {


		$listadatos 	= DB::table('DOCUMENTO_SUNAT')
						    ->where('RUC_EMPRESA', $empresa_id)
						    ->where('PERIODO', $periodo)
						    ->get();



        return  $listadatos;
    }


    private function sut_combo_empresa() {
            

		$empresas 					= 	DB::table('FE_TOKEN')
									    ->select('COD_EMPR', 'TXT_EMPR')
									    ->groupBy('COD_EMPR', 'TXT_EMPR')
							            ->pluck('TXT_EMPR','COD_EMPR')
							            ->toArray();

        $combo                  	=   array('' => 'Seleccione empresa') + $empresas;

        return  $combo;                             
    }

   private function sut_combo_periodo() {
            
		$periodos 					= DB::table('DOCUMENTO_SUNAT')
									    ->select('PERIODO')
									    ->groupBy('PERIODO')
									    ->orderBy('PERIODO', 'desc')
							            ->pluck('PERIODO','PERIODO')
							            ->toArray();


        $combo                  	=   array('' => 'Seleccione periodo') + $periodos;

        return  $combo;                             
    }





	private function versicarpetanoexiste_che($ruta) {
		$valor = false;
		if (!file_exists($ruta)) {
		    mkdir($ruta, 0777, true);
		    $valor=true;
		}
		return $valor;
	}




    private function buscar_archivo_sunat_nuevo_fa($urlxml, $fetoken)
    {


        $curl = curl_init();

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


        if (!isset($response_array['comprobantes'])) {
            $array_nombre_archivo = [
                'cod_error' => 1,
                'informacionItems' => '',
                'mensaje' => 'Hubo un problema de sunat buscar nuevamente'
            ];
        } else {
            $array_nombre_archivo = [
                'cod_error' => 0,
                'informacionItems' => $response_array,
                'mensaje' => 'encontrado con exito'
            ];
        }

        return $array_nombre_archivo;

    }

    private function sut_buscar_archivo_sunat_compra($urlxml, $fetoken)
    {

        $array_nombre_archivo = array();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlxml,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $fetoken->TOKEN
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response_array = json_decode($response, true);


        return $response_array;

    }


}