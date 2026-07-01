<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('entregadocumento.excel.ajax.axlistaocentregable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php if($operacion_id == 'CONTRATO'): ?>
    <?php echo $__env->make('entregadocumento.excel.ajax.axlistaocentregablecontrato', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>

    <?php if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO'): ?>
      <?php echo $__env->make('entregadocumento.excel.ajax.axlistaocentregablelca', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php else: ?>
      <?php echo $__env->make('entregadocumento.excel.ajax.axlistaocentregable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>

  <?php endif; ?>
<?php endif; ?>


