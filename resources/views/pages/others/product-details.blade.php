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
                        <h3 class="mb-0">Product Details</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Front Pages</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Product Details</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-sm-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h4 class="fs-16 fw-medium mb-2 mb-sm-0">Filter</h4>  

                                <form class="default-src-form">
                                    <div class="d-sm-flex flex-wrap gap-3">
                                        <div class="position-relative mb-2 mb-sm-0">
                                            <input type="text" class="form-control rounded-1" placeholder="Search here">
                                            <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y fs-18">search</i>
                                        </div>
                                        <div>
                                            <select class="form-select form-control rounded-1 py-0 fs-14 ps-3 bg-transparent pe-5" aria-label="Default select example">
                                                <option selected>Default Shorting</option> 
                                                <option value="1">Apple</option>
                                                <option value="2">SAMSUNG</option>
                                                <option value="3">T-Shirts</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="tab-content position-relative bg-body-bg product-for-dark text-center p-5 rounded-3 mb-4" id="myTabContent">
                                        <div class="tab-pane product-details-img fade show active" id="product1-tab-pane" role="tabpanel" aria-labelledby="product1-tab" tabindex="0">
                                            <img src="assets/images/product-15.png" alt="product">
                                        </div>
                                        <div class="tab-pane product-details-img fade" id="product2-tab-pane" role="tabpanel" aria-labelledby="product2-tab" tabindex="0">
                                            <img src="assets/images/product-16.png" alt="product">
                                        </div>
                                        <div class="tab-pane product-details-img fade" id="product3-tab-pane" role="tabpanel" aria-labelledby="product3-tab" tabindex="0">
                                            <img src="assets/images/product-17.png" alt="product">
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs products-tabs justify-content-center gap-3 gap-sm-4 border-0" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link bg-body-bg product-for-dark rounded-3 active" id="product1-tab" data-bs-toggle="tab" data-bs-target="#product1-tab-pane" type="button" role="tab" aria-controls="product1-tab-pane" aria-selected="true">
                                                <img src="assets/images/product-15.png" class="mw-123" alt="product">
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link bg-body-bg product-for-dark rounded-3" id="product2-tab" data-bs-toggle="tab" data-bs-target="#product2-tab-pane" type="button" role="tab" aria-controls="product2-tab-pane" aria-selected="false">
                                                <img src="assets/images/product-16.png" class="mw-123" alt="product">
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link bg-body-bg product-for-dark rounded-3" id="product3-tab" data-bs-toggle="tab" data-bs-target="#product3-tab-pane" type="button" role="tab" aria-controls="product3-tab-pane" aria-selected="false">
                                                <img src="assets/images/product-17.png" class="mw-123" alt="product">
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="product-details-content ms-lg-4 ms-xl-3 ms-xxl-5 mt-4 mt-lg-0">
                                        <span class="bg-success bg-opacity-10 text-success d-inline-block py-1 px-3 rounded-3 mb-3">
                                            <i class="ri-check-line fs-16 position-relative top-1"></i>
                                            in stock
                                        </span>
                                        <h3 class="fs-18 fw-medium lh-base lh-sm mb-3">Apple MacBook Pro 16.2" with Liquid Retina XDR Display, M2 Max Chip with 12-Core CPU</h3>
                                        <div class="d-flex gap-1 mb-3 pb-3 border-bottom">
                                            <i class="ri-star-fill fs-16 text-warning"></i>
                                            <i class="ri-star-fill fs-16 text-warning"></i>
                                            <i class="ri-star-fill fs-16 text-warning"></i>
                                            <i class="ri-star-fill fs-16 text-warning"></i>
                                            <i class="ri-star-fill fs-16 text-warning"></i>
                                            <span class="position-relative top-2 ms-2">(5 Reviews)</span>
                                        </div>
                                        <h2 class="fs-18 mb-3">$3,499 <del class="fw-normal fs-16 ms-2">$3,799</del></h2>
                                        <div class="d-flex style-select mb-2 align-items-center">
                                            <span>Style:</span>
                                            <h5 class="mb-0 fw-medium fs-14 position-relative top-2 ms-1">Apple M1  Pro Chip</h5>
                                        </div>
                                        <div class="select-style mb-4 d-flex flex-wrap gap-3">
                                            <div>
                                                <input type="radio" class="btn-check" name="options-base" id="option5" autocomplete="off">
                                                <label class="btn mb-2 mb-sm-0 border" for="option5">Apple M1  Max Chip</label>
                                            </div>
                                            <div>
                                                <input type="radio" class="btn-check" name="options-base" id="option6" autocomplete="off" checked>
                                                <label class="btn mb-2 mb-sm-0 border" for="option6">Apple M1  Pro Chip</label>
                                            </div>
                                        </div>
                                        <div class="d-flex style-select mb-2 align-items-center">
                                            <span>Capacity:</span>
                                            <h5 class="mb-0 fw-medium fs-14 position-relative top-2 ms-1">1 TB</h5>
                                        </div>
                                        <div class="select-style mb-4 d-flex flex-wrap gap-3">
                                            <div>
                                                <input type="radio" class="btn-check" name="options-outlined" id="success-outlined" autocomplete="off" checked>
                                                <label class="btn mb-2 mb-sm-0 border" for="success-outlined">512 GB</label>
                                            </div>
            
                                            <div>
                                                <input type="radio" class="btn-check" name="options-outlined" id="danger-outlined" autocomplete="off">
                                                <label class="btn mb-2 mb-sm-0 border" for="danger-outlined">1 TB</label>
                                            </div>
                                        </div>
                                        <div class="d-flex style-select mb-2 align-items-center">
                                            <span>Color:</span>
                                            <h5 class="mb-0 fw-medium fs-14 position-relative top-2 ms-1">Silver</h5>
                                        </div>
                                        <ul class="d-flex ps-0 mb-0 list-unstyled select-color gap-2 mb-4">
                                            <li class="color1 active"></li>
                                            <li class="color2"></li>
                                        </ul>
                                        <div class="d-flex align-items-center mb-4 gap-3">
                                            <div class="product-quantity">
                                                <div class="add-to-cart-counter">
                                                    <input type="button" class="minusBtn" value="-"/>
                                                    <input type="text" size="25" value="4" class="count"/> 
                                                    <input type="button" class="plusBtn" value="+"/>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary rounded-3 py-2">
                                                <i class="ri-shopping-cart-line text-white"></i>
                                                <span>Add To Cart</span>
                                            </button>
                                        </div>
                                        <button class="d-flex align-items-center gap-2 mb-2 border-0 bg-transparent">
                                            <i class="ri-heart-line wh-30 lh-30 d-inline-block bg-border-color fs-16 rounded-pill text-body"></i>
                                            <span class="fs-14 fw-medium">Add to wishlist</span>
                                        </button>
                                        <button class="d-flex align-items-center gap-2 border-0 bg-transparent">
                                            <i class="ri-eye-line wh-30 lh-30 d-inline-block bg-border-color fs-16 rounded-pill text-body"></i>
                                            <span class="fs-14">565 people are viewing the products</span>
                                        </button>
                                        <ul class="ps-0 list-unstyled border-top border-bottom py-3 my-3">
                                            <li class="d-flex align-items-center mb-2">
                                                <i class="ri-check-line fs-18 position-relative top-2 text-success me-2"></i>
                                                <span class="text-secondary">Free delivery today</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-2">
                                                <i class="ri-check-line fs-18 position-relative top-2 text-success me-2"></i>
                                                <span class="text-secondary">100% money back Guarantee</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-2">
                                                <i class="ri-check-line fs-18 position-relative top-2 text-success me-2"></i>
                                                <span class="text-secondary">7 days product return policy</span>
                                            </li>
                                        </ul>
                                        <ul class="ps-0 mb-3 list-unstyled">
                                            <li class="d-flex align-items-center mb-2">
                                                <span>SKU:</span>
                                                <span class="fw-medium text-secondary ms-1">SMTGS6T45</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-2">
                                                <span>Category:</span>
                                                <span class="fw-medium text-secondary ms-1">Computer</span>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <span>Tags:</span>
                                                <span class="fw-medium text-secondary ms-1">laptop, macbook, PC</span>
                                            </li>
                                        </ul>
                                        <ul class="ps-0 mb-0 list-unstyled d-flex gap-2 flex-wrap">
                                            <li class="d-flex align-items-center me-2">
                                                <span>Share:</span>
                                            </li>
                                            <li class="d-flex align-items-center gap-2">
                                                <a href="https://facebook.com/" class="wh-30 lh-30 bg-body text-center text-decoration-none rounded-pill hover-bg" target="_blank">
                                                    <i class="ri-facebook-fill"></i>
                                                </a>
                                            </li>
                                            <li class="d-flex align-items-center gap-2">
                                                <a href="https://twitter.com/" class="wh-30 lh-30 bg-body text-center text-decoration-none rounded-pill hover-bg" target="_blank">
                                                    <i class="ri-twitter-x-line"></i>
                                                </a>
                                            </li>
                                            <li class="d-flex align-items-center gap-2">
                                                <a href="https://linkedin.com/" class="wh-30 lh-30 bg-body text-center text-decoration-none rounded-pill hover-bg" target="_blank">
                                                    <i class="ri-linkedin-fill"></i>
                                                </a>
                                            </li>
                                            <li class="d-flex align-items-center gap-2">
                                                <a href="https://whatsapp.com/" class="wh-30 lh-30 bg-body text-center text-decoration-none rounded-pill hover-bg" target="_blank">
                                                    <i class="ri-whatsapp-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs review-tabs gap-3 border-0 bg-transparent" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link border-0 fs-16 fw-medium active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link border-0 fs-16 fw-medium" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification-tab-pane" type="button" role="tab" aria-controls="specification-tab-pane" aria-selected="false">Specification</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link border-0 fs-16 fw-medium" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">Reviews</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                            <div class="card bg-white border-0 rounded-3 mb-4 rounded-top-0">
                                <div class="card-body p-4">
                                    <p>The Apple MacBook Pro 16.2 is a cutting-edge laptop designed to deliver exceptional performance and advanced features for professionals and creative enthusiasts. With its sleek aluminum body and precision engineering, this MacBook Pro represents the pinnacle of Apple's laptop technology.</p>
                                    <p>Stay connected with a variety of ports, including Thunderbolt 3, USB-C, and audio jacks. These versatile ports support high-speed data transfer and external device connections. Enjoy a rich audio experience with high-fidelity speakers that deliver clear and immersive sound. Perfect for content creators and multimedia enthusiasts.</p>
                                    <p>Equipped with the latest processors, ample RAM, and high-performance graphics, the MacBook Pro 16.2 ensures smooth multitasking, fast rendering, and efficient handling of resource-intensive tasks. Seamlessly integrate with the macOS ecosystem, benefiting from features like iCloud, Siri, and a vast selection of applications available on the App Store.</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="specification-tab-pane" role="tabpanel" aria-labelledby="specification-tab" tabindex="0">
                            <div class="card bg-white border-0 rounded-3 mb-4 rounded-top-0">
                                <div class="card-body p-4">
                                    <div class="default-table-area style-two">
                                        <div class="table-responsive p-0">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td class="title text-dark">Brand</td>
                                                        <td class="price">Apple</td>
                                                    </tr>
                                                    <tr> 
                                                        <td class="title text-dark">Categories</td>
                                                        <td class="price">Brond New</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="title text-dark">SKU</td>
                                                        <td class="price">01</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="title text-dark">Price</td>
                                                        <td class="price">$399 </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">
                            <div class="card bg-white border-0 rounded-3 mb-4 rounded-top-0">
                                <div class="card-body p-4">
                                    <div class="mw-480 text-center m-auto mb-4">
                                        <h3 class="fs-24">Feedback</h3>
                                        <p>This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-4 col-sm-6 col-md-6">
                                            <div class="card bg-body-bg border-0 rounded-3 mb-4">
                                                <div class="card-body p-4">
                                                    <ul class="ps-0 mb-2 list-unstyled d-flex gap-2">
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-line text-light fs-20"></i>
                                                        </li>
                                                    </ul>
                                                    <p class="fw-medium">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>

                                                    <div class="d-flex align-items-center mt-3">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-34.jpg" class="rounded-circle wh-35" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4 class="mb-0 fs-16 fw-medium">Alvarado Turner</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6 col-md-6">
                                            <div class="card bg-body-bg border-0 rounded-3 mb-4">
                                                <div class="card-body p-4">
                                                    <ul class="ps-0 mb-2 list-unstyled d-flex gap-2">
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-line text-light fs-20"></i>
                                                        </li>
                                                    </ul>
                                                    <p class="fw-medium">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>

                                                    <div class="d-flex align-items-center mt-3">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-35.jpg" class="rounded-circle wh-35" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4 class="mb-0 fs-16 fw-medium">Eddie Bryan</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6 col-md-6">
                                            <div class="card bg-body-bg border-0 rounded-3 mb-4">
                                                <div class="card-body p-4">
                                                    <ul class="ps-0 mb-2 list-unstyled d-flex gap-2">
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-warning fs-20"></i>
                                                        </li>
                                                    </ul>
                                                    <p class="fw-medium">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>

                                                    <div class="d-flex align-items-center mt-3">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-36.jpg" class="rounded-circle wh-35" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4 class="mb-0 fs-16 fw-medium">Thomas Albart</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-semibold mb-4">Customers Feedback :</h3>
                                    <div class="card bg-body-bg border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="row align-items-center">
                                                <div class="col-lg-8">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <ul class="pe-4 mb-0 list-unstyled d-flex gap-2">
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                        </ul>
                                                        <div class="progress w-100 rounded-pill" role="progressbar" aria-label="Example 5px high" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 5px; background-color: #EFF2FF;">
                                                            <div class="progress-bar rounded-pill" style="width: 100%"></div>
                                                        </div>
                                                        <span class="ms-4">359</span>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <ul class="pe-4 mb-0 list-unstyled d-flex gap-2">
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                                            </li>
                                                        </ul>
                                                        <div class="progress w-100 rounded-pill" role="progressbar" aria-label="Example 5px high" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="height: 5px; background-color: #EFF2FF;">
                                                            <div class="progress-bar rounded-pill" style="width: 90%"></div>
                                                        </div>
                                                        <span class="ms-4">208</span>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <ul class="pe-4 mb-0 list-unstyled d-flex gap-2">
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                                            </li>
                                                        </ul>
                
                                                        <div class="progress w-100 rounded-pill" role="progressbar" aria-label="Example 5px high" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: 5px; background-color: #EFF2FF;">
                                                            <div class="progress-bar rounded-pill" style="width: 80%"></div>
                                                        </div>
                                                        <span class="ms-4">124</span>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <ul class="pe-4 mb-0 list-unstyled d-flex gap-2">
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                                            </li>
                                                        </ul>
                
                                                        <div class="progress w-100 rounded-pill" role="progressbar" aria-label="Example 5px high" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="height: 5px; background-color: #EFF2FF;">
                                                            <div class="progress-bar rounded-pill" style="width: 70%"></div>
                                                        </div>
                                                        <span class="ms-4">89</span>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-0">
                                                        <ul class="pe-4 mb-0 list-unstyled d-flex gap-2">
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                                            </li>
                                                        </ul>
                
                                                        <div class="progress w-100 rounded-pill" role="progressbar" aria-label="Example 5px high" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 5px; background-color: #EFF2FF;">
                                                            <div class="progress-bar rounded-pill" style="width: 60%"></div>
                                                        </div>
                                                        <span class="ms-4">4</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="text-center mt-4 mt-lg-0">
                                                        <h1 class="fs-40 mb-2">4.28</h1>
                                                        <ul class="ps-0 mb-3 list-unstyled d-flex gap-2 justify-content-center">
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-30"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-30"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-30"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-warning fs-30"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-light fs-30"></i>
                                                            </li>
                                                        </ul>
                                                        <span class="ms-4">of 3250 Reviews</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-sm-flex justify-content-between  mb-4">
                                        <h3 class="fs-18 fw-semibold text-center">Write Feedback Here:</h3>
                                        <ul class="ps-0 mb-0 list-unstyled d-flex gap-2 justify-content-center ratings">
                                            <li class="rating">
                                                <i class="ri-star-fill fs-20"></i>
                                            </li>
                                            <li class="rating">
                                                <i class="ri-star-fill fs-20"></i>
                                            </li>
                                            <li class="rating">
                                                <i class="ri-star-fill fs-20"></i>
                                            </li>
                                            <li class="rating">
                                                <i class="ri-star-fill fs-20"></i>
                                            </li>
                                            <li class="rating">
                                                <i class="ri-star-fill fs-20"></i>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card bg-body-bg border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <form>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Your Name</label>
                                                            <input type="text" class="form-control h-55 text-dark" placeholder="Your Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Your Email</label>
                                                            <input type="email" class="form-control h-55 text-dark" placeholder="Your Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Your Phone No</label>
                                                            <input type="number" class="form-control h-55 text-dark" placeholder="Your Phone No">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Your Subject</label>
                                                            <input type="email" class="form-control h-55 text-dark" placeholder="Your Subject">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-4">
                                                            <label class="label text-secondary">Write Comment</label>
                                                            <textarea class="form-control" placeholder="Write Comment" cols="30" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-0">
                                                            <button type="submit" class="btn btn-primary text-white fw-semibold py-3 px-5">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
