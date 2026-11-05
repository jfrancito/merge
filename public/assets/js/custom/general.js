(function () {
	"use strict";

	window.onload = function () {
	};

	// ✅ SOLUCIÓN: Evitar que el modal de carga se quede pegado al dar "Atrás" en el navegador
	window.addEventListener('pageshow', function (event) {
		if (event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2)) {
			cerrarcargando();
		}
	});

	/************************ modal cargando ************************/
	$('.opcmenu').on('click', function (e) {
		abrircargando('Cargando Opción...');
	});

	function setMensajeCargando(mensaje) {
		var cadmensaje = '';
		if ((mensaje === undefined) || (mensaje == '')) {
			cadmensaje = "Procesando la información";
		}
		else {
			cadmensaje = mensaje;
		}
		return cadmensaje;
	}

	// ✅ EXPONER cerrarcargando al scope global
	window.cerrarcargando = function () {
		$("#WindowLoad").fadeOut(200, function () {
			$(this).remove();
		});
	}

	// ✅ EXPONER abrircargando al scope global - VERSIÓN PREMIUM
	window.abrircargando = function (mensaje) {
		cerrarcargando();

		var msg = mensaje || "Procesando información";

		var html = `
			<div id="WindowLoad" style="
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: rgba(15, 23, 42, 0.7);
				backdrop-filter: blur(8px);
				-webkit-backdrop-filter: blur(8px);
				z-index: 999999;
				display: flex;
				justify-content: center;
				align-items: center;
				opacity: 0;
				transition: opacity 0.3s ease;
			">
				<div style="
					background: rgba(255, 255, 255, 0.1);
					padding: 40px 60px;
					border-radius: 24px;
					border: 1px solid rgba(255, 255, 255, 0.2);
					box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
					text-align: center;
					max-width: 400px;
					width: 90%;
				">
					<!-- Spinner Animado -->
					<div class="custom-loader" style="
						width: 50px;
						height: 50px;
						border: 4px solid rgba(255, 255, 255, 0.1);
						border-left-color: #ffffff;
						border-radius: 50%;
						margin: 0 auto 24px;
						animation: spin 1s linear infinite;
					"></div>
					
					<h4 style="
						color: #ffffff;
						margin: 0;
						font-family: 'Inter', sans-serif;
						font-size: 18px;
						font-weight: 600;
						letter-spacing: -0.01em;
					">${msg}</h4>
					
					<p style="
						color: rgba(255, 255, 255, 0.6);
						margin: 8px 0 0;
						font-size: 14px;
					">Por favor, espera un momento...</p>
				</div>
			</div>
			<style>
				@keyframes spin {
					to { transform: rotate(360deg); }
				}
			</style>
		`;

		$('body').append(html);

		// Force reflow for transition
		setTimeout(() => {
			$('#WindowLoad').css('opacity', '1');
		}, 10);
	}

	// Versión alternativa con spinner CSS (por si no hay gif)
	window.abrircargandoSimple = function (mensaje) {
		cerrarcargando();

		mensaje = setMensajeCargando(mensaje);

		var html = `
			<div id="WindowLoad" style="
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: rgba(0, 0, 0, 0.8);
				z-index: 99999;
				display: flex;
				justify-content: center;
				align-items: center;
			">
				<div style="text-align: center; color: white;">
					<div class="spinner-border text-light" role="status" style="width: 4rem; height: 4rem; margin-bottom: 20px;">
						<span class="visually-hidden">Cargando...</span>
					</div>
					<div class="msjcargando" style="font-size: 18px; font-weight: 600;">
						${mensaje}
					</div>
				</div>
			</div>
		`;

		$('body').append(html);
	}

	window.showAlertBS5 = function (texto, tipo, contenedor, velocidad = 100) {
		const id = "rd" + Math.floor((Math.random() * 500) + 1);

		const html = `
	        <div id="${id}" class="alert alert-${tipo} alert-dismissible fade show alertawrelative" role="alert"
	            style="z-index:999999;">
	            <span class="icon mdi mdi-check"></span>
	            <strong>${tipo === "success" ? "Bien Hecho!" : "Error!"}</strong> ${texto}
	            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	        </div>
	    `;

		$(contenedor).append(html);
		setTimeout(() => {
			const $alert = $("#" + id);

			$alert.fadeOut(velocidad, function () {
				// Bootstrap 5 destruye la alerta completamente
				const alertInstance = bootstrap.Alert.getOrCreateInstance($alert[0]);
				alertInstance.close();
			});

		}, velocidad);

	};


	window.alertmobil = function (texto) {
		showAlertBS5(texto, "success", ".panel-ajax-alert-mobil", 100);
	};

	window.alertdangermobil = function (texto) {
		showAlertBS5(texto, "danger", ".panel-ajax-alert-mobil", 100);
	};

	window.alertdangermobil_lenta = function (texto) {
		showAlertBS5(texto, "danger", ".panel-ajax-alert-mobil", 1000);
	};

	window.alertajax = function (texto) {
		// debugger;
		showAlertBS5(texto, "success", ".panel-ajax-alert", 1200);
	};

	window.alerterrorajax = function (texto) {
		showAlertBS5(texto, "danger", ".panel-ajax-alert", 2500);
	};

	window.alerterrorajaxflotante = function (texto) {
		showAlertBS5(texto, "danger", ".panel-ajax-alert-flotante", 2500);
	};

	window.alerterror505ajax = function (texto) {
		showAlertBS5(texto, "danger", ".panel-ajax-alert", 3000);
	};


})();

