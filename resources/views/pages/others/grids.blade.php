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
                        <h3 class="mb-0">Grids</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">UI Elements</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Grids</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Large Grid-Example</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview-tab-pane" type="button" role="tab" aria-controls="preview-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code-tab-pane" type="button" role="tab" aria-controls="code-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="preview-tab-pane" role="tabpanel" aria-labelledby="preview-tab" tabindex="0">
                                            <div class="row">
                                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center">
                                                        <p>col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode">
    &lt;div class="row"&gt;
        &lt;div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center"&gt;
                &lt;p&gt;col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 pb-0">
                                    <h4 class="fs-18 mb-4">Mid Grid-Example</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab2" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview2-tab" data-bs-toggle="tab" data-bs-target="#preview2-tab-pane" type="button" role="tab" aria-controls="preview2-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code2-tab" data-bs-toggle="tab" data-bs-target="#code2-tab-pane" type="button" role="tab" aria-controls="code2-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent2">
                                        <div class="tab-pane fade show active" id="preview2-tab-pane" role="tabpanel" aria-labelledby="preview2-tab" tabindex="0">
                                            <div class="row">
                                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4">
                                                        <p>col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6</p>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4">
                                                        <p>col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode2">
    &lt;div class="row"&gt;
        &lt;div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center"&gt;
                &lt;p&gt;col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center"&gt;
                &lt;p&gt;col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 pb-0">
                                    <h4 class="fs-18 mb-4">Three Grid-Example</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview3-tab" data-bs-toggle="tab" data-bs-target="#preview3-tab-pane" type="button" role="tab" aria-controls="preview3-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code3-tab" data-bs-toggle="tab" data-bs-target="#code3-tab-pane" type="button" role="tab" aria-controls="code3-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent3">
                                        <div class="tab-pane fade show active" id="preview3-tab-pane" role="tabpanel" aria-labelledby="preview3-tab" tabindex="0">
                                            <div class="row">
                                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                                    <div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4">
                                                        <p>col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4</p>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                                    <div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4">
                                                        <p>col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4</p>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                                    <div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4">
                                                        <p>col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode3">
    &lt;div class="mt-2 me-2 d-inline-block"&gt;
        &lt;div class="btn-group"&gt;
            &lt;button type="button" class="btn btn-primary text-white py-2 px-3"&gt;Primary&lt;/button&gt;
            &lt;button type="button" class="btn btn-primary text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"&gt;
                &lt;span class="visually-hidden"&gt;Primary&lt;/span&gt;
            &lt;/button&gt;
            &lt;ul class="dropdown-menu bg-white"&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;hr class="dropdown-divider"&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Separated link&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="mt-2 me-2 d-inline-block"&gt;
        &lt;div class="btn-group"&gt;
            &lt;button type="button" class="btn btn-secondary text-white py-2 px-3"&gt;Secondary&lt;/button&gt;
            &lt;button type="button" class="btn btn-secondary text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"&gt;
                &lt;span class="visually-hidden"&gt;Primary&lt;/span&gt;
            &lt;/button&gt;
            &lt;ul class="dropdown-menu bg-white"&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;hr class="dropdown-divider"&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Separated link&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="mt-2 me-2 d-inline-block"&gt;
        &lt;div class="btn-group"&gt;
            &lt;button type="button" class="btn btn-success text-white py-2 px-3"&gt;Success&lt;/button&gt;
            &lt;button type="button" class="btn btn-success text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"&gt;
                &lt;span class="visually-hidden"&gt;Success&lt;/span&gt;
            &lt;/button&gt;
            &lt;ul class="dropdown-menu bg-white"&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;hr class="dropdown-divider"&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Separated link&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="mt-2 me-2 d-inline-block"&gt;
        &lt;div class="btn-group"&gt;
            &lt;button type="button" class="btn btn-info text-white py-2 px-3"&gt;Info&lt;/button&gt;
            &lt;button type="button" class="btn btn-info text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"&gt;
                &lt;span class="visually-hidden"&gt;Info&lt;/span&gt;
            &lt;/button&gt;
            &lt;ul class="dropdown-menu bg-white"&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;hr class="dropdown-divider"&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Separated link&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="mt-2 me-2 d-inline-block"&gt;
        &lt;div class="btn-group"&gt;
            &lt;button type="button" class="btn btn-warning text-white py-2 px-3"&gt;Warning&lt;/button&gt;
            &lt;button type="button" class="btn btn-warning text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"&gt;
                &lt;span class="visually-hidden"&gt;Warning&lt;/span&gt;
            &lt;/button&gt;
            &lt;ul class="dropdown-menu bg-white"&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;hr class="dropdown-divider"&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Separated link&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="mt-2 me-2 d-inline-block"&gt;
        &lt;div class="btn-group"&gt;
            &lt;button type="button" class="btn btn-danger text-white py-2 px-3"&gt;Danger&lt;/button&gt;
            &lt;button type="button" class="btn btn-danger text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"&gt;
                &lt;span class="visually-hidden"&gt;Danger&lt;/span&gt;
            &lt;/button&gt;
            &lt;ul class="dropdown-menu bg-white"&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;hr class="dropdown-divider"&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Separated link&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="mt-2 me-2 d-inline-block"&gt;
        &lt;div class="btn-group"&gt;
            &lt;button type="button" class="btn btn-dark text-white py-2 px-3"&gt;Dark&lt;/button&gt;
            &lt;button type="button" class="btn btn-dark text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"&gt;
                &lt;span class="visually-hidden"&gt;Dark&lt;/span&gt;
            &lt;/button&gt;
            &lt;ul class="dropdown-menu bg-white"&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;hr class="dropdown-divider"&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Separated link&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="mt-2 me-2 d-inline-block"&gt;
        &lt;div class="btn-group"&gt;
            &lt;button type="button" class="btn btn-light text-white py-2 px-3"&gt;Light&lt;/button&gt;
            &lt;button type="button" class="btn btn-light text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"&gt;
                &lt;span class="visually-hidden"&gt;Light&lt;/span&gt;
            &lt;/button&gt;
            &lt;ul class="dropdown-menu bg-white"&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;hr class="dropdown-divider"&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Separated link&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 pb-0">
                                    <h4 class="fs-18 mb-4">Four Grid-Example</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab4" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview4-tab" data-bs-toggle="tab" data-bs-target="#preview4-tab-pane" type="button" role="tab" aria-controls="preview4-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code4-tab" data-bs-toggle="tab" data-bs-target="#code4-tab-pane" type="button" role="tab" aria-controls="code4-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent4">
                                        <div class="tab-pane fade show active" id="preview4-tab-pane" role="tabpanel" aria-labelledby="preview4-tab" tabindex="0">
                                            <div class="row">
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                                    <div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4">
                                                        <p>col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3</p>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                                    <div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4">
                                                        <p>col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3</p>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                                    <div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4">
                                                        <p>col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3</p>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                                    <div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4">
                                                        <p>col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode4">
    &lt;div class="row"&gt;
        &lt;div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-5 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 pb-0">
                                    <h4 class="fs-18 mb-4">Twelve Grid-Example</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab5" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview5-tab" data-bs-toggle="tab" data-bs-target="#preview5-tab-pane" type="button" role="tab" aria-controls="preview5-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code5-tab" data-bs-toggle="tab" data-bs-target="#code5-tab-pane" type="button" role="tab" aria-controls="code5-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent5">
                                        <div class="tab-pane fade show active" id="preview5-tab-pane" role="tabpanel" aria-labelledby="preview5-tab" tabindex="0">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4">
                                                        <p>col</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode5">
    &lt;div class="row"&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;div class="bg-primary bg-opacity-10 p-3 rounded-3 text-center mb-4"&gt;
                &lt;p&gt;col&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
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
