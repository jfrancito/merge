<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>@yield('title', 'AppMovil')</title>
		
		<!-- Styles -->
		@include('partials.styles')
		
		<!-- Additional Styles -->
		@stack('styles')
		@push('styles')
			<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		@endpush

	</head>
	<body class="boxed-size">
		@include('partials.preloader')
		@include('partials.sidebar')
		@include('partials.alerts')

		<div class="container-fluid">
			<div class="main-content d-flex flex-column">
				<!-- Start Header Area -->
				@include('partials.header')
				<!-- End Header Area -->

				<div class="main-content-container overflow-hidden">
					<!-- Breadcrumb Section (Optional) -->
					@hasSection('breadcrumb')
						<div class="row">
							<div class="col-12">
								<div class="page-title-box d-flex align-items-center justify-content-between mb-4">
									<h4 class="mb-0">@yield('page-title')</h4>
									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											@yield('breadcrumb')
										</ol>
									</div>
								</div>
							</div>
						</div>
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
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		@include('partials.scripts')
		<script src="{{ url('/assets/js/custom/custom.js') }}"></script>
		{{-- AQUI DEBE IR VITE --}}
		<!-- Additional Scripts -->
		@stack('scripts')

	  
	</body>
</html>