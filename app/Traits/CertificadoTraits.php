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

use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;

trait CertificadoTraits
{

	private function con_lista_certificados() {

		$listadatos 	= 	Certificado::where('activo','=','1')->get();
	 	return  $listadatos;

	}


}