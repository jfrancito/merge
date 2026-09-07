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

@php
    $fechas_cierre = [
        [
            'mes' => 'SETIEMBRE',
            'anio' => '2026',
            'fecha' => '30/09/2026',
            'fecha_comparar' => '2026-09-30',
            'border' => 'border-left-blue',
            'text_color' => '#2563eb'
        ],
        [
            'mes' => 'OCTUBRE',
            'anio' => '2026',
            'fecha' => '31/10/2026',
            'fecha_comparar' => '2026-10-31',
            'border' => 'border-left-indigo',
            'text_color' => '#4f46e5'
        ],
        [
            'mes' => 'NOVIEMBRE',
            'anio' => '2026',
            'fecha' => '30/11/2026',
            'fecha_comparar' => '2026-11-30',
            'border' => 'border-left-purple',
            'text_color' => '#7c3aed'
        ],
        [
            'mes' => 'DICIEMBRE',
            'anio' => '2026',
            'fecha' => '02/01/2026',
            'fecha_comparar' => '2027-01-02',
            'border' => 'border-left-emerald',
            'text_color' => '#059669'
        ],
    ];

    $hoy = date('Y-m-d');
    $limite_pasado = date('Y-m-d', strtotime('-2 days'));

    $cierres_mostrar = [];
    foreach ($fechas_cierre as $item) {
        if ($item['fecha_comparar'] >= $limite_pasado) {
            $cierres_mostrar[] = $item;
        }
    }
    // Tomar los 2 meses más próximos
    $cierres_mostrar = array_slice($cierres_mostrar, 0, 2);
@endphp

