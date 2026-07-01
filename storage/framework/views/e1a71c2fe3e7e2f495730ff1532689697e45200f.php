<?php if(!empty($listaconsolidadopedidoap)): ?>
    <?php echo $__env->make('ordenpedido.consolidadoap.ajax.listaconsolidadopedidoaprueba', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
    <div class="alert alert-info text-center">
        No se encontraron consolidados pendientes para el periodo seleccionado.
    </div>
<?php endif; ?>

<div class="hidden-aprobados-ajax" style="display: none;">
    <?php echo $__env->make('ordenpedido.consolidadoap.ajax.listaconsolidadosaprobados_ajax', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
