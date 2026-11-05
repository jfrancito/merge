<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Manzana;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Traits\UserTraits;
use App\Facades\Hashids;

class ManzanaController extends Controller
{
    use UserTraits;

    public function actionListarManzanas($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Manzanas y Secciones');

        $empresa_id = session('empresa_id');
        $proyecto_id = $request->get('proyecto_id');

        $proyectos = Proyecto::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        $query = Manzana::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->with(['proyecto', 'lotes']);

        if ($proyecto_id) {
            $query->where('proyecto_id', $proyecto_id);
        }

        $manzanas = $query->orderBy('orden', 'asc')->orderBy('nombre', 'asc')->get();

        return View::make('pages.inmobiliaria.manzanas.listamanzanas', [
            'manzanas' => $manzanas,
            'proyectos' => $proyectos,
            'proyecto_id' => $proyecto_id,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionAgregarManzana($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Registrar Manzana / Sección');

        $empresa_id = session('empresa_id');

        if ($request->isMethod('post')) {
            $request->validate([
                'proyecto_id' => 'required|string|exists:proyectos,id',
                'nombre' => 'required|string|max:60',
                'orden' => 'nullable|integer|min:1',
                'descripcion' => 'nullable|string|max:250',
            ], [
                'proyecto_id.required' => 'Debe seleccionar un proyecto inmobiliario',
                'nombre.required' => 'El nombre de la manzana es obligatorio (Ej: Mz. A)',
            ]);

            try {
                DB::beginTransaction();

                $idmanzana = $this->user_CreateIdMaestra('manzanas');

                $manzana = new Manzana();
                $manzana->id = $idmanzana;
                $manzana->empresa_id = $empresa_id;
                $manzana->proyecto_id = $request->input('proyecto_id');
                $manzana->nombre = strtoupper(trim($request->input('nombre')));
                $manzana->descripcion = $request->input('descripcion');
                $manzana->orden = $request->input('orden', 1);
                $manzana->activo = 1;
                $manzana->usuario_crea = session('usuario')->id;
                $manzana->fecha_crea = date('Y-m-d H:i:s');
                $manzana->save();

                DB::commit();

                return redirect()->to('/gestion-de-manzanas/' . $idopcion . '?proyecto_id=' . $manzana->proyecto_id)
                    ->with('bienhecho', 'Manzana ' . $manzana->nombre . ' registrada con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Ocurrió un error al registrar la manzana: ' . $e->getMessage());
            }
        }

        $proyectos = Proyecto::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        return View::make('pages.inmobiliaria.manzanas.form.agregarmanzana', [
            'idopcion' => $idopcion,
            'proyectos' => $proyectos,
            'proyecto_id_selected' => $request->get('proyecto_id'),
        ]);
    }

    public function actionModificarManzana(Request $request, $idopcion, $idmanzana)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'modificar');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Modificar Manzana');

        $empresa_id = session('empresa_id');
        $idManzanaReal = $this->user_decodificarmaestra($idmanzana);

        $manzana = Manzana::where('id', $idManzanaReal)
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$manzana) {
            return redirect()->back()->with('errorbd', 'Manzana no encontrada.');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'proyecto_id' => 'required|string|exists:proyectos,id',
                'nombre' => 'required|string|max:60',
                'orden' => 'nullable|integer|min:1',
                'activo' => 'required|integer',
            ], [
                'nombre.required' => 'El nombre de la manzana es obligatorio',
            ]);

            try {
                DB::beginTransaction();

                $manzana->proyecto_id = $request->input('proyecto_id');
                $manzana->nombre = strtoupper(trim($request->input('nombre')));
                $manzana->descripcion = $request->input('descripcion');
                $manzana->orden = $request->input('orden', 1);
                $manzana->activo = $request->input('activo', 1);
                $manzana->usuario_modifica = session('usuario')->id;
                $manzana->fecha_modifica = date('Y-m-d H:i:s');
                $manzana->save();

                DB::commit();

                return redirect()->to('/gestion-de-manzanas/' . $idopcion . '?proyecto_id=' . $manzana->proyecto_id)
                    ->with('bienhecho', 'Manzana ' . $manzana->nombre . ' actualizada con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error al modificar: ' . $e->getMessage());
            }
        }

        $proyectos = Proyecto::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        return View::make('pages.inmobiliaria.manzanas.form.modificarmanzana', [
            'idopcion' => $idopcion,
            'idmanzana' => $idmanzana,
            'manzana' => $manzana,
            'proyectos' => $proyectos,
        ]);
    }

    public function actionEliminarManzana(Request $request, $idopcion, $idmanzana)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'eliminar');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        $empresa_id = session('empresa_id');
        $idManzanaReal = $this->user_decodificarmaestra($idmanzana);

        $manzana = Manzana::where('id', $idManzanaReal)
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$manzana) {
            return redirect()->back()->with('errorbd', 'Manzana no encontrada.');
        }

        $tieneLotes = Lote::where('manzana_id', $idManzanaReal)->where('activo', 1)->exists();
        if ($tieneLotes) {
            return redirect()->back()->with('errorbd', 'No se puede eliminar la manzana porque contiene lotes registrados.');
        }

        $manzana->activo = 0;
        $manzana->usuario_modifica = session('usuario')->id;
        $manzana->fecha_modifica = date('Y-m-d H:i:s');
        $manzana->save();

        return redirect()->to('/gestion-de-manzanas/' . $idopcion)
            ->with('bienhecho', 'Manzana eliminada con éxito.');
    }

    public function actionAjaxManzanasPorProyecto(Request $request)
    {
        $proyecto_id = $request->get('proyecto_id');
        $empresa_id = session('empresa_id');

        $manzanas = Manzana::where('empresa_id', $empresa_id)
            ->where('proyecto_id', $proyecto_id)
            ->where('activo', 1)
            ->orderBy('orden', 'asc')
            ->orderBy('nombre', 'asc')
            ->get(['id', 'nombre', 'orden']);

        return response()->json([
            'success' => true,
            'manzanas' => $manzanas,
        ]);
    }
}
