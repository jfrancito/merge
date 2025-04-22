<table id="cesii" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" style='width: 100%;'>
    <thead style="background: #1d3a6d; color: white; text-align: center">
    <tr>
        <th>CÓDIGO</th>
        <th>ENVASES</th>

        @foreach($centros_internacional as $centro)
            <th>{{'CANT. '.$centro['NOM_CENTRO']}}</th>
        @endforeach

        <th>PRECIO UNITARIO</th>
        <th>MONTO</th>
        <th>% PORCENTAJE</th>
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
    <tr style="background: #4285f4; color: white; text-align: center">
        <th colspan="2">TOTAL</th>

        @foreach($centros_internacional as $centro2)
            <th style="text-align: right">{{number_format($centro2['MONTO'], 2, '.', '')}}</th>
        @endforeach

        <th></th>
        <th style="text-align: right">{{number_format($total_internacional, 2, '.', '')}}</th>
        <th style="text-align: right">{{number_format($total_porcentaje_internacional, 2, '.', '')}}</th>
    </tr>
    </tfoot>
</table>
