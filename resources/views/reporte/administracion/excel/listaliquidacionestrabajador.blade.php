<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
@php
    $total_soles = 0.00;
@endphp
<style type="text/css">
    .tablaho {
        border: 1px solid #000000;
        background: #1d3a6d;
        color: #fff;
        font-weight: bold;
        text-align: center;
    }
    .border {
        border: 1px solid #000000;
    }
    .center {
        text-align: center;
    }
    .footerho {
        border: 1px solid #000000;
        background: #e0e0e0;
        font-weight: bold;
    }
</style>

<table>
    <thead>
    <tr>
        <th class="tablaho">EMPRESA</th>
        <th class="tablaho">CENTRO</th>
        <th class="tablaho">TRABAJADOR</th>
        <th class="tablaho">FECHA LIQUIDACIÓN</th>
        <th class="tablaho">MES</th>
        <th class="tablaho">NRO LIQUIDACIÓN</th>
        <th class="tablaho">MONEDA</th>
        <th class="tablaho">PROVEEDOR</th>
        <th class="tablaho">TIPO DOC</th>
        <th class="tablaho">NRO DOCUMENTO</th>
        <th class="tablaho">FECHA DOC</th>
        <th class="tablaho">PRODUCTO</th>
        <th class="tablaho">CATEGORÍA</th>
        <th class="tablaho">ESTADO</th>
        <th class="tablaho">MONTO (S/)</th>
        <th class="tablaho">CENTRO COSTO</th>
        <th class="tablaho">GLOSA</th>
        <th class="tablaho">USUARIO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listaLiquidaciones as $item)
        <tr>
            <td class="border">{{ $item['EMP_SISTEMA'] }}</td>
            <td class="border">{{ $item['NOM_CENTRO'] }}</td>
            <td class="border">{{ $item['TRABAJADOR'] }}</td>
            <td class="border">
                {{ \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new \DateTime($item['FECHA_LIQUIDACION'])) }}
            </td>
            <td class="border">{{ $item['MES'] }}</td>
            <td class="border">{{ $item['NRO_LIQUIDACION'] }}</td>
            <td class="border">{{ $item['MONEDA'] }}</td>
            <td class="border">{{ $item['PROVEEDOR'] }}</td>
            <td class="border">{{ $item['TIPO_DOCUMENTO'] }}</td>
            <td class="border">{{ $item['NRO_DOCUMENTO'] }}</td>
            <td class="border">
                @if(!empty($item['FEC_EMISION']))
                    {{ \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new \DateTime($item['FEC_EMISION'])) }}
                @endif
            </td>
            <td class="border">{{ $item['PRODUCTO'] }}</td>
            <td class="border">{{ $item['CATEGORIA_PRODUSTO'] }}</td>
            <td class="border">{{ $item['ESTADO_DOCUMENTO'] }}</td>
            <td class="border">{{ number_format($item['MONTO_DOCUMENTO_SOLES'], 2, '.', '') }}</td>
            <td class="border">{{ $item['CENTRO_COSTO'] }}</td>
            <td class="border">{{ $item['GLOSA'] }}</td>
            <td class="border">{{ $item['USUARIO_REGISTRO'] }}</td>
        </tr>
        @php
            $total_soles += $item['MONTO_DOCUMENTO_SOLES'];
        @endphp
    @endforeach
    </tbody>

    @if($total_soles > 0)
        <tfoot>
        <tr>
            <th class="footerho center" colspan="14">TOTAL</th>
            <th class="footerho">{{ number_format($total_soles, 2, '.', '') }}</th>
            <th class="footerho" colspan="3"></th>
        </tr>
        </tfoot>
    @endif
</table>
</html>
