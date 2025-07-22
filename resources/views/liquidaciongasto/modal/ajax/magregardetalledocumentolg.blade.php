@if(isset($detdocumentolg))
	<form method="POST" id ='agregarpmd' class="form2" action="{{ url('/modificar-detalle-documento-lg/'.$idopcion.'/'.Hashids::encode(substr($detdocumentolg->ID_DOCUMENTO, -8)).'/'.$detdocumentolg->ITEM.'/'.$detdocumentolg->ITEMDOCUMENTO) }}">
@else
	<form method="POST" id ='agregarpmd' class="form2" action="{{ url('/guardar-detalle-documento-lg/'.$idopcion.'/'.Hashids::encode(substr($detliquidaciongasto->ID_DOCUMENTO, -8)).'/'.$detliquidaciongasto->ITEM) }}">
@endif
	{{ csrf_field() }}
	<div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
		<h3 class="modal-title">
			{{$detliquidaciongasto->TXT_TIPODOCUMENTO}}<span>: {{$detliquidaciongasto->SERIE}} - {{$detliquidaciongasto->NUMERO}}</span>
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

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group">
					<label class="col-sm-12 control-label labelleft negrita" >IMPORTE <span class="obligatorio">(*)</span>: </label>
					<div class="col-sm-12">
							<input  type="text"
											id="importe" 
											name='importe' 
											value="@if(isset($detdocumentolg)){{old('importe' ,$detdocumentolg->TOTAL)}}@else{{old('importe')}}@endif" 
											placeholder="Importe"
											autocomplete="off" 
											class="form-control input-sm importe"/>
					</div>
				</div>
			</div>




			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group">
				  <label class="col-sm-12 control-label labelleft negrita" >¿ESTA AFECTO A IGV?<span class="obligatorio">(*)</span> :</label>
				  <div class="col-sm-12">
				      {!! Form::select( 'igv_id', $combo_igv, array($igv_id),
		                              [
		                                'class'       => 'select7 form-control control input-xs' ,
		                                'id'          => 'igv_id',        
		                              ]) !!}
				  </div>
				</div>
			</div>



@if(isset($detdocumentolg))

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group">
				  <label class="col-sm-12 control-label labelleft negrita" >ACTIVO <span class="obligatorio">(*)</span> :</label>
				  <div class="col-sm-12">
				      {!! Form::select( 'activo', $comboestado, $activo,
		                              [
		                                'class'       => 'select6 form-control control input-xs' ,
		                                'id'          => 'activo',        
		                                'required'    => ''
		                              ]) !!}
				  </div>
				</div>
			</div>
@endif


		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-detalle-documento-lg">Guardar</button>
	</div>
</form>
@if(isset($ajax))
	<script type="text/javascript">
		$(document).ready(function(){
	        $('.select7').select2();


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


        	$('.form2').parsley();
			$('.importe').inputmask({ 'alias': 'numeric', 
			'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
			'digitsOptional': false, 
			'prefix': '', 
			'placeholder': '0'});
		});
	</script>
@endif





