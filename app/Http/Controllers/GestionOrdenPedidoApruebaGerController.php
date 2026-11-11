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
use App\Modelos\FeDocumentoHistorial;

use Session;
use App\WEBRegla, App\STDEmpresa, APP\User, App\CMPCategoria;
use View;
use Validator;
use App\Biblioteca\NotaCredito;


class GestionOrdenPedidoApruebaGerController extends Controller
{
    use OrdenPedidoTraits;


    public function actionOrdenPedidoApruebaGer()
    {


        $cod_usuario_registro = Session::get('usuario')->id;
        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;


        $empresa_id = Session::get('empresas')->COD_EMPR;

        $listapedido = DB::connection('sqlsrv')->select("
            SELECT OP.*,
            STUFF((
                SELECT ' [SEP] ' + ARCH.NOMBRE_ARCHIVO + ' [FLD] ' + ARCH.URL_ARCHIVO
                FROM dbo.ARCHIVOS ARCH
                WHERE ARCH.ID_DOCUMENTO = OP.ID_PEDIDO
                AND ARCH.ACTIVO = 1
                FOR XML PATH(''), TYPE
            ).value('.', 'NVARCHAR(MAX)'), 1, 7, '') AS MULTI_ARCHIVOS
            FROM WEB.ORDEN_PEDIDO OP
            WHERE OP.ACTIVO = 1
            AND OP.COD_EMPR = ?
            ORDER BY OP.FEC_PEDIDO DESC
        ", [$empresa_id]);


        $listapedido = json_decode(json_encode($listapedido), true);



        return view('ordenpedido.ajax.apruebaordenpedidogerencia', [
            'listapedido' => $listapedido,
            'usuario_logueado_id' => $usuario_logueado_id,
            'cod_usuario_modifica' => $cod_usuario_registro,
            'ajax' => true,
        ]);
    }

    public function insertApruebaOrdenPedidoGer(Request $request)
    {
        ob_start();
        try {
            $id_buscar = $request->input('orden_pedido_id');
            $orden_pedido_id = $request->input('orden_pedido_id');

            $pedido = DB::table('WEB.ORDEN_PEDIDO')
                ->where('ID_PEDIDO', $orden_pedido_id)
                ->first();
            $estado = DB::table('CMP.CATEGORIA')
                ->where('TXT_GRUPO', 'ESTADO_MERGE')
                ->where('COD_CATEGORIA', 'ETM0000000000015')
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

            $pedido_db = DB::table('WEB.ORDEN_PEDIDO')->where('ID_PEDIDO', $orden_pedido_id)->first();
            $documento = new FeDocumentoHistorial;
            $documento->ID_DOCUMENTO = $orden_pedido_id;
            $documento->DOCUMENTO_ITEM = 1;
            
            $fecha_modif = !empty($pedido_db->FEC_USUARIO_MODIF_AUD) ? $pedido_db->FEC_USUARIO_MODIF_AUD : date('Y-m-d H:i:s');
            $documento->FECHA = date('Y-m-d\TH:i:s', strtotime($fecha_modif));
            
            $documento->USUARIO_ID = Session::get('usuario')->id;
            $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
            $documento->TIPO = 'AUTORIZACIÓN DE GERENCIA ÁREA';
            $documento->MENSAJE = '';
            $documento->save();

            ob_clean();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            ob_clean();
            \Log::error('Error al aprobar orden de pedido gerencia: ' . $e->getMessage());
            return response()->json(['success' => false, 'mensaje' => $e->getMessage()], 500);
        }
    }

    public function insertRechazarOrdenPedidoGer(Request $request)
    {
        ob_start();
        try {
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

            // Guardar motivo de rechazo
            DB::table('WEB.ORDEN_PEDIDO')
                ->where('ID_PEDIDO', $orden_pedido_id)
                ->update(['TXT_GLOSA_RECHAZO' => $request->input('motivo', '')]);

            $pedido_db = DB::table('WEB.ORDEN_PEDIDO')->where('ID_PEDIDO', $orden_pedido_id)->first();
            $documento = new FeDocumentoHistorial;
            $documento->ID_DOCUMENTO = $orden_pedido_id;
            $documento->DOCUMENTO_ITEM = 1;
            
            $fecha_modif = !empty($pedido_db->FEC_USUARIO_MODIF_AUD) ? $pedido_db->FEC_USUARIO_MODIF_AUD : date('Y-m-d H:i:s');
            $documento->FECHA = date('Y-m-d\TH:i:s', strtotime($fecha_modif));
            
            $documento->USUARIO_ID = Session::get('usuario')->id;
            $documento->USUARIO_NOMBRE = Session::get('usuario')->nombre;
            $documento->TIPO = 'PEDIDO RECHAZADO';
            $documento->MENSAJE = $request->input('motivo', '');
            $documento->save();

            ob_clean();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            ob_clean();
            \Log::error('Error al rechazar orden de pedido gerencia: ' . $e->getMessage());
            return response()->json(['success' => false, 'mensaje' => $e->getMessage()], 500);
        }
    }


    public function actionDetallePedidoGer(Request $request)
    {
        $id_buscar = $request->input('orden_pedido_id');

        $pedido = DB::table('WEB.ORDEN_PEDIDO')->where('ID_PEDIDO', $id_buscar)->first();
        
        $pedillodetalle = DB::table('WEB.ORDEN_PEDIDO_DETALLE as D')
            ->leftJoin('ALM.PRODUCTO as P', 'P.COD_PRODUCTO', '=', 'D.COD_PRODUCTO')
            ->where('D.ID_PEDIDO', $id_buscar)
            ->where('D.ACTIVO', 1)
            ->select('D.*', 'P.IND_MATERIAL_SERVICIO')
            ->get();


        $id_pedido = $pedillodetalle->pluck('ID_PEDIDO');
        $nom_producto = $pedillodetalle->pluck('NOM_PRODUCTO');
        $nom_categoria = $pedillodetalle->pluck('NOM_CATEGORIA');
        $cantidad = $pedillodetalle->pluck('CANTIDAD');
        $txt_observacion = $pedillodetalle->pluck('TXT_OBSERVACION');
        $can_precio = $pedillodetalle->pluck('CAN_PRECIO');

        $cod_usuario_session = Session::get('usuario')->usuarioosiris_id;

        $historial = DB::table('FE_DOCUMENTO_HISTORIAL')
            ->where('ID_DOCUMENTO', $id_buscar)
            ->orderBy('FECHA', 'asc')
            ->get();

        return view('ordenpedido.ajax.detalletabpedidoger', [
            'ajax' => true,
            'pedido' => $pedido,
            'id_pedido' => $id_pedido,
            'nom_producto' => $nom_producto,
            'nom_categoria' => $nom_categoria,
            'cantidad' => $cantidad,
            'txt_observacion' => $txt_observacion,
            'can_precio' => $can_precio,
            'pedillodetalle' => $pedillodetalle,
            'cod_usuario_session' => $cod_usuario_session,
            'historial' => $historial
        ]);
    }

    public function actionGuardarEditarDetalleGer(Request $request)
    {
        $orden_pedido_id = $request->input('orden_pedido_id');
        $cantidades = $request->input('cantidades');

        try {
            DB::beginTransaction();
            foreach ($cantidades as $item) {

                $detalleOriginal = DB::table('WEB.ORDEN_PEDIDO_DETALLE')
                    ->where('ID_PEDIDO', $orden_pedido_id)
                    ->where('COD_PRODUCTO', $item['cod_producto'])
                    ->first();

                if ($item['cantidad'] > $detalleOriginal->CANTIDAD) {
                    return response()->json([
                        'success' => false,
                        'mensaje' => "La cantidad para <b>{$detalleOriginal->NOM_PRODUCTO}</b> no puede ser mayor a la cantidad original (" . (int)$detalleOriginal->CANTIDAD . ")."
                    ]);
                }

                DB::table('WEB.ORDEN_PEDIDO_DETALLE')
                    ->where('ID_PEDIDO', $orden_pedido_id)
                    ->where('COD_PRODUCTO', $item['cod_producto'])
                    ->update(['CAN_MODIF_GER' => $item['cantidad']]);
            }
            DB::commit();
            $this->replicateOrdenPedidoToZona($orden_pedido_id);
            return response()->json(['success' => true, 'mensaje' => 'Cantidades actualizadas correctamente.']);
        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'mensaje' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

}
