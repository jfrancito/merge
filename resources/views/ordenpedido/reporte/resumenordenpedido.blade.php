@extends('template_lateral')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }}"/>
    <style>
        /* Ajuste para tabla grande */
        .table-responsive {
            overflow-x: auto;
        }

        .cajareporte {
            padding-bottom: 15px;
        }

        .filtrotabla .form-group {
            margin-bottom: 0;
        }

        .panel-heading .tools {
            float: right;
        }
    </style>
@stop

@section('section')
<div class="be-content contenido ordenpedido">
    <div class="main-content container-fluid">
        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-border-color panel-border-color-success">
                    <div class="panel-heading">
                        {{ $titulo }}
                      <div class="tools tooltiptop">
                      <div class="dropdown">

                          <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones buscarpedidoresumen">
                            <span class="tooltiptext">Buscar Pedido</span>
                            <span class="icon mdi mdi-search"></span>
                          </a>

                          <span class="icon mdi mdi-more-vert dropdown-toggle" id="menudespacho"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></span>

                          <ul class="dropdown-menu" aria-labelledby="menudespacho"
                              style="margin: 7px -169px 0;">
                              <li>
                                <a href="{{url('/resumen-masivo-excel-op')}}" 
                                   class='tn btn-secondary botoncabecera tooltipcss opciones'
                                   target="_blank"
                                   id="descargarresumenmasivoexcelop" 
                                   data-href="{{url('/resumen-masivo-excel-op')}}"
                                   title="Descargar excel" style="width:100%">
                                   <span class="tooltiptext">Descargar excel Orden</span>
                                   Descargar excel pedido
                                </a>
                              </li>
                          </ul>
                      </div>
                  </div>

                </div>
                    <div class="panel-body">
                        {{-- FILTROS --}}
                        <div class="row filtrotabla">
                            <div class="col-xs-12 col-md-3 cajareporte">
                                <label class="control-label">Empresa:</label>
                                {!! Form::select('empresa_id', $combo_empresa, $empresa_id, ['class'=>'select2 form-control input-sm','id'=>'empresa_id']) !!}
                            </div>

                           <div class="col-xs-12 col-md-1 cajareporte">
                                <label class="control-label">Centro:</label>
                                {!! Form::select('centro_pedido', $combo_centro, $centro_pedido, ['class'=>'select2 form-control input-sm','id'=>'centro_pedido']) !!}
                            </div>

                            <div class="col-xs-12 col-md-2 cajareporte">
                                <label class="control-label">Área:</label>
                                {!! Form::select('area', $combo_area, $area, ['class'=>'select2 form-control input-sm','id'=>'area']) !!}
                            </div>

                            <div class="col-xs-12 col-md-3 cajareporte">
                                <div class="form-group ">
                                  <label class="col-sm-12 control-label labelleft" >Fecha Inicio:</label>
                                  <div class="col-sm-12 abajocaja" >
                                    <div data-min-view="2" 
                                           data-date-format="dd-mm-yyyy"  
                                           class="input-group date datetimepicker pickerfecha" style = 'padding: 0px 0;margin-top: -3px;'>
                                           <input size="16" type="text" 
                                                  value="{{$fecha_inicio}}" 
                                                  placeholder="Fecha Inicio"
                                                  id='fecha_inicio' 
                                                  name='fecha_inicio' 
                                                  required = ""
                                                  class="form-control input-sm"/>
                                            <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                                      </div>
                                  </div>
                                </div>
                            </div> 

                              <div class="col-xs-12 col-md-3 cajareporte">
                              <div class="form-group ">
                                <label class="col-sm-12 control-label labelleft" >Fecha Fin:</label>
                                <div class="col-sm-12 abajocaja" >
                                  <div data-min-view="2" 
                                         data-date-format="dd-mm-yyyy"  
                                         class="input-group date datetimepicker pickerfecha" style = 'padding: 0px 0;margin-top: -3px;'>
                                         <input size="16" type="text" 
                                                value="{{$fecha_fin}}" 
                                                placeholder="Fecha Fin"
                                                id='fecha_fin' 
                                                name='fecha_fin' 
                                                required = ""
                                                class="form-control input-sm"/>
                                          <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                              </div>
                            </div>

                            <input type="hidden" name="idopcion" id="idopcion" value="{{ $idopcion }}">
                        </div>

                        {{-- TABLA --}}
                        <div class="table-responsive listajax" style="margin-top: 20px;">
                            @if(isset($ajax) && $ajax)
                                @include('ordenpedido.reporte.alistaresumenordenpedido')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- MODAL DETALLE -->
    <div id="modal-detalle-pedido-resumen" class="modal-container colored-header colored-header-primary modal-effect-8">
        <div class="modal-content ">
            <div class='modal-detalle-pedido-container'>
            </div>
        </div>
    </div>
    <div class="modal-overlay"></div>

    <style>
        #modal-detalle-pedido-resumen {
            width: 95%;
            max-width: 1200px;
            margin: auto;
        }
        #modal-detalle-pedido-resumen .modal-content {
            border-radius: 14px;
            overflow: hidden;
        }
    </style>

@stop

@section('script')

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

        $.fn.niftyModal('setDefaults', {
            overlaySelector: '.modal-overlay',
            closeSelector: '.modal-close',
            classAddAfterOpen: 'modal-show',
        });
    </script>
    

    <script type="text/javascript">

        $(document).ready(function () {
            App.init();
            App.formElements();
            App.dataTables();
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


    <script src="{{ asset('public/js/ordenpedido/ordenpedido.js?v='.$version) }}" type="text/javascript"></script>
@stop
