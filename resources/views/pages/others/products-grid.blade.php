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
                        <h3 class="mb-0">Products Grid</h3>

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
                                    <span class="fw-medium">Products Grid</span>
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

                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4 transition-y">
                                <div class="position-relative mb-3">
                                    <a href="product-details">
                                        <img src="assets/images/product-6.jpg" class="rounded-3" alt="product">
                                    </a>
                                    <a href="cart" class="bg-body-bg bg-for-dark-mode pt-2 ps-2 position-absolute bottom-0 end-0 rounded-3 rounded-bottom-0 rounded-end-0">
                                        <i class="material-symbols-outlined wh-60 lh-60 bg-primary hover-bg d-inline-block text-white text-center rounded-3 fs-24">shopping_cart</i>
                                    </a>
                                </div>
                                <a href="#" class="text-secondary text-decoration-none fs-16 hover d-block mb-4">Apple MacBook Pro 16.2" with M3 Pro Chip</a>
    
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fs-20 mb-0">$3479 <del class="fs-16 fw-normal">$3599</del></h2>
                                    <div class="d-flex flex-wrap gap-1">
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4 transition-y">
                                <div class="position-relative mb-3">
                                    <a href="product-details">
                                        <img src="assets/images/product-7.jpg" class="rounded-3" alt="product">
                                    </a>
                                    <a href="cart" class="bg-body-bg bg-for-dark-mode pt-2 ps-2 position-absolute bottom-0 end-0 rounded-3 rounded-bottom-0 rounded-end-0">
                                        <i class="material-symbols-outlined wh-60 lh-60 bg-primary hover-bg d-inline-block text-white text-center rounded-3 fs-24">shopping_cart</i>
                                    </a>
                                </div>
                                <a href="#" class="text-secondary text-decoration-none fs-16 hover d-block mb-4">SAMSUNG Galaxy Tab A9+ Tablet 11”</a>
    
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fs-20 mb-0">$549 <del class="fs-16 fw-normal">$649</del></h2>
                                    <div class="d-flex flex-wrap gap-1">
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-half-fill fs-16 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4 transition-y">
                                <div class="position-relative mb-3">
                                    <a href="product-details">
                                        <img src="assets/images/product-8.jpg" class="rounded-3" alt="product">
                                    </a>
                                    <a href="cart" class="bg-body-bg bg-for-dark-mode pt-2 ps-2 position-absolute bottom-0 end-0 rounded-3 rounded-bottom-0 rounded-end-0">
                                        <i class="material-symbols-outlined wh-60 lh-60 bg-primary hover-bg d-inline-block text-white text-center rounded-3 fs-24">shopping_cart</i>
                                    </a>
                                </div>
                                <a href="#" class="text-secondary text-decoration-none fs-16 hover d-block mb-4">Apple iPhone 15 Pro Max (512 GB)</a>
    
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fs-20 mb-0">$1479 <del class="fs-16 fw-normal">$1599</del></h2>
                                    <div class="d-flex flex-wrap gap-1">
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-line fs-16 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4 transition-y">
                                <div class="position-relative mb-3">
                                    <a href="product-details">
                                        <img src="assets/images/product-9.jpg" class="rounded-3" alt="product">
                                    </a>
                                    <a href="cart" class="bg-body-bg bg-for-dark-mode pt-2 ps-2 position-absolute bottom-0 end-0 rounded-3 rounded-bottom-0 rounded-end-0">
                                        <i class="material-symbols-outlined wh-60 lh-60 bg-primary hover-bg d-inline-block text-white text-center rounded-3 fs-24">shopping_cart</i>
                                    </a>
                                </div>
                                <a href="#" class="text-secondary text-decoration-none fs-16 hover d-block mb-4">Gildan Men's Crew T-Shirts, Multipack</a>
    
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fs-20 mb-0">$79 <del class="fs-16 fw-normal">$89</del></h2>
                                    <div class="d-flex flex-wrap gap-1">
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4 transition-y">
                                <div class="position-relative mb-3">
                                    <a href="product-details">
                                        <img src="assets/images/product-10.jpg" class="rounded-3" alt="product">
                                    </a>
                                    <a href="cart" class="bg-body-bg bg-for-dark-mode pt-2 ps-2 position-absolute bottom-0 end-0 rounded-3 rounded-bottom-0 rounded-end-0">
                                        <i class="material-symbols-outlined wh-60 lh-60 bg-primary hover-bg d-inline-block text-white text-center rounded-3 fs-24">shopping_cart</i>
                                    </a>
                                </div>
                                <a href="#" class="text-secondary text-decoration-none fs-16 hover d-block mb-4">Skechers Men's Summits High Range</a>
    
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fs-20 mb-0">$849 <del class="fs-16 fw-normal">$999</del></h2>
                                    <div class="d-flex flex-wrap gap-1">
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-line fs-16 text-warning"></i>
                                        <i class="ri-star-line fs-16 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4 transition-y">
                                <div class="position-relative mb-3">
                                    <a href="product-details">
                                        <img src="assets/images/product-11.jpg" class="rounded-3" alt="product">
                                    </a>
                                    <a href="cart" class="bg-body-bg bg-for-dark-mode pt-2 ps-2 position-absolute bottom-0 end-0 rounded-3 rounded-bottom-0 rounded-end-0">
                                        <i class="material-symbols-outlined wh-60 lh-60 bg-primary hover-bg d-inline-block text-white text-center rounded-3 fs-24">shopping_cart</i>
                                    </a>
                                </div>
                                <a href="#" class="text-secondary text-decoration-none fs-16 hover d-block mb-4">Amazfit GTR 3 Smart Watch for Men</a>
    
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fs-20 mb-0">$49 <del class="fs-16 fw-normal">$69</del></h2>
                                    <div class="d-flex flex-wrap gap-1">
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4 transition-y">
                                <div class="position-relative mb-3">
                                    <a href="product-details">
                                        <img src="assets/images/product-12.jpg" class="rounded-3" alt="product">
                                    </a>
                                    <a href="cart" class="bg-body-bg bg-for-dark-mode pt-2 ps-2 position-absolute bottom-0 end-0 rounded-3 rounded-bottom-0 rounded-end-0">
                                        <i class="material-symbols-outlined wh-60 lh-60 bg-primary hover-bg d-inline-block text-white text-center rounded-3 fs-24">shopping_cart</i>
                                    </a>
                                </div>
                                <a href="#" class="text-secondary text-decoration-none fs-16 hover d-block mb-4">SOJOS Small Round Polarized Sunglasses</a>
    
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fs-20 mb-0">$39 <del class="fs-16 fw-normal">$49</del></h2>
                                    <div class="d-flex flex-wrap gap-1">
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-half-fill fs-16 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4 transition-y">
                                <div class="position-relative mb-3">
                                    <a href="product-details">
                                        <img src="assets/images/product-13.jpg" class="rounded-3" alt="product">
                                    </a>
                                    <a href="cart" class="bg-body-bg bg-for-dark-mode pt-2 ps-2 position-absolute bottom-0 end-0 rounded-3 rounded-bottom-0 rounded-end-0">
                                        <i class="material-symbols-outlined wh-60 lh-60 bg-primary hover-bg d-inline-block text-white text-center rounded-3 fs-24">shopping_cart</i>
                                    </a>
                                </div>
                                <a href="#" class="text-secondary text-decoration-none fs-16 hover d-block mb-4">Nautical Clock Ship Table Clock Brass Desk</a>
    
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fs-20 mb-0">$25 <del class="fs-16 fw-normal">$39</del></h2>
                                    <div class="d-flex flex-wrap gap-1">
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-line fs-16 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-4 transition-y">
                                <div class="position-relative mb-3">
                                    <a href="product-details">
                                        <img src="assets/images/product-14.jpg" class="rounded-3" alt="product">
                                    </a>
                                    <a href="cart" class="bg-body-bg bg-for-dark-mode pt-2 ps-2 position-absolute bottom-0 end-0 rounded-3 rounded-bottom-0 rounded-end-0">
                                        <i class="material-symbols-outlined wh-60 lh-60 bg-primary hover-bg d-inline-block text-white text-center rounded-3 fs-24">shopping_cart</i>
                                    </a>
                                </div>
                                <a href="#" class="text-secondary text-decoration-none fs-16 hover d-block mb-4">Carhartt, Durable, Adjustable Crossbody Bag</a>
    
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fs-20 mb-0">$149 <del class="fs-16 fw-normal">$299</del></h2>
                                    <div class="d-flex flex-wrap gap-1">
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                        <i class="ri-star-fill fs-16 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                        <span class="fs-12 fw-medium">Showing 09 of 30 Results</span>
        
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="products-grid" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link active" href="products-grid">1</a></li>
                                                <li class="page-item"><a class="page-link" href="products-grid">2</a></li>
                                                <li class="page-item"><a class="page-link" href="products-grid">3</a></li>
                                                <li class="page-item"><a class="page-link" href="products-grid">4</a></li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="products-grid" aria-label="Next">
                                                        <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
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
