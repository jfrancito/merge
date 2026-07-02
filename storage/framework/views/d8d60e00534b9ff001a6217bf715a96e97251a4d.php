

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
                    <input type="radio" name="radio_pedido" class="radio-seleccion" value="<?php echo e($item->ID_PEDIDO); ?>">
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
