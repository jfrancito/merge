<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\OrdenPedidoTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoMotivoValeRendir;
use App\Modelos\WEBValeRendir;
use App\Modelos\WEBValeRendirDetalle;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Facades\Log;

use Session;
use App\WEBRegla, App\STDEmpresa, APP\User, App\CMPCategoria;
use View;
use Validator;
use App\Biblioteca\NotaCredito;


class GestionOrdenPedidoAutorizaController extends Controller
{
    use OrdenPedidoTraits;  

   
    public function actionOrdenPedidoAutoriza()
    {

        
        $cod_usuario_registro = Session::get('usuario')->id;
        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;
        
        
       $listapedido = $this->listaOrdenPedido(
            "GEN",                 
            "",                    
            "1901-01-01",        
            "",                   
            0,                     
            "",                  
            "",                                        
            "",                   
            "",                    
            "",                   
            "",                   
            "",                    
            "",                    
            "",                    
            ""                     
         );


        return view('ordenpedido.ajax.autorizaordenpedido', [
                    'listapedido' => $listapedido,
                    'usuario_logueado_id' => $usuario_logueado_id,
                    'cod_usuario_modifica' => $cod_usuario_registro,  
                    'ajax'=>true,
        ]);
    }

    public function insertAutorizaOrdenPedido(Request $request)
    {
     
        $id_buscar = $request->input('orden_pedido_id'); 
        $orden_pedido_id = $request->input('orden_pedido_id');

        $pedido = DB::table('WEB.ORDEN_PEDIDO')
            ->where('ID_PEDIDO', $orden_pedido_id)
            ->first();
        $estado = DB::table('CMP.CATEGORIA')
            ->where('TXT_GRUPO', 'ESTADO_MERGE')
            ->where('COD_CATEGORIA', 'ETM0000000000013') 
            ->first();


            $this->insertOrdenPedido(
            'U',
            $id_buscar,
            $pedido->FEC_PEDIDO,
            $pedido->COD_PERIODO,
            $pedido->TXT_NOMBRE,
            $pedido->COD_ANIO,
            $pedido->COD_EMPR,
            $pedido->COD_CENTRO,
            $pedido->COD_TIPO_PEDIDO,
            $pedido->TXT_TIPO_PEDIDO,
            $pedido->COD_TRABAJADOR_SOLICITA,
            $pedido->TXT_TRABAJADOR_SOLICITA,
            $pedido->COD_TRABAJADOR_AUTORIZA,
            $pedido->TXT_TRABAJADOR_AUTORIZA,
            $pedido->COD_TRABAJADOR_APRUEBA_GER,
            $pedido->TXT_TRABAJADOR_APRUEBA_GER,
            $pedido->COD_TRABAJADOR_APRUEBA_ADM,
            $pedido->TXT_TRABAJADOR_APRUEBA_ADM,
            $pedido->TXT_GLOSA,
            $estado->COD_CATEGORIA,
            $estado->NOM_CATEGORIA,
            $pedido->COD_AREA,
            $pedido->TXT_AREA,
            true,
            ""
        );

        return response()->json([
            'success' => true
        ]);
    }

     public function insertRechazarOrdenPedido(Request $request)
    {
     
        $id_buscar = $request->input('orden_pedido_id'); 
        $orden_pedido_id = $request->input('orden_pedido_id');

        $pedido = DB::table('WEB.ORDEN_PEDIDO')
            ->where('ID_PEDIDO', $orden_pedido_id)
            ->first();
        $estado = DB::table('CMP.CATEGORIA')
            ->where('TXT_GRUPO', 'ESTADO_MERGE')
            ->where('NOM_CATEGORIA', 'RECHAZADO')
            ->first();


            $this->insertOrdenPedido(
            'R',
            $id_buscar,
            $pedido->FEC_PEDIDO,
            $pedido->COD_PERIODO,
            $pedido->TXT_NOMBRE,
            $pedido->COD_ANIO,
            $pedido->COD_EMPR,
            $pedido->COD_CENTRO,
            $pedido->COD_TIPO_PEDIDO,
            $pedido->TXT_TIPO_PEDIDO,
            $pedido->COD_TRABAJADOR_SOLICITA,
            $pedido->TXT_TRABAJADOR_SOLICITA,
            $pedido->COD_TRABAJADOR_AUTORIZA,
            $pedido->TXT_TRABAJADOR_AUTORIZA,
            $pedido->COD_TRABAJADOR_APRUEBA_GER,
            $pedido->TXT_TRABAJADOR_APRUEBA_GER,
            $pedido->COD_TRABAJADOR_APRUEBA_ADM,
            $pedido->TXT_TRABAJADOR_APRUEBA_ADM,
            $pedido->TXT_GLOSA,
            $estado->COD_CATEGORIA,
            $estado->NOM_CATEGORIA,
            $pedido->COD_AREA,
            $pedido->TXT_AREA,
            true,
            ""
        );

        return response()->json([
            'success' => true
        ]);
    }




     public function actionDetallePedido(Request $request)
    { 
         $id_buscar = $request->input('orden_pedido_id'); 

        
        $pedido = DB::table('WEB.ORDEN_PEDIDO')->where('ID_PEDIDO', $id_buscar)->first(); 
        $pedillodetalle = DB::table('WEB.ORDEN_PEDIDO_DETALLE')->where('ID_PEDIDO', $id_buscar)->get(); 

        
        $id_pedido = $pedillodetalle->pluck('ID_PEDIDO');
        $nom_producto = $pedillodetalle->pluck('NOM_PRODUCTO');
        $nom_categoria = $pedillodetalle->pluck('NOM_CATEGORIA');
        $cantidad = $pedillodetalle->pluck('CANTIDAD');
        $txt_observacion = $pedillodetalle->pluck('TXT_OBSERVACION');

        return view('ordenpedido.modal.modaldetallepedido', [
            'ajax'              => true,
            'pedido'            => $pedido,
            'id_pedido'         => $id_pedido,
            'nom_producto'      => $nom_producto,
            'nom_categoria'     => $nom_categoria,
            'cantidad'          => $cantidad,
            'txt_observacion'   => $txt_observacion,
            'pedillodetalle'    => $pedillodetalle
        ]);  
    }        
}
 




