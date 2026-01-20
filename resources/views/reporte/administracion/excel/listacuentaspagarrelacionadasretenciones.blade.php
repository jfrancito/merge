<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @php
        $total_mn = 0.0000;
        $total_me = 0.0000;
    @endphp
    <style type="text/css">
        h1{
            text-align: center;
        }
        .footerho{
            border: 1px solid #000000;
            background: #4285f4;
            color: #fff;
            font-weight: bold;
        }
        .tablaho{
            border: 1px solid #000000;
            background: #1d3a6d;
            color:#fff;
            font-weight: bold;
        }
        .center{
            text-align: center;
        }
    </style>
    <table>
        <thead>
        <tr>
            <th class="center tablaho">CLIENTE</th>
            <th class="center tablaho">CONTRATO</th>
            <th class="center tablaho">CENTRO</th>
            <th class="center tablaho">TIPO CAMBIO</th>
            <th class="center tablaho">FECHA DOCUMENTO</th>
            <th class="center tablaho">TIPO DOCUMENTO</th>
            <th class="center tablaho">NUMERO DOCUMENTO</th>
            <th class="center tablaho">FACTURAS RELACIONADAS</th>
            <th class="center tablaho">DIAS TRANSCURRIDOS</th>
            <th class="center tablaho">MONEDA</th>
            <th class="center tablaho">JEFE VENTA</th>
            <th class="center tablaho">TIPO CONTRATO</th>
            <th class="center tablaho">IMPORTE ORIGINAL</th>
            <th class="center tablaho">SALDO S/.</th>
            <th class="center tablaho">SALDO $</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cuentas as $index=>$item)
            @if($item['IND_REL'] === 'R' AND $item['IND_CP'] === 'P' AND str_contains($item['TipoDocumento'], 'COMPROBANTE DE RETENCION DE IGV'))
                <tr>
                    <td class="border"> {{$item['NOM_CLIENTE']}}</td>
                    <td class="border">{{substr($item['NRO_CONTRATO'],0,6).'-'.strval(intval(substr($item['NRO_CONTRATO'],6,16)))}}</td>
                    <td class="border">{{$item['Centro']}}</td>
                    <td class="border">{{number_format($item['Tcambio'], 2, '.', '')}}</td>
                    {{--<td class="border">{{$item["FecDocumento_Emis"]}}</td>--}}
                    <td class="border">{{\PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new \DateTime($item["FecDocumento"]))}}</td>
                    <td class="border">{{$item['TipoDocumento']}}</td>
                    <td class="border">{{$item['NroDocumento']}}</td>
                    <td class="border">{{$item["DOCS"]}}</td>
                    <td class="border">{{$item['diasTranscurridos']}}</td>
                    <td class="border">{{$item['SIM_MONEDA']}}</td>
                    <td class="border">{{$item['JEFE_VENTA']}}</td>
                    <td class="border">{{$item['TIPO_CONTRATO']}}</td>
                    <td class="border">{{number_format($item['TOT_DOC'], 2, '.', '')}}</td>
                    <td class="border">{{number_format($item['CAN_CAPITAL_SALDO'] + $item['CAN_INTERES_SALDO'], 2, '.', '')}}</td>
                    <td class="border">{{number_format($item['CAN_CAPITAL_SALDO_ME'] + $item['CAN_INTERES_SALDO'], 2, '.', '')}}</td>
                </tr>
                @php
                    $total_mn = $total_mn + ($item['CAN_CAPITAL_SALDO'] + $item['CAN_INTERES_SALDO']);
                    $total_me = $total_me + ($item['CAN_CAPITAL_SALDO_ME'] + $item['CAN_INTERES_SALDO']);
                @endphp
            @endif
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th class="center footerho" colspan="11">Total</th>
            <th class="footerho">{{number_format($total_mn, 2, '.', '')}}</th>
            <th class="footerho">{{number_format($total_me, 2, '.', '')}}</th>
        </tr>
        </tfoot>
    </table>

</html>
