<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trezo - Laravel Admin Dashboard Template</title>
        <!-- Styles -->
        @include('partials.styles')
    </head>
    <body class="boxed-size">
        @include('partials.preloader')
        @include('partials.sidebar')

        <div class="container-fluid">
			<div class="main-content d-flex flex-column">
				<!-- Start Header Area -->
				@include('partials.header')
				<!-- End Header Area -->

				<div class="main-content-container overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <h3 class="mb-0">Gallery</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Extra Pages</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Gallery</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4 pb-0">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="mb-4">
                                        <img src="assets/images/product-6.jpg" class="rounded-3" alt="product">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="mb-4">
                                        <img src="assets/images/product-7.jpg" class="rounded-3" alt="product">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="mb-4">
                                        <img src="assets/images/product-8.jpg" class="rounded-3" alt="product">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-4">
                                        <img src="assets/images/product-9.jpg" class="rounded-3" alt="product">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-4">
                                        <img src="assets/images/product-10.jpg" class="rounded-3" alt="product">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-4">
                                        <img src="assets/images/product-11.jpg" class="rounded-3" alt="product">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-4">
                                        <img src="assets/images/product-12.jpg" class="rounded-3" alt="product">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="mb-4">
                                        <img src="assets/images/product-13.jpg" class="rounded-3" alt="product">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="mb-4">
                                        <img src="assets/images/product-14.jpg" class="rounded-3" alt="product">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

				<div class="flex-grow-1"></div>

				<!-- Start Footer Area -->
				@include('partials.footer')
				<!-- End Footer Area -->
			</div>
		</div>

        
        @include('partials.theme_settings')
        @include('partials.scripts')
    </body>
</html>
