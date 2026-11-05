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
                        <h3 class="mb-0">Advanced Elements</h3>

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
                                    <span class="fw-medium">Advanced Elements</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Selectr Components</h4>
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
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <label class="label text-secondary">Default Select</label>
                                                        <div class="form-group position-relative">
                                                            <select class="form-select form-control h-60" aria-label="Default select example">
                                                                <option selected class="text-dark">Value 1</option>
                                                                <option value="1" class="text-dark">Value 2</option>
                                                                <option value="2" class="text-dark">Value 3</option>
                                                                <option value="3" class="text-dark">Value 4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <label class="label text-secondary">Multi Tags</label>
                                                        <div class="tag-container p-1 rounded-3 form-control h-auto p-0" id="tagContainer">
                                                            <input type="text" id="tagInput" class="form-control h-49 border-0" placeholder="Type and press Enter">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <label class="label text-secondary">Taggable Select</label>
                                                        <div class="form-group position-relative">
                                                            <select class="form-select form-control h-60" aria-label="Default select example">
                                                                <option selected class="text-dark">Trezo</option>
                                                                <option value="1" class="text-dark">Seku</option>
                                                                <option value="2" class="text-dark">Adlo</option>
                                                                <option value="3" class="text-dark">Orla</option>
                                                            </select>
                                                        </div>
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
<div>&lt;div class="row"&gt;</div>
<div>    &lt;div class="col-lg-4"&gt;</div>
<div>        &lt;div class="form-group mb-4"&gt;</div>
<div>            &lt;label class="label text-secondary"&gt;Default Select&lt;/label&gt;</div>
<div>            &lt;div class="form-group position-relative"&gt;</div>
<div>                &lt;select class="form-select form-control h-60" aria-label="Default select example"&gt;</div>
<div>                    &lt;option selected class="text-dark"&gt;Value 1&lt;/option&gt;</div>
<div>                    &lt;option value="1" class="text-dark"&gt;Value 2&lt;/option&gt;</div>
<div>                    &lt;option value="2" class="text-dark"&gt;Value 3&lt;/option&gt;</div>
<div>                    &lt;option value="3" class="text-dark"&gt;Value 4&lt;/option&gt;</div>
<div>                &lt;/select&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-lg-4"&gt;</div>
<div>        &lt;div class="form-group mb-4"&gt;</div>
<div>            &lt;label class="label text-secondary"&gt;Multi Tags&lt;/label&gt;</div>
<div>            &lt;div class="tag-container p-1 rounded-3 form-control h-auto p-0" id="tagContainer"&gt;</div>
<div>                &lt;input type="text" id="tagInput" class="form-control h-49 border-0" placeholder="Type and press Enter"&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>    &lt;/div&gt;</div>
<div>    &lt;div class="col-lg-4"&gt;</div>
<div>        &lt;div class="form-group mb-4"&gt;</div>
<div>            &lt;label class="label text-secondary"&gt;Taggable Select&lt;/label&gt;</div>
<div>            &lt;div class="form-group position-relative"&gt;</div>
<div>                &lt;select class="form-select form-control h-60" aria-label="Default select example"&gt;</div>
<div>                    &lt;option selected class="text-dark"&gt;Trezo&lt;/option&gt;</div>
<div>                    &lt;option value="1" class="text-dark"&gt;Seku&lt;/option&gt;</div>
<div>                    &lt;option value="2" class="text-dark"&gt;Adlo&lt;/option&gt;</div>
<div>                    &lt;option value="3" class="text-dark"&gt;Orla&lt;/option&gt;</div>
<div>                &lt;/select&gt;</div>
<div>            &lt;/div&gt;</div>
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
                                    <h4 class="fs-18 mb-4">Custom country select input</h4>
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
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Default Select</label>
                                                            <div class="form-group position-relative">
                                                                <select class="form-select form-control h-60" aria-label="Default select example">
                                                                    <option selected class="text-dark">Value 1</option>
                                                                    <option value="1" class="text-dark">Value 2</option>
                                                                    <option value="2" class="text-dark">Value 3</option>
                                                                    <option value="3" class="text-dark">Value 4</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Multi Tags</label>
                                                            <div class="col-12">
                                                                <label class="visually-hidden" for="inlineFormInputGroupUsername">Enter number</label>
                                                                <div class="input-group h-60 form-control p-0">
                                                                    <div class="input-group-text rounded-3 px-3">
                                                                        <img src="assets/images/united-states.jpg" alt="united-states">
                                                                        <span class="ms-3 text-dark">+1</span>
                                                                    </div>
                                                                    <input type="number" class="form-control h-auto border-0 text-dark" id="inlineFormInputGroupUsername" placeholder="Enter number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Taggable Select</label>
                                                            <div class="form-group position-relative">
                                                                <select class="form-select form-control h-60 ps-5" aria-label="Default select example">
                                                                    <option selected class="text-dark">United States</option>
                                                                    <option value="1" class="text-dark">United Kingdom</option>
                                                                    <option value="2" class="text-dark">Germany</option>
                                                                </select>
                                                                <img src="assets/images/united-states.jpg" class="position-absolute top-50 start-0 translate-middle-y ps-3" alt="united-states">
                                                            </div>
                                                        </div>
                                                    </div>
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
<div>    &lt;div class="row"&gt;</div>
<div>        &lt;div class="col-lg-4"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Default Select&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;select class="form-select form-control h-60" aria-label="Default select example"&gt;</div>
<div>                        &lt;option selected class="text-dark"&gt;Value 1&lt;/option&gt;</div>
<div>                        &lt;option value="1" class="text-dark"&gt;Value 2&lt;/option&gt;</div>
<div>                        &lt;option value="2" class="text-dark"&gt;Value 3&lt;/option&gt;</div>
<div>                        &lt;option value="3" class="text-dark"&gt;Value 4&lt;/option&gt;</div>
<div>                    &lt;/select&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-4"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Multi Tags&lt;/label&gt;</div>
<div>                &lt;div class="col-12"&gt;</div>
<div>                    &lt;label class="visually-hidden" for="inlineFormInputGroupUsername"&gt;Enter number&lt;/label&gt;</div>
<div>                    &lt;div class="input-group h-60 form-control p-0"&gt;</div>
<div>                        &lt;div class="input-group-text rounded-3 px-3"&gt;</div>
<div>                            &lt;img src="assets/images/united-states.jpg" alt="united-states"&gt;</div>
<div>                            &lt;span class="ms-3 text-dark"&gt;+1&lt;/span&gt;</div>
<div>                        &lt;/div&gt;</div>
<div>                        &lt;input type="number" class="form-control h-auto border-0 text-dark" id="inlineFormInputGroupUsername" placeholder="Enter number"&gt;</div>
<div>                    &lt;/div&gt;</div>
<div>                &lt;/div&gt;</div>
<div>            &lt;/div&gt;</div>
<div>        &lt;/div&gt;</div>
<div>        &lt;div class="col-lg-4"&gt;</div>
<div>            &lt;div class="form-group mb-4"&gt;</div>
<div>                &lt;label class="label text-secondary"&gt;Taggable Select&lt;/label&gt;</div>
<div>                &lt;div class="form-group position-relative"&gt;</div>
<div>                    &lt;select class="form-select form-control h-60 ps-5" aria-label="Default select example"&gt;</div>
<div>                        &lt;option selected class="text-dark"&gt;United States&lt;/option&gt;</div>
<div>                        &lt;option value="1" class="text-dark"&gt;United Kingdom&lt;/option&gt;</div>
<div>                        &lt;option value="2" class="text-dark"&gt;Germany&lt;/option&gt;</div>
<div>                    &lt;/select&gt;</div>
<div>                    &lt;img src="assets/images/united-states.jpg" class="position-absolute top-50 start-0 translate-middle-y ps-3" alt="united-states"&gt;</div>
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
                        <div class="col-xxl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">By Date</h4>
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
                                            <div class="d-flex align-items-center mb-4 gap-5">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        This Week
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                    <label class="form-check-label" for="flexCheckDefault2">
                                                        Last Week
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-4 gap-5">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                    <label class="form-check-label" for="flexCheckDefault3">
                                                        This Month
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                    <label class="form-check-label" for="flexCheckDefault4">
                                                        Last Month
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-4 gap-5">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                    <label class="form-check-label" for="flexCheckDefault5">
                                                        This Year
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                    <label class="form-check-label" for="flexCheckDefault6">
                                                        Last Year
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="border-top border-bottom py-3 mb-4">
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-1" style="background-image: unset;" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                    <label class="form-check-label text-dark fs-14" for="flexRadioDefault1">
                                                        Date Range
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="calendar-content">
                                                <h1 id="month-year"></h1>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>S</th>
                                                            <th>M</th>
                                                            <th>T</th>
                                                            <th>W</th>
                                                            <th>T</th>
                                                            <th>F</th>
                                                            <th>S</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="calendar-body"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
