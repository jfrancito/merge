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
                        <h3 class="mb-0">RemixIcon</h3>

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
                                    <span class="fw-medium">RemixIcon</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4 text-center">
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;i class="ri-home-7-line"&gt;&lt;/i&gt;
</code>
</pre>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-home-7-line fs-20"></i>
                                    <span class="d-block mt-4">ri-home-7-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-store-2-line fs-20"></i>
                                    <span class="d-block mt-4">ri-store-2-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-mail-open-line fs-20"></i>
                                    <span class="d-block mt-4">ri-mail-open-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-cloud-line fs-20"></i>
                                    <span class="d-block mt-4">ri-cloud-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-bar-chart-box-line fs-20"></i>
                                    <span class="d-block mt-4">ri-bar-chart-box-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-calendar-todo-line fs-20"></i>
                                    <span class="d-block mt-4">ri-calendar-todo-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-global-line fs-20"></i>
                                    <span class="d-block mt-4">ri-global-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-flag-2-fill fs-20"></i>
                                    <span class="d-block mt-4">ri-flag-2-fill</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-service-line fs-20"></i>
                                    <span class="d-block mt-4">ri-service-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-megaphone-line fs-20"></i>
                                    <span class="d-block mt-4">ri-megaphone-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-message-2-line fs-20"></i>
                                    <span class="d-block mt-4">ri-message-2-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-chat-quote-line fs-20"></i>
                                    <span class="d-block mt-4">ri-chat-quote-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-emoji-sticker-line fs-20"></i>
                                    <span class="d-block mt-4">ri-emoji-sticker-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-ball-pen-line fs-20"></i>
                                    <span class="d-block mt-4">ri-ball-pen-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-contrast-2-line fs-20"></i>
                                    <span class="d-block mt-4">ri-contrast-2-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-collage-line fs-20"></i>
                                    <span class="d-block mt-4">ri-collage-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-bug-fill fs-20"></i>
                                    <span class="d-block mt-4">ri-bug-fill</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-scan-line fs-20"></i>
                                    <span class="d-block mt-4">ri-scan-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-wifi-off-fill fs-20"></i>
                                    <span class="d-block mt-4">ri-wifi-off-fill</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-eth-line fs-20"></i>
                                    <span class="d-block mt-4">ri-eth-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-cup-line fs-20"></i>
                                    <span class="d-block mt-4">ri-cup-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-cake-3-line fs-20"></i>
                                    <span class="d-block mt-4">ri-cake-3-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-angularjs-line fs-20"></i>
                                    <span class="d-block mt-4">ri-angularjs-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-edge-new-fill fs-20"></i>
                                    <span class="d-block mt-4">ri-edge-new-fill</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-xbox-line fs-20"></i>
                                    <span class="d-block mt-4">ri-xbox-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-map-pin-line fs-20"></i>
                                    <span class="d-block mt-4">ri-map-pin-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-rocket-line fs-20"></i>
                                    <span class="d-block mt-4">ri-rocket-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-bus-line fs-20"></i>
                                    <span class="d-block mt-4">ri-bus-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-motorbike-fill fs-20"></i>
                                    <span class="d-block mt-4">ri-motorbike-fill</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="ri-image-add-line fs-20"></i>
                                    <span class="d-block mt-4">ri-image-add-line</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center mb-4">
                            <a href="https://remixicon.com/" target="_blank" class="btn btn-primary py-2 px-4 text-decoration-none rounded-pill">
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
