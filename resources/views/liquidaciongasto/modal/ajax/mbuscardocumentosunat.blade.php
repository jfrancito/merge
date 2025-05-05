<div class="modal-header">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	<h3 class="modal-title">
		BUSCAR DOCUMENTOS EN SUNAT
	</h3>
</div>
<div class="modal-body">
	<div class="container">
		<div  class="row regla-modal">

				    <div class="col-sm-12" style="margin-bottom: 10px;">
	            <div class="form-group" >
	              <label class="col-sm-3 control-label">RUC</label>
	              <div class="col-sm-8">
	                <input  type="text"
	                        id="ruc_sunat" name='ruc_sunat' value="20480744480" placeholder="RUC"
	                        required = ""
	                        autocomplete="off" class="form-control input-sm" data-aw="4"/>

	              </div>
	            </div>
	          </div>

				    <div class="col-sm-12" style="margin-bottom: 10px;">
	            <div class="form-group" >
	              <label class="col-sm-3 control-label">TIPO DOCUMENTO</label>
	              <div class="col-sm-8">
	                {!! Form::select( 'td', $combotd, array('01'),
	                                  [
	                                    'class'       => 'form-control control input-sm select2' ,
	                                    'id'          => 'td',
	                                    'required'    => '',
	                                    'data-aw'     => '7'
	                                  ]) !!}
	              </div>
	            </div>
	          </div>

				    <div class="col-sm-12" style="margin-bottom: 10px;">    
	            <div class="form-group" >
	              <label class="col-sm-3 control-label">SERIE</label>
	              <div class="col-sm-8">
	                <input  type="text"
	                        id="serie_sunat" name='serie_sunat' value="E001" placeholder="SERIE"
	                        required = ""
	                        autocomplete="off" class="form-control input-sm" data-aw="4"/>
	              </div>
	            </div>
	          </div>
				    <div class="col-sm-12" style="margin-bottom: 10px;">  
	            <div class="form-group" >
	              <label class="col-sm-3 control-label">NRO. DOCUMENTO</label>
	              <div class="col-sm-8">

	                <input  type="text"
	                        id="correlativo_sunat" name='correlativo_sunat' value="1372" placeholder="NRO. DOCUMENTO"
	                        required = ""
	                        autocomplete="off" class="form-control input-sm" data-aw="4"/>

	                  @include('error.erroresvalidate', [ 'id' => $errors->has('name')  , 
	                                                      'error' => $errors->first('name', ':message') , 
	                                                      'data' => '4'])
	              </div>
	            </div>
	          </div>
	            <div class="row xs-pt-15">
	              <div class="col-xs-6">
	                  <div class="be-checkbox">

	                  </div>
	              </div>
	              <div class="col-xs-6">
	                <p class="text-right">
	                  <button type="button" class="btn btn-space btn-primary btn_cargando btn_buscar_cpe_lg" data-iddocumento='{{$ID_DOCUMENTO}}'>Buscar</button>
	                </p>
	              </div>
	            </div>
		</div>
	</div>
</div>
@if(isset($ajax))
	<script type="text/javascript">
		$(document).ready(function(){
			$('.importe').inputmask({ 'alias': 'numeric', 
			'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
			'digitsOptional': false, 
			'prefix': '', 
			'placeholder': '0'});
		});
	</script>
@endif





