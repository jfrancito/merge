
<form method="POST" action="{{ url('/guardar-cambio-reparable/'.$orden_id.'/'.$idopcion) }}">
      {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>

	<div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
		<h3 class="modal-title">
			 <b>Usuarios {{ $orden_id }}</b>
		</h3>
	</div>
	<div class="modal-body">
		<div  class="row regla-modal">
		    <div class="col-md-12">
		        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Usuarios (*):</label>
		                <div class="col-sm-12 abajocaja" >
		                  {!! Form::select( 'usuario_id', $combo_usuario, $usuario_id,
		                                    [
		                                      'class'       => 'select3 form-control control input-xs combo' ,
		                                      'id'          => 'usuario_id',
		                                      'data-aw'     => '1',
		                                      'required'    => '',
		                                    ]) !!}
		                </div>
		              </div>
		        </div>
				</div>
		    </div>
		</div>
	</div>

	<div class="modal-footer">
	  <button type="submit" data-dismiss="modal" class="btn btn-success">Guardar</button>
	</div>
</form>


@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){

      $('.select3').select2();

    });
  </script>
@endif




