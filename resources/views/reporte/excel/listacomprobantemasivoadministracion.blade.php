<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #cbd5e1;
            font-family: Calibri;
        }

        /* Banner de Título */
        .title-banner {
            background-color: #1e3a8a; /* Deep Navy */
            color: #ffffff;
            font-family: Calibri;
            font-size: 14;
            font-weight: bold;
            text-align: center;
        }

        .subtitle-banner {
            background-color: #f1f5f9;
            color: #475569;
            font-family: Calibri;
            font-size: 10;
            font-weight: bold;
            text-align: left;
        }

        /* Cabeceras por Categoría */
        .header-contrato {
            background-color: #0284c7; /* Sky Blue 600 */
            color: #ffffff;
            font-family: Calibri;
            font-size: 10;
            font-weight: bold;
            text-align: center;
        }

        .header-comprobante {
            background-color: #334155; /* Slate 700 */
            color: #ffffff;
            font-family: Calibri;
            font-size: 10;
            font-weight: bold;
            text-align: center;
        }

        .header-pago {
            background-color: #059669; /* Emerald 600 */
            color: #ffffff;
            font-family: Calibri;
            font-size: 10;
            font-weight: bold;
            text-align: center;
        }

        .header-dias {
            background-color: #d97706; /* Amber 600 */
            color: #ffffff;
            font-family: Calibri;
            font-size: 10;
            font-weight: bold;
            text-align: center;
        }

        /* Celdas de datos */
        .row-even {
            background-color: #ffffff;
        }

        .row-odd {
            background-color: #f8fafc;
        }

        .cell-text {
            font-family: Calibri;
            font-size: 10;
            color: #1e293b;
            text-align: left;
        }

        .cell-center {
            font-family: Calibri;
            font-size: 10;
            color: #1e293b;
            text-align: center;
        }

        .cell-code {
            font-family: Calibri;
            font-size: 10;
            color: #1e293b;
            text-align: center;
            mso-number-format: "\@";
        }

        .cell-money {
            font-family: Calibri;
            font-size: 10;
            color: #1e293b;
            text-align: right;
            mso-number-format: "#,##0.00";
        }

        .cell-number-int {
            font-family: Calibri;
            font-size: 10;
            color: #1e293b;
            text-align: center;
            font-weight: bold;
            mso-number-format: "0";
        }

        /* Estados */
        .estado-pagado {
            background-color: #dcfce7;
            color: #166534;
            font-family: Calibri;
            font-size: 10;
            font-weight: bold;
            text-align: center;
        }

        .estado-pendiente {
            background-color: #fef3c7;
            color: #92400e;
            font-family: Calibri;
            font-size: 10;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <!-- Banner Principal -->
        <tr>
            <th colspan="30" class="title-banner">REPORTE ADMINISTRATIVO DE CONTRATOS Y CANCELACIÓN DE FACTURAS</th>
        </tr>
        <tr>
            <th colspan="30" class="subtitle-banner">
                RANGO DE FECHAS: {{ $fecha_inicio }} AL {{ $fecha_fin }} &nbsp;|&nbsp; 
                PROVEEDOR: {{ $proveedor_id != 'TODO' ? $proveedor_id : 'TODOS' }} &nbsp;|&nbsp; 
                TOTAL REGISTROS: {{ count($listadatos) }} &nbsp;|&nbsp; 
                GENERADO EL: {{ date('d/m/Y H:i:s') }}
            </th>
        </tr>

        <!-- Cabecera de Columnas -->
        <tr>
            <!-- Datos del Contrato -->
            <th class="header-contrato">N°</th>
            <th class="header-contrato">N° CONTRATO</th>
            <th class="header-contrato">FECHA EMISIÓN CONTRATO</th>
            <th class="header-contrato">EMPRESA RECEPTORA</th>
            <th class="header-contrato">SEDE / CENTRO</th>

            <!-- Datos del Proveedor -->
            <th class="header-comprobante">RUC PROVEEDOR</th>
            <th class="header-comprobante">PROVEEDOR</th>

            <!-- Datos de Factura / Comprobante -->
            <th class="header-comprobante">TIPO COMPROBANTE</th>
            <th class="header-comprobante">N° FACTURA / COMPROBANTE</th>
            <th class="header-comprobante">FECHA EMISIÓN FACTURA</th>
            <th class="header-comprobante">DESCRIPCIÓN DE BIEN O SERVICIO</th>
            <th class="header-comprobante">GUÍAS ASOCIADAS</th>
            <th class="header-comprobante">MONEDA</th>
            <th class="header-comprobante">TIPO DE CAMBIO</th>
            <th class="header-comprobante">BASE / SUBTOTAL</th>
            <th class="header-comprobante">IGV</th>
            <th class="header-comprobante">TOTAL FACTURA</th>
            <th class="header-comprobante">ESTADO COMPROBANTE</th>

            <!-- Detracción -->
            <th class="header-comprobante">DETRACCIÓN</th>
            <th class="header-comprobante">CÓD. DETRACCIÓN</th>
            <th class="header-comprobante">MONTO DETRACCIÓN</th>
            <th class="header-comprobante">CONSTANCIA DETRACCIÓN</th>

            <!-- Datos de Pago -->
            <th class="header-pago">ESTADO PAGO</th>
            <th class="header-pago">FECHA DE PAGO</th>
            <th class="header-pago">MEDIO DE PAGO</th>
            <th class="header-pago">BANCO DE PAGO</th>
            <th class="header-pago">IMPORTE NETO PAGADO</th>
            <th class="header-pago">DETRACCIÓN PAGADA</th>
            <th class="header-pago">TOTAL CANCELADO</th>

            <!-- Días de Diferencia -->
            <th class="header-dias">DÍAS DIFERENCIA (FACTURA A PAGO)</th>
            <th class="header-dias">DÍAS DIFERENCIA (CONTRATO A PAGO)</th>
            <th class="header-comprobante">USUARIO CONTACTO</th>
        </tr>

        <!-- Filas de Datos -->
        @foreach($listadatos as $index => $item)
            @php
                $es_par = ($index % 2 == 0);
                $clase_fila = $es_par ? 'row-even' : 'row-odd';
                $tiene_detraccion = ((float)$item->MONTO_DETRACCION > 0);
            @endphp
            <tr>
                <td class="cell-center {{ $clase_fila }}">{{ $index + 1 }}</td>
                <td class="cell-code {{ $clase_fila }}">{{ $item->NRO_CONTRATO }}</td>
                <td class="cell-center {{ $clase_fila }}">{{ $item->FECHA_EMISION_CONTRATO }}</td>
                <td class="cell-text {{ $clase_fila }}">{{ $item->EMPRESA_RECEPTORA }}</td>
                <td class="cell-text {{ $clase_fila }}">{{ $item->SEDE_CENTRO }}</td>

                <td class="cell-code {{ $clase_fila }}">{{ $item->RUC_PROVEEDOR }}</td>
                <td class="cell-text {{ $clase_fila }}">{{ $item->RZ_PROVEEDOR }}</td>

                <td class="cell-center {{ $clase_fila }}">
                    @if($item->ID_TIPO_DOC == '01')
                        FACTURA
                    @elseif($item->ID_TIPO_DOC == '02')
                        RECIBO POR HONORARIOS
                    @elseif($item->ID_TIPO_DOC == '03')
                        BOLETA
                    @else
                        {{ $item->ID_TIPO_DOC }}
                    @endif
                </td>
                <td class="cell-code {{ $clase_fila }}">{{ $item->NRO_COMPROBANTE }}</td>
                <td class="cell-center {{ $clase_fila }}">{{ $item->FECHA_EMISION_FACTURA }}</td>
                <td class="cell-text {{ $clase_fila }}">{{ $item->DESCRIPCION_SERVICIO }}</td>
                <td class="cell-text {{ $clase_fila }}">{{ $item->GUIAS_ASOCIADAS }}</td>
                <td class="cell-center {{ $clase_fila }}">{{ $item->MONEDA }}</td>
                <td class="cell-money {{ $clase_fila }}">{{ number_format((float)$item->TIPO_CAMBIO, 3, '.', '') }}</td>
                <td class="cell-money {{ $clase_fila }}">{{ number_format((float)$item->SUBTOTAL_FACTURA, 2, '.', '') }}</td>
                <td class="cell-money {{ $clase_fila }}">{{ number_format((float)$item->IGV_FACTURA, 2, '.', '') }}</td>
                <td class="cell-money {{ $clase_fila }}">{{ number_format((float)$item->TOTAL_FACTURA, 2, '.', '') }}</td>
                <td class="cell-center {{ $clase_fila }}">{{ $item->ESTADO_COMPROBANTE }}</td>

                <!-- Detracción -->
                <td class="cell-center {{ $clase_fila }}">{{ $tiene_detraccion ? 'SI' : 'NO' }}</td>
                <td class="cell-code {{ $clase_fila }}">{{ $tiene_detraccion ? trim($item->TIPO_DETRACCION) : '-' }}</td>
                <td class="cell-money {{ $clase_fila }}">{{ number_format((float)$item->MONTO_DETRACCION, 2, '.', '') }}</td>
                <td class="cell-code {{ $clase_fila }}">{{ !empty($item->FOLIO_DETRACCION) ? $item->FOLIO_DETRACCION : '-' }}</td>

                <!-- Pago -->
                <td class="{{ $item->ESTADO_PAGO == 'PAGADO' ? 'estado-pagado' : 'estado-pendiente' }}">
                    {{ $item->ESTADO_PAGO }}
                </td>
                <td class="cell-center {{ $clase_fila }}">
                    {{ !empty($item->FECHA_PAGO) ? $item->FECHA_PAGO : '-' }}
                </td>
                <td class="cell-center {{ $clase_fila }}">{{ !empty($item->MEDIO_PAGO) ? $item->MEDIO_PAGO : '-' }}</td>
                <td class="cell-text {{ $clase_fila }}">{{ !empty($item->BANCO_PAGO) ? $item->BANCO_PAGO : '-' }}</td>
                <td class="cell-money {{ $clase_fila }}">{{ number_format((float)$item->IMPORTE_NETO_PAGADO, 2, '.', '') }}</td>
                <td class="cell-money {{ $clase_fila }}">{{ number_format((float)$item->IMPORTE_DETRACCION_PAGADO, 2, '.', '') }}</td>
                <td class="cell-money {{ $clase_fila }}">{{ number_format((float)$item->TOTAL_IMPORTE_PAGADO, 2, '.', '') }}</td>

                <!-- Días de Diferencia -->
                <td class="cell-number-int {{ $clase_fila }}" style="color: {{ $item->ESTADO_PAGO == 'PAGADO' ? '#047857' : '#b45309' }};">
                    {{ $item->DIAS_DIFERENCIA_FACTURA }}
                    @if($item->ESTADO_PAGO != 'PAGADO') (transcurridos) @endif
                </td>
                <td class="cell-number-int {{ $clase_fila }}" style="color: {{ $item->ESTADO_PAGO == 'PAGADO' ? '#047857' : '#b45309' }};">
                    {{ $item->DIAS_DIFERENCIA_CONTRATO }}
                    @if($item->ESTADO_PAGO != 'PAGADO') (transcurridos) @endif
                </td>
                <td class="cell-text {{ $clase_fila }}">{{ $item->USUARIO_CONTACTO }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
