<?php

namespace App\Modelos;

use Illuminate\Support\Facades\DB;

/**
 * Modelo para preguntas frecuentes del Asistente Analítico
 */
class PreguntaFrecuenteAsistente
{
    protected static $table = 'preguntas_frecuentes_asistente';

    /**
     * Obtener las preguntas frecuentes de un usuario
     */
    public static function getPreguntas($usuarioId, $limit = 10)
    {
        return DB::table(self::$table)
            ->where('usuario_id', strval($usuarioId))
            ->orderBy('uso_count', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * Guardar o actualizar una pregunta frecuente
     */
    public static function guardarPregunta($usuarioId, $pregunta, $etiqueta = null)
    {
        $usuarioId = strval($usuarioId);

        // Verificar si ya existe
        $existing = DB::table(self::$table)
            ->where('usuario_id', $usuarioId)
            ->where('pregunta', $pregunta)
            ->first();

        if ($existing) {
            // Incrementar contador de uso
            return DB::table(self::$table)
                ->where('id', $existing->id)
                ->update(['uso_count' => $existing->uso_count + 1]);
        }

        // Crear nueva
        return DB::table(self::$table)->insert([
            'usuario_id' => $usuarioId,
            'pregunta' => $pregunta,
            'etiqueta' => $etiqueta
        ]);
    }

    /**
     * Eliminar una pregunta frecuente
     */
    public static function eliminarPregunta($usuarioId, $preguntaId)
    {
        return DB::table(self::$table)
            ->where('usuario_id', strval($usuarioId))
            ->where('id', $preguntaId)
            ->delete();
    }
}
