<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$fi_dmy = '01-01-2025';
$ff_dmy = '31-12-2025';

$q1 = DB::table('WEB.VALE_RENDIR as V')
    ->where(function ($query) use ($fi_dmy, $ff_dmy) {
        $query->whereBetween(DB::raw("CAST(V.FEC_USUARIO_CREA_AUD AS DATE)"), [$fi_dmy, $ff_dmy])
            ->orWhereBetween(DB::raw("CAST(V.FEC_USUARIO_MODIF_AUD AS DATE)"), [$fi_dmy, $ff_dmy]);
    })->count();

echo "Count with d-m-Y: " . $q1 . "\n";

$fi_ymd = date('Y-m-d', strtotime('01-01-2025'));
$ff_ymd = date('Y-m-d', strtotime('31-12-2025'));

$q2 = DB::table('WEB.VALE_RENDIR as V')
    ->where(function ($query) use ($fi_ymd, $ff_ymd) {
        $query->whereBetween(DB::raw("CAST(V.FEC_USUARIO_CREA_AUD AS DATE)"), [$fi_ymd, $ff_ymd])
            ->orWhereBetween(DB::raw("CAST(V.FEC_USUARIO_MODIF_AUD AS DATE)"), [$fi_ymd, $ff_ymd]);
    })->count();

echo "Count with Y-m-d: " . $q2 . "\n";
