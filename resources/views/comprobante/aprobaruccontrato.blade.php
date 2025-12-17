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
            <div class="panel-heading">Revision de Comprobante ({{$ordencompra->COD_DOCUMENTO_CTBLE}})</div>
            <div class="tab-container">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#aprobar" data-toggle="tab"><b>APROBAR y RECOMENDAR</b></a></li>
                <li><a href="#observar" data-toggle="tab"><b>OBSERVAR</b></a></li>
              </ul>
              <div class="tab-content">
                <div id="aprobar" class="tab-pane active cont">
                  <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading panel-heading-divider">Aprobar Comprobante Contacto<span class="panel-subtitle">Aprobar un Comprobante Usuario Contacto</span></div>
                    <div class="panel-body">
                      <form method="POST" id='formpedido' action="{{ url('/aprobar-comprobante-uc-contrato/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
                            {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>
                        @include('comprobante.form.formaprobarcontrato')

                      </form>
                    </div>
                  </div>
                </div>
                <div id="observar" class="tab-pane cont">
                  <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading panel-heading-divider">Observar Comprobante<span class="panel-subtitle">Observar un Comprobante</span></div>
                    <div class="panel-body">
                      <form method="POST" id='formpedidoobservar' action="{{ url('/agregar-observacion-uc-contrato/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                            {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>
                        @include('comprobante.form.formobservaruccontrato')
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

         $('#file-otros').fileinput({
            theme: 'fa5',
            language: 'es',
          });


         $('#file-pdf').fileinput({
            theme: 'fa5',
            language: 'es',
            allowedFileExtensions: ['pdf'],
          });



        @foreach($archivospdf as $index => $item)
          var nombre_archivo = '{{$item->NOMBRE_ARCHIVO}}';
          $('#file-'+{{$index}}).fileinput({
            theme: 'fa5',
            language: 'es',
            initialPreview: ["{{ route('serve-filecontrato', ['file' => '']) }}" + nombre_archivo],
            initialPreviewAsData: true,
            initialPreviewFileType: 'pdf',
            initialPreviewConfig: [
                {type: "pdf", caption: nombre_archivo, downloadUrl: "{{ route('serve-filecontrato', ['file' => '']) }}" + nombre_archivo} // Para mostrar el botón de descarga
            ]
          });
        @endforeach


        @foreach($array_guias as $index => $item)
          var nombre_archivo = '{{$item['COD_DOCUMENTO_CTBLE']}}';
          $('#file-'+nombre_archivo).fileinput({
            theme: 'fa5',
            language: 'es',
            initialPreview: ["{{ route('serve-filecontrato-sg', ['file' => '']) }}" + nombre_archivo],
            initialPreviewAsData: true,
            initialPreviewFileType: 'pdf',
            initialPreviewConfig: [
                {type: "pdf", caption: nombre_archivo, downloadUrl: "{{ route('serve-filecontrato-sg', ['file' => '']) }}" + nombre_archivo} // Para mostrar el botón de descarga
            ]
          });
        @endforeach

        @foreach($array_guias_no as $index => $item)
          var nombre_archivo = '{{$item['COD_DOCUMENTO_CTBLE']}}';
           $('#file-'+nombre_archivo).fileinput({
              theme: 'fa5',
              language: 'es',
              allowedFileExtensions: ['pdf'],
            });
        @endforeach

        var rutaoc = '{{$rutaorden}}';
        if(rutaoc==''){
          var nombre_archivo = '{{$ordencompra->COD_DOCUMENTO_CTBLE}}';
           $('#file-'+nombre_archivo).fileinput({
              theme: 'fa5',
              language: 'es',
              allowedFileExtensions: ['pdf'],
            });
        }

        @foreach($tarchivos_g as $index => $item)
          var nombre_archivo = '{{$item->COD_ORDEN}}';
          $('#file-'+nombre_archivo).fileinput({
            theme: 'fa5',
            language: 'es',
            initialPreview: ["{{ route('serve-filecontrato-sg', ['file' => '']) }}" + nombre_archivo],
            initialPreviewAsData: true,
            initialPreviewFileType: 'pdf',
            initialPreviewConfig: [
                {type: "pdf", caption: nombre_archivo, downloadUrl: "{{ route('serve-filecontrato-sg', ['file' => '']) }}" + nombre_archivo} // Para mostrar el botón de descarga
            ]
          });
        @endforeach







    </script>
    <script src="{{ asset('public/js/comprobante/registro.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/comprobante/uc.js?v='.$version) }}" type="text/javascript"></script>
@stop

