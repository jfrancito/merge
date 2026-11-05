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
                        <h3 class="mb-0">Avatar</h3>

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
                                    <span class="fw-medium">Avatar</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-xxl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Single User Example</h4>
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
                                            <div class="d-sm-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center mb-3 mb-sm-0">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-62.jpg" class="wh-60 rounded-circle" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h4 class="fs-16 fw-semibold mb-1">Andrew Burns</h4>
                                                        <span class="fs-14">Programmer</span>
                                                    </div>
                                                </div>
                                                <ul class="ps-0 mb-0 list-unstyled d-flex gap-2">
                                                    <li>
                                                        <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-40 bg-primary bg-opacity-10 d-block
                                                        text-center position-relative rounded-circle text-primary hover-bg">
                                                            <i class="ri-facebook-fill position-absolute top-50 start-50 translate-middle fs-18"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-40 bg-primary bg-opacity-10 d-block
                                                        text-center position-relative rounded-circle text-primary hover-bg">
                                                            <i class="ri-twitter-x-line position-absolute top-50 start-50 translate-middle fs-18"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-40 bg-primary bg-opacity-10 d-block
                                                        text-center position-relative rounded-circle text-primary hover-bg">
                                                            <i class="ri-linkedin-fill position-absolute top-50 start-50 translate-middle fs-18"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;div class="card bg-white border-0 rounded-3 mb-4"&gt;
    &lt;div class="card-body p-4"&gt;
        &lt;h4 class="fs-18 mb-4"&gt;Single User Example&lt;/h4&gt;
        &lt;div class="d-sm-flex justify-content-between align-items-center"&gt;
            &lt;div class="d-flex align-items-center mb-3 mb-sm-0"&gt;
                &lt;div class="flex-shrink-0"&gt;
                    &lt;img src="/assets/images/user-62.jpg" class="wh-60 rounded-circle" alt="user"&gt;
                &lt;/div&gt;
                &lt;div class="flex-grow-1 ms-3"&gt;
                    &lt;h4 class="fs-16 fw-semibold mb-1"&gt;Andrew Burns&lt;/h4&gt;
                    &lt;span class="fs-14"&gt;Programmer&lt;/span&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;ul class="ps-0 mb-0 list-unstyled d-flex gap-2"&gt;
                &lt;li&gt;
                    &lt;a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-40 bg-primary bg-opacity-10 d-block
                    text-center position-relative rounded-circle text-primary hover-bg"&gt;
                        &lt;i class="ri-facebook-fill position-absolute top-50 start-50 translate-middle fs-18"&gt;&lt;/i&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
                &lt;li&gt;
                    &lt;a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-40 bg-primary bg-opacity-10 d-block
                    text-center position-relative rounded-circle text-primary hover-bg"&gt;
                        &lt;i class="ri-twitter-x-line position-absolute top-50 start-50 translate-middle fs-18"&gt;&lt;/i&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
                &lt;li&gt;
                    &lt;a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-40 bg-primary bg-opacity-10 d-block
                    text-center position-relative rounded-circle text-primary hover-bg"&gt;
                        &lt;i class="ri-linkedin-fill position-absolute top-50 start-50 translate-middle fs-18"&gt;&lt;/i&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
            &lt;/ul&gt;
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
                        <div class="col-lg-6 col-xxl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Group User Example</h4>
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
                                            <div class="d-flex justify-content-between">
                                                <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                    <li>
                                                        <a href="#">
                                                            <img src="/assets/images/user-1.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user">
                                                        </a>
                                                    </li>
                                                    <li class="ms-m-15">
                                                        <a href="#">
                                                            <img src="/assets/images/user-2.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user">
                                                        </a>
                                                    </li>
                                                    <li class="ms-m-15">
                                                        <a href="#">
                                                            <img src="/assets/images/user-3.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user">
                                                        </a>
                                                    </li>
                                                    <li class="ms-m-15">
                                                        <a href="#" class="wh-40 rounded-circle bg-primary d-block text-center position-relative text-decoration-none text-white hover-bg">
                                                            <i class="ri-add-line fs-20 position-absolute top-50 start-50 translate-middle"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <a href="#" class="btn bg-primary bg-opacity-10 fw-bold fs-14 hover-bg">
                                                    <span class="position-relative top-2">View Details</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
