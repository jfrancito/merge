<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" type="text/css"
          href="<?php echo e(asset('public/lib/datatables/css/dataTables.bootstrap.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo e(asset('public/lib/datatables/css/responsive.dataTables.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> "/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        .background-fila-activa {
            background-color: #d9edf7 !important;
            border-left: 4px solid #34aadc;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>

  <!-- ================= CONTENEDOR PRINCIPAL ================= -->
<div class="be-content ordenpedidoprincipal">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <div class="tab-container">

                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#crearconsolidado" data-toggle="tab"><b>CREAR CONSOLIDADO SEDE</b></a></li>
                        <li><a href="#ordenpedidoconsolidado" data-toggle="tab"><b>ORDEN CONSOLIDADO SEDE</b></a></li>
                    </ul>

                    <!-- CONTENIDO TABS -->
                    <div class="tab-content">
                        <div id="crearconsolidado" class="tab-pane fade in active cont">
                            <?php echo $__env->make('ordenpedido.tab.creartabordenconsolidado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>

                        <div id="ordenpedidoconsolidado" class="tab-pane fade cont">
                            <?php echo $__env->make('ordenpedido.consolidado.alistaconsolidadogenerado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div><!-- FIN tab-content -->
                </div><!-- FIN tab-container -->
            </div>
        </div>
    </div>
    <?php echo $__env->make('ordenpedido.modal.modalsolicitud', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('ordenpedido.modal.modal_detalle_producto_consolidado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

    <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.extensions.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.numeric.extensions.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.date.extensions.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/inputmask/jquery.inputmask.js')); ?>" type="text/javascript"></script>

    <script src="<?php echo e(asset('public/lib/datatables/js/jquery.dataTables.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/js/dataTables.bootstrap.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.print.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/app-tables-datatables.js?v='.$version)); ?>" type="text/javascript"></script>


    <script src="<?php echo e(asset('public/lib/jquery-ui/jquery-ui.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/jquery.nestable/jquery.nestable.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/moment.js/min/moment.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/select2/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/bootstrap-slider/js/bootstrap-slider.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/app-form-elements.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/parsley/parsley.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js')); ?>"
            type="text/javascript"></script>
    <script type="text/javascript">

        $.fn.niftyModal('setDefaults', {
            overlaySelector: '.modal-overlay',
            closeSelector: '.modal-close',
            classAddAfterOpen: 'modal-show',
        });
    </script>
    

    <script type="text/javascript">

        $(document).ready(function () {
            App.init();
            App.formElements();
            App.dataTables();
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


    <script src="<?php echo e(asset('public/js/ordenpedido/ordenpedido.js?v='.$version)); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>