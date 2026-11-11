<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select("
    SELECT c.TABLE_SCHEMA, c.TABLE_NAME, c.COLUMN_NAME
    FROM INFORMATION_SCHEMA.COLUMNS c
    JOIN INFORMATION_SCHEMA.TABLES t ON c.TABLE_SCHEMA = t.TABLE_SCHEMA AND c.TABLE_NAME = t.TABLE_NAME
    WHERE t.TABLE_TYPE = 'BASE TABLE'
    AND c.DATA_TYPE IN ('char', 'varchar', 'nvarchar', 'nchar')
    AND c.CHARACTER_MAXIMUM_LENGTH >= 12
");

echo "Total columns to scan: " . count($tables) . "\n";

foreach ($tables as $t) {
    $schema = $t->TABLE_SCHEMA;
    $tbl = $t->TABLE_NAME;
    $col = $t->COLUMN_NAME;
    $full = "[$schema].[$tbl]";
    try {
        $count = DB::select("SELECT COUNT(*) as cnt FROM $full WHERE [$col] = '1CIX00000080'")[0]->cnt;
        if ($count > 0) {
            echo "Found $count in $full.[$col]\n";
        }
    } catch (\Exception $e) {
        // echo "Error on $full: " . $e->getMessage() . "\n";
    }
}
