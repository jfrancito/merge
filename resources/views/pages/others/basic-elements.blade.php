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
                        <h3 class="mb-0">Basic Elements</h3>

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
                                    <span class="fw-medium">Basic Elements</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Textual Inputs</h4>
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
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">First Name</label>
                                                            <div class="form-group position-relative">
                                                                <input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name">
                                                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Last Name</label>
                                                            <div class="form-group position-relative">
                                                                <input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name">
                                                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Email Address</label>
                                                            <div class="form-group position-relative">
                                                                <input type="email" class="form-control text-dark ps-5 h-55" placeholder="Enter Email Address">
                                                                <i class="ri-mail-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Phone</label>
                                                            <div class="form-group position-relative">
                                                                <input type="number" class="form-control text-dark ps-5 h-55" placeholder="Enter Phone Number">
                                                                <i class="ri-phone-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Address</label>
                                                            <div class="form-group position-relative">
                                                                <input type="number" class="form-control text-dark ps-5 h-55" placeholder="Your Location">
                                                                <i class="ri-map-pin-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Country</label>
                                                            <div class="form-group position-relative">
                                                                <select class="form-select form-control ps-5 h-55" aria-label="Default select example">
                                                                    <option selected class="text-dark">United Kingdom</option>
                                                                    <option value="1" class="text-dark">United States</option>
                                                                    <option value="2" class="text-dark">Canada</option>
                                                                    <option value="3" class="text-dark">France</option>
                                                                </select>
                                                                <i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Town/City</label>
                                                            <div class="form-group position-relative">
                                                                <select class="form-select form-control ps-5 h-55" aria-label="Default select example">
                                                                    <option selected class="text-dark">California</option>
                                                                    <option value="1" class="text-dark">United States</option>
                                                                    <option value="2" class="text-dark">Canada</option>
                                                                    <option value="3" class="text-dark">France</option>
                                                                </select>
                                                                <i class="ri-list-ordered position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">State</label>
                                                            <div class="form-group position-relative">
                                                                <select class="form-select form-control ps-5 h-55" aria-label="Default select example">
                                                                    <option selected class="text-dark">South poal evenue state 4C</option>
                                                                    <option value="1" class="text-dark">United States</option>
                                                                    <option value="2" class="text-dark">Canada</option>
                                                                    <option value="3" class="text-dark">France</option>
                                                                </select>
                                                                <i class="ri-font-size position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Zip Code</label>
                                                            <div class="form-group position-relative">
                                                                <input type="number" class="form-control ps-5 h-55" placeholder="Enter number">
                                                                <i class="ri-hashtag position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-0">
                                                            <label class="label text-secondary">Order Notes :</label>
                                                            <div class="form-group position-relative">
                                                                <textarea class="form-control ps-5 text-dark" placeholder="Some demo text ... " cols="30" rows="5"></textarea>
                                                                <i class="ri-information-line position-absolute top-0 start-0 fs-20 ps-20 pt-2"></i>
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
<div>&lt;form&gt;</div>
<div>    &lt;div class="row"&gt;</div>
<div>        &lt;div class="col-lg-6"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;First Name&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name"&gt;</div>
<div>                    &lt;i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"&gt;&lt;/i&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-6"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Last Name&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;input type="text" class="form-control text-dark ps-5 h-55" placeholder="Enter Name"&gt;</div>
<div>                    &lt;i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"&gt;&lt;/i&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-6"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Email Address&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;input type="email" class="form-control text-dark ps-5 h-55" placeholder="Enter Email Address"&gt;</div>
<div>                    &lt;i class="ri-mail-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"&gt;&lt;/i&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-6"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Phone&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;input type="number" class="form-control text-dark ps-5 h-55" placeholder="Enter Phone Number"&gt;</div>
<div>                    &lt;i class="ri-phone-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"&gt;&lt;/i&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-12"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Address&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;input type="number" class="form-control text-dark ps-5 h-55" placeholder="Your Location"&gt;</div>
<div>                    &lt;i class="ri-map-pin-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"&gt;&lt;/i&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-12"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Country&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;select class="form-select form-control ps-5 h-55" aria-label="Default select example"&gt;</div>
<div>                        &lt;option selected class="text-dark"&gt;United Kingdom&lt;/option&gt;</div>
<div>                        &lt;option value="1" class="text-dark"&gt;United States&lt;/option&gt;</div>
<div>                        &lt;option value="2" class="text-dark"&gt;Canada&lt;/option&gt;</div>
<div>                        &lt;option value="3" class="text-dark"&gt;France&lt;/option&gt;</div>
<div>                    &lt;/select&gt;</div>
<div>                    &lt;i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"&gt;&lt;/i&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-4"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Town/City&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;select class="form-select form-control ps-5 h-55" aria-label="Default select example"&gt;</div>
<div>                        &lt;option selected class="text-dark"&gt;California&lt;/option&gt;</div>
<div>                        &lt;option value="1" class="text-dark"&gt;United States&lt;/option&gt;</div>
<div>                        &lt;option value="2" class="text-dark"&gt;Canada&lt;/option&gt;</div>
<div>                        &lt;option value="3" class="text-dark"&gt;France&lt;/option&gt;</div>
<div>                    &lt;/select&gt;</div>
<div>                    &lt;i class="ri-list-ordered position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"&gt;&lt;/i&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-4"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;State&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;select class="form-select form-control ps-5 h-55" aria-label="Default select example"&gt;</div>
<div>                        &lt;option selected class="text-dark"&gt;South poal evenue state 4C&lt;/option&gt;</div>
<div>                        &lt;option value="1" class="text-dark"&gt;United States&lt;/option&gt;</div>
<div>                        &lt;option value="2" class="text-dark"&gt;Canada&lt;/option&gt;</div>
<div>                        &lt;option value="3" class="text-dark"&gt;France&lt;/option&gt;</div>
<div>                    &lt;/select&gt;</div>
<div>                    &lt;i class="ri-font-size position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"&gt;&lt;/i&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-4"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Zip Code&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;input type="number" class="form-control ps-5 h-55" placeholder="Enter number"&gt;</div>
<div>                    &lt;i class="ri-hashtag position-absolute top-50 start-0 translate-middle-y fs-20 ps-20"&gt;&lt;/i&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-12"&gt;</div>
<div>            &lt;div class="form-group mb-0"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Order Notes :&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;textarea class="form-control ps-5 text-dark" placeholder="Some demo text ... " cols="30" rows="5"&gt;&lt;/textarea&gt;</div>
<div>                    &lt;i class="ri-information-line position-absolute top-0 start-0 fs-20 ps-20 pt-2"&gt;&lt;/i&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/form&gt;</div>
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
                                    <h4 class="fs-18 mb-4">Basic Form</h4>
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
                                            <form>
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">First Name</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-dark h-55" placeholder="Enter Name">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Email</label>
                                                    <div class="form-group">
                                                        <input type="email" class="form-control text-dark h-55" placeholder="envytheme@info.com">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Password</label>
                                                    <div class="form-group">
                                                        <div class="password-wrapper position-relative">
                                                            <input type="password" id="password" class="form-control h-55 text-dark" value="password">
                                                            <i style="color: #A9A9C8; font-size: 16px; right: 15px !important;" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 end-0 position-absolute" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Remember me
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary bg-primary bg-opacity-10 text-primary border-0 fw-semibold py-2 px-4">Submit</button>
                                                    <button type="submit" class="btn btn-danger bg-danger bg-opacity-10 text-danger border-0 fw-semibold py-2 px-4">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
