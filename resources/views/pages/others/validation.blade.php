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
                        <h3 class="mb-0">Validation</h3>

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
                                    <span class="fw-medium">Validation</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Validation Form</h4>
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
                                            <form class="row g-3 needs-validation" novalidate>
                                                <div class="col-md-6">
                                                    <label for="validationCustom01" class="form-label label text-secondary">First name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control h-55 ps-5" id="validationCustom01" value="Mark" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <i class="ri-user-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="validationCustom02" class="form-label label text-secondary">Last name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control h-55 ps-5" id="validationCustom02" value="Otto" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <i class="ri-user-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="validationCustom03" class="form-label label text-secondary">Email Address</label>
                                                    <div class="position-relative">
                                                        <input type="email" class="form-control h-55 ps-5" id="validationCustom03" value="trezo@gmail.com" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <i class="ri-mail-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="validationCustom04" class="form-label label text-secondary">Phone</label>
                                                    <div class="position-relative">
                                                        <input type="number" class="form-control h-55 ps-5 text-dark" id="validationCustom04" value="+02071234567" placeholder="020 7123 4567" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <i class="ri-phone-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="validationCustom05" class="form-label label text-secondary">Address</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control h-55 ps-5" id="validationCustom05" placeholder="Your location" required>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid Address.
                                                        </div>
                                                        <i class="ri-map-pin-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="validationCustom06" class="form-label label text-secondary">Town/City</label>
                                                    <div class="position-relative">
                                                        <select class="form-select form-control h-55 ps-5" id="validationCustom06" required>
                                                            <option selected disabled value="">Choose...</option>
                                                            <option>California</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select a valid Town/City.
                                                        </div>
                                                        <i class="ri-building-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="validationCustom07" class="form-label label text-secondary">State</label>
                                                    <div class="position-relative">
                                                        <select class="form-select form-control h-55 ps-5" id="validationCustom07" required>
                                                            <option selected disabled value="">South poal evenue state 4C</option>
                                                            <option>Trezo</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select a valid State.
                                                        </div>
                                                        <i class="ri-building-4-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="validationCustom08" class="form-label label text-secondary">Zip Code</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control h-55 ps-5" id="validationCustom08" required>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid zip.
                                                        </div>
                                                        <i class="ri-inbox-unarchive-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="validationCustom09" class="form-label label text-secondary">Order Notes :</label>
                                                    <div class="position-relative">
                                                        <textarea cols="30" rows="5" class="form-control ps-5 py-3" id="validationCustom09" placeholder="Notes" required></textarea>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid Notes.
                                                        </div>
                                                        <i class="ri-sticky-note-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                                        <label class="form-check-label" for="invalidCheck">
                                                            Agree to terms and conditions
                                                        </label>
                                                        <div class="invalid-feedback">
                                                            You must agree before submitting.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-primary fw-semibold text-white py-2 px-3" type="submit">Submit Form</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
