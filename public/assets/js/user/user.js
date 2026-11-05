$(document).ready(function () {

	// Evento de selección de rol
	$('.selectrol').on('click', function (event) {
		event.preventDefault();

		var idrol = $(this).attr("id");
		var rolNombre = $(this).attr('data-rol-nombre');
		var _token = $('#token').val();

		// Limpiar contenido previo
		$(".listadoopciones").html("");

		// Remover clase active de todos los enlaces (Bootstrap 5)
		$(".menu-roles li a").removeClass("active");

		// Agregar clase active al enlace clickeado
		$(this).addClass("active");

		// Mostrar spinner de carga
		$(".listadoopciones").html(`
			<div class="text-center py-5">
				<div class="spinner-border text-primary mb-3" role="status">
					<span class="visually-hidden">Cargando...</span>
				</div>
				<p class="text-secondary mb-0">Cargando permisos para <strong>${rolNombre}</strong>...</p>
			</div>
		`);

		// Petición AJAX
		$.ajax({
			type: "POST",
			url: (window.baseUrl ? window.baseUrl : '') + "/ajax-listado-de-opciones",
			data: {
				_token: _token,
				idrol: idrol
			},
			success: function (data) {
				$(".listadoopciones").html(data);
			},
			error: function (data) {
				console.log('Error:', data);
				$(".listadoopciones").html(`
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<i class="ri-error-warning-line me-2"></i>
						<strong>Error:</strong> No se pudieron cargar los permisos. Por favor, intente nuevamente.
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				`);
			}
		});

	});


	// Revista virtual (mantener funcionalidad existente)
	$('.btn_rn').on('click', function (event) {
		event.preventDefault();

		var dni = $('#dni').val();
		var _token = $('#token').val();

		$.ajax({
			type: "POST",
			url: (window.baseUrl ? window.baseUrl : '') + "/ver-revista-virtual",
			data: {
				_token: _token,
				dni: dni
			},
			success: function (data) {
				if (data == "1") {
					window.open("https://www.flipsnack.com/rdinduamerica/revista-induamerica.html");
				} else {
					alerterrorajax('DNI no existe');
				}
			},
			error: function (data) {
				console.log('Error:', data);
			}
		});

	});


	// ===== NUEVO: Manejo de permisos con switches (Bootstrap 5) =====
	// Detectar cambios directamente en el input (switch)
	$(".listadoopciones").on('change', 'input[type="checkbox"]', function () {
		// debugger;
		var input = $(this);
		var label = input.siblings('label');
		var accion = label.attr('data-atr');
		var name = label.attr('name');
		var _token = $('#token').val();
		var check = -1;
		var estado = -1;

		// Verificar el estado ACTUAL del checkbox después del cambio
		if (input.is(':checked')) {
			check = 1;
			estado = true;
		} else {
			check = 0;
			estado = false;
		}
		// alertajax("TEST");

		data = validarrelleno(accion, name, estado, check, _token);
		debugger;
		$.ajax({
			type: "POST",
			url: (window.baseUrl ? window.baseUrl : '') + "/ajax-activar-permisos",
			data: data,
			success: function (data) {
				alertajax("Realizado con éxito");
				console.log(data);
			},
			error: function (data) {
				console.log('Error:', data);
				// Mostrar alerta de error con Bootstrap 5
				mostrarAlertaError("Error al actualizar permisos");
			}
		});

	});


	// Función de validación de permisos
	function validarrelleno(accion, name, estado, check, token) {

		var ver = 0, anadir = 0, modificar = 0, todas = 0;
		var data = {};

		if (accion == 'todas') {
			$("#1" + name).prop("checked", estado);
			$("#2" + name).prop("checked", estado);
			$("#3" + name).prop("checked", estado);

			data = {
				_token: token,
				idrolopcion: name,
				ver: check,
				anadir: check,
				modificar: check,
				todas: check
			};

		} else {

			if (accion == 'ver') {
				if (estado == false) {
					$("#2" + name).prop("checked", estado);
					$("#3" + name).prop("checked", estado);
					$("#4" + name).prop("checked", estado);

					data = {
						_token: token,
						idrolopcion: name,
						ver: 0,
						anadir: 0,
						modificar: 0,
						todas: 0
					}
				} else {
					data = {
						_token: token,
						idrolopcion: name,
						ver: 1,
						anadir: 0,
						modificar: 0,
						todas: 0
					}
				}

			} else if (accion == 'anadir') {

				if (estado == false) {
					$("#4" + name).prop("checked", estado);

					if ($("#1" + name).is(':checked')) { ver = 1; } else { ver = 0; }
					if ($("#3" + name).is(':checked')) { modificar = 1; } else { modificar = 0; }
					if ($("#4" + name).is(':checked')) { todas = 1; } else { todas = 0; }

					data = {
						_token: token,
						idrolopcion: name,
						ver: ver,
						anadir: 0,
						modificar: modificar,
						todas: todas
					}

				} else {
					$("#1" + name).prop("checked", estado);

					if ($("#1" + name).is(':checked')) { ver = 1; } else { ver = 0; }
					if ($("#3" + name).is(':checked')) { modificar = 1; } else { modificar = 0; }
					if (ver == 1 && modificar == 1) { $("#4" + name).prop("checked", estado); }
					if ($("#4" + name).is(':checked')) { todas = 1; } else { todas = 0; }

					data = {
						_token: token,
						idrolopcion: name,
						ver: ver,
						anadir: 1,
						modificar: modificar,
						todas: todas
					}
				}

			} else {
				// accion == 'modificar'
				if (estado == false) {
					$("#4" + name).prop("checked", estado);

					if ($("#1" + name).is(':checked')) { ver = 1; } else { ver = 0; }
					if ($("#2" + name).is(':checked')) { anadir = 1; } else { anadir = 0; }
					if ($("#4" + name).is(':checked')) { todas = 1; } else { todas = 0; }

					data = {
						_token: token,
						idrolopcion: name,
						ver: ver,
						anadir: anadir,
						modificar: 0,
						todas: todas
					}

				} else {
					$("#1" + name).prop("checked", estado);

					if ($("#1" + name).is(':checked')) { ver = 1; } else { ver = 0; }
					if ($("#2" + name).is(':checked')) { anadir = 1; } else { anadir = 0; }
					if (ver == 1 && anadir == 1) { $("#4" + name).prop("checked", estado); }
					if ($("#4" + name).is(':checked')) { todas = 1; } else { todas = 0; }

					data = {
						_token: token,
						idrolopcion: name,
						ver: ver,
						anadir: anadir,
						modificar: 1,
						todas: todas
					}
				}
			}
		}

		return data;
	}


	// Función auxiliar para mostrar alertas de error (Bootstrap 5)
	function mostrarAlertaError(mensaje) {
		const alertaHtml = `
			<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" 
				 role="alert" 
				 style="z-index: 9999; min-width: 300px;">
				<i class="ri-error-warning-line me-2"></i>
				<strong>Error:</strong> ${mensaje}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		`;

		$('body').append(alertaHtml);

		// Auto-cerrar después de 5 segundos
		setTimeout(function () {
			$('.alert').fadeOut('slow', function () {
				$(this).remove();
			});
		}, 5000);
	}



});
