<?php

namespace App\Http\Controllers;

use App\Models\Vendedor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Traits\UserTraits;
use App\Facades\Hashids;

class VendedorController extends Controller
{
    use UserTraits;

    public function actionListarVendedores($idopcion)
    {
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Equipo de Ventas / Asesores');

        $empresa_id = session('empresa_id');
        $vendedores = Vendedor::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->orderBy('id', 'desc')
            ->get();

        return View::make('pages.inmobiliaria.vendedores.listavendedores', [
            'vendedores' => $vendedores,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionAgregarVendedor($idopcion, Request $request)
    {
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Registrar Asesor Inmobiliario');

        $empresa_id = session('empresa_id');

        if ($request->isMethod('post')) {
            $request->validate([
                'tipo_documento' => 'required|string|in:DNI,CE,PASAPORTE',
                'numero_documento' => 'required|string|max:20',
                'nombre' => 'required|string|max:100',
                'apellidos' => 'nullable|string|max:100',
                'telefono' => 'nullable|string|max:30',
                'email' => 'nullable|email|max:100',
                'porcentaje_comision' => 'nullable|numeric|min:0|max:100',
            ], [
                'numero_documento.required' => 'El número de documento es obligatorio',
                'nombre.required' => 'El nombre del asesor es obligatorio',
            ]);

            try {
                DB::beginTransaction();

                $idvendedor = $this->user_CreateIdMaestra('vendedores');

                $vendedor = new Vendedor();
                $vendedor->id = $idvendedor;
                $vendedor->empresa_id = $empresa_id;
                $vendedor->tipo_documento = $request->input('tipo_documento', 'DNI');
                $vendedor->numero_documento = trim($request->input('numero_documento'));
                $vendedor->nombre = strtoupper(trim($request->input('nombre')));
                $vendedor->apellidos = strtoupper(trim($request->input('apellidos')));
                $vendedor->telefono = $request->input('telefono');
                $vendedor->email = $request->input('email');
                $vendedor->porcentaje_comision = $request->input('porcentaje_comision', 0.00);
                $vendedor->comision_fija = $request->input('comision_fija', 0.00);
                $vendedor->activo = 1;
                $vendedor->usuario_crea = session('usuario')->id;
                $vendedor->fecha_crea = date('Y-m-d H:i:s');
                $vendedor->save();

                DB::commit();

                return redirect()->to('/gestion-de-vendedores/' . $idopcion)
                    ->with('bienhecho', 'Asesor ' . $vendedor->nombre_completo . ' registrado con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error al registrar asesor: ' . $e->getMessage());
            }
        }

        return View::make('pages.inmobiliaria.vendedores.form.agregarvendedor', [
            'idopcion' => $idopcion,
        ]);
    }

    public function actionModificarVendedor(Request $request, $idopcion, $idvendedor)
    {
        $validarurl = $this->user_url($idopcion, 'modificar');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Modificar Asesor Inmobiliario');

        $empresa_id = session('empresa_id');
        $idVendedorReal = $this->user_decodificarmaestra($idvendedor);

        $vendedor = Vendedor::where('id', $idVendedorReal)
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$vendedor) {
            return redirect()->back()->with('errorbd', 'Asesor no encontrado.');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'tipo_documento' => 'required|string|in:DNI,CE,PASAPORTE',
                'numero_documento' => 'required|string|max:20',
                'nombre' => 'required|string|max:100',
                'activo' => 'required|integer',
            ]);

            try {
                DB::beginTransaction();

                $vendedor->tipo_documento = $request->input('tipo_documento');
                $vendedor->numero_documento = trim($request->input('numero_documento'));
                $vendedor->nombre = strtoupper(trim($request->input('nombre')));
                $vendedor->apellidos = strtoupper(trim($request->input('apellidos')));
                $vendedor->telefono = $request->input('telefono');
                $vendedor->email = $request->input('email');
                $vendedor->porcentaje_comision = $request->input('porcentaje_comision', 0.00);
                $vendedor->comision_fija = $request->input('comision_fija', 0.00);
                $vendedor->activo = $request->input('activo', 1);
                $vendedor->usuario_modifica = session('usuario')->id;
                $vendedor->fecha_modifica = date('Y-m-d H:i:s');
                $vendedor->save();

                DB::commit();

                return redirect()->to('/gestion-de-vendedores/' . $idopcion)
                    ->with('bienhecho', 'Asesor ' . $vendedor->nombre_completo . ' actualizado con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error al modificar asesor: ' . $e->getMessage());
            }
        }

        return View::make('pages.inmobiliaria.vendedores.form.modificarvendedor', [
            'idopcion' => $idopcion,
            'idvendedor' => $idvendedor,
            'vendedor' => $vendedor,
        ]);
    }

    public function actionEliminarVendedor(Request $request, $idopcion, $idvendedor)
    {
        $validarurl = $this->user_url($idopcion, 'eliminar');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        $empresa_id = session('empresa_id');
        $idVendedorReal = $this->user_decodificarmaestra($idvendedor);

        $vendedor = Vendedor::where('id', $idVendedorReal)
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$vendedor) {
            return redirect()->back()->with('errorbd', 'Asesor no encontrado.');
        }

        $vendedor->activo = 0;
        $vendedor->usuario_modifica = session('usuario')->id;
        $vendedor->fecha_modifica = date('Y-m-d H:i:s');
        $vendedor->save();

        return redirect()->to('/gestion-de-vendedores/' . $idopcion)
            ->with('bienhecho', 'Asesor eliminado con éxito.');
    }
}
