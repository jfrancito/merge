<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\Rolopcion; // Namespace actualizado
use App\Facades\Hashids; // Namespace correcto para Hashids

trait UserTraits
{
    public function user_decodificarmaestra($id)
    {
        if (empty($id)) {
            return '';
        }
        //decodificar variable
        // Inicializar Hashids
        //$hashids = new Hashids(env('HASHIDS_SALT', 'default-salt'), 10);


        $iddeco = Hashids::decode($id);

        //ver si viene con letras la cadena codificada
        if (_count($iddeco) == 0) {
            return '';
        }
        //concatenar con ceros
        $idopcioncompleta = str_pad($iddeco[0], 8, "0", STR_PAD_LEFT);
        //concatenar prefijo

        //$prefijo = Local::where('activo', '=', 1)->first();

        // apunta ahi en tu cuaderno porque esto solo va a permitir decodifcar  cuando sea el contrato del locl en donde estas del resto no
        //¿cuando sea el contrato del local?
        $prefijo = '1CIX';
        $idopcioncompleta = $prefijo . $idopcioncompleta;
        return $idopcioncompleta;

    }



    public function user_CreateIdMaestra($tabla)
    {
        // Se utiliza beginTransaction para asegurar la atomicidad de la lectura del MAX().
        // Si ya hay una transacción abierta (Ej. desde el Controller), Laravel maneja el nivel y no la cierra prematuramente.
        DB::beginTransaction();

        try {
            // Si usamos PostgreSQL, aplicamos este bloqueo que evita que dos usuarios
            // calculen el mismo ID al mismo instante.
            if (DB::connection()->getDriverName() === 'pgsql') {
                DB::statement('LOCK TABLE ' . $tabla . ' IN EXCLUSIVE MODE');
            }

            // maximo valor de la tabla referente
            $id = DB::table($tabla)
                ->select(DB::raw('COALESCE(MAX(SUBSTRING(id FROM 5 FOR 8))::integer, 0) as id'))
                ->first();

            // conversion a string y suma uno para el siguiente id
            $idsuma = $id ? (int)$id->id + 1 : 1;

            // concatenar con ceros y prefijo
            $prefijo = '1CIX';
            $idopcioncompleta = $prefijo . str_pad($idsuma, 8, "0", STR_PAD_LEFT);

            DB::commit();

            return $idopcioncompleta;

        }
        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function user_url($idopcion, $accion)
    {
        // Inicializar Hashids
        //$hashids = new Hashids(env('HASHIDS_SALT', 'default-salt'), 10);

        // Decodificar variable
        $decidopcion = Hashids::decode($idopcion);
        // Ver si viene con letras la cadena codificada
        if (_count($decidopcion) == 0) {
            return Redirect::back()->withInput()->with('errorurl', 'Índices de la url con errores');
        }
        // Concatenar con ceros
        $idopcioncompleta = str_pad($decidopcion[0], 8, "0", STR_PAD_LEFT);

        // Concatenar prefijo
        $idopcioncompleta = '1CIX' . $idopcioncompleta;

        // Ver si la opción existe
        $opcion = Rolopcion::where('opcion_id', '=', $idopcioncompleta)
            ->where('rol_id', '=', session('usuario')->rol_id)
            ->where($accion, '=', 1)
            ->first();

        // En Laravel 11, first() retorna null si no encuentra resultados
        if (!$opcion) {
            return Redirect::back()->withInput()->with('errorurl', 'No tiene autorización para ' . $accion . ' aquí');
        }

        return 'true';
    }

    public function user_nextResumenCorrelativo($empresaId, $hoy)
    {
        // 1. Buscar en resumenes_diarios (identificador: RC-YYYYMMDD-N o RA-YYYYMMDD-N)
        $maxResumen = DB::table('resumenes_diarios')
            ->where('empresa_id', $empresaId)
            ->where(function($q) use ($hoy) {
                $q->where('identificador', 'LIKE', 'RC-' . $hoy . '-%')
                  ->orWhere('identificador', 'LIKE', 'RA-' . $hoy . '-%');
            })
            ->get()
            ->map(function($r) {
                $parts = explode('-', $r->identificador);
                return isset($parts[2]) ? (int)$parts[2] : 0;
            })->max();

        // 2. Buscar en ventas (xml_baja_path o xml_path conteniendo RC-YYYYMMDD-N o RA-YYYYMMDD-N)
        $maxVentaBaja = DB::table('ventas')
            ->where('empresa_id', $empresaId)
            ->where(function($q) use ($hoy) {
                $q->where('xml_baja_path', 'LIKE', '%RC-' . $hoy . '-%')
                  ->orWhere('xml_baja_path', 'LIKE', '%RA-' . $hoy . '-%')
                  ->orWhere('xml_path', 'LIKE', '%RC-' . $hoy . '-%')
                  ->orWhere('xml_path', 'LIKE', '%RA-' . $hoy . '-%');
            })
            ->get()
            ->map(function($v) use ($hoy) {
                $maxLocal = 0;
                $paths = [$v->xml_baja_path, $v->xml_path];
                foreach ($paths as $path) {
                    if ($path && preg_match('/(?:RC|RA)-' . $hoy . '-(\d+)/i', $path, $matches)) {
                        $val = (int)$matches[1];
                        if ($val > $maxLocal) {
                            $maxLocal = $val;
                        }
                    }
                }
                return $maxLocal;
            })->max();

        return max($maxResumen ?? 0, $maxVentaBaja ?? 0) + 1;
    }
}