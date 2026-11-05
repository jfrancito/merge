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
                        <h3 class="mb-0">FeatherIcon</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Icons</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">FeatherIcon</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4 text-center">
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;i data-feather="circle"&gt;&lt;/i&gt;
</code>
</pre>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="activity"></i>
                                    <span class="d-block mt-4">activity</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="airplay"></i>
                                    <span class="d-block mt-4">airplay</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="alert-circle"></i>
                                    <span class="d-block mt-4">alert-circle</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="alert-octagon"></i>
                                    <span class="d-block mt-4">alert-octagon</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="alert-triangle"></i>
                                    <span class="d-block mt-4">alert-triangle</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="align-center"></i>
                                    <span class="d-block mt-4">align-center</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="align-justify"></i>
                                    <span class="d-block mt-4">align-justify</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="align-left"></i>
                                    <span class="d-block mt-4">align-left</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="align-right"></i>
                                    <span class="d-block mt-4">align-right</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="anchor"></i>
                                    <span class="d-block mt-4">anchor</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="aperture"></i>
                                    <span class="d-block mt-4">aperture</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="arrow-down-circle"></i>
                                    <span class="d-block mt-4">arrow-down-circle</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="arrow-down-left"></i>
                                    <span class="d-block mt-4">arrow-down-left</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="arrow-down-right"></i>
                                    <span class="d-block mt-4">arrow-down-right</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="arrow-down"></i>
                                    <span class="d-block mt-4">arrow-down</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="arrow-left-circle"></i>
                                    <span class="d-block mt-4">arrow-left-circle</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="arrow-left"></i>
                                    <span class="d-block mt-4">arrow-left</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="bar-chart"></i>
                                    <span class="d-block mt-4">bar-chart</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="battery-charging"></i>
                                    <span class="d-block mt-4">battery-charging</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="battery"></i>
                                    <span class="d-block mt-4">battery</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="bell-off"></i>
                                    <span class="d-block mt-4">bell-off</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="bell"></i>
                                    <span class="d-block mt-4">bell</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="bluetooth"></i>
                                    <span class="d-block mt-4">bluetooth</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="bold"></i>
                                    <span class="d-block mt-4">bold</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="book-open"></i>
                                    <span class="d-block mt-4">book-open</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="book"></i>
                                    <span class="d-block mt-4">book</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="bookmark"></i>
                                    <span class="d-block mt-4">bookmark</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="box"></i>
                                    <span class="d-block mt-4">box</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="briefcase"></i>
                                    <span class="d-block mt-4">briefcase</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i data-feather="calendar"></i>
                                    <span class="d-block mt-4">calendar</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center mb-4">
                            <a href="https://feathericons.com/" target="_blank" class="btn btn-primary py-2 px-4 text-decoration-none rounded-pill">
                                <span class="d-inline-block py-1">View All Icons</span>
                            </a>
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
