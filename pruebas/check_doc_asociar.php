<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$keys = DB::select("
    SELECT COLUMN_NAME, CONSTRAINT_NAME 
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
    WHERE TABLE_NAME = 'DOC_ASOCIAR_COMPRA' AND TABLE_SCHEMA = 'CMP'
");
print_r($keys);
