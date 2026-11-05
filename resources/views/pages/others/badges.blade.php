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
                        <h3 class="mb-0">Badges</h3>

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
                                    <span class="fw-medium">Badges</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Default Badges</h4>
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
                                            <span class="badge text-bg-primary py-1 px-2 text-white rounded-1 fw-medium fs-12">Primary</span>
                                            <span class="badge text-bg-secondary py-1 px-2 text-white rounded-1 fw-medium fs-12">Secondary</span>
                                            <span class="badge text-bg-success py-1 px-2 text-white rounded-1 fw-medium fs-12">Success</span>
                                            <span class="badge text-bg-danger py-1 px-2 text-white rounded-1 fw-medium fs-12">Danger</span>
                                            <span class="badge text-bg-warning py-1 px-2 text-white rounded-1 fw-medium fs-12">Warning</span>
                                            <span class="badge text-bg-info py-1 px-2 text-white rounded-1 fw-medium fs-12">Info</span>
                                            <span class="badge text-bg-light py-1 px-2 text-white rounded-1 fw-medium fs-12">Light</span>
                                            <span class="badge text-bg-dark py-1 px-2 text-white rounded-1 fw-medium fs-12">Dark</span>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;span class="badge text-bg-primary py-1 px-2 text-white rounded-1 fw-medium fs-12"&gt;Primary&lt;/span&gt;
&lt;span class="badge text-bg-secondary py-1 px-2 text-white rounded-1 fw-medium fs-12"&gt;Secondary&lt;/span&gt;
&lt;span class="badge text-bg-success py-1 px-2 text-white rounded-1 fw-medium fs-12"&gt;Success&lt;/span&gt;
&lt;span class="badge text-bg-danger py-1 px-2 text-white rounded-1 fw-medium fs-12"&gt;Danger&lt;/span&gt;
&lt;span class="badge text-bg-warning py-1 px-2 text-white rounded-1 fw-medium fs-12"&gt;Warning&lt;/span&gt;
&lt;span class="badge text-bg-info py-1 px-2 text-white rounded-1 fw-medium fs-12"&gt;Info&lt;/span&gt;
&lt;span class="badge text-bg-light py-1 px-2 text-white rounded-1 fw-medium fs-12"&gt;Light&lt;/span&gt;
&lt;span class="badge text-bg-dark py-1 px-2 text-white rounded-1 fw-medium fs-12"&gt;Dark&lt;/span&gt;
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
                                    <h4 class="fs-18 mb-4">Soft Badges</h4>
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
                                            <span class="badge bg-opacity-10 bg-primary py-1 px-2 text-primary rounded-1 fw-medium fs-12">Primary</span>
                                            <span class="badge bg-opacity-10 bg-secondary py-1 px-2 text-secondary rounded-1 fw-medium fs-12">Secondary</span>
                                            <span class="badge bg-opacity-10 bg-success py-1 px-2 text-success rounded-1 fw-medium fs-12">Success</span>
                                            <span class="badge bg-opacity-10 bg-danger py-1 px-2 text-danger rounded-1 fw-medium fs-12">Danger</span>
                                            <span class="badge bg-opacity-10 bg-warning py-1 px-2 text-warning rounded-1 fw-medium fs-12">Warning</span>
                                            <span class="badge bg-opacity-10 bg-info py-1 px-2 text-info rounded-1 fw-medium fs-12">Info</span>
                                            <span class="badge bg-opacity-10 bg-light py-1 px-2 text-light rounded-1 fw-medium fs-12">Light</span>
                                            <span class="badge bg-opacity-10 bg-dark py-1 px-2 text-dark rounded-1 fw-medium fs-12">Dark</span>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
&lt;span class="badge bg-opacity-10 bg-primary py-1 px-2 text-primary rounded-1 fw-medium fs-12"&gt;Primary&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-secondary py-1 px-2 text-secondary rounded-1 fw-medium fs-12"&gt;Secondary&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-success py-1 px-2 text-success rounded-1 fw-medium fs-12"&gt;Success&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-danger py-1 px-2 text-danger rounded-1 fw-medium fs-12"&gt;Danger&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-warning py-1 px-2 text-warning rounded-1 fw-medium fs-12"&gt;Warning&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-info py-1 px-2 text-info rounded-1 fw-medium fs-12"&gt;Info&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-light py-1 px-2 text-light rounded-1 fw-medium fs-12"&gt;Light&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-dark py-1 px-2 text-dark rounded-1 fw-medium fs-12"&gt;Dark&lt;/span&gt;
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
                                    <h4 class="fs-18 mb-4">Rounded Pill Badges</h4>
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
                                            <span class="badge text-bg-primary py-1 px-2 text-white rounded-pill fw-medium fs-12">Primary</span>
                                            <span class="badge text-bg-secondary py-1 px-2 text-white rounded-pill fw-medium fs-12">Secondary</span>
                                            <span class="badge text-bg-success py-1 px-2 text-white rounded-pill fw-medium fs-12">Success</span>
                                            <span class="badge text-bg-danger py-1 px-2 text-white rounded-pill fw-medium fs-12">Danger</span>
                                            <span class="badge text-bg-warning py-1 px-2 text-white rounded-pill fw-medium fs-12">Warning</span>
                                            <span class="badge text-bg-info py-1 px-2 text-white rounded-pill fw-medium fs-12">Info</span>
                                            <span class="badge text-bg-light py-1 px-2 text-white rounded-pill fw-medium fs-12">Light</span>
                                            <span class="badge text-bg-dark py-1 px-2 text-white rounded-pill fw-medium fs-12">Dark</span>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
