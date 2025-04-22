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
            <th class="center tablaho" colspan="{{count($centros_internacional) + 5}}">INDUAMERICA INTERNACIONAL</th>
        </tr>
        <tr>
            <th class="center tablaho">CÓDIGO</th>
            <th class="center tablaho">ENVASES</th>

            @foreach($centros_internacional as $centro)
                <th class="center tablaho">{{'CANT. '.$centro['NOM_CENTRO']}}</th>
            @endforeach

            <th class="center tablaho">PRECIO UNITARIO</th>
            <th class="center tablaho">MONTO</th>
            <th class="center tablaho">% PORCENTAJE</th>
        </tr>
        </thead>
        <tbody>
        @foreach($compras_internacional as $index=>$item)
            <tr>
                <td>{{$item['COD_PRODUCTO']}}</td>
                <td>{{$item['NOM_PRODUCTO']}}</td>

                @foreach($centros_internacional as $centro1)
                    <td style="text-align: right">{{number_format($item[$centro1['COD_CENTRO']], 2, '.', '')}}</td>
                @endforeach

                <td style="text-align: right">{{number_format($item['PRE_CON_IGV'], 2, '.', '')}}</td>
                <td style="text-align: right">{{number_format($item['TOTAL'], 2, '.', '')}}</td>

                <td style="text-align: right">{{number_format((($item['TOTAL'] * 100 ) / $total_internacional), 2, '.', '')}}</td>

            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th class="center footerho" colspan="2">TOTAL</th>

            @foreach($centros_internacional as $centro2)
                <th class="footerho" style="text-align: right">{{number_format($centro2['MONTO'], 2, '.', '')}}</th>
            @endforeach

            <th class="center footerho" ></th>
            <th class="footerho" style="text-align: right">{{number_format($total_internacional, 2, '.', '')}}</th>
            <th class="footerho" style="text-align: right">{{number_format($total_porcentaje_internacional, 2, '.', '')}}</th>
        </tr>
        </tfoot>
    </table>

</html>
