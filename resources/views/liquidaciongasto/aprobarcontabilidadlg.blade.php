@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/file/fileinput.css') }} "/>
    <style>
        .editarcuentas{
            display: none;
        }
        .editarcuentasreparable{
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
    </style>
@stop
@section('section')

<div class="be-content liquidaciongasto">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">Revision de Comprobante ({{$liquidaciongastos->ID_DOCUMENTO}})</div>
            <div class="tab-container">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#aprobar" data-toggle="tab"><b>APROBAR y RECOMENDAR</b></a></li>
                <li><a href="#observar" data-toggle="tab"><b>OBSERVAR</b></a></li>
                <li><a href="#rechazar" data-toggle="tab"><b>EXTORNAR</b></a></li>
              </ul>
              <div class="tab-content">
                <div id="aprobar" class="tab-pane active cont">
                      <div class="panel panel-default panel-border-color panel-border-color-primary">
                        <div class="panel-heading panel-heading-divider">Aprobar Liquidacion de Gasto Contabilidad<span class="panel-subtitle">Aprobar una Liquidacion de Gasto Contabilidad</span></div>
                        <div class="panel-body">
                          <form method="POST" id='formpedido' action="{{ url('/aprobar-liquidacion-gasto-contabilidad/'.$idopcion.'/'.Hashids::encode(substr($liquidaciongastos->ID_DOCUMENTO, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include('liquidaciongasto.form.formaprobarcontlg')
                            <div class="row xs-pt-15">
                              <div class="col-xs-6">
                                  <div class="be-checkbox">
                                  </div>
                              </div>
                              <div class="col-xs-6">
                                <p class="text-right">
                                  <a href="{{ url('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
                                  <button type="button"  class="btn btn-space btn-primary btnaprobarcomporbatnte">Guardar</button>
                                </p>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                </div>
                <div id="observar" class="tab-pane cont">
                  <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading panel-heading-divider">Observar Comprobante<span class="panel-subtitle">Observar un Comprobante</span></div>
                    <div class="panel-body">
                        <form method="POST" id='formpedidoobservar' action="{{ url('/agregar-observar-contabilidad/'.$idopcion.'/'.Hashids::encode(substr($liquidaciongastos->ID_DOCUMENTO, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                              {{ csrf_field() }}
                          <input type="hidden" name="data_observacion" id="data_observacion">
                          @include('liquidaciongasto.form.formobservarcont')
                          <div class="row xs-pt-15">
                            <div class="col-xs-6">
                                <div class="be-checkbox">
                                </div>
                            </div>
                            <div class="col-xs-6">
                              <p class="text-right">
                                <a href="{{ url('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
                                <button type="button"  class="btn btn-space btn-primary btnobservarcomporbatnte">Guardar</button>
                              </p>
                            </div>
                          </div>

                        </form>
                    </div>
                  </div>
                </div>

                <div id="rechazar" class="tab-pane">
                  <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading panel-heading-divider">Extornar<span class="panel-subtitle">Extornar un Comprobante</span></div>
                    <div class="panel-body">

                        <form method="POST" id='formpedidorechazar' action="{{ url('/agregar-extorno-contabilidad-lg/'.$idopcion.'/'.Hashids::encode(substr($liquidaciongastos->ID_DOCUMENTO, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                              {{ csrf_field() }}
                          @include('liquidaciongasto.form.formrechazocont')

                          <div class="row xs-pt-15">
                            <div class="col-xs-6">
                                <div class="be-checkbox">
                                </div>
                            </div>
                            <div class="col-xs-6">
                              <p class="text-right">
                                <a href="{{ url('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
                                <button type="button"  class="btn btn-space btn-primary btnrechazocomporbatnte">Guardar</button>
                              </p>
                            </div>
                          </div>

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
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/js/file/fileinput.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/file/locales/es.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        App.dataTables();
        $('form').parsley();
      });
    </script>

    <script type="text/javascript">

          var initialPreview = {!! $initialPreview !!};
          var initialPreviewConfig = {!! $initialPreviewConfig !!};
          $("#input-24").fileinput({
              initialPreview: initialPreview,
              initialPreviewAsData: true,
              initialPreviewConfig: initialPreviewConfig,
              overwriteInitial: false,
              maxFileSize: 100,
              zoomModalHeight: 'auto', // Ajusta el modal automáticamente al contenido
              zoomModalWidth: 'auto'  // Ajusta el ancho del modal
          });

          $('.dinero').inputmask({
              'alias': 'numeric',
              'groupSeparator': ',', 'autoGroup': true, 'digits': 4,
              'digitsOptional': false,
              'prefix': '',
              'placeholder': '0'
          });

        $('#input-24').on('filezoomshown', function(event, params) {
            // Ajustar el modal de zoom para que se maximice
            var modal = params.modal;
            modal.find('.modal-dialog').css({
                'max-width': '100%',
                'width': '100%',
                'height': '100%',
                'max-height': '100%',
            });
            modal.find('.modal-content').css({
                'height': '100%',
            });
            modal.find('.modal-body').css({
                'height': 'calc(100% - 55px)', // Ajusta la altura del cuerpo del modal
                'overflow': 'auto',
            });
            modal.find('img').css({
                'width': '100%',
                'height': 'auto',
            });

            // Activar el modo de pantalla completa
            setTimeout(function() {
                modal.find('.btn-kv-fullscreen').trigger('click');
            }, 100); // Retraso para asegurar que el modal está completamente cargado
        });


    </script>



    <script src="{{ asset('public/js/comprobante/liquidaciongasto.js?v='.$version) }}" type="text/javascript"></script>
@stop
