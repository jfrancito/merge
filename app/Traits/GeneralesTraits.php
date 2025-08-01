<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\WEBCuentaContable;
use App\Modelos\ALMProducto;
use App\Modelos\Categoria;
use App\Modelos\Estado;
use App\Modelos\Conei;
use App\Modelos\FeDocumento;
use App\Modelos\CONPeriodo;
use App\Modelos\Requerimiento;
use App\Modelos\Archivo;
use App\Modelos\PlaSerie;
use App\Modelos\PlaMovilidad;
use App\Modelos\FePlanillaEntregable;



use App\User;


use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use Storage;
use File;
use ZipArchive;

trait GeneralesTraits
{

    public function gn_numero_pl($serie,$centro_id)
    {

        $dserie  = FePlanillaEntregable::where('COD_CENTRO', '=', $centro_id)
		            ->where('COD_EMPRESA', '=', Session::get('empresas')->COD_EMPR)
		            ->where('SERIE', '=', $serie)
		            ->select(DB::raw('max(NUMERO) as numero'))
		            ->orderBy('NUMERO','desc')
		            ->first();

		//conversion a string y suma uno para el siguiente id
		$idsuma = (int) $dserie->numero + 1;
		//concatenar con ceros
		$idopcioncompleta = str_pad($idsuma, 10, "0", STR_PAD_LEFT);
		$idopcioncompleta = $idopcioncompleta;
		return $idopcioncompleta;

    }


    public function gn_numero($serie,$centro_id)
    {

        $dserie  = PlaMovilidad::where('COD_CENTRO', '=', $centro_id)
		            ->where('COD_EMPRESA', '=', Session::get('empresas')->COD_EMPR)
		            ->where('SERIE', '=', $serie)
		            ->select(DB::raw('max(NUMERO) as numero'))
		            ->orderBy('NUMERO','desc')
		            ->first();

		//conversion a string y suma uno para el siguiente id
		$idsuma = (int) $dserie->numero + 1;
		//concatenar con ceros
		$idopcioncompleta = str_pad($idsuma, 10, "0", STR_PAD_LEFT);
		$idopcioncompleta = $idopcioncompleta;
		return $idopcioncompleta;

    }


    public function gn_serie($anio, $mes,$centro_id)
    {

    	$serie   = '';
        $dserie  = PlaSerie::where('activo', '=', 1)
		            ->where('COD_CENTRO', '=', $centro_id)
		            ->where('COD_EMPRESA', '=', Session::get('empresas')->COD_EMPR)
		            ->first();
		if(count($dserie)>0){
    		$serie   = $dserie->SERIE;
		}
        return $serie;
    }

    public function gn_combo_periodo_xempresa( $cod_empresa, $todo, $titulo)
    {
        $array = CONPeriodo::where('COD_ESTADO', '=', 1)
            ->where('COD_EMPR', '=', $cod_empresa)
            ->orderBy('TXT_CODIGO', 'DESC')
            ->pluck('TXT_CODIGO', 'COD_PERIODO')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;


    }


    public function gn_combo_periodo_xanio_xempresa($anio, $cod_empresa, $todo, $titulo)
    {
        $array = CONPeriodo::where('COD_ESTADO', '=', 1)
            ->where('COD_ANIO', '=', $anio)
            ->where('COD_EMPR', '=', $cod_empresa)
            ->orderBy('COD_MES', 'DESC')
            ->pluck('TXT_NOMBRE', 'COD_PERIODO')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;


    }

    public function gn_combo_usuarios()
    {

        $array = User::where('activo', '=', 1)
            ->where('id', '<>', '1CIX00000001')
            ->where('rol_id', '<>', '1CIX00000024')
            ->orderBy('nombre', 'asc')
            ->pluck('nombre', 'id')
            ->toArray();
        $combo = array('' => 'Seleccione quien autorizara') + $array;
        return $combo;
    }

    public function gn_combo_usuarios_id($usuario_id)
    {

        $array = User::where('activo', '=', 1)
            ->where('id', '<>', '1CIX00000001')
            ->where('id', '=', $usuario_id)
            ->where('rol_id', '<>', '1CIX00000024')
            ->orderBy('nombre', 'asc')
            ->pluck('nombre', 'id')
            ->toArray();
        $combo = array('' => 'Seleccione quien autorizara') + $array;
        return $combo;
    }


