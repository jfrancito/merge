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
                        <h3 class="mb-0">Buttons</h3>

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
                                    <span class="fw-medium">Buttons</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Default Buttons</h4>
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
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-primary fw-medium text-white py-2 px-4">Primary</button>
                                                <button type="button" class="btn btn-secondary fw-medium text-white py-2 px-4">Secondary</button>
                                                <button type="button" class="btn btn-success fw-medium text-white py-2 px-4">Success</button>
                                                <button type="button" class="btn btn-danger fw-medium text-white py-2 px-4">Danger</button>
                                                <button type="button" class="btn btn-warning fw-medium text-white py-2 px-4">Warning</button>
                                                <button type="button" class="btn btn-info fw-medium text-white py-2 px-4">Info</button>
                                                <button type="button" class="btn btn-light fw-medium text-white py-2 px-4">Light</button>
                                                <button type="button" class="btn btn-dark fw-medium text-white py-2 px-4">Dark</button>
                                                <button type="button" class="btn btn-link fw-medium text-white py-2 px-4">Link</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;button type="button" class="btn btn-primary fw-medium text-white py-2 px-4"&gt;Primary&lt;/button&gt;
&lt;button type="button" class="btn btn-secondary fw-medium text-white py-2 px-4"&gt;Secondary&lt;/button&gt;
&lt;button type="button" class="btn btn-success fw-medium text-white py-2 px-4"&gt;Success&lt;/button&gt;
&lt;button type="button" class="btn btn-danger fw-medium text-white py-2 px-4"&gt;Danger&lt;/button&gt;
&lt;button type="button" class="btn btn-warning fw-medium text-white py-2 px-4"&gt;Warning&lt;/button&gt;
&lt;button type="button" class="btn btn-info fw-medium text-white py-2 px-4"&gt;Info&lt;/button&gt;
&lt;button type="button" class="btn btn-light fw-medium text-white py-2 px-4"&gt;Light&lt;/button&gt;
&lt;button type="button" class="btn btn-dark fw-medium text-white py-2 px-4"&gt;Dark&lt;/button&gt;
&lt;button type="button" class="btn btn-link fw-medium text-white py-2 px-4"&gt;Link&lt;/button&gt;
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
                                                <button type="button" class="btn btn-outline-primary fw-medium py-2 px-4 hover-white">Primary</button>
                                                <button type="button" class="btn btn-outline-secondary fw-medium py-2 px-4 hover-white">Secondary</button>
                                                <button type="button" class="btn btn-outline-success fw-medium py-2 px-4 hover-white">Success</button>
                                                <button type="button" class="btn btn-outline-danger fw-medium py-2 px-4 hover-white">Danger</button>
                                                <button type="button" class="btn btn-outline-warning fw-medium py-2 px-4 hover-white">Warning</button>
                                                <button type="button" class="btn btn-outline-info fw-medium py-2 px-4 hover-white">Info</button>
                                                <button type="button" class="btn btn-outline-light fw-medium py-2 px-4 hover-white">Light</button>
                                                <button type="button" class="btn btn-outline-dark fw-medium py-2 px-4 hover-white">Dark</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
&lt;button type="button" class="btn btn-outline-primary fw-medium py-2 px-4 hover-white"&gt;Primary&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-secondary fw-medium py-2 px-4 hover-white"&gt;Secondary&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-success fw-medium py-2 px-4 hover-white"&gt;Success&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-danger fw-medium py-2 px-4 hover-white"&gt;Danger&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-warning fw-medium py-2 px-4 hover-white"&gt;Warning&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-info fw-medium py-2 px-4 hover-white"&gt;Info&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-light fw-medium py-2 px-4 hover-white"&gt;Light&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-dark fw-medium py-2 px-4 hover-white"&gt;Dark&lt;/button&gt;
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
                                    <h4 class="fs-18 mb-4">Soft Buttons</h4>
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
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn bg-primary bg-opacity-10 fw-medium text-primary py-2 px-4">Primary</button>
                                                <button type="button" class="btn bg-secondary bg-opacity-10 fw-medium text-secondary py-2 px-4">Secondary</button>
                                                <button type="button" class="btn bg-success bg-opacity-10 fw-medium text-success py-2 px-4">Success</button>
                                                <button type="button" class="btn bg-danger bg-opacity-10 fw-medium text-danger py-2 px-4">Danger</button>
                                                <button type="button" class="btn bg-warning bg-opacity-10 fw-medium text-warning py-2 px-4">Warning</button>
                                                <button type="button" class="btn bg-info bg-opacity-10 fw-medium text-info py-2 px-4">Info</button>
                                                <button type="button" class="btn bg-light bg-opacity-10 fw-medium text-light py-2 px-4">Light</button>
                                                <button type="button" class="btn bg-dark bg-opacity-10 fw-medium text-dark py-2 px-4">Dark</button>
                                                <button type="button" class="btn bg-link bg-opacity-10 fw-medium text-link py-2 px-4">Link</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
