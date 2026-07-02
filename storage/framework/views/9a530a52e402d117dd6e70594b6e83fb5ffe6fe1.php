<?php if($operacion_id == 'ORDEN_COMPRA'): ?>
  <?php echo $__env->make('comprobante.ajax.alistaadministracion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php if($operacion_id == 'ORDEN_COMPRA_ANTICIPO'): ?>
    <?php echo $__env->make('comprobante.ajax.alistaadministracionoca', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>

  <?php if($operacion_id == 'CONTRATO_ANTICIPO'): ?>
    <?php echo $__env->make('comprobante.ajax.alistaadministracioncontratoa', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>

        <?php if($operacion_id == 'CONTRATO'): ?>
          <?php echo $__env->make('comprobante.ajax.alistacontratoareaadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php else: ?>
          <?php if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO'): ?>
            <?php echo $__env->make('comprobante.ajax.alistaliquidacioncompraanticipoareaadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php else: ?>
            <?php if($operacion_id == 'NOTA_CREDITO'): ?>
              <?php echo $__env->make('comprobante.ajax.alistanotacreditoareaadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php else: ?>
              <?php if($operacion_id == 'NOTA_DEBITO'): ?>
                <?php echo $__env->make('comprobante.ajax.alistanotadebitoareaadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php else: ?>

                <?php if($operacion_id == 'PROVISION_GASTO'): ?>
                  <?php echo $__env->make('comprobante.ajax.alistapgareaadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php else: ?>
                  <?php if($operacion_id == 'DOCUMENTO_INTERNO_COMPRA'): ?>
                    <?php echo $__env->make('comprobante.ajax.alistaestibaareaadministradordic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <?php else: ?>
                    <?php echo $__env->make('comprobante.ajax.alistaestibaareaadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
  <?php endif; ?>
  <?php endif; ?>

<?php endif; ?>