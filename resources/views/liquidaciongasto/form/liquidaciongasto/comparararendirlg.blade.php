<div tabindex="0" class="panel panel-default panel-contrast pnldetallesdocumentos">
    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">COMPARACION DE VALE Y LIQUIDACION
    </div>
    <div class="panel-body panel-body-contrast">
        <table id="tblactivos" class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>VALE</th>
                <th>LIQUIDACION</th>
                <th>MONTO VALE</th>
                <th>MONTO LIQUIDACION</th>
                <th>DIFERENCIA</th>
            </tr>
            </thead>
            <tbody>
            @php
                // Calcular sumas antes del bucle
                $sumaMonto = 0;
                $sumaTotal = 0;
                $sumaRestante = 0;
            @endphp
            
            @foreach($listaarendirlg as $item)
                @php
                    // Acumular las sumas
                    $sumaMonto += $item['monto'];
                    $sumaTotal += $item['TOTAL'];
                    $sumaRestante += $item['restante'];
                @endphp
                <tr>
                    <td>{{ $item['concepto'] }}</td>
                    <td>{{ $item['TXT_PRODUCTO'] }}</td>
                    <td>{{ number_format($item['monto'], 2) }}</td>
                    <td>{{ number_format($item['TOTAL'], 2) }}</td>
                    <td>{{ number_format($item['restante'], 2) }}</td>
                </tr>
            @endforeach
            
            <tr style="font-weight: bold; background-color: #f5f5f5;">
                <td></td>
                <td></td>
                <td><b>{{ number_format($sumaMonto, 2) }}</b></td>
                <td><b>{{ number_format($sumaTotal, 2) }}</b></td>
                <td><b>{{ number_format($sumaRestante, 2) }}</b></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
