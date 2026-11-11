<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\MontoOrdenPedidoTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoMotivoValeRendir;
use App\Modelos\WEBValeRendir;
use App\Modelos\WEBValeRendirDetalle;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;


class MontoOrdenPedidoController extends Controller

{
    use MontoOrdenPedidoTraits;


    public function actionMontoOrdenPedido(Request $request)
    {
        $usuarioSesion = Session::get('usuario');
        $usuario_solicita = $usuarioSesion->usuarioosiris_id;

        $empresaSesion = Session::get('empresas');



        $nombre_config = DB::table('WEB.MONTO_ORDEN_PEDIDO')
            ->where('COD_ESTADO', 1)
            ->pluck('TXT_AREA', 'COD_AREA')
            ->toArray();

        $combo1 = array('' => 'Seleccione ') + $nombre_config;


        $listamontopedido = $this->listaMontoOrdenPedido(
            "GEN",
            "",
            "",
            "",
            "",
            ""
        );


        return view('ordenpedido.monto.montoordenpedido', [
            'nombre_config' => $combo1,
            'combo1' => $combo1,
            'listamontopedido' => $listamontopedido,
            'ajax' => true
        ]);
    }

    public function actionModificarMontoOrdenPedido(Request $request)
    {
        $cod_area = $request->input('cod_area');
        $monto = $request->input('monto');

        try {
            DB::table('WEB.MONTO_ORDEN_PEDIDO')
                ->where('COD_AREA', $cod_area)
                ->update([
                'MONTO' => $monto,
                'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id,
                'FEC_USUARIO_MODIF_AUD' => date('Y-m-d\TH:i:s')
                
            ]);

            return response()->json([
                'success' => true,
                'mensaje' => 'Monto actualizado correctamente.'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al actualizar el monto: ' . $e->getMessage()
            ]);
        }
    }

}
