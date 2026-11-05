<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Manzana;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Traits\UserTraits;
use App\Facades\Hashids;

class PlanoController extends Controller
{
    use UserTraits;

    public function actionVerPlano($idopcion, Request $request)
    {
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Plano Interactivo de Lotes');

        $empresa_id = session('empresa_id');
        $proyectos = Proyecto::where('empresa_id', $empresa_id)->where('activo', 1)->orderBy('nombre', 'asc')->get();

        $proyecto_id = $request->get('proyecto_id') ?: ($proyectos->first() ? $proyectos->first()->id : null);

        $proyectoSeleccionado = null;
        $manzanas = [];

        if ($proyecto_id) {
            $proyectoSeleccionado = Proyecto::where('id', $proyecto_id)->where('empresa_id', $empresa_id)->first();
            $manzanas = Manzana::where('empresa_id', $empresa_id)
                ->where('proyecto_id', $proyecto_id)
                ->where('activo', 1)
                ->with(['lotes' => function ($q) {
                    $q->where('activo', 1)->orderBy('numero_lote', 'asc');
                }])
                ->orderBy('orden', 'asc')
                ->get();
        }

        return View::make('pages.inmobiliaria.plano.planointeractivo', [
            'proyectos' => $proyectos,
            'proyectoSeleccionado' => $proyectoSeleccionado,
            'manzanas' => $manzanas,
            'proyecto_id' => $proyecto_id,
            'idopcion' => $idopcion,
        ]);
    }
}