<div>&lt;form class="row g-3 needs-validation" novalidate&gt;</div>
<div>    &lt;div class="col-md-6"&gt;</div>
<div>        &lt;label for="validationCustom01" class="form-label label text-secondary"&gt;First name&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="text" class="form-control h-55 ps-5" id="validationCustom01" value="Mark" required&gt;</div>
<div>            &lt;div class="valid-feedback"&gt;</div>
<div>                Looks good!</div>
<div>            &lt;/div&gt;</div>
<div>            &lt;i class="ri-user-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"&gt;&lt;/i&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-6"&gt;</div>
<div>        &lt;label for="validationCustom02" class="form-label label text-secondary"&gt;Last name&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="text" class="form-control h-55 ps-5" id="validationCustom02" value="Otto" required&gt;</div>
<div>            &lt;div class="valid-feedback"&gt;</div>
<div>                Looks good!</div>
<div>            &lt;/div&gt;</div>
<div>            &lt;i class="ri-user-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"&gt;&lt;/i&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-6"&gt;</div>
<div>        &lt;label for="validationCustom03" class="form-label label text-secondary"&gt;Email Address&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="email" class="form-control h-55 ps-5" id="validationCustom03" value="trezo@gmail.com" required&gt;</div>
<div>            &lt;div class="valid-feedback"&gt;</div>
<div>                Looks good!</div>
<div>            &lt;/div&gt;</div>
<div>            &lt;i class="ri-mail-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"&gt;&lt;/i&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-6"&gt;</div>
<div>        &lt;label for="validationCustom04" class="form-label label text-secondary"&gt;Phone&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="number" class="form-control h-55 ps-5 text-dark" id="validationCustom04" value="+02071234567" placeholder="020 7123 4567" required&gt;</div>
<div>            &lt;div class="valid-feedback"&gt;</div>
<div>                Looks good!</div>
<div>            &lt;/div&gt;</div>
<div>            &lt;i class="ri-phone-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"&gt;&lt;/i&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-12"&gt;</div>
<div>        &lt;label for="validationCustom05" class="form-label label text-secondary"&gt;Address&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="text" class="form-control h-55 ps-5" id="validationCustom05" placeholder="Your location" required&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                Please provide a valid Address.</div>
<div>            &lt;/div&gt;</div>
<div>            &lt;i class="ri-map-pin-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"&gt;&lt;/i&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-4"&gt;</div>
<div>        &lt;label for="validationCustom06" class="form-label label text-secondary"&gt;Town/City&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;select class="form-select form-control h-55 ps-5" id="validationCustom06" required&gt;</div>
<div>                &lt;option selected disabled value=""&gt;Choose...&lt;/option&gt;</div>
<div>                &lt;option&gt;California&lt;/option&gt;</div>
<div>            &lt;/select&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                Please select a valid Town/City.</div>
<div>            &lt;/div&gt;</div>
<div>            &lt;i class="ri-building-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"&gt;&lt;/i&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-4"&gt;</div>
<div>        &lt;label for="validationCustom07" class="form-label label text-secondary"&gt;State&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;select class="form-select form-control h-55 ps-5" id="validationCustom07" required&gt;</div>
<div>                &lt;option selected disabled value=""&gt;South poal evenue state 4C&lt;/option&gt;</div>
<div>                &lt;option&gt;Trezo&lt;/option&gt;</div>
<div>            &lt;/select&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                Please select a valid State.</div>
<div>            &lt;/div&gt;</div>
<div>            &lt;i class="ri-building-4-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"&gt;&lt;/i&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-4"&gt;</div>
<div>        &lt;label for="validationCustom08" class="form-label label text-secondary"&gt;Zip Code&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="text" class="form-control h-55 ps-5" id="validationCustom08" required&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                Please provide a valid zip.</div>
<div>            &lt;/div&gt;</div>
<div>            &lt;i class="ri-inbox-unarchive-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"&gt;&lt;/i&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-12"&gt;</div>
<div>        &lt;label for="validationCustom09" class="form-label label text-secondary"&gt;Order Notes :&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;textarea cols="30" rows="5" class="form-control ps-5 py-3" id="validationCustom09" placeholder="Notes" required&gt;&lt;/textarea&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                Please provide a valid Notes.</div>
<div>            &lt;/div&gt;</div>
<div>            &lt;i class="ri-sticky-note-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20" style="top: 13px !important;"&gt;&lt;/i&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-12"&gt;</div>
<div>        &lt;div class="form-check"&gt;</div>
<div>            &lt;input class="form-check-input" type="checkbox" value="" id="invalidCheck" required&gt;</div>
<div>            &lt;label class="form-check-label" for="invalidCheck"&gt;</div>
<div>                Agree to terms and conditions</div>
<div>            &lt;/label&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                You must agree before submitting.</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-12"&gt;</div>
<div>        &lt;button class="btn btn-primary fw-semibold text-white py-2 px-3" type="submit"&gt;Submit Form&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/form&gt;</div>
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
                                    <h4 class="fs-18 mb-4">Validation Schema With On Change</h4>
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
                                            <form class="row g-3 needs-validation" novalidate>
                                                <div class="col-md-6">
                                                    <label for="validationCustom10" class="form-label label text-secondary">First name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control h-55" id="validationCustom10" value="Mark" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="validationCustom11" class="form-label label text-secondary">Last name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control h-55" id="validationCustom11" value="Otto" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="validationCustom12" class="form-label label text-secondary">Email Address</label>
                                                    <div class="position-relative">
                                                        <input type="email" class="form-control h-55" id="validationCustom12" value="trezo@gmail.com" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="validationCustom13" class="form-label label text-secondary">Phone</label>
                                                    <div class="position-relative">
                                                        <input type="number" class="form-control h-55 text-dark" id="validationCustom13" value="+02071234567" placeholder="020 7123 4567" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="validationCustom14" class="form-label label text-secondary">Address</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control h-55" id="validationCustom14" placeholder="Your location" required>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid Address.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="validationCustom15" class="form-label label text-secondary">Town/City</label>
                                                    <div class="position-relative">
                                                        <select class="form-select form-control h-55" id="validationCustom15" required>
                                                            <option selected disabled value="">Choose...</option>
                                                            <option>California</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select a valid Town/City.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="validationCustom16" class="form-label label text-secondary">State</label>
                                                    <div class="position-relative">
                                                        <select class="form-select form-control h-55" id="validationCustom16" required>
                                                            <option selected disabled value="">South poal evenue state 4C</option>
                                                            <option>Trezo</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select a valid State.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="validationCustom17" class="form-label label text-secondary">Zip Code</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control h-55" id="validationCustom17" required>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid zip.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="validationCustom18" class="form-label label text-secondary">Order Notes :</label>
                                                    <div class="position-relative">
                                                        <textarea cols="30" rows="5" class="form-control py-3" id="validationCustom18" placeholder="Notes" required></textarea>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid Notes.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                                                        <label class="form-check-label" for="invalidCheck2">
                                                            Agree to terms and conditions
                                                        </label>
                                                        <div class="invalid-feedback">
                                                            You must agree before submitting.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-primary fw-semibold text-white py-2 px-3" type="submit">Submit Form</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
