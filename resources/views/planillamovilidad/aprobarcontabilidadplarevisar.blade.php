@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/file/fileinput.css') }} "/>
@stop
@section('section')

<div class="be-content cfedocumento">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">Revision de Comprobante ({{$feplanillaentrega->ID_DOCUMENTO}})</div>
            <div class="tab-container">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#aprobar" data-toggle="tab"><b>APROBAR y RECOMENDAR</b></a></li>
              </ul>
              <div class="tab-content">
                <div id="aprobar" class="tab-pane active cont">
                      <div class="panel panel-default panel-border-color panel-border-color-primary">
                        <div class="panel-heading panel-heading-divider">Aprobar Liquidacion de Gasto Contabilidad<span class="panel-subtitle">Aprobar una Liquidacion de Gasto Contabilidad</span></div>
                        <div class="panel-body">
                          <form method="POST" id='formpedido' action="{{ url('/aprobar-planilla-movilidad-contabilidad/'.$idopcion.'/'.Hashids::encode(substr($feplanillaentrega->ID_DOCUMENTO, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include('planillamovilidad.form.formaprobarcontpla')
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



    <script src="{{ asset('public/js/comprobante/planilla.js?v='.$version) }}" type="text/javascript"></script>
@stop