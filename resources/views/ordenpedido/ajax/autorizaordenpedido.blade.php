@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
@stop
@section('section')
    <div class="be-content ordenpedidoprincipal">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    
                    <div class="tab-container">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#ordenpedidoautoriza" data-toggle="tab">
                                    <i class="fa fa-list me-1"></i> <b>ORDEN PEDIDO - AUTORIZA</b>
                                </a>
                            </li>
                            <li id="tab-detalle-pedido-aut" style="display:none;">
                                <a href="#detallepedidoaut" data-toggle="tab">
                                    <i class="fa fa-file-text-o me-1"></i> <b>DETALLE PEDIDO</b>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- LISTADO PRINCIPAL -->
                            <div id="ordenpedidoautoriza" class="tab-pane fade in active cont">
                                <div class='listajax'>    
                                    @include('ordenpedido.ajax.alistaordenpedidoautoriza')
                                </div>
                            </div>

                            <!-- DETALLE DINÁMICO -->
                            <div id="detallepedidoaut" class="tab-pane fade cont">
                                <div id="detalle-pedido-aut-container">
                                    <div class="text-center py-5">
                                        <i class="fa fa-spinner fa-spin fa-3x mb-3 text-primary"></i>
                                        <p class="text-muted">Cargando detalles del pedido...</p>
                                    </div>
                                </div>
                            </div>
                        </div><!-- FIN tab-content -->
                    </div><!-- FIN tab-container -->

                </div>
            </div>
        </div>
        <input type="text" id="vale_rendir_id" hidden>
        @include('ordenpedido.modal.modalsolicitud')
    </div>

@stop
@section('script')

<script src="{{ asset('public/js/general/inputmask/inputmask.js') }}" type="text/javascript"></script> 
<script src="{{ asset('public/js/general/inputmask/inputmask.extensions.js') }}" type="text/javascript"></script> 
<script src="{{ asset('public/js/general/inputmask/inputmask.numeric.extensions.js') }}" type="text/javascript"></script> 
<script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script> 
<script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>

<script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>        
<script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/select2/js/i18n/es.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>

<script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/js/app-tables-datatables.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/raphael/raphael-min.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/lib//chartjs/Chart.min.js')}}" type="text/javascript"></script>

<script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}" type="text/javascript"></script>

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

        // Inicializar tablas de autorización
        if (typeof inicializarTablasAutorizacion === 'undefined') {
            window.inicializarTablasAutorizacion = function() {
                var config = {
                    "pageLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    "order": [[0, "desc"]],
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

                // Destruir instancias previas si existen para evitar errores al recargar con AJAX
                if ($.fn.DataTable.isDataTable('#table-pedidos-pendientes')) {
                    $('#table-pedidos-pendientes').DataTable().destroy();
                }
                if ($.fn.DataTable.isDataTable('#table-pedidos-autorizados')) {
                    $('#table-pedidos-autorizados').DataTable().destroy();
                }
                if ($.fn.DataTable.isDataTable('#table-pedidos-rechazados')) {
                    $('#table-pedidos-rechazados').DataTable().destroy();
                }

                $('#table-pedidos-pendientes, #table-pedidos-autorizados, #table-pedidos-rechazados').dataTable(config);
            };
        }

        inicializarTablasAutorizacion();

        // Ajustar columnas de DataTables al cambiar de pestaña para evitar desalineación
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if ($.fn.DataTable) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            }
        });

      });
    </script> 
<script src="{{ asset('public/js/ordenpedido/ordenpedido.js?v='.$version) }}" type="text/javascript"></script>
@stop