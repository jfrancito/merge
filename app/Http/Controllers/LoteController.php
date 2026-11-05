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

class LoteController extends Controller
{
    use UserTraits;

    public function actionListarLotes($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Catálogo de Lotes');

        $empresa_id = session('empresa_id');
        $proyecto_id = $request->get('proyecto_id');
        $manzana_id = $request->get('manzana_id');
        $estado = $request->get('estado');

        $proyectos = Proyecto::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        $manzanas = [];
        if ($proyecto_id) {
            $manzanas = Manzana::where('empresa_id', $empresa_id)
                ->where('proyecto_id', $proyecto_id)
                ->where('activo', 1)
                ->orderBy('orden', 'asc')
                ->get();
        }

        $query = Lote::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->with(['proyecto', 'manzana']);

        if ($proyecto_id) {
            $query->where('proyecto_id', $proyecto_id);
        }

        if ($manzana_id) {
            $query->where('manzana_id', $manzana_id);
        }

        if ($estado) {
            $query->where('estado', $estado);
        }

        $lotes = $query->orderBy('proyecto_id', 'asc')
            ->orderBy('manzana_id', 'asc')
            ->orderBy('numero_lote', 'asc')
            ->get();

        // Resumen de Métricas
        $metricas = [
            'total' => $lotes->count(),
            'disponibles' => $lotes->where('estado', 'disponible')->count(),
            'reservados' => $lotes->filter(fn($l) => in_array($l->estado, ['reservado', 'separado']))->count(),
            'vendidos' => $lotes->where('estado', 'vendido')->count(),
            'bloqueados' => $lotes->where('estado', 'bloqueado')->count(),
            'total_m2' => $lotes->sum('area_m2'),
            'total_valor' => $lotes->sum('precio_total'),
        ];

        return View::make('pages.inmobiliaria.lotes.listalotes', [
            'lotes' => $lotes,
            'proyectos' => $proyectos,
            'manzanas' => $manzanas,
            'proyecto_id' => $proyecto_id,
            'manzana_id' => $manzana_id,
            'estado_filtro' => $estado,
            'metricas' => $metricas,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionAgregarLote($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Registrar Lote');

        $empresa_id = session('empresa_id');

        if ($request->isMethod('post')) {
            $request->validate([
                'proyecto_id' => 'required|string|exists:proyectos,id',
                'manzana_id' => 'required|string|exists:manzanas,id',
                'numero_lote' => 'required|string|max:30',
                'area_m2' => 'required|numeric|min:1',
                'precio_m2' => 'nullable|numeric|min:0',
                'precio_total' => 'required|numeric|min:0',
                'tipo_lote' => 'required|string|in:estandar,esquina,parque,avenida',
                'estado' => 'required|string|in:disponible,reservado,vendido,bloqueado',
            ], [
                'proyecto_id.required' => 'Debe seleccionar un proyecto',
                'manzana_id.required' => 'Debe seleccionar una manzana',
                'numero_lote.required' => 'El número de lote es obligatorio (Ej: 01)',
                'area_m2.required' => 'El área en m² es obligatoria',
                'precio_total.required' => 'El precio total es obligatorio',
            ]);

            // Validar si el lote ya existe en esa manzana
            $existeLote = Lote::where('manzana_id', $request->input('manzana_id'))
                ->where('numero_lote', trim($request->input('numero_lote')))
                ->where('activo', 1)
                ->exists();

            if ($existeLote) {
                return redirect()->back()->withInput()->with('errorbd', 'El Lote ' . $request->input('numero_lote') . ' ya existe en esta manzana.');
            }

            try {
                DB::beginTransaction();

                $idlote = $this->user_CreateIdMaestra('lotes');

                $lote = new Lote();
                $lote->id = $idlote;
                $lote->empresa_id = $empresa_id;
                $lote->proyecto_id = $request->input('proyecto_id');
                $lote->manzana_id = $request->input('manzana_id');
                $lote->numero_lote = trim($request->input('numero_lote'));
                $lote->area_m2 = $request->input('area_m2');
                $lote->medida_frente = $request->input('medida_frente', 0.00);
                $lote->medida_fondo = $request->input('medida_fondo', 0.00);
                $lote->medida_izquierda = $request->input('medida_izquierda', 0.00);
                $lote->medida_derecha = $request->input('medida_derecha', 0.00);
                $lote->lindero_norte = $request->input('lindero_norte');
                $lote->lindero_sur = $request->input('lindero_sur');
                $lote->lindero_este = $request->input('lindero_este');
                $lote->lindero_oeste = $request->input('lindero_oeste');
                $lote->precio_m2 = $request->input('precio_m2', 0.00);
                $lote->precio_total = $request->input('precio_total');
                $lote->tipo_lote = $request->input('tipo_lote', 'estandar');
                $lote->estado = $request->input('estado', 'disponible');
                $lote->observaciones = $request->input('observaciones');
                $lote->activo = 1;
                $lote->usuario_crea = session('usuario')->id;
                $lote->fecha_crea = date('Y-m-d H:i:s');
                $lote->save();

                DB::commit();

                return redirect()->to('/gestion-de-lotes/' . $idopcion . '?proyecto_id=' . $lote->proyecto_id . '&manzana_id=' . $lote->manzana_id)
                    ->with('bienhecho', 'Lote ' . $lote->numero_lote . ' registrado con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Ocurrió un error al guardar el lote: ' . $e->getMessage());
            }
        }

        $proyectos = Proyecto::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        return View::make('pages.inmobiliaria.lotes.form.agregarlote', [
            'idopcion' => $idopcion,
            'proyectos' => $proyectos,
            'proyecto_id_selected' => $request->get('proyecto_id'),
            'manzana_id_selected' => $request->get('manzana_id'),
        ]);
    }

    public function actionModificarLote(Request $request, $idopcion, $idlote)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'modificar');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Modificar Lote');

        $empresa_id = session('empresa_id');
        $idLoteReal = $this->user_decodificarmaestra($idlote);

        $lote = Lote::where('id', $idLoteReal)
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$lote) {
            return redirect()->back()->with('errorbd', 'Lote no encontrado.');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'proyecto_id' => 'required|string|exists:proyectos,id',
                'manzana_id' => 'required|string|exists:manzanas,id',
                'numero_lote' => 'required|string|max:30',
                'area_m2' => 'required|numeric|min:1',
                'precio_m2' => 'nullable|numeric|min:0',
                'precio_total' => 'required|numeric|min:0',
                'tipo_lote' => 'required|string|in:estandar,esquina,parque,avenida',
                'estado' => 'required|string|in:disponible,reservado,vendido,bloqueado',
                'activo' => 'required|integer',
            ], [
                'numero_lote.required' => 'El número de lote es obligatorio',
                'area_m2.required' => 'El área en m² es obligatoria',
                'precio_total.required' => 'El precio total es obligatorio',
            ]);

