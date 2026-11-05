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
                        <h3 class="mb-0">Apex Line Charts</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Apex Charts</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Basic Line Chart</h3>
                                    <div id="product_trends_by_month"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Line with Data Labels</h3>
                                    <div id="average_high_low_temperature"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Stepline Chart</h3>
                                    <div id="stepline_chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Dashed</h3>
                                    <div id="page_statistics"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-center mb-4">
                                <a href="https://apexcharts.com/javascript-chart-demos/line-charts/" target="_blank" class="btn btn-primary py-3 px-4 fs-16 fw-medium text-decoration-none d-inline-block">
                                    View All Line Charts
                                </a>
                                <a href="https://apexcharts.com/javascript-chart-demos/" target="_blank" class="btn btn-success text-white py-3 px-4 fs-16 fw-medium text-decoration-none d-inline-block">
                                    View All Charts
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <h3 class="mb-0">Apex Area Charts</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Apex Charts</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Spline Area</h3>
                                    <div id="spline_area"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Negative Area</h3>
                                    <div id="area_with_negative_values"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-center mb-4">
                                <a href="https://apexcharts.com/javascript-chart-demos/area-charts/" target="_blank" class="btn btn-primary py-3 px-4 fs-16 fw-medium text-decoration-none d-inline-block">
                                    View All Area Charts
                                </a>
                                <a href="https://apexcharts.com/javascript-chart-demos/" target="_blank" class="btn btn-success text-white py-3 px-4 fs-16 fw-medium text-decoration-none d-inline-block">
                                    View All Charts
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <h3 class="mb-0">Apex BRB Charts</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Apex Charts</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Basic Bar Area</h3>
                                    <div id="basic_bar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Grouped</h3>
                                    <div id="grouped"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-center mb-4">
                                <a href="https://apexcharts.com/javascript-chart-demos/bar-charts/" target="_blank" class="btn btn-primary py-3 px-4 fs-16 fw-medium text-decoration-none d-inline-block">
                                    View All Bar Charts
                                </a>
                                <a href="https://apexcharts.com/javascript-chart-demos/" target="_blank" class="btn btn-success text-white py-3 px-4 fs-16 fw-medium text-decoration-none d-inline-block">
                                    View All Charts
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <h3 class="mb-0">Apex Column Charts</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Apex Charts</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Basic Column Area</h3>
                                    <div id="basic_column"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Column with Data Labels</h3>
                                    <div id="column_with_data_labels"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-center mb-4">
                                <a href="https://apexcharts.com/javascript-chart-demos/column-charts/" target="_blank" class="btn btn-primary py-3 px-4 fs-16 fw-medium text-decoration-none d-inline-block">
                                    View All Column Charts
                                </a>
                                <a href="https://apexcharts.com/javascript-chart-demos/" target="_blank" class="btn btn-success text-white py-3 px-4 fs-16 fw-medium text-decoration-none d-inline-block">
                                    View All Charts
                                </a>
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
