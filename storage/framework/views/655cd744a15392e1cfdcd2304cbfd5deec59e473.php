<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datatables/css/dataTables.bootstrap.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datatables/css/responsive.dataTables.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> "/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>
    <div class="be-content ordenpedidoprincipal">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">

                    <!-- NAVEGACIÓN DE PESTAÑAS -->
                    <div class="tab-container" style="margin-bottom: 25px;">
                        <ul class="nav nav-tabs nav-tabs-primary" id="ordenpedido-tabs" style="border-bottom: 2px solid #e3e6f0; background: #fff; border-radius: 8px 8px 0 0;">
                            <li class="active">
                                <a href="#ordenpedidoger" data-toggle="tab" style="font-weight: 700; color: #4e73df; padding: 15px 25px;">
                                    <i class="fa fa-list me-1"></i> LISTADO DE PEDIDOS (GERENCIA)
                                </a>
                            </li>
                            <li id="tab-detalle-pedido-ger" style="display: none;">
                                <a href="#detalle-pedido-ger" data-toggle="tab" style="font-weight: 700; color: #1cc88a; padding: 15px 25px;">
                                    <i class="fa fa-eye me-1"></i> DETALLE DEL PEDIDO
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" style="background: #fff; padding: 0; border: 1px solid #e3e6f0; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                            <!-- PESTAÑA: LISTADO -->
                            <div id="ordenpedidoger" class="tab-pane active">
                                <div class="panel panel-default panel-table" style="border: none; margin-bottom: 0;">
                                    <div class="panel-body" style="padding: 20px;">
                                        <div class='listajax'>    
                                            <?php echo $__env->make('ordenpedido.ajax.alistaordenpedidoapruebagerencia', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PESTAÑA: DETALLE (SE CARGA POR AJAX) -->
                            <div id="detalle-pedido-ger" class="tab-pane">
                                <div id="detalle-pedido-ger-container" style="padding: 2px;">
                                    <div class="text-center" style="padding: 100px 0;">
                                        <i class="fa fa-spinner fa-spin fa-3x text-primary"></i>
                                        <p class="mt-3 text-muted fw-bold">Cargando información detallada...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <input type="text" id="vale_rendir_id" hidden>
        <?php echo $__env->make('ordenpedido.modal.modalsolicitud', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('public/js/general/inputmask/inputmask.js')); ?>" type="text/javascript"></script> 
<script src="<?php echo e(asset('public/js/general/inputmask/inputmask.extensions.js')); ?>" type="text/javascript"></script> 
<script src="<?php echo e(asset('public/js/general/inputmask/inputmask.numeric.extensions.js')); ?>" type="text/javascript"></script> 
<script src="<?php echo e(asset('public/js/general/inputmask/inputmask.date.extensions.js')); ?>" type="text/javascript"></script> 
<script src="<?php echo e(asset('public/js/general/inputmask/jquery.inputmask.js')); ?>" type="text/javascript"></script>

<script src="<?php echo e(asset('public/lib/jquery-ui/jquery-ui.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/jquery.nestable/jquery.nestable.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/moment.js/min/moment.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>        
<script src="<?php echo e(asset('public/lib/select2/js/select2.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/select2/js/i18n/es.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/bootstrap-slider/js/bootstrap-slider.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/js/app-form-elements.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/parsley/parsley.js')); ?>" type="text/javascript"></script>

<script src="<?php echo e(asset('public/lib/datatables/js/jquery.dataTables.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/js/dataTables.bootstrap.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.print.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/js/app-tables-datatables.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib/raphael/raphael-min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/lib//chartjs/Chart.min.js')); ?>" type="text/javascript"></script>

<script src="<?php echo e(asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js')); ?>" type="text/javascript"></script>

<script type="text/javascript">

      $.fn.niftyModal('setDefaults',{
        overlaySelector: '.modal-overlay',
        closeSelector: '.modal-close',
        classAddAfterOpen: 'modal-show',
      });
      
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        App.formElements();
        $('form').parsley();

        $('.importe').inputmask({ 'alias': 'numeric', 
        'groupSeparator': ',', 'autoGroup': true, 'digits': 4, 
        'digitsOptional': false, 
        'prefix': '', 
        'placeholder': '0'});

        // Inicializar tablas de aprobación gerencia
        if (typeof inicializarTablasAprobacionGer === 'undefined') {
            window.inicializarTablasAprobacionGer = function() {
                var config = {
                    "pageLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    "language": {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando del 0 al 0 de 0 registros",
                        "sInfoFiltered":   "(filtrado de _MAX_ registros)",
                        "sSearch":         "Buscar:",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                };

                if ($.fn.DataTable.isDataTable('#table-pedidos-ger-pendientes')) {
                    $('#table-pedidos-ger-pendientes').DataTable().destroy();
                }
                if ($.fn.DataTable.isDataTable('#table-pedidos-ger-aprobados')) {
                    $('#table-pedidos-ger-aprobados').DataTable().destroy();
                }
                if ($.fn.DataTable.isDataTable('#table-pedidos-ger-rechazados')) {
                    $('#table-pedidos-ger-rechazados').DataTable().destroy();
                }

                $('#table-pedidos-ger-pendientes, #table-pedidos-ger-aprobados, #table-pedidos-ger-rechazados').dataTable(config);
            };
        }

        inicializarTablasAprobacionGer();

      });
    </script> 
<script src="<?php echo e(asset('public/js/ordenpedido/ordenpedido.js?v='.$version)); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>