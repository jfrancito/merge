<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('comprobante.ajax.alistausuariocontacto', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php echo $__env->make('comprobante.ajax.alistausuariocontactocontrato', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>