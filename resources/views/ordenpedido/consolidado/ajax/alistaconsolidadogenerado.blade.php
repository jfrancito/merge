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
