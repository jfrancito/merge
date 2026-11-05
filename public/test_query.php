<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Start session manually
    $request = Illuminate\Http\Request::capture();
    $request->setLaravelSession($app->make('session')->driver());
    session(['empresa_id' => '1CIX00000002']);

    $q = 'producto';
    $productos = \App\Models\Producto::where('activo', 1)
        ->where(function ($query) use ($q) {
            $query->where('descripcion', 'ILIKE', "%$q%")
                ->orWhere('codigo', 'ILIKE', "%$q%");
        })
        ->limit(10)
        ->get();

    echo "Query successful! Count: " . $productos->count() . "\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
