<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

$vr = DB::table('WEB.VALE_RENDIR')->first();
$emprObj = new stdClass();
$emprObj->COD_EMPR = $vr ? $vr->COD_EMPR : 'IACHEM0000010394';
Session::put('empresas', $emprObj);

$controller = new App\Http\Controllers\GestionValeRendirController();

$reflection = new ReflectionClass($controller);
$method = $reflection->getMethod('lg_lista_cabecera_vale_rendir_excel');
$method->setAccessible(true);

// Let's filter around June 2025 where IICHAU0000000001 has detail
$fecha_inicio = '2025-06-23';
$fecha_fin = '2025-06-23';
$estado_id = 'TODO';
$tipo_vale = 'RENDIR';

$listavale = $method->invoke($controller, $fecha_inicio, $fecha_fin, $estado_id, $tipo_vale);

echo "Total records found: " . count($listavale) . "\n";

$html = View::make('reporte/excel/listavalerendirmasivo', [
    'listavale' => $listavale->take(2),
    'titulo' => 'Vales-Rendir-Merge'
])->render();

$pos = strpos($html, '<table>');
echo substr($html, $pos);
echo "\n--- SUCCESS ---\n";
