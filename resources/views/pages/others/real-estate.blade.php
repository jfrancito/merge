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
                        <div class="col-xxl-4">
                            <div class="row">
                                <div class="col-md-6 col-xxl-12">
                                    <div class="border-0 rounded-3 position-relative mb-4 overflow-hidden" style="background: linear-gradient(101deg, #FE7A36 0%, #FD5812 100%);">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <div class="p-4 pe-0">
                                                    <span class="text-white d-block mb-2">Active Total Property</span>
                                                    <h3 class="fs-20 text-white">507,020</h3>
                                                </div>
                                            </div>
                                            <div class="col-sm-5 mt-md-3 mt-xxl-0">
                                                <div class="pt-sm-4 mt-sm-3 text-end">
                                                    <img src="/assets/images/real-property.png" style="width: 188px; height: 125px;" alt="real-property">
                                                    <img src="/assets/images/shape-9.png" class="position-absolute bottom-0 start-0" alt="shape">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xxl-12">
                                    <div class="card rounded-3 bg-white border-0 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 me-3">
                                                    <div class="d-flex align-items-start">
                                                        <div class="me-4">
                                                            <span class="d-block mb-2">Revenue</span>
                                                            <h3 class="mb-0 fs-20">$194,712</h3>
                                                        </div>
                                                        <span class="d-inline-block border-success border bg-success bg-opacity-10 text-success px-2 rounded-pill fs-12 fw-medium position-relative top-4">+ 60%</span>
                                                    </div>
                                                </div>
        
                                                <div class="flex-shrink-0">
                                                    <span class="fs-12">Last 7 days</span>
                                                </div>
                                            </div>
                                            <div style="margin: -26px -23px -25px -22px;">
                                                <div id="property_revenue"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0 position-relative z-1">New Listings vs Sold Properties</h3>
                                        <select class="form-select month-select form-control position-relative z-1" aria-label="Default select example">
                                            <option selected>Monthly</option>
                                            <option value="1">Weekly</option>
                                            <option value="2">Today</option>
                                            <option value="3">Yearly</option>
                                        </select>
                                    </div>

                                    <div style="margin: -25px -9px -20px -18px;">
                                        <div id="new_listings_vs_sold_properties"></div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="d-inline-block border-success border bg-success bg-opacity-10 text-success rounded-pill fs-12 fw-medium px-2">+ 75%</span>
                                        <span class="fs-12">Last 30 days</span>
                                    </div>
                                    <div class="row align-items-end">
                                        <div class="col-sm-6">
                                            <span class="d-block mb-2">Properties for Sale</span>
                                            <h3 class="mb-0 fs-20 mb-0">5,458</h3>
                                        </div>
                                        <div class="col-sm-6">
                                            <div style="margin: -36px 0 -36px 0;">
                                                <div id="properties_for_sale" class="mt-4 mt-sm-0"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="d-inline-block border-success border bg-success bg-opacity-10 text-success rounded-pill fs-12 fw-medium px-2">+ 35%</span>
                                        <span class="fs-12">Last 30 days</span>
                                    </div>
                                    <div class="row align-items-end">
                                        <div class="col-sm-6">
                                            <span class="d-block mb-2">Properties for Rent</span>
                                            <h3 class="mb-0 fs-20 mb-0">2,510</h3>
                                        </div>
                                        <div class="col-sm-6">
                                            <div style="margin: -36px 0 -36px 0;">
                                                <div id="properties_for_rent" class="mt-4 mt-sm-0"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="bg-white rounded-3 mb-4" style="background: linear-gradient(73deg, #23272E 0%, #343A46 100%);">
                                <div class="card-body p-4">
                                    <div class="mb-3 pb-2">
                                        <span class="d-block mb-2" style="color: #8695AA;">New Customers This Month</span>
                                        <h3 class="text-white mb-0 fs-20">4,712</h3>
                                    </div>

                                    <span class="d-block mb-2" style="color: #8695AA;">Join Today</span>

                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                        <li>
                                            <a href="/my-profile">
                                                <img src="/assets/images/user-63.jpg" style="width: 40px; height: 40px;" class="rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="/my-profile">
                                                <img src="/assets/images/user-64.jpg" style="width: 40px; height: 40px;" class="rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="/my-profile">
                                                <img src="/assets/images/user-65.jpg" style="width: 40px; height: 40px;" class="rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="/my-profile">
                                                <img src="/assets/images/user-66.jpg" style="width: 40px; height: 40px;" class="rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="/user-list" class="rounded-circle d-block text-center text-decoration-none text-white fs-14 fw-bold border border-1 border-color-white" style="background-color: #FE7A36; width: 40px; height: 40px; line-height: 40px;">59</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xxl-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Most Sales Location</h3>

                                        <div class="dropdown action-opt">
                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-horizontal"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="clock"></i>
                                                        Today
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="pie-chart"></i>
                                                        Last 7 Days
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="rotate-cw"></i>
                                                        Last Month
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="calendar"></i>
                                                        Last 1 Year
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="bar-chart"></i>
                                                        All Time
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
                                    </div>
                                    <div class="text-center" style="margin: 38px 0;">
                                        <div id="most_sales_location"></div>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled sales_by_locations mt-4">
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/usa.svg" class="wh-30 rounded-circle" alt="usa">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">United States</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 85%">
                                                        <span class="count fw-medium text-body">85%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/germany.svg" class="wh-30 rounded-circle" alt="germany">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">Germany</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-danger" style="width: 75%">
                                                        <span class="count fw-medium text-body">75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/united-kingdom.svg" class="wh-30 rounded-circle" alt="united-kingdom">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">United Kingdom</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-success" style="width: 40%">
                                                        <span class="count fw-medium text-body">40%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/canada.svg" class="wh-30 rounded-circle" alt="canada">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">Canada</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-primary-div" style="width: 10%">
                                                        <span class="count fw-medium text-body">10%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/portugal.svg" class="wh-30 rounded-circle" alt="portugal">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">Portugal</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="05" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 05%">
                                                        <span class="count fw-medium text-body">05%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/spain.svg" class="wh-30 rounded-circle" alt="spain">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">Spain</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-secondary bg-opacity-50" style="width: 15%">
                                                        <span class="count fw-medium text-body">15%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card bg-primary-div bg-opacity-10 border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Recent Property</h3>
                                        <div class="swiper-pagination3 text-end" style="width: 100px;"></div>
                                    </div>

                                    <div class="swiper recent-property-slide">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide bg-white p-2 rounded-3">
                                                <img src="/assets/images/property-5.png" class="rounded-3" alt="property">

                                                <div class="mt-3">
                                                    <h3 class="mb-2">$800,000</h3>
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-2">
                                                        <span>35 Prince Consort Road</span>
                                                        <a href="#" class="fs-14 text-primary fw-medium text-decoration-none">View More</a>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-hotel-bed-line fs-18 text-primary"></i>
                                                            <span class="ms-2">6 Bed</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-showers-line fs-18 text-primary"></i>
                                                            <span class="ms-2">5 Bath</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-square-line fs-18 text-primary"></i>
                                                            <span class="ms-2">5 Bath</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide bg-white p-2 rounded-3">
                                                <img src="/assets/images/property-6.png" class="rounded-3" alt="property">

                                                <div class="mt-3">
                                                    <h3 class="mb-2">$220,000</h3>
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-2">
                                                        <span>58 Gateway Road Portland</span>
                                                        <a href="#" class="fs-14 text-primary fw-medium text-decoration-none">View More</a>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-hotel-bed-line fs-18 text-primary"></i>
                                                            <span class="ms-2">8 Bed</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-showers-line fs-18 text-primary"></i>
                                                            <span class="ms-2">6 Bath</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-square-line fs-18 text-primary"></i>
                                                            <span class="ms-2">2000 sqft</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide bg-white p-2 rounded-3">
                                                <img src="/assets/images/property-5.png" class="rounded-3" alt="property">

                                                <div class="mt-3">
                                                    <h3 class="mb-2">$800,000</h3>
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-2">
                                                        <span>35 Prince Consort Road</span>
                                                        <a href="#" class="fs-14 text-primary fw-medium text-decoration-none">View More</a>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-hotel-bed-line fs-18 text-primary"></i>
                                                            <span class="ms-2">6 Bed</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-showers-line fs-18 text-primary"></i>
                                                            <span class="ms-2">5 Bath</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-square-line fs-18 text-primary"></i>
                                                            <span class="ms-2">5 Bath</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide bg-white p-2 rounded-3">
                                                <img src="/assets/images/property-6.png" class="rounded-3" alt="property">

                                                <div class="mt-3">
                                                    <h3 class="mb-2">$220,000</h3>
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-2">
                                                        <span>58 Gateway Road Portland</span>
                                                        <a href="#" class="fs-14 text-primary fw-medium text-decoration-none">View More</a>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-hotel-bed-line fs-18 text-primary"></i>
                                                            <span class="ms-2">8 Bed</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-showers-line fs-18 text-primary"></i>
                                                            <span class="ms-2">6 Bath</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-square-line fs-18 text-primary"></i>
                                                            <span class="ms-2">2000 sqft</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Rental Income</h3>

                                        <div class="dropdown action-opt">
                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-horizontal"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="clock"></i>
                                                        Today
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="pie-chart"></i>
                                                        Last 7 Days
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="rotate-cw"></i>
                                                        Last Month
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="calendar"></i>
                                                        Last 1 Year
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="bar-chart"></i>
                                                        All Time
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
                                    </div>

                                    <div style="margin: -25px -21px -28px -18px;">
                                        <div id="rental_income"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <h3 class="mb-0">Social Search</h3>
                                                <span>Total Traffic In This Week</span>
                                            </div>

                                            <div style="margin: -20px 0 -22px 0;">
                                                <div id="social_search"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                                <h3 class="mb-0">Top Property</h3>
        
                                                <div class="dropdown action-opt">
                                                    <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i data-feather="more-horizontal"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="clock"></i>
                                                                Today
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="pie-chart"></i>
                                                                Last 7 Days
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="rotate-cw"></i>
                                                                Last Month
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="calendar"></i>
                                                                Last 1 Year
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="bar-chart"></i>
                                                                All Time
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
                                            </div>

                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/property-1.png" class="rounded-3" style="width: 40px; height: 40px;" alt="property">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-16 mb-0">Industrial</h4>
                                                    <span>36 Clay Street Indianapolis</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/property-2.png" class="rounded-3" style="width: 40px; height: 40px;" alt="property">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-16 mb-0">Office</h4>
                                                    <span>07 Maple Street Los Angeles</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/property-3.png" class="rounded-3" style="width: 40px; height: 40px;" alt="property">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-16 mb-0">Multi-Family</h4>
                                                    <span>94 Brooke Street Houston</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/property-4.png" class="rounded-3" style="width: 40px; height: 40px;" alt="property">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-16 mb-0">Retail</h4>
                                                    <span>84 Pick Street Centennial</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                                <h3 class="mb-0">Customer Reviews</h3>

                                                <div class="dropdown action-opt">
                                                    <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i data-feather="more-horizontal"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="clock"></i>
                                                                Today
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="pie-chart"></i>
                                                                Last 7 Days
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="rotate-cw"></i>
                                                                Last Month
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="calendar"></i>
                                                                Last 1 Year
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="bar-chart"></i>
                                                                All Time
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
                                            </div>

                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-48.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between">
                                                            <div>
                                                                <h4 class="fs-15 mb-0 fw-semibold">Irene George</h4>
                                                                <span class="fs-12">15m ago</span>
                                                            </div>
                                                            <div class="d-flex gap-1">
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="fs-12" style="line-height: 1.4;">"Great service! Found exactly what I needed for my property, and the process was smooth and hassle-free."</p>
                                            </div>
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-49.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between">
                                                            <div>
                                                                <h4 class="fs-15 mb-0 fw-semibold">Irene George</h4>
                                                                <span class="fs-12">15m ago</span>
                                                            </div>
                                                            <div class="d-flex gap-1">
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-line text-warning fs-16"></i>
                                                                <i class="ri-star-line text-warning fs-16"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="fs-12" style="line-height: 1.4;">"Great service! Found exactly what I needed for my property, and the process was smooth and hassle-free."</p>
                                            </div>
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-50.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between">
                                                            <div>
                                                                <h4 class="fs-15 mb-0 fw-semibold">Irene George</h4>
                                                                <span class="fs-12">15m ago</span>
                                                            </div>
                                                            <div class="d-flex gap-1">
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="fs-12" style="line-height: 1.4;">"Great service! Found exactly what I needed for my property, and the process was smooth and hassle-free."</p>
                                            </div>
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-51.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between">
                                                            <div>
                                                                <h4 class="fs-15 mb-0 fw-semibold">Irene George</h4>
                                                                <span class="fs-12">15m ago</span>
                                                            </div>
                                                            <div class="d-flex gap-1">
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-line text-warning fs-16"></i>
                                                                <i class="ri-star-line text-warning fs-16"></i>
                                                                <i class="ri-star-line text-warning fs-16"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="fs-12" style="line-height: 1.4;">"Great service! Found exactly what I needed for my property, and the process was smooth and hassle-free."</p>
                                            </div>
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-52.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between">
                                                            <div>
                                                                <h4 class="fs-15 mb-0 fw-semibold">Irene George</h4>
                                                                <span class="fs-12">15m ago</span>
                                                            </div>
                                                            <div class="d-flex gap-1">
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-fill text-warning fs-16"></i>
                                                                <i class="ri-star-line text-warning fs-16"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="fs-12" style="line-height: 1.4;">"Great service! Found exactly what I needed for my property, and the process was smooth and hassle-free."</p>
                                            </div>

                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/real-estate" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/real-estate">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/real-estate">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/real-estate">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/real-estate">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/real-estate" aria-label="Next">
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
                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-4">
                                <h3 class="mb-0">Latest Transaction</h3>
                                <select class="form-select month-select form-control w-135 bg-border-color border-color bg-transparent" aria-label="Default select example">
                                    <option selected="">Last 30 days</option>
                                    <option value="1">Last 90 days</option>
                                    <option value="1">Last 1 year</option>
                                </select>
                            </div>

                            <div class="default-table-area style-two latest-transaction">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        </div>
                                                        <span class="ms-1">Customer ID</span>
                                                    </div>
                                                </th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Property</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Payment</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                        </div>
                                                        <span class="ms-1 text-secondary">#TRE0015</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/my-profile" class="d-flex align-items-center">
                                                        <img src="/assets/images/user-1.jpg" class="wh-44 rounded-2" alt="user">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium fs-14">Sarah Johnson</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Industrial</td>
                                                <td>2024-10-01</td> 
                                                <td>$500,000</td> 
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Completed</span>
                                                </td>
                                                <td>Master Card</td> 
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                        </div>
                                                        <span class="ms-1 text-secondary">#TRE0099</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/my-profile" class="d-flex align-items-center">
                                                        <img src="/assets/images/user-2.jpg" class="wh-44 rounded-2" alt="user">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium fs-14">Michael Smith</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Office</td>
                                                <td>2024-09-28</td> 
                                                <td>$1,200,000</td> 
                                                <td>
                                                    <span class="badge bg-warning bg-opacity-10 text-warning p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>Paypal</td> 
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                        </div>
                                                        <span class="ms-1 text-secondary">#TRE0145</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/my-profile" class="d-flex align-items-center">
                                                        <img src="/assets/images/user-3.jpg" class="wh-44 rounded-2" alt="user">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium fs-14">Emily Brown</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Multi-Family</td>
                                                <td>2024-09-25</td> 
                                                <td>$350,000</td> 
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-25 text-danger p-2 fs-12 fw-normal">Cancel</span>
                                                </td>
                                                <td>Wise</td> 
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                        </div>
                                                        <span class="ms-1 text-secondary">#TRE0247</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/my-profile" class="d-flex align-items-center">
                                                        <img src="/assets/images/user-4.jpg" class="wh-44 rounded-2" alt="user">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium fs-14">Jason Lee</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Residential</td>
                                                <td>2024-09-22</td> 
                                                <td>$220,000</td> 
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Completed</span>
                                                </td>
                                                <td>Payoneer</td> 
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                        </div>
                                                        <span class="ms-1 text-secondary">#TRE0299</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/my-profile" class="d-flex align-items-center">
                                                        <img src="/assets/images/user-5.jpg" class="wh-44 rounded-2" alt="user">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium fs-14">Ashley Davis</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Commercial</td>
                                                <td>2024-09-20</td> 
                                                <td>$1,500,000</td> 
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Rejected</span>
                                                </td>
                                                <td>Credit Card</td> 
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
    
                                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap p-4">
                                    <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
    
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination mb-0 justify-content-center">
                                            <li class="page-item">
                                                <a class="page-link icon" href="/real-estate" aria-label="Previous">
                                                    <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link active" href="/real-estate">1</a></li>
                                            <li class="page-item"><a class="page-link" href="/real-estate">2</a></li>
                                            <li class="page-item"><a class="page-link" href="/real-estate">3</a></li>
                                            <li class="page-item"><a class="page-link" href="/real-estate">4</a></li>
                                            <li class="page-item">
                                                <a class="page-link icon" href="/real-estate" aria-label="Next">
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