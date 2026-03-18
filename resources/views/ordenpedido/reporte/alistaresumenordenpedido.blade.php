{{-- Scripts redundantes eliminados para evitar conflictos con jQuery --}}

<style>
    .fila-seleccionada td {
        background-color: #cce5ff !important;
    }
    .fila-aprobada {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .fila-aprobada:hover td {
        background-color: #e2e6ea !important;
    }
    input.radio-seleccion {
        cursor: pointer;
        transform: scale(1.5);
    }
</style>

<div style="margin-bottom: 15px; display: none; padding: 10px; background-color: #f8f9fa; border-left: 4px solid #6deb0670; border-radius: 4px;" id="contenedorBotonTerminar">
    <span style="font-size: 14px; font-weight: bold; margin-right: 15px;" id="textoPedidoSeleccionado"></span>
    <button id="btnTerminarPedido" class="btn btn-success btn-sm" style="font-weight: bold;">
        <i class="icon mdi mdi-check-circle"></i> TERMINAR PEDIDO
    </button>
</div>

<input type="hidden" id="pedidoSeleccionadoParaTerminar" value="">

<div style="overflow-x: auto;"> <!-- Contenedor para scroll horizontal -->
<table id="tablaReporteOrdenResumen" class="table table-striped table-borderless" style="font-style: italic; min-width: 1200px;">
    <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th style="width: 50px; text-align: center;">SEL</th>
            <th>ID PEDIDO</th>
            <th>ESTADO</th>
            <th>FEC PEDIDO</th>
            <th>AREA</th>
            <th>FAMILIA</th>
            <th>GLOSA</th>
            <th>SOLICITA</th>
            <th>AUTORIZA</th>
            <th>APRUEBA ADM</th>
            <th style="text-align: center;">DETALLE</th>
        </tr>
    </thead>

    <tbody>
        @foreach($listaordenpedido as $item)
        @php
            $estado = strtoupper(trim($item->TXT_ESTADO));
            $es_aprobado_real = ($estado == 'APROBADO' && (is_null($item->TXT_ESTADO_TEMP) || trim($item->TXT_ESTADO_TEMP) == ''));

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
        
        <tr class="{{ $es_aprobado_real ? 'fila-aprobada' : '' }}" data-id="{{ $item->ID_PEDIDO }}" data-estado="{{ empty($item->TXT_ESTADO_TEMP) ? $item->TXT_ESTADO : $item->TXT_ESTADO_TEMP }}">
            <td style="text-align: center; vertical-align: middle;">
                @if($es_aprobado_real)
                    <input type="radio" name="radio_pedido" class="radio-seleccion" value="{{ $item->ID_PEDIDO }}">
                @endif
            </td>
            <td>{{ $item->ID_PEDIDO }}</td>
            <td>
                @if(isset($item->TXT_ESTADO_TEMP) && $item->TXT_ESTADO_TEMP != '')
                    <span class="badge badge-success">{{ $item->TXT_ESTADO_TEMP }}</span>
                @else
                   <span class="badge {{ $clase }}">
                    {{ $item->TXT_ESTADO }}
                </span>
                @endif
            </td>
            <td>{{ $item->FEC_PEDIDO }}</td>
            <td>{{ $item->TXT_AREA }}</td>
            <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            <td>{{ $item->TXT_GLOSA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_SOLICITA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_AUTORIZA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_APRUEBA_ADM }}</td>
            <td style="text-align: center;">
                <button class="btn btn-sm btn-primary ver-detalle-pedido-res" 
                        data-id="{{ $item->ID_PEDIDO }}">
                    <i class="fa fa-eye me-1"></i> Detalle
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>



<script>
$(document).ready(function () {
    var tablaResumen = $('#tablaReporteOrdenResumen').DataTable({
        pageLength: 10,
        order: [[1, 'desc']], // Ordenar por ID PEDIDO, ignorando la columna del radio
        scrollX: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });

    // Evento de seleccion de fila
    $('#tablaReporteOrdenResumen tbody').on('click', 'tr.fila-aprobada', function (e) {
        var tr = $(this);
        var idPedido = tr.data('id');
        var radio = tr.find('.radio-seleccion');

        // Desmarcar todas y marcar solo esta
        $('#tablaReporteOrdenResumen tbody tr').removeClass('fila-seleccionada');
        $('.radio-seleccion').prop('checked', false);

        tr.addClass('fila-seleccionada');
        radio.prop('checked', true);
        
        $('#pedidoSeleccionadoParaTerminar').val(idPedido);
        $('#textoPedidoSeleccionado').text('Pedido Seleccionado: ' + idPedido);
        $('#contenedorBotonTerminar').fadeIn();
    });
});
</script>
