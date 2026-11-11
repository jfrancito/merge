
<div class="modal-header" style="background-color: #4285f4; color: white;">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close" style="color: white;"></span></button>
	<h3 class="modal-title">
		 <i class="mdi mdi-lock" style="margin-right: 10px;"></i><b>Seguridad: Cambiar Contraseña</b>
	</h3>
</div>
<div class="modal-body" style="padding: 30px;">
	<form method="POST" action="{{ url('/ajax-cambiar-clave') }}" id="form_cambiar_clave">
		{{ csrf_field() }}
		
		<div class="form-group">
			<label class="control-label" style="font-weight: bold; color: #555;">Contraseña Antigua</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="mdi mdi-lock-open"></i></span>
				<input type="password" id="old_pass" name="old_pass" class="form-control" required placeholder="Ingrese su contraseña actual">
			</div>
			<small class="text-muted">Por seguridad, verifique su identidad.</small>
		</div>

		<hr style="border-top: 1px dashed #ccc;">

		<div class="form-group">
			<label class="control-label" style="font-weight: bold; color: #555;">Nueva Contraseña</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="mdi mdi-key"></i></span>
				<input type="password" id="pass" name="pass" class="form-control" required placeholder="Mínimo 6 caracteres + Criterios">
			</div>
			<small class="text-muted">Debe incluir: Mayúscula, Minúscula, Número y Carácter Especial.</small>
		</div>

		<div class="form-group">
			<label class="control-label" style="font-weight: bold; color: #555;">Confirmar Nueva Contraseña</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="mdi mdi-check"></i></span>
				<input type="password" id="pass_confirm" name="pass_confirm" class="form-control" required placeholder="Repita la nueva contraseña">
			</div>
		</div>

		<div class="row" style="margin-top: 30px;">
			<div class="col-xs-6">
				<button type="submit" class="btn btn-primary btn-lg btn-block btn-guardar-clave" style="border-radius: 4px; font-weight: bold;">
					<i class="mdi mdi-floppy" style="margin-right: 5px;"></i> ACTUALIZAR
				</button>
			</div>
			<div class="col-xs-6">
				<button type="button" data-dismiss="modal" class="btn btn-default btn-lg btn-block" style="border-radius: 4px;">CANCELAR</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $("#form_cambiar_clave").submit(function(e){
        e.preventDefault();
        var old_pass = $("#old_pass").val();
        var pass = $("#pass").val();
        var pass_confirm = $("#pass_confirm").val();

        if(old_pass == ""){
            alerterrorajax("Debe ingresar su contraseña antigua");
            return false;
        }

        if(pass != pass_confirm){
            alerterrorajax("Las nuevas contraseñas no coinciden");
            return false;
        }

        if(pass.length < 6){
            alerterrorajax("La nueva contraseña debe tener al menos 6 caracteres");
            return false;
        }

        if(pass == old_pass){
            alerterrorajax("La nueva contraseña no puede ser igual a la anterior");
            return false;
        }

        // Regex para validar: Al menos una mayúscula, una minúscula, un número y un carácter especial
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/;
        if(!regex.test(pass)){
            alerterrorajax("La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial");
            return false;
        }

        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta + "/ajax-cambiar-clave",
            data    :   $(this).serialize(),
            success: function (data) {
                cerrarcargando();
                if(data.indexOf("Error") > -1){
                    alerterrorajax(data);
                }else{
                    window.location.href = "{{ url('/bienvenido') }}";
                }
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });
    });
  });
</script>
