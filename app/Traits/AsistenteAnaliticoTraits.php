<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Modelos\VLiquidacionGastos_Analitica;

/**
 * ASISTENTE ANALÍTICO DE LIQUIDACIÓN DE GASTOS
 * Integración con Claude AI para consultas inteligentes
 */
trait AsistenteAnaliticoTraits
{
    // Track if using Claude AI or local processing
    private $usingClaudeAI = false;
    private $lastSqlQuery = '';

    /**
     * Log a message to the assistant log file
     */
    private function logAssistant($message, $data = [])
    {
        $logPath = storage_path('logs/asistente.log');
        $timestamp = date('Y-m-d H:i:s');
        $logLine = "[{$timestamp}] {$message}";

        if (!empty($data)) {
            $logLine .= " | " . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        file_put_contents($logPath, $logLine . "\n", FILE_APPEND);
    }
    /**
     * System prompt con el diccionario de datos y reglas
     */
    private function getSystemPrompt()
    {
        // Current date info for relative calculations
        $currentYear = date('Y');
        $currentMonth = date('n');
        $currentQuarter = ceil($currentMonth / 3);
        $lastQuarter = $currentQuarter > 1 ? $currentQuarter - 1 : 4;
        $lastQuarterYear = $currentQuarter > 1 ? $currentYear : $currentYear - 1;

        return <<<PROMPT
Eres un Asistente Analítico Gerencial experto en finanzas. Tu trabajo es RESPONDER PREGUNTAS con datos concretos.

FECHA ACTUAL: {$currentYear}-{$currentMonth}. Trimestre actual: {$currentQuarter}. Último trimestre: Q{$lastQuarter} de {$lastQuarterYear}.

TABLA: VLiquidacionGastos_Analitica

COLUMNAS (MAYÚSCULAS, sin tildes):
- ANIO, MES, TRIMESTRE (números)
- NOMBRE_EMPRESA, NOMBRE_CENTRO_TRABAJO, NOMBRE_AREA_TRABAJO
- NOMBRE_PROVEEDOR: Proveedor que vendió el producto/servicio
- NOMBRE_TRABAJADOR: Trabajador que SOLICITA la liquidación
- NOMBRE_JEFE_AUTORIZA: Jefe que AUTORIZA/APRUEBA los gastos
- TIPO_DOCUMENTO: Tipo de comprobante
- ESTADO_LIQUIDACION: Solo existen 'GENERADO' o 'EXTORNADO'. (Si preguntan por 'PENDIENTE', 'POR APROBAR' o 'EN PROCESO' -> FILTRA por 'GENERADO')
- TOTAL_GENERAL, SUBTOTAL, IMPUESTO (montos)

IMPORTANTE - ¿Quién autoriza vs quién solicita?:
- Si preguntan "quién AUTORIZÓ" o "quién APROBÓ" gastos → usa group_by: "NOMBRE_JEFE_AUTORIZA"
- Si preguntan "quién SOLICITÓ" o "qué TRABAJADOR" → usa group_by: "NOMBRE_TRABAJADOR"

TIPOS DE CONSULTA:
- "aggregate": Totales generales (¿cuánto se gastó?)
- "ranking": Top N de algo (¿cuál es el mayor?, ¿top proveedores?)
- "count": Contar registros (¿cuántas liquidaciones?)
- "group_time": Evolución temporal (gasto por mes, por trimestre)
- "compare": Comparar periodos (enero vs febrero)

IMPORTANTE - group_by:
Cuando pregunten "¿cuál mes gastó más?", "¿qué proveedor?", "¿qué área?", DEBES incluir:
- "group_by": "MES" para preguntas sobre meses
- "group_by": "NOMBRE_PROVEEDOR" para preguntas sobre proveedores
- "group_by": "NOMBRE_AREA_TRABAJO" para preguntas sobre áreas
- "group_by": "TRIMESTRE" para preguntas sobre trimestres
- "group_by": "NOMBRE_JEFE_AUTORIZA" para preguntas sobre quién autorizó

FORMATO JSON (sin backticks, sin markdown):
{
    "mensaje": "<p>Respuesta HTML DIRECTA a la pregunta. Si preguntan cuál es el mayor, DI que lo calcularás y mostrarás el ranking.</p>",
    "tipo_consulta": "ranking",
    "group_by": "MES",
    "filtros": {
        "ANIO": 2025
    }
}

EJEMPLOS:

Pregunta: "¿Cuál fue el mes con más gasto en 2025?"
{
    "mensaje": "<p>Aquí está el <strong>ranking de gastos por mes</strong> del año 2025. El mes con mayor gasto aparece primero:</p>",
    "tipo_consulta": "ranking",
    "group_by": "MES",
    "filtros": {"ANIO": 2025}
}

Pregunta: "Top 5 proveedores de este año"
{
    "mensaje": "<p><strong>Top 5 proveedores</strong> con mayor gasto en {$currentYear}:</p>",
    "tipo_consulta": "ranking",
    "group_by": "NOMBRE_PROVEEDOR",
    "limit": 5,
    "filtros": {"ANIO": {$currentYear}}
}

Pregunta: "¿Cuánto gastamos en enero 2025?"
{
    "mensaje": "<p>El gasto total de <strong>enero 2025</strong>:</p>",
    "tipo_consulta": "aggregate",
    "filtros": {"ANIO": 2025, "MES": 1}
}

Pregunta: "Evolución mensual del gasto 2024"
{
    "mensaje": "<p>Evolución del gasto <strong>mes a mes</strong> en 2024:</p>",
    "tipo_consulta": "group_time",
    "group_by": "MES",
    "filtros": {"ANIO": 2024}
}

REGLAS:
1. SIEMPRE responde en JSON válido
2. NUNCA uses tildes en nombres de columnas (ANIO, no año)
3. NUNCA pongas valores como "pendiente" - usa números reales
4. SI preguntan "cuál es el mayor/menor", usa tipo "ranking" con group_by
5. El mensaje debe ser ÚTIL y ejecutivo para gerencia
PROMPT;
    }

    /**
     * Procesa la pregunta del usuario usando Claude AI
     */
    public function processQuestion($question, $context = [])
    {
        $apiKey = env('CLAUDE_API_KEY');
        // Usamos Haiku por defecto (Rápido y barato: $0.25/$1.25)
        // Opcional: 'claude-3-5-sonnet-20240620' (Más inteligente: $3.00/$15.00)
        $model = env('CLAUDE_MODEL', 'claude-3-haiku-20240307');

        // Log the incoming question
        $this->logAssistant('=== NUEVA CONSULTA ===');
        $this->logAssistant('Pregunta del usuario', ['pregunta' => $question]);

        // Si no hay API key, retornar error
        if (empty($apiKey) || $apiKey === 'your-api-key-here') {
            $this->usingClaudeAI = false;
            $this->logAssistant('ERROR: No hay API Key de Claude configurada');
            return [
                'success' => false,
                'message' => '<p><strong>⚠️ API Key no configurada</strong></p><p>Para usar el asistente, configura tu API Key de Claude en el archivo <code>.env</code>:</p><pre>CLAUDE_API_KEY=sk-ant-api03-XXXXXXXX</pre><p>Obtén tu API Key en <a href="https://console.anthropic.com" target="_blank">console.anthropic.com</a></p>',
                'ai_mode' => 'Sin configurar'
            ];
        }

        $this->usingClaudeAI = true;
        $this->logAssistant('Modo: CLAUDE AI', ['modelo' => $model]);

        try {
            // Preparar mensajes para Claude
            $messages = [];

            // Añadir contexto de conversación previa
            foreach ($context as $msg) {
                $messages[] = [
                    'role' => $msg['role'] === 'assistant' ? 'assistant' : 'user',
                    'content' => strip_tags($msg['content'])
                ];
            }

            // Añadir pregunta actual
            $messages[] = [
                'role' => 'user',
                'content' => $question
            ];

            // Llamar a la API de Claude usando cURL
            $payload = json_encode([
                'model' => $model,
                'max_tokens' => 2048,
                'system' => $this->getSystemPrompt(),
                'messages' => $messages
            ]);

            $this->logAssistant('Enviando a Claude API...');

            $ch = curl_init('https://api.anthropic.com/v1/messages');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'x-api-key: ' . $apiKey,
                'anthropic-version: 2023-06-01',
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $this->logAssistant('Respuesta de Claude API', ['http_code' => $httpCode]);

            if ($httpCode !== 200) {
                $this->logAssistant('ERROR: API de Claude falló', ['response' => $response]);
                throw new \Exception('Error en API de Claude: HTTP ' . $httpCode);
            }

            $result = json_decode($response, true);
            $aiResponse = isset($result['content'][0]['text']) ? $result['content'][0]['text'] : '';

            $this->logAssistant('Respuesta de Claude', ['respuesta_ai' => $aiResponse]);

            // Parsear respuesta JSON de Claude
            $parsed = $this->parseClaudeResponse($aiResponse);

            // Ejecutar la consulta basada en la respuesta de Claude
            return $this->executeClaudeQuery($parsed, $question);

        } catch (\Exception $e) {
            $this->logAssistant('ERROR: Claude API falló', ['error' => $e->getMessage()]);
            $this->usingClaudeAI = false;

            // Retornar error en lugar de fallback
            return [
                'success' => false,
                'message' => '<p><strong>❌ Error al procesar con Claude AI</strong></p><p>' . htmlspecialchars($e->getMessage()) . '</p><p>Por favor, intenta de nuevo o contacta al administrador.</p>',
                'ai_mode' => 'Error'
            ];
        }
    }

    /**
     * Parsea la respuesta JSON de Claude
     */
    private function parseClaudeResponse($response)
    {
        // Limpiar la respuesta
        $response = trim($response);

        // Intentar extraer JSON si viene con texto adicional
        if (preg_match('/\{[\s\S]*\}/', $response, $matches)) {
            $response = $matches[0];
        }

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Si no es JSON válido, crear estructura por defecto
            return [
                'mensaje' => $response,
                'tipo_consulta' => 'default',
                'filtros' => []
            ];
        }

        return $decoded;
    }

