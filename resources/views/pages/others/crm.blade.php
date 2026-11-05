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
                    <div class="row justify-content-center">
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-35">
                                            <span>Revenue Growth</span>
                                            <h3 class="fs-20 mt-1 mb-0">$32,420</h3>
                                        </div>
                                        <div id="revenue_growth" class="chart-position"></div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                        <span class="count up fw-medium ms-0">+10%</span>
                                        <span class="fs-12">Last 7 days</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-35">
                                            <span>Lead Conversion</span>
                                            <h3 class="fs-20 mt-1 mb-0">48.79%</h3>
                                        </div>
                                        <div id="lead_conversion" class="chart-position"></div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                        <span class="count fw-medium ms-0">-15%</span>
                                        <span class="fs-12">Last 30 days </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-35">
                                            <span>Total Orders</span>
                                            <h3 class="fs-20 mt-1 mb-0">$72,458</h3>
                                        </div>
                                        <div id="total_orders2" class="chart-position"></div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                        <span class="count up fw-medium ms-0">+25%</span>
                                        <span class="fs-12">Last 90 days</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-35">
                                            <span>Annual Profit</span>
                                            <h3 class="fs-20 mt-1 mb-0">$879.6k</h3>
                                        </div>
                                        <div id="annual_profit" class="chart-position"></div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                        <span class="count up fw-medium ms-0">+30%</span>
                                        <span class="fs-12">Last 12 months</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Balance Overview</h3>
                                        <select class="form-select month-select form-control w-145" aria-label="Default select example">
                                            <option selected>Current Year</option>
                                            <option value="1">Last Year</option>
                                            <option value="2">Last Monthly</option>
                                        </select>
                                    </div>

                                    <div id="balance_overview"></div> 

                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-4 justify-content-center">
                                        <li class="d-flex align-items-center">
                                            <h4 class="fs-20 fw-semibold text-primary me-2 mb-0">$628k</h4>
                                            <span class="fs-12">Revenue</span>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <h4 class="fs-20 fw-semibold text-primary-div me-2 mb-0">$379k</h4>
                                            <span class="fs-12">Expenses</span>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <h4 class="fs-20 fw-semibold text-success me-2 mb-0">11.2%</h4>
                                            <span class="fs-12">Profit Ratio</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 pb-0">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Leads by Source</h3>
                                        <select class="form-select month-select form-control w-135" aria-label="Default select example">
                                            <option selected>This Month</option>
                                            <option value="1">Last Month</option>
                                            <option value="2">Last Year</option>
                                        </select>
                                    </div>

                                    <div style="margin-top: -10px; margin-bottom: 10px;">
                                        <div id="leads_by_source"></div> 
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col col-lg-4 col-md-2 mb-4">
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 bg-primary rounded-1 me-1"></span>
                                                <span>Organic</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1">320</h4>
                                        </div>
                                        <div class="col col-lg-4 col-md-2 mb-4">
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 rounded-1 me-1" style="background-color: #3584FC;"></span>
                                                <span>Paid</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1">60</h4>
                                        </div>
                                        <div class="col col-lg-4 col-md-2 mb-4">
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 bg-primary-div rounded-1 me-1"></span>
                                                <span>Direct</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1">30</h4>
                                        </div>
                                        <div class="col col-lg-4 col-md-2 mb-4">
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 bg-info rounded-1 me-1"></span>
                                                <span>Social</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1">160</h4>
                                        </div>
                                        <div class="col col-lg-4 col-md-2 mb-4">
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 bg-success rounded-1 me-1"></span>
                                                <span>Referrals</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1">279</h4>
                                        </div>
                                        <div class="col col-lg-4 col-md-2 mb-4">
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 bg-danger rounded-1 me-1"></span>
                                                <span>Others</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1">19</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xxl-4 col-xl-5 col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Top Performer</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>This Month</option>
                                            <option value="1">Last Month</option>
                                            <option value="2">Last Year</option>
                                        </select>
                                    </div>

                                    <ul class="ps-0 mb-0 list-unstyled border-top pt-3">
                                        <li class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-6.jpg" class="wh-44 rounded-circle" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                    <h6 class="mb-0 fw-medium">Alex Davis</h6>
                                                    <span>alex@trezo.com</span>
                                                </div>
                                            </div>
                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                            </a>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-7.jpg" class="wh-44 rounded-circle" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                    <h6 class="mb-0 fw-medium">Alex Davis</h6>
                                                    <span>alex@trezo.com</span>
                                                </div>
                                            </div>
                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                            </a>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-8.jpg" class="wh-44 rounded-circle" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                    <h6 class="mb-0 fw-medium">Alex Davis</h6>
                                                    <span>alex@trezo.com</span>
                                                </div>
                                            </div>
                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                            </a>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-9.jpg" class="wh-44 rounded-circle" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                    <h6 class="mb-0 fw-medium">Alex Davis</h6>
                                                    <span>alex@trezo.com</span>
                                                </div>
                                            </div>
                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                            </a>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-10.jpg" class="wh-44 rounded-circle" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                    <h6 class="mb-0 fw-medium">Alex Davis</h6>
                                                    <span>alex@trezo.com</span>
                                                </div>
                                            </div>
                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                        <span class="fs-12 fw-medium">Items per pages: 5</span>
        
                                        <div class="d-flex align-items-center">
                                            <span class="fs-12 fw-medium me-2">1 - 5 of 12</span>
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="index" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="index" aria-label="Next">
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
                        <div class="col-xxl-8 col-xl-7 col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-4">
                                        <h3 class="mb-0">Recent Leads</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>This Week</option>
                                            <option value="1">This Month</option>
                                            <option value="2">This Year</option>
                                        </select>
                                    </div>

                                    <div class="default-table-area style-two recent-leads">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                            </div>
                                                        </th>
                                                        <th scope="col">Customer</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Source</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/user-11.jpg" class="wh-44 rounded-circle" alt="user">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">David Brown</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>david@trezo.com</td>
                                                        <td>Organic</td> 
                                                        <td>
                                                            <span class="badge bg-info bg-opacity-10 text-info p-2 fs-12 fw-normal">Confirmed</span>
                                                        </td>
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
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/user-12.jpg" class="wh-44 rounded-circle" alt="user">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">Sarah Miller</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>sara@trezo.com</td>
                                                        <td>Social</td> 
                                                        <td>
                                                            <span class="badge bg-warning bg-opacity-10 text-warning p-2 fs-12 fw-normal">Pending</span>
                                                        </td>
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
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/user-13.jpg" class="wh-44 rounded-circle" alt="user">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">Michael Wilson</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>micheal@trezo.com</td>
                                                        <td>Website</td> 
                                                        <td>
                                                            <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">In Progress</span>
                                                        </td>
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
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/user-14.jpg" class="wh-44 rounded-circle" alt="user">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">Amanda Clark</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>amanda@trezo.com</td>
                                                        <td>Paid</td> 
                                                        <td>
                                                            <span class="badge bg-info bg-opacity-10 text-info p-2 fs-12 fw-normal">Confirmed</span>
                                                        </td>
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
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/user-15.jpg" class="wh-44 rounded-circle" alt="user">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">David Brown</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>Jennifer Taylor</td>
                                                        <td>Others</td> 
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Rejected</span>
                                                        </td>
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
                                                        <a class="page-link icon" href="index" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="index">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="index">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="index">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="index">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="index" aria-label="Next">
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

                    <div class="row justify-content-center">
                        <div class="col-xxl-8 col-xl-7 col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Sales Report</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>This Week</option>
                                            <option value="1">This Month</option>
                                            <option value="2">This Year</option>
                                        </select>
                                    </div>

                                    <div style="margin-bottom: -15px; margin-left: -10px;">
                                        <div id="sales_report"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-5 col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Top Products by Sales</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>This Month</option>
                                            <option value="1">Last Month</option>
                                            <option value="2">Last Year</option>
                                        </select>
                                    </div>

                                    <ul class="ps-0 mb-0 list-unstyled">
                                        <li class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-primary bg-opacity-10 text-primary text-center rounded-1 wh-48 lh-48">smartphone</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Samsung Galaxy</h6>
                                                    <span class="fs-12">Samsung</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-secondary">$96,455</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-primary-div bg-opacity-10 text-primary-div text-center rounded-1 wh-48 lh-48">tap_and_play</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">iPhone 15 Plus</h6>
                                                    <span class="fs-12">Apple inc.</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-secondary">$89,670</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-danger bg-opacity-10 text-danger text-center rounded-1 wh-48 lh-48">edgesensor_low</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Vivo V30</h6>
                                                    <span class="fs-12">Vivo Ltd.</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-secondary">$75,329</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-success bg-opacity-10 text-success text-center rounded-1 wh-48 lh-48">watch</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Watch Series 7</h6>
                                                    <span class="fs-12">Apple</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-secondary">$98,256</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-circle bg-info bg-opacity-10 text-info text-center rounded-1 wh-48 lh-48">headphones</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6 class="fw-medium fs16 mb-0">Sony WF-SP800N</h6>
                                                    <span class="fs-12">Sony</span>
                                                </div>
                                            </div>
                                            <span class="fs-14 fw-medium text-secondary">$65,987</span>
                                        </li>
                                    </ul>
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
