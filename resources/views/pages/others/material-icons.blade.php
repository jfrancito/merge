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
                        <h3 class="mb-0">Material Symbols</h3>

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
                                    <span class="fw-medium">Material Symbols</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4 text-center">
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;span class="material-symbols-outlined"&gt;search&lt;/span&gt;
</code>
</pre>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">search</i>
                                    <span class="d-block mt-4">search</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">home</i>
                                    <span class="d-block mt-4">home</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">menu</i>
                                    <span class="d-block mt-4">menu</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">close</i>
                                    <span class="d-block mt-4">close</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">settings</i>
                                    <span class="d-block mt-4">settings</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">done</i>
                                    <span class="d-block mt-4">done</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">expand_more</i>
                                    <span class="d-block mt-4">expand_more</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">search</i>
                                    <span class="d-block mt-4">search</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">check_circle</i>
                                    <span class="d-block mt-4">check_circle</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">favorite</i>
                                    <span class="d-block mt-4">favorite</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">add</i>
                                    <span class="d-block mt-4">add</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">arrow_back</i>
                                    <span class="d-block mt-4">arrow_back</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">star</i>
                                    <span class="d-block mt-4">star</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">chevron_right</i>
                                    <span class="d-block mt-4">chevron_right</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">logout</i>
                                    <span class="d-block mt-4">logout</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">arrow_forward_ios</i>
                                    <span class="d-block mt-4">arrow_forward_ios</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">add_circle</i>
                                    <span class="d-block mt-4">add_circle</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">cancel</i>
                                    <span class="d-block mt-4">cancel</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">arrow_back_ios</i>
                                    <span class="d-block mt-4">arrow_back_ios</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">arrow_forward</i>
                                    <span class="d-block mt-4">arrow_forward</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">arrow_drop_down</i>
                                    <span class="d-block mt-4">arrow_drop_down</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">check</i>
                                    <span class="d-block mt-4">check</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">check_box</i>
                                    <span class="d-block mt-4">check_box</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">toggle_on</i>
                                    <span class="d-block mt-4">toggle_on</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">open_in_new</i>
                                    <span class="d-block mt-4">open_in_new</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">grade</i>
                                    <span class="d-block mt-4">grade</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">refresh</i>
                                    <span class="d-block mt-4">refresh</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">check_box_outline_blank</i>
                                    <span class="d-block mt-4">check_box_outline_blank</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">login</i>
                                    <span class="d-block mt-4">login</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 text-center">
                                    <i class="material-symbols-outlined">chevron_left</i>
                                    <span class="d-block mt-4">chevron_left</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center mb-4">
                            <a href="https://fonts.google.com/icons" target="_blank" class="btn btn-primary py-2 px-4 text-decoration-none rounded-pill">
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