    /**
     * Ejecuta la consulta basada en la respuesta de Claude
     */
    private function executeClaudeQuery($parsed, $originalQuestion)
    {
        $tipo = isset($parsed['tipo_consulta']) ? $parsed['tipo_consulta'] : 'default';
        $filtros = isset($parsed['filtros']) ? $parsed['filtros'] : [];
        $mensaje = isset($parsed['mensaje']) ? $parsed['mensaje'] : '';
        $groupBy = isset($parsed['group_by']) ? strtoupper($parsed['group_by']) : null;
        $limit = isset($parsed['limit']) ? intval($parsed['limit']) : 10;

        $this->logAssistant('Claude response parsed', [
            'tipo' => $tipo,
            'group_by' => $groupBy,
            'limit' => $limit
        ]);

        // Validate and normalize filters
        $validColumns = [
            'ANIO',
            'MES',
            'TRIMESTRE',
            'NOMBRE_EMPRESA',
            'NOMBRE_CENTRO_TRABAJO',
            'NOMBRE_AREA_TRABAJO',
            'NOMBRE_PROVEEDOR',
            'ESTADO_LIQUIDACION',
            'MONEDA',
            'NOMBRE_TRABAJADOR',
            'NOMBRE_JEFE_AUTORIZA',
            'TIPO_DOCUMENTO'
        ];
        // Invalid values that should be ignored (including wrong ESTADO values)
        $invalidValues = ['pendiente', 'pending', 'null', 'undefined', 'todos', 'all', 'aprobado', 'rechazado'];

        $cleanFilters = [];
        $arrayFilters = []; // For whereIn clauses

        foreach ($filtros as $campo => $valor) {
            // Normalize column name (uppercase, no accents)
            $campoNorm = strtoupper(str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['A', 'E', 'I', 'O', 'U', 'N'], $campo));

            // Handle array values (e.g., MES: [1, 2] for comparisons)
            if (is_array($valor)) {
                // Filter out invalid values from array
                $validArrayValues = array_filter($valor, function ($v) use ($invalidValues) {
                    return !in_array(strtolower(strval($v)), $invalidValues) && $v !== null && $v !== '';
                });

                if (!empty($validArrayValues) && in_array($campoNorm, $validColumns)) {
                    $arrayFilters[$campoNorm] = array_values($validArrayValues);
                    $this->logAssistant('Filtro array detectado', ['campo' => $campoNorm, 'valores' => $validArrayValues]);
                }
                continue;
            }

            // Skip null values
            if ($valor === null || $valor === '') {
                continue;
            }

            // Skip invalid string values
            if (is_string($valor) && in_array(strtolower($valor), $invalidValues)) {
                $this->logAssistant('Filtro ignorado (valor inválido)', ['campo' => $campo, 'valor' => $valor]);
                continue;
            }

            // Only apply valid columns
            if (in_array($campoNorm, $validColumns)) {
                $cleanFilters[$campoNorm] = $valor;
            } else {
                $this->logAssistant('Filtro ignorado (columna inválida)', ['campo' => $campo, 'valor' => $valor]);
            }
        }

