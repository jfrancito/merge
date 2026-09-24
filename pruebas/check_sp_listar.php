<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Let's call WEB.VALE_RENDIR_LISTAR with ID = 'ISBEAU0000000243' or 'GEN'
$stmt = DB::connection('sqlsrv')->getPdo()->prepare("
    SET NOCOUNT ON;
    EXEC WEB.VALE_RENDIR_LISTAR
        @IND_TIPO_OPERACION = 'GEN',
        @ID = 'ISBEAU0000000243', 
        @COD_EMPR = 'IACHEM0000007086',
        @COD_CENTRO = 'CEN0000000000006',
        @USUARIO_AUTORIZA = '',
        @USUARIO_APRUEBA = '',
        @TIPO_MOTIVO = '',
        @TXT_GLOSA = '',
        @CAN_TOTAL_IMPORTE = 0.0,
        @CAN_TOTAL_SALDO = 0.0,
        @COD_USUARIO = ''
");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "=== RESULT FOR ISBEAU0000000243 with GEN ===\n";
print_r($results);

// Also let's check SP definition of WEB.VALE_RENDIR_LISTAR
$spDef = DB::select("EXEC sp_helptext 'WEB.VALE_RENDIR_LISTAR'");
echo "\n=== SP WEB.VALE_RENDIR_LISTAR DEFINITION ===\n";
foreach ($spDef as $line) {
    echo $line->Text;
}
