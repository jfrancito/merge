@extends('template_lateral')
@section('style')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Tema moderno (opcional: material_blue, dark, airbnb, etc.) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

    <link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/confirm/jquery-confirm.min.css') }} "/>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.7.0/slimselect.min.css" rel="stylesheet">
    <style rel="stylesheet" type="text/css">
        .gridjs-container {
            overflow-y: auto !important;  /* activa scroll vertical */
        }

        .gridjs-container thead th {
            position: sticky;
            top: 0;
            background: #f8f9fa; /* color del fondo del header */
            z-index: 2; /* se mantiene sobre las celdas */
        }
    </style>
@stop
@section('section')
    <div class="be-content contenido comprobantescontabilidad">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default panel-border-color panel-border-color-success">
                        <div class="panel-heading">{{ $titulo }}
                            <div class="tools tooltiptop">
                                <div class="tools tooltiptop">
                                    <a href="#" class="tooltipcss opciones buscarcomprobantes">
                                        <span class="tooltiptext">Buscar Documento</span>
                                        <span class="icon mdi mdi-search"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class='filtrotabla row'>

                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 cajareporte" style="display: none">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label labelleft negrita">Fecha Inicio: </label>
                                        <div class="col-sm-12 abajocaja">
                                            <input type="text" id="fecha_inicio" class="form-control input-sm"
                                                   placeholder="📅 Elige una fecha inicio">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 cajareporte" style="display: none">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label labelleft negrita">Fecha Fin: </label>
                                        <div class="col-sm-12 abajocaja">
                                            <input type="text" id="fecha_fin" class="form-control input-sm"
                                                   placeholder="📅 Elige una fecha final">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label labelleft negrita">Año :</label>
                                        <div class="col-sm-12 abajocaja">
                                            {!! Form::select( 'anio_aiento', $array_anio, $anio_defecto,
                                                              [
                                                                'class'       => 'slim',
                                                                'id'          => 'anio_asiento',
                                                                'data-aw'     => '1',
                                                                'required'    => true,
                                                              ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ajax_anio_asiento">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label labelleft negrita">Periodo
                                            :</label>
                                        <div class="col-sm-12 abajocaja">
                                            {!! Form::select( 'periodo_asiento', $array_periodo, $periodo_defecto,
                                                              [
                                                                'class'       => 'slim',
                                                                'id'          => 'periodo_asiento',
                                                                'data-aw'     => '2',
                                                                'required'    => true,
                                                              ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <input type="hidden" name="idopcion" id='idopcion' value='{{$idopcion}}'>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id='tbl_respuesta'>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script>
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
    <script src="{{ asset('public/js/confirm/jquery-confirm.min.js') }}" type="text/javascript"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.7.0/slimselect.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <script type="text/javascript">

        window.selects = {};
        document.querySelectorAll("select.slim").forEach(function(el) {
            window.selects[el.id] = new SlimSelect({
                select: el,
                placeholder: 'Seleccione...',
                allowDeselect: true
            })
        })

        flatpickr("#fecha_inicio", {
            dateFormat: "d-m-Y",   // formato DD-MM-YYYY
            locale: "es",          // idioma español
            disableMobile: true    // fuerza estilo moderno también en móviles
        });

        flatpickr("#fecha_fin", {
            dateFormat: "d-m-Y",   // formato DD-MM-YYYY
            locale: "es",          // idioma español
            disableMobile: true    // fuerza estilo moderno también en móviles
        });

        $.fn.niftyModal('setDefaults', {
            overlaySelector: '.modal-overlay',
            closeSelector: '.modal-close',
            classAddAfterOpen: 'modal-show',
        });

        $(document).ready(function () {
            //initialize the javascript
            App.init();
            App.formElements();
            App.dataTables();
            $('[data-toggle="tooltip"]').tooltip();
            $('form').parsley();
        });

    </script>
    <script src="{{ asset('public/js/comprobante/comprobantescontabilidad.js?v='.$version) }}" type="text/javascript"></script>
@stop
