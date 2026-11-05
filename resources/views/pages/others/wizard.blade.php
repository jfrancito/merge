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
                        <h3 class="mb-0">Wizard</h3>

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
                                    <span class="fw-medium">Wizard</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Wizard Form</h4>
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
                                            <ul class="nav nav-tabs justify-content-between border-0 mb-4 wizard-tabs" id="myTabstep" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link wh-48 bg-primary bg-opacity-10 rounded-circle p-0 active" id="step1-tab" data-bs-toggle="tab" data-bs-target="#step1-tab-pane" type="button" role="tab" aria-controls="step1-tab-pane" aria-selected="true">
                                                        <span class="fs-20 fw-bold text-primary">1</span>
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link wh-48 bg-primary bg-opacity-10 rounded-circle p-0" id="step2-tab" data-bs-toggle="tab" data-bs-target="#step2-tab-pane" type="button" role="tab" aria-controls="step2-tab-pane" aria-selected="false">
                                                        <span class="fs-20 fw-bold text-primary">2</span>
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link wh-48 bg-primary bg-opacity-10 rounded-circle p-0" id="step3-tab" data-bs-toggle="tab" data-bs-target="#step3-tab-pane" type="button" role="tab" aria-controls="step3-tab-pane" aria-selected="false">
                                                        <span class="fs-20 fw-bold text-primary">3</span>
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link wh-48 bg-primary bg-opacity-10 rounded-circle p-0" id="step4-tab" data-bs-toggle="tab" data-bs-target="#step4-tab-pane" type="button" role="tab" aria-controls="step4-tab-pane" aria-selected="false">
                                                        <span class="fs-20 fw-bold text-primary">4</span>
                                                    </button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabstepContent">
                                                <div class="tab-pane fade show active" id="step1-tab-pane" role="tabpanel" aria-labelledby="step1-tab" tabindex="0">
                                                    <h4 class="fs-18 fw-semibold">General Information</h4>
                                                    <p class="text-gray-light mb-4">Fill all Information as below</p>
    
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">First Name</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name">
                                                                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Last Name</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name">
                                                                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Email Address</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="email" class="form-control text-dark ps-5 h-55" placeholder="Enter Email Address">
                                                                        <i class="ri-mail-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Phone</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="number" class="form-control text-dark ps-5 h-55" placeholder="Enter Phone Number">
                                                                        <i class="ri-phone-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Address</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="number" class="form-control text-dark ps-5 h-55" placeholder="Your Location">
                                                                        <i class="ri-map-pin-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group d-flex gap-3">
                                                                    <button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0">Back</button>
                                                                    <button class="btn btn-primary py-3 px-5 fw-semibold text-white">Next</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="step2-tab-pane" role="tabpanel" aria-labelledby="step2-tab" tabindex="0">
                                                    <h4 class="fs-18 fw-semibold">Personal Information</h4>
                                                    <p class="text-gray-light mb-4">Fill all Information as below</p>
    
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Country</label>
                                                                    <div class="form-group position-relative">
                                                                        <select class="form-select form-control ps-5 h-55" aria-label="Default select example">
                                                                            <option selected class="text-dark">United Kingdom</option>
                                                                            <option value="1" class="text-dark">United States</option>
                                                                            <option value="2" class="text-dark">Canada</option>
                                                                            <option value="3" class="text-dark">France</option>
                                                                        </select>
                                                                        <i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Town/City</label>
                                                                    <div class="form-group position-relative">
                                                                        <select class="form-select form-control ps-5 h-55" aria-label="Default select example">
                                                                            <option selected class="text-dark">California</option>
                                                                            <option value="1" class="text-dark">United States</option>
                                                                            <option value="2" class="text-dark">Canada</option>
                                                                            <option value="3" class="text-dark">France</option>
                                                                        </select>
                                                                        <i class="ri-list-ordered position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">State</label>
                                                                    <div class="form-group position-relative">
                                                                        <select class="form-select form-control ps-5 h-55" aria-label="Default select example">
                                                                            <option selected class="text-dark">South poal evenue state 4C</option>
                                                                            <option value="1" class="text-dark">United States</option>
                                                                            <option value="2" class="text-dark">Canada</option>
                                                                            <option value="3" class="text-dark">France</option>
                                                                        </select>
                                                                        <i class="ri-font-size position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Zip Code</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="number" class="form-control ps-5 text-gray-light h-55" placeholder="Enter number">
                                                                        <i class="ri-hashtag position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Order Notes :</label>
                                                                    <div class="form-group position-relative">
                                                                        <textarea class="form-control ps-5 text-dark" placeholder="Some demo text ... " cols="30" rows="5"></textarea>
                                                                        <i class="ri-information-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20 pt-2"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group d-flex gap-3">
                                                                    <button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0">Back</button>
                                                                    <button class="btn btn-primary py-3 px-5 fw-semibold text-white">Next</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="step3-tab-pane" role="tabpanel" aria-labelledby="step3-tab" tabindex="0">
                                                    <h4 class="fs-18 fw-semibold">Social Information</h4>
                                                    <p class="text-gray-light mb-4">Fill all Information as below</p>
    
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Facebook</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="url" class="form-control text-dark ps-5 h-55" placeholder="URL">
                                                                        <i class="ri-facebook-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Twitter</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="url" class="form-control text-dark ps-5 h-55" placeholder="URL">
                                                                        <i class="ri-twitter-x-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Linkedin</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="url" class="form-control text-dark ps-5 h-55" placeholder="URL">
                                                                        <i class="ri-linkedin-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">YouTube</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="url" class="form-control text-dark ps-5 h-55" placeholder="URL">
                                                                        <i class="ri-youtube-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group d-flex gap-3">
                                                                    <button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0">Back</button>
                                                                    <button class="btn btn-primary py-3 px-5 fw-semibold text-white">Next</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="step4-tab-pane" role="tabpanel" aria-labelledby="step4-tab" tabindex="0">
                                                    <h4 class="fs-18 fw-semibold">Any Note</h4>
                                                    <p class="text-gray-light mb-4">Fill all Information as below</p>
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Order Notes :</label>
                                                                    <div class="form-group position-relative">
                                                                        <textarea class="form-control ps-5 text-dark" placeholder="Some demo text ... " cols="30" rows="5"></textarea>
                                                                        <i class="ri-information-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20 pt-2"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-primary py-3 px-5 fw-semibold text-white">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
