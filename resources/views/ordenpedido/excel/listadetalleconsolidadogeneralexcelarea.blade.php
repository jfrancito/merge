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
        <th class='tabladp'>CANTIDAD ORIGINAL</th>
        <th class='tabladp'>CANTIDAD APROBADO</th>
        <th class='tabladp'>COMPRA ASIGNADA</th>
        <th class='tabladp'>COMPRA DISPONIBLE</th>
        <th class='tabladp'>FAMILIA</th>
        <th class='tabladp'>CENTRO</th>
        <th class='tabladp'>AREA</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listadetalle as $item)
        <tr>
            <td>{{ $item->COD_PRODUCTO }}</td>
            <td>{{ $item->NOM_PRODUCTO }}</td>
            <td>{{ $item->NOM_CATEGORIA_MEDIDA }}</td>
            <td>{{ number_format($item->CANT_ORIGINAL, 2) }}</td>
            <td>{{ number_format($item->CANT_APROBADA, 2) }}</td>
            <td>{{ number_format($item->CAN_COMPRADA_ASIGNADA, 2) }}</td>
            <td>{{ number_format($item->CAN_COMPRADA_DISPONIBLE, 2) }} </td>
            <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            <td>{{ $item->NOM_CENTRO }}</td>
            <td>{{ $item->NOM_AREA }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</html>
