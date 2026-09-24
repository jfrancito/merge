<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$u80 = DB::table('users')->where('id', '1CIX00000080')->first();
$u401 = DB::table('users')->where('id', '1CIX00000401')->first();

echo "User 80: " . json_encode($u80) . "\n";
echo "User 401: " . json_encode($u401) . "\n";

// Check if there are user-centro or user-empresa assignments
$allTables = DB::select("SELECT TABLE_SCHEMA + '.' + TABLE_NAME as tbl FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'");
foreach ($allTables as $t) {
    $tbl = $t->tbl;
    if (stripos($tbl, 'usuario') !== false || stripos($tbl, 'user') !== false || stripos($tbl, 'permiso') !== false || stripos($tbl, 'regla') !== false || stripos($tbl, 'centro') !== false) {
        // let's see columns
        $cols = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA + '.' + TABLE_NAME = '$tbl'");
        $colNames = array_map(function($c) { return $c->COLUMN_NAME; }, $cols);
        $foundCols = array_intersect(['user_id', 'usuario_id', 'id_usuario', 'COD_USUARIO', 'COD_TRABAJADOR', 'COD_PERSONAL', 'id'], $colNames);
        if (!empty($foundCols)) {
            foreach ($foundCols as $fc) {
                try {
                    $c80 = DB::table($tbl)->where($fc, '1CIX00000080')->orWhere($fc, 'IATR000000000061')->count();
                    if ($c80 > 0) {
                        echo "Found in $tbl.$fc for user 80: $c80 rows\n";
                        $rows = DB::table($tbl)->where($fc, '1CIX00000080')->orWhere($fc, 'IATR000000000061')->get();
                        print_r($rows);
                    }
                } catch (\Exception $e) {}
            }
        }
    }
}
