<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

use App\Modelos\WEBGrupoopcion;
use App\Modelos\WEBOpcion;
use App\Modelos\WEBRol;
use App\Modelos\WEBRolOpcion;
use App\Modelos\STDEmpresaDireccion;
use App\Modelos\TESCuentaBancaria;
use App\Modelos\CMPCategoria;
use App\Modelos\STDEmpresa;
use App\Modelos\WEBUserEmpresaCentro;
use App\User;


use App\Modelos\VMergeOC;
use App\Modelos\FeFormaPago;
use App\Modelos\FeDetalleDocumento;
use App\Modelos\FeDocumento;
use App\Modelos\Estado;
use App\Modelos\CMPOrden;
use App\Modelos\FeToken;


use App\Modelos\FeDocumentoHistorial;
use App\Modelos\SGDUsuario;

use App\Modelos\STDTrabajador;
use App\Modelos\Archivo;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\DetCompraHarold;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use Stdclass;
use App\Traits\UserTraits;
use App\Traits\GeneralesTraits;
use App\Traits\ComprobanteTraits;


class CpeController extends Controller {

    use UserTraits;
    use GeneralesTraits;
    use ComprobanteTraits;





	public function actionGestionCpeCompra(Request $request)
	{




		$compras = DB::table('compras_harol')->WhereNull('ind_sw')->get();

		//dd($compras);

		foreach($compras as $index => $item){

			$ruc 	 		 			= 	$item->RUC;
			$td 	 		 			= 	'01';
			$serie 	 		 			= 	$item->NRO_SERIE;
			$correlativo 	 		 	= 	$item->NRO_DOC;
			$TXT_REFERENCIA 	 		 	= 	$item->TXT_REFERENCIA;
			$EMPRESAABRE = substr($TXT_REFERENCIA, 0, 2);

			if($EMPRESAABRE == 'II'){
				$empresa_cod = 'IACHEM0000010394';
			}else{
				$empresa_cod = 'IACHEM0000007086';
			}


			$fetoken 					=	FeToken::where('COD_EMPR','=',$empresa_cod)->first();
			//buscar xml
			$urlxml 					= 	'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2';

			//dd($urlxml);

			$respuetaxml 				=	$this->buscar_archivo_sunat_compra($urlxml,$fetoken);




			if(count($respuetaxml)>0){
				if (isset($respuetaxml['comprobantes'])) {

					foreach($respuetaxml['comprobantes'] as $indexitem => $itemitems){
						foreach($itemitems['informacionItems'] as $indexitem2 => $itemitems2){

							$detcompra     					= new DetCompraHarold;
							$detcompra->TXT_REFERENCIA      = $TXT_REFERENCIA;		
							$detcompra->desItem      = $itemitems2['desItem'];	
							$detcompra->mtoValUnitario      = $itemitems2['mtoValUnitario'];	
							$detcompra->mtoImpTotal      = $itemitems2['mtoImpTotal'];	
							$detcompra->save();

				            DB::table('compras_harol')->where('TXT_REFERENCIA','=',$TXT_REFERENCIA)
				            ->update(
				                    [
				                        'ind_sw'=>1
				                    ]);


						}
					}


				}


			}



		}
		dd($respuetaxml);


	}