    public function gn_combo_arendir_restante()
    {

		$liquidaciones = DB::table('LQG_LIQUIDACION_GASTO')
					    ->where('ACTIVO', 1)
					    ->where('COD_ESTADO', '<>', 'ETM0000000000006')
					    ->where('USUARIO_CREA', Session::get('usuario')->id)
			            ->pluck('ARENDIR_ID')
			            ->toArray();

        $array    = 	DB::table('WEB.VALE_RENDIR')
        				->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                		->where('COD_USUARIO_CREA_AUD', Session::get('usuario')->id)
                		->where('COD_CATEGORIA_ESTADO_VALE', 'ETM0000000000007')
                		->whereNotIn('ID', $liquidaciones)
					    ->select(
					        'ID',
					        DB::raw("ID_OSIRIS + ' - ' + CAST(CAN_TOTAL_IMPORTE AS VARCHAR) AS MONTO")
					    )
			            ->orderBy('ID', 'asc')
			            ->pluck('MONTO', 'ID')
			            ->toArray();

        $combo = array('' => 'Seleccione un arendir') + $array;
        return $combo;
    }

    public function gn_combo_arendir()
    {

        $array    = 	DB::table('WEB.VALE_RENDIR')
        				->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                		->where('COD_USUARIO_CREA_AUD', Session::get('usuario')->id)
                		->where('COD_CATEGORIA_ESTADO_VALE', 'ETM0000000000007')
					    ->select(
					        'ID',
					        DB::raw("ID_OSIRIS + ' - ' + CAST(CAN_TOTAL_IMPORTE AS VARCHAR) AS MONTO")
					    )
			            ->orderBy('ID', 'asc')
			            ->pluck('MONTO', 'ID')
			            ->toArray();

        $combo = array('' => 'Seleccione un arendir') + $array;
        return $combo;
    }

    public function gn_arendir_top()
    {

    	$arendir_id = '';
        $vale    = 	DB::table('WEB.VALE_RENDIR')
        				->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
                		->where('COD_USUARIO_CREA_AUD', Session::get('usuario')->id)
                		->where('COD_CATEGORIA_ESTADO_VALE', 'ETM0000000000007')
			            ->first();

		if(count($vale)>0){
    		$arendir_id = $vale->ID;
		}

        return $arendir_id;
    }



    public function gn_direccion_fiscal()
    {
		$direccion = DB::table('STD.EMPRESA as EMP')
		    ->join('STD.EMPRESA_DIRECCION as EMD', 'EMP.COD_EMPR', '=', 'EMD.COD_EMPR')
		    ->leftJoin('CMP.CATEGORIA as DEP', 'EMD.COD_DEPARTAMENTO', '=', 'DEP.COD_CATEGORIA')
		    ->leftJoin('CMP.CATEGORIA as PRO', 'EMD.COD_PROVINCIA', '=', 'PRO.COD_CATEGORIA')
		    ->leftJoin('CMP.CATEGORIA as DIS', 'EMD.COD_DISTRITO', '=', 'DIS.COD_CATEGORIA')
		    ->where('EMP.COD_EMPR', '=', Session::get('empresas')->COD_EMPR)
		    ->where(function($query) {
		        $query->where('EMD.COD_ESTABLECIMIENTO_SUNAT', '<>', '')
		              ->orWhere('EMD.IND_DIRECCION_FISCAL', '=', 1);
		    })
		    ->where('EMD.IND_DIRECCION_FISCAL', '=', 1)
		    ->where('EMD.COD_ESTADO', '=', 1)
		    ->select(
		        'EMD.COD_DIRECCION',
		        DB::raw("EMD.NOM_DIRECCION + ' - ' + DEP.NOM_CATEGORIA + ' - ' + PRO.NOM_CATEGORIA + ' - ' + DIS.NOM_CATEGORIA AS DIRECCION"),
		        'EMD.IND_DIRECCION_FISCAL'
		    )
		    ->first();
        return $direccion;
    }


