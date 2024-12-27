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

	private function scrapear_tottus($supermercado) {

// Ruta para almacenar cookies temporalmente
$cookieFile = __DIR__ . '/cookies.txt';

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://tottus.falabella.com.pe/tottus-pe/category/CATG14739/Arroz',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
    CURLOPT_COOKIEFILE => $cookieFile, // Archivo para leer cookies
    CURLOPT_COOKIEJAR => $cookieFile, // Archivo para guardar cookies
));

$response = curl_exec($curl);

// if (curl_errno($curl)) {
//     echo 'Error: ' . curl_error($curl);
// } else {
//     echo $response;
// }

curl_close($curl);
		// Cargar el HTML en DOMDocument
		dd($response);

		$array_data 	= json_decode($html,true);
		//primera pagina
		foreach ($array_data['data']['productSearch']['products'] as $product) {
			if (strpos($product['productName'], 'Pack') === false) {
				// Convertir el resultado en una cadena
				$marca = strtoupper($product['brand']);
				if($marca==''){
					$marca = 'GENERICO';
				}
				$precio = $product['priceRange']['sellingPrice']['highPrice'];
				// Dividir la cadena por espacios
				preg_match('/(\d+)\s*(kg|g)/i', $product['productName'], $matches);
				//preg_match('/(\d+)(\D+)/', $ump, $matches);
				// Obtener el valor numérico y el texto
				$peso = 0; // 5
				$unidad = ''; // kg
				if(isset($matches[1])){
					$peso = $matches[1]; // 5
				}
				if(isset($matches[2])){
					$unidad = $matches[2]; // kg
				}
	            $tabla                       	=   new SuperPrecio;
	            $tabla->MARCA         	 		=   $marca;
	            $tabla->SUPERMERCADO      		=   $supermercado;
	            $tabla->FECHA      	     		=   date('Ymd');
	            $tabla->FECHA_TIME        		=   date('Ymd h:i:s');
	            $tabla->NOMBRE_PRODUCTO   		=   $product['productName'];
	            $tabla->DESCRIPCION_PRODUCTO 	=   '';
	            $tabla->PRECIO            		=   (float)$precio;
	            $tabla->UNIDAD_MEDIDA     		=   $unidad;
	            $tabla->PESO        		 	=   (float)$peso;
	            $tabla->save();

        	}
		}

	}

	private function scrapear_metro($supermercado) {

		$url = "https://www.metro.pe/_v/segment/graphql/v1?workspace=master&maxAge=short&appsEtag=remove&domain=store&locale=es-PE&__bindingId=893de73e-7d5d-4f4e-9c7a-a32f1b2d77cb&operationName=productSearchV3&variables=%7B%7D&extensions=%7B%22persistedQuery%22%3A%7B%22version%22%3A1%2C%22sha256Hash%22%3A%229177ba6f883473505dc99fcf2b679a6e270af6320a157f0798b92efeab98d5d3%22%2C%22sender%22%3A%22vtex.store-resources%400.x%22%2C%22provider%22%3A%22vtex.search-graphql%400.x%22%7D%2C%22variables%22%3A%22eyJoaWRlVW5hdmFpbGFibGVJdGVtcyI6dHJ1ZSwic2t1c0ZpbHRlciI6IkFMTCIsInNpbXVsYXRpb25CZWhhdmlvciI6ImRlZmF1bHQiLCJpbnN0YWxsbWVudENyaXRlcmlhIjoiTUFYX1dJVEhPVVRfSU5URVJFU1QiLCJwcm9kdWN0T3JpZ2luVnRleCI6ZmFsc2UsIm1hcCI6ImMsYyIsInF1ZXJ5IjoiYWJhcnJvdGVzL2Fycm96Iiwib3JkZXJCeSI6Ik9yZGVyQnlTY29yZURFU0MiLCJmcm9tIjowLCJ0byI6NTksInNlbGVjdGVkRmFjZXRzIjpbeyJrZXkiOiJjIiwidmFsdWUiOiJhYmFycm90ZXMifSx7ImtleSI6ImMiLCJ2YWx1ZSI6ImFycm96In1dLCJvcGVyYXRvciI6ImFuZCIsImZ1enp5IjoiMCIsInNlYXJjaFN0YXRlIjpudWxsLCJmYWNldHNCZWhhdmlvciI6IlN0YXRpYyIsImNhdGVnb3J5VHJlZUJlaGF2aW9yIjoiZGVmYXVsdCIsIndpdGhGYWNldHMiOmZhbHNlLCJhZHZlcnRpc2VtZW50T3B0aW9ucyI6eyJzaG93U3BvbnNvcmVkIjp0cnVlLCJzcG9uc29yZWRDb3VudCI6MywiYWR2ZXJ0aXNlbWVudFBsYWNlbWVudCI6InRvcF9zZWFyY2giLCJyZXBlYXRTcG9uc29yZWRQcm9kdWN0cyI6dHJ1ZX19%22%7D";
		// Inicializar cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// Ejecutar la solicitud
		$html = curl_exec($ch);
		curl_close($ch);
		// Cargar el HTML en DOMDocument
		$array_data 	= json_decode($html,true);
		//primera pagina
		foreach ($array_data['data']['productSearch']['products'] as $product) {
			if (strpos($product['productName'], 'Pack') === false) {
				// Convertir el resultado en una cadena
				$marca = strtoupper($product['brand']);
				if($marca==''){
					$marca = 'GENERICO';
				}
				$precio = $product['priceRange']['sellingPrice']['highPrice'];
				// Dividir la cadena por espacios
				preg_match('/(\d+)\s*(kg|g)/i', $product['productName'], $matches);
				//preg_match('/(\d+)(\D+)/', $ump, $matches);
				// Obtener el valor numérico y el texto
				$peso = 0; // 5
				$unidad = ''; // kg
				if(isset($matches[1])){
					$peso = $matches[1]; // 5
				}
				if(isset($matches[2])){
					$unidad = $matches[2]; // kg
				}
	            $tabla                       	=   new SuperPrecio;
	            $tabla->MARCA         	 		=   $marca;
	            $tabla->SUPERMERCADO      		=   $supermercado;
	            $tabla->FECHA      	     		=   date('Ymd');
	            $tabla->FECHA_TIME        		=   date('Ymd h:i:s');
	            $tabla->NOMBRE_PRODUCTO   		=   $product['productName'];
	            $tabla->DESCRIPCION_PRODUCTO 	=   '';
	            $tabla->PRECIO            		=   (float)$precio;
	            $tabla->UNIDAD_MEDIDA     		=   $unidad;
	            $tabla->PESO        		 	=   (float)$peso;
	            $tabla->save();

        	}
		}
		//segunda pagina
		$url = "https://www.metro.pe/_v/segment/graphql/v1?workspace=master&maxAge=short&appsEtag=remove&domain=store&locale=es-PE&__bindingId=893de73e-7d5d-4f4e-9c7a-a32f1b2d77cb&operationName=productSearchV3&variables=%7B%7D&extensions=%7B%22persistedQuery%22%3A%7B%22version%22%3A1%2C%22sha256Hash%22%3A%229177ba6f883473505dc99fcf2b679a6e270af6320a157f0798b92efeab98d5d3%22%2C%22sender%22%3A%22vtex.store-resources%400.x%22%2C%22provider%22%3A%22vtex.search-graphql%400.x%22%7D%2C%22variables%22%3A%22eyJoaWRlVW5hdmFpbGFibGVJdGVtcyI6dHJ1ZSwic2t1c0ZpbHRlciI6IkFMTCIsInNpbXVsYXRpb25CZWhhdmlvciI6ImRlZmF1bHQiLCJpbnN0YWxsbWVudENyaXRlcmlhIjoiTUFYX1dJVEhPVVRfSU5URVJFU1QiLCJwcm9kdWN0T3JpZ2luVnRleCI6ZmFsc2UsIm1hcCI6ImMsYyIsInF1ZXJ5IjoiYWJhcnJvdGVzL2Fycm96Iiwib3JkZXJCeSI6Ik9yZGVyQnlTY29yZURFU0MiLCJmcm9tIjo2MCwidG8iOjExOSwic2VsZWN0ZWRGYWNldHMiOlt7ImtleSI6ImMiLCJ2YWx1ZSI6ImFiYXJyb3RlcyJ9LHsia2V5IjoiYyIsInZhbHVlIjoiYXJyb3oifV0sIm9wZXJhdG9yIjoiYW5kIiwiZnV6enkiOiIwIiwic2VhcmNoU3RhdGUiOm51bGwsImZhY2V0c0JlaGF2aW9yIjoiU3RhdGljIiwiY2F0ZWdvcnlUcmVlQmVoYXZpb3IiOiJkZWZhdWx0Iiwid2l0aEZhY2V0cyI6ZmFsc2UsImFkdmVydGlzZW1lbnRPcHRpb25zIjp7InNob3dTcG9uc29yZWQiOnRydWUsInNwb25zb3JlZENvdW50IjozLCJhZHZlcnRpc2VtZW50UGxhY2VtZW50IjoidG9wX3NlYXJjaCIsInJlcGVhdFNwb25zb3JlZFByb2R1Y3RzIjp0cnVlfX0%3D%22%7D";
				// Inicializar cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// Ejecutar la solicitud
		$html = curl_exec($ch);
		curl_close($ch);
		// Cargar el HTML en DOMDocument
		$array_data 	= json_decode($html,true);

		//dd($array_data);

		//primera pagina
		foreach ($array_data['data']['productSearch']['products'] as $product) {
			if (strpos($product['productName'], 'Pack') === false) {
				// Convertir el resultado en una cadena
				$marca = strtoupper($product['brand']);
				if($marca==''){
					$marca = 'GENERICO';
				}
				$precio = $product['priceRange']['sellingPrice']['highPrice'];
				// Dividir la cadena por espacios
				preg_match('/(\d+)\s*(kg|g)/i', $product['productName'], $matches);
				//preg_match('/(\d+)(\D+)/', $ump, $matches);
				// Obtener el valor numérico y el texto
				$peso = 0; // 5
				$unidad = ''; // kg
				if(isset($matches[1])){
					$peso = $matches[1]; // 5
				}
				if(isset($matches[2])){
					$unidad = $matches[2]; // kg
				}
	            $tabla                       	=   new SuperPrecio;
	            $tabla->MARCA         	 		=   $marca;
	            $tabla->SUPERMERCADO      		=   $supermercado;
	            $tabla->FECHA      	     		=   date('Ymd');
	            $tabla->FECHA_TIME        		=   date('Ymd h:i:s');
	            $tabla->NOMBRE_PRODUCTO   		=   $product['productName'];
	            $tabla->DESCRIPCION_PRODUCTO 	=   '';
	            $tabla->PRECIO            		=   (float)$precio;
	            $tabla->UNIDAD_MEDIDA     		=   $unidad;
	            $tabla->PESO        		 	=   (float)$peso;
	            $tabla->save();

        	}
		}
	}
	private function scrapear_plazavea($supermercado) {

		$url = "https://www.plazavea.com.pe/api/catalog_system/pub/products/search?fq=C:/431/432/&_from=0&_to=49&O=OrderByScoreDESC&";
		// Inicializar cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// Ejecutar la solicitud
		$html = curl_exec($ch);
		curl_close($ch);
		// Cargar el HTML en DOMDocument
		$array_data 	= json_decode($html,true);
		foreach ($array_data as $product) {
			// Extraer solo las letras mayúsculas
			preg_match_all('/\b[A-Z]+\b/', $product['productName'], $mayusculas);
			// Convertir el resultado en una cadena
			$marca = implode('', $mayusculas[0]);
			if($marca==''){
				$marca = 'GENERICO';
			}
			$precio = $product['items'][0]['sellers'][0]['commertialOffer']['Price'];
			// Dividir la cadena por espacios
			$ultimap = explode(' ', $product['productName']);
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
            $tabla->NOMBRE_PRODUCTO   		=   $product['productName'];
            $tabla->DESCRIPCION_PRODUCTO 	=   $product['metaTagDescription'];
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