&lt;div class="card bg-white border-0 rounded-3 mb-4"&gt;
    &lt;div class="card-body p-4"&gt;
        &lt;h4 class="fs-18 mb-4"&gt;Group User Example&lt;/h4&gt;

        &lt;div class="d-flex justify-content-between"&gt;
            &lt;ul class="ps-0 mb-0 list-unstyled d-flex align-items-center"&gt;
                &lt;li&gt;
                    &lt;a href="#"&gt;
                        &lt;img src="/assets/images/user-1.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user"&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
                &lt;li class="ms-15"&gt;
                    &lt;a href="#"&gt;
                        &lt;img src="/assets/images/user-2.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user"&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
                &lt;li class="ms-15"&gt;
                    &lt;a href="#"&gt;
                        &lt;img src="/assets/images/user-3.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user"&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
                &lt;li class="ms-15"&gt;
                    &lt;a href="#" class="wh-40 rounded-circle bg-primary d-block text-center position-relative text-decoration-none text-white hover-bg"&gt;
                        &lt;i class="ri-add-line fs-20 position-absolute top-50 start-50 translate-middle"&gt;&lt;/i&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
            &lt;/ul&gt;

            &lt;a href="#" class="btn bg-primary bg-opacity-10 fw-bold fs-14 hover-bg"&gt;
                &lt;span class="position-relative top-2"&gt;View Details&lt;/span&gt;
            &lt;/a&gt;
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
                        <div class="col-lg-6 col-xxl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Single User With Badge Example</h4>
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
                                            <div class="d-flex justify-content-between">
                                                <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center gap-1">
                                                    <li>
                                                        <a href="#" class="position-relative d-block">
                                                            <img src="/assets/images/user-1.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user">
                                                            <div class="position-absolute top-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="position-relative d-block">
                                                            <img src="/assets/images/user-2.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user">
                                                            <div class="position-absolute top-0 end-0 p-1 bg-primary border border-2 border-white rounded-circle"></div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="position-relative d-block">
                                                            <img src="/assets/images/user-3.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user">
                                                            <div class="position-absolute top-0 end-0 p-1 bg-warning border border-2 border-white rounded-circle"></div>
                                                        </a>
                                                    </li>
                                                </ul>
    
                                                <a href="#" class="btn bg-primary bg-opacity-10 fw-bold fs-14 hover-bg">
                                                    <span class="position-relative top-2">View Details</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