<div>&lt;ul class="nav nav-tabs justify-content-between border-0 mb-4 wizard-tabs" id="myTabstep" role="tablist"&gt;</div>
<div>    &lt;li class="nav-item" role="presentation"&gt;</div>
<div>        &lt;button class="nav-link wh-48 bg-primary bg-opacity-10 rounded-circle p-0 active" id="step1-tab" data-bs-toggle="tab" data-bs-target="#step1-tab-pane" type="button" role="tab" aria-controls="step1-tab-pane" aria-selected="true"&gt;</div>
<div>            &lt;span class="fs-20 fw-bold text-primary"&gt;1&lt;/span&gt;</div>
<div>        &lt;/button&gt;</div>
<div>    &lt;/li&gt;</div>
<div>    &lt;li class="nav-item" role="presentation"&gt;</div>
<div>        &lt;button class="nav-link wh-48 bg-primary bg-opacity-10 rounded-circle p-0" id="step2-tab" data-bs-toggle="tab" data-bs-target="#step2-tab-pane" type="button" role="tab" aria-controls="step2-tab-pane" aria-selected="false"&gt;</div>
<div>            &lt;span class="fs-20 fw-bold text-primary"&gt;2&lt;/span&gt;</div>
<div>        &lt;/button&gt;</div>
<div>    &lt;/li&gt;</div>
<div>    &lt;li class="nav-item" role="presentation"&gt;</div>
<div>        &lt;button class="nav-link wh-48 bg-primary bg-opacity-10 rounded-circle p-0" id="step3-tab" data-bs-toggle="tab" data-bs-target="#step3-tab-pane" type="button" role="tab" aria-controls="step3-tab-pane" aria-selected="false"&gt;</div>
<div>            &lt;span class="fs-20 fw-bold text-primary"&gt;3&lt;/span&gt;</div>
<div>        &lt;/button&gt;</div>
<div>    &lt;/li&gt;</div>
<div>    &lt;li class="nav-item" role="presentation"&gt;</div>
<div>        &lt;button class="nav-link wh-48 bg-primary bg-opacity-10 rounded-circle p-0" id="step4-tab" data-bs-toggle="tab" data-bs-target="#step4-tab-pane" type="button" role="tab" aria-controls="step4-tab-pane" aria-selected="false"&gt;</div>
<div>            &lt;span class="fs-20 fw-bold text-primary"&gt;3&lt;/span&gt;</div>
<div>        &lt;/button&gt;</div>
<div>    &lt;/li&gt;</div>
<div>&lt;/ul&gt;</div>
<div>&lt;div class="tab-content" id="myTabstepContent"&gt;</div>
<div>    &lt;div class="tab-pane fade show active" id="step1-tab-pane" role="tabpanel" aria-labelledby="step1-tab" tabindex="0"&gt;</div>
<div>        &lt;h4 class="fs-18 fw-semibold"&gt;General Information&lt;/h4&gt;</div>
<div>        &lt;p class="text-gray-light mb-4"&gt;Fill all Information as below&lt;/p&gt;</div>
<div>        &lt;form&gt;</div>
<div>            &lt;div class="row"&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;First Name&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name"&gt;</div>
<div>                            &lt;i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Last Name&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name"&gt;</div>
<div>                            &lt;i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Email Address&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="email" class="form-control text-dark ps-5 h-55" placeholder="Enter Email Address"&gt;</div>
<div>                            &lt;i class="ri-mail-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Phone&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="number" class="form-control text-dark ps-5 h-55" placeholder="Enter Phone Number"&gt;</div>
<div>                            &lt;i class="ri-phone-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Address&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="number" class="form-control text-dark ps-5 h-55" placeholder="Your Location"&gt;</div>
<div>                            &lt;i class="ri-map-pin-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group d-flex gap-3"&gt;</div>
<div>                        &lt;button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0"&gt;Back&lt;/button&gt;</div>
<div>                        &lt;button class="btn btn-primary py-3 px-5 fw-semibold text-white"&gt;Next&lt;/button&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/form&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="tab-pane fade" id="step2-tab-pane" role="tabpanel" aria-labelledby="step2-tab" tabindex="0"&gt;</div>
<div>        &lt;h4 class="fs-18 fw-semibold"&gt;Personal Information&lt;/h4&gt;</div>
<div>        &lt;p class="text-gray-light mb-4"&gt;Fill all Information as below&lt;/p&gt;</div>
<div>        &lt;form&gt;</div>
<div>            &lt;div class="row"&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Country&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;select class="form-select form-control ps-5 h-55" aria-label="Default select example"&gt;</div>
<div>                                &lt;option selected class="text-dark"&gt;United Kingdom&lt;/option&gt;</div>
<div>                                &lt;option value="1" class="text-dark"&gt;United States&lt;/option&gt;</div>
<div>                                &lt;option value="2" class="text-dark"&gt;Canada&lt;/option&gt;</div>
<div>                                &lt;option value="3" class="text-dark"&gt;France&lt;/option&gt;</div>
<div>                            &lt;/select&gt;</div>
<div>                            &lt;i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-4"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Town/City&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;select class="form-select form-control ps-5 h-55" aria-label="Default select example"&gt;</div>
<div>                                &lt;option selected class="text-dark"&gt;California&lt;/option&gt;</div>
<div>                                &lt;option value="1" class="text-dark"&gt;United States&lt;/option&gt;</div>
<div>                                &lt;option value="2" class="text-dark"&gt;Canada&lt;/option&gt;</div>
<div>                                &lt;option value="3" class="text-dark"&gt;France&lt;/option&gt;</div>
<div>                            &lt;/select&gt;</div>
<div>                            &lt;i class="ri-list-ordered position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-4"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;State&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;select class="form-select form-control ps-5 h-55" aria-label="Default select example"&gt;</div>
<div>                                &lt;option selected class="text-dark"&gt;South poal evenue state 4C&lt;/option&gt;</div>
<div>                                &lt;option value="1" class="text-dark"&gt;United States&lt;/option&gt;</div>
<div>                                &lt;option value="2" class="text-dark"&gt;Canada&lt;/option&gt;</div>
<div>                                &lt;option value="3" class="text-dark"&gt;France&lt;/option&gt;</div>
<div>                            &lt;/select&gt;</div>
<div>                            &lt;i class="ri-font-size position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-4"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Zip Code&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="number" class="form-control ps-5 text-gray-light h-55" placeholder="Enter number"&gt;</div>
<div>                            &lt;i class="ri-hashtag position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Order Notes :&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;textarea class="form-control ps-5 text-dark" placeholder="Some demo text ... " cols="30" rows="5"&gt;&lt;/textarea&gt;</div>
<div>                            &lt;i class="ri-information-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20 pt-2"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group d-flex gap-3"&gt;</div>
<div>                        &lt;button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0"&gt;Back&lt;/button&gt;</div>
<div>                        &lt;button class="btn btn-primary py-3 px-5 fw-semibold text-white"&gt;Next&lt;/button&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/form&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="tab-pane fade" id="step3-tab-pane" role="tabpanel" aria-labelledby="step3-tab" tabindex="0"&gt;</div>
<div>        &lt;h4 class="fs-18 fw-semibold"&gt;Social Information&lt;/h4&gt;</div>
<div>        &lt;p class="text-gray-light mb-4"&gt;Fill all Information as below&lt;/p&gt;</div>
<div>        &lt;form&gt;</div>
<div>            &lt;div class="row"&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Facebook&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="text" class="form-control text-dark ps-5 h-55" placeholder="URL"&gt;</div>
<div>                            &lt;i class="ri-facebook-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Twitter&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="text" class="form-control text-dark ps-5 h-55" placeholder="URL"&gt;</div>
<div>                            &lt;i class="ri-twitter-x-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Linkedin&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="email" class="form-control text-dark ps-5 h-55" placeholder="URL"&gt;</div>
<div>                            &lt;i class="ri-linkedin-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;YouTube&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="number" class="form-control text-dark ps-5 h-55" placeholder="URL"&gt;</div>
<div>                            &lt;i class="ri-youtube-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group d-flex gap-3"&gt;</div>
<div>                        &lt;button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0"&gt;Back&lt;/button&gt;</div>
<div>                        &lt;button class="btn btn-primary py-3 px-5 fw-semibold text-white"&gt;Next&lt;/button&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/form&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="tab-pane fade" id="step4-tab-pane" role="tabpanel" aria-labelledby="step4-tab" tabindex="0"&gt;</div>
<div>        &lt;h4 class="fs-18 fw-semibold"&gt;Any Note&lt;/h4&gt;</div>
<div>        &lt;p class="text-gray-light mb-4"&gt;Fill all Information as below&lt;/p&gt;</div>
<div>        &lt;form&gt;</div>
<div>            &lt;div class="row"&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Order Notes :&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;textarea class="form-control ps-5 text-dark" placeholder="Some demo text ... " cols="30" rows="5"&gt;&lt;/textarea&gt;</div>
<div>                            &lt;i class="ri-information-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20 pt-2"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group"&gt;</div>
<div>                        &lt;button type="submit" class="btn btn-primary py-3 px-5 fw-semibold text-white"&gt;Submit&lt;/button&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/form&gt;</div>
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
                                            <ul class="nav nav-tabs justify-content-between border-0 mb-4 wizard-tabs2" id="myTabstep2" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link p-0 d-flex align-items-center active" id="step5-tab" data-bs-toggle="tab" data-bs-target="#step5-tab-pane" type="button" role="tab" aria-controls="step5-tab-pane" aria-selected="true">
                                                        <span class="fs-20 fw-bold text-primary wh-48 bg-primary bg-opacity-10 rounded-circle d-inline-block">1</span>
    
                                                        <div class="text-start ms-3 d-none d-lg-block">
                                                            <h4 class="fs-18 fw-semibold">General Information</h4>
                                                            <p class="text-gray-light mb-0">Fill all Information as below</p>
                                                        </div>
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link p-0 d-flex align-items-center" id="step6-tab" data-bs-toggle="tab" data-bs-target="#step6-tab-pane" type="button" role="tab" aria-controls="step6-tab-pane" aria-selected="false">
                                                        <span class="fs-20 fw-bold text-primary wh-48 bg-primary bg-opacity-10 rounded-circle d-inline-block">2</span>
    
                                                        <div class="text-start ms-3 d-none d-lg-block">
                                                            <h4 class="fs-18 fw-semibold">Personal Info</h4>
                                                            <p class="text-gray-light mb-0">Setup Information</p>
                                                        </div>
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link p-0 d-flex align-items-center" id="step7-tab" data-bs-toggle="tab" data-bs-target="#step7-tab-pane" type="button" role="tab" aria-controls="step7-tab-pane" aria-selected="false">
                                                        <span class="fs-20 fw-bold text-primary wh-48 bg-primary bg-opacity-10 rounded-circle d-inline-block">3</span>
    
                                                        <div class="text-start ms-3 d-none d-lg-block">
                                                            <h4 class="fs-18 fw-semibold">Social Links</h4>
                                                            <p class="text-gray-light mb-0">Add Social Links</p>
                                                        </div>
                                                    </button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabstep2Content">
                                                <div class="tab-pane fade show active" id="step5-tab-pane" role="tabpanel" aria-labelledby="step5-tab" tabindex="0">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">First Name</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name">
                                                                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Last Name</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name">
                                                                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Email Address</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="email" class="form-control text-dark ps-5 h-55" placeholder="Enter Email Address">
                                                                        <i class="ri-mail-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Phone</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="number" class="form-control text-dark ps-5 h-55" placeholder="Enter Phone Number">
                                                                        <i class="ri-phone-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Address</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="number" class="form-control text-dark ps-5 h-55" placeholder="Your Location">
                                                                        <i class="ri-map-pin-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group d-flex gap-3">
                                                                    <button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0">Back</button>
                                                                    <button class="btn btn-primary py-3 px-5 fw-semibold text-white">Next</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="step6-tab-pane" role="tabpanel" aria-labelledby="step6-tab" tabindex="0">
                                                    <h4 class="fs-18 fw-semibold">Personal Information</h4>
                                                    <p class="text-gray-light mb-4">Fill all Information as below</p>
    
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Country</label>
                                                                    <div class="form-group position-relative">
                                                                        <select class="form-select form-control ps-5 h-55" aria-label="Default select example">
                                                                            <option selected class="text-dark">United Kingdom</option>
                                                                            <option value="1" class="text-dark">United States</option>
                                                                            <option value="2" class="text-dark">Canada</option>
                                                                            <option value="3" class="text-dark">France</option>
                                                                        </select>
                                                                        <i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Town/City</label>
                                                                    <div class="form-group position-relative">
                                                                        <select class="form-select form-control ps-5 h-55" aria-label="Default select example">
                                                                            <option selected class="text-dark">California</option>
                                                                            <option value="1" class="text-dark">United States</option>
                                                                            <option value="2" class="text-dark">Canada</option>
                                                                            <option value="3" class="text-dark">France</option>
                                                                        </select>
                                                                        <i class="ri-list-ordered position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">State</label>
                                                                    <div class="form-group position-relative">
                                                                        <select class="form-select form-control ps-5 h-55" aria-label="Default select example">
                                                                            <option selected class="text-dark">South poal evenue state 4C</option>
                                                                            <option value="1" class="text-dark">United States</option>
                                                                            <option value="2" class="text-dark">Canada</option>
                                                                            <option value="3" class="text-dark">France</option>
                                                                        </select>
                                                                        <i class="ri-font-size position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Zip Code</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="number" class="form-control ps-5 text-gray-light h-55" placeholder="Enter number">
                                                                        <i class="ri-hashtag position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Order Notes :</label>
                                                                    <div class="form-group position-relative">
                                                                        <textarea class="form-control ps-5 text-dark" placeholder="Some demo text ... " cols="30" rows="5"></textarea>
                                                                        <i class="ri-information-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20 pt-2"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group d-flex gap-3">
                                                                    <button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0">Back</button>
                                                                    <button class="btn btn-primary py-3 px-5 fw-semibold text-white">Next</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="step7-tab-pane" role="tabpanel" aria-labelledby="step7-tab" tabindex="0">
                                                    <h4 class="fs-18 fw-semibold">Social Information</h4>
                                                    <p class="text-gray-light mb-4">Fill all Information as below</p>
    
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Facebook</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="text" class="form-control text-dark ps-5 h-55" placeholder="URL">
                                                                        <i class="ri-facebook-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Twitter</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="text" class="form-control text-dark ps-5 h-55" placeholder="URL">
                                                                        <i class="ri-twitter-x-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">Linkedin</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="email" class="form-control text-dark ps-5 h-55" placeholder="URL">
                                                                        <i class="ri-linkedin-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="label">YouTube</label>
                                                                    <div class="form-group position-relative">
                                                                        <input type="number" class="form-control text-dark ps-5 h-55" placeholder="URL">
                                                                        <i class="ri-youtube-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group d-flex gap-3">
                                                                    <button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0">Back</button>
                                                                    <button type="submit" class="btn btn-primary py-3 px-5 fw-semibold text-white">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
