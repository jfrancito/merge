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
                        <h3 class="mb-0">Editors</h3>

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
                                    <span class="fw-medium">Editors</span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                   
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Editors</h4>
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
                                            <form>
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary fs-14">Description</label>
                                                    <div id="standalone-container">
                                                        <div id="toolbar-container" class="rounded-top-2">
                                                            <span class="ql-formats">
                                                                <select class="ql-font"></select>
                                                                <select class="ql-size"></select>
                                                            </span>
                                                            <span class="ql-formats">
                                                                <button class="ql-bold"></button>
                                                                <button class="ql-italic"></button>
                                                                <button class="ql-underline"></button>
                                                                <button class="ql-strike"></button>
                                                            </span>
                                                            <span class="ql-formats">
                                                                <button class="ql-blockquote"></button>
                                                                <button class="ql-code-block"></button>
                                                            </span>
                                                            <span class="ql-formats">
                                                                <button class="ql-list" value="ordered"></button>
                                                                <button class="ql-list" value="bullet"></button>
                                                                <button class="ql-indent" value="-1"></button>
                                                                <button class="ql-indent" value="+1"></button>
                                                            </span>
                                                            <span class="ql-formats">
                                                                <button class="ql-link"></button>
                                                                <button class="ql-image"></button>
                                                                <button class="ql-video"></button>
                                                            </span>
                                                        </div>
                                                        <div id="editor-container" style="height: 250px; border-color: #D5D9E2;" class="rounded-bottom-2"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex flex-wrap gap-3 align-items-center">
                                                        <button class="btn btn-primary text-white fw-semibold py-2 px-4 me-4" type="submit">
                                                            Send
                                                        </button>
                                                        <div class="position-relative top-3 d-flex align-items-baseline flex-wrap gap-sm-0">
                                                            <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Text">
                                                                <i class="material-symbols-outlined fs-20 text-body hover">text_fields_alt</i>
                                                            </button>
                                                            <button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="File">
                                                                <i class="material-symbols-outlined fs-20 text-body hover">attach_file</i>
                                                            </button>
                                                            <button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Link">
                                                                <i class="material-symbols-outlined fs-20 text-body hover">link</i>
                                                            </button>
                                                            <button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Mood">
                                                                <i class="material-symbols-outlined fs-20 text-body hover">mood</i>
                                                            </button>
                                                            <button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Drive">
                                                                <i class="material-symbols-outlined fs-20 text-body hover">add_to_drive</i>
                                                            </button>
                                                            <button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pen">
                                                                <i class="material-symbols-outlined fs-20 text-body hover">ink_pen</i>
                                                            </button>
                                                            <div class="dropdown action-opt ms-3 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                                                <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="material-symbols-outlined fs-20 text-body hover">more_vert</i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                                            <i data-feather="eye"></i>
                                                                            View All 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                                            <i data-feather="trash-2"></i>
                                                                            Delete One
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                                            <i data-feather="lock"></i>
                                                                            Block
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
<div>
<div>&lt;form&gt;</div>
<div>    &lt;div class="form-group mb-4"&gt;</div>
<div>        &lt;label class="label text-secondary fs-14"&gt;Description&lt;/label&gt;</div>
<div>        &lt;div id="standalone-container"&gt;</div>
<div>            &lt;div id="toolbar-container" class="rounded-top-2"&gt;</div>
<div>                &lt;span class="ql-formats"&gt;</div>
<div>                    &lt;select class="ql-font"&gt;&lt;/select&gt;</div>
<div>                    &lt;select class="ql-size"&gt;&lt;/select&gt;</div>
<div>                &lt;/span&gt;</div>
<div>                &lt;span class="ql-formats"&gt;</div>
<div>                    &lt;button class="ql-bold"&gt;&lt;/button&gt;</div>
<div>                    &lt;button class="ql-italic"&gt;&lt;/button&gt;</div>
<div>                    &lt;button class="ql-underline"&gt;&lt;/button&gt;</div>
<div>                    &lt;button class="ql-strike"&gt;&lt;/button&gt;</div>
<div>                &lt;/span&gt;</div>
<div>                &lt;span class="ql-formats"&gt;</div>
<div>                    &lt;button class="ql-blockquote"&gt;&lt;/button&gt;</div>
<div>                    &lt;button class="ql-code-block"&gt;&lt;/button&gt;</div>
<div>                &lt;/span&gt;</div>
<div>                &lt;span class="ql-formats"&gt;</div>
<div>                    &lt;button class="ql-list" value="ordered"&gt;&lt;/button&gt;</div>
<div>                    &lt;button class="ql-list" value="bullet"&gt;&lt;/button&gt;</div>
<div>                    &lt;button class="ql-indent" value="-1"&gt;&lt;/button&gt;</div>
<div>                    &lt;button class="ql-indent" value="+1"&gt;&lt;/button&gt;</div>
<div>                &lt;/span&gt;</div>
<div>                &lt;span class="ql-formats"&gt;</div>
<div>                    &lt;button class="ql-link"&gt;&lt;/button&gt;</div>
<div>                    &lt;button class="ql-image"&gt;&lt;/button&gt;</div>
<div>                    &lt;button class="ql-video"&gt;&lt;/button&gt;</div>
<div>                &lt;/span&gt;</div>
<div>            &lt;/div&gt;</div>
<div>            &lt;div id="editor-container" style="height: 250px; border-color: #D5D9E2;" class="rounded-bottom-2"&gt;&lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="form-group"&gt;</div>
<div>        &lt;div class="d-flex flex-wrap gap-3 align-items-center"&gt;</div>
<div>            &lt;button class="btn btn-primary text-white fw-semibold py-2 px-4 me-4" type="submit"&gt;</div>
<div>                Send</div>
<div>            &lt;/button&gt;</div>
<div>            &lt;div class="position-relative top-3 d-flex align-items-baseline flex-wrap gap-sm-0"&gt;</div>
<div>                &lt;button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Text"&gt;</div>
<div>                    &lt;i class="material-symbols-outlined fs-20 text-body hover"&gt;text_fields_alt&lt;/i&gt;</div>
<div>                &lt;/button&gt;</div>
<div>                &lt;button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="File"&gt;</div>
<div>                    &lt;i class="material-symbols-outlined fs-20 text-body hover"&gt;attach_file&lt;/i&gt;</div>
<div>                &lt;/button&gt;</div>
<div>                &lt;button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Link"&gt;</div>
<div>                    &lt;i class="material-symbols-outlined fs-20 text-body hover"&gt;link&lt;/i&gt;</div>
<div>                &lt;/button&gt;</div>
<div>                &lt;button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Mood"&gt;</div>
<div>                    &lt;i class="material-symbols-outlined fs-20 text-body hover"&gt;mood&lt;/i&gt;</div>
<div>                &lt;/button&gt;</div>
<div>                &lt;button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Drive"&gt;</div>
<div>                    &lt;i class="material-symbols-outlined fs-20 text-body hover"&gt;add_to_drive&lt;/i&gt;</div>
<div>                &lt;/button&gt;</div>
<div>                &lt;button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pen"&gt;</div>
<div>                    &lt;i class="material-symbols-outlined fs-20 text-body hover"&gt;ink_pen&lt;/i&gt;</div>
<div>                &lt;/button&gt;</div>
<div>                &lt;div class="dropdown action-opt ms-3 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option"&gt;</div>
<div>                    &lt;button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false"&gt;</div>
<div>                        &lt;i class="material-symbols-outlined fs-20 text-body hover"&gt;more_vert&lt;/i&gt;</div>
<div>                    &lt;/button&gt;</div>
<div>                    &lt;ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow"&gt;</div>
<div>                        &lt;li&gt;</div>
<div>                            &lt;a class="dropdown-item" href="javascript:void(0);"&gt;</div>
<div>                                &lt;i data-feather="eye"&gt;&lt;/i&gt;</div>
<div>                                View All</div>
<div>                            &lt;/a&gt;</div>
<div>                        &lt;/li&gt;</div>
<div>                        &lt;li&gt;</div>
<div>                            &lt;a class="dropdown-item" href="javascript:void(0);"&gt;</div>
<div>                                &lt;i data-feather="trash-2"&gt;&lt;/i&gt;</div>
<div>                                Delete One</div>
<div>                            &lt;/a&gt;</div>
<div>                        &lt;/li&gt;</div>
<div>                        &lt;li&gt;</div>
<div>                            &lt;a class="dropdown-item" href="javascript:void(0);"&gt;</div>
<div>                                &lt;i data-feather="lock"&gt;&lt;/i&gt;</div>
<div>                                Block</div>
<div>                            &lt;/a&gt;</div>
<div>                        &lt;/li&gt;</div>
<div>                    &lt;/ul&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/form&gt;</div>
</div>
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
