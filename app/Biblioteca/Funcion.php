<?php
namespace App\Biblioteca;


use App\User;
use App\Modelos\WEBRolopcion;
use App\Modelos\Estado;
use App\Modelos\FeDocumento;

use Hashids;
use Illuminate\Support\Facades\DB;
use Redirect;
use Session;
use table;

class Funcion {

	public function neto_pagar_oc($oc){

		$valor_detraccion = 0;
		$neto_pagar 	  = 0;

		$fedocumento = FeDocumento::where('ID_DOCUMENTO','=',$oc->COD_ORDEN)->first();

		$COD_PAGO_DETRACCION = $fedocumento->COD_PAGO_DETRACCION;
		if($COD_PAGO_DETRACCION == '' || is_null($COD_PAGO_DETRACCION)){
			$COD_PAGO_DETRACCION = Session::get('empresas')->COD_EMPR;
		}

		if($COD_PAGO_DETRACCION == Session::get('empresas')->COD_EMPR){
			$neto_pagar 	  = (float)$oc->CAN_TOTAL - (float)$oc->CAN_DETRACCION - (float)$oc->CAN_RETENCION + (float)$oc->CAN_PERCEPCION;
		}else{
			$neto_pagar 	  = (float)$oc->CAN_TOTAL - (float)$oc->CAN_RETENCION + (float)$oc->CAN_PERCEPCION;
		}

        $neto_pagar 	  = ROUND($neto_pagar,2);
        return $neto_pagar;
	}




	public function se_paga_detraccion_contrato($id_documento){

		$valor_detraccion = 0;
		$fedocumento = FeDocumento::where('ID_DOCUMENTO','=',$id_documento)->first();
		if($fedocumento->COD_PAGO_DETRACCION == Session::get('empresas')->COD_EMPR){
			$valor_detraccion = $fedocumento->MONTO_DETRACCION_RED;
		}
		
		return $valor_detraccion;
	}


	public function estorno_referencia($cod_orden) {
		$TXT_VALOR = '';
		$fe = FeDocumento::where('TXT_REFERENCIA', '=', $cod_orden)->first();
		if(count($fe)>0){
			$TXT_VALOR = 'SI';
		}
		return $TXT_VALOR;
	}



	public function estado_nombre($id) {
		$nombre = '';
		$estado = Estado::where('id', '=', $id)->first();
		if(count($estado)>0){
			$nombre = $estado->nombre;
		}
		return $nombre;
	}


	public function tabla_usuario($usuario_id) {
		$usuario = User::where('id', '=', $usuario_id)->first();
		return $usuario;
	}
	public function color_empresa($empresa_id) {

		$color 		= '';
		if($empresa_id == 'IACHEM0000010394'){
			$color 		= 'color-iin';
		}

		if($empresa_id == 'IACHEM0000007086'){
			$color 		= 'color-ico';
		}
		if($empresa_id == 'EMP0000000000007'){
			$color 		= 'color-itr';
		}

		if($empresa_id == 'IACHEM0000001339'){
			$color 		= 'color-ich';
		}

		if($empresa_id == 'EMP0000000000001'){
			$color 		= 'color-iaa';
		}
		return $color;
	}
	

	public function generar_codigo($basedatos, $cantidad) {

		// maximo valor de la tabla referente
		$tabla = DB::table($basedatos)
			->select(DB::raw('max(codigo) as codigo'))
			->get();

		//conversion a string y suma uno para el siguiente id
		$idsuma = (int) $tabla[0]->codigo + 1;

		//concatenar con ceros
		$correlativocompleta = str_pad($idsuma, $cantidad, "0", STR_PAD_LEFT);

		return $correlativocompleta;

	}

