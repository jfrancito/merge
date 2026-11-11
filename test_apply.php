<?php
require 'vendor/autoload.php'; 
$app = require_once 'bootstrap/app.php'; 
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); 

$productos = DB::table('ALM.PRODUCTO as P')->select('P.COD_PRODUCTO')->limit(100)->get();
$codigos_productos = $productos->pluck('COD_PRODUCTO')->toArray();
if (count($codigos_productos) > 0) {
    $union_queries = array_map(function($c) { return "SELECT '$c' AS COD_PRODUCTO"; }, $codigos_productos);
    $query_outer_apply = "
        SELECT p.COD_PRODUCTO, ultima.CAN_PRECIO_UNIT_IGV AS PRECIO_ULTIMA_ORDEN
        FROM (
            " . implode(" UNION ALL ", $union_queries) . "
        ) p
        OUTER APPLY (
            SELECT TOP 1 DP.CAN_PRECIO_UNIT_IGV
            FROM CMP.ORDEN OC
            INNER JOIN CMP.DETALLE_PRODUCTO DP ON OC.COD_ORDEN = DP.COD_TABLA 
            INNER JOIN CMP.CATEGORIA CA ON OC.COD_CATEGORIA_TIPO_ORDEN = CA.COD_CATEGORIA AND CA.TXT_GLOSA = 'COMPRAS'
            WHERE OC.COD_ESTADO = 1 
            AND DP.COD_ESTADO = 1
            AND DP.COD_PRODUCTO = p.COD_PRODUCTO
            ORDER BY OC.FEC_ORDEN DESC
        ) ultima
    ";
    $start = microtime(true);
    $ultimas_ordenes_apply = DB::select($query_outer_apply);
    echo "Step 3 (OUTER APPLY query with 100 codes): " . (microtime(true)-$start) . " seconds\n";
}
