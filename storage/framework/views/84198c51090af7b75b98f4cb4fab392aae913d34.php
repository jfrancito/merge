<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('comprobante.ajax.alistaoc_administrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php if($operacion_id == 'ORDEN_COMPRA_ANTICIPO'): ?>
    <?php echo $__env->make('comprobante.ajax.alistaestibaadministradorocan', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>
    <?php if($operacion_id == 'CONTRATO_ANTICIPO'): ?>
      <?php echo $__env->make('comprobante.ajax.alistaestibaadministradorconan', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php else: ?>

        <?php if($operacion_id == 'CONTRATO'): ?>
          <?php echo $__env->make('comprobante.ajax.alistacontratoadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php else: ?>
          <?php if($operacion_id == 'PROVISION_GASTO'): ?>
            <?php echo $__env->make('comprobante.ajax.alistarprovisiongastoadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php else: ?>
              <?php if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO'): ?>
                <?php echo $__env->make('comprobante.ajax.alistaliquidacioncompraanticipoadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php else: ?>
                    <?php if($operacion_id == 'NOTA_CREDITO'): ?>
                      <?php echo $__env->make('comprobante.ajax.alistanotacreditoadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php else: ?>
                        <?php if($operacion_id == 'NOTA_DEBITO'): ?>
                          <?php echo $__env->make('comprobante.ajax.alistanotadebitoadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php else: ?>
                            <?php if($operacion_id == 'DOCUMENTO_INTERNO_COMPRA'): ?>
                              <?php echo $__env->make('comprobante.ajax.alistaestibaadministradordocintcom', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php else: ?>
                              <?php echo $__env->make('comprobante.ajax.alistaestibaadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
              <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>

  <?php endif; ?>
<?php endif; ?>