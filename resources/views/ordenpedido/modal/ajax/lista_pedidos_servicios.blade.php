<!-- BARRA DE BÚSQUEDA -->
<div class="row" style="margin-bottom: 15px; padding: 0 5px;">
    <div class="col-md-12">
        <div class="input-group shadow-soft" style="border-radius: 25px; overflow: hidden;">
            <span class="input-group-addon" style="background: #1d3a6d; color: #fff; border: none;">
                <i class="mdi mdi-magnify" style="font-size: 20px; vertical-align: middle;"></i>
            </span>
            <input type="text" id="buscar_pedidos_servicios_modal" class="form-control" 
                   placeholder="Escribe para buscar por ID o Solicitante..." 
                   style="border: none; height: 45px; font-weight: 500; font-size: 14px;">
        </div>
    </div>
</div>

<div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
    <table id="table-pedidos-servicios-aprobado" class="table table-striped table-hover table-fw-widget listatabla">
        <thead>
            <tr>
                <th class="text-center" width="50">
                    <div class="xs-check">
                        <input id="check-all-pedidos" type="checkbox">
                        <label for="check-all-pedidos"></label>
                    </div>
                </th>
                <th>ID PEDIDO</th>
                <th>CENTRO</th>
                <th>SOLICITANTE</th>
                <th>FECHA</th>
                <th>GLOSA</th>
                <th>ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lista_pedidos as $item)
            <tr>
                <td class="text-center">
                    <div class="xs-check">
                        <input id="check-ped-{{ $item->ID_PEDIDO }}" 
                               type="checkbox" 
                               name="id_pedido_servicio[]" 
                               class="check-pedido" 
                               value="{{ $item->ID_PEDIDO }}"
                               data-centro="{{ trim($item->NOM_CENTRO) }}">
                        <label for="check-ped-{{ $item->ID_PEDIDO }}"></label>
                    </div>
                </td>
                <td class="font-bold">{{ $item->ID_PEDIDO }}</td>
                <td class="text-primary" style="font-size: 11px; font-weight: 700;">{{ $item->NOM_CENTRO }}</td>
                <td style="font-size: 12px;">{{ $item->TXT_TRABAJADOR_SOLICITA }}</td>
                <td>{{ date('d-m-Y', strtotime($item->FEC_PEDIDO)) }}</td>
                <td style="font-size: 11px; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->TXT_GLOSA }}">
                    {{ $item->TXT_GLOSA }}
                </td>
                <td>
                    <span class="label label-success shadow-soft" style="background:#28a745; font-size: 11px;">
                        <i class="mdi mdi-check-circle" style="margin-right: 3px;"></i> {{ $item->TXT_ESTADO }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        // Seleccionar todos los checkboxes
        $('#check-all-pedidos').on('change', function() {
            $('.check-pedido').prop('checked', $(this).prop('checked'));
        });

        // Filtrar pedidos en tiempo real
        $('#buscar_pedidos_servicios_modal').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $("#table-pedidos-servicios-aprobado tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Al hacer clic en una fila, seleccionar el checkbox (UX mejorada)
        $('#table-pedidos-servicios-aprobado tbody tr').on('click', function(e) {
            if ($(e.target).is('input') || $(e.target).is('label')) return;
            var cb = $(this).find('.check-pedido');
            cb.prop('checked', !cb.prop('checked'));
        });
    });
</script>

<style>
    .xs-check {
        position: relative;
        display: inline-block;
        vertical-align: middle;
        text-align: left;
    }
    .xs-check input { opacity: 0; position: absolute; z-index: -1; }
    .xs-check label { cursor: pointer; display: block; height: 18px; width: 18px; border: 2px solid #ddd; border-radius: 4px; position: relative; }
    .xs-check input:checked + label { background: #1d3a6d; border-color: #1d3a6d; }
    .xs-check input:checked + label:after {
        content: '';
        position: absolute;
        left: 5px;
        top: 1px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
</style>
