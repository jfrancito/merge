<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.notacredito.comparar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
      <?php echo $__env->make('comprobante.form.notacredito.consultaapi', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      

  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.notacredito.seguimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div> 
</div>
<div class="row">

  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.notacredito.archivos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    <?php echo $__env->make('comprobante.form.notacredito.informacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>



<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php echo $__env->make('comprobante.form.ordencompra.verarchivopdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.notacredito.archivosobservados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>