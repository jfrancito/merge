@extends('template_lateral')
@section('style')
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
          <div class="panel-heading panel-heading-divider">Comprobante Observado<span class="panel-subtitle">Comprobante Observado</span></div>
          <div class="panel-body">
            <form method="POST" id='formpedido' action="{{ url('/observacion-comprobante-uc-estiba-oca/'.$idopcion.'/'.$lote) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="device_info" id='device_info'>
                @include('comprobante.form.formmitigarobservarestibamoca')
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
    <script src="{{ asset('public/js/file/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('public/js/file/fileinput.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/file/locales/es.js') }}" type="text/javascript"></script>


    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();

        $('.cuentanumero').on('keypress', function (e) {
            // Permitir solo números (0-9)
            var charCode = e.which ? e.which : e.keyCode;
            if (charCode < 48 || charCode > 57) {
                e.preventDefault(); // Evita que se inserten caracteres no válidos
            }
        });

        // Opcional: evitar pegar texto que no sea numérico
        $('.cuentanumero').on('paste', function (e) {
            var pasteData = e.originalEvent.clipboardData.getData('text');
            if (!/^\d+$/.test(pasteData)) {
                e.preventDefault(); // Evita que se peguen caracteres no válidos
            }
        });


        
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
            
           $('#file-otros').fileinput({
              theme: 'fa5',
              language: 'es',
            });
    </script>

        <script type="text/javascript">    

      $('#file-otros').fileinput({
        theme: 'fa5',
        language: 'es',
      });

          @foreach($archivospdf as $index => $item)
            var nombre_archivo = '{{$item->NOMBRE_ARCHIVO}}';
            $('#file-'+{{$index}}).fileinput({
              theme: 'fa5',
              language: 'es',
              initialPreview: ["{{ route('serve-fileliquidacioncompraanticipo', ['file' => '']) }}" + nombre_archivo],
              initialPreviewAsData: true,
              initialPreviewFileType: 'pdf',
              initialPreviewConfig: [
                  {type: "pdf", caption: nombre_archivo, downloadUrl: "{{ route('serve-fileliquidacioncompraanticipo', ['file' => '']) }}" + nombre_archivo} // Para mostrar el botón de descarga
              ]
            });
          @endforeach


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


  <script src="{{ asset('public/js/comprobante/uc.js?v='.$version) }}" type="text/javascript"></script>

@stop