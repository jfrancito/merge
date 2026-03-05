<div class="table-responsive">
    <table 
        class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
        cellspacing="0" width="100%">
        
        <thead class="background-th-azul">
            <tr>
                <th>ID CONSOLIDADO GENERAL</th>
                <th>EMPRESA</th>
                <th>FEC CONSO GENERALA</th>
                <th>MES</th>
                <th>FAMILIA</th>
                <th>ESTADO</th>
            </tr>
        </thead>

        <tbody>
       @foreach($listaordenpedidogeneralterminado as $consolidado)

    @php $cabecera = $consolidado->first(); @endphp

    <tr class="fila-consolidado-general-terminado" 
        data-consolidado-general="{{ $cabecera->ID_PEDIDO_CONSOLIDADO_GENERAL }}"
        data-familia-cod = '{{ $cabecera->COD_CATEGORIA_FAMILIA }}'
        style="cursor: pointer;">
        <td>{{ $cabecera->ID_PEDIDO_CONSOLIDADO_GENERAL }}</td>
        <td>{{ $cabecera->NOM_EMPR }}</td>
        <td>{{ $cabecera->FEC_PEDIDO }}</td>
        <td>{{ $cabecera->TXT_NOMBRE }}</td>
        <td>{{ $cabecera->NOM_CATEGORIA_FAMILIA }}</td>
        <td>{{ $cabecera->TXT_ESTADO }}</td>
    </tr>

    @endforeach

        </tbody>

    </table>



    <div id="lista-detalle-consolidado-general-container">
        <!-- AQUÍ SE CARGARÁ EL DETALLE POR AJAX -->
    </div>
</div>
