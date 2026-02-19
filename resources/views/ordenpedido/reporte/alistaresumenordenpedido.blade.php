<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<div style="overflow-x: auto;"> <!-- Contenedor para scroll horizontal -->
<table id="tablaReporteOrdenResumen" class="table table-striped table-borderless" style="font-style: italic; min-width: 1200px;">
    <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th>ID PEDIDO</th>
            <th>ESTADO</th>
            <th>FEC PEDIDO</th>
            <th>AREA</th>
            <th>FAMILIA</th>
            <th>GLOSA</th>
            <th>SOLICITA</th>
            <th>AUTORIZA</th>
            <th>APRUEBA ADM</th>
            
           
        </tr>
    </thead>

    <tbody>
        @foreach($listaordenpedido as $item)
        <tr>
            <td>{{ $item->ID_PEDIDO }}</td>
            <td>{{ $item->TXT_ESTADO }}</td>
            <td>{{ $item->FEC_PEDIDO }}</td>
            <td>{{ $item->TXT_AREA }}</td>
            <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            <td>{{ $item->TXT_GLOSA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_SOLICITA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_AUTORIZA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_APRUEBA_ADM }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<script>
$(document).ready(function () {
    $('#tablaReporteOrdenResumen').DataTable({
        pageLength: 10,
        order: [[0, 'desc']],
        scrollX: true, // Habilita desplazamiento horizontal
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });
});
</script>
