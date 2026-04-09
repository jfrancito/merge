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

                 @if(Session::get('usuario')->rol_id == '1CIX00000001' || 
                    Session::get('usuario')->id == '1CIX00000173' || 
                    Session::get('usuario')->id == '1CIX00000442' ||
                    Session::get('usuario')->id == '1CIX00000167'

                    )
                <div class="row">
                    <div class="col-md-4">
                        <div class="btn-toolbar">
                            <div role="group" class="btn-group btn-group-justified btn-space">
                                @if(Session::get('usuario')->rol_id == '1CIX00000001' || Session::get('usuario')->id == '1CIX00000173' || Session::get('usuario')->id == '1CIX00000167')
                                <a href="{{ url('/actualizar-data/BE') }}" class="btn btn-primary btn_actualizar_data">DATA BE</a>
                                @endif
                                @if(Session::get('usuario')->rol_id == '1CIX00000001' || Session::get('usuario')->id == '1CIX00000442')
                                <a href="{{ url('/actualizar-data/RI') }}" class="btn btn-primary btn_actualizar_data" >DATA RI</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif


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

@if(trim(Session::get('usuario')->rol_id) != '1CIX00000024')
<!-- Modal de Aviso Importante - Ultra Professional Edition (EXACT TEXT) -->
<div class="modal fade" id="modalAnuncioImportante" tabindex="-1" role="dialog" aria-labelledby="modalAnuncioImportanteLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index: 9999;">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 950px;">
        <div class="modal-content shadow-premium border-0" style="border-radius: 20px; overflow: hidden; background: #ffffff;">
            
            <div class="modal-header header-gradient text-white p-4" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); border: none;">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="m-0 font-weight-bold" style="font-size: 20px; letter-spacing: -0.5px; color: #ffffff !important;">Nueva Funcionalidad: Planilla de Movilidad</h3>
                        <p class="m-0 small opacity-80" style="color: #ffffff !important; opacity: 0.9 !important;">Integración con Liquidación de Gastos</p>
                    </div>
                </div>
                <button type="button" class="btn btn-confirm" data-dismiss="modal" aira-label="Close" style="background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; font-weight: 700; padding: 10px 20px; font-size: 14px; outline: none; transition: all 0.3s; margin-top: -5px;">
                    <span>ENTENDIDO, IR AL SISTEMA</span>
                    <i class="fa fa-arrow-right ml-2"></i>
                </button>
            </div>


            <div class="modal-body p-0" style="background: #fafbfc;">
                

                <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
                    <video controls style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;">
                        <source src="{{ asset('public/videos/video_planilla.mp4') }}" type="video/mp4">
                        Tu navegador no soporta la reproducción de videos.
                    </video>
                </div>

                <div class="p-5">
                    <div class="premium-card border-accent-blue" style="border-top: 4px solid #3b82f6; background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                        <h5 class="font-weight-bold text-dark mb-3" style="display: flex; align-items: center;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #3b82f6; margin-right: 12px;"></span>
                            ¿De qué trata esta actualización?
                        </h5>
                        <p class="text-muted text-justify" style="font-size: 15px; line-height: 1.7; color: #475569;">
                            <b>COMUNICADO:</b> Las planillas de movilidad que se generen desde el 1ero de Abril del 2026 estarán bajo esta nueva forma de <b>integrar automáticamente la Planilla de Movilidad a tus Liquidaciones de Gastos</b>. Este proceso optimizado permite vincular los gastos por movilidad local de manera directa, asegurando mayor precisión y rapidez en tus registros administrativos. 
                            Tomar en cuenta que las planillas de movilidad generadas al 31 de Marzo del 2026 se mantienen en cargar con la planilla de movilidad consolidada.
                        </p>
                        
                        <div class="mt-4 p-3 rounded" style="background: #f0f4ff; border: 1px solid #d9e2ff; color: #3f51b5; font-size: 13.5px; display: flex; align-items: flex-start;">
                            <i class="fa fa-lightbulb-o mr-2" style="font-size: 18px; margin-top: 2px;"></i>
                            <span><b>Tip:</b> Mira el video completo para aprender a utilizar esta herramienta y optimizar tus tiempos de rendición.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 p-4 bg-white">
                <button type="button" class="btn btn-confirm w-100 py-3" data-dismiss="modal" style="background: #1e293b; color: white; border-radius: 12px; font-weight: 700; letter-spacing: 0.5px; transition: all 0.3s;">
                    <span>ENTENDIDO, CONTINUAR AL SISTEMA</span>
                    <i class="fa fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</div> 