        $filtros = $cleanFilters;

        $this->logAssistant('Ejecutando query Claude', [
            'tipo' => $tipo,
            'filtros_simples' => $filtros,
            'filtros_array' => $arrayFilters
        ]);

        // Construir query base
        $query = VLiquidacionGastos_Analitica::query();

        // Columns that should use LIKE for partial matching
        $likeColumns = [
            'NOMBRE_TRABAJADOR',
            'NOMBRE_PROVEEDOR',
            'NOMBRE_EMPRESA',
            'NOMBRE_CENTRO_TRABAJO',
            'NOMBRE_AREA_TRABAJO',
            'NOMBRE_PRODUCTO',
            'NOMBRE_JEFE_AUTORIZA'
        ];

        // Aplicar filtros simples
        foreach ($filtros as $campo => $valor) {
            if (!empty($valor) || $valor === 0) {
                // Use LIKE for name columns (partial match with word splitting)
                if (in_array($campo, $likeColumns)) {
                    // Split into words and search for each word
                    $words = preg_split('/\s+/', trim($valor));
                    foreach ($words as $word) {
                        if (strlen($word) >= 2) { // Skip very short words
                            $query->where($campo, 'LIKE', '%' . $word . '%');
                        }
                    }
                } else {
                    $query->where($campo, $valor);
                }
            }
        }

