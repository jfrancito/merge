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

        $cod_centro = $centro ? $centro->COD_CENTRO : '';

        // Anular automáticamente cotizaciones aprobadas con más de 7 días de antigüedad
        // siempre y cuando NO esté referenciada a una ORDEN DE COMPRA
        DB::table('WEB.ORDEN_COTIZACION')
            ->where('COD_ESTADO', 'ETM0000000000005') // APROBADO
            ->where('ACTIVO', 1)
            ->whereRaw('DATEDIFF(day, FEC_COTIZACION, GETDATE()) >= 7')
            ->whereRaw("ID_COTIZACION NOT IN (
                SELECT RA.COD_TABLA 
                FROM CMP.REFERENCIA_ASOC RA
                INNER JOIN CMP.ORDEN O ON O.COD_ORDEN = RA.COD_TABLA_ASOC
                WHERE RA.TXT_TABLA = 'WEB.ORDEN_COTIZACION' 
                AND RA.TXT_TABLA_ASOC = 'CMP.ORDEN'
                AND O.COD_CATEGORIA_ESTADO_ORDEN NOT IN ('EOR0000000000005', 'EOR0000000000017')
            )")
            ->update([
                'COD_ESTADO' => 'ETM0000000000014',
                'TXT_ESTADO' => 'ANULADO',
                'TXT_GLOSA_ANULACION' => 'pasaron los 7 días de vigencia',
                'FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()'),
                'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id
            ]);

        $listacotizaciones = DB::table('WEB.ORDEN_COTIZACION as C')
            ->leftJoin('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'C.COD_CENTRO')
            ->select('C.*', 'CEN.NOM_CENTRO', 'CEN.TXT_ABREVIATURA as ABREV_CENTRO', DB::raw("(SELECT STUFF((
                SELECT '|' + A.URL_ARCHIVO + '*' + ISNULL(A.NOMBRE_ARCHIVO, 'Archivo')
                FROM dbo.ARCHIVOS A
                WHERE A.ID_DOCUMENTO = C.ID_COTIZACION
                AND A.ACTIVO = 1
                FOR XML PATH('')
            ), 1, 1, '')) as RUTAS_ARCHIVOS"))
            ->where('C.COD_EMPR', isset($empresa_sesion->COD_EMPR) ? $empresa_sesion->COD_EMPR : (isset($empresa_sesion->COD_EMR) ? $empresa_sesion->COD_EMR : ''))
            ->where('C.ACTIVO', 1)
            ->when($cod_centro != '', function ($query) use ($cod_centro) {
                return $query->where('C.COD_CENTRO', $cod_centro);
            })
            ->orderBy('C.ID_COTIZACION', 'DESC')
            ->get();

        return view('ordenpedido.cotizacion.cotizacionordenpedido', [
            'combo_tipo_pago' => $combo_tipo_pago,
            'combo_moneda' => $combo_moneda,
            'nro_cotizacion' => $nro_cotizacion,
            'valor_tipo_cambio' => $valor_tipo_cambio,
            'listacotizaciones' => $listacotizaciones,
            'cod_centro' => $cod_centro,
            'funcion' => $this,
            'idopcion' => $idopcion
        ]);
    }

    public function actionAjaxListarDetalleCotizacion(Request $request)
    {
        $id_cotizacion = $request->input('id_cotizacion');

        $cotizacion = DB::table('WEB.ORDEN_COTIZACION')
            ->where('ID_COTIZACION', $id_cotizacion)
            ->first();

        $lista_detalle = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
            ->where('ID_COTIZACION', $id_cotizacion)
            ->where('ACTIVO', 1)
            ->get();

        $archivos = DB::table('dbo.ARCHIVOS')
            ->where('ID_DOCUMENTO', $id_cotizacion)
            ->where('ACTIVO', 1)
            ->get();

        return view('ordenpedido.cotizacion.ajax.detalletabcotizacion', [
            'cotizacion' => $cotizacion,
            'lista_detalle' => $lista_detalle,
            'archivos' => $archivos
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

        $usuario_id = Session::get('usuario')->usuarioosiris_id;
        $centro_usuario = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->where('C.COD_ESTADO', 1)
            ->select('C.NOM_CENTRO')
            ->first();

        $nom_centro_usuario = $centro_usuario ? trim($centro_usuario->NOM_CENTRO) : '---';

        // Limpiar espacios en blanco de las propiedades (SQL Server char sometimes pads)
        $cot_data = [];
        foreach ((array) $cotizacion as $key => $value) {
            $cot_data[trim($key)] = is_string($value) ? trim($value) : $value;
        }

        // Obtener detalles recuperando solo los consolidados que corresponden a cada producto específico (Usando EXISTS y Centro para precisión)
        $detalles = DB::table('WEB.ORDEN_COTIZACION_DETALLE as D')
            ->select(
                'D.*',
                DB::raw("(SELECT STUFF((
                    SELECT DISTINCT ' - ' + RA.COD_TABLA
                    FROM CMP.REFERENCIA_ASOC RA
                    WHERE RA.COD_TABLA_ASOC = D.ID_COTIZACION
                    AND RA.TXT_TIPO_REFERENCIA = 'COTIZACION_CONSOLIDADO'
                    FOR XML PATH('')
                ), 1, 3, '')) as ID_PEDIDO_CONSOLIDADO"),
                // Calcular Saldo Pendiente (Total del Consolidado - Otras Cotizaciones activas)
                DB::raw("(
                    ISNULL((SELECT TOP 1 PCD.CAN_COMPRADA
                     FROM WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE PCD
                     WHERE PCD.ID_PEDIDO_CONSOLIDADO = D.ID_PEDIDO_CONSOLIDADO_GENERAL
                     AND PCD.COD_PRODUCTO = D.COD_PRODUCTO
                     AND PCD.ACTIVO = 1), 0)
                    -
                    ISNULL((SELECT SUM(OCD.CANTIDAD)
                     FROM WEB.ORDEN_COTIZACION_DETALLE OCD
                     WHERE OCD.ID_PEDIDO_CONSOLIDADO_GENERAL = D.ID_PEDIDO_CONSOLIDADO_GENERAL
                     AND OCD.COD_PRODUCTO = D.COD_PRODUCTO
                     AND OCD.ACTIVO = 1
                     AND OCD.ID_COTIZACION <> D.ID_COTIZACION), 0)
                ) as SALDO_PENDIENTE"),
                DB::raw("(SELECT TOP 1 DP.CAN_PRECIO_UNIT_IGV 
                          FROM CMP.ORDEN OC 
                          INNER JOIN CMP.DETALLE_PRODUCTO DP ON OC.COD_ORDEN = DP.COD_TABLA 
                          INNER JOIN CMP.CATEGORIA CA ON OC.COD_CATEGORIA_TIPO_ORDEN = CA.COD_CATEGORIA AND CA.TXT_GLOSA = 'COMPRAS' 
                          WHERE OC.COD_ESTADO = 1 
                          AND DP.COD_ESTADO = 1 
                          AND DP.COD_PRODUCTO = D.COD_PRODUCTO 
                          ORDER BY OC.FEC_ORDEN DESC) as PRECIO_COMPRA_ANTERIOR")
            )
            ->where('D.ID_COTIZACION', $id_cotizacion)
            ->where('D.ACTIVO', 1)
            ->get();

        // DETERMINAR SI LA COTIZACIÓN ES DE SERVICIO
        $es_servicio = false;
        $primer_detalle = $detalles->first();
        if ($primer_detalle) {
            $prod = DB::table('ALM.PRODUCTO')
                ->where('COD_PRODUCTO', $primer_detalle->COD_PRODUCTO)
                ->first();
            if ($prod && isset($prod->IND_MATERIAL_SERVICIO) && $prod->IND_MATERIAL_SERVICIO == 'S') {
                $es_servicio = true;
            }
        }

        $productos_html = view('ordenpedido.cotizacion.ajax.listaproductoscotizacion', [
            'lista_detalle' => $detalles,
            'es_edicion' => true,
            'es_servicio' => $es_servicio
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

    public function actionAjaxGetCorrelativoSinCotizacion(Request $request)
    {
        $serie = 'C001';
        $empresa_sesion = Session::get('empresas');
        $cod_empr = $empresa_sesion->COD_EMPR ?? $empresa_sesion->COD_EMR;
        $usuario_id = Session::get('usuario')->usuarioosiris_id;

        // Obtener el centro del trabajador
        $centro = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->select('P.centro_osiris_id')
            ->first();

        $cod_centro = $centro ? $centro->centro_osiris_id : '';

        // Obtener el máximo número para la serie 0001 y tipo SIN COTIZACION filtrado por Empresa y Centro
        $ultimo = DB::table('WEB.ORDEN_COTIZACION')
            ->where('COD_EMPR', $cod_empr)
            ->where('COD_CENTRO', $cod_centro)
            ->where('NRO_SERIE', $serie)
            ->where('TXT_TIPO_COTIZACION', 'SIN COTIZACION')
            ->select(DB::raw('MAX(CAST(ISNULL(NULLIF(NRO_DOC, \'\'), \'0\') AS INT)) as max_nro'))
            ->first();

        $nuevo_nro = ($ultimo && $ultimo->max_nro) ? $ultimo->max_nro + 1 : 1;
        $numero = str_pad($nuevo_nro, 8, '0', STR_PAD_LEFT);

        return response()->json([
            'success' => true,
            'serie' => $serie,
            'numero' => $numero
        ]);
    }

    public function actionAjaxListarConsolidadoGeneralAprobado(Request $request)
    {
        $empresa_sesion = Session::get('empresas');
        $cod_empr = $empresa_sesion->COD_EMPR ?? $empresa_sesion->COD_EMR;
        $usuario_id = Session::get('usuario')->usuarioosiris_id;

        // Obtener el centro del trabajador logueado
        $centro = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->where('C.COD_ESTADO', 1)
            ->select('C.NOM_CENTRO')
            ->first();

        $nom_centro_usuario = $centro ? trim($centro->NOM_CENTRO) : '---';

        $lista_consolidado = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO as C')
            ->join('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'C.COD_CENTRO')
            ->select(
                'C.*',
                'CEN.NOM_CENTRO',
                DB::raw("(SELECT STUFF((
                    SELECT ' - ' + OP.ID_PEDIDO
                    FROM CMP.REFERENCIA_ASOC RA
                    INNER JOIN WEB.ORDEN_PEDIDO OP ON OP.ID_PEDIDO = RA.COD_TABLA
                    WHERE RA.COD_TABLA_ASOC = C.ID_PEDIDO_CONSOLIDADO
                    AND RA.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                    FOR XML PATH('')
                ), 1, 3, '')) as ID_PEDIDOS"),
                DB::raw("(SELECT TOP 1 D.NOM_CATEGORIA_FAMILIA 
                          FROM WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE D 
                          WHERE D.ID_PEDIDO_CONSOLIDADO = C.ID_PEDIDO_CONSOLIDADO) as NOM_CATEGORIA_FAMILIA")
            )
            ->where('C.COD_EMPR', $cod_empr)
            ->where('C.COD_ESTADO', 'ETM0000000000005') // APROBADO
            ->where('C.ACTIVO', 1)
            ->whereExists(function ($query) use ($nom_centro_usuario) {
                $query->select(DB::raw(1))
                    ->from('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE as D')
                    ->whereColumn('D.ID_PEDIDO_CONSOLIDADO', 'C.ID_PEDIDO_CONSOLIDADO')
                    ->where('D.ACTIVO', 1)
                    ->where('D.IND_COMPRA', '=', $nom_centro_usuario)
                    ->whereRaw("(D.CAN_COMPRADA - ISNULL((
                        SELECT SUM(CD.CANTIDAD) 
                        FROM WEB.ORDEN_COTIZACION_DETALLE CD 
                        WHERE CD.ID_PEDIDO_CONSOLIDADO_GENERAL = D.ID_PEDIDO_CONSOLIDADO 
                        AND CD.COD_PRODUCTO = D.COD_PRODUCTO 
                        AND CD.ACTIVO = 1 
                    ), 0)) > 0");
            })
            ->orderBy('C.ID_PEDIDO_CONSOLIDADO', 'DESC')
            ->get();

        return view('ordenpedido.modal.ajax.lista_consolidado_general', [
            'lista_consolidado' => $lista_consolidado
        ]);
    }

    public function actionAjaxListarPedidosAprobadosServicio(Request $request)
    {
        $empresa_sesion = Session::get('empresas');
        $cod_empr = $empresa_sesion->COD_EMPR ?? $empresa_sesion->COD_EMR;
        $usuario_id = Session::get('usuario')->usuarioosiris_id;

        // Obtener el centro del trabajador logueado
        $centro = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->where('C.COD_ESTADO', 1)
            ->select('C.COD_CENTRO', 'C.NOM_CENTRO')
            ->first();

        $cod_centro_usuario = $centro ? $centro->COD_CENTRO : '---';

        $lista_pedidos = DB::table('WEB.ORDEN_PEDIDO as O')
            ->join('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'O.COD_CENTRO')
            ->select('O.*', 'CEN.NOM_CENTRO')
            ->where('O.COD_EMPR', $cod_empr)
            ->where('O.COD_CENTRO', $cod_centro_usuario)
            ->where('O.COD_ESTADO', 'ETM0000000000005') // APROBADO
            ->where('O.ACTIVO', 1)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('WEB.ORDEN_PEDIDO_DETALLE as D')
                    ->whereColumn('D.ID_PEDIDO', 'O.ID_PEDIDO')
                    ->where('D.ACTIVO', 1)
                    ->where('D.IND_MATERIAL_SERVICIO', '=', 'S')
                    ->whereRaw("(D.CANTIDAD - ISNULL((
                        SELECT SUM(CD.CANTIDAD) 
                        FROM WEB.ORDEN_COTIZACION_DETALLE CD 
                        WHERE CD.ID_PEDIDO_CONSOLIDADO_GENERAL = D.ID_PEDIDO 
                        AND CD.COD_PRODUCTO = D.COD_PRODUCTO 
                        AND CD.ACTIVO = 1 
                    ), 0)) > 0");
            })
            ->orderBy('O.FEC_PEDIDO', 'DESC')
            ->get();

        return view('ordenpedido.modal.ajax.lista_pedidos_servicios', [
            'lista_pedidos' => $lista_pedidos
        ]);
    }

    public function actionAjaxListarDetalleConsolidadoGeneralSeleccionado(Request $request)
    {
        $id_consolidado_individales = $request->input('selected_ids');
        $usuario_id = Session::get('usuario')->usuarioosiris_id;

        // Obtener el centro del trabajador logueado
        $centro = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->where('C.COD_ESTADO', 1)
            ->select('C.NOM_CENTRO')
            ->first();

        $nom_centro_usuario = $centro ? trim($centro->NOM_CENTRO) : '---';

        $detalles = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE as D')
            ->select(
                'D.*',
                DB::raw("(SELECT ISNULL(SUM(CD.CANTIDAD), 0) 
                          FROM WEB.ORDEN_COTIZACION_DETALLE CD 
                          WHERE CD.ID_PEDIDO_CONSOLIDADO_GENERAL = D.ID_PEDIDO_CONSOLIDADO 
                          AND CD.COD_PRODUCTO = D.COD_PRODUCTO 
                          AND CD.ACTIVO = 1) as CAN_COTIZADA"),
                DB::raw("(SELECT TOP 1 DP.CAN_PRECIO_UNIT_IGV 
                          FROM CMP.ORDEN OC 
                          INNER JOIN CMP.DETALLE_PRODUCTO DP ON OC.COD_ORDEN = DP.COD_TABLA 
                          INNER JOIN CMP.CATEGORIA CA ON OC.COD_CATEGORIA_TIPO_ORDEN = CA.COD_CATEGORIA AND CA.TXT_GLOSA = 'COMPRAS' 
                          WHERE OC.COD_ESTADO = 1 
                          AND DP.COD_ESTADO = 1 
                          AND DP.COD_PRODUCTO = D.COD_PRODUCTO 
                          ORDER BY OC.FEC_ORDEN DESC) as PRECIO_COMPRA_ANTERIOR")
            )
            ->whereIn('D.ID_PEDIDO_CONSOLIDADO', $id_consolidado_individales)
            ->where('D.ACTIVO', 1)
            ->where('D.IND_COMPRA', '=', $nom_centro_usuario)
            ->get();

        // Agrupar por COD_PRODUCTO
        $grouped = [];
        foreach ($detalles as $d) {
            $key = trim($d->COD_PRODUCTO);
            $saldo_real = (float) $d->CAN_COMPRADA - (float) $d->CAN_COTIZADA;

            if ($saldo_real <= 0)
                continue;

            if (!isset($grouped[$key])) {
                $grouped[$key] = $d;
                $grouped[$key]->ID_CONSOLIDADOS_LISTA = [trim($d->ID_PEDIDO_CONSOLIDADO)];
                $grouped[$key]->BREAKDOWN = [
                    ['id' => trim($d->ID_PEDIDO_CONSOLIDADO), 'cant' => $saldo_real]
                ];
                // Asegurar que SALDO_PENDIENTE exista para la vista
                $grouped[$key]->SALDO_PENDIENTE = $saldo_real;
            } else {
                $grouped[$key]->SALDO_PENDIENTE += $saldo_real;
                $grouped[$key]->ID_CONSOLIDADOS_LISTA[] = trim($d->ID_PEDIDO_CONSOLIDADO);
                $grouped[$key]->BREAKDOWN[] = ['id' => trim($d->ID_PEDIDO_CONSOLIDADO), 'cant' => $saldo_real];
            }
        }

        foreach ($grouped as $item) {
            $item->ID_PEDIDO_CONSOLIDADO = implode(' - ', array_unique(array_map('trim', $item->ID_CONSOLIDADOS_LISTA)));
        }

        return view('ordenpedido.cotizacion.ajax.listaproductoscotizacion', [
            'lista_detalle' => array_values($grouped)
        ]);
    }

    public function actionAjaxListarDetallePedidosAprobadosSeleccionados(Request $request)
    {
        $id_pedidos = $request->input('selected_ids');
        $usuario_id = Session::get('usuario')->usuarioosiris_id;
        $id_cotizacion_edit = $request->input('id_cotizacion_edit');

        $detalles = DB::table('WEB.ORDEN_PEDIDO_DETALLE as D')
            ->join('WEB.ORDEN_PEDIDO as OP', 'OP.ID_PEDIDO', '=', 'D.ID_PEDIDO')
            ->leftJoin('ALM.PRODUCTO as P', 'P.COD_PRODUCTO', '=', 'D.COD_PRODUCTO')
            ->leftJoin('CMP.CATEGORIA as CAT', 'CAT.COD_CATEGORIA', '=', 'P.COD_CATEGORIA_FAMILIA')
            ->select(
                'D.*',
                'CAT.COD_CATEGORIA as COD_CATEGORIA_FAMILIA',
                'CAT.NOM_CATEGORIA as NOM_CATEGORIA_FAMILIA',
                'D.COD_CATEGORIA as COD_CATEGORIA_MEDIDA',
                'D.NOM_CATEGORIA as NOM_CATEGORIA_MEDIDA',
                'D.ID_PEDIDO as ID_PEDIDO_CONSOLIDADO', 
                DB::raw("(
                    D.CANTIDAD - ISNULL((
                        SELECT SUM(CD.CANTIDAD) 
                        FROM WEB.ORDEN_COTIZACION_DETALLE CD 
                        WHERE CD.ID_PEDIDO_CONSOLIDADO_GENERAL = D.ID_PEDIDO 
                        AND CD.COD_PRODUCTO = D.COD_PRODUCTO 
                        AND CD.ACTIVO = 1
                        " . (!empty($id_cotizacion_edit) ? " AND CD.ID_COTIZACION <> '$id_cotizacion_edit' " : "") . "
                    ), 0)
                ) as SALDO_PENDIENTE"),
                DB::raw("(SELECT TOP 1 DP.CAN_PRECIO_UNIT_IGV 
                          FROM CMP.ORDEN OC 
                          INNER JOIN CMP.DETALLE_PRODUCTO DP ON OC.COD_ORDEN = DP.COD_TABLA 
                          INNER JOIN CMP.CATEGORIA CA ON OC.COD_CATEGORIA_TIPO_ORDEN = CA.COD_CATEGORIA AND CA.TXT_GLOSA = 'COMPRAS' 
                          WHERE OC.COD_ESTADO = 1 
                          AND DP.COD_ESTADO = 1 
                          AND DP.COD_PRODUCTO = D.COD_PRODUCTO 
                          ORDER BY OC.FEC_ORDEN DESC) as PRECIO_COMPRA_ANTERIOR")
            )
            ->whereIn('D.ID_PEDIDO', $id_pedidos)
            ->where('D.IND_MATERIAL_SERVICIO', '=', 'S')
            ->where('D.ACTIVO', 1)
            ->whereRaw("(
                D.CANTIDAD - ISNULL((
                    SELECT SUM(CD.CANTIDAD) 
                    FROM WEB.ORDEN_COTIZACION_DETALLE CD 
                    WHERE CD.ID_PEDIDO_CONSOLIDADO_GENERAL = D.ID_PEDIDO 
                    AND CD.COD_PRODUCTO = D.COD_PRODUCTO 
                    AND CD.ACTIVO = 1
                    " . (!empty($id_cotizacion_edit) ? " AND CD.ID_COTIZACION <> '$id_cotizacion_edit' " : "") . "
                ), 0)
            ) > 0")
            ->get();

        return view('ordenpedido.cotizacion.ajax.listaproductoscotizacion', [
            'lista_detalle' => $detalles,
            'es_servicio' => true
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

            // --- Conexión para réplica en Zonas ---
            $conexionbd = 'sqlsrv';
            if($cod_centro == 'CEN0000000000004'){
                $conexionbd = 'sqlsrv_r';
            }else{
                if($cod_centro == 'CEN0000000000006'){
                    $conexionbd = 'sqlsrv_b';
                }
            }

            // 4.1 Guardar el tipo de cotización (CON/SIN)
            DB::table('WEB.ORDEN_COTIZACION')
                ->where('ID_COTIZACION', $id_cotizacion)
                ->update(['TXT_TIPO_COTIZACION' => $request->input('txt_tipo_cotizacion')]);

            if ($conexionbd !== 'sqlsrv') {
                try {
                    DB::connection($conexionbd)->table('WEB.ORDEN_COTIZACION')
                        ->where('ID_COTIZACION', $id_cotizacion)
                        ->update(['TXT_TIPO_COTIZACION' => $request->input('txt_tipo_cotizacion')]);
                } catch (\Exception $ez) {
                    Log::error('Error al replicar actualización tipo cotización a zona (' . $conexionbd . '): ' . $ez->getMessage());
                }
            }

            // 5. Inserción de detalles
            // Si es edición, primero desactivamos los detalles anteriores y liberamos el estado 'Cotizado'
            if ($accion == 'U') {
                // 1. Eliminar referencias anteriores en CMP.REFERENCIA_ASOC
                DB::table('CMP.REFERENCIA_ASOC')
                    ->where('COD_TABLA_ASOC', $id_cotizacion)
                    ->whereIn('TXT_TIPO_REFERENCIA', ['COTIZACION_CONSOLIDADO', 'COTIZACION_PEDIDO'])
                    ->delete();

                // 2. Obtener detalles previos para resetear su estado en consolidados
                $detalles_previos = DB::table('WEB.ORDEN_COTIZACION_DETALLE as CD')
                    ->join('CMP.REFERENCIA_ASOC as RA', 'RA.COD_TABLA_ASOC', '=', 'CD.ID_COTIZACION')
                    ->where('CD.ID_COTIZACION', $id_cotizacion)
                    ->where('CD.ACTIVO', 1)
                    ->where('RA.TXT_TIPO_REFERENCIA', 'COTIZACION_CONSOLIDADO')
                    ->select('CD.COD_PRODUCTO', 'RA.COD_TABLA as ID_PEDIDO_CONSOLIDADO_GENERAL')
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

                if ($conexionbd !== 'sqlsrv') {
                    try {
                        DB::connection($conexionbd)->table('WEB.ORDEN_COTIZACION_DETALLE')
                            ->where('ID_COTIZACION', $id_cotizacion)
                            ->update(['ACTIVO' => 0]);
                    } catch (\Exception $ez) {
                        Log::error('Error al desactivar detalles anteriores en zona (' . $conexionbd . '): ' . $ez->getMessage());
                    }
                }
            }

            $detalles_json = $request->input('detalles');
            $detalles = json_decode($detalles_json, true);

            if (is_array($detalles)) {
                foreach ($detalles as $det) {

                    $total_por_distribuir = (float) $det['cantidad'];
                    $breakdown = isset($det['breakdown']) ? $det['breakdown'] : null;

                    // Si no hay breakdown (caso raro), creamos uno ficticio con el ID principal
                    if (!is_array($breakdown) || count($breakdown) == 0) {
                        $breakdown = [['id' => $det['id_consolidado'], 'cant' => $total_por_distribuir]];
                    }

                    // Distribuir la cantidad entre los consolidados del breakdown
                    foreach ($breakdown as $index => $b) {

                        $id_consolidado_linea = trim($b['id']);
                        $max_en_este_consolidado = (float) $b['cant'];

                        // Cantidad a asignar a este consolidado (FIFO)
                        $cantidad_asignar = 0;
                        if ($total_por_distribuir > 0) {
                            // Si es el último item y sobra algo, se lo asignamos todo (por si hubo redondeo o ajuste manual)
                            if ($index == count($breakdown) - 1) {
                                $cantidad_asignar = $total_por_distribuir;
                            } else {
                                $cantidad_asignar = min($total_por_distribuir, $max_en_este_consolidado);
                            }
                        }

                        // Solo insertamos si hay cantidad o si es el único consolidado
                        if ($cantidad_asignar > 0 || count($breakdown) == 1) {

                            // 1. Inserción de detalle de cotización (UNA FILA POR CADA CONSOLIDADO QUE APORTA)
                            $this->insertOrdenCotizacionDetalle(
                                'I',
                                $id_cotizacion,
                                $id_consolidado_linea,
                                '',
                                $cod_centro,
                                $det['cod_producto'],
                                $det['nom_producto'],
                                $det['cod_medida'],
                                $det['nom_medida'],
                                $cantidad_asignar,
                                $det['precio'],
                                $det['precio_igv'],
                                isset($det['cod_familia']) ? $det['cod_familia'] : '',
                                isset($det['nom_familia']) ? $det['nom_familia'] : '',
                                1,
                                ''
                            );

                            // 2. Guardar relación en CMP.REFERENCIA_ASOC (Referencia de cabecera a cabecera)
                            $es_tipo_servicio = ($request->input('ind_mat_o_ser') === 'S');
                            $ref_txt_tabla = $es_tipo_servicio ? 'WEB.ORDEN_PEDIDO' : 'WEB.ORDEN_PEDIDO_CONSOLIDADO';
                            $ref_tipo = $es_tipo_servicio ? 'COTIZACION_PEDIDO' : 'COTIZACION_CONSOLIDADO';

                            $existe_ref = DB::table('CMP.REFERENCIA_ASOC')
                                ->where('COD_TABLA', $id_consolidado_linea)
                                ->where('COD_TABLA_ASOC', $id_cotizacion)
                                ->where('TXT_TIPO_REFERENCIA', $ref_tipo)
                                ->exists();

                            if (!$existe_ref) {
                                DB::table('CMP.REFERENCIA_ASOC')->insert([
                                    'COD_TABLA' => $id_consolidado_linea,
                                    'COD_TABLA_ASOC' => $id_cotizacion,
                                    'TXT_TABLA' => $ref_txt_tabla,
                                    'TXT_TABLA_ASOC' => 'WEB.ORDEN_COTIZACION',
                                    'TXT_TIPO_REFERENCIA' => $ref_tipo,
                                    'COD_USUARIO_CREA_AUD' => Session::get('usuario')->id,
                                    'FEC_USUARIO_CREA_AUD' => date('Y-m-d\TH:i:s'),
                                    'COD_ESTADO' => 1
                                ]);
                            }

                            // Réplica de relación REFERENCIA_ASOC en zonas
                            if ($conexionbd !== 'sqlsrv') {
                                try {
                                    $existe_ref_z = DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')
                                        ->where('COD_TABLA', $id_consolidado_linea)
                                        ->where('COD_TABLA_ASOC', $id_cotizacion)
                                        ->where('TXT_TIPO_REFERENCIA', $ref_tipo)
                                        ->exists();

                                    if (!$existe_ref_z) {
                                        DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')->insert([
                                            'COD_TABLA' => $id_consolidado_linea,
                                            'COD_TABLA_ASOC' => $id_cotizacion,
                                            'TXT_TABLA' => $ref_txt_tabla,
                                            'TXT_TABLA_ASOC' => 'WEB.ORDEN_COTIZACION',
                                            'TXT_TIPO_REFERENCIA' => $ref_tipo,
                                            'COD_USUARIO_CREA_AUD' => Session::get('usuario')->id,
                                            'FEC_USUARIO_CREA_AUD' => date('Y-m-d\TH:i:s'),
                                            'COD_ESTADO' => 1
                                        ]);
                                    }
                                } catch (\Exception $ez) {
                                    Log::error('Error al replicar CMP.REFERENCIA_ASOC a zona (' . $conexionbd . '): ' . $ez->getMessage());
                                }
                            }

                            // 3. Actualizar estado de TXT_COTIZACION en el consolidado (SOLO SI ES MATERIAL)
                            if (!$es_tipo_servicio) {
                                $total_registrado = DB::table('WEB.ORDEN_COTIZACION_DETALLE as CD')
                                    ->join('CMP.REFERENCIA_ASOC as RA', 'RA.COD_TABLA_ASOC', '=', 'CD.ID_COTIZACION')
                                    ->where('RA.COD_TABLA', $id_consolidado_linea)
                                    ->where('CD.ID_PEDIDO_CONSOLIDADO_GENERAL', $id_consolidado_linea)
                                    ->where('CD.COD_PRODUCTO', $det['cod_producto'])
                                    ->where('CD.ACTIVO', 1)
                                    ->sum('CD.CANTIDAD');

                                $consolidado_det = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                                    ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $id_consolidado_linea)
                                    ->where('COD_PRODUCTO', $det['cod_producto'])
                                    ->first();

                                if ($consolidado_det && $total_registrado >= $consolidado_det->CAN_COMPRADA) {
                                    DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                                        ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $id_consolidado_linea)
                                        ->where('COD_PRODUCTO', $det['cod_producto'])
                                        ->update(['TXT_COTIZACION' => 'SI']);
                                } else {
                                    DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                                        ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $id_consolidado_linea)
                                        ->where('COD_PRODUCTO', $det['cod_producto'])
                                        ->update(['TXT_COTIZACION' => null]);
                                }
                            }

                            $total_por_distribuir -= $cantidad_asignar;
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

            // Obtener el centro para réplica en zonas antes de modificar la cabecera
            $cot = DB::table('WEB.ORDEN_COTIZACION')
                ->where('ID_COTIZACION', $id_cotizacion)
                ->first();
            $cod_centro = $cot ? $cot->COD_CENTRO : '';

            $conexionbd = 'sqlsrv';
            if($cod_centro == 'CEN0000000000004'){
                $conexionbd = 'sqlsrv_r';
            }else{
                if($cod_centro == 'CEN0000000000006'){
                    $conexionbd = 'sqlsrv_b';
                }
            }

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

            // Réplica de eliminación/anulación a zonas
            if ($conexionbd !== 'sqlsrv') {
                try {
                    DB::connection($conexionbd)->table('WEB.ORDEN_COTIZACION')
                        ->where('ID_COTIZACION', $id_cotizacion)
                        ->update([
                            'ACTIVO' => 0,
                            'COD_ESTADO' => 'ETM0000000000014',
                            'TXT_ESTADO' => 'ANULADO',
                            'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id,
                            'FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                        ]);

                    DB::connection($conexionbd)->table('WEB.ORDEN_COTIZACION_DETALLE')
                        ->where('ID_COTIZACION', $id_cotizacion)
                        ->update(['ACTIVO' => 0]);
                } catch (\Exception $ez) {
                    Log::error('Error al replicar anulación de cotización a zona (' . $conexionbd . '): ' . $ez->getMessage());
                }
            }

            // 3. Desactivar Archivos
            DB::table('dbo.ARCHIVOS')
                ->where('ID_DOCUMENTO', $id_cotizacion)
                ->update(['ACTIVO' => 0]);

            // 4. Eliminar referencias en CMP.REFERENCIA_ASOC
            $referencias = DB::table('CMP.REFERENCIA_ASOC')
                ->where('COD_TABLA_ASOC', $id_cotizacion)
                ->where('TXT_TIPO_REFERENCIA', 'COTIZACION_CONSOLIDADO')
                ->get();

            DB::table('CMP.REFERENCIA_ASOC')
                ->where('COD_TABLA_ASOC', $id_cotizacion)
                ->where('TXT_TIPO_REFERENCIA', 'COTIZACION_CONSOLIDADO')
                ->delete();

            // Réplica de eliminación REFERENCIA_ASOC en zonas
            if ($conexionbd !== 'sqlsrv') {
                try {
                    DB::connection($conexionbd)->table('CMP.REFERENCIA_ASOC')
                        ->where('COD_TABLA_ASOC', $id_cotizacion)
                        ->where('TXT_TIPO_REFERENCIA', 'COTIZACION_CONSOLIDADO')
                        ->delete();
                } catch (\Exception $ez) {
                    Log::error('Error al replicar eliminación de CMP.REFERENCIA_ASOC a zona (' . $conexionbd . '): ' . $ez->getMessage());
                }
            }

            // 5. Restaurar TXT_COTIZACION en Consolidados
            $detalles = DB::table('WEB.ORDEN_COTIZACION_DETALLE')
                ->where('ID_COTIZACION', $id_cotizacion)
                ->get();

            foreach ($detalles as $det) {
                foreach ($referencias as $ref) {
                    // Al desactivar esta cotización, el TXT_COTIZACION del consolidado debe volver a NULL 
                    // para que el saldo pendiente sea recalculado correctamente en las consultas
                    DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE')
                        ->where('ID_PEDIDO_CONSOLIDADO_GENERAL', $ref->COD_TABLA)
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