	public function generar_folio($basedatos, $cantidad) {

		// maximo valor de la tabla referente
		$tabla = DB::table($basedatos)
			->select(DB::raw('max(FOLIO) as codigo'))
			->get();

		//conversion a string y suma uno para el siguiente id
		$idsuma = (int) $tabla[0]->codigo + 1;

		//concatenar con ceros
		$correlativocompleta = str_pad($idsuma, $cantidad, "0", STR_PAD_LEFT);

		return $correlativocompleta;

	}


	public function decodificarmaestra($id) {

		//decodificar variable
		$iddeco = Hashids::decode($id);

		//ver si viene con letras la cadena codificada
		if (count($iddeco) == 0) {
			return '';
		}
		//concatenar con ceros
		$idopcioncompleta = str_pad($iddeco[0], 8, "0", STR_PAD_LEFT);
		//concatenar prefijo

		//$prefijo = Local::where('activo', '=', 1)->first();

		// apunta ahi en tu cuaderno porque esto solo va a permitir decodifcar  cuando sea el contrato del locl en donde estas del resto no
		//¿cuando sea el contrato del local?
		$prefijo = $this->prefijomaestra();
		$idopcioncompleta = $prefijo . $idopcioncompleta;
		return $idopcioncompleta;

	}

	public function decodificarmaestraprefijo($id,$prefijo) {

		//decodificar variable
		$iddeco = Hashids::decode($id);


		//ver si viene con letras la cadena codificada
		if (count($iddeco) == 0) {
			return '';
		}
		//concatenar con ceros
		$idopcioncompleta = str_pad($iddeco[0], 10, "0", STR_PAD_LEFT);
		//concatenar prefijo

		//$prefijo = Local::where('activo', '=', 1)->first();
		// apunta ahi en tu cuaderno porque esto solo va a permitir decodifcar  cuando sea el contrato del locl en donde estas del resto no
		//¿cuando sea el contrato del local?
		$idopcioncompleta = $prefijo . $idopcioncompleta;
		return $idopcioncompleta;

	}


	public function decodificarmaestraprefijo_contrato($id,$prefijo) {

		//decodificar variable
		$iddeco = Hashids::decode($id);
		//ver si viene con letras la cadena codificada
		if (count($iddeco) == 0) {
			return '';
		}
		//concatenar con ceros
		$idopcioncompleta = str_pad($iddeco[0], 9, "0", STR_PAD_LEFT);
		//concatenar prefijo
		//$prefijo = Local::where('activo', '=', 1)->first();
		// apunta ahi en tu cuaderno porque esto solo va a permitir decodifcar  cuando sea el contrato del locl en donde estas del resto no
		//¿cuando sea el contrato del local?
		$idopcioncompleta = $prefijo . $idopcioncompleta;
		return $idopcioncompleta;

	}



	public function decodificarmaestraprefijodoc($id,$prefijo) {

		//decodificar variable
		$iddeco = Hashids::decode($id);


		//ver si viene con letras la cadena codificada
		if (count($iddeco) == 0) {
			return '';
		}
		//concatenar con ceros
		$idopcioncompleta = str_pad($iddeco[0], 8, "0", STR_PAD_LEFT);
		//concatenar prefijo

		//$prefijo = Local::where('activo', '=', 1)->first();
		// apunta ahi en tu cuaderno porque esto solo va a permitir decodifcar  cuando sea el contrato del locl en donde estas del resto no
		//¿cuando sea el contrato del local?
		$idopcioncompleta = $prefijo . $idopcioncompleta;
		return $idopcioncompleta;

	}



