<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$u = DB::table('users')->where('id', '1CIX00000080')->first();
echo "USER 1CIX00000080:\n";
print_r($u);

$u401 = DB::table('users')->where('id', '1CIX00000401')->first();
echo "\nUSER 1CIX00000401:\n";
print_r($u401);