&lt;button type="button" class="btn bg-primary bg-opacity-10 fw-medium text-primary py-2 px-4"&gt;Primary&lt;/button&gt;
&lt;button type="button" class="btn bg-secondary bg-opacity-10 fw-medium text-secondary py-2 px-4"&gt;Secondary&lt;/button&gt;
&lt;button type="button" class="btn bg-success bg-opacity-10 fw-medium text-success py-2 px-4"&gt;Success&lt;/button&gt;
&lt;button type="button" class="btn bg-danger bg-opacity-10 fw-medium text-danger py-2 px-4"&gt;Danger&lt;/button&gt;
&lt;button type="button" class="btn bg-warning bg-opacity-10 fw-medium text-warning py-2 px-4"&gt;Warning&lt;/button&gt;
&lt;button type="button" class="btn bg-info bg-opacity-10 fw-medium text-info py-2 px-4"&gt;Info&lt;/button&gt;
&lt;button type="button" class="btn bg-light bg-opacity-10 fw-medium text-light py-2 px-4"&gt;Light&lt;/button&gt;
&lt;button type="button" class="btn bg-dark bg-opacity-10 fw-medium text-dark py-2 px-4"&gt;Dark&lt;/button&gt;
&lt;button type="button" class="btn bg-link bg-opacity-10 fw-medium text-link py-2 px-4"&gt;Link&lt;/button&gt;
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
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-primary fw-medium text-white py-2 px-4"><i class="ri-add-line"></i> Primary</button>
                                                <button type="button" class="btn btn-secondary fw-medium text-white py-2 px-4"><i class="ri-add-line"></i> Secondary</button>
                                                <button type="button" class="btn btn-success fw-medium text-white py-2 px-4">Success</button>
                                                <button type="button" class="btn btn-danger fw-medium text-white py-2 px-4"><i class="ri-add-line"></i> Danger</button>
                                                <button type="button" class="btn btn-warning fw-medium text-white py-2 px-4"><i class="ri-add-line"></i> Warning</button>
                                                <button type="button" class="btn btn-info fw-medium text-white py-2 px-4"><i class="ri-add-line"></i> Info</button>
                                                <button type="button" class="btn btn-light fw-medium text-white py-2 px-4"><i class="ri-add-line"></i> Light</button>
                                                <button type="button" class="btn btn-dark fw-medium text-white py-2 px-4"><i class="ri-add-line"></i> Dark</button>
                                                <button type="button" class="btn btn-link fw-medium text-white py-2 px-4"><i class="ri-add-line"></i> Link</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
&lt;button type="button" class="btn btn-primary fw-medium text-white py-2 px-4"&gt;&lt;i class="ri-add-line"&gt;&lt;/i&gt; Primary&lt;/button&gt;
&lt;button type="button" class="btn btn-secondary fw-medium text-white py-2 px-4"&gt;&lt;i class="ri-add-line"&gt;&lt;/i&gt; Secondary&lt;/button&gt;
&lt;button type="button" class="btn btn-success fw-medium text-white py-2 px-4"&gt;Success&lt;/button&gt;
&lt;button type="button" class="btn btn-danger fw-medium text-white py-2 px-4"&gt;&lt;i class="ri-add-line"&gt;&lt;/i&gt; Danger&lt;/button&gt;
&lt;button type="button" class="btn btn-warning fw-medium text-white py-2 px-4"&gt;&lt;i class="ri-add-line"&gt;&lt;/i&gt; Warning&lt;/button&gt;
&lt;button type="button" class="btn btn-info fw-medium text-white py-2 px-4"&gt;&lt;i class="ri-add-line"&gt;&lt;/i&gt; Info&lt;/button&gt;
&lt;button type="button" class="btn btn-light fw-medium text-white py-2 px-4"&gt;&lt;i class="ri-add-line"&gt;&lt;/i&gt; Light&lt;/button&gt;
&lt;button type="button" class="btn btn-dark fw-medium text-white py-2 px-4"&gt;&lt;i class="ri-add-line"&gt;&lt;/i&gt; Dark&lt;/button&gt;
&lt;button type="button" class="btn btn-link fw-medium text-white py-2 px-4"&gt;&lt;i class="ri-add-line"&gt;&lt;/i&gt; Link&lt;/button&gt;
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
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-primary fw-medium text-white py-2 px-4 rounded-pill">Primary</button>
                                                <button type="button" class="btn btn-secondary fw-medium text-white py-2 px-4 rounded-pill">Secondary</button>
                                                <button type="button" class="btn btn-success fw-medium text-white py-2 px-4 rounded-pill">Success</button>
                                                <button type="button" class="btn btn-danger fw-medium text-white py-2 px-4 rounded-pill">Danger</button>
                                                <button type="button" class="btn btn-warning fw-medium text-white py-2 px-4 rounded-pill">Warning</button>
                                                <button type="button" class="btn btn-info fw-medium text-white py-2 px-4 rounded-pill">Info</button>
                                                <button type="button" class="btn btn-light fw-medium text-white py-2 px-4 rounded-pill">Light</button>
                                                <button type="button" class="btn btn-dark fw-medium text-white py-2 px-4 rounded-pill">Dark</button>
                                                <button type="button" class="btn btn-link fw-medium text-white py-2 px-4 rounded-pill">Link</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode5">