    public function gn_periodo_actual_xanio_xempresa($anio, $mes, $cod_empresa)
    {


        $periodo = CONPeriodo::where('COD_ESTADO', '=', 1)
            ->where('COD_ANIO', '=', $anio)
            ->where('COD_MES', '=', $mes)
            ->where('COD_EMPR', '=', $cod_empresa)
            ->first();


        return $periodo;


    }



	private function buscar_archivo_sunat_local($urlxml) {

		$url = '';
		if (file_exists($urlxml)) {
		    $url = $urlxml;
		} else {
		    $url = '';
		}
	 	return  $url;

	}

	private function buscar_archivo_sunat_td($urlxml) {

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $urlxml,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: ITMRCONSRUCSESSION=6kQkyY2K12JgySwpdyFvyvXlQGTb2tGwqv5cmkbbTTD2h8hXQ0nJQypQpxs1QB44WRx0hYknLNTpbRTRm16th1bykQPlPyGhLxMQ4yyKnfwdfv7yqty8J2HzJBzBrydVP6kvGTsNNyNFF2pM1kcXN7X0RF7cBQfLlT1TpDjfM5ncB1FJBdfsBrWrJD1Tpgsfy8G0JydRnyyy5Qp3nPNLrpNSLJ8c2n9QTHpNpXPTCnX4vSQq2yMjG2vNGGVGnWJv!637287358!-336427344; TS01fda901=014dc399cb02c7e99dabe548e899a665fcfab9f294b2d2b8c00d75f74ce28e127857a7d560ff80f24bf801a58569542299cd5ae803ddffbd003798123ef9e33a4f9ede5c78'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	 	return  $response;

	}


	private function buscar_ruc_sunat_lg($urlxml) {
		
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
	 	return  $response;

	}




	private function buscar_archivo_sunat_lg_indicador($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO,$IND) {

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
				'mensaje' => 'Hubo un problema de sunat buscar nuevamente'
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



	private function buscar_archivo_sunat_lg($urlxml,$fetoken,$pathFiles,$prefijocarperta,$ID_DOCUMENTO) {

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
				'mensaje' => 'Hubo un problema de sunat buscar nuevamente'
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
			        // Obtener el primer archivo dentro del ZIP (puedes adaptarlo si hay más)
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


	private function buscar_archivo_sunat($urlxml,$fetoken) {

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
				'mensaje' => 'Hubo un problema de sunat buscar nuevamente'
			];
		}else{
	        $fileName = $response_array['nomArchivo'];
	        $base64File = $response_array['valArchivo'];
			$array_nombre_archivo = [
				'cod_error' => 0,
				'nombre_archivo' => $response_array['nomArchivo'],
				'mensaje' => 'encontrado con exito'
			];
	        $fileData = base64_decode($base64File);
	        $filePath = storage_path('app/sunat/' . $fileName); // Reemplaza 'app/public/' con tu ruta deseada dentro del almacenamiento
			File::put($filePath, $fileData);
		}

	 	return  $array_nombre_archivo;

	}


	private function buscar_archivo_sunat_compra_sire($urlxml,$fetoken) {

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
			   'Authorization: Bearer '.$fetoken->TOKEN,
			   'Cookie: TS012c881c=019edc9eb884f3c173126afd7e374f7b898ce93149f5bce8305ea2963908fce398ac58444d0515e03eda2d885198343181ec82ed38'
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response_array = json_decode($response, true);


	 	return  $response_array;

	}



	private function buscar_archivo_sunat_compra($urlxml,$fetoken) {

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
		    'Authorization: Bearer '.$fetoken->TOKEN
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response_array = json_decode($response, true);


	 	return  $response_array;

	}