            try {
                DB::beginTransaction();

                $lote->proyecto_id = $request->input('proyecto_id');
                $lote->manzana_id = $request->input('manzana_id');
                $lote->numero_lote = trim($request->input('numero_lote'));
                $lote->area_m2 = $request->input('area_m2');
                $lote->medida_frente = $request->input('medida_frente', 0.00);
                $lote->medida_fondo = $request->input('medida_fondo', 0.00);
                $lote->medida_izquierda = $request->input('medida_izquierda', 0.00);
                $lote->medida_derecha = $request->input('medida_derecha', 0.00);
                $lote->lindero_norte = $request->input('lindero_norte');
                $lote->lindero_sur = $request->input('lindero_sur');
                $lote->lindero_este = $request->input('lindero_este');
                $lote->lindero_oeste = $request->input('lindero_oeste');
                $lote->precio_m2 = $request->input('precio_m2', 0.00);
                $lote->precio_total = $request->input('precio_total');
                $lote->tipo_lote = $request->input('tipo_lote', 'estandar');
                $lote->estado = $request->input('estado', 'disponible');
                $lote->observaciones = $request->input('observaciones');
                $lote->activo = $request->input('activo', 1);
                $lote->usuario_modifica = session('usuario')->id;
                $lote->fecha_modifica = date('Y-m-d H:i:s');
                $lote->save();

                DB::commit();

                return redirect()->to('/gestion-de-lotes/' . $idopcion . '?proyecto_id=' . $lote->proyecto_id . '&manzana_id=' . $lote->manzana_id)
                    ->with('bienhecho', 'Lote ' . $lote->numero_lote . ' modificado con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error al modificar lote: ' . $e->getMessage());
            }
        }

        $proyectos = Proyecto::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        $manzanas = Manzana::where('empresa_id', $empresa_id)
            ->where('proyecto_id', $lote->proyecto_id)
            ->where('activo', 1)
            ->orderBy('orden', 'asc')
            ->get();

        return View::make('pages.inmobiliaria.lotes.form.modificarlote', [
            'idopcion' => $idopcion,
            'idlote' => $idlote,
            'lote' => $lote,
            'proyectos' => $proyectos,
            'manzanas' => $manzanas,
        ]);
    }

    public function actionCreacionMasivaLotes($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Generación Masiva de Lotes');

        $empresa_id = session('empresa_id');

        if ($request->isMethod('post')) {
            $request->validate([
                'proyecto_id' => 'required|string|exists:proyectos,id',
                'manzana_id' => 'required|string|exists:manzanas,id',
                'desde_numero' => 'required|integer|min:1',
                'hasta_numero' => 'required|integer|gte:desde_numero|max:500',
                'area_m2' => 'required|numeric|min:1',
                'precio_m2' => 'required|numeric|min:0',
                'medida_frente' => 'nullable|numeric|min:0',
                'medida_fondo' => 'nullable|numeric|min:0',
                'medida_izquierda' => 'nullable|numeric|min:0',
                'medida_derecha' => 'nullable|numeric|min:0',
            ], [
                'desde_numero.required' => 'Indique el número inicial del lote (Ej: 1)',
                'hasta_numero.required' => 'Indique el número final del lote (Ej: 20)',
                'hasta_numero.gte' => 'El número final debe ser mayor o igual al número inicial',
            ]);

            try {
                DB::beginTransaction();

                $desde = (int)$request->input('desde_numero');
                $hasta = (int)$request->input('hasta_numero');
                $proyectoId = $request->input('proyecto_id');
                $manzanaId = $request->input('manzana_id');
                $areaM2 = (float)$request->input('area_m2');
                $precioM2 = (float)$request->input('precio_m2');
                $precioTotal = round($areaM2 * $precioM2, 2);

                $creados = 0;
                $omitidos = 0;

                for ($i = $desde; $i <= $hasta; $i++) {
                    $numLote = str_pad($i, 2, "0", STR_PAD_LEFT);

                    $existe = Lote::where('manzana_id', $manzanaId)
                        ->where('numero_lote', $numLote)
                        ->where('activo', 1)
                        ->exists();

                    if ($existe) {
                        $omitidos++;
                        continue;
                    }

                    $idlote = $this->user_CreateIdMaestra('lotes');

                    $lote = new Lote();
                    $lote->id = $idlote;
                    $lote->empresa_id = $empresa_id;
                    $lote->proyecto_id = $proyectoId;
                    $lote->manzana_id = $manzanaId;
                    $lote->numero_lote = $numLote;
                    $lote->area_m2 = $areaM2;
                    $lote->medida_frente = $request->input('medida_frente', 0.00);
                    $lote->medida_fondo = $request->input('medida_fondo', 0.00);
                    $lote->medida_izquierda = $request->input('medida_izquierda', 0.00);
                    $lote->medida_derecha = $request->input('medida_derecha', 0.00);
                    $lote->precio_m2 = $precioM2;
                    $lote->precio_total = $precioTotal;
                    $lote->tipo_lote = 'estandar';
                    $lote->estado = 'disponible';
                    $lote->activo = 1;
                    $lote->usuario_crea = session('usuario')->id;
                    $lote->fecha_crea = date('Y-m-d H:i:s');
                    $lote->save();

                    $creados++;
                }

                DB::commit();

                $msg = "Se generaron $creados lotes correctamente.";
                if ($omitidos > 0) {
                    $msg .= " ($omitidos lotes ya existían y fueron omitidos).";
                }

                return redirect()->to('/gestion-de-lotes/' . $idopcion . '?proyecto_id=' . $proyectoId . '&manzana_id=' . $manzanaId)
                    ->with('bienhecho', $msg);

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error en generación masiva: ' . $e->getMessage());
            }
        }

        $proyectos = Proyecto::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        return View::make('pages.inmobiliaria.lotes.form.creacionmasiva', [
            'idopcion' => $idopcion,
            'proyectos' => $proyectos,
            'proyecto_id_selected' => $request->get('proyecto_id'),
            'manzana_id_selected' => $request->get('manzana_id'),
        ]);
    }

    public function actionEliminarLote(Request $request, $idopcion, $idlote)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'eliminar');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        $empresa_id = session('empresa_id');
        $idLoteReal = $this->user_decodificarmaestra($idlote);

        $lote = Lote::where('id', $idLoteReal)
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$lote) {
            return redirect()->back()->with('errorbd', 'Lote no encontrado.');
        }

        if ($lote->estado === 'vendido') {
            return redirect()->back()->with('errorbd', 'No se puede eliminar un lote que se encuentra en estado Vendido.');
        }

        $lote->activo = 0;
        $lote->usuario_modifica = session('usuario')->id;
        $lote->fecha_modifica = date('Y-m-d H:i:s');
        $lote->save();

        return redirect()->to('/gestion-de-lotes/' . $idopcion . '?proyecto_id=' . $lote->proyecto_id . '&manzana_id=' . $lote->manzana_id)
            ->with('bienhecho', 'Lote eliminado con éxito.');
    }

    public function actionAjaxDetalleLote(Request $request)
    {
        $lote_id = $request->get('lote_id');
        $empresa_id = session('empresa_id');

        $lote = Lote::where('empresa_id', $empresa_id)
            ->where('id', $lote_id)
            ->where('activo', 1)
            ->with(['proyecto', 'manzana'])
            ->first();

        if (!$lote) {
            return response()->json(['success' => false, 'message' => 'Lote no encontrado'], 404);
        }

        return response()->json([
            'success' => true,
            'lote' => $lote,
        ]);
    }

    public function actionAjaxLotesPorManzana(Request $request)
    {
        $manzana_id = $request->get('manzana_id');
        $empresa_id = session('empresa_id');

        $lotes = Lote::where('empresa_id', $empresa_id)
            ->where('manzana_id', $manzana_id)
            ->where('activo', 1)
            ->where('estado', '!=', 'vendido')
            ->orderBy('numero_lote', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'lotes' => $lotes,
        ]);
    }
}
