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
                        <h3 class="mb-0">Cards</h3>

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
                                    <span class="fw-medium">Cards</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xxl-3 col-md-6 position-relative">
                            <ul class="nav nav-tabs mb-4 bg-white" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview-tab-pane" type="button" role="tab" aria-controls="preview-tab-pane" aria-selected="true">Preview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code-tab-pane" type="button" role="tab" aria-controls="code-tab-pane" aria-selected="false">Code</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="preview-tab-pane" role="tabpanel" aria-labelledby="preview-tab" tabindex="0">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <span class="badge bg-primary bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium">Primary</span>
                                                <span class="badge bg-success bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium">Success</span>
                                            </div>
                                            <h3 class="mb-3 fs-16 fw-semibold">Nesta Technologies</h3>
                                            <p class="mb-20">When you enter into any new area of science, you almost always find.</p>
                                            <a href="#" class="btn btn-primary py-2 px-4 bg-primary bg-opacity-10 fw-semibold text-primary border-0 hover-bg">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                    <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0 mt-5" data-clipboard-target="#basicAlertsCode">
                                        Copy
                                    </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode">
    &lt;div class="card bg-white border-0 rounded-3 mb-4"&gt;
        &lt;div class="card-body p-4"&gt;
            &lt;div class="mb-4"&gt;
                &lt;span class="badge bg-primary bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Primary&lt;/span&gt;
                &lt;span class="badge bg-success bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Success&lt;/span&gt;
            &lt;/div&gt;
            &lt;h3 class="mb-3 fs-16 fw-semibold"&gt;Nesta Technologies&lt;/h3&gt;
            &lt;p class="mb-20"&gt;When you enter into any new area of science, you almost always find.&lt;/p&gt;
            &lt;a href="#" class="btn btn-primary py-2 px-4 bg-primary bg-opacity-10 fw-semibold text-primary border-0 hover-bg"&gt;
                View Details
            &lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 position-relative">
                            <ul class="nav nav-tabs mb-4 bg-white" id="myTab2" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="preview2-tab" data-bs-toggle="tab" data-bs-target="#preview2-tab-pane" type="button" role="tab" aria-controls="preview2-tab-pane" aria-selected="true">Preview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="code2-tab" data-bs-toggle="tab" data-bs-target="#code2-tab-pane" type="button" role="tab" aria-controls="code2-tab-pane" aria-selected="false">Code</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTab2Content">
                                <div class="tab-pane fade show active" id="preview2-tab-pane" role="tabpanel" aria-labelledby="preview2-tab" tabindex="0">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <span class="badge bg-success bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium">Success</span>
                                            </div>
                                            <h3 class="mb-3 fs-16 fw-semibold">Nesta Technologies</h3>
                                            <p class="mb-20">When you enter into any new area of science, you almost always find.</p>
                                            <a href="#" class="btn btn-primary py-2 px-4 bg-primary bg-opacity-10 fw-semibold text-primary border-0 hover-bg">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                    <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0 mt-5" data-clipboard-target="#basicAlertsCode2">
                                        Copy
                                    </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode2">
    &lt;div class="card bg-white border-0 rounded-3 mb-4"&gt;
        &lt;div class="card-body p-4"&gt;
            &lt;div class="mb-4"&gt;
                &lt;span class="badge bg-primary bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Primary&lt;/span&gt;
                &lt;span class="badge bg-success bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Success&lt;/span&gt;
            &lt;/div&gt;
            &lt;h3 class="mb-3 fs-16 fw-semibold"&gt;Nesta Technologies&lt;/h3&gt;
            &lt;p class="mb-20"&gt;When you enter into any new area of science, you almost always find.&lt;/p&gt;
            &lt;a href="#" class="btn btn-primary py-2 px-4 bg-primary bg-opacity-10 fw-semibold text-primary border-0 hover-bg"&gt;
                View Details
            &lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 position-relative">
                            <ul class="nav nav-tabs mb-4 bg-white" id="myTab3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="preview3-tab" data-bs-toggle="tab" data-bs-target="#preview3-tab-pane" type="button" role="tab" aria-controls="preview3-tab-pane" aria-selected="true">Preview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="code3-tab" data-bs-toggle="tab" data-bs-target="#code3-tab-pane" type="button" role="tab" aria-controls="code3-tab-pane" aria-selected="false">Code</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTab3Content">
                                <div class="tab-pane fade show active" id="preview3-tab-pane" role="tabpanel" aria-labelledby="preview3-tab" tabindex="0">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <span class="badge bg-primary bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium">Primary</span>
                                                <span class="badge bg-warning bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium">warning</span>
                                            </div>
                                            <h3 class="mb-3 fs-16 fw-semibold">Nesta Technologies</h3>
                                            <p class="mb-20">When you enter into any new area of science, you almost always find.</p>
                                            <a href="#" class="btn btn-primary py-2 px-4 bg-primary bg-opacity-10 fw-semibold text-primary border-0 hover-bg">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                    <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0 mt-5" data-clipboard-target="#basicAlertsCode3">
                                        Copy
                                    </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode3">
    &lt;div class="card bg-white border-0 rounded-3 mb-4"&gt;
        &lt;div class="card-body p-4"&gt;
            &lt;div class="mb-4"&gt;
                &lt;span class="badge bg-primary bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Primary&lt;/span&gt;
                &lt;span class="badge bg-success bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Success&lt;/span&gt;
            &lt;/div&gt;
            &lt;h3 class="mb-3 fs-16 fw-semibold"&gt;Nesta Technologies&lt;/h3&gt;
            &lt;p class="mb-20"&gt;When you enter into any new area of science, you almost always find.&lt;/p&gt;
            &lt;a href="#" class="btn btn-primary py-2 px-4 bg-primary bg-opacity-10 fw-semibold text-primary border-0 hover-bg"&gt;
                View Details
            &lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 position-relative">
                            <ul class="nav nav-tabs mb-4 bg-white" id="myTab4" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="preview4-tab" data-bs-toggle="tab" data-bs-target="#preview4-tab-pane" type="button" role="tab" aria-controls="preview4-tab-pane" aria-selected="true">Preview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="code4-tab" data-bs-toggle="tab" data-bs-target="#code4-tab-pane" type="button" role="tab" aria-controls="code4-tab-pane" aria-selected="false">Code</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTab4Content">
                                <div class="tab-pane fade show active" id="preview4-tab-pane" role="tabpanel" aria-labelledby="preview4-tab" tabindex="0">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <span class="badge bg-warning bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-semibold">Warning</span>
                                            </div>
                                            <h3 class="mb-3 fs-16 fw-semibold">Nesta Technologies</h3>
                                            <p class="mb-20">When you enter into any new area of science, you almost always find.</p>
                                            <a href="#" class="btn btn-primary py-2 px-4 bg-primary bg-opacity-10 fw-semibold text-primary border-0 hover-bg">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                    <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0 mt-5" data-clipboard-target="#basicAlertsCode4">
                                        Copy
                                    </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode4">
    &lt;div class="card bg-white border-0 rounded-3 mb-4"&gt;
        &lt;div class="card-body p-4"&gt;
            &lt;div class="mb-4"&gt;
                &lt;span class="badge bg-primary bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Primary&lt;/span&gt;
                &lt;span class="badge bg-success bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Success&lt;/span&gt;
            &lt;/div&gt;
            &lt;h3 class="mb-3 fs-16 fw-semibold"&gt;Nesta Technologies&lt;/h3&gt;
            &lt;p class="mb-20"&gt;When you enter into any new area of science, you almost always find.&lt;/p&gt;
            &lt;a href="#" class="btn btn-primary py-2 px-4 bg-primary bg-opacity-10 fw-semibold text-primary border-0 hover-bg"&gt;
                View Details
            &lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 position-relative">
                            <ul class="nav nav-tabs mb-4 bg-white" id="myTab5" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="preview5-tab" data-bs-toggle="tab" data-bs-target="#preview5-tab-pane" type="button" role="tab" aria-controls="preview5-tab-pane" aria-selected="true">Preview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="code5-tab" data-bs-toggle="tab" data-bs-target="#code5-tab-pane" type="button" role="tab" aria-controls="code5-tab-pane" aria-selected="false">Code</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTab5Content">
                                <div class="tab-pane fade show active" id="preview5-tab-pane" role="tabpanel" aria-labelledby="preview5-tab" tabindex="0">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <span class="badge bg-primary bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium">Primary</span>
                                                <span class="badge bg-warning bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium">Warning</span>
                                                <span class="badge bg-success bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium">Success</span>
                                            </div>
                                            <img src="assets/images/card-1.jpg" class="mb-4 rounded-3" alt="card">
                                            <h3 class="mb-3 fs-16 fw-semibold">Nesta Technologies</h3>
                                            <p class="mb-20">When you enter into any new area of science, you almost always find.</p>
                                            <a href="#" class="btn btn-primary py-2 px-4 bg-primary bg-opacity-10 fw-semibold text-primary border-0 hover-bg">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                    <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0 mt-5" data-clipboard-target="#basicAlertsCode5">
                                        Copy
                                    </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode5">
    &lt;div class="card bg-white border-0 rounded-3 mb-4"&gt;
        &lt;div class="card-body p-4"&gt;
            &lt;div class="mb-4"&gt;
                &lt;span class="badge bg-primary bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Primary&lt;/span&gt;
                &lt;span class="badge bg-success bg-opacity-50 rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Success&lt;/span&gt;
            &lt;/div&gt;
            &lt;img src="assets/images/card-1.jpg" class="mb-4 rounded-3" alt="card"&gt;
            &lt;h3 class="mb-3 fs-16 fw-semibold"&gt;Nesta Technologies&lt;/h3&gt;
            &lt;p class="mb-20"&gt;When you enter into any new area of science, you almost always find.&lt;/p&gt;
            &lt;a href="#" class="btn btn-primary py-2 px-4 bg-primary bg-opacity-10 fw-semibold text-primary border-0 hover-bg"&gt;
                View Details
            &lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 position-relative">
                            <ul class="nav nav-tabs mb-4 bg-white" id="myTab6" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="preview6-tab" data-bs-toggle="tab" data-bs-target="#preview6-tab-pane" type="button" role="tab" aria-controls="preview6-tab-pane" aria-selected="true">Preview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="code6-tab" data-bs-toggle="tab" data-bs-target="#code6-tab-pane" type="button" role="tab" aria-controls="code6-tab-pane" aria-selected="false">Code</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTab6Content">
                                <div class="tab-pane fade show active" id="preview6-tab-pane" role="tabpanel" aria-labelledby="preview6-tab" tabindex="0">
                                    <div class="card text-bg-dark border-0 rounded-3">
                                        <img src="assets/images/card-2.jpg" class="card-img" alt="card">
                                        <div class="position-absolute top-0 p-3">
                                            <span class="badge bg-primary rounded-1 text-dark py-2 px-3 fs-13 fw-medium">Primary</span>
                                            <span class="badge bg-warning rounded-1 text-dark py-2 px-3 fs-13 fw-medium">Warning</span>
                                            <span class="badge bg-success rounded-1 text-dark py-2 px-3 fs-13 fw-medium">Success</span>
                                        </div>
                                        <div class="card-img-overlay" style="top: auto; bottom: 0;">
                                            <h5 class="card-title fs-18 fw-semibold">Card title</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small>Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="code6-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                    <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0 mt-5" data-clipboard-target="#basicAlertsCode6">
                                        Copy
                                    </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode6">
    &lt;div class="card text-bg-dark border-0 rounded-3"&gt;
        &lt;img src="assets/images/card-2.jpg" class="card-img" alt="card"&gt;
        &lt;div class="position-absolute top-0 p-3"&gt;
            &lt;span class="badge bg-primary rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Primary&lt;/span&gt;
            &lt;span class="badge bg-warning rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Warning&lt;/span&gt;
            &lt;span class="badge bg-success rounded-1 text-dark py-2 px-3 fs-13 fw-medium"&gt;Success&lt;/span&gt;
        &lt;/div&gt;
        &lt;div class="card-img-overlay" style="top: auto; bottom: 0;"&gt;
            &lt;h5 class="card-title"&gt;Card title&lt;/h5&gt;
            &lt;p class="card-text"&gt;This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.&lt;/p&gt;
            &lt;p class="card-text"&gt;&lt;small&gt;Last updated 3 mins ago&lt;/small&gt;&lt;/p&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    </code>
    </pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 position-relative">
                            <ul class="nav nav-tabs mb-4 bg-white" id="myTab7" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="preview7-tab" data-bs-toggle="tab" data-bs-target="#preview7-tab-pane" type="button" role="tab" aria-controls="preview7-tab-pane" aria-selected="true">Preview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="code7-tab" data-bs-toggle="tab" data-bs-target="#code7-tab-pane" type="button" role="tab" aria-controls="code7-tab-pane" aria-selected="false">Code</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTab7Content">
                                <div class="tab-pane fade show active" id="preview7-tab-pane" role="tabpanel" aria-labelledby="preview7-tab" tabindex="0">
                                    <div class="card bg-white">
                                        <div class="card-header fs-16 fw-semibold">
                                            Featured
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">An item</li>
                                            <li class="list-group-item">A second item</li>
                                            <li class="list-group-item">A third item</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="code7-tab-pane" role="tabpanel" aria-labelledby="code7-tab" tabindex="0">
                                    <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0 mt-5" data-clipboard-target="#basicAlertsCode7">
                                        Copy
                                    </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode7">
    &lt;div class="card bg-white"&gt;
        &lt;div class="card-header fs-16 fw-semibold"&gt;
            Featured
        &lt;/div&gt;
        &lt;ul class="list-group list-group-flush"&gt;
            &lt;li class="list-group-item"&gt;An item&lt;/li&gt;
            &lt;li class="list-group-item"&gt;A second item&lt;/li&gt;
            &lt;li class="list-group-item"&gt;A third item&lt;/li&gt;
        &lt;/ul&gt;
    &lt;/div&gt;
    </code>
    </pre>
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
