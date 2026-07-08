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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>

  <!-- ================= CONTENEDOR PRINCIPAL ================= -->
<div class="be-content ordenpedidoprincipal">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <div class="tab-container">

                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#crearpedido" data-toggle="tab"><b>CREAR PEDIDO</b></a></li>
                        <li><a href="#ordenpedido" data-toggle="tab"><b>ORDEN PEDIDO</b></a></li>
                        <li id="tab-detalle-pedido" style="display:none;"><a href="#detallepedido" data-toggle="tab"><b>DETALLE PEDIDO</b></a></li>
                    </ul>

                    <!-- CONTENIDO TABS -->
                    <div class="tab-content">
                        <div id="crearpedido" class="tab-pane fade in active cont">
                            <?php echo $__env->make('ordenpedido.tab.creartaborden', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>

                        <div id="ordenpedido" class="tab-pane fade cont">
                            <?php echo $__env->make('ordenpedido.ajax.alistaordenpedido', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>

                        <div id="detallepedido" class="tab-pane fade cont">
                            <div id="detalle-pedido-container">
                                <!-- Contenido dinámico -->
                            </div>
                        </div>
                    </div><!-- FIN tab-content -->
                </div><!-- FIN tab-container -->
            </div>
        </div>
    </div>
    <?php echo $__env->make('ordenpedido.modal.modalsolicitud', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
     
     <script>
        var registrosMonto = <?php echo json_encode($registrosMonto, JSON_UNESCAPED_UNICODE); ?>;
        var registrosPeriodos = <?php echo json_encode($registrosPeriodos, JSON_UNESCAPED_UNICODE); ?>;
        
    </script>

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
            
            $("#tabla-orden-pedido").dataTable({
                "pageLength": 10,
                "order": [[0, "desc"]]
            });

            // Ajustar columnas de DataTables al cambiar de pestaña para evitar desalineación
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                if ($.fn.DataTable) {
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                }
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


    <script src="<?php echo e(asset('public/js/ordenpedido/ordenpedido.js?v='.$version)); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>