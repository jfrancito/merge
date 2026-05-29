@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <style>
        .panel-border-color-success {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .panel-heading {
            background: #ffffff !important;
            color: #0f172a !important;
            font-weight: 700 !important;
            letter-spacing: -0.5px;
            padding: 24px 30px !important;
            font-size: 22px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-agregar-activo {
            background-color: #64748b !important; /* Color más bajo / sutil */
            border: none !important;
            color: #fff !important;
            border-radius: 6px !important;
            padding: 8px 20px !important;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px rgba(100, 116, 139, 0.2);
        }
        .btn-agregar-activo:hover {
            background-color: #475569 !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(71, 85, 105, 0.3);
        }
        
        /* Unified Filter and Search Container */
        .premium-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f8fafc;
            padding: 15px 25px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 15px;
            border-radius: 8px;
            width: 100%;
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .premium-filter-label {
            font-weight: 600;
            color: #475569;
            font-size: 14px;
            margin: 0;
        }

        .premium-filter-input {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 14px;
            color: #1e293b;
            background: #fff;
            outline: none;
            transition: all 0.2s;
            width: 160px;
        }

        .premium-filter-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        /* Override DataTables default search */
        .dataTables_filter {
            float: none !important;
            text-align: right;
            margin: 0 !important;
        }
        
        .dataTables_filter input {
            border: 1px solid #cbd5e1 !important;
            border-radius: 6px !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
            color: #1e293b !important;
            background: #fff !important;
            width: 250px !important;
            margin-left: 10px !important;
        }
        
        .dataTables_filter input:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
            outline: none !important;
        }
    </style>
@stop
@section('section')
  <div class="be-content contenido activofijo">
    <div class="main-content container-fluid">
      <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-border-color panel-border-color-success">
                <div class="panel-heading">Gestión de Obras
                  <div class="tools">
                      <a href="#" class="btn btn-agregar-activo">
                        <i class="icon mdi mdi-plus-circle"></i> Agregar Obra
                      </a>
                  </div>
                </div>

                <div class="panel-body">
                  <div class="col-xs-12">
                    <input type="hidden" name="idopcion" id='idopcion' value='{{$idopcion}}'>
                  </div>
                  <div class='listajax'>
                  </div>

                  <!-- Modal de Formulario -->
                  <div id="modal-formulario-activo" class="modal-container colored-header colored-header-primary modal-effect-8">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
                              <h3 class="modal-title">FORMULARIO DE OBRA</h3>
                          </div>
                          <div class="modal-body modal-formulario-activo-container">
                              @include('activofijo.modal.ajax.mformulario')
                          </div>
                          <div class="modal-footer">
                              <button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancelar</button>
                              <button type="button" class="btn btn-success btn-guardar-activo">Guardar</button>
                          </div>
                      </div>
                  </div>
                  <div class="modal-overlay"></div>

                </div>
              </div>
            </div>
          </div>
    </div>
  </div>

@stop
@section('script')

  <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js?v=5') }}" type="text/javascript"></script>
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
      App.init();
      App.formElements();
      $('[data-toggle="tooltip"]').tooltip();
      $('form').parsley();
    });
  </script>
  <script src="{{ asset('public/js/activofijo/activofijo.js?v='.time()) }}" type="text/javascript"></script>
@stop
