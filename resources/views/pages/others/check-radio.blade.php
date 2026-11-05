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
                        <h3 class="mb-0">Check & Radio</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Extra Pages</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Check & Radio</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Default Checks</h4>
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
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Default checkbox
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Checked checkbox
                                                </label>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;div class="form-check mb-3"&gt;
	&lt;input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"&gt;
	&lt;label class="form-check-label" for="flexCheckDefault"&gt;
		Default checkbox
	&lt;/label&gt;
&lt;/div&gt;
&lt;div class="form-check"&gt;
	&lt;input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked&gt;
	&lt;label class="form-check-label" for="flexCheckChecked"&gt;
		Checked checkbox
	&lt;/label&gt;
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
                                    <h4 class="fs-18 mb-4">Disabled Check</h4>
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
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminateDisabled" disabled>
                                                <label class="form-check-label" for="flexCheckIndeterminateDisabled">
                                                    Disabled indeterminate checkbox
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" disabled>
                                                <label class="form-check-label" for="flexCheckDisabled">
                                                    Disabled checkbox
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" checked disabled>
                                                <label class="form-check-label" for="flexCheckCheckedDisabled">
                                                    Disabled checked checkbox
                                                </label>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
&lt;div class="form-check mb-3"&gt;
	&lt;input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminateDisabled" disabled&gt;
	&lt;label class="form-check-label" for="flexCheckIndeterminateDisabled"&gt;
		Disabled indeterminate checkbox
	&lt;/label&gt;
&lt;/div&gt;
&lt;div class="form-check mb-3"&gt;
	&lt;input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" disabled&gt;
	&lt;label class="form-check-label" for="flexCheckDisabled"&gt;
		Disabled checkbox
	&lt;/label&gt;
&lt;/div&gt;
&lt;div class="form-check"&gt;
	&lt;input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" checked disabled&gt;
	&lt;label class="form-check-label" for="flexCheckCheckedDisabled"&gt;
		Disabled checked checkbox
	&lt;/label&gt;
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
                                    <h4 class="fs-18 mb-4">Default Radios</h4>
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
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Default radio
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Default checked radio
                                                </label>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
&lt;div class="form-check mb-3"&gt;
	&lt;input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1"&gt;
	&lt;label class="form-check-label" for="flexRadioDefault1"&gt;
		Default radio
	&lt;/label&gt;
&lt;/div&gt;
&lt;div class="form-check"&gt;
	&lt;input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked&gt;
	&lt;label class="form-check-label" for="flexRadioDefault2"&gt;
		Default checked radio
	&lt;/label&gt;
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
                                    <h4 class="fs-18 mb-4">Disabled Radios</h4>
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
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioDisabled" disabled>
                                                <label class="form-check-label" for="flexRadioDisabled">
                                                    Disabled radio
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioCheckedDisabled" checked disabled>
                                                <label class="form-check-label" for="flexRadioCheckedDisabled">
                                                    Disabled checked radio
                                                </label>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
&lt;div class="form-check"&gt;
	&lt;input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioDisabled" disabled&gt;
	&lt;label class="form-check-label" for="flexRadioDisabled"&gt;
		Disabled radio
	&lt;/label&gt;
&lt;/div&gt;
&lt;div class="form-check"&gt;
	&lt;input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioCheckedDisabled" checked disabled&gt;
	&lt;label class="form-check-label" for="flexRadioCheckedDisabled"&gt;
		Disabled checked radio
	&lt;/label&gt;
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
                                    <h4 class="fs-18 mb-4">Switches  Buttons</h4>
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
                                            <input type="checkbox" class="btn-check" id="btn-check" autocomplete="off">
                                            <label class="btn btn-primary" for="btn-check">Single toggle</label>

                                            <input type="checkbox" class="btn-check" id="btn-check-2" checked autocomplete="off">
                                            <label class="btn btn-primary" for="btn-check-2">Checked</label>

                                            <input type="checkbox" class="btn-check" id="btn-check-3" autocomplete="off" disabled>
                                            <label class="btn btn-primary" for="btn-check-3">Disabled</label>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode5">
