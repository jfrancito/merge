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
                    <div class="row">
                        <div class="col-xxl-6">
                            <div class="card border-0 rounded-3 overflow-hidden position-relative z-1 mb-4 for-rtl-beauty" style="background: linear-gradient(90deg, #EAB9D2 0%, #EBA2C7 100%);">
                                <div class="row align-items-end">
                                    <div class="col-sm-7">
                                        <div class="p-4 py-5">
                                            <div class="py-4">
                                                <span class="fs-18 d-block mb-3" style="color: #000000;">Hello Joanna!</span>
                                                <h3 class="fs-28 fw-900 mb-4" style="color: #000000;">Welcome To Your Beauty Lounge</h3>
                                                <p style="color: #3A4252 !important;">You have 15.7% more bookings today.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="p-3 pb-0 ps-0 text-end" style="margin-left: -50px;">
                                            <img src="/assets/images/beauty-salon.png" alt="beauty-salon">
                                        </div>
                                    </div>
                                </div>
                                <img src="/assets/images/shape-13.png" class="position-absolute top-0 start-0 p-5 px-4" alt="shape">
                            </div>
                        </div>
                        <div class="col-xxl-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <span class="fs-14 d-block mb-2">Customer Satisfaction Rate</span>
                                            <h2 class="fs-32 lh-1">88.5%</h2>
                                            <div style="margin: -6px 0 -11px 0;">
                                                <div id="customer_satisfaction_rate"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <span class="fs-14 d-block mb-2">New Customer This Month</span>
                                            <h2 class="fs-32 lh-1 mb-2">14.5K</h2>
                                            <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium mb-2">+7%</span>
                                            <p class="fs-12">vs previous 30 days</p>
                                            <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap align-items-center customer-join mt-5 pt-3">
                                                <li class="item">
                                                    <img src="/assets/images/user-82.png" alt="user">
                                                </li>
                                                <li class="item">
                                                    <img src="/assets/images/user-80.png" alt="user">
                                                </li>
                                                <li class="item p">
                                                    <span class="name">P</span>
                                                </li>
                                                <li class="item">
                                                    <img src="/assets/images/user-81.png" alt="user">
                                                </li>
                                                <li class="item s">
                                                    <span class="name">s</span>
                                                </li>
                                                <li class="item">
                                                    <img src="/assets/images/user-84.png" alt="user">
                                                </li>
                                                <li class="item count">
                                                    <span class="name">+24</span>
                                                </li>
                                            </ul>
                                            <h3 class="fs-12 fw-medium text-body mt-2 pt-1 mb-0">Joined Today</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-8">
                            <div class="bg-white p-4 rounded-3 mb-4 top-selling-products-for-dark">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 mb-lg-4">
                                    <h3 class="mb-0">Top Selling Products</h3>

                                    <div class="dropdown select-dropdown">
                                        <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            This Month
                                        </button>
                                      
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Day</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Week</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Month</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Year</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="position-relative">
                                    <div class="swiper top-selling-products-slide">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-29.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Hair Treatment</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">321</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 23.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-30.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Facial Kit</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">124</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 20.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-31.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Winter Cream</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">76</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 25.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-32.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Perfume</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">24</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 30.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-33.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Face Wash</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">12</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 15.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-34.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Glow Serum</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">23</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 45.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-29.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Hair Treatment</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">321</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 23.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-30.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Facial Kit</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">124</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 20.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-31.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Winter Cream</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">76</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 25.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-32.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Perfume</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">24</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 30.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-33.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Face Wash</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">12</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 15.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="/product-details" class="beauty-product d-block text-decoration-none">
                                                    <img src="/assets/images/product-34.png" class="mb-3 rounded-2" alt="product">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-2">
                                                        <h4 class="mb-0 fs-14 mb-0 fw-semibold">Glow Serum</h4>
                                                        <span class="d-inline-block bg-success-80 border-success-70 border px-2 rounded-pill text-success-50 fs-12 fw-medium">23</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-14 fw-semibold text-primary-60">$ 45.50</span>
                                                        <span class="fs-12">sold</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="nft-controller">
                                        <div class="controller-icon prev bg-primary" style="margin-left: -15px;">
                                            <i class="ri-arrow-left-line text-white"></i>
                                        </div>
                                        <div class="controller-icon next bg-primary" style="margin-right: -15px;">
                                            <i class="ri-arrow-right-line text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="mb-3 mb-lg-30 pb-2">
                                        <h3 class="mb-0">Customers From Channels</h3>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled last-child-none">
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/facebook.svg" style="width: 31px;" alt="facebook">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Facebook</h4>
                                                            <span class="fs-12">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #DDE4FF;" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 50%; height: 8px; background-color: #757DFF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">50%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/dribbble.svg" style="width: 31px;" alt="dribbble">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Dribbble</h4>
                                                            <span class="fs-12">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #DAEBFF;" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 75%; height: 8px; background-color: #5DA8FF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/instagram.svg" style="width: 31px;" alt="instagram">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Instagram</h4>
                                                            <span class="fs-12">Reel</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #FFE8D4;" role="progressbar" aria-label="Example with label" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 30%; height: 8px; background-color: #FE7A36;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">30%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/google2.svg" style="width: 31px;" alt="google">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Google</h4>
                                                            <span class="fs-12">SEO & PPC</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #D8FFC8;" role="progressbar" aria-label="Example with label" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 20%; height: 8px; background-color: #58F229;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">20%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                <h3 class="fs-18 mb-3 pb-1">Featured Services</h3>

                                <ul class="ps-0 mb-0 list-unstyled last-child-none">
                                    <li class="border-bottom pb-3 mb-3">
                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/featured-1.png" alt="featured">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-14 fw-semibold mb-0">Hair Cut</h4>
                                                    <span class="fs-12">132 Served this week</span>
                                                </div>
                                            </div>
                                            <span class="fs-12 fw-medium bg-primary bg-opacity-10 d-inline-block text-center text-primary rounded-circle" style="width: 20px; height: 20px; line-height: 20px;">01</span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-3">
                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/featured-2.png" alt="featured">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-14 fw-semibold mb-0">Manicure</h4>
                                                    <span class="fs-12">102 Served this week</span>
                                                </div>
                                            </div>
                                            <span class="fs-12 fw-medium bg-primary bg-opacity-10 d-inline-block text-center text-primary rounded-circle" style="width: 20px; height: 20px; line-height: 20px;">02</span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-3">
                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/featured-3.png" alt="featured">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-14 fw-semibold mb-0">Pedicure</h4>
                                                    <span class="fs-12">99 Served this week</span>
                                                </div>
                                            </div>
                                            <span class="fs-12 fw-medium bg-primary bg-opacity-10 d-inline-block text-center text-primary rounded-circle" style="width: 20px; height: 20px; line-height: 20px;">03</span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-3">
                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/featured-4.png" alt="featured">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-14 fw-semibold mb-0">Nail Art</h4>
                                                    <span class="fs-12">89 Served this week</span>
                                                </div>
                                            </div>
                                            <span class="fs-12 fw-medium bg-primary bg-opacity-10 d-inline-block text-center text-primary rounded-circle" style="width: 20px; height: 20px; line-height: 20px;">04</span>
                                        </div>
                                    </li>
                                    <li class="border-bottom pb-3 mb-3">
                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/featured-5.png" alt="featured">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-14 fw-semibold mb-0">Facial Treatment</h4>
                                                    <span class="fs-12">72 Served this week</span>
                                                </div>
                                            </div>
                                            <span class="fs-12 fw-medium bg-primary bg-opacity-10 d-inline-block text-center text-primary rounded-circle" style="width: 20px; height: 20px; line-height: 20px;">05</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="calendar-container">
                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3 mb-lg-30">
                                            <h3 class="fs-18 fw-semibold letter-spacing-1 mb-0">Recent Appointment</h3>
                                            <div>
                                                <div class="d-flex align-items-center bg-border-color py-2 px-3 rounded-2 for-dark-digital-date">
                                                    <div id="digital_date_schedule"></div>
                                                    <i class="ri-calendar-2-line ms-2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="calendar-header d-none">
                                                    <button id="prevMonth">Prev</button>
                                                    <select id="monthSelect"></select>
                                                    <select id="yearSelect"></select>
                                                    <button id="nextMonth">Next</button>
                                                </div>
                                                <table class="calendar-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sun</th>
                                                            <th>Mon</th>
                                                            <th>Tue</th>
                                                            <th>Wed</th>
                                                            <th>Thu</th>
                                                            <th>Fri</th>
                                                            <th>Sat</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="calendarBody">
                                                        <!-- Calendar days will be dynamically generated here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mt-4 mt-sm-0 today-appointments-for-dark" style="padding-left: 11px; max-height: 291px;" data-simplebar>
                                                    <div class="recent-appointment-for-rtl" style="border-left: 1px dashed #D5D9E2; padding-left: 37px;">
                                                        <div class="p-4 rounded-3 mb-4 position-relative" style="background-color: #DDE4FF;">
                                                            <div class="d-flex flex-wrap gap-1 justify-content-between align-items-start">
                                                                <div>
                                                                    <span class="text-dark fw-semibold d-block mb-1">10:00 AM</span>
                                                                    <h4 class="fs-14 text-body">Pedicure Treatment</h4>
                                                                </div>
                                                                <span class="bg-opacity-10 text-success-50 fs-12 px-2 rounded-pill d-inline-block" style="background-color: #D8FFC8; border: 1px solid #82FC5A;">Done</span>
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-1 justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-81.png" class="rounded-circle border border-2 border-color-white position-relative top-2" style="width: 26px; height: 26px;" alt="user">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <span class="fs-10 fw-medium">Client</span>
                                                                        <h4 class="fs-12 fw-semibold text-body mb-0">Jonathon Ronan</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-80.png" class="rounded-circle border border-2 border-color-white position-relative top-2" style="width: 26px; height: 26px;" alt="user">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <span class="fs-10 fw-medium">Served by</span>
                                                                        <h4 class="fs-12 fw-semibold text-body mb-0">Zinia Andy</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <img src="/assets/images/verify-3.svg" class="position-absolute top-50 start-0 translate-middle" style="left: -37px !important;" alt="verify">
                                                        </div>
                                                        <div class="p-4 rounded-3 mb-4 position-relative" style="background-color: #F3E8FF;">
                                                            <div class="d-flex flex-wrap gap-1 justify-content-between align-items-start">
                                                                <div>
                                                                    <span class="text-dark fw-semibold d-block mb-1">11:00 AM</span>
                                                                    <h4 class="fs-14 text-body">Facial Treatment</h4>
                                                                </div>
                                                                <span class="bg-opacity-10 fs-12 px-2 rounded-pill d-inline-block" style="background-color: #DDE4FF; border: 1px solid #9CAAFF; color: #3E2AD8;">Upcoming</span>
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-1 justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-106.png" class="rounded-circle border border-2 border-color-white position-relative top-2" style="width: 26px; height: 26px;" alt="user">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <span class="fs-10 fw-medium">Client</span>
                                                                        <h4 class="fs-12 fw-semibold text-body mb-0">Angela Carter</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-107.png" class="rounded-circle border border-2 border-color-white position-relative top-2" style="width: 26px; height: 26px;" alt="user">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <span class="fs-10 fw-medium">Served by</span>
                                                                        <h4 class="fs-12 fw-semibold text-body mb-0">Skyler White</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <img src="/assets/images/verify-border.svg" class="position-absolute top-50 start-0 translate-middle bg-white" style="left: -37px !important;" alt="verify-border">
                                                        </div>
                                                        <div class="p-4 rounded-3 mb-4 position-relative" style="background-color: #DDE4FF;">
                                                            <div class="d-flex flex-wrap gap-1 justify-content-between align-items-start">
                                                                <div>
                                                                    <span class="text-dark fw-semibold d-block mb-1">10:00 AM</span>
                                                                    <h4 class="fs-14 text-body">Pedicure Treatment</h4>
                                                                </div>
                                                                <span class="bg-opacity-10 text-success-50 fs-12 px-2 rounded-pill d-inline-block" style="background-color: #D8FFC8; border: 1px solid #82FC5A;">Done</span>
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-1 justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-81.png" class="rounded-circle border border-2 border-color-white position-relative top-2" style="width: 26px; height: 26px;" alt="user">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <span class="fs-10 fw-medium">Client</span>
                                                                        <h4 class="fs-12 fw-semibold text-body mb-0">Jonathon Ronan</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-80.png" class="rounded-circle border border-2 border-color-white position-relative top-2" style="width: 26px; height: 26px;" alt="user">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <span class="fs-10 fw-medium">Served by</span>
                                                                        <h4 class="fs-12 fw-semibold text-body mb-0">Zinia Andy</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <img src="/assets/images/verify-3.svg" class="position-absolute top-50 start-0 translate-middle" style="left: -37px !important;" alt="verify">
                                                        </div>
                                                        <div class="p-4 rounded-3 mb-4 position-relative" style="background-color: #F3E8FF;">
                                                            <div class="d-flex flex-wrap gap-1 justify-content-between align-items-start">
                                                                <div>
                                                                    <span class="text-dark fw-semibold d-block mb-1">11:00 AM</span>
                                                                    <h4 class="fs-14 text-body">Facial Treatment</h4>
                                                                </div>
                                                                <span class="bg-opacity-10 fs-12 px-2 rounded-pill d-inline-block" style="background-color: #DDE4FF; border: 1px solid #9CAAFF; color: #3E2AD8;">Upcoming</span>
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-1 justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-106.png" class="rounded-circle border border-2 border-color-white position-relative top-2" style="width: 26px; height: 26px;" alt="user">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <span class="fs-10 fw-medium">Client</span>
                                                                        <h4 class="fs-12 fw-semibold text-body mb-0">Angela Carter</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-107.png" class="rounded-circle border border-2 border-color-white position-relative top-2" style="width: 26px; height: 26px;" alt="user">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <span class="fs-10 fw-medium">Served by</span>
                                                                        <h4 class="fs-12 fw-semibold text-body mb-0">Skyler White</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <img src="/assets/images/verify-border.svg" class="position-absolute top-50 start-0 translate-middle bg-white" style="left: -37px !important;" alt="verify-border">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-8 col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Revenue By Services</h3>
                                        
                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                This Monthly
                                            </button>
                                          
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">This Day</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">This Week</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">This Month</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">This Year</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div style="margin: -24px -24px -20px -17px;">
                                        <div id="revenue_by_services"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-lg-5">
                            <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                <h3 class="mb-4">Top Stylist Performance</h3>

                                <div class="last-child-none">
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child border-bottom" style="margin-bottom: 14px; padding-bottom: 14px;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-108.png" class="rounded-3" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="fs-14 fw-semibold mb-0">Zinia Anderson</h4>
                                                <span class="fs-12"><span class="fw-bold">2032</span> Total Bookings</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <span class="fs-12 position-relative top-1">5.0</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child border-bottom" style="margin-bottom: 14px; padding-bottom: 14px;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-109.png" class="rounded-3" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="fs-14 fw-semibold mb-0">Angela Carter</h4>
                                                <span class="fs-12"><span class="fw-bold">1020</span> Total Bookings</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-half-line text-warning"></i> 
                                            <span class="fs-12 position-relative top-1">4.9</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child border-bottom" style="margin-bottom: 14px; padding-bottom: 14px;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-110.png" class="rounded-3" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="fs-14 fw-semibold mb-0">Skyler White</h4>
                                                <span class="fs-12"><span class="fw-bold">99</span> Total Bookings</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-half-line text-warning"></i>
                                            <span class="fs-12 position-relative top-1">4.8</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child border-bottom" style="margin-bottom: 14px; padding-bottom: 14px;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-111.png" class="rounded-3" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="fs-14 fw-semibold mb-0">Jane Ronan</h4>
                                                <span class="fs-12"><span class="fw-bold">89</span> Total Bookings</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-half-line text-warning"></i>
                                            <span class="fs-12 position-relative top-1">4.5</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child border-bottom" style="margin-bottom: 14px; padding-bottom: 14px;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-112.png" class="rounded-3" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="fs-14 fw-semibold mb-0">Angel Peril</h4>
                                                <span class="fs-12"><span class="fw-bold">72</span> Total Bookings</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-half-line text-warning"></i>
                                            <span class="fs-12 position-relative top-1">4.3</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-0">
                                <h3 class="mb-0">Top Customers</h3>

                                <div class="dropdown select-dropdown">
                                    <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        This Week
                                    </button>
                                  
                                    <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">This Day</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">This Week</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">This Month</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">This Year</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="default-table-area style-two campaigns-table top-customers-table">
                                <div class="table-responsive">
                                    <table class="table align-middle border-0">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th scope="col" class=" bg-transparent text-body fw-medium">
                                                    <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">ID</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">CUSTOMER NAME</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">PHONE NO</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">EMAIL</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">PROFFERED SERVICE</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">LAST VISIT</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">STATUS</span>
                                                </th>
                                                <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                    <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">ACTION</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50">#001</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-81.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Johhna Loren</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body-color-50">+321 427 8690</td>
                                                <td class="fs-12 fw-normal text-body">loren123@gmail.com</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">Nail Art</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">17 Oct, 2024</td>
                                                <td>
                                                    <span class="d-inline-block px-2 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">VIP</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown action-opt">
                                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="edit"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="eye"></i>
                                                                    View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="trash"></i>
                                                                    Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50">#002</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-80.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Skyler White</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body-color-50">+321 427 3980</td>
                                                <td class="fs-12 fw-normal text-body">skyqueen@gmail.com</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">Hair Cut</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">18 Oct, 2024</td>
                                                <td>
                                                    <span class="d-inline-block px-2 bg-primary bg-opacity-10 text-primary border border-primary rounded-pill fs-12 fw-medium">Royal</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown action-opt">
                                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="edit"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="eye"></i>
                                                                    View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="trash"></i>
                                                                    Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50">#003</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-82.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Jonathon Watson</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body-color-50">+321 427 1243</td>
                                                <td class="fs-12 fw-normal text-body">jona2134@gmail.com</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">Manicure</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">19 Oct, 2024</td>
                                                <td>
                                                    <span class="d-inline-block px-2 bg-primary bg-opacity-10 text-primary border border-primary rounded-pill fs-12 fw-medium">Royal</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown action-opt">
                                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="edit"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="eye"></i>
                                                                    View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="trash"></i>
                                                                    Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50">#004</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-83.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Walter White</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body-color-50">+321 427 7685</td>
                                                <td class="fs-12 fw-normal text-body">puzzleworld@gmail.com</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">Pedicure</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">21 Oct, 2024</td>
                                                <td>
                                                    <span class="d-inline-block px-2 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">VIP</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown action-opt">
                                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="edit"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="eye"></i>
                                                                    View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="trash"></i>
                                                                    Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50">#005</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-84.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">David Carlen</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body-color-50">+321 427 9021</td>
                                                <td class="fs-12 fw-normal text-body">liveslong@gmail.com</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">Facial</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">25 Oct, 2024</td>
                                                <td>
                                                    <span class="d-inline-block px-2 bg-primary bg-opacity-10 text-primary border border-primary rounded-pill fs-12 fw-medium">Royal</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown action-opt">
                                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="edit"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="eye"></i>
                                                                    View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;">
                                                                    <i data-feather="trash"></i>
                                                                    Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                    <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
    
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination mb-0 justify-content-center">
                                            <li class="page-item">
                                                <button class="page-link icon hover-bg" aria-label="Previous">
                                                    <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                </button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link active">1</button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link">2</button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link">3</button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link">4</button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link icon hover-bg" aria-label="Next">
                                                    <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                                </button>
                                            </li>
                                        </ul>
                                    </nav>
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
