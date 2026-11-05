<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('ventas', 'orden_pedido_id')) {
    Schema::table('ventas', function (Blueprint $table) {
        $table->string('orden_pedido_id', 15)->nullable()->after('referencia_externa');
    });
    echo "Column orden_pedido_id added.";
} else {
    echo "Column already exists.";
}
