@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/file/fileinput.css') }} "/>
@stop
@section('section')

<div class="be-content">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">Revision de Comporbante ({{$planillamovilidad->ID_DOCUMENTO}})</div>
            <div class="tab-container">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#aprobar" data-toggle="tab"><b>APROBAR y RECOMENDAR</b></a></li>
                <li><a href="#observar" data-toggle="tab"><b>OBSERVAR</b></a></li>
                <li><a href="#rechazar" data-toggle="tab"><b>EXTORNAR</b></a></li>
              </ul>
              <div class="tab-content">
                <div id="aprobar" class="tab-pane active cont">
                      <div class="panel panel-default panel-border-color panel-border-color-primary">
                        <div class="panel-heading panel-heading-divider">Aprobar Planilla Movilidad Jefe<span class="panel-subtitle">Aprobar una Planilla Movilidad Jefe</span></div>
                        <div class="panel-body">
                          <form method="POST" id='formpedido' action="{{ url('/aprobar-planilla-movilidad-jefe/'.$idopcion.'/'.Hashids::encode(substr($planillamovilidad->ID_DOCUMENTO, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            @include('planillamovilidad.form.formaprobarjefe')
                            <div class="row xs-pt-15">
                              <div class="col-xs-6">
                                  <div class="be-checkbox">
                                  </div>
                              </div>
                              <div class="col-xs-6">
                                <p class="text-right">
                                  <a href="{{ url('/gestion-de-contabilidad-aprobar/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
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
                        OBSERVAR
                    </div>
                  </div>
                </div>

                <div id="rechazar" class="tab-pane">
                  <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading panel-heading-divider">Extornar<span class="panel-subtitle">Extornar un Comprobante</span></div>
                    <div class="panel-body">
                      EXTORNAR
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
        $('form').parsley();
      });
    </script> 
    <script src="{{ asset('public/js/comprobante/planilla.js?v='.$version) }}" type="text/javascript"></script>
@stop