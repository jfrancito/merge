<?php $__env->startSection('style'); ?>
<link rel="stylesheet" type="text/css"
  href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> " />
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> " />
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> " />
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/confirm/jquery-confirm.min.css')); ?> " />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>
<div class="be-content planillamovilidad">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">PLANILLA DE MOVILIDAD

            <span class="panel-subtitle">Crear un nueva nueva planilla de movilidad</span>
          </div>
          <div class="panel-body">
            <form method="POST" action="<?php echo e(url('/agregar-planilla-movilidad/' . $idopcion)); ?>"
              style="border-radius: 0px;" class="form-horizontal group-border-dashed" id='frmpm'>
              <?php echo e(csrf_field()); ?>

              <input type="hidden" name="device_info" id='device_info'>

              <div class='formconsulta'>
                <!-- TUTORIAL-PASO-2: Complete la información básica de su planilla -->
                <?php echo $__env->make('planillamovilidad.form.faplanillamovilidad', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="row xs-pt-15">
                  <div class="col-xs-6">
                    <div class="be-checkbox">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <p class="text-right">
                      <!-- TUTORIAL-PASO-3: Guardar para generar el número de planilla -->
                      <button type="submit" class="btn btn-space btn-primary btnguardarplanillamovilidad">Crear Nueva
                        Planilla Movilidad</button>
                    </p>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo $__env->make('planillamovilidad.modal.mregistrorequerimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>


<script src="<?php echo e(asset('public/js/general/inputmask/inputmask.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/js/general/inputmask/inputmask.extensions.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/js/general/inputmask/inputmask.numeric.extensions.js')); ?>"
  type="text/javascript"></script>
<script src="<?php echo e(asset('public/js/general/inputmask/inputmask.date.extensions.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/js/general/inputmask/jquery.inputmask.js')); ?>" type="text/javascript"></script>

<script src="<?php echo e(asset('public/lib/jquery-ui/jquery-ui.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/jquery.nestable/jquery.nestable.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/moment.js/min/moment.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>"
  type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/select2/js/select2.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/bootstrap-slider/js/bootstrap-slider.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/js/app-form-elements.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/parsley/parsley.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/js/confirm/jquery-confirm.min.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">


  $.fn.niftyModal('setDefaults', {
    overlaySelector: '.modal-overlay',
    closeSelector: '.modal-close',
    classAddAfterOpen: 'modal-show',
  });

  $(document).ready(function () {
    //initialize the javascript
    App.init();
    App.formElements();
    $('form').parsley();


    $('.importe').inputmask({
      'alias': 'numeric',
      'groupSeparator': ',', 'autoGroup': true, 'digits': 2,
      'digitsOptional': false,
      'prefix': '',
      'placeholder': '0'
    });

  });
</script>

<script src="<?php echo e(asset('public/js/comprobante/planilla.js?v=' . $version)); ?>" type="text/javascript"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>