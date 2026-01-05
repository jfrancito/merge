@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.7.0/slimselect.min.css" rel="stylesheet">
    <style>
        .mdi--file-excel {
            width: 1em;
            height: 1em;
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: contain;  /* importante para no deformar */
            mask-size: contain;
        }

        .btn-group .icon {
            display: inline-block;
            width: 1em;   /* mismo ancho */
            height: 1em;  /* misma altura */
            font-size: 16px; /* controla el tamaño general */
            vertical-align: middle;
        }

    </style>
@stop
@section('section')

    <div class="be-content contenido reporteliquidaciones">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default panel-border-color @if(Session::get('empresas')->COD_EMPR == 'IACHEM0000010394') panel-border-color-danger @else @if(Session::get('empresas')->COD_EMPR == 'IACHEM0000007086') panel-border-color-success @else panel-border-color-info @endif @endif">
                        <div class="panel-heading">REPORTE DE LIQUIDACIONES
                            <div class="tools tooltiptop">

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm tooltipcss buscarliquidaciones">
                                        <span class="icon mdi mdi-search text-white"></span>
                                        Buscar
                                    </button>

                                    <button type="button" class="btn btn-success btn-sm tooltipcss descargararchivo">
                                        <span class="icon mdi--file-excel text-white"></span>
                                        Excel
                                    </button>
                                </div>

                            </div>
                            <span class="panel-subtitle">{{Session::get('empresas')->NOM_EMPR}} </span>

                        </div>

                        <div class="panel-body">
                            <div class='filtrotabla row'>
                                <div class="col-xs-12">

                                    <form method="POST"
                                          id="formdescargar"
                                          target="_blank"
                                          action="{{ url('/obtener-reporte-liquidaciones-trabajador-excel') }}"
                                          style="border-radius: 0px;"
                                    >
                                        {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>


                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft negrita">Fecha Inicio
                                                    :</label>
                                                <div class="col-sm-12 abajocaja">
                                                    <input required id="startDate" name="startDate"
                                                           class="form-control control input-sm" type="date"
                                                           value="{{ date('Y-m-d', strtotime('-1 week')) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft negrita">Fecha Fin
                                                    :</label>
                                                <div class="col-sm-12 abajocaja">
                                                    <input required id="endDate" name="endDate"
                                                           class="form-control control input-sm" type="date"
                                                           value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 cajareporte">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft negrita">Trabajador :</label>
                                                <div class="col-sm-12 abajocaja">
                                                    {!! Form::select( 'employee', [], '',
                                                                      [
                                                                        'id'          => 'employee',
                                                                        'data-aw'     => '1',
                                                                      ]) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            let defaultId = "{{ '' }}";
                                            let defaultText = "{{ 'TODOS' }}";
                                        </script>

                                        <input type="hidden" name="idopcion" id='idopcion' value='{{$idopcion}}'>

                                    </form>

                                </div>

                            </div>

                            <div class='listajax'>
                                @include('reporte.administracion.ajax.listaliquidacionestrabajador')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')

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
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.7.0/slimselect.min.js"></script>

    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function() {

            let carpeta = $("#carpeta").val();
            let _token = $("#token").val();
            let link = '/buscar-trabajador-liquidaciones';

            let select = new TomSelect("#employee", {
                valueField: 'id',
                labelField: 'text',
                searchField: 'text',
                placeholder: "Escriba para buscar...",
                preload: true, // carga inicial
                load: function(query, callback) {
                    let data = {
                        _token: _token,
                        busqueda: query
                    };
                    fetch(carpeta + link, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(data)
                    })
                        //fetch('/buscar-tipo-documento?q=' + encodeURIComponent(query))
                        .then(response => response.json())
                        .then(json => { callback(json); })
                        .catch(() => { callback(); });
                }
            });

            // ✅ Si hay valor por defecto, lo insertamos
            if (defaultId) {
                select.addOption({id: defaultId, text: defaultText}); // añade la opción
                select.setValue(defaultId); // la selecciona
            }

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

        $(".select3").select2({
            width: '100%'
        });
    </script>
    <script src="{{ asset('public/js/reporte/reporteliquidaciones.js?v='.$version) }}" type="text/javascript"></script>

@stop
