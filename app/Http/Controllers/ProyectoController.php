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

class ProyectoController extends Controller
{
    use UserTraits;

    public function actionListarProyectos($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Proyectos Inmobiliarios');

        $empresa_id = session('empresa_id');
        $proyectos = Proyecto::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->orderBy('id', 'desc')
            ->with(['manzanas', 'lotes'])
            ->get();

        return View::make('pages.inmobiliaria.proyectos.listaproyectos', [
            'proyectos' => $proyectos,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionAgregarProyecto($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Registrar Proyecto Inmobiliario');

        if ($request->isMethod('post')) {
            $request->validate([
                'nombre' => 'required|string|max:150',
                'moneda' => 'required|string|in:PEN,USD',
                'precio_m2_referencial' => 'nullable|numeric|min:0',
                'departamento' => 'nullable|string|max:80',
                'provincia' => 'nullable|string|max:80',
                'distrito' => 'nullable|string|max:80',
                'direccion' => 'nullable|string|max:250',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
                'plano' => 'nullable|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            ], [
                'nombre.required' => 'El nombre del proyecto es obligatorio',
                'foto.image' => 'El archivo de foto debe ser una imagen válida',
                'foto.max' => 'La foto no debe superar los 3MB',
                'plano.max' => 'El plano no debe superar los 10MB',
            ]);

            try {
                DB::beginTransaction();

                $empresa_id = session('empresa_id');
                $idproyecto = $this->user_CreateIdMaestra('proyectos');

                $fotoPath = null;
                if ($request->hasFile('foto')) {
                    $fotoPath = $request->file('foto')->store('proyectos', 'public');
                }

                $planoPath = null;
                if ($request->hasFile('plano')) {
                    $planoPath = $request->file('plano')->store('planos', 'public');
                }

                $proyecto = new Proyecto();
                $proyecto->id = $idproyecto;
                $proyecto->empresa_id = $empresa_id;
                $proyecto->nombre = trim($request->input('nombre'));
                $proyecto->descripcion = $request->input('descripcion');
                $proyecto->departamento = $request->input('departamento');
                $proyecto->provincia = $request->input('provincia');
                $proyecto->distrito = $request->input('distrito');
                $proyecto->direccion = $request->input('direccion');
                $proyecto->moneda = $request->input('moneda', 'PEN');
                $proyecto->precio_m2_referencial = $request->input('precio_m2_referencial', 0.00);
                $proyecto->foto = $fotoPath;
                $proyecto->plano = $planoPath;
                $proyecto->activo = 1;
                $proyecto->usuario_crea = session('usuario')->id;
                $proyecto->fecha_crea = date('Y-m-d H:i:s');
                $proyecto->save();

                DB::commit();

                return redirect()->to('/gestion-de-proyectos/' . $idopcion)
                    ->with('bienhecho', 'Proyecto ' . $proyecto->nombre . ' registrado con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Ocurrió un error al guardar el proyecto: ' . $e->getMessage());
            }
        }

        return View::make('pages.inmobiliaria.proyectos.form.agregarproyecto', [
            'idopcion' => $idopcion,
        ]);
    }

    public function actionModificarProyecto(Request $request, $idopcion, $idproyecto)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'modificar');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Modificar Proyecto Inmobiliario');

        $empresa_id = session('empresa_id');
        $idProyectoReal = $this->user_decodificarmaestra($idproyecto);

        $proyecto = Proyecto::where('id', $idProyectoReal)
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$proyecto) {
            return redirect()->back()->with('errorbd', 'Proyecto no encontrado.');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'nombre' => 'required|string|max:150',
                'moneda' => 'required|string|in:PEN,USD',
                'precio_m2_referencial' => 'nullable|numeric|min:0',
                'departamento' => 'nullable|string|max:80',
                'provincia' => 'nullable|string|max:80',
                'distrito' => 'nullable|string|max:80',
                'direccion' => 'nullable|string|max:250',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
                'plano' => 'nullable|mimes:jpeg,png,jpg,webp,pdf|max:10240',
                'activo' => 'required|integer',
            ], [
                'nombre.required' => 'El nombre del proyecto es obligatorio',
                'foto.image' => 'El archivo de foto debe ser una imagen válida',
            ]);

            try {
                DB::beginTransaction();

                if ($request->hasFile('foto')) {
                    $proyecto->foto = $request->file('foto')->store('proyectos', 'public');
                }

                if ($request->hasFile('plano')) {
                    $proyecto->plano = $request->file('plano')->store('planos', 'public');
                }

                $proyecto->nombre = trim($request->input('nombre'));
                $proyecto->descripcion = $request->input('descripcion');
                $proyecto->departamento = $request->input('departamento');
                $proyecto->provincia = $request->input('provincia');
                $proyecto->distrito = $request->input('distrito');
                $proyecto->direccion = $request->input('direccion');
                $proyecto->moneda = $request->input('moneda', 'PEN');
                $proyecto->precio_m2_referencial = $request->input('precio_m2_referencial', 0.00);
                $proyecto->activo = $request->input('activo', 1);
                $proyecto->usuario_modifica = session('usuario')->id;
                $proyecto->fecha_modifica = date('Y-m-d H:i:s');
                $proyecto->save();

                DB::commit();

                return redirect()->to('/gestion-de-proyectos/' . $idopcion)
                    ->with('bienhecho', 'Proyecto ' . $proyecto->nombre . ' actualizado con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Ocurrió un error al actualizar: ' . $e->getMessage());
            }
        }

        return View::make('pages.inmobiliaria.proyectos.form.modificarproyecto', [
            'idopcion' => $idopcion,
            'idproyecto' => $idproyecto,
            'proyecto' => $proyecto,
        ]);
    }

    public function actionEliminarProyecto(Request $request, $idopcion, $idproyecto)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'eliminar');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        $empresa_id = session('empresa_id');
        $idProyectoReal = $this->user_decodificarmaestra($idproyecto);

        $proyecto = Proyecto::where('id', $idProyectoReal)
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$proyecto) {
            return redirect()->back()->with('errorbd', 'Proyecto no encontrado.');
        }

        // Validar si tiene lotes asociados
        $tieneLotes = Lote::where('proyecto_id', $idProyectoReal)->where('activo', 1)->exists();
        if ($tieneLotes) {
            return redirect()->back()->with('errorbd', 'No se puede eliminar el proyecto porque contiene lotes registrados.');
        }

        $proyecto->activo = 0;
        $proyecto->usuario_modifica = session('usuario')->id;
        $proyecto->fecha_modifica = date('Y-m-d H:i:s');
        $proyecto->save();

        return redirect()->to('/gestion-de-proyectos/' . $idopcion)
            ->with('bienhecho', 'Proyecto eliminado correctamente.');
    }
}
