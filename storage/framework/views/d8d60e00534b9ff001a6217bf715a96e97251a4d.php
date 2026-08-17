

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
    input.checkbox-seleccion {
        cursor: pointer;
        transform: scale(1.5);
        border-radius: 50%;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 12px;
        height: 12px;
        border: 2px solid #5a5a5a;
        background-color: #fff;
        outline: none;
        display: inline-block;
        position: relative;
        vertical-align: middle;
    }
    input.checkbox-seleccion:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
    input.checkbox-seleccion:checked::after {
        content: '';
        position: absolute;
        width: 4px;
        height: 4px;
        background-color: #fff;
        border-radius: 50%;
        top: 2px;
        left: 2px;
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
            <th style="width: 50px; text-align: center;"><input type="checkbox" id="checkAllPedidos" style="transform: scale(1.5); cursor: pointer;"></th>
            <th>ID PEDIDO</th>
            <th>ESTADO</th>
            <th>FEC PEDIDO</th>
            <th>AREA</th>
            <th>FAMILIA</th>
            <th>GLOSA</th>
            <th>USUARIO SOLICITA</th>
            <th>AUTORIZA JEFE AREA</th>
            <th>APRUEBA GERENCIA AREA</th>
            <th>APRUEBA GER ADM - JEF. COMPRAS</th>
            <th style="text-align: center;">DETALLE</th>
        </tr>
    </thead>

    <tbody>
        <?php $__currentLoopData = $listaordenpedido; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php 
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
         ?>
        
        <tr class="<?php echo e($es_aprobado_real ? 'fila-aprobada' : ''); ?>" data-id="<?php echo e($item->ID_PEDIDO); ?>" data-estado="<?php echo e(empty($item->TXT_ESTADO_TEMP) ? $item->TXT_ESTADO : $item->TXT_ESTADO_TEMP); ?>">
            <td style="text-align: center; vertical-align: middle;">
                <?php if($es_aprobado_real): ?>
                    <input type="checkbox" name="checkbox_pedido" class="checkbox-seleccion" value="<?php echo e($item->ID_PEDIDO); ?>">
                <?php endif; ?>
            </td>
            <td><?php echo e($item->ID_PEDIDO); ?></td>
            <td>
                <?php if(isset($item->TXT_ESTADO_TEMP) && $item->TXT_ESTADO_TEMP != ''): ?>
                    <span class="badge badge-success"><?php echo e($item->TXT_ESTADO_TEMP); ?></span>
                <?php elseif(isset($item->COD_ESTADO) && $item->COD_ESTADO == 'ETM0000000000015' && isset($item->COD_TRABAJADOR_APRUEBA_ADM) && $item->COD_TRABAJADOR_APRUEBA_ADM == 'IITR000000000391'): ?>
                    <span class="badge" style="background-color: #f57c00; color: #fff;">POR APROBAR GERENCIA ADM</span>
                <?php else: ?>
                   <span class="badge <?php echo e($clase); ?>">
                    <?php echo e($item->TXT_ESTADO); ?>

                </span>
                <?php endif; ?>
            </td>
            <td><?php echo e($item->FEC_PEDIDO); ?></td>
            <td><?php echo e($item->TXT_AREA); ?></td>
            <td><?php echo e($item->NOM_CATEGORIA_FAMILIA); ?></td>
            <td><?php echo e($item->TXT_GLOSA); ?></td>
            <td><?php echo e($item->TXT_TRABAJADOR_SOLICITA); ?></td>
            <td><?php echo e($item->TXT_TRABAJADOR_AUTORIZA); ?></td>
            <td><?php echo e($item->TXT_TRABAJADOR_APRUEBA_GER); ?></td>
            <td><?php echo e($item->TXT_TRABAJADOR_APRUEBA_ADM); ?></td>
            <td style="text-align: center;">
                <button class="btn btn-sm ver-detalle-pedido-res btn-detalle-moderno" 
                        data-id="<?php echo e($item->ID_PEDIDO); ?>">
                    <i class="fa fa-eye"></i> Detalle
                </button>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>



<script>
$(document).ready(function () {
    var selectedOrders = new Set();

    var tablaResumen = $('#tablaReporteOrdenResumen').DataTable({
        pageLength: 10,
        order: [[1, 'desc']], // Ordenar por ID PEDIDO, ignorando la columna del radio
        scrollX: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });

    // Evento de seleccion de fila (soporta seleccion unica al hacer click en la fila y multiple al hacer click en el check)
    $('#tablaReporteOrdenResumen tbody').on('click', 'tr.fila-aprobada', function (e) {
        // Evitar seleccion si hacen clic en el boton de Detalle
        if ($(e.target).closest('button').length > 0 || $(e.target).is('button') || $(e.target).is('i')) {
            return;
        }

        var tr = $(this);
        var idPedido = tr.data('id');
        var cb = tr.find('.checkbox-seleccion');

        // Si el click fue en el checkbox o en su celda (primer td)
        if ($(e.target).is('.checkbox-seleccion') || $(e.target).closest('td').index() === 0) {
            // Si hicieron click en la celda y no directamente en el checkbox, invertimos el checkbox
            if (!$(e.target).is('.checkbox-seleccion')) {
                cb.prop('checked', !cb.prop('checked'));
            }
            
            var isChecked = cb.prop('checked');
            if (isChecked) {
                tr.addClass('fila-seleccionada');
                selectedOrders.add(idPedido);
            } else {
                tr.removeClass('fila-seleccionada');
                selectedOrders.delete(idPedido);
            }
            actualizarSeleccion();
            return;
        }

        // En cualquier otra celda, se comporta como seleccion unica
        selectedOrders.clear();
        selectedOrders.add(idPedido);

        // Desmarcar todos y limpiar filas seleccionadas en el DOM actual
        $('#tablaReporteOrdenResumen tbody tr').removeClass('fila-seleccionada');
        $('.checkbox-seleccion').prop('checked', false);

        // Seleccionar esta fila en el DOM
        tr.addClass('fila-seleccionada');
        cb.prop('checked', true);
        
        actualizarSeleccion();
    });

    // Evento para "Seleccionar todos"
    $(document).on('change', '#checkAllPedidos', function (e) {
        var checked = $(this).prop('checked');
        var rows = tablaResumen.rows({ search: 'applied' }).nodes();
        
        $(rows).each(function () {
            var tr = $(this);
            if (tr.hasClass('fila-aprobada')) {
                var idPedido = tr.data('id');
                var cb = tr.find('.checkbox-seleccion');
                cb.prop('checked', checked);
                if (checked) {
                    tr.addClass('fila-seleccionada');
                    selectedOrders.add(idPedido);
                } else {
                    tr.removeClass('fila-seleccionada');
                    selectedOrders.delete(idPedido);
                }
            }
        });
        actualizarSeleccion();
    });

    // Mantener la seleccion visual en cada redibujado de la tabla (por ejemplo al cambiar de pagina)
    tablaResumen.on('draw', function () {
        $('#tablaReporteOrdenResumen tbody tr.fila-aprobada').each(function () {
            var tr = $(this);
            var idPedido = tr.data('id');
            var cb = tr.find('.checkbox-seleccion');
            
            if (selectedOrders.has(idPedido)) {
                tr.addClass('fila-seleccionada');
                cb.prop('checked', true);
            } else {
                tr.removeClass('fila-seleccionada');
                cb.prop('checked', false);
            }
        });
        actualizarEstadoSelectAll();
    });

    function actualizarSeleccion() {
        var selectedIds = Array.from(selectedOrders);

        if (selectedIds.length > 0) {
            $('#pedidoSeleccionadoParaTerminar').val(selectedIds.join(','));
            if (selectedIds.length === 1) {
                $('#textoPedidoSeleccionado').text('Pedido Seleccionado: ' + selectedIds[0]);
            } else {
                $('#textoPedidoSeleccionado').text('Pedidos Seleccionados (' + selectedIds.length + '): ' + selectedIds.join(', '));
            }
            $('#contenedorBotonTerminar').fadeIn();
        } else {
            $('#pedidoSeleccionadoParaTerminar').val('');
            $('#textoPedidoSeleccionado').text('');
            $('#contenedorBotonTerminar').fadeOut();
            $('#checkAllPedidos').prop('checked', false);
        }

        actualizarEstadoSelectAll();
    }

    function actualizarEstadoSelectAll() {
        var rows = tablaResumen.rows({ search: 'applied' }).nodes();
        var allChecked = true;
        var hasAprobadas = false;

        $(rows).each(function () {
            var tr = $(this);
            if (tr.hasClass('fila-aprobada')) {
                hasAprobadas = true;
                var idPedido = tr.data('id');
                if (!selectedOrders.has(idPedido)) {
                    allChecked = false;
                }
            }
        });

        $('#checkAllPedidos').prop('checked', hasAprobadas && allChecked);
    }
});
</script>
