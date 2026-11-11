<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        /* Configuración General de Bordes y Estructura de Tabla */
        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #cbd5e1; /* Bordes finos color Slate 300 */
        }

        /* Banner de Título Superior (Plomo Medio) */
        .title-banner {
            background-color: #cbd5e1; /* Slate 200 (Plomo Medio) */
            color: #1e293b; /* Dark Slate 800 */
            font-family: Calibri;
            font-size: 14;
            font-weight: bold;
            text-align: center;
        }

        /* Cabeceras de Columnas Únicas (Plomo Bajito) */
        .header-column {
            background-color: #e2e8f0; /* Slate 100 (Plomo Bajito) */
            color: #334155; /* Slate 700 */
            font-family: Calibri;
            font-size: 11;
            font-weight: bold;
            text-align: center;
        }

        /* Filas Alternas (Zebra Striping) */
        .row-even {
            background-color: #ffffff;
        }

        .row-odd {
            background-color: #f8fafc; /* Very light slate gray */
        }

        /* Estilos de Celda por Tipo de Contenido */
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

        .cell-number {
            font-family: Calibri;
            font-size: 10;
            color: #1e293b;
            text-align: right;
        }

        .cell-text-force {
            font-family: Calibri;
            font-size: 10;
            color: #1e293b;
            text-align: center;
            mso-number-format: "\@"; /* Force text format in Excel */
        }
    </style>
    <table>
        <!-- Banner Principal de Título -->
        <tr>
            <th colspan="17" class="title-banner">SERVICIOS POR ACCIONES DE MARKETING</th>
        </tr>
        
        <!-- Cabecera de la Tabla -->
        <tr>
            <th class="header-column">CLASIFICACION DE ACCIONES MARKETING</th>
            <th class="header-column">Nombre de Activación</th>
            <th class="header-column">Periodo</th>
            <th class="header-column">Fecha De Emisión de CPE</th>
            <th class="header-column">Tipo de CPE</th>
            <th class="header-column">Nro De CPE</th>
            <th class="header-column">Proveedor</th>
            <th class="header-column">RUC</th>
            <th class="header-column">Moneda</th>
            <th class="header-column">Descripción del CPE</th>
            <th class="header-column">Base imponible</th>
            <th class="header-column">IGV</th>
            <th class="header-column">TOTAL</th>
            <th class="header-column">Área a cargo</th>
            <th class="header-column">Personal a cargo</th>
            <th class="header-column">Lugar-Ubicación</th>
            <th class="header-column">CTAS CONTABLES</th>
        </tr>

        <!-- Datos con Zebra Striping -->
        @foreach($listadatos as $index => $item) 
        <tr class="{{ $index % 2 == 0 ? 'row-even' : 'row-odd' }}">
            <td class="cell-text">{{ $item->CLASIFICACION_MK }}</td>
            <td class="cell-text">{{ $item->GRUPO_MK_NOMBRE }}</td>
            <td class="cell-center">{{ date_format(date_create($item->FEC_VENTA), 'm-Y') }}</td>
            <td class="cell-center">{{ date_format(date_create($item->FEC_VENTA), 'd-m-Y') }}</td>
            <td class="cell-center">
                @if($item->ID_TIPO_DOC == '01')
                    FACTURA
                @else
                    @if($item->ID_TIPO_DOC == 'R1')
                        RECIBO POR HONORARIO
                    @else
                        RECIBO DE SERVICIOS
                    @endif
                @endif
            </td>
            <td class="cell-center">{{$item->SERIE}} - {{str_pad($item->NUMERO, 7, "0", STR_PAD_LEFT)}}</td>
            <td class="cell-text">{{$item->RZ_PROVEEDOR}}</td>
            <td class="cell-text-force">{{$item->RUC_PROVEEDOR}}</td>
            <td class="cell-center">{{$item->TXT_CATEGORIA_MONEDA}}</td>
            <td class="cell-text">{{$item->PRODUCTO}}</td>
            <td class="cell-number">
                @if($item->ID_TIPO_DOC == '01')
                    {{ number_format($item->VAL_SUBTOTAL_ORIG, 2, '.', '') }}
                @else
                    {{ number_format($item->SUB_TOTAL_VENTA_ORIG, 2, '.', '') }}
                @endif
            </td>
            <td class="cell-number">
                @if($item->ID_TIPO_DOC == '01')
                    {{ number_format($item->VAL_IGV_ORIG, 2, '.', '') }}
                @else
                    {{ number_format($item->VALOR_IGV_ORIG, 2, '.', '') }}
                @endif
            </td>
            <td class="cell-number">
                @if($item->ID_TIPO_DOC == '01')
                    {{ number_format($item->VAL_VENTA_ORIG, 2, '.', '') }}
                @else
                    {{ number_format($item->TOTAL_VENTA_ORIG, 2, '.', '') }}
                @endif
            </td>
            <td class="cell-text">{{ $item->AREA }}</td>
            <td class="cell-text">{{ $item->TXT_CONTACTO_N }}</td>
            <td class="cell-text">{{ $item->UBICACION_MK }}</td>
            <td class="cell-text-force">{{ $item->NRO_CUENTA }}</td>
        </tr>
        @endforeach
    </table>
</html>
