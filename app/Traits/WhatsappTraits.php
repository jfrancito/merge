<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;

use App\Modelos\Whatsapp;

use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use PDO;

trait WhatsappTraits
{

	public function insertar_whatsaap($numero,$nombre,$mensaje,$rutaimagen){

			$cabecera            	 	=	new Whatsapp;
			$cabecera->numero_contacto 	=   $numero;
			$cabecera->nombre_contacto 	=	$nombre;
			$cabecera->mensaje  		=	$mensaje;
			$cabecera->ruta_imagen  	=	$rutaimagen;
			$cabecera->ind_envio  		=	0;
			$cabecera->nombre_proyecto 	=	'MERGE';
			$cabecera->fecha_crea 	   	=  	date('d-m-Y H:i:s');
			$cabecera->activo 	 		= 	1;
			$cabecera->save();



	}

}