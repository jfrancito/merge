<div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
    <table id="table-consolidado-aprobado" class="table table-striped table-hover table-fw-widget listatabla">
        <thead>
            <tr>
                <th class="text-center" width="50">
                    <div class="xs-check">
                        <input id="check-all-consolidados" type="checkbox">
                        <label for="check-all-consolidados"></label>
                    </div>
                </th>
                <th>ID CONSOLIDADO</th>
                <th>FECHA</th>
                <th>CATEGORÍA FAMILIA</th>
                <th>ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lista_consolidado as $item)
            <tr>
                <td class="text-center">
                    <div class="xs-check">
                        <input id="check-{{ $item->ID_PEDIDO_CONSOLIDADO_GENERAL }}" 
                               type="checkbox" 
                               name="id_pedido_consolidado_general[]" 
                               class="check-consolidado" 
                               value="{{ $item->ID_PEDIDO_CONSOLIDADO_GENERAL }}"
                               data-familia="{{ $item->NOM_CATEGORIA_FAMILIA }}">
                        <label for="check-{{ $item->ID_PEDIDO_CONSOLIDADO_GENERAL }}"></label>
                    </div>
                </td>
                <td class="font-bold">{{ $item->ID_PEDIDO_CONSOLIDADO_GENERAL }}</td>
                <td>{{ date('d-m-Y', strtotime($item->FEC_PEDIDO)) }}</td>
                <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
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
        $('#check-all-consolidados').on('change', function() {
            $('.check-consolidado').prop('checked', $(this).prop('checked'));
        });

        // Al hacer clic en una fila, seleccionar el checkbox (UX mejorada)
        $('#table-consolidado-aprobado tbody tr').on('click', function(e) {
            if ($(e.target).is('input') || $(e.target).is('label')) return;
            var cb = $(this).find('.check-consolidado');
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
        content: '\2714';
        position: absolute;
        top: -1px;
        left: 2px;
        color: white;
        font-size: 12px;
    }
</style>
