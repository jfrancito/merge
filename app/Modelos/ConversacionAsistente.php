<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Modelo para guardar conversaciones del Asistente Analítico
 */
class ConversacionAsistente extends Model
{
    protected $table = 'conversacion_asistente';
    protected $primaryKey = 'id';
    public $timestamps = false; // Disable automatic timestamps for SQL Server

    protected $fillable = [
        'usuario_id',
        'rol',
        'mensaje',
        'ai_mode',
        'tipo_consulta',
        'filtros',
        'created_at',
        'updated_at'
    ];

    /**
     * Guardar un mensaje en la conversación (usando query builder para SQL Server)
     */
    public static function guardarMensaje($usuarioId, $rol, $mensaje, $aiMode = null, $tipoConsulta = null, $filtros = null)
    {
        return DB::table('conversacion_asistente')->insert([
            'usuario_id' => strval($usuarioId),
            'rol' => $rol,
            'mensaje' => $mensaje,
            'ai_mode' => $aiMode,
            'tipo_consulta' => $tipoConsulta,
            'filtros' => $filtros ? json_encode($filtros) : null
        ]);
    }

    /**
     * Obtener las últimas N conversaciones de un usuario
     */
    public static function getConversacion($usuarioId, $limit = 20)
    {
        return DB::table('conversacion_asistente')
            ->where('usuario_id', strval($usuarioId))
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get()
            ->reverse()
            ->values();
    }

    /**
     * Limpiar conversación de un usuario
     */
    public static function limpiarConversacion($usuarioId)
    {
        return DB::table('conversacion_asistente')
            ->where('usuario_id', strval($usuarioId))
            ->delete();
    }

    /**
     * Obtener contexto para Claude (últimos mensajes)
     */
    public static function getContextoParaClaude($usuarioId, $limit = 6)
    {
        $mensajes = DB::table('conversacion_asistente')
            ->where('usuario_id', strval($usuarioId))
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get()
            ->reverse();

        $contexto = [];
        foreach ($mensajes as $m) {
            $contexto[] = [
                'role' => $m->rol,
                'content' => strip_tags($m->mensaje)
            ];
        }

        return $contexto;
    }
}
