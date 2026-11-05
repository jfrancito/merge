<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Cookie\CookieJar;

class MtcService
{
    protected $baseUrl = "https://www.mtc.gob.pe/tramitesenlinea/tweb_tLinea/tw_consultadgtt/";
    protected $formUrl = "https://www.mtc.gob.pe/tramitesenlinea/tweb_tLinea/tw_consultadgtt/Frm_rep_intra_mercancia.aspx";

    protected $headers = [
        "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36",
        "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "Accept-Language" => "es-PE,es;q=0.9,en;q=0.7",
    ];

    /**
     * Consulta información por Placa, RUC o Partida
     */
    public function consultar($tipo, $valor)
    {
        try {
            $tipo = strtolower($tipo);
            $radioIds = [
                "ruc"    => "2",
                "partida" => "3",
                "placa"   => "4",
                "constancia" => "5"
            ];

            if (!isset($radioIds[$tipo])) {
                return ['success' => false, 'message' => 'Tipo de consulta no válido.'];
            }

            $jar = new CookieJar();

            // 1. Obtener ViewState inicial
            $response = Http::withOptions(['cookies' => $jar])
                ->withHeaders($this->headers)
                ->timeout(20)
                ->withoutVerifying()
                ->get($this->formUrl);

            if (!$response->successful()) {
                return ['success' => false, 'message' => 'No se pudo conectar con el portal del MTC.'];
            }

            $html = $response->body();
            $viewStateData = $this->extractViewState($html);

            // 2. Realizar el POST de búsqueda a la página de resultados
            $displayUrl = str_replace("Frm_rep_intra_mercancia.aspx", "Frm_rep_intra_mercancia_display.aspx", $this->formUrl);
            
            $payload = array_merge($viewStateData, [
                "hdopcion" => $radioIds[$tipo],
                "hdvalore" => strtoupper(trim($valor)),
                "hdopc"    => "2"
            ]);

            $responsePost = Http::withOptions(['cookies' => $jar])
                ->withHeaders(array_merge($this->headers, [
                    "Content-Type" => "application/x-www-form-urlencoded",
                    "Referer"      => $this->formUrl
                ]))
                ->timeout(30)
                ->withoutVerifying()
                ->asForm()
                ->post($displayUrl, $payload);

            if (!$responsePost->successful()) {
                return ['success' => false, 'message' => 'Error en la respuesta del MTC tras la búsqueda.'];
            }

            $htmlPost = $responsePost->body();

            // 3. Si el MTC devuelve una tabla intermedia, debemos seguir al tercer paso (datos)
            if (str_contains($htmlPost, 'toDetalle(')) {
                if ($tipo === 'ruc') {
                    return $this->parseRucHtml($htmlPost);
                }

                // Extraer los parámetros de la función javascript:toDetalle('partida','ruc')
                if (preg_match("/toDetalle\('([^']+)','([^']+)'\)/", $htmlPost, $matches)) {
                    $hdpartida = $matches[1];
                    $hdruc = $matches[2];

                    $viewStateData2 = $this->extractViewState($htmlPost);
                    $payload2 = array_merge($viewStateData2, [
                        "hdpartida" => $hdpartida,
                        "hdruc"     => $hdruc
                    ]);

                    $datosUrl = str_replace("Frm_rep_intra_mercancia_display.aspx", "Frm_rep_intra_mercancia_datos.aspx", $displayUrl);

                    $responseDatos = Http::withOptions(['cookies' => $jar])
                        ->withHeaders(array_merge($this->headers, [
                            "Content-Type" => "application/x-www-form-urlencoded",
                            "Referer"      => $displayUrl
                        ]))
                        ->timeout(30)
                        ->withoutVerifying()
                        ->asForm()
                        ->post($datosUrl, $payload2);

                    if ($responseDatos->successful()) {
                        $htmlPost = $responseDatos->body();
                    }
                }
            }

            $resultado = $this->parseHtml($htmlPost, $tipo, $valor);

            if (empty($resultado['vehiculos']) && empty($resultado['datos'])) {
                Log::warning("MTC devolvió HTML sin tablas útiles. HTML: " . substr($htmlPost, 0, 1000));
            }

            return $resultado;

        } catch (\Exception $e) {
            Log::error("Error en MtcService: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error interno: ' . $e->getMessage()];
        }
    }

    /**
     * Extrae los campos ocultos de ASP.NET (__VIEWSTATE, etc.)
     */
    private function extractViewState($html)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $fields = [
            "__VIEWSTATE",
            "__VIEWSTATEGENERATOR",
            "__EVENTVALIDATION",
            "__EVENTTARGET",
            "__EVENTARGUMENT"
        ];

        $data = [];
        foreach ($fields as $field) {
            $node = $xpath->query("//input[@name='$field']")->item(0);
            $data[$field] = $node ? $node->getAttribute('value') : "";
        }

        return $data;
    }

