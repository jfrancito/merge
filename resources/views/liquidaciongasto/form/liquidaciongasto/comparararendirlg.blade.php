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
            @foreach($listaarendirlg as $item)
            <tr>
                <td>{{ $item['concepto'] }}</td>
                <td>{{ $item['TXT_PRODUCTO'] }}</td>
                <td>{{ number_format($item['monto'], 2) }}</td>
                <td>{{ number_format($item['TOTAL'], 2) }}</td>
                <td>{{ number_format($item['restante'], 2) }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
