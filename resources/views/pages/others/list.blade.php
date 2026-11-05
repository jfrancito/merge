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
                        <h3 class="mb-0">List</h3>

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
                                    <span class="fw-medium">List</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Basic List</h4>
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
                                            <ul class="list-group">
                                                <li class="list-group-item bg-white">An item</li>
                                                <li class="list-group-item bg-white">A second item</li>
                                                <li class="list-group-item bg-white">A third item</li>
                                                <li class="list-group-item bg-white">A fourth item</li>
                                                <li class="list-group-item bg-white">And a fifth one</li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;ul class="list-group"&gt;
    &lt;li class="list-group-item bg-white"&gt;An item&lt;/li&gt;
    &lt;li class="list-group-item bg-white"&gt;A second item&lt;/li&gt;
    &lt;li class="list-group-item bg-white"&gt;A third item&lt;/li&gt;
    &lt;li class="list-group-item bg-white"&gt;A fourth item&lt;/li&gt;
    &lt;li class="list-group-item bg-white"&gt;And a fifth one&lt;/li&gt;
&lt;/ul&gt;
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
                                    <h4 class="fs-18 mb-4">Active List</h4>
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
                                            <ul class="list-group">
                                                <li class="list-group-item active" aria-current="true">An active item</li>
                                                <li class="list-group-item bg-white">A second item</li>
                                                <li class="list-group-item bg-white">A third item</li>
                                                <li class="list-group-item bg-white">A fourth item</li>
                                                <li class="list-group-item bg-white">And a fifth one</li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
&lt;ul class="list-group"&gt;
    &lt;li class="list-group-item active" aria-current="true"&gt;An active item&lt;/li&gt;
    &lt;li class="list-group-item bg-white"&gt;A second item&lt;/li&gt;
    &lt;li class="list-group-item bg-white"&gt;A third item&lt;/li&gt;
    &lt;li class="list-group-item bg-white"&gt;A fourth item&lt;/li&gt;
    &lt;li class="list-group-item bg-white"&gt;And a fifth one&lt;/li&gt;
&lt;/ul&gt;
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
                                    <h4 class="fs-18 mb-4">Numbered List</h4>
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
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item bg-white d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Subheading</div>
                                                        Content for list item
                                                    </div>
                                                    <span class="badge bg-primary rounded-pill">14</span>
                                                </li>
                                                <li class="list-group-item bg-white d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Subheading</div>
                                                        Content for list item
                                                    </div>
                                                    <span class="badge bg-primary rounded-pill">14</span>
                                                </li>
                                                <li class="list-group-item bg-white d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Subheading</div>
                                                        Content for list item
                                                    </div>
                                                    <span class="badge bg-primary rounded-pill">14</span>
                                                </li>
                                            </ol>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
&lt;ol class="list-group list-group-numbered"&gt;
    &lt;li class="list-group-item bg-white d-flex justify-content-between align-items-start"&gt;
        &lt;div class="ms-2 me-auto"&gt;
            &lt;div class="fw-bold"&gt;Subheading&lt;/div&gt;
                Content for list item
        &lt;/div&gt;
        &lt;span class="badge bg-primary rounded-pill"&gt;14&lt;/span&gt;
    &lt;/li&gt;
    &lt;li class="list-group-item bg-white d-flex justify-content-between align-items-start"&gt;
        &lt;div class="ms-2 me-auto"&gt;
            &lt;div class="fw-bold"&gt;Subheading&lt;/div&gt;
                Content for list item
            &lt;/div&gt;
        &lt;span class="badge bg-primary rounded-pill"&gt;14&lt;/span&gt;
    &lt;/li&gt;
    &lt;li class="list-group-item bg-white d-flex justify-content-between align-items-start"&gt;
        &lt;div class="ms-2 me-auto"&gt;
            &lt;div class="fw-bold"&gt;Subheading&lt;/div&gt;
            Content for list item
        &lt;/div&gt;
        &lt;span class="badge bg-primary rounded-pill"&gt;14&lt;/span&gt;
    &lt;/li&gt;
&lt;/ol&gt;
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
                                    <h4 class="fs-18 mb-4">Variants List</h4>
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
                                            <ul class="list-group">
                                                <li class="list-group-item">A simple default list group item</li>
                                                <li class="list-group-item list-group-item-primary">A simple primary list group item</li>
                                                <li class="list-group-item list-group-item-secondary">A simple secondary list group item</li>
                                                <li class="list-group-item list-group-item-success">A simple success list group item</li>
                                                <li class="list-group-item list-group-item-danger">A simple danger list group item</li>
                                                <li class="list-group-item list-group-item-warning">A simple warning list group item</li>
                                                <li class="list-group-item list-group-item-info">A simple info list group item</li>
                                                <li class="list-group-item list-group-item-light">A simple light list group item</li>
                                                <li class="list-group-item list-group-item-dark">A simple dark list group item</li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
