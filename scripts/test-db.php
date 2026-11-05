<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$empresas = \App\Models\Empresa::all();
foreach ($empresas as $emp) {
    echo "ID: " . $emp->id . " | Nombre: " . $emp->nombre . " | RUC: " . $emp->ruc . "\n";
}