<div>&lt;div class="calendar-content"&gt;</div>
<div>    &lt;h1 id="month-year"&gt;&lt;/h1&gt;</div>
<div>    &lt;table id="calendar"&gt;</div>
<div>        &lt;thead&gt;</div>
<div>            &lt;tr&gt;</div>
<div>                &lt;th&gt;S&lt;/th&gt;</div>
<div>                &lt;th&gt;M&lt;/th&gt;</div>
<div>                &lt;th&gt;T&lt;/th&gt;</div>
<div>                &lt;th&gt;W&lt;/th&gt;</div>
<div>                &lt;th&gt;T&lt;/th&gt;</div>
<div>                &lt;th&gt;F&lt;/th&gt;</div>
<div>                &lt;th&gt;S&lt;/th&gt;</div>
<div>            &lt;/tr&gt;</div>
<div>        &lt;/thead&gt;</div>
<div>        &lt;tbody id="calendar-body"&gt;&lt;/tbody&gt;</div>
<div>    &lt;/table&gt;</div>
<div>&lt;/div&gt;</div>
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Custom Touch Spin</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab4" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview4-tab" data-bs-toggle="tab" data-bs-target="#preview4-tab-pane" type="button" role="tab" aria-controls="preview4-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code4-tab-pane" type="button" role="tab" aria-controls="code4-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab4Content">
                                        <div class="tab-pane fade show active" id="preview4-tab-pane" role="tabpanel" aria-labelledby="preview4-tab" tabindex="0">
                                            <div class="d-flex gap-sm-3 gap-lg-4">
                                                <div>
                                                    <label class="label d-block">Default</label>
                                                    <div class="product-quantity">
                                                        <div class="add-to-cart-counter gap-2">
                                                            <button type="submit" class="minusBtn"></button>
                                                            <input type="text" size="25" value="1" class="count"/> 
                                                            <button type="submit" class="plusBtn"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="label d-block">Light</label>
                                                    <div class="product-quantity bg-e2e8f0">
                                                        <div class="add-to-cart-counter gap-2">
                                                            <button type="submit" class="minusBtn"></button>
                                                            <input type="text" size="25" value="1" class="count"/> 
                                                            <button type="submit" class="plusBtn"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
