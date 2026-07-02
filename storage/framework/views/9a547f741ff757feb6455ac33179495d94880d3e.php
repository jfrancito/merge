<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('comprobante.ajax.alistatesoreriapagado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php if($operacion_id == 'CONTRATO'): ?>
    <?php echo $__env->make('comprobante.ajax.alistacontratotesoreriapagado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>
    <?php echo $__env->make('comprobante.ajax.alistacomisiontesoreriapagado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php endif; ?>
<?php endif; ?>