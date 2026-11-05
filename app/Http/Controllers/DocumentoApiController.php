<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modelos\SuperPrecio;
use App\Modelos\FeIa;
use PDO;
use GuzzleHttp\Client;

class DocumentoApiController extends Controller {

    protected $client;



    public function actionRegexGuias(Request $request)
    {
        header('Content-Type: application/json; charset=utf-8');

        try{ 

            $nombre = ""; 
            if($request->hasFile('file')){
                $file = $request->file('file');
                $nombresolo = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = $file->getClientOriginalName();
                $filename = pathinfo($filename, PATHINFO_FILENAME);
                $nombre = $request->file->getClientOriginalName();
                $file->move(storage_path('app/public'),$nombre);
            } 
            $filePath = storage_path('app/public/'.$nombre);
            if (!file_exists($filePath)) {
                throw new Exception('El archivo no existe');
            }

            $pythonPath = "C:\\Users\\Administrador\\AppData\\Local\\Programs\\Python\\Python310\\python.exe";
            $scriptPath = "C:\\laragon\\www\\merge\\ocr.py";
            $imagePath  = "C:\\laragon\\www\\merge\\storage\\app\\public\\".$nombre;

            $command = "\"$pythonPath\" \"$scriptPath\" \"$imagePath\" 2>&1";
            $output = shell_exec($command);
            $output = trim($output, "b\"\n"); // Elimina "b" al inicio y los saltos de línea


            if ($output) {
                //print_r($output); // Muestra el texto extraído
            } else {
                throw new Exception('ERROR DE EXTRAR DATA IMG O PDF');

            }
            $output = utf8_encode($output);
            $texto  =  $output;

            // 🔹 Expresión regular para detectar la SERIE y el CORRELATIVO
            preg_match('/([A-Z0-9]{1,4})\s*-\s*(\d{6,8})/', $texto, $match);
            // 🔹 Expresión regular para el RUC (11 dígitos, con o sin "RUC N" antes)
            preg_match_all('/(10|20)\d{9}/', $texto, $rucs);
            // 🔹 Si hay más de un RUC, el remitente suele ser el primero y el destinatario el segundo
            $rucRemitente = $rucs[0][0] ?? "";
            $rucDestinatario = $rucs[0][1] ?? "";



            // 🔹 Resultado final
            $array = [
                "SERIE" => $match[1] ?? "",
                "CORRELATIVO" => $match[2] ?? "",
                "RUC_REMITENTE" => $rucRemitente
            ];
            $responsecode = 200;
            $header = array (
                'Content-Type'  => 'application/json; charset=UTF-8',
                'charset'       => 'utf-8'
            );
            $arraydata    =     array(
                                    "codigo"                    => '0001',
                                    "mensaje"                   => 'Consulta Exitosa',
                                    "data"                      =>  $array
                                    );
            return response()->json($arraydata, 
                    $responsecode, $header, JSON_UNESCAPED_UNICODE);

        }catch(\Exception $ex){
            $array_respuesta    =   array(
                "codigo"                    => '0000',
                "mensaje"                   => 'Ocurrio un error '.$ex->getMessage()
            );

            $responsecode = 401;
            $header = array (
                'Content-Type'  => 'application/json; charset=UTF-8',
                'charset'       => 'utf-8'
            );
            return response()->json($array_respuesta, $responsecode, $header, JSON_UNESCAPED_UNICODE);

        }




    }