<div>&lt;div class="product-quantity"&gt;</div>
<div>    &lt;div class="add-to-cart-counter gap-2"&gt;</div>
<div>        &lt;button type="submit" class="minusBtn"&gt;&lt;/button&gt;</div>
<div>        &lt;inputtype="text"size="25"value="1"class="count"/&gt;</div>
<div>        &lt;button type="submit" class="plusBtn"&gt;&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/div&gt;</div>
<div>&lt;div class="product-quantity bg-e2e8f0"&gt;</div>
<div>    &lt;div class="add-to-cart-counter gap-2"&gt;</div>
<div>        &lt;button type="submit" class="minusBtn"&gt;&lt;/button&gt;</div>
<div>        &lt;inputtype="text"size="25"value="1"class="count"/&gt;</div>
<div>        &lt;button type="submit" class="plusBtn"&gt;&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/div&gt;</div>
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">(Full width) Custom Touch Spin</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab5" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview5-tab" data-bs-toggle="tab" data-bs-target="#preview5-tab-pane" type="button" role="tab" aria-controls="preview5-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code5-tab-pane" type="button" role="tab" aria-controls="code5-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab5Content">
                                        <div class="tab-pane fade show active" id="preview5-tab-pane" role="tabpanel" aria-labelledby="preview5-tab" tabindex="0">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label class="label d-block">Default</label>
                                                    <div class="product-quantity w-100">
                                                        <div class="add-to-cart-counter gap-2 justify-content-between">
                                                            <button type="submit" class="minusBtn"></button>
                                                            <input type="text" size="25" value="1" class="count"/> 
                                                            <button type="submit" class="plusBtn"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="label d-block">Light</label>
                                                    <div class="product-quantity w-100 bg-e2e8f0">
                                                        <div class="add-to-cart-counter gap-2 justify-content-between">
                                                            <button type="submit" class="minusBtn"></button>
                                                            <input type="text" size="25" value="1" class="count"/> 
                                                            <button type="submit" class="plusBtn"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode5">
<div>&lt;div class="product-quantity w-100"&gt;</div>
<div>    &lt;div class="add-to-cart-counter gap-2 justify-content-between"&gt;</div>
<div>        &lt;button type="submit" class="minusBtn"&gt;&lt;/button&gt;</div>
<div>        &lt;inputtype="text"size="25"value="1"class="count"/&gt;</div>
<div>        &lt;button type="submit" class="plusBtn"&gt;&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/div&gt;</div>
<div>&lt;div class="product-quantity w-100 bg-e2e8f0"&gt;</div>
<div>    &lt;div class="add-to-cart-counter gap-2 justify-content-between"&gt;</div>
<div>        &lt;button type="submit" class="minusBtn"&gt;&lt;/button&gt;</div>
<div>        &lt;inputtype="text"size="25"value="1"class="count"/&gt;</div>
<div>        &lt;button type="submit" class="plusBtn"&gt;&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/div&gt;</div>
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 pb-0">
                                    <h4 class="fs-18 mb-4">Custom Touch Spin Colors</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab6" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview6-tab" data-bs-toggle="tab" data-bs-target="#preview6-tab-pane" type="button" role="tab" aria-controls="preview6-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code6-tab-pane" type="button" role="tab" aria-controls="code6-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab6Content">
                                        <div class="tab-pane fade show active" id="preview6-tab-pane" role="tabpanel" aria-labelledby="preview6-tab" tabindex="0">
                                            <div class="row">
                                                <div class="col-lg-3 col-sm-6 mb-4">
                                                    <label class="label d-block">Colored-1</label>
                                                    <div class="product-quantity">
                                                        <div class="add-to-cart-counter gap-3 justify-content-between">
                                                            <button type="submit" class="minusBtn bg-primary text-white"></button>
                                                            <input type="text" size="25" value="1" class="count"/> 
                                                            <button type="submit" class="plusBtn bg-primary text-white"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 mb-4">
                                                    <label class="label d-block">Colored-2</label>
                                                    <div class="product-quantity bg-e2e8f0">
                                                        <div class="add-to-cart-counter gap-3 justify-content-between">
                                                            <button type="submit" class="minusBtn bg-white text-primary"></button>
                                                            <input type="text" size="25" value="1" class="count bg-primary text-white"/> 
                                                            <button type="submit" class="plusBtn bg-white text-primary"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 mb-4">
                                                    <label class="label d-block">Colored-3</label>
                                                    <div class="product-quantity">
                                                        <div class="add-to-cart-counter gap-3 justify-content-between">
                                                            <button type="submit" class="minusBtn bg-danger text-white"></button>
                                                            <input type="text" size="25" value="1" class="count border-danger"/> 
                                                            <button type="submit" class="plusBtn bg-danger text-white"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <label class="label d-block">Colored-4</label>
                                                    <div class="product-quantity">
                                                        <div class="add-to-cart-counter gap-3 justify-content-between">
                                                            <button type="submit" class="minusBtn bg-success text-white"></button>
                                                            <input type="text" size="25" value="1" class="count border-success"/> 
                                                            <button type="submit" class="plusBtn bg-success text-white"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code6-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode6">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode6">
<div>&lt;div class="product-quantity"&gt;</div>
<div>    &lt;div class="add-to-cart-counter gap-3 justify-content-between"&gt;</div>
<div>        &lt;button type="submit" class="minusBtn bg-primary text-white"&gt;&lt;/button&gt;</div>
<div>        &lt;inputtype="text"size="25"value="1"class="count"/&gt;</div>
<div>        &lt;button type="submit" class="plusBtn bg-primary text-white"&gt;&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/div&gt;</div>
<div>&lt;div class="product-quantity bg-e2e8f0"&gt;</div>
<div>    &lt;div class="add-to-cart-counter gap-3 justify-content-between"&gt;</div>
<div>        &lt;button type="submit" class="minusBtn bg-white text-primary"&gt;&lt;/button&gt;</div>
<div>        &lt;inputtype="text"size="25"value="1"class="count bg-primary text-white"/&gt;</div>
<div>        &lt;button type="submit" class="plusBtn bg-white text-primary"&gt;&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/div&gt;</div>
<div>&lt;div class="product-quantity"&gt;</div>
<div>    &lt;div class="add-to-cart-counter gap-3 justify-content-between"&gt;</div>
<div>        &lt;button type="submit" class="minusBtn bg-danger text-white"&gt;&lt;/button&gt;</div>
<div>        &lt;inputtype="text"size="25"value="1"class="count border-danger"/&gt;</div>
<div>        &lt;button type="submit" class="plusBtn bg-danger text-white"&gt;&lt;/button&gt;</div>
<div>    &lt;/div&gt;</div>
<div>&lt;/div&gt;</div>
<div>&lt;div class="product-quantity"&gt;</div>
<div>    &lt;div class="add-to-cart-counter gap-3 justify-content-between"&gt;</div>
<div>        &lt;button type="submit" class="minusBtn bg-success text-white"&gt;&lt;/button&gt;</div>
<div>        &lt;inputtype="text"size="25"value="1"class="count border-success"/&gt;</div>
<div>        &lt;button type="submit" class="plusBtn bg-success text-white"&gt;&lt;/button&gt;</div>
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