@if(trim(Session::get('usuario')->rol_id) != '1CIX00000024' && count($cierres_mostrar) > 0)
<!-- Modal de Aviso de Cierres de Corte de Integración y Aprobación de Documentación de Compras -->
<div class="modal fade" id="modalAvisoCierre" tabindex="-1" role="dialog" aria-labelledby="modalAvisoCierreLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index: 9999;">
    <div class="modal-dialog modal-lg modal-dialog-centered responsive-modal-cierre" role="document">
        <div class="modal-content shadow-cierre border-0" style="border-radius: 18px; overflow: hidden; background: #ffffff;">
            
            <!-- Header -->
            <div class="modal-header header-cierre text-white p-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #2563eb 100%); border: none; position: relative;">
                <div class="d-flex align-items-center w-100 justify-content-between">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div class="icon-cierre-header">
                            <i class="fa fa-calendar-check-o" style="color: #fbbf24;"></i>
                        </div>
                        <div>
                            <span class="badge-aviso-tag">COMUNICADO OFICIAL</span>
                            <h3 class="m-0 font-weight-bold" style="font-size: 18px; letter-spacing: -0.3px; color: #ffffff !important; margin-top: 4px;">
                                Cierres de Corte de Integración y Aprobación
                            </h3>
                            <p class="m-0 small" style="color: #cbd5e1 !important; font-size: 13px; margin-top: 2px;">
                                Fechas límites para documentación de compras
                            </p>
                        </div>
                    </div>
                    <button type="button" class="close text-white d-none d-sm-block" data-dismiss="modal" aria-label="Close" style="opacity: 0.85; text-shadow: none; font-size: 28px; outline: none; margin-top: -10px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body p-4" style="background: #f8fafc;">
                
                <!-- Info banner -->
                <div class="alert-cierre-intro mb-3">
                    <div class="d-flex align-items-start" style="gap: 12px;">
                        <i class="fa fa-info-circle text-primary mt-1" style="font-size: 20px; min-width: 20px;"></i>
                        <div style="font-size: 13.5px; color: #334155; line-height: 1.55;">
                            Estimado usuario, se hace de su conocimiento los días de <strong>cierre de corte de integración</strong> y de <strong>aprobación de documentación de compras</strong> para los meses próximos:
                        </div>
                    </div>
                </div>

                <!-- Grid of dates -->
                <div class="row" style="margin-left: -8px; margin-right: -8px;">
                    @foreach($cierres_mostrar as $cierre)
                    <div class="{{ count($cierres_mostrar) == 1 ? 'col-md-12 col-sm-12 col-xs-12' : 'col-md-6 col-sm-6 col-xs-12' }} mb-3" style="padding-left: 8px; padding-right: 8px;">
                        <div class="cierre-card {{ $cierre['border'] }}">
                            <div class="cierre-card-header">
                                <div class="cierre-month">
                                    <i class="fa fa-calendar-o mr-2" style="color: {{ $cierre['text_color'] }};"></i>
                                    <span>{{ $cierre['mes'] }}</span>
                                </div>
                                <span class="cierre-badge-year">{{ $cierre['anio'] }}</span>
                            </div>
                            <div class="cierre-card-body">
                                <div class="cierre-date-label">Fecha de corte:</div>
                                <div class="cierre-date-value">
                                    <i class="fa fa-clock-o mr-1" style="color: {{ $cierre['text_color'] }};"></i> {{ $cierre['fecha'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Callout warning -->
                <div class="warning-cierre-box mt-1">
                    <i class="fa fa-exclamation-triangle" style="font-size: 18px; color: #d97706; margin-right: 10px; min-width: 18px;"></i>
                    <span style="font-size: 12.5px; color: #92400e; line-height: 1.45;">
                        <strong>Recomendación:</strong> Por favor gestionar y aprobar todos sus comprobantes y liquidaciones antes de cada fecha de corte para evitar observaciones o retrasos en los procesos administrativos.
                    </span>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 p-3 bg-white" style="text-align: center; display: flex; justify-content: center;">
                <button type="button" class="btn btn-cierre-action px-5 py-2" data-dismiss="modal" style="min-width: 220px;">
                    <i class="fa fa-check-circle mr-1"></i> ENTENDIDO, CONTINUAR
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .responsive-modal-cierre {
        max-width: 720px;
        margin: 2rem auto;
    }

    .shadow-cierre {
        box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.35);
    }

    .icon-cierre-header {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        backdrop-filter: blur(4px);
    }

    .badge-aviso-tag {
        display: inline-block;
        padding: 2px 10px;
        background: rgba(251, 191, 36, 0.2);
        border: 1px solid rgba(251, 191, 36, 0.4);
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        color: #fde047;
        letter-spacing: 0.5px;
    }

    .alert-cierre-intro {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .cierre-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 14px 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.03);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .cierre-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.07);
    }

    .border-left-blue { border-left: 5px solid #2563eb !important; }
    .border-left-indigo { border-left: 5px solid #4f46e5 !important; }
    .border-left-purple { border-left: 5px solid #7c3aed !important; }
    .border-left-emerald { border-left: 5px solid #059669 !important; }

    .cierre-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        padding-bottom: 6px;
        border-bottom: 1px dashed #e2e8f0;
    }

    .cierre-month {
        font-weight: 700;
        font-size: 14px;
        color: #1e293b;
        display: flex;
        align-items: center;
    }

    .cierre-badge-year {
        background: #f1f5f9;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 6px;
    }

    .cierre-date-label {
        font-size: 11.5px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .cierre-date-value {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 2px;
        letter-spacing: -0.3px;
    }

    .warning-cierre-box {
        background: #fffbeb;
        border: 1px solid #fef3c7;
        border-radius: 10px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
    }

    .btn-cierre-action {
        background: linear-gradient(135deg, #1d3a6d 0%, #2563eb 100%);
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-cierre-action:hover {
        background: linear-gradient(135deg, #162b50 0%, #1d4ed8 100%);
        transform: translateY(-1.5px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.45);
        color: #ffffff !important;
    }
    .btn-cierre-action:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .responsive-modal-cierre {
            max-width: 95% !important;
            margin: 10px auto !important;
        }
        .modal-header h3 {
            font-size: 16px !important;
        }
        .cierre-date-value {
            font-size: 16px !important;
        }
    }
</style>
@endif

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
            var avisoCierreVisto = sessionStorage.getItem('aviso_cierre_compras_visto');

            if ($('#modalListaNegra').length > 0) {
                $('#modalListaNegra').modal('show');
                
                @if(trim(Session::get('usuario')->rol_id) != '1CIX00000024' && count($cierres_mostrar) > 0)
                    if (!avisoCierreVisto) {
                        // Esperar a que se cierre el primero para mostrar el aviso de cierre
                        $('#modalListaNegra').on('hidden.bs.modal', function () {
                            $('#modalAvisoCierre').modal('show');
                            sessionStorage.setItem('aviso_cierre_compras_visto', 'true');
                        });
                    }
                @endif
            } else {
                @if(trim(Session::get('usuario')->rol_id) != '1CIX00000024' && count($cierres_mostrar) > 0)
                    if (!avisoCierreVisto) {
                        $('#modalAvisoCierre').modal('show');
                        sessionStorage.setItem('aviso_cierre_compras_visto', 'true');
                    }
                @endif
            }
        }, 1000);
        
        // Funcionalidad de búsqueda en modalListaNegra
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

        // Forzar cierre de modalAvisoCierre
        $(document).on('click', '#modalAvisoCierre [data-dismiss="modal"]', function() {
            $('#modalAvisoCierre').modal('hide');
        });

    });
</script>

  <script src="{{ asset('public/js/user/proveedor.js?v='.$version) }}" type="text/javascript"></script>

@stop

