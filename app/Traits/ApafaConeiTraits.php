<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\Requerimiento;
use App\Modelos\Conei;


use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;

trait ApafaConeiTraits
{

	private function con_lista_requerimiento() {
		$listadatos 	= 	Requerimiento::get();
	 	return  $listadatos;
	}


	private function con_lista_conei() {
		$listadatos 	= 	Conei::where('director_id','=',Session::get('direccion')->id)
							->get();
	 	return  $listadatos;
	}


}