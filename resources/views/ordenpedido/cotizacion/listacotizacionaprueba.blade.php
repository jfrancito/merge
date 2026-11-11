@extends('template_lateral')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }}"/>
    <style>
        /* Ajuste para tabla grande */
        .table-responsive {
            overflow-x: auto;
        }

        .cajareporte {
            padding-bottom: 15px;
        }

        .filtrotabla .form-group {
            margin-bottom: 0;
        }

        .panel-heading .tools {
            float: right;
        }
    </style>
@stop

@section('section')
<div class="be-content ordenpedidoprincipal">
    <div class="main-content container-fluid">
        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="carpeta" value="{{$capeta}}" id="carpeta">

        <div class="row">
            <div class="col-sm-12">

                <div class="tab-container">
                    <ul class="nav nav-tabs" style="display: none;">
                        <li class="active"><a href="#ordenpedido" data-toggle="tab"><b>RESUMEN</b></a></li>
                        <li id="tab-detalle-pedido" style="display:none;"><a href="#detallepedido" data-toggle="tab"><b>DETALLE</b></a></li>
                    </ul>

                    <div class="tab-content">
                        <!-- LISTADO PRINCIPAL -->
                        <div id="ordenpedido" class="tab-pane fade in active cont">
                            
                            <!-- PESTAÑAS INTERNAS DE ESTADO -->
                            <div class="tab-container">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#pendientes" data-toggle="tab">
                                            <span class="badge badge-warning" style="margin-right: 5px;">{{ count($pendientes) }}</span> PENDIENTES
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#aprobado" data-toggle="tab">
                                            <span class="badge badge-success" style="margin-right: 5px;">{{ count($aprobados) }}</span> APROBADO
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#rechazados" data-toggle="tab">
                                            <span class="badge badge-danger" style="margin-right: 5px;">{{ count($rechazados) }}</span> RECHAZADOS
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content" style="padding: 20px 0 0 0;">
                                    <!-- PESTAÑA PENDIENTES -->
                                    <div id="pendientes" class="tab-pane active cont">
                                        @include('ordenpedido.cotizacion.ajax.listatablasaprueba', ['listacotizaciones' => $pendientes, 'tipo' => 'pendientes'])
                                    </div>

                                    <!-- PESTAÑA APROBADO -->
                                    <div id="aprobado" class="tab-pane cont">
                                        @include('ordenpedido.cotizacion.ajax.listatablasaprueba', ['listacotizaciones' => $aprobados, 'tipo' => 'aprobado'])
                                    </div>

                                    <!-- PESTAÑA RECHAZADOS -->
                                    <div id="rechazados" class="tab-pane cont">
                                        @include('ordenpedido.cotizacion.ajax.listatablasaprueba', ['listacotizaciones' => $rechazados, 'tipo' => 'rechazados'])
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <!-- DETALLE DINÁMICO -->
                        <div id="detallepedido" class="tab-pane fade cont">
                            <div id="detalle-pedido-container">
                                <div class="text-center py-5">
                                    <i class="fa fa-spinner fa-spin fa-3x mb-3 text-primary"></i>
                                    <p class="text-muted">Cargando detalles de la cotización...</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- FIN tab-content -->
                </div><!-- FIN tab-container -->

            </div>
        </div>
    </div>
</div>
@stop

@section('script')

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


    <script src="{{ asset('public/js/ordenpedido/aprobarcotizacion.js?v='.$version) }}" type="text/javascript"></script>
@stop
