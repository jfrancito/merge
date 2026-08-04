
<form method="POST" action="{{ url('/configurar-grupo-marketing/'.$orden_id.'/'.$idopcion) }}">
      {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>

	<div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
		<h3 class="modal-title">
			 <b>Datos de la Grupo</b>
		</h3>
	</div>
	<div class="modal-body">
		<div  class="row regla-modal">
		    <div class="col-md-12">

		        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Grupo</label>
		                <div class="col-sm-12 abajocaja" >
                        <input  type="text"
                                id="grupo" name='grupo' value="" placeholder="Grupo"
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

      $('.select3').select2();
      $('.importe').inputmask({ 'alias': 'numeric', 
      'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 
      'digitsOptional': false, 
      'prefix': '', 
      'placeholder': '0'});

	    $('.cuentanumero').on('keypress', function (e) {
	        // Permitir solo números (0-9)
	        var charCode = e.which ? e.which : e.keyCode;
	        if (charCode < 48 || charCode > 57) {
	            e.preventDefault(); // Evita que se inserten caracteres no válidos
	        }
	    });

	    // Opcional: evitar pegar texto que no sea numérico
	    $('.cuentanumero').on('paste', function (e) {
	        var pasteData = e.originalEvent.clipboardData.getData('text');
	        if (!/^\d+$/.test(pasteData)) {
	            e.preventDefault(); // Evita que se peguen caracteres no válidos
	        }
	    });



    });
  </script>
@endif
