<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;
use App\Traits\UserTraits;
use App\Models\Opcion;
use App\Models\Grupoopcion;
use App\Models\RolOpcion;
use App\Models\Rol;

class SuperAdminController extends Controller
{
    use UserTraits;
    /**
     * ID fijo del Super Admin - nunca se borra.
     */
    const SUPER_ADMIN_EMPRESA_ID = '1CIX00000001';
    const SUPER_ADMIN_USER_ID    = '1CIX00000001';
    const SUPER_ADMIN_ROL_ID     = '1CIX00000001';

    /**
     * Verifica que el usuario actual es el Super Admin.
     */
    private function esSuperAdmin(): bool
    {
        $usuario = session('usuario');
        return $usuario && $usuario->id === self::SUPER_ADMIN_USER_ID;
    }

    /**
     * Vista de limpieza: muestra estadísticas y formulario de confirmación.
     */
    public function verLimpieza()
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado. Solo el Super Administrador puede acceder a esta función.');
        }

        View::share('titulo', '⚠️ Limpieza de Base de Datos - Producción');

        // Recopilar estadísticas de lo que se va a eliminar
        $stats = $this->obtenerEstadisticas();

        return view('pages.superadmin.limpiar_bd', [
            'stats' => $stats,
        ]);
    }

    /**
     * Ejecuta la limpieza de la base de datos.
     */
    public function ejecutarLimpieza(Request $request)
    {
        // === CAPA 1: Verificar que es Super Admin ===
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado.');
        }

        // === CAPA 2: Verificar palabra de confirmación ===
        if ($request->input('confirmacion') !== 'CONFIRMAR') {
            return redirect()->back()->with('errorbd', 'Debes escribir exactamente "CONFIRMAR" para proceder.');
        }

        // === CAPA 3: Verificar contraseña del Super Admin ===
        $usuario = session('usuario');
        $passwordIngresado = strtoupper(trim($request->input('password_admin')));

        try {
            $passwordGuardado = strtoupper(Crypt::decrypt($usuario->password));
        } catch (\Exception $e) {
            return redirect()->back()->with('errorbd', 'Error al verificar la contraseña. Inténtalo de nuevo.');
        }

        if ($passwordIngresado !== $passwordGuardado) {
            return redirect()->back()->with('errorbd', 'Contraseña incorrecta. La limpieza fue cancelada.');
        }

        // === EJECUTAR LIMPIEZA ===
        try {
            DB::beginTransaction();

            $resultado = $this->ejecutarBorrado();

            DB::commit();

            // Registrar en log
            \Log::warning('LIMPIEZA DE BD EJECUTADA', [
                'ejecutado_por' => $usuario->id . ' (' . $usuario->nombre . ')',
                'fecha'         => now()->toDateTimeString(),
                'registros'     => $resultado,
            ]);

            return redirect('/bienvenido')
                ->with('bienhecho', '✅ Limpieza ejecutada exitosamente. La base de datos está lista para producción. Se eliminaron ' . array_sum($resultado) . ' registros en total.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('ERROR EN LIMPIEZA DE BD: ' . $e->getMessage());
            return redirect()->back()->with('errorbd', 'Error durante la limpieza: ' . $e->getMessage() . '. Los cambios fueron revertidos.');
        }
    }

    /**
     * Obtiene las estadísticas de registros que se van a eliminar.
     */
    public function obtenerEstadisticas(): array
    {
        return [
            // Tablas de negocio (sin filtro, se borran TODAS)
            'ventas'              => DB::table('ventas')->count(),
            'venta_detalles'      => DB::table('venta_detalles')->count(),
            'venta_sunat_logs'    => DB::table('venta_sunat_logs')->count(),
            'venta_cuotas'        => DB::table('venta_cuotas')->count(),
            'resumenes_diarios'   => DB::table('resumenes_diarios')->count(),
            'guias'               => DB::table('guias')->count(),
            'guia_detalles'       => DB::table('guia_detalles')->count(),
            'ordenes_pedido'      => DB::table('orden_pedidos')->count(),
            'ordenes_pedido_det'  => DB::table('orden_pedido_detalles')->count(),
            'clientes'            => DB::table('clientes')->count(),
            'productos'           => DB::table('productos')->count(),
            'tipo_cambios'        => DB::table('tipo_cambios')->count(),
            'usuario_series'      => DB::table('usuario_series')->count(),
            'series'              => DB::table('series')->count(),
            'sedes'               => DB::table('sedes')->count(),
            // Tablas con filtro (excluir Super Admin)
            'users'    => DB::table('users')->where('id', '!=', self::SUPER_ADMIN_USER_ID)->count(),
            'rols'     => DB::table('rols')->where('id', '!=', self::SUPER_ADMIN_ROL_ID)->count(),
            'rolopciones_no_sa' => DB::table('rolopciones')->where('rol_id', '!=', self::SUPER_ADMIN_ROL_ID)->count(),
            'empresas' => DB::table('empresas')->where('id', '!=', self::SUPER_ADMIN_EMPRESA_ID)->count(),
        ];
    }

    /**
     * Ejecuta el borrado en el orden correcto (respetando FK).
     * SIEMPRE dentro de una transacción.
     */
    private function ejecutarBorrado(): array
    {
        $resultado = [];

        // 1. Tablas hija de ventas
        $resultado['venta_sunat_logs'] = DB::table('venta_sunat_logs')->delete();
        $resultado['venta_cuotas']     = DB::table('venta_cuotas')->delete();
        $resultado['venta_detalles']   = DB::table('venta_detalles')->delete();

        // 2. Tablas hija de guías
        $resultado['guia_detalles'] = DB::table('guia_detalles')->delete();

        // 3. Tablas hija de órdenes de pedido
        $resultado['ordenes_pedido_detalles'] = DB::table('orden_pedido_detalles')->delete();

        // 4. Tablas principales de negocio
        $resultado['ventas']            = DB::table('ventas')->delete();
        $resultado['guias']             = DB::table('guias')->delete();
        $resultado['ordenes_pedido']    = DB::table('orden_pedidos')->delete();
        $resultado['resumenes_diarios'] = DB::table('resumenes_diarios')->delete();
        $resultado['tipo_cambios']      = DB::table('tipo_cambios')->delete();

        // 5. Tablas de catálogo por empresa
        $resultado['clientes']        = DB::table('clientes')->delete();
        $resultado['productos']       = DB::table('productos')->delete();
        $resultado['usuario_series']  = DB::table('usuario_series')->delete();
        $resultado['series']          = DB::table('series')->delete();
        $resultado['sedes']           = DB::table('sedes')->delete();

        // 6. Usuarios (excepto Super Admin)
        $resultado['users'] = DB::table('users')
            ->where('id', '!=', self::SUPER_ADMIN_USER_ID)
            ->delete();

        // 7. Permisos de roles (excepto los del Super Admin)
        $resultado['rolopciones'] = DB::table('rolopciones')
            ->where('rol_id', '!=', self::SUPER_ADMIN_ROL_ID)
            ->delete();

        // 8. Roles (excepto Super Admin)
        $resultado['rols'] = DB::table('rols')
            ->where('id', '!=', self::SUPER_ADMIN_ROL_ID)
            ->delete();

        // 9. Empresas (excepto Super Admin) — AL FINAL porque otros tienen FK a empresas
        $resultado['empresas'] = DB::table('empresas')
            ->where('id', '!=', self::SUPER_ADMIN_EMPRESA_ID)
            ->delete();

        return $resultado;
    }

    /**
     * Listar Grupo de Opciones
     */
    public function listarGrupoOpciones()
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado. Solo el Super Administrador puede acceder a esta función.');
        }

        View::share('titulo', 'Super Admin - Grupos de Opciones');
        $grupos = Grupoopcion::orderBy('orden', 'asc')->get();

        return view('pages.superadmin.grupoopciones_lista', [
            'listadatos' => $grupos,
        ]);
    }

    /**
     * Formulario agregar Grupo de Opciones
     */
    public function agregarGrupoOpcion()
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado. Solo el Super Administrador puede acceder a esta función.');
        }

        View::share('titulo', 'Super Admin - Agregar Grupo Opción');
        
        $combo_icono = [
            'settings' => 'settings',
            'person' => 'person',
            'shopping_cart' => 'shopping_cart',
            'analytics' => 'analytics',
            'description' => 'description',
            'receipt' => 'receipt',
            'inventory' => 'inventory',
            'category' => 'category',
            'group' => 'group',
            'dashboard' => 'dashboard',
            'hub' => 'hub',
            'store' => 'store',
        ];

        return view('pages.superadmin.grupoopciones_form', [
            'item' => null,
            'combo_icono' => $combo_icono,
        ]);
    }

    /**
     * Guardar nuevo Grupo de Opciones
     */
    public function guardarGrupoOpcion(Request $request)
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado.');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'icono' => 'required|string|max:100',
            'orden' => 'required|integer',
            'activo' => 'required|integer',
        ]);

        $grupo = new Grupoopcion();
        $grupo->id = $this->user_CreateIdMaestra('grupoopciones');
        $grupo->nombre = $request->input('nombre');
        $grupo->icono = $request->input('icono');
        $grupo->orden = $request->input('orden');
        $grupo->activo = $request->input('activo');
        $grupo->fecha_crea = now();
        $grupo->usuario_crea = session('usuario')->id ?? session('usuario_id') ?? '1CIX00000001';
        $grupo->save();

        $this->regenerarMenuSesion();

        return redirect()->route('superadmin.grupo_opciones')->with('success', 'Grupo de opciones creado correctamente.');
    }

    /**
     * Formulario editar Grupo de Opciones
     */
    public function editarGrupoOpcion($id)
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado.');
        }

        $grupo = Grupoopcion::findOrFail($id);
        View::share('titulo', 'Super Admin - Editar Grupo Opción');

        $combo_icono = [
            'settings' => 'settings',
            'person' => 'person',
            'shopping_cart' => 'shopping_cart',
            'analytics' => 'analytics',
            'description' => 'description',
            'receipt' => 'receipt',
            'inventory' => 'inventory',
            'category' => 'category',
            'group' => 'group',
            'dashboard' => 'dashboard',
            'hub' => 'hub',
            'store' => 'store',
        ];

        return view('pages.superadmin.grupoopciones_form', [
            'item' => $grupo,
            'combo_icono' => $combo_icono,
        ]);
    }

    /**
     * Actualizar Grupo de Opciones
     */
    public function actualizarGrupoOpcion(Request $request, $id)
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado.');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'icono' => 'required|string|max:100',
            'orden' => 'required|integer',
            'activo' => 'required|integer',
        ]);

        $grupo = Grupoopcion::findOrFail($id);
        $grupo->nombre = $request->input('nombre');
        $grupo->icono = $request->input('icono');
        $grupo->orden = $request->input('orden');
        $grupo->activo = $request->input('activo');
        $grupo->save();

        $this->regenerarMenuSesion();

        return redirect()->route('superadmin.grupo_opciones')->with('success', 'Grupo de opciones actualizado correctamente.');
    }

    /**
     * Listar Opciones
     */
    public function listarOpciones()
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado.');
        }

        View::share('titulo', 'Super Admin - Opciones del Menú');
        $opciones = Opcion::with('grupoopcion')->orderBy('grupoopcion_id')->orderBy('orden', 'asc')->get();

        return view('pages.superadmin.opciones_lista', [
            'listadatos' => $opciones,
        ]);
    }

    /**
     * Formulario agregar Opcion
     */
    public function agregarOpcion()
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado.');
        }

        View::share('titulo', 'Super Admin - Agregar Opción');
        $grupos = Grupoopcion::orderBy('nombre', 'asc')->get();

        return view('pages.superadmin.opciones_form', [
            'item' => null,
            'grupos' => $grupos,
        ]);
    }

    /**
     * Guardar Opcion
     */
    public function guardarOpcion(Request $request)
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado.');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:200',
            'pagina' => 'required|string|max:100',
            'grupoopcion_id' => 'required|string|max:200',
            'orden' => 'required|integer',
            'activo' => 'required|integer',
        ]);

        $opcion = new Opcion();
        $opcion->id = $this->user_CreateIdMaestra('opciones');
        $opcion->nombre = $request->input('nombre');
        $opcion->descripcion = $request->input('descripcion');
        $opcion->pagina = $request->input('pagina');
        $opcion->grupoopcion_id = $request->input('grupoopcion_id');
        $opcion->orden = $request->input('orden');
        $opcion->activo = $request->input('activo');
        $opcion->fecha_crea = now();
        $opcion->usuario_crea = session('usuario')->id ?? session('usuario_id') ?? '1CIX00000001';
        $opcion->save();

        // Sincronizar permisos en rolopciones para TODOS los roles
        $this->sincronizarRolOpcionesParaTodosLosRoles($opcion->id);

        $this->regenerarMenuSesion();

        return redirect()->route('superadmin.opciones')->with('success', 'Opción de menú creada correctamente.');
    }

    /**
     * Formulario editar Opcion
     */
    public function editarOpcion($id)
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado.');
        }

        $opcion = Opcion::findOrFail($id);
        View::share('titulo', 'Super Admin - Editar Opción');
        $grupos = Grupoopcion::orderBy('nombre', 'asc')->get();

        return view('pages.superadmin.opciones_form', [
            'item' => $opcion,
            'grupos' => $grupos,
        ]);
    }

    /**
     * Actualizar Opcion
     */
    public function actualizarOpcion(Request $request, $id)
    {
        if (!$this->esSuperAdmin()) {
            return redirect('/bienvenido')->with('errorbd', 'Acceso denegado.');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:200',
            'pagina' => 'required|string|max:100',
            'grupoopcion_id' => 'required|string|max:200',
            'orden' => 'required|integer',
            'activo' => 'required|integer',
        ]);

        $opcion = Opcion::findOrFail($id);
        $opcion->nombre = $request->input('nombre');
        $opcion->descripcion = $request->input('descripcion');
        $opcion->pagina = $request->input('pagina');
        $opcion->grupoopcion_id = $request->input('grupoopcion_id');
        $opcion->orden = $request->input('orden');
        $opcion->activo = $request->input('activo');
        $opcion->save();

        // Sincronizar roles faltantes para esta opción
        $this->sincronizarRolOpcionesParaTodosLosRoles($opcion->id);

        $this->regenerarMenuSesion();

        return redirect()->route('superadmin.opciones')->with('success', 'Opción de menú actualizada correctamente.');
    }

    /**
     * Sincroniza la tabla rolopciones para asegurar que TODOS los roles
     * tengan un registro para la opción especificada.
     * - Super Admin: ver=1, anadir=1, modificar=1, eliminar=1, todas=1
     * - Demás roles: ver=0, anadir=0, modificar=0, eliminar=0, todas=0
     * - Si un rol ya tiene un registro en rolopciones, NO se modifica.
     */
    private function sincronizarRolOpcionesParaTodosLosRoles(string $opcionId): void
    {
        $roles = Rol::all();
        $usuarioId = session('usuario')->id ?? session('usuario_id') ?? '1CIX00000001';

        foreach ($roles as $rol) {
            $existe = RolOpcion::where('rol_id', $rol->id)
                ->where('opcion_id', $opcionId)
                ->first();

            if (!$existe) {
                $idRolOp = $this->user_CreateIdMaestra('rolopciones');
                $maxOrden = RolOpcion::where('rol_id', $rol->id)->max('orden') ?? 0;
                $esSuperAdmin = ($rol->id === self::SUPER_ADMIN_ROL_ID || strtolower($rol->nombre) === 'super administrador' || strtolower($rol->nombre) === 'superadmin');

                $rolopcion = new RolOpcion();
                $rolopcion->id = $idRolOp;
                $rolopcion->rol_id = $rol->id;
                $rolopcion->opcion_id = $opcionId;
                $rolopcion->ver = $esSuperAdmin ? 1 : 0;
                $rolopcion->anadir = $esSuperAdmin ? 1 : 0;
                $rolopcion->modificar = $esSuperAdmin ? 1 : 0;
                $rolopcion->eliminar = $esSuperAdmin ? 1 : 0;
                $rolopcion->todas = $esSuperAdmin ? 1 : 0;
                $rolopcion->orden = $maxOrden + 1;
                $rolopcion->activo = 1;
                $rolopcion->fecha_crea = now();
                $rolopcion->usuario_crea = $usuarioId;
                $rolopcion->save();
            }
        }
    }

    /**
     * Regenera el menú de la sesión actual
     */
    private function regenerarMenuSesion()
    {
        $usuario = session('usuario');
        if (!$usuario) return;

        $rolId = $usuario->rol_id;

        $listamenu = Grupoopcion::join('opciones', 'opciones.grupoopcion_id', '=', 'grupoopciones.id')
            ->join('rolopciones', 'rolopciones.opcion_id', '=', 'opciones.id')
            ->where('grupoopciones.activo', '=', 1)
            ->where('opciones.activo', '=', 1)
            ->where('rolopciones.rol_id', '=', $rolId)
            ->where('rolopciones.ver', '=', 1)
            ->groupBy('grupoopciones.id', 'grupoopciones.nombre', 'grupoopciones.icono', 'grupoopciones.orden')
            ->select('grupoopciones.id', 'grupoopciones.nombre', 'grupoopciones.icono', 'grupoopciones.orden')
            ->orderBy('grupoopciones.orden', 'asc')
            ->get();

        $listaopciones = RolOpcion::join('opciones', 'opciones.id', '=', 'rolopciones.opcion_id')
            ->where('rolopciones.rol_id', '=', $rolId)
            ->where('rolopciones.ver', '=', 1)
            ->where('opciones.activo', '=', 1)
            ->orderBy('rolopciones.orden', 'asc')
            ->orderBy('opciones.orden', 'asc')
            ->pluck('rolopciones.opcion_id')
            ->toArray();

        Session::put('listamenu', $listamenu);
        Session::put('listaopciones', $listaopciones);
    }
}