&lt;input type="checkbox" class="btn-check" id="btn-check" autocomplete="off"&gt;
&lt;label class="btn btn-primary" for="btn-check"&gt;Single toggle&lt;/label&gt;

&lt;input type="checkbox" class="btn-check" id="btn-check-2" checked autocomplete="off"&gt;
&lt;label class="btn btn-primary" for="btn-check-2"&gt;Checked&lt;/label&gt;

&lt;input type="checkbox" class="btn-check" id="btn-check-3" autocomplete="off" disabled&gt;
&lt;label class="btn btn-primary" for="btn-check-3"&gt;Disabled&lt;/label&gt;
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
                                            <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked>
                                            <label class="btn btn-secondary" for="option1">Checked</label>

                                            <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
                                            <label class="btn btn-secondary" for="option2">Radio</label>

                                            <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off" disabled>
                                            <label class="btn btn-secondary" for="option3">Disabled</label>

                                            <input type="radio" class="btn-check" name="options" id="option4" autocomplete="off">
                                            <label class="btn btn-secondary" for="option4">Radio</label>
                                        </div>
                                        <div class="tab-pane fade" id="code6-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode6">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode6">
&lt;input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked&gt;
&lt;label class="btn btn-secondary" for="option1"&gt;Checked&lt;/label&gt;

&lt;input type="radio" class="btn-check" name="options" id="option2" autocomplete="off"&gt;
&lt;label class="btn btn-secondary" for="option2"&gt;Radio&lt;/label&gt;

&lt;input type="radio" class="btn-check" name="options" id="option3" autocomplete="off" disabled&gt;
&lt;label class="btn btn-secondary" for="option3"&gt;Disabled&lt;/label&gt;

&lt;input type="radio" class="btn-check" name="options" id="option4" autocomplete="off"&gt;
&lt;label class="btn btn-secondary" for="option4"&gt;Radio&lt;/label&gt;
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
                                            <div class="d-flex flex-wrap gap-2">
                                                <div>
                                                    <input type="checkbox" class="btn-check" id="btn-check-outlined" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btn-check-outlined">Single toggle</label>
                                                </div>

                                                <div>
                                                    <input type="checkbox" class="btn-check" id="btn-check-2-outlined" checked autocomplete="off">
                                                    <label class="btn btn-outline-secondary" for="btn-check-2-outlined">Checked</label>
                                                </div>

                                                <div>
                                                    <input type="radio" class="btn-check" name="options-outlined" id="success-outlined" autocomplete="off" checked>
                                                    <label class="btn btn-outline-success" for="success-outlined">Checked success radio</label>
                                                </div>

                                                <div>
                                                    <input type="radio" class="btn-check" name="options-outlined" id="danger-outlined" autocomplete="off">
                                                    <label class="btn btn-outline-danger" for="danger-outlined">Danger radio</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code7-tab-pane" role="tabpanel" aria-labelledby="code7-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode7">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode7">
&lt;input type="checkbox" class="btn-check" id="btn-check-outlined" autocomplete="off"&gt;
&lt;label class="btn btn-outline-primary" for="btn-check-outlined"&gt;Single toggle&lt;/label&gt;&lt;br&gt;

&lt;input type="checkbox" class="btn-check" id="btn-check-2-outlined" checked autocomplete="off"&gt;
&lt;label class="btn btn-outline-secondary" for="btn-check-2-outlined"&gt;Checked&lt;/label&gt;&lt;br&gt;

&lt;input type="radio" class="btn-check" name="options-outlined" id="success-outlined" autocomplete="off" checked&gt;
&lt;label class="btn btn-outline-success" for="success-outlined"&gt;Checked success radio&lt;/label&gt;

&lt;input type="radio" class="btn-check" name="options-outlined" id="danger-outlined" autocomplete="off"&gt;
&lt;label class="btn btn-outline-danger" for="danger-outlined"&gt;Danger radio&lt;/label&gt;
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
