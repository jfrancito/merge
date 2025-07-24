
	<div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
		<h3 class="modal-title">
			{{$data_producto}}
		</h3>
	</div>
	<div class="modal-body">
		<div  class="row regla-modal">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group">
				  <label class="col-sm-12 control-label labelleft negrita" >PRODUCTO <span class="obligatorio">(*)</span> :</label>
				  <div class="col-sm-12">
				      {!! Form::select( 'producto_id', $comboproducto, $producto_id,
		                              [
		                                'class'       => 'form-control control input-xs' ,
		                                'id'          => 'producto_id',        
		                              ]) !!}
				  </div>
				</div>
			</div>

			
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" data_item={{$data_item}} class="btn btn-success btn-relacionar-producto-lg">Guardar</button>
	</div>

@if(isset($ajax))
	<script type="text/javascript">
		$(document).ready(function(){
	        $('#producto_id').select2({
	            // Activamos la opcion "Tags" del plugin
	            width: '100%',
	            placeholder: 'Seleccione una empresa',
	            language: "es",
	            tags: true,
	            tokenSeparators: [','],
	            ajax: {
	                dataType: 'json',
	                url: '{{ url("buscarproducto") }}',
	                delay: 100,
	                data: function(params) {
	                    return {
	                        term: params.term
	                    }
	                },
	                processResults: function (data, page) {
	                  return {
	                    results: data
	                  };

	                },
	            }
	        });

	        $('#producto_id_factura').select2({
	            // Activamos la opcion "Tags" del plugin
	            width: '100%',
	            placeholder: 'Seleccione una empresa',
	            language: "es",
	            tags: true,
	            tokenSeparators: [','],
	            ajax: {
	                dataType: 'json',
	                url: '{{ url("buscarproducto") }}',
	                delay: 100,
	                data: function(params) {
	                    return {
	                        term: params.term
	                    }
	                },
	                processResults: function (data, page) {
	                  return {
	                    results: data
	                  };

	                },
	            }
	        });

        	$('.form2').parsley();
			$('.importe').inputmask({ 'alias': 'numeric', 
			'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
			'digitsOptional': false, 
			'prefix': '', 
			'placeholder': '0'});
		});
	</script>
@endif





