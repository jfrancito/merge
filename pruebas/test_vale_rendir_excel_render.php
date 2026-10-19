<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

// Simulate session if needed
$vr = DB::table('WEB.VALE_RENDIR')->first();
$emprObj = new stdClass();
$emprObj->COD_EMPR = $vr ? $vr->COD_EMPR : 'IACHEM0000010394';
Session::put('empresas', $emprObj);

// Test controller
$controller = new App\Http\Controllers\GestionValeRendirController();

// Use reflection to call private method lg_lista_cabecera_vale_rendir_excel
$reflection = new ReflectionClass($controller);
$method = $reflection->getMethod('lg_lista_cabecera_vale_rendir_excel');
$method->setAccessible(true);

$fecha_inicio = '2025-01-01';
$fecha_fin = '2025-12-31';
$estado_id = 'TODO';
$tipo_vale = 'TODO';

$listavale = $method->invoke($controller, $fecha_inicio, $fecha_fin, $estado_id, $tipo_vale);

echo "Total records found: " . count($listavale) . "\n";

$sample = $listavale->take(3);

$html = View::make('reporte/excel/listavalerendirmasivo', [
    'listavale' => $sample,
    'titulo' => 'Vales-Rendir-Merge'
])->render();

$pos = strpos($html, '<table>');
echo substr($html, $pos);
echo "\n--- SUCCESS ---\n";
