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
                    <div class="border-0 rounded-3 bg-rating-color mb-4 p-25">
                        <div class="welcome-real-estate-agent">
                            <div class="row align-items-center g-4">
                                <div class="col-lg-6 text-center text-lg-start">
                                    <div class="mb-12 mt-8">
                                        <span class="fs-16 text-card-text-c fw-medium d-inline-block" style="background-color: #212529; padding: 1px 13px;">Hello Olivia!</span>
                                    </div>
                                    <h2 class="fs-32 text-white mx-auto ms-lg-0" style="letter-spacing: -.5px; max-width: 480px;">Welcome Back! Ready to Close More Deals Today?</h2>
                                </div>
                                <div class="col-lg-6 text-lg-end text-center">
                                    <img src="/assets/images/bank-real-estate.png" alt="bank-real-estate">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="welcome-card-wrap mb-4">
                        <div class="row justify-content-center g-4">
                            <div class="col-lg-3 col-sm-6">
                                <div class="card border-0 rounded-3 bg-white p-25">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-grow-1">
                                            <span class="d-block">Total Listings</span>
                                            <h3 class="fs-24 mt-6 mb-11 lh-1">3251</h3>
                                            <div>
                                                <span class="d-inline-block bg-success-80 border-success-60 border px-2 rounded-pill text-success-60 fs-12 fw-medium">+3.4%</span>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/building1.png" alt="building1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card border-0 rounded-3 bg-white p-25">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-grow-1">
                                            <span class="d-block">Sales Volume</span>
                                            <h3 class="fs-24 mt-6 mb-11 lh-1">$1.2M</h3>
                                            <div>
                                                <span class="d-inline-block bg-card-text-c border-danger-50 border px-2 rounded-pill text-danger-50 fs-12 fw-medium">-3.2%</span>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/building2.png" alt="building1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card border-0 rounded-3 bg-white p-25">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-grow-1">
                                            <span class="d-block">Active Deals</span>
                                            <h3 class="fs-24 mt-6 mb-11 lh-1">1124</h3>
                                            <div>
                                                <span class="d-inline-block bg-success-80 border-success-60 border px-2 rounded-pill text-success-60 fs-12 fw-medium">+1.4%</span>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/building3.png" alt="building1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card border-0 rounded-3 bg-white p-25">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-grow-1">
                                            <span class="d-block">Closed Deals</span>
                                            <h3 class="fs-24 mt-6 mb-11 lh-1">2312</h3>
                                            <div>
                                                <span class="d-inline-block bg-card-text-c border-danger-50 border px-2 rounded-pill text-danger-50 fs-12 fw-medium">-1.2%</span>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/building4.png" alt="building1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="p-25">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <div class="">
                                            <span class="d-block mb-10">Total Revenue</span>
                                            <div class="d-flex align-items-center" style="gap: 10px;">
                                                <h3 class="mb-0 fs-32 lh-1">$1,528</h3>
                                                <div>
                                                    <span class="d-inline-block bg-success-80 border-success-60 border px-2 rounded-pill text-success-60 fs-12 fw-medium">+5.4%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle border text-body rounded-2 bg-gray-100" data-bs-toggle="dropdown" aria-expanded="false">
                                                Monthly
                                            </button>
                                            
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Daily</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Weekly</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Monthly</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Yearly</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div style="margin: -20px 0 -20px -15px">
                                        <div id="real_total_revenue_chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 top-channels-for-dark">
                                <div class="card-body p-25">
                                    <div class="mb-4 d-flex justify-content-between align-items-center">
                                        <h3 class="mb-0">Top Channels</h3>
                                        <a href="#" class="text-decoration-none hover">Browse All<i class="ri-arrow-right-s-line fs-22 lh-1 position-relative top-3"></i></a>
                                    </div>
                                    <ul class="px-0 mb-0 list-unstyled last-child-none pt-1">
                                        <li class="mb-14 pb-14 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/facebook-real.svg" style="max-width: 25px;" alt="facebook">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold">Facebook</h4>
                                                            <span class="fs-12 d-block" style="margin-top: 2px;">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="ms-auto" style=" 
                                                        position: relative; 
                                                        width: 43px; 
                                                        height: 43px; 
                                                        border-radius: 50%; 
                                                        display: flex; 
                                                        align-items: center; 
                                                        justify-content: center; 
                                                        background: conic-gradient(#6f77f3 80%, #ffffff 80%);"
                                                    >
                                                        <div style="
                                                            position: absolute; 
                                                            width: 87%; 
                                                            height: 87%; 
                                                            background-color: #ffffff; 
                                                            border-radius: 50%; 
                                                            display: flex; 
                                                            align-items: center; 
                                                            justify-content: center;"
                                                        >
                                                            <p class="text-body" style="font-size: 10px;">80%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-14 pb-14 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/dribbble-real.svg" style="max-width: 25px;" alt="dribbble">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold">Dribbble</h4>
                                                            <span class="fs-12 d-block" style="margin-top: 2px;">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="ms-auto" style=" 
                                                        position: relative; 
                                                        width: 43px; 
                                                        height: 43px; 
                                                        border-radius: 50%; 
                                                        display: flex; 
                                                        align-items: center; 
                                                        justify-content: center; 
                                                        background: conic-gradient(#5ba5fa 75%, #ffffff 75%);"
                                                    >
                                                        <div style="
                                                            position: absolute; 
                                                            width: 87%; 
                                                            height: 87%;
                                                            background-color: #ffffff; 
                                                            border-radius: 50%; 
                                                            display: flex; 
                                                            align-items: center; 
                                                            justify-content: center;"
                                                        >
                                                            <p class="text-body" style="font-size: 10px;">75%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-14 pb-14 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/instagram-real.svg" style="max-width: 25px;" alt="instagram">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold">Instagram</h4>
                                                            <span class="fs-12 d-block" style="margin-top: 2px;">Reel</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="ms-auto" style=" 
                                                        position: relative; 
                                                        width: 43px; 
                                                        height: 43px; 
                                                        border-radius: 50%; 
                                                        display: flex; 
                                                        align-items: center; 
                                                        justify-content: center; 
                                                        background: conic-gradient(#fc7936 80%, #ffffff 80%);"
                                                    >
                                                        <div style="
                                                            position: absolute; 
                                                            width: 87%; 
                                                            height: 87%;
                                                            background-color: #ffffff; 
                                                            border-radius: 50%; 
                                                            display: flex; 
                                                            align-items: center; 
                                                            justify-content: center;"
                                                        >
                                                            <p class="text-body" style="font-size: 10px;">80%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-14 pb-14 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/google-real.svg" style="max-width: 25px;" alt="google">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold">Google</h4>
                                                            <span class="fs-12 d-block" style="margin-top: 2px;">SEO & PPC</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="ms-auto" style=" 
                                                        position: relative; 
                                                        width: 43px; 
                                                        height: 43px; 
                                                        border-radius: 50%; 
                                                        display: flex; 
                                                        align-items: center; 
                                                        justify-content: center; 
                                                        background: conic-gradient(#58f229 100%, #ffffff 100%);"
                                                    >
                                                        <div style="
                                                            position: absolute; 
                                                            width: 87%; 
                                                            height: 87%;
                                                            background-color: #ffffff; 
                                                            border-radius: 50%; 
                                                            display: flex; 
                                                            align-items: center; 
                                                            justify-content: center;"
                                                        >
                                                            <p class="text-body" style="font-size: 10px;">100%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-14 pb-14 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/figma-real.svg" style="max-width: 25px;" alt="google">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold">Figma</h4>
                                                            <span class="fs-12 d-block" style="margin-top: 2px;">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="ms-auto" style=" 
                                                        position: relative; 
                                                        width: 43px; 
                                                        height: 43px; 
                                                        border-radius: 50%; 
                                                        display: flex; 
                                                        align-items: center; 
                                                        justify-content: center; 
                                                        background: conic-gradient(#bf85fb 60%, #ffffff 60%);"
                                                    >
                                                        <div style="
                                                            position: absolute; 
                                                            width: 87%; 
                                                            height: 87%;
                                                            background-color: #ffffff; 
                                                            border-radius: 50%; 
                                                            display: flex; 
                                                            align-items: center; 
                                                            justify-content: center;"
                                                        >
                                                            <p class="text-body" style="font-size: 10px;">60%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-25">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <h3 class="mb-0">Recent Clients</h3>
                                        
                                        <div class="dropdown select-dropdown">
                                            <button class="bg-transparent border text-body rounded-2 p-0 border-0 dot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-2-fill" style="font-size: 22px;"></i>
                                            </button>
                                            
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3" style="width: 195px;">
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
                                    <ul class="ps-0 mb-0 list-unstyled pt-3 border-top">
                                        <li class="mb-12 pb-12 border-bottom d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center" style="gap: 14px;">
                                                <div class="flex-shrink-0 position-relative" style="top: -2px;">
                                                    <img src="/assets/images/user-177.png" style="max-width: 35px;" alt="user">
                                                    <div class="position-absolute bg-success-60 border border-1 border-white rounded-circle status-position2 bottom-0" style="width: 12px; height: 12px;"></div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="fs-14 fw-semibold mb-0">Johhna Loren</h4>
                                                    <span class="fs-12 d-block" style="margin-top: 2px;">Doctor</span>
                                                </div>
                                            </div>
                                            <a href="/profile" class="text-decoration-none">
                                                <i class="ri-arrow-right-line fs-18"></i>
                                            </a>
                                        </li>
                                        <li class="mb-12 pb-12 border-bottom d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center" style="gap: 14px;">
                                                <div class="flex-shrink-0 position-relative" style="top: -2px;">
                                                    <img src="/assets/images/user-157.png" style="max-width: 35px;" alt="user">
                                                    <div class="position-absolute bg-success-60 border border-1 border-white rounded-circle status-position2 bottom-0" style="width: 12px; height: 12px;"></div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="fs-14 fw-semibold mb-0">Zinia Watson</h4>
                                                    <span class="fs-12 d-block" style="margin-top: 2px;">Lawyer</span>
                                                </div>
                                            </div>
                                            <a href="/profile" class="text-decoration-none">
                                                <i class="ri-arrow-right-line fs-18"></i>
                                            </a>
                                        </li>
                                        <li class="mb-12 pb-12 border-bottom d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center" style="gap: 14px;">
                                                <div class="flex-shrink-0 position-relative" style="top: -2px;">
                                                    <img src="/assets/images/user-158.png" style="max-width: 35px;" alt="user">
                                                    <div class="position-absolute bg-success-60 border border-1 border-white rounded-circle status-position2 bottom-0" style="width: 12px; height: 12px;"></div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="fs-14 fw-semibold mb-0">Angela Carter</h4>
                                                    <span class="fs-12 d-block" style="margin-top: 2px;">Businesswoman</span>
                                                </div>
                                            </div>
                                            <a href="/profile" class="text-decoration-none">
                                                <i class="ri-arrow-right-line fs-18"></i>
                                            </a>
                                        </li>
                                        <li class="mb-12 pb-12 border-bottom d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center" style="gap: 14px;">
                                                <div class="flex-shrink-0 position-relative" style="top: -2px;">
                                                    <img src="/assets/images/user-159.png" style="max-width: 35px;" alt="user">
                                                    <div class="position-absolute bg-body-color-60 border border-1 border-white rounded-circle status-position2 bottom-0" style="width: 12px; height: 12px;"></div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="fs-14 fw-semibold mb-0">Skyler White</h4>
                                                    <span class="fs-12 d-block" style="margin-top: 2px;">Enterpreuner</span>
                                                </div>
                                            </div>
                                            <a href="/profile" class="text-decoration-none">
                                                <i class="ri-arrow-right-line fs-18"></i>
                                            </a>
                                        </li>
                                        <li class="mb-12 pb-12 border-bottom d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center" style="gap: 14px;">
                                                <div class="flex-shrink-0 position-relative" style="top: -2px;">
                                                    <img src="/assets/images/user-160.png" style="max-width: 35px;" alt="user">
                                                    <div class="position-absolute bg-success-60 border border-1 border-white rounded-circle status-position2 bottom-0" style="width: 12px; height: 12px;"></div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="fs-14 fw-semibold mb-0">Jane Ronan</h4>
                                                    <span class="fs-12 d-block" style="margin-top: 2px;">Editor</span>
                                                </div>
                                            </div>
                                            <a href="/profile" class="text-decoration-none">
                                                <i class="ri-arrow-right-line fs-18"></i>
                                            </a>
                                        </li>
                                        <li class="mb-0 pb-12 border-bottom d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center" style="gap: 14px;">
                                                <div class="flex-shrink-0 position-relative" style="top: -2px;">
                                                    <img src="/assets/images/user-154.png" style="max-width: 35px;" alt="user">
                                                    <div class="position-absolute bg-body-color-60 border border-1 border-white rounded-circle status-position2 bottom-0" style="width: 12px; height: 12px;"></div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="fs-14 fw-semibold mb-0">Viktor James</h4>
                                                    <span class="fs-12 d-block" style="margin-top: 2px;">Editor</span>
                                                </div>
                                            </div>
                                            <a href="/profile" class="text-decoration-none">
                                                <i class="ri-arrow-right-line fs-18"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="border-0 rounded-3 position-relative z-1 p-25 bg-card-text-c my-featured-listings-bg">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-1 mb-4">
                                    <h3 class="mb-0">My Featured Listings</h3>
                                    <div class="">
                                        <div class="swiper-pagination-my-featured-listings"></div>
                                    </div>
                                </div>
                                
                                <div class="swiper my-featured-listings-slide">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <a href="/property-details" class="text-decoration-none position-relative d-block">
                                                <div class="position-relative z-1 bg-img rounded-top-2" style="background-image: url(/assets/images/property-1.jpg); height: 202px;">
                                                    <div class="position-absolute top-0 start-0 m-2">
                                                        <span class="d-inline-block bg-card-text-c px-2 rounded-1 text-danger-50 fs-12 fw-medium" style="padding-top: 3px; padding-bottom: 3px;">For Rent</span>
                                                    </div>
                                                </div>
        
                                                <div class="bg-white rounded-bottom-2" style="padding: 20px;">
                                                    <h3 class="fs-16 fw-semibold mb-6">Luxury Comfort Villa</h3>
                                                    <span class="text-body">London, United Kingdom</span>

                                                    <ul class="px-0 pb-13 mb-13 border-bottom mt-13 list-unstyled d-flex justify-content-between align-items-center">
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">open_run </i>
                                                            <span>425 Sft</span>
                                                        </li>
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">bed </i>
                                                            <span>3 Bed</span>
                                                        </li>
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">bathtub </i>
                                                            <span>2 Bath</span>
                                                        </li>
                                                    </ul>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h3 class="mb-0">$4,274/m</h3>
                                                        <i class="ri-arrow-right-line wh-30 d-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg lh-1"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="swiper-slide">
                                            <a href="/property-details" class="text-decoration-none position-relative d-block">
                                                <div class="position-relative z-1 bg-img rounded-top-2" style="background-image: url(/assets/images/property-2.jpg); height: 202px;">
                                                    <div class="position-absolute top-0 start-0 m-2">
                                                        <span class="d-inline-block bg-card-text-c px-2 rounded-1 text-danger-50 fs-12 fw-medium" style="padding-top: 3px; padding-bottom: 3px;">For Rent</span>
                                                    </div>
                                                </div>
        
                                                <div class="bg-white rounded-bottom-2" style="padding: 20px;">
                                                    <h3 class="fs-16 fw-semibold mb-6">White House Villa</h3>
                                                    <span class="text-body">New Castle, United Kingdom</span>

                                                    <ul class="px-0 pb-13 mb-13 border-bottom mt-13 list-unstyled d-flex justify-content-between align-items-center">
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">open_run </i>
                                                            <span>321 Sft</span>
                                                        </li>
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">bed </i>
                                                            <span>2 Bed</span>
                                                        </li>
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">bathtub </i>
                                                            <span>1 Bath</span>
                                                        </li>
                                                    </ul>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h3 class="mb-0">$4,274/m</h3>
                                                        <i class="ri-arrow-right-line wh-30 d-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg lh-1"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="swiper-slide">
                                            <a href="/property-details" class="text-decoration-none position-relative d-block">
                                                <div class="position-relative z-1 bg-img rounded-top-2" style="background-image: url(/assets/images/property-1.jpg); height: 202px;">
                                                    <div class="position-absolute top-0 start-0 m-2">
                                                        <span class="d-inline-block bg-card-text-c px-2 rounded-1 text-danger-50 fs-12 fw-medium" style="padding-top: 3px; padding-bottom: 3px;">For Rent</span>
                                                    </div>
                                                </div>
        
                                                <div class="bg-white rounded-bottom-2" style="padding: 20px;">
                                                    <h3 class="fs-16 fw-semibold mb-6">Luxury Comfort Villa</h3>
                                                    <span class="text-body">London, United Kingdom</span>

                                                    <ul class="px-0 pb-13 mb-13 border-bottom mt-13 list-unstyled d-flex justify-content-between align-items-center">
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">open_run </i>
                                                            <span>425 Sft</span>
                                                        </li>
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">bed </i>
                                                            <span>3 Bed</span>
                                                        </li>
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">bathtub </i>
                                                            <span>2 Bath</span>
                                                        </li>
                                                    </ul>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h3 class="mb-0">$4,274/m</h3>
                                                        <i class="ri-arrow-right-line wh-30 d-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg lh-1"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="swiper-slide">
                                            <a href="/property-details" class="text-decoration-none position-relative d-block">
                                                <div class="position-relative z-1 bg-img rounded-top-2" style="background-image: url(/assets/images/property-2.jpg); height: 202px;">
                                                    <div class="position-absolute top-0 start-0 m-2">
                                                        <span class="d-inline-block bg-card-text-c px-2 rounded-1 text-danger-50 fs-12 fw-medium" style="padding-top: 3px; padding-bottom: 3px;">For Rent</span>
                                                    </div>
                                                </div>
        
                                                <div class="bg-white rounded-bottom-2" style="padding: 20px;">
                                                    <h3 class="fs-16 fw-semibold mb-6">White House Villa</h3>
                                                    <span class="text-body">New Castle, United Kingdom</span>

                                                    <ul class="px-0 pb-13 mb-13 border-bottom mt-13 list-unstyled d-flex justify-content-between align-items-center">
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">open_run </i>
                                                            <span>321 Sft</span>
                                                        </li>
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">bed </i>
                                                            <span>2 Bed</span>
                                                        </li>
                                                        <li class="d-flex align-items-center gap-1 text-body">
                                                            <i class="material-symbols-outlined fs-18">bathtub </i>
                                                            <span>1 Bath</span>
                                                        </li>
                                                    </ul>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h3 class="mb-0">$4,274/m</h3>
                                                        <i class="ri-arrow-right-line wh-30 d-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg lh-1"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="p-25">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <h3 class="mb-0">Revenue Goal Progress</h3>

                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle border text-body rounded-2 bg-gray-100" data-bs-toggle="dropdown" aria-expanded="false">
                                                Monthly
                                            </button>
                                            
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Daily</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Weekly</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Monthly</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Yearly</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div style="margin: -20px 0 -25px -15px;">
                                        <div id="real_revenue_goal_progress_chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <h3 class="mb-0">Sales By Country</h3>
                                        <div class="dropdown select-dropdown">
                                            <button class="bg-transparent border text-body rounded-2 p-0 border-0 dot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-2-fill" style="font-size: 22px;"></i>
                                            </button>
                                            
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3" style="width: 195px;">
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
                                    <div class="ext-center" style="margin: 31px 0;">
                                        <div id="sales_by_country_map"></div>
                                    </div>
                                    <ul class="px-0 mb-0 list-unstyled border-top border-bottom pt-12 pb-12">
                                        <li class="mb-12 pb-12 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <img src="/assets/images/portugal.svg" style="width: 24px;" alt="united-states">
                                                        <h4 class="mb-0 fs-14 fw-medium lh-1 text-body">Portugal</h4>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 5px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 85%; height: 5px; background-color: #757DFF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">85%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-12 pb-12 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <img src="/assets/images/germany.svg" style="width: 24px;" alt="germany">
                                                        <h4 class="mb-0 fs-14 fw-medium lh-1 text-body">Germany</h4>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 5px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 65%; height: 5px; background-color: #0F79F3;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">65%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-12 pb-12 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <img src="/assets/images/spain.svg" style="width: 24px;" alt="spain">
                                                        <h4 class="mb-0 fs-14 fw-medium lh-1 text-body">Spain</h4>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 5px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 45%; height: 5px; background-color: #9135E8;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">45%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <img src="/assets/images/canada.svg" style="width: 24px;" alt="canada">
                                                        <h4 class="mb-0 fs-14 fw-medium lh-1 text-body">Canada</h4>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 5px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 75%; height: 5px; background-color: #25B003;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-lg-3">
                            <div class="rounded-3 p-25 manage-app-for-dark" style="background-color: #b2ff97;">
                                <div class="mx-auto py-sm-4 my-1" style="max-width: 210px;">
                                    <h2 class="fs-24 text-secondary mb-20">Manage Your Dashboard From Your Mobile</h2>
                                    <a href="/real-estate-agent" class="app-btn">
                                        Download App
                                    </a>
                                    <div class="text-center">
                                        <img src="/assets/images/saas.png" alt="saas">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-20">
                                        <h3 class="mb-0">Latest Transactions</h3>
                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle border text-body rounded-2 bg-gray-100" data-bs-toggle="dropdown" aria-expanded="false">
                                                Monthly
                                            </button>
                                            
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Daily</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Weekly</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Monthly</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Yearly</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="default-table-area style-two campaigns-table px-20 py-12 latest-transactions-table">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class="bg-transparent">
                                                            <span class="fs-10 text-body fw-semibold letter-spacing-1">CLIENT</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent">
                                                            <span class="fs-10 text-body fw-semibold letter-spacing-1">EMAIL</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent">
                                                            <span class="fs-10 text-body fw-semibold letter-spacing-1">AMOUNT</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent">
                                                            <span class="fs-10 text-body fw-semibold letter-spacing-1">PAYMENT METHOD</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent">
                                                            <span class="fs-10 text-body fw-semibold letter-spacing-1">STATUS</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-166.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Johhna Loren</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">loren123@gmail.com</td>
                                                        <td class="fs-12 fw-semibold text-secondary">$6240</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/paypal.png" alt="paypal">
                                                                <span class="ms-2 text-secondary fs-12 fw-semibold">Paypal</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-10 border-success-60 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 1px 10px;">Completed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-170.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Skyler Queen</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">skyqueen@gmail.com</td>
                                                        <td class="fs-12 fw-semibold text-secondary">$5135</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/wise.png" alt="wise">
                                                                <span class="ms-2 text-secondary fs-12 fw-semibold">Wise</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="d-inline-block bg-card-bg-c bg-opacity-10 border-card-bg-c border rounded-pill text-card-bg-c fs-12 fw-medium" style="padding: 1px 10px;">Pending</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-172.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Jonathon Watson</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">jona2134@gmail.com</td>
                                                        <td class="fs-12 fw-semibold text-secondary">$4321</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/bank.png" alt="bank">
                                                                <span class="ms-2 text-secondary fs-12 fw-semibold">Bank</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="d-inline-block bg-danger-80 bg-opacity-10 border-danger-80 border rounded-pill text-danger-80 fs-12 fw-medium" style="padding: 1px 10px;">Failed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-171.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Walter White</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">puzzleworld@gmail.com</td>
                                                        <td class="fs-12 fw-semibold text-secondary">$3124</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/paypal.png" alt="paypal">
                                                                <span class="ms-2 text-secondary fs-12 fw-semibold">Paypal</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-10 border-success-60 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 1px 10px;">Completed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-166.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">David Carlen</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">liveslong@gmail.com</td>
                                                        <td class="fs-12 fw-semibold text-secondary">$2137</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/skrill.png" alt="skrill">
                                                                <span class="ms-2 text-secondary fs-12 fw-semibold">Skrill</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="d-inline-block bg-card-bg-c bg-opacity-10 border-card-bg-c border rounded-pill text-card-bg-c fs-12 fw-medium" style="padding: 1px 10px;">Pending</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-12">
                                            <span class="fs-12 fw-medium">Showing 5 of 36 Results</span>
            
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
                    </div>
                    <div class="bg-white border-0 rounded-3 mb-4 client-ratings-bg ">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                <h3 class="mb-0">Client Ratings</h3>
                                <div class="dropdown select-dropdown">
                                    <button class="dropdown-toggle border text-body rounded-2 bg-gray-100" data-bs-toggle="dropdown" aria-expanded="false">
                                        Top Rated
                                    </button>
                                    
                                    <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">Top Rated</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">Latest</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">Oldest</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="swiper client-ratings-slide">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="border-0 rounded-3 bg-border-color-50 p-25">
                                            <div class="d-flex align-items-center mb-4" style="gap: 12px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-182.jpg" style="width: 38px; height: 38px; top: -2px;" class="rounded-circle position-relative" alt="user">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-semibold fs-14" style="margin-bottom: 3px;">David Carlen</h6>
                                                    <span class="fs-12 text-body">New Castle, United Kingdom</span>
                                                </div>
                                            </div>
                                            <p class="fs-16 text-secondary mb-20" style="line-height: 1.5;">“Working with William was an absolute pleasure. His market knowledge and attention to detail helped us sell our home quickly and at a great price.” </p>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center" style="gap: 1px;">
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <span class="fs-12" style="margin-left: 2px;">5.0</span>
                                                </div>
                                                <i class="ri-double-quotes-r fs-30 text-white lh-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="border-0 rounded-3 bg-danger-100 p-25">
                                            <div class="d-flex align-items-center mb-4" style="gap: 12px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-183.jpg" style="width: 38px; height: 38px; top: -2px;" class="rounded-circle position-relative" alt="user">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-semibold fs-14" style="margin-bottom: 3px;">Zinia Anderson</h6>
                                                    <span class="fs-12 text-body">New Brunchwick, Canada</span>
                                                </div>
                                            </div>
                                            <p class="fs-16 text-secondary mb-20" style="line-height: 1.5;"> “William’s professionalism and responsiveness set him apart from other agents. He listened, and delivered outstanding results.” </p>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center" style="gap: 1px;">
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-half-line text-danger lh-1"></i>
                                                    <span class="fs-12" style="margin-left: 2px;">4.5</span>
                                                </div>
                                                <i class="ri-double-quotes-r fs-30 text-white lh-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="border-0 rounded-3 bg-success-90 p-25">
                                            <div class="d-flex align-items-center mb-4" style="gap: 12px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-184.jpg" style="width: 38px; height: 38px; top: -2px;" class="rounded-circle position-relative" alt="user">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-semibold fs-14" style="margin-bottom: 3px;">Walter White</h6>
                                                    <span class="fs-12 text-body">New York, USA</span>
                                                </div>
                                            </div>
                                            <p class="fs-16 text-secondary mb-20" style="line-height: 1.5;">“Thanks to William, I felt confident every step of the way during my first home purchase. His friendly demeanor and expert advice helped us.” </p>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center" style="gap: 1px;">
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-line text-danger lh-1"></i>
                                                    <span class="fs-12" style="margin-left: 2px;">4.0</span>
                                                </div>
                                                <i class="ri-double-quotes-r fs-30 text-white lh-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="border-0 rounded-3 bg-border-color-50 p-25">
                                            <div class="d-flex align-items-center mb-4" style="gap: 12px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-182.jpg" style="width: 38px; height: 38px; top: -2px;" class="rounded-circle position-relative" alt="user">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-semibold fs-14" style="margin-bottom: 3px;">David Carlen</h6>
                                                    <span class="fs-12 text-body">New Castle, United Kingdom</span>
                                                </div>
                                            </div>
                                            <p class="fs-16 text-secondary mb-20" style="line-height: 1.5;">“Working with William was an absolute pleasure. His market knowledge and attention to detail helped us sell our home quickly and at a great price.” </p>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center" style="gap: 1px;">
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <span class="fs-12" style="margin-left: 2px;">5.0</span>
                                                </div>
                                                <i class="ri-double-quotes-r fs-30 text-white lh-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="border-0 rounded-3 bg-danger-100 p-25">
                                            <div class="d-flex align-items-center mb-4" style="gap: 12px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-183.jpg" style="width: 38px; height: 38px; top: -2px;" class="rounded-circle position-relative" alt="user">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-semibold fs-14" style="margin-bottom: 3px;">Zinia Anderson</h6>
                                                    <span class="fs-12 text-body">New Brunchwick, Canada</span>
                                                </div>
                                            </div>
                                            <p class="fs-16 text-secondary mb-20" style="line-height: 1.5;"> “William’s professionalism and responsiveness set him apart from other agents. He listened, and delivered outstanding results.” </p>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center" style="gap: 1px;">
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-half-line text-danger lh-1"></i>
                                                    <span class="fs-12" style="margin-left: 2px;">4.5</span>
                                                </div>
                                                <i class="ri-double-quotes-r fs-30 text-white lh-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="border-0 rounded-3 bg-success-90 p-25">
                                            <div class="d-flex align-items-center mb-4" style="gap: 12px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-184.jpg" style="width: 38px; height: 38px; top: -2px;" class="rounded-circle position-relative" alt="user">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-semibold fs-14" style="margin-bottom: 3px;">Walter White</h6>
                                                    <span class="fs-12 text-body">New York, USA</span>
                                                </div>
                                            </div>
                                            <p class="fs-16 text-secondary mb-20" style="line-height: 1.5;">“Thanks to William, I felt confident every step of the way during my first home purchase. His friendly demeanor and expert advice helped us.” </p>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center" style="gap: 1px;">
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-fill text-danger lh-1"></i>
                                                    <i class="ri-star-line text-danger lh-1"></i>
                                                    <span class="fs-12" style="margin-left: 2px;">4.0</span>
                                                </div>
                                                <i class="ri-double-quotes-r fs-30 text-white lh-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-pagination-client-ratings text-center mt-4 lh-1"></div>
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
