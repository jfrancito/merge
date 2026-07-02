<?php if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO'): ?>
  <?php echo $__env->make('acopio.ajax.alistaliquidacioncompraanticipoareaacopio', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php echo $__env->make('acopio.ajax.alistaestibaareaacopio', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>
