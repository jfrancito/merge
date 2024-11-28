@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/file/fileinput.css') }} "/>
@stop

@section('section')
<div class="be-content registrocomprobante hextorno">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-border-color panel-border-color-success">
                    <div class="panel-heading">{{ $titulo }} 
                            @include('comprobante.hextorno')
                    </div>
                    <div class="panel-body">
                      @include('comprobante.lista.detallecomprobanteadministradorcontrato')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('comprobante.modal.mregistrorequerimiento')

    @include('usuario.modal.musuario')

</div>


@stop

@section('script')


  <script src="{{ asset('public/js/general/inputmask/inputmask.js') }}" type="text/javascript"></script> 
  <script src="{{ asset('public/js/general/inputmask/inputmask.extensions.js') }}" type="text/javascript"></script> 
  <script src="{{ asset('public/js/general/inputmask/inputmask.numeric.extensions.js') }}" type="text/javascript"></script> 
  <script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script> 
  <script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>


  <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
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


    <script src="{{ asset('public/js/file/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('public/js/file/fileinput.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/file/locales/es.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/general.js') }}" type="text/javascript"></script>

   <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}" type="text/javascript"></script>



    <script type="text/javascript">

        $.fn.niftyModal('setDefaults',{
          overlaySelector: '.modal-overlay',
          closeSelector: '.modal-close',
          classAddAfterOpen: 'modal-show',
        });


        $(document).ready(function(){

          App.init();
          App.formElements();
          App.dataTables();
          $('[data-toggle="tooltip"]').tooltip();
          $('form').parsley();

        $('.importe').inputmask({ 'alias': 'numeric', 
        'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
        'digitsOptional': false, 
        'prefix': '', 
        'placeholder': '0'});

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

        @foreach($array_guias as $index => $item) 

            $("#file-{{$item['COD_DOCUMENTO_CTBLE']}}").fileinput({
              theme: 'fa5',
              language: 'es',
              allowedFileExtensions: ['pdf'],
            });

        @endforeach


    </script>
    <script src="{{ asset('public/js/comprobante/registro.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/comprobante/hextorno.js?v='.$version) }}" type="text/javascript"></script>
    
    
@stop