<div>&lt;ul class="nav nav-tabs justify-content-between border-0 mb-4 wizard-tabs2" id="myTabstep2" role="tablist"&gt;</div>
<div>    &lt;li class="nav-item" role="presentation"&gt;</div>
<div>        &lt;button class="nav-link p-0 d-flex align-items-center active" id="step5-tab" data-bs-toggle="tab" data-bs-target="#step5-tab-pane" type="button" role="tab" aria-controls="step5-tab-pane" aria-selected="true"&gt;</div>
<div>            &lt;span class="fs-20 fw-bold text-primary wh-48 bg-primary bg-opacity-10 rounded-circle d-inline-block"&gt;1&lt;/span&gt;</div>
<div>            &lt;div class="text-start ms-3"&gt;</div>
<div>                &lt;h4 class="fs-18 fw-semibold"&gt;General Information&lt;/h4&gt;</div>
<div>                &lt;p class="text-gray-light mb-0"&gt;Fill all Information as below&lt;/p&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/button&gt;</div>
<div>    &lt;/li&gt;</div>
<div>    &lt;li class="nav-item" role="presentation"&gt;</div>
<div>        &lt;button class="nav-link p-0 d-flex align-items-center" id="step6-tab" data-bs-toggle="tab" data-bs-target="#step6-tab-pane" type="button" role="tab" aria-controls="step6-tab-pane" aria-selected="false"&gt;</div>
<div>            &lt;span class="fs-20 fw-bold text-primary wh-48 bg-primary bg-opacity-10 rounded-circle d-inline-block"&gt;2&lt;/span&gt;</div>
<div>            &lt;div class="text-start ms-3"&gt;</div>
<div>                &lt;h4 class="fs-18 fw-semibold"&gt;Personal Info&lt;/h4&gt;</div>
<div>                &lt;p class="text-gray-light mb-0"&gt;Setup Information&lt;/p&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/button&gt;</div>
<div>    &lt;/li&gt;</div>
<div>    &lt;li class="nav-item" role="presentation"&gt;</div>
<div>        &lt;button class="nav-link p-0 d-flex align-items-center" id="step7-tab" data-bs-toggle="tab" data-bs-target="#step7-tab-pane" type="button" role="tab" aria-controls="step7-tab-pane" aria-selected="false"&gt;</div>
<div>            &lt;span class="fs-20 fw-bold text-primary wh-48 bg-primary bg-opacity-10 rounded-circle d-inline-block"&gt;3&lt;/span&gt;</div>
<div>            &lt;div class="text-start ms-3"&gt;</div>
<div>                &lt;h4 class="fs-18 fw-semibold"&gt;Social Links&lt;/h4&gt;</div>
<div>                &lt;p class="text-gray-light mb-0"&gt;Add Social Links&lt;/p&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/button&gt;</div>
<div>    &lt;/li&gt;</div>
<div>&lt;/ul&gt;</div>
<div>&lt;div class="tab-content" id="myTabstep2Content"&gt;</div>
<div>    &lt;div class="tab-pane fade show active" id="step5-tab-pane" role="tabpanel" aria-labelledby="step5-tab" tabindex="0"&gt;</div>
<div>        &lt;form&gt;</div>
<div>            &lt;div class="row"&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;First Name&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name"&gt;</div>
<div>                            &lt;i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Last Name&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name"&gt;</div>
<div>                            &lt;i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Email Address&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="email" class="form-control text-dark ps-5 h-55" placeholder="Enter Email Address"&gt;</div>
<div>                            &lt;i class="ri-mail-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Phone&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="number" class="form-control text-dark ps-5 h-55" placeholder="Enter Phone Number"&gt;</div>
<div>                            &lt;i class="ri-phone-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Address&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="number" class="form-control text-dark ps-5 h-55" placeholder="Your Location"&gt;</div>
<div>                            &lt;i class="ri-map-pin-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group d-flex gap-3"&gt;</div>
<div>                        &lt;button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0"&gt;Back&lt;/button&gt;</div>
<div>                        &lt;button class="btn btn-primary py-3 px-5 fw-semibold text-white"&gt;Next&lt;/button&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/form&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="tab-pane fade" id="step6-tab-pane" role="tabpanel" aria-labelledby="step6-tab" tabindex="0"&gt;</div>
<div>        &lt;h4 class="fs-18 fw-semibold"&gt;Personal Information&lt;/h4&gt;</div>
<div>        &lt;p class="text-gray-light mb-4"&gt;Fill all Information as below&lt;/p&gt;</div>
<div>        &lt;form&gt;</div>
<div>            &lt;div class="row"&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Country&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;select class="form-select form-control ps-5 h-55" aria-label="Default select example"&gt;</div>
<div>                                &lt;option selected class="text-dark"&gt;United Kingdom&lt;/option&gt;</div>
<div>                                &lt;option value="1" class="text-dark"&gt;United States&lt;/option&gt;</div>
<div>                                &lt;option value="2" class="text-dark"&gt;Canada&lt;/option&gt;</div>
<div>                                &lt;option value="3" class="text-dark"&gt;France&lt;/option&gt;</div>
<div>                            &lt;/select&gt;</div>
<div>                            &lt;i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-4"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Town/City&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;select class="form-select form-control ps-5 h-55" aria-label="Default select example"&gt;</div>
<div>                                &lt;option selected class="text-dark"&gt;California&lt;/option&gt;</div>
<div>                                &lt;option value="1" class="text-dark"&gt;United States&lt;/option&gt;</div>
<div>                                &lt;option value="2" class="text-dark"&gt;Canada&lt;/option&gt;</div>
<div>                                &lt;option value="3" class="text-dark"&gt;France&lt;/option&gt;</div>
<div>                            &lt;/select&gt;</div>
<div>                            &lt;i class="ri-list-ordered position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-4"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;State&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;select class="form-select form-control ps-5 h-55" aria-label="Default select example"&gt;</div>
<div>                                &lt;option selected class="text-dark"&gt;South poal evenue state 4C&lt;/option&gt;</div>
<div>                                &lt;option value="1" class="text-dark"&gt;United States&lt;/option&gt;</div>
<div>                                &lt;option value="2" class="text-dark"&gt;Canada&lt;/option&gt;</div>
<div>                                &lt;option value="3" class="text-dark"&gt;France&lt;/option&gt;</div>
<div>                            &lt;/select&gt;</div>
<div>                            &lt;i class="ri-font-size position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-4"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Zip Code&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="number" class="form-control ps-5 text-gray-light h-55" placeholder="Enter number"&gt;</div>
<div>                            &lt;i class="ri-hashtag position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Order Notes :&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;textarea class="form-control ps-5 text-dark" placeholder="Some demo text ... " cols="30" rows="5"&gt;&lt;/textarea&gt;</div>
<div>                            &lt;i class="ri-information-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20 pt-2"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group d-flex gap-3"&gt;</div>
<div>                        &lt;button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0"&gt;Back&lt;/button&gt;</div>
<div>                        &lt;button class="btn btn-primary py-3 px-5 fw-semibold text-white"&gt;Next&lt;/button&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/form&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="tab-pane fade" id="step7-tab-pane" role="tabpanel" aria-labelledby="step7-tab" tabindex="0"&gt;</div>
<div>        &lt;h4 class="fs-18 fw-semibold"&gt;Social Information&lt;/h4&gt;</div>
<div>        &lt;p class="text-gray-light mb-4"&gt;Fill all Information as below&lt;/p&gt;</div>
<div>        &lt;form&gt;</div>
<div>            &lt;div class="row"&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Facebook&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="text" class="form-control text-dark ps-5 h-55" placeholder="URL"&gt;</div>
<div>                            &lt;i class="ri-facebook-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Twitter&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="text" class="form-control text-dark ps-5 h-55" placeholder="URL"&gt;</div>
<div>                            &lt;i class="ri-twitter-x-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;Linkedin&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="email" class="form-control text-dark ps-5 h-55" placeholder="URL"&gt;</div>
<div>                            &lt;i class="ri-linkedin-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-6"&gt;</div>
<div>                    &lt;div class="form-group mb-4"&gt;</div>
<div>                        &lt;label class="label"&gt;YouTube&lt;/label&gt;</div>
<div>                        &lt;div class="form-group position-relative"&gt;</div>
<div>                            &lt;input type="number" class="form-control text-dark ps-5 h-55" placeholder="URL"&gt;</div>
<div>                            &lt;i class="ri-youtube-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"&gt;&lt;/i&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>                &lt;div class="col-lg-12"&gt;</div>
<div>                    &lt;div class="form-group d-flex gap-3"&gt;</div>
<div>                        &lt;button class="btn btn-primary bg-primary bg-opacity-10 text-primary py-3 px-5 fw-semibold border-0"&gt;Back&lt;/button&gt;</div>
<div>                        &lt;button type="submit" class="btn btn-primary py-3 px-5 fw-semibold text-white"&gt;Submit&lt;/button&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/form&gt;</div>
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
