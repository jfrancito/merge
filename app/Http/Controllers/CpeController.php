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


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use Stdclass;
use App\Traits\UserTraits;
use App\Traits\GeneralesTraits;


class CpeController extends Controller {

    use UserTraits;
    use GeneralesTraits;


	public function actionGestionCpe($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

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
			$respuetacdr 				=	$this->buscar_archivo_sunat($urlxml,$fetoken);


 			return Redirect::to('/gestion-de-cpe/'.$idopcion)->with('bienhecho', 'Archivo '.$ruc.' encontrado con exito');

		}else{


			$combotd  					= 	array('01' => 'FACTURA','03' => 'BOLETA','07' => 'NOTA DE CREDITO','08' => 'NOTA DE DEBITO');

		
			return View::make('cpe/buscarcpe',
						[
							'combotd'  		=> $combotd,			
						  	'idopcion'  	=> $idopcion
						]);
		}
	}


}
