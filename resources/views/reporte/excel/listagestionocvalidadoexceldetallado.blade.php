<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">    
        .titulo-centrado {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            background-color: #1f4e78;
            color: #ffffff;
            vertical-align: middle;
        }
        .tabladp {
            background: #1f4e78;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }
        .center {
            text-align: center;
        }
        .number {
            text-align: right;
        }
        .texto {
            mso-number-format: "\@";
            text-align: left;
        }
    </style>
    @php
        if (!function_exists('safe_format_date')) {
            function safe_format_date($val, $format = 'd-m-Y H:i:s') {
                if (empty($val) || $val == '0000-00-00 00:00:00' || $val == '0000-00-00') return '';
                try {
                    $dt = date_create($val);
                    return ($dt !== false) ? date_format($dt, $format) : '';
                } catch (\Exception $e) {
                    return '';
                }
            }
        }

        if (!function_exists('get_user_name_excel')) {
            function get_user_name_excel($userId) {
                if (empty($userId)) return '';
                $u = \DB::table('users')->where('id', $userId)->first();
                return $u ? $u->nombre : '';
            }
        }

        if (!function_exists('get_nombre_sede')) {
            function get_nombre_sede($item) {
                if (!empty($item->NOM_CENTRO)) {
                    return $item->NOM_CENTRO;
                }
                $map = [
                    'CEN0000000000001' => 'CHICLAYO',
                    'CEN0000000000002' => 'LIMA',
                    'CEN0000000000004' => 'RIOJA',
                    'CEN0000000000006' => 'BELLAVISTA',
                ];
                $cod = $item->COD_CENTRO ?? '';
                return isset($map[$cod]) ? $map[$cod] : $cod;
            }
        }

        if (!function_exists('get_tipo_documento')) {
            function get_tipo_documento($item) {
                if (!empty($item->TXT_CATEGORIA_DOCUMENTO)) {
                    return $item->TXT_CATEGORIA_DOCUMENTO;
                }
                $map = [
                    '01' => 'FACTURA',
                    '03' => 'BOLETA',
                    '04' => 'LIQUIDACION DE COMPRA',
                    '07' => 'NOTA DE CREDITO',
                    '08' => 'NOTA DE DEBITO',
                    'R1' => 'RECIBO POR HONORARIOS',
                ];
                $tipo = $item->ID_TIPO_DOC ?? '';
                if (isset($map[$tipo])) {
                    return $map[$tipo];
                }
                return $tipo;
            }
        }

        $titulo_operacion = [
            'ORDEN_COMPRA' => 'REPORTE DE GESTIÓN - ORDEN DE COMPRA',
            'CONTRATO' => 'REPORTE DE GESTIÓN - CONTRATO',
            'ESTIBA' => 'REPORTE DE GESTIÓN - ESTIBA',
            'DOCUMENTO_INTERNO_PRODUCCION' => 'REPORTE DE GESTIÓN - DOCUMENTO INTERNO PRODUCCIÓN',
            'DOCUMENTO_INTERNO_SECADO' => 'REPORTE DE GESTIÓN - DOCUMENTO INTERNO SECADO',
            'DOCUMENTO_SERVICIO_BALANZA' => 'REPORTE DE GESTIÓN - DOCUMENTO POR SERVICIO DE BALANZA',
            'DOCUMENTO_INTERNO_COMPRA' => 'REPORTE DE GESTIÓN - DOCUMENTO INTERNO COMPRA',
            'COMISION' => 'REPORTE DE GESTIÓN - COMISIÓN',
            'LIQUIDACION_COMPRA_ANTICIPO' => 'REPORTE DE GESTIÓN - LIQUIDACIÓN DE COMPRA ANTICIPO',
            'PROVISION_GASTO' => 'REPORTE DE GESTIÓN - PROVISIÓN DE GASTO',
            'NOTA_CREDITO' => 'REPORTE DE GESTIÓN - NOTA DE CRÉDITO',
            'NOTA_DEBITO' => 'REPORTE DE GESTIÓN - NOTA DE DÉBITO',
            'ORDEN_COMPRA_ANTICIPO' => 'REPORTE DE GESTIÓN - ORDEN DE COMPRA ANTICIPO',
            'CONTRATO_ANTICIPO' => 'REPORTE DE GESTIÓN - CONTRATO ANTICIPO',
        ];
        $nombre_titulo = isset($titulo_operacion[$operacion_id]) ? $titulo_operacion[$operacion_id] : 'REPORTE DE GESTIÓN - '.str_replace('_', ' ', $operacion_id);
    @endphp
    <table>
    @if($operacion_id == 'ORDEN_COMPRA')
        <thead>
            <tr>
                <th colspan="31" class="titulo-centrado">{{ $nombre_titulo }}</th>
            </tr>
            <tr>
                <th class="tabladp">ITEM</th>
                <th class="tabladp">SEDE</th>
                <th class="tabladp">CODIGO OC</th>
                <th class="tabladp">FECHA OC</th>
                <th class="tabladp">DOCUMENTO</th>
                <th class="tabladp">PROVEEDOR</th>
                <th class="tabladp">TOTAL OC</th>
                <th class="tabladp">TOTAL FACTURA</th>
                <th class="tabladp">PERCEPCION</th>
                <th class="tabladp">RETENCION</th>
                <th class="tabladp">SERIE FACTURA</th>
                <th class="tabladp">NUMERO FACTURA</th>
                <th class="tabladp">FECHA FACTURA</th>
                <th class="tabladp">INFORMACIÓN DE LA ORDEN DE COMPRA</th>
                <th class="tabladp">AREA</th>
                <th class="tabladp">FORMA PAGO</th>
                <th class="tabladp">FECHA REGISTRO PROVEEDOR</th>
                <th class="tabladp">USUARIO CONTACTO</th>
                <th class="tabladp">FECHA REGISTRO U. CONTACTO</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN CONTABILIDAD</th>
                <th class="tabladp">FECHA REGISTRO CONTABILIDAD</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN ADMINISTRACIÓN</th>
                <th class="tabladp">FECHA REGISTRO ADMINISTRACION</th>
                <th class="tabladp">ESTADO</th>
                <th class="tabladp">OBSERVACION</th>
                <th class="tabladp">REPARABLE</th>
                <th class="tabladp">OBSERVADO REPARABLE</th>
                <th class="tabladp">FOLIO</th>
                <th class="tabladp">BANCO</th>
                <th class="tabladp">HISTORIAL OBSERVACION</th>
                <th class="tabladp">HISTORIAL REPARABLE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listadatos as $index => $item) 
            <tr>
                <td class="center">{{$index + 1}}</td>
                <td>{{ get_nombre_sede($item) }}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->COD_ORDEN}}</td>
                <td>{{$item->FEC_ORDEN}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->RUC_PROVEEDOR ?? ''}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->TXT_EMPR_CLIENTE ?? $item->TXT_EMPR_PROVEEDOR ?? ''}}</td>
                <td class="number">{{is_numeric($item->CAN_TOTAL) ? (float)$item->CAN_TOTAL : $item->CAN_TOTAL}}</td>
                <td class="number">{{is_numeric($item->TOTAL_VENTA_ORIG) ? (float)$item->TOTAL_VENTA_ORIG : $item->TOTAL_VENTA_ORIG}}</td>
                <td class="number">{{is_numeric($item->PERCEPCION) ? (float)$item->PERCEPCION : $item->PERCEPCION}}</td>
                <td class="number">{{is_numeric($item->MONTO_RETENCION) ? (float)$item->MONTO_RETENCION : $item->MONTO_RETENCION}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->SERIE}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->NUMERO}}</td>
                <td>{{$item->FEC_VENTA}}</td>
                <td>{{ !empty($item->TXT_GLOSA_ORDEN) ? $item->TXT_GLOSA_ORDEN : ($item->TXT_GLOSA ?? $item->GLOSA ?? $item->TXT_OBSERVACION ?? '') }}</td>
                <td>{{$item->AREA}}</td>
                <td>{{$item->FORMA_PAGO}}</td>
                <td>{{ safe_format_date($item->fecha_pa) }}</td>
                <td>{{$item->TXT_CONTACTO_UC}}</td>
                <td>{{ safe_format_date($item->fecha_uc) }}</td>
                <td>{{ get_user_name_excel($item->usuario_pr) }}</td>
                <td>{{ safe_format_date($item->fecha_pr) }}</td>
                <td>{{ get_user_name_excel($item->usuario_ap) }}</td>
                <td>{{ safe_format_date($item->fecha_ap) }}</td>
                <td>{{!empty($item->TXT_ESTADO) ? $item->TXT_ESTADO : 'GENERADO'}}</td>
                <td>{{(isset($item->ind_observacion) && $item->ind_observacion == 1) ? 'EN PROCESO' : 'SIN OBSERVACIONES'}}</td>
                <td>{{(isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 1) ? 'EN PROCESO' : ((isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 2) ? 'EN REVISION' : '-')}}</td>
                <td>{{(isset($item->IND_OBSERVACION_REPARABLE) && $item->IND_OBSERVACION_REPARABLE == 1) ? 'OBSERVADO' : '-'}}</td>
                <td>{{$item->FOLIO}}</td>
                <td>{{$item->TXT_CATEGORIA_BANCO}}</td>
                <td>{{$item->TXT_OBSERVADO}}</td>
                <td>{{$item->TXT_REPARABLE}}</td>
            </tr>
            @endforeach
        </tbody>

    @elseif($operacion_id == 'CONTRATO')
        <thead>
            <tr>
                <th colspan="28" class="titulo-centrado">{{ $nombre_titulo }}</th>
            </tr>
            <tr>
                <th class="tabladp">ITEM</th>
                <th class="tabladp">SEDE</th>
                <th class="tabladp">CODIGO CONTRATO</th>
                <th class="tabladp">FECHA EMISION</th>
                <th class="tabladp">DOCUMENTO</th>
                <th class="tabladp">PROVEEDOR</th>
                <th class="tabladp">TOTAL CONTRATO</th>
                <th class="tabladp">TOTAL FACTURA</th>
                <th class="tabladp">SERIE FACTURA</th>
                <th class="tabladp">NUMERO FACTURA</th>
                <th class="tabladp">FECHA FACTURA</th>
                <th class="tabladp">INFORMACIÓN DE LA ORDEN DE COMPRA</th>
                <th class="tabladp">AREA</th>
                <th class="tabladp">FORMA PAGO</th>
                <th class="tabladp">FECHA REGISTRO PROVEEDOR</th>
                <th class="tabladp">USUARIO CONTACTO</th>
                <th class="tabladp">FECHA REGISTRO U. CONTACTO</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN CONTABILIDAD</th>
                <th class="tabladp">FECHA REGISTRO CONTABILIDAD</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN ADMINISTRACIÓN</th>
                <th class="tabladp">FECHA REGISTRO ADMINISTRACION</th>
                <th class="tabladp">ESTADO</th>
                <th class="tabladp">OBSERVACION</th>
                <th class="tabladp">REPARABLE</th>
                <th class="tabladp">OBSERVADO REPARABLE</th>
                <th class="tabladp">FOLIO</th>
                <th class="tabladp">HISTORIAL OBSERVACION</th>
                <th class="tabladp">HISTORIAL REPARABLE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listadatos as $index => $item)
            <tr>
                <td class="center">{{$index + 1}}</td>
                <td>{{ get_nombre_sede($item) }}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->COD_DOCUMENTO_CTBLE}}</td>
                <td>{{$item->FEC_EMISION}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
                <td>{{$item->TXT_EMPR_EMISOR}}</td>
                <td class="number">{{is_numeric($item->CAN_TOTAL) ? (float)$item->CAN_TOTAL : $item->CAN_TOTAL}}</td>
                <td class="number">{{is_numeric($item->TOTAL_VENTA_ORIG) ? (float)$item->TOTAL_VENTA_ORIG : $item->TOTAL_VENTA_ORIG}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->SERIE}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->NUMERO}}</td>
                <td>{{$item->FEC_VENTA}}</td>
                <td>{{$item->TXT_GLOSA ?? $item->GLOSA ?? $item->TXT_OBSERVACION ?? ''}}</td>
                <td>{{$item->AREA}}</td>
                <td>{{$item->FORMA_PAGO}}</td>
                <td>{{ safe_format_date($item->fecha_pa) }}</td>
                <td>{{$item->TXT_CONTACTO}}</td>
                <td>{{ safe_format_date($item->fecha_uc) }}</td>
                <td>{{ get_user_name_excel($item->usuario_pr) }}</td>
                <td>{{ safe_format_date($item->fecha_pr) }}</td>
                <td>{{ get_user_name_excel($item->usuario_ap) }}</td>
                <td>{{ safe_format_date($item->fecha_ap) }}</td>
                <td>{{!empty($item->TXT_ESTADO) ? $item->TXT_ESTADO : 'GENERADO'}}</td>
                <td>{{(isset($item->ind_observacion) && $item->ind_observacion == 1) ? 'EN PROCESO' : 'SIN OBSERVACIONES'}}</td>
                <td>{{(isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 1) ? 'EN PROCESO' : ((isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 2) ? 'EN REVISION' : '-')}}</td>
                <td>{{(isset($item->IND_OBSERVACION_REPARABLE) && $item->IND_OBSERVACION_REPARABLE == 1) ? 'OBSERVADO' : '-'}}</td>
                <td>{{$item->FOLIO}}</td>
                <td>{{$item->TXT_OBSERVADO}}</td>
                <td>{{$item->TXT_REPARABLE}}</td>
            </tr>
            @endforeach
        </tbody>

    @elseif($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO')
        <thead>
            <tr>
                <th colspan="29" class="titulo-centrado">{{ $nombre_titulo }}</th>
            </tr>
            <tr>
                <th class="tabladp">ITEM</th>
                <th class="tabladp">SEDE</th>
                <th class="tabladp">CODIGO AUTORIZACION</th>
                <th class="tabladp">FECHA AUTORIZACION</th>
                <th class="tabladp">DOCUMENTO</th>
                <th class="tabladp">PROVEEDOR</th>
                <th class="tabladp">TOTAL LCA</th>
                <th class="tabladp">TOTAL FACTURA</th>
                <th class="tabladp">SERIE FACTURA</th>
                <th class="tabladp">NUMERO FACTURA</th>
                <th class="tabladp">FECHA FACTURA</th>
                <th class="tabladp">INFORMACIÓN DE LA ORDEN DE COMPRA</th>
                <th class="tabladp">AREA</th>
                <th class="tabladp">FORMA PAGO</th>
                <th class="tabladp">FECHA REGISTRO PROVEEDOR</th>
                <th class="tabladp">USUARIO CONTACTO</th>
                <th class="tabladp">FECHA REGISTRO U. CONTACTO</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN CONTABILIDAD</th>
                <th class="tabladp">FECHA REGISTRO CONTABILIDAD</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN ADMINISTRACIÓN</th>
                <th class="tabladp">FECHA REGISTRO ADMINISTRACION</th>
                <th class="tabladp">ESTADO</th>
                <th class="tabladp">OBSERVACION</th>
                <th class="tabladp">REPARABLE</th>
                <th class="tabladp">OBSERVADO REPARABLE</th>
                <th class="tabladp">CUENTA OSIRIS</th>
                <th class="tabladp">FOLIO</th>
                <th class="tabladp">HISTORIAL OBSERVACION</th>
                <th class="tabladp">HISTORIAL REPARABLE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listadatos as $index => $item)
                @php $NOMBRE_OSIRIS = isset($item->ID_DOCUMENTO) ? $funcion->funciones->cuenta_osiris_lca($item->ID_DOCUMENTO) : '' @endphp
            <tr>
                <td class="center">{{$index + 1}}</td>
                <td>{{ get_nombre_sede($item) }}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->COD_AUTORIZACION}}</td>
                <td>{{$item->FEC_AUTORIZACION}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->TXT_SERIE}} - {{$item->TXT_NUMERO}}</td>
                <td>{{$NOMBRE_OSIRIS != '' ? $NOMBRE_OSIRIS : $item->TXT_EMPRESA}}</td>
                <td class="number">{{is_numeric($item->CAN_TOTAL) ? (float)$item->CAN_TOTAL : $item->CAN_TOTAL}}</td>
                <td class="number">{{is_numeric($item->TOTAL_VENTA_ORIG) ? (float)$item->TOTAL_VENTA_ORIG : $item->TOTAL_VENTA_ORIG}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->SERIE}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->NUMERO}}</td>
                <td>{{$item->FEC_VENTA}}</td>
                <td>{{$item->TXT_GLOSA ?? $item->GLOSA ?? $item->TXT_OBSERVACION ?? ''}}</td>
                <td>{{$item->AREA}}</td>
                <td>{{$item->FORMA_PAGO}}</td>
                <td>{{ safe_format_date($item->fecha_pa) }}</td>
                <td>{{$item->TXT_CONTACTO}}</td>
                <td>{{ safe_format_date($item->fecha_uc) }}</td>
                <td>{{ get_user_name_excel($item->usuario_pr) }}</td>
                <td>{{ safe_format_date($item->fecha_pr) }}</td>
                <td>{{ get_user_name_excel($item->usuario_ap) }}</td>
                <td>{{ safe_format_date($item->fecha_ap) }}</td>
                <td>{{!empty($item->TXT_ESTADO) ? $item->TXT_ESTADO : 'GENERADO'}}</td>
                <td>{{(isset($item->ind_observacion) && $item->ind_observacion == 1) ? 'EN PROCESO' : 'SIN OBSERVACIONES'}}</td>
                <td>{{(isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 1) ? 'EN PROCESO' : ((isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 2) ? 'EN REVISION' : '-')}}</td>
                <td>{{(isset($item->IND_OBSERVACION_REPARABLE) && $item->IND_OBSERVACION_REPARABLE == 1) ? 'OBSERVADO' : '-'}}</td>
                <td>{{$item->TXT_EMPRESA}}</td>
                <td>{{$item->FOLIO}}</td>
                <td>{{$item->TXT_OBSERVADO}}</td>
                <td>{{$item->TXT_REPARABLE}}</td>
            </tr>
            @endforeach
        </tbody>

    @elseif(in_array($operacion_id, ['NOTA_CREDITO', 'NOTA_DEBITO', 'PROVISION_GASTO']))
        <thead>
            <tr>
                <th colspan="26" class="titulo-centrado">{{ $nombre_titulo }}</th>
            </tr>
            <tr>
                <th class="tabladp">ITEM</th>
                <th class="tabladp">SEDE</th>
                <th class="tabladp">CODIGO</th>
                <th class="tabladp">FECHA EMISION</th>
                <th class="tabladp">DOCUMENTO</th>
                <th class="tabladp">PROVEEDOR</th>
                <th class="tabladp">TOTAL</th>
                <th class="tabladp">TOTAL FACTURA</th>
                <th class="tabladp">SERIE FACTURA</th>
                <th class="tabladp">NUMERO FACTURA</th>
                <th class="tabladp">FECHA FACTURA</th>
                <th class="tabladp">INFORMACIÓN DE LA ORDEN DE COMPRA</th>
                <th class="tabladp">AREA</th>
                <th class="tabladp">FORMA PAGO</th>
                <th class="tabladp">FECHA REGISTRO PROVEEDOR</th>
                <th class="tabladp">USUARIO CONTACTO</th>
                <th class="tabladp">FECHA REGISTRO U. CONTACTO</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN CONTABILIDAD</th>
                <th class="tabladp">FECHA REGISTRO CONTABILIDAD</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN ADMINISTRACIÓN</th>
                <th class="tabladp">FECHA REGISTRO ADMINISTRACION</th>
                <th class="tabladp">ESTADO</th>
                <th class="tabladp">OBSERVACION</th>
                <th class="tabladp">REPARABLE</th>
                <th class="tabladp">OBSERVADO REPARABLE</th>
                <th class="tabladp">HISTORIAL OBSERVACION</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listadatos as $index => $item)
            <tr>
                <td class="center">{{$index + 1}}</td>
                <td>{{ get_nombre_sede($item) }}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->COD_DOCUMENTO_CTBLE}}</td>
                <td>{{$item->FEC_EMISION}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
                <td>{{$item->TXT_EMPR_EMISOR}}</td>
                <td class="number">{{is_numeric($item->CAN_TOTAL) ? (float)$item->CAN_TOTAL : $item->CAN_TOTAL}}</td>
                <td class="number">{{is_numeric($item->TOTAL_VENTA_ORIG) ? (float)$item->TOTAL_VENTA_ORIG : $item->TOTAL_VENTA_ORIG}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->SERIE}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->NUMERO}}</td>
                <td>{{$item->FEC_VENTA}}</td>
                <td>{{$item->TXT_GLOSA ?? $item->GLOSA ?? $item->TXT_OBSERVACION ?? ''}}</td>
                <td>{{$item->AREA}}</td>
                <td>{{$item->FORMA_PAGO}}</td>
                <td>{{ safe_format_date($item->fecha_pa) }}</td>
                <td>{{$item->TXT_CONTACTO}}</td>
                <td>{{ safe_format_date($item->fecha_uc) }}</td>
                <td>{{ get_user_name_excel($item->usuario_pr) }}</td>
                <td>{{ safe_format_date($item->fecha_pr) }}</td>
                <td>{{ get_user_name_excel($item->usuario_ap) }}</td>
                <td>{{ safe_format_date($item->fecha_ap) }}</td>
                <td>{{!empty($item->TXT_ESTADO) ? $item->TXT_ESTADO : 'GENERADO'}}</td>
                <td>{{(isset($item->ind_observacion) && $item->ind_observacion == 1) ? 'EN PROCESO' : 'SIN OBSERVACIONES'}}</td>
                <td>{{(isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 1) ? 'EN PROCESO' : ((isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 2) ? 'EN REVISION' : '-')}}</td>
                <td>{{(isset($item->IND_OBSERVACION_REPARABLE) && $item->IND_OBSERVACION_REPARABLE == 1) ? 'OBSERVADO' : '-'}}</td>
                <td>{{$item->TXT_OBSERVADO}}</td>
            </tr>
            @endforeach
        </tbody>

    @elseif($operacion_id == 'COMISION')
        <thead>
            <tr>
                <th colspan="21" class="titulo-centrado">{{ $nombre_titulo }}</th>
            </tr>
            <tr>
                <th class="tabladp">ITEM</th>
                <th class="tabladp">SEDE</th>
                <th class="tabladp">LOTE</th>
                <th class="tabladp">SERIE FACTURA</th>
                <th class="tabladp">NUMERO FACTURA</th>
                <th class="tabladp">FECHA FACTURA</th>
                <th class="tabladp">INFORMACIÓN DE LA ORDEN DE COMPRA</th>
                <th class="tabladp">FORMA PAGO</th>
                <th class="tabladp">PROVEEDOR</th>
                <th class="tabladp">TOTAL FACTURA</th>
                <th class="tabladp">USUARIO CONTACTO</th>
                <th class="tabladp">FECHA REGISTRO PROVEEDOR</th>
                <th class="tabladp">FECHA REGISTRO U. CONTACTO</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN CONTABILIDAD</th>
                <th class="tabladp">FECHA REGISTRO CONTABILIDAD</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN ADMINISTRACIÓN</th>
                <th class="tabladp">FECHA REGISTRO ADMINISTRACION</th>
                <th class="tabladp">ESTADO</th>
                <th class="tabladp">OBSERVACION</th>
                <th class="tabladp">REPARABLE</th>
                <th class="tabladp">OBSERVADO REPARABLE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listadatos as $index => $item)
            <tr>
                <td class="center">{{$index + 1}}</td>
                <td>{{ get_nombre_sede($item) }}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->ID_DOCUMENTO}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->SERIE}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->NUMERO}}</td>
                <td>{{$item->FEC_VENTA}}</td>
                <td>{{$item->TXT_GLOSA ?? $item->GLOSA ?? $item->TXT_OBSERVACION ?? ''}}</td>
                <td>{{$item->FORMA_PAGO}}</td>
                <td>{{$item->RZ_PROVEEDOR}}</td>
                <td class="number">{{is_numeric($item->TOTAL_VENTA_ORIG) ? (float)$item->TOTAL_VENTA_ORIG : $item->TOTAL_VENTA_ORIG}}</td>
                <td>{{$item->TXT_CONTACTO}}</td>
                <td>{{ safe_format_date($item->fecha_pa) }}</td>
                <td>{{ safe_format_date($item->fecha_uc) }}</td>
                <td>{{ get_user_name_excel($item->usuario_pr) }}</td>
                <td>{{ safe_format_date($item->fecha_pr) }}</td>
                <td>{{ get_user_name_excel($item->usuario_ap) }}</td>
                <td>{{ safe_format_date($item->fecha_ap) }}</td>
                <td>{{!empty($item->TXT_ESTADO) ? $item->TXT_ESTADO : 'GENERADO'}}</td>
                <td>{{(isset($item->ind_observacion) && $item->ind_observacion == 1) ? 'EN PROCESO' : 'SIN OBSERVACIONES'}}</td>
                <td>{{(isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 1) ? 'EN PROCESO' : ((isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 2) ? 'EN REVISION' : '-')}}</td>
                <td>{{(isset($item->IND_OBSERVACION_REPARABLE) && $item->IND_OBSERVACION_REPARABLE == 1) ? 'OBSERVADO' : '-'}}</td>
            </tr>
            @endforeach
        </tbody>

    @elseif($operacion_id == 'DOCUMENTO_INTERNO_COMPRA')
        <thead>
            <tr>
                <th colspan="26" class="titulo-centrado">{{ $nombre_titulo }}</th>
            </tr>
            <tr>
                <th class="tabladp">ITEM</th>
                <th class="tabladp">SEDE</th>
                <th class="tabladp">LOTE</th>
                <th class="tabladp">SERIE FACTURA</th>
                <th class="tabladp">NUMERO FACTURA</th>
                <th class="tabladp">FECHA FACTURA</th>
                <th class="tabladp">INFORMACIÓN DE LA ORDEN DE COMPRA</th>
                <th class="tabladp">FORMA PAGO</th>
                <th class="tabladp">PROVEEDOR</th>
                <th class="tabladp">TOTAL FACTURA</th>
                <th class="tabladp">USUARIO CONTACTO</th>
                <th class="tabladp">FECHA REGISTRO PROVEEDOR</th>
                <th class="tabladp">FECHA REGISTRO U. CONTACTO</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN CONTABILIDAD</th>
                <th class="tabladp">FECHA REGISTRO CONTABILIDAD</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN ADMINISTRACIÓN</th>
                <th class="tabladp">FECHA REGISTRO ADMINISTRACION</th>
                <th class="tabladp">ESTADO</th>
                <th class="tabladp">OBSERVACION</th>
                <th class="tabladp">REPARABLE</th>
                <th class="tabladp">OBSERVADO REPARABLE</th>
                <th class="tabladp">CUENTA OSIRIS</th>
                <th class="tabladp">REVISAO DE CONTABILIDAD</th>
                <th class="tabladp">FOLIO</th>
                <th class="tabladp">HISTORIAL OBSERVACION</th>
                <th class="tabladp">HISTORIAL REPARABLE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listadatos as $index => $item)
                @php $NOMBRE_OSIRIS = isset($item->ID_DOCUMENTO) ? $funcion->funciones->cuenta_osiris_lic($item->ID_DOCUMENTO) : '' @endphp
            <tr>
                <td class="center">{{$index + 1}}</td>
                <td>{{ get_nombre_sede($item) }}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->ID_DOCUMENTO}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->SERIE}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->NUMERO}}</td>
                <td>{{$item->FEC_VENTA}}</td>
                <td>{{$item->TXT_GLOSA ?? $item->GLOSA ?? $item->TXT_OBSERVACION ?? ''}}</td>
                <td>{{$item->FORMA_PAGO}}</td>
                <td>{{$item->RZ_PROVEEDOR}}</td>
                <td class="number">{{is_numeric($item->TOTAL_VENTA_ORIG) ? (float)$item->TOTAL_VENTA_ORIG : $item->TOTAL_VENTA_ORIG}}</td>
                <td>{{$item->TXT_CONTACTO}}</td>
                <td>{{ safe_format_date($item->fecha_pa) }}</td>
                <td>{{ safe_format_date($item->fecha_uc) }}</td>
                <td>{{ get_user_name_excel($item->usuario_pr) }}</td>
                <td>{{ safe_format_date($item->fecha_pr) }}</td>
                <td>{{ get_user_name_excel($item->usuario_ap) }}</td>
                <td>{{ safe_format_date($item->fecha_ap) }}</td>
                <td>{{!empty($item->TXT_ESTADO) ? $item->TXT_ESTADO : 'GENERADO'}}</td>
                <td>{{(isset($item->ind_observacion) && $item->ind_observacion == 1) ? 'EN PROCESO' : 'SIN OBSERVACIONES'}}</td>
                <td>{{(isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 1) ? 'EN PROCESO' : ((isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 2) ? 'EN REVISION' : '-')}}</td>
                <td>{{(isset($item->IND_OBSERVACION_REPARABLE) && $item->IND_OBSERVACION_REPARABLE == 1) ? 'OBSERVADO' : '-'}}</td>
                <td>{{$NOMBRE_OSIRIS}}</td>
                <td>{{$item->IND_CONTABILIDAD_APRO == '1' ? 'REVISADO' : 'POR REVISAR'}}</td>
                <td>{{$item->FOLIO}}</td>
                <td>{{$item->TXT_OBSERVADO}}</td>
                <td>{{$item->TXT_REPARABLE}}</td>
            </tr>
            @endforeach
        </tbody>

    @else
        <thead>
            <tr>
                <th colspan="24" class="titulo-centrado">{{ $nombre_titulo }}</th>
            </tr>
            <tr>
                <th class="tabladp">ITEM</th>
                <th class="tabladp">SEDE</th>
                <th class="tabladp">LOTE</th>
                <th class="tabladp">SERIE FACTURA</th>
                <th class="tabladp">NUMERO FACTURA</th>
                <th class="tabladp">FECHA FACTURA</th>
                <th class="tabladp">INFORMACIÓN DE LA ORDEN DE COMPRA</th>
                <th class="tabladp">FORMA PAGO</th>
                <th class="tabladp">PROVEEDOR</th>
                <th class="tabladp">TOTAL FACTURA</th>
                <th class="tabladp">USUARIO CONTACTO</th>
                <th class="tabladp">FECHA REGISTRO PROVEEDOR</th>
                <th class="tabladp">FECHA REGISTRO U. CONTACTO</th>
                <th class="tabladp">USUARIO QUE APRUEBA EN CONTABILIDAD</th>
                @if($operacion_id != 'DOCUMENTO_INTERNO_COMPRA')
                <th class="tabladp">FECHA REGISTRO CONTABILIDAD</th>
                @endif
                <th class="tabladp">USUARIO QUE APRUEBA EN ADMINISTRACIÓN</th>
                <th class="tabladp">FECHA REGISTRO ADMINISTRACION</th>
                <th class="tabladp">ESTADO</th>
                <th class="tabladp">OBSERVACION</th>
                <th class="tabladp">REPARABLE</th>
                <th class="tabladp">OBSERVADO REPARABLE</th>
                <th class="tabladp">FOLIO</th>
                <th class="tabladp">HISTORIAL OBSERVACION</th>
                <th class="tabladp">HISTORIAL REPARABLE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listadatos as $index => $item)
            <tr>
                <td class="center">{{$index + 1}}</td>
                <td>{{ get_nombre_sede($item) }}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->ID_DOCUMENTO}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->SERIE}}</td>
                <td class="texto" style="mso-number-format:'\@';">{{$item->NUMERO}}</td>
                <td>{{$item->FEC_VENTA}}</td>
                <td>{{$item->TXT_GLOSA ?? $item->GLOSA ?? $item->TXT_OBSERVACION ?? ''}}</td>
                <td>{{$item->FORMA_PAGO}}</td>
                <td>{{$item->RZ_PROVEEDOR}}</td>
                <td class="number">{{is_numeric($item->TOTAL_VENTA_ORIG) ? (float)$item->TOTAL_VENTA_ORIG : $item->TOTAL_VENTA_ORIG}}</td>
                <td>{{$item->TXT_CONTACTO}}</td>
                <td>{{ safe_format_date($item->fecha_pa) }}</td>
                <td>{{ safe_format_date($item->fecha_uc) }}</td>
                <td>{{ get_user_name_excel($item->usuario_pr) }}</td>
                @if($operacion_id != 'DOCUMENTO_INTERNO_COMPRA')
                <td>{{ safe_format_date($item->fecha_pr) }}</td>
                @endif
                <td>{{ get_user_name_excel($item->usuario_ap) }}</td>
                <td>{{ safe_format_date($item->fecha_ap) }}</td>
                <td>{{!empty($item->TXT_ESTADO) ? $item->TXT_ESTADO : 'GENERADO'}}</td>
                <td>{{(isset($item->ind_observacion) && $item->ind_observacion == 1) ? 'EN PROCESO' : 'SIN OBSERVACIONES'}}</td>
                <td>{{(isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 1) ? 'EN PROCESO' : ((isset($item->IND_REPARABLE) && $item->IND_REPARABLE == 2) ? 'EN REVISION' : '-')}}</td>
                <td>{{(isset($item->IND_OBSERVACION_REPARABLE) && $item->IND_OBSERVACION_REPARABLE == 1) ? 'OBSERVADO' : '-'}}</td>
                <td>{{$item->FOLIO}}</td>
                <td>{{$item->TXT_OBSERVADO}}</td>
                <td>{{$item->TXT_REPARABLE}}</td>
            </tr>
            @endforeach
        </tbody>
    @endif
    </table>
</html>
