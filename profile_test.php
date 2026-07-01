<?php
require __DIR__.'/bootstrap/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// --- ORIGINAL QUERIES ---
$start1 = microtime(true);
$orig_autoriza = DB::table('WEB.ListaplatrabajadoresGenereal')
    ->where(function ($query) {
        $query->where('cadcargo', 'LIKE', '%JEFE%')
            ->orWhere('cadcargo', 'COORDINADOR DE CONTROL DE CALIDAD')
            ->orWhere('COD_TRAB', 'IITR000000000391')
            ->orWhere('COD_TRAB', 'ICTR000000000250');
    })
    ->where('situacion_id', 'PRMAECEN000000000002')
    ->whereIn('empresa_osiris_id', [
        'IACHEM0000010394',
        'IACHEM0000007086'
    ])
    ->orderBy('apellidopaterno')
    ->orderBy('apellidomaterno')
    ->orderBy('nombres')
    ->pluck(
        DB::raw("
                        LTRIM(RTRIM(
                            ISNULL(apellidopaterno,'') + ' ' +
                            ISNULL(apellidomaterno,'') + ' ' +
                            ISNULL(nombres,'')
                        ))
                    "),
        'COD_TRAB'
    )
    ->toArray();
$dur1 = microtime(true) - $start1;

$start2 = microtime(true);
$orig_gerente = DB::table('WEB.ListaplatrabajadoresGenereal')
    ->where('cadcargo', 'LIKE', '%GERENTE%')
    ->where('situacion_id', 'PRMAECEN000000000002')
    ->whereIn('empresa_osiris_id', [
        'IACHEM0000010394',
        'IACHEM0000007086'
    ])
    ->orderBy('apellidopaterno')
    ->orderBy('apellidomaterno')
    ->orderBy('nombres')
    ->pluck(
        DB::raw("
                                    LTRIM(RTRIM(
                                        ISNULL(apellidopaterno,'') + ' ' +
                                        ISNULL(apellidomaterno,'') + ' ' +
                                        ISNULL(nombres,'')
                                    ))
                                "),
        'COD_TRAB'
    )
    ->toArray();
$dur2 = microtime(true) - $start2;

$start3 = microtime(true);
$orig_admin = DB::table('WEB.ListaplatrabajadoresGenereal')
    ->where('situacion_id', 'PRMAECEN000000000002')
    ->whereIn('empresa_osiris_id', [
        'IACHEM0000010394',
        'IACHEM0000007086'
    ])
    ->whereIn('cod_trab', [
        'IITR000000000391',
        'IATR000000000199'
    ])
    ->orderBy('apellidopaterno')
    ->orderBy('apellidomaterno')
    ->orderBy('nombres')
    ->pluck(
        DB::raw("
                                    LTRIM(RTRIM(
                                        ISNULL(apellidopaterno,'') + ' ' +
                                        ISNULL(apellidomaterno,'') + ' ' +
                                        ISNULL(nombres,'')
                                    ))
                                "),
        'COD_TRAB'
    )
    ->toArray();
$dur3 = microtime(true) - $start3;

echo "Original DB queries took: " . number_format($dur1 + $dur2 + $dur3, 4) . " seconds total.\n";

// --- BULK CONSOLIDATED QUERY ---
$start_bulk = microtime(true);
$trabajadores = DB::table('WEB.ListaplatrabajadoresGenereal')
    ->where('situacion_id', 'PRMAECEN000000000002')
    ->whereIn('empresa_osiris_id', [
        'IACHEM0000010394',
        'IACHEM0000007086'
    ])
    ->orderBy('apellidopaterno')
    ->orderBy('apellidomaterno')
    ->orderBy('nombres')
    ->get(['COD_TRAB', 'apellidopaterno', 'apellidomaterno', 'nombres', 'cadcargo']);

$trabajadoresMapped = $trabajadores->map(function($t) {
    $apellidopaterno = isset($t->apellidopaterno) ? trim($t->apellidopaterno) : '';
    $apellidomaterno = isset($t->apellidomaterno) ? trim($t->apellidomaterno) : '';
    $nombres = isset($t->nombres) ? trim($t->nombres) : '';
    $t->fullname = trim($apellidopaterno . ' ' . $apellidomaterno . ' ' . $nombres);
    return $t;
});

// 1. Jefe Autoriza
$bulk_autoriza = $trabajadoresMapped->filter(function($t) {
    $cargo = strtoupper($t->cadcargo);
    $cod = $t->COD_TRAB;
    return (strpos($cargo, 'JEFE') !== false)
        || ($cargo === 'COORDINADOR DE CONTROL DE CALIDAD')
        || ($cod === 'IITR000000000391')
        || ($cod === 'ICTR000000000250');
})->pluck('fullname', 'COD_TRAB')->toArray();

// 2. Aprueba Gerente
$bulk_gerente = $trabajadoresMapped->filter(function($t) {
    $cargo = strtoupper($t->cadcargo);
    return (strpos($cargo, 'GERENTE') !== false);
})->pluck('fullname', 'COD_TRAB')->toArray();

// 3. Aprueba Administracion
$bulk_admin = $trabajadoresMapped->filter(function($t) {
    $cod = $t->COD_TRAB;
    return in_array($cod, ['IITR000000000391', 'IATR000000000199']);
})->pluck('fullname', 'COD_TRAB')->toArray();

$dur_bulk = microtime(true) - $start_bulk;

echo "Bulk consolidated query + PHP filtering took: " . number_format($dur_bulk, 4) . " seconds.\n";

// --- VALIDATION ---
$diff_autoriza = array_diff_assoc($orig_autoriza, $bulk_autoriza) || array_diff_assoc($bulk_autoriza, $orig_autoriza);
$diff_gerente = array_diff_assoc($orig_gerente, $bulk_gerente) || array_diff_assoc($bulk_gerente, $orig_gerente);
$diff_admin = array_diff_assoc($orig_admin, $bulk_admin) || array_diff_assoc($bulk_admin, $orig_admin);

if (!$diff_autoriza && !$diff_gerente && !$diff_admin) {
    echo "SUCCESS: The outputs are IDENTICAL!\n";
} else {
    echo "WARNING: There are DIFFERENCES!\n";
    if ($diff_autoriza) echo "- Differences found in Autoriza\n";
    if ($diff_gerente) echo "- Differences found in Gerente\n";
    if ($diff_admin) echo "- Differences found in Admin\n";
}
