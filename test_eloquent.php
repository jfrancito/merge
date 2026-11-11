<?php
require 'vendor/autoload.php'; 
$app = require_once 'bootstrap/app.php'; 
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); 

$productos = DB::table('ALM.PRODUCTO as P')->select('P.COD_PRODUCTO')->limit(10)->get();
$codigos_productos = $productos->pluck('COD_PRODUCTO')->toArray();
$start = microtime(true);
$ordenes_precios = [];
foreach ($codigos_productos as $cod) {
    try {
        $ultima = DB::table('CMP.ORDEN as OC')
            ->join('CMP.DETALLE_PRODUCTO as DP', 'OC.COD_ORDEN', '=', 'DP.COD_TABLA')
            ->join('CMP.CATEGORIA as CA', 'OC.COD_CATEGORIA_TIPO_ORDEN', '=', 'CA.COD_CATEGORIA')
            ->where('CA.TXT_GLOSA', 'COMPRAS')
            ->where('OC.COD_ESTADO', 1)
            ->where('DP.COD_ESTADO', 1)
            ->where('DP.COD_PRODUCTO', $cod)
            ->orderBy('OC.FEC_ORDEN', 'desc')
            ->select('DP.CAN_PRECIO_UNIT_IGV')
            ->first();
        if ($ultima) {
            $ordenes_precios[$cod] = $ultima->CAN_PRECIO_UNIT_IGV;
        }
    } catch (\Exception $e) {}
}
echo "Step 3 (10 queries individually): " . (microtime(true)-$start) . " seconds\n";
