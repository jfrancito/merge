<table id="cxcr" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" style='width: 100%;'>
    @php
        $total_mn = 0.0000;
        $total_me = 0.0000;
    @endphp
    <thead style="background: #1d3a6d; color: white; text-align: center">
    <tr>
        <th>CLIENTE</th>
        <th>CONTRATO</th>
        <th>CENTRO</th>
        <th>TIPO CAMBIO</th>
        <th>FECHA DOCUMENTO</th>
        <th>TIPO DOCUMENTO</th>
        <th>NUMERO DOCUMENTO</th>
        <th>DIAS TRANSCURRIDOS</th>
        <th>MONEDA</th>
        <th>JEFE VENTA</th>
        <th>TIPO CONTRATO</th>
        <th>SALDO S/.</th>
        <th>SALDO $</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cuentas as $index=>$item)
        @if($item['IND_REL'] === 'R' AND $item['IND_CP'] === 'C')
            <tr>
                <td>{{$item['NOM_CLIENTE']}}</td>
                <td>{{substr($item['NRO_CONTRATO'],0,6).'-'.strval(intval(substr($item['NRO_CONTRATO'],6,16)))}}</td>
                <td>{{$item['Centro']}}</td>
                <td>{{number_format($item['Tcambio'], 4, '.', '')}}</td>
                <td>{{$item['FecDocumento']}}</td>
                <td>{{$item['TipoDocumento']}}</td>
                <td>{{$item['NroDocumento']}}</td>
                <td>{{$item['diasTranscurridos']}}</td>
                <td>{{$item['SIM_MONEDA']}}</td>
                <td>{{$item['JEFE_VENTA']}}</td>
                <td>{{$item['TIPO_CONTRATO']}}</td>
                <td>{{number_format($item['CAN_CAPITAL_SALDO'] + $item['CAN_INTERES_SALDO'], 4, '.', '')}}</td>
                <td>{{number_format($item['CAN_CAPITAL_SALDO_ME'] + $item['CAN_INTERES_SALDO'], 4, '.', '')}}</td>
            </tr>
            @php
                $total_mn = $total_mn + ($item['CAN_CAPITAL_SALDO'] + $item['CAN_INTERES_SALDO']);
                $total_me = $total_me + ($item['CAN_CAPITAL_SALDO_ME'] + $item['CAN_INTERES_SALDO']);
            @endphp
        @endif
    @endforeach
    </tbody>
    <tfoot>
    <tr style="background: #4285f4; color: white; text-align: center">
        <th class="center footerho" colspan="11">TOTAL</th>
        <th class="center footerho">{{number_format($total_mn, 4, '.', '')}}</th>
        <th class="center footerho">{{number_format($total_me, 4, '.', '')}}</th>
    </tr>
    </tfoot>
</table>
