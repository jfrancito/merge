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
use App\Modelos\SuperPrecio;


use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use DOMDocument;
use DOMXPath;

trait PrecioCompetenciaTraits
{

	private function scrapear_plazavea($supermercado) {

		$url = "https://www.plazavea.com.pe/abarrotes/arroz";
		// Inicializar cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// Ejecutar la solicitud
		$html = curl_exec($ch);
		curl_close($ch);
		// Cargar el HTML en DOMDocument
		$dom = new DOMDocument();
		libxml_use_internal_errors(true); // Evitar mostrar errores de HTML no válido
		$dom->loadHTML($html);
		libxml_clear_errors();
		$xpath = new DOMXPath($dom);

		dd($html);



		$url 	= 	'https://magicloops.dev/api/loop/90dd3c60-3bfc-4a23-abe2-77352869bf62/run?input=I+love+Magic+Loops%21';
		$json 	=  	$this->buscar_curl($url);

		foreach ($json['products'] as $product) {
			// Extraer solo las letras mayúsculas
			preg_match_all('/\b[A-Z]+\b/', $product['product_name'], $mayusculas);
			// Convertir el resultado en una cadena
			$marca = implode('', $mayusculas[0]);
			if($marca==''){
				$marca = 'GENERICO';
			}
			$cadena = $product['price'];
			// Extraer el valor numérico
			preg_match('/[\d.]+/', $cadena, $precio);
			// Dividir la cadena por espacios
			$ultimap = explode(' ', $product['product_name']);
			// Obtener el último elemento
			$ump = end($ultimap);
			preg_match('/(\d+)(\D+)/', $ump, $matches);
			// Obtener el valor numérico y el texto
			$peso = $matches[1]; // 5
			$unidad = $matches[2]; // kg

            $tabla                       	=   new SuperPrecio;
            $tabla->MARCA         	 		=   $marca;
            $tabla->SUPERMERCADO      		=   $supermercado;
            $tabla->FECHA      	     		=   date('Ymd');
            $tabla->FECHA_TIME        		=   date('Ymd h:i:s');
            $tabla->NOMBRE_PRODUCTO   		=   $product['product_name'];
            $tabla->DESCRIPCION_PRODUCTO 	=   $product['description'];
            $tabla->PRECIO            		=   (float)$precio;
            $tabla->UNIDAD_MEDIDA     		=   $unidad;
            $tabla->PESO        		 	=   (float)$peso;
            $tabla->save();
		}
	}



	public function buscar_curl($urlxml) {

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
        $response_array = json_decode($response, true);


        return  $response_array;

    }



}