@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/file/fileinput.css') }} "/>
@stop

@section('section')
<div class="be-content registrocomprobante">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-border-color panel-border-color-success">
                    <div class="panel-heading">{{ $titulo }}
                      <div class="tools tooltiptop">
                      </div>
                    </div>
                    <div class="panel-body">
                      @include('comprobante.lista.detallecomprobantevalidadonuevocontrato')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('script')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('public/css/portal/calendario.css?v='.$version) }} "/> --}}

    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>        
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>


    <script src="{{ asset('public/js/file/fileinput.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/file/locales/es.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/general.js') }}" type="text/javascript"></script>

 
    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();
      });
    </script> 

    <script type="text/javascript">    
           $('#file-cdr').fileinput({
              theme: 'fa5',
              language: 'es',
              allowedFileExtensions: ['xml','zip','ZIP'],
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


           
    </script>
  <script src="{{ asset('public/js/comprobante/registro.js?v='.$version) }}" type="text/javascript"></script>

    
@stop

