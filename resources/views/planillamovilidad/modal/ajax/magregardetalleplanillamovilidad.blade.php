@if(isset($dplanillamovilidad))
	<form method="POST" id ='agregarpmd' class="form2" action="{{ url('/modificar-detalle-planilla-movilidad/'.$idopcion.'/'.Hashids::encode(substr($planillamovilidad->ID_DOCUMENTO, -8)).'/'.$dplanillamovilidad->ITEM ) }}">
@else
	<form method="POST" id ='agregarpmd' class="form2" action="{{ url('/guardar-detalle-planilla-movilidad/'.$idopcion.'/'.Hashids::encode(substr($planillamovilidad->ID_DOCUMENTO, -8))) }}">
@endif
	{{ csrf_field() }}
	<div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
		<h3 class="modal-title">
			{{$planillamovilidad->TXT_TRABAJADOR}}<span>: {{$planillamovilidad->SERIE}} - {{$planillamovilidad->NUMERO}}</span>
		</h3>
	</div>
	<div class="modal-body">
		<div  class="row regla-modal">

	        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cajareporte">
	          <div class="form-group ">
	            <label class="col-sm-12 control-label labelleft negrita" >FECHA DEL GASTO  <span class="obligatorio">(*)</span>:</label>
	            <div class="col-sm-12 abajocaja" >
	              <div data-min-view="2" 
	                     data-date-format="dd-mm-yyyy"  
	                     class="input-group date datetimepicker02 pickerfecha" style = 'padding: 0px 0;margin-top: -3px;'>
	                     <input size="16" type="text" 
	                            value="@if(isset($dplanillamovilidad)){{old('fecha_gasto' ,date_format(date_create(date($dplanillamovilidad->FECHA_GASTO)), 'd-m-Y'))}}@else{{old('fecha_gasto')}}@endif" 
	                            placeholder="FECHA DEL GASTO"
	                            id='fecha_gasto' 
	                            name='fecha_gasto' 
	                            class="form-control input-sm"/>
	                      <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
	                </div>
	            </div>
	          </div>
	        </div> 

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group">
				  <label class="col-sm-12 control-label labelleft negrita" >MOTIVO <span class="obligatorio">(*)</span> :</label>
				  <div class="col-sm-12">
				      {!! Form::select( 'motivo_id', $combomotivo, $motivo_id,
		                              [
		                                'class'       => 'select3 form-control control input-xs' ,
		                                'id'          => 'motivo_id',        
		                              ]) !!}
				  </div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="col-sm-12" >
					<p style="text-align: center;margin-top: 11px;margin-bottom: 11px;background: #5f99f5;color: #fff;"><b>PARTIDA</b></p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
				<div class="form-group">
				  <label class="col-sm-12 control-label labelleft negrita" >DEPARTAMENTO PARTIDA <span class="obligatorio">(*)</span> :</label>
				  <div class="col-sm-12">
				      {!! Form::select( 'departamentopartida_id', $combodepartamento, $departamento_id,
		                              [
		                                'class'       => 'select3 form-control control input-xs' ,
		                                'id'          => 'departamentopartida_id',        
		                              ]) !!}
				  </div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
				<div class="form-group ajax_provincia_partida">
					@include('general.ajax.comboprovinciapartida')
				</div>
			</div>


			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
				<div class="form-group ajax_distrito_partida">
					@include('general.ajax.combodistritopartida')
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
				<div class="form-group">
					<label class="col-sm-12 control-label labelleft negrita" >DIRECCION PARTIDA<span class="obligatorio">(*)</span>: </label>
					<div class="col-sm-12">
							<input  type="text"
											id="lugarpartida" 
											name='lugarpartida' 
											value="@if(isset($dplanillamovilidad)){{old('lugarpartida' ,$dplanillamovilidad->TXT_LUGARPARTIDA)}}@else{{old('lugarpartida')}}@endif" 
											placeholder="Lugar de Partida"
											autocomplete="off" 
											class="form-control input-sm validarmayusculas"/>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="col-sm-12" >
					<p style="text-align: center;margin-top: 11px;margin-bottom: 11px;background: #5f99f5;color: #fff;"><b>LLEGADA</b></p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
				<div class="form-group">
				  <label class="col-sm-12 control-label labelleft negrita" >DEPARTAMENTO LLEGADA <span class="obligatorio">(*)</span> :</label>
				  <div class="col-sm-12">
				      {!! Form::select( 'departamentollegada_id', $combodepartamentoll, $departamento_idll,
		                              [
		                                'class'       => 'select3 form-control control input-xs' ,
		                                'id'          => 'departamentollegada_id',        
		                              ]) !!}
				  </div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
				<div class="form-group ajax_provincia_llegada">
					@include('general.ajax.comboprovinciallegada')
				</div>
			</div>


			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
				<div class="form-group ajax_distrito_llegada">
					@include('general.ajax.combodistritollegada')
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
				<div class="form-group">
					<label class="col-sm-12 control-label labelleft negrita" >DIRECCION DE LLEGADA <span class="obligatorio">(*)</span>: </label>
					<div class="col-sm-12">
							<input  type="text"
											id="lugarllegada" 
											name='lugarllegada' 
											value="@if(isset($dplanillamovilidad)){{old('lugarllegada' ,$dplanillamovilidad->TXT_LUGARLLEGADA)}}@else{{old('lugarllegada')}}@endif" 
											placeholder="Lugar de Llegada"
											autocomplete="off" 
											class="form-control input-sm validarmayusculas"/>
					</div>
				</div>
			</div>




			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group">
					<label class="col-sm-12 control-label labelleft negrita" >TOTAL : </label>
					<div class="col-sm-12">
							<input  type="text"
											id="total" 
											name='total'
											value="@if(isset($dplanillamovilidad)){{old('total' ,$dplanillamovilidad->TOTAL)}}@else{{old('total')}}@endif" 
											placeholder="Total"
											autocomplete="off" 
											class="form-control input-sm importe"/>
					</div>
				</div>
			</div>	

			@if(isset($dplanillamovilidad))

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
							  <label class="col-sm-12 control-label labelleft negrita" >ACTIVO <span class="obligatorio">(*)</span> :</label>
							  <div class="col-sm-12">
							      {!! Form::select( 'activo', $comboestado, $activo,
					                              [
					                                'class'       => 'select3 form-control control input-xs' ,
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
		<button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-detalle-planilla">Guardar</button>
	</div>
</form>
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
		});
	</script>
@endif





