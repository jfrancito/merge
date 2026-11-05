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
                        <h3 class="mb-0">Alerts</h3>

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
                                    <span class="fw-medium">Alerts</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Basic Alerts</h4>
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
                                            <div class="alert alert-primary text-primary" role="alert">
                                                A simple primary alert—check it out!
                                            </div>
                                            <div class="alert alert-secondary text-secondary" role="alert">
                                                A simple secondary alert—check it out!
                                            </div>
                                            <div class="alert alert-success text-success" role="alert">
                                                A simple success alert—check it out!
                                            </div>
                                            <div class="alert alert-danger text-danger" role="alert">
                                                A simple danger alert—check it out!
                                            </div>
                                            <div class="alert alert-warning text-warning" role="alert">
                                                A simple warning alert—check it out!
                                            </div>
                                            <div class="alert alert-info text-info" role="alert">
                                                A simple info alert—check it out!
                                            </div>
                                            <div class="alert alert-light text-light" role="alert">
                                                A simple light alert—check it out!
                                            </div>
                                            <div class="alert alert-dark text-dark mb-0" role="alert">
                                                A simple dark alert—check it out!
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;div class="alert alert-primary" role="alert"&gt;
    A simple primary alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-secondary" role="alert"&gt;
    A simple secondary alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-success" role="alert"&gt;
    A simple success alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-danger" role="alert"&gt;
    A simple danger alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-warning" role="alert"&gt;
    A simple warning alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-info" role="alert"&gt;
    A simple info alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-light" role="alert"&gt;
    A simple light alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-dark mb-0" role="alert"&gt;
    A simple dark alert—check it out!
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
                                    <h4 class="fs-18 mb-4">BG Basic Alerts</h4>
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
                                            <div class="alert alert-primary bg-primary text-white" role="alert">
                                                A simple primary alert—check it out!
                                            </div>
                                            <div class="alert alert-secondary bg-secondary text-white" role="alert">
                                                A simple secondary alert—check it out!
                                            </div>
                                            <div class="alert alert-success bg-success text-white" role="alert">
                                                A simple success alert—check it out!
                                            </div>
                                            <div class="alert alert-danger bg-danger text-white" role="alert">
                                                A simple danger alert—check it out!
                                            </div>
                                            <div class="alert alert-warning bg-warning text-white" role="alert">
                                                A simple warning alert—check it out!
                                            </div>
                                            <div class="alert alert-info bg-info text-white" role="alert">
                                                A simple info alert—check it out!
                                            </div>
                                            <div class="alert alert-light bg-light text-dark" role="alert">
                                                A simple light alert—check it out!
                                            </div>
                                            <div class="alert alert-dark mb-0 bg-dark text-white" role="alert">
                                                A simple dark alert—check it out!
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
&lt;div class="alert alert-primary bg-primary text-white" role="alert"&gt;
    A simple primary alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-secondary bg-secondary text-white" role="alert"&gt;
    A simple secondary alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-success bg-success text-white" role="alert"&gt;
    A simple success alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-danger bg-danger text-white" role="alert"&gt;
    A simple danger alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-warning bg-warning text-white" role="alert"&gt;
    A simple warning alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-info bg-info text-white" role="alert"&gt;
    A simple info alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-light bg-light text-dark" role="alert"&gt;
    A simple light alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-dark mb-0 bg-dark text-white" role="alert"&gt;
    A simple dark alert—check it out!
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
                                    <h4 class="fs-18 mb-4">Outline Alerts</h4>
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
                                            <div class="alert alert-primary bg-transparent text-primary" role="alert">
                                                A simple primary alert—check it out!
                                            </div>
                                            <div class="alert alert-secondary bg-transparent text-secondary" role="alert">
                                                A simple secondary alert—check it out!
                                            </div>
                                            <div class="alert alert-success bg-transparent text-success" role="alert">
                                                A simple success alert—check it out!
                                            </div>
                                            <div class="alert alert-danger bg-transparent text-danger" role="alert">
                                                A simple danger alert—check it out!
                                            </div>
                                            <div class="alert alert-warning bg-transparent text-warning" role="alert">
                                                A simple warning alert—check it out!
                                            </div>
                                            <div class="alert alert-info bg-transparent text-info" role="alert">
                                                A simple info alert—check it out!
                                            </div>
                                            <div class="alert alert-light bg-transparent text-light" role="alert">
                                                A simple light alert—check it out!
                                            </div>
                                            <div class="alert alert-dark mb-0 bg-transparent text-dark" role="alert">
                                                A simple dark alert—check it out!
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
&lt;div class="alert alert-primary bg-transparent text-primary" role="alert"&gt;
    A simple primary alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-secondary bg-transparent text-secondary" role="alert"&gt;
    A simple secondary alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-success bg-transparent text-success" role="alert"&gt;
    A simple success alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-danger bg-transparent text-danger" role="alert"&gt;
    A simple danger alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-warning bg-transparent text-warning" role="alert"&gt;
    A simple warning alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-info bg-transparent text-info" role="alert"&gt;
    A simple info alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-light bg-transparent text-light" role="alert"&gt;
    A simple light alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-dark mb-0 bg-transparent text-dark" role="alert"&gt;
    A simple dark alert—check it out!
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
                                    <h4 class="fs-18 mb-4">Outline Alerts</h4>
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
                                            <div class="alert alert-primary text-primary" role="alert">
                                                A simple primary alert with <a href="#" class="fw-semibold">an example link</a>. Give it a click if you like.
                                            </div>
                                            <div class="alert alert-secondary text-secondary" role="alert">
                                                A simple secondary alert with <a href="#" class="fw-semibold">an example link</a>. Give it a click if you like.
                                            </div>
                                            <div class="alert alert-success text-success" role="alert">
                                                A simple success alert with <a href="#" class="fw-semibold">an example link</a>. Give it a click if you like.
                                            </div>
                                            <div class="alert alert-danger text-danger" role="alert">
                                                A simple danger alert with <a href="#" class="fw-semibold">an example link</a>. Give it a click if you like.
                                            </div>
                                            <div class="alert alert-warning text-warning" role="alert">
                                                A simple warning alert with <a href="#" class="fw-semibold">an example link</a>. Give it a click if you like.
                                            </div>
                                            <div class="alert alert-info text-info" role="alert">
                                                A simple info alert with <a href="#" class="fw-semibold">an example link</a>. Give it a click if you like.
                                            </div>
                                            <div class="alert alert-light text-light" role="alert">
                                                A simple light alert with <a href="#" class="fw-semibold">an example link</a>. Give it a click if you like.
                                            </div>
                                            <div class="alert alert-dark text-dark mb-0" role="alert">
                                                A simple dark alert with <a href="#" class="fw-semibold">an example link</a>. Give it a click if you like.
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
&lt;div class="alert alert-primary text-primary" role="alert"&gt;
    A simple primary alert with &lt;a href="#" class="fw-semibold"&gt;an example link&lt;/a&gt;. Give it a click if you like.
