<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.contrato.comparar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
      <?php echo $__env->make('comprobante.form.contrato.consultaapi', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php echo $__env->make('comprobante.form.contrato.infodetraccion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      
    <?php echo $__env->make('comprobante.form.contrato.transferecia', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.contrato.seguimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div> 
</div>
<div class="row">

  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.contrato.archivos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    <?php echo $__env->make('comprobante.form.contrato.informacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php if(count($lista_anticipo_merge)>0): ?>
      <?php echo $__env->make('comprobante.form.ordencompra.anticipomerge', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
    
  </div>
</div>

<div class="row">
    <?php echo $__env->make('comprobante.form.contrato.pagobanco', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<div class="row">
    <?php echo $__env->make('comprobante.form.contrato.detraccion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php echo $__env->make('comprobante.form.ordencompra.verarchivopdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.contrato.archivosobservados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>