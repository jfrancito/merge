<div class="modal-header">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	<h3 class="modal-title">
		BUSCAR DOCUMENTOS EN SUNAT
	</h3>
</div>
<div class="modal-body">
	<div class="container">
	    <div class="tab-container">
	        <ul class="nav nav-tabs">
	          <li class="active"><a href="#sunat" data-toggle="tab">SUNAT</a></li>
	          <li><a href="#tareas" data-toggle="tab">TAREAS</a></li>  
	        </ul>
	        <div class="tab-content">
	          <div id="sunat" class="tab-pane  active cont">
					<div  class="row regla-modal">

						    <div class="col-sm-12" style="margin-bottom: 10px;">
					            <div class="form-group" >
					              <label class="col-sm-3 control-label">RUC</label>
					              <div class="col-sm-8">
					                <input  type="text"
					                        id="ruc_sunat" name='ruc_sunat' value="" placeholder="RUC"
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
				                        id="serie_sunat" name='serie_sunat' value="" placeholder="SERIE"
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
				                        id="correlativo_sunat" name='correlativo_sunat' value="" placeholder="NRO. DOCUMENTO"
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
				                	<button type="button" class="btn btn-space btn-danger btn_cargando btn_tarea_cpe_lg" data-iddocumento='{{$ID_DOCUMENTO}}'>TAREAS</button>
				                  	<button type="button" class="btn btn-space btn-primary btn_cargando btn_buscar_cpe_lg" data-iddocumento='{{$ID_DOCUMENTO}}'>BUSCAR</button>
				                </p>


				              </div>
				            </div>
					</div>
	          </div>
	          <div id="tareas" class="tab-pane cont">
	          				<div class="row">
							    <div class="col-sm-12" style="margin-bottom: 10px;">
						            <div class="form-group" >
						              <label class="col-sm-12 control-label">WHATSAPP EJEMPLO : <b>979820173</b></label>
						              <div class="col-sm-12">
					          	        <div class="input-group xs-mb-15">
				                         	<input type="text"
										       name="whatsapp"
										       id="whatsapp"
										       class="form-control"
										       maxlength="9"
										       pattern="\d{9}"
										       value="{{$user->celular_contacto}}" 
										       title="Ingrese un número de 9 dígitos"
										       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
										       >
				                         	<span class="input-group-btn">
				                            <button type="button" class="btn btn-primary btn-guardar-whatsapp">GUARDAR</button></span>
				                        </div>
						              </div>
						            </div>
					          	</div>
	          				</div>



				<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 					
					<div class='listajax'>
	                    @include('liquidaciongasto.ajax.alistatareassunat')
	                </div>
				</div>

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





