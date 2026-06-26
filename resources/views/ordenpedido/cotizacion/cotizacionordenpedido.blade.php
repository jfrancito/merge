@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        .background-fila-activa {
            background-color: #d9edf7 !important;
            border-left: 4px solid #34aadc;
        }
    </style>
@stop
@section('section')

<div class="be-content cotizacionordenpedidoprincipal">
    <!-- VALORES OCULTOS -->
    <input type="hidden" id="tipo_cambio_actual" value="{{ $valor_tipo_cambio }}">
    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <input type="hidden" id="cod_centro_usuario" value="{{ $cod_centro }}">

    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="tab-container">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#crearcotizacionpedido" data-toggle="tab"><b>CREAR COTIZACIÓN PEDIDOS</b></a>
                        </li>
                        <li>
                            <a href="#listacotizacionpedido" data-toggle="tab"><b>COTIZACIÓN PEDIDOS</b></a>
                        </li>
                        <li id="tab-header-detalle" style="display: none;">
                            <a href="#detallecotizacion" data-toggle="tab"><b style="color: #e67e22;">DETALLE COTIZACIÓN</b></a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- TAB: CREAR -->
                        <div id="crearcotizacionpedido" class="tab-pane active cont">
                            @include('ordenpedido.tab.creartabordencotizacion')
                        </div>
                        
                        <!-- TAB: LISTA -->
                        <div id="listacotizacionpedido" class="tab-pane fade cont">
                            @include('ordenpedido.cotizacion.listacotizacionpedido')
                        </div>

                        <!-- TAB: DETALLE (NUEVO) -->
                        <div id="detallecotizacion" class="tab-pane fade cont">
                            <div id="contenedor-detalle-cotizacion-tab">
                                <div class="text-center" style="padding: 100px;">
                                    <i class="fa fa-spinner fa-spin fa-4x text-primary" style="margin-bottom: 20px;"></i>
                                    <h4 class="text-muted">Cargando información detallada...</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('ordenpedido.modal.modal_seleccionar_consolidado_general')
    @include('ordenpedido.modal.modal_seleccionar_pedido')
    @include('ordenpedido.modal.modal_deshabilitar_productos')
</div>

@stop
@section('script')

    <script src="{{ asset('public/js/general/inputmask/inputmask.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/inputmask.extensions.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/inputmask.numeric.extensions.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-tables-datatables.js?v='.$version) }}" type="text/javascript"></script>

    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}" type="text/javascript"></script>
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

    <script src="{{ asset('public/js/ordenpedido/cotizacionpedido.js?v='.$version) }}" type="text/javascript"></script>
@stop
