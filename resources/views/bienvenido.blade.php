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
	          	<div class="row">
		            <div class="col-xs-12 col-md-6">
		              
		              <div class="panel panel-border-color panel-border-color-success">
		                <div class="panel-heading panel-heading-divider xs-pb-15">Datos del Proveedor
		                	<div class="tools editar_datos_proveedor"> <span class="label label-primary">Editar</span> </div>
		                </div>
		                <div class="panel-body xs-pt-25">

		                  <div class="row user-progress user-progress-small">
		                    <div class="col-md-5"><span class="title"><b>Razón Social :</b></span></div>
		                    <div class="col-md-7">
		                    	{{$usuario->nombre}}
		                    </div>
		                  </div>

		                  <div class="row user-progress user-progress-small">
		                    <div class="col-md-5"><span class="title"><b>Ruc :</b></span></div>
		                    <div class="col-md-7">
		                    	{{$usuario->name}}
		                    </div>
		                  </div>

		                  <div class="row user-progress user-progress-small">
		                    <div class="col-md-5"><span class="title"><b>Dirección Fiscal :</b></span></div>
		                    <div class="col-md-7">
		                    	{{$usuario->direccion_fiscal}}
		                    </div>
		                  </div>

		                  <div class="row user-progress user-progress-small">
		                    <div class="col-md-5"><span class="title"><b>Cuenta Detracción :</b></span></div>
		                    <div class="col-md-7">
		                    	{{$usuario->cuenta_detraccion}}
		                    </div>
		                  </div>


		                </div>
		              </div>
			            </div>
			            <div class="col-xs-12 col-md-6">
			              <div class="panel panel-border-color panel-border-color-primary">
			                <div class="panel-heading panel-heading-divider xs-pb-15">Datos del Contacto
			                	<div class="tools editar_datos_contacto"> <span class="label label-primary">Editar</span> </div>
			                </div>
			                <div class="panel-body xs-pt-25">

			                  <div class="row user-progress user-progress-small">
			                    <div class="col-md-5"><span class="title"><b>Nombres :</b></span></div>
			                    <div class="col-md-7">
			                    	{{$usuario->nombre_contacto}}
			                    </div>
			                  </div>

			                  <div class="row user-progress user-progress-small">
			                    <div class="col-md-5"><span class="title"><b>Celular :</b></span></div>
			                    <div class="col-md-7">
			                    	{{$usuario->celular_contacto}}
			                    </div>
			                  </div>

			                  <div class="row user-progress user-progress-small">
			                    <div class="col-md-5"><span class="title"><b>Correo electronico :</b></span></div>
			                    <div class="col-md-7">
			                    	{{$usuario->email}}
			                    </div>
			                  </div>

			                  <div class="row user-progress user-progress-small">
			                    <div class="col-md-5"><span class="title"><b>Confirmacion de email :</b></span></div>
			                    <div class="col-md-7">
			                    	<span class="label label-success">Aceptado</span>
			                    	
			                    </div>
			                  </div>



			                </div>
			              </div>
			            </div>
	          	</div>

		          <div class="row">
		            <div class="col-sm-12">
		              <div class="panel panel-default panel-table">
		                <div class="panel-heading">Mis Cuentas Bancarias
			                	<div class="tools agregar_cuenta_bancaria" style="cursor: pointer;"> <span class="label label-primary">Agregar</span> </div>
		                </div>
		                <div class="panel-body">
		                  <table class="table table-striped table-borderless">
		                    <thead>
		                      <tr>
		                        <th>Banco</th>
		                        <th>Tipo Cuenta</th>
		                        <th>Moneda</th>
		                        <th>Nro. Cuenta</th>
		                        <th>Nro. CCI</th>
		                        <th></th>
		                      </tr>
		                    </thead>
		                    <tbody class="no-border-x">

		                      @foreach($cuentabancarias as $index => $item)
			                      <tr>
			                        <td>{{$item->TXT_EMPR_BANCO}}</td>
			                        <td>{{$item->TXT_REFERENCIA}}</td>
			                        <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
			                        <td>{{$item->TXT_NRO_CUENTA_BANCARIA}}</td>
			                        <td>{{$item->TXT_NRO_CCI}}</td>
			                        <td>
			                        	<span style="cursor:pointer;" 
			                        		data_COD_EMPR_TITULAR = '{{$item->COD_EMPR_TITULAR}}'
			                        		data_COD_EMPR_BANCO = '{{$item->COD_EMPR_BANCO}}'
			                        		data_COD_CATEGORIA_MONEDA = '{{$item->COD_CATEGORIA_MONEDA}}'
			                        		data_TXT_TIPO_REFERENCIA = '{{$item->TXT_TIPO_REFERENCIA}}'
			                        		data_TXT_NRO_CUENTA_BANCARIA = '{{$item->TXT_NRO_CUENTA_BANCARIA}}'

			                        		class="badge badge-danger btn-eliminar-cb">
			                        		<a href="#" class="icon"><i class="mdi mdi-close" style="color: #fff;"></i></a>
			                        	</span>
			                        </td>
			                      </tr>

		                      @endforeach



		                    </tbody>
		                  </table>
		                </div>
		              </div>
		            </div>
		          </div>

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

