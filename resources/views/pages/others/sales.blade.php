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
                    <div class="card bg-white border-0 rounded-3 p-4 pb-0 mb-4">
                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
                            <h3 class="fs-24 fw-normal mb-0">Welcome Back, <span class="text-primary">Olivia!</span> <img src="/assets/images/dog.svg" alt="dog"></h3>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <select class="form-select month-select form-control h-auto pe-5 w-auto" style="background-position: right 15px center; color: #64748B;" aria-label="Default select example">
                                    <option>July 01 - July 31, 2024</option>
                                    <option value="1">August 01 - August 31, 2024</option>
                                    <option selected value="2">September 01 - September 31, 2024</option>
                                </select>
                                <button class="btn btn-primary py-1 px-3 rounded-3">
                                    <span class="d-inline-block py-1">
                                        <i class="ri-download-2-line text-white fs-16 me-1"></i>
                                        Export CSV
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card border bg-white rounded-3 overflow-hidden mb-4">
                                    <div class="d-flex align-items-center p-4 pb-3 mb-1">
                                        <div class="flex-shrink-0">
                                            <div class="wh-55 bg-primary bg-opacity-25 text-center rounded-2" style="line-height: 55px;">
                                                <i class="ri-shopping-cart-line fs-22 bg-primary text-white rounded-2 p-2"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h3 class="fs-24 fw-medium mb-0">$150,000</h3>
                                            <span>Total Sales</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center p-4 pb-0">
                                        <span class="d-inline-block bg-success text-success bg-opacity-10 border border-success rounded-pill px-2 fw-medium d-flex align-items-center">
                                            <i class="ri-arrow-up-fill fs-16 lh-1"></i>
                                            12%
                                        </span>
                                        <span class="ms-2 fs-12">from last week</span>
                                    </div>

                                    <div style="margin: -45px -11px -31px -15px;">
                                        <div id="total_sales"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card border bg-white rounded-3 overflow-hidden mb-4">
                                    <div class="d-flex align-items-center p-4 pb-3 mb-1">
                                        <div class="flex-shrink-0">
                                            <div class="wh-55 bg-primary-div bg-opacity-25 text-center rounded-2" style="line-height: 55px;">
                                                <i class="ri-shopping-bag-3-line fs-22 bg-primary-div text-white rounded-2 p-2"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h3 class="fs-24 fw-medium mb-0">1,250</h3>
                                            <span>Total Orders</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center p-4 pb-0">
                                        <span class="d-inline-block bg-success text-success bg-opacity-10 border border-success rounded-pill px-2 fw-medium d-flex align-items-center">
                                            <i class="ri-arrow-up-fill fs-16 lh-1"></i>
                                            8%
                                        </span>
                                        <span class="ms-2 fs-12">from last month</span>
                                    </div>

                                    <div style="margin: -45px 0 -31px -9px;">
                                        <div id="total_order"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card border bg-white rounded-3 overflow-hidden mb-4">
                                    <div class="d-flex align-items-center p-4 pb-3 mb-1">
                                        <div class="flex-shrink-0">
                                            <div class="wh-55 bg-card-bg-c bg-opacity-25 text-center rounded-2" style="line-height: 55px;">
                                                <i class="ri-wallet-2-line fs-22 bg-card-bg-c text-white rounded-2 p-2"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h3 class="fs-24 fw-medium mb-0">$80,000</h3>
                                            <span>Total Profit</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center p-4 pb-0">
                                        <span class="d-inline-block bg-danger text-danger bg-opacity-10 border border-danger rounded-pill px-2 fw-medium d-flex align-items-center">
                                            <i class="ri-arrow-down-fill fs-16 lh-1"></i>
                                            7%
                                        </span>
                                        <span class="ms-2 fs-12">from last week</span>
                                    </div>

                                    <div style="margin: -45px -11px -31px -15px;">
                                        <div id="total_profit"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card border bg-white rounded-3 overflow-hidden mb-4">
                                    <div class="d-flex align-items-center p-4 pb-3 mb-1">
                                        <div class="flex-shrink-0">
                                            <div class="wh-55 bg-danger bg-opacity-25 text-center rounded-2" style="line-height: 55px;">
                                                <i class="ri-money-dollar-circle-line fs-22 bg-danger text-white rounded-2 p-2"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h3 class="fs-24 fw-medium mb-0">$250,000</h3>
                                            <span>Total Revenue</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center p-4 pb-0">
                                        <span class="d-inline-block bg-success text-success bg-opacity-10 border border-success rounded-pill px-2 fw-medium d-flex align-items-center">
                                            <i class="ri-arrow-up-fill fs-16 lh-1"></i>
                                            12%
                                        </span>
                                        <span class="ms-2 fs-12">from last week</span>
                                    </div>

                                    <div style="margin: -45px -11px -31px -15px;">
                                        <div id="total_revenues"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card bg-white border rounded-3 mb-4">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                            <h3 class="mb-0">Recent Earnings</h3>
                                            <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                                <option selected="">This Month</option>
                                                <option value="1">Last Month</option>
                                                <option value="2">Last Year</option>
                                            </select>
                                        </div>
    
                                        <div style="margin: -5px -9px -28px -17px;">
                                            <div id="recent_earnings"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-white border rounded-3 mb-4">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                            <h3 class="mb-0">Sales by Locations</h3>
    
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
                                        <div class="text-center mb-0">
                                            <img src="/assets/images/map.svg" alt="map">
                                        </div>
                                        
                                        <div class="default-table-area style-two sales-locations-table">
                                            <div class="table-responsive">
                                                <table class="table align-middle border-0">
                                                    <thead>
                                                        <tr class="border-bottom">
                                                            <th scope="col" class="bg-transparent">Country</th>
                                                            <th scope="col" class="text-end bg-transparent">Orders</th>
                                                            <th scope="col" class="text-end bg-transparent">Earnings</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-end fw-medium ps-0">
                                                                <div class="d-flex">
                                                                    <img src="/assets/images/usa.svg" class="rounded-circle" style="width: 20px;" alt="usa">
                                                                    <span class="ps-2 fw-medium">USA</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-end fw-medium">22,124</td>
                                                            <td class="text-end fw-medium">$250.4k</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-end fw-medium ps-0">
                                                                <div class="d-flex">
                                                                    <img src="/assets/images/germany.svg" class="rounded-circle" style="width: 20px;" alt="germany">
                                                                    <span class="ps-2 fw-medium">Germany</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-end fw-medium">18,320</td>
                                                            <td class="text-end fw-medium">$180.3k</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-end fw-medium ps-0">
                                                                <div class="d-flex">
                                                                    <img src="/assets/images/united-kingdom.svg" class="rounded-circle" style="width: 20px;" alt="united-kingdom">
                                                                    <span class="ps-2 fw-medium">UK</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-end fw-medium">12,560</td>
                                                            <td class="text-end fw-medium">$125.6k</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-end fw-medium ps-0">
                                                                <div class="d-flex">
                                                                    <img src="/assets/images/canada.svg" class="rounded-circle" style="width: 20px;" alt="usa">
                                                                    <span class="ps-2 fw-medium">Canada</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-end fw-medium">8,720</td>
                                                            <td class="text-end fw-medium">$94.1k</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-xxl-4 col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Transaction History</h3>
                                        
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
                                    
                                    <ul class="ps-0 mb-0 list-unstyled">
                                        <li class="d-flex align-items-center justify-content-between mb-3 pb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-primary bg-opacity-10 text-primary text-center rounded-circle wh-40 lh-40">credit_card</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Master Card</h6>
                                                    <span class="fs-12">23 Dec 2024 - 3:20 pm</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-success">+1,520</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between mb-3 pb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-danger bg-opacity-10 text-danger text-center rounded-circle wh-40 lh-40">redeem</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Paypal</h6>
                                                    <span class="fs-12">23 Dec 2024 - 3:20 pm</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-danger">-2,250</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between mb-3 pb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-primary-div bg-opacity-10 text-primary-div text-center rounded-circle wh-40 lh-40">account_balance</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Wise</h6>
                                                    <span class="fs-12">23 Dec 2024 - 3:20 pm</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-success">+3,560</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between mb-3 pb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-info bg-opacity-10 text-info text-center rounded-circle wh-40 lh-40">currency_ruble</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Payoneer</h6>
                                                    <span class="fs-12">23 Dec 2024 - 3:20 pm</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-success">+6,500</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between mb-3 pb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-success bg-opacity-10 text-success text-center rounded-circle wh-40 lh-40">credit_score</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Credit Card</h6>
                                                    <span class="fs-12">23 Dec 2024 - 3:20 pm</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-danger">+4,320</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between mb-3 pb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-primary-div bg-opacity-10 text-primary-div text-center rounded-circle wh-40 lh-40">account_balance</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Wise</h6>
                                                    <span class="fs-12">16 Dec 2024 - 1:23 pm</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-success">+5,432</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-danger bg-opacity-10 text-danger text-center rounded-circle wh-40 lh-40">redeem</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Paypal</h6>
                                                    <span class="fs-12">23 Dec 2024 - 3:20 pm</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-success">+1,820</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8 col-xxl-8 col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Recent Orders</h3>
                                        <div class="d-flex">
                                            <form class="position-relative table-src-form">
                                                <input type="text" class="form-control" placeholder="Search here">
                                                <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                            </form>
                                            <select class="form-select month-select form-control" aria-label="Default select example">
                                                <option selected>Show All</option>
                                                <option value="1">Weekly</option>
                                                <option value="2">Monthly</option>
                                                <option value="3">Yearly</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="default-table-area recent-orders recent-style-two">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Order ID</th>
                                                        <th scope="col">Customer</th>
                                                        <th scope="col">Created</th>
                                                        <th scope="col">Total</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>#JAN-2345</td>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/user-1.jpg" class="wh-40 rounded-3" alt="user">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Sarah Johnson</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>12 Jan, 2024</td>
                                                        <td>$10,490</td>
                                                        <td>
                                                            <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Shipped</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>#JAN-1323</td>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/user-2.jpg" class="wh-40 rounded-3" alt="user">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Michael Smith</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>08 Jan, 2024</td>
                                                        <td>$6,575</td>
                                                        <td>
                                                            <span class="badge bg-info bg-opacity-10 text-info p-2 fs-12 fw-normal">Confirmed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>#DEC-1234</td>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/user-3.jpg" class="wh-40 rounded-3" alt="user">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Emily Brown</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>13 Dec, 2023</td>
                                                        <td>$12,870</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Pending</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>#DEC-3567</td>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/user-4.jpg" class="wh-40 rounded-3" alt="user">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Jason Lee</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>05 Dec, 2023</td>
                                                        <td>$7,895</td>
                                                        <td>
                                                            <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Shipped</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>#DEC-1098</td>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/user-5.jpg" class="wh-40 rounded-3" alt="user">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Ashley Davis</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>01 Dec, 2023</td>
                                                        <td>$4,680</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Rejected</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
            
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                            <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/sales" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/sales">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/sales">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/sales">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/sales">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/sales" aria-label="Next">
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
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 p-4 mb-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                    <h3 class="mb-0">Real-Time Sales</h3>

                                    <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                        <option selected="">Today</option>
                                        <option value="1">Last Week</option>
                                        <option value="2">Last Month</option>
                                    </select>
                                </div>

                                <div style="margin-top: -30px;">
                                    <div id="real_time_sales"></div>
                                </div>

                                <div class="d-flex justify-content-between border-top pt-4">
                                    <div>
                                        <span class="fs-12 d-block mb-1">Total Sales</span>
                                        <h3 class="fs-18 fw-medium mb-0">$150.7k 
                                            <span class="text-success fs-12">
                                                <i class="ri-arrow-up-fill"></i> 
                                                12%
                                            </span>
                                        </h3>
                                    </div>
                                    <div>
                                        <span class="fs-12 d-block mb-1">Avg. Sales Per Day</span>
                                        <h3 class="fs-18 fw-medium mb-0">$19.2k 
                                            <span class="text-danger fs-12">
                                                <i class="ri-arrow-down-fill"></i> 
                                                7%
                                            </span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 p-4 mb-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                    <h3 class="mb-0">Sales Overview</h3>

                                    <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                        <option selected="">This Year</option>
                                        <option value="1">Last Year</option>
                                        <option value="2">Last 2 Year</option>
                                    </select>
                                </div>

                                <div style="margin: -32px 0 -30px 0;">
                                    <div id="sales_overview"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-primary-div bg-opacity-10 border-0 rounded-3 p-4 mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="/assets/images/balance-2.png" alt="balance">
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <span class="mb-1 d-block fw-medium text-body">GROSS EARNINGS</span>
                                        <div class="d-flex">
                                            <h3 class="mb-0 fs-20 fw-semibold me-1">$78,350.00</h3>
                                            <i class="material-symbols-outlined fs-16 position-relative top-3 text-success">trending_up</i>
                                            <span class="text-success">+2.3%</span>   
                                        </div>
                                    </div>
                                </div>

                                <div id="gross_earnings"></div>

                                <div class="d-flex justify-content-between pt-4 for-dark-border" style="border-top: 1px solid #E9D5FF;">
                                    <div>
                                        <span class="fs-14 d-block mb-1">Total Balance</span>
                                        <h3 class="fs-20 fw-medium mb-0">$3,42,890</h3>
                                    </div>
                                    <div>
                                        <span class="fs-14 d-block mb-1">Withdrawals</span>
                                        <h3 class="fs-20 fw-medium mb-0">$2,35,425</h3>
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
