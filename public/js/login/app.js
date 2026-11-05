document.addEventListener("DOMContentLoaded", () => {
	console.log("DOM listo");

	$('#frmLoginMain').on('submit', function (e) {

		let email = $('input[name="email"]').val().trim();
		let pass  = $('input[name="password"]').val().trim();
		let valido = true;

		// Eliminar mensajes previos
		$('.is-invalid').removeClass('is-invalid');

		// Validar email
		if (email === '') {
			$('input[name="email"]').addClass('is-invalid');
			valido = false;
		}

		// Validar password
		if (pass === '') {
			$('input[name="password"]').addClass('is-invalid');
			valido = false;
		}

		// Si no es válido, detener envío del form
		if (!valido) {
			e.preventDefault();
			return false;
		}

		return true;
	});

});