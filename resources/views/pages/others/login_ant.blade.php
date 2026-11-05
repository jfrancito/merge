<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Iniciar Session en el Aplicativo Movil</title>
		<!-- Styles -->
		@include('partials.styles')
	</head>
	<body class="boxed-size bg-white">
		@include('partials.preloader')
		@include('partials.error')


		<form action="{{ route('login.post') }}" 
		  method="POST" 
		  id="frmLoginMain"
		  class="needs-validation"
		  novalidate>
		@csrf

		<div class="container">
			<div class="main-content d-flex flex-column p-0">
				<div class="m-auto m-1230">
					<div class="row align-items-center">

						<div class="col-lg-6 d-none d-lg-block">
							<img src="assets/images/login.jpg" class="rounded-3" alt="login">
						</div>

						<div class="col-lg-6">
							<div class="mw-480 ms-lg-auto">

								<a href="index" class="d-inline-block mb-4">
									<img src="assets/images/logo.svg" class="rounded-3 for-light-logo" alt="login">
									<img src="assets/images/white-logo.svg" class="rounded-3 for-dark-logo" alt="login">
								</a>

								<h3 class="fs-28 mb-2">Bienvenido de vuelta a AppMovil!</h3>

								<!-- EMAIL -->
								<div class="form-group mb-4">
									<label class="label text-secondary">Email</label>
									<input name="email" type="email" class="form-control h-55" 
										   placeholder="example@appmovil.com" required>
									<div class="invalid-feedback">
										Por favor ingresa tu correo electrónico.
									</div>
								</div>

								<!-- PASSWORD -->
								<div class="form-group mb-4">
									<label class="label text-secondary">Password</label>
									<input name="password" type="password" class="form-control h-55"
										   placeholder="password ***" required minlength="4">
									<div class="invalid-feedback">
										La contraseña es obligatoria.
									</div>
								</div>

								<!-- SUBMIT -->
								<div class="form-group mb-4">
									<button type="submit" class="btn btn-primary fw-medium py-2 px-3 w-100">
										<div class="d-flex align-items-center justify-content-center py-1">
											<i class="material-symbols-outlined text-white fs-20 me-2">login</i>
											<span>Login</span>
										</div>
									</button>
								</div>

								<div class="form-group">
									<p>Aún no tienes una Cuenta?  
										<a href="register" class="fw-medium text-primary text-decoration-none">
											Registrarse
										</a>
									</p>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</form>

		<button class="theme-settings-btn p-0 border-0 bg-transparent position-absolute" style="right: 30px; bottom: 30px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
			<i class="material-symbols-outlined bg-primary wh-35 lh-35 text-white rounded-1" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Click On Theme Settings">settings</i>
		</button>
		
		{{-- <script>console.log("Existe $:", typeof $);</script> --}}

		
		@include('partials.theme_settings')
		@include('partials.scripts')

	
			
		@vite(['resources/js/app.js']) {{-- AQUI DEBE IR VITE --}}
			
		<script src="{{ asset('/js/login/app.js?v='.$version) }}" type="text/javascript"></script>
		
		<script>
			
		</script>

			


	</body>
</html>
