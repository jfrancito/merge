<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$id_cotizacion = 'ISBECOT000000218';

echo "=== COTIZACION ===\n";
$cot = DB::table('WEB.ORDEN_COTIZACION')->where('ID_COTIZACION', $id_cotizacion)->first();
print_r($cot);

echo "\n=== REFERENCIA ASOC ===\n";
$refs = DB::table('CMP.REFERENCIA_ASOC')->where('COD_TABLA_ASOC', $id_cotizacion)->get();
print_r($refs);

if ($refs->isNotEmpty()) {
    foreach ($refs as $ref) {
        $id_pedido = $ref->COD_TABLA;
        echo "\n=== PEDIDO $id_pedido ===\n";
        $ped = DB::table('WEB.ORDEN_PEDIDO')->where('ID_PEDIDO', $id_pedido)->first();
        print_r($ped);
        
        echo "\n=== DETALLE PEDIDO $id_pedido ===\n";
        $det = DB::table('WEB.ORDEN_PEDIDO_DETALLE')->where('ID_PEDIDO', $id_pedido)->get();
        print_r($det);
    }
}

echo "\n=== MONTO_ORDEN_PEDIDO ===\n";
$montos = DB::table('WEB.MONTO_ORDEN_PEDIDO')->get();
print_r($montos);
