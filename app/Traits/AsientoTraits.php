<?php

namespace App\Traits;

use App\Modelos\WEBAsiento;

trait AsientoTraits
{
    private function lista_asientos_fe($COD_EMPR, $COD_PERIODO)
    {

        return WEBAsiento::where('COD_ESTADO', '=', 1)
            ->where('COD_EMPR', '=', $COD_EMPR)
            ->where('COD_PERIODO', '=', $COD_PERIODO)
            ->where('TXT_TIPO_REFERENCIA', 'LIKE', 'dbo%')
            ->get();

    }
}
