<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
    h1{
        text-align: center;
    }
    .subtitulos{
        font-weight: bold;
        font-style: italic;
    }
    .titulotabla{
        background: #4285f4;
        color: #fff;
        font-weight: bold;
    }
    .tabladp{
        background: #bababa;
        color:#fff;
    }
    .negrita{
        font-weight: bold;
    }
    .center{
        text-align: center;
    }
</style>
<table>
    <thead>
    <tr>
        <th class='tabladp'>COD PRODUCTO</th>
        <th class='tabladp'>PRODUCTO</th>
        <th class='tabladp'>UNIDAD MEDIDA</th>
        <th class='tabladp'>CANTIDAD</th>
        <th class='tabladp'>STOCK</th>
        <th class='tabladp'>RESERVADO</th>
        <th class='tabladp'>DIFERENCIA</th>
        <th class='tabladp'>CAN COMPRAR</th>
        <th class='tabladp'>FAMILIA</th>
        <th class='tabladp'>CENTRO</th>
        <th class='tabladp'>AREA</th>
        <th class='tabladp'>OBSERVACION</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listadetalle as $item)
        <tr>
            <td>{{ $item->COD_PRODUCTO }}</td>
            <td>{{ $item->NOM_PRODUCTO }}</td>
            <td>{{ $item->NOM_CATEGORIA_MEDIDA }}</td>
            <td>{{ number_format($item->CANTIDAD, 2) }}</td>
            <td>{{ number_format($item->STOCK, 2) }}</td>
            <td>{{ number_format($item->RESERVADO, 2) }}</td>
            <td>{{ number_format($item->DIFERENCIA, 2) }}</td>
         {{--   <td>
                {{ (isset($item->CAN_COMPRADA_CALCULADA) && !is_null($item->CAN_COMPRADA_CALCULADA)) ? intval($item->CAN_COMPRADA_CALCULADA) : ($item->DIFERENCIA < 0 ? 0 : intval($item->DIFERENCIA)) }}
            </td> --}}
             <td>{{ number_format($item->CAN_COMPRADA_CALCULADA, 2) }} </td>
            <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            <td>{{ $item->NOM_CENTRO }}</td>
            <td>{{ $item->DETALLE_POR_AREA }}</td>
            <td>{{ $item->OBSERVACION_POR_AREA }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</html>