&lt;div class="card bg-white border-0 rounded-3 mb-4"&gt;
    &lt;div class="card-body p-4"&gt;
        &lt;h4 class="fs-18 mb-4"&gt;Single User With Badge Example&lt;/h4&gt;

        &lt;div class="d-flex justify-content-between"&gt;
            &lt;ul class="ps-0 mb-0 list-unstyled d-flex align-items-center gap-1"&gt;
                &lt;li&gt;
                    &lt;a href="#" class="position-relative d-block"&gt;
                        &lt;img src="/assets/images/user-1.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user"&gt;
                        &lt;div class="position-absolute top-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"&gt;&lt;/div&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
                &lt;li&gt;
                    &lt;a href="#" class="position-relative d-block"&gt;
                        &lt;img src="/assets/images/user-2.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user"&gt;
                        &lt;div class="position-absolute top-0 end-0 p-1 bg-primary border border-2 border-white rounded-circle"&gt;&lt;/div&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
                &lt;li&gt;
                    &lt;a href="#" class="position-relative d-block"&gt;
                        &lt;img src="/assets/images/user-3.jpg" class="wh-40 rounded-circle border border-2 border-color-white" alt="user"&gt;
                        &lt;div class="position-absolute top-0 end-0 p-1 bg-warning border border-2 border-white rounded-circle"&gt;&lt;/div&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
            &lt;/ul&gt;

            &lt;a href="#" class="btn bg-primary bg-opacity-10 fw-bold fs-14 hover-bg"&gt;
                &lt;span class="position-relative top-2"&gt;View Details&lt;/span&gt;
            &lt;/a&gt;
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
                        <div class="col-lg-6 overflow-hidden">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Avatar Size Rounded-Circle Example</h4>
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
                                            <div class="d-flex align-items-center gap-4 flex-wrap">
                                                <img src="/assets/images/user-68.jpg" class="wh-87 rounded-circle" alt="user">
                                                <img src="/assets/images/user-68.jpg" class="wh-77 rounded-circle" alt="user">
                                                <img src="/assets/images/user-68.jpg" class="wh-67 rounded-circle" alt="user">
                                                <img src="/assets/images/user-68.jpg" class="wh-57 rounded-circle" alt="user">
                                                <img src="/assets/images/user-68.jpg" class="wh-47 rounded-circle" alt="user">
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
&lt;img src="/assets/images/user-68.jpg" class="wh-87 rounded-circle" alt="user"&gt;
&lt;img src="/assets/images/user-68.jpg" class="wh-77 rounded-circle" alt="user"&gt;
&lt;img src="/assets/images/user-68.jpg" class="wh-67 rounded-circle" alt="user"&gt;
&lt;img src="/assets/images/user-68.jpg" class="wh-57 rounded-circle" alt="user"&gt;
&lt;img src="/assets/images/user-68.jpg" class="wh-47 rounded-circle" alt="user"&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 overflow-hidden">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Avatar Size Simple Rounded Example</h4>
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
                                            <div class="d-flex align-items-center gap-4 flex-wrap">
                                                <img src="/assets/images/screenshorts.jpg" class="wh-87 rounded-3" alt="screenshorts">
                                                <img src="/assets/images/screenshorts.jpg" class="wh-77 rounded-3" alt="screenshorts">
                                                <img src="/assets/images/screenshorts.jpg" class="wh-67 rounded-3" alt="screenshorts">
                                                <img src="/assets/images/screenshorts.jpg" class="wh-57 rounded-3" alt="screenshorts">
                                                <img src="/assets/images/screenshorts.jpg" class="wh-47 rounded-3" alt="screenshorts">
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode5">
&lt;img src="/assets/images/screenshorts.jpg" class="wh-87 rounded-3" alt="screenshorts"&gt;
&lt;img src="/assets/images/screenshorts.jpg" class="wh-77 rounded-3" alt="screenshorts"&gt;
&lt;img src="/assets/images/screenshorts.jpg" class="wh-67 rounded-3" alt="screenshorts"&gt;
&lt;img src="/assets/images/screenshorts.jpg" class="wh-57 rounded-3" alt="screenshorts"&gt;
&lt;img src="/assets/images/screenshorts.jpg" class="wh-47 rounded-3" alt="screenshorts"&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 overflow-hidden">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Avatar Size Rounded-Circle Example</h4>
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
                                            <div class="d-flex align-items-center gap-4 flex-wrap">
                                                <div class="wh-87 rounded-circle position-relative text-center bg-primary bg-opacity-10">
                                                    <span class="fs-3 text-primary fw-semibold position-absolute top-50 start-50 translate-middle">Ab</span>
                                                </div>
                                                <div class="wh-77 rounded-circle position-relative text-center bg-primary bg-opacity-10">
                                                    <span class="fs-24 text-primary fw-semibold position-absolute top-50 start-50 translate-middle">Ab</span>
                                                </div>
                                                <div class="wh-67 rounded-circle position-relative text-center bg-primary bg-opacity-10">
                                                    <span class="fs-20 text-primary fw-semibold position-absolute top-50 start-50 translate-middle">Ab</span>
                                                </div>
                                                <div class="wh-57 rounded-circle position-relative text-center bg-primary bg-opacity-10">
                                                    <span class="fs-16 text-primary fw-semibold position-absolute top-50 start-50 translate-middle">Ab</span>
                                                </div>
                                                <div class="wh-47 rounded-circle position-relative text-center bg-primary bg-opacity-10">
                                                    <span class="fs-14 text-primary fw-semibold position-absolute top-50 start-50 translate-middle">Ab</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code6-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode6">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode6">
&lt;div class="wh-87 rounded-circle position-relative text-center bg-primary bg-opacity-10"&gt;
    &lt;span class="fs-3 text-primary fw-semibold position-absolute top-50 start-50 translate-middle"&gt;Ab&lt;/span&gt;
