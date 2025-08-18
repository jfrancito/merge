@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@stop
@section('section')

    <div class="be-content valerendirprincipal">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">

                    <div class="tab-container">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#crearvale" data-toggle="tab"><b>CREAR VALE</b></a></li>
                        <li><a href="#valependiente" data-toggle="tab"><b>VALES PENDIENTES ({{count($listarValePendientes)}})</b></a></li>
                        <li><a href="#liquidaciones" data-toggle="tab"><b>LIQUIDACIONES SIN PROCESAR ({{count($listarLiquidacionesPendientes)}})</b></a></li>
                        <li><a href="#documentos" data-toggle="tab"><b>DOCUMENTOS CDR/XML ({{count($listarDocumentoXML_CDR)}})</b></a></li>
                         <li><a href="#listanegra" data-toggle="tab"><b>PROVEEDORES LISTA NEGRA ({{count($listarlistanegra)}})</b></a></li>
                      </ul>
                      <div class="tab-content">
                        <div id="crearvale" class="tab-pane active cont">
                            @include('valerendir.tab.creartab')
                        </div>
                        <div id="valependiente" class="tab-pane cont">
                            @include('valerendir.ajax.listamodalvalespendientes') 
                        </div>
                        <div id="liquidaciones" class="tab-pane cont">
                            @include('valerendir.ajax.listamodalliquidacionessinprocesar') 
                        </div>
                        <div id="documentos" class="tab-pane cont">
                            @include('valerendir.ajax.listamodaldocumentos_xml_cdr') 
                        </div>
                         <div id="listanegra" class="tab-pane cont">
                            @include('valerendir.ajax.listamodallistanegraproveedores') 
                        </div>
                      </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="glosaModal" tabindex="-1" role="dialog" aria-labelledby="glosaModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-lg shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #6c757d; color: #fff;">
                    <h5 class="modal-title" id="glosaModalLabel">Motivo de Rechazo</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto; padding: 15px;">
                    <div class="alert" style="background-color: #d6d8db; color: #212529; word-wrap: break-word;">
                        <strong>Motivo:</strong>
                        <p id="glosaRechazoMessage" class="text-dark" style="white-space: normal;"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #007bff; color: white;"
                            data-dismiss="modal">Cerrar
                    </button>
                </div>
            </div>
        </div></div>
    <div class="modal fade" id="glosaModal1" tabindex="-1" role="dialog" aria-labelledby="glosaModalLabel1"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-lg shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #6c757d; color: #fff;">
                    <h5 class="modal-title" id="glosaModalLabel1">Motivo de Aprobación</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto; padding: 15px;">
                    <div class="alert" style="background-color: #d6d8db; color: #212529; word-wrap: break-word;">
                        <strong>Motivo:</strong>
                        <p id="glosaAutorizaMessage" class="text-dark" style="white-space: normal;"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #007bff; color: white;"
                            data-dismiss="modal">Cerrar
                    </button>
                </div>
            </div>
        </div></div>

    <style>
        .custom-glosa-height {
            height: 100px;
        }

        .row-deleted {
            background-color: #f8d7da !important;
            color: #721c24 !important;
        }
    </style>

@stop
@section('script')

    <script>
        var importeDestinos = {!! json_encode($importeDestinos, JSON_UNESCAPED_UNICODE) !!};
    </script>

    <script src="{{ asset('public/js/general/inputmask/inputmask.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/inputmask.extensions.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/inputmask.numeric.extensions.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/js/app-tables-datatables.js?v='.$version) }}" type="text/javascript"></script>


    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}"
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

            $('#can_total_importe').on('input', function () {
                var importe = $(this).val();
                $('#can_total_saldo').val(importe);
            });

            $('#can_total_saldo').on('input', function () {
                var saldo = $(this).val();
                $('#can_total_importe').val(saldo);
            });
            App.init();
            App.formElements();
            App.dataTables();
            $('[data-toggle="tooltip"]').tooltip();

            $('.dinero').inputmask({
                'alias': 'numeric',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 2,
                'digitsOptional': false,
                'prefix': '',
                'placeholder': '0'
            });

            $('.dinero_masivo').inputmask({
                'alias': 'numeric',
                'groupSeparator': '',
                'autoGroup': true,
                'digits': 2,
                'digitsOptional': false,
                'prefix': '',
                'placeholder': '0'
            });

        });
    </script>


    <script src="{{ asset('public/js/vale/valerendir.js?v='.$version) }}" type="text/javascript"></script>
@stop
