<div class="table-responsive">
    <table 
        class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
        cellspacing="0" width="100%">
        
        <thead class="background-th-azul">
            <tr>
                <th>ID CONSOLIDADO</th>
                <th>EMPRESA</th>
                <th>FEC PEDIDO</th>
                <th>MES</th>
                <th>FAMILIA</th>
                <th>ESTADO</th>
            </tr>
        </thead>

        <tbody>
        @foreach($listaordenconsolidado as $consolidado)

            @php 
                $cabecera = $consolidado->first(); 
                // Obtener familias únicas para este consolidado
                $familias_unicas = $consolidado->unique('COD_CATEGORIA_FAMILIA')->map(function($item) {
                    return [
                        'id' => $item->COD_CATEGORIA_FAMILIA,
                        'nombre' => $item->NOM_CATEGORIA_FAMILIA
                    ];
                })->values();
            @endphp

            <tr class="fila-consolidado-generado"
                data-consolidado="{{ $cabecera->ID_PEDIDO_CONSOLIDADO }}"
                data-familias="{{ json_encode($familias_unicas) }}"
                style="cursor: pointer;">
                <td>{{ $cabecera->ID_PEDIDO_CONSOLIDADO }}</td>
                <td>{{ $cabecera->NOM_EMPR }}</td>
                <td>{{ $cabecera->FEC_PEDIDO }}</td>
                <td>{{ $cabecera->TXT_NOMBRE }}</td>
                <td>{{ $cabecera->NOM_CATEGORIA_FAMILIA }}</td>
                <td>{{ $cabecera->TXT_ESTADO }}</td>
            </tr>
        @endforeach
        </tbody>

    </table>



    <div id="lista-detalle-consolidado-container">
        <!-- AQUÍ SE CARGARÁ EL DETALLE POR AJAX -->
    </div>
</div>
