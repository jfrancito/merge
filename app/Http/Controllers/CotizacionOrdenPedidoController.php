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
        $combo_tipo_pago = DB::table('CMP.CATEGORIA')
            ->where('TXT_GRUPO', 'TIPO_PAGO')
            ->where('COD_ESTADO', 1)
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();
        $combo_tipo_pago = ['' => 'Seleccione tipo de pago'] + $combo_tipo_pago;

        $combo_moneda = DB::table('CMP.CATEGORIA')
            ->whereIn('COD_CATEGORIA', ['MOM0000000000001', 'MOM0000000000002'])
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();
        $combo_moneda = ['' => 'Seleccione moneda'] + $combo_moneda;

        // Calcular correlativo siguiendo la lógica del SP
        $empresa_sesion = Session::get('empresas');
        $usuario_id = Session::get('usuario')->usuarioosiris_id;

        // Obtener el centro del trabajador (equivalente a lo que hace el sistema en otros módulos)
        $centro = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->where('C.COD_ESTADO', 1)
            ->select('C.COD_CENTRO', 'C.TXT_ABREVIATURA as ABREV_CENTRO')
            ->first();

        $abrev_empresa = trim($empresa_sesion->TXT_ABREVIATURA);
        $abrev_centro = $centro ? trim($centro->ABREV_CENTRO) : '';
        $prefijo = $abrev_empresa . $abrev_centro . 'COT';

        $max_id = DB::table('WEB.ORDEN_COTIZACION')
            ->where('ID_COTIZACION', 'LIKE', $prefijo . '%')
            ->max('ID_COTIZACION');

        if ($max_id) {
            $number = (int) substr($max_id, strlen($prefijo));
            $new_number = $number + 1;
            // Asumiendo longitud total de 16 caracteres como en el ejemplo IICOT00000000001
            $nro_cotizacion = $prefijo . str_pad($new_number, 16 - strlen($prefijo), '0', STR_PAD_LEFT);
        } else {
            $nro_cotizacion = $prefijo . str_pad(1, 11, '0', STR_PAD_LEFT);
        }

        // Obtener tipo de cambio actual (específico para la fecha de hoy, usando la lógica nativa SQL Server)
        $tipo_cambio = DB::table('CMP.TIPO_CAMBIO')
            ->whereRaw('CAST(FEC_CAMBIO AS DATE) = CAST(GETDATE() AS DATE)')
            ->where('COD_ESTADO', 1)
            ->first();

        $valor_tipo_cambio = 0;
        if ($tipo_cambio) {
            $valor_tipo_cambio = $tipo_cambio->CAN_COMPRA;
            // Normalizar si el ERP lo guarda escalado por 10000 (ej: 34480.0000 -> 3.4480)
            if ($valor_tipo_cambio > 100) {
                $valor_tipo_cambio = $valor_tipo_cambio / 10000;
            }
        }

        $listacotizaciones = DB::table('WEB.ORDEN_COTIZACION as C')
            ->select('C.*', DB::raw("(SELECT STUFF((
                SELECT '|' + A.URL_ARCHIVO + '*' + ISNULL(A.NOMBRE_ARCHIVO, 'Archivo')
                FROM dbo.ARCHIVOS A
                WHERE A.ID_DOCUMENTO = C.ID_COTIZACION
                AND A.ACTIVO = 1
                FOR XML PATH('')
            ), 1, 1, '')) as RUTAS_ARCHIVOS"))
            ->where('C.COD_EMPR', isset($empresa_sesion->COD_EMPR) ? $empresa_sesion->COD_EMPR : (isset($empresa_sesion->COD_EMR) ? $empresa_sesion->COD_EMR : ''))
            ->where('C.ACTIVO', 1)
            ->orderBy('C.ID_COTIZACION', 'DESC')
            ->get();

        return view('ordenpedido.cotizacion.cotizacionordenpedido', [
            'combo_tipo_pago' => $combo_tipo_pago,
            'combo_moneda' => $combo_moneda,
            'nro_cotizacion' => $nro_cotizacion,
            'valor_tipo_cambio' => $valor_tipo_cambio,
            'listacotizaciones' => $listacotizaciones,
            'funcion' => $this,
            'idopcion' => $idopcion
        ]);
    }

    public function actionAjaxListarDetalleCotizacion(Request $request)
    {
        $id_cotizacion = $request->input('id_cotizacion');

        $lista_detalle = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
            ->where('ID_COTIZACION', $id_cotizacion)
            ->where('ACTIVO', 1)
            ->get();

        return view('ordenpedido.cotizacion.ajax.listadetallecotizacion', [
            'lista_detalle' => $lista_detalle
        ]);
    }

    public function actionAjaxEditarCotizacion(Request $request)
    {
        $id_cotizacion = trim($request->input('id_cotizacion'));

        $cotizacion = DB::table('WEB.ORDEN_COTIZACION')
            ->where('ID_COTIZACION', $id_cotizacion)
            ->first();

        if (!$cotizacion) {
            return response()->json(['success' => false, 'message' => 'Cotización ' . $id_cotizacion . ' no encontrada.']);
        }

        // Limpiar espacios en blanco de las propiedades (SQL Server char sometimes pads)
        $cot_data = [];
        foreach ((array) $cotizacion as $key => $value) {
            $cot_data[trim($key)] = is_string($value) ? trim($value) : $value;
        }

        // Obtener detalles 
        $detalles = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
            ->where('ID_COTIZACION', $id_cotizacion)
            ->where('ACTIVO', 1)
            ->get();

        $productos_html = view('ordenpedido.cotizacion.ajax.listaproductoscotizacion', [
            'lista_detalle' => $detalles,
            'es_edicion' => true
        ])->render();

        $archivos = DB::table('dbo.ARCHIVOS')
            ->where('ID_DOCUMENTO', $id_cotizacion)
            ->where('ACTIVO', 1)
            ->get();

        return response()->json([
            'success' => true,
            'cotizacion' => $cot_data, // Enviamos el array limpio
            'productos_html' => $productos_html,
            'archivos' => $archivos
        ]);
    }

    public function actionAjaxBuscarProveedorRuc(Request $request)
    {
        $ruc = $request->input('ruc');

        $empresa = DB::table('STD.EMPRESA')
            ->where('NRO_DOCUMENTO', $ruc)
            ->where('IND_PROVEEDOR', 1)
            ->where('COD_ESTADO', 1)
            ->first();

        if ($empresa) {
            $direccion = DB::table('STD.EMPRESA_DIRECCION')
                ->where('COD_EMPR', $empresa->COD_EMPR)
                ->where('IND_DIRECCION_FISCAL', 1)
                ->where('COD_ESTADO', 1)
                ->first();

            return response()->json([
                'success' => true,
                'nombre' => $empresa->NOM_EMPR,
                'telefono' => $empresa->TXT_TELEFONO,
                'direccion' => $direccion ? $direccion->NOM_DIRECCION : ''
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Proveedor no encontrado']);
    }

      public function actionAjaxListarConsolidadoGeneralAprobado(Request $request)
    {
        $empresa_sesion = Session::get('empresas');
        $cod_empr = $empresa_sesion->COD_EMPR ?? $empresa_sesion->COD_EMR;

        $lista_consolidado = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL as C')
            ->select('C.*', DB::raw("(SELECT STUFF((
                SELECT ' - ' + R2.COD_TABLA
                FROM CMP.REFERENCIA_ASOC R1
                INNER JOIN CMP.REFERENCIA_ASOC R2 ON R1.COD_TABLA = R2.COD_TABLA_ASOC
                WHERE R1.COD_TABLA_ASOC = C.ID_PEDIDO_CONSOLIDADO_GENERAL
                AND R1.TXT_TIPO_REFERENCIA = 'CONSOLIDADO_GENERAL'
                AND R2.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                FOR XML PATH('')
            ), 1, 3, '')) as ID_PEDIDOS"))
            ->where('C.COD_EMPR', $cod_empr)
            ->where('C.COD_ESTADO', 'ETM0000000000005')
            ->where('C.ACTIVO', 1)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE as D')
                    ->whereColumn('D.ID_PEDIDO_CONSOLIDADO_GENERAL', 'C.ID_PEDIDO_CONSOLIDADO_GENERAL')
                    ->where('D.ACTIVO', 1)
                    ->whereRaw("D.CAN_COMPRADA - ISNULL((
                        SELECT SUM(CD.CANTIDAD) 
                        FROM WEB.ORDEN_COTIZACION_DETALLE CD 
                        WHERE CD.ID_PEDIDO_CONSOLIDADO_GENERAL = D.ID_PEDIDO_CONSOLIDADO_GENERAL 
                        AND CD.COD_PRODUCTO = D.COD_PRODUCTO 
                        AND CD.ACTIVO = 1
                    ), 0) > 0");
            })
            ->orderBy('C.ID_PEDIDO_CONSOLIDADO_GENERAL', 'DESC')
            ->get();

        return view('ordenpedido.modal.ajax.lista_consolidado_general', [
            'lista_consolidado' => $lista_consolidado
        ]);
    }

    public function actionAjaxListarDetalleConsolidadoGeneralSeleccionado(Request $request)
    {
        $id_consolidado_generals = $request->input('selected_ids');

        $lista_detalle = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE as D')
            ->select('D.*', DB::raw("D.CAN_COMPRADA - ISNULL((
                SELECT SUM(CD.CANTIDAD) 
                FROM WEB.ORDEN_COTIZACION_DETALLE CD 
                WHERE CD.ID_PEDIDO_CONSOLIDADO_GENERAL = D.ID_PEDIDO_CONSOLIDADO_GENERAL 
                AND CD.COD_PRODUCTO = D.COD_PRODUCTO 
                AND CD.ACTIVO = 1
            ), 0) as SALDO_PENDIENTE"))
            ->whereIn('D.ID_PEDIDO_CONSOLIDADO_GENERAL', $id_consolidado_generals)
            ->where('D.ACTIVO', 1)
            ->whereRaw("D.CAN_COMPRADA - ISNULL((
                SELECT SUM(CD.CANTIDAD) 
                FROM WEB.ORDEN_COTIZACION_DETALLE CD 
                WHERE CD.ID_PEDIDO_CONSOLIDADO_GENERAL = D.ID_PEDIDO_CONSOLIDADO_GENERAL 
                AND CD.COD_PRODUCTO = D.COD_PRODUCTO 
                AND CD.ACTIVO = 1
            ), 0) > 0")
            ->get();

        return view('ordenpedido.cotizacion.ajax.listaproductoscotizacion', [
            'lista_detalle' => $lista_detalle
        ]);
    }
    public function actionGuardarCotizacion(Request $request)
    {
        try {
            DB::beginTransaction();

            $empresa_sesion = Session::get('empresas');
            $usuario_id = Session::get('usuario')->usuarioosiris_id;

            // 1. Obtener el centro actual del usuario
            $centro = DB::table('STD.TRABAJADOR as T')
                ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
                ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
                ->where('T.COD_TRAB', $usuario_id)
                ->where('P.situacion_id', 'PRMAECEN000000000002')
                ->where('C.COD_ESTADO', 1)
                ->select('C.COD_CENTRO')
                ->first();

            $cod_centro = $centro ? $centro->COD_CENTRO : '';

            // 2. Obtener el código de la empresa proveedora (desde el RUC)
            $empresa_proveedor = DB::table('STD.EMPRESA')
                ->where('NRO_DOCUMENTO', $request->input('nro_ruc'))
                ->where('COD_ESTADO', 1)
                ->first();

            $cod_empr_proveedor = $empresa_proveedor ? $empresa_proveedor->COD_EMPR : '';

            // 3. Obtener el código de la dirección (preferiblemente fiscal)
            $direccion = DB::table('STD.EMPRESA_DIRECCION')
                ->where('COD_EMPR', $cod_empr_proveedor)
                ->where('IND_DIRECCION_FISCAL', 1)
                ->where('COD_ESTADO', 1)
                ->first();

            $cod_direccion = $direccion ? $direccion->COD_DIRECCION : '';

            $id_cotizacion_edit = $request->input('id_cotizacion_edit');
            $accion = 'I';
            $id_cotizacion = '';

            if (!empty($id_cotizacion_edit)) {
                $accion = 'U';
                $id_cotizacion = $id_cotizacion_edit;
            }

            // 4. Inserción/Actualización de cabecera usando el Trait
            $id_cotizacion = $this->insertOrdenCotizacion(
                $accion,
                $id_cotizacion,
                $request->input('fec_cotizacion'),
                $request->input('nro_serie'),
                $request->input('nro_doc'),
                '',
                $cod_centro,
                $request->input('nro_ruc'),
                $cod_empr_proveedor,
                $request->input('nom_empr_proveedor'),
                $request->input('txt_telefono'),
                $cod_direccion,
                $request->input('nom_direccion'),
                $request->input('fec_validez'),
                $request->input('fec_entrega'),
                $request->input('cod_categoria_moneda'),
                $request->input('txt_categoria_moneda'),
                $request->input('cod_categoria_tipo_pago'),
                $request->input('txt_categoria_tipo_pago'),
                $request->input('txt_observacion'),
                $request->input('can_total'),
                $request->input('ind_igv'), // @IND_IGV
                'ETM0000000000001',
                'GENERADO',
                1,
                ''
            );

            // 5. Inserción de detalles
            // Si es edición, primero desactivamos los detalles anteriores y liberamos el estado 'Cotizado'
            if ($accion == 'U') {
                // Obtener detalles previos para resetear su estado en consolidados
                $detalles_previos = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
                    ->where('ID_COTIZACION', $id_cotizacion)
                    ->where('ACTIVO', 1)
                    ->get();

                foreach ($detalles_previos as $dp) {
                    DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                        ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $dp->ID_PEDIDO_CONSOLIDADO_GENERAL)
                        ->where('COD_PRODUCTO', $dp->COD_PRODUCTO)
                        ->update(['TXT_COTIZACION' => null]);
                }

                DB::table('WEB.ORDEN_COTIZACION_DETALLE')
                    ->where('ID_COTIZACION', $id_cotizacion)
                    ->update(['ACTIVO' => 0]);
            }

            $detalles_json = $request->input('detalles');
            $detalles = json_decode($detalles_json, true);

            if (is_array($detalles)) {
                foreach ($detalles as $det) {
                    $this->insertOrdenCotizacionDetalle(
                        'I',
                        $id_cotizacion,
                        $det['id_consolidado'],
                        '',
                        $cod_centro,
                        $det['cod_producto'],
                        $det['nom_producto'],
                        $det['cod_medida'],
                        $det['nom_medida'],
                        $det['cantidad'],
                        $det['precio'],
                        $det['cod_familia'],
                        $det['nom_familia'],
                        1,
                        ''
                    );

                    // Marcar como cotizado en el consolidado general solo si ya no queda saldo pendiente
                    if (isset($det['id_consolidado'])) {

                        // Recalcular saldo agrupado para este producto en consolidados
                        $total_registrado = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
                            ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $det['id_consolidado'])
                            ->where('COD_PRODUCTO', $det['cod_producto'])
                            ->where('ACTIVO', 1)
                            ->sum('CANTIDAD');

                        $consolidado_det = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                            ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $det['id_consolidado'])
                            ->where('COD_PRODUCTO', $det['cod_producto'])
                            ->first();

                        if ($consolidado_det && $total_registrado >= $consolidado_det->CAN_COMPRADA) {
                            DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                                ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $det['id_consolidado'])
                                ->where('COD_PRODUCTO', $det['cod_producto'])
                                ->update(['TXT_COTIZACION' => 'SI']);
                        } else {
                            DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                                ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $det['id_consolidado'])
                                ->where('COD_PRODUCTO', $det['cod_producto'])
                                ->update(['TXT_COTIZACION' => null]);
                        }
                    }
                }
            }

            // 6. Manejo de archivos adjuntos (Eliminación selectiva y adición)
            $archivos_a_eliminar_json = $request->input('archivos_a_eliminar');
            $archivos_a_eliminar = json_decode($archivos_a_eliminar_json, true);

            if (is_array($archivos_a_eliminar) && count($archivos_a_eliminar) > 0) {
                DB::table('dbo.ARCHIVOS')
                    ->where('ID_DOCUMENTO', $id_cotizacion)
                    ->whereIn('DOCUMENTO_ITEM', $archivos_a_eliminar)
                    ->update(['ACTIVO' => 0]);
            }

            // Limpieza de archivos huérfanos solo en INSERT
            // Cambiamos update a delete para asegurar que no queden registros residuales si no se sube nada
            if ($accion == 'I') {
                DB::table('dbo.ARCHIVOS')
                    ->where('ID_DOCUMENTO', $id_cotizacion)
                    ->delete();
            }

            // Procesar nuevos archivos
            if ($request->hasFile('archivo')) {
                $archivos_raw = $request->file('archivo');
                // Asegurar que siempre sea un array para el foreach
                $archivos = is_array($archivos_raw) ? $archivos_raw : [$archivos_raw];

                $destino_remoto = '\\\\10.1.50.2\\comprobantes\\ORDENCOTIZACION';

                // Obtener el último DOCUMENTO_ITEM para no colisionar si ya existen archivos
                $ultimo_item = DB::table('dbo.ARCHIVOS')
                    ->where('ID_DOCUMENTO', $id_cotizacion)
                    ->max('DOCUMENTO_ITEM');
                $ultimo_item = isset($ultimo_item) ? $ultimo_item : 0;

                foreach ($archivos as $index => $archivo) {
                    $nombre_original = $archivo->getClientOriginalName();
                    $extension = $archivo->getClientOriginalExtension();
                    $size = $archivo->getSize();
                    $mime = $archivo->getMimeType();
                    $nombre_guardado = time() . '_' . $index . '_' . $nombre_original;

                    $ruta_final = $destino_remoto . '\\' . $nombre_guardado;

                    // Copia al servidor remoto UNC
                    if (copy($archivo->getRealPath(), $ruta_final)) {
                        DB::table('dbo.ARCHIVOS')->insert([
                            'ID_DOCUMENTO' => $id_cotizacion,
                            'DOCUMENTO_ITEM' => $ultimo_item + $index + 1,
                            'TIPO_ARCHIVO' => $mime,
                            'NOMBRE_ARCHIVO' => pathinfo($nombre_original, PATHINFO_FILENAME),
                            'DESCRIPCION_ARCHIVO' => $nombre_original,
                            'URL_ARCHIVO' => $ruta_final,
                            'EXTENSION' => $extension,
                            'SIZE' => $size,
                            'ACTIVO' => 1,
                            'FECHA_CREA' => DB::raw('GETDATE()'),
                            'USUARIO_CREA' => isset(Session::get('usuario')->id) ? Session::get('usuario')->id : 'SISTEMA',
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'id_cotizacion' => $id_cotizacion, 'mensaje' => 'Cotización guardada correctamente con ID: ' . $id_cotizacion]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error al guardar cotización: ' . $e->getMessage()]);
        }
    }

    public function actionAjaxEliminarCotizacion(Request $request)
    {
        $id_cotizacion = $request->input('id_cotizacion');

        try {
            DB::beginTransaction();

            // 1. Desactivar Cabecera y Cambiar Estado a ANULADO con Auditoría
            DB::table('WEB.ORDEN_COTIZACION')
                ->where('ID_COTIZACION', $id_cotizacion)
                ->update([
                    'ACTIVO' => 0,
                    'COD_ESTADO' => 'ETM0000000000014',
                    'TXT_ESTADO' => 'ANULADO',
                    'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id,
                    'FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                ]);

            // 2. Desactivar Detalle (aunque ya se filtran por cabecera, mejor ser explícitos)
            DB::table('WEB.ORDEN_COTIZACION_DETALLE')
                ->where('ID_COTIZACION', $id_cotizacion)
                ->update(['ACTIVO' => 0]);

            // 3. Desactivar Archivos
            DB::table('dbo.ARCHIVOS')
                ->where('ID_DOCUMENTO', $id_cotizacion)
                ->update(['ACTIVO' => 0]);

            // 4. Restaurar TXT_COTIZACION en Consolidados
            $detalles = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
                ->where('ID_COTIZACION', $id_cotizacion)
                ->get();

            foreach ($detalles as $det) {
                if ($det->ID_PEDIDO_CONSOLIDADO_GENERAL) {
                    // Al desactivar esta cotización, el TXT_COTIZACION del consolidado debe volver a NULL 
                    // para que el saldo pendiente sea recalculado correctamente en las consultas
                    DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                        ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $det->ID_PEDIDO_CONSOLIDADO_GENERAL)
                        ->where('COD_PRODUCTO', $det->COD_PRODUCTO)
                        ->update(['TXT_COTIZACION' => null]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Cotización eliminada correctamente.']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error al eliminar: ' . $e->getMessage()]);
        }
    }

    public function actionAjaxSubirArchivoCotizacion(Request $request)
    {
        $id_cotizacion = $request->input('id_cotizacion');

        if ($request->hasFile('archivo')) {
            $archivos = $request->file('archivo');
            $destino_remoto = '\\\\10.1.50.2\\comprobantes\\ORDENCOTIZACION';

            // Obtener el último DOCUMENTO_ITEM para este documento
            $ultimo_item = DB::table('dbo.ARCHIVOS')
                ->where('ID_DOCUMENTO', $id_cotizacion)
                ->max('DOCUMENTO_ITEM');
            $ultimo_item = isset($ultimo_item) ? $ultimo_item : 0;

            foreach ($archivos as $index => $archivo) {
                $nombre_original = $archivo->getClientOriginalName();
                $extension = $archivo->getClientOriginalExtension();
                $nombre_sin_extension = pathinfo($nombre_original, PATHINFO_FILENAME);
                $size = $archivo->getSize();
                $mime = $archivo->getMimeType();

                $nombre_guardado = time() . '_' . $index . '_' . $nombre_original;
                $ruta_final = $destino_remoto . '\\' . $nombre_guardado;

                // Copia al servidor remoto UNC
                try {
                    if (copy($archivo->getRealPath(), $ruta_final)) {
                        // Registro en la tabla ARCHIVOS
                        DB::table('dbo.ARCHIVOS')->insert([
                            'ID_DOCUMENTO' => $id_cotizacion,
                            'DOCUMENTO_ITEM' => $ultimo_item + $index + 1,
                            'TIPO_ARCHIVO' => $mime,
                            'NOMBRE_ARCHIVO' => $nombre_sin_extension,
                            'DESCRIPCION_ARCHIVO' => $nombre_original,
                            'URL_ARCHIVO' => $ruta_final,
                            'EXTENSION' => $extension,
                            'SIZE' => $size,
                            'ACTIVO' => 1,
                            'FECHA_CREA' => DB::raw('GETDATE()'),
                            'USUARIO_CREA' => isset(Session::get('usuario')->usuario) ? Session::get('usuario')->usuario : 'SISTEMA',
                        ]);
                    }
                } catch (\Exception $e) {
                    // Log error but continue with other files if any
                    \Log::error("Error subiendo archivo de cotización: " . $e->getMessage());
                }
            }

            return response()->json(['ok' => true]);
        }

        return response()->json(['ok' => false, 'mensaje' => 'No se recibió ningún archivo.']);
    }

    public function actionAjaxAprobarCotizacion(Request $request)
    {
        $id_cotizacion = $request->input('id_cotizacion');
        \Log::info("Intentando aprobar cotización: " . $id_cotizacion);

        try {
            DB::table('WEB.ORDEN_COTIZACION')
                ->where('ID_COTIZACION', $id_cotizacion)
                ->update([
                    'COD_ESTADO' => 'ETM0000000000005',
                    'TXT_ESTADO' => 'APROBADO',
                    'FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()'),
                    'COD_USUARIO_MODIF_AUD' => isset(Session::get('usuario')->id) ? Session::get('usuario')->id : 'SISTEMA',
                ]);

            return response()->json([
                'success' => true,
                'mensaje' => 'La cotización <b>' . $id_cotizacion . '</b> ha sido aprobada correctamente.'
            ]);

        } catch (\Throwable $e) {
            \Log::error("Error en aprobación de cotización: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'mensaje' => 'Ocurrió un error al intentar aprobar la cotización: ' . $e->getMessage()
            ], 500);
        }
    }
}
