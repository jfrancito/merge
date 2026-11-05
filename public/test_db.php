<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$ventas = \App\Models\Venta::withoutGlobalScope('empresa')->take(5)->get(['id', 'empresa_id', 'orden_pedido_id']);
$detalles = \App\Models\OrdenPedidoDetalle::take(5)->get(['id', 'orden_pedido_id', 'empresa_id', 'producto_id']);
$empresas = \App\Models\Empresa::get(['id', 'razon_social', 'nombre_comercial']);

header('Content-Type: application/json');
echo json_encode([
    'ventas' => $ventas,
    'detalles' => $detalles,
    'empresas' => $empresas
]);
