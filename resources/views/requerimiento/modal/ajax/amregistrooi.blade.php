<div class="modal-header">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	<h3 class="modal-title">
		 OTROS INTEGRANTES
	</h3>
</div>
<div class="modal-body">
	<div  class="row regla-modal">
		    <div class="col-md-12">

            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label"><b>Tipo Documento : </b></label>
                {!! Form::select( 'tdgoi', $combotd, $selecttd,
                                  [
                                    'class'       => 'select3 form-control control input-xs combo ctipodocumento',
                                    'id'          => 'tdgoi',
                                  ]) !!}
              </div>
            </div>
            <div class="col-sm-6">
              <div class="input-group my-group">
                  <label class="control-label"><b>Documento : </b></label>
                  <input  type="text"
                          id="documentogoi" 
                          name='documentogoi'                        
                          placeholder="DOCUMENTO"
                          required = ""
                          maxlength="10"                     
                          autocomplete="off" class="form-control input-sm"/>

                    <span class="input-group-btn">
                      <button class="btn btn-primary btn_buscar_dni_oi"
                              data_dni_m = 'documentogoi'
                              data_nombre_m = 'nombresgoi'
                              type="button" 
                              style="margin-top: 26px;height: 37px;">
                              Buscar Reniec</button>
                    </span>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label"><b>NOMBRES <small class="">(OTROS INTEGRANTES)</small> : </b></label>
                <input  type="text"
                        id="nombresgoi" 
                        name='nombresgoi'                        
                        placeholder="NOMBRES"
                        required = ""
                        maxlength="300"                     
                        autocomplete="off" class="form-control input-sm"/>

              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label"><b>CARGO  : </b></label>
                <input  type="text"
                        id="cargo" 
                        name='cargo'                        
                        placeholder="CARGO"
                        required = ""
                        maxlength="300"                     
                        autocomplete="off" class="form-control input-sm"/>
              </div>
            </div>
		    </div>
	    <div class="col-md-6">
	    </div>
	</div>
</div>

<div class="modal-footer">
  <button type="submit" 
  				data-dismiss="modal" class="btn btn-success btn_asignar_nombre_oi"
  				>
  	Asignar
  </button>
</div>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
			$(".select3").select2({
		      width: '100%'
		  });
    });
  </script>
@endif



