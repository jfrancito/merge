@extends('template_lateral')

@section('style')


    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>

@stop

@section('section')
	<div class="be-content  contenido proveedor" style="height: 100vh;">
		<div class="main-content container-fluid">
			<div class='container'>
				@if(Session::get('usuario')->rol_id == '1CIX00000024')
					@include('usuario.proveedores')
				@else
					<div class="row">

            <div class="col-xs-12 col-md-4">
              <div class="widget be-loading" style="background-color: #f5f5f5;">
                <div class="panel-heading panel-heading-divider xs-pb-15" style="padding-top: 0px;">Documentos Pendientes por aprobar(Proveedor)</div>
                <div class="widget-chart-container" >
                  <div id="top-sales" style="height: 100px;"></div>
                  <div class="chart-pie-counter">
                        {{$count_x_aprobar}}<br>
                  </div>
                </div>
                <div class="chart-legend">
                	<a href="{{ url($url) }}" class="btn btn-rounded btn-space btn-primary">Ir Aprobar</a>
                </div>
                <div class="be-spinner">
                  <svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                    <circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
                  </svg>
                </div>
              </div>
            </div>
						@if($trol->ind_uc == 1)
              <div class="col-xs-12 col-md-4">
                <div class="widget be-loading" style="background-color: #f5f5f5;">
                  <div class="panel-heading panel-heading-divider xs-pb-15" style="padding-top: 0px;">Orden de Compra Pendientes por integrar</div>
                  <div class="widget-chart-container" >
                    <div id="top-sales" style="height: 100px;"></div>
                    <div class="chart-pie-counter">
                          {{$count_x_aprobar_gestion}}<br>
                    </div>
                  </div>
                  <div class="chart-legend">
                    <a href="{{ url($url_gestion) }}" class="btn btn-rounded btn-space btn-primary">Ir a Integrar</a>
                  </div>
                  <div class="be-spinner">
                    <svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                      <circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
                    </svg>
                  </div>
                </div>
              </div>
	            <div class="col-xs-12 col-md-4">
	              <div class="widget be-loading" style="background-color: #f5f5f5;">
	                <div class="panel-heading panel-heading-divider xs-pb-15" style="padding-top: 0px;">Documentos Observados</div>
	                <div class="widget-chart-container" >
	                  <div id="top-sales" style="height: 100px;"></div>
	                  <div class="chart-pie-counter">
	                        {{$count_observados}}<br>
	                  </div>
	                </div>
	                <div class="chart-legend">
	                	<a href="{{ url($url_obs) }}" class="btn btn-rounded btn-space btn-primary">Ir Observados</a>
	                </div>
	                <div class="be-spinner">
	                  <svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
	                    <circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
	                  </svg>
	                </div>
	              </div>
	            </div>
						@endif
					</div>
				@endif
			</div>
		</div>
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
      App.dataTables();
      $('[data-toggle="tooltip"]').tooltip();
      $('form').parsley();

      $('.importe').inputmask({ 'alias': 'numeric', 
      'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 
      'digitsOptional': false, 
      'prefix': '', 
      'placeholder': '0'});


    });

  </script>
  <script src="{{ asset('public/js/user/proveedor.js?v='.$version) }}" type="text/javascript"></script>

@stop