<div>&lt;form class="row g-3 needs-validation" novalidate&gt;</div>
<div>    &lt;div class="col-md-6"&gt;</div>
<div>        &lt;label for="validationCustom10" class="form-label label text-secondary"&gt;First name&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="text" class="form-control h-55" id="validationCustom10" value="Mark" required&gt;</div>
<div>            &lt;div class="valid-feedback"&gt;</div>
<div>                Looks good!</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-6"&gt;</div>
<div>        &lt;label for="validationCustom11" class="form-label label text-secondary"&gt;Last name&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="text" class="form-control h-55" id="validationCustom11" value="Otto" required&gt;</div>
<div>            &lt;div class="valid-feedback"&gt;</div>
<div>                Looks good!</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-6"&gt;</div>
<div>        &lt;label for="validationCustom12" class="form-label label text-secondary"&gt;Email Address&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="email" class="form-control h-55" id="validationCustom12" value="trezo@gmail.com" required&gt;</div>
<div>            &lt;div class="valid-feedback"&gt;</div>
<div>                Looks good!</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-6"&gt;</div>
<div>        &lt;label for="validationCustom13" class="form-label label text-secondary"&gt;Phone&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="number" class="form-control h-55 text-dark" id="validationCustom13" value="+02071234567" placeholder="020 7123 4567" required&gt;</div>
<div>            &lt;div class="valid-feedback"&gt;</div>
<div>                Looks good!</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-12"&gt;</div>
<div>        &lt;label for="validationCustom14" class="form-label label text-secondary"&gt;Address&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="text" class="form-control h-55" id="validationCustom14" placeholder="Your location" required&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                Please provide a valid Address.</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-4"&gt;</div>
<div>        &lt;label for="validationCustom15" class="form-label label text-secondary"&gt;Town/City&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;select class="form-select form-control h-55" id="validationCustom15" required&gt;</div>
<div>                &lt;option selected disabled value=""&gt;Choose...&lt;/option&gt;</div>
<div>                &lt;option&gt;California&lt;/option&gt;</div>
<div>            &lt;/select&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                Please select a valid Town/City.</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-4"&gt;</div>
<div>        &lt;label for="validationCustom16" class="form-label label text-secondary"&gt;State&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;select class="form-select form-control h-55" id="validationCustom16" required&gt;</div>
<div>                &lt;option selected disabled value=""&gt;South poal evenue state 4C&lt;/option&gt;</div>
<div>                &lt;option&gt;Trezo&lt;/option&gt;</div>
<div>            &lt;/select&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                Please select a valid State.</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-4"&gt;</div>
<div>        &lt;label for="validationCustom17" class="form-label label text-secondary"&gt;Zip Code&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;input type="text" class="form-control h-55" id="validationCustom17" required&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                Please provide a valid zip.</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-md-12"&gt;</div>
<div>        &lt;label for="validationCustom18" class="form-label label text-secondary"&gt;Order Notes :&lt;/label&gt;</div>
<div>        &lt;div class="position-relative"&gt;</div>
<div>            &lt;textarea cols="30" rows="5" class="form-control py-3" id="validationCustom18" placeholder="Notes" required&gt;&lt;/textarea&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                Please provide a valid Notes.</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-12"&gt;</div>
<div>        &lt;div class="form-check"&gt;</div>
<div>            &lt;input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required&gt;</div>
<div>            &lt;label class="form-check-label" for="invalidCheck2"&gt;</div>
<div>                Agree to terms and conditions</div>
<div>            &lt;/label&gt;</div>
<div>            &lt;div class="invalid-feedback"&gt;</div>
<div>                You must agree before submitting.</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-12"&gt;</div>
<div>        &lt;button class="btn btn-primary fw-semibold text-white py-2 px-3" type="submit"&gt;Submit Form&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/form&gt;</div>
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
