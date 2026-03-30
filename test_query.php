<?php
require 'vendor/autoload.php'; 
$app = require_once 'bootstrap/app.php'; 
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); 

$term = 'ARTI';
$empresa = 'IACHEM0000007086'; // Just a guess

$start = microtime(true);
$productos = DB::table('ALM.PRODUCTO as P')
    ->leftJoin('CMP.CATEGORIA as CAT', 'P.COD_CATEGORIA_UNIDAD_MEDIDA', '=', 'CAT.COD_CATEGORIA')
    // ->where('P.COD_EMPR', $empresa)
    ->where('P.COD_ESTADO', 1)
    ->where(function ($sub) use ($term) {
        $sub->where('P.NOM_PRODUCTO', 'LIKE', '%' . $term . '%')
            ->orWhere('P.COD_PRODUCTO', 'LIKE', '%' . $term . '%');
    })
    ->select('P.COD_PRODUCTO')
    ->limit(100)
    ->get();
echo "Step 1 (ALM.PRODUCTO search): " . (microtime(true) - $start) . " seconds\n";

$codigos_productos = $productos->pluck('COD_PRODUCTO')->toArray();
$codigos_string = "'" . implode("','", $codigos_productos) . "'";

$start2 = microtime(true);
$ultimas_ordenes = DB::select("
    SELECT 
        DP.COD_PRODUCTO,
        DP.CAN_PRECIO_UNIT_IGV AS PRECIO_ULTIMA_ORDEN
    FROM (
        SELECT 
            DP.COD_PRODUCTO,
            DP.CAN_PRECIO_UNIT_IGV,
            ROW_NUMBER() OVER (
                PARTITION BY DP.COD_PRODUCTO
                ORDER BY OC.FEC_ORDEN DESC
            ) AS RN
        FROM CMP.ORDEN OC
        INNER JOIN CMP.DETALLE_PRODUCTO DP ON OC.COD_ORDEN = DP.COD_TABLA 
        INNER JOIN CMP.CATEGORIA CA ON OC.COD_CATEGORIA_TIPO_ORDEN = CA.COD_CATEGORIA AND CA.TXT_GLOSA = 'COMPRAS'
        WHERE OC.COD_ESTADO = 1 
        AND DP.COD_ESTADO = 1
        AND DP.COD_PRODUCTO IN ($codigos_string)
    ) DP
    WHERE DP.RN = 1
");
echo "Step 2 (ROW_NUMBER query): " . (microtime(true) - $start2) . " seconds\n";

// Now test with CROSS APPLY
$start3 = microtime(true);
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
    $ultimas_ordenes_apply = DB::select($query_outer_apply);
}
echo "Step 3 (OUTER APPLY query): " . (microtime(true) - $start3) . " seconds\n";

