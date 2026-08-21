<table id="tabla-orden-compras" class="table table-striped table-hover table-fw-widget listatabla">
    <thead>
        <tr>
            <th>Código Orden</th>
            <th>Empresa Cliente</th>
            <th>Centro (Sede)</th>
            <th>Fecha Orden</th>
            <th>Tipo Compra</th>
            <th>Total</th>
            <th>Glosa</th>
            <th>Estado</th>
            <th class="text-center" style="width: 100px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listaordenes as $item)
            @php
                // Formateamos los badges de estado
                $estado = trim($item->TXT_CATEGORIA_ESTADO_ORDEN);
                $badge_class = 'badge-default';
                $badge_style = 'font-weight: bold; font-size: 10px; padding: 4px 8px; border-radius: 12px;';
                if ($estado === 'APROBADO' || $estado === 'APROBADA') {
                    $badge_class = 'badge-warning';
                    $badge_style = 'font-weight: bold; font-size: 11px; padding: 5px 12px; border-radius: 12px; margin-right: 15px; background-color: #f0ad4e; color: #ffffff;';
                } elseif ($estado === 'RECHAZADO' || $estado === 'RECHAZADA' || $estado === 'ANULADA') {
                    $badge_class = 'badge-danger';
                } elseif ($estado === 'GENERADA' || $estado === 'GENERADO' || $estado === 'EMITIDA') {
                    $badge_class = '';
                    $badge_style .= ' color: #000000; background-color: rgba(226, 232, 240, 0.7); border: 1px solid #cbd5e1;';
                } elseif ($estado === 'TERMINADA' || $estado === 'TERMINADO') {
                    $badge_class = 'badge-primary';
                }

                // Tipo de Compra
                $tipo = trim($item->IND_MATERIAL_SERVICIO);
                $tipo_label = ($tipo === 'M') ? 'MATERIAL' : (($tipo === 'S') ? 'SERVICIO' : 'OTRO');

                // Centro/Sede
                $centro_nombre = $item->NOM_CENTRO ? trim($item->NOM_CENTRO) : trim($item->COD_CENTRO);
            @endphp
            <tr data-codorden="{{ $item->COD_ORDEN }}">
                <td><b>{{ $item->COD_ORDEN }}</b></td>
                <td>{{ $item->TXT_EMPR_CLIENTE }}</td>
                <td>
                    <span style="font-weight: 500; color: #334155;">
                        {{ $centro_nombre }}
                    </span>
                </td>
                <td>{{ date('d-m-Y', strtotime($item->FEC_ORDEN)) }}</td>
                <td>
                    <span style="font-weight: 500; color: #334155;">
                        {{ $tipo_label }}
                    </span>
                </td>
                <td style="font-weight: bold; color: #2c3e50;">
                    {{ $item->TXT_CATEGORIA_MONEDA == 'DOLARES' ? '$' : 'S/.' }} {{ number_format($item->CAN_TOTAL, 2) }}
                </td>
                <td title="{{ $item->TXT_GLOSA }}" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $item->TXT_GLOSA }}
                </td>
                <td>
                    <span class="badge {{ $badge_class }}" style="{{ $badge_style }}">
                        {{ $estado }}
                    </span>
                </td>
                <td class="text-center">
                    <button type="button" 
                            class="btn btn-info btn-xs btn-ver-detalle" 
                            data-codorden="{{ $item->COD_ORDEN }}"
                            style="border-radius: 4px; padding: 4px 10px; font-weight: bold;">
                        <span class="icon mdi mdi-eye"></span> Ver Detalle
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#tabla-orden-compras').DataTable({
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sSearch":         "Buscar:",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            "order": [[ 3, "desc" ]]
        });

        // Al buscar en la tabla, ocultar y limpiar el panel de detalles para evitar confusiones al usuario
        table.on('search.dt', function() {
            if ($("#detalle-orden-compras-container").is(":visible")) {
                $("#detalle-orden-compras-container").slideUp(200).html("");
            }
        });
    });
</script>
