<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$trab199 = DB::table('STD.TRABAJADOR')->where('COD_TRAB', 'IATR000000000199')->first();
print_r($trab199);
$user199 = DB::table('users')->where('usuarioosiris_id', 'IATR000000000199')->first();
print_r($user199);

$trab61 = DB::table('STD.TRABAJADOR')->where('COD_TRAB', 'IATR000000000061')->first();
print_r($trab61);