&lt;/div&gt;
&lt;div class="alert alert-secondary text-secondary" role="alert"&gt;
    A simple secondary alert with &lt;a href="#" class="fw-semibold"&gt;an example link&lt;/a&gt;. Give it a click if you like.
&lt;/div&gt;
&lt;div class="alert alert-success text-success" role="alert"&gt;
    A simple success alert with &lt;a href="#" class="fw-semibold"&gt;an example link&lt;/a&gt;. Give it a click if you like.
&lt;/div&gt;
&lt;div class="alert alert-danger text-danger" role="alert"&gt;
    A simple danger alert with &lt;a href="#" class="fw-semibold"&gt;an example link&lt;/a&gt;. Give it a click if you like.
&lt;/div&gt;
&lt;div class="alert alert-warning text-warning" role="alert"&gt;
    A simple warning alert with &lt;a href="#" class="fw-semibold"&gt;an example link&lt;/a&gt;. Give it a click if you like.
&lt;/div&gt;
&lt;div class="alert alert-info text-info" role="alert"&gt;
    A simple info alert with &lt;a href="#" class="fw-semibold"&gt;an example link&lt;/a&gt;. Give it a click if you like.
&lt;/div&gt;
&lt;div class="alert alert-light text-light" role="alert"&gt;
    A simple light alert with &lt;a href="#" class="fw-semibold"&gt;an example link&lt;/a&gt;. Give it a click if you like.