&lt;button type="button" class="btn btn-primary fw-medium text-white py-2 px-4 rounded-pill"&gt;Primary&lt;/button&gt;
&lt;button type="button" class="btn btn-secondary fw-medium text-white py-2 px-4 rounded-pill"&gt;Secondary&lt;/button&gt;
&lt;button type="button" class="btn btn-success fw-medium text-white py-2 px-4 rounded-pill"&gt;Success&lt;/button&gt;
&lt;button type="button" class="btn btn-danger fw-medium text-white py-2 px-4 rounded-pill"&gt;Danger&lt;/button&gt;
&lt;button type="button" class="btn btn-warning fw-medium text-white py-2 px-4 rounded-pill"&gt;Warning&lt;/button&gt;
&lt;button type="button" class="btn btn-info fw-medium text-white py-2 px-4 rounded-pill"&gt;Info&lt;/button&gt;
&lt;button type="button" class="btn btn-light fw-medium text-white py-2 px-4 rounded-pill"&gt;Light&lt;/button&gt;
&lt;button type="button" class="btn btn-dark fw-medium text-white py-2 px-4 rounded-pill"&gt;Dark&lt;/button&gt;
&lt;button type="button" class="btn btn-link fw-medium text-white py-2 px-4 rounded-pill"&gt;Link&lt;/button&gt;
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
                                    <h4 class="fs-18 mb-4">Outline Rounded Buttons</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab6" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview6-tab" data-bs-toggle="tab" data-bs-target="#preview6-tab-pane" type="button" role="tab" aria-controls="preview6-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code6-tab" data-bs-toggle="tab" data-bs-target="#code6-tab-pane" type="button" role="tab" aria-controls="code6-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent6">
                                        <div class="tab-pane fade show active" id="preview6-tab-pane" role="tabpanel" aria-labelledby="preview6-tab" tabindex="0">
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-outline-primary fw-medium py-2 px-4 hover-white rounded-pill">Primary</button>
                                                <button type="button" class="btn btn-outline-secondary fw-medium py-2 px-4 hover-white rounded-pill">Secondary</button>
                                                <button type="button" class="btn btn-outline-success fw-medium py-2 px-4 hover-white rounded-pill">Success</button>
                                                <button type="button" class="btn btn-outline-danger fw-medium py-2 px-4 hover-white rounded-pill">Danger</button>
                                                <button type="button" class="btn btn-outline-warning fw-medium py-2 px-4 hover-white rounded-pill">Warning</button>
                                                <button type="button" class="btn btn-outline-info fw-medium py-2 px-4 hover-white rounded-pill">Info</button>
                                                <button type="button" class="btn btn-outline-light fw-medium py-2 px-4 hover-white rounded-pill">Light</button>
                                                <button type="button" class="btn btn-outline-dark fw-medium py-2 px-4 hover-white rounded-pill">Dark</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code6-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode6">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode6">
&lt;button type="button" class="btn btn-outline-primary fw-medium py-2 px-4 hover-white rounded-pill"&gt;Primary&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-secondary fw-medium py-2 px-4 hover-white rounded-pill"&gt;Secondary&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-success fw-medium py-2 px-4 hover-white rounded-pill"&gt;Success&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-danger fw-medium py-2 px-4 hover-white rounded-pill"&gt;Danger&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-warning fw-medium py-2 px-4 hover-white rounded-pill"&gt;Warning&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-info fw-medium py-2 px-4 hover-white rounded-pill"&gt;Info&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-light fw-medium py-2 px-4 hover-white rounded-pill"&gt;Light&lt;/button&gt;
&lt;button type="button" class="btn btn-outline-dark fw-medium py-2 px-4 hover-white rounded-pill"&gt;Dark&lt;/button&gt;
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
                                    <h4 class="fs-18 mb-4">Block Buttons</h4>
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
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-primary fw-medium text-white py-3 px-4 w-100">Block Button</button>
                                                <button type="button" class="btn bg-primary bg-opacity-50 fw-medium text-white py-3 px-4 w-100">Block Button</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code7-tab-pane" role="tabpanel" aria-labelledby="code7-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode7">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode7">
&lt;button type="button" class="btn btn-primary fw-medium text-white py-3 px-4 w-100"&gt;Block Button&lt;/button&gt;
&lt;button type="button" class="btn bg-primary bg-opacity-50 fw-medium text-white py-3 px-4 w-100"&gt;Block Button&lt;/button&gt;
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
