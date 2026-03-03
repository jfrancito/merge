<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\OrdenPedidoCotizacionTraits;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;


class CotizacionOrdenPedidoController extends Controller
{
	 use OrdenPedidoCotizacionTraits;  

      public function actionCotizacionOrdenPedido($idopcion)
    {
        

        return view('ordenpedido.cotizacion.cotizacionordenpedido', [
          
            'funcion'                 => $this,
            'idopcion'                => $idopcion
        ]);
    }


}