&lt;/div&gt;
&lt;div class="alert alert-dark text-dark mb-0" role="alert"&gt;
    A simple dark alert with &lt;a href="#" class="fw-semibold"&gt;an example link&lt;/a&gt;. Give it a click if you like.
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
                                    <h4 class="fs-18 mb-4">Alerts with Icon</h4>
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
                                            <div class="alert alert-primary text-primary" role="alert">
                                                <i class="ri-home-7-line fs-18 me-1"></i>
                                                A simple primary alert—check it out!
                                            </div>
                                            <div class="alert alert-secondary text-secondary" role="alert">
                                                <i class="ri-star-line fs-18 me-1"></i>
                                                A simple secondary alert—check it out!
                                            </div>
                                            <div class="alert alert-success text-success" role="alert">
                                                <i class="ri-play-circle-line fs-18 me-1"></i>
                                                A simple success alert—check it out!
                                            </div>
                                            <div class="alert alert-danger text-danger" role="alert">
                                                <i class="ri-service-line fs-18 me-1"></i>
                                                A simple danger alert—check it out!
                                            </div>
                                            <div class="alert alert-warning text-warning" role="alert">
                                                <i class="ri-edit-box-line fs-18 me-1"></i>
                                                A simple warning alert—check it out!
                                            </div>
                                            <div class="alert alert-info text-info" role="alert">
                                                <i class="ri-table-line fs-18 me-1"></i>
                                                A simple info alert—check it out!
                                            </div>
                                            <div class="alert alert-light text-light" role="alert">
                                                <i class="ri-code-s-slash-fill fs-18 me-1"></i>
                                                A simple light alert—check it out!
                                            </div>
                                            <div class="alert alert-dark text-dark mb-0" role="alert">
                                                <i class="ri-html5-line fs-18 me-1"></i>
                                                A simple dark alert—check it out!
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode5">
&lt;div class="alert alert-primary text-primary" role="alert"&gt;
    &lt;i class="ri-home-7-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple primary alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-secondary text-secondary" role="alert"&gt;
    &lt;i class="ri-star-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple secondary alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-success text-success" role="alert"&gt;
    &lt;i class="ri-play-circle-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple success alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-danger text-danger" role="alert"&gt;
    &lt;i class="ri-service-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple danger alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-warning text-warning" role="alert"&gt;
    &lt;i class="ri-edit-box-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple warning alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-info text-info" role="alert"&gt;
    &lt;i class="ri-table-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple info alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-light text-light" role="alert"&gt;
    &lt;i class="ri-code-s-slash-fill fs-18 me-1"&gt;&lt;/i&gt;
    A simple light alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-dark text-dark mb-0" role="alert"&gt;
    &lt;i class="ri-html5-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple dark alert—check it out!
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
                                    <h4 class="fs-18 mb-4">BG Alerts with Icon</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab6" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview6-tab" data-bs-toggle="tab" data-bs-target="#preview6-tab-pane" type="button" role="tab" aria-controls="preview6-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code6-tab" data-bs-toggle="tab" data-bs-target="#code6-tab-pane" type="button" role="tab" aria-controls="code5-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent6">
                                        <div class="tab-pane fade show active" id="preview6-tab-pane" role="tabpanel" aria-labelledby="preview6-tab" tabindex="0">
                                            <div class="alert alert-primary bg-primary text-white" role="alert">
                                                <i class="ri-home-7-line fs-18 me-1"></i>
                                                A simple primary alert—check it out!
                                            </div>
                                            <div class="alert alert-secondary bg-secondary text-white" role="alert">
                                                <i class="ri-star-line fs-18 me-1"></i>
                                                A simple secondary alert—check it out!
                                            </div>
                                            <div class="alert alert-success bg-success text-white" role="alert">
                                                <i class="ri-play-circle-line fs-18 me-1"></i>
                                                A simple success alert—check it out!
                                            </div>
                                            <div class="alert alert-danger bg-danger text-white" role="alert">
                                                <i class="ri-service-line fs-18 me-1"></i>
                                                A simple danger alert—check it out!
                                            </div>
                                            <div class="alert alert-warning bg-warning text-white" role="alert">
                                                <i class="ri-edit-box-line fs-18 me-1"></i>
                                                A simple warning alert—check it out!
                                            </div>
                                            <div class="alert alert-info bg-info text-white" role="alert">
                                                <i class="ri-table-line fs-18 me-1"></i>
                                                A simple info alert—check it out!
                                            </div>
                                            <div class="alert alert-light bg-light text-white" role="alert">
                                                <i class="ri-code-s-slash-fill fs-18 me-1"></i>
                                                A simple light alert—check it out!
                                            </div>
                                            <div class="alert alert-dark bg-dark text-white mb-0" role="alert">
                                                <i class="ri-html5-line fs-18 me-1"></i>
                                                A simple dark alert—check it out!
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code6-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode6">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode6">
&lt;div class="alert alert-primary bg-primary text-white" role="alert"&gt;
    &lt;i class="ri-home-7-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple primary alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-secondary bg-secondary text-white" role="alert"&gt;
    &lt;i class="ri-star-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple secondary alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-success bg-success text-white" role="alert"&gt;
    &lt;i class="ri-play-circle-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple success alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-danger bg-danger text-white" role="alert"&gt;
    &lt;i class="ri-service-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple danger alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-warning bg-warning text-white" role="alert"&gt;
    &lt;i class="ri-edit-box-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple warning alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-info bg-info text-white" role="alert"&gt;
    &lt;i class="ri-table-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple info alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-light bg-light text-white" role="alert"&gt;
    &lt;i class="ri-code-s-slash-fill fs-18 me-1"&gt;&lt;/i&gt;
    A simple light alert—check it out!
