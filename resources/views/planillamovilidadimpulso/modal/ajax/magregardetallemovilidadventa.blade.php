    <div class="panel panel-default">
      <div class="tab-container">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#registro" data-toggle="tab">REGISTRO</a></li>

        </ul>

        <div class="tab-content">
          	<div id="registro" class="tab-pane active cont">
						<form method="POST" id ='agregarpmd' class="form2" action="{{ url('/guardar-detalle-movilidad-venta-trabajador/'.$idopcion.'/'.Hashids::encode(substr($planillamovilidad->ID_DOCUMENTO, -8))) }}">
							{{ csrf_field() }}
							<div class="modal-header">
								<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
								<h3 class="modal-title">
									{{$planillamovilidad->ID_DOCUMENTO}}<span>: {{$planillamovilidad->ANIO}} - {{$planillamovilidad->MES}}</span>
								</h3>
							</div>
							<div class="modal-body">
								<div  class="row regla-modal">


										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group">
											  <label class="col-sm-12 control-label labelleft negrita" >VENDEDOR <span class="obligatorio">(*)</span> :</label>
											  <div class="col-sm-12">
											      {!! Form::select( 'trabajador_id', $combotrabajador, $trabajador_id,
									                              [
									                                'class'       => 'select3 form-control control input-xs' ,
									                                'required'          => 'required',
									                                'id'          => 'trabajador_id',        
									                              ]) !!}
											  </div>
											</div>
										</div>


								</div>
							</div>
					<div class="modal-footer">
						<button type="submit" data-dismiss="modal" class="btn btn-success">Guardar</button>
					</div>
				</form>
      	</div>
        </div>
       </div>
	</div>
@if(isset($ajax))
	<script type="text/javascript">
		$(document).ready(function(){

		    $(".datetimepicker02").datetimepicker({
		    	autoclose: true,
		      	pickerPosition: "bottom-left",
		    	componentIcon: '.mdi.mdi-calendar',
		    	navIcons:{
		    		rightIcon: 'mdi mdi-chevron-right',
		    		leftIcon: 'mdi mdi-chevron-left'
		    	}
		    });
			$(".select3").select2({
		      width: '100%'
		    });
        	$('.form2').parsley();

			$('.importe').inputmask({ 'alias': 'numeric', 
			'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
			'digitsOptional': false, 
			'prefix': '', 
			'placeholder': '0'});

	        $("#nsop").dataTable({
	            dom: 'Bfrtip',
	            buttons: [
	                'csv', 'excel', 'pdf'
	            ],
	            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
	            columnDefs:[{
	                targets: "_all",
	                sortable: false
	            }]
	        });

	        $("#nsol").dataTable({
	            dom: 'Bfrtip',
	            buttons: [
	                'csv', 'excel', 'pdf'
	            ],
	            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
	            columnDefs:[{
	                targets: "_all",
	                sortable: false
	            }]
	        });

		});
	</script>
@endif





