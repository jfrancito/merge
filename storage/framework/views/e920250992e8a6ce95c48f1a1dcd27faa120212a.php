<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('comprobante.ajax.alistaocreparable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php if($operacion_id == 'CONTRATO'): ?>
    <?php echo $__env->make('comprobante.ajax.alistaocreparablecontrato', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>
    <?php echo $__env->make('comprobante.ajax.alistaocreparableestiba', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php endif; ?>
<?php endif; ?>