document.addEventListener("DOMContentLoaded", function () {
	// 1. Manejo de Formularios (Inserción/Modificación)
	const forms = document.querySelectorAll('.frmcargando, .needs-validation');

	forms.forEach(function (form) {
		form.addEventListener('submit', function (event) {
			if (form.checkValidity()) {
				// Sacar el mensaje del atributo data-loading-msg si existe, sino usar default
				const customMsg = form.getAttribute('data-loading-msg') || "Procesando la información";
				abrircargando(customMsg);
			}
			form.classList.add('was-validated');
		}, false);
	});
});

// Función global para inicializar Select2
window.initSelect2 = function () {
	if (typeof jQuery === 'undefined' || !jQuery.fn.select2) {
		return;
	}

	jQuery('.form-select').each(function () {
		const $this = jQuery(this);

		// Solo inicializar si no ha sido inicializado
		if (!$this.hasClass('select2-hidden-accessible')) {
			$this.select2({
				theme: 'bootstrap-5',
				width: '100%',
				placeholder: $this.data('placeholder') || 'Seleccione...',
				allowClear: Boolean($this.data('allow-clear')),
				minimumResultsForSearch: 0,
				// Si está en un modal, el parent DEBE ser el modal para evitar bloqueos de foco
				dropdownParent: $this.closest('.modal').length ? $this.closest('.modal') : jQuery(document.body),
				language: {
					noResults: function () { return "No se encontraron resultados"; },
					searching: function () { return "Buscando..."; }
				}
			});

			// Select2 ya dispara el evento 'change' por defecto, no es necesario re-dispararlo manualmente
			// para evitar bucles infinitos.
		}
	});
};

// Problema conocido: Select2 + Bootstrap Modal causa que la página se cuelgue por conflicto de foco
// Esta solución previene el bucle infinito de foco
jQuery(document).on('focusin', function (e) {
	if (jQuery(e.target).closest(".select2-container").length) {
		e.stopImmediatePropagation();
	}
});

// Inicializar una sola vez al estar listos
jQuery(function () {
	window.initSelect2();
});

// Re-inicializar si se abren modales dinámicos
jQuery(document).on('shown.bs.modal', function () {
	window.initSelect2();
});