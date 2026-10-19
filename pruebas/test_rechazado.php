<?php
require __DIR__.'/../bootstrap/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\DB;

echo "=== FE_DOCUMENTO Columns / Sample ===\n";
$fe = DB::table('FE_DOCUMENTO')->orderBy('ID_DOCUMENTO', 'desc')->take(1)->get();
print_r($fe);

echo "\n=== Search by ID_DOCUMENTO = '00014917X' or SERIE / DOC ===\n";
$res1 = DB::table('FE_DOCUMENTO')->where('ID_DOCUMENTO', 'like', '%00014917X%')->get();
print_r($res1);

$res2 = DB::table('FE_DOCUMENTO_HISTORIAL')->where('ID_DOCUMENTO', 'like', '%00014917X%')->get();
print_r($res2);

$tipodoc_id = 'TDO0000000000086';
$estado_no = 'ETM0000000000006';
$cod_empr_session = 'IACHEM0000010394';

$combo = DB::table('VMERGEDOCUMENTOS')
    ->leftJoin('VMERGEDOCUMENTO_INTERNO_COMPRA', function($leftJoin) {
        $leftJoin->on('VMERGEDOCUMENTO_INTERNO_COMPRA.ID_DOCUMENTO', '=', 'VMERGEDOCUMENTOS.COD_DOCUMENTO_CTBLE');
    })
    ->leftJoin('FE_DOCUMENTO', function ($leftJoin) use ($estado_no){
        $leftJoin->on('FE_DOCUMENTO.ID_DOCUMENTO', '=', 'VMERGEDOCUMENTO_INTERNO_COMPRA.LOTE')
            ->where('FE_DOCUMENTO.COD_ESTADO', '<>', 'ETM0000000000006');
    })
    ->where('VMERGEDOCUMENTOS.COD_EMPR', '=', $cod_empr_session)
    ->where(function ($query) {
        $query->where('VMERGEDOCUMENTO_INTERNO_COMPRA.ESTATUS', '=', 'OFF')
              ->orWhereNull('VMERGEDOCUMENTO_INTERNO_COMPRA.ESTATUS')
              ->orwhere('VMERGEDOCUMENTO_INTERNO_COMPRA.ESTATUS', '=', '')
              ->orWhereRaw("CAN_TOTAL <> COALESCE(VMERGEDOCUMENTO_INTERNO_COMPRA.TOTAL_MERGE, 0)");
    })
    ->where(function ($query) {
        $query->where('FE_DOCUMENTO.COD_ESTADO', '=', 'ETM0000000000001')
              ->orWhereNull('FE_DOCUMENTO.COD_ESTADO')
              ->orwhere('FE_DOCUMENTO.COD_ESTADO', '=', '');
    })
    ->where('VMERGEDOCUMENTOS.COD_ESTADO', '=', '1')
    ->where('COD_CATEGORIA_TIPO_DOC', '=', $tipodoc_id)
    ->pluck('TXT_EMPR_EMISOR', 'COD_EMPR_EMISOR')
    ->toArray();

echo "Combo count: " . count($combo) . "\n";
print_r($combo);

