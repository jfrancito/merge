<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/file/fileinput.css')); ?> "/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>

<div class="be-content">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">Comprobante Reparable<span class="panel-subtitle">Comprobante Reparable Administracion</span></div>
          <div class="panel-body">
            <form method="POST" id='formpedido' action="<?php echo e(url('/reparable-comprobante-uc-admin/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10)))); ?>" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
                  <?php echo e(csrf_field()); ?>

              <?php echo $__env->make('comprobante.form.formmitigarreparableadmin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
    <script src="<?php echo e(asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js')); ?>" type="text/javascript"></script>

    <script src="<?php echo e(asset('public/js/file/fileinput.js?v='.$version)); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/file/locales/es.js')); ?>" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();
      });
    </script> 
    <script type="text/javascript">

      <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
         $('#file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>').fileinput({
            theme: 'fa5',
            language: 'es',
            allowedFileExtensions: ['<?php echo e($item->TXT_FORMATO); ?>'],
          });
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      <?php $__currentLoopData = $archivospdf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        var nombre_archivo = '<?php echo e($item->NOMBRE_ARCHIVO); ?>';
        $('#file-'+<?php echo e($index); ?>).fileinput({
          theme: 'fa5',
          language: 'es',
          initialPreview: ["<?php echo e(route('serve-file', ['file' => ''])); ?>" + nombre_archivo],
          initialPreviewAsData: true,
          initialPreviewFileType: 'pdf',
          initialPreviewConfig: [
              {type: "pdf", caption: nombre_archivo, downloadUrl: "<?php echo e(route('serve-file', ['file' => ''])); ?>" + nombre_archivo} // Para mostrar el botón de descarga
          ]
        });
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      
      
      $('#file-otros').fileinput({
        theme: 'fa5',
        language: 'es',
      });


    </script>


  <script src="<?php echo e(asset('public/js/comprobante/uc.js?v='.$version)); ?>" type="text/javascript"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>