        // Aplicar filtros de array (whereIn for comparisons)
        foreach ($arrayFilters as $campo => $valores) {
            $query->whereIn($campo, $valores);
        }

        // Log the SQL query
        $this->lastSqlQuery = $query->toSql();
        $this->logAssistant('SQL Query Base', [
            'sql' => $this->lastSqlQuery,
            'bindings' => $query->getBindings()
        ]);

        // Ejecutar según tipo (passing groupBy and limit from Claude)
        $result = $this->executeQueryByType($query, $tipo, $filtros, $groupBy, $limit);

        // Formatear respuesta final
        $response = $this->formatClaudeResponse($result, $mensaje, $tipo, $filtros);

        // Add AI mode indicator
        $response['ai_mode'] = $this->usingClaudeAI ? 'Claude AI' : 'Local';
        $response['sql_ejecutado'] = $this->lastSqlQuery;

        return $response;
    }

    /**
     * Ejecuta query según el tipo identificado por Claude
     */
    private function executeQueryByType($query, $tipo, $filtros, $groupBy = null, $limit = 10)
    {
        // Use groupBy from Claude if provided, otherwise use defaults
        $defaultGroupFields = [
            'ranking' => 'NOMBRE_PROVEEDOR',
            'group_time' => 'MES',
            'compare' => 'MES'
        ];

        $groupField = $groupBy ?: (isset($defaultGroupFields[$tipo]) ? $defaultGroupFields[$tipo] : 'NOMBRE_PROVEEDOR');

        $this->logAssistant('Executing query by type', [
            'tipo' => $tipo,
            'groupField' => $groupField,
            'limit' => $limit
        ]);

        switch ($tipo) {
            case 'aggregate':
                return [
                    'total' => $query->sum('TOTAL_GENERAL'),
                    'count' => (clone $query)->distinct()->count('ID_LIQUIDACION'),
                    'impuesto' => (clone $query)->sum('IMPUESTO')
                ];

            case 'ranking':
                return [
                    'data' => $query->select($groupField, DB::raw('SUM(TOTAL_GENERAL) as total'), DB::raw('COUNT(*) as cantidad'))
                        ->groupBy($groupField)
                        ->orderBy('total', 'DESC')
                        ->limit($limit)
                        ->get(),
                    'group' => $groupField
                ];

            case 'count':
                return [
                    'count' => $query->distinct()->count('ID_LIQUIDACION')
                ];

            case 'group_time':
            case 'compare':
                return [
                    'data' => $query->select($groupField, DB::raw('SUM(TOTAL_GENERAL) as total'), DB::raw('COUNT(DISTINCT ID_LIQUIDACION) as cantidad'))
                        ->groupBy($groupField)
                        ->orderBy($groupField)
                        ->get(),
                    'group' => $groupField
                ];

            default:
                return [
                    'total' => $query->sum('TOTAL_GENERAL'),
                    'count' => (clone $query)->distinct()->count('ID_LIQUIDACION')
                ];
        }
    }

    /**
     * Formatea la respuesta final para el frontend
     */
    private function formatClaudeResponse($result, $mensaje, $tipo, $filtros)
    {
        $response = [
            'success' => true,
            'message' => $mensaje,
            'data' => [
                'periodo' => $this->formatPeriodo($filtros),
                'filtros' => $this->formatFiltros($filtros),
                'kpis' => [],
                'tabla' => [],
                'columnas' => [],
                'chart' => null,
                'sugerencias' => $this->getSuggestions($tipo)
            ]
        ];

        // Construir KPIs y tablas según resultados
        if (isset($result['total'])) {
            $response['data']['kpis'][] = [
                'label' => 'Monto Total',
                'value' => 'S/ ' . number_format($result['total'], 2),
                'tipo' => 'info'
            ];
        }

        if (isset($result['count'])) {
            $response['data']['kpis'][] = [
                'label' => 'Documentos',
                'value' => number_format($result['count']),
                'tipo' => 'info',
                'subtext' => 'liquidaciones encontradas'
            ];
        }

        if (isset($result['data']) && count($result['data']) > 0) {
            $tableData = [];
            $chartLabels = [];
            $chartValues = [];
            $groupField = isset($result['group']) ? $result['group'] : 'categoria';

            foreach ($result['data'] as $i => $row) {
                $label = $row->{$groupField};
                $tableData[] = [
                    '#' => $i + 1,
                    'Categoría' => $label,
                    'Monto' => 'S/ ' . number_format($row->total, 2),
                    'Cantidad' => $row->cantidad
                ];
                $chartLabels[] = strlen($label) > 25 ? substr($label, 0, 25) . '...' : $label;
                $chartValues[] = $row->total;
            }

            $response['data']['tabla'] = $tableData;
            $response['data']['columnas'] = ['#', 'Categoría', 'Monto', 'Cantidad'];
            $response['data']['chart'] = [
                'type' => $tipo === 'group_time' ? 'line' : 'bar',
                'labels' => $chartLabels,
                'datasets' => [
                    [
                        'label' => 'Monto (S/)',
                        'data' => $chartValues,
                        'backgroundColor' => $tipo === 'group_time' ? 'rgba(102, 126, 234, 0.2)' : '#667eea',
                        'borderColor' => '#667eea',
                        'fill' => $tipo === 'group_time'
                    ]
                ],
                'options' => $tipo !== 'group_time' ? ['indexAxis' => 'y'] : []
            ];
        }

        return $response;
    }

    /**
     * Obtiene sugerencias según el tipo de consulta
     */
    private function getSuggestions($tipo)
    {
        $suggestions = [
            'aggregate' => ['¿Cuáles son los top 5 proveedores?', '¿Cuántas liquidaciones están pendientes?', 'Mostrar gasto por área'],
            'ranking' => ['¿Cuánto se gastó en total?', 'Comparar con el mes anterior', 'Ver tendencia mensual'],
            'count' => ['¿Cuál es el monto total?', 'Top áreas por gasto', 'Ver por trimestre'],
            'group_time' => ['¿Cuál fue el mes con mayor gasto?', 'Ver top proveedores', 'Filtrar por estado pendiente'],
            'default' => ['¿Cuánto se gastó este año?', 'Top 10 proveedores', 'Gasto por mes']
        ];

        return isset($suggestions[$tipo]) ? $suggestions[$tipo] : $suggestions['default'];
    }

    // =========================================
    // PROCESAMIENTO LOCAL (FALLBACK)
    // =========================================

    /**
     * Procesa la pregunta localmente (sin API)
     */
    private function processQuestionLocal($question, $context = [])
    {
        $question = mb_strtolower(trim($question));

        // Detectar intención
        $intent = $this->detectIntent($question);
        $filters = $this->extractFilters($question);

        $this->logAssistant('Procesamiento Local', [
            'intent' => $intent,
            'filters' => $filters
        ]);

        // Ejecutar consulta
        $query = VLiquidacionGastos_Analitica::query();

        foreach ($filters as $field => $value) {
            $query->where($field, $value);
        }

        if (isset($intent['filter'])) {
            foreach ($intent['filter'] as $field => $value) {
                $query->where($field, $value);
            }
        }

        // Log the SQL query
        $this->lastSqlQuery = $query->toSql();
        $this->logAssistant('SQL Query Local', [
            'sql' => $this->lastSqlQuery,
            'bindings' => $query->getBindings()
        ]);

        // Obtener resultados según tipo
        $result = $this->executeLocalQuery($query, $intent);

        $response = $this->formatLocalResponse($result, $intent, $filters);

        // Add AI mode indicator
        $response['ai_mode'] = 'Local (Sin Claude API)';
        $response['sql_ejecutado'] = $this->lastSqlQuery;

        $this->logAssistant('Respuesta generada', ['ai_mode' => $response['ai_mode']]);

        return $response;
    }

    private function detectIntent($question)
    {
        $patterns = [
            'ranking' => ['top', 'mayores', 'principales', 'ranking', 'más gasto'],
            'count' => ['cuántas', 'cuantas', 'número de', 'cantidad de'],
            'pending' => ['pendientes', 'sin aprobar', 'por aprobar'],
            'monthly' => ['por mes', 'mensual', 'cada mes'],
            'quarterly' => ['por trimestre', 'trimestral']
        ];

        foreach ($patterns as $type => $words) {
            foreach ($words as $word) {
                if (strpos($question, $word) !== false) {
                    return ['type' => $type];
                }
            }
        }

        return ['type' => 'aggregate'];
    }

    private function extractFilters($question)
    {
        $filters = [];
        $meses = ['enero' => 1, 'febrero' => 2, 'marzo' => 3, 'abril' => 4, 'mayo' => 5, 'junio' => 6, 'julio' => 7, 'agosto' => 8, 'septiembre' => 9, 'octubre' => 10, 'noviembre' => 11, 'diciembre' => 12];

        // Año
        if (preg_match('/\b(20\d{2})\b/', $question, $m)) {
            $filters['ANIO'] = (int) $m[1];
        }

        // Mes
        foreach ($meses as $nombre => $num) {
            if (strpos($question, $nombre) !== false) {
                $filters['MES'] = $num;
                break;
            }
        }

        // Este año/mes
        if (strpos($question, 'este año') !== false) {
            $filters['ANIO'] = date('Y');
        }
        if (strpos($question, 'este mes') !== false) {
            $filters['MES'] = date('n');
            $filters['ANIO'] = date('Y');
        }

        return $filters;
    }

    private function executeLocalQuery($query, $intent)
    {
        $type = isset($intent['type']) ? $intent['type'] : 'aggregate';

        switch ($type) {
            case 'ranking':
                return [
                    'type' => 'ranking',
                    'data' => $query->select('NOMBRE_PROVEEDOR', DB::raw('SUM(TOTAL_GENERAL) as total'), DB::raw('COUNT(*) as cantidad'))
                        ->groupBy('NOMBRE_PROVEEDOR')
                        ->orderBy('total', 'DESC')
                        ->limit(10)
                        ->get()
                ];

            case 'count':
                return [
                    'type' => 'count',
                    'count' => $query->distinct()->count('ID_LIQUIDACION')
                ];

            case 'pending':
                $query->where('ESTADO_LIQUIDACION', 'PENDIENTE');
                return [
                    'type' => 'pending',
                    'total' => $query->sum('TOTAL_GENERAL'),
                    'count' => $query->distinct()->count('ID_LIQUIDACION')
                ];

            case 'monthly':
                return [
                    'type' => 'monthly',
                    'data' => $query->select('MES', DB::raw('SUM(TOTAL_GENERAL) as total'))
                        ->groupBy('MES')
                        ->orderBy('MES')
                        ->get()
                ];

            default:
                return [
                    'type' => 'aggregate',
                    'total' => $query->sum('TOTAL_GENERAL'),
                    'count' => (clone $query)->distinct()->count('ID_LIQUIDACION')
                ];
        }
    }

    private function formatLocalResponse($result, $intent, $filters)
    {
        $type = isset($result['type']) ? $result['type'] : 'aggregate';
        $periodo = $this->formatPeriodo($filters);

        $response = [
            'success' => true,
            'message' => '',
            'data' => [
                'periodo' => $periodo,
                'filtros' => $this->formatFiltros($filters),
                'kpis' => [],
                'tabla' => [],
                'columnas' => [],
                'chart' => null,
                'sugerencias' => ['¿Cuánto se gastó este año?', 'Top 10 proveedores', 'Gasto por mes']
            ]
        ];

        switch ($type) {
            case 'aggregate':
                $response['message'] = "<p>El gasto total es de <strong>S/ " . number_format($result['total'], 2) . "</strong> en <strong>" . number_format($result['count']) . "</strong> documentos.</p>";
                $response['data']['kpis'] = [
                    ['label' => 'Monto Total', 'value' => 'S/ ' . number_format($result['total'], 2), 'tipo' => 'info'],
                    ['label' => 'Documentos', 'value' => number_format($result['count']), 'tipo' => 'info']
                ];
                break;

            case 'ranking':
                $response['message'] = "<p>Aquí tienes el <strong>ranking de proveedores</strong> por monto:</p>";
                $tableData = [];
                $chartLabels = [];
                $chartValues = [];

                foreach ($result['data'] as $i => $row) {
                    $tableData[] = ['#' => $i + 1, 'Proveedor' => $row->NOMBRE_PROVEEDOR, 'Monto' => 'S/ ' . number_format($row->total, 2), 'Cantidad' => $row->cantidad];
                    $chartLabels[] = substr($row->NOMBRE_PROVEEDOR, 0, 20);
                    $chartValues[] = $row->total;
                }

                $response['data']['tabla'] = $tableData;
                $response['data']['columnas'] = ['#', 'Proveedor', 'Monto', 'Cantidad'];
                $response['data']['chart'] = ['type' => 'bar', 'labels' => $chartLabels, 'datasets' => [['label' => 'Monto', 'data' => $chartValues, 'backgroundColor' => '#667eea']], 'options' => ['indexAxis' => 'y']];
                break;

            case 'count':
                $response['message'] = "<p>Se encontraron <strong>" . number_format($result['count']) . "</strong> liquidaciones.</p>";
                $response['data']['kpis'] = [['label' => 'Total Liquidaciones', 'value' => number_format($result['count']), 'tipo' => 'info']];
                break;

            case 'pending':
                $response['message'] = "<p>Hay <strong>" . number_format($result['count']) . "</strong> liquidaciones pendientes por un monto de <strong>S/ " . number_format($result['total'], 2) . "</strong>.</p>";
                $response['data']['kpis'] = [
                    ['label' => 'Monto Pendiente', 'value' => 'S/ ' . number_format($result['total'], 2), 'tipo' => 'negative'],
                    ['label' => 'Documentos', 'value' => number_format($result['count']), 'tipo' => 'info']
                ];
                break;
        }

        return $response;
    }

    private function formatPeriodo($filters)
    {
        $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        if (isset($filters['MES']) && isset($filters['ANIO'])) {
            return $meses[$filters['MES']] . ' ' . $filters['ANIO'];
        }
        if (isset($filters['ANIO'])) {
            return 'Año ' . $filters['ANIO'];
        }
        return 'Todos los periodos';
    }

    private function formatFiltros($filters)
    {
        if (empty($filters))
            return 'Sin filtros';
        $parts = [];
        foreach ($filters as $k => $v) {
            $parts[] = "$k: $v";
        }
        return implode(', ', $parts);
    }
}
