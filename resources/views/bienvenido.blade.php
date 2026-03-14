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
            
            <!-- Elegant Modern Header -->
            <div class="modal-header border-0 p-0">
                <div class="w-100 p-5 text-white header-gradient">

                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-box-header mr-3">
                            <i class="fa fa-info-circle"></i>
                        </div>
                        <h1 class="modal-title font-weight-bolder m-0" id="modalAnuncioImportanteLabel" style="letter-spacing: -0.5px; font-size: 30px;">
                            CONSIDERACIONES.
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Scrollable Body with EXACT User Text -->
            <div class="modal-body p-0" style="max-height: 72vh; overflow-y: auto; background: #fafbfc;">
                
                <div class="p-5">
                    
                    <!-- Card 1 -->
                    <div class="premium-card mb-4 border-accent-blue">
                        <div class="card-title-group">
                            <div class="dot-indicator bg-blue"></div>
                            <h5 class="m-0 font-weight-bold">1. Tiempos de Revisión</h5>
                        </div>
                        <div class="card-content mt-3">
                            <p class="text-justify">
                                El Tiempo de revisiones de las operaciones de compra, se inicia con la recepción por las áreas revisantes, 24 hr para el área de administración y luego 24 hr para el área de contabilidad. Hay excepciones de ciertas operaciones que amerita atención inmediata como son: Servicios de estiba y operaciones entre relacionadas.
                            </p>
                            <div class="status-tip mt-3 py-2 px-3 bg-light rounded-pill border">
                                <i class="fa fa-info-circle mr-1 text-blue"></i>
                                <span>Recordar que en Merge, opción: <b>"Seguimiento de documento"</b>, puede irse revisando el estado de las operaciones.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="premium-card mb-4 border-accent-amber">
                        <div class="card-title-group">
                            <div class="dot-indicator bg-amber"></div>
                            <h5 class="m-0 font-weight-bold">2. Operaciones Reparadas</h5>
                        </div>
                        <div class="card-content mt-3 text-justify">
                            <p>
                                Por las operaciones reparadas, que el usuario presenta documentos para levantar, serán revisadas por contabilidad los miércoles y sábados. Por la última semana del mes, se revisará hasta la fecha de corte del periodo.
                            </p>
                            <div class="bg-warning-light p-3 rounded mt-3 border">
                                <b class="text-warning-dark d-block mb-1">Se considera como reparaciones de las operaciones:</b>
                                <p class="m-0 small">
                                    Por Informes de servicios que aún no culminan sus procesos (siendo anticipos), no adjuntar Guías de remisión Transportistas físicas y en IACM por no adjuntar Guías de remisión por envío a zonas. De ahí todas las operaciones deben tener el sustento completo en Merge, caso contrario se observará.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="premium-card mb-4 border-accent-emerald">
                        <div class="card-title-group">
                            <div class="dot-indicator bg-emerald"></div>
                            <h5 class="m-0 font-weight-bold">3. Carga de Facturas y Gastos</h5>
                        </div>
                        <div class="card-content mt-3 text-justify">
                            <p>
                                Toda factura emitida debería ser cargada hasta el día siguiente, no se debe acumular operaciones, porque se acumula de forma indebida con otras que si corresponden. De los Últimos días del mes debe ser cargada en Merge hasta la fecha de corte de dicho periodo. Esto implica que coordinen con el proveedor el envío o registro de sus correos para la recepción automática. Tomar en cuenta que en el Merge, opción: Gestión Compras Sire, puede verse los comprobantes emitidos en el mes, por proveedor.
                            </p>
                            <div class="bg-danger-light p-3 rounded my-3 border-dashed-danger">
                                <p class="m-0 text-danger small">
                                    Todo gasto que genere la obligación de pagar debe ser cargado en el periodo que corresponde la operación, por lo tanto no se debe emitir el comprobante de pago, regularizando en los primeros días del mes siguiente. Adjunto Fecha de corte para el 2026.
                                </p>
                            </div>

                            <!-- Cutoff Table Integration -->
                            <div class="modern-table-container mt-4">
                                <div class="bg-navy text-white text-center py-2 font-weight-bold small" style="background: #0f172a;">
                                    FECHA DE CORTE POR PERIODO DEL EJERCICIO 2026
                                </div>
                                <table class="table table-custom m-0 table-sm">
                                    <thead>
                                        <tr style="background: #f1f5f9;">
                                            <th class="border-right">Febrero</th>
                                            <th class="border-right">Marzo</th>
                                            <th class="border-right">Abril</th>
                                            <th class="border-right">Mayo</th>
                                            <th class="border-right">Junio</th>
                                            <th class="border-right">Julio</th>
                                            <th class="border-right">Agosto</th>
                                            <th class="border-right">Setiembre</th>
                                            <th class="border-right">Octubre</th>
                                            <th class="border-right">Noviembre</th>
                                            <th>Diciembre</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        <tr class="font-weight-bold">
                                            <td class="border-right">2-Mar</td>
                                            <td class="border-right">1-Abr</td>
                                            <td class="border-right">2-May</td>
                                            <td class="border-right">2-Jun</td>
                                            <td class="border-right">2-Jul</td>
                                            <td class="border-right">3-Ago</td>
                                            <td class="border-right">2-Set</td>
                                            <td class="border-right">2-Oct</td>
                                            <td class="border-right">2-Nov</td>
                                            <td class="border-right">2-Dic</td>
                                            <td>2-Ene</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="premium-card mb-2 border-accent-indigo">
                        <div class="card-title-group">
                            <div class="dot-indicator bg-indigo"></div>
                            <h5 class="m-0 font-weight-bold">4. Gestión de Documentación</h5>
                        </div>
                        <div class="card-content mt-3 text-justify">
                            <p>
                                Los informes firmados de forma manual, y su documentación correspondiente, escaneados y cargados en Merge, no debe ser entregada a contabilidad de forma física, pero sí debe ser archivada por el área correspondiente como respaldo de sus operaciones. Excepto las Guías de remisión Transportistas Físicas que deben ser entregadas de forma obligatoria dentro del mes o hasta la fecha del corte.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Solid Minimal Footer -->
            <div class="modal-footer border-top p-4 bg-white justify-content-center">
                <button type="button" class="btn btn-confirm py-3 px-5" data-dismiss="modal">
                    <span>CONFIRMAR LECTURA</span>
                    <i class="fa fa-check-circle ml-2"></i>
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
    });
</script>

  <script src="{{ asset('public/js/user/proveedor.js?v='.$version) }}" type="text/javascript"></script>

@stop

