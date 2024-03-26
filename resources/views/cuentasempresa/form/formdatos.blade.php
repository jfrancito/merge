@php
	if(isset($modificar)){
		$disabled=true;
	}
	else{
		$disabled=false;
	}
@endphp

	<div class="form-group">
		<label class="col-sm-3 control-label">Entidad Financiera <span class="obligatorio">(*)</span> :</label>
		<div class="col-sm-6">
			{!! Form::select( 'entidad_id', $combo_entidad, $select_entidad,
												[
													'class'       => 'select2 form-control control input-xs' ,
													'id'          => 'entidad_id',
													'required'    => '',
													'disabled'		=> $disabled,
													'data-aw'     => '5'
												]) !!}

				@include('error.erroresvalidate', [ 'id' => $errors->has('entidad_id')  , 
																						'error' => $errors->first('entidad_id', ':message') , 
																						'data' => '5'])

		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Moneda <span class="obligatorio">(*)</span> :</label>
		<div class="col-sm-6">
			{!! Form::select( 'moneda_id', $combo_moneda, $select_moneda,
												[
													'class'       => 'select2 form-control control input-xs' ,
													'id'          => 'moneda_id',
													'required'    => '',
													'disabled'		=> $disabled,
													'data-aw'     => '10'
												]) !!}

				@include('error.erroresvalidate', [ 'id' => $errors->has('moneda_id')  , 
																						'error' => $errors->first('moneda_id', ':message') , 
																						'data' => '10'])

		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label">Nro Cta <span class="obligatorio">(*)</span> :</label>
		<div class="col-sm-6">

					<input  type="text"
									id="nrocta" name='nrocta' 
									value="@if(isset($registro)){{old('nrocta' ,$registro->nrocta)}}@else{{old('nrocta')}}@endif"
									placeholder="Nro Cuenta"
									required = ""
									autocomplete="off" 
									class="form-control validarnrocta" data-aw="15"/>

					@include('error.erroresvalidate', [ 'id' => $errors->has('nrocta')  , 
																							'error' => $errors->first('nrocta', ':message') , 
																							'data' => '15'])

		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" title="Codigo de Cuenta Interbancaria">Nro CCI :</label>
		<div class="col-sm-6">

					<input  type="text"
									id="nroctacci" name='nroctacci' 
									value="@if(isset($registro)){{old('nroctacci' ,$registro->nroctacci)}}@else{{old('nroctacci')}}@endif"
									placeholder="Nro Codigo de Cuenta Interbancaria"

									autocomplete="off" 
									class="form-control validarnrocta" data-aw="20"/>

					@include('error.erroresvalidate', [ 'id' => $errors->has('nroctacci')  , 
																							'error' => $errors->first('nroctacci', ':message') , 
																							'data' => '20'])

		</div>
	</div>

	<div class="row xs-pt-15">
		<div class="col-xs-6">
				<div class="be-checkbox">

				</div>
		</div>
		<div class="col-xs-6">
			<p class="text-right">
				<a href="{{ url('/gestion-'.$url.'/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
				<button type="submit" class="btn btn-space btn-primary btnguardarregistro">Guardar</button>
			</p>
		</div>
	</div>