<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
          href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/file/fileinput.css')); ?> "/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section'); ?>
    <div class="be-content registrocomprobante hextorno">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default panel-border-color panel-border-color-success">
                        <div class="panel-heading"><?php echo e($titulo); ?>

                        </div>
                        <div class="panel-body">
                            <?php echo $__env->make('comision.lista.detallecomprobanteadministradorcomision', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $__env->make('comision.modal.mregistrorequerimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

    <script src="<?php echo e(asset('public/lib/jquery-ui/jquery-ui.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/jquery.nestable/jquery.nestable.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/moment.js/min/moment.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/select2/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/bootstrap-slider/js/bootstrap-slider.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/app-form-elements.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/parsley/parsley.js')); ?>" type="text/javascript"></script>


    <script src="<?php echo e(asset('public/js/file/fileinput.js?v='.$version)); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/file/locales/es.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/general.js')); ?>" type="text/javascript"></script>




    <script type="text/javascript">

        $.fn.niftyModal('setDefaults', {
            overlaySelector: '.modal-overlay',
            closeSelector: '.modal-close',
            classAddAfterOpen: 'modal-show',
        });


        $(document).ready(function () {

            App.init();
            App.formElements();
            App.dataTables();
            $('[data-toggle="tooltip"]').tooltip();
            $('form').parsley();

            $('.importe').inputmask({
                'alias': 'numeric',
                'groupSeparator': ',', 'autoGroup': true, 'digits': 2,
                'digitsOptional': false,
                'prefix': '',
                'placeholder': '0'
            });

            $('.cuentanumero').on('keypress', function (e) {
                // Permitir solo números (0-9)
                var charCode = e.which ? e.which : e.keyCode;
                if (charCode < 48 || charCode > 57) {
                    e.preventDefault(); // Evita que se inserten caracteres no válidos
                }
            });

            // Opcional: evitar pegar texto que no sea numérico
            $('.cuentanumero').on('paste', function (e) {
                var pasteData = e.originalEvent.clipboardData.getData('text');
                if (!/^\d+$/.test(pasteData)) {
                    e.preventDefault(); // Evita que se peguen caracteres no válidos
                }
            });


        });
    </script>

    <script type="application/json" id="tarchivos-data">
    [
      <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php 
            $categoria_pdfs = isset($archivospdf) ? $archivospdf->where('TIPO_ARCHIVO', $item->COD_CATEGORIA_DOCUMENTO) : collect();
            $initialPreview = [];
            $initialPreviewConfig = [];
            foreach ($categoria_pdfs as $pdf) {
                $nombre_archivo = $pdf->NOMBRE_ARCHIVO;
                $url = route('serve-fileestiba', ['file' => '']) . $nombre_archivo;
                $initialPreview[] = $url;
                $initialPreviewConfig[] = [
                    'type' => 'pdf',
                    'caption' => $nombre_archivo,
                    'downloadUrl' => $url
                ];
            }
         ?>
        {
            "cod_categoria": "<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>",
            "formato": "<?php echo e($item->TXT_FORMATO); ?>",
            "initialPreview": <?php echo json_encode($initialPreview); ?>,
            "initialPreviewConfig": <?php echo json_encode($initialPreviewConfig); ?>

        }<?php if(!$loop->last): ?>,<?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ]
    </script>
    <script src="<?php echo e(asset('public/js/comprobante/registro.js?v='.$version)); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/comprobante/hextorno.js?v='.$version)); ?>" type="text/javascript"></script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>