	private function gn_combo_categoria_array($titulo,$todo,$array) {

		$array_t 					= 	DB::table('CMP.CATEGORIA')
        								->whereIn('COD_CATEGORIA', $array)
		        						->pluck('NOM_CATEGORIA','COD_CATEGORIA')
										->toArray();
		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array_t;
		}else{
			$combo  				= 	array('' => $titulo) + $array_t;
		}
	 	return  $combo;					 			
	}


	private function gn_combo_centro($titulo,$todo) {

		$array_t 					= 	DB::table('ALM.CENTRO')
										->where('COD_ESTADO','=','1')
		        						->pluck('NOM_CENTRO','COD_CENTRO')
										->toArray();
		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array_t;
		}else{
			$combo  				= 	array('' => $titulo) + $array_t;
		}
	 	return  $combo;					 			
	}



	public function ge_linea_documento($orden_id)
	{
		$item = 1;

		$fedocumento = FeDocumento::where('ID_DOCUMENTO','=',$orden_id)->get();

		if(count($fedocumento)>0){
			$item = count($fedocumento)+1;
		}

		return $item;
	}


	public function ge_validarArchivoDuplicado($nombrearchivo,$registrodestino_id)
	{
		$valor = true;
		$larchivos = Archivo::where('referencia_id','=',$registrodestino_id)->where('activo',1)->get();
		foreach ($larchivos as $key => $archivo) {
			if($nombrearchivo==$archivo->nombre_archivo){
				$valor=false;
				break;
			}
		}
		return $valor;
	}

	public function getIdEstado($descripcion)
	{
		$id = ($descripcion!=='') ? Categoria::where('tipo_categoria','ESTADO_GENERAL')->where('descripcion',$descripcion)->first()->id:'';
		return $id;
	}
	public function getIdTipoMovimiento($descripcion)
	{
		$id = ($descripcion!=='') ? Categoria::where('tipo_categoria','TIPO_MOVIMIENTO')->where('descripcion',$descripcion)->first()->id:'';
		return $id;
	}
	public function getIdCompraVenta($descripcion)
	{
		$id = ($descripcion!=='') ? Categoria::where('tipo_categoria','COMPRAVENTA')->where('descripcion',$descripcion)->first()->id:'';
		return $id;
	}
	public function getIdMotivoDocumento($descripcion)
	{
		$id = ($descripcion!=='') ? Categoria::where('tipo_categoria','MOTIVO_DOCUMENTO')->where('descripcion',$descripcion)->first()->id:'';
		return $id;
	}
	public function getIdTipoCompra($descripcion)
	{
		$id = ($descripcion!=='') ? Categoria::where('tipo_categoria','TIPO_COMPRA')->where('descripcion',$descripcion)->first()->id:'';
		return $id;
	}	


	public function ge_validarSizeArchivos($files,$arr_archivos,$lote,$limite,$unidad)
	{
		$sw 			= 	true;
		$sizerestante 	=	0;
		$sizefileslote  = 	(float)DB::table('archivos')
								->where('activo','=',1)
								->where('lote','=',$lote)
								->sum('size'); ///en bytes  //1024^2 para ser megas
		$sizefiles = 0;
		foreach($files as $file){
			$nombreoriginal 			= $file->getClientOriginalName();
			if(in_array($nombreoriginal,$arr_archivos)){
				$sizefiles = $sizefiles + filesize($file);
			}
		}

		if($limite>=($sizefileslote + $sizefiles))
		{
			//no supera el limite
			$sw=false;
			$sizerestante = $limite -  ($sizefileslote + $sizefiles);
		}
		// $sizeusado = $sizefiles + $sizefileslote;
		$sizeusado = $sizefileslote;

		$sizefiles 		= round(($sizefiles/pow(1024,$unidad)),2);
		$sizeusado 		= round(($sizeusado/pow(1024,$unidad)),2);
		$sizerestante 	= round(($sizerestante/pow(1024,$unidad)),2);
		$sizefileslote 	= round(($sizefileslote/pow(1024,$unidad)),2);
		$limitesize 	= round(($limite/pow(1024,$unidad)),2);
		 
		// dd(compact('sw','sizefiles','sizefileslote','sizeusado','sizerestante','limitesize'));
		return compact('sw','sizefiles','sizefileslote','sizeusado','sizerestante','limitesize');
	}
    public function ge_isUsuarioAdmin()
    {
        $valor=false;
        if(Session::get('usuario')->id=='1CIX00000001'){
            $valor=true;
        }
        return $valor;
    }

    public function mostrarValor($dato)
    {
        if($this->ge_isUsuarioAdmin()){
            dd($dato);
        }
    }
	public function ge_getMensajeError($error,$sw=true)
	{
		$mensaje = ($sw==true)?'Ocurrio un error Inesperado':'';
        if($this->ge_isUsuarioAdmin()){
            if(isset($error)){
                $mensaje=$mensaje.': '.$error;
            }
        }
        return $mensaje;
	}

	public function ge_crearCarpetaSiNoExiste($ruta){
		$valor = false;
		
		if (!file_exists($ruta)) {
		    mkdir($ruta, 0777, true);
		    $valor=true;
		}
		return $valor;
	}

	private function gn_combo_departamentos()
	{
		$datos =	[];
		$datos = 	DB::table('departamentos')
						->where('activo',1)
						->pluck('descripcion','id')
						->toArray();
		return [''=>'SELECCIONE DEPARTAMENTO']+$datos;
	}

	private function gn_generacion_combo_tabla($tabla,$atributo1,$atributo2,$titulo,$todo,$tipoestado) {
		
		$array 							= 	DB::table($tabla)
        									->where('activo','=',1)
        									->where('tipoestado','=',$tipoestado)

		        							->pluck($atributo2,$atributo1)
											->toArray();
		if($titulo==''){
			$combo  					= 	$array;
		}else{
			if($todo=='TODO'){
				$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
			}else{
				$combo  				= 	array('' => $titulo) + $array;
			}
		}

	 	return  $combo;					 			
	}


	private function gn_generacion_combo_tabla_not_array($tabla,$atributo1,$atributo2,$titulo,$todo,$tipoestado,$array) {
		
		$array 							= 	DB::table($tabla)
        									->where('activo','=',1)
        									->whereNotIn('id',$array)
        									->where('tipoestado','=',$tipoestado)
		        							->pluck($atributo2,$atributo1)
											->toArray();
		if($titulo==''){
			$combo  					= 	$array;
		}else{
			if($todo=='TODO'){
				$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
			}else{
				$combo  				= 	array('' => $titulo) + $array;
			}
		}

	 	return  $combo;					 			
	}


	private function gn_generacion_estados_sobrantes($tabla,$atributo1,$atributo2,$titulo,$todo,$tipoestado) {
		
		$periodo_array 					=   Conei::where('institucion_id','=',Session::get('usuario')->institucion_id)
			    							->where('periodo_id','<>','ESRE00000003')
											->pluck('periodo_id')
											->toArray();

		$array 							= 	DB::table($tabla)
											->whereNotIn('id',$periodo_array)
        									->where('activo','=',1)
        									->where('tipoestado','=',$tipoestado)
		        							->pluck($atributo2,$atributo1)
											->toArray();
		if($titulo==''){
			$combo  					= 	$array;
		}else{
			if($todo=='TODO'){
				$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
			}else{
				$combo  				= 	array('' => $titulo) + $array;
			}
		}

	 	return  $combo;					 			
	}


	private function gn_combo_provincias($departamento_id)
	{
		$datos =	[];
		$datos = 	DB::table('provincias')
						->where('departamento_id','=',$departamento_id)
						->where('activo',1)
						->pluck('descripcion','id')
						->toArray();
		return [''=>'SELECCIONE PROVINCIA']+$datos;
	}

	private function gn_combo_distritos($provincia_id)
	{
		$datos =	[];
		$datos = 	DB::table('distritos')
						->where('provincia_id','=',$provincia_id)
						->where('activo',1)
						->pluck('descripcion','id')
						->toArray();
		return [''=>'SELECCIONE DISTRITO']+$datos;
	}

	private function gn_combo_categoria($tipocategoria,$titulo,$todo) {
		$array 						= 	DB::table('categorias')
        								->where('activo','=',1)
        								->where('tipo_categoria','=',$tipocategoria)
		        						->pluck('descripcion','id')
										->toArray();
		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
		}else{
			$combo  				= 	array('' => $titulo) + $array;
		}
	 	return  $combo;					 			
	}

	private function gn_combo_estadoscompras($titulo,$todo) {
		$array 						= 	DB::table('categorias')
        								->where('activo','=',1)
        								->where('tipo_categoria','=','ESTADO_GENERAL')
        								->whereIn('descripcion', ['GENERADO','EMITIDO','EXTORNADO'])
		        						->pluck('descripcion','id')
										->toArray();
		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
		}else{
			$combo  				= 	array('' => $titulo) + $array;
		}
	 	return  $combo;					 			
	}

	private function gn_generacion_combo_array($titulo, $todo , $array)
	{
		if($todo=='TODO'){
			$combo_anio_pc  		= 	array('' => $titulo , $todo => $todo) + $array;
		}else{
			$combo_anio_pc  		= 	array('' => $titulo) + $array;
		}
	    return $combo_anio_pc;
	}

	private function gn_generacion_combo($tabla,$atributo1,$atributo2,$titulo,$todo) {
		
		$array 						= 	DB::table($tabla)
        								->where('activo','=',1)
		        						->pluck($atributo2,$atributo1)
										->toArray();

		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
		}else{
			$combo  				= 	array('' => $titulo) + $array;
		}

	 	return  $combo;					 			
	}

	private function gn_generacion_combo_tabla_osiris($tabla,$atributo1,$atributo2,$titulo,$todo) {
		
		$array 							= 	DB::table($tabla)
        									->where('COD_ESTADO','=',1)
		        							->pluck($atributo2,$atributo1)
											->toArray();
		if($titulo==''){
			$combo  					= 	$array;
		}else{
			if($todo=='TODO'){
				$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
			}else{
				$combo  				= 	array('' => $titulo) + $array;
			}
		}

	 	return  $combo;					 			
	}


	private function gn_generacion_combo_direccion($txt_grupo,$titulo,$todo,$id) {
		
		$array 						= 	DB::table('CMP.CATEGORIA')
        								->where('COD_ESTADO','=',1)
        								->where('TXT_GRUPO','=',$txt_grupo)
        								->where('COD_CATEGORIA_SUP','=',$id)
		        						->pluck('NOM_CATEGORIA','COD_CATEGORIA')
										->toArray();

		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
		}else{
			$combo  				= 	array('' => $titulo) + $array;
		}

	 	return  $combo;					 			
	}



	private function gn_generacion_combo_categoria_xid($txt_grupo,$titulo,$todo,$id) {
		
		$array 						= 	DB::table('CMP.CATEGORIA')
        								->where('COD_ESTADO','=',1)
        								->where('TXT_GRUPO','=',$txt_grupo)
        								->where('COD_CATEGORIA_SUP','=',$id)
		        						->pluck('NOM_CATEGORIA','COD_CATEGORIA')
										->toArray();

		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
		}else{
			$combo  				= 	array('' => $titulo) + $array;
		}

	 	return  $combo;					 			
	}


	private function gn_generacion_combo_direccion_lg($titulo,$todo) {
		
		$array = DB::table('STD.EMPRESA as EMP')
		    ->join('STD.EMPRESA_DIRECCION as EMD', 'EMP.COD_EMPR', '=', 'EMD.COD_EMPR')
		    ->leftJoin('CMP.CATEGORIA as DEP', 'EMD.COD_DEPARTAMENTO', '=', 'DEP.COD_CATEGORIA')
		    ->leftJoin('CMP.CATEGORIA as PRO', 'EMD.COD_PROVINCIA', '=', 'PRO.COD_CATEGORIA')
		    ->leftJoin('CMP.CATEGORIA as DIS', 'EMD.COD_DISTRITO', '=', 'DIS.COD_CATEGORIA')
		    ->where('EMP.COD_EMPR', Session::get('empresas')->COD_EMPR)
		    ->where('EMD.COD_ESTADO', 1)
		    ->where(function ($query) {
		        $query->where('EMD.COD_ESTABLECIMIENTO_SUNAT', '<>', '')
		              ->orWhere('EMD.IND_DIRECCION_FISCAL', 1);
		    })
		    ->select(
		        'EMD.COD_DIRECCION',
		        DB::raw("EMD.NOM_DIRECCION + ' - ' + DEP.NOM_CATEGORIA + ' - ' + PRO.NOM_CATEGORIA + ' - ' + DIS.NOM_CATEGORIA AS DIRECCION")
		    )
			->pluck('DIRECCION','COD_DIRECCION')
			->toArray();

		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
		}else{
			$combo  				= 	array('' => $titulo) + $array;
		}

	 	return  $combo;					 			
	}


	private function gn_generacion_combo_direccion_lg_top($direcion_id) {

		$direccion = DB::table('STD.EMPRESA as EMP')
		    ->join('STD.EMPRESA_DIRECCION as EMD', 'EMP.COD_EMPR', '=', 'EMD.COD_EMPR')
		    ->leftJoin('CMP.CATEGORIA as DEP', 'EMD.COD_DEPARTAMENTO', '=', 'DEP.COD_CATEGORIA')
		    ->leftJoin('CMP.CATEGORIA as PRO', 'EMD.COD_PROVINCIA', '=', 'PRO.COD_CATEGORIA')
		    ->leftJoin('CMP.CATEGORIA as DIS', 'EMD.COD_DISTRITO', '=', 'DIS.COD_CATEGORIA')
		    ->where('EMP.COD_EMPR', Session::get('empresas')->COD_EMPR)
		    ->where('EMD.COD_DIRECCION', $direcion_id)
		    ->where('EMD.COD_ESTADO', 1)
		    ->where(function ($query) {
		        $query->where('EMD.COD_ESTABLECIMIENTO_SUNAT', '<>', '')
		              ->orWhere('EMD.IND_DIRECCION_FISCAL', 1);
		    })
		    ->select(
		        'EMD.COD_DIRECCION',
		        DB::raw("EMD.NOM_DIRECCION + ' - ' + DEP.NOM_CATEGORIA + ' - ' + PRO.NOM_CATEGORIA + ' - ' + DIS.NOM_CATEGORIA AS DIRECCION")
		    )
			->first();
			
	 	return  $direccion;					 			
	}




	private function gn_generacion_combo_categoria($txt_grupo,$titulo,$todo) {
		
		$array 						= 	DB::table('CMP.CATEGORIA')
        								->where('COD_ESTADO','=',1)
        								->where('TXT_GRUPO','=',$txt_grupo)
		        						->pluck('NOM_CATEGORIA','COD_CATEGORIA')
										->toArray();

		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
		}else{
			$combo  				= 	array('' => $titulo) + $array;
		}

	 	return  $combo;					 			
	}





	public function gn_background_fila_activo($activo)
	{
		$background =	'';
		if($activo == 0){
			$background = 'fila-desactivada';
		}
	    return $background;
	}


	public function gn_combo_tipo_cliente()
	{
		$combo  	= 	array('' => 'Seleccione tipo de cliente' , '0' => 'Tercero', '1' => 'Relacionada');
	    return $combo;
	}

	public function rp_generacion_combo_resultado_control($titulo)
	{
		$combo  	= 	array('' => $titulo , '1' => 'Nueva Cita', '2' => 'Resultado');
	    return $combo;
	}

	public function rp_sexo_paciente($sexo_letra)
	{
		$sexo = 'Femenino';
		if($sexo_letra == 'M'){
			$sexo = 'Maculino';
		}
	    return $sexo;
	}	

	public function rp_tipo_cita($ind_tipo_cita)
	{
		$tipo_cita = 'Nueva Cita';
		if($ind_tipo_cita == 2){
			$tipo_cita = 'Resultado';
		}
	    return $tipo_cita;
	}	
	public function rp_estado_control($ind_atendido)
	{
		$estado = 'Atendido';
		if($ind_atendido == 0){
			$estado = 'Sin atender';
		}
	    return $estado;
	}	


	private function gn_generacion_combo_productos($titulo,$todo)
	{


		$array 						= 	ALMProducto::where('COD_ESTADO','=',1)
										->whereIn('IND_MATERIAL_SERVICIO', ['M','S'])
		        						->pluck('NOM_PRODUCTO','COD_PRODUCTO')
		        						->take(10)
										->toArray();

		if($todo=='TODO'){
			$combo  				= 	array('' => $titulo , $todo => $todo) + $array;
		}else{
			$combo  				= 	array('' => $titulo) + $array;
		}

	 	return  $combo;	
	}


}