&lt;/div&gt;
&lt;div class="alert alert-dark bg-dark text-white mb-0" role="alert"&gt;
    &lt;i class="ri-html5-line fs-18 me-1"&gt;&lt;/i&gt;
    A simple dark alert—check it out!
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
                                    <h4 class="fs-18 mb-4">Dismissing Alerts</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab7" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview7-tab" data-bs-toggle="tab" data-bs-target="#preview7-tab-pane" type="button" role="tab" aria-controls="preview7-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code7-tab" data-bs-toggle="tab" data-bs-target="#code7-tab-pane" type="button" role="tab" aria-controls="code7-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent7">
                                        <div class="tab-pane fade show active" id="preview7-tab-pane" role="tabpanel" aria-labelledby="preview7-tab" tabindex="0">
                                            <div class="alert alert-primary alert-dismissible" role="alert">
                                                A simple primary alert—check it out!
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <div class="alert alert-secondary alert-dismissible" role="alert">
                                                A simple secondary alert—check it out!
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                A simple success alert—check it out!
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                A simple danger alert—check it out!
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <div class="alert alert-warning alert-dismissible" role="alert">
                                                A simple warning alert—check it out!
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <div class="alert alert-info alert-dismissible" role="alert">
                                                A simple info alert—check it out!
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <div class="alert alert-light alert-dismissible" role="alert">
                                                A simple light alert—check it out!
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <div class="alert alert-dark alert-dismissible" role="alert">
                                                A simple dark alert—check it out!
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code7-tab-pane" role="tabpanel" aria-labelledby="code7-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode7">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode7">
&lt;div class="alert alert-primary alert-dismissible" role="alert"&gt;
    A simple primary alert—check it out!
    &lt;button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"&gt;&lt;/button&gt;
&lt;/div&gt;
&lt;div class="alert alert-secondary alert-dismissible" role="alert"&gt;
    A simple secondary alert—check it out!
    &lt;button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"&gt;&lt;/button&gt;
&lt;/div&gt;
&lt;div class="alert alert-success alert-dismissible" role="alert"&gt;
    A simple success alert—check it out!
    &lt;button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"&gt;&lt;/button&gt;
&lt;/div&gt;
&lt;div class="alert alert-danger alert-dismissible" role="alert"&gt;
    A simple danger alert—check it out!
    &lt;button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"&gt;&lt;/button&gt;
&lt;/div&gt;
&lt;div class="alert alert-warning alert-dismissible" role="alert"&gt;
    A simple warning alert—check it out!
    &lt;button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"&gt;&lt;/button&gt;
&lt;/div&gt;
&lt;div class="alert alert-info alert-dismissible" role="alert"&gt;
    A simple info alert—check it out!
    &lt;button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"&gt;&lt;/button&gt;
&lt;/div&gt;
&lt;div class="alert alert-light alert-dismissible" role="alert"&gt;
    A simple light alert—check it out!
    &lt;button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"&gt;&lt;/button&gt;
&lt;/div&gt;
&lt;div class="alert alert-dark alert-dismissible" role="alert"&gt;
    A simple dark alert—check it out!
    &lt;button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"&gt;&lt;/button&gt;
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
                                    <h4 class="fs-18 mb-4">Additional Content Alerts</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab8" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview8-tab" data-bs-toggle="tab" data-bs-target="#preview8-tab-pane" type="button" role="tab" aria-controls="preview8-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code8-tab" data-bs-toggle="tab" data-bs-target="#code8-tab-pane" type="button" role="tab" aria-controls="code8-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent8">
                                        <div class="tab-pane fade show active" id="preview8-tab-pane" role="tabpanel" aria-labelledby="preview8-tab" tabindex="0">
                                            <div class="alert alert-success" role="alert">
                                                <h4 class="alert-heading">Well done!</h4>
                                                <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
                                                <hr>
                                                <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code8-tab-pane" role="tabpanel" aria-labelledby="code8-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode8">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode8">
&lt;div class="alert alert-success" role="alert"&gt;
    &lt;h4 class="alert-heading"&gt;Well done!&lt;/h4&gt;
    &lt;p&gt;Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.&lt;/p&gt;
    &lt;hr&gt;
    &lt;p class="mb-0"&gt;Whenever you need to, be sure to use margin utilities to keep things nice and tidy.&lt;/p&gt;
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
