<table>
    <thead>
        <tr>
            <th colspan="9" style="text-align: center; font-weight: bold; font-size: 14px;">
                DETALLE CONSOLIDADO GENERAL
            </th>
        </tr>
        <tr>
            <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000;">COD PRODUCTO</th>
            <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000;">PRODUCTO</th>
            <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000;">UNIDAD MEDIDA</th>
            <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000;">CANTIDAD</th>
            <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000;">STOCK</th>
            <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000;">RESERVADO</th>
            <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000;">DIFERENCIA</th>
            <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000;">CAN COMPRAR</th>
            <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000;">FAMILIA</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listadetalle as $item)
            @php
                $can_comprar = (isset($item->CAN_COMPRADA) && !is_null($item->CAN_COMPRADA)) 
                               ? $item->CAN_COMPRADA 
                               : ($item->DIFERENCIA < 0 ? 0 : $item->DIFERENCIA);
            @endphp
            <tr>
                <td style="border: 1px solid #000000;">{{ $item->COD_PRODUCTO }}</td>
                <td style="border: 1px solid #000000;">{{ $item->NOM_PRODUCTO }}</td>
                <td style="border: 1px solid #000000;">{{ $item->NOM_CATEGORIA_MEDIDA }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ number_format($item->CANTIDAD, 2, '.', '') }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ number_format($item->STOCK, 2, '.', '') }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ number_format($item->RESERVADO, 2, '.', '') }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ number_format($item->DIFERENCIA, 2, '.', '') }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ number_format($can_comprar, 2, '.', '') }}</td>
                <td style="border: 1px solid #000000;">{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
