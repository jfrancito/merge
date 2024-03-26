<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
// use App\Modelos\Empresa,App\Modelos\Local,App\Modelos\Trabajador,App\Modelos\Area;
// use App\Modelos\Planillatrabajador;
use App\Modelos\Cliente;
// use App\Modelos\Planillacts,App\Modelos\Planillactsdetalle;
// use App\Modelos\Estado,App\Modelos\Liquidacion,App\Modelos\Cargo;
// use App\Modelos\Ajustemovimientoutilidades;

use View;
use Session;
use Hashids;


class GeneralAjaxController extends Controller
{




	////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function actionProvinciaAjax(Request $request)
	{
		$departamento_id   = $request['departamento_id'];
		$provincia = DB::table('provincias')->where('departamento_id','=',$departamento_id)->pluck('descripcion','id')->toArray();
		$comboprovincia  = array('' => "Seleccione Provincia") + $provincia;
		return View::make('general/ajax/comboprovincia',
						 [
						 	'comboprovincia' => $comboprovincia,
						 	'select_provincia'=>'',
							'ajax'	=>true,
						 ]);
	}	

	public function actionDistritoAjax(Request $request)
	{
		$provincia_id   = $request['provincia_id'];
		$distrito = DB::table('distritos')->where('provincia_id','=',$provincia_id)->pluck('descripcion','id')->toArray();
		$combodistrito  = array('' => "Seleccione Distrito") + $distrito;

		return View::make('general/ajax/combodistrito',
						 [
						 	'combodistrito' => $combodistrito,
						 	'select_distrito'=>'',
						 	'ajax'	=>true,
						 ]);
	}	

	public function actionCargarNDocClienteSinDocumento(Request $request)
	{
		// dd('ss');
		$cliente 	= Cliente::select('numerodocumento')->where('sindocumento',1)->orderby('numerodocumento','desc')->first();
		$numero 	= 1;
		if(count($cliente)){
			$numero = round((float)$cliente->numerodocumento,0)+1;
		}

		$cadnumero = '';
		$cadnumero = str_pad($numero, 8, "0", STR_PAD_LEFT); 
	  	return $cadnumero;
	}

	
}
