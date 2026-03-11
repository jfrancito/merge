@extends('template_lateral')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/file/fileinput.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/mergeantigravity.css?v='.$version) }} " />
@stop
@section('section')
<div class="be-content contratoacopio">
  <div class="main-content container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary modern-panel">
          <div class="panel-heading panel-heading-divider">
            <div class="title-container">
                <span class="main-title">CONTRATO ACOPIO</span>
                <span class="panel-subtitle">Registro de nuevo contrato de acopio para proveedores de materia prima</span>
            </div>
            <div class="header-actions">
                <span class="badge badge-primary">ID: {{$idopcion}}</span>
            </div>
          </div>
          <div class="panel-body">
            <form method="POST" action="{{ url('/agregar-contrato-acopio/'.$idopcion) }}" class="form-horizontal modern-form" id='frmpm' enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <input type="hidden" name="device_info" id='device_info'>

                  <div class='form-wrapper'>
                    @include('contratoacopio.form.facontratoacopio')
                    
                    <div class="form-footer">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="footer-info">
                                    <i class="bi bi-info-circle"></i> Todos los campos marcados con (*) son obligatorios.
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 text-right">
                                <a href="{{ url('/gestion-de-contrato-acopio/'.$idopcion) }}" class="btn btn-space btn-default btn-xl">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-space btn-primary btn-xl btnguardar">
                                    <i class="bi bi-check-circle"></i> Guardar Contrato
                                </button>     
                            </div>
                        </div>
                    </div>
                  </div>
            </form>
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
        //initialize the javascript
        App.init();
        App.formElements();

        /*$('.select2').select2({
            width: '100%',
            placeholder: 'Seleccione una opción',
            language: "es"
        });*/

        $('#empresa_id').select2({
            // Activamos la opcion "Tags" del plugin
            width: '100%',
            placeholder: 'Seleccione una empresa',
            language: "es",
            tags: true,
            tokenSeparators: [','],
            ajax: {
                dataType: 'json',
                url: '{{ url("buscarempresacontrato") }}',
                delay: 100,
                data: function(params) {
                    return {
                        term: params.term
                    }
                },
                processResults: function (data, page) {
                  return {
                    results: data
                  };

                },
            }
        });

        // Inicializar Select2 general





        $('form').parsley();


        $('.importe').inputmask({ 'alias': 'numeric', 
        'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
        'digitsOptional': false, 
        'prefix': '', 
        'placeholder': '0'});


        
      });
    </script> 

    <script type="text/javascript">
        @foreach($tarchivos as $index => $item) 
            var extension = 'PDF';
            $('#file-{{$item->COD_CATEGORIA}}').fileinput({
              theme: 'fa5',
              language: 'es',
              allowedFileExtensions: [extension],
            });


        @endforeach
    </script>


    <script src="{{ asset('public/js/comprobante/contratoacopio.js?v='.$version) }}" type="text/javascript"></script>


@stop