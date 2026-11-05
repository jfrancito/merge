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
                        <div class="col-xxl-3 col-sm-6">
                            <div class="card custom-shadow for-dark-rounded-bg rounded-3 border mb-4" style="background: linear-gradient(102deg, #4936F5 3.78%, #757DFF 70.84%);">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding: 14.5px 25px;">
                                    <h3 class="mb-0 fs-16 fw-normal text-white">Total Sales</h3>

                                    <div class="dropdown action-opt right-for-rtl" style="right: -8px;">
                                        <button class="btn bg-transparent p-0 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical" style="stroke: #fff;"></i>
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
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body bg-white p-4 rounded-2">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h3 class="fs-24 fw-semibold text-secondary mb-0">$75,000</h3>
                                        <div class="text-center rounded-circle" style="background-color: #ECF0FF; width: 51px; height: 51px; line-height: 51px;">
                                            <img src="/assets/images/total-sales-icon.svg" alt="total-sales-icon">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-symbols-outlined fs-20 text-success-60 me-2">trending_up</span>
                                        <span><span class="fw-semibold">+15%</span> from last month</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div class="card custom-shadow for-dark-rounded-bg rounded-3 border mb-4" style="background: linear-gradient(103deg, #9135E8 9.27%, #BF85FB 83.62%);">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding: 14.5px 25px;">
                                    <h3 class="mb-0 fs-16 fw-normal text-white">Total Transactions</h3>

                                    <div class="dropdown action-opt right-for-rtl" style="right: -8px;">
                                        <button class="btn bg-transparent p-0 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical" style="stroke: #fff;"></i>
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
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body bg-white p-4 rounded-2">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h3 class="fs-24 fw-semibold text-secondary mb-0">1200</h3>
                                        <div class="text-center rounded-circle" style="background-color: #F3E8FF; width: 51px; height: 51px; line-height: 51px;">
                                            <img src="/assets/images/total-transactions-icon.svg" alt="total-transactions-icon">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-symbols-outlined fs-20 text-success-60 me-2">trending_up</span>
                                        <span><span class="fw-semibold">+10%</span> from last month</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div class="card custom-shadow for-dark-rounded-bg rounded-3 border mb-4" style="background: linear-gradient(104deg, #25B003 7.79%, #37D80A 83.18%);">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding: 14.5px 25px;">
                                    <h3 class="mb-0 fs-16 fw-normal text-white">Average Order Value</h3>

                                    <div class="dropdown action-opt right-for-rtl" style="right: -8px;">
                                        <button class="btn bg-transparent p-0 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical" style="stroke: #fff;"></i>
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
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body bg-white p-4 rounded-2">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h3 class="fs-24 fw-semibold text-secondary mb-0">$40</h3>
                                        <div class="text-center rounded-circle" style="background-color: #D8FFC8; width: 51px; height: 51px; line-height: 51px;">
                                            <img src="/assets/images/average-order-value-icon.svg" alt="average-order-value-icon">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-symbols-outlined fs-20 text-danger-50 me-2">trending_down</span>
                                        <span><span class="fw-semibold">-5%</span> from last month</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div class="card custom-shadow for-dark-rounded-bg rounded-3 border mb-4" style="background: linear-gradient(106deg, #EE3E08 9.72%, #FD5812 79.69%);">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding: 14.5px 25px;"> 
                                    <h3 class="mb-0 fs-16 fw-normal text-white">Total Discount</h3>

                                    <div class="dropdown action-opt right-for-rtl" style="right: -8px;">
                                        <button class="btn bg-transparent p-0 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical" style="stroke: #fff;"></i>
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
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body bg-white p-4 rounded-2">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h3 class="fs-24 fw-semibold text-secondary mb-0">$5,200</h3>
                                        <div class="text-center rounded-circle" style="background-color: #FFE8D4; width: 51px; height: 51px; line-height: 51px;">
                                            <img src="/assets/images/total-discount-icon.svg" alt="total-discount-icon">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-symbols-outlined fs-20 text-success-60 me-2">trending_up</span>
                                        <span><span class="fw-semibold">+8%</span> from last month</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card custom-shadow for-dark-rounded-bg rounded-3 border mb-4 bg-body-bg">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding: 14.5px 25px;">
                                    <h3 class="mb-0 fs-16 fw-normal text-secondary">Sales Analytics</h3>

                                    <div class="dropdown select-dropdown without-border position-relative" style="right: -5px;">
                                        <button class="dropdown-toggle bg-transparent border text-body rounded-2" style="padding-right: 20px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Last Month
                                        </button>
                                      
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last Day</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last Week</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last Month</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last Year</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body bg-white p-4 rounded-top-3 border-top">
                                    <div class="row align-items-">
                                        <div class="col-lg-6 mt-4">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="rounded-2 text-center" style="background-color: #DDE4FF; width: 44px; height: 44px; line-height: 44px;">
                                                            <img src="/assets/images/sales-over-time-icon.svg" alt="sales-over-time-icon">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-10">
                                                        <span>Sales Over Time</span>
                                                        <h3 class="fs-24 fw-semibold mb-0">$120,000</h3>
                                                    </div>
                                                </div>
                                                <span class="text-success-50 p-2 py-1 d-inline-block rounded-1 ms-10" style="background-color: #D8FFC8;">+9.1%</span>
                                            </div>
                                            <p style="line-height: 1.44; max-width: 284px;">Sales have shown a positive trend, with a significant increase of 9.1% over the previous month.</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <div style="margin: -7px -20px -14px 0;">
                                                <div id="sales_over_time"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-white px-4 rounded-bottom-3 border-top" style="padding-top: 40px; padding-bottom: 42px;">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div style="margin: -19px -15px -8px -23px;">
                                                <div id="sales_by_category_products"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <h3 class="mb-3 pb-1 fs-16 fw-medium mt-4 mt-sm-0">Sales by Category/Products <span class="fs-14 fw-normal text-body">(Top Performing)</span></h3>
                                            
                                            <div class="d-flex flex-wrap gap-3 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="rounded-2 text-center" style="background-color: #F3E8FF; width: 44px; height: 44px; line-height: 44px;">
                                                            <img src="/assets/images/electronics-icon.svg" alt="electronics-icon">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-10">
                                                        <span>Electronics</span>
                                                        <h3 class="fs-20 fw-medium mb-0">$35,000</h3>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="rounded-2 text-center" style="background-color: #D8FFC8; width: 44px; height: 44px; line-height: 44px;">
                                                            <img src="/assets/images/clothing-icon.svg" alt="clothing-icon">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-10">
                                                        <span>Clothing</span>
                                                        <h3 class="fs-20 fw-medium mb-0">$25,000</h3>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="rounded-2 text-center" style="background-color: #DAEBFF; width: 44px; height: 44px; line-height: 44px;">
                                                            <img src="/assets/images/home-goods-icon.svg" alt="home-goods-icon">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-10">
                                                        <span>Home Goods</span>
                                                        <h3 class="fs-20 fw-medium mb-0">$18,000</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card custom-shadow for-dark-rounded-bg rounded-3 border mb-4 bg-body-bg">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding: 14.5px 25px;">
                                    <h3 class="mb-0 fs-16 fw-normal text-secondary">Customer Segmentation</h3>

                                    <div class="dropdown action-opt right-for-rtl" style="right: -8px;">
                                        <button class="btn bg-transparent p-0 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical" style="stroke: #64748B;"></i>
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
                                <div class="card-body bg-white p-4 rounded-3 border-top">
                                    <div style="margin: 0 0 0 0;">
                                        <div id="customer_segmentation"></div>
                                    </div>

                                    <div class="last-child-none mt-4">
                                        <div class="d-flex align-items-center child mb-4">
                                            <div class="flex-shrink-0">
                                                <div class="rounded-2 text-center" style="background-color: #DAEBFF; width: 44px; height: 44px; line-height: 44px;">
                                                    <img src="/assets/images/new-customers-icon.svg" alt="new-customers-icon">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <span>New Customers</span>
                                                <h3 class="fs-20 fw-medium mb-0">1,200 <span class="fs-12 fw-normal text-body"><span class="fw-medium">+40%</span> of total transactions</span></h3>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center child mb-4">
                                            <div class="flex-shrink-0">
                                                <div class="rounded-2 text-center" style="background-color: #F3E8FF; width: 44px; height: 44px; line-height: 44px;">
                                                    <img src="/assets/images/returning-customers-icon.svg" alt="returning-customers-icon">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <span>Returning Customers</span>
                                                <h3 class="fs-20 fw-medium mb-0">1,800 <span class="fs-12 fw-normal text-body"><span class="fw-medium">+60%</span> of total transactions</span></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-8">
                            <h3 class="fs-20 fw-medium mb-4">Categories</h3>
                            <ul class="nav nav-tabs border-0 mb-4 gap-3 categories-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-2 bg-transparent rounded-3 active" style="width: 125px; padding: 20px; padding-bottom: 16px;" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">
                                        <img src="/assets/images/all-icon.svg" class="mb-3" alt="all-icon">
                                        <h4 class="fs-16 fw-medium d-block mb-0">All</h4>
                                        <span class="fs-12 fw-medium text-body">450 <span class="d-none">Products</span></span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-2 bg-transparent rounded-3" style="width: 125px; padding: 20px; padding-bottom: 16px;" id="electronics-tab" data-bs-toggle="tab" data-bs-target="#electronics-tab-pane" type="button" role="tab" aria-controls="electronics-tab-pane" aria-selected="false">
                                        <img src="/assets/images/electronics-icon2.svg" class="mb-3" alt="electronics-icon">
                                        <h4 class="fs-16 fw-medium d-block mb-0">Electronics</h4>
                                        <span class="fs-12 fw-medium text-body">45 <span class="d-none">Products</span></span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-2 bg-transparent rounded-3" style="width: 125px; padding: 20px; padding-bottom: 16px;" id="clothing-tab" data-bs-toggle="tab" data-bs-target="#clothing-tab-pane" type="button" role="tab" aria-controls="clothing-tab-pane" aria-selected="false">
                                        <img src="/assets/images/clothing-icon2.svg" class="mb-3" alt="clothing-icon2">
                                        <h4 class="fs-16 fw-medium d-block mb-0">Clothing</h4>
                                        <span class="fs-12 fw-medium text-body">29 <span class="d-none">Products</span></span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-2 bg-transparent rounded-3" style="width: 125px; padding: 20px; padding-bottom: 16px;" id="beauty-tab" data-bs-toggle="tab" data-bs-target="#beauty-tab-pane" type="button" role="tab" aria-controls="beauty-tab-pane" aria-selected="false">
                                        <img src="/assets/images/beauty-icon.svg" class="mb-3" alt="beauty-icon">
                                        <h4 class="fs-16 fw-medium d-block mb-0">Beauty</h4>
                                        <span class="fs-12 fw-medium text-body">34 <span class="d-none">Products</span></span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-2 bg-transparent rounded-3" style="width: 125px; padding: 20px; padding-bottom: 16px;" id="foods-tab" data-bs-toggle="tab" data-bs-target="#foods-tab-pane" type="button" role="tab" aria-controls="foods-tab-pane" aria-selected="false">
                                        <img src="/assets/images/foods-icon.svg" class="mb-3" alt="foods-icon">
                                        <h4 class="fs-16 fw-medium d-block mb-0">Foods</h4>
                                        <span class="fs-12 fw-medium text-body">18 <span class="d-none">Products</span></span>
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-36.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Apple iPhone 16</h3>
                                                        <span class="text-body">Smartphones</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$799</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-37.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Levi's 501</h3>
                                                        <span class="text-body">Pants</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$89</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-38.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Maybelline Lash</h3>
                                                        <span class="text-body">Makeup</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$29</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-39.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Quaker Oats</h3>
                                                        <span class="text-body">Breakfast</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$99</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-40.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Fitbit Charge</h3>
                                                        <span class="text-body">Wearables</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$179</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-41.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Adidas Women</h3>
                                                        <span class="text-body">Outerwear</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$85</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-42.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Galaxy Tab</h3>
                                                        <span class="text-body">Tablets</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$649</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-43.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">H&M Basic</h3>
                                                        <span class="text-body">T-Shirts</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$20</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-44.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">L'Oréal Paris</h3>
                                                        <span class="text-body">Makeup</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$69</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap custom-shadow for-dark-rounded-bg rounded-3 border bg-white px-4 mb-4" style="padding-top: 11px; padding-bottom: 11px;">
                                        <span class="fs-12 fw-medium">Showing 9 of 30 Results</span> 
        
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
                                                    <button class="page-link">3</button></li>
                                                <li class="page-item"><a class="page-link">4</a>
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
                                <div class="tab-pane fade" id="electronics-tab-pane" role="tabpanel" aria-labelledby="electronics-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-40.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Fitbit Charge</h3>
                                                        <span class="text-body">Wearables</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$179</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-36.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Apple iPhone 16</h3>
                                                        <span class="text-body">Smartphones</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$799</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-42.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Galaxy Tab</h3>
                                                        <span class="text-body">Tablets</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$649</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-37.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Levi's 501</h3>
                                                        <span class="text-body">Pants</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$89</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-41.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Adidas Women</h3>
                                                        <span class="text-body">Outerwear</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$85</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-43.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">H&M Basic</h3>
                                                        <span class="text-body">T-Shirts</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$20</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap custom-shadow for-dark-rounded-bg rounded-3 border bg-white px-4 mb-4" style="padding-top: 11px; padding-bottom: 11px;">
                                        <span class="fs-12 fw-medium">Showing 3 of 30 Results</span> 
        
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
                                                    <button class="page-link">3</button></li>
                                                <li class="page-item"><a class="page-link">4</a>
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
                                <div class="tab-pane fade" id="clothing-tab-pane" role="tabpanel" aria-labelledby="clothing-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-37.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Levi's 501</h3>
                                                        <span class="text-body">Pants</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$89</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-41.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Adidas Women</h3>
                                                        <span class="text-body">Outerwear</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$85</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-43.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">H&M Basic</h3>
                                                        <span class="text-body">T-Shirts</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$20</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-36.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Apple iPhone 16</h3>
                                                        <span class="text-body">Smartphones</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$799</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-40.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Fitbit Charge</h3>
                                                        <span class="text-body">Wearables</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$179</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-42.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Galaxy Tab</h3>
                                                        <span class="text-body">Tablets</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$649</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap custom-shadow for-dark-rounded-bg rounded-3 border bg-white px-4 mb-4" style="padding-top: 11px; padding-bottom: 11px;">
                                        <span class="fs-12 fw-medium">Showing 3 of 30 Results</span> 
        
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
                                                    <button class="page-link">3</button></li>
                                                <li class="page-item"><a class="page-link">4</a>
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
                                <div class="tab-pane fade" id="beauty-tab-pane" role="tabpanel" aria-labelledby="beauty-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-38.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Maybelline Lash</h3>
                                                        <span class="text-body">Makeup</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$29</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-40.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Fitbit Charge</h3>
                                                        <span class="text-body">Wearables</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$179</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-44.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">L'Oréal Paris</h3>
                                                        <span class="text-body">Makeup</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$69</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-37.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Levi's 501</h3>
                                                        <span class="text-body">Pants</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$89</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-41.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Adidas Women</h3>
                                                        <span class="text-body">Outerwear</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$85</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-43.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">H&M Basic</h3>
                                                        <span class="text-body">T-Shirts</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$20</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap custom-shadow for-dark-rounded-bg rounded-3 border bg-white px-4 mb-4" style="padding-top: 11px; padding-bottom: 11px;">
                                        <span class="fs-12 fw-medium">Showing 3 of 30 Results</span> 
        
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
                                                    <button class="page-link">3</button></li>
                                                <li class="page-item"><a class="page-link">4</a>
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
                                <div class="tab-pane fade" id="foods-tab-pane" role="tabpanel" aria-labelledby="foods-tab" tabindex="0">
                                    <div class="row justify-content-center">
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-39.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Quaker Oats</h3>
                                                        <span class="text-body">Breakfast</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$99</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-37.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Levi's 501</h3>
                                                        <span class="text-body">Pants</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$89</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-41.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Adidas Women</h3>
                                                        <span class="text-body">Outerwear</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$85</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-42.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">Galaxy Tab</h3>
                                                        <span class="text-body">Tablets</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$649</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-43.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">H&M Basic</h3>
                                                        <span class="text-body">T-Shirts</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$20</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card custom-shadow rounded-3 border mb-4 bg-white p-20">
                                                <div class="pb-1">
                                                    <a href="/product-details" class="d-block text-decoration-none mb-2">
                                                        <img src="/assets/images/product-44.png" class="rounded-2 mb-3" alt="product">
                                                        <h3 class="fs-20 fw-medium mb-1">L'Oréal Paris</h3>
                                                        <span class="text-body">Makeup</span>
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-end">
                                                        <span class="fs-24 fw-medium text-success-60 lh-1 position-relative top-3">$69</span>
                                                        <button class="rounded-1 border-0 p-0 text-center text-primary fs-24" style="background-color:#DDE4FF; width: 35px; height: 35px; line-height: 35px;">
                                                            <i class="ri-shopping-cart-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap custom-shadow for-dark-rounded-bg rounded-3 border bg-white px-4 mb-4" style="padding-top: 11px; padding-bottom: 11px;">
                                        <span class="fs-12 fw-medium">Showing 1 of 30 Results</span> 
        
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
                                                    <button class="page-link">3</button></li>
                                                <li class="page-item"><a class="page-link">4</a>
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
                        <div class="col-xxl-4">
                            <div class="card custom-shadow for-dark-rounded-bg rounded-3 border mb-4 bg-body-bg">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding: 8.5px 25px;">
                                    <h3 class="mb-0 fs-20 fw-medium text-secondary">Order Details</h3>

                                    <button class="bg-transparent p-0 border-0 text-primary-50 fs-24">
                                        <i class="ri-refresh-line"></i>
                                    </button>
                                </div>
                                <div class="card-body bg-white py-4 px-0 rounded-3 border-top">
                                    <div class="last-child-none">
                                        <div class="d-flex justify-content-between align-items-center child border-bottom px-3 px-sm-4" style="padding-bottom: 20px; margin-bottom: 20px;">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/product-45.jpg" style="width: 40px; height: 28px;" class="rounded-1" alt="product">
                                                </div>
                                                <div class="flex-grow-1 ms-10">
                                                    <h3 class="fs-14 fw-medium mb-0" style="max-width: 78px;">Maybelline Lash</h3>
                                                </div>
                                            </div>
    
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="product-quantity border-0 bg-body-bg rounded-2">
                                                    <div class="add-to-cart-counter p-0">
                                                        <input type="button" class="minusBtn bg-transparent position-relative for-dark-cart" style="color: #666666; font-size: 30px; height: 31px; top: -2px; width: 30px;" value="-">
                                                        <input type="text" size="25" value="1" class="count bg-body-bg border-0" style="max-width: 30px;"> 
                                                        <input type="button" class="plusBtn bg-transparent" style="color: #666666; font-size: 20px; height: 31px; width: 30px;" value="+">
                                                    </div>
                                                </div>
                           
                                                <span class="fs-18 fw-medium text-primary ms-2 ms-sm-4">$29</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center child border-bottom px-3 px-sm-4" style="padding-bottom: 20px; margin-bottom: 20px;">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/product-46.jpg" style="width: 40px; height: 28px;" class="rounded-1" alt="product">
                                                </div>
                                                <div class="flex-grow-1 ms-10">
                                                    <h3 class="fs-14 fw-medium mb-0" style="max-width: 78px;">Apple iPhone 16</h3>
                                                </div>
                                            </div>
    
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="product-quantity border-0 bg-body-bg rounded-2">
                                                    <div class="add-to-cart-counter p-0">
                                                        <input type="button" class="minusBtn bg-transparent position-relative for-dark-cart" style="color: #666666; font-size: 30px; height: 31px; top: -2px; width: 30px;" value="-">
                                                        <input type="text" size="25" value="1" class="count bg-body-bg border-0" style="max-width: 30px;"> 
                                                        <input type="button" class="plusBtn bg-transparent" style="color: #666666; font-size: 20px; height: 31px; width: 30px;" value="+">
                                                    </div>
                                                </div>
    
                                                <span class="fs-18 fw-medium text-primary ms-2 ms-sm-4">$799</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center child border-bottom px-3 px-sm-4" style="padding-bottom: 20px; margin-bottom: 20px;">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/product-47.jpg" style="width: 40px; height: 28px;" class="rounded-1" alt="product">
                                                </div>
                                                <div class="flex-grow-1 ms-10">
                                                    <h3 class="fs-14 fw-medium mb-0" style="max-width: 78px;">Adidas Woman</h3>
                                                </div>
                                            </div>
    
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="product-quantity border-0 bg-body-bg rounded-2">
                                                    <div class="add-to-cart-counter p-0">
                                                        <input type="button" class="minusBtn bg-transparent position-relative for-dark-cart" style="color: #666666; font-size: 30px; height: 31px; top: -2px; width: 30px;" value="-">
                                                        <input type="text" size="25" value="1" class="count bg-body-bg border-0" style="max-width: 30px;"> 
                                                        <input type="button" class="plusBtn bg-transparent" style="color: #666666; font-size: 20px; height: 31px; width: 30px;" value="+">
                                                    </div>
                                                </div>
    
                                                <span class="fs-18 fw-medium text-primary ms-2 ms-sm-4">$85</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <div class="bg-body-bg p-20 rounded-3 mb-30">
                                            <ul class="ps-0 mb-3 list-unstyled last-child-none">
                                                <li class="d-flex justify-content-between align-items-center" style="margin-bottom: 7px;">
                                                    <span>Total</span>
                                                    <span>3 Items</span>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center" style="margin-bottom: 7px;">
                                                    <span class="text-secondary fw-medium">Subtotal:</span>
                                                    <span class="text-secondary fw-medium">$913.00</span>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center" style="margin-bottom: 7px;">
                                                    <span class="text-secondary fw-medium">Shipping:</span>
                                                    <span class="text-secondary fw-medium">$0.00</span>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center" style="margin-bottom: 7px;">
                                                    <span class="text-secondary fw-medium">Tax (10%):</span>
                                                    <span class="text-secondary fw-medium">$91.30</span>
                                                </li>
                                            </ul>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h3 class="fs-20 fw-medium mb-0">Payable Total</h3>
                                                <h3 class="fs-20 fw-medium mb-0">$1004.30</h3>
                                            </div>
                                        </div>

                                        <h3 class="fs-20 fw-medium mb-3">Payment Method</h3>

                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center payment-method mb-30">
                                            <div>
                                                <input type="radio" class="btn-check" name="options-base" id="option5" autocomplete="off">
                                                <label class="btn" for="option5" style="width: 81px; height: 66px; background-color: #F6F7F9; border: 1px solid #DDE4FF; padding: 9px 0;">
                                                    <img src="/assets/images/cash.svg" alt="cash">
                                                    <span class="d-block text-secondary">Cash</span>
                                                </label>
                                            </div>

                                            <div class="">
                                                <input type="radio" class="btn-check" name="options-base" id="option6" autocomplete="off" checked>
                                                <label class="btn" for="option6" style="width: 81px; height: 66px; background-color: #F6F7F9; border: 1px solid #DDE4FF; padding: 9px 0;">
                                                    <img src="/assets/images/card.svg" alt="cash">
                                                    <span class="d-block text-secondary">Card</span>
                                                </label>
                                            </div>

                                            <div class="">
                                                <input type="radio" class="btn-check" name="options-base" id="option8" autocomplete="off">
                                                <label class="btn" for="option8" style="width: 81px; height: 66px; background-color: #F6F7F9; border: 1px solid #DDE4FF; padding: 9px 0;">
                                                    <img src="/assets/images/e-wallet.svg" alt="cash">
                                                    <span class="d-block text-secondary">E-Wallet</span>
                                                </label>
                                            </div>
                                        </div>

                                        <a href="/checkout" class="btn btn-primary fs-16 fw-medium w-100 py-2">
                                            Place Order
                                        </a>
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