&lt;ul class="list-group"&gt;
    &lt;li class="list-group-item"&gt;A simple default list group item&lt;/li&gt;
    &lt;li class="list-group-item list-group-item-primary"&gt;A simple primary list group item&lt;/li&gt;
    &lt;li class="list-group-item list-group-item-secondary"&gt;A simple secondary list group item&lt;/li&gt;
    &lt;li class="list-group-item list-group-item-success"&gt;A simple success list group item&lt;/li&gt;
    &lt;li class="list-group-item list-group-item-danger"&gt;A simple danger list group item&lt;/li&gt;
    &lt;li class="list-group-item list-group-item-warning"&gt;A simple warning list group item&lt;/li&gt;
    &lt;li class="list-group-item list-group-item-info"&gt;A simple info list group item&lt;/li&gt;
    &lt;li class="list-group-item list-group-item-light"&gt;A simple light list group item&lt;/li&gt;
    &lt;li class="list-group-item list-group-item-dark"&gt;A simple dark list group item&lt;/li&gt;
&lt;/ul&gt;
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
                                    <h4 class="fs-18 mb-4">Custom content</h4>
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
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">List group item heading</h5>
                                                    <small>3 days ago</small>
                                                </div>
                                                <p class="mb-1">Some placeholder content in a paragraph.</p>
                                                <small>And some small print.</small>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">List group item heading</h5>
                                                <small class="text-body-secondary">3 days ago</small>
                                                </div>
                                                <p class="mb-1">Some placeholder content in a paragraph.</p>
                                                <small class="text-body-secondary">And some muted small print.</small>
                                            </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">List group item heading</h5>
                                                    <small class="text-body-secondary">3 days ago</small>
                                                </div>
                                                <p class="mb-1">Some placeholder content in a paragraph.</p>
                                                    <small class="text-body-secondary">And some muted small print.</small>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode5">
&lt;div class="list-group"&gt;
    &lt;a href="#" class="list-group-item list-group-item-action active" aria-current="true"&gt;
        &lt;div class="d-flex w-100 justify-content-between"&gt;
            &lt;h5 class="mb-1"&gt;List group item heading&lt;/h5&gt;
            &lt;small&gt;3 days ago&lt;/small&gt;
        &lt;/div&gt;
        &lt;p class="mb-1"&gt;Some placeholder content in a paragraph.&lt;/p&gt;
        &lt;small&gt;And some small print.&lt;/small&gt;
    &lt;/a&gt;
    &lt;a href="#" class="list-group-item list-group-item-action"&gt;
        &lt;div class="d-flex w-100 justify-content-between"&gt;
            &lt;h5 class="mb-1"&gt;List group item heading&lt;/h5&gt;
            &lt;small class="text-body-secondary"&gt;3 days ago&lt;/small&gt;
        &lt;/div&gt;
        &lt;p class="mb-1"&gt;Some placeholder content in a paragraph.&lt;/p&gt;
        &lt;small class="text-body-secondary"&gt;And some muted small print.&lt;/small&gt;
    &lt;/a&gt;
    &lt;a href="#" class="list-group-item list-group-item-action"&gt;
        &lt;div class="d-flex w-100 justify-content-between"&gt;
            &lt;h5 class="mb-1"&gt;List group item heading&lt;/h5&gt;
            &lt;small class="text-body-secondary"&gt;3 days ago&lt;/small&gt;
        &lt;/div&gt;
        &lt;p class="mb-1"&gt;Some placeholder content in a paragraph.&lt;/p&gt;
        &lt;small class="text-body-secondary"&gt;And some muted small print.&lt;/small&gt;
    &lt;/a&gt;
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
                                    <h4 class="fs-18 mb-4">Checkboxes and radios List</h4>
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
                                            <ul class="list-group">
                                                <li class="list-group-item bg-white">
                                                    <input class="form-check-input me-1" type="checkbox" value="" id="firstCheckbox">
                                                    <label class="form-check-label" for="firstCheckbox">First checkbox</label>
                                                </li>
                                                <li class="list-group-item bg-white">
                                                    <input class="form-check-input me-1" type="checkbox" value="" id="secondCheckbox">
                                                    <label class="form-check-label" for="secondCheckbox">Second checkbox</label>
                                                </li>
                                                <li class="list-group-item bg-white">
                                                    <input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckbox">
                                                    <label class="form-check-label" for="thirdCheckbox">Third checkbox</label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="code6-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode6">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode6">
&lt;ul class="list-group"&gt;
    &lt;li class="list-group-item bg-white"&gt;
        &lt;input class="form-check-input me-1" type="checkbox" value="" id="firstCheckbox"&gt;
        &lt;label class="form-check-label" for="firstCheckbox"&gt;First checkbox&lt;/label&gt;
    &lt;/li&gt;
    &lt;li class="list-group-item bg-white"&gt;
        &lt;input class="form-check-input me-1" type="checkbox" value="" id="secondCheckbox"&gt;
        &lt;label class="form-check-label" for="secondCheckbox"&gt;Second checkbox&lt;/label&gt;
    &lt;/li&gt;
    &lt;li class="list-group-item bg-white"&gt;
        &lt;input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckbox"&gt;
        &lt;label class="form-check-label" for="thirdCheckbox"&gt;Third checkbox&lt;/label&gt;
    &lt;/li&gt;
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
