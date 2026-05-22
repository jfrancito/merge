<?php

namespace App\Traits;

use App\Modelos\WEBValeRendir;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, App\CMPCategoria;
use App\Modelos\STDTrabajadorVale;
use App\User;
use Session;
use PDO;

trait OrdenPedidoCotizacionTraits

{
	public function insertOrdenCotizacion($ind_tipo_operacion,$id_cotizacion,$fec_cotizacion,$nro_serie,$nro_doc,$cod_empr,$cod_centro,$nro_ruc,
    $cod_empr_proveedor,$nom_empr_proveedor,$txt_telefono,$cod_direccion,$nom_direccion,$fec_validez,$fec_entrega,$cod_categoria_moneda,
    $txt_categoria_moneda,$cod_categoria_tipo_pago,$txt_categoria_tipo_pago,$txt_observacion,$can_total, $ind_igv, $cod_estado,$txt_estado,$activo,
    $cod_usuario_registro)
	{
	    try {

	        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('
	            SET NOCOUNT ON;
	            EXEC WEB.ORDEN_COTIZACION_IUD
	                @IND_TIPO_OPERACION = ?,
	                @ID_COTIZACION = ?,
	                @FEC_COTIZACION = ?,
	                @NRO_SERIE = ?,
	                @NRO_DOC = ?,
	                @COD_EMPR = ?,
	                @COD_CENTRO = ?,
	                @NRO_RUC = ?,
	                @COD_EMPR_PROVEEDOR = ?,
	                @NOM_EMPR_PROVEEDOR = ?,
	                @TXT_TELEFONO = ?,
	                @COD_DIRECCION = ?,
	                @NOM_DIRECCION = ?,
	                @FEC_VALIDEZ = ?,
	                @FEC_ENTREGA = ?,
	                @COD_CATEGORIA_MONEDA = ?,
	                @TXT_CATEGORIA_MONEDA = ?,
	                @COD_CATEGORIA_TIPO_PAGO = ?,
	                @TXT_CATEGORIA_TIPO_PAGO = ?,
	                @TXT_OBSERVACION = ?,
	                @CAN_TOTAL = ?,
	                @IND_IGV = ?,
	                @COD_ESTADO = ?,
	                @TXT_ESTADO = ?,
	                @ACTIVO = ?,
	                @COD_USUARIO_REGISTRO = ?
	        ');

	        // 🔐 valores de sesión (igual que tu lógica)
	        $cod_usuario_registro = Session::get('usuario')->id;
	        $cod_empr = Session::get('empresas')->COD_EMPR;

	        // 🔗 Bind params
	        $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
	        $stmt->bindParam(2, $id_cotizacion, PDO::PARAM_STR);
	        $stmt->bindParam(3, $fec_cotizacion, PDO::PARAM_STR);
	        $stmt->bindParam(4, $nro_serie, PDO::PARAM_STR);
	        $stmt->bindParam(5, $nro_doc, PDO::PARAM_STR);
	        $stmt->bindParam(6, $cod_empr, PDO::PARAM_STR);
	        $stmt->bindParam(7, $cod_centro, PDO::PARAM_STR);
	        $stmt->bindParam(8, $nro_ruc, PDO::PARAM_STR);
	        $stmt->bindParam(9, $cod_empr_proveedor, PDO::PARAM_STR);
	        $stmt->bindParam(10, $nom_empr_proveedor, PDO::PARAM_STR);
	        $stmt->bindParam(11, $txt_telefono, PDO::PARAM_STR);
	        $stmt->bindParam(12, $cod_direccion, PDO::PARAM_STR);
	        $stmt->bindParam(13, $nom_direccion, PDO::PARAM_STR);
	        $stmt->bindParam(14, $fec_validez, PDO::PARAM_STR);
	        $stmt->bindParam(15, $fec_entrega, PDO::PARAM_STR);
	        $stmt->bindParam(16, $cod_categoria_moneda, PDO::PARAM_STR);
	        $stmt->bindParam(17, $txt_categoria_moneda, PDO::PARAM_STR);
	        $stmt->bindParam(18, $cod_categoria_tipo_pago, PDO::PARAM_STR);
	        $stmt->bindParam(19, $txt_categoria_tipo_pago, PDO::PARAM_STR);
	        $stmt->bindParam(20, $txt_observacion, PDO::PARAM_STR);
	        $stmt->bindParam(21, $can_total); // decimal
	        $stmt->bindParam(22, $ind_igv, PDO::PARAM_INT);
	        $stmt->bindParam(23, $cod_estado, PDO::PARAM_STR);
	        $stmt->bindParam(24, $txt_estado, PDO::PARAM_STR);
	        $stmt->bindParam(25, $activo, PDO::PARAM_INT);
	        $stmt->bindParam(26, $cod_usuario_registro, PDO::PARAM_STR);

	        $stmt->execute();

	        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
	        $id_cotizacion_res = $resultado['ID_COTIZACION'];

	        // 🔗 Réplica en Zonas
	        $conexionbd = 'sqlsrv';
	        if($cod_centro == 'CEN0000000000004'){
	            $conexionbd = 'sqlsrv_r';
	        }else{
	            if($cod_centro == 'CEN0000000000006'){
	                $conexionbd = 'sqlsrv_b';
	            }
	        }

	        if ($conexionbd !== 'sqlsrv') {
	            try {
	                // 1. Obtener la cabecera completa recién insertada/actualizada de la base central
	                $cabecera = DB::connection('sqlsrv')->table('WEB.ORDEN_COTIZACION')
	                    ->where('ID_COTIZACION', $id_cotizacion_res)
	                    ->first();

	                if ($cabecera) {
	                    // Formatear fechas de manera inequívoca para SQL Server en zonas
	                    $safe_format_dates = function($array) {
	                        foreach ($array as $key => $value) {
	                            if (is_string($value)) {
	                                if (preg_match('/^(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2}:\d{2}(\.\d+)?)$/', $value, $matches)) {
	                                    $array[$key] = $matches[1] . 'T' . $matches[2];
	                                }
	                                elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $matches)) {
	                                    $array[$key] = $matches[1] . $matches[2] . $matches[3];
	                                }
	                            }
	                        }
	                        return $array;
	                    };

	                    $cab_array = $safe_format_dates((array)$cabecera);

	                    // Sincronizar directamente a la tabla sin requerir SP en la zona
	                    DB::connection($conexionbd)->table('WEB.ORDEN_COTIZACION')
	                        ->updateOrInsert(
	                            ['ID_COTIZACION' => $id_cotizacion_res],
	                            $cab_array
	                        );
	                }
	            } catch (\Exception $ez) {
	                Log::error('Error al replicar cotización cabecera a zona (' . $conexionbd . '): ' . $ez->getMessage());
	            }
	        }

	        return $id_cotizacion_res;

	    } catch (\Exception $e) {
	        Log::error('Error al insertar cotización: ' . $e->getMessage());
	        throw $e;
	    }
	}

	public function insertOrdenCotizacionDetalle($ind_tipo_operacion,$id_cotizacion,$id_consolidado, $cod_empr,$cod_centro,$cod_producto,$nom_producto,
		$cod_categoria_medida,$nom_categoria_medida,$cantidad,$precio, $precio_igv,  $cod_categoria_familia,$nom_categoria_familia,$activo,
	    $cod_usuario_registro)
	{
	    try {

	        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('
	            SET NOCOUNT ON;
	            EXEC WEB.ORDEN_COTIZACION_DETALLE_IUD
	                @IND_TIPO_OPERACION = ?,
	                @ID_COTIZACION = ?,
                    @ID_PEDIDO_CONSOLIDADO_GENERAL = ?,
	                @COD_EMPR = ?,
	                @COD_CENTRO = ?,
	                @COD_PRODUCTO = ?,
	                @NOM_PRODUCTO = ?,
	                @COD_CATEGORIA_MEDIDA = ?,
	                @NOM_CATEGORIA_MEDIDA = ?,
	                @CANTIDAD = ?,
	                @CAN_PRECIO = ?,
	                @CAN_PRECIO_IGV = ?,
	                @COD_CATEGORIA_FAMILIA = ?,
	                @NOM_CATEGORIA_FAMILIA = ?,
	                @ACTIVO = ?,
	                @COD_USUARIO_REGISTRO = ?
	        ');

	        // 🔐 valores de sesión (igual que tu lógica)
	        $cod_usuario_registro = Session::get('usuario')->id;
	        $cod_empr = Session::get('empresas')->COD_EMPR;

	        // 🔗 Bind params
	        $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
	        $stmt->bindParam(2, $id_cotizacion, PDO::PARAM_STR);
            $stmt->bindParam(3, $id_consolidado, PDO::PARAM_STR);
	        $stmt->bindParam(4, $cod_empr, PDO::PARAM_STR);
	        $stmt->bindParam(5, $cod_centro, PDO::PARAM_STR);
	        $stmt->bindParam(6, $cod_producto, PDO::PARAM_STR);
	        $stmt->bindParam(7, $nom_producto, PDO::PARAM_STR);
	        $stmt->bindParam(8, $cod_categoria_medida, PDO::PARAM_STR);
	        $stmt->bindParam(9, $nom_categoria_medida, PDO::PARAM_STR);
	        $stmt->bindParam(10, $cantidad, PDO::PARAM_STR);
	        $stmt->bindParam(11, $precio, PDO::PARAM_STR); // CAN_PRECIO
	        $stmt->bindParam(12, $precio_igv, PDO::PARAM_STR); // CAN_PRECIO_IGV
	        $stmt->bindParam(13, $cod_categoria_familia, PDO::PARAM_STR);
	        $stmt->bindParam(14, $nom_categoria_familia, PDO::PARAM_STR);
	        $stmt->bindParam(15, $activo, PDO::PARAM_INT);
	        $stmt->bindParam(16, $cod_usuario_registro, PDO::PARAM_STR);

	        $stmt->execute();

	        // 🔗 Réplica en Zonas
	        $conexionbd = 'sqlsrv';
	        if($cod_centro == 'CEN0000000000004'){
	            $conexionbd = 'sqlsrv_r';
	        }else{
	            if($cod_centro == 'CEN0000000000006'){
	                $conexionbd = 'sqlsrv_b';
	            }
	        }

	        if ($conexionbd !== 'sqlsrv') {
	            try {
	                // 1. Obtener el detalle completo recién insertado/actualizado de la base central
	                $detalle = DB::connection('sqlsrv')->table('WEB.ORDEN_COTIZACION_DETALLE')
	                    ->where('ID_COTIZACION', $id_cotizacion)
	                    ->where('COD_PRODUCTO', $cod_producto)
	                    ->first();

	                if ($detalle) {
	                    // Formatear fechas de manera inequívoca para SQL Server en zonas
	                    $safe_format_dates = function($array) {
	                        foreach ($array as $key => $value) {
	                            if (is_string($value)) {
	                                if (preg_match('/^(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2}:\d{2}(\.\d+)?)$/', $value, $matches)) {
	                                    $array[$key] = $matches[1] . 'T' . $matches[2];
	                                }
	                                elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $matches)) {
	                                    $array[$key] = $matches[1] . $matches[2] . $matches[3];
	                                }
	                            }
	                        }
	                        return $array;
	                    };

	                    $det_array = $safe_format_dates((array)$detalle);

	                    // Sincronizar directamente a la tabla sin requerir SP en la zona
	                    DB::connection($conexionbd)->table('WEB.ORDEN_COTIZACION_DETALLE')
	                        ->updateOrInsert(
	                            ['ID_COTIZACION' => $id_cotizacion, 'COD_PRODUCTO' => $cod_producto],
	                            $det_array
	                        );
	                }
	            } catch (\Exception $ez) {
	                Log::error('Error al replicar cotización detalle a zona (' . $conexionbd . '): ' . $ez->getMessage());
	            }
	        }

	    } catch (\Exception $e) {
	        Log::error('Error al insertar cotización detalle: ' . $e->getMessage());
	        throw $e;
	    }
	}
}
