<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @php
        $total_mn = 0.0000;
        $total_me = 0.0000;
        $total_interes = 0.0000;
        $total_saldo = 0.0000;
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

        .resumen-header {
            background: #28a745;
            color: #fff;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000000;
        }

        .resumen-total {
            background: #ffc107;
            font-weight: bold;
            border: 1px solid #000000;
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
            <th class="center tablaho">DIAS TRANSCURRIDOS</th>
            <th class="center tablaho">MONEDA</th>
            <th class="center tablaho">JEFE VENTA</th>
            <th class="center tablaho">TIPO CONTRATO</th>
            <th class="center tablaho">IMPORTE ORIGINAL</th>
            <th class="center tablaho">SALDO S/.</th>
            <th class="center tablaho">SALDO $</th>
            <th class="center tablaho">INTERESES</th>
            <th class="center tablaho">TOTAL SALDO</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cuentas as $index=>$item)
            @php
                $esCreditoEspecial = in_array($item['TIPO_CONTRATO'] ?? '', ['CREDITO AGRARIO', 'CREDITO FERTILIZANTES']);
                $esCentroBellavista = ($item['Centro'] ?? '') === 'BELLAVISTA';
            @endphp

            @if($item['IND_REL'] === 'T' && $item['IND_CP'] === 'C' && $esCreditoEspecial && $esCentroBellavista)
                @php
                    $esMN = ($item['COD_MONEDA'] ?? '') === 'MON0000000000001';
                    $esME = ($item['COD_MONEDA'] ?? '') === 'MON0000000000002';

                    $capital = $esMN ? ($item['CAN_CAPITAL_SALDO'] ?? 0) : ($item['CAN_CAPITAL_SALDO_ME'] ?? 0);
                    $interes = $item['CAN_INTERES_SALDO'] ?? 0;
                    $importeOriginal = $item['TOT_DOC'] ?? 0;

                    $saldoMN = $esMN ? $capital : 0;
                    $saldoME = $esME ? $capital : 0;
                    $totalFila = $capital + $interes;

                    // Formatear número de contrato
                    $nroContrato = $item['NRO_CONTRATO'] ?? '';
                    $contratoFormateado = substr($nroContrato,0,6).'-'.strval(intval(substr($nroContrato,6,16)));

                    // Clave única para el resumen (CONTRATO + TITULAR + TIPO CONTRATO)
                    $claveResumen = $contratoFormateado . '|' . ($item['NOM_CLIENTE'] ?? '') . '|' . ($item['TIPO_CONTRATO'] ?? '');

                    // Acumular en el array de resumen
                    if (!isset($resumen_contratos[$claveResumen])) {
                        $resumen_contratos[$claveResumen] = [
                            'contrato' => $contratoFormateado,
                            'titular' => $item['NOM_CLIENTE'] ?? '',
                            'tipo_contrato' => $item['TIPO_CONTRATO'] ?? '',
                            'importe_original' => 0,
                            'saldo_mn' => 0,
                            'saldo_me' => 0,
                            'intereses' => 0,
                            'total_saldo' => 0,
                        ];
                    }

                    $resumen_contratos[$claveResumen]['importe_original'] += $importeOriginal;
                    $resumen_contratos[$claveResumen]['saldo_mn'] += $saldoMN;
                    $resumen_contratos[$claveResumen]['saldo_me'] += $saldoME;
                    $resumen_contratos[$claveResumen]['intereses'] += $interes;
                    $resumen_contratos[$claveResumen]['total_saldo'] += $totalFila;
                @endphp
                <tr>
                    <td class="border"> {{$item['NOM_CLIENTE']}}</td>
                    <td class="border">{{$contratoFormateado}}</td>
                    <td class="border">{{$item['Centro']}}</td>
                    <td class="border">{{number_format($item['Tcambio'], 2, '.', '')}}</td>
                    {{--<td class="border">{{$item["FecDocumento_Emis"]}}</td>--}}
                    <td class="border">{{\PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new \DateTime($item["FecDocumento"]))}}</td>
                    <td class="border">{{$item['TipoDocumento']}}</td>
                    <td class="border">{{$item['NroDocumento']}}</td>
                    <td class="border">{{$item['diasTranscurridos']}}</td>
                    <td class="border">{{$item['SIM_MONEDA']}}</td>
                    <td class="border">{{$item['JEFE_VENTA']}}</td>
                    <td class="border">{{$item['TIPO_CONTRATO']}}</td>
                    <td class="border">{{number_format($item['TOT_DOC'], 2, '.', '')}}</td>
                    <td class="border">{{ $item['COD_MONEDA'] === 'MON0000000000001' ? number_format($item['CAN_CAPITAL_SALDO'], 2, '.', '') : 0.00 }}</td>
                    <td class="border">{{ $item['COD_MONEDA'] === 'MON0000000000002' ? number_format($item['CAN_CAPITAL_SALDO_ME'], 2, '.', ''): 0.00 }}</td>
                    <td class="border">{{ number_format($item['CAN_INTERES_SALDO'], 2, '.', '') }}</td>
                    <td class="border">{{ $item['COD_MONEDA'] === 'MON0000000000001' ? number_format($item['CAN_CAPITAL_SALDO'] + $item['CAN_INTERES_SALDO'], 2, '.', '') : number_format($item['CAN_CAPITAL_SALDO_ME'] + $item['CAN_INTERES_SALDO'], 2, '.', '') }}</td>
                @php
                    $total_mn = $total_mn + ($item['COD_MONEDA'] === 'MON0000000000001' ? $item['CAN_CAPITAL_SALDO'] : 0.00);
                    $total_me = $total_me + ($item['COD_MONEDA'] === 'MON0000000000002' ? $item['CAN_CAPITAL_SALDO_ME'] : 0.00);
                    $total_interes = $total_interes + $item['CAN_INTERES_SALDO'];
                    $total_saldo = $total_saldo + ($item['COD_MONEDA'] === 'MON0000000000001' ? ($item['CAN_CAPITAL_SALDO'] + $item['CAN_INTERES_SALDO']) : ($item['CAN_CAPITAL_SALDO_ME'] + $item['CAN_INTERES_SALDO']));
                @endphp
            @endif
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th class="center footerho" colspan="12">Total</th>
            <th class="footerho">{{number_format($total_mn, 2, '.', '')}}</th>
            <th class="footerho">{{number_format($total_me, 2, '.', '')}}</th>
            <th class="footerho">{{number_format($total_interes, 2, '.', '')}}</th>
            <th class="footerho">{{number_format($total_saldo, 2, '.', '')}}</th>
        </tr>
        </tfoot>
    </table>
    <!-- TABLA DE RESUMEN POR CONTRATO -->
    @if(!empty($resumen_contratos))
        @php
            $total_resumen_importe = 0;
            $total_resumen_mn = 0;
            $total_resumen_me = 0;
            $total_resumen_interes = 0;
            $total_resumen_saldo = 0;
        @endphp

        <table>
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="center resumen-header" colspan="8">RESUMEN POR CONTRATO - TITULAR - TIPO CONTRATO</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="center resumen-header">CONTRATO</th>
                <th class="center resumen-header">TITULAR</th>
                <th class="center resumen-header">TIPO CONTRATO</th>
                <th class="center resumen-header">IMPORTE ORIGINAL</th>
                <th class="center resumen-header">SALDO S/.</th>
                <th class="center resumen-header">SALDO $</th>
                <th class="center resumen-header">INTERESES</th>
                <th class="center resumen-header">TOTAL SALDO</th>
            </tr>
            </thead>
            <tbody>
            @foreach($resumen_contratos as $resumen)
                @php
                    $total_resumen_importe += $resumen['importe_original'];
                    $total_resumen_mn += $resumen['saldo_mn'];
                    $total_resumen_me += $resumen['saldo_me'];
                    $total_resumen_interes += $resumen['intereses'];
                    $total_resumen_saldo += $resumen['total_saldo'];
                @endphp

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="border">{{ $resumen['contrato'] }}</td>
                    <td class="border">{{ $resumen['titular'] }}</td>
                    <td class="border">{{ $resumen['tipo_contrato'] }}</td>
                    <td class="border" style="text-align: right;">{{ number_format($resumen['importe_original'], 2, '.', '') }}</td>
                    <td class="border" style="text-align: right;">{{ number_format($resumen['saldo_mn'], 2, '.', '') }}</td>
                    <td class="border" style="text-align: right;">{{ number_format($resumen['saldo_me'], 2, '.', '') }}</td>
                    <td class="border" style="text-align: right;">{{ number_format($resumen['intereses'], 2, '.', '') }}</td>
                    <td class="border" style="text-align: right;">{{ number_format($resumen['total_saldo'], 2, '.', '') }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="center resumen-total" colspan="3">TOTALES</th>
                <th class="resumen-total" style="text-align: right;">{{ number_format($total_resumen_importe, 2, '.', '') }}</th>
                <th class="resumen-total" style="text-align: right;">{{ number_format($total_resumen_mn, 2, '.', '') }}</th>
                <th class="resumen-total" style="text-align: right;">{{ number_format($total_resumen_me, 2, '.', '') }}</th>
                <th class="resumen-total" style="text-align: right;">{{ number_format($total_resumen_interes, 2, '.', '') }}</th>
                <th class="resumen-total" style="text-align: right;">{{ number_format($total_resumen_saldo, 2, '.', '') }}</th>
            </tr>
            </tfoot>
        </table>
    @endif
</html>
