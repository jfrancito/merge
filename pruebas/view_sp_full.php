<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$spDef = DB::select("EXEC sp_helptext 'WEB.VALE_RENDIR_LISTAR'");
foreach ($spDef as $line) {
    echo $line->Text;
}