<style>
    /* Premium Design Tokens */
    .header-gradient {
        position: relative;
        overflow: hidden;
    }
    .header-gradient::after {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
    }
    
    .icon-box-header {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        backdrop-filter: blur(5px);
    }
    
    .shadow-premium {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .alert-soft-indigo {
        background-color: #f0f4ff;
        border: 1px solid #d9e2ff;
        color: #3f51b5;
        border-radius: 12px;
    }
    
    .premium-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s, box-shadow 0.2s;
        margin-bottom: 10px;
    }
    .premium-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .card-title-group {
        display: flex;
        align-items: center;
    }
    .dot-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 12px;
    }
    
    .bg-blue { background-color: #3b82f6; }
    .bg-amber { background-color: #f59e0b; }
    .bg-emerald { background-color: #10b981; }
    .bg-indigo { background-color: #6366f1; }
    
    .border-accent-blue { border-top: 4px solid #3b82f6; }
    .border-accent-amber { border-top: 4px solid #f59e0b; }
    .border-accent-emerald { border-top: 4px solid #10b981; }
    .border-accent-indigo { border-top: 4px solid #6366f1; }
    
    .card-content p {
        font-size: 14.5px;
        color: #475569;
        line-height: 1.6;
        margin-bottom: 0;
    }
    
    .time-list {
        list-style: none;
        padding: 0;
        margin: 10px 0;
    }
    .time-list li {
        font-size: 14px;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }
    .time-list li i { margin-right: 10px; font-size: 12px; }
    
    .exception-box {
        background: #fff;
        border: 1px solid #3b82f620;
        padding: 10px;
        border-radius: 8px;
    }
    .text-blue { color: #2563eb; }
    
    .day-badge {
        padding: 6px 16px;
        background: #fff8e1;
        border: 1px solid #ffe082;
        color: #ef6c00;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .small-reason {
        font-size: 12px;
        color: #64748b;
        position: relative;
        padding-left: 15px;
        margin-bottom: 4px;
    }
    .small-reason::before {
        content: "•";
        position: absolute;
        left: 0;
        color: #f59e0b;
    }
    
    .warning-modern {
        background: #fff1f2;
        padding: 12px;
        border-radius: 10px;
        font-size: 13px;
        color: #991b1b;
        display: flex;
        align-items: center;
        border: 1px solid #fecaca;
    }
    
    .sire-box {
        padding: 10px;
        background: #f1f5f9;
        border-radius: 8px;
        color: #1e293b;
        text-align: center;
    }
    
    .bg-danger-soft { background-color: #fef2f2; }
    .border-left-danger { border-left: 4px solid #ef4444 !important; }
    
    .section-divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .section-divider::before, .section-divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #e2e8f0;
    }
    .section-divider span { padding: 0 15px; }
    
    .modern-table-container {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        background: white;
    }
    .table-custom thead {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-custom th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        padding: 12px 0;
        border: none;
    }
    .table-custom td {
        padding: 15px 0;
        font-size: 13px;
        border: none;
    }
    .month-col { padding-left: 20px !important; text-align: left !important; }
    
    .btn-confirm {
        background: #1e293b;
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .btn-confirm:hover {
        background: #0f172a;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.3);
        color: white;
    }
    .opacity-60 { opacity: 0.6; }
    .opacity-80 { opacity: 0.8; }
    
    /* Scrollbar Styling */
    #modalAnuncioImportante .modal-body::-webkit-scrollbar { width: 6px; }
    #modalAnuncioImportante .modal-body::-webkit-scrollbar-track { background: #fafbfc; }
    #modalAnuncioImportante .modal-body::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    #modalAnuncioImportante .modal-body::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endif




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
        setTimeout(function() {
            if ($('#modalListaNegra').length > 0) {
                $('#modalListaNegra').modal('show');
                
                @if(trim(Session::get('usuario')->rol_id) != '1CIX00000024')
                    // Esperar a que se cierre el primero para mostrar el segundo
                    $('#modalListaNegra').on('hidden.bs.modal', function () {
                        $('#modalAnuncioImportante').modal('show');
                    });
                @endif
            } else {
                @if(trim(Session::get('usuario')->rol_id) != '1CIX00000024')
                    $('#modalAnuncioImportante').modal('show');
                @endif
            }
        }, 1000);
        
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
        // Forzar cierre de modalAnuncioImportante
        $(document).on('click', '#modalAnuncioImportante .close, #modalAnuncioImportante .btn-confirm', function() {
            $('#modalAnuncioImportante').modal('hide');
        });

        // Detener video al cerrar el modal
        $('#modalAnuncioImportante').on('hidden.bs.modal', function () {
            var video = $(this).find('video')[0];
            if (video) {
                video.pause();
                video.currentTime = 0;
            }
        });

    });
</script>

  <script src="{{ asset('public/js/user/proveedor.js?v='.$version) }}" type="text/javascript"></script>

@stop