&lt;/div&gt;
&lt;div class="wh-77 rounded-circle position-relative text-center bg-primary bg-opacity-10"&gt;
    &lt;span class="fs-24 text-primary fw-semibold position-absolute top-50 start-50 translate-middle"&gt;Ab&lt;/span&gt;
&lt;/div&gt;
&lt;div class="wh-67 rounded-circle position-relative text-center bg-primary bg-opacity-10"&gt;
    &lt;span class="fs-20 text-primary fw-semibold position-absolute top-50 start-50 translate-middle"&gt;Ab&lt;/span&gt;
&lt;/div&gt;
&lt;div class="wh-57 rounded-circle position-relative text-center bg-primary bg-opacity-10"&gt;
    &lt;span class="fs-16 text-primary fw-semibold position-absolute top-50 start-50 translate-middle"&gt;Ab&lt;/span&gt;
&lt;/div&gt;
&lt;div class="wh-47 rounded-circle position-relative text-center bg-primary bg-opacity-10"&gt;
    &lt;span class="fs-14 text-primary fw-semibold position-absolute top-50 start-50 translate-middle"&gt;Ab&lt;/span&gt;
&lt;/div&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 overflow-hidden">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Avatar Size Simple Rounded Example</h4>
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
                                            <div class="d-flex align-items-center gap-4 flex-wrap">
                                                <div class="wh-87 rounded-3 position-relative text-center bg-primary bg-opacity-10">
                                                    <span class="fs-3 text-primary fw-semibold position-absolute top-50 start-50 translate-middle">Ab</span>
                                                </div>
                                                <div class="wh-77 rounded-3 position-relative text-center bg-primary bg-opacity-10">
                                                    <span class="fs-24 text-primary fw-semibold position-absolute top-50 start-50 translate-middle">Ab</span>
                                                </div>
                                                <div class="wh-67 rounded-3 position-relative text-center bg-primary bg-opacity-10">
                                                    <span class="fs-20 text-primary fw-semibold position-absolute top-50 start-50 translate-middle">Ab</span>
                                                </div>
                                                <div class="wh-57 rounded-3 position-relative text-center bg-primary bg-opacity-10">
                                                    <span class="fs-16 text-primary fw-semibold position-absolute top-50 start-50 translate-middle">Ab</span>
                                                </div>
                                                <div class="wh-47 rounded-3 position-relative text-center bg-primary bg-opacity-10">
                                                    <span class="fs-14 text-primary fw-semibold position-absolute top-50 start-50 translate-middle">Ab</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code7-tab-pane" role="tabpanel" aria-labelledby="code7-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode7">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode7">
&lt;div class="wh-87 rounded-3 position-relative text-center bg-primary bg-opacity-10"&gt;
    &lt;span class="fs-3 text-primary fw-semibold position-absolute top-50 start-50 translate-middle"&gt;Ab&lt;/span&gt;
&lt;/div&gt;
&lt;div class="wh-77 rounded-3 position-relative text-center bg-primary bg-opacity-10"&gt;
    &lt;span class="fs-24 text-primary fw-semibold position-absolute top-50 start-50 translate-middle"&gt;Ab&lt;/span&gt;
&lt;/div&gt;
&lt;div class="wh-67 rounded-3 position-relative text-center bg-primary bg-opacity-10"&gt;
    &lt;span class="fs-20 text-primary fw-semibold position-absolute top-50 start-50 translate-middle"&gt;Ab&lt;/span&gt;
&lt;/div&gt;
&lt;div class="wh-57 rounded-3 position-relative text-center bg-primary bg-opacity-10"&gt;
    &lt;span class="fs-16 text-primary fw-semibold position-absolute top-50 start-50 translate-middle"&gt;Ab&lt;/span&gt;
&lt;/div&gt;
&lt;div class="wh-47 rounded-3 position-relative text-center bg-primary bg-opacity-10"&gt;
    &lt;span class="fs-14 text-primary fw-semibold position-absolute top-50 start-50 translate-middle"&gt;Ab&lt;/span&gt;
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