    public function actionOpenAILecturaGuias(Request $request) {


        header('Content-Type: application/json; charset=utf-8');
        try{ 

            $feia   =   FeIa::where('COD_IA','=','0000000001')->first();

            $apiKey = $feia->CLAVE_API;
            $nombre = ""; 
            if($request->hasFile('file')){
                $file = $request->file('file');
                $nombresolo = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = $file->getClientOriginalName();
                $filename = pathinfo($filename, PATHINFO_FILENAME);
                $nombre = $request->file->getClientOriginalName();
                $file->move(storage_path('app/public'),$nombre);
            } 
            $filePath = storage_path('app/public/'.$nombre);
            if (!file_exists($filePath)) {
                throw new Exception('El archivo no existe');
            }
            // Detectar si el archivo es PDF
            if (mime_content_type($filePath) === 'application/pdf') {

                $outputPath = storage_path('app/public/'.$nombresolo.'.jpg');
                $gsPath = "C:\\Program Files\\gs\\gs10.03.1\\bin\\gswin64c.exe"; // Ajusta si es necesario
                // Comando Ghostscript corregido para generar imagen JPEG
                $gsCommand = "\"$gsPath\" -sDEVICE=jpeg -r300 -dFirstPage=1 -dLastPage=1 -o \"$outputPath\" \"$filePath\"";
                exec($gsCommand, $output, $return_var);
                if ($return_var !== 0) {
                    throw new Exception("Error al convertir el PDF. Código de salida: $return_var");
                }
                $filePath = storage_path('app/public/'.$nombresolo.'.jpg');
            }
            
            // Leer el archivo y convertirlo a base64
            $fileData = base64_encode(file_get_contents($filePath));
            $url = 'https://api.openai.com/v1/chat/completions';
            $postFields = [
                'model' => 'gpt-4-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un asistente que extrae texto de imágenes.'],
                    ['role' => 'user', 'content' => [
                    ['type' => 'text', 'text' => 'Extrae el texto de esta imagen o pdf y devuelve solo los nombres de los campos junto a sus valores, en una estructura JSON, en el siguiente formato ejemplo:  
                        {"SERIE":"F002","CORRELATIVO":"00258544","RUC":"20602740278"} DONDE TE DESCRIBO LOS CAMPOS PARA QUE TENGAS EN CONSIDERACION
                        SERIE
                        La serie es un código alfanumérico de 4 caracteres que identifica el tipo de comprobante y el establecimiento emisor.
                        Para la serie suele comenzar con una letra pero no siempre, seguida de numéricos.
                        Ejemplos: F001, B002, 0001, 0001, EG01, TG01.

                        CORRELATIVO
                        Es un número secuencial asignado al comprobante dentro de la serie.
                        Tiene una longitud variable (normalmente de 6 a 8 dígitos).
                        Debe ser único dentro de la combinación de serie y tipo de comprobante.
                        Ejemplos: 000123, 00456789.

                        RUC
                        Es un número de 11 dígitos que identifica a una empresa o persona natural con negocio en Perú.
                        Debe cumplir con la validación establecida por la SUNAT.
                        El primer dígito identifica el tipo de contribuyente (por ejemplo, los RUC de empresas suelen empezar con 10 o 20).
                        Ejemplo: 20123456789, 10456789012
                        '],
                        ['type' => 'image_url', 'image_url' => ['url' => 'data:image/png;base64,' . $fileData]] // 🔹 Corrección: Objeto con "url"
                    ]]
                ],
                'max_tokens' => 1000
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer $apiKey",
                    "Content-Type: application/json"
                ],
                CURLOPT_POSTFIELDS => json_encode($postFields)
            ]);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                throw new Exception("Error en el curl: curl_error($curl)");
            }

            curl_close($curl);
            // Decodificar JSON y extraer solo el contenido deseado
            $data = json_decode($response, true);
            $jsonContent = $data['choices'][0]['message']['content'] ?? '{}';
            $jsonContent = str_replace('```json', '', $jsonContent);
            $jsonContent = str_replace('```', '', $jsonContent);
            $datos = json_decode(trim($jsonContent), true);
            $jsonLegible = json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $array = json_decode($jsonLegible, true);


            $responsecode = 200;
            $header = array (
                'Content-Type'  => 'application/json; charset=UTF-8',
                'charset'       => 'utf-8'
            );
            
            $arraydata    =     array(
                                    "codigo"                    => '0001',
                                    "mensaje"                   => 'Consulta Exitosa',
                                    "data"                      =>  $array
                                    );


            FeIa::where('COD_IA','=','0000000001')
                        ->update(
                                [
                                    'CAN_CONSULTA' => DB::raw('CAN_CONSULTA + 1'),
                                    'FECHA_MOD'=>$this->fechaactual
                                ]);


            return response()->json($arraydata, 
                    $responsecode, $header, JSON_UNESCAPED_UNICODE);

        }catch(\Exception $ex){
            $array_respuesta    =   array(
                "codigo"                    => '0000',
                "mensaje"                   => 'Ocurrio un error '.$ex->getMessage()
            );

            $responsecode = 401;
            $header = array (
                'Content-Type'  => 'application/json; charset=UTF-8',
                'charset'       => 'utf-8'
            );
            return response()->json($array_respuesta, $responsecode, $header, JSON_UNESCAPED_UNICODE);

        }
    }





    public function actionDeepseekHuggingfaceGuias()
    {
        $pythonPath = "C:\\Users\\Usuario\\AppData\\Local\\Programs\\Python\\Python310\\python.exe";
        $scriptPath = "C:\\laragon\\www\\merge\\ocr.py";
        $imagePath  = "C:\\laragon\\www\\merge\\storage\\app\\public\\img1.jpeg";

        $command = "\"$pythonPath\" \"$scriptPath\" \"$imagePath\" 2>&1";
        $output = shell_exec($command);
        $output = trim($output, "b\"\n"); // Elimina "b" al inicio y los saltos de línea

        if ($output) {
            //print_r($output); // Muestra el texto extraído
        } else {
            echo "Error ejecutando OCR.";
        }
        $output = utf8_encode($output);
        //print_r($output);

        $contenido  =  'DE ESTE TEXTO ('.$output.') EXTRA DATA Y deseo que me devuelvas en una estructura JSON, en el siguiente formato ejemplo:  
                        {"SERIE":"F002","CORRELATIVO":"00258544","RUC":"20602740278"} DONDE TE DESCRIBO LOS CAMPOS PARA QUE TENGAS EN CONSIDERACION

                        {"SERIE": "XXXX"}  
                        **Reglas para identificar la SERIE:**  
                        - La serie es un código alfanumérico de **hasta 4 caracteres**.  
                        - Puede empezar con una **letra**, pero también puede ser solo numérico.  
                        - Se encuentra antes del **correlativo**, que es un número largo (6-8 dígitos).  
                        - Ejemplos de "T411,F001, B002, 0001, 0001, EG01, TG01". 

                        CORRELATIVO
                        Es un número secuencial asignado al comprobante dentro de la serie.
                        El CORRELATIVO no tiene 
                        Tiene una longitud variable (normalmente de 6 a 8 dígitos).
                        Debe ser único dentro de la combinación de serie y tipo de comprobante.
                        Ejemplos: 000123, 00456789.

                        RUC
                        Es un número de 11 dígitos que identifica a una empresa o persona natural con negocio en Perú.
                        Debe cumplir con la validación establecida por la SUNAT.
                        El primer dígito identifica el tipo de contribuyente (por ejemplo, los RUC de empresas suelen empezar con 10 o 20).
                        Ejemplo: 20123456789, 10456789012';

            $contenido = 'Extrae los datos en formato JSON del siguiente texto: ' . $output . ' 
            Solo responde con un JSON sin texto adicional. 
            Ejemplo de respuesta esperada: 
            {"SERIE":"T415","CORRELATIVO_R":"02518723","RUC":"20331066703"}';







            $apiKey = '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';
            $url = "https://api-inference.huggingface.co/models/mistralai/Mistral-7B-Instruct-v0.1";


            $data = [
                "inputs" => "Extrae los datos en formato JSON del siguiente texto: 
                [\"R.U.C.N°20331066703\", \"GUiA DE REMISIóN\", \"ELECTRONICA REMITENTE\", \"T411-02518723\"].
                Solo responde con un JSON sin texto adicional.",
                "parameters" => ["max_new_tokens" => 100, "temperature" => 0.1] // Ajustes para más velocidad
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $apiKey",
                "Content-Type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $response = curl_exec($ch);
            curl_close($ch);

            echo $response;

    }




    public function actionDeepseekPaddleocrGuias(Request $request) {

        $pythonPath = "C:\\Users\\Usuario\\AppData\\Local\\Programs\\Python\\Python310\\python.exe";
        $scriptPath = "C:\\laragon\\www\\merge\\ocr.py";
        $imagePath  = "C:\\laragon\\www\\merge\\storage\\app\\public\\img1.jpeg";

        $command = "\"$pythonPath\" \"$scriptPath\" \"$imagePath\" 2>&1";
        $output = shell_exec($command);
        $output = trim($output, "b\"\n"); // Elimina "b" al inicio y los saltos de línea

        if ($output) {
            //print_r($output); // Muestra el texto extraído
        } else {
            echo "Error ejecutando OCR.";
        }
        $output = utf8_encode($output);
        //print_r($output);

        $contenido  =  'DE ESTE TEXTO ('.$output.') EXTRA DATA Y deseo que me devuelvas en una estructura JSON, en el siguiente formato ejemplo:  
                        {"SERIE":"F002","CORRELATIVO":"00258544","RUC":"20602740278"} DONDE TE DESCRIBO LOS CAMPOS PARA QUE TENGAS EN CONSIDERACION

                        {"SERIE": "XXXX"}  
                        **Reglas para identificar la SERIE:**  
                        - La serie es un código alfanumérico de **hasta 4 caracteres**.  
                        - Puede empezar con una **letra**, pero también puede ser solo numérico.  
                        - Se encuentra antes del **correlativo**, que es un número largo (6-8 dígitos).  
                        - Ejemplos de "T411,F001, B002, 0001, 0001, EG01, TG01". 

                        CORRELATIVO
                        Es un número secuencial asignado al comprobante dentro de la serie.
                        El CORRELATIVO no tiene 
                        Tiene una longitud variable (normalmente de 6 a 8 dígitos).
                        Debe ser único dentro de la combinación de serie y tipo de comprobante.
                        Ejemplos: 000123, 00456789.

                        RUC
                        Es un número de 11 dígitos que identifica a una empresa o persona natural con negocio en Perú.
                        Debe cumplir con la validación establecida por la SUNAT.
                        El primer dígito identifica el tipo de contribuyente (por ejemplo, los RUC de empresas suelen empezar con 10 o 20).
                        Ejemplo: 20123456789, 10456789012';

        //dd($contenido);

        $feia   = FeIa::where('COD_IA', '0000000002')->first();
        $apiKey = $feia->CLAVE_API;
        //$contenido = 'HOLA';
        //dd($contenido);

        $url = "https://openrouter.ai/api/v1/chat/completions";
        $data = [
            "model" => "mistralai/mistral-7b-instruct",
            "messages" => [
                ["role" => "system", "content" => "Eres un asistente útil."],
                ["role" => "user", "content" => $contenido]
            ],
            "stream" => false
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey",
            "HTTP-Referer: http://alfasweb.com",
            "X-Title: Mi Aplicación PHP"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['choices'][0]['message']['content'])) {
            $rawContent = $responseData['choices'][0]['message']['content'];

            // 🔍 Extraer solo el JSON usando expresión regular
            if (preg_match('/\{.*\}/s', $rawContent, $matches)) {
                $jsonClean = $matches[0];
                echo $jsonClean; // Esto imprimirá solo el JSON limpio
            } else {
                echo "Error: No se encontró JSON válido en la respuesta.";
            }
        } else {
            echo "Error: No se encontró una respuesta válida en la API.";
        }
    }
    public function actionDeepseekLecturaGuias(Request $request) {

        $feia   = FeIa::where('COD_IA', '0000000002')->first();
        $apiKey = $feia->CLAVE_API;

        $url = "https://openrouter.ai/api/v1/chat/completions";

        $data = [
            "model" => "deepseek/deepseek-r1:free",
            "messages" => [
                ["role" => "system", "content" => "Eres un asistente útil."],
                ["role" => "user", "content" => "¡Hola!"]
            ],
            "stream" => false
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey",
            "HTTP-Referer: http://alfasweb.com",
            "X-Title: Mi Aplicación PHP"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);

        // Decodificar la respuesta JSON
        $responseData = json_decode($response, true);

        // Extraer el mensaje de la IA
        if (isset($responseData['choices'][0]['message']['content'])) {
            echo $responseData['choices'][0]['message']['content']; 
        } else {
            echo "Error: No se encontró una respuesta válida en la API.";
        }
    }
    public function actionBuscarPrecio() {

        $dni = '';
        header('Content-Type: application/json; charset=utf-8');
        $lista              = SuperPrecio::get()->toArray();
        $responsecode = 200;
        $header = array (
            'Content-Type'  => 'application/json; charset=UTF-8',
            'charset'       => 'utf-8'
        );
        $arraydata    =     $lista;
        return response()->json($arraydata, 
                $responsecode, $header, JSON_UNESCAPED_UNICODE);
    }



}
