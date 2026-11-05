<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Traits\UserTraits;
use App\Facades\Hashids;

class ClienteController extends Controller
{
    use UserTraits;

    public function actionListarClientes($idopcion)
    {
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Directorio de Clientes');

        $empresa_id = session('empresa_id');
        $clientes = Cliente::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->orderBy('id', 'desc')
            ->get();

        return View::make('pages.inmobiliaria.clientes.listaclientes', [
            'clientes' => $clientes,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionAgregarCliente($idopcion, Request $request)
    {
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Registrar Cliente');

        $empresa_id = session('empresa_id');

        if ($request->isMethod('post')) {
            $request->validate([
                'tipo_documento' => 'required|string|in:DNI,RUC,CE,PASAPORTE',
                'numero_documento' => 'required|string|max:20',
                'nombre_razon_social' => 'required|string|max:150',
                'telefono' => 'nullable|string|max:30',
                'email' => 'nullable|email|max:100',
            ], [
                'numero_documento.required' => 'El número de documento es obligatorio',
                'nombre_razon_social.required' => 'El nombre o razón social es obligatorio',
            ]);

            // Validar unicidad de documento por empresa
            $existe = Cliente::where('empresa_id', $empresa_id)
                ->where('numero_documento', trim($request->input('numero_documento')))
                ->where('activo', 1)
                ->exists();

            if ($existe) {
                return redirect()->back()->withInput()->with('errorbd', 'Ya existe un cliente registrado con ese número de documento.');
            }

            try {
                DB::beginTransaction();

                $idcliente = $this->user_CreateIdMaestra('clientes');

                $cliente = new Cliente();
                $cliente->id = $idcliente;
                $cliente->empresa_id = $empresa_id;
                $cliente->tipo_documento = $request->input('tipo_documento');
                $cliente->numero_documento = trim($request->input('numero_documento'));
                $cliente->nombre_razon_social = strtoupper(trim($request->input('nombre_razon_social')));
                $cliente->apellidos = strtoupper(trim($request->input('apellidos')));
                $cliente->telefono = $request->input('telefono');
                $cliente->email = $request->input('email');
                $cliente->direccion = $request->input('direccion');
                $cliente->departamento = $request->input('departamento');
                $cliente->provincia = $request->input('provincia');
                $cliente->distrito = $request->input('distrito');
                $cliente->estado_civil = $request->input('estado_civil');
                $cliente->ocupacion = $request->input('ocupacion');
                $cliente->conyuge_nombre = strtoupper(trim($request->input('conyuge_nombre')));
                $cliente->conyuge_dni = trim($request->input('conyuge_dni'));
                $cliente->observaciones = $request->input('observaciones');
                $cliente->activo = 1;
                $cliente->usuario_crea = session('usuario')->id;
                $cliente->fecha_crea = date('Y-m-d H:i:s');
                $cliente->save();

                DB::commit();

                return redirect()->to('/gestion-de-clientes/' . $idopcion)
                    ->with('bienhecho', 'Cliente ' . $cliente->nombre_completo . ' registrado con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error al registrar cliente: ' . $e->getMessage());
            }
        }

        return View::make('pages.inmobiliaria.clientes.form.agregarcliente', [
            'idopcion' => $idopcion,
        ]);
    }

    public function actionModificarCliente(Request $request, $idopcion, $idcliente)
    {
        $validarurl = $this->user_url($idopcion, 'modificar');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Modificar Cliente');

        $empresa_id = session('empresa_id');
        $idClienteReal = $this->user_decodificarmaestra($idcliente);

        $cliente = Cliente::where('id', $idClienteReal)
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$cliente) {
            return redirect()->back()->with('errorbd', 'Cliente no encontrado.');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'tipo_documento' => 'required|string|in:DNI,RUC,CE,PASAPORTE',
                'numero_documento' => 'required|string|max:20',
                'nombre_razon_social' => 'required|string|max:150',
                'activo' => 'required|integer',
            ]);

            try {
                DB::beginTransaction();

                $cliente->tipo_documento = $request->input('tipo_documento');
                $cliente->numero_documento = trim($request->input('numero_documento'));
                $cliente->nombre_razon_social = strtoupper(trim($request->input('nombre_razon_social')));
                $cliente->apellidos = strtoupper(trim($request->input('apellidos')));
                $cliente->telefono = $request->input('telefono');
                $cliente->email = $request->input('email');
                $cliente->direccion = $request->input('direccion');
                $cliente->departamento = $request->input('departamento');
                $cliente->provincia = $request->input('provincia');
                $cliente->distrito = $request->input('distrito');
                $cliente->estado_civil = $request->input('estado_civil');
                $cliente->ocupacion = $request->input('ocupacion');
                $cliente->conyuge_nombre = strtoupper(trim($request->input('conyuge_nombre')));
                $cliente->conyuge_dni = trim($request->input('conyuge_dni'));
                $cliente->observaciones = $request->input('observaciones');
                $cliente->activo = $request->input('activo', 1);
                $cliente->usuario_modifica = session('usuario')->id;
                $cliente->fecha_modifica = date('Y-m-d H:i:s');
                $cliente->save();

                DB::commit();

                return redirect()->to('/gestion-de-clientes/' . $idopcion)
                    ->with('bienhecho', 'Cliente ' . $cliente->nombre_completo . ' actualizado con éxito.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error al modificar cliente: ' . $e->getMessage());
            }
        }

        return View::make('pages.inmobiliaria.clientes.form.modificarcliente', [
            'idopcion' => $idopcion,
            'idcliente' => $idcliente,
            'cliente' => $cliente,
        ]);
    }

    public function actionEliminarCliente(Request $request, $idopcion, $idcliente)
    {
        $validarurl = $this->user_url($idopcion, 'eliminar');
        if ($validarurl != 'true') {
            return $validarurl;
        }

        $empresa_id = session('empresa_id');
        $idClienteReal = $this->user_decodificarmaestra($idcliente);

        $cliente = Cliente::where('id', $idClienteReal)
            ->where('empresa_id', $empresa_id)
            ->first();

        if (!$cliente) {
            return redirect()->back()->with('errorbd', 'Cliente no encontrado.');
        }

        $cliente->activo = 0;
        $cliente->usuario_modifica = session('usuario')->id;
        $cliente->fecha_modifica = date('Y-m-d H:i:s');
        $cliente->save();

        return redirect()->to('/gestion-de-clientes/' . $idopcion)
            ->with('bienhecho', 'Cliente eliminado con éxito.');
    }

    public function actionAjaxBuscarCliente(Request $request)
    {
        $q = trim($request->get('q'));
        $empresa_id = session('empresa_id');

        $clientes = Cliente::where('empresa_id', $empresa_id)
            ->where('activo', 1)
            ->where(function ($query) use ($q) {
                $query->where('numero_documento', 'LIKE', "%{$q}%")
                    ->orWhere('nombre_razon_social', 'ILIKE', "%{$q}%")
                    ->orWhere('apellidos', 'ILIKE', "%{$q}%");
            })
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'clientes' => $clientes->map(function ($c) {
                return [
                    'id' => $c->id,
                    'text' => "{$c->numero_documento} - {$c->nombre_completo}",
                    'documento' => $c->numero_documento,
                    'nombre' => $c->nombre_completo,
                    'telefono' => $c->telefono,
                    'email' => $c->email,
                    'direccion' => $c->direccion,
                    'conyuge_nombre' => $c->conyuge_nombre,
                    'conyuge_dni' => $c->conyuge_dni,
                ];
            }),
        ]);
    }
}
