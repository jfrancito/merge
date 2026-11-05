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
                        <h3 class="mb-0">Dropdowns</h3>

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
                                    <span class="fw-medium">Dropdowns</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Dropdown Default Buttons</h4>
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
                                            <div class="d-flex gap-3 flex-wrap">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Dropdown button
                                                    </button>
                                                    <ul class="dropdown-menu bg-white">
                                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown">
                                                    <a class="btn btn-primary text-white py-2 px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Dropdown link
                                                    </a>
                                                  
                                                    <ul class="dropdown-menu bg-white">
                                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;div class="dropdown"&gt;
    &lt;button class="btn btn-primary text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Dropdown button
    &lt;/button&gt;
    &lt;ul class="dropdown-menu bg-white"&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;
&lt;div class="dropdown"&gt;
    &lt;a class="btn btn-primary text-white py-2 px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Dropdown link
    &lt;/a&gt;

    &lt;ul class="dropdown-menu bg-white"&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Outline buttons</h4>
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
                                            <div class="d-flex gap-2 flex-wrap">
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-primary text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Primary
                                                    </button>
                                                    <ul class="dropdown-menu bg-primary">
                                                        <li><a class="dropdown-item text-white" href="#">Action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-secondary text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Secondary
                                                    </button>
                                                    <ul class="dropdown-menu bg-secondary">
                                                        <li><a class="dropdown-item text-white" href="#">Action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-success text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Success
                                                    </button>
                                                    <ul class="dropdown-menu bg-success">
                                                        <li><a class="dropdown-item text-white" href="#">Action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-info text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Info
                                                    </button>
                                                    <ul class="dropdown-menu bg-info">
                                                        <li><a class="dropdown-item text-white" href="#">Action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-warning text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Warning
                                                    </button>
                                                    <ul class="dropdown-menu bg-warning">
                                                        <li><a class="dropdown-item text-white" href="#">Action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-danger text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Danger
                                                    </button>
                                                    <ul class="dropdown-menu bg-danger">
                                                        <li><a class="dropdown-item text-white" href="#">Action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-dark text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Dark
                                                    </button>
                                                    <ul class="dropdown-menu bg-dark">
                                                        <li><a class="dropdown-item text-white" href="#">Action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item text-white" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-light text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Light
                                                    </button>
                                                    <ul class="dropdown-menu bg-light">
                                                        <li><a class="dropdown-item text-dark" href="#">Action</a></li>
                                                        <li><a class="dropdown-item text-dark" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item text-dark" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
&lt;div class="dropdown d-inline-block"&gt;
    &lt;button class="btn btn-primary text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Primary
    &lt;/button&gt;
    &lt;ul class="dropdown-menu bg-primary"&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;

&lt;div class="dropdown d-inline-block"&gt;
    &lt;button class="btn btn-secondary text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Secondary
    &lt;/button&gt;
    &lt;ul class="dropdown-menu bg-secondary"&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;

&lt;div class="dropdown d-inline-block"&gt;
    &lt;button class="btn btn-success text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Success
    &lt;/button&gt;
    &lt;ul class="dropdown-menu bg-success"&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;

&lt;div class="dropdown d-inline-block"&gt;
    &lt;button class="btn btn-info text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Info
    &lt;/button&gt;
    &lt;ul class="dropdown-menu bg-info"&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;

&lt;div class="dropdown d-inline-block"&gt;
    &lt;button class="btn btn-warning text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Warning
    &lt;/button&gt;
    &lt;ul class="dropdown-menu bg-warning"&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;

&lt;div class="dropdown d-inline-block"&gt;
    &lt;button class="btn btn-danger text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Danger
    &lt;/button&gt;
    &lt;ul class="dropdown-menu bg-danger"&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;

&lt;div class="dropdown d-inline-block"&gt;
    &lt;button class="btn btn-dark text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Dark
    &lt;/button&gt;
    &lt;ul class="dropdown-menu bg-dark"&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-white" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;

&lt;div class="dropdown d-inline-block"&gt;
    &lt;button class="btn btn-light text-white py-2 px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Light
    &lt;/button&gt;
    &lt;ul class="dropdown-menu bg-light"&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-dark" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-dark" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item text-dark" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Split Button Dropdown</h4>
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
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="d-inline-block">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary text-white py-2 px-3">Primary</button>
                                                        <button type="button" class="btn btn-primary text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Primary</span>
                                                        </button>
                                                        <ul class="dropdown-menu bg-white">
                                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-secondary text-white py-2 px-3">Secondary</button>
                                                        <button type="button" class="btn btn-secondary text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Primary</span>
                                                        </button>
                                                        <ul class="dropdown-menu bg-white">
                                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success text-white py-2 px-3">Success</button>
                                                        <button type="button" class="btn btn-success text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Success</span>
                                                        </button>
                                                        <ul class="dropdown-menu bg-white">
                                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info text-white py-2 px-3">Info</button>
                                                        <button type="button" class="btn btn-info text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Info</span>
                                                        </button>
                                                        <ul class="dropdown-menu bg-white">
                                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning text-white py-2 px-3">Warning</button>
                                                        <button type="button" class="btn btn-warning text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Warning</span>
                                                        </button>
                                                        <ul class="dropdown-menu bg-white">
                                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-danger text-white py-2 px-3">Danger</button>
                                                        <button type="button" class="btn btn-danger text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Danger</span>
                                                        </button>
                                                        <ul class="dropdown-menu bg-white">
                                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-dark text-white py-2 px-3">Dark</button>
                                                        <button type="button" class="btn btn-dark text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Dark</span>
                                                        </button>
                                                        <ul class="dropdown-menu bg-white">
                                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-light text-white py-2 px-3">Light</button>
                                                        <button type="button" class="btn btn-light text-white py-2 px-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Light</span>
                                                        </button>
                                                        <ul class="dropdown-menu bg-white">
                                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                                        </ul>
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
&lt;div class="d-inline-block"&gt;
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
&lt;div class="d-inline-block"&gt;
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
&lt;div class="d-inline-block"&gt;
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
&lt;div class="d-inline-block"&gt;
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
&lt;div class="d-inline-block"&gt;
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
&lt;div class="d-inline-block"&gt;
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
&lt;div class="d-inline-block"&gt;
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
&lt;div class="d-inline-block"&gt;
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
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Buttons With Icon</h4>
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
                                            <div class="d-flex gap-4">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary text-primary bg-transparent p-0 border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Dropdown button
                                                    </button>
                                                    <ul class="dropdown-menu bg-white">
                                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown">
                                                    <a class="btn btn-primary text-primary bg-transparent p-0 border-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Dropdown link
                                                    </a>
                                                  
                                                    <ul class="dropdown-menu bg-white">
                                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
