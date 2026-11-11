<table id="iscomercial"
       class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
       style='width: 100%;'>
    <thead>
    <tr>
        <th class="cabecera" colspan="14">INDUAMERICA COMERCIAL @if($sede <> 'TODOS')
                - {{$sede}}
            @endif</th>
    </tr>
    <tr>
        <th class="cabecera" rowspan="2">CÓDIGO</th>
        <th class="cabecera" rowspan="2">ENVASES</th>
        <th class="cabecera" rowspan="1" colspan="2">STOCK ULTIMO MES</th>
        <th class="cabecera" rowspan="1" colspan="2">INGRESO MES ACTUAL REPORTE</th>
        <th class="cabecera" rowspan="1" colspan="2">STOCK CON EL TOTAL DE LA COMPRAS</th>
        <th class="cabecera" rowspan="1" colspan="2">INGRESOS MENSUAL</th>
        <th class="cabecera" rowspan="1" colspan="2">SALIDAS MENSUAL</th>
        <th class="cabecera" rowspan="1" colspan="2">STOCK ULTIMO DIA DEL MES</th>
    </tr>
    <tr>
        <th class="cabecera" rowspan="1">CANTIDAD</th>
        <th class="cabecera" rowspan="1">SOLES</th>
        <th class="cabecera" rowspan="1">CANTIDAD</th>
        <th class="cabecera" rowspan="1">SOLES</th>
        <th class="cabecera" rowspan="1">CANTIDAD</th>
        <th class="cabecera" rowspan="1">SOLES</th>
        <th class="cabecera" rowspan="1">CANTIDAD</th>
        <th class="cabecera" rowspan="1">SOLES</th>
        <th class="cabecera" rowspan="1">CANTIDAD</th>
        <th class="cabecera" rowspan="1">SOLES</th>
        <th class="cabecera" rowspan="1">CANTIDAD</th>
        <th class="cabecera" rowspan="1">SOLES</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lista_comercial as $index=>$item)
        <tr>
            <td>{{$item['COD_PRODUCTO']}}</td>
            <td>{{$item['NOM_PRODUCTO']}}</td>
            <td>{{number_format($item['STOCK_ANT'], 4, '.', '')}}</td>
            <td>{{number_format($item['COSTO_TOTAL_ANT'], 4, '.', '')}}</td>
            <td>{{number_format($item['STOCK_COMP'], 4, '.', '')}}</td>
            <td>{{number_format($item['COSTO_TOTAL_COMP'], 4, '.', '')}}</td>
            <td>{{number_format($item['STOCK_FECHA'], 4, '.', '')}}</td>
            <td>{{number_format($item['COSTO_FECHA'], 4, '.', '')}}</td>
            <td>{{number_format($item['STOCK_ING'], 4, '.', '')}}</td>
            <td>{{number_format($item['COSTO_TOTAL_ING'], 4, '.', '')}}</td>
            <td>{{number_format($item['STOCK_SAL'], 4, '.', '')}}</td>
            <td>{{number_format($item['COSTO_TOTAL_SAL'], 4, '.', '')}}</td>
            <td>{{number_format($item['STOCK_ULTIMA_FECHA'], 4, '.', '')}}</td>
            <td>{{number_format($item['COSTO_ULTIMA_FECHA'], 4, '.', '')}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr class="pie">
        <th colspan="2">TOTAL</th>
        <th style="text-align: right">{{number_format($stock_anterior_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($total_anterior_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($stock_compras_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($total_compras_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($stock_anterior_compras_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($total_anterior_compras_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($stock_ingresos_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($total_ingresos_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($stock_salidas_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($total_salidas_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($stock_ultima_fecha_comercial, 4, '.', '')}}</th>
        <th style="text-align: right">{{number_format($total_ultima_fecha_comercial, 4, '.', '')}}</th>
    </tr>
    </tfoot>
</table>
