@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
@stop
@section('section')
  <div class="be-content contenido valerendir">
    <div class="main-content container-fluid">
      <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-border-color panel-border-color-success">
                <div class="panel-heading">{{ $titulo }}

                  <div class="tools tooltiptop">
                      <div class="dropdown">

                          <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones buscardocumento">
                            <span class="tooltiptext">Buscar Documento</span>
                            <span class="icon mdi mdi-search"></span>
                          </a>

                          <span class="icon mdi mdi-more-vert dropdown-toggle" id="menudespacho"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></span>

                          <ul class="dropdown-menu" aria-labelledby="menudespacho"
                              style="margin: 7px -169px 0;">
                              <li>
                             {{--   <a href="{{url('/comprobante-masivo-excel-lg')}}" 
                                   class='tn btn-secondary botoncabecera tooltipcss opciones'
                                   target="_blank"
                                   id="descargarcomprobantemasivoexcel" 
                                   data-href="{{url('/comprobante-masivo-excel-lg')}}"
                                   title="Descargar excel" style="width:100%">
                                   <span class="tooltiptext">Descargar excel Contabilidada</span>
                                   Descargar excel Contabilidada
                                </a> --}}
                              </li>
                          </ul>
                      </div>
                  </div>



                </div>

                <div class="panel-body">
                  <div class='filtrotabla row'>

                          <div class="col-xs-12">

                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">
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

                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">
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

                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">

                                <div class="form-group">
                                  <label class="col-sm-12 control-label labelleft" >Proveedor :</label>
                                  <div class="col-sm-12 abajocaja" >
                                   
                                  </div>
                                </div>
                            </div> 

                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">

                                <div class="form-group">
                                  <label class="col-sm-12 control-label labelleft" >Estados :</label>
                                  <div class="col-sm-12 abajocaja" >
                                     {!! Form::select(
                                                      'estado_id',
                                                      $combo_estado,
                                                      $estado_id,  // Valor seleccionado por defecto
                                                      [
                                                          'class'       => 'select2 form-control control input-sm',
                                                          'id'          => 'estado_id',
                                                          'required'    => '',
                                                          'data-aw'     => '1',
                                                      ]
                                                  ) !!} 
                                  </div>
                                </div>
                            </div> 


                          </div>


                    <div class="col-xs-12">
                      <input type="hidden" name="idopcion" id='idopcion' value='{{$idopcion}}'>
                    </div>
                  </div>
                  <div class='listajax'>
                    @include('valerendir.gestion.alistavalesrendiradmin') 
                  </div>
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
      App.dataTables();
      $('[data-toggle="tooltip"]').tooltip();
      $('form').parsley();

    });
  </script>
   <script src="{{ asset('public/js/vale/gestionvalerendir.js?v='.$version) }}" type="text/javascript"></script>
@stop

