<?php

namespace App\Http\Controllers;
use App\Biblioteca\Funcion;


use DateTime;
use Hashids;
use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public $funciones;

	public $inicio;
	public $inicioanio;
	
	public $fin;
	public $hoy;
	public $prefijomaestro;
	public $fechaactual;
	public $fecha_sin_hora;
	public $maxsize;
	public $unidadmb;
	public $igv;
	public $mgadmin;
	public $mgutil;
	public $generado;
	public $apronado;
	public $emitido;
	public $evaluado;
	public $pathFiles='\\\\10.1.50.2';
	public $hoy_sh;

	public $anio;
	public $mes;



	public function __construct() {
		$this->funciones 		= new Funcion();

		$this->unidadmb 		= 2;
		$this->maxsize 			= pow(1024,$this->unidadmb)*20;
		$fecha 					= new DateTime();
		$fecha->modify('first day of this month');

		$this->inicioanio 		= date_format(date_create($fecha->format('Y') . '-01-01'), 'd-m-Y');
		$this->inicio 			= date_format(date_create($fecha->format('Y-m-d')), 'd-m-Y');
		$this->fin 				= date_format(date_create(date('Y-m-d')), 'd-m-Y');

		$this->prefijomaestro 	= $this->funciones->prefijomaestra();
		$this->fechaactual 		= date('Ymd H:i:s');
		$this->hoy 				= date_format(date_create(date('Ymd h:i:s')), 'Ymd h:i:s');
		$this->hoy_sh 			= date_format(date_create(date('Ymd h:i:s')), 'Ymd');
		$this->fecha_sin_hora 	= date('d-m-Y');

		$anio 					= date("Y");	
		$this->anio 			= $anio;

		$mes 					= date("m");	
		$this->mes 				= $mes;

		//fecha actual 10 dias
		$fechatreinta 	= date('Y-m-j');
		$nuevafecha 	= strtotime ( '-30 day' , strtotime($fechatreinta));
		$nuevafecha 	= date ('Y-m-j' , $nuevafecha);
		$this->fecha_menos_diez_dias = date_format(date_create($nuevafecha), 'd-m-Y');




	}



	public function getPermisosOpciones($idopcion,$idusuario)
	{

		//decodificar variable
	  	$decidopcion = Hashids::decode($idopcion);
	  	
	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($decidopcion[0], 8, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo

	  	$idopcioncompleta = $this->funciones->prefijomaestra().$idopcioncompleta;

	  	// ver si la opcion existe
	  	$opcion =  DB::table('rolopciones as RO')
	  					->join('rols as R','RO.rol_id','=','R.id')
	  					->join('users as U','U.rol_id','=','R.id')
	  					->where('U.id','=',$idusuario)
	  					->where('RO.opcion_id','=',$idopcioncompleta)
	  					->select(
	  						'RO.ver',
	  						'RO.anadir',
	  						'RO.modificar',
	  						'RO.eliminar',
	  						'RO.todas',
	  						'RO.*'
	  					)
	  					->first();
	  	// dd($opcion);
	  	if((count($opcion)>0) && !empty($opcion))
	  	{
	  		$permisosopciones['ver'] 		= $opcion->ver;
	  		$permisosopciones['anadir'] 	= $opcion->anadir;
	  		$permisosopciones['modificar'] 	= $opcion->modificar;
	  		$permisosopciones['eliminar'] 	= $opcion->eliminar;
	  		$permisosopciones['todas'] 		= $opcion->todas;
	  	}
		// $opciones= P
		return $permisosopciones;
	}



}
