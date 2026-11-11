<table class="table table-striped table-bordered table-hover td-color-borde td-padding-7">
    <thead>
        <tr>
            <th colspan="12" style="text-align: center; font-size: 14px; font-weight: bold; background-color: #f1f5f9;">
                DETALLE CONSOLIDADO: {{ $id_consolidado }}
            </th>
        </tr>
        <tr>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>COD PRODUCTO</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>PRODUCTO</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>UNIDAD MEDIDA</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>CANTIDAD</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>STOCK</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>RESERVADO</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>DIFERENCIA</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>CAN COMPRAR</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>FAMILIA</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>CENTRO</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>AREA</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>OBSERVACION</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($listadetalle as $item)
            <tr>
                <td>{{ $item->COD_PRODUCTO }}</td>
                <td>{{ $item->NOM_PRODUCTO }}</td>
                <td>{{ $item->NOM_CATEGORIA_MEDIDA }}</td>
                <td style="text-align: right;">{{ number_format($item->CANTIDAD, 2) }}</td>
                <td style="text-align: right;">{{ number_format($item->STOCK, 2) }}</td>
                <td style="text-align: right;">{{ number_format($item->RESERVADO, 2) }}</td>
                <td style="text-align: right;">{{ number_format($item->DIFERENCIA, 2) }}</td>
                <td style="text-align: right; font-weight: bold;">
                    {{ number_format(!is_null($item->CAN_COMPRADA) ? $item->CAN_COMPRADA : ($item->DIFERENCIA < 0 ? 0 : $item->DIFERENCIA), 2) }}
                </td>
                <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
                <td>{{ $item->TXT_CENTROS }}</td>
                <td>{{ $item->TXT_AREAS }}</td>
                <td>{{ $item->TXT_GLOSAS }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