	public function actionGestionCpe($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
        View::share('titulo','Descargar CPE');
		if($_POST)
		{

			$ruc 	 		 			= 	$request['ruc'];
			$td 	 		 			= 	$request['td'];
			$serie 	 		 			= 	$request['serie'];
			$correlativo 	 		 	= 	$request['correlativo'];
			$fetoken 					=	FeToken::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)->first();
			//buscar xml
			$urlxml 					= 	'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/02';
			$respuetaxml 				=	$this->buscar_archivo_sunat($urlxml,$fetoken);
			$urlxml 					= 	'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/01';
			$respuetapdf 				=	$this->buscar_archivo_sunat($urlxml,$fetoken);
			$urlxml 					= 	'https://api-cpe.sunat.gob.pe/v1/contribuyente/consultacpe/comprobantes/'.$ruc.'-'.$td.'-'.$serie.'-'.$correlativo.'-2/03';
			$respuetacdr 				=	$this->buscar_archivo_sunat($urlxml,$fetoken);


			Session::flash('respuetaxml', $respuetaxml);
			Session::flash('respuetapdf', $respuetapdf);
			Session::flash('respuetacdr', $respuetacdr);
			//return Redirect::back()->withInput()->with('bienhecho', 'Se encontraron los Archivos');
 			return Redirect::to('/gestion-de-cpe/'.$idopcion)->withInput()->with('bienhecho', 'Archivo '.$ruc.' encontrado con exito');

		}else{

			$combotd  					= 	array('01' => 'FACTURA','03' => 'BOLETA','07' => 'NOTA DE CREDITO','08' => 'NOTA DE DEBITO','02' => 'RECIBO POR HONORARIO');

			return View::make('cpe/buscarcpe',
						[
							'combotd'  		=> $combotd,			
						  	'idopcion'  	=> $idopcion
						]);
		}
	}

	public function actionGestionCpeLocal($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
        View::share('titulo','Descargar CPE Local');
		if($_POST)
		{

			$ruc 	 		 			= 	$request['ruc'];
			$td 	 		 			= 	$request['td'];
			$serie 	 		 			= 	$request['serie'];
			$correlativo 	 		 	= 	(int)$request['correlativo'];
			$correlativo 				= 	str_pad($correlativo,8 , "0", STR_PAD_LEFT);

			$fetoken 					=	FeToken::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)->first();
            $prefijocarperta 			=   $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);

			//buscar xml
			$urlxml 					= 	'\\\\10.1.0.12\\cpe\\Facturacion\\' . $prefijocarperta . '\\' . 
									          Session::get('empresas')->NRO_DOCUMENTO . '-01-' . $serie . '-' . 
									          $correlativo . '.zip';					          
			$respuetaxml 				=	$this->buscar_archivo_sunat_local($urlxml);
			$urlxml 					= 	'\\\\10.1.0.201\\cpe\\Facturacion\\Archivos\\'. 
									          Session::get('empresas')->NRO_DOCUMENTO . '-01-' . $serie . '-' . 
									          $correlativo . '\\'.Session::get('empresas')->NRO_DOCUMENTO . '-01-' . $serie . '-' . $correlativo.'.pdf';
			$respuetapdf 				=	$this->buscar_archivo_sunat_local($urlxml);
			$urlxml 					= 	'\\\\10.1.0.12\\cpe\\Facturacion\\' . $prefijocarperta . '\\R-' . 
									          Session::get('empresas')->NRO_DOCUMENTO . '-01-' . $serie . '-' . 
									          $correlativo . '.zip';
			$respuetacdr 				=	$this->buscar_archivo_sunat_local($urlxml);

			if (Session::has('respuetaxml')) {
			    Session::forget('respuetaxml');
			    Session::forget('respuetapdf');
			    Session::forget('respuetacdr');
			}


			Session::put('respuetaxml', $respuetaxml);
			Session::put('respuetapdf', $respuetapdf);
			Session::put('respuetacdr', $respuetacdr);
			Session::put('documentob', $ruc."-".$serie."-".$correlativo);

			//return Redirect::back()->withInput()->with('bienhecho', 'Se encontraron los Archivos');
 			return Redirect::to('/gestion-de-sunat-cpe-local/'.$idopcion)->withInput()->with('bienhecho', 'Archivo '.$ruc.' encontrado con exito');

		}else{

			$combotd  					= 	array('01' => 'FACTURA');

			return View::make('cpe/buscarcpelocal',
						[
							'combotd'  		=> $combotd,			
						  	'idopcion'  	=> $idopcion
						]);
		}
	}


    public function descargarArchivoLocal($tipo)
    {

		$sesiones = [
	        'cdr' => 'respuetacdr',
	        'xml' => 'respuetaxml',
	        'pdf' => 'respuetapdf',
	    ];

	    if (!isset($sesiones[$tipo])) {
	        return back()->with('errorbd', 'Tipo de archivo inválido.');
	    }

	    $archivo = Session::get($sesiones[$tipo]);


	    if (!$archivo || $archivo == '') {
	        return back()->with('errorbd', 'El archivo no existe.');
	    }

	    $rutaCompleta = $archivo;

	    if (!file_exists($rutaCompleta)) {
	        return back()->with('errorbd', 'El archivo no se encuentra en el servidor.');
	    }

	    // Eliminar el archivo de la sesión después de descargarlo
	    Session::forget($sesiones[$tipo]);

	    return response()->download($rutaCompleta);
    }


    public function actionDescargarArchivo($archivonombre)
    {

        View::share('titulo','DESCARGAR ARCHIVO');
        try{
            // DB::beginTransaction();

            $storagePath            =   storage_path('app\\sunat\\'.$archivonombre);


            if(is_file($storagePath))
            {       
                    // return Response::download($rutaArchivo);
                    return response()->download($storagePath);
            }
            
            // DB::commit();
        }catch(\Exception $ex){
            // DB::rollback(); 
            $sw =   1;
            $mensaje  = $this->ge_getMensajeError($ex);
            dd('archivo no encontrado');

        }
        
    }


}
