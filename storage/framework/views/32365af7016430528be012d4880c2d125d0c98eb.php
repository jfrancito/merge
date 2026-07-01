<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/file/fileinput.css')); ?> "/>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>
<div class="be-content liquidaciongasto">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">LIQUIDACION DE GASTOS (<?php echo e($liquidaciongastos->ID_DOCUMENTO); ?>)

            <span class="panel-subtitle">Emitir la liquidacion de gastos</span>
            <input type="hidden" name="idopcion" id='idopcion' value='<?php echo e($idopcion); ?>'>
            <div class="tools tooltiptop">
              <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones btncuadrocomparativo" data_id="<?php echo e($liquidaciongastos->ID_DOCUMENTO); ?>" style="width:140px;">
                <span class="tooltiptext">Cuadro Comparativo</span>
                Cuadro Comparativo
              </a>
            </div>
          </div>
          <div class="panel-body">
                <div class='formconsulta'>
                  <?php echo $__env->make('liquidaciongasto.form.faliquidaciongastomodificar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div class='detallemovilidad' style="margin-top:15px;">
                  <?php echo $__env->make('liquidaciongasto.ajax.amdetalleliquidaciongastos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <input type="hidden" name="ID_DOCUMENTO" id="ID_DOCUMENTO" value="<?php echo e($liquidaciongastos->ID_DOCUMENTO); ?>">
                </div>
          </div>
        </div>
      </div>
    </div>
      <?php echo $__env->make('planillamovilidad.modal.mregistrorequerimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>

</div>  
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>


  <script src="<?php echo e(asset('public/lib/datatables/js/jquery.dataTables.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/lib/datatables/js/dataTables.bootstrap.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/lib/datatables/js/dataTables.responsive.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/lib/datatables/js/responsive.bootstrap.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/js/app-tables-datatables.js?v='.$version)); ?>" type="text/javascript"></script>

  <script src="<?php echo e(asset('public/lib/jquery-ui/jquery-ui.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/lib/jquery.nestable/jquery.nestable.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/lib/moment.js/min/moment.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>        
  <script src="<?php echo e(asset('public/lib/select2/js/select2.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/lib/bootstrap-slider/js/bootstrap-slider.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/js/app-form-elements.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/lib/parsley/parsley.js')); ?>" type="text/javascript"></script>

  <!-- <script src="<?php echo e(asset('public/js/file/bootstrap.bundle.min.js')); ?>" crossorigin="anonymous"></script> -->
  <script src="<?php echo e(asset('public/js/file/fileinput.js?v='.$version)); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/js/file/locales/es.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/js/general/general.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js')); ?>" type="text/javascript"></script>

  <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.js')); ?>" type="text/javascript"></script> 
  <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.extensions.js')); ?>" type="text/javascript"></script> 
  <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.numeric.extensions.js')); ?>" type="text/javascript"></script> 
  <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.date.extensions.js')); ?>" type="text/javascript"></script> 
  <script src="<?php echo e(asset('public/js/general/inputmask/jquery.inputmask.js')); ?>" type="text/javascript"></script>


    <script type="text/javascript">


      $.fn.niftyModal('setDefaults',{
        overlaySelector: '.modal-overlay',
        closeSelector: '.modal-close',
        classAddAfterOpen: 'modal-show',
      });

      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();

        $('#empresa_id').select2({
            // Activamos la opcion "Tags" del plugin
            width: '100%',
            placeholder: 'Seleccione una empresa',
            language: "es",
            tags: true,
            tokenSeparators: [','],
            ajax: {
                dataType: 'json',
                url: '<?php echo e(url("buscarempresalg")); ?>',
                delay: 100,
                data: function(params) {
                    return {
                        term: params.term
                    }
                },
                processResults: function (data, page) {
                  return {
                    results: data
                  };

                },
            }
        });

        
        // $('#producto_id_factura').select2({
        //     // Activamos la opcion "Tags" del plugin
        //     width: '100%',
        //     placeholder: 'Seleccione una empresa',
        //     language: "es",
        //     tags: true,
        //     tokenSeparators: [','],
        //     ajax: {
        //         dataType: 'json',
        //         url: '<?php echo e(url("buscarproducto")); ?>',
        //         delay: 100,
        //         data: function(params) {
        //             return {
        //                 term: params.term
        //             }
        //         },
        //         processResults: function (data, page) {
        //           return {
        //             results: data
        //           };

        //         },
        //     }
        // });





        $('form').parsley();
        $('.importe').inputmask({ 'alias': 'numeric', 
        'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
        'digitsOptional': false, 
        'prefix': '', 
        'placeholder': '0'});

        $('.whatsapp').inputmask({ 'alias': 'numeric', 
        'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
        'digitsOptional': false, 
        'prefix': '', 
        'placeholder': '0'});
        
      });
    </script> 


    <script type="text/javascript">
        <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            var extension = '<?php echo e($item->COD_CTBLE); ?>';
            if(extension=='ZIP'){
                extension = 'XML';
            }
            $('#file-<?php echo e($item->COD_CATEGORIA); ?>').fileinput({
              theme: 'fa5',
              language: 'es',
              allowedFileExtensions: [extension],
            });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>


    <script src="<?php echo e(asset('public/js/comprobante/liquidaciongasto.js?v='.$version)); ?>" type="text/javascript"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>