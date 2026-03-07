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
        <th class='tabladp'>ID PEDIDO</th>
        <th class='tabladp'>AREA</th>
        <th class='tabladp'>FECHA PEDIDO</th>
        <th class='tabladp'>AÑO</th>
        <th class='tabladp'>PERIODO</th>
        <th class='tabladp'>CENTRO</th>
        <th class='tabladp'>ESTADO</th>
        <th class='tabladp'>CONSOLIDADO SEDE</th>
        <th class='tabladp'>CONSOLIDADO GENERAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach($resultado as $index => $item)
        <tr>
            <td>{{$item->ID_PEDIDO}}</td>
            <td>{{$item->NOM_AREA}}</td>
            <td>{{$item->FEC_PEDIDO}}</td>
            <td>{{$item->COD_ANIO}}</td>
            <td>{{$item->NOM_PERIODO}}</td>
            <td>{{$item->NOM_CENTRO}}</td>
            <td>{{$item->TXT_ESTADO}}</td>
            <td>{{$item->ID_PEDIDO_CONSOLIDADO}}</td>
            <td>{{$item->ID_PEDIDO_CONSOLIDADO_GENERAL}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</html>

