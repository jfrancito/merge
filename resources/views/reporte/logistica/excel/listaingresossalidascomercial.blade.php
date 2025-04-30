<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        .cabecera {
            background: #1d3a6d;
            color: #FFFFFF;
            text-align: center;
            border: 2px solid #000000;
        }

        .pie {
            background: #4285f4;
            color: #FFFFFF;
            text-align: center;
            border: 2px solid #000000;
        }
    </style>
    <table>
        <thead>
        <tr>
            <th class="cabecera" colspan="14">INDUAMERICA COMERCIAL @if($sede <> 'TODOS')
                    - {{$sede}}
                @endif</th>
        </tr>
        <tr>
            <th class="cabecera" rowspan="2">CÓDIGO</th>
            <th class="cabecera" rowspan="2">ENVASES</th>
            <th class="cabecera" colspan="2" rowspan="1">STOCK ULTIMO MES</th>
            <th class="cabecera" colspan="2" rowspan="1">INGRESO MES ACTUAL REPORTE</th>
            <th class="cabecera" colspan="2" rowspan="1">STOCK CON EL TOTAL DE LA COMPRAS</th>
            <th class="cabecera" colspan="2" rowspan="1" >INGRESOS MENSUAL</th>
            <th class="cabecera" colspan="2" rowspan="1" >SALIDAS MENSUAL</th>
            <th class="cabecera" colspan="2" rowspan="1" >STOCK ULTIMO DIA DEL MES</th>
        </tr>
        <tr>
            <th class="cabecera" rowspan="1"></th>
            <th class="cabecera" rowspan="1"></th>
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
        <tr>
            <td class="pie" colspan="2">TOTAL</td>
            <td class="pie">{{number_format($stock_anterior_comercial, 4, '.', '')}}</td>
            <td class="pie">{{number_format($total_anterior_comercial, 4, '.', '')}}</td>
            <td class="pie">{{number_format($stock_compras_comercial, 4, '.', '')}}</td>
            <td class="pie">{{number_format($total_compras_comercial, 4, '.', '')}}</td>
            <td class="pie">{{number_format($stock_anterior_compras_comercial, 4, '.', '')}}</td>
            <td class="pie">{{number_format($total_anterior_compras_comercial, 4, '.', '')}}</td>
            <th class="pie">{{number_format($stock_ingresos_comercial, 4, '.', '')}}</th>
            <th class="pie">{{number_format($total_ingresos_comercial, 4, '.', '')}}</th>
            <th class="pie">{{number_format($stock_salidas_comercial, 4, '.', '')}}</th>
            <th class="pie">{{number_format($total_salidas_comercial, 4, '.', '')}}</th>
            <th class="pie">{{number_format($stock_ultima_fecha_comercial, 4, '.', '')}}</th>
            <th class="pie">{{number_format($total_ultima_fecha_comercial, 4, '.', '')}}</th>
        </tr>
        </tbody>
    </table>
</html>
