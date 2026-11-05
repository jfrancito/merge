<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

header('Content-Type: text/plain');

$ventas = App\Models\Venta::withoutGlobalScope('empresa')->whereNotNull('orden_pedido_id')->get();
echo "Total ventas with orden_pedido_id: " . $ventas->count() . "\n";
foreach ($ventas as $v) {
    $sede = App\Models\Sede::withoutGlobalScope('empresa')->find($v->sede_id);
    echo "Venta ID: {$v->id} | Sede ID: {$v->sede_id} | Sede Name: " . ($sede ? $sede->nombre : 'NULL') . "\n";
}

echo "\nList of all Sedes in database:\n";
$sedes = App\Models\Sede::withoutGlobalScope('empresa')->get();
foreach ($sedes as $s) {
    echo "Sede ID: {$s->id} | Empresa ID: {$s->empresa_id} | Nombre: {$s->nombre}\n";
}
