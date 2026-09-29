<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        .th-header {
            background-color: #1d3a6d;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000000;
        }
        .th-header-right {
            background-color: #1d3a6d;
            color: #ffffff;
            font-weight: bold;
            text-align: right;
            border: 1px solid #000000;
        }
        .td-center {
            text-align: center;
            border: 1px solid #cccccc;
        }
        .td-left {
            text-align: left;
            border: 1px solid #cccccc;
        }
        .td-right {
            text-align: right;
            border: 1px solid #cccccc;
        }
        .total-label {
            background-color: #e2e8f0;
            font-weight: bold;
            text-align: right;
            border: 1px solid #000000;
        }
        .total-value {
            background-color: #e2e8f0;
            font-weight: bold;
            text-align: right;
            border: 1px solid #000000;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th class="th-header" style="background-color: #1d3a6d; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #000000;">FECHA EMISION</th>
                <th class="th-header" style="background-color: #1d3a6d; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #000000;">DOCUMENTO</th>
                <th class="th-header" style="background-color: #1d3a6d; color: #ffffff; font-weight: bold; text-align: left; border: 1px solid #000000;">PROVEEDOR</th>
                <th class="th-header-right" style="background-color: #1d3a6d; color: #ffffff; font-weight: bold; text-align: right; border: 1px solid #000000;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php $sumaTotal = 0; @endphp
            @foreach($listadetalle as $index => $item)
                @php $sumaTotal += (float)$item->TOTAL; @endphp
                <tr>
                    <td class="td-center" style="text-align: center; border: 1px solid #cccccc;">
                        {{ !empty($item->FECHA_EMISION) ? date_format(date_create($item->FECHA_EMISION), 'd/m/Y') : '' }}
                    </td>
                    <td class="td-center" style="text-align: center; border: 1px solid #cccccc;">
                        {{ !empty($item->SERIE) ? $item->SERIE . ' - ' . $item->NUMERO : $item->NUMERO }}
                    </td>
                    <td class="td-left" style="text-align: left; border: 1px solid #cccccc;">
                        {{ $item->TXT_EMPRESA_PROVEEDOR }}
                    </td>
                    <td class="td-right" style="text-align: right; border: 1px solid #cccccc;">
                        {{ number_format((float)$item->TOTAL, 2, '.', '') }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="total-label" style="background-color: #e2e8f0; font-weight: bold; text-align: right; border: 1px solid #000000;">TOTAL:</td>
                <td class="total-value" style="background-color: #e2e8f0; font-weight: bold; text-align: right; border: 1px solid #000000;">{{ number_format($sumaTotal, 2, '.', '') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
