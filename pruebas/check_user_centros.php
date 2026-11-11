<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== USER 80 centros ===\n";
print_r(DB::table('WEB.userempresacentros')->where('usuario_id', '1CIX00000080')->get());

echo "=== USER 401 centros ===\n";
print_r(DB::table('WEB.userempresacentros')->where('usuario_id', '1CIX00000401')->get());

echo "=== OTHER userempresacentros ===\n";
print_r(DB::table('WEB.userempresacentros')->take(10)->get());
