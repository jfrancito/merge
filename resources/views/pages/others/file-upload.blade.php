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
                        <h3 class="mb-0">File Upload</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Forms</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">File Upload</span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                   
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
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
                                            <div class="form-group mb-4">
                                                <label class="label text-dark fs-18">Project Preview Image</label>
                                                <div class="form-control h-100 text-center position-relative p-4 p-lg-5">
                                                    <div class="product-upload">
                                                        <label for="file-upload" class="file-upload mb-0">
                                                            <i class="ri-folder-image-line bg-primary bg-opacity-10 p-2 rounded-1 text-primary"></i>
                                                            <span class="d-block text-body fs-14">Drag and drop an image or <span class="text-primary text-decoration-underline">Browse</span></span>
                                                        </label>
                                                        <input id="file-upload" type="file">
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
<div>
<div>&lt;div class="form-group mb-4"&gt;</div>
<div>    &lt;label class="label text-dark fs-18"&gt;Project Preview Image&lt;/label&gt;</div>
<div>    &lt;div class="form-control h-100 text-center position-relative p-4 p-lg-5"&gt;</div>
<div>        &lt;div class="product-upload"&gt;</div>
<div>            &lt;label for="file-upload" class="file-upload mb-0"&gt;</div>
<div>                &lt;i class="ri-folder-image-line bg-primary bg-opacity-10 p-2 rounded-1 text-primary"&gt;&lt;/i&gt;</div>
<div>                &lt;span class="d-block text-body fs-14"&gt;Drag and drop an image or &lt;span class="text-primary text-decoration-underline"&gt;Browse&lt;/span&gt;&lt;/span&gt;</div>
<div>            &lt;/label&gt;</div>
<div>            &lt;input id="file-upload" type="file"&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/div&gt;</div>
</div>
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <ul class="nav nav-tabs mb-4" id="myTab2" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview2-tab" data-bs-toggle="tab" data-bs-target="#preview2-tab-pane" type="button" role="tab" aria-controls="preview2-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code2-tab-pane" type="button" role="tab" aria-controls="code2-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab2Content">
                                        <div class="tab-pane fade show active" id="preview2-tab-pane" role="tabpanel" aria-labelledby="preview2-tab" tabindex="0">
                                            <div class="form-group">
                                                <label class="label text-dark fs-18">File Upload - Product Gallery</label>
                                                <div class="form-control h-100 text-center position-relative p-4 p-lg-5">
                                                    <div class="product-upload">
                                                        <label for="file-upload" class="file-upload mb-0">
                                                            <i class="ri-upload-cloud-2-line fs-2 text-gray-light"></i>
                                                            <span class="d-block fw-semibold text-body">Drop files here or click to upload.</span>
                                                        </label>
                                                        <input id="file-upload" type="file">
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
<div>&lt;div class="form-group"&gt;</div>
<div>    &lt;label class="label"&gt;File Upload - Product Gallery&lt;/label&gt;</div>
<div>    &lt;div class="form-control h-100 text-center position-relative p-4 p-lg-5"&gt;</div>
<div>        &lt;div class="product-upload"&gt;</div>
<div>            &lt;label for="file-upload" class="file-upload mb-0"&gt;</div>
<div>                &lt;i class="ri-upload-cloud-2-line fs-2 text-gray-light"&gt;&lt;/i&gt;</div>
<div>                &lt;span class="d-block fw-semibold text-body"&gt;Drop files here or click to upload.&lt;/span&gt;</div>
<div>            &lt;/label&gt;</div>
<div>            &lt;input id="file-upload" type="file"&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/div&gt;</div>
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <ul class="nav nav-tabs mb-4" id="myTab3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview3-tab" data-bs-toggle="tab" data-bs-target="#preview3-tab-pane" type="button" role="tab" aria-controls="preview3-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code3-tab-pane" type="button" role="tab" aria-controls="code3-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab3Content">
                                        <div class="tab-pane fade show active" id="preview3-tab-pane" role="tabpanel" aria-labelledby="preview3-tab" tabindex="0">
                                            <label class="label text-dark fs-18">File Upload - Product Image2</label>
                                            <div class="form-group p-4 d-sm-flex justify-content-between align-items-center rounded-3">
                                                <div class="d-sm-flex align-items-center mb-3 mb-sm-0 me-lg-3">
                                                    <div class="me-md-5 pe-xxl-5 mb-3 mb-sm-0">
                                                        <h4 class="body-font fs-15 fw-semibold text-body">Project Avatar</h4>
                                                        <p>This will displayed on your project avatar.</p>
                                                    </div>
                                                    <img src="assets/images/product-6.jpg" class="rounded-4 wh-160 ms-3 ms-lg-0" alt="product">
                                                </div>
                                                
                                                <div class="d-flex ms-sm-3 ms-md-0">
                                                   <button class="btn bg-danger bg-opacity-10 text-danger fw-semibold">Delete</button>
                                                   <button class="btn bg-primary bg-opacity-10 text-primary fw-semibold ms-3">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
<div>&lt;div class="form-group p-4 d-sm-flex justify-content-between align-items-center rounded-3"&gt;</div>
<div>    &lt;div class="d-sm-flex align-items-center mb-3 mb-sm-0 me-lg-3"&gt;</div>
<div>        &lt;div class="me-md-5 pe-xxl-5 mb-3 mb-sm-0"&gt;</div>
<div>            &lt;h4 class="body-font fs-15 fw-semibold text-body"&gt;Project Avatar&lt;/h4&gt;</div>
<div>            &lt;p&gt;This will displayed on your project avatar.&lt;/p&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;img src="assets/images/product-11.jpg" class="rounded-4 wh-78 ms-3 ms-lg-0" alt="product"&gt;</div>
<div>    &lt;/div&gt;</div>
<div></div>
<div>    &lt;div class="d-flex ms-sm-3 ms-md-0"&gt;</div>
<div>        &lt;button class="btn bg-danger bg-opacity-10 text-danger fw-semibold"&gt;Delete&lt;/button&gt;</div>
<div>        &lt;button class="btn bg-primary bg-opacity-10 text-primary fw-semibold ms-3"&gt;Update&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/div&gt;</div>
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