&lt;div class="dropdown"&gt;
    &lt;button class="btn btn-primary text-primary bg-transparent p-0 border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Dropdown button
    &lt;/button&gt;
    &lt;ul class="dropdown-menu bg-white"&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;
&lt;div class="dropdown"&gt;
    &lt;a class="btn btn-primary text-primary bg-transparent p-0 border-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;
        Dropdown link
    &lt;/a&gt;

    &lt;ul class="dropdown-menu bg-white"&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Another action&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a class="dropdown-item" href="#"&gt;Something else here&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Rounded Buttons</h4>
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
                                            <div class="d-flex align-items-start gap-3">
                                                <ul class="dropdown-menus bg-white mb-0 list-unstyled p-3 rounded-2 bg-for-dark-mode" style="box-shadow: 0px 10px 35px 0px rgba(50, 110, 189, 0.20);">
                                                    <li><a class="dropdown-item fs-14 mb-2" href="#">Today</a></li>
                                                    <li><a class="dropdown-item fs-14 mb-2" href="#">Last 7 Days</a></li>
                                                    <li><a class="dropdown-item fs-14 mb-2" href="#">Last Month</a></li>
                                                    <li><a class="dropdown-item fs-14 mb-2" href="#">Last 12 Months</a></li>
                                                    <li><a class="dropdown-item fs-14 mb-0" href="#">All Time</a></li>
                                                </ul>
                                                <ul class="dropdown-menus bg-white mb-0 list-unstyled p-3 rounded-2 bg-for-dark-mode" style="box-shadow: 0px 10px 35px 0px rgba(50, 110, 189, 0.20);">
                                                    <li><a class="dropdown-item fs-14 mb-2" href="#"><i class="ri-stackshare-line"></i> Share</a></li>
                                                    <li><a class="dropdown-item fs-14 mb-2" href="#"><i class="ri-edit-line"></i> Last 7 Days</a></li>
                                                    <li><a class="dropdown-item fs-14 mb-0" href="#"><i class="ri-delete-bin-7-line"></i> Last Month</a></li>
                                                </ul>
                                                <ul class="dropdown-menus bg-white mb-0 list-unstyled p-3 rounded-2 bg-for-dark-mode" style="box-shadow: 0px 10px 35px 0px rgba(50, 110, 189, 0.20);">
                                                    <li><a class="dropdown-item fs-14 mb-2" href="#"><i class="ri-user-line"></i> Profile</a></li>
                                                    <li><a class="dropdown-item fs-14 mb-2" href="#"><i class="ri-settings-3-line"></i> Settings</a></li>
                                                    <li><a class="dropdown-item fs-14 mb-0" href="#"><i class="ri-logout-circle-line"></i> Logout</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode5">
&lt;ul class="dropdown-menus bg-white mb-0 list-unstyled p-3 rounded-2" style="box-shadow: 0px 10px 35px 0px rgba(50, 110, 189, 0.20);"&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-2" href="#"&gt;Today&lt;/a&gt;&lt;/li&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-2" href="#"&gt;Last 7 Days&lt;/a&gt;&lt;/li&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-2" href="#"&gt;Last Month&lt;/a&gt;&lt;/li&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-2" href="#"&gt;Last 12 Months&lt;/a&gt;&lt;/li&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-0" href="#"&gt;All Time&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;

&lt;ul class="dropdown-menus bg-white mb-0 list-unstyled p-3 rounded-2" style="box-shadow: 0px 10px 35px 0px rgba(50, 110, 189, 0.20);"&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-2" href="#"&gt;&lt;i class="ri-stackshare-line"&gt;&lt;/i&gt; Share&lt;/a&gt;&lt;/li&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-2" href="#"&gt;&lt;i class="ri-edit-line"&gt;&lt;/i&gt; Last 7 Days&lt;/a&gt;&lt;/li&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-0" href="#"&gt;&lt;i class="ri-delete-bin-7-line"&gt;&lt;/i&gt; Last Month&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;

&lt;ul class="dropdown-menus bg-white mb-0 list-unstyled p-3 rounded-2" style="box-shadow: 0px 10px 35px 0px rgba(50, 110, 189, 0.20);"&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-2" href="#"&gt;&lt;i class="ri-user-line"&gt;&lt;/i&gt; Profile&lt;/a&gt;&lt;/li&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-2" href="#"&gt;&lt;i class="ri-settings-3-line"&gt;&lt;/i&gt; Settings&lt;/a&gt;&lt;/li&gt;
    &lt;li&gt;&lt;a class="dropdown-item fs-14 mb-0" href="#"&gt;&lt;i class="ri-logout-circle-line"&gt;&lt;/i&gt; Logout&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
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