<div>&lt;form&gt;</div>
<div>    &lt;div class="form-group mb-4"&gt;</div>
<div>        &lt;label class="label text-secondary"&gt;First Name&lt;/label&gt;</div>
<div>        &lt;div class="form-group"&gt;</div>
<div>            &lt;input type="text" class="form-control text-dark h-55" placeholder="Enter Name"&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="form-group mb-4"&gt;</div>
<div>        &lt;label class="label text-secondary"&gt;Email&lt;/label&gt;</div>
<div>        &lt;div class="form-group"&gt;</div>
<div>            &lt;input type="email" class="form-control text-dark h-55" placeholder="envytheme@info.com"&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="form-group mb-4"&gt;</div>
<div>        &lt;label class="label text-secondary"&gt;Password&lt;/label&gt;</div>
<div>        &lt;div class="form-group"&gt;</div>
<div>            &lt;div class="password-wrapper position-relative"&gt;</div>
<div>                &lt;input type="password" id="password" class="form-control text-dark" value="password"&gt;</div>
<div>                &lt;i style="color: #A9A9C8; font-size: 16px; right: 15px !important;" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 end-0 position-absolute" aria-hidden="true"&gt;&lt;/i&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="form-group mb-4"&gt;</div>
<div>        &lt;div class="form-check"&gt;</div>
<div>            &lt;input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"&gt;</div>
<div>            &lt;label class="form-check-label" for="flexCheckDefault"&gt;</div>
<div>                Remember me</div>
<div>            &lt;/label&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="d-flex gap-2"&gt;</div>
<div>        &lt;button type="submit" class="btn btn-primary bg-primary bg-opacity-10 text-primary border-0 fw-semibold py-2 px-4"&gt;Submit&lt;/button&gt;</div>
<div>        &lt;button type="submit" class="btn btn-danger bg-danger bg-opacity-10 text-danger border-0 fw-semibold py-2 px-4"&gt;Cancel&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/form&gt;</div>
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
                                    <h4 class="fs-18 mb-4">Custom Styles</h4>
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
                                            <form>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control text-dark h-55 border-0 border-bottom" placeholder="Enter Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            
                                                            <div class="form-group">
                                                                <input type="email" class="form-control text-dark h-55 border-0 border-bottom" placeholder="Email Address">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-4">
                                                            <div class="form-group">
                                                                <textarea class="form-control border-0 border-bottom text-dark" placeholder="Comment Here" cols="30" rows="11"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary bg-primary bg-opacity-10 text-primary border-0 fw-semibold py-2 px-4">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
