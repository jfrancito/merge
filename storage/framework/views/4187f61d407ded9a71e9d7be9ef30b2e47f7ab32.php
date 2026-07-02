<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('comprobante.ajax.alistatesoreria', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php if($operacion_id == 'CONTRATO'): ?>
    <?php echo $__env->make('comprobante.ajax.alistacontratotesoreria', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>
    <?php echo $__env->make('comprobante.ajax.alistaestibatesoreria', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php endif; ?>
<?php endif; ?>