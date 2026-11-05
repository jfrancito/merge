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
                        <h3 class="mb-0">Calendar</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Apps</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Calendar</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="calendar-wrap">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="mb-3 mb-lg-4">
                                        <h3 class="mb-0">Working Schedule</h3>
                                    </div>
                                    <div class="calendar-wraps">
                                        <div id="calendari"></div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="fw-medium">Upcoming Events:</span>
                                        <div class="swiper-pagination1 text-end" style="width: 100px;"></div>
                                    </div>

                                    <div class="swiper upcoming-events-slide">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide cursor">
                                                <div class="position-relative d-flex">
                                                    <span class="wh-11 bg-primary rounded-1 d-inline-block position-relative top-1"></span>
                                                    <div>
                                                        <h4 class="fs-12 fw-semibold text-secondary mb-0 ms-1"> Pythons Unleashed: A Development Expedition</h4>
                                                        <p class="fs-12"><span class="text-primary">April 15, 2024</span> -  12.00 PM - 6.00 PM</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide cursor">
                                                <div class="position-relative d-flex">
                                                    <span class="wh-11 bg-primary rounded-1 d-inline-block position-relative top-1"></span>
                                                    <div>
                                                        <h4 class="fs-12 fw-semibold text-secondary mb-0 ms-1"> Big Data Analytics</h4>
                                                        <p class="fs-12"><span class="text-primary">15 Mar 2024</span> -  01.00 PM - 7.00 PM</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide cursor">
                                                <div class="position-relative d-flex">
                                                    <span class="wh-11 bg-primary rounded-1 d-inline-block position-relative top-1"></span>
                                                    <div>
                                                        <h4 class="fs-12 fw-semibold text-secondary mb-0 ms-1">Introduction to Blockchain</h4>
                                                        <p class="fs-12"><span class="text-primary">10 Mar 2024</span> -  02.00 PM - 9.00 PM</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