    /**
     * Procesa las tablas de resultados del MTC
     */
    private function parseHtml($html, $tipo, $valor)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $resultado = [
            'success' => true,
            'encontrado' => false,
            'datos' => [],
            'vehiculos' => []
        ];

        // Verificar si hay mensajes de "No se encontró"
        $bodyText = strtolower($dom->textContent);
        if (str_contains($bodyText, "no se encontr") || str_contains($bodyText, "sin resultado")) {
            return ['success' => false, 'message' => 'No se encontraron registros en el MTC para el valor ingresado.'];
        }

        $resultado['encontrado'] = true;

        // Función auxiliar para limpiar texto de forma agresiva (incluyendo espacios de no separación)
        $cleanText = function($text) {
            // Reemplazar espacios de no separación (\xA0) y otros por espacios normales
            $text = str_replace(["\xc2\xa0", "\xa0", "&nbsp;"], ' ', $text);
            return trim(preg_replace('/\s+/', ' ', $text));
        };

        // Extraer tablas
        $tables = $dom->getElementsByTagName('table');
        foreach ($tables as $table) {
            $rows = $table->getElementsByTagName('tr');
            if ($rows->length == 0) continue;

            // Determinar cabeceras
            $headers = [];
            $thList = $table->getElementsByTagName('th');
            if ($thList->length > 0) {
                foreach ($thList as $th) $headers[] = $cleanText($th->textContent);
            } else {
                $firstRow = $rows->item(0);
                $tds = $firstRow->getElementsByTagName('td');
                if ($tds->length > 2) {
                    foreach ($tds as $td) $headers[] = $cleanText($td->textContent);
                }
            }

            if (_count($headers) >= 2) {
                foreach ($rows as $index => $row) {
                    if ($index === 0 && _count($headers) > 0) continue;
                    
                    $tds = $row->getElementsByTagName('td');
                    if ($tds->length >= _count($headers)) {
                        $item = [];
                        foreach ($tds as $tdIndex => $td) {
                            $headerName = $headers[$tdIndex] ?? "Col_$tdIndex";
                            $item[$headerName] = $cleanText($td->textContent);
                        }
                        
                        $match = false;
                        if ($tipo == 'placa') {
                            foreach ($item as $k => $v) {
                                if (str_contains(strtolower($k), 'placa') && strtoupper($v) == strtoupper($valor)) {
                                    $match = true; break;
                                }
                            }
                        } else { $match = true; }

                        if ($match) {
                            $cleanItem = [];
                            foreach($item as $k => $v) {
                                $kLower = strtolower($k);
                                if (str_contains($kLower, 'certif') || str_contains($kLower, 'tuc') || str_contains($kLower, 'constan')) {
                                    $cleanItem['Certificado'] = $v;
                                }
                                $cleanItem[$k] = $v;
                            }
                            $resultado['vehiculos'][] = $cleanItem;
                        }
                    }
                }
            } else {
                foreach ($rows as $row) {
                    $cols = $row->getElementsByTagName('td');
                    if ($cols->length == 2) {
                        $key = $cleanText(str_replace(':', '', $cols->item(0)->textContent));
                        $val = $cleanText($cols->item(1)->textContent);
                        if ($key && $val) {
                            $resultado['datos'][$key] = $val;
                        }
                    }
                }
            }
        }

        return $resultado;
    }

    /**
     * Procesa la tabla intermedia de RUC y extrae las partidas autorizadas
     */
    private function parseRucHtml($html)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $resultado = [
            'success' => true,
            'encontrado' => false,
            'partidas' => []
        ];

        // Buscar la tabla de resultados
        $rows = $xpath->query("//table[contains(@class, 'table')]//tr");
        if ($rows->length > 0) {
            foreach ($rows as $index => $row) {
                // Saltar la cabecera (Item, Código, Razón Social, R.U.C., etc.)
                if ($index === 0) continue;

                $cols = $row->getElementsByTagName('td');
                if ($cols->length >= 4) {
                    $item = trim($cols->item(0)->textContent);
                    $codigo = trim($cols->item(1)->textContent);
                    $razonSocial = trim($cols->item(2)->textContent);
                    $ruc = trim($cols->item(3)->textContent);

                    if (!empty($codigo)) {
                        $resultado['encontrado'] = true;
                        $resultado['partidas'][] = [
                            'item' => $item,
                            'codigo' => $codigo,
                            'razon_social' => $razonSocial,
                            'ruc' => $ruc
                        ];
                    }
                }
            }
        }

        // Si no encontró filas con códigos
        if (empty($resultado['partidas'])) {
            // Verificar si hay mensajes de "No se encontró"
            $bodyText = strtolower($dom->textContent);
            if (str_contains($bodyText, "no se encontr") || str_contains($bodyText, "sin resultado")) {
                return ['success' => false, 'message' => 'No se encontraron registros en el MTC para el RUC ingresado.'];
            }
            return ['success' => false, 'message' => 'No se pudieron extraer las partidas del RUC.'];
        }

        return $resultado;
    }
}
