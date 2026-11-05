<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Opcion;
use App\Models\Rol;
use App\Models\RolOpcion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use App\Traits\UserTraits;
use App\Facades\Hashids;

class EmpresaController extends Controller
{
    use UserTraits;

    public function actionListarEmpresas($idopcion)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'ver');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Lista de Empresas / Inmobiliarias');

        $listaempresas = Empresa::orderBy('id', 'asc')->get();

        return View::make('pages.empresa.listaempresas', [
            'listaempresas' => $listaempresas,
            'idopcion' => $idopcion,
        ]);
    }

    public function actionAgregarEmpresa($idopcion, Request $request)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'anadir');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Registrar Empresa / Inmobiliaria');

        if ($request->isMethod('post')) {

            /**** Validaciones laravel ****/
            $validated = $request->validate([
                'nombre' => 'required|string|max:200',
                'ruc' => 'required|digits:11|unique:empresas,ruc',
                'direccion_fiscal' => 'nullable|string|max:250',
                'telefono' => 'nullable|string|max:30',
                'email' => 'nullable|email|max:100',
                'representante_legal' => 'nullable|string|max:150',
                'representante_dni' => 'nullable|digits:8',
                'usuario' => 'required|string|min:3|max:50|unique:users,name',
                'password' => 'required|min:4',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048'
            ], [
                'nombre.required' => 'La Razón Social o Nombre Comercial es obligatorio',
                'ruc.required' => 'El número de RUC es obligatorio',
                'ruc.digits' => 'El RUC debe tener exactamente 11 dígitos numéricos',
                'ruc.unique' => 'Este número de RUC ya se encuentra registrado',
                'email.email' => 'Ingrese un formato de correo electrónico válido',
                'representante_dni.digits' => 'El DNI del representante debe tener 8 dígitos',
                'usuario.required' => 'El nombre de usuario administrador es obligatorio',
                'usuario.unique' => 'Este nombre de usuario ya está registrado en el sistema',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 4 caracteres',
                'logo.image' => 'El archivo debe ser una imagen válida',
                'logo.max' => 'La imagen del logo no debe superar los 2MB'
            ]);

            try {
                DB::beginTransaction();

                // 1. Crear ID de Empresa (estándar '1CIX00000000')
                $maxId = DB::table('empresas')
                    ->select(DB::raw('COALESCE(MAX(SUBSTRING(id FROM 5 FOR 8))::integer, 0) as max_id'))
                    ->first();
                $nuevoEmpId = $maxId ? (int)$maxId->max_id + 1 : 1;
                $empresa_id = '1CIX' . str_pad($nuevoEmpId, 8, "0", STR_PAD_LEFT);

                // Manejo de Logo
                $logoPath = null;
                if ($request->hasFile('logo')) {
                    $logoPath = $request->file('logo')->store('logos', 'public');
                }

                // Configuración adicional (contacto, representante)
                $configuracionSimple = [
                    'telefono' => $request->input('telefono'),
                    'email' => $request->input('email'),
                    'representante_legal' => $request->input('representante_legal'),
                    'representante_dni' => $request->input('representante_dni'),
                    'cuenta_bancaria_soles' => $request->input('cuenta_bancaria_soles'),
                    'cuenta_bancaria_dolares' => $request->input('cuenta_bancaria_dolares'),
                ];

                // 2. Crear Empresa
                $empresa = new Empresa();
                $empresa->id = $empresa_id;
                $empresa->nombre = strtoupper(trim($request->input('nombre')));
                $empresa->ruc = trim($request->input('ruc'));
                $empresa->direccion_fiscal = $request->input('direccion_fiscal');
                $empresa->establecimiento = $request->input('establecimiento', '0000');
                $empresa->logo = $logoPath;
                $empresa->configuracion_simple = $configuracionSimple;
                $empresa->activo = 1;
                $empresa->save();

                // 3. Crear Rol Administrador para esta empresa
                $idrol = $this->user_CreateIdMaestra('rols');
                $rol = new Rol();
                $rol->id = $idrol;
                $rol->nombre = 'Administrador General';
                $rol->activo = 1;
                $rol->empresa_id = $empresa_id;
                $rol->fecha_crea = date('Y-m-d H:i:s');
                $rol->usuario_crea = session('usuario')->id;
                $rol->save();

                // 4. Asignar todos los permisos de opciones a ese nuevo Rol (excepto opciones exclusivas de superadmin)
                $opcionesBloqueadas = ['1CIX00000004', '1CIX00000005', '1CIX00000006']; // Opciones de superadmin

                $listaopcion = Opcion::where('activo', 1)
                    ->whereNotIn('id', $opcionesBloqueadas)
                    ->orderBy('id', 'asc')
                    ->get();

                $count = 1;
                foreach ($listaopcion as $item) {
                    $idrolopciones = $this->user_CreateIdMaestra('rolopciones');

                    $detalle = new RolOpcion();
                    $detalle->id = $idrolopciones;
                    $detalle->opcion_id = $item->id;
                    $detalle->rol_id = $idrol;
                    $detalle->orden = $count;
                    $detalle->ver = 1;
                    $detalle->anadir = 1;
                    $detalle->modificar = 1;
                    $detalle->eliminar = 1;
                    $detalle->todas = 1;
                    $detalle->fecha_crea = date('Y-m-d H:i:s');
                    $detalle->usuario_crea = session('usuario')->id;
                    $detalle->save();
                    $count++;
                }

                // 5. Crear el Usuario Administrador para esta empresa
                $iduser = $this->user_CreateIdMaestra('users');
                $user = new User();
                $user->id = $iduser;
                $user->nombre = 'ADMIN ' . $empresa->nombre;
                $user->name = strtolower(trim($request->input('usuario')));
                $user->password = Crypt::encrypt(strtoupper(trim($request->input('password'))));
                $user->rol_id = $idrol;
                $user->empresa_id = $empresa_id;
                $user->activo = 1;
                $user->fecha_crea = date('Y-m-d H:i:s');
                $user->usuario_crea = session('usuario')->id;
                $user->save();

                DB::commit();

                return redirect()->to('/gestion-de-empresas/' . $idopcion)
                    ->with('bienhecho', 'Inmobiliaria / Empresa ' . $empresa->nombre . ' registrada con éxito');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Ocurrió un error al registrar: ' . $e->getMessage());
            }
        }

        return View::make('pages.empresa.form.empresa', [
            'idopcion' => $idopcion,
        ]);
    }

    public function actionModificarEmpresa(Request $request, $idopcion, $idempresa)
    {
        /******************* validar url **********************/
        $validarurl = $this->user_url($idopcion, 'modificar');
        if ($validarurl != 'true') {
            return $validarurl;
        }
        /******************************************************/

        View::share('titulo', 'Modificar Empresa / Inmobiliaria');

        // Decodificar el ID de la empresa
        $empresaIdReal = $this->user_decodificarmaestra($idempresa);
        if (empty($empresaIdReal)) {
            $iddeco = Hashids::decode($idempresa);
            if (_count($iddeco) > 0) {
                $empresaIdReal = '1CIX' . str_pad($iddeco[0], 8, "0", STR_PAD_LEFT);
            }
        }

        $empresa = Empresa::find($empresaIdReal);
        if (!$empresa) {
            return redirect()->back()->with('errorbd', 'Empresa no encontrada.');
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'nombre' => 'required|string|max:200',
                'ruc' => 'required|digits:11|unique:empresas,ruc,' . $empresa->id,
                'direccion_fiscal' => 'nullable|string|max:250',
                'telefono' => 'nullable|string|max:30',
                'email' => 'nullable|email|max:100',
                'representante_legal' => 'nullable|string|max:150',
                'representante_dni' => 'nullable|digits:8',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
                'activo' => 'required|integer'
            ], [
                'nombre.required' => 'La Razón Social o Nombre Comercial es obligatorio',
                'ruc.required' => 'El número de RUC es obligatorio',
                'ruc.digits' => 'El RUC debe tener exactamente 11 dígitos numéricos',
                'ruc.unique' => 'Este RUC ya está registrado en otra empresa',
                'email.email' => 'Ingrese un formato de correo electrónico válido',
                'representante_dni.digits' => 'El DNI del representante debe tener 8 dígitos',
                'logo.image' => 'El archivo debe ser una imagen válida',
                'logo.max' => 'La imagen no debe superar los 2MB'
            ]);

            try {
                DB::beginTransaction();

                if ($request->hasFile('logo')) {
                    $empresa->logo = $request->file('logo')->store('logos', 'public');
                }

                $configActual = $empresa->configuracion_simple ?? [];
                $configActual['telefono'] = $request->input('telefono');
                $configActual['email'] = $request->input('email');
                $configActual['representante_legal'] = $request->input('representante_legal');
                $configActual['representante_dni'] = $request->input('representante_dni');
                $configActual['cuenta_bancaria_soles'] = $request->input('cuenta_bancaria_soles');
                $configActual['cuenta_bancaria_dolares'] = $request->input('cuenta_bancaria_dolares');

                $empresa->nombre = strtoupper(trim($request->input('nombre')));
                $empresa->ruc = trim($request->input('ruc'));
                $empresa->direccion_fiscal = $request->input('direccion_fiscal');
                $empresa->establecimiento = $request->input('establecimiento', '0000');
                $empresa->configuracion_simple = $configActual;
                $empresa->activo = $request->input('activo');
                $empresa->save();

                DB::commit();

                // Si se modificó a sí mismo siendo superadmin y es la misma, actualiza la info de sesión:
                if (session('empresa_id') == $empresa->id) {
                    session(['empresa' => $empresa]);
                }

                return redirect()->to('/gestion-de-empresas/' . $idopcion)
                    ->with('bienhecho', 'Empresa ' . $empresa->nombre . ' modificada exitosamente');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('errorbd', 'Error al modificar: ' . $e->getMessage());
            }
        }

        return View::make('pages.empresa.form.modificarempresa', [
            'idopcion' => $idopcion,
            'idempresa' => $idempresa,
            'empresa' => $empresa
        ]);
    }

    public function actionCambiarEmpresa($empresa_id)
    {
        // Solo el Super Admin puede cambiar de empresa
        if (session('usuario')->rol_id !== '1CIX00000001' && session('usuario')->id !== '1CIX00000001') {
            return redirect()->back()->with('errorbd', 'No tienes permisos para esta acción.');
        }

        $empresa = Empresa::find($empresa_id);
        if (!$empresa) {
            return redirect()->back()->with('errorbd', 'Empresa no encontrada.');
        }

        // Actualizar sesión
        session(['empresa_id' => $empresa->id]);
        session(['empresa' => $empresa]);

        return redirect()->to('/bienvenido')->with('bienhecho', 'Cambiado a la empresa: ' . $empresa->nombre);
    }
}

