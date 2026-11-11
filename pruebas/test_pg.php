<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Modelos\VMergeDocumentoPg;
use App\Modelos\CMPDocAsociarCompra;

$item = VMergeDocumentoPg::where('COD_ESTADO', '=', '1')->first();
if ($item) {
    echo "Found PG: " . $item->COD_DOCUMENTO_CTBLE . "\n";
    $docs = CMPDocAsociarCompra::where('COD_ORDEN', $item->COD_DOCUMENTO_CTBLE)->get();
    echo "Existing docs count: " . count($docs) . "\n";
    foreach($docs as $d){
        echo "- " . $d->COD_CATEGORIA_DOCUMENTO . " | " . $d->NOM_CATEGORIA_DOCUMENTO . " | Oblig: " . $d->IND_OBLIGATORIO . "\n";
    }
} else {
    echo "No PG found with estado 1\n";
    $item = VMergeDocumentoPg::first();
    if ($item) {
        echo "Found any PG: " . $item->COD_DOCUMENTO_CTBLE . "\n";
    }
}