&lt;button type="button" class="btn bg-primary bg-opacity-10 fw-medium text-primary py-2 px-4 mt-2 me-2"&gt;Primary&lt;/button&gt;
&lt;button type="button" class="btn bg-secondary bg-opacity-10 fw-medium text-secondary py-2 px-4 mt-2 me-2"&gt;Secondary&lt;/button&gt;
&lt;button type="button" class="btn bg-success bg-opacity-10 fw-medium text-success py-2 px-4 mt-2 me-2"&gt;Success&lt;/button&gt;
&lt;button type="button" class="btn bg-danger bg-opacity-10 fw-medium text-danger py-2 px-4 mt-2 me-2"&gt;Danger&lt;/button&gt;
&lt;button type="button" class="btn bg-warning bg-opacity-10 fw-medium text-warning py-2 px-4 mt-2 me-2"&gt;Warning&lt;/button&gt;
&lt;button type="button" class="btn bg-info bg-opacity-10 fw-medium text-info py-2 px-4 mt-2 me-2"&gt;Info&lt;/button&gt;
&lt;button type="button" class="btn bg-light bg-opacity-10 fw-medium text-light py-2 px-4 mt-2 me-2"&gt;Light&lt;/button&gt;
&lt;button type="button" class="btn bg-dark bg-opacity-10 fw-medium text-dark py-2 px-4 mt-2 me-2"&gt;Dark&lt;/button&gt;
&lt;button type="button" class="btn bg-link bg-opacity-10 fw-medium text-link py-2 px-4 mt-2 me-2"&gt;Link&lt;/button&gt;
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
                                    <h4 class="fs-18 mb-4">Rounded Pill Badges</h4>
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
                                            <span class="badge bg-opacity-10 bg-primary py-1 px-2 text-primary rounded-pill fw-medium fs-12">Primary</span>
                                            <span class="badge bg-opacity-10 bg-secondary py-1 px-2 text-secondary rounded-pill fw-medium fs-12">Secondary</span>
                                            <span class="badge bg-opacity-10 bg-success py-1 px-2 text-success rounded-pill fw-medium fs-12">Success</span>
                                            <span class="badge bg-opacity-10 bg-danger py-1 px-2 text-danger rounded-pill fw-medium fs-12">Danger</span>
                                            <span class="badge bg-opacity-10 bg-warning py-1 px-2 text-warning rounded-pill fw-medium fs-12">Warning</span>
                                            <span class="badge bg-opacity-10 bg-info py-1 px-2 text-info rounded-pill fw-medium fs-12">Info</span>
                                            <span class="badge bg-opacity-10 bg-light py-1 px-2 text-light rounded-pill fw-medium fs-12">Light</span>
                                            <span class="badge bg-opacity-10 bg-dark py-1 px-2 text-dark rounded-pill fw-medium fs-12">Dark</span>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
&lt;span class="badge bg-opacity-10 bg-primary py-1 px-2 text-primary rounded-pill fw-medium fs-12"&gt;Primary&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-secondary py-1 px-2 text-secondary rounded-pill fw-medium fs-12"&gt;Secondary&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-success py-1 px-2 text-success rounded-pill fw-medium fs-12"&gt;Success&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-danger py-1 px-2 text-danger rounded-pill fw-medium fs-12"&gt;Danger&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-warning py-1 px-2 text-warning rounded-pill fw-medium fs-12"&gt;Warning&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-info py-1 px-2 text-info rounded-pill fw-medium fs-12"&gt;Info&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-light py-1 px-2 text-light rounded-pill fw-medium fs-12"&gt;Light&lt;/span&gt;
&lt;span class="badge bg-opacity-10 bg-dark py-1 px-2 text-dark rounded-pill fw-medium fs-12"&gt;Dark&lt;/span&gt;
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
                                    <h4 class="fs-18 mb-4">Headings Badges </h4>
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
                                            <h1>Example heading <span class="badge bg-primary">New</span></h1>
                                            <h2>Example heading <span class="badge bg-secondary">New</span></h2>
                                            <h3>Example heading <span class="badge bg-success">New</span></h3>
                                            <h4>Example heading <span class="badge bg-warning">New</span></h4>
                                            <h5>Example heading <span class="badge bg-danger">New</span></h5>
                                            <h6>Example heading <span class="badge bg-info">New</span></h6>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode5">
