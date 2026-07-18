<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('entregadocumento.ajax.alistaocentregable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php if($operacion_id == 'CONTRATO'): ?>
    <?php echo $__env->make('entregadocumento.ajax.alistaocentregablecontrato', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>

      <?php if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO'): ?>
        <?php echo $__env->make('entregadocumento.ajax.alistaocentregablelqa', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php else: ?>

          <?php if($operacion_id=='ORDEN_COMPRA_ANTICIPO' || $operacion_id=='CONTRATO_ANTICIPO'): ?>
            <?php echo $__env->make('entregadocumento.ajax.alistaocentregableestibaanticipo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php else: ?>
            <?php echo $__env->make('entregadocumento.ajax.alistaocentregableestiba', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php endif; ?>


      <?php endif; ?>

    
  <?php endif; ?>
<?php endif; ?>