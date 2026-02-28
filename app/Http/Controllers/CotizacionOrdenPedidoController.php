<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\OrdenPedidoTraits;
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
        $validarurl = $this->funciones->getUrl($idopcion, 'Ver');
        if ($validarurl <> 'true') {
            return $validarurl;
        }

        View::share('titulo', 'Lista Orden Pedido General');

        $empresa_sesion = Session::get('empresas');
        $usuario_id     = Session::get('usuario')->usuarioosiris_id;

        $combo_empresa = [
        $empresa_sesion->COD_EMPR => $empresa_sesion->NOM_EMPR
        ];

        /* =========================
           COMBOS GENERALES
        ========================== */

        $periodo_mes = DB::table('Web.periodos')
            ->whereIn('COD_EMPR', array_keys($combo_empresa))
            ->pluck('TXT_NOMBRE', 'COD_PERIODO')
            ->toArray();

        $combo_mes = ['' => 'Seleccione Mes'] + $periodo_mes;

       
        $periodo_anio = DB::table('Web.periodos')
            ->where('activo', 1)
            ->whereIn('COD_EMPR', array_keys($combo_empresa))
            ->pluck('anio', 'anio')
            ->toArray();

        $combo_anio = $periodo_anio;

        $anio_pedido = '';

        if (!empty($periodo_anio)) {
            $keys = array_keys($periodo_anio);
            $anio_pedido = $keys[0]; // primer año (el más reciente)
        }
        /* =========================
           OBTENER CENTRO DEL LOGUEADO
        ========================== */

        $empresa_id   = '';
        $mes_pedido   = '';
        $anio_pedido  = '';
       

      
        $listaordenpedidogeneral = $this->lg_lista_cabecera_pedido_consolidado_general($empresa_id,
            $mes_pedido,
            $anio_pedido
        );

        $listaordenpedidogeneralterminado = $this->lg_lista_cabecera_pedido_consolidado_general_terminado();


        return view('ordenpedido.consolidadogeneral.ordenpedidoconsolidadogeneral', [
            'listaordenpedidogeneral'        => $listaordenpedidogeneral,
            'listaordenpedidogeneralterminado' => $listaordenpedidogeneralterminado,
            'funcion'                 => $this,
            'empresa_id'              => $empresa_id,
            'combo_empresa'           => $combo_empresa,
            'combo_mes'               => $combo_mes,
            'mes_pedido'              => $mes_pedido,
            'combo_anio'              => $combo_anio,
            'anio_pedido'             => $anio_pedido,
            'idopcion'                => $idopcion
        ]);
    }


}
