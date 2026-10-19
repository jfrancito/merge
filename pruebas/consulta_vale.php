<?php
require __DIR__ . '/../bootstrap/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== VALE ISRJAU0000000372 ===\n";
$vale = DB::table('WEB.VALE_RENDIR')->where('ID', 'ISRJAU0000000372')->first();
print_r($vale);

echo "\n=== USUARIO CREADOR 1CIX00000545 ===\n";
$user = DB::table('users')->where('id', '1CIX00000545')->first();
print_r($user);

if ($user) {
    echo "\n=== STD.TRABAJADOR FOR usuarioosiris_id: {$user->usuarioosiris_id} ===\n";
    $trab = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $user->usuarioosiris_id)->first();
    print_r($trab);

    if ($trab) {
        echo "\n=== STD.EMPRESA FOR NRO_DOCUMENTO: {$trab->NRO_DOCUMENTO} ===\n";
        $emp = DB::table('STD.EMPRESA')->where('NRO_DOCUMENTO', $trab->NRO_DOCUMENTO)->get();
        print_r($emp);
    }

    echo "\n=== terceros FOR user_id: {$user->id} ===\n";
    $ter = DB::table('terceros')->where('USER_ID', $user->id)->get();
    print_r($ter);
}

echo "\n=== STORED PROCEDURE WEB.VALE_RENDIR_IUD ===\n";
try {
    $proc = DB::select("EXEC sp_helptext 'WEB.VALE_RENDIR_IUD'");
    foreach ($proc as $line) {
        echo $line->Text;
    }
} catch (\Exception $e) {
    echo "Error getting proc: " . $e->getMessage() . "\n";
}
