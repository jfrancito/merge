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

<div class="be-content registrocomprobanteuc">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">


      <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">Revision de Comprobante ({{$ordencompra->COD_ORDEN}})</div>
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
                          <form method="POST" id='formpedido' action="{{ url('/aprobar-comprobante-uc/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <input type="hidden" name="device_info" id='device_info'>

                            @include('comprobante.form.formaprobar')
                          </form>
                        </div>
                      </div>

                </div>
                <div id="observar" class="tab-pane cont">
                    <div class="panel panel-default panel-border-color panel-border-color-primary">
                      <div class="panel-heading panel-heading-divider">Observar Comprobante<span class="panel-subtitle">Observar un Comprobante</span></div>
                      <div class="panel-body">

                              <form method="POST" id='formpedidoobservar' action="{{ url('/agregar-observacion-uc/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                                    {{ csrf_field() }}
                                <input type="hidden" name="device_info" id='device_info'>

                                @include('comprobante.form.formobservaruc')
                              </form>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    @include('comprobante.modal.mmodificararchivo')
    @include('comprobante.modal.mregistrorequerimiento')

    @include('usuario.modal.musuario')

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


    <script src="{{ asset('public/js/file/fileinput.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/file/locales/es.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/general.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}" type="text/javascript"></script>
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

      <script src="{{ asset('public/js/general/inputmask/inputmask.js') }}" type="text/javascript"></script> 
      <script src="{{ asset('public/js/general/inputmask/inputmask.extensions.js') }}" type="text/javascript"></script> 
      <script src="{{ asset('public/js/general/inputmask/inputmask.numeric.extensions.js') }}" type="text/javascript"></script> 
      <script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script> 
      <script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>


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
        $('form').parsley();

        $(document).on('click', '.modificar-pdf', function(e) {
            e.preventDefault();
            var tipo = $(this).data('tipo');
            var nombre = $(this).data('nombre');
            $('#modal-tipo-archivo').val(tipo);
            $('#modal-descripcion-archivo').val(nombre);
            $('#modal-modificar-archivo').niftyModal('show');
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


    </script>


  <script src="{{ asset('public/js/comprobante/uc.js?v='.$version) }}" type="text/javascript"></script>

@stop
