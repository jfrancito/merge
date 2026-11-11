<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$userId = '1CIX00000080';
$u80 = DB::table('users')->where('id', $userId)->first();
echo "=== USER 80 ===\n";
print_r($u80);

$rol = DB::table('WEB.roles')->where('id', $u80->rol_id)->first();
echo "\n=== ROL ===\n";
print_r($rol);

// Let's check permissions or options assigned to this user or role
$permisos = DB::table('WEB.rolopciones as ro')
    ->join('WEB.opciones as o', 'o.id', '=', 'ro.opcion_id')
    ->where('ro.rol_id', $u80->rol_id)
    ->where('o.nombre', 'like', '%cotiz%')
    ->select('o.id', 'o.nombre', 'o.pagina', 'ro.ver', 'ro.anadir', 'ro.modificar', 'ro.eliminar', 'ro.todas')
    ->get();

echo "\n=== OPCIONES COTIZACION PARA ROL ===\n";
print_r($permisos);

$permisosOC = DB::table('WEB.rolopciones as ro')
    ->join('WEB.opciones as o', 'o.id', '=', 'ro.opcion_id')
    ->where('ro.rol_id', $u80->rol_id)
    ->where('o.nombre', 'like', '%admin%')
    ->select('o.id', 'o.nombre', 'o.pagina', 'ro.ver', 'ro.anadir', 'ro.modificar', 'ro.eliminar', 'ro.todas')
    ->get();

echo "\n=== OPCIONES ADMIN PARA ROL ===\n";
print_r($permisosOC);
