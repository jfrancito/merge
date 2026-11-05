<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title', 'LOTEAME - Gestión Inmobiliaria')</title>

	<link rel="manifest" href="{{ asset('manifest.json') }}">
	<link rel="icon" href="{{ asset('assets/images/loteame/favicon.ico') }}" type="image/x-icon">
	<link rel="shortcut icon" href="{{ asset('assets/images/loteame/favicon.ico') }}" type="image/x-icon">
	<link rel="apple-touch-icon" href="{{ asset('assets/images/loteame/favicon.png') }}">
	<link rel="icon" href="{{ asset('assets/images/loteame/favicon.png') }}" type="image/png">

	<!-- jQuery en el HEAD para que esté disponible para todos los plugins -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

	<script>
		// Detección automática de subdirectorio (para compatibilidad dual: localhost/bi y bi.test)
		var carpeta = "{{ $carpeta ?? '' }}"; // ej: '/bi'
		window.baseUrl = "{{ url('/') }}";    // ej: 'http://localhost'

		// Si estamos corriendo bajo /bi pero Laravel piensa que es root, corregimos la URL base
		if (carpeta && window.location.pathname.indexOf(carpeta) === 0 && window.baseUrl.indexOf(carpeta) === -1) {
			window.baseUrl = window.location.origin + carpeta;
		}

		if ('serviceWorker' in navigator) {
			navigator.serviceWorker.register("{{ asset('sw.js') }}")
				.then(reg => console.log('Service Worker registrado', reg))
				.catch(err => console.error('SW error', err));
		}

		// Configuración global de DataTables en español
		window.dtSpanish = {
			"processing": "Procesando...",
			"lengthMenu": "Mostrar _MENU_ registros",
			"zeroRecords": "No se encontraron resultados",
			"emptyTable": "Ningún dato disponible en esta tabla",
			"info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
			"infoFiltered": "(filtrado de un total de _MAX_ registros)",
			"infoPostFix": "",
			"search": "Buscar:",
			"url": "",
			"thousands": ",",
			"loadingRecords": "Cargando...",
			"paginate": {
				"first": "Primero",
				"last": "Último",
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"aria": {
				"sortAscending": ": Activar para ordenar la columna de manera ascendente",
				"sortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		};
	</script>


	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">

	<link rel="stylesheet" href="{{ asset('assets/css/base/trezo-breadcrumb.css?v=' . $version) }}">

	<!-- Styles -->
	@include('partials.styles')

	@stack('styles')
</head>

<body class="boxed-size">
	{{-- @include('partials.preloader') --}}
	@include('partials.alerts')
	@include('partials.sidebar')
	<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
	<input type='hidden' id='carpeta' value="{{$carpeta}}" />

	<div class="container-fluid">
		<div class="main-content d-flex flex-column">
			<!-- Start Header Area -->
			@include('partials.header')
			<!-- End Header Area -->

			<div class="main-content-container overflow-hidden">
				<!-- Breadcrumb Section (Optional) -->
				@hasSection('breadcrumb')
					@yield('breadcrumb')
				@endif


				<!-- Main Content -->
				@yield('content')
			</div>

			<div class="flex-grow-1"></div>

			<!-- Start Footer Area -->
			@include('partials.footer')
			<!-- End Footer Area -->
		</div>
	</div>

	@include('partials.theme_settings')

	@yield('modals')

	<!-- Scripts de Bootstrap y otros -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

	<!-- 3. Bootstrap y otros scripts -->
	@include('partials.scripts')

	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<!-- 4. Vite assets -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])

	<!-- 5. Custom scripts -->
	<script src="{{ asset('/assets/js/custom/custom.js') }}"></script>
	<script src="{{ asset('/assets/js/custom/general.js?version=' . $version) }}"></script>

	<!-- 6. Scripts adicionales de las páginas AL FINAL -->
	@stack('scripts')

	<script>
		// Seguro final para asegurar que Select2 se inicialice después de TODO
		window.addEventListener('load', function () {
			if (window.initSelect2) {
				window.initSelect2();
			}
		});
	</script>





</body>

</html>