	public function getUrl($idopcion, $accion) {

		//decodificar variable
		$decidopcion = Hashids::decode($idopcion);
		//ver si viene con letras la cadena codificada
		if (count($decidopcion) == 0) {
			return Redirect::back()->withInput()->with('errorurl', 'Indices de la url con errores');
		}

		//concatenar con ceros
		$idopcioncompleta = str_pad($decidopcion[0], 8, "0", STR_PAD_LEFT);
		//concatenar prefijo

		// hemos hecho eso porque ahora el prefijo va hacer fijo en todas las empresas que 1CIX
		//$prefijo = Local::where('activo', '=', 1)->first();
		//$idopcioncompleta = $prefijo->prefijoLocal.$idopcioncompleta;
		$idopcioncompleta = '1CIX' . $idopcioncompleta;

		// ver si la opcion existe
		$opcion = WEBRolopcion::where('opcion_id', '=', $idopcioncompleta)
			->where('rol_id', '=', Session::get('usuario')->rol_id)
			->where($accion, '=', 1)
			->first();

		if (count($opcion) <= 0) {
			return Redirect::back()->withInput()->with('errorurl', 'No tiene autorización para ' . $accion . ' aquí');
		}
		return 'true';

	}

	public function getCreateIdArchivo($tabla) {

		$id = "";
		// maximo valor de la tabla referente
		$id = DB::table($tabla)
			->select(DB::raw('max(SUBSTRING(id,5,8)) as id'))
			->first();
		//conversion a string y suma uno para el siguiente id
		$idsuma = (int) $id->id + 1;
		//concatenar con ceros
		$idopcioncompleta = str_pad($idsuma, 8, "0", STR_PAD_LEFT);
		//concatenar prefijo
		$prefijo = $this->prefijomaestra();
		$idopcioncompleta = $prefijo . $idopcioncompleta;
		return $idopcioncompleta;

	}


	public function getCreateIdMaestra($tabla) {

		$id = "";
		// maximo valor de la tabla referente
		$id = DB::table($tabla)
			->select(DB::raw('max(SUBSTRING(id,5,8)) as id'))
			->first();
		//conversion a string y suma uno para el siguiente id
		$idsuma = (int) $id->id + 1;
		//concatenar con ceros
		$idopcioncompleta = str_pad($idsuma, 8, "0", STR_PAD_LEFT);
		//concatenar prefijo
		$prefijo = $this->prefijomaestra();
		$idopcioncompleta = $prefijo . $idopcioncompleta;
		return $idopcioncompleta;

	}


	public function getCreateIdMaestradoc($tabla) {

		$id = "";
		// maximo valor de la tabla referente
		$id = DB::table($tabla)
			->where('TXT_PROCEDENCIA','=','SUE')
			->select(DB::raw('max(SUBSTRING(ID_DOCUMENTO,5,8)) as id'))
			->first();
		//conversion a string y suma uno para el siguiente id
		$idsuma = (int) $id->id + 1;
		//concatenar con ceros
		$idopcioncompleta = str_pad($idsuma, 8, "0", STR_PAD_LEFT);
		//concatenar prefijo
		$prefijo = $this->prefijomaestra();
		$idopcioncompleta = $prefijo . $idopcioncompleta;
		return $idopcioncompleta;

	}


	public function prefijomaestra() {

		$prefijo = '1CIX';
		return $prefijo;
	}

	public function getCreateCodCorrelativo($tabla, $length) {

		$cod = "";
		// maximo valor de la tabla referente
		$cod = DB::table($tabla)
			->select(DB::raw('max(codigo) as codigo'))
			->first();			
		//conversion a string y suma uno para el siguiente codigo
		$codsuma = (int) $cod->codigo + 1;
		//concatenar con ceros
		$codcompleto = str_pad($codsuma, $length, "0", STR_PAD_LEFT);
		return $codcompleto;

	}

	public function getCreateLoteCorrelativo($tabla, $length) {

		$cod = "";
		// maximo valor de la tabla referente
		$cod = DB::table($tabla)
			->select(DB::raw('max(lote) as lote'))
			->first();			
		//conversion a string y suma uno para el siguiente lote
		$codsuma = (int) $cod->lote + 1;
		//concatenar con ceros
		$codcompleto = str_pad($codsuma, $length, "0", STR_PAD_LEFT);
		return $codcompleto;

	}

}
