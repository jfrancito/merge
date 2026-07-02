<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.estiba.comparar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <?php if($fedocumento->OPERACION != 'DOCUMENTO_INTERNO_COMPRA'): ?>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <?php echo $__env->make('comprobante.form.contrato.consultaapi', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('comprobante.form.contrato.infodetraccion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
  <?php endif; ?>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.contrato.seguimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div> 
</div>

<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.estiba.archivos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    <?php echo $__env->make('comprobante.form.estiba.informacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>

<?php if($fedocumento->OPERACION != 'DOCUMENTO_INTERNO_COMPRA'): ?>
  <div class="row">
      <?php echo $__env->make('comprobante.form.contrato.pagobanco', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>

  <div class="row">
      <?php echo $__env->make('comprobante.form.contrato.detraccion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php echo $__env->make('comprobante.form.ordencompra.verarchivopdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.estiba.archivosobservados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>