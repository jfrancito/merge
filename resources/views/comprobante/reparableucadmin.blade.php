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
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">Comprobante Reparable<span class="panel-subtitle">Comprobante Reparable Administracion</span></div>
          <div class="panel-body">
            <form method="POST" id='formpedido' action="{{ url('/reparable-comprobante-uc-admin/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
                  {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>
              @include('comprobante.form.formmitigarreparableadmin')
            </form>
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

      @foreach($tarchivos as $index => $item) 
         $('#file-{{$item->COD_CATEGORIA_DOCUMENTO}}').fileinput({
            theme: 'fa5',
            language: 'es',
            allowedFileExtensions: ['{{$item->TXT_FORMATO}}'],
          });
      @endforeach

      @foreach($archivospdf as $index => $item)
        var nombre_archivo = '{{$item->NOMBRE_ARCHIVO}}';
        $('#file-'+{{$index}}).fileinput({
          theme: 'fa5',
          language: 'es',
          initialPreview: ["{{ route('serve-file', ['file' => '']) }}" + nombre_archivo],
          initialPreviewAsData: true,
          initialPreviewFileType: 'pdf',
          initialPreviewConfig: [
              {type: "pdf", caption: nombre_archivo, downloadUrl: "{{ route('serve-file', ['file' => '']) }}" + nombre_archivo} // Para mostrar el botón de descarga
          ]
        });
      @endforeach
      
      
      $('#file-otros').fileinput({
        theme: 'fa5',
        language: 'es',
      });


    </script>


  <script src="{{ asset('public/js/comprobante/uc.js?v='.$version) }}" type="text/javascript"></script>

@stop