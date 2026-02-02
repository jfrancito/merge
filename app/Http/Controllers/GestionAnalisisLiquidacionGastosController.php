<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\LqgLiquidacionGasto;
use App\Modelos\LqgDocumentoHistorial;
use App\Modelos\LqgDetLiquidacionGasto;
use App\Modelos\LqgDetDocumentoLiquidacionGasto;
use App\Modelos\VLiquidacionGastos_Analitica;


use Greenter\Parser\DocumentParserInterface;
use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;
use Greenter\Xml\Parser\PerceptionParser;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use App\Traits\GeneralesTraits;
use App\Traits\AnalisisLiquidacionGastoTraits;


use PDF;
use Hashids;
use SplFileInfo;
use Excel;
use Carbon\Carbon;

class GestionAnalisisLiquidacionGastosController extends Controller
{
    use GeneralesTraits;
    use AnalisisLiquidacionGastoTraits;
    use \App\Traits\AsistenteAnaliticoTraits;


    public function actionGestionAsistenteLiquidacionCompra($idopcion, Request $request)
    {

        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Anadir');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Asistente de Liquidación de Gastos');
        return View::make(
            'analisisliquidaciongasto/asistenteliquidaciongastos',
            [
                'idopcion' => $idopcion,
            ]
        );
    }

    public function actionGestionAnalisisaLiquidacionCompra($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->funciones->getUrl($idopcion, 'Anadir');
        if ($validarurl <> 'true') {
            return $validarurl;
        }
        /******************************************************/
        View::share('titulo', 'Análisis de Liquidación de Gastos');

        // Obtener listas de filtros directamente de la vista histórica para evitar errores de tablas inexistentes
        $lista_empresas = VLiquidacionGastos_Analitica::select('ID_EMPRESA', 'NOMBRE_EMPRESA')->distinct()->pluck('NOMBRE_EMPRESA', 'ID_EMPRESA')->all();
        $lista_monedas = VLiquidacionGastos_Analitica::select('MONEDA')->distinct()->pluck('MONEDA', 'MONEDA')->all();
        $lista_estados = VLiquidacionGastos_Analitica::select('ESTADO_LIQUIDACION')->distinct()->pluck('ESTADO_LIQUIDACION', 'ESTADO_LIQUIDACION')->all();
        $lista_centros = VLiquidacionGastos_Analitica::select('ID_CENTRO_TRABAJO', 'NOMBRE_CENTRO_TRABAJO')->distinct()->pluck('NOMBRE_CENTRO_TRABAJO', 'ID_CENTRO_TRABAJO')->all();
        $lista_areas = VLiquidacionGastos_Analitica::select('ID_AREA_TRABAJO', 'NOMBRE_AREA_TRABAJO')->distinct()->pluck('NOMBRE_AREA_TRABAJO', 'ID_AREA_TRABAJO')->all();

        $anios = VLiquidacionGastos_Analitica::select('ANIO')->distinct()->orderBy('ANIO', 'desc')->pluck('ANIO', 'ANIO')->all();
        $meses = [
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Junio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];

        return View::make(
            'analisisliquidaciongasto/analisiliquidaciongastos',
            [
                'idopcion' => $idopcion,
                'lista_empresas' => $lista_empresas,
                'lista_monedas' => $lista_monedas,
                'lista_estados' => $lista_estados,
                'lista_centros' => $lista_centros,
                'lista_areas' => $lista_areas,
                'anios' => $anios,
                'meses' => $meses,
            ]
        );
    }

    public function actionAjaxDashboards(Request $request)
    {
        $tipo = $request->input('tipo');
        $data = [];

        switch ($tipo) {
            case 'ejecutivo':
                $data = $this->getDashboardEjecutivo($request);
                break;
            case 'areacentro':
                $data = $this->getDashboardAreaCentro($request);
                break;
            case 'proveedores':
                $data = $this->getDashboardProveedores($request);
                break;
            case 'responsables':
                $data = $this->getDashboardResponsables($request);
                break;
            case 'productos':
                $data = $this->getDashboardProductos($request);
                break;
            case 'comparativos':
                $data = $this->getDashboardComparativos($request);
                break;
            case 'detalle':
                $data = $this->getDashboardDetalle($request);
                break;
        }

        return response()->json($data);
    }

    public function actionGetSampleData(Request $request)
    {
        $data = VLiquidacionGastos_Analitica::first();
        return response()->json($data);
    }

    /**
     * API para el Asistente Analítico (Chatbot)
     */
    public function actionApiAsistenteAnalitico($idopcion, Request $request)
    {
        try {
            $question = $request->input('question', '');
            $usuarioId = Session::get('usuario') ? Session::get('usuario')->id : 0;

            if (empty($question)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Por favor, escribe una pregunta.'
                ], 400);
            }

            // Guardar pregunta del usuario
            \App\Modelos\ConversacionAsistente::guardarMensaje(
                $usuarioId,
                'user',
                $question
            );

            // Obtener contexto de conversaciones previas del usuario
            $context = \App\Modelos\ConversacionAsistente::getContextoParaClaude($usuarioId, 6);

            // Procesar la pregunta usando el trait
            $response = $this->processQuestion($question, $context);

            // Guardar respuesta del asistente
            if (isset($response['success']) && $response['success']) {
                \App\Modelos\ConversacionAsistente::guardarMensaje(
                    $usuarioId,
                    'assistant',
                    $response['message'],
                    isset($response['ai_mode']) ? $response['ai_mode'] : null,
                    isset($response['data']['tipo_consulta']) ? $response['data']['tipo_consulta'] : null,
                    isset($response['data']['filtros']) ? $response['data']['filtros'] : null
                );
            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la consulta: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cargar historial de conversación del usuario
     */
    public function actionCargarConversacion($idopcion, Request $request)
    {
        try {
            $usuarioId = Session::get('usuario') ? Session::get('usuario')->id : 0;
            $conversacion = \App\Modelos\ConversacionAsistente::getConversacion($usuarioId, 30);

            return response()->json([
                'success' => true,
                'data' => $conversacion
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar conversación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Limpiar conversación del usuario
     */
    public function actionLimpiarConversacion($idopcion, Request $request)
    {
        try {
            $usuarioId = Session::get('usuario') ? Session::get('usuario')->id : 0;
            \App\Modelos\ConversacionAsistente::limpiarConversacion($usuarioId);

            return response()->json([
                'success' => true,
                'message' => 'Conversación limpiada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al limpiar conversación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener preguntas frecuentes del usuario
     */
    public function actionGetPreguntasFrecuentes($idopcion, Request $request)
    {
        try {
            $usuarioId = Session::get('usuario') ? Session::get('usuario')->id : 0;
            $preguntas = \App\Modelos\PreguntaFrecuenteAsistente::getPreguntas($usuarioId, 10);

            return response()->json([
                'success' => true,
                'data' => $preguntas
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar preguntas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar pregunta frecuente
     */
    public function actionGuardarPreguntaFrecuente($idopcion, Request $request)
    {
        try {
            $usuarioId = Session::get('usuario') ? Session::get('usuario')->id : 0;
            $pregunta = $request->input('pregunta', '');
            $etiqueta = $request->input('etiqueta', null);

            if (empty($pregunta)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La pregunta no puede estar vacía.'
                ], 400);
            }

            \App\Modelos\PreguntaFrecuenteAsistente::guardarPregunta($usuarioId, $pregunta, $etiqueta);

            return response()->json([
                'success' => true,
                'message' => 'Pregunta guardada como favorita'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar pregunta: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar pregunta frecuente
     */
    public function actionEliminarPreguntaFrecuente($idopcion, Request $request)
    {
        try {
            $usuarioId = Session::get('usuario') ? Session::get('usuario')->id : 0;
            $preguntaId = $request->input('id');

            \App\Modelos\PreguntaFrecuenteAsistente::eliminarPregunta($usuarioId, $preguntaId);

            return response()->json([
                'success' => true,
                'message' => 'Pregunta eliminada'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar pregunta: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar Insights Automáticos ("Sorpréndeme")
     */
    public function actionGenerarInsights($idopcion, Request $request)
    {
        try {
            $usuarioId = Session::get('usuario') ? Session::get('usuario')->id : 0;

            // Guardar mensaje del usuario
            \App\Modelos\ConversacionAsistente::guardarMensaje(
                $usuarioId,
                'user',
                '✨ [Sorpréndeme] - Solicité un análisis automático'
            );

            // Generar insights usando el trait
            $response = $this->generateInsights();

            // Guardar respuesta del asistente (solo mensaje corto, no el HTML completo)
            if (isset($response['success']) && $response['success']) {
                $modoInsight = $response['ai_mode'] ?? 'Insights';
                $resumenCorto = "✅ Análisis completado - {$modoInsight}. Revisa el panel de resultados para ver los detalles.";

                \App\Modelos\ConversacionAsistente::guardarMensaje(
                    $usuarioId,
                    'assistant',
                    $resumenCorto,
                    'Insights Automáticos',
                    'insights',
                    null
                );
            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar insights: ' . $e->getMessage()
            ], 500);
        }
    }

}

