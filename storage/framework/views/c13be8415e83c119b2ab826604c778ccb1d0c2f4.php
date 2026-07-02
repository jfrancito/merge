<?php $__env->startSection('style'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datatables/css/dataTables.bootstrap.min.css')); ?> " />
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datatables/css/responsive.dataTables.min.css')); ?> " />
<link rel="stylesheet" type="text/css"
  href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> " />
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> " />
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> " />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>
<div class="be-content planillamovilidad">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">PLANILLA DE MOVILIDAD (<?php echo e($planillamovilidad->ID_DOCUMENTO); ?>)
            <div class="tools tooltiptop">
              <!-- TUTORIAL-PASO-4: Aquí registraremos cada uno de los desplazamientos y gastos de movilidad realizados -->
              <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones agregardetalle"
                data_planilla_movilidad_id='<?php echo e($planillamovilidad->ID_DOCUMENTO); ?>' style="width:140px;">
                <span class="tooltiptext">Agregar Detalle</span>
                Agregar Detalle
              </a>
            </div>
            <span class="panel-subtitle">Crear un nueva nueva planilla de movilidad</span>
            <input type="hidden" name="idopcion" id='idopcion' value='<?php echo e($idopcion); ?>'>
          </div>
          <div class="panel-body">

            <form method="POST"
              action="<?php echo e(url('/emitir-planilla-movilidad/' . $idopcion . '/' . Hashids::encode(substr($planillamovilidad->ID_DOCUMENTO, -8)))); ?>"
              style="border-radius: 0px;" id='frmpmemitir'>
              <?php echo e(csrf_field()); ?>

              <input type="hidden" name="device_info" id='device_info'>

              <div class='formconsulta'>
                <?php echo $__env->make('planillamovilidad.form.faplanillamovilidad', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
              <div class='detallemovilidad' style="margin-top:15px;">
                <?php echo $__env->make('planillamovilidad.ajax.amdetalleplanillamovilidad', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
              <div class="row xs-pt-15">
                <div class="col-xs-6">
                  <div class="be-checkbox">
                  </div>
                </div>
                <div class="col-xs-6">
                  <p class="text-right">
                    <button type="submit" class="btn btn-space btn-primary btnemitirplanillamovilidad">Emitir Planilla
                      de Movilidad</button>
                  </p>
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

<script src="<?php echo e(asset('public/lib/datatables/js/jquery.dataTables.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/js/dataTables.bootstrap.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js')); ?>"
  type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.print.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js')); ?>"
  type="text/javascript"></script>
<script src="<?php echo e(asset('public/js/app-tables-datatables.js?v=' . $version)); ?>" type="text/javascript"></script>


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