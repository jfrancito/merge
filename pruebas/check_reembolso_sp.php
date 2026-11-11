<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $spDef = DB::select("EXEC sp_helptext 'WEB.VALE_RENDIR_REEMBOLSO_LISTAR'");
    foreach ($spDef as $line) {
        echo $line->Text;
    }
} catch (\Exception $e) {
    echo "No SP WEB.VALE_RENDIR_REEMBOLSO_LISTAR or error: " . $e->getMessage();
}
