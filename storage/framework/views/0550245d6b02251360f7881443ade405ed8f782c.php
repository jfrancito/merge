<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> "/>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>

<div class="be-content">
  <div class="main-content container-fluid">

    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">ROL<span class="panel-subtitle">Modificar Rol : <?php echo e($rol->nombre); ?> <?php echo e($rol->apellido); ?></span></div>
          <div class="panel-body">
            <form method="POST" action="<?php echo e(url('/modificar-rol/'.$idopcion.'/'.Hashids::encode(substr($rol->id, -8)))); ?>" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  <?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>


              <div class="form-group">
                <label class="col-sm-3 control-label">Nombres</label>
                <div class="col-sm-6">

                  <input  type="text"
                          id="nombre" name='nombre' value="<?php echo e(old('nombre', $rol->nombre)); ?>" placeholder="Nombres"
                          required = ""
                          autocomplete="off" class="form-control" data-aw="1"/>

                    <?php echo $__env->make('error.erroresvalidate', [ 'id' => $errors->has('nombre')  , 
                                                        'error' => $errors->first('nombre', ':message') , 
                                                        'data' => '1'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>                          

                </div>
              </div>



              <div class="form-group">
                <label class="col-sm-3 control-label">Activo</label>
                <div class="col-sm-6">
                  <div class="be-radio has-success inline">
                    <input type="radio" value='1' <?php if($rol->activo == 1): ?> checked <?php endif; ?> name="activo" id="rad6">
                    <label for="rad6">Activado</label>
                  </div>
                  <div class="be-radio has-danger inline">
                    <input type="radio" value='0' <?php if($rol->activo == 0): ?> checked <?php endif; ?> name="activo" id="rad8">
                    <label for="rad8">Desactivado</label>
                  </div>
                </div>
              </div>              

              <div class="row xs-pt-15">
                <div class="col-xs-6">
                    <div class="be-checkbox">

                    </div>
                </div>
                <div class="col-xs-6">
                  <p class="text-right">
                    <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                  </p>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>  



<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>



	  <script src="<?php echo e(asset('public/lib/jquery-ui/jquery-ui.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/jquery.nestable/jquery.nestable.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/moment.js/min/moment.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>        
    <script src="<?php echo e(asset('public/lib/select2/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/bootstrap-slider/js/bootstrap-slider.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/app-form-elements.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/parsley/parsley.js')); ?>" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();
      });
    </script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>