
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> <?php echo $__env->make('comprobante.form.ordencompra.compararanticiposxml', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <?php endif; ?>    
    <?php if($fedocumento->OPERACION_DET != 'SIN_XML'): ?> <?php echo $__env->make('comprobante.form.ordencompra.compararanticipo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <?php endif; ?> 
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> <?php echo $__env->make('comprobante.form.ordencompra.datosfactura', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <?php endif; ?>    
    <?php if($fedocumento->OPERACION_DET != 'SIN_XML'): ?> <?php echo $__env->make('comprobante.form.ordencompra.sunat', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <?php endif; ?> 
    <?php echo $__env->make('comprobante.form.ordencompra.infodetraccion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('comprobante.form.ordencompra.ordeningreso', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('comprobante.form.ordencompra.ordensalida', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.ordencompra.seguimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div> 
</div>

<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.ordencompra.archivos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    <?php echo $__env->make('comprobante.form.ordencompra.informacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php echo $__env->make('comprobante.form.ordencompra.verarchivopdfmultiple', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>



<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.ordencompra.archivosobservados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>