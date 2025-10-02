@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/file/fileinput.css') }} "/>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.7.0/slimselect.min.css" rel="stylesheet">

    <style>
        .editarcuentas {
            display: none;
        }

        .editarcuentasreparable {
            display: none;
        }

        #asientodetalle {
            width: 100% !important;
        }

        #asientodetallereversion {
            width: 100% !important;
        }

        #asientodetallededuccion {
            width: 100% !important;
        }

        #asientodetallepercepcion {
            width: 100% !important;
        }

        #asientodetallereparable {
            width: 100% !important;
        }

        .selected {
            background-color: #00ffff !important;
            color: #000000;
            vertical-align: middle;
            padding: 1.5em;
        }

        /* Versión pequeña tipo input-sm */
        .ss-main {
            height: 38px;         /* ajusta la altura */
            font-size: 12px;      /* tamaño de fuente */
            padding: 2px 8px;     /* espacio interno */
        }

    </style>
@stop
@section('section')

    <div class="be-content">
        <div class="main-content container-fluid">
            <!--Basic forms-->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <input type="hidden" name="idopcion" id='idopcion' value="{{ $idopcion }}">
                        <input type="hidden" name="idoc" id='idoc' value="{{ $idoc }}">

                        <div class="panel-heading">Revision de Comprobante ({{$ordencompra->COD_ORDEN}})</div>
                        <div class="tab-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#aprobar" data-toggle="tab"><b>APROBAR y RECOMENDAR</b></a>
                                </li>
                                <li><a href="#observar" data-toggle="tab"><b>OBSERVAR</b></a></li>
                                <li><a href="#reparable" data-toggle="tab"><b>REPARABLE</b></a></li>
                                <li><a href="#rechazar" data-toggle="tab"><b>EXTORNAR</b></a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="aprobar" class="tab-pane active cont">
                                    <div class="panel panel-default panel-border-color panel-border-color-primary">
                                        <div class="panel-heading panel-heading-divider">Aprobar Comprobante
                                            Contabilidad<span
                                                    class="panel-subtitle">Aprobar un Comprobante Contabilidad</span>
                                        </div>
                                        <div class="panel-body">

                                            <form method="POST" id='formpedido'
                                                  action="{{ url('/aprobar-comprobante-contabilidad/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}"
                                                  style="border-radius: 0px;"
                                                  class="form-horizontal group-border-dashed"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                @include('comprobante.form.formaprobarcont')
                                                <div class="row xs-pt-15">
                                                    <div class="col-xs-6">
                                                        <div class="be-checkbox">

                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <p class="text-right">
                                                            <a href="{{ url('/gestion-de-contabilidad-aprobar/'.$idopcion) }}">
                                                                <button type="button"
                                                                        class="btn btn-space btn-danger btncancelar">
                                                                    Cancelar
                                                                </button>
                                                            </a>
                                                            <button type="button"
                                                                    class="btn btn-space btn-primary btnaprobarcomporbatnte">
                                                                Guardar
                                                            </button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="observar" class="tab-pane cont">
                                    <div class="panel panel-default panel-border-color panel-border-color-primary">
                                        <div class="panel-heading panel-heading-divider">Observar Comprobante<span
                                                    class="panel-subtitle">Observar un Comprobante</span></div>
                                        <div class="panel-body">

                                            <form method="POST" id='formpedidoobservar'
                                                  action="{{ url('/agregar-observacion-contabilidad/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}"
                                                  style="border-radius: 0px;"
                                                  class="form-horizontal group-border-dashed">
                                                {{ csrf_field() }}
                                                @include('comprobante.form.formobservar')

                                                <div class="row xs-pt-15">
                                                    <div class="col-xs-6">
                                                        <div class="be-checkbox">

                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <p class="text-right">
                                                            <a href="{{ url('/gestion-de-contabilidad-aprobar/'.$idopcion) }}">
                                                                <button type="button"
                                                                        class="btn btn-space btn-danger btncancelar">
                                                                    Cancelar
                                                                </button>
                                                            </a>
                                                            <button type="button"
                                                                    class="btn btn-space btn-primary btnobservarcomporbatnte">
                                                                Guardar
                                                            </button>
                                                        </p>
                                                    </div>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>


                                <div id="reparable" class="tab-pane">
                                    <div class="panel panel-default panel-border-color panel-border-color-primary">
                                        <div class="panel-heading panel-heading-divider">Reparable<span
                                                    class="panel-subtitle">Reparar un Comprobante</span></div>
                                        <div class="panel-body">
                                            <form method="POST" id='formpedidoreparable'
                                                  action="{{ url('/agregar-reparable-contabilidad/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}"
                                                  style="border-radius: 0px;"
                                                  class="form-horizontal group-border-dashed">
                                                {{ csrf_field() }}
                                                @include('comprobante.form.formreparable')
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div id="rechazar" class="tab-pane">
                                    <div class="panel panel-default panel-border-color panel-border-color-primary">
                                        <div class="panel-heading panel-heading-divider">Extornar<span
                                                    class="panel-subtitle">Extornar un Comprobante</span></div>
                                        <div class="panel-body">
                                            <form method="POST" id='formpedidorechazar'
                                                  action="{{ url('/agregar-extorno-contabilidad/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}"
                                                  style="border-radius: 0px;"
                                                  class="form-horizontal group-border-dashed">
                                                {{ csrf_field() }}
                                                @include('comprobante.form.formrechazo')
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')

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

    <script src="{{ asset('public/js/file/fileinput.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/file/locales/es.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.7.0/slimselect.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            //initialize the javascript
            App.init();
            //App.formElements();
            App.dataTables();
            $('form').parsley();
        });
    </script>

    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function() {

            let carpeta = $("#carpeta").val();
            let _token = $("#token").val();
            let link = '/buscar-proveedor';

            //siempre que uses nifty modal usar esta libreria para poder abrir los modales
            $.fn.niftyModal('setDefaults',{
                overlaySelector: '.modal-overlay',
                closeSelector: '.modal-close',
                classAddAfterOpen: 'modal-show',
              });

            let select = new TomSelect("#empresa_asiento", {
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

            let select_reparable = new TomSelect("#empresa_asiento_reparable", {
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
                    //fetch(carpeta + '/buscar-tipo-documento?q=' + encodeURIComponent(query))
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

            if (defaultIdReparable) {
                select_reparable.addOption({id: defaultIdReparable, text: defaultTextReparable}); // añade la opción
                select_reparable.setValue(defaultIdReparable); // la selecciona
            }

            window.selects = {};
            document.querySelectorAll("select.slim").forEach(function(el) {
                window.selects[el.id] = new SlimSelect({
                    select: el,
                    placeholder: 'Seleccione...',
                    allowDeselect: true
                })
            })

            $('.pnlasientos').hide();

        });

        $('#file-otros').fileinput({
            theme: 'fa5',
            language: 'es',
        });

        $('.dinero').inputmask({
            'alias': 'numeric',
            'groupSeparator': ',', 'autoGroup': true, 'digits': 4,
            'digitsOptional': false,
            'prefix': '',
            'placeholder': '0'
        });

        $('#file-pdf').fileinput({
            theme: 'fa5',
            language: 'es',
            allowedFileExtensions: ['pdf'],
        });

        @foreach($archivospdf as $index => $item)
        var nombre_archivo = '{{$item->NOMBRE_ARCHIVO}}';
        $('#file-' + {{$index}}).fileinput({
            theme: 'fa5',
            language: 'es',
            initialPreview: ["{{ route('serve-file', ['file' => '']) }}" + nombre_archivo],
            initialPreviewAsData: true,
            initialPreviewFileType: 'pdf',
            initialPreviewConfig: [
                {
                    type: "pdf",
                    caption: nombre_archivo,
                    downloadUrl: "{{ route('serve-file', ['file' => '']) }}" + nombre_archivo
                } // Para mostrar el botón de descarga
            ]
        });
        @endforeach
    </script>

    <script src="{{ asset('public/js/comprobante/uc.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/comprobante/af.js?v='.$version) }}" type="text/javascript"></script>

@stop
