@extends('template_lateral')

@section('style')


    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/dashboard.css?v='.$version) }} " />
@stop

@section('section')
	<div class="be-content  contenido proveedor" style="height: 100vh;">
		<div class="main-content container-fluid">
			<div class='container'>
          <div class="row">
              @if(Session::get('usuario')->rol_id == '1CIX00000024')
                @include('usuario.proveedores')
              @else
                @include('usuario.administrativo')
              @endif
          </div>
			</div>
		</div>



@if(Session::has('listanegra'))
<div class="modal fade" id="modalListaNegra" tabindex="-1" role="dialog" aria-labelledby="modalListaNegraLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalListaNegraLabel">
                    <i class="fa fa-exclamation-triangle"></i> Alerta: Proveedores con Problemas SUNAT
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <strong>Atención:</strong> Los siguientes proveedores tienen problemas para descargar sus comprobantes desde SUNAT. 
                    Por favor, coordine con ellos antes de continuar con la liquidación.
                </div>
                
                <div class="form-group mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="buscarProveedor" placeholder="Buscar proveedor...">
                    </div>
                    <small class="form-text text-muted">
                        Total de proveedores: <span id="totalProveedores">{{ count(Session::get('listanegra')) }}</span>
                    </small>
                </div>

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-dark" >
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Proveedor</th>
                            </tr>
                        </thead>
                        <tbody id="tablaProveedores">
                            @foreach(Session::get('listanegra') as $index => $proveedor)
                            <tr class="fila-proveedor">
                                <td>{{ $index + 1 }}</td>
                                <td class="proveedor-nombre">{{ $proveedor->TXT_EMPRESA_PROVEEDOR }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div id="noResultados" class="alert alert-info mt-3" style="display: none;">
                    <i class="fa fa-info-circle"></i> No se encontraron proveedores con ese criterio de búsqueda.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>



@endif


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

      $('[data-toggle="tooltip"]').tooltip();
      $('form').parsley();

      $('.importe').inputmask({ 'alias': 'numeric', 
      'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 
      'digitsOptional': false, 
      'prefix': '', 
      'placeholder': '0'});

      $('.category-tab').on('click', function() {
          // Remover clases activas
          $('.nav-link').removeClass('active');
          $('.category-content').removeClass('active');
          
          // Agregar clases activas a la categoría seleccionada
          $(this).addClass('active');
          
          // Obtener el ID de la categoría
          var categoryId = $(this).data('category');
          
          // Mostrar el contenido de la categoría seleccionada
          $('#' + categoryId).addClass('active');
      });


    });




  </script>


<script>
    $(document).ready(function() {
        // Abrir modal automáticamente
        $('#modalListaNegra').modal('show');
        
        // Funcionalidad de búsqueda
        $('#buscarProveedor').on('keyup', function() {
            var valor = $(this).val().toLowerCase();
            var filasMostradas = 0;
            
            $('#tablaProveedores .fila-proveedor').each(function() {
                var proveedor = $(this).find('.proveedor-nombre').text().toLowerCase();
                var usuario = $(this).find('.usuario-autoriza').text().toLowerCase();
                
                // Buscar en nombre de proveedor y usuario autoriza
                if (proveedor.indexOf(valor) > -1 || usuario.indexOf(valor) > -1) {
                    $(this).show();
                    filasMostradas++;
                } else {
                    $(this).hide();
                }
            });
            
            // Actualizar contador
            $('#totalProveedores').text(filasMostradas);
            
            // Mostrar mensaje si no hay resultados
            if (filasMostradas === 0) {
                $('#noResultados').show();
            } else {
                $('#noResultados').hide();
            }
        });
    });
</script>

  <script src="{{ asset('public/js/user/proveedor.js?v='.$version) }}" type="text/javascript"></script>

@stop

