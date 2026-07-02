<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('comprobante.ajax.alistaocobservados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>

  <?php if($operacion_id == 'ORDEN_COMPRA_ANTICIPO'): ?>
    <?php echo $__env->make('comprobante.ajax.alistaococaobservados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>


      <?php if($operacion_id == 'CONTRATO'): ?>
        <?php echo $__env->make('comprobante.ajax.alistaocobservadoscontrato', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php else: ?>
        <?php if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO'): ?>
          <?php echo $__env->make('comprobante.ajax.alistaocobservadosliquidacioncompraanticipo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php else: ?>
          <?php if($operacion_id == 'NOTA_CREDITO'): ?>
            <?php echo $__env->make('comprobante.ajax.alistaocobservadosnotacredito', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php else: ?>
            <?php if($operacion_id == 'NOTA_DEBITO'): ?>
              <?php echo $__env->make('comprobante.ajax.alistaocobservadosnotadebito', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php else: ?>
              <?php if($operacion_id == 'PROVISION_GASTO'): ?>
                <?php echo $__env->make('comprobante.ajax.alistaocobservadospg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php else: ?>
                <?php echo $__env->make('comprobante.ajax.alistaocobservadosestiba', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
  <?php endif; ?>

<?php endif; ?>