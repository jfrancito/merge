<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('comprobante.ajax.alistacontabilidad', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php if($operacion_id == 'ORDEN_COMPRA_ANTICIPO'): ?>
    <?php echo $__env->make('comprobante.ajax.alistacontabilidadestibaoca', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>
  <?php if($operacion_id == 'CONTRATO_ANTICIPO'): ?>
    <?php echo $__env->make('comprobante.ajax.alistacontabilidadestibacontratoa', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>

    <?php if($operacion_id == 'CONTRATO'): ?>
      <?php echo $__env->make('comprobante.ajax.alistacontabilidadcontrato', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php else: ?>

      <?php if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO'): ?>
        <?php echo $__env->make('comprobante.ajax.alistaliquidacioncompraanticipocontabilidad', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php else: ?>
        <?php if($operacion_id == 'NOTA_CREDITO'): ?>
          <?php echo $__env->make('comprobante.ajax.alistacontabilidadnotacredito', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php else: ?>
          <?php if($operacion_id == 'NOTA_DEBITO'): ?>
            <?php echo $__env->make('comprobante.ajax.alistacontabilidadnotadebito', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php else: ?>

            <?php if($operacion_id == 'PROVISION_GASTO'): ?>
              <?php echo $__env->make('comprobante.ajax.alistacontabilidadpg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php else: ?>
              <?php if($operacion_id == 'DOCUMENTO_INTERNO_COMPRA'): ?>
                <?php echo $__env->make('comprobante.ajax.alistacontabilidadestibadic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php else: ?>

                <?php if($operacion_id == 'COMISION'): ?>
                  <?php echo $__env->make('comprobante.ajax.alistacontabilidadestibacomi', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php else: ?>
                  <?php echo $__env->make('comprobante.ajax.alistacontabilidadestiba', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>


              <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endif; ?>


  <?php endif; ?>



  <?php endif; ?>

<?php endif; ?>