<div>&lt;form&gt;</div>
<div>    &lt;div class="row"&gt;</div>
<div>        &lt;div class="col-lg-6"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;div class="form-group"&gt;</div>
<div>                    &lt;input type="text" class="form-control text-dark h-55 border-0 border-bottom" placeholder="Enter Name"&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-6"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div></div>
<div>                &lt;div class="form-group"&gt;</div>
<div>                    &lt;input type="email" class="form-control text-dark h-55 border-0 border-bottom" placeholder="Email Address"&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-12"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;div class="form-group"&gt;</div>
<div>                    &lt;textarea class="form-control border-0 border-bottom text-dark" placeholder="Comment Here" cols="30" rows="11"&gt;&lt;/textarea&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div></div>
<div>    &lt;div class="text-end"&gt;</div>
<div>        &lt;button type="submit" class="btn btn-primary bg-primary bg-opacity-10 text-primary border-0 fw-semibold py-2 px-4"&gt;Submit&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/form&gt;</div>
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
                                    <h4 class="fs-18 mb-4">Input Groups Buttons</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview4-tab" data-bs-toggle="tab" data-bs-target="#preview4-tab-pane" type="button" role="tab" aria-controls="preview4-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code4-tab-pane" type="button" role="tab" aria-controls="code4-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab3Content">
                                        <div class="tab-pane fade show active" id="preview4-tab-pane" role="tabpanel" aria-labelledby="preview4-tab" tabindex="0">
                                            <form class="src-form">
                                                <div class="form-group mb-4 position-relative">
                                                    <input type="text" class="form-control h-55 bg-body-bg border-0 text-dark rounded-pill" placeholder="Search here..">
                                                    <button type="submit" class="position-absolute top-50 end-0 translate-middle-y bg-transparent p-0 pe-3 border-0">
                                                        <i class="ri-search-line fs-24 position-relative top-1 text-primary"></i>
                                                    </button>
                                                </div>
                                                <div class="form-group mb-4 position-relative">
                                                    <input type="text" class="form-control h-55 bg-body-bg border-0 text-dark rounded-pill" placeholder="Search here..">
                                                    <button type="submit" class="position-absolute top-50 end-0 translate-middle-y bg-primary p-0 wh-40 border-0 text-center text-white rounded-circle me-2">
                                                        <i class="ri-search-line fs-24 position-relative top-1"></i>
                                                    </button>
                                                </div>
                                                <div class="form-group mb-4 position-relative">
                                                    <input type="text" class="form-control h-55 bg-body-bg border-0 text-dark rounded-pill" placeholder="Search here..">
                                                    <button type="submit" class="position-absolute top-50 end-0 translate-middle-y bg-primary p-0 border-0 text-center text-white rounded-pill px-3 py-2 me-2 fw-semibold">
                                                        Search
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
<div>&lt;form class="src-form"&gt;</div>
<div>    &lt;div class="form-group mb-4 position-relative"&gt;</div>
<div>        &lt;input type="text" class="form-control h-55 bg-body-bg border-0 text-dark rounded-pill" placeholder="Search here.."&gt;</div>
<div>        &lt;button type="submit" class="position-absolute top-50 end-0 translate-middle-y bg-transparent p-0 pe-3 border-0"&gt;</div>
<div>            &lt;i class="ri-search-line fs-24 position-relative top-1 text-primary"&gt;&lt;/i&gt;</div>
<div>        &lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="form-group mb-4 position-relative"&gt;</div>
<div>        &lt;input type="text" class="form-control h-55 bg-body-bg border-0 text-dark rounded-pill" placeholder="Search here.."&gt;</div>
<div>        &lt;button type="submit" class="position-absolute top-50 end-0 translate-middle-y bg-primary p-0 wh-40 border-0 text-center text-white rounded-circle me-2"&gt;</div>
<div>            &lt;i class="ri-search-line fs-24 position-relative top-1"&gt;&lt;/i&gt;</div>
<div>        &lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="form-group mb-4 position-relative"&gt;</div>
<div>        &lt;input type="text" class="form-control h-55 bg-body-bg border-0 text-dark rounded-pill" placeholder="Search here.."&gt;</div>
<div>        &lt;button type="submit" class="position-absolute top-50 end-0 translate-middle-y bg-primary p-0 border-0 text-center text-white rounded-pill px-3 py-2 me-2 fw-semibold"&gt;</div>
<div>            Search</div>
<div>        &lt;/button&gt;</div>
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
