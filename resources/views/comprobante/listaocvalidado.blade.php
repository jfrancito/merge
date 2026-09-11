@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <style>
        .mdi--file-excel {
            display: inline-block;
            width: 1.25em;
            height: 1.25em;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zm1.8 18H14l-2-3.4l-2 3.4H8.2l2.9-4.5L8.2 11H10l2 3.4l2-3.4h1.8l-2.9 4.5zM13 9V3.5L18.5 9z'/%3E%3C/svg%3E");
            background-color: #ffffff;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
            vertical-align: middle;
        }
        .btn-excel-premium {
            background: linear-gradient(135deg, #107c41 0%, #1f4e2e 100%) !important;
            border: 1px solid #107c41 !important;
            color: #ffffff !important;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(16, 124, 65, 0.3);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 34px;
            width: 38px;
            margin-left: 4px;
        }
        .btn-excel-premium:hover, .btn-excel-premium:focus {
            background: linear-gradient(135deg, #0c5e31 0%, #153922 100%) !important;
            box-shadow: 0 4px 10px rgba(16, 124, 65, 0.45);
            transform: translateY(-1px);
            color: #ffffff !important;
        }
        .btn-excel-premium .tooltiptext {
            width: auto !important;
            white-space: nowrap !important;
            padding: 6px 12px !important;
            left: 50% !important;
            top: 125% !important;
            bottom: auto !important;
            transform: translateX(-50%) !important;
            margin-left: 0 !important;
            background-color: #1f2937 !important;
            color: #ffffff !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            border-radius: 4px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25) !important;
            line-height: 1.2 !important;
            letter-spacing: 0.3px;
        }
        .btn-excel-premium .tooltiptext::after {
            top: auto !important;
            bottom: 100% !important;
            left: 50% !important;
            margin-left: -5px !important;
            border-color: transparent transparent #1f2937 transparent !important;
        }
    </style>
@stop
@section('section')
  <div class="be-content contenido cfedocumento">
    <div class="main-content container-fluid">
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

                          <a href="{{url('/gestion-de-oc-validado-excel-detallado')}}" 
                             onclick="var fi=$('#fecha_inicio').val(), ff=$('#fecha_fin').val(), p=$('#proveedor_id').val(), e=$('#estado_id').val(), o=$('#operacion_id').val(), f=$('#filtrofecha_id').val(), id=$('#idopcion').val(); if(!fi){alert('Seleccione una fecha inicio.'); return false;} if(!ff){alert('Seleccione una fecha fin.'); return false;} this.href=this.getAttribute('data-href')+'/'+fi+'/'+ff+'/'+p+'/'+e+'/'+o+'/'+f+'/'+id; return true;"
                             class='btn btn-excel-premium tooltipcss opciones'
                             target="_blank"
                             id="descargargestionocvalidadoexceldetallado" 
                             data-href="{{url('/gestion-de-oc-validado-excel-detallado')}}"
                             title="Descargar excel detallado">
                             <span class="tooltiptext">Descargar excel detallado</span>
                             <span class="icon mdi--file-excel"></span>
                          </a>

                          <span class="icon mdi mdi-more-vert dropdown-toggle" id="menudespacho"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></span>

                          <ul class="dropdown-menu" aria-labelledby="menudespacho"
                              style="margin: 7px -169px 0;">
                              <li>
                                  <a href="{{url('/comprobante-masivo-tesoreria-excel')}}" 
                                     onclick="var fi=$('#fecha_inicio').val(), ff=$('#fecha_fin').val(), p=$('#proveedor_id').val(), e=$('#estado_id').val(), o=$('#operacion_id').val(), id=$('#idopcion').val(); if(!fi){alert('Seleccione una fecha inicio.'); return false;} if(!ff){alert('Seleccione una fecha fin.'); return false;} this.href=this.getAttribute('data-href')+'/'+fi+'/'+ff+'/'+p+'/'+e+'/'+o+'/'+id; return true;"
                                     class='btn btn-secondary botoncabecera tooltipcss opciones'
                                     target="_blank"
                                     id="descargarcomprobantemasivotesoreriraexcel" 
                                     data-href="{{url('/comprobante-masivo-tesoreria-excel')}}"
                                     title="Descargar excel" style="width:100%">
                                     <span class="tooltiptext">Descargar excel Tesoreria</span>
                                     Descargar excel Tesoreria
                                  </a>
                              </li>
                              <li>
                                <a href="{{url('/comprobante-masivo-excel')}}" 
                                   onclick="var fi=$('#fecha_inicio').val(), ff=$('#fecha_fin').val(), p=$('#proveedor_id').val(), e=$('#estado_id').val(), o=$('#operacion_id').val(), id=$('#idopcion').val(); if(!fi){alert('Seleccione una fecha inicio.'); return false;} if(!ff){alert('Seleccione una fecha fin.'); return false;} this.href=this.getAttribute('data-href')+'/'+fi+'/'+ff+'/'+p+'/'+e+'/'+o+'/'+id; return true;"
                                   class='btn btn-secondary botoncabecera tooltipcss opciones'
                                   target="_blank"
                                   id="descargarcomprobantemasivoexcel" 
                                   data-href="{{url('/comprobante-masivo-excel')}}"
                                   title="Descargar excel" style="width:100%">
                                   <span class="tooltiptext">Descargar excel Contabilidad</span>
                                   Descargar excel Contabilidad
                                </a>
                              </li>
                              <li>
                               <a href="{{url('/comprobante-masivo-mkt-excel')}}" 
                                    onclick="var fi=$('#fecha_inicio').val(), ff=$('#fecha_fin').val(), p=$('#proveedor_id').val(), e=$('#estado_id').val(), o=$('#operacion_id').val(), id=$('#idopcion').val(); if(!fi){alert('Seleccione una fecha inicio.'); return false;} if(!ff){alert('Seleccione una fecha fin.'); return false;} this.href=this.getAttribute('data-href')+'/'+fi+'/'+ff+'/'+p+'/'+e+'/'+o+'/'+id; return true;"
                                    class='btn btn-secondary botoncabecera tooltipcss opciones'
                                    target="_blank"
                                    id="descargarcomprobantemasivomktexcel" 
                                    data-href="{{url('/comprobante-masivo-mkt-excel')}}"
                                    title="Descargar excel" style="width:100%">
                                    <span class="tooltiptext">Descargar excel Marketing</span>
                                    Descargar excel Marketing
                                 </a>
                              </li>
                          </ul>
                      </div>
                  </div>






                </div>

                <div class="panel-body">
                  <div class='filtrotabla row'>

                          <div class="col-xs-12">

                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">
                                <div class="form-group">
                                  <label class="col-sm-12 control-label labelleft" >Operacion :</label>
                                  <div class="col-sm-12 abajocaja" >
                                    {!! Form::select( 'operacion_id', $combo_operacion, array($operacion_id),
                                                      [
                                                        'class'       => 'select2 form-control control input-sm' ,
                                                        'id'          => 'operacion_id',
                                                        'required'    => '',
                                                        'data-aw'     => '1',
                                                      ]) !!}
                                  </div>
                                </div>
                            </div> 


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
                                    {!! Form::select( 'proveedor_id', $combo_proveedor, array(),
                                                      [
                                                        'class'       => 'select2 form-control control input-sm' ,
                                                        'id'          => 'proveedor_id',
                                                        'required'    => '',
                                                        'data-aw'     => '1',
                                                      ]) !!}
                                  </div>
                                </div>
                            </div> 

                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">

                                <div class="form-group">
                                  <label class="col-sm-12 control-label labelleft" >Estados :</label>
                                  <div class="col-sm-12 abajocaja" >
                                    {!! Form::select( 'estado_id', $combo_estado, array(),
                                                      [
                                                        'class'       => 'select2 form-control control input-sm' ,
                                                        'id'          => 'estado_id',
                                                        'required'    => '',
                                                        'data-aw'     => '1',
                                                      ]) !!}
                                  </div>
                                </div>
                            </div> 


                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">

                                <div class="form-group">
                                  <label class="col-sm-12 control-label labelleft" >Filtro Fecha :</label>
                                  <div class="col-sm-12 abajocaja" >
                                    {!! Form::select( 'filtrofecha_id', $combo_filtrofecha, array(),
                                                      [
                                                        'class'       => 'select2 form-control control input-sm' ,
                                                        'id'          => 'filtrofecha_id',
                                                        'required'    => '',
                                                        'data-aw'     => '1',
                                                      ]) !!}
                                  </div>
                                </div>
                            </div> 




                          </div>


                    <div class="col-xs-12">
                      <input type="hidden" name="idopcion" id='idopcion' value='{{$idopcion}}'>
                    </div>
                  </div>
                  <div class='listajax'>
                    @include('comprobante.ajax.mergelistaocvalidado')
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
  </div>
    @include('comprobante.modal.mregistrorequerimiento')
  
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
  <script src="{{ asset('public/js/comprobante/oc.js?v='.$version) }}" type="text/javascript"></script>

@stop