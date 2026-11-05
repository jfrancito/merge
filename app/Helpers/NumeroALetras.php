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

    public static function fechaBonita($fecha)
    {
        $fecha = \Carbon\Carbon::parse($fecha);
        $meses = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo',
            4 => 'abril', 5 => 'mayo', 6 => 'junio',
            7 => 'julio', 8 => 'agosto', 9 => 'septiembre',
            10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        ];
        return $fecha->format('d') . ' de ' . $meses[$fecha->format('n')] . ' de ' . $fecha->format('Y');
    }

}
