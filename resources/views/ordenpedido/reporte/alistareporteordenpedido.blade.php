<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<div style="overflow-x: auto;"> <!-- Contenedor para scroll horizontal -->
<table id="tablaReporteOrden" class="table table-striped table-borderless" style="font-style: italic; min-width: 1200px;">
    <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th>ID PEDIDO</th>
            <th>FEC PEDIDO</th>
            <th>AÑO</th>
            <th>MES</th>
            <th>EMPRESA</th>
            <th>CENTRO</th>
            <th>AREA</th>
            <th>TIPO PEDIDO</th>
            <th>SOLICITA</th>
            <th>AUTORIZA</th>
            <th>APRUEBA GER</th>
            <th>APRUEBA ADM</th>
            <th>GLOSA</th>
            <th>ESTADO</th>
            <th>USUARIO RECHAZA</th>
            <th>COD PRODUCTO</th>
            <th>PRODUCTO</th>
            <th>CATEGORIA FAMILIA</th>
            <th>CATEGORIA UNIDAD</th>
            <th>CANTIDAD</th>
            <th>OBSERVACION PRODUCTO</th>
        </tr>
    </thead>

    <tbody>
        @foreach($listaordenpedido as $item)

   @php
            $estado = strtoupper(trim($item->TXT_ESTADO));
           

            if($estado == 'GENERADO'){
                $clase = 'badge-default';
            }elseif($estado == 'POR APROBAR AUTORIZACION' || $estado == 'POR APROBAR JEFE DE COMPRAS'){
                $clase = 'badge-warning';
            }elseif($estado == 'POR APROBAR GERENCIA' || $estado == 'APROBADO'){
                $clase = 'badge-info';
            }elseif($estado == 'ANULADO' || $estado == 'RECHAZADO'){
                $clase = 'badge-danger';
            }else{
                $clase = 'badge-default';
            }
        @endphp
        <tr>
            <td>{{ $item->ID_PEDIDO }}</td>
            <td>{{ $item->FEC_PEDIDO }}</td>
            <td>{{ $item->COD_ANIO }}</td>
            <td>{{ $item->TXT_NOMBRE }}</td>
            <td>{{ $item->NOM_EMPR }}</td>
            <td>{{ $item->NOM_CENTRO }}</td>
            <td>{{ $item->TXT_AREA }}</td>
            <td>{{ $item->TXT_TIPO_PEDIDO }}</td>
            <td>{{ $item->TXT_TRABAJADOR_SOLICITA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_AUTORIZA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_APRUEBA_GER }}</td>
            <td>{{ $item->TXT_TRABAJADOR_APRUEBA_ADM }}</td>
            <td>{{ $item->TXT_GLOSA }}</td>
           <td>
                <span class="badge {{ $clase }}">
                    {{ $item->TXT_ESTADO }}
                </span>
            </td>
            <td>
                @if($item->TXT_ESTADO == 'RECHAZADO')
                    {{ $item->USUARIO_MODIF }}
                @endif
            </td>
            <td>{{ $item->COD_PRODUCTO ?? '' }}</td>
            <td>{{ $item->NOM_PRODUCTO }}</td>
            <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            <td>{{ $item->NOM_CATEGORIA }}</td>
            <td>{{ $item->CANTIDAD }}</td>
            <td>{{ $item->TXT_OBSERVACION }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<script>
$(document).ready(function () {
    $('#tablaReporteOrden').DataTable({
        pageLength: 10,
        order: [[0, 'desc']],
        scrollX: true, // Habilita desplazamiento horizontal
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });
});
</script>
