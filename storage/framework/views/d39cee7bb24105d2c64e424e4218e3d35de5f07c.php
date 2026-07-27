<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('comprobante.ajax.alistaocvalidado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php if($operacion_id == 'ORDEN_COMPRA_ANTICIPO'): ?>
    <?php echo $__env->make('comprobante.ajax.alistaocvalidadoestibaoca', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>

      <?php if($operacion_id == 'CONTRATO'): ?>
        <?php echo $__env->make('comprobante.ajax.alistaocvalidadocontrato', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php else: ?>
        <?php if($operacion_id == 'COMISION'): ?>
          <?php echo $__env->make('comprobante.ajax.alistaocvalidadocomision', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php else: ?>
          <?php if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO'): ?>
            <?php echo $__env->make('comprobante.ajax.alistaocvalidadoliquidacioncompraanticipo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php else: ?>
            <?php if($operacion_id == 'NOTA_CREDITO'): ?>
              <?php echo $__env->make('comprobante.ajax.alistaocvalidadonotacredito', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php else: ?>
              <?php if($operacion_id == 'NOTA_DEBITO'): ?>
                <?php echo $__env->make('comprobante.ajax.alistaocvalidadonotadebito', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php else: ?>
                <?php if($operacion_id == 'PROVISION_GASTO'): ?>
                  <?php echo $__env->make('comprobante.ajax.alistaocvalidadopg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php else: ?>

                  <?php if($operacion_id == 'DOCUMENTO_INTERNO_COMPRA'): ?>
                    <?php echo $__env->make('comprobante.ajax.alistaocvalidadoestibadic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <?php else: ?>
                    <?php echo $__env->make('comprobante.ajax.alistaocvalidadoestiba', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <?php endif; ?>

                <?php endif; ?>
              <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
  <?php endif; ?>

<?php endif; ?>