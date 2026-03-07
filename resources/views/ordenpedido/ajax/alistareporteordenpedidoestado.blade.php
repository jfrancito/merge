<table id="reporteordenpedidoestado"
       class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap "
       cellspacing="0" width="100%">
    <thead class="background-th-azul">
    <tr>
        <th>ID PEDIDO</th>
        <th>AREA</th>
        <th>FECHA PEDIDO</th>
        <th>AÑO</th>
        <th>PERIODO</th>
        <th>CENTRO</th>
        <th>ESTADO</th>
        <th>CONSOLIDADO SEDE</th>
        <th>CONSOLIDADO GENERAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach($resultado as $index => $item)
        <tr>
            <td>{{$item->ID_PEDIDO}}</td>
            <td>{{$item->NOM_AREA}}</td>
            <td class="align-center-tb">{{$item->FEC_PEDIDO}}</td>
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
@if(isset($ajax))
    <script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
    </script>
@endif
