<?php

namespace App\Helpers;

class NumeroALetras
{
    public static function convertir($numero, $moneda = 'NUEVOS SOLES')
    {
        $entero = floor($numero);
        $decimal = round(($numero - $entero) * 100);

        $formatter = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
        $enteroTexto = strtoupper($formatter->format($entero));

        return $enteroTexto . ' Y ' . str_pad($decimal, 2, '0', STR_PAD_LEFT) . '/100 ' . strtoupper($moneda);
    }
}
