<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$userId = '1CIX00000080';
$trabId = 'IATR000000000061';

// Check all tables in current database that have user_id, usuario_id, cod_usuario, cod_personal, etc.
$tables = DB::select("
    SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE COLUMN_NAME IN ('usuario_id', 'user_id', 'cod_usuario', 'cod_personal', 'COD_USUARIO_REGISTRO', 'COD_TRABAJADOR', 'COD_PERSONAL')
");

echo "Checking tables for $userId / $trabId...\n";
foreach ($tables as $t) {
    $fullTable = $t->TABLE_SCHEMA . '.' . $t->TABLE_NAME;
    $col = $t->COLUMN_NAME;
    try {
        $count = DB::table($fullTable)->where($col, $userId)->count();
        if ($count > 0) {
            echo "MATCH ($fullTable.$col = '$userId'): $count records\n";
            $sample = DB::table($fullTable)->where($col, $userId)->take(5)->get();
            print_r($sample);
        }
        $count2 = DB::table($fullTable)->where($col, $trabId)->count();
        if ($count2 > 0) {
            echo "MATCH ($fullTable.$col = '$trabId'): $count2 records\n";
            $sample2 = DB::table($fullTable)->where($col, $trabId)->take(5)->get();
            print_r($sample2);
        }
    } catch (\Exception $e) {
        // ignore
    }
}
