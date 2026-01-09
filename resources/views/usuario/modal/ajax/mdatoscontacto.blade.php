
<form method="POST" action="{{ url('/configurar-datos-contacto/'.Hashids::encode(substr($usuario->id, -8))) }}">
      {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>

	<div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
		<h3 class="modal-title">
			 {{$usuario->nombre}} <span>({{$usuario->name}})</span>
		</h3>
	</div>
	<div class="modal-body">
		<div  class="row regla-modal">
		    <div class="col-md-12">


		        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Nombres  :</label>
		                <div class="col-sm-12 abajocaja" >

                        <input  type="text"
                                id="nombre" name='nombre' value="{{$usuario->nombre_contacto}}" placeholder="Nombre"
                                required = ""
                                autocomplete="off" class="form-control input-sm" data-aw="4"/>
		                </div>
		              </div>
		        </div>

		        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Celular :</label>
		                <div class="col-sm-12 abajocaja" >
                        <input  type="text"
                                id="lblcelular" name='lblcelular' value="{{$usuario->celular_contacto}}" placeholder="Ingrese su celular"
                                required = ""
                                data-parsley-type="number"
                                autocomplete="off" 
                                class="form-control textpucanegro fuente-recoleta-regular input-sm"
                                data-aw="1"/>
		                </div>
		              </div>
		        </div>

		        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Correo electronico :</label>
		                <div class="col-sm-12 abajocaja" >
                        <input  type="email"
                                id="lblemail" name='lblemail' value="{{$usuario->email}}" placeholder="Ingresa tu correo electronico"
                                required = ""
                                autocomplete="off" 
                                class="form-control textpucanegro fuente-recoleta-regular input-sm"
                                data-aw="1"/>
		                </div>
		              </div>
		        </div>

		        
				</div>
		    </div>
		    <div class="col-md-6">
		    </div>

		</div>
	</div>

	<div class="modal-footer">
	  <button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-configuracion">Guardar</button>
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




