
<form method="POST" action="{{ url('/configurar-datos-cuenta-bancaria/'.Hashids::encode(substr($usuario->id, -8))) }}">
      {{ csrf_field() }}
	<div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
		<h3 class="modal-title">
			 <b>Datos de la Cuenta Bancaria</b>
		</h3>
	</div>
	<div class="modal-body">
		<div  class="row regla-modal">
		    <div class="col-md-12">
		        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Banco :</label>
		                <div class="col-sm-12 abajocaja" >
		                  {!! Form::select( 'banco_id', $combo_banco, $defecto_banco,
		                                    [
		                                      'class'       => 'select2 form-control control input-xs combo' ,
		                                      'id'          => 'banco_id',
		                                      'data-aw'     => '1',
		                                      'required'    => '',
		                                    ]) !!}
		                </div>
		              </div>
		        </div>
		        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Tipo Cuenta :</label>
		                <div class="col-sm-12 abajocaja" >
		                  {!! Form::select( 'tipocuenta_id', $combo_tipocuenta, $defecto_tipocuenta,
		                                    [
		                                      'class'       => 'select2 form-control control input-xs combo' ,
		                                      'id'          => 'tipocuenta_id',
		                                      'data-aw'     => '1',
		                                      'required'    => '',
		                                    ]) !!}
		                </div>
		              </div>
		        </div>


		        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Moneda :</label>
		                <div class="col-sm-12 abajocaja" >
		                  {!! Form::select( 'moneda_id', $combo_moneda, $defecto_moneda,
		                                    [
		                                      'class'       => 'select2 form-control control input-xs combo' ,
		                                      'id'          => 'moneda_id',
		                                      'data-aw'     => '1',
		                                      'required'    => '',
		                                    ]) !!}
		                </div>
		              </div>
		        </div>


		        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Nro. Cuenta  :</label>
		                <div class="col-sm-12 abajocaja" >

                        <input  type="text"
                                id="numerocuenta" name='numerocuenta' value="" placeholder="Nro. Cuenta"
                                required = ""
                                autocomplete="off" class="form-control input-sm" data-aw="4"/>
		                </div>
		              </div>
		        </div>



		        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Nro. Cuenta (CCI) :</label>
		                <div class="col-sm-12 abajocaja" >

                        <input  type="text"
                                id="numerocuentacci" name='numerocuentacci' value="" placeholder="Nro. Cuenta (CCI)"
                                required = ""
                                autocomplete="off" class="form-control input-sm" data-aw="4"/>
		                </div>
		              </div>
		        </div>

		        
				</div>
		    </div>
		</div>
	</div>

	<div class="modal-footer">
	  <button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-configuracion-cb">Guardar</button>
	</div>
</form>


@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){

      App.formElements();
      $('.importe').inputmask({ 'alias': 'numeric', 
      'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 
      'digitsOptional': false, 
      'prefix': '', 
      'placeholder': '0'});

    });
  </script>
@endif




