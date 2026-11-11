<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Modelos\CMPDocAsociarCompra;

$tarchivos = collect([
    (object)[
        'COD_CATEGORIA_DOCUMENTO' => 'DCC0000000000001',
        'NOM_CATEGORIA_DOCUMENTO' => 'ORDEN DE COMPRA',
        'TXT_FORMATO' => 'PDF',
        'IND_OBLIGATORIO' => 1
    ],
    (object)[
        'COD_CATEGORIA_DOCUMENTO' => 'DCC0000000000006',
        'NOM_CATEGORIA_DOCUMENTO' => 'INFORME',
        'TXT_FORMATO' => 'PDF',
        'IND_OBLIGATORIO' => 0
    ],
]);

$rutaorden = '';

$html = View::make('comprobantesx.lista.detallecomprobanteadministradornuevosxpg', [
    'tarchivos' => $tarchivos,
    'rutaorden' => $rutaorden,
    'fedocumento' => (object)[
        'DOCUMENTO_ITEM' => 1,
        'RUC_PROVEEDOR' => '20000000001',
        'RZ_PROVEEDOR' => 'PROVEEDOR TEST',
        'SERIE' => 'F001',
        'NUMERO' => '123',
        'FEC_VENTA' => '20261019',
        'FEC_VENCI_PAGO' => '20261019',
        'TOTAL_VENTA_ORIG' => 100.00,
        'SERIE_ANTICIPO' => '',
        'NRO_ANTICIPO' => '',
        'MONTO_ANTICIPO_DESC' => 0,
        'MONTO_ANTICIPO_DESC_OTROS' => 0,
        'ind_errototal' => ''
    ],
    'ordencompra' => (object)[
        'COD_DOCUMENTO_CTBLE' => 'IILMGTO000001394',
        'FEC_EMISION' => '2026-10-19',
        'FEC_ORDEN' => '2026-10-19',
        'TXT_EMPR_EMISOR' => 'PROVEEDOR DEMO',
        'COD_EMPR' => 'EMP001',
        'CAN_TOTAL' => 100.00,
        'CAN_DETRACCION' => 0,
        'COD_CATEGORIA_MONEDA' => 'MON0000000000001',
        'TXT_CATEGORIA_MONEDA' => 'SOLES'
    ],
    'ordencompra_f' => (object)[
        'COD_EMPR' => 'EMP001',
        'TXT_DETRACCION' => '',
        'CAN_PERCEPCION' => 0,
        'CAN_RETENCION' => 0,
        'CAN_DETRACCION' => 0
    ],
    'tp' => (object)['NOM_CATEGORIA' => 'CONTADO'],
    'rutafila' => '',
    'detalleordencompra' => collect([]),
    'procedencia' => 'PROVISION',
    'idopcion' => 'k5X',
    'combobancos' => [],
    'combocb' => [],
    'cb_id' => '',
    'user_orden' => (object)['contacto_nombre' => 'TEST'],
    'empresa' => (object)['NRO_DOCUMENTO' => '20000000001', 'NOM_EMPR' => 'TEST EMPRESA', 'TXT_DETRACCION' => ''],
    'combotipodetraccion' => [],
    'combopagodetraccion' => [],
    'monto_anticipo' => 0,
    'listaanticipo' => [],
    'arrayitem' => [],
    'comboant' => [],
    'combocontacto' => [],
    'contacto' => (object)['nombre' => 'TEST CONTACTO', 'id' => '1'],
    'usuario' => (object)['NOM_USUARIO' => 'TEST USUARIO', 'NOM_TRABAJADOR' => 'CONTACTO TEST', 'COD_TRABAJADOR' => 'TRAB001'],
    'funcion' => new class {
        public function decodificarmaestraprefijo_contrato($a, $b) { return $a; }
    }
])->render();

// Check if DCC0000000000001 is present and required
if (strpos($html, 'id="file-DCC0000000000001"') !== false && strpos($html, 'name="DCC0000000000001[]"') !== false) {
    echo "DCC0000000000001 (ORDEN DE COMPRA) found.\n";
}

// Check if DCC0000000000006 is present and NOT required
if (strpos($html, 'id="file-DCC0000000000006"') !== false && strpos($html, 'name="DCC0000000000006[]"') !== false) {
    echo "DCC0000000000006 (INFORME) found.\n";
}

// Extract the input tag for DCC0000000000006
preg_match('/<input[^>]*id="file-DCC0000000000006"[^>]*>/', $html, $matches);
if (!empty($matches)) {
    echo "Input tag for DCC0000000000006: " . $matches[0] . "\n";
    if (strpos($matches[0], 'required') === false) {
        echo "SUCCESS: DCC0000000000006 is NOT required!\n";
    } else {
        echo "ERROR: DCC0000000000006 has required!\n";
    }
}

// Extract the input tag for DCC0000000000001
preg_match('/<input[^>]*id="file-DCC0000000000001"[^>]*>/', $html, $matches1);
if (!empty($matches1)) {
    echo "Input tag for DCC0000000000001: " . $matches1[0] . "\n";
    if (strpos($matches1[0], 'required') !== false) {
        echo "SUCCESS: DCC0000000000001 IS required!\n";
    } else {
        echo "ERROR: DCC0000000000001 is NOT required!\n";
    }
}