&lt;h1&gt;Example heading &lt;span class="badge bg-primary"&gt;New&lt;/span&gt;&lt;/h1&gt;
&lt;h2&gt;Example heading &lt;span class="badge bg-secondary"&gt;New&lt;/span&gt;&lt;/h2&gt;
&lt;h3&gt;Example heading &lt;span class="badge bg-success"&gt;New&lt;/span&gt;&lt;/h3&gt;
&lt;h4&gt;Example heading &lt;span class="badge bg-warning"&gt;New&lt;/span&gt;&lt;/h4&gt;
&lt;h5&gt;Example heading &lt;span class="badge bg-danger"&gt;New&lt;/span&gt;&lt;/h5&gt;
&lt;h6&gt;Example heading &lt;span class="badge bg-info"&gt;New&lt;/span&gt;&lt;/h6&gt;
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
                                    <h4 class="fs-18 mb-4">Other Badges</h4>
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
                                            <button type="button" class="btn btn-primary fw-medium text-white">
                                                Notifications <span class="badge text-bg-danger text-white">4</span>
                                            </button>
                                            <div class="mb-4"></div>
                                            <button type="button" class="btn btn-primary position-relative fw-medium text-white">
                                                Inbox
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    99+
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </button>
                                            <div class="mb-4"></div>
                                            <button type="button" class="btn btn-primary position-relative fw-medium text-white">
                                                Profile
                                                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                                    <span class="visually-hidden">New alerts</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="tab-pane fade" id="code6-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode6">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode6">
&lt;button type="button" class="btn btn-primary fw-medium text-white"&gt;
    Notifications &lt;span class="badge text-bg-danger text-white"&gt;4&lt;/span&gt;
&lt;/button&gt;

&lt;button type="button" class="btn btn-primary position-relative fw-medium text-white"&gt;
    Inbox
    &lt;span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"&gt;
        99+
        &lt;span class="visually-hidden"&gt;unread messages&lt;/span&gt;
    &lt;/span&gt;
&lt;/button&gt;

&lt;button type="button" class="btn btn-primary position-relative fw-medium text-white"&gt;
    Profile
    &lt;span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"&gt;
        &lt;span class="visually-hidden"&gt;New alerts&lt;/span&gt;
    &lt;/span&gt;
&lt;/button&gt;
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
                                    <h4 class="fs-18 mb-4">Badges With Icons</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab7" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview7-tab" data-bs-toggle="tab" data-bs-target="#preview7-tab-pane" type="button" role="tab" aria-controls="preview7-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code7-tab" data-bs-toggle="tab" data-bs-target="#code7-tab-pane" type="button" role="tab" aria-controls="code6-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent7">
                                        <div class="tab-pane fade show active" id="preview7-tab-pane" role="tabpanel" aria-labelledby="preview7-tab" tabindex="0">
                                            <div class="d-flex">
                                                <span class="badge text-bg-primary bg-opacity-10 py-1 px-2 text-primary rounded-1 fw-medium fs-12 d-flex align-items-center gap-1 py-3 px-4">
                                                    <i class="ri-layout-grid-fill fs-18"></i>
                                                    <span class="ms-1 fw-medium fs-15">Dashboard</span>
                                                    <span class="ms-1 bg-primary text-white py-1 px-2 rounded-1 fs-14 lh-1 ms-4">4</span>
                                                    <i class="ri-arrow-down-s-line ms-1"></i>
                                                </span>
                                                <span class="badge text-bg-primary py-1 px-2 text-white rounded-1 fw-medium fs-12 d-flex align-items-center gap-1 py-3 px-4 ms-3">
                                                    <i class="ri-layout-grid-fill fs-18"></i>
                                                    <span class="ms-1 fw-medium fs-15">Dashboard</span>
                                                    <span class="ms-1 bg-white bg-opacity-10 text-white py-1 px-2 rounded-1 fs-14 lh-1 ms-4">4</span>
                                                    <i class="ri-arrow-down-s-line ms-1"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code7-tab-pane" role="tabpanel" aria-labelledby="code7-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode6">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode6">
&lt;span class="badge text-bg-primary bg-opacity-10 py-1 px-2 text-primary rounded-1 fw-medium fs-12 d-flex align-items-center gap-1 py-3 px-4"&gt;
    &lt;i class="ri-layout-grid-fill fs-18"&gt;&lt;/i&gt;
    &lt;span class="ms-1 fw-medium fs-15"&gt;Dashboard&lt;/span&gt;
    &lt;span class="ms-1 bg-primary text-white py-1 px-2 rounded-1 fs-14 lh-1 ms-4"&gt;4&lt;/span&gt;
    &lt;i class="ri-arrow-down-s-line ms-1"&gt;&lt;/i&gt;
&lt;/span&gt;
&lt;span class="badge text-bg-primary py-1 px-2 text-white rounded-1 fw-medium fs-12 d-flex align-items-center gap-1 py-3 px-4 ms-3"&gt;
    &lt;i class="ri-layout-grid-fill fs-18"&gt;&lt;/i&gt;
    &lt;span class="ms-1 fw-medium fs-15"&gt;Dashboard&lt;/span&gt;
    &lt;span class="ms-1 bg-white bg-opacity-10 text-white py-1 px-2 rounded-1 fs-14 lh-1 ms-4"&gt;4&lt;/span&gt;
    &lt;i class="ri-arrow-down-s-line ms-1"&gt;&lt;/i&gt;
&lt;/span&gt;
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
