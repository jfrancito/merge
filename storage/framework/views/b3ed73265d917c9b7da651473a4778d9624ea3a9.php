
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-12">
    <?php echo $__env->make('liquidaciongasto.form.liquidaciongasto.comparararendirlg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('liquidaciongasto.form.liquidaciongasto.cabecera', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('liquidaciongasto.form.liquidaciongasto.detalleagru', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('liquidaciongasto.form.liquidaciongasto.valearendir', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('liquidaciongasto.form.liquidaciongasto.seguimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
<div class="col-xs-12">
  <?php echo $__env->make('liquidaciongasto.form.liquidaciongasto.detallevisualizar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php echo $__env->make('liquidaciongasto.form.liquidaciongasto.detallelg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>


<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ACOTACION
      </div>
      <div class="panel-body panel-body-contrast">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="form-group sectioncargarimagen">
                  <label class="col-sm-12 control-label" style="text-align: left;"><b>REALIZAR UNA ACOTACION</b> <br><br></label>
                  <div class="col-sm-12">
                      <textarea 
                      name="descripcion"
                      id = "descripcion"
                      class="form-control input-sm validarmayusculas"
                      rows="12" 
                      cols="200"    
                      data-aw="2"></textarea>
                  </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
