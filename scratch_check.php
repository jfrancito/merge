<?php
define('LARAVEL_START', microtime(true));
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

class SimController {
    use App\Traits\ComprobanteTraits;
}

$sim = new SimController();
Session::put('empresas', DB::table('STD.EMPRESA')->where('COD_EMPR','=','IACHEM0000007086')->first());

$user = DB::table('users')->where('id', '=', '1CIX00000001')->first();
Session::put('usuario', $user);

$fecha_inicio = '01-01-2026';
$fecha_fin = '31-12-2026';
$proveedor_id = 'TODO';
$estado_id = 'TODO';
$cod_empresa = $user->usuarioosiris_id; // IITR000000000158
$operacion_id = 'ORDEN_COMPRA_ANTICIPO';

try {
    $ref = new ReflectionMethod(SimController::class, 'con_lista_cabecera_comprobante_total_gestion_estiba_excel');
    $ref->setAccessible(true);
    $listadatos = $ref->invoke($sim, $cod_empresa, $fecha_inicio, $fecha_fin, $proveedor_id, $estado_id, $operacion_id);
    
    echo "SUCCESS: Got " . count($listadatos) . " rows for ORDEN_COMPRA_ANTICIPO.\n";
    if (count($listadatos) > 0) {
        foreach($listadatos as $row) {
            echo "ID: " . $row->ID_DOCUMENTO . " | SERIE: " . $row->SERIE . " | NUMERO: " . $row->NUMERO . "\n";
        }
    }
